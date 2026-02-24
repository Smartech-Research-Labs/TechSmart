<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-3xl font-display font-bold text-foreground mb-2">Roles & Permissions</h1>
          <p class="text-muted-foreground">Manage roles and their associated permissions</p>
        </div>
        <button class="bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition whitespace-nowrap">
          + Create Role
        </button>
      </div>

      <!-- Roles Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div v-for="role in roles" :key="role.name" class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
              <div :class="['w-10 h-10 rounded-xl flex items-center justify-center', role.bgColor]">
                <svg class="w-5 h-5" :class="role.iconColor" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="role.icon" />
                </svg>
              </div>
              <div>
                <h3 class="font-bold text-foreground capitalize">{{ role.name }}</h3>
                <p class="text-xs text-muted-foreground">{{ role.userCount }} users</p>
              </div>
            </div>
            <button class="text-primary hover:text-primary/80 text-sm font-semibold transition">Edit</button>
          </div>
          <p class="text-sm text-muted-foreground mb-4">{{ role.description }}</p>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="perm in role.permissions"
              :key="perm"
              class="px-2 py-1 bg-muted/50 border border-border rounded text-xs text-muted-foreground"
            >
              {{ perm }}
            </span>
          </div>
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
                <th v-for="role in roleNames" :key="role" class="text-center text-muted-foreground text-xs font-semibold p-3 uppercase tracking-wider">{{ role }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="perm in permissionsList" :key="perm" class="border-b border-border/50">
                <td class="p-3 text-sm text-foreground font-medium">{{ perm }}</td>
                <td v-for="role in roleNames" :key="role" class="p-3 text-center">
                  <span v-if="hasPermission(role, perm)" class="inline-flex w-5 h-5 bg-green-500/20 rounded-full items-center justify-center">
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
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';

const roleNames = ['superadmin', 'admin', 'editor', 'user'];

const roles = [
  {
    name: 'superadmin',
    description: 'Full system access including user management, roles, settings, and audit logs',
    userCount: 1,
    bgColor: 'bg-red-500/10',
    iconColor: 'text-red-500',
    icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
    permissions: ['All Permissions', 'User Management', 'Role Management', 'System Settings', 'Audit Logs'],
  },
  {
    name: 'admin',
    description: 'Content management, service/product CRUD, enquiry management, and CMS control',
    userCount: 3,
    bgColor: 'bg-purple-500/10',
    iconColor: 'text-purple-500',
    icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065',
    permissions: ['Content CRUD', 'CMS Management', 'Enquiry Management', 'Blog Management', 'Settings'],
  },
  {
    name: 'editor',
    description: 'Create and edit content, manage blog posts and pages',
    userCount: 5,
    bgColor: 'bg-blue-500/10',
    iconColor: 'text-blue-500',
    icon: 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
    permissions: ['Blog Create/Edit', 'Page Create/Edit', 'Media Upload', 'View Analytics'],
  },
  {
    name: 'user',
    description: 'Basic access to dashboard, profile, wishlist, enquiries, and reviews',
    userCount: 147,
    bgColor: 'bg-green-500/10',
    iconColor: 'text-green-500',
    icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
    permissions: ['Profile Management', 'Wishlist', 'Submit Enquiry', 'Write Review'],
  },
];

const permissionsList = [
  'View Dashboard',
  'Manage Users',
  'Manage Roles',
  'Manage Services',
  'Manage Products',
  'Manage Bundles',
  'Manage Blog',
  'Manage Pages',
  'Manage CMS',
  'Manage Enquiries',
  'Manage Reviews',
  'Manage Settings',
  'View Audit Logs',
  'System Administration',
];

const permissionMap: Record<string, string[]> = {
  superadmin: permissionsList, // all
  admin: ['View Dashboard', 'Manage Services', 'Manage Products', 'Manage Bundles', 'Manage Blog', 'Manage Pages', 'Manage CMS', 'Manage Enquiries', 'Manage Reviews', 'Manage Settings'],
  editor: ['View Dashboard', 'Manage Blog', 'Manage Pages'],
  user: ['View Dashboard'],
};

function hasPermission(role: string, perm: string): boolean {
  return permissionMap[role]?.includes(perm) ?? false;
}
</script>
