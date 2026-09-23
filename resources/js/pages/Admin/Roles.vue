<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground mb-1">Roles & Permissions</h1>
          <p class="text-muted-foreground">Manage roles and their associated permissions</p>
        </div>
        <button
          @click="openCreateModal"
          class="bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition whitespace-nowrap"
        >
          + Create Role
        </button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-20">
        <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <span class="ml-3 text-muted-foreground">Loading roles…</span>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-destructive/10 border border-destructive/30 rounded-xl p-6 text-center">
        <svg class="w-10 h-10 text-destructive mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-destructive font-semibold mb-1">Failed to load roles</p>
        <p class="text-muted-foreground text-sm mb-4">{{ error }}</p>
        <button @click="fetchRoles" class="bg-primary hover:bg-primary/90 text-white font-semibold px-5 py-2 rounded-lg transition">
          Retry
        </button>
      </div>

      <!-- Empty State -->
      <div v-else-if="roles.length === 0" class="bg-card border border-border rounded-xl p-12 text-center">
        <svg class="w-12 h-12 text-muted-foreground mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
        <p class="text-foreground font-semibold mb-1">No roles found</p>
        <p class="text-muted-foreground text-sm">Create a role to get started.</p>
      </div>

      <!-- Roles Table -->
      <template v-else>
        <div class="bg-card border border-border rounded-xl overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-border bg-muted/30">
                  <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Role</th>
                  <th class="text-center text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Permissions</th>
                  <th class="text-center text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Users</th>
                  <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Created</th>
                  <th class="text-right text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="role in roles" :key="role.id" class="border-b border-border/50 hover:bg-muted/20 transition">
                  <td class="p-4">
                    <div class="flex items-center gap-3">
                      <div :class="['w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold', roleColor(role.name)]">
                        {{ role.name.charAt(0).toUpperCase() }}
                      </div>
                      <div>
                        <p class="font-semibold text-foreground capitalize">{{ role.name }}</p>
                        <p class="text-xs text-muted-foreground">{{ role.guard_name }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="p-4 text-center">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary/10 text-primary rounded-full text-xs font-semibold">
                      {{ role.permissions?.length ?? 0 }}
                    </span>
                  </td>
                  <td class="p-4 text-center">
                    <span class="text-sm text-foreground font-medium">{{ role.users_count ?? 0 }}</span>
                  </td>
                  <td class="p-4 text-sm text-muted-foreground">
                    {{ formatDate(role.created_at) }}
                  </td>
                  <td class="p-4">
                    <div class="flex items-center justify-end gap-2">
                      <button
                        @click="openEditModal(role)"
                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded-lg transition"
                        title="Edit role"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                      </button>
                      <button
                        v-if="!isSystemRole(role.name)"
                        @click="confirmDelete(role)"
                        class="p-2 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-lg transition"
                        title="Delete role"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                      <span
                        v-else
                        class="p-2 text-muted-foreground/30 cursor-not-allowed"
                        title="System role cannot be deleted"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                      </span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Permissions Matrix -->
        <div class="bg-card border border-border rounded-xl p-6">
          <h2 class="text-xl font-bold text-foreground mb-6">Permissions Matrix</h2>
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-border">
                  <th class="text-left text-muted-foreground text-xs font-semibold p-3 uppercase tracking-wider">Permission</th>
                  <th v-for="role in roles" :key="'matrix-' + role.id" class="text-center text-muted-foreground text-xs font-semibold p-3 uppercase tracking-wider">
                    {{ role.name }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="perm in allPermissions" :key="perm" class="border-b border-border/50">
                  <td class="p-3 text-sm text-foreground font-medium">{{ perm }}</td>
                  <td v-for="role in roles" :key="'cell-' + role.id + '-' + perm" class="p-3 text-center">
                    <span v-if="roleHasPermission(role, perm)" class="inline-flex w-5 h-5 bg-green-500/20 rounded-full items-center justify-center">
                      <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                      </svg>
                    </span>
                    <span v-else class="inline-flex w-5 h-5 bg-muted rounded-full items-center justify-center">
                      <svg class="w-3 h-3 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </template>

      <!-- Create / Edit Modal -->
      <Teleport to="body">
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal" />
          <div class="relative bg-card border border-border rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-border">
              <h2 class="text-xl font-bold text-foreground">
                {{ editingRole ? 'Edit Role' : 'Create Role' }}
              </h2>
              <button @click="closeModal" class="p-2 hover:bg-muted rounded-lg transition text-muted-foreground">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto flex-1 space-y-6">
              <!-- Role Name -->
              <div>
                <label class="block text-sm font-semibold text-foreground mb-2">Role Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  placeholder="e.g. editor, moderator"
                  class="w-full px-4 py-2.5 bg-background border border-border rounded-lg text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition"
                  :disabled="Boolean(editingRole && isSystemRole(editingRole.name))"
                />
                <p v-if="formErrors.name" class="text-destructive text-xs mt-1">{{ formErrors.name }}</p>
              </div>

              <!-- Permissions -->
              <div>
                <div class="flex items-center justify-between mb-3">
                  <label class="text-sm font-semibold text-foreground">Permissions</label>
                  <div class="flex gap-2">
                    <button @click="selectAllPermissions" class="text-xs text-primary hover:underline">Select All</button>
                    <span class="text-muted-foreground text-xs">|</span>
                    <button @click="deselectAllPermissions" class="text-xs text-primary hover:underline">Deselect All</button>
                  </div>
                </div>
                <p v-if="formErrors.permissions" class="text-destructive text-xs mb-2">{{ formErrors.permissions }}</p>

                <div v-if="permissionsLoading" class="flex items-center justify-center py-8">
                  <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                  </svg>
                  <span class="ml-2 text-sm text-muted-foreground">Loading permissions…</span>
                </div>

                <div v-else class="space-y-4">
                  <div v-for="(perms, group) in groupedPermissions" :key="group" class="border border-border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                      <h4 class="text-sm font-semibold text-foreground capitalize">{{ group }}</h4>
                      <button
                        @click="toggleGroup(perms)"
                        class="text-xs text-primary hover:underline"
                      >
                        {{ isGroupFullySelected(perms) ? 'Deselect' : 'Select' }} All
                      </button>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                      <label
                        v-for="perm in perms"
                        :key="perm"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-muted/50 cursor-pointer transition text-sm"
                      >
                        <input
                          type="checkbox"
                          :value="perm"
                          v-model="form.permissions"
                          class="rounded border-border text-primary focus:ring-primary/50"
                        />
                        <span class="text-foreground">{{ permissionLabel(perm) }}</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-border">
              <button
                @click="closeModal"
                class="px-5 py-2.5 text-muted-foreground hover:text-foreground font-semibold rounded-lg transition"
              >
                Cancel
              </button>
              <button
                @click="submitForm"
                :disabled="saving"
                class="bg-primary hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium px-4 py-2 text-sm rounded-lg transition flex items-center gap-2"
              >
                <svg v-if="saving" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                {{ editingRole ? 'Update Role' : 'Create Role' }}
              </button>
            </div>
          </div>
        </div>
      </Teleport>

      <!-- Delete Confirmation Modal -->
      <Teleport to="body">
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showDeleteModal = false" />
          <div class="relative bg-card border border-border rounded-2xl shadow-2xl w-full max-w-md p-6">
            <div class="text-center">
              <div class="w-12 h-12 bg-destructive/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-destructive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </div>
              <h3 class="text-lg font-bold text-foreground mb-2">Delete Role</h3>
              <p class="text-muted-foreground text-sm mb-6">
                Are you sure you want to delete the role <strong class="text-foreground">"{{ deletingRole?.name }}"</strong>?
                This action cannot be undone.
              </p>
              <div class="flex items-center justify-center gap-3">
                <button
                  @click="showDeleteModal = false"
                  class="px-5 py-2.5 text-muted-foreground hover:text-foreground font-semibold rounded-lg transition"
                >
                  Cancel
                </button>
                <button
                  @click="deleteRole"
                  :disabled="deleting"
                  class="bg-destructive hover:bg-destructive/90 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium px-4 py-2 text-sm rounded-lg transition flex items-center gap-2"
                >
                  <svg v-if="deleting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                  </svg>
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </Teleport>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import AdminLayout from '@/layouts/AdminLayout.vue';

// ─── Types ─────────────────────────────────────────────────
interface Role {
  id: number;
  name: string;
  guard_name: string;
  created_at: string;
  permissions: { id: number; name: string }[];
  users_count: number;
}

// ─── Composables ─────────────────────────────────────────────────────
const { get, post, put, delete: del } = useApi();
const toast = useToast();

// ─── State ───────────────────────────────────────────────────────────
const roles = ref<Role[]>([]);
const allPermissions = ref<string[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);
const permissionsLoading = ref(false);

const showModal = ref(false);
const editingRole = ref<Role | null>(null);
const saving = ref(false);
const formErrors = reactive<{ name?: string; permissions?: string }>({});

const showDeleteModal = ref(false);
const deletingRole = ref<Role | null>(null);
const deleting = ref(false);

const form = reactive({
  name: '',
  permissions: [] as string[],
});

const SYSTEM_ROLES = ['superadmin', 'admin', 'user'];

// ─── Computed ────────────────────────────────────────────────────────
const groupedPermissions = computed(() => {
  const groups: Record<string, string[]> = {};
  for (const perm of allPermissions.value) {
    const dotIndex = perm.indexOf('.');
    const group = dotIndex > -1 ? perm.substring(0, dotIndex) : 'general';
    if (!groups[group]) groups[group] = [];
    groups[group].push(perm);
  }
  // Sort groups alphabetically
  const sorted: Record<string, string[]> = {};
  for (const key of Object.keys(groups).sort()) {
    sorted[key] = groups[key].sort();
  }
  return sorted;
});

// ─── Helpers ─────────────────────────────────────────────────────────
function isSystemRole(name: string): boolean {
  return SYSTEM_ROLES.includes(name.toLowerCase());
}

function roleColor(name: string): string {
  const map: Record<string, string> = {
    superadmin: 'bg-red-500/10 text-red-500',
    admin: 'bg-purple-500/10 text-purple-500',
    user: 'bg-green-500/10 text-green-500',
  };
  return map[name.toLowerCase()] ?? 'bg-blue-500/10 text-blue-500';
}

function formatDate(dateStr: string): string {
  if (!dateStr) return '—';
  return new Date(dateStr).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
}

function permissionLabel(perm: string): string {
  const dotIndex = perm.indexOf('.');
  const action = dotIndex > -1 ? perm.substring(dotIndex + 1) : perm;
  return action.replace(/[._-]/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
}

function roleHasPermission(role: Role, perm: string): boolean {
  return role.permissions?.some(p => p.name === perm) ?? false;
}

function isGroupFullySelected(perms: string[]): boolean {
  return perms.every(p => form.permissions.includes(p));
}

function toggleGroup(perms: string[]) {
  if (isGroupFullySelected(perms)) {
    form.permissions = form.permissions.filter(p => !perms.includes(p));
  } else {
    const toAdd = perms.filter(p => !form.permissions.includes(p));
    form.permissions.push(...toAdd);
  }
}

function selectAllPermissions() {
  form.permissions = [...allPermissions.value];
}

function deselectAllPermissions() {
  form.permissions = [];
}

function resetForm() {
  form.name = '';
  form.permissions = [];
  formErrors.name = undefined;
  formErrors.permissions = undefined;
}

// ─── API Calls ───────────────────────────────────────────────────────
async function fetchRoles() {
  loading.value = true;
  error.value = null;
  try {
    const res = await get('/admin/roles');
    roles.value = Array.isArray(res) ? res : (res.data ?? []);
  } catch (e: any) {
    error.value = e.response?.data?.message || e.message || 'An unexpected error occurred';
    toast.error('Error', error.value!);
  } finally {
    loading.value = false;
  }
}

async function fetchPermissions() {
  permissionsLoading.value = true;
  try {
    const res = await get('/admin/permissions');
    const perms = Array.isArray(res) ? res : (res.data ?? []);
    // Controller now returns plain name strings, but handle objects defensively
    allPermissions.value = perms.map((p: any) => (typeof p === 'string' ? p : p.name));
  } catch (e: any) {
    toast.error('Error', 'Failed to load permissions');
  } finally {
    permissionsLoading.value = false;
  }
}

// ─── Modal Actions ───────────────────────────────────────────────────
function openCreateModal() {
  resetForm();
  editingRole.value = null;
  showModal.value = true;
  if (allPermissions.value.length === 0) fetchPermissions();
}

function openEditModal(role: Role) {
  resetForm();
  editingRole.value = role;
  form.name = role.name;
  form.permissions = role.permissions?.map(p => p.name) ?? [];
  showModal.value = true;
  if (allPermissions.value.length === 0) fetchPermissions();
}

function closeModal() {
  showModal.value = false;
  editingRole.value = null;
  resetForm();
}

function validateForm(): boolean {
  formErrors.name = undefined;
  formErrors.permissions = undefined;
  let valid = true;

  if (!form.name.trim()) {
    formErrors.name = 'Role name is required';
    valid = false;
  }

  return valid;
}

async function submitForm() {
  if (!validateForm()) return;

  saving.value = true;
  try {
    const payload = { name: form.name.trim(), permissions: form.permissions };

    if (editingRole.value) {
      await put(`/admin/roles/${editingRole.value.id}`, payload);
      toast.success('Role Updated', `"${form.name}" has been updated successfully.`);
    } else {
      await post('/admin/roles', payload);
      toast.success('Role Created', `"${form.name}" has been created successfully.`);
    }

    closeModal();
    await fetchRoles();
  } catch (e: any) {
    const msg = e.response?.data?.message || e.message || 'Something went wrong';
    if (e.response?.data?.errors) {
      const errs = e.response.data.errors;
      if (errs.name) formErrors.name = errs.name[0];
      if (errs.permissions) formErrors.permissions = errs.permissions[0];
    }
    toast.error('Error', msg);
  } finally {
    saving.value = false;
  }
}

// ─── Delete ──────────────────────────────────────────────────────────
function confirmDelete(role: Role) {
  deletingRole.value = role;
  showDeleteModal.value = true;
}

async function deleteRole() {
  if (!deletingRole.value) return;

  deleting.value = true;
  try {
    await del(`/admin/roles/${deletingRole.value.id}`);
    toast.success('Role Deleted', `"${deletingRole.value.name}" has been deleted.`);
    showDeleteModal.value = false;
    deletingRole.value = null;
    await fetchRoles();
  } catch (e: any) {
    const msg = e.response?.data?.message || e.message || 'Failed to delete role';
    toast.error('Error', msg);
  } finally {
    deleting.value = false;
  }
}

// ─── Init ────────────────────────────────────────────────────────────
onMounted(() => {
  fetchRoles();
});
</script>
