<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground mb-1">Media Library</h1>
          <p class="text-muted-foreground text-sm">Manage all website images and SEO metadata</p>
        </div>
        <div class="flex gap-2">
          <Button @click="scanImages" :disabled="scanning" class="gap-2">
            <Loader2 v-if="scanning" class="w-4 h-4 animate-spin" />
            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            {{ scanning ? 'Scanning...' : 'Scan Resources' }}
          </Button>
        </div>
      </div>

      <!-- Filters & Search -->
      <div class="flex flex-col sm:flex-row gap-3">
        <Input v-model="search" placeholder="Search by name, title, alt text..." class="flex-1" @input="debouncedSearch" />
        <Select v-model="selectedFolder" @change="page = 1; fetchMedia()">
          <option value="all">All Folders</option>
          <option value="resources">Resources</option>
          <option value="services">Services</option>
          <option v-for="stat in folderStats" :key="stat.folder" :value="stat.folder">
            {{ stat.folder }} ({{ stat.count }})
          </option>
        </Select>
        <Select v-model="sortBy" @change="page = 1; fetchMedia()">
          <option value="created_at">Newest</option>
          <option value="name">Name (A-Z)</option>
          <option value="file_size">File Size</option>
        </Select>
      </div>

      <!-- Bulk Actions -->
      <Card v-if="selectedMedia.length > 0" class="bg-blue-50 dark:bg-blue-950 border border-blue-200 dark:border-blue-800">
        <CardContent class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <p class="text-sm text-foreground">{{ selectedMedia.length }} image(s) selected</p>
          <div class="flex gap-2">
            <Button @click="openBulkSeoModal" size="sm" variant="outline">
              <Wand2 class="w-4 h-4 mr-2" />
              Generate SEO (AI)
            </Button>
            <Button @click="selectedMedia = []" size="sm" variant="outline">
              Clear Selection
            </Button>
          </div>
        </CardContent>
      </Card>

      <!-- Media Grid -->
      <div v-if="loading" class="flex items-center justify-center p-12">
        <Loader2 class="w-8 h-8 animate-spin text-primary" />
      </div>
      <div v-else-if="media.length === 0" class="text-center p-12 rounded-lg border border-border">
        <p class="text-muted-foreground">No images found. Try scanning resources folder.</p>
      </div>
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div
          v-for="item in media"
          :key="item.id"
          class="group relative bg-card border border-border rounded-lg overflow-hidden hover:border-primary transition cursor-pointer"
          @click="selectedMedia.includes(item.id) ? selectedMedia = selectedMedia.filter(id => id !== item.id) : selectedMedia = [...selectedMedia, item.id]"
        >
          <!-- Checkbox -->
          <div class="absolute top-2 left-2 z-10">
            <input
              type="checkbox"
              :checked="selectedMedia.includes(item.id)"
              @change="selectedMedia.includes(item.id) ? selectedMedia = selectedMedia.filter(id => id !== item.id) : selectedMedia = [...selectedMedia, item.id]"
              class="w-4 h-4 accent-primary"
              @click.stop
            />
          </div>

          <!-- Image Preview -->
          <div class="h-48 bg-muted overflow-hidden flex items-center justify-center">
            <img v-if="item.url" :src="item.url" :alt="item.name" class="w-full h-full object-cover group-hover:scale-110 transition" />
            <div v-else class="text-muted-foreground">
              <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
          </div>

          <!-- Info -->
          <div class="p-3 space-y-2">
            <div class="text-xs text-muted-foreground line-clamp-1">{{ item.name }}</div>
            <div class="text-xs text-muted-foreground">{{ item.formatted_size }} • {{ item.folder }}</div>
            
            <!-- SEO Badge -->
            <div v-if="item.alt_text && item.title" class="text-xs bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-400 px-2 py-0.5 rounded w-fit">
              ✓ SEO Ready
            </div>
            <div v-else class="text-xs bg-yellow-100 text-yellow-700 dark:bg-yellow-950 dark:text-yellow-400 px-2 py-0.5 rounded w-fit">
              ⚠ Needs SEO
            </div>
          </div>

          <!-- Actions (show on hover) -->
          <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
            <button
              @click.stop="editingItem(item)"
              class="p-2 bg-primary text-white rounded-lg hover:bg-primary/90"
              title="Edit metadata"
            >
              <Edit2 class="w-4 h-4" />
            </button>
            <button
              @click.stop="generateSeoForItem(item)"
              class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
              title="Generate SEO"
            >
              <Wand2 class="w-4 h-4" />
            </button>
            <button
              @click.stop="deleteMedia(item)"
              class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
              title="Delete"
            >
              <Trash2 class="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="totalPages > 1" class="flex justify-center gap-1">
        <button
          v-for="p in totalPages"
          :key="p"
          @click="page = p; fetchMedia()"
          :class="['px-3 py-1 text-xs rounded-md border transition', p === page ? 'border-primary bg-primary text-white' : 'border-border text-muted-foreground hover:bg-muted']"
        >{{ p }}</button>
      </div>
    </div>

    <!-- ═══════ Edit Metadata Modal ═══════ -->
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-[5vh] overflow-y-auto">
          <div class="fixed inset-0 bg-black/50" @click="showEditModal = false" />
          <div class="relative bg-card border border-border rounded-xl shadow-xl w-full max-w-2xl z-10 my-8">
            <div class="flex items-center justify-between p-5 border-b border-border">
              <h3 class="font-semibold text-foreground text-lg">Edit Image Metadata</h3>
              <button @click="showEditModal = false" class="p-1 hover:bg-muted rounded-md">
                <X class="w-4 h-4" />
              </button>
            </div>

            <div class="p-5 space-y-5 max-h-[70vh] overflow-y-auto">
              <!-- Preview -->
              <div class="flex gap-4">
                <img v-if="editingMedia?.url" :src="editingMedia.url" :alt="editingMedia.name" class="w-32 h-32 object-cover rounded-lg" />
                <div class="flex-1">
                  <p class="text-sm text-muted-foreground mb-2">{{ editingMedia?.name }}</p>
                  <p class="text-xs text-muted-foreground">{{ editingMedia?.formatted_size }}</p>
                </div>
              </div>

              <!-- SEO Fields -->
              <div class="space-y-4">
                <div class="space-y-1.5">
                  <Label>Title (SEO) *</Label>
                  <Input v-model="editForm.title" placeholder="e.g., Professional Web Development Services" maxlength="255" />
                  <p class="text-xs text-muted-foreground">{{ editForm.title.length }}/255 characters</p>
                </div>

                <div class="space-y-1.5">
                  <Label>Alt Text (Accessibility) *</Label>
                  <Input v-model="editForm.alt_text" placeholder="Describe what's in the image" maxlength="125" />
                  <p class="text-xs text-muted-foreground">{{ editForm.alt_text.length }}/125 characters</p>
                </div>

                <div class="space-y-1.5">
                  <Label>Description (SEO)</Label>
                  <textarea v-model="editForm.description" rows="3" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 resize-none" placeholder="Brief description for search engines" maxlength="160" />
                  <p class="text-xs text-muted-foreground">{{ editForm.description.length }}/160 characters</p>
                </div>

                <div class="space-y-1.5">
                  <Label>Caption (For Context)</Label>
                  <textarea v-model="editForm.caption" rows="2" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 resize-none" placeholder="Context or explanation for the image" />
                </div>
              </div>
            </div>

            <div class="flex items-center justify-between p-5 border-t border-border">
              <Button @click="showEditModal = false" variant="outline">Cancel</Button>
              <Button @click="saveMetadata" :disabled="savingMetadata">
                <Loader2 v-if="savingMetadata" class="w-4 h-4 animate-spin mr-2" />
                Save Changes
              </Button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- ═══════ Bulk SEO Generation Modal ═══════ -->
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="showBulkSeoModal" class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-[5vh] overflow-y-auto">
          <div class="fixed inset-0 bg-black/50" @click="showBulkSeoModal = false" />
          <div class="relative bg-card border border-border rounded-xl shadow-xl w-full max-w-2xl z-10 my-8">
            <div class="flex items-center justify-between p-5 border-b border-border">
              <h3 class="font-semibold text-foreground text-lg">Generate SEO Metadata (AI)</h3>
              <button @click="showBulkSeoModal = false" class="p-1 hover:bg-muted rounded-md">
                <X class="w-4 h-4" />
              </button>
            </div>

            <div class="p-5 space-y-5 max-h-[70vh] overflow-y-auto">
              <div class="bg-blue-50 dark:bg-blue-950 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <p class="text-sm text-blue-900 dark:text-blue-100">
                  Using OpenAI to generate SEO-optimized metadata for {{ selectedMedia.length }} image(s). This will create titles, descriptions, alt text, and captions optimized for search engines and accessibility.
                </p>
              </div>

              <div class="space-y-1.5">
                <Label>Context (Optional)</Label>
                <textarea v-model="bulkSeoContext" rows="3" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 resize-none" placeholder="e.g., These are service images for a tech company, or Industry: Healthcare & Medical Services" />
              </div>

              <div class="space-y-1.5">
                <Label>Type</Label>
                <Select v-model="bulkSeoType">
                  <option value="generic">Generic (All images)</option>
                  <option value="services">Services Images</option>
                  <option value="industries">Industries Section</option>
                </Select>
              </div>

              <div class="bg-yellow-50 dark:bg-yellow-950 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                <p class="text-xs text-yellow-900 dark:text-yellow-100">
                  Note: Each image generation uses API credits. The more context you provide, the better the AI generates descriptions.
                </p>
              </div>
            </div>

            <div class="flex items-center justify-between p-5 border-t border-border">
              <Button @click="showBulkSeoModal = false" variant="outline">Cancel</Button>
              <Button @click="generateBulkSeo" :disabled="generatingBulkSeo">
                <Loader2 v-if="generatingBulkSeo" class="w-4 h-4 animate-spin mr-2" />
                Generate for {{ selectedMedia.length }} Images
              </Button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useApi } from '@/composables/useApi'
import { useToast } from '@/composables/useToast'
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Card, CardContent } from '@/components/ui/card'
import { Select } from '@/components/ui/select'
import { Loader2, Wand2, Edit2, Trash2, X } from 'lucide-vue-next'
import { debounce } from '@/utils/debounce'

const { get, post, put, delete: destroy } = useApi()
const toast = useToast()

// State
const media = ref([])
const loading = ref(false)
const scanning = ref(false)
const page = ref(1)
const perPage = ref(24)
const total = ref(0)
const search = ref('')
const selectedFolder = ref('all')
const sortBy = ref('created_at')
const folderStats = ref([])

// Modals
const showEditModal = ref(false)
const showBulkSeoModal = ref(false)
const editingMedia = ref(null)
const editForm = ref({
  title: '',
  alt_text: '',
  description: '',
  caption: '',
})

// Bulk SEO
const selectedMedia = ref([])
const bulkSeoContext = ref('')
const bulkSeoType = ref('generic')
const savingMetadata = ref(false)
const generatingBulkSeo = ref(false)

const totalPages = computed(() => Math.ceil(total.value / perPage.value))

const debouncedSearch = debounce(() => {
  page.value = 1
  fetchMedia()
}, 300)

onMounted(() => {
  fetchMedia()
  fetchFolderStats()
})

async function fetchMedia() {
  loading.value = true
  try {
    const params: Record<string, string | number> = {
      page: page.value,
      per_page: perPage.value,
      search: search.value,
      sort: sortBy.value,
      direction: 'desc',
    }

    if (selectedFolder.value !== 'all') {
      params.folder = selectedFolder.value
    }

    const data = await get('/admin/media-library', { params })

    media.value = data.data
    total.value = data.total
  } catch (error) {
    toast.error('Error', 'Failed to fetch media')
  } finally {
    loading.value = false
  }
}

async function fetchFolderStats() {
  try {
    folderStats.value = await get('/admin/media-library/stats')
  } catch (error) {
    console.error('Failed to fetch folder stats', error)
  }
}

async function scanImages() {
  scanning.value = true
  try {
    const data = await post('/admin/media-library/scan-import')

    toast.success('Scan Complete', `Imported ${data.imported_count} images, Skipped ${data.skipped_count}`)

    fetchMedia()
    fetchFolderStats()
  } catch (error) {
    toast.error('Error', 'Failed to scan images')
  } finally {
    scanning.value = false
  }
}

function editingItem(item) {
  editingMedia.value = item
  editForm.value = {
    title: item.title || '',
    alt_text: item.alt_text || '',
    description: item.description || '',
    caption: item.caption || '',
  }
  showEditModal.value = true
}

async function saveMetadata() {
  if (!editingMedia.value) return

  savingMetadata.value = true
  try {
    await put(`/admin/media-library/${editingMedia.value.id}`, editForm.value)

    toast.success('Success', 'Metadata saved successfully')
    showEditModal.value = false
    fetchMedia()
  } catch (error) {
    toast.error('Error', 'Failed to save metadata')
  } finally {
    savingMetadata.value = false
  }
}

async function generateSeoForItem(item) {
  try {
    await post(`/admin/media-library/${item.id}/generate-seo`, { context: '' })

    toast.success('Success', 'SEO metadata generated')
    fetchMedia()
  } catch (error) {
    toast.error('Error', 'Failed to generate SEO metadata')
  }
}

function openBulkSeoModal() {
  bulkSeoContext.value = ''
  bulkSeoType.value = 'generic'
  showBulkSeoModal.value = true
}

async function generateBulkSeo() {
  if (selectedMedia.value.length === 0) return

  generatingBulkSeo.value = true
  try {
    const data = await post('/admin/media-library/bulk-generate-seo', {
      media_ids: selectedMedia.value,
      context: bulkSeoContext.value,
      type: bulkSeoType.value,
    })

    toast.success('Success', data.message)

    showBulkSeoModal.value = false
    selectedMedia.value = []
    fetchMedia()
  } catch (error) {
    toast.error('Error', 'Failed to generate bulk SEO metadata')
  } finally {
    generatingBulkSeo.value = false
  }
}

async function deleteMedia(item) {
  if (!confirm(`Delete "${item.name}"?`)) return

  try {
    await destroy(`/admin/media-library/${item.id}`)

    toast.success('Success', 'Media deleted')
    fetchMedia()
  } catch (error) {
    toast.error('Error', 'Failed to delete media')
  }
}
</script>
