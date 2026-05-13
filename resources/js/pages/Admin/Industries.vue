<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground mb-1">Industries</h1>
          <p class="text-muted-foreground text-sm">Manage the industries your company serves</p>
        </div>
        <Button @click="openCreate">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
          Add Industry
        </Button>
      </div>

      <!-- Search -->
      <div class="flex gap-3">
        <Input v-model="search" placeholder="Search industries..." class="max-w-sm" @input="debouncedFetch" />
      </div>

      <!-- Table -->
      <Card>
        <CardContent class="p-0">
          <div v-if="loading" class="p-8 text-center">
            <Loader2 class="h-6 w-6 animate-spin text-primary mx-auto" />
          </div>
          <table v-else class="w-full text-sm">
            <thead>
              <tr class="border-b border-border text-muted-foreground text-xs">
                <th class="text-left py-3 px-4 font-medium">Image</th>
                <th class="text-left py-3 px-4 font-medium">Title</th>
                <th class="text-left py-3 px-4 font-medium hidden md:table-cell">Short Description</th>
                <th class="text-center py-3 px-4 font-medium">Status</th>
                <th class="text-center py-3 px-4 font-medium">Order</th>
                <th class="text-right py-3 px-4 font-medium">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="ind in industries" :key="ind.id" class="border-b border-border last:border-0 hover:bg-muted/30">
                <td class="py-3 px-4">
                  <img v-if="ind.image" :src="ind.image" :alt="ind.title" class="w-10 h-10 rounded-lg object-cover" />
                  <div v-else class="w-10 h-10 rounded-lg bg-muted flex items-center justify-center text-lg">🏢</div>
                </td>
                <td class="py-3 px-4 font-medium text-foreground">{{ ind.title }}</td>
                <td class="py-3 px-4 text-muted-foreground text-xs hidden md:table-cell">
                  <span class="line-clamp-1">{{ ind.short_description }}</span>
                </td>
                <td class="py-3 px-4 text-center">
                  <span :class="['px-2 py-0.5 rounded-full text-[10px] font-semibold', ind.is_active ? 'bg-green-500/10 text-green-600' : 'bg-red-500/10 text-red-500']">
                    {{ ind.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="py-3 px-4 text-center text-muted-foreground">{{ ind.sort_order }}</td>
                <td class="py-3 px-4 text-right">
                  <div class="flex justify-end gap-1">
                    <button @click="openEdit(ind)" class="p-1.5 hover:bg-muted rounded-md text-muted-foreground hover:text-foreground transition" title="Edit">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button @click="confirmDelete(ind)" class="p-1.5 hover:bg-red-500/10 rounded-md text-muted-foreground hover:text-red-500 transition" title="Delete">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="!loading && industries.length === 0">
                <td colspan="6" class="py-12 text-center text-muted-foreground">No industries found.</td>
              </tr>
            </tbody>
          </table>
        </CardContent>
      </Card>

      <!-- Pagination -->
      <div v-if="totalPages > 1" class="flex justify-center gap-1">
        <button
          v-for="p in totalPages" :key="p"
          @click="page = p; fetchIndustries()"
          :class="['px-3 py-1 text-xs rounded-md border transition', p === page ? 'border-primary bg-primary text-white' : 'border-border text-muted-foreground hover:bg-muted']"
        >{{ p }}</button>
      </div>
    </div>

    <!-- ═══════ Create/Edit Modal ═══════ -->
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-[5vh] overflow-y-auto">
          <div class="fixed inset-0 bg-black/50" @click="showModal = false" />
          <div class="relative bg-card border border-border rounded-xl shadow-xl w-full max-w-3xl z-10 my-8">
            <div class="flex items-center justify-between p-5 border-b border-border">
              <h3 class="font-semibold text-foreground text-lg">{{ editingId ? 'Edit Industry' : 'Add Industry' }}</h3>
              <button @click="showModal = false" class="p-1 hover:bg-muted rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>

            <div class="p-5 space-y-5 max-h-[70vh] overflow-y-auto">
              <!-- Basic Info -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                  <Label>Title *</Label>
                  <Input v-model="form.title" placeholder="e.g. Healthcare" />
                </div>
                <div class="space-y-1.5">
                  <Label>Slug</Label>
                  <Input v-model="form.slug" placeholder="auto-generated" />
                </div>
              </div>

              <div class="space-y-1.5">
                <Label>Short Description</Label>
                <Input v-model="form.short_description" placeholder="A brief tagline" />
              </div>

              <div class="space-y-1.5">
                <Label>Full Description</Label>
                <textarea v-model="form.description" rows="4" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 resize-none" placeholder="Detailed description of the industry..." />
              </div>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                  <Label>Icon Name</Label>
                  <Input v-model="form.icon" placeholder="e.g. Healthcare" />
                </div>
                <div class="space-y-1.5">
                  <Label>Sort Order</Label>
                  <Input v-model.number="form.sort_order" type="number" />
                </div>
                <div class="space-y-1.5 flex items-end">
                  <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" v-model="form.is_active" class="accent-primary w-4 h-4" />
                    <span class="text-sm text-foreground">Active</span>
                  </label>
                </div>
              </div>

              <!-- Images -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                  <Label>Card Image</Label>
                  <p class="text-xs text-muted-foreground mb-2">Used on listing cards</p>
                  <div v-if="form.image_id" class="mb-2 flex gap-2 items-start">
                    <div class="flex-1 p-3 bg-muted rounded-lg">
                      <p class="text-xs font-medium text-foreground">Selected from Library</p>
                      <p class="text-xs text-muted-foreground">ID: {{ form.image_id }}</p>
                    </div>
                    <button @click="form.image_id = null; form.image = ''" class="p-1.5 hover:bg-red-500/10 text-red-500 rounded-md">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                  </div>
                  <div class="flex gap-2">
                    <Button @click="showImagePickerModal('image')" size="sm" variant="outline" class="flex-1">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><circle cx="9" cy="10" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                      Choose from Library
                    </Button>
                    <ImageUploader v-model="form.image" class="flex-1" />
                  </div>
                </div>
                <div class="space-y-1.5">
                  <Label>Banner Image</Label>
                  <p class="text-xs text-muted-foreground mb-2">Detail page hero</p>
                  <div v-if="form.banner_image_id" class="mb-2 flex gap-2 items-start">
                    <div class="flex-1 p-3 bg-muted rounded-lg">
                      <p class="text-xs font-medium text-foreground">Selected from Library</p>
                      <p class="text-xs text-muted-foreground">ID: {{ form.banner_image_id }}</p>
                    </div>
                    <button @click="form.banner_image_id = null; form.banner_image = ''" class="p-1.5 hover:bg-red-500/10 text-red-500 rounded-md">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                  </div>
                  <div class="flex gap-2">
                    <Button @click="showImagePickerModal('banner')" size="sm" variant="outline" class="flex-1">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><circle cx="9" cy="10" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                      Choose from Library
                    </Button>
                    <ImageUploader v-model="form.banner_image" class="flex-1" />
                  </div>
                </div>
              </div>

              <!-- Sub-Sectors (repeater) -->
              <div class="border border-border rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                  <Label>Sub-Sectors</Label>
                  <button type="button" @click="form.sub_sectors.push({ name: '', description: '', icon: '' })" class="text-xs text-primary hover:underline">+ Add</button>
                </div>
                <div v-for="(sub, i) in form.sub_sectors" :key="i" class="flex gap-2 items-start">
                  <Input v-model="sub.name" placeholder="Name" class="flex-1" />
                  <Input v-model="sub.description" placeholder="Description" class="flex-[2]" />
                  <Input v-model="sub.icon" placeholder="Icon" class="w-16" />
                  <button @click="form.sub_sectors.splice(i, 1)" class="p-1.5 hover:bg-red-500/10 text-red-500 rounded-md shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
              </div>

              <!-- Process Steps (repeater) -->
              <div class="border border-border rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                  <Label>Process Steps</Label>
                  <button type="button" @click="form.process_steps.push({ title: '', description: '', icon: '' })" class="text-xs text-primary hover:underline">+ Add</button>
                </div>
                <div v-for="(step, i) in form.process_steps" :key="i" class="flex gap-2 items-start">
                  <Input v-model="step.title" placeholder="Step title" class="flex-1" />
                  <Input v-model="step.description" placeholder="Description" class="flex-[2]" />
                  <button @click="form.process_steps.splice(i, 1)" class="p-1.5 hover:bg-red-500/10 text-red-500 rounded-md shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
              </div>

              <!-- Features (repeater) -->
              <div class="border border-border rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                  <Label>Features</Label>
                  <button type="button" @click="form.features.push({ title: '', description: '' })" class="text-xs text-primary hover:underline">+ Add</button>
                </div>
                <div v-for="(feat, i) in form.features" :key="i" class="flex gap-2 items-start">
                  <Input v-model="feat.title" placeholder="Feature title" class="flex-1" />
                  <Input v-model="feat.description" placeholder="Description" class="flex-[2]" />
                  <button @click="form.features.splice(i, 1)" class="p-1.5 hover:bg-red-500/10 text-red-500 rounded-md shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
              </div>

              <!-- Stats (repeater) -->
              <div class="border border-border rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                  <Label>Stats</Label>
                  <button type="button" @click="form.stats.push({ value: '', label: '' })" class="text-xs text-primary hover:underline">+ Add</button>
                </div>
                <div v-for="(stat, i) in form.stats" :key="i" class="flex gap-2 items-start">
                  <Input v-model="stat.value" placeholder="e.g. 500+" class="w-28" />
                  <Input v-model="stat.label" placeholder="e.g. Clients Served" class="flex-1" />
                  <button @click="form.stats.splice(i, 1)" class="p-1.5 hover:bg-red-500/10 text-red-500 rounded-md shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
              </div>

              <!-- CTA & SEO -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                  <Label>CTA Title</Label>
                  <Input v-model="form.cta_title" placeholder="Call to action heading" />
                </div>
                <div class="space-y-1.5">
                  <Label>CTA Description</Label>
                  <Input v-model="form.cta_description" placeholder="Call to action text" />
                </div>
                <div class="space-y-1.5">
                  <Label>Meta Title</Label>
                  <Input v-model="form.meta_title" placeholder="SEO title" />
                </div>
                <div class="space-y-1.5">
                  <Label>Meta Description</Label>
                  <Input v-model="form.meta_description" placeholder="SEO description" />
                </div>
              </div>
            </div>

            <div class="flex justify-end gap-3 p-5 border-t border-border">
              <Button variant="outline" @click="showModal = false">Cancel</Button>
              <Button :disabled="submitting" @click="submitForm">
                <Loader2 v-if="submitting" class="mr-2 h-4 w-4 animate-spin" />
                {{ editingId ? 'Update' : 'Create' }}
              </Button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- Delete Confirm -->
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <div class="fixed inset-0 bg-black/50" @click="deleteTarget = null" />
          <div class="relative bg-card border border-border rounded-xl shadow-xl w-full max-w-sm z-10 p-6 text-center">
            <h3 class="font-semibold text-foreground mb-2">Delete "{{ deleteTarget.title }}"?</h3>
            <p class="text-sm text-muted-foreground mb-6">This action cannot be undone.</p>
            <div class="flex justify-center gap-3">
              <Button variant="outline" @click="deleteTarget = null">Cancel</Button>
              <Button variant="destructive" @click="deleteIndustry">Delete</Button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>

    <!-- Media Picker Modal -->
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="showMediaPicker" class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-[5vh] overflow-y-auto">
          <div class="fixed inset-0 bg-black/50" @click="showMediaPicker = false; pickerType = null" />
          <div class="relative bg-card border border-border rounded-xl shadow-xl w-full max-w-4xl z-10 my-8">
            <div class="flex items-center justify-between p-5 border-b border-border">
              <h3 class="font-semibold text-foreground text-lg">Select Image from Media Library</h3>
              <button @click="showMediaPicker = false; pickerType = null" class="p-1 hover:bg-muted rounded-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
              </button>
            </div>

            <div class="p-5 space-y-4 max-h-[60vh] overflow-y-auto">
              <Input v-model="mediaPickerSearch" placeholder="Search images..." />
              
              <div v-if="mediaPickerLoading" class="flex items-center justify-center p-8">
                <Loader2 class="w-6 h-6 animate-spin text-primary" />
              </div>
              <div v-else-if="mediaPickerItems.length === 0" class="text-center p-8">
                <p class="text-muted-foreground">No images found</p>
              </div>
              <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                <div
                  v-for="item in mediaPickerItems"
                  :key="item.id"
                  @click="selectMedia(item)"
                  class="cursor-pointer group relative rounded-lg overflow-hidden border-2 border-border hover:border-primary transition"
                  :class="{ 'border-primary bg-primary/5': isMediaSelected(item.id) }"
                >
                  <div class="aspect-square bg-muted flex items-center justify-center">
                    <img v-if="item.url" :src="item.url" :alt="item.name" class="w-full h-full object-cover group-hover:scale-110 transition" />
                    <svg v-else class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                  </div>
                  <div class="p-2 text-xs line-clamp-1">{{ item.name }}</div>
                  <div v-if="isMediaSelected(item.id)" class="absolute top-1 right-1 w-5 h-5 bg-primary rounded-full flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex items-center justify-between p-5 border-t border-border">
              <Button @click="showMediaPicker = false; pickerType = null" variant="outline">Cancel</Button>
              <Button @click="confirmMediaSelection" :disabled="!selectedMediaForPicker">Confirm Selection</Button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </AdminLayout>
</template>

<script setup lang="ts">
import { Loader2 } from 'lucide-vue-next';
import { ref, reactive, onMounted } from 'vue';
import ImageUploader from '@/components/ImageUploader.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import AdminLayout from '@/layouts/AdminLayout.vue';

const { get, post, put, delete: destroy } = useApi();
const toast = useToast();

const loading = ref(true);
const industries = ref<any[]>([]);
const page = ref(1);
const totalPages = ref(1);
const search = ref('');

const showModal = ref(false);
const editingId = ref<number | null>(null);
const submitting = ref(false);
const deleteTarget = ref<any>(null);

// Media Picker
const showMediaPicker = ref(false);
const pickerType = ref<'image' | 'banner' | null>(null);
const mediaPickerItems = ref<any[]>([]);
const mediaPickerLoading = ref(false);
const mediaPickerSearch = ref('');
const selectedMediaForPicker = ref<any>(null);

let debounceTimer: ReturnType<typeof setTimeout>;
function debouncedFetch() {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => { page.value = 1; fetchIndustries(); }, 300);
}

const defaultForm = () => ({
  title: '',
  slug: '',
  short_description: '',
  description: '',
  icon: '',
  image: '',
  banner_image: '',
  image_id: null as number | null,
  banner_image_id: null as number | null,
  sub_sectors: [] as { name: string; description: string; icon: string }[],
  process_steps: [] as { title: string; description: string; icon: string }[],
  features: [] as { title: string; description: string }[],
  stats: [] as { value: string; label: string }[],
  cta_title: '',
  cta_description: '',
  meta_title: '',
  meta_description: '',
  sort_order: 0,
  is_active: true,
});

const form = reactive(defaultForm());

function resetForm() {
  Object.assign(form, defaultForm());
}

function openCreate() {
  resetForm();
  editingId.value = null;
  showModal.value = true;
}

function openEdit(ind: any) {
  resetForm();
  editingId.value = ind.id;
  Object.assign(form, {
    ...ind,
    sub_sectors: ind.sub_sectors || [],
    process_steps: ind.process_steps || [],
    features: ind.features || [],
    stats: ind.stats || [],
  });
  showModal.value = true;
}

async function fetchIndustries() {
  loading.value = true;
  try {
    const params: Record<string, any> = { page: page.value, per_page: 20 };
    if (search.value) params.search = search.value;
    const data = await get('/admin/industries', { params });
    industries.value = data.data || [];
    totalPages.value = data.last_page || 1;
  } catch {
    toast.error('Failed to load industries');
  } finally {
    loading.value = false;
  }
}

async function submitForm() {
  if (!form.title) { toast.error('Title is required'); return; }
  submitting.value = true;
  try {
    if (editingId.value) {
      await put(`/admin/industries/${editingId.value}`, form);
      toast.success('Industry updated');
    } else {
      await post('/admin/industries', form);
      toast.success('Industry created');
    }
    showModal.value = false;
    fetchIndustries();
  } catch (e: any) {
    toast.error('Save failed', e?.response?.data?.message);
  } finally {
    submitting.value = false;
  }
}

function confirmDelete(ind: any) {
  deleteTarget.value = ind;
}

async function deleteIndustry() {
  if (!deleteTarget.value) return;
  try {
    await destroy(`/admin/industries/${deleteTarget.value.id}`);
    toast.success('Industry deleted');
    deleteTarget.value = null;
    fetchIndustries();
  } catch {
    toast.error('Delete failed');
  }
}

// Media Picker Functions
async function showImagePickerModal(type: 'image' | 'banner') {
  pickerType.value = type;
  showMediaPicker.value = true;
  selectedMediaForPicker.value = null;
  mediaPickerSearch.value = '';
  await fetchMediaLibraryItems();
}

async function fetchMediaLibraryItems() {
  mediaPickerLoading.value = true;
  try {
    const params = new URLSearchParams({
      per_page: '50',
      folder: 'all',
      search: mediaPickerSearch.value,
    });
    const response = await fetch(`/api/v1/admin/media-library?${params}`);
    const data = await response.json();
    mediaPickerItems.value = data.data;
  } catch (error) {
    toast.error('Failed to load media library');
  } finally {
    mediaPickerLoading.value = false;
  }
}

function selectMedia(item: any) {
  selectedMediaForPicker.value = selectedMediaForPicker.value?.id === item.id ? null : item;
}

function isMediaSelected(id: number): boolean {
  return selectedMediaForPicker.value?.id === id;
}

function confirmMediaSelection() {
  if (!selectedMediaForPicker.value || !pickerType.value) return;
  
  if (pickerType.value === 'image') {
    form.image_id = selectedMediaForPicker.value.id;
    form.image = selectedMediaForPicker.value.url;
  } else if (pickerType.value === 'banner') {
    form.banner_image_id = selectedMediaForPicker.value.id;
    form.banner_image = selectedMediaForPicker.value.url;
  }
  
  showMediaPicker.value = false;
  pickerType.value = null;
  selectedMediaForPicker.value = null;
}

onMounted(fetchIndustries);
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
