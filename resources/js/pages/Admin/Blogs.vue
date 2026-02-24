<template>
  <AdminLayout>
    <div class="p-6">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-2xl font-display font-bold text-foreground">Blog Management</h1>
          <p class="text-sm text-muted-foreground mt-1">{{ blogs.length }} post{{ blogs.length !== 1 ? 's' : '' }} total</p>
        </div>
        <button
          @click="openCreateModal"
          class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg hover:shadow-lg transition text-sm font-semibold"
        >
          + New Post
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-20">
        <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <span class="ml-3 text-muted-foreground">Loading posts...</span>
      </div>

      <!-- Blog List -->
      <div v-else class="bg-card border border-border rounded-xl overflow-hidden">
        <table class="w-full">
          <thead>
            <tr class="border-b border-border">
              <th class="text-left py-3 px-4 text-xs font-semibold text-muted-foreground uppercase">Title</th>
              <th class="text-left py-3 px-4 text-xs font-semibold text-muted-foreground uppercase">Category</th>
              <th class="text-left py-3 px-4 text-xs font-semibold text-muted-foreground uppercase">Tags</th>
              <th class="text-left py-3 px-4 text-xs font-semibold text-muted-foreground uppercase">Status</th>
              <th class="text-left py-3 px-4 text-xs font-semibold text-muted-foreground uppercase">Views</th>
              <th class="text-left py-3 px-4 text-xs font-semibold text-muted-foreground uppercase">Date</th>
              <th class="text-right py-3 px-4 text-xs font-semibold text-muted-foreground uppercase">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="blog in blogs" :key="blog.id" class="border-b border-border last:border-0 hover:bg-white/5 transition">
              <td class="py-3 px-4">
                <div class="text-sm font-medium text-foreground">{{ blog.title }}</div>
                <div v-if="blog.slug" class="text-xs text-muted-foreground truncate max-w-[200px]">/{{ blog.slug }}</div>
              </td>
              <td class="py-3 px-4 text-sm text-muted-foreground">{{ blog.category || '—' }}</td>
              <td class="py-3 px-4">
                <div class="flex flex-wrap gap-1">
                  <span
                    v-for="tag in parseTags(blog.tags)"
                    :key="tag"
                    class="px-1.5 py-0.5 text-[10px] bg-primary/10 text-primary rounded"
                  >{{ tag }}</span>
                  <span v-if="!parseTags(blog.tags).length" class="text-sm text-muted-foreground">—</span>
                </div>
              </td>
              <td class="py-3 px-4">
                <span :class="['px-2 py-1 text-xs rounded-full font-medium', blog.is_published ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400']">
                  {{ blog.is_published ? 'Published' : 'Draft' }}
                </span>
              </td>
              <td class="py-3 px-4 text-sm text-muted-foreground">{{ blog.views || 0 }}</td>
              <td class="py-3 px-4 text-sm text-muted-foreground">{{ formatDate(blog.published_at || blog.created_at) }}</td>
              <td class="py-3 px-4 text-right space-x-2">
                <button @click="openEditModal(blog)" class="text-primary hover:text-primary/80 text-sm font-medium transition">Edit</button>
                <button @click="deleteBlog(blog.id)" :disabled="deleting === blog.id" class="text-red-400 hover:text-red-300 text-sm font-medium transition disabled:opacity-50">
                  {{ deleting === blog.id ? 'Deleting...' : 'Delete' }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="blogs.length === 0" class="py-12 text-center text-muted-foreground">
          No blog posts yet. Create your first one!
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.lastPage > 1" class="flex items-center justify-center gap-2 mt-6">
        <button
          v-for="page in pagination.lastPage"
          :key="page"
          @click="fetchBlogs(page)"
          :class="[
            'w-8 h-8 rounded-lg text-sm font-medium transition',
            page === pagination.currentPage
              ? 'bg-primary text-foreground'
              : 'bg-card border border-border text-muted-foreground hover:border-primary'
          ]"
        >{{ page }}</button>
      </div>

      <!-- Create Modal -->
      <Teleport to="body">
        <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @click.self="showCreateModal = false">
          <div class="bg-card border border-border rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-bold text-foreground">Create Blog Post</h2>
              <button @click="showCreateModal = false" class="text-muted-foreground hover:text-foreground">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>

            <form @submit.prevent="createBlog" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Title <span class="text-red-400">*</span></label>
                <input v-model="form.title" type="text" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
                <p v-if="errors.title" class="text-red-400 text-xs mt-1">{{ errors.title }}</p>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1">Category</label>
                  <input v-model="form.category" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g. Technology, Business" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1">Tags</label>
                  <input v-model="form.tagsInput" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="tag1, tag2, tag3" />
                  <p class="text-muted-foreground text-[10px] mt-0.5">Comma-separated</p>
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Excerpt</label>
                <textarea v-model="form.excerpt" rows="2" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="Short description for listing pages..."></textarea>
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Content <span class="text-red-400">*</span></label>
                <textarea v-model="form.content" rows="10" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"></textarea>
                <p v-if="errors.content" class="text-red-400 text-xs mt-1">{{ errors.content }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Featured Image URL</label>
                <input v-model="form.featured_image" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="https://..." />
              </div>

              <!-- SEO Section -->
              <details class="border border-border rounded-lg">
                <summary class="px-3 py-2 text-sm font-medium text-foreground cursor-pointer hover:text-primary transition">SEO Settings</summary>
                <div class="p-3 pt-0 space-y-3">
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">SEO Title</label>
                    <input v-model="form.seo_title" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">SEO Description</label>
                    <textarea v-model="form.seo_description" rows="2" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"></textarea>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">SEO Keywords</label>
                    <input v-model="form.seo_keywords" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="keyword1, keyword2" />
                  </div>
                </div>
              </details>

              <div class="flex items-center gap-2">
                <input v-model="form.is_published" type="checkbox" id="createPublished" class="rounded border-border" />
                <label for="createPublished" class="text-sm text-foreground">Publish immediately</label>
              </div>

              <div class="flex gap-3 pt-4">
                <button type="submit" :disabled="saving" class="flex-1 px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg font-semibold text-sm transition hover:shadow-lg disabled:opacity-50">
                  {{ saving ? 'Creating...' : 'Create Post' }}
                </button>
                <button type="button" @click="showCreateModal = false" class="px-4 py-2 bg-background border border-border text-foreground rounded-lg text-sm transition hover:border-primary">
                  Cancel
                </button>
              </div>
            </form>
          </div>
        </div>
      </Teleport>

      <!-- Edit Modal -->
      <Teleport to="body">
        <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @click.self="showEditModal = false">
          <div class="bg-card border border-border rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-bold text-foreground">Edit Blog Post</h2>
              <button @click="showEditModal = false" class="text-muted-foreground hover:text-foreground">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>

            <form @submit.prevent="updateBlog" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Title <span class="text-red-400">*</span></label>
                <input v-model="form.title" type="text" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
                <p v-if="errors.title" class="text-red-400 text-xs mt-1">{{ errors.title }}</p>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1">Slug</label>
                  <input v-model="form.slug" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="auto-generated-from-title" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1">Category</label>
                  <input v-model="form.category" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g. Technology, Business" />
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Tags</label>
                <input v-model="form.tagsInput" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="tag1, tag2, tag3" />
                <p class="text-muted-foreground text-[10px] mt-0.5">Comma-separated</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Excerpt</label>
                <textarea v-model="form.excerpt" rows="2" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="Short description for listing pages..."></textarea>
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Content <span class="text-red-400">*</span></label>
                <textarea v-model="form.content" rows="10" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"></textarea>
                <p v-if="errors.content" class="text-red-400 text-xs mt-1">{{ errors.content }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Featured Image URL</label>
                <input v-model="form.featured_image" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="https://..." />
              </div>

              <!-- SEO Section -->
              <details class="border border-border rounded-lg" open>
                <summary class="px-3 py-2 text-sm font-medium text-foreground cursor-pointer hover:text-primary transition">SEO Settings</summary>
                <div class="p-3 pt-0 space-y-3">
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">SEO Title</label>
                    <input v-model="form.seo_title" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">SEO Description</label>
                    <textarea v-model="form.seo_description" rows="2" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"></textarea>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">SEO Keywords</label>
                    <input v-model="form.seo_keywords" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="keyword1, keyword2" />
                  </div>
                </div>
              </details>

              <div class="flex items-center gap-2">
                <input v-model="form.is_published" type="checkbox" id="editPublished" class="rounded border-border" />
                <label for="editPublished" class="text-sm text-foreground">Published</label>
              </div>

              <div class="flex gap-3 pt-4">
                <button type="submit" :disabled="saving" class="flex-1 px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg font-semibold text-sm transition hover:shadow-lg disabled:opacity-50">
                  {{ saving ? 'Saving...' : 'Update Post' }}
                </button>
                <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-background border border-border text-foreground rounded-lg text-sm transition hover:border-primary">
                  Cancel
                </button>
              </div>
            </form>
          </div>
        </div>
      </Teleport>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';

const { get, post, put, delete: destroy } = useApi();
const toast = useToast();

// --- State ---
const blogs = ref<any[]>([]);
const loading = ref(false);
const saving = ref(false);
const deleting = ref<number | null>(null);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const editingId = ref<number | null>(null);

const pagination = reactive({
  currentPage: 1,
  lastPage: 1,
  total: 0,
});

const defaultForm = () => ({
  title: '',
  slug: '',
  content: '',
  excerpt: '',
  category: '',
  tagsInput: '',
  featured_image: '',
  seo_title: '',
  seo_description: '',
  seo_keywords: '',
  is_published: true,
});

const form = reactive(defaultForm());
const errors = reactive<Record<string, string>>({});

// --- Helpers ---
function resetForm() {
  Object.assign(form, defaultForm());
  Object.keys(errors).forEach((k) => delete errors[k]);
}

function parseTags(tags: any): string[] {
  if (!tags) return [];
  if (Array.isArray(tags)) return tags.filter(Boolean);
  if (typeof tags === 'string') {
    try { return JSON.parse(tags); } catch { return tags.split(',').map((t: string) => t.trim()).filter(Boolean); }
  }
  return [];
}

function tagsInputToArray(input: string): string[] {
  return input.split(',').map((t) => t.trim()).filter(Boolean);
}

function buildPayload() {
  return {
    title: form.title,
    slug: form.slug || undefined,
    content: form.content,
    excerpt: form.excerpt || undefined,
    category: form.category || undefined,
    tags: tagsInputToArray(form.tagsInput),
    featured_image: form.featured_image || undefined,
    seo_title: form.seo_title || undefined,
    seo_description: form.seo_description || undefined,
    seo_keywords: form.seo_keywords || undefined,
    is_published: form.is_published,
  };
}

function applyValidationErrors(err: any) {
  Object.keys(errors).forEach((k) => delete errors[k]);
  if (err?.response?.status === 422 && err.response.data?.errors) {
    const serverErrors = err.response.data.errors as Record<string, string[]>;
    for (const [field, messages] of Object.entries(serverErrors)) {
      errors[field] = messages[0];
    }
  }
}

function formatDate(date: string) {
  if (!date) return '';
  return new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

// --- CRUD ---
async function fetchBlogs(page = 1) {
  loading.value = true;
  try {
    const res = await get('/admin/blogs', { params: { page } });
    blogs.value = res.data || [];
    pagination.currentPage = res.current_page ?? page;
    pagination.lastPage = res.last_page ?? 1;
    pagination.total = res.total ?? blogs.value.length;
  } catch (err: any) {
    toast.error('Failed to load blogs', err?.response?.data?.message || 'Please try again.');
  } finally {
    loading.value = false;
  }
}

function openCreateModal() {
  resetForm();
  showCreateModal.value = true;
}

async function createBlog() {
  saving.value = true;
  Object.keys(errors).forEach((k) => delete errors[k]);
  try {
    await post('/admin/blogs', buildPayload());
    showCreateModal.value = false;
    toast.success('Post created', 'Blog post has been created successfully.');
    await fetchBlogs(pagination.currentPage);
  } catch (err: any) {
    applyValidationErrors(err);
    toast.error('Create failed', err?.response?.data?.message || 'Could not create blog post.');
  } finally {
    saving.value = false;
  }
}

function openEditModal(blog: any) {
  resetForm();
  editingId.value = blog.id;
  form.title = blog.title || '';
  form.slug = blog.slug || '';
  form.content = blog.content || '';
  form.excerpt = blog.excerpt || '';
  form.category = blog.category || '';
  form.tagsInput = parseTags(blog.tags).join(', ');
  form.featured_image = blog.featured_image || '';
  form.seo_title = blog.seo_title || '';
  form.seo_description = blog.seo_description || '';
  form.seo_keywords = blog.seo_keywords || '';
  form.is_published = !!blog.is_published;
  showEditModal.value = true;
}

async function updateBlog() {
  if (!editingId.value) return;
  saving.value = true;
  Object.keys(errors).forEach((k) => delete errors[k]);
  try {
    await put(`/admin/blogs/${editingId.value}`, buildPayload());
    showEditModal.value = false;
    editingId.value = null;
    toast.success('Post updated', 'Blog post has been updated successfully.');
    await fetchBlogs(pagination.currentPage);
  } catch (err: any) {
    applyValidationErrors(err);
    toast.error('Update failed', err?.response?.data?.message || 'Could not update blog post.');
  } finally {
    saving.value = false;
  }
}

async function deleteBlog(id: number) {
  if (!confirm('Are you sure you want to delete this post? This action cannot be undone.')) return;
  deleting.value = id;
  try {
    await destroy(`/admin/blogs/${id}`);
    toast.success('Post deleted', 'Blog post has been removed.');
    await fetchBlogs(pagination.currentPage);
  } catch (err: any) {
    toast.error('Delete failed', err?.response?.data?.message || 'Could not delete blog post.');
  } finally {
    deleting.value = null;
  }
}

onMounted(() => fetchBlogs());
</script>
