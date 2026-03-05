<template>
  <AdminLayout>
    <div class="p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground">Case Studies</h1>
          <p class="text-sm text-muted-foreground mt-1">{{ caseStudies.length }} case {{ caseStudies.length !== 1 ? 'studies' : 'study' }} total</p>
        </div>
        <button @click="openCreateModal" class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg hover:shadow-lg transition text-sm font-semibold">
          + New Case Study
        </button>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="flex items-center justify-center py-20">
        <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <span class="ml-3 text-muted-foreground">Loading case studies...</span>
      </div>

      <!-- List -->
      <div v-else>
        <div class="mb-6">
          <input v-model="searchQuery" type="text" placeholder="Search by title, client, industry..." class="w-full sm:w-80 px-4 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
        </div>

        <div v-if="filteredCaseStudies.length === 0" class="py-12 text-center text-muted-foreground">
          {{ searchQuery ? 'No case studies match your search.' : 'No case studies yet. Create your first one!' }}
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          <div v-for="cs in filteredCaseStudies" :key="cs.id" class="bg-card border border-border rounded-xl overflow-hidden hover:border-primary/40 transition group">
            <div v-if="cs.featured_image" class="h-40 overflow-hidden">
              <img :src="cs.featured_image" :alt="cs.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
            </div>
            <div class="p-4 space-y-3">
              <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                  <h3 class="text-sm font-semibold text-foreground truncate">{{ cs.title }}</h3>
                  <p v-if="cs.client_name" class="text-xs text-muted-foreground truncate">{{ cs.client_name }}</p>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                  <span v-if="cs.is_featured" class="px-1.5 py-0.5 text-[10px] rounded-full font-medium bg-amber-500/10 text-amber-400">Featured</span>
                  <span :class="['px-2 py-0.5 text-[10px] rounded-full font-medium', cs.is_published ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400']">
                    {{ cs.is_published ? 'Published' : 'Draft' }}
                  </span>
                </div>
              </div>
              <p v-if="cs.excerpt" class="text-xs text-muted-foreground line-clamp-2">{{ cs.excerpt }}</p>
              <div class="flex items-center gap-3 text-xs text-muted-foreground">
                <span v-if="cs.industry" class="px-1.5 py-0.5 bg-primary/10 text-primary rounded">{{ cs.industry }}</span>
                <span v-if="cs.service">{{ cs.service.name }}</span>
              </div>
              <div v-if="cs.technologies?.length" class="flex flex-wrap gap-1">
                <span v-for="tech in cs.technologies.slice(0, 4)" :key="tech" class="px-1.5 py-0.5 text-[10px] bg-accent/10 text-accent rounded">{{ tech }}</span>
              </div>
              <div class="flex items-center gap-2 pt-2 border-t border-border">
                <button @click="openEditModal(cs)" class="text-primary hover:text-primary/80 text-xs font-medium transition">Edit</button>
                <button @click="deleteCaseStudy(cs.id)" :disabled="deleting === cs.id" class="text-red-400 hover:text-red-300 text-xs font-medium transition disabled:opacity-50">
                  {{ deleting === cs.id ? 'Deleting...' : 'Delete' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.lastPage > 1" class="flex items-center justify-center gap-2 mt-6">
        <button v-for="page in pagination.lastPage" :key="page" @click="fetchCaseStudies(page)" :class="['w-8 h-8 rounded-lg text-sm font-medium transition', page === pagination.currentPage ? 'bg-primary text-foreground' : 'bg-card border border-border text-muted-foreground hover:border-primary']">{{ page }}</button>
      </div>

      <!-- Create / Edit Modal -->
      <Teleport to="body">
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @click.self="showModal = false">
          <div class="bg-card border border-border rounded-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-bold text-foreground">{{ editingId ? 'Edit' : 'Create' }} Case Study</h2>
              <button @click="showModal = false" class="text-muted-foreground hover:text-foreground">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>

            <form @submit.prevent="editingId ? updateCaseStudy() : createCaseStudy()" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Title <span class="text-red-400">*</span></label>
                <input v-model="form.title" type="text" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1">Client Name</label>
                  <input v-model="form.client_name" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1">Industry</label>
                  <input v-model="form.industry" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g. Healthcare, Finance" />
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1">Featured Image URL</label>
                  <input v-model="form.featured_image" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="https://..." />
                </div>
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1">Client Logo URL</label>
                  <input v-model="form.client_logo" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="https://..." />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Excerpt</label>
                <textarea v-model="form.excerpt" rows="2" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="Brief summary for listing pages..."></textarea>
              </div>

              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Technologies</label>
                <input v-model="form.techInput" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="Laravel, Vue.js, Python (comma-separated)" />
              </div>

              <!-- Challenge / Solution / Results -->
              <details class="border border-border rounded-lg" open>
                <summary class="px-3 py-2 text-sm font-medium text-foreground cursor-pointer hover:text-primary transition">Case Study Details</summary>
                <div class="p-3 pt-0 space-y-3">
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">The Challenge</label>
                    <textarea v-model="form.challenge" rows="4" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"></textarea>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">Our Solution</label>
                    <textarea v-model="form.solution" rows="4" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"></textarea>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">The Results</label>
                    <textarea v-model="form.results" rows="4" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"></textarea>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">Full Content (optional)</label>
                    <textarea v-model="form.content" rows="6" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"></textarea>
                  </div>
                </div>
              </details>

              <!-- Metrics -->
              <details class="border border-border rounded-lg">
                <summary class="px-3 py-2 text-sm font-medium text-foreground cursor-pointer hover:text-primary transition">Metrics (Key Numbers)</summary>
                <div class="p-3 pt-0 space-y-2">
                  <div v-for="(metric, i) in form.metrics" :key="i" class="flex gap-2 items-center">
                    <input v-model="metric.value" type="text" placeholder="e.g. 300%" class="w-28 px-2 py-1.5 bg-background border border-border rounded text-sm text-foreground focus:border-primary outline-none" />
                    <input v-model="metric.label" type="text" placeholder="e.g. ROI Increase" class="flex-1 px-2 py-1.5 bg-background border border-border rounded text-sm text-foreground focus:border-primary outline-none" />
                    <button type="button" @click="form.metrics.splice(i, 1)" class="text-red-400 hover:text-red-300 text-xs">Remove</button>
                  </div>
                  <button type="button" @click="form.metrics.push({ value: '', label: '' })" class="text-primary text-xs font-medium hover:underline">+ Add Metric</button>
                </div>
              </details>

              <!-- Testimonial -->
              <details class="border border-border rounded-lg">
                <summary class="px-3 py-2 text-sm font-medium text-foreground cursor-pointer hover:text-primary transition">Client Testimonial</summary>
                <div class="p-3 pt-0 space-y-3">
                  <div>
                    <label class="block text-sm font-medium text-foreground mb-1">Quote</label>
                    <textarea v-model="form.testimonial_quote" rows="3" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"></textarea>
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                      <label class="block text-sm font-medium text-foreground mb-1">Author Name</label>
                      <input v-model="form.testimonial_author" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-foreground mb-1">Author Role</label>
                      <input v-model="form.testimonial_role" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g. CEO, Acme Corp" />
                    </div>
                  </div>
                </div>
              </details>

              <!-- SEO -->
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
                </div>
              </details>

              <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                  <input v-model="form.is_published" type="checkbox" id="csPublished" class="rounded border-border" />
                  <label for="csPublished" class="text-sm text-foreground">Published</label>
                </div>
                <div class="flex items-center gap-2">
                  <input v-model="form.is_featured" type="checkbox" id="csFeatured" class="rounded border-border" />
                  <label for="csFeatured" class="text-sm text-foreground">Featured</label>
                </div>
              </div>

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
import { ref, reactive, computed, onMounted } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';

const { get, post, put, delete: destroy } = useApi();
const toast = useToast();

const caseStudies = ref<any[]>([]);
const loading = ref(false);
const saving = ref(false);
const deleting = ref<number | null>(null);
const showModal = ref(false);
const editingId = ref<number | null>(null);
const searchQuery = ref('');

const pagination = reactive({
  currentPage: 1,
  lastPage: 1,
  total: 0,
});

const filteredCaseStudies = computed(() => {
  if (!searchQuery.value) return caseStudies.value;
  const q = searchQuery.value.toLowerCase();
  return caseStudies.value.filter((cs: any) =>
    (cs.title || '').toLowerCase().includes(q) ||
    (cs.client_name || '').toLowerCase().includes(q) ||
    (cs.industry || '').toLowerCase().includes(q)
  );
});

const defaultForm = () => ({
  title: '',
  excerpt: '',
  content: '',
  featured_image: '',
  client_name: '',
  client_logo: '',
  industry: '',
  techInput: '',
  challenge: '',
  solution: '',
  results: '',
  metrics: [] as { value: string; label: string }[],
  testimonial_quote: '',
  testimonial_author: '',
  testimonial_role: '',
  seo_title: '',
  seo_description: '',
  is_published: true,
  is_featured: false,
});

const form = reactive(defaultForm());

function resetForm() {
  Object.assign(form, defaultForm());
  form.metrics = [];
}

function buildPayload() {
  return {
    title: form.title,
    excerpt: form.excerpt || undefined,
    content: form.content || undefined,
    featured_image: form.featured_image || undefined,
    client_name: form.client_name || undefined,
    client_logo: form.client_logo || undefined,
    industry: form.industry || undefined,
    technologies: form.techInput ? form.techInput.split(',').map((t: string) => t.trim()).filter(Boolean) : [],
    challenge: form.challenge || undefined,
    solution: form.solution || undefined,
    results: form.results || undefined,
    metrics: form.metrics.filter((m) => m.value && m.label),
    testimonial_quote: form.testimonial_quote || undefined,
    testimonial_author: form.testimonial_author || undefined,
    testimonial_role: form.testimonial_role || undefined,
    seo_title: form.seo_title || undefined,
    seo_description: form.seo_description || undefined,
    is_published: form.is_published,
    is_featured: form.is_featured,
  };
}

async function fetchCaseStudies(page = 1) {
  loading.value = true;
  try {
    const res = await get('/admin/case-studies', { params: { page } });
    caseStudies.value = res.data || [];
    pagination.currentPage = res.current_page ?? page;
    pagination.lastPage = res.last_page ?? 1;
    pagination.total = res.total ?? caseStudies.value.length;
  } catch (err: any) {
    toast.error('Failed to load case studies', err?.response?.data?.message || 'Please try again.');
  } finally {
    loading.value = false;
  }
}

function openCreateModal() {
  resetForm();
  editingId.value = null;
  showModal.value = true;
}

function openEditModal(cs: any) {
  resetForm();
  editingId.value = cs.id;
  form.title = cs.title || '';
  form.excerpt = cs.excerpt || '';
  form.content = cs.content || '';
  form.featured_image = cs.featured_image || '';
  form.client_name = cs.client_name || '';
  form.client_logo = cs.client_logo || '';
  form.industry = cs.industry || '';
  form.techInput = (cs.technologies || []).join(', ');
  form.challenge = cs.challenge || '';
  form.solution = cs.solution || '';
  form.results = cs.results || '';
  form.metrics = (cs.metrics || []).map((m: any) => ({ value: m.value || '', label: m.label || '' }));
  form.testimonial_quote = cs.testimonial_quote || '';
  form.testimonial_author = cs.testimonial_author || '';
  form.testimonial_role = cs.testimonial_role || '';
  form.seo_title = cs.seo_title || '';
  form.seo_description = cs.seo_description || '';
  form.is_published = !!cs.is_published;
  form.is_featured = !!cs.is_featured;
  showModal.value = true;
}

async function createCaseStudy() {
  saving.value = true;
  try {
    await post('/admin/case-studies', buildPayload());
    showModal.value = false;
    toast.success('Created', 'Case study has been created successfully.');
    await fetchCaseStudies(pagination.currentPage);
  } catch (err: any) {
    toast.error('Create failed', err?.response?.data?.message || 'Could not create case study.');
  } finally {
    saving.value = false;
  }
}

async function updateCaseStudy() {
  if (!editingId.value) return;
  saving.value = true;
  try {
    await put(`/admin/case-studies/${editingId.value}`, buildPayload());
    showModal.value = false;
    editingId.value = null;
    toast.success('Updated', 'Case study has been updated successfully.');
    await fetchCaseStudies(pagination.currentPage);
  } catch (err: any) {
    toast.error('Update failed', err?.response?.data?.message || 'Could not update case study.');
  } finally {
    saving.value = false;
  }
}

async function deleteCaseStudy(id: number) {
  if (!confirm('Delete this case study? This action cannot be undone.')) return;
  deleting.value = id;
  try {
    await destroy(`/admin/case-studies/${id}`);
    toast.success('Deleted', 'Case study has been removed.');
    await fetchCaseStudies(pagination.currentPage);
  } catch (err: any) {
    toast.error('Delete failed', err?.response?.data?.message || 'Could not delete case study.');
  } finally {
    deleting.value = null;
  }
}

onMounted(() => fetchCaseStudies());
</script>
