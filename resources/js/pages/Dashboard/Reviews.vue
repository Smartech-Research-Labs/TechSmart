<template>
  <DashboardLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-xl font-display font-bold text-foreground mb-1">My Reviews</h1>
        <p class="text-muted-foreground">Reviews and feedback you've submitted</p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="space-y-4">
        <div v-for="i in 3" :key="i" class="bg-card border border-border rounded-lg p-6 animate-pulse">
          <div class="flex items-start justify-between mb-4">
            <div class="space-y-2 flex-1">
              <div class="h-5 w-1/2 bg-muted rounded" />
              <div class="h-3 w-1/4 bg-muted rounded" />
            </div>
            <div class="flex gap-1">
              <div v-for="j in 5" :key="j" class="w-5 h-5 bg-muted rounded" />
            </div>
          </div>
          <div class="h-4 w-full bg-muted rounded mb-2" />
          <div class="h-4 w-3/4 bg-muted rounded" />
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-card border border-border rounded-lg p-12 text-center">
        <div class="w-16 h-16 bg-destructive/10 rounded-full flex items-center justify-center mx-auto mb-4">
          <IconAlertTriangle class="size-8 text-destructive" />
        </div>
        <h3 class="text-lg font-semibold text-foreground mb-2">Failed to load reviews</h3>
        <p class="text-muted-foreground mb-4">{{ error }}</p>
        <button
          @click="fetchReviews"
          class="inline-block bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition"
        >
          Retry
        </button>
      </div>

      <!-- Reviews List -->
      <div v-else-if="reviews.length > 0" class="space-y-4">
        <div class="mb-2">
          <input v-model="searchQuery" type="text" placeholder="Search by item name, review content..." class="w-full sm:w-80 px-4 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
        </div>
        <div v-if="searchQuery && filteredReviews.length === 0" class="py-8 text-center text-muted-foreground">No reviews match your search.</div>
        <div
          v-for="review in filteredReviews"
          :key="review.id"
          class="bg-card border border-border rounded-lg p-6 hover:border-primary transition"
        >
          <div class="flex items-start justify-between mb-4">
            <div>
              <h3 class="text-lg font-bold text-foreground mb-1">
                {{ review.reviewable?.name || review.reviewable?.title || 'Item' }}
              </h3>
              <div class="flex items-center gap-3">
                <p class="text-sm text-muted-foreground">{{ formatDate(review.created_at) }}</p>
                <span
                  v-if="review.status"
                  :class="[
                    'px-2 py-0.5 rounded-full text-[10px] font-semibold',
                    statusBadgeClass(review.status),
                  ]"
                >
                  {{ review.status.toUpperCase() }}
                </span>
              </div>
            </div>
            <div class="flex items-center gap-1">
              <svg
                v-for="i in 5"
                :key="i"
                :class="[
                  'w-5 h-5',
                  i <= review.rating ? 'text-amber-400' : 'text-muted-foreground/30',
                ]"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
              </svg>
            </div>
          </div>

          <p class="text-muted-foreground mb-4">{{ review.comment || review.content }}</p>

          <!-- Related item type -->
          <div v-if="review.reviewable" class="text-xs text-muted-foreground">
            {{ getTypeLabel(review.reviewable_type) }}
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="pagination.lastPage > 1" class="flex items-center justify-center gap-2 pt-4">
          <button
            @click="goToPage(pagination.currentPage - 1)"
            :disabled="pagination.currentPage <= 1"
            class="px-3 py-1.5 text-sm border border-border rounded-lg hover:bg-muted transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Previous
          </button>
          <span class="text-sm text-muted-foreground">
            Page {{ pagination.currentPage }} of {{ pagination.lastPage }}
          </span>
          <button
            @click="goToPage(pagination.currentPage + 1)"
            :disabled="pagination.currentPage >= pagination.lastPage"
            class="px-3 py-1.5 text-sm border border-border rounded-lg hover:bg-muted transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Next
          </button>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="bg-card border border-border rounded-lg p-12 text-center">
        <div class="w-20 h-20 bg-muted rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-foreground mb-2">No Reviews Yet</h3>
        <p class="text-muted-foreground mb-6">Share your experience with our services</p>
        <router-link
          to="/services"
          class="inline-block bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition"
        >
          Browse Services
        </router-link>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { IconAlertTriangle } from '@tabler/icons-vue';
import { ref, onMounted, computed } from 'vue';
import { useApi } from '@/composables/useApi';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const { get } = useApi();

const loading = ref(true);
const error = ref<string | null>(null);
const reviews = ref<any[]>([]);
const searchQuery = ref('');

const filteredReviews = computed(() => {
  if (!searchQuery.value) return reviews.value;
  const q = searchQuery.value.toLowerCase();
  return reviews.value.filter((r: any) =>
    (r.reviewable?.name || '').toLowerCase().includes(q) ||
    (r.reviewable?.title || '').toLowerCase().includes(q) ||
    (r.comment || r.content || '').toLowerCase().includes(q) ||
    (r.status || '').toLowerCase().includes(q)
  );
});

const pagination = ref({
  currentPage: 1,
  lastPage: 1,
  total: 0,
});

function statusBadgeClass(status: string): string {
  switch (status?.toLowerCase()) {
    case 'approved': return 'bg-green-500/20 text-green-400';
    case 'pending': return 'bg-amber-500/20 text-amber-400';
    case 'rejected': return 'bg-red-500/20 text-red-400';
    default: return 'bg-muted text-muted-foreground';
  }
}

function formatDate(dateStr: string): string {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  });
}

function getTypeLabel(type: string): string {
  if (!type) return '';
  if (type.includes('Product')) return 'Product Review';
  if (type.includes('Service')) return 'Service Review';
  if (type.includes('Bundle')) return 'Bundle Review';
  return 'Review';
}

async function fetchReviews(page: number = 1) {
  loading.value = true;
  error.value = null;
  try {
    const data = await get(`/user/reviews?page=${page}`);
    // Handle Laravel paginated response
    reviews.value = data.data ?? data ?? [];
    pagination.value = {
      currentPage: data.current_page ?? 1,
      lastPage: data.last_page ?? 1,
      total: data.total ?? reviews.value.length,
    };
  } catch (err: any) {
    error.value = err.response?.data?.message || err.message || 'Failed to load reviews';
    reviews.value = [];
  } finally {
    loading.value = false;
  }
}

function goToPage(page: number) {
  if (page >= 1 && page <= pagination.value.lastPage) {
    fetchReviews(page);
  }
}

onMounted(() => fetchReviews());
</script>
