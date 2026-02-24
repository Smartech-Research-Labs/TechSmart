<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-display font-bold text-foreground">CMS Management</h1>
          <p class="text-muted-foreground mt-1">Manage all content across your website</p>
        </div>
      </div>

      <!-- Tabs -->
      <div class="border-b border-border">
        <nav class="-mb-px flex space-x-8">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'pb-4 px-1 border-b-2 font-medium text-sm transition',
              activeTab === tab.id
                ? 'border-primary text-primary'
                : 'border-transparent text-muted-foreground hover:text-foreground hover:border-border'
            ]"
          >
            {{ tab.label }}
          </button>
        </nav>
      </div>

      <!-- Tab Content -->
      <div class="mt-6">
        <!-- Sliders Tab -->
        <div v-if="activeTab === 'sliders'" class="space-y-4">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-foreground">Hero Sliders</h2>
            <button
              @click="showCreateSliderModal = true"
              class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg hover:shadow-lg transition text-sm font-semibold"
            >
              + Add Slider
            </button>
          </div>

          <!-- Sliders List -->
          <div v-if="sliders.length > 0" class="grid gap-4">
            <div
              v-for="slider in sliders"
              :key="slider.id"
              class="bg-card border border-border rounded-lg p-6 flex items-start justify-between"
            >
              <div class="flex-1">
                <h3 class="text-lg font-bold text-foreground">{{ slider.heading }}</h3>
                <p class="text-sm text-muted-foreground mt-1">{{ slider.subheading }}</p>
                <div class="mt-3 flex items-center gap-4 text-xs text-muted-foreground">
                  <span>Order: {{ slider.order }}</span>
                  <span :class="slider.is_visible ? 'text-green-500' : 'text-red-500'">
                    {{ slider.is_visible ? 'Visible' : 'Hidden' }}
                  </span>
                </div>
              </div>
              <div class="flex items-center gap-2">
                <button
                  @click="editSlider(slider)"
                  class="px-3 py-1.5 text-sm bg-muted text-foreground rounded hover:bg-muted/80 transition"
                >
                  Edit
                </button>
                <button
                  @click="deleteSlider(slider.id)"
                  class="px-3 py-1.5 text-sm bg-red-500/10 text-red-500 rounded hover:bg-red-500/20 transition"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12 bg-card border border-border rounded-lg">
            <p class="text-muted-foreground">No sliders yet. Create your first one!</p>
          </div>
        </div>

        <!-- Clients Tab -->
        <div v-if="activeTab === 'clients'" class="space-y-4">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-foreground">Client Logos</h2>
            <button
              @click="showCreateClientModal = true"
              class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg hover:shadow-lg transition text-sm font-semibold"
            >
              + Add Client
            </button>
          </div>

          <!-- Clients Grid -->
          <div v-if="clients.length > 0" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <div
              v-for="client in clients"
              :key="client.id"
              class="bg-card border border-border rounded-lg p-4 text-center group relative"
            >
              <img
                :src="`/storage/${client.logo}`"
                :alt="client.name"
                class="h-16 w-auto mx-auto object-contain"
                onerror="this.src='/placeholder-logo.png'"
              />
              <p class="mt-2 text-xs text-muted-foreground">{{ client.name }}</p>
              <div class="absolute inset-0 bg-background/90 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 rounded-lg">
                <button
                  @click="deleteClient(client.id)"
                  class="px-3 py-1.5 text-xs bg-red-500 text-foreground rounded"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12 bg-card border border-border rounded-lg">
            <p class="text-muted-foreground">No clients yet. Add your first client logo!</p>
          </div>
        </div>

        <!-- Counters Tab -->
        <div v-if="activeTab === 'counters'" class="space-y-4">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-foreground">Stats Counters</h2>
            <button
              @click="showCreateCounterModal = true"
              class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg hover:shadow-lg transition text-sm font-semibold"
            >
              + Add Counter
            </button>
          </div>

          <div v-if="counters.length > 0" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
              v-for="counter in counters"
              :key="counter.id"
              class="bg-card border border-border rounded-lg p-6"
            >
              <div class="text-3xl font-bold text-primary">
                {{ counter.number }}{{ counter.suffix }}
              </div>
              <div class="text-sm text-foreground mt-2">{{ counter.label }}</div>
              <div class="mt-4 flex gap-2">
                <button
                  @click="editCounter(counter)"
                  class="px-3 py-1 text-xs bg-muted text-foreground rounded"
                >
                  Edit
                </button>
                <button
                  @click="deleteCounter(counter.id)"
                  class="px-3 py-1 text-xs bg-red-500/10 text-red-500 rounded"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12 bg-card border border-border rounded-lg">
            <p class="text-muted-foreground">No counters yet. Create stats for your homepage!</p>
          </div>
        </div>

        <!-- Pages Tab -->
        <div v-if="activeTab === 'pages'" class="space-y-4">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-foreground">Custom Pages</h2>
            <router-link
              to="/admin/pages/create"
              class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg hover:shadow-lg transition text-sm font-semibold"
            >
              + Create Page
            </router-link>
          </div>

          <div v-if="pages.length > 0" class="space-y-4">
            <div
              v-for="page in pages"
              :key="page.id"
              class="bg-card border border-border rounded-lg p-6 flex items-start justify-between"
            >
              <div class="flex-1">
                <h3 class="text-lg font-bold text-foreground">{{ page.title }}</h3>
                <p class="text-sm text-muted-foreground mt-1">{{ page.description }}</p>
                <div class="mt-3 flex items-center gap-4 text-xs text-muted-foreground">
                  <span>/{{ page.slug }}</span>
                  <span>{{ page.sections?.length || 0 }} sections</span>
                  <span :class="page.is_published ? 'text-green-500' : 'text-red-500'">
                    {{ page.is_published ? 'Published' : 'Draft' }}
                  </span>
                </div>
              </div>
              <div class="flex items-center gap-2">
                <router-link
                  :to="`/admin/pages/${page.id}`"
                  class="px-3 py-1.5 text-sm bg-muted text-foreground rounded hover:bg-muted/80 transition"
                >
                  Edit
                </router-link>
                <button
                  @click="deletePage(page.id)"
                  class="px-3 py-1.5 text-sm bg-red-500/10 text-red-500 rounded hover:bg-red-500/20 transition"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12 bg-card border border-border rounded-lg">
            <p class="text-muted-foreground">No custom pages yet. Create your first page!</p>
          </div>
        </div>

        <!-- Settings Tab -->
        <div v-if="activeTab === 'settings'" class="space-y-6">
          <div class="bg-card border border-border rounded-lg p-6">
            <h2 class="text-xl font-bold text-foreground mb-6">Site Settings</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
              <!-- Logo Upload -->
              <div>
                <label class="block text-sm font-medium text-foreground mb-2">Site Logo</label>
                <div class="flex items-center gap-4">
                  <img
                    v-if="settings?.logo_path"
                    :src="`/storage/${settings.logo_path}`"
                    alt="Logo"
                    class="h-16 w-auto"
                  />
                  <input
                    type="file"
                    @change="uploadLogo"
                    accept="image/*"
                    class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-foreground hover:file:bg-primary/90"
                  />
                </div>
              </div>

              <!-- Favicon Upload -->
              <div>
                <label class="block text-sm font-medium text-foreground mb-2">Favicon</label>
                <div class="flex items-center gap-4">
                  <img
                    v-if="settings?.favicon_path"
                    :src="`/storage/${settings.favicon_path}`"
                    alt="Favicon"
                    class="h-8 w-8"
                  />
                  <input
                    type="file"
                    @change="uploadFavicon"
                    accept="image/*"
                    class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-foreground hover:file:bg-primary/90"
                  />
                </div>
              </div>
            </div>

            <div class="mt-6 grid gap-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-2">Site Name</label>
                <input
                  v-model="settings.site_name"
                  type="text"
                  class="w-full px-4 py-2 bg-background border border-border rounded-lg text-foreground"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-2">Tagline</label>
                <input
                  v-model="settings.tagline"
                  type="text"
                  class="w-full px-4 py-2 bg-background border border-border rounded-lg text-foreground"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-2">Marquee Text (pipe-separated)</label>
                <textarea
                  v-model="settings.marquee_text"
                  rows="3"
                  class="w-full px-4 py-2 bg-background border border-border rounded-lg text-foreground"
                ></textarea>
              </div>
              <button
                @click="saveSettings"
                class="self-start px-6 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg hover:shadow-lg transition font-semibold"
              >
                Save Settings
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import AdminLayout from '@/layouts/AdminLayout.vue';
import axios from 'axios';

const router = useRouter();

const activeTab = ref('sliders');
const tabs = [
  { id: 'sliders', label: 'Sliders' },
  { id: 'clients', label: 'Clients' },
  { id: 'counters', label: 'Counters' },
  { id: 'pages', label: 'Pages' },
  { id: 'settings', label: 'Settings' },
];

const sliders = ref<any[]>([]);
const clients = ref<any[]>([]);
const counters = ref<any[]>([]);
const pages = ref<any[]>([]);
const settings = ref<any>({});

const showCreateSliderModal = ref(false);
const showCreateClientModal = ref(false);
const showCreateCounterModal = ref(false);

onMounted(async () => {
  await Promise.all([
    fetchSliders(),
    fetchClients(),
    fetchCounters(),
    fetchPages(),
    fetchSettings(),
  ]);
});

async function fetchSliders() {
  try {
    const { data } = await axios.get('/api/v1/admin/sliders');
    sliders.value = data.sliders || [];
  } catch (err) {
    console.error('Failed to fetch sliders:', err);
  }
}

async function fetchClients() {
  try {
    const { data } = await axios.get('/api/v1/admin/cms/clients');
    clients.value = data.clients || [];
  } catch (err) {
    console.error('Failed to fetch clients:', err);
  }
}

async function fetchCounters() {
  try {
    const { data } = await axios.get('/api/v1/admin/cms/counters');
    counters.value = data.counters || [];
  } catch (err) {
    console.error('Failed to fetch counters:', err);
  }
}

async function fetchPages() {
  try {
    const { data } = await axios.get('/api/v1/admin/pages');
    pages.value = data.pages || [];
  } catch (err) {
    console.error('Failed to fetch pages:', err);
  }
}

async function fetchSettings() {
  try {
    const { data } = await axios.get('/api/v1/admin/settings');
    settings.value = data.settings?.general || {};
  } catch (err) {
    console.error('Failed to fetch settings:', err);
  }
}

async function deleteSlider(id: number) {
  if (!confirm('Are you sure you want to delete this slider?')) return;
  
  try {
    await axios.delete(`/api/v1/admin/sliders/${id}`);
    await fetchSliders();
  } catch (err) {
    console.error('Failed to delete slider:', err);
    alert('Failed to delete slider');
  }
}

async function deleteClient(id: number) {
  if (!confirm('Are you sure you want to delete this client?')) return;
  
  try {
    await axios.delete(`/api/v1/admin/cms/clients/${id}`);
    await fetchClients();
  } catch (err) {
    console.error('Failed to delete client:', err);
    alert('Failed to delete client');
  }
}

async function deleteCounter(id: number) {
  if (!confirm('Are you sure you want to delete this counter?')) return;
  
  try {
    await axios.delete(`/api/v1/admin/cms/counters/${id}`);
    await fetchCounters();
  } catch (err) {
    console.error('Failed to delete counter:', err);
    alert('Failed to delete counter');
  }
}

async function deletePage(id: number) {
  if (!confirm('Are you sure you want to delete this page?')) return;
  
  try {
    await axios.delete(`/api/v1/admin/pages/${id}`);
    await fetchPages();
  } catch (err) {
    console.error('Failed to delete page:', err);
    alert('Failed to delete page');
  }
}

async function uploadLogo(event: Event) {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('logo', file);

  try {
    const { data } = await axios.post('/api/v1/admin/settings/logo', formData);
    settings.value.logo_path = data.logo_path;
    alert('Logo uploaded successfully');
  } catch (err) {
    console.error('Failed to upload logo:', err);
    alert('Failed to upload logo');
  }
}

async function uploadFavicon(event: Event) {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('favicon', file);

  try {
    const { data } = await axios.post('/api/v1/admin/settings/favicon', formData);
    settings.value.favicon_path = data.favicon_path;
    alert('Favicon uploaded successfully');
  } catch (err) {
    console.error('Failed to upload favicon:', err);
    alert('Failed to upload favicon');
  }
}

async function saveSettings() {
  try {
    await axios.put('/api/v1/admin/settings', {
      settings: [
        { key: 'site_name', value: settings.value.site_name, group: 'general' },
        { key: 'tagline', value: settings.value.tagline, group: 'general' },
        { key: 'marquee_text', value: settings.value.marquee_text, group: 'general' },
      ]
    });
    alert('Settings saved successfully');
  } catch (err) {
    console.error('Failed to save settings:', err);
    alert('Failed to save settings');
  }
}

function editSlider(slider: any) {
  // TODO: Implement edit modal
  console.log('Edit slider:', slider);
}

function editCounter(counter: any) {
  // TODO: Implement edit modal
  console.log('Edit counter:', counter);
}
</script>
