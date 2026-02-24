<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-display font-bold text-foreground mb-2">Manage Products</h1>
          <p class="text-muted-foreground">Add, edit, and organize products</p>
        </div>
        <button
          @click="openCreateModal"
          class="bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition"
        >
          + Add Product
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-20">
        <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <span class="ml-3 text-muted-foreground">Loading products...</span>
      </div>

      <!-- Error State -->
      <div v-else-if="fetchError" class="bg-red-500/10 border border-red-500/30 rounded-lg p-6 text-center">
        <p class="text-red-400 mb-3">{{ fetchError }}</p>
        <button @click="fetchProducts" class="text-sm text-primary hover:underline">Try again</button>
      </div>

      <!-- Products Table -->
      <div v-else class="bg-card border border-border rounded-lg overflow-hidden">
        <table class="w-full">
          <thead class="bg-muted/30">
            <tr class="border-b border-border">
              <th class="text-left text-muted-foreground text-sm font-semibold p-4">Product Name</th>
              <th class="text-left text-muted-foreground text-sm font-semibold p-4">Category</th>
              <th class="text-left text-muted-foreground text-sm font-semibold p-4">Price</th>
              <th class="text-left text-muted-foreground text-sm font-semibold p-4">Featured</th>
              <th class="text-left text-muted-foreground text-sm font-semibold p-4">Status</th>
              <th class="text-left text-muted-foreground text-sm font-semibold p-4">Order</th>
              <th class="text-right text-muted-foreground text-sm font-semibold p-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="product in products"
              :key="product.id"
              class="border-b border-border hover:bg-muted/20 transition"
            >
              <td class="p-4">
                <p class="text-foreground font-semibold">{{ product.name }}</p>
                <p v-if="product.short_description" class="text-muted-foreground text-xs mt-0.5 line-clamp-1">{{ product.short_description }}</p>
              </td>
              <td class="p-4">
                <p class="text-muted-foreground">{{ product.category || '—' }}</p>
              </td>
              <td class="p-4">
                <p class="text-foreground font-semibold">{{ product.price_label || formatPrice(product.price) }}</p>
              </td>
              <td class="p-4">
                <span
                  :class="[
                    'px-2 py-1 rounded text-xs font-semibold',
                    product.is_featured ? 'bg-yellow-500/20 text-yellow-400' : 'bg-gray-500/20 text-muted-foreground'
                  ]"
                >
                  {{ product.is_featured ? 'Featured' : 'No' }}
                </span>
              </td>
              <td class="p-4">
                <span
                  :class="[
                    'px-2 py-1 rounded text-xs font-semibold',
                    product.is_published ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-muted-foreground'
                  ]"
                >
                  {{ product.is_published ? 'Published' : 'Draft' }}
                </span>
              </td>
              <td class="p-4">
                <p class="text-muted-foreground">{{ product.order ?? '—' }}</p>
              </td>
              <td class="p-4">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="openEditModal(product)"
                    class="text-primary hover:text-primary/80 text-sm font-semibold transition"
                  >
                    Edit
                  </button>
                  <button
                    @click="confirmDelete(product)"
                    class="text-red-400 hover:text-red-300 text-sm font-semibold transition"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="products.length === 0" class="py-12 text-center text-muted-foreground">
          No products yet. Create your first one!
        </div>
      </div>

      <!-- Create / Edit Modal -->
      <div
        v-if="showFormModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4"
        @mousedown.self="showFormModal = false"
      >
        <div class="bg-card border border-border rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-foreground">
              {{ editingProduct ? 'Edit Product' : 'Create Product' }}
            </h2>
            <button @click="showFormModal = false" class="text-muted-foreground hover:text-foreground">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <form @submit.prevent="submitForm" class="space-y-4">
            <!-- Name -->
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Name *</label>
              <input
                v-model="form.name"
                type="text"
                required
                class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"
                placeholder="Product name"
              />
            </div>

            <!-- Category & Price row -->
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Category</label>
                <input
                  v-model="form.category"
                  type="text"
                  class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"
                  placeholder="e.g. Software, Hardware"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Price</label>
                <input
                  v-model.number="form.price"
                  type="number"
                  step="0.01"
                  min="0"
                  class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"
                  placeholder="0.00"
                />
              </div>
            </div>

            <!-- Price Label & Order row -->
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Price Label</label>
                <input
                  v-model="form.price_label"
                  type="text"
                  class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"
                  placeholder="e.g. From $999/mo"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Order</label>
                <input
                  v-model.number="form.order"
                  type="number"
                  min="0"
                  class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"
                  placeholder="0"
                />
              </div>
            </div>

            <!-- Short Description -->
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Short Description</label>
              <input
                v-model="form.short_description"
                type="text"
                class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"
                placeholder="Brief product summary"
              />
            </div>

            <!-- Description -->
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Description</label>
              <textarea
                v-model="form.description"
                rows="4"
                class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"
                placeholder="Full product description"
              ></textarea>
            </div>

            <!-- Features (dynamic list) -->
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Features</label>
              <div class="space-y-2">
                <div
                  v-for="(feature, index) in form.features"
                  :key="index"
                  class="flex items-center gap-2"
                >
                  <input
                    v-model="form.features[index]"
                    type="text"
                    class="flex-1 px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary"
                    placeholder="Feature description"
                  />
                  <button
                    type="button"
                    @click="removeFeature(index)"
                    class="text-red-400 hover:text-red-300 p-1 transition"
                    title="Remove feature"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
              <button
                type="button"
                @click="addFeature"
                class="mt-2 text-sm text-primary hover:text-primary/80 transition"
              >
                + Add Feature
              </button>
            </div>

            <!-- Toggles row -->
            <div class="flex items-center gap-6">
              <label class="flex items-center gap-2 cursor-pointer">
                <input
                  v-model="form.is_featured"
                  type="checkbox"
                  class="rounded border-border"
                />
                <span class="text-sm text-foreground">Featured</span>
              </label>
              <label class="flex items-center gap-2 cursor-pointer">
                <input
                  v-model="form.is_published"
                  type="checkbox"
                  class="rounded border-border"
                />
                <span class="text-sm text-foreground">Published</span>
              </label>
            </div>

            <!-- Form Error -->
            <p v-if="formError" class="text-red-400 text-sm">{{ formError }}</p>

            <!-- Actions -->
            <div class="flex gap-3 pt-4">
              <button
                type="submit"
                :disabled="submitting"
                class="flex-1 px-4 py-2 bg-gradient-to-r from-primary to-accent text-foreground rounded-lg font-semibold text-sm transition hover:shadow-lg disabled:opacity-50"
              >
                {{ submitting ? 'Saving...' : (editingProduct ? 'Update Product' : 'Create Product') }}
              </button>
              <button
                type="button"
                @click="showFormModal = false"
                class="px-4 py-2 bg-background border border-border text-foreground rounded-lg text-sm transition hover:border-primary"
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div
        v-if="showDeleteModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4"
        @mousedown.self="showDeleteModal = false"
      >
        <div class="bg-card border border-border rounded-xl w-full max-w-md p-6">
          <h2 class="text-xl font-bold text-foreground mb-2">Delete Product</h2>
          <p class="text-muted-foreground mb-6">
            Are you sure you want to delete <span class="text-foreground font-semibold">{{ deletingProduct?.name }}</span>? This action cannot be undone.
          </p>
          <div class="flex gap-3">
            <button
              @click="deleteProduct"
              :disabled="deleting"
              class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold text-sm transition disabled:opacity-50"
            >
              {{ deleting ? 'Deleting...' : 'Delete' }}
            </button>
            <button
              @click="showDeleteModal = false"
              class="px-4 py-2 bg-background border border-border text-foreground rounded-lg text-sm transition hover:border-primary"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';

interface Product {
  id: number;
  name: string;
  slug?: string;
  short_description?: string;
  description?: string;
  category?: string;
  price?: number;
  price_label?: string;
  features?: string[];
  specifications?: Record<string, any>;
  is_featured: boolean;
  is_published: boolean;
  order?: number;
  created_at?: string;
  updated_at?: string;
}

interface ProductForm {
  name: string;
  category: string;
  price: number | null;
  price_label: string;
  short_description: string;
  description: string;
  features: string[];
  is_featured: boolean;
  is_published: boolean;
  order: number | null;
}

const { get, post, put, delete: destroy } = useApi();
const toast = useToast();

const products = ref<Product[]>([]);
const loading = ref(false);
const fetchError = ref('');

// Form modal state
const showFormModal = ref(false);
const editingProduct = ref<Product | null>(null);
const submitting = ref(false);
const formError = ref('');

const defaultForm = (): ProductForm => ({
  name: '',
  category: '',
  price: null,
  price_label: '',
  short_description: '',
  description: '',
  features: [],
  is_featured: false,
  is_published: true,
  order: null,
});

const form = ref<ProductForm>(defaultForm());

// Delete modal state
const showDeleteModal = ref(false);
const deletingProduct = ref<Product | null>(null);
const deleting = ref(false);

// --- Fetch ---
async function fetchProducts() {
  loading.value = true;
  fetchError.value = '';
  try {
    const res = await get('/admin/cms/products');
    products.value = res.data ?? res ?? [];
  } catch (err: any) {
    fetchError.value = err?.response?.data?.message || 'Failed to load products.';
    toast.error('Error', fetchError.value);
  } finally {
    loading.value = false;
  }
}

// --- Create ---
function openCreateModal() {
  editingProduct.value = null;
  form.value = defaultForm();
  formError.value = '';
  showFormModal.value = true;
}

// --- Edit ---
function openEditModal(product: Product) {
  editingProduct.value = product;
  form.value = {
    name: product.name,
    category: product.category || '',
    price: product.price ?? null,
    price_label: product.price_label || '',
    short_description: product.short_description || '',
    description: product.description || '',
    features: Array.isArray(product.features) ? [...product.features] : [],
    is_featured: !!product.is_featured,
    is_published: !!product.is_published,
    order: product.order ?? null,
  };
  formError.value = '';
  showFormModal.value = true;
}

// --- Submit (create or update) ---
async function submitForm() {
  submitting.value = true;
  formError.value = '';

  const payload = {
    ...form.value,
    features: form.value.features.filter((f) => f.trim() !== ''),
  };

  try {
    if (editingProduct.value) {
      await put(`/admin/cms/products/${editingProduct.value.id}`, payload);
      toast.success('Product updated', `"${payload.name}" has been updated.`);
    } else {
      await post('/admin/cms/products', payload);
      toast.success('Product created', `"${payload.name}" has been created.`);
    }
    showFormModal.value = false;
    await fetchProducts();
  } catch (err: any) {
    const msg = err?.response?.data?.message || 'Something went wrong. Please try again.';
    formError.value = msg;
    toast.error('Error', msg);
  } finally {
    submitting.value = false;
  }
}

// --- Features helpers ---
function addFeature() {
  form.value.features.push('');
}

function removeFeature(index: number) {
  form.value.features.splice(index, 1);
}

// --- Delete ---
function confirmDelete(product: Product) {
  deletingProduct.value = product;
  showDeleteModal.value = true;
}

async function deleteProduct() {
  if (!deletingProduct.value) return;
  deleting.value = true;
  try {
    await destroy(`/admin/cms/products/${deletingProduct.value.id}`);
    toast.success('Deleted', `"${deletingProduct.value.name}" has been deleted.`);
    showDeleteModal.value = false;
    deletingProduct.value = null;
    await fetchProducts();
  } catch (err: any) {
    const msg = err?.response?.data?.message || 'Failed to delete product.';
    toast.error('Error', msg);
  } finally {
    deleting.value = false;
  }
}

// --- Helpers ---
function formatPrice(price?: number) {
  if (price == null) return '—';
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(price);
}

onMounted(fetchProducts);
</script>
