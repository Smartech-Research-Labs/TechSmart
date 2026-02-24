<template>
  <AdminLayout>
    <!-- Error State -->
    <div v-if="error" class="flex flex-col items-center justify-center gap-4 py-16">
      <div class="w-16 h-16 rounded-full bg-destructive/10 flex items-center justify-center">
        <IconAlertTriangle class="size-8 text-destructive" />
      </div>
      <div class="text-center">
        <h3 class="text-lg font-semibold">Failed to load dashboard</h3>
        <p class="text-sm text-muted-foreground mt-1">{{ error }}</p>
      </div>
      <Button variant="outline" size="sm" @click="fetchAll">
        <IconRefresh class="size-4 mr-2" />
        Retry
      </Button>
    </div>

    <template v-else>
      <!-- Stats Cards -->
      <div
        class="*:data-[slot=card]:from-primary/5 *:data-[slot=card]:to-card dark:*:data-[slot=card]:bg-card grid grid-cols-1 gap-4 *:data-[slot=card]:bg-gradient-to-t *:data-[slot=card]:shadow-xs @xl/main:grid-cols-2 @5xl/main:grid-cols-4"
      >
        <!-- Loading skeleton -->
        <template v-if="loadingStats">
          <Card v-for="i in 8" :key="i" class="@container/card animate-pulse">
            <CardHeader>
              <div class="h-4 w-24 bg-muted rounded" />
              <div class="h-8 w-16 bg-muted rounded mt-2" />
            </CardHeader>
            <CardFooter class="flex-col items-start gap-1.5">
              <div class="h-3 w-32 bg-muted rounded" />
            </CardFooter>
          </Card>
        </template>

        <!-- Real stat cards -->
        <template v-else>
          <Card v-for="stat in statsCards" :key="stat.label" class="@container/card">
            <CardHeader>
              <CardDescription>{{ stat.label }}</CardDescription>
              <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
                {{ stat.value }}
              </CardTitle>
              <CardAction>
                <Badge variant="outline">
                  <component :is="stat.icon" class="size-4" />
                </Badge>
              </CardAction>
            </CardHeader>
            <CardFooter class="flex-col items-start gap-1.5 text-sm">
              <div class="text-muted-foreground">
                {{ stat.description }}
              </div>
            </CardFooter>
          </Card>
        </template>
      </div>

      <!-- Recent Activity -->
      <Card>
        <CardHeader>
          <div class="flex items-center justify-between">
            <div>
              <CardTitle>Recent Activity</CardTitle>
              <CardDescription>Latest actions across your platform</CardDescription>
            </div>
            <Button variant="outline" size="sm" @click="fetchActivity">
              <IconRefresh class="size-4" />
            </Button>
          </div>
        </CardHeader>
        <CardContent>
          <!-- Loading skeleton -->
          <div v-if="loadingActivity" class="space-y-4">
            <div v-for="i in 5" :key="i" class="flex items-start gap-3 animate-pulse">
              <div class="w-8 h-8 bg-muted rounded-full shrink-0" />
              <div class="flex-1 space-y-2">
                <div class="h-4 w-3/4 bg-muted rounded" />
                <div class="h-3 w-1/2 bg-muted rounded" />
              </div>
            </div>
          </div>

          <!-- Empty state -->
          <div v-else-if="activityItems.length === 0" class="text-center py-8 text-muted-foreground text-sm">
            No recent activity found.
          </div>

          <!-- Activity list -->
          <div v-else class="space-y-4">
            <div
              v-for="item in activityItems"
              :key="item.id"
              class="flex items-start gap-3 p-3 rounded-lg hover:bg-muted/50 transition-colors"
            >
              <div :class="['w-8 h-8 rounded-full flex items-center justify-center shrink-0 text-xs font-semibold', typeBadgeClasses(item.type)]">
                {{ typeInitial(item.type) }}
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                  <p class="text-sm font-medium text-foreground truncate">{{ item.message }}</p>
                  <Badge variant="outline" class="shrink-0 text-[10px] px-1.5 py-0">{{ item.type }}</Badge>
                </div>
                <p v-if="item.detail" class="text-xs text-muted-foreground truncate mt-0.5">{{ item.detail }}</p>
                <div class="flex items-center gap-2 mt-1 text-xs text-muted-foreground">
                  <span v-if="item.user">{{ item.user }}</span>
                  <span v-if="item.user && item.time">·</span>
                  <span>{{ item.time }}</span>
                </div>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <Card
          v-for="action in quickActions"
          :key="action.to"
          class="group cursor-pointer hover:shadow-md transition-shadow"
          @click="$router.push(action.to)"
        >
          <CardHeader>
            <div class="flex items-center gap-4">
              <div :class="['w-12 h-12 rounded-2xl flex items-center justify-center', action.bgColor]">
                <span class="text-2xl">{{ action.emoji }}</span>
              </div>
              <div>
                <CardTitle class="text-sm font-semibold group-hover:text-primary transition">{{ action.label }}</CardTitle>
                <CardDescription>{{ action.description }}</CardDescription>
              </div>
            </div>
          </CardHeader>
        </Card>
      </div>
    </template>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import {
  IconBriefcase,
  IconPackage,
  IconStack2,
  IconArticle,
  IconMail,
  IconStar,
  IconUsers,
  IconMessageCircle,
  IconAlertTriangle,
  IconRefresh,
} from '@tabler/icons-vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
  Card,
  CardAction,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card';
import { useApi } from '@/composables/useApi';

const { get } = useApi();

// --- State ---
const loadingStats = ref(true);
const loadingActivity = ref(true);
const error = ref<string | null>(null);

interface DashboardStats {
  services: number;
  products: number;
  bundles: number;
  blogs: number;
  enquiries: number;
  reviews: number;
  users: number;
  chat_sessions: number;
}

interface ActivityItem {
  id: number;
  type: string;
  message: string;
  detail?: string;
  user?: string;
  email?: string;
  time: string;
  created_at: string;
}

const rawStats = ref<DashboardStats | null>(null);
const activityItems = ref<ActivityItem[]>([]);

// --- Computed stat cards from API data ---
const statCardDefinitions = [
  { key: 'services', label: 'Total Services', icon: IconBriefcase, description: 'Active service listings' },
  { key: 'products', label: 'Total Products', icon: IconPackage, description: 'Products in catalog' },
  { key: 'bundles', label: 'Total Bundles', icon: IconStack2, description: 'Bundle packages available' },
  { key: 'blogs', label: 'Total Blogs', icon: IconArticle, description: 'Published blog posts' },
  { key: 'enquiries', label: 'Total Enquiries', icon: IconMail, description: 'Customer enquiries received' },
  { key: 'reviews', label: 'Total Reviews', icon: IconStar, description: 'Customer reviews collected' },
  { key: 'users', label: 'Total Users', icon: IconUsers, description: 'Registered user accounts' },
  { key: 'chat_sessions', label: 'Chat Sessions', icon: IconMessageCircle, description: 'AI chat conversations' },
] as const;

const statsCards = computed(() =>
  statCardDefinitions.map((def) => ({
    label: def.label,
    value: rawStats.value ? rawStats.value[def.key as keyof DashboardStats] : 0,
    icon: def.icon,
    description: def.description,
  })),
);

// --- Activity helpers ---
function typeBadgeClasses(type: string): string {
  const map: Record<string, string> = {
    enquiry: 'bg-blue-500/15 text-blue-600',
    product: 'bg-green-500/15 text-green-600',
    service: 'bg-indigo-500/15 text-indigo-600',
    blog: 'bg-purple-500/15 text-purple-600',
    review: 'bg-amber-500/15 text-amber-600',
    user: 'bg-cyan-500/15 text-cyan-600',
    chat: 'bg-pink-500/15 text-pink-600',
    bundle: 'bg-teal-500/15 text-teal-600',
  };
  return map[type?.toLowerCase()] ?? 'bg-muted text-muted-foreground';
}

function typeInitial(type: string): string {
  return (type ?? '?').charAt(0).toUpperCase();
}

// --- Quick Actions ---
const quickActions = [
  { to: '/admin/services', label: 'Manage Services', description: 'View & edit service listings', emoji: '🚀', bgColor: 'bg-blue-500/10' },
  { to: '/admin/products', label: 'Manage Products', description: 'View & edit products', emoji: '📦', bgColor: 'bg-green-500/10' },
  { to: '/admin/bundles', label: 'Manage Bundles', description: 'View & edit bundles', emoji: '📁', bgColor: 'bg-teal-500/10' },
  { to: '/admin/blogs', label: 'Manage Blogs', description: 'Write & publish blog posts', emoji: '✍️', bgColor: 'bg-purple-500/10' },
  { to: '/admin/enquiries', label: 'Enquiries', description: 'View customer messages', emoji: '💬', bgColor: 'bg-pink-500/10' },
  { to: '/admin/reviews', label: 'Reviews', description: 'Moderate customer reviews', emoji: '⭐', bgColor: 'bg-amber-500/10' },
];

// --- Data fetching ---
async function fetchStats() {
  loadingStats.value = true;
  try {
    const data = await get<{ data: DashboardStats } | DashboardStats>('/admin/dashboard/stats');
    rawStats.value = (data as any).data ?? data;
  } catch (e: any) {
    throw new Error(e?.response?.data?.message || e.message || 'Failed to load stats');
  } finally {
    loadingStats.value = false;
  }
}

async function fetchActivity() {
  loadingActivity.value = true;
  try {
    const data = await get<{ data: ActivityItem[] } | ActivityItem[]>('/admin/dashboard/activity');
    activityItems.value = Array.isArray(data) ? data : (data as any).data ?? [];
  } catch (e: any) {
    // Non-critical — keep going, show empty state
    activityItems.value = [];
  } finally {
    loadingActivity.value = false;
  }
}

async function fetchAll() {
  error.value = null;
  try {
    await Promise.all([fetchStats(), fetchActivity()]);
  } catch (e: any) {
    error.value = e.message || 'Something went wrong';
  }
}

onMounted(fetchAll);
</script>
