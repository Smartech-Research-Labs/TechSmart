<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground mb-1">Activity Log</h1>
          <p class="text-muted-foreground">Recent system activity across enquiries, reviews, and user registrations</p>
        </div>
        <button
          @click="fetchActivity"
          :disabled="loading"
          class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-50 transition text-sm font-medium"
        >
          <svg :class="['w-4 h-4', { 'animate-spin': loading }]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
          Refresh
        </button>
      </div>

      <!-- Summary Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-card border border-border rounded-xl p-4 flex items-center gap-4">
          <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
          </div>
          <div>
            <p class="text-lg font-bold text-foreground">{{ typeCounts.enquiry }}</p>
            <p class="text-xs text-muted-foreground">Enquiries</p>
          </div>
        </div>
        <div class="bg-card border border-border rounded-xl p-4 flex items-center gap-4">
          <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
          </div>
          <div>
            <p class="text-lg font-bold text-foreground">{{ typeCounts.review }}</p>
            <p class="text-xs text-muted-foreground">Reviews</p>
          </div>
        </div>
        <div class="bg-card border border-border rounded-xl p-4 flex items-center gap-4">
          <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
          <div>
            <p class="text-lg font-bold text-foreground">{{ typeCounts.user }}</p>
            <p class="text-xs text-muted-foreground">Registrations</p>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1 relative">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input
            v-model="search"
            type="text"
            placeholder="Search activity..."
            class="w-full bg-card border border-border rounded-lg pl-10 pr-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none transition"
          />
        </div>
        <select v-model="typeFilter" class="bg-card border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition">
          <option value="">All Types</option>
          <option value="enquiry">Enquiries</option>
          <option value="review">Reviews</option>
          <option value="user">User Registrations</option>
        </select>
        <div class="flex gap-2">
          <input
            v-model="dateFrom"
            type="date"
            class="bg-card border border-border rounded-lg px-3 py-2.5 text-foreground focus:border-primary focus:outline-none transition text-sm"
            placeholder="From"
          />
          <input
            v-model="dateTo"
            type="date"
            class="bg-card border border-border rounded-lg px-3 py-2.5 text-foreground focus:border-primary focus:outline-none transition text-sm"
            placeholder="To"
          />
        </div>
        <button
          v-if="hasActiveFilters"
          @click="clearFilters"
          class="px-4 py-2.5 bg-muted border border-border rounded-lg text-muted-foreground hover:text-foreground transition text-sm"
        >
          Clear Filters
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="space-y-4">
        <div v-for="i in 6" :key="i" class="bg-card border border-border rounded-xl p-5 animate-pulse">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-muted rounded-full"></div>
            <div class="flex-1 space-y-2">
              <div class="h-4 bg-muted rounded w-3/4"></div>
              <div class="h-3 bg-muted rounded w-1/2"></div>
            </div>
            <div class="h-3 bg-muted rounded w-20"></div>
          </div>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-card border border-red-500/30 rounded-xl p-8 text-center">
        <svg class="w-12 h-12 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
        </svg>
        <h3 class="text-lg font-semibold text-foreground mb-2">Failed to load activity</h3>
        <p class="text-muted-foreground mb-4">{{ error }}</p>
        <button
          @click="fetchActivity"
          class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition text-sm"
        >
          Try Again
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="filteredActivity.length === 0 && activities.length === 0" class="bg-card border border-border rounded-xl p-12 text-center">
        <svg class="w-16 h-16 text-muted-foreground/50 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <h3 class="text-lg font-semibold text-foreground mb-2">No activity yet</h3>
        <p class="text-muted-foreground">System activity will appear here as enquiries, reviews, and user registrations come in.</p>
      </div>

      <!-- No Filter Results -->
      <div v-else-if="filteredActivity.length === 0" class="bg-card border border-border rounded-xl p-8 text-center">
        <svg class="w-12 h-12 text-muted-foreground/50 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <h3 class="text-lg font-semibold text-foreground mb-2">No matching activity</h3>
        <p class="text-muted-foreground mb-4">Try adjusting your search or filters.</p>
        <button @click="clearFilters" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition text-sm">
          Clear Filters
        </button>
      </div>

      <!-- Timeline Activity List -->
      <div v-else class="relative">
        <!-- Timeline line -->
        <div class="absolute left-5 top-0 bottom-0 w-px bg-border hidden sm:block"></div>

        <div class="space-y-4">
          <div
            v-for="item in paginatedActivity"
            :key="item.id"
            class="relative bg-card border border-border rounded-xl p-5 sm:ml-12 hover:border-primary/30 transition group"
          >
            <!-- Timeline dot -->
            <div
              :class="[
                'absolute -left-[2.15rem] top-6 w-3 h-3 rounded-full border-2 border-background hidden sm:block',
                typeColor(item.type).dot
              ]"
            ></div>

            <div class="flex items-start gap-4">
              <!-- Type icon -->
              <div :class="['w-10 h-10 rounded-lg flex items-center justify-center shrink-0', typeColor(item.type).bg]">
                <svg v-if="item.type === 'enquiry'" :class="['w-5 h-5', typeColor(item.type).text]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <svg v-else-if="item.type === 'review'" :class="['w-5 h-5', typeColor(item.type).text]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                <svg v-else :class="['w-5 h-5', typeColor(item.type).text]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>

              <!-- Content -->
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                  <span class="text-foreground font-medium text-sm">{{ item.message }}</span>
                  <span :class="['px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider shrink-0', typeColor(item.type).badge]">
                    {{ item.type }}
                  </span>
                </div>
                <p v-if="item.detail" class="text-muted-foreground text-sm truncate mb-1">{{ item.detail }}</p>
                <div class="flex items-center gap-3 text-xs text-muted-foreground">
                  <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ item.user }}
                  </span>
                  <span v-if="item.email" class="hidden sm:inline">{{ item.email }}</span>
                </div>
              </div>

              <!-- Timestamp -->
              <div class="text-right shrink-0">
                <p class="text-xs text-muted-foreground">{{ item.time }}</p>
                <p class="text-[10px] text-muted-foreground/60 mt-0.5">{{ formatDate(item.created_at) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="!loading && !error && filteredActivity.length > 0" class="flex items-center justify-between">
        <p class="text-sm text-muted-foreground">
          Showing {{ paginationStart }}â€“{{ paginationEnd }} of {{ filteredActivity.length }} entries
        </p>
        <div class="flex gap-2">
          <button
            @click="currentPage = Math.max(1, currentPage - 1)"
            :disabled="currentPage <= 1"
            class="px-4 py-2 bg-card border border-border rounded-lg text-muted-foreground hover:bg-muted disabled:opacity-40 transition text-sm"
          >
            Previous
          </button>
          <span class="px-3 py-2 text-sm text-muted-foreground">{{ currentPage }} / {{ totalPages }}</span>
          <button
            @click="currentPage = Math.min(totalPages, currentPage + 1)"
            :disabled="currentPage >= totalPages"
            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 disabled:opacity-40 transition text-sm"
          >
            Next
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import AdminLayout from '@/layouts/AdminLayout.vue';

interface ActivityItem {
  id: string;
  type: 'enquiry' | 'review' | 'user';
  message: string;
  detail: string;
  user: string;
  email: string | null;
  time: string;
  created_at: string;
}

const { get } = useApi();
const toast = useToast();

const activities = ref<ActivityItem[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);

const search = ref('');
const typeFilter = ref('');
const dateFrom = ref('');
const dateTo = ref('');
const currentPage = ref(1);
const perPage = 15;

const hasActiveFilters = computed(() => {
  return search.value || typeFilter.value || dateFrom.value || dateTo.value;
});

const typeCounts = computed(() => {
  const counts = { enquiry: 0, review: 0, user: 0 };
  activities.value.forEach(a => {
    if (a.type in counts) counts[a.type as keyof typeof counts]++;
  });
  return counts;
});

const filteredActivity = computed(() => {
  return activities.value.filter(item => {
    // Text search
    if (search.value) {
      const q = search.value.toLowerCase();
      const matchesSearch =
        item.message.toLowerCase().includes(q) ||
        item.user.toLowerCase().includes(q) ||
        (item.detail && item.detail.toLowerCase().includes(q)) ||
        (item.email && item.email.toLowerCase().includes(q));
      if (!matchesSearch) return false;
    }

    // Type filter
    if (typeFilter.value && item.type !== typeFilter.value) return false;

    // Date range filter
    if (dateFrom.value || dateTo.value) {
      const itemDate = new Date(item.created_at);
      if (dateFrom.value) {
        const from = new Date(dateFrom.value);
        from.setHours(0, 0, 0, 0);
        if (itemDate < from) return false;
      }
      if (dateTo.value) {
        const to = new Date(dateTo.value);
        to.setHours(23, 59, 59, 999);
        if (itemDate > to) return false;
      }
    }

    return true;
  });
});

const totalPages = computed(() => Math.max(1, Math.ceil(filteredActivity.value.length / perPage)));
const paginationStart = computed(() => (currentPage.value - 1) * perPage + 1);
const paginationEnd = computed(() => Math.min(currentPage.value * perPage, filteredActivity.value.length));

const paginatedActivity = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return filteredActivity.value.slice(start, start + perPage);
});

// Reset to page 1 when filters change
watch([search, typeFilter, dateFrom, dateTo], () => {
  currentPage.value = 1;
});

function typeColor(type: string) {
  const map: Record<string, { bg: string; text: string; badge: string; dot: string }> = {
    enquiry: {
      bg: 'bg-blue-500/10',
      text: 'text-blue-500',
      badge: 'bg-blue-500/10 text-blue-500',
      dot: 'bg-blue-500',
    },
    review: {
      bg: 'bg-amber-500/10',
      text: 'text-amber-500',
      badge: 'bg-amber-500/10 text-amber-500',
      dot: 'bg-amber-500',
    },
    user: {
      bg: 'bg-green-500/10',
      text: 'text-green-500',
      badge: 'bg-green-500/10 text-green-500',
      dot: 'bg-green-500',
    },
  };
  return map[type] || { bg: 'bg-muted', text: 'text-muted-foreground', badge: 'bg-muted text-muted-foreground', dot: 'bg-muted-foreground' };
}

function formatDate(iso: string) {
  try {
    return new Date(iso).toLocaleString('en-US', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    });
  } catch {
    return iso;
  }
}

function clearFilters() {
  search.value = '';
  typeFilter.value = '';
  dateFrom.value = '';
  dateTo.value = '';
}

async function fetchActivity() {
  loading.value = true;
  error.value = null;

  try {
    const data = await get<ActivityItem[]>('/admin/dashboard/activity?limit=100');
    activities.value = data;
    toast.success('Activity loaded', `${data.length} items fetched`);
  } catch (err: any) {
    const msg = err?.response?.data?.message || err?.message || 'An unexpected error occurred';
    error.value = msg;
    toast.error('Failed to load activity', msg);
  } finally {
    loading.value = false;
  }
}

onMounted(fetchActivity);
</script>
