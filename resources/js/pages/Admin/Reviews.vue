<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-3xl font-display font-bold text-foreground mb-2">Manage Reviews</h1>
        <p class="text-muted-foreground">Review and moderate customer feedback</p>
      </div>

      <!-- Stats Cards -->
      <div v-if="stats" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-card border border-border rounded-lg p-5">
          <p class="text-sm text-muted-foreground mb-1">Total Reviews</p>
          <p class="text-2xl font-bold text-foreground">{{ stats.total }}</p>
        </div>
        <div class="bg-card border border-border rounded-lg p-5">
          <p class="text-sm text-muted-foreground mb-1">Pending</p>
          <p class="text-2xl font-bold text-amber-400">{{ stats.pending }}</p>
        </div>
        <div class="bg-card border border-border rounded-lg p-5">
          <p class="text-sm text-muted-foreground mb-1">Approved</p>
          <p class="text-2xl font-bold text-green-400">{{ stats.approved }}</p>
        </div>
        <div class="bg-card border border-border rounded-lg p-5">
          <p class="text-sm text-muted-foreground mb-1">Rejected</p>
          <p class="text-2xl font-bold text-red-400">{{ stats.rejected }}</p>
        </div>
        <div class="bg-card border border-border rounded-lg p-5">
          <p class="text-sm text-muted-foreground mb-1">Avg Rating</p>
          <div class="flex items-center gap-2">
            <p class="text-2xl font-bold text-amber-400">{{ Number(stats.avg_rating).toFixed(1) }}</p>
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Filter Bar -->
      <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input
            v-model="filters.search"
            type="text"
            placeholder="Search reviews..."
            class="w-full bg-card border border-border rounded-lg pl-10 pr-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition"
            @input="debouncedFetch"
          />
        </div>
        <select
          v-model="filters.status"
          class="bg-card border border-border rounded-lg px-4 py-2.5 text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition"
          @change="fetchReviews"
        >
          <option value="">All Statuses</option>
          <option value="pending">Pending</option>
          <option value="approved">Approved</option>
          <option value="rejected">Rejected</option>
        </select>
        <select
          v-model="filters.rating"
          class="bg-card border border-border rounded-lg px-4 py-2.5 text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition"
          @change="fetchReviews"
        >
          <option value="">All Ratings</option>
          <option value="5">5 Stars</option>
          <option value="4">4 Stars</option>
          <option value="3">3 Stars</option>
          <option value="2">2 Stars</option>
          <option value="1">1 Star</option>
        </select>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-16">
        <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <span class="ml-3 text-muted-foreground">Loading reviews...</span>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-red-500/10 border border-red-500/30 rounded-lg p-6 text-center">
        <p class="text-red-400 font-semibold mb-2">Failed to load reviews</p>
        <p class="text-muted-foreground text-sm mb-4">{{ error }}</p>
        <button
          class="bg-primary hover:bg-primary/80 text-primary-foreground font-semibold py-2 px-6 rounded-lg transition text-sm"
          @click="fetchReviews"
        >
          Retry
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="reviews.length === 0" class="text-center py-16">
        <svg class="mx-auto w-16 h-16 text-muted-foreground/40 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <p class="text-muted-foreground font-medium">No reviews found</p>
        <p class="text-muted-foreground/60 text-sm mt-1">Try adjusting your filters</p>
      </div>

      <!-- Reviews List -->
      <div v-else class="space-y-4">
        <div
          v-for="review in reviews"
          :key="review.id"
          class="bg-card border border-border rounded-lg p-6 hover:border-primary/50 transition"
        >
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-foreground font-bold shrink-0">
                {{ review.user?.name?.charAt(0) ?? '?' }}
              </div>
              <div>
                <h3 class="text-foreground font-semibold">{{ review.user?.name ?? 'Unknown User' }}</h3>
                <p class="text-sm text-muted-foreground">{{ formatDate(review.created_at) }}</p>
                <div class="flex items-center gap-1 mt-1">
                  <svg
                    v-for="i in 5"
                    :key="i"
                    :class="['w-4 h-4', i <= review.rating ? 'text-amber-400' : 'text-gray-700']"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                  </svg>
                </div>
              </div>
            </div>
            <span :class="[
              'px-2 py-1 rounded text-xs font-semibold capitalize',
              review.status === 'approved' ? 'bg-green-500/20 text-green-400' :
              review.status === 'pending' ? 'bg-amber-500/20 text-amber-400' :
              'bg-red-500/20 text-red-400'
            ]">
              {{ review.status }}
            </span>
          </div>

          <div class="mb-4">
            <p class="text-sm text-muted-foreground mb-1">
              Review for:
              <span class="text-foreground">{{ review.reviewable?.name ?? review.reviewable?.title ?? 'Unknown Item' }}</span>
              <span class="text-muted-foreground/60 ml-1">({{ reviewableLabel(review.reviewable_type) }})</span>
            </p>
            <p class="text-muted-foreground">{{ review.content }}</p>
          </div>

          <!-- Admin Notes (if any) -->
          <div v-if="review.admin_notes" class="mb-4 bg-muted/30 border border-border rounded-md p-3">
            <p class="text-xs text-muted-foreground font-semibold mb-1">Admin Notes</p>
            <p class="text-sm text-muted-foreground">{{ review.admin_notes }}</p>
          </div>

          <!-- Reject reason input -->
          <div v-if="rejectingId === review.id" class="mb-4 flex gap-2">
            <input
              v-model="rejectReason"
              type="text"
              placeholder="Reason for rejection..."
              class="flex-1 bg-card border border-border rounded-lg px-4 py-2 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition text-sm"
              @keyup.enter="confirmReject(review.id)"
              @keyup.escape="cancelReject"
            />
            <button
              class="bg-red-500/20 hover:bg-red-500/30 text-red-400 font-semibold py-2 px-4 rounded-lg transition text-sm"
              :disabled="actionLoading === review.id"
              @click="confirmReject(review.id)"
            >
              Confirm
            </button>
            <button
              class="border border-border hover:border-muted-foreground text-muted-foreground font-semibold py-2 px-3 rounded-lg transition text-sm"
              @click="cancelReject"
            >
              Cancel
            </button>
          </div>

          <!-- Delete confirmation -->
          <div v-if="deletingId === review.id" class="mb-4 bg-red-500/5 border border-red-500/20 rounded-lg p-3 flex items-center justify-between">
            <p class="text-sm text-red-400">Are you sure you want to delete this review?</p>
            <div class="flex gap-2">
              <button
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1.5 px-4 rounded-lg transition text-sm"
                :disabled="actionLoading === review.id"
                @click="confirmDelete(review.id)"
              >
                Delete
              </button>
              <button
                class="border border-border hover:border-muted-foreground text-muted-foreground font-semibold py-1.5 px-3 rounded-lg transition text-sm"
                @click="deletingId = null"
              >
                Cancel
              </button>
            </div>
          </div>

          <!-- Action Buttons -->
          <div v-if="rejectingId !== review.id && deletingId !== review.id" class="flex gap-2">
            <button
              v-if="review.status !== 'approved'"
              class="bg-green-500/20 hover:bg-green-500/30 text-green-400 font-semibold py-2 px-4 rounded-lg transition text-sm disabled:opacity-50"
              :disabled="actionLoading === review.id"
              @click="approveReview(review.id)"
            >
              <span v-if="actionLoading === review.id && actionType === 'approve'" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
                Approving...
              </span>
              <span v-else>Approve</span>
            </button>
            <button
              v-if="review.status !== 'rejected'"
              class="bg-red-500/20 hover:bg-red-500/30 text-red-400 font-semibold py-2 px-4 rounded-lg transition text-sm disabled:opacity-50"
              :disabled="actionLoading === review.id"
              @click="startReject(review.id)"
            >
              Reject
            </button>
            <button
              class="border border-border hover:border-muted-foreground text-muted-foreground font-semibold py-2 px-4 rounded-lg transition text-sm disabled:opacity-50"
              :disabled="actionLoading === review.id"
              @click="startDelete(review.id)"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.lastPage > 1" class="flex items-center justify-center gap-2 pt-4">
        <button
          class="px-3 py-2 rounded-lg border border-border text-muted-foreground hover:text-foreground hover:border-primary/50 transition text-sm disabled:opacity-40 disabled:cursor-not-allowed"
          :disabled="pagination.currentPage <= 1"
          @click="goToPage(pagination.currentPage - 1)"
        >
          Previous
        </button>
        <template v-for="page in paginationPages" :key="page">
          <span v-if="page === '...'" class="px-2 text-muted-foreground">...</span>
          <button
            v-else
            :class="[
              'px-3 py-2 rounded-lg border text-sm transition',
              page === pagination.currentPage
                ? 'border-primary bg-primary/10 text-primary font-semibold'
                : 'border-border text-muted-foreground hover:text-foreground hover:border-primary/50'
            ]"
            @click="goToPage(page as number)"
          >
            {{ page }}
          </button>
        </template>
        <button
          class="px-3 py-2 rounded-lg border border-border text-muted-foreground hover:text-foreground hover:border-primary/50 transition text-sm disabled:opacity-40 disabled:cursor-not-allowed"
          :disabled="pagination.currentPage >= pagination.lastPage"
          @click="goToPage(pagination.currentPage + 1)"
        >
          Next
        </button>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';

const { get, post, put, delete: apiDelete } = useApi();
const toast = useToast();

// --- Types ---
interface ReviewUser {
  id: number;
  name: string;
  email: string;
  avatar?: string;
}

interface Review {
  id: number;
  user_id: number;
  reviewable_type: string;
  reviewable_id: number;
  rating: number;
  content: string;
  status: 'pending' | 'approved' | 'rejected';
  admin_notes: string | null;
  sentiment_data: any;
  reviewed_by: number | null;
  reviewed_at: string | null;
  created_at: string;
  user?: ReviewUser;
  reviewable?: { id: number; name?: string; title?: string };
}

interface Stats {
  total: number;
  pending: number;
  approved: number;
  rejected: number;
  avg_rating: number;
  five_star: number;
  four_star: number;
  three_star_or_less: number;
}

// --- State ---
const reviews = ref<Review[]>([]);
const stats = ref<Stats | null>(null);
const loading = ref(false);
const error = ref<string | null>(null);
const actionLoading = ref<number | null>(null);
const actionType = ref<string | null>(null);
const rejectingId = ref<number | null>(null);
const rejectReason = ref('');
const deletingId = ref<number | null>(null);

const filters = reactive({
  search: '',
  status: '',
  rating: '',
});

const pagination = reactive({
  currentPage: 1,
  lastPage: 1,
  total: 0,
});

// --- Debounce ---
let searchTimeout: ReturnType<typeof setTimeout> | null = null;
function debouncedFetch() {
  if (searchTimeout) clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    pagination.currentPage = 1;
    fetchReviews();
  }, 400);
}

// --- Pagination helpers ---
const paginationPages = computed(() => {
  const pages: (number | string)[] = [];
  const total = pagination.lastPage;
  const current = pagination.currentPage;

  if (total <= 7) {
    for (let i = 1; i <= total; i++) pages.push(i);
  } else {
    pages.push(1);
    if (current > 3) pages.push('...');
    for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) {
      pages.push(i);
    }
    if (current < total - 2) pages.push('...');
    pages.push(total);
  }
  return pages;
});

function goToPage(page: number) {
  if (page < 1 || page > pagination.lastPage) return;
  pagination.currentPage = page;
  fetchReviews();
}

// --- Fetch ---
async function fetchStats() {
  try {
    const data = await get<Stats>('/admin/reviews/stats');
    stats.value = data;
  } catch {
    // stats failure is non-critical
  }
}

async function fetchReviews() {
  loading.value = true;
  error.value = null;
  try {
    const params: Record<string, string | number> = { page: pagination.currentPage };
    if (filters.status) params.status = filters.status;
    if (filters.rating) params.rating = filters.rating;
    if (filters.search) params.search = filters.search;

    const data = await get<any>('/admin/reviews', { params });
    reviews.value = data.data ?? [];
    pagination.currentPage = data.current_page ?? data.meta?.current_page ?? 1;
    pagination.lastPage = data.last_page ?? data.meta?.last_page ?? 1;
    pagination.total = data.total ?? data.meta?.total ?? 0;
  } catch (err: any) {
    error.value = err?.response?.data?.message || err?.message || 'Something went wrong.';
    toast.error('Load failed', error.value!);
  } finally {
    loading.value = false;
  }
}

// --- Actions ---
async function approveReview(id: number) {
  actionLoading.value = id;
  actionType.value = 'approve';
  try {
    await post(`/admin/reviews/${id}/approve`);
    toast.success('Review approved', 'The review has been approved successfully.');
    await Promise.all([fetchReviews(), fetchStats()]);
  } catch (err: any) {
    toast.error('Approve failed', err?.response?.data?.message || 'Could not approve review.');
  } finally {
    actionLoading.value = null;
    actionType.value = null;
  }
}

function startReject(id: number) {
  rejectingId.value = id;
  rejectReason.value = '';
}

function cancelReject() {
  rejectingId.value = null;
  rejectReason.value = '';
}

async function confirmReject(id: number) {
  if (!rejectReason.value.trim()) {
    toast.warning('Reason required', 'Please provide a reason for rejection.');
    return;
  }
  actionLoading.value = id;
  actionType.value = 'reject';
  try {
    await post(`/admin/reviews/${id}/reject`, { reason: rejectReason.value.trim() });
    toast.success('Review rejected', 'The review has been rejected.');
    rejectingId.value = null;
    rejectReason.value = '';
    await Promise.all([fetchReviews(), fetchStats()]);
  } catch (err: any) {
    toast.error('Reject failed', err?.response?.data?.message || 'Could not reject review.');
  } finally {
    actionLoading.value = null;
    actionType.value = null;
  }
}

function startDelete(id: number) {
  deletingId.value = id;
}

async function confirmDelete(id: number) {
  actionLoading.value = id;
  actionType.value = 'delete';
  try {
    await apiDelete(`/admin/reviews/${id}`);
    toast.success('Review deleted', 'The review has been removed.');
    deletingId.value = null;
    await Promise.all([fetchReviews(), fetchStats()]);
  } catch (err: any) {
    toast.error('Delete failed', err?.response?.data?.message || 'Could not delete review.');
  } finally {
    actionLoading.value = null;
    actionType.value = null;
  }
}

// --- Helpers ---
function formatDate(dateStr: string): string {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function reviewableLabel(type: string): string {
  if (!type) return '';
  // e.g. "App\\Models\\Service" -> "Service"
  const parts = type.split('\\');
  return parts[parts.length - 1] || type;
}

// --- Init ---
onMounted(() => {
  fetchReviews();
  fetchStats();
});
</script>
