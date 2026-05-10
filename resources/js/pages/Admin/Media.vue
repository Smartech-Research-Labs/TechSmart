<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground mb-1">Media Library</h1>
          <p class="text-muted-foreground">Upload, browse, and manage media files</p>
        </div>
        <div class="flex items-center gap-2">
          <Button v-if="selected.length > 0" variant="destructive" @click="confirmBulkDelete">
            <Trash2 class="mr-2 h-4 w-4" />
            Delete Selected ({{ selected.length }})
          </Button>
          <Button variant="outline" @click="toggleSelectMode">
            {{ selectMode ? 'Cancel Selection' : 'Select Files' }}
          </Button>
          <Button @click="showUploadDialog = true">
            <Upload class="mr-2 h-4 w-4" />
            Upload
          </Button>
        </div>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="flex items-center justify-center py-24">
        <Loader2 class="h-8 w-8 animate-spin text-primary" />
        <span class="ml-3 text-muted-foreground">Loading media...</span>
      </div>

      <!-- Empty State -->
      <div v-else-if="images.length === 0" class="flex flex-col items-center justify-center py-24 text-center">
        <ImageIcon class="h-16 w-16 text-muted-foreground/40 mb-4" />
        <h3 class="text-lg font-semibold text-foreground mb-1">No media yet</h3>
        <p class="text-muted-foreground mb-6">Upload your first image to get started</p>
        <Button @click="showUploadDialog = true">
          <Upload class="mr-2 h-4 w-4" />
          Upload Image
        </Button>
      </div>

      <!-- Media Grid -->
      <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        <div
          v-for="image in images"
          :key="image.path"
          class="group relative aspect-square rounded-lg border border-border overflow-hidden bg-muted/20 cursor-pointer hover:ring-2 hover:ring-primary/50 transition-all"
          :class="{ 'ring-2 ring-primary': selected.includes(image.path) }"
          @click="selectMode ? toggleSelect(image.path) : previewImage(image)"
        >
          <img
            :src="image.url"
            :alt="image.name"
            class="w-full h-full object-cover"
            loading="lazy"
          />
          <!-- Selection Checkbox -->
          <div
            v-if="selectMode"
            class="absolute top-2 left-2 z-10"
            @click.stop="toggleSelect(image.path)"
          >
            <div
              class="w-5 h-5 rounded border-2 flex items-center justify-center transition-colors"
              :class="selected.includes(image.path) ? 'bg-primary border-primary text-primary-foreground' : 'bg-background/80 border-muted-foreground'"
            >
              <Check v-if="selected.includes(image.path)" class="h-3 w-3" />
            </div>
          </div>
          <!-- File Info Overlay -->
          <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-2 translate-y-full group-hover:translate-y-0 transition-transform">
            <p class="text-xs text-white truncate">{{ image.name }}</p>
            <p class="text-[10px] text-white/70">{{ formatSize(image.size) }}</p>
          </div>
        </div>
      </div>

      <!-- Upload Dialog -->
      <Dialog :open="showUploadDialog" @update:open="showUploadDialog = $event">
        <DialogContent class="sm:max-w-lg">
          <DialogHeader>
            <DialogTitle>Upload Media</DialogTitle>
            <DialogDescription>Upload images to the media library</DialogDescription>
          </DialogHeader>

          <div class="space-y-4">
            <!-- Single Upload -->
            <div class="space-y-2">
              <Label>Single Upload</Label>
              <Input type="file" accept="image/png,image/jpeg,image/gif,image/svg+xml,image/webp,image/avif" @change="handleSingleUpload" />
              <p v-if="singleUploading" class="text-sm text-muted-foreground flex items-center gap-2">
                <Loader2 class="h-3 w-3 animate-spin" /> Uploading...
              </p>
              <p v-if="singleUploadError" class="text-sm text-destructive">{{ singleUploadError }}</p>
            </div>

            <Separator />

            <!-- Bulk Upload -->
            <div class="space-y-2">
              <Label>Bulk Upload</Label>
              <Input type="file" multiple accept="image/png,image/jpeg,image/gif,image/svg+xml,image/webp,image/avif" @change="handleBulkUpload" />
              <p v-if="bulkUploading" class="text-sm text-muted-foreground flex items-center gap-2">
                <Loader2 class="h-3 w-3 animate-spin" /> Uploading {{ bulkProgress }}...
              </p>
              <p v-if="bulkUploadError" class="text-sm text-destructive">{{ bulkUploadError }}</p>
            </div>

            <Separator />

            <!-- WebP Toggle -->
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-foreground">Convert to WebP</p>
                <p class="text-xs text-muted-foreground">Automatically convert PNG/JPG to WebP format</p>
              </div>
              <Checkbox id="convert-webp" v-model:checked="convertWebp" />
            </div>
          </div>
        </DialogContent>
      </Dialog>

      <!-- Preview Dialog -->
      <Dialog :open="!!previewImageUrl" @update:open="previewImageUrl = $event ? previewImageUrl : null">
        <DialogContent class="sm:max-w-3xl">
          <DialogHeader>
            <DialogTitle>{{ previewFileName }}</DialogTitle>
          </DialogHeader>
          <div class="flex items-center justify-center bg-muted/20 rounded-lg overflow-hidden max-h-[70vh]">
            <img :src="previewImageUrl" :alt="previewFileName" class="max-w-full max-h-[70vh] object-contain" />
          </div>
          <div class="flex items-center justify-between text-sm text-muted-foreground">
            <span>{{ previewFilePath }}</span>
            <Button variant="destructive" size="sm" @click="deleteSingle(previewFilePath)">
              <Trash2 class="mr-2 h-4 w-4" /> Delete
            </Button>
          </div>
        </DialogContent>
      </Dialog>

      <!-- Bulk Delete Confirmation -->
      <Dialog :open="showDeleteConfirm" @update:open="showDeleteConfirm = $event">
        <DialogContent class="sm:max-w-md">
          <DialogHeader>
            <DialogTitle>Confirm Delete</DialogTitle>
            <DialogDescription>Are you sure you want to delete {{ selected.length }} file(s)? This action cannot be undone.</DialogDescription>
          </DialogHeader>
          <div class="flex justify-end gap-3">
            <Button variant="outline" @click="showDeleteConfirm = false">Cancel</Button>
            <Button variant="destructive" @click="executeBulkDelete" :disabled="deleting">
              <Loader2 v-if="deleting" class="mr-2 h-4 w-4 animate-spin" />
              {{ deleting ? 'Deleting...' : 'Delete' }}
            </Button>
          </div>
        </DialogContent>
      </Dialog>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Checkbox } from '@/components/ui/checkbox'
import { Separator } from '@/components/ui/separator'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog'
import { Loader2, Upload, Trash2, ImageIcon, Check } from 'lucide-vue-next'
import axios from 'axios'

interface MediaImage {
  path: string
  url: string
  name: string
  size: number
  last_modified: number
}

const loading = ref(true)
const images = ref<MediaImage[]>([])
const showUploadDialog = ref(false)
const convertWebp = ref(true)

// Single upload
const singleUploading = ref(false)
const singleUploadError = ref('')

// Bulk upload
const bulkUploading = ref(false)
const bulkProgress = ref('')
const bulkUploadError = ref('')

// Preview
const previewImageUrl = ref<string | null>(null)
const previewFileName = ref('')
const previewFilePath = ref('')

// Select / bulk delete
const selectMode = ref(false)
const selected = ref<string[]>([])
const showDeleteConfirm = ref(false)
const deleting = ref(false)

async function fetchImages() {
  loading.value = true
  try {
    const { data } = await axios.get('/api/v1/admin/media')
    images.value = data.images
  } finally {
    loading.value = false
  }
}

async function handleSingleUpload(e: Event) {
  const target = e.target as HTMLInputElement
  const file = target.files?.[0]
  if (!file) return

  singleUploading.value = true
  singleUploadError.value = ''
  target.value = ''

  try {
    const formData = new FormData()
    formData.append('image', file)
    formData.append('convert_webp', String(convertWebp.value))

    await axios.post('/api/v1/admin/media/upload', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    })

    await fetchImages()
  } catch (err: any) {
    singleUploadError.value = err.response?.data?.message || 'Upload failed'
  } finally {
    singleUploading.value = false
  }
}

async function handleBulkUpload(e: Event) {
  const target = e.target as HTMLInputElement
  const files = target.files
  if (!files || files.length === 0) return

  bulkUploading.value = true
  bulkUploadError.value = ''
  bulkProgress.value = `0/${files.length}`
  target.value = ''

  try {
    const formData = new FormData()
    for (let i = 0; i < files.length; i++) {
      formData.append('images[]', files[i])
    }
    formData.append('convert_webp', String(convertWebp.value))

    const { data } = await axios.post('/api/v1/admin/media/upload-multiple', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    })

    bulkProgress.value = `${data.images?.length || files.length}/${files.length}`
    await fetchImages()
  } catch (err: any) {
    bulkUploadError.value = err.response?.data?.message || 'Bulk upload failed'
  } finally {
    bulkUploading.value = false
  }
}

function previewImage(image: MediaImage) {
  previewImageUrl.value = image.url
  previewFileName.value = image.name
  previewFilePath.value = image.path
}

async function deleteSingle(path: string) {
  try {
    await axios.delete('/api/v1/admin/media', { data: { path } })
    previewImageUrl.value = null
    await fetchImages()
  } catch {
    // ignore
  }
}

function toggleSelectMode() {
  selectMode.value = !selectMode.value
  if (!selectMode.value) selected.value = []
}

function toggleSelect(path: string) {
  const idx = selected.value.indexOf(path)
  if (idx === -1) {
    selected.value.push(path)
  } else {
    selected.value.splice(idx, 1)
  }
}

function confirmBulkDelete() {
  showDeleteConfirm.value = true
}

async function executeBulkDelete() {
  deleting.value = true
  try {
    await axios.post('/api/v1/admin/media/delete-multiple', { paths: selected.value })
    selected.value = []
    selectMode.value = false
    showDeleteConfirm.value = false
    await fetchImages()
  } finally {
    deleting.value = false
  }
}

function formatSize(bytes: number): string {
  if (bytes < 1024) return bytes + ' B'
  if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB'
  return (bytes / (1024 * 1024)).toFixed(1) + ' MB'
}

onMounted(fetchImages)
</script>
