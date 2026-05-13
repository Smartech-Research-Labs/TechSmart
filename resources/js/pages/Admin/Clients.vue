<template>
  <AdminLayout>
    <div class="p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground">Trusted By (Clients/Partners)</h1>
          <p class="text-sm text-muted-foreground mt-1">{{ clients.length }} {{ clients.length !== 1 ? 'clients' : 'client' }} total</p>
        </div>
        <button @click="openCreateModal" class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg hover:shadow-lg transition text-sm font-semibold">
          + Add Client
        </button>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="flex items-center justify-center py-20">
        <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <span class="ml-3 text-muted-foreground">Loading clients...</span>
      </div>

      <!-- List -->
      <div v-else class="space-y-4">
        <!-- Search -->
        <div class="mb-6">
          <input v-model="searchQuery" type="text" placeholder="Search by name or domain..." class="w-full sm:w-80 px-4 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
        </div>

        <div v-if="filteredClients.length === 0" class="py-12 text-center text-muted-foreground">
          {{ searchQuery ? 'No clients match your search.' : 'No clients yet. Add your first one!' }}
        </div>

        <!-- Grid -->
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <div v-for="client in filteredClients" :key="client.id" class="bg-card border border-border rounded-xl overflow-hidden hover:border-primary/40 transition group">
            <!-- Logo Preview -->
            <div class="h-32 bg-muted/50 flex items-center justify-center overflow-hidden p-4">
              <img v-if="client.logo" :src="client.logo" :alt="client.name" class="max-h-24 max-w-full object-contain group-hover:scale-110 transition-transform" />
              <div v-else class="text-center">
                <svg class="w-12 h-12 text-muted-foreground/30 mx-auto mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM9 17H7v-7h2v7zm4 0h-2V9h2v8zm4 0h-2v-4h2v4z" /></svg>
                <p class="text-xs text-muted-foreground">No Logo</p>
              </div>
            </div>
            
            <!-- Info -->
            <div class="p-4 space-y-3">
              <div>
                <h3 class="text-sm font-semibold text-foreground truncate">{{ client.name }}</h3>
                <p v-if="client.domain" class="text-xs text-muted-foreground truncate">{{ client.domain }}</p>
              </div>
              
              <!-- Status Badges -->
              <div class="flex items-center gap-2 flex-wrap">
                <span v-if="client.is_visible" class="px-2 py-0.5 text-[10px] rounded-full font-medium bg-green-500/10 text-green-400">Visible</span>
                <span v-else class="px-2 py-0.5 text-[10px] rounded-full font-medium bg-yellow-500/10 text-yellow-400">Hidden</span>
                <span v-if="client.is_seeded" class="px-2 py-0.5 text-[10px] rounded-full font-medium bg-blue-500/10 text-blue-400">Seeded</span>
              </div>

              <!-- Actions -->
              <div class="flex items-center gap-2 pt-2 border-t border-border">
                <button @click="openEditModal(client)" class="text-primary hover:text-primary/80 text-xs font-medium transition">Edit</button>
                <button v-if="!client.is_seeded" @click="deleteClient(client.id)" :disabled="deleting === client.id" class="text-red-400 hover:text-red-300 text-xs font-medium transition disabled:opacity-50">
                  {{ deleting === client.id ? 'Deleting...' : 'Delete' }}
                </button>
                <button v-else class="text-muted-foreground text-xs">Seeded (locked)</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Create / Edit Modal -->
      <Teleport to="body">
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @click.self="showModal = false">
          <div class="bg-card border border-border rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-bold text-foreground">{{ editingId ? 'Edit' : 'Add' }} Client</h2>
              <button @click="showModal = false" class="text-muted-foreground hover:text-foreground">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>

            <form @submit.prevent="editingId ? updateClient() : createClient()" class="space-y-4">
              <!-- Name -->
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Client Name <span class="text-red-400">*</span></label>
                <input v-model="form.name" type="text" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g., Acme Corp" />
              </div>

              <!-- Domain -->
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Domain / Business Type</label>
                <input v-model="form.domain" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g., Technology, Finance" />
              </div>

              <!-- Logo URL -->
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Logo URL</label>
                <input v-model="form.logo" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="https://example.com/logo.png or /storage/path/to/logo.png" />
                <p class="text-xs text-muted-foreground mt-1">Full URL (http/https) or path to storage file (/storage/...)</p>
                <div v-if="form.logo" class="mt-3 p-3 bg-muted/30 rounded-lg flex items-center justify-center h-24">
                  <img :src="form.logo" :alt="form.name" class="max-h-20 max-w-full object-contain" @error="logoError = true" />
                  <p v-if="logoError" class="text-xs text-red-400">Unable to load image</p>
                </div>
              </div>

              <!-- Website URL -->
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Website URL</label>
                <input v-model="form.website_url" type="url" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="https://example.com" />
              </div>

              <!-- Caption -->
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Caption / Description</label>
                <textarea v-model="form.caption" rows="2" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="Brief description of the client..." />
              </div>

              <!-- Display Order -->
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Display Order</label>
                <input v-model.number="form.order" type="number" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="1" />
                <p class="text-xs text-muted-foreground mt-1">Lower numbers appear first in "Trusted By" sections</p>
              </div>

              <!-- Visibility Toggle -->
              <div class="flex items-center gap-3 p-3 bg-muted/20 rounded-lg">
                <input v-model="form.is_visible" type="checkbox" id="isVisible" class="rounded border-border" />
                <label for="isVisible" class="text-sm text-foreground cursor-pointer">
                  Display on Website
                  <p class="text-xs text-muted-foreground">Show this client in "Trusted By" sections on frontend</p>
                </label>
              </div>

              <!-- Submit -->
              <div class="flex gap-3 pt-4">
                <button type="submit" :disabled="saving" class="flex-1 px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg font-semibold text-sm transition hover:shadow-lg disabled:opacity-50">
                  {{ saving ? 'Saving...' : (editingId ? 'Update' : 'Create') }}
                </button>
                <button type="button" @click="showModal = false" class="px-4 py-2 bg-background border border-border text-foreground rounded-lg text-sm transition hover:border-primary">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </Teleport>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, reactive } from 'vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import AdminLayout from '@/layouts/AdminLayout.vue';

const { get, post, put, delete: destroy } = useApi();
const toast = useToast();

const clients = ref<any[]>([]);
const loading = ref(false);
const saving = ref(false);
const deleting = ref<number | null>(null);
const showModal = ref(false);
const editingId = ref<number | null>(null);
const searchQuery = ref('');
const logoError = ref(false);

const filteredClients = computed(() => {
  if (!searchQuery.value) return clients.value;
  const q = searchQuery.value.toLowerCase();
  return clients.value.filter((client: any) =>
    (client.name || '').toLowerCase().includes(q) ||
    (client.domain || '').toLowerCase().includes(q)
  );
});

const defaultForm = () => ({
  name: '',
  logo: '',
  image: '',
  domain: '',
  caption: '',
  website_url: '',
  is_visible: true,
  order: 0,
});

const form = reactive(defaultForm());

function resetForm() {
  Object.assign(form, defaultForm());
  logoError.value = false;
}

async function fetchClients() {
  loading.value = true;
  try {
    const res = await get('/admin/clients');
    clients.value = res.data || [];
  } catch (err: any) {
    toast.error('Failed to load clients', err?.response?.data?.message || 'Please try again.');
  } finally {
    loading.value = false;
  }
}

function openCreateModal() {
  resetForm();
  editingId.value = null;
  showModal.value = true;
}

function openEditModal(client: any) {
  Object.assign(form, client);
  editingId.value = client.id;
  logoError.value = false;
  showModal.value = true;
}

async function createClient() {
  saving.value = true;
  try {
    const payload = {
      name: form.name,
      logo: form.logo || undefined,
      image: form.image || undefined,
      domain: form.domain || undefined,
      caption: form.caption || undefined,
      website_url: form.website_url || undefined,
      is_visible: form.is_visible,
      order: form.order,
    };

    await post('/admin/clients', payload);
    toast.success('Client created successfully');
    showModal.value = false;
    resetForm();
    await fetchClients();
  } catch (err: any) {
    toast.error('Failed to create client', err?.response?.data?.message || 'Please try again.');
  } finally {
    saving.value = false;
  }
}

async function updateClient() {
  saving.value = true;
  try {
    const payload = {
      name: form.name,
      logo: form.logo || undefined,
      image: form.image || undefined,
      domain: form.domain || undefined,
      caption: form.caption || undefined,
      website_url: form.website_url || undefined,
      is_visible: form.is_visible,
      order: form.order,
    };

    await put(`/admin/clients/${editingId.value}`, payload);
    toast.success('Client updated successfully');
    showModal.value = false;
    resetForm();
    await fetchClients();
  } catch (err: any) {
    toast.error('Failed to update client', err?.response?.data?.message || 'Please try again.');
  } finally {
    saving.value = false;
  }
}

async function deleteClient(id: number) {
  if (!confirm('Are you sure you want to delete this client?')) return;
  
  deleting.value = id;
  try {
    await destroy(`/admin/clients/${id}`);
    toast.success('Client deleted successfully');
    await fetchClients();
  } catch (err: any) {
    toast.error('Failed to delete client', err?.response?.data?.message || 'Please try again.');
  } finally {
    deleting.value = null;
  }
}

onMounted(() => fetchClients());
</script>
