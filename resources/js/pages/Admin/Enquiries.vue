<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-xl font-display font-bold text-foreground mb-1">Manage Enquiries</h1>
        <p class="text-muted-foreground">View and respond to customer inquiries</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-card border border-border rounded-lg p-5">
          <p class="text-sm text-muted-foreground mb-1">Total</p>
          <p class="text-lg font-bold text-foreground">{{ stats.total }}</p>
        </div>
        <div class="bg-card border border-blue-500/30 rounded-lg p-5">
          <p class="text-sm text-blue-400 mb-1">New</p>
          <p class="text-lg font-bold text-blue-400">{{ stats.new }}</p>
        </div>
        <div class="bg-card border border-amber-500/30 rounded-lg p-5">
          <p class="text-sm text-amber-400 mb-1">In Progress</p>
          <p class="text-lg font-bold text-amber-400">{{ stats.in_progress }}</p>
        </div>
        <div class="bg-card border border-green-500/30 rounded-lg p-5">
          <p class="text-sm text-green-400 mb-1">Resolved</p>
          <p class="text-lg font-bold text-green-400">{{ stats.resolved }}</p>
        </div>
      </div>

      <!-- Search & Filter Bar -->
      <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search by name, email, or message..."
            class="w-full bg-card border border-border rounded-lg py-2.5 pl-10 pr-4 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition"
            @input="debouncedFetch"
          />
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
        </div>
        <select
          v-model="statusFilter"
          class="bg-card border border-border rounded-lg py-2.5 px-4 text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition"
          @change="fetchEnquiries"
        >
          <option value="">All Statuses</option>
          <option value="new">New</option>
          <option value="in-progress">In Progress</option>
          <option value="resolved">Resolved</option>
          <option value="closed">Closed</option>
        </select>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-16">
        <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <span class="ml-3 text-muted-foreground">Loading enquiries...</span>
      </div>

      <!-- Error State -->
      <div v-else-if="errorMsg" class="bg-red-500/10 border border-red-500/30 rounded-lg p-6 text-center">
        <p class="text-red-400 mb-3">{{ errorMsg }}</p>
        <button
          class="bg-red-500/20 hover:bg-red-500/30 text-red-400 font-semibold py-2 px-4 rounded-lg transition text-sm"
          @click="fetchEnquiries"
        >
          Retry
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="enquiries.length === 0" class="bg-card border border-border rounded-lg p-12 text-center">
        <p class="text-muted-foreground">No enquiries found.</p>
      </div>

      <!-- Enquiries List -->
      <div v-else class="space-y-4">
        <div
          v-for="enquiry in enquiries"
          :key="enquiry.id"
          class="bg-card border border-border rounded-lg p-6 hover:border-primary transition"
        >
          <div class="flex items-start justify-between mb-4">
            <div>
              <h3 class="text-lg font-bold text-foreground mb-1">{{ enquiry.name }}</h3>
              <p class="text-sm text-muted-foreground">{{ enquiry.email }}<span v-if="enquiry.phone"> &middot; {{ enquiry.phone }}</span></p>
              <p v-if="enquiry.company" class="text-sm text-muted-foreground">{{ enquiry.company }}</p>
              <p class="text-sm text-muted-foreground mt-1">{{ formatDate(enquiry.created_at) }}</p>
            </div>
            <span :class="statusBadgeClasses(enquiry.status)">
              {{ formatStatus(enquiry.status) }}
            </span>
          </div>

          <div class="bg-muted/30 rounded-lg p-4 mb-4">
            <p class="text-muted-foreground whitespace-pre-line">{{ enquiry.message }}</p>
          </div>

          <!-- Reply Form -->
          <div v-if="replyingTo === enquiry.id" class="mb-4">
            <textarea
              v-model="replyText"
              rows="3"
              placeholder="Type your reply..."
              class="w-full bg-muted/30 border border-border rounded-lg p-3 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition resize-none"
            />
            <div class="flex gap-2 mt-2">
              <button
                :disabled="!replyText.trim() || sendingReply"
                class="bg-primary hover:bg-primary/90 text-white font-semibold py-2 px-4 rounded-lg transition text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                @click="submitReply(enquiry.id)"
              >
                {{ sendingReply ? 'Sending...' : 'Send Reply' }}
              </button>
              <button
                class="border border-border hover:border-muted-foreground text-muted-foreground font-semibold py-2 px-4 rounded-lg transition text-sm"
                @click="cancelReply"
              >
                Cancel
              </button>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-2">
            <button
              v-if="replyingTo !== enquiry.id"
              class="bg-primary hover:bg-primary/90 text-white font-semibold py-2 px-4 rounded-lg transition text-sm"
              @click="startReply(enquiry.id)"
            >
              Reply
            </button>
            <button
              v-if="enquiry.status !== 'resolved' && enquiry.status !== 'closed'"
              :disabled="resolvingId === enquiry.id"
              class="bg-green-500/20 hover:bg-green-500/30 text-green-400 font-semibold py-2 px-4 rounded-lg transition text-sm disabled:opacity-50"
              @click="markResolved(enquiry.id)"
            >
              {{ resolvingId === enquiry.id ? 'Resolving...' : 'Mark Resolved' }}
            </button>
            <button
              :disabled="deletingId === enquiry.id"
              class="border border-border hover:border-red-500/50 text-muted-foreground hover:text-red-400 font-semibold py-2 px-4 rounded-lg transition text-sm disabled:opacity-50"
              @click="confirmDelete(enquiry.id)"
            >
              {{ deletingId === enquiry.id ? 'Deleting...' : 'Delete' }}
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.lastPage > 1" class="flex items-center justify-center gap-2">
        <button
          :disabled="pagination.currentPage <= 1"
          class="px-3 py-1.5 rounded-lg border border-border text-sm text-muted-foreground hover:border-primary hover:text-foreground transition disabled:opacity-40 disabled:cursor-not-allowed"
          @click="goToPage(pagination.currentPage - 1)"
        >
          Previous
        </button>
        <span class="text-sm text-muted-foreground">
          Page {{ pagination.currentPage }} of {{ pagination.lastPage }}
        </span>
        <button
          :disabled="pagination.currentPage >= pagination.lastPage"
          class="px-3 py-1.5 rounded-lg border border-border text-sm text-muted-foreground hover:border-primary hover:text-foreground transition disabled:opacity-40 disabled:cursor-not-allowed"
          @click="goToPage(pagination.currentPage + 1)"
        >
          Next
        </button>
      </div>

      <!-- Delete Confirmation Modal -->
      <Teleport to="body">
        <div v-if="deleteConfirmId !== null" class="fixed inset-0 z-50 flex items-center justify-center">
          <div class="absolute inset-0 bg-black/60" @click="deleteConfirmId = null" />
          <div class="relative bg-card border border-border rounded-xl p-6 max-w-md w-full mx-4 shadow-xl">
            <h3 class="text-lg font-bold text-foreground mb-2">Delete Enquiry</h3>
            <p class="text-muted-foreground mb-6">Are you sure you want to delete this enquiry? This action cannot be undone.</p>
            <div class="flex gap-3 justify-end">
              <button
                class="border border-border hover:border-muted-foreground text-muted-foreground font-semibold py-2 px-4 rounded-lg transition text-sm"
                @click="deleteConfirmId = null"
              >
                Cancel
              </button>
              <button
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition text-sm"
                @click="deleteEnquiry(deleteConfirmId!)"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </Teleport>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import AdminLayout from '@/layouts/AdminLayout.vue';

interface Enquiry {
  id: number;
  user_id: number | null;
  name: string;
  email: string;
  phone: string | null;
  company: string | null;
  enquirable_type: string | null;
  enquirable_id: number | null;
  message: string;
  form_data: Record<string, any> | null;
  status: 'new' | 'in-progress' | 'resolved' | 'closed';
  internal_notes: string | null;
  assigned_to: number | null;
  created_at: string;
  updated_at: string;
}

const { get, post, put, delete: apiDelete } = useApi();
const toast = useToast();

const enquiries = ref<Enquiry[]>([]);
const loading = ref(false);
const errorMsg = ref('');
const searchQuery = ref('');
const statusFilter = ref('');

const stats = reactive({ total: 0, new: 0, in_progress: 0, resolved: 0 });
const pagination = reactive({ currentPage: 1, lastPage: 1 });

const replyingTo = ref<number | null>(null);
const replyText = ref('');
const sendingReply = ref(false);
const resolvingId = ref<number | null>(null);
const deletingId = ref<number | null>(null);
const deleteConfirmId = ref<number | null>(null);

let debounceTimer: ReturnType<typeof setTimeout> | null = null;

function debouncedFetch() {
  if (debounceTimer) clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    pagination.currentPage = 1;
    fetchEnquiries();
  }, 400);
}

async function fetchStats() {
  try {
    const data = await get('/admin/enquiries/stats');
    stats.total = data.total ?? 0;
    stats.new = data.new ?? 0;
    stats.in_progress = data.in_progress ?? 0;
    stats.resolved = data.resolved ?? 0;
  } catch {
    // stats are non-critical â€” silently ignore
  }
}

async function fetchEnquiries(page = pagination.currentPage) {
  loading.value = true;
  errorMsg.value = '';
  try {
    const params: Record<string, string | number> = { page };
    if (searchQuery.value) params.search = searchQuery.value;
    if (statusFilter.value) params.status = statusFilter.value;

    const data = await get('/admin/enquiries', { params });

    enquiries.value = data.data ?? data;
    pagination.currentPage = data.current_page ?? page;
    pagination.lastPage = data.last_page ?? 1;
  } catch (err: any) {
    errorMsg.value = err?.response?.data?.message || 'Failed to load enquiries.';
  } finally {
    loading.value = false;
  }
}

function goToPage(page: number) {
  fetchEnquiries(page);
}

function startReply(id: number) {
  replyingTo.value = id;
  replyText.value = '';
}

function cancelReply() {
  replyingTo.value = null;
  replyText.value = '';
}

async function submitReply(id: number) {
  if (!replyText.value.trim()) return;
  sendingReply.value = true;
  try {
    await post(`/admin/enquiries/${id}/reply`, { reply: replyText.value });
    toast.success('Reply sent', 'Your reply has been sent successfully.');
    cancelReply();
    await Promise.all([fetchEnquiries(), fetchStats()]);
  } catch (err: any) {
    toast.error('Reply failed', err?.response?.data?.message || 'Could not send the reply.');
  } finally {
    sendingReply.value = false;
  }
}

async function markResolved(id: number) {
  resolvingId.value = id;
  try {
    await put(`/admin/enquiries/${id}`, { status: 'resolved' });
    toast.success('Enquiry resolved', 'The enquiry has been marked as resolved.');
    await Promise.all([fetchEnquiries(), fetchStats()]);
  } catch (err: any) {
    toast.error('Update failed', err?.response?.data?.message || 'Could not update the enquiry.');
  } finally {
    resolvingId.value = null;
  }
}

function confirmDelete(id: number) {
  deleteConfirmId.value = id;
}

async function deleteEnquiry(id: number) {
  deleteConfirmId.value = null;
  deletingId.value = id;
  try {
    await apiDelete(`/admin/enquiries/${id}`);
    toast.success('Enquiry deleted', 'The enquiry has been removed.');
    await Promise.all([fetchEnquiries(), fetchStats()]);
  } catch (err: any) {
    toast.error('Delete failed', err?.response?.data?.message || 'Could not delete the enquiry.');
  } finally {
    deletingId.value = null;
  }
}

function formatDate(dateStr: string): string {
  return new Date(dateStr).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
}

function formatStatus(status: string): string {
  return status.replace(/-/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
}

function statusBadgeClasses(status: string): string {
  const base = 'px-2 py-1 rounded text-xs font-semibold';
  switch (status) {
    case 'new':
      return `${base} bg-blue-500/20 text-blue-400`;
    case 'in-progress':
      return `${base} bg-amber-500/20 text-amber-400`;
    case 'resolved':
      return `${base} bg-green-500/20 text-green-400`;
    case 'closed':
      return `${base} bg-gray-500/20 text-gray-400`;
    default:
      return `${base} bg-muted text-muted-foreground`;
  }
}

onMounted(() => {
  fetchEnquiries();
  fetchStats();
});
</script>
