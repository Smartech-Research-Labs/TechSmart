<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground mb-1">Manage Services</h1>
          <p class="text-muted-foreground">Add, edit, and organize services</p>
        </div>
        <button @click="openCreateModal" class="bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition whitespace-nowrap">
          + Add Service
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-20">
        <div class="flex items-center gap-3 text-muted-foreground">
          <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
          </svg>
          <span>Loading services...</span>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-red-500/10 border border-red-500/30 rounded-lg p-6 text-center">
        <p class="text-red-400 font-semibold mb-2">Failed to load services</p>
        <p class="text-muted-foreground text-sm mb-4">{{ error }}</p>
        <button @click="fetchServices" class="bg-primary hover:bg-primary/90 text-white font-semibold px-4 py-2 rounded-lg transition text-sm">
          Retry
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="services.length === 0" class="bg-card border border-border rounded-lg p-12 text-center">
        <p class="text-4xl mb-4">🛠️</p>
        <p class="text-foreground font-semibold text-lg mb-1">No services yet</p>
        <p class="text-muted-foreground text-sm mb-6">Create your first service to get started.</p>
        <button @click="openCreateModal" class="bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition">
          + Add Service
        </button>
      </div>

      <!-- Services Grid -->
      <div v-else>
        <!-- Search Bar -->
        <div class="mb-6">
          <div class="relative max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input v-model="searchQuery" type="text" placeholder="Search services..." class="w-full pl-10 pr-4 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
          </div>
        </div>

        <div v-if="filteredServices.length === 0" class="py-12 text-center text-muted-foreground">
          {{ searchQuery ? 'No services match your search.' : 'No services yet. Create your first one.' }}
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="service in filteredServices"
          :key="service.id"
          class="bg-card border border-border rounded-lg p-6 hover:border-primary transition"
        >
          <div class="flex items-start justify-between mb-4">
            <span class="text-3xl">{{ service.icon || 'ðŸ”§' }}</span>
            <div class="flex items-center gap-2">
              <span v-if="service.is_featured" class="px-2 py-1 rounded text-xs font-semibold bg-amber-500/20 text-amber-400">
                Featured
              </span>
              <span :class="[
                'px-2 py-1 rounded text-xs font-semibold',
                service.is_published ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-muted-foreground'
              ]">
                {{ service.is_published ? 'Published' : 'Draft' }}
              </span>
            </div>
          </div>
          <h3 class="text-lg font-bold text-foreground mb-1">{{ service.name }}</h3>
          <p v-if="service.category" class="text-xs text-primary font-medium mb-2">{{ service.category }}</p>
          <p class="text-muted-foreground text-sm mb-4 line-clamp-2">{{ service.short_description || service.description }}</p>
          <div v-if="service.features && service.features.length" class="mb-4">
            <p class="text-xs text-muted-foreground mb-1">{{ service.features.length }} feature{{ service.features.length !== 1 ? 's' : '' }}</p>
          </div>
          <div class="flex gap-2">
            <button @click="openEditModal(service)" class="flex-1 bg-primary/10 hover:bg-primary/20 text-primary font-semibold py-2 rounded-lg transition text-sm">
              Edit
            </button>
            <button @click="confirmDelete(service)" class="flex-1 border border-border hover:border-red-500/50 text-muted-foreground hover:text-red-400 font-semibold py-2 rounded-lg transition text-sm">
              Delete
            </button>
          </div>
        </div>
      </div>
      </div>
    </div>

    <!-- Create / Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @mousedown.self="closeModal">
      <div class="bg-card border border-border rounded-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl font-bold text-foreground">{{ isEditing ? 'Edit Service' : 'Create Service' }}</h2>
          <button @click="closeModal" class="text-muted-foreground hover:text-foreground transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>

        <form @submit.prevent="submitForm" class="space-y-4">
          <!-- Row: Name + Category -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Name <span class="text-red-400">*</span></label>
              <input v-model="form.name" type="text" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g. Web Development" />
            </div>
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Category</label>
              <input v-model="form.category" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g. Development, Design" />
            </div>
          </div>

          <!-- Row: Slug + Icon -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Slug</label>
              <input v-model="form.slug" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="auto-generated-from-name" />
            </div>
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Icon</label>
              <input v-model="form.icon" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g. ðŸš€ or icon class name" />
            </div>
          </div>

          <!-- Image URL -->
          <div>
            <label class="block text-sm font-medium text-foreground mb-1">Image URL</label>
            <input v-model="form.image" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="https://example.com/image.jpg" />
          </div>

          <!-- Short Description -->
          <div>
            <label class="block text-sm font-medium text-foreground mb-1">Short Description</label>
            <textarea v-model="form.short_description" rows="2" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary resize-y" placeholder="Brief summary shown in cards"></textarea>
          </div>

          <!-- Full Description -->
          <div>
            <label class="block text-sm font-medium text-foreground mb-1">Description</label>
            <textarea v-model="form.description" rows="5" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary resize-y" placeholder="Detailed service description"></textarea>
          </div>

          <!-- Features (dynamic list) -->
          <div>
            <label class="block text-sm font-medium text-foreground mb-1">Features</label>
            <div class="space-y-2">
              <div v-for="(feature, idx) in form.features" :key="idx" class="flex items-center gap-2">
                <input v-model="form.features[idx]" type="text" class="flex-1 px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" :placeholder="'Feature ' + (idx + 1)" />
                <button type="button" @click="removeFeature(idx)" class="text-red-400 hover:text-red-300 transition p-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>
            </div>
            <button type="button" @click="addFeature" class="mt-2 text-primary hover:text-primary/80 text-sm font-medium transition">
              + Add Feature
            </button>
          </div>

          <!-- Process Steps (dynamic list with title + description) -->
          <div>
            <label class="block text-sm font-medium text-foreground mb-1">Process Steps</label>
            <div class="space-y-3">
              <div v-for="(step, idx) in form.process_steps" :key="idx" class="flex items-start gap-2 bg-muted/30 border border-border rounded-lg p-3">
                <span class="text-xs text-muted-foreground font-bold w-6 text-center mt-2.5">{{ idx + 1 }}</span>
                <div class="flex-1 space-y-2">
                  <input v-model="form.process_steps[idx].title" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" :placeholder="'Step ' + (idx + 1) + ' title'" />
                  <input v-model="form.process_steps[idx].description" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" :placeholder="'Step ' + (idx + 1) + ' description (optional)'" />
                </div>
                <button type="button" @click="removeStep(idx)" class="text-red-400 hover:text-red-300 transition p-1 mt-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>
            </div>
            <button type="button" @click="addStep" class="mt-2 text-primary hover:text-primary/80 text-sm font-medium transition">
              + Add Step
            </button>
          </div>

          <!-- Row: Order + Toggles -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Order</label>
              <input v-model.number="form.order" type="number" min="0" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
            </div>
            <div class="flex items-center gap-2 pb-1">
              <input v-model="form.is_featured" type="checkbox" id="is_featured" class="rounded border-border" />
              <label for="is_featured" class="text-sm text-foreground">Featured</label>
            </div>
            <div class="flex items-center gap-2 pb-1">
              <input v-model="form.is_published" type="checkbox" id="is_published" class="rounded border-border" />
              <label for="is_published" class="text-sm text-foreground">Published</label>
            </div>
          </div>

          <!-- Validation Errors -->
          <div v-if="formErrors.length" class="bg-red-500/10 border border-red-500/30 rounded-lg p-3">
            <ul class="list-disc list-inside text-sm text-red-400 space-y-1">
              <li v-for="(err, idx) in formErrors" :key="idx">{{ err }}</li>
            </ul>
          </div>

          <!-- Actions -->
          <div class="flex gap-3 pt-4">
            <button type="submit" :disabled="submitting" class="flex-1 bg-primary hover:bg-primary/90 text-white font-semibold px-4 py-2.5 rounded-lg transition text-sm disabled:opacity-50">
              {{ submitting ? (isEditing ? 'Updating...' : 'Creating...') : (isEditing ? 'Update Service' : 'Create Service') }}
            </button>
            <button type="button" @click="closeModal" class="px-4 py-2.5 bg-background border border-border text-foreground rounded-lg text-sm transition hover:border-primary">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @mousedown.self="showDeleteModal = false">
      <div class="bg-card border border-border rounded-xl w-full max-w-md p-6">
        <div class="text-center">
          <div class="mx-auto w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
          </div>
          <h3 class="text-lg font-bold text-foreground mb-2">Delete Service</h3>
          <p class="text-muted-foreground text-sm mb-6">
            Are you sure you want to delete <span class="text-foreground font-semibold">{{ serviceToDelete?.name }}</span>? This action cannot be undone.
          </p>
          <div class="flex gap-3">
            <button @click="showDeleteModal = false" class="flex-1 px-4 py-2.5 bg-background border border-border text-foreground rounded-lg text-sm transition hover:border-primary">
              Cancel
            </button>
            <button @click="deleteService" :disabled="deleting" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg text-sm transition disabled:opacity-50">
              {{ deleting ? 'Deleting...' : 'Delete' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import AdminLayout from '@/layouts/AdminLayout.vue';

const { get, post, put, delete: destroy } = useApi();
const toast = useToast();

// â”€â”€ State â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
interface Service {
  id: number;
  name: string;
  slug: string;
  short_description: string;
  description: string;
  icon: string;
  image: string;
  category: string;
  features: string[];
  process_steps: Array<{ title: string; description: string }>;
  is_featured: boolean;
  is_published: boolean;
  order: number;
  created_at?: string;
  updated_at?: string;
}

const services = ref<Service[]>([]);
const loading = ref(false);
const error = ref('');
const searchQuery = ref('');

const filteredServices = computed(() => {
  if (!searchQuery.value.trim()) return services.value;
  const q = searchQuery.value.toLowerCase();
  return services.value.filter(s =>
    s.name.toLowerCase().includes(q) ||
    (s.category || '').toLowerCase().includes(q) ||
    (s.short_description || '').toLowerCase().includes(q)
  );
});

// Modal
const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref<number | null>(null);
const submitting = ref(false);
const formErrors = ref<string[]>([]);

// Delete
const showDeleteModal = ref(false);
const serviceToDelete = ref<Service | null>(null);
const deleting = ref(false);

// Toast
// Uses global useToast composable (toast is already declared above)

const defaultForm = () => ({
  name: '',
  slug: '',
  short_description: '',
  description: '',
  icon: '',
  image: '',
  category: '',
  features: [] as string[],
  process_steps: [] as Array<{ title: string; description: string }>,
  is_featured: false,
  is_published: true,
  order: 0,
});

const form = ref(defaultForm());

// â”€â”€ Toast helper â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function showToast(message: string, type: 'success' | 'error' = 'success') {
  if (type === 'success') toast.success(message);
  else toast.error(message);
}

// â”€â”€ Fetch â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
async function fetchServices() {
  loading.value = true;
  error.value = '';
  try {
    const res = await get('/admin/cms/services');
    services.value = res.data ?? res ?? [];
  } catch (err: any) {
    error.value = err?.response?.data?.message || err?.message || 'Something went wrong';
  } finally {
    loading.value = false;
  }
}

// â”€â”€ Create / Edit modal â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  form.value = defaultForm();
  formErrors.value = [];
  showModal.value = true;
}

function openEditModal(service: Service) {
  isEditing.value = true;
  editingId.value = service.id;
  form.value = {
    name: service.name ?? '',
    slug: service.slug ?? '',
    short_description: service.short_description ?? '',
    description: service.description ?? '',
    icon: service.icon ?? '',
    image: service.image ?? '',
    category: service.category ?? '',
    features: Array.isArray(service.features) ? [...service.features] : [],
    process_steps: Array.isArray(service.process_steps) ? service.process_steps.map((s: any) => typeof s === 'string' ? { title: s, description: '' } : { title: s.title || '', description: s.description || '' }) : [],
    is_featured: !!service.is_featured,
    is_published: !!service.is_published,
    order: service.order ?? 0,
  };
  formErrors.value = [];
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  formErrors.value = [];
}

// â”€â”€ Features / Steps helpers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function addFeature() { form.value.features.push(''); }
function removeFeature(idx: number) { form.value.features.splice(idx, 1); }
function addStep() { form.value.process_steps.push({ title: '', description: '' }); }
function removeStep(idx: number) { form.value.process_steps.splice(idx, 1); }

// â”€â”€ Submit (Create or Update) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
async function submitForm() {
  formErrors.value = [];
  submitting.value = true;

  // Clean empty strings from arrays
  const payload = {
    ...form.value,
    features: form.value.features.filter((f) => f.trim() !== ''),
    process_steps: form.value.process_steps.filter((s) => s.title.trim() !== ''),
  };

  try {
    if (isEditing.value && editingId.value) {
      await put(`/admin/cms/services/${editingId.value}`, payload);
      showToast('Service updated successfully');
    } else {
      await post('/admin/cms/services', payload);
      showToast('Service created successfully');
    }
    closeModal();
    await fetchServices();
  } catch (err: any) {
    const resp = err?.response?.data;
    if (resp?.errors) {
      formErrors.value = Object.values(resp.errors).flat() as string[];
    } else {
      formErrors.value = [resp?.message || err?.message || 'Something went wrong'];
    }
    showToast(formErrors.value[0] || 'Operation failed', 'error');
  } finally {
    submitting.value = false;
  }
}

// â”€â”€ Delete â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function confirmDelete(service: Service) {
  serviceToDelete.value = service;
  showDeleteModal.value = true;
}

async function deleteService() {
  if (!serviceToDelete.value) return;
  deleting.value = true;
  try {
    await destroy(`/admin/cms/services/${serviceToDelete.value.id}`);
    showToast('Service deleted successfully');
    showDeleteModal.value = false;
    serviceToDelete.value = null;
    await fetchServices();
  } catch (err: any) {
    showToast(err?.response?.data?.message || 'Failed to delete service', 'error');
  } finally {
    deleting.value = false;
  }
}

// â”€â”€ Init â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
onMounted(fetchServices);
</script>
