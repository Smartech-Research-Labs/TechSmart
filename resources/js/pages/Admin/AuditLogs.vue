<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-3xl font-display font-bold text-foreground mb-2">Audit Logs</h1>
        <p class="text-muted-foreground">Track system events, user actions, and security incidents</p>
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
            placeholder="Search audit logs..."
            class="w-full bg-card border border-border rounded-lg pl-10 pr-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none transition"
          />
        </div>
        <select v-model="typeFilter" class="bg-card border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition">
          <option value="">All Events</option>
          <option value="auth">Authentication</option>
          <option value="content">Content</option>
          <option value="settings">Settings</option>
          <option value="user">User Management</option>
        </select>
        <select v-model="severityFilter" class="bg-card border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition">
          <option value="">All Severity</option>
          <option value="info">Info</option>
          <option value="warning">Warning</option>
          <option value="critical">Critical</option>
        </select>
      </div>

      <!-- Logs Table -->
      <div class="bg-card border border-border rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-border bg-muted/30">
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Timestamp</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">User</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Action</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Type</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">Severity</th>
                <th class="text-left text-muted-foreground text-xs font-semibold p-4 uppercase tracking-wider">IP Address</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="log in filteredLogs" :key="log.id" class="border-b border-border/50 hover:bg-muted/30 transition">
                <td class="p-4 text-muted-foreground text-sm whitespace-nowrap">{{ log.timestamp }}</td>
                <td class="p-4">
                  <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xs font-bold">
                      {{ log.user.charAt(0) }}
                    </div>
                    <span class="text-foreground text-sm font-medium">{{ log.user }}</span>
                  </div>
                </td>
                <td class="p-4 text-foreground text-sm">{{ log.action }}</td>
                <td class="p-4">
                  <span :class="['px-2 py-1 rounded text-xs font-semibold', typeClass(log.type)]">{{ log.type }}</span>
                </td>
                <td class="p-4">
                  <span :class="['px-2 py-1 rounded-full text-xs font-semibold', severityClass(log.severity)]">{{ log.severity }}</span>
                </td>
                <td class="p-4 text-muted-foreground text-sm font-mono">{{ log.ip }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      <div class="flex items-center justify-between">
        <p class="text-sm text-muted-foreground">Showing {{ filteredLogs.length }} of {{ logs.length }} entries</p>
        <div class="flex gap-2">
          <button class="px-4 py-2 bg-card border border-border rounded-lg text-muted-foreground hover:bg-muted transition text-sm">Previous</button>
          <button class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition text-sm">Next</button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

const search = ref('');
const typeFilter = ref('');
const severityFilter = ref('');

const logs = ref([
  { id: 1, timestamp: '2025-08-15 14:32:01', user: 'Admin User', action: 'Updated site settings', type: 'settings', severity: 'info', ip: '192.168.1.1' },
  { id: 2, timestamp: '2025-08-15 14:28:15', user: 'Admin User', action: 'Created blog post "Launch Announcement"', type: 'content', severity: 'info', ip: '192.168.1.1' },
  { id: 3, timestamp: '2025-08-15 13:45:22', user: 'John Doe', action: 'Failed login attempt (3rd attempt)', type: 'auth', severity: 'warning', ip: '203.0.113.42' },
  { id: 4, timestamp: '2025-08-15 12:11:08', user: 'Jane Smith', action: 'Updated service "Web Development"', type: 'content', severity: 'info', ip: '10.0.0.55' },
  { id: 5, timestamp: '2025-08-15 11:05:33', user: 'Admin User', action: 'Changed user role: Mike Johnson → admin', type: 'user', severity: 'warning', ip: '192.168.1.1' },
  { id: 6, timestamp: '2025-08-15 09:22:17', user: 'System', action: 'Database backup completed successfully', type: 'settings', severity: 'info', ip: '127.0.0.1' },
  { id: 7, timestamp: '2025-08-14 23:58:44', user: 'Unknown', action: 'Unauthorized API access attempt to /api/v1/admin/users', type: 'auth', severity: 'critical', ip: '198.51.100.78' },
  { id: 8, timestamp: '2025-08-14 20:15:09', user: 'Admin User', action: 'Deleted product "Legacy Package"', type: 'content', severity: 'warning', ip: '192.168.1.1' },
  { id: 9, timestamp: '2025-08-14 18:30:55', user: 'David Brown', action: 'Published page "Privacy Policy"', type: 'content', severity: 'info', ip: '10.0.0.88' },
  { id: 10, timestamp: '2025-08-14 16:42:11', user: 'Admin User', action: 'Created new user account: sarah@example.com', type: 'user', severity: 'info', ip: '192.168.1.1' },
]);

const filteredLogs = computed(() => {
  return logs.value.filter(log => {
    const matchesSearch = !search.value ||
      log.action.toLowerCase().includes(search.value.toLowerCase()) ||
      log.user.toLowerCase().includes(search.value.toLowerCase());
    const matchesType = !typeFilter.value || log.type === typeFilter.value;
    const matchesSeverity = !severityFilter.value || log.severity === severityFilter.value;
    return matchesSearch && matchesType && matchesSeverity;
  });
});

function typeClass(type: string) {
  const map: Record<string, string> = {
    auth: 'bg-blue-500/10 text-blue-500',
    content: 'bg-green-500/10 text-green-500',
    settings: 'bg-purple-500/10 text-purple-500',
    user: 'bg-amber-500/10 text-amber-500',
  };
  return map[type] || 'bg-muted text-muted-foreground';
}

function severityClass(severity: string) {
  const map: Record<string, string> = {
    info: 'bg-blue-500/10 text-blue-500',
    warning: 'bg-amber-500/10 text-amber-500',
    critical: 'bg-red-500/10 text-red-500',
  };
  return map[severity] || 'bg-muted text-muted-foreground';
}
</script>
