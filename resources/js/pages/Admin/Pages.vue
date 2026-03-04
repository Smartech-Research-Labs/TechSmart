<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground mb-1">Manage Pages</h1>
          <p class="text-sm text-muted-foreground">Create and edit website pages</p>
        </div>
        <button
          class="bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 rounded-lg transition text-sm"
          @click="openCreateModal"
        >
          + Add New Page
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-20">
        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-primary"></div>
        <span class="ml-3 text-muted-foreground">Loading pages...</span>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-red-500/10 border border-red-500/30 rounded-lg p-6 text-center">
        <p class="text-red-400 font-semibold mb-2">Failed to load pages</p>
        <p class="text-muted-foreground text-sm mb-4">{{ error }}</p>
        <button
          class="bg-primary hover:bg-primary/90 text-white font-semibold px-4 py-2 rounded-lg transition text-sm"
          @click="fetchPages"
        >
          Retry
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="pages.length === 0" class="bg-card border border-border rounded-lg p-12 text-center">
        <p class="text-muted-foreground text-lg mb-2">No pages found</p>
        <p class="text-muted-foreground text-sm mb-6">Get started by creating your first page.</p>
        <button
          class="bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition"
          @click="openCreateModal"
        >
          + Add New Page
        </button>
      </div>

      <!-- Search Bar -->
      <div v-if="pages.length > 0" class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search pages..."
          class="w-full bg-card border border-border rounded-lg pl-10 pr-4 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition"
        />
      </div>

      <!-- Pages Card Grid -->
      <div v-if="!loading && !error && filteredPages.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="page in filteredPages"
          :key="page.id"
          class="bg-card border border-border rounded-lg p-4 hover:border-primary/50 transition group"
        >
          <div class="flex items-start justify-between mb-3">
            <h3 class="text-sm font-semibold text-foreground group-hover:text-primary transition truncate pr-2">{{ page.title }}</h3>
            <span :class="[
              'px-2 py-0.5 rounded text-[10px] font-semibold shrink-0',
              page.is_published ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-muted-foreground'
            ]">
              {{ page.is_published ? 'Published' : 'Draft' }}
            </span>
          </div>
          <p class="text-xs text-muted-foreground mb-1">/{{ page.slug }}</p>
          <p v-if="page.description" class="text-xs text-muted-foreground line-clamp-2 mb-3">{{ page.description }}</p>
          <p class="text-[10px] text-muted-foreground/60 mb-3">Updated {{ formatDate(page.updated_at) }}</p>
          <div class="flex items-center gap-2">
            <button
              class="text-xs text-primary hover:text-primary/80 font-medium transition"
              @click="openEditModal(page)"
            >
              Edit
            </button>
            <span class="text-border">|</span>
            <button
              class="text-xs text-red-400 hover:text-red-300 font-medium transition"
              @click="confirmDelete(page)"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <!-- No search results -->
      <div v-if="!loading && !error && pages.length > 0 && filteredPages.length === 0" class="text-center py-8">
        <p class="text-muted-foreground text-sm">No pages match "{{ searchQuery }}"</p>
      </div>

      <!-- Create / Edit Modal -->
      <Teleport to="body">
        <div
          v-if="showModal"
          class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
          @click.self="closeModal"
        >
          <div class="bg-card border border-border rounded-xl shadow-2xl w-full max-w-xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-border">
              <h2 class="text-xl font-display font-bold text-foreground">
                {{ editingPage ? 'Edit Page' : 'Create Page' }}
              </h2>
              <button class="text-muted-foreground hover:text-foreground transition" @click="closeModal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>

            <form class="p-6 space-y-5" @submit.prevent="savePage">
              <!-- Title -->
              <div>
                <label class="block text-sm font-semibold text-foreground mb-1.5">Title</label>
                <input
                  v-model="form.title"
                  type="text"
                  required
                  class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition"
                  placeholder="Page title"
                  @input="autoSlug"
                />
              </div>

              <!-- Slug -->
              <div>
                <label class="block text-sm font-semibold text-foreground mb-1.5">Slug</label>
                <input
                  v-model="form.slug"
                  type="text"
                  required
                  class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition"
                  placeholder="page-slug"
                />
              </div>

              <!-- Description -->
              <div>
                <label class="block text-sm font-semibold text-foreground mb-1.5">Description</label>
                <textarea
                  v-model="form.description"
                  rows="3"
                  class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition resize-none"
                  placeholder="Brief page description"
                ></textarea>
              </div>

              <!-- SEO Title -->
              <div>
                <label class="block text-sm font-semibold text-foreground mb-1.5">SEO Title</label>
                <input
                  v-model="form.seo_title"
                  type="text"
                  class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition"
                  placeholder="SEO title (optional)"
                />
              </div>

              <!-- SEO Description -->
              <div>
                <label class="block text-sm font-semibold text-foreground mb-1.5">SEO Description</label>
                <textarea
                  v-model="form.seo_description"
                  rows="2"
                  class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition resize-none"
                  placeholder="SEO description (optional)"
                ></textarea>
              </div>

              <!-- Published Toggle -->
              <div class="flex items-center gap-3">
                <button
                  type="button"
                  :class="[
                    'relative inline-flex h-6 w-11 items-center rounded-full transition-colors',
                    form.is_published ? 'bg-primary' : 'bg-border'
                  ]"
                  @click="form.is_published = !form.is_published"
                >
                  <span
                    :class="[
                      'inline-block h-4 w-4 transform rounded-full bg-white transition-transform',
                      form.is_published ? 'translate-x-6' : 'translate-x-1'
                    ]"
                  />
                </button>
                <label class="text-sm font-semibold text-foreground">
                  {{ form.is_published ? 'Published' : 'Draft' }}
                </label>
              </div>

              <!-- Form Actions -->
              <div class="flex items-center justify-end gap-3 pt-2">
                <button
                  type="button"
                  class="px-5 py-2.5 rounded-lg border border-border text-foreground hover:bg-muted/50 font-semibold transition text-sm"
                  @click="closeModal"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  :disabled="saving"
                  class="bg-primary hover:bg-primary/90 disabled:opacity-50 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm flex items-center gap-2"
                >
                  <span v-if="saving" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></span>
                  {{ saving ? 'Saving...' : (editingPage ? 'Update Page' : 'Create Page') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </Teleport>

      <!-- Delete Confirmation Modal -->
      <Teleport to="body">
        <div
          v-if="showDeleteModal"
          class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
          @click.self="showDeleteModal = false"
        >
          <div class="bg-card border border-border rounded-xl shadow-2xl w-full max-w-md mx-4 p-6">
            <h2 class="text-xl font-display font-bold text-foreground mb-2">Delete Page</h2>
            <p class="text-muted-foreground mb-6">
              Are you sure you want to delete <span class="font-semibold text-foreground">{{ deletingPage?.title }}</span>? This action cannot be undone.
            </p>
            <div class="flex items-center justify-end gap-3">
              <button
                class="px-5 py-2.5 rounded-lg border border-border text-foreground hover:bg-muted/50 font-semibold transition text-sm"
                @click="showDeleteModal = false"
              >
                Cancel
              </button>
              <button
                :disabled="deleting"
                class="bg-red-500 hover:bg-red-600 disabled:opacity-50 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm flex items-center gap-2"
                @click="deletePage"
              >
                <span v-if="deleting" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></span>
                {{ deleting ? 'Deleting...' : 'Delete' }}
              </button>
            </div>
          </div>
        </div>
      </Teleport>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';

interface Page {
  id: number;
  title: string;
  slug: string;
  description: string | null;
  seo_title: string | null;
  seo_description: string | null;
  og_image: string | null;
  is_published: boolean;
  created_at: string;
  updated_at: string;
}

const { get, post, put, delete: destroy } = useApi();
const toast = useToast();

const pages = ref<Page[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);
const saving = ref(false);
const deleting = ref(false);
const searchQuery = ref('');

const filteredPages = computed(() => {
  if (!searchQuery.value.trim()) return pages.value;
  const q = searchQuery.value.toLowerCase();
  return pages.value.filter(p =>
    p.title.toLowerCase().includes(q) ||
    p.slug.toLowerCase().includes(q) ||
    (p.description && p.description.toLowerCase().includes(q))
  );
});

// Modal state
const showModal = ref(false);
const editingPage = ref<Page | null>(null);
const showDeleteModal = ref(false);
const deletingPage = ref<Page | null>(null);

const defaultForm = {
  title: '',
  slug: '',
  description: '',
  seo_title: '',
  seo_description: '',
  is_published: false,
};

const form = ref({ ...defaultForm });

// Fetch pages
async function fetchPages() {
  loading.value = true;
  error.value = null;
  try {
    const res = await get('/admin/pages');
    pages.value = res.pages ?? res.data ?? res;
  } catch (e: any) {
    error.value = e.response?.data?.message || e.message || 'An unexpected error occurred';
    toast.error('Error', error.value!);
  } finally {
    loading.value = false;
  }
}

// Auto-generate slug from title (only when creating)
function autoSlug() {
  if (!editingPage.value) {
    form.value.slug = form.value.title
      .toLowerCase()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-')
      .replace(/^-|-$/g, '');
  }
}

// Open create modal
function openCreateModal() {
  editingPage.value = null;
  form.value = { ...defaultForm };
  showModal.value = true;
}

// Open edit modal
function openEditModal(page: Page) {
  editingPage.value = page;
  form.value = {
    title: page.title,
    slug: page.slug,
    description: page.description ?? '',
    seo_title: page.seo_title ?? '',
    seo_description: page.seo_description ?? '',
    is_published: page.is_published,
  };
  showModal.value = true;
}

// Close modal
function closeModal() {
  showModal.value = false;
  editingPage.value = null;
  form.value = { ...defaultForm };
}

// Save (create or update)
async function savePage() {
  saving.value = true;
  try {
    if (editingPage.value) {
      const res = await put(`/admin/pages/${editingPage.value.id}`, form.value);
      const updated = res.page ?? res.data ?? res;
      const idx = pages.value.findIndex((p) => p.id === editingPage.value!.id);
      if (idx !== -1) pages.value[idx] = updated;
      toast.success('Page Updated', `"${updated.title}" has been updated.`);
    } else {
      const res = await post('/admin/pages', form.value);
      const created = res.page ?? res.data ?? res;
      pages.value.unshift(created);
      toast.success('Page Created', `"${created.title}" has been created.`);
    }
    closeModal();
  } catch (e: any) {
    const msg = e.response?.data?.message || e.message || 'Failed to save page';
    toast.error('Error', msg);
  } finally {
    saving.value = false;
  }
}

// Confirm delete
function confirmDelete(page: Page) {
  deletingPage.value = page;
  showDeleteModal.value = true;
}

// Delete page
async function deletePage() {
  if (!deletingPage.value) return;
  deleting.value = true;
  try {
    await destroy(`/admin/pages/${deletingPage.value.id}`);
    pages.value = pages.value.filter((p) => p.id !== deletingPage.value!.id);
    toast.success('Page Deleted', `"${deletingPage.value.title}" has been deleted.`);
    showDeleteModal.value = false;
    deletingPage.value = null;
  } catch (e: any) {
    const msg = e.response?.data?.message || e.message || 'Failed to delete page';
    toast.error('Error', msg);
  } finally {
    deleting.value = false;
  }
}

// Format date helper
function formatDate(dateStr: string): string {
  if (!dateStr) return '—';
  const date = new Date(dateStr);
  return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

onMounted(fetchPages);
</script>
