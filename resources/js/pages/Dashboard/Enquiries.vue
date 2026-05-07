<template>
  <DashboardLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-xl font-display font-bold text-foreground mb-1">My Enquiries</h1>
        <p class="text-muted-foreground">Track your service and product inquiries</p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="space-y-4">
        <div v-for="i in 3" :key="i" class="bg-card border border-border rounded-lg p-6 animate-pulse">
          <div class="flex items-start justify-between mb-4">
            <div class="space-y-2 flex-1">
              <div class="h-5 w-2/3 bg-muted rounded" />
              <div class="h-3 w-1/4 bg-muted rounded" />
            </div>
            <div class="h-6 w-20 bg-muted rounded-full" />
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
        <h3 class="text-lg font-semibold text-foreground mb-2">Failed to load enquiries</h3>
        <p class="text-muted-foreground mb-4">{{ error }}</p>
        <button
          @click="fetchEnquiries"
          class="inline-block bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition"
        >
          Retry
        </button>
      </div>

      <!-- Enquiries List -->
      <div v-else-if="enquiries.length > 0" class="space-y-4">
        <div class="mb-2">
          <input v-model="searchQuery" type="text" placeholder="Search by subject, message..." class="w-full sm:w-80 px-4 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
        </div>
        <div v-if="searchQuery && filteredEnquiries.length === 0" class="py-8 text-center text-muted-foreground">No enquiries match your search.</div>
        <div
          v-for="enquiry in filteredEnquiries"
          :key="enquiry.id"
          class="bg-card border border-border rounded-lg p-6 hover:border-primary transition"
        >
          <div class="flex items-start justify-between mb-4">
            <div>
              <h3 class="text-lg font-bold text-foreground mb-1">
                {{ enquiry.subject || enquiry.enquirable?.name || 'Enquiry' }}
              </h3>
              <p class="text-sm text-muted-foreground">{{ formatDate(enquiry.created_at) }}</p>
            </div>
            <span
              :class="[
                'px-3 py-1 rounded-full text-xs font-semibold',
                statusBadgeClass(enquiry.status),
              ]"
            >
              {{ (enquiry.status || 'pending').toUpperCase() }}
            </span>
          </div>

          <p class="text-muted-foreground mb-4">{{ enquiry.message }}</p>

          <!-- Expandable replies -->
          <div v-if="enquiry.reply || enquiry.admin_reply" class="mb-4">
            <button
              @click="toggleExpand(enquiry.id)"
              class="text-sm text-primary hover:text-primary/80 font-semibold transition flex items-center gap-1"
            >
              <svg
                class="w-4 h-4 transition-transform"
                :class="expanded.has(enquiry.id) ? 'rotate-180' : ''"
                fill="none" stroke="currentColor" viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
              {{ expanded.has(enquiry.id) ? 'Hide Reply' : 'View Reply' }}
            </button>
            <div v-if="expanded.has(enquiry.id)" class="bg-muted/30 border border-border rounded-lg p-4 mt-3">
              <p class="text-sm text-muted-foreground mb-2">Reply from support:</p>
              <p class="text-muted-foreground">{{ enquiry.reply || enquiry.admin_reply }}</p>
            </div>
          </div>

          <!-- Related item -->
          <div v-if="enquiry.enquirable" class="text-xs text-muted-foreground">
            Related to: <span class="font-medium text-foreground">{{ enquiry.enquirable.name || enquiry.enquirable.title }}</span>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-foreground mb-2">No Enquiries Yet</h3>
        <p class="text-muted-foreground mb-6">Have questions? Get in touch with us</p>
        <router-link
          to="/contact"
          class="inline-block bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition"
        >
          Contact Us
        </router-link>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { IconAlertTriangle } from '@tabler/icons-vue';
import { ref, reactive, onMounted, computed } from 'vue';
import { useApi } from '@/composables/useApi';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const { get } = useApi();

const loading = ref(true);
const error = ref<string | null>(null);
const enquiries = ref<any[]>([]);
const expanded = reactive(new Set<number>());
const searchQuery = ref('');

const filteredEnquiries = computed(() => {
  if (!searchQuery.value) return enquiries.value;
  const q = searchQuery.value.toLowerCase();
  return enquiries.value.filter((e: any) =>
    (e.subject || '').toLowerCase().includes(q) ||
    (e.message || '').toLowerCase().includes(q) ||
    (e.enquirable?.name || '').toLowerCase().includes(q) ||
    (e.status || '').toLowerCase().includes(q)
  );
});

const pagination = ref({
  currentPage: 1,
  lastPage: 1,
  total: 0,
});

function statusBadgeClass(status: string): string {
  switch (status?.toLowerCase()) {
    case 'pending': return 'bg-amber-500/20 text-amber-400';
    case 'replied': return 'bg-blue-500/20 text-blue-400';
    case 'resolved': case 'closed': return 'bg-green-500/20 text-green-400';
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

function toggleExpand(id: number) {
  if (expanded.has(id)) {
    expanded.delete(id);
  } else {
    expanded.add(id);
  }
}

async function fetchEnquiries(page: number = 1) {
  loading.value = true;
  error.value = null;
  try {
    const data = await get(`/user/enquiries?page=${page}`);
    // Handle Laravel paginated response
    enquiries.value = data.data ?? data ?? [];
    pagination.value = {
      currentPage: data.current_page ?? 1,
      lastPage: data.last_page ?? 1,
      total: data.total ?? enquiries.value.length,
    };
  } catch (err: any) {
    error.value = err.response?.data?.message || err.message || 'Failed to load enquiries';
    enquiries.value = [];
  } finally {
    loading.value = false;
  }
}

function goToPage(page: number) {
  if (page >= 1 && page <= pagination.value.lastPage) {
    fetchEnquiries(page);
  }
}

onMounted(() => fetchEnquiries());
</script>
