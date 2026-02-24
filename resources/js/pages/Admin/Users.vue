<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-3xl font-display font-bold text-foreground mb-2">User Management</h1>
          <p class="text-muted-foreground">Manage registered users, assign roles, and monitor activity</p>
        </div>
        <button @click="showAddModal = true" class="bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition whitespace-nowrap">
          + Add User
        </button>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div v-for="stat in userStats" :key="stat.label" class="bg-card border border-border rounded-xl p-5">
          <p class="text-muted-foreground text-sm mb-1">{{ stat.label }}</p>
          <p class="text-2xl font-bold text-foreground">{{ stat.value }}</p>
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
          />
        </div>
        <select v-model="roleFilter" class="bg-card border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition">
          <option value="">All Roles</option>
          <option value="superadmin">Super Admin</option>
          <option value="admin">Admin</option>
          <option value="editor">Editor</option>
          <option value="user">User</option>
        </select>
      </div>

      <!-- Users Table -->
      <div class="bg-card border border-border rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-border bg-muted/30">
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">User</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Role</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Status</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Joined</th>
                <th class="text-right text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="u in filteredUsers" :key="u.id" class="border-b border-border/50 hover:bg-muted/30 transition">
                <td class="p-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                      {{ u.name.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                      <p class="text-foreground font-semibold">{{ u.name }}</p>
                      <p class="text-muted-foreground text-sm">{{ u.email }}</p>
                    </div>
                  </div>
                </td>
                <td class="p-4">
                  <span :class="['px-2.5 py-1 rounded-full text-xs font-semibold', roleClass(u.role)]">
                    {{ u.role }}
                  </span>
                </td>
                <td class="p-4">
                  <span :class="['px-2.5 py-1 rounded-full text-xs font-semibold', u.active ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500']">
                    {{ u.active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="p-4 text-muted-foreground text-sm">{{ u.joined }}</td>
                <td class="p-4">
                  <div class="flex items-center justify-end gap-2">
                    <button class="text-primary hover:text-primary/80 text-sm font-semibold transition">Edit</button>
                    <button class="text-muted-foreground hover:text-red-500 text-sm font-semibold transition">Delete</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

const searchQuery = ref('');
const roleFilter = ref('');
const showAddModal = ref(false);

const userStats = [
  { label: 'Total Users', value: 156 },
  { label: 'Active Users', value: 142 },
  { label: 'Admins', value: 4 },
  { label: 'New This Month', value: 23 },
];

const users = ref([
  { id: 1, name: 'Admin User', email: 'admin@techsmart.co.za', role: 'superadmin', active: true, joined: 'Jan 1, 2025' },
  { id: 2, name: 'John Doe', email: 'john@example.com', role: 'user', active: true, joined: 'Feb 5, 2025' },
  { id: 3, name: 'Jane Smith', email: 'jane@example.com', role: 'editor', active: true, joined: 'Mar 12, 2025' },
  { id: 4, name: 'Mike Johnson', email: 'mike@example.com', role: 'admin', active: true, joined: 'Apr 8, 2025' },
  { id: 5, name: 'Sarah Wilson', email: 'sarah@example.com', role: 'user', active: false, joined: 'May 20, 2025' },
  { id: 6, name: 'David Brown', email: 'david@example.com', role: 'editor', active: true, joined: 'Jun 15, 2025' },
]);

const filteredUsers = computed(() => {
  return users.value.filter(u => {
    const matchesSearch = !searchQuery.value || 
      u.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      u.email.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchesRole = !roleFilter.value || u.role === roleFilter.value;
    return matchesSearch && matchesRole;
  });
});

function roleClass(role: string) {
  const map: Record<string, string> = {
    superadmin: 'bg-red-500/10 text-red-500',
    admin: 'bg-purple-500/10 text-purple-500',
    editor: 'bg-blue-500/10 text-blue-500',
    user: 'bg-green-500/10 text-green-500',
  };
  return map[role] || 'bg-muted text-muted-foreground';
}
</script>
