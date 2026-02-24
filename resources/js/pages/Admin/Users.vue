<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-3xl font-display font-bold text-foreground mb-2">User Management</h1>
          <p class="text-muted-foreground">Manage registered users, assign roles, and monitor activity</p>
        </div>
        <button @click="openCreateModal" class="bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition whitespace-nowrap">
          + Add User
        </button>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
        <div class="bg-card border border-border rounded-xl p-5">
          <p class="text-muted-foreground text-sm mb-1">Total Users</p>
          <p class="text-2xl font-bold text-foreground">{{ stats.total }}</p>
        </div>
        <div class="bg-card border border-border rounded-xl p-5">
          <p class="text-muted-foreground text-sm mb-1">Admins</p>
          <p class="text-2xl font-bold text-foreground">{{ stats.admins }}</p>
        </div>
        <div class="bg-card border border-border rounded-xl p-5">
          <p class="text-muted-foreground text-sm mb-1">Editors</p>
          <p class="text-2xl font-bold text-foreground">{{ stats.editors }}</p>
        </div>
        <div class="bg-card border border-border rounded-xl p-5">
          <p class="text-muted-foreground text-sm mb-1">Regular Users</p>
          <p class="text-2xl font-bold text-foreground">{{ stats.users }}</p>
        </div>
        <div class="bg-card border border-border rounded-xl p-5">
          <p class="text-muted-foreground text-sm mb-1">New This Month</p>
          <p class="text-2xl font-bold text-foreground">{{ stats.recent }}</p>
        </div>
      </div>

      <!-- Search & Filters -->
      <div class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1 relative">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search users by name or email..."
            class="w-full bg-card border border-border rounded-lg pl-10 pr-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none transition"
            @input="onSearchInput"
          />
        </div>
        <select v-model="roleFilter" @change="fetchUsers(1)" class="bg-card border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition">
          <option value="">All Roles</option>
          <option v-for="r in roles" :key="r" :value="r">{{ capitalize(r) }}</option>
        </select>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-20">
        <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <span class="ml-3 text-muted-foreground">Loading users...</span>
      </div>

      <!-- Error State -->
      <div v-else-if="fetchError" class="bg-red-500/10 border border-red-500/20 rounded-xl p-8 text-center">
        <p class="text-red-500 font-semibold mb-2">Failed to load users</p>
        <p class="text-muted-foreground text-sm mb-4">{{ fetchError }}</p>
        <button @click="fetchUsers()" class="bg-primary hover:bg-primary/90 text-white font-semibold px-4 py-2 rounded-lg transition text-sm">Retry</button>
      </div>

      <!-- Empty State -->
      <div v-else-if="users.length === 0" class="bg-card border border-border rounded-xl p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-muted-foreground/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <p class="text-muted-foreground font-semibold">No users found</p>
        <p class="text-muted-foreground/70 text-sm mt-1">Try adjusting your search or filter criteria</p>
      </div>

      <!-- Users Table -->
      <div v-else class="bg-card border border-border rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-border bg-muted/30">
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">User</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Email</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Phone</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Role</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Joined</th>
                <th class="text-right text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="u in users" :key="u.id" class="border-b border-border/50 hover:bg-muted/30 transition">
                <td class="p-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                      {{ u.name.charAt(0).toUpperCase() }}
                    </div>
                    <p class="text-foreground font-semibold">{{ u.name }}</p>
                  </div>
                </td>
                <td class="p-4 text-muted-foreground text-sm">{{ u.email }}</td>
                <td class="p-4 text-muted-foreground text-sm">{{ u.phone || '—' }}</td>
                <td class="p-4">
                  <span :class="['px-2.5 py-1 rounded-full text-xs font-semibold', roleClass(u.role)]">
                    {{ capitalize(u.role) }}
                  </span>
                </td>
                <td class="p-4 text-muted-foreground text-sm">{{ formatDate(u.created_at) }}</td>
                <td class="p-4">
                  <div class="flex items-center justify-end gap-2">
                    <button @click="openEditModal(u)" class="text-primary hover:text-primary/80 text-sm font-semibold transition">Edit</button>
                    <template v-if="deleteConfirmId === u.id">
                      <span class="text-red-500 text-sm">Sure?</span>
                      <button @click="confirmDelete(u.id)" class="text-red-500 hover:text-red-400 text-sm font-semibold transition" :disabled="deleting">Yes</button>
                      <button @click="deleteConfirmId = null" class="text-muted-foreground text-sm font-semibold transition">No</button>
                    </template>
                    <button v-else @click="deleteConfirmId = u.id" class="text-muted-foreground hover:text-red-500 text-sm font-semibold transition">Delete</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="pagination.lastPage > 1" class="flex items-center justify-between px-4 py-3 border-t border-border">
          <p class="text-muted-foreground text-sm">
            Showing {{ pagination.from }}–{{ pagination.to }} of {{ pagination.total }}
          </p>
          <div class="flex items-center gap-1">
            <button
              v-for="page in paginationPages"
              :key="page"
              @click="fetchUsers(page)"
              :class="[
                'px-3 py-1.5 text-sm rounded-lg font-medium transition',
                page === pagination.currentPage
                  ? 'bg-primary text-white'
                  : 'text-muted-foreground hover:bg-muted'
              ]"
            >
              {{ page }}
            </button>
          </div>
        </div>
      </div>

      <!-- Create / Edit Modal Backdrop -->
      <Teleport to="body">
        <Transition name="modal">
          <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" @mousedown.self="closeModal">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" />
            <div class="relative bg-card border border-border rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto z-10">
              <!-- Modal Header -->
              <div class="flex items-center justify-between p-6 border-b border-border">
                <h2 class="text-xl font-bold text-foreground">{{ editingUser ? 'Edit User' : 'Create User' }}</h2>
                <button @click="closeModal" class="text-muted-foreground hover:text-foreground transition">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>

              <!-- Modal Body -->
              <form @submit.prevent="submitForm" class="p-6 space-y-5">
                <!-- Name -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1.5">Name</label>
                  <input v-model="form.name" type="text" required class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none transition" placeholder="Full name" />
                  <p v-if="formErrors.name" class="text-red-500 text-xs mt-1">{{ formErrors.name[0] }}</p>
                </div>

                <!-- Email -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1.5">Email</label>
                  <input v-model="form.email" type="email" required class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none transition" placeholder="user@example.com" />
                  <p v-if="formErrors.email" class="text-red-500 text-xs mt-1">{{ formErrors.email[0] }}</p>
                </div>

                <!-- Phone -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1.5">Phone</label>
                  <input v-model="form.phone" type="text" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none transition" placeholder="+27 12 345 6789" />
                  <p v-if="formErrors.phone" class="text-red-500 text-xs mt-1">{{ formErrors.phone[0] }}</p>
                </div>

                <!-- Password -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1.5">
                    Password
                    <span v-if="editingUser" class="text-muted-foreground font-normal">(leave blank to keep current)</span>
                  </label>
                  <input v-model="form.password" type="password" :required="!editingUser" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none transition" placeholder="••••••••" />
                  <p v-if="formErrors.password" class="text-red-500 text-xs mt-1">{{ formErrors.password[0] }}</p>
                </div>

                <!-- Confirm Password -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1.5">Confirm Password</label>
                  <input v-model="form.password_confirmation" type="password" :required="!!form.password" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none transition" placeholder="••••••••" />
                </div>

                <!-- Role -->
                <div>
                  <label class="block text-sm font-medium text-foreground mb-1.5">Role</label>
                  <select v-model="form.role" required class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition">
                    <option value="" disabled>Select a role</option>
                    <option v-for="r in roles" :key="r" :value="r">{{ capitalize(r) }}</option>
                  </select>
                  <p v-if="formErrors.role" class="text-red-500 text-xs mt-1">{{ formErrors.role[0] }}</p>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end gap-3 pt-2">
                  <button type="button" @click="closeModal" class="px-5 py-2.5 text-sm font-semibold text-muted-foreground hover:text-foreground transition rounded-lg border border-border hover:bg-muted">
                    Cancel
                  </button>
                  <button type="submit" :disabled="submitting" class="px-5 py-2.5 text-sm font-semibold bg-primary hover:bg-primary/90 text-white rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <svg v-if="submitting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    {{ editingUser ? 'Update User' : 'Create User' }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </Transition>
      </Teleport>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted, watch } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import { useAuthStore } from '@/stores/auth';

interface UserRecord {
  id: number;
  name: string;
  email: string;
  phone: string | null;
  email_verified_at: string | null;
  profile_photo_url: string | null;
  two_factor_confirmed_at: string | null;
  role: string;
  created_at: string;
}

interface Stats {
  total: number;
  admins: number;
  editors: number;
  users: number;
  recent: number;
}

const { get, post, put, delete: del } = useApi();
const toast = useToast();
const authStore = useAuthStore();

// --- State ---
const users = ref<UserRecord[]>([]);
const stats = reactive<Stats>({ total: 0, admins: 0, editors: 0, users: 0, recent: 0 });
const roles = ref<string[]>([]);
const loading = ref(false);
const fetchError = ref<string | null>(null);

const searchQuery = ref('');
const roleFilter = ref('');
let searchTimeout: ReturnType<typeof setTimeout> | null = null;

const pagination = reactive({
  currentPage: 1,
  lastPage: 1,
  total: 0,
  from: 0,
  to: 0,
});

// Modal
const showModal = ref(false);
const editingUser = ref<UserRecord | null>(null);
const submitting = ref(false);
const formErrors = ref<Record<string, string[]>>({});

const form = reactive({
  name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
  role: '',
});

// Delete
const deleteConfirmId = ref<number | null>(null);
const deleting = ref(false);

// --- Computed ---
const paginationPages = computed(() => {
  const pages: number[] = [];
  const maxVisible = 7;
  const current = pagination.currentPage;
  const last = pagination.lastPage;

  if (last <= maxVisible) {
    for (let i = 1; i <= last; i++) pages.push(i);
  } else {
    const start = Math.max(1, current - 3);
    const end = Math.min(last, start + maxVisible - 1);
    for (let i = start; i <= end; i++) pages.push(i);
  }
  return pages;
});

// --- Methods ---
function capitalize(str: string) {
  if (!str) return '';
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function roleClass(role: string) {
  const map: Record<string, string> = {
    superadmin: 'bg-red-500/10 text-red-500',
    admin: 'bg-purple-500/10 text-purple-500',
    editor: 'bg-blue-500/10 text-blue-500',
    user: 'bg-green-500/10 text-green-500',
  };
  return map[role] || 'bg-muted text-muted-foreground';
}

function formatDate(dateStr: string) {
  if (!dateStr) return '—';
  return new Date(dateStr).toLocaleDateString('en-ZA', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
}

function onSearchInput() {
  if (searchTimeout) clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    fetchUsers(1);
  }, 400);
}

async function fetchUsers(page?: number) {
  loading.value = true;
  fetchError.value = null;
  try {
    const params: Record<string, string | number> = {};
    if (searchQuery.value) params.search = searchQuery.value;
    if (roleFilter.value) params.role = roleFilter.value;
    params.page = page || pagination.currentPage;

    const res = await get('/admin/users', { params });
    // Expect Laravel paginated response
    users.value = res.data;
    pagination.currentPage = res.current_page;
    pagination.lastPage = res.last_page;
    pagination.total = res.total;
    pagination.from = res.from ?? 0;
    pagination.to = res.to ?? 0;
  } catch (err: any) {
    fetchError.value = err.response?.data?.message || err.message || 'An unexpected error occurred';
    toast.error('Error', fetchError.value!);
  } finally {
    loading.value = false;
  }
}

async function fetchStats() {
  try {
    const res = await get('/admin/users/stats');
    Object.assign(stats, res);
  } catch {
    // Non-critical, stats just stay at 0
  }
}

async function fetchRoles() {
  try {
    const res = await get('/admin/roles');
    // Expect array of role objects with name or array of strings
    roles.value = Array.isArray(res) ? res.map((r: any) => (typeof r === 'string' ? r : r.name)) : [];
  } catch {
    // Fallback roles
    roles.value = ['superadmin', 'admin', 'editor', 'user'];
  }
}

function resetForm() {
  form.name = '';
  form.email = '';
  form.phone = '';
  form.password = '';
  form.password_confirmation = '';
  form.role = '';
  formErrors.value = {};
}

function openCreateModal() {
  editingUser.value = null;
  resetForm();
  showModal.value = true;
}

function openEditModal(user: UserRecord) {
  editingUser.value = user;
  form.name = user.name;
  form.email = user.email;
  form.phone = user.phone || '';
  form.password = '';
  form.password_confirmation = '';
  form.role = user.role;
  formErrors.value = {};
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  editingUser.value = null;
  resetForm();
}

async function submitForm() {
  submitting.value = true;
  formErrors.value = {};

  try {
    if (editingUser.value) {
      // Update
      const payload: Record<string, string> = {
        name: form.name,
        email: form.email,
        phone: form.phone,
        role: form.role,
      };
      if (form.password) {
        payload.password = form.password;
        payload.password_confirmation = form.password_confirmation;
      }
      await put(`/admin/users/${editingUser.value.id}`, payload);
      toast.success('User updated', `${form.name} has been updated successfully.`);
    } else {
      // Create
      await post('/admin/users', {
        name: form.name,
        email: form.email,
        phone: form.phone,
        password: form.password,
        password_confirmation: form.password_confirmation,
        role: form.role,
      });
      toast.success('User created', `${form.name} has been created successfully.`);
    }

    closeModal();
    fetchUsers();
    fetchStats();
  } catch (err: any) {
    if (err.response?.status === 422 && err.response?.data?.errors) {
      formErrors.value = err.response.data.errors;
    } else {
      const msg = err.response?.data?.message || 'Something went wrong';
      toast.error('Error', msg);
    }
  } finally {
    submitting.value = false;
  }
}

async function confirmDelete(userId: number) {
  // Prevent deleting yourself
  if (authStore.user?.id === userId) {
    toast.warning('Cannot delete', 'You cannot delete your own account.');
    deleteConfirmId.value = null;
    return;
  }

  deleting.value = true;
  try {
    await del(`/admin/users/${userId}`);
    toast.success('User deleted', 'The user has been removed.');
    deleteConfirmId.value = null;
    fetchUsers();
    fetchStats();
  } catch (err: any) {
    if (err.response?.status === 403) {
      toast.error('Forbidden', 'You cannot delete this user.');
    } else {
      toast.error('Error', err.response?.data?.message || 'Failed to delete user');
    }
    deleteConfirmId.value = null;
  } finally {
    deleting.value = false;
  }
}

// --- Lifecycle ---
onMounted(() => {
  fetchUsers(1);
  fetchStats();
  fetchRoles();
});
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.2s ease;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
