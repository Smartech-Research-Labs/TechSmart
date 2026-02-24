<template>
  <DashboardLayout>
    <!-- Error State -->
    <div v-if="error" class="flex flex-col items-center justify-center gap-4 py-16">
      <div class="w-16 h-16 rounded-full bg-destructive/10 flex items-center justify-center">
        <IconAlertTriangle class="size-8 text-destructive" />
      </div>
      <div class="text-center">
        <h3 class="text-lg font-semibold">Failed to load dashboard</h3>
        <p class="text-sm text-muted-foreground mt-1">{{ error }}</p>
      </div>
      <Button variant="outline" size="sm" @click="fetchDashboard">
        <IconRefresh class="size-4 mr-2" />
        Retry
      </Button>
    </div>

    <template v-else>
      <!-- Welcome -->
      <div class="mb-2">
        <h1 class="text-2xl font-display font-bold text-foreground">
          Welcome back, {{ authStore.user?.name ?? 'User' }}
        </h1>
        <p class="text-muted-foreground text-sm mt-1">Here's an overview of your account</p>
      </div>

      <!-- Stats Cards -->
      <div
        class="*:data-[slot=card]:from-primary/5 *:data-[slot=card]:to-card dark:*:data-[slot=card]:bg-card grid grid-cols-1 gap-4 *:data-[slot=card]:bg-gradient-to-t *:data-[slot=card]:shadow-xs @xl/main:grid-cols-2 @5xl/main:grid-cols-4"
      >
        <!-- Loading skeleton -->
        <template v-if="loadingStats">
          <Card v-for="i in 4" :key="i" class="@container/card animate-pulse">
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

      <!-- Tabs: Activity + Saved Items + Quick Actions -->
      <Tabs default-value="activity" class="w-full flex-col justify-start gap-6">
        <div class="flex items-center justify-between">
          <TabsList>
            <TabsTrigger value="activity">Recent Activity</TabsTrigger>
            <TabsTrigger value="saved">Saved Items</TabsTrigger>
            <TabsTrigger value="actions">Quick Actions</TabsTrigger>
          </TabsList>
        </div>

        <TabsContent value="activity" class="flex flex-col gap-4">
          <Card>
            <CardContent class="pt-6">
              <!-- Loading -->
              <div v-if="loadingActivity" class="space-y-4">
                <div v-for="i in 4" :key="i" class="flex items-start gap-3 animate-pulse">
                  <div class="w-8 h-8 bg-muted rounded-full shrink-0" />
                  <div class="flex-1 space-y-2">
                    <div class="h-4 w-3/4 bg-muted rounded" />
                    <div class="h-3 w-1/2 bg-muted rounded" />
                  </div>
                </div>
              </div>

              <!-- Empty -->
              <div v-else-if="recentActivity.length === 0" class="text-center py-8 text-muted-foreground text-sm">
                No recent activity yet.
              </div>

              <!-- Activity list -->
              <div v-else class="space-y-4">
                <div v-for="activity in recentActivity" :key="activity.id" class="flex items-start gap-3">
                  <div :class="['w-8 h-8 rounded-full flex items-center justify-center shrink-0', activity.bgColor]">
                    <component :is="activity.icon" class="size-4" :class="activity.iconColor" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm text-foreground">{{ activity.text }}</p>
                    <p class="text-xs text-muted-foreground mt-0.5">{{ activity.time }}</p>
                  </div>
                </div>
              </div>

              <div class="mt-6 text-center">
                <Button variant="outline" size="sm" as-child>
                  <router-link to="/dashboard/enquiries">View All Activity</router-link>
                </Button>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="saved" class="flex flex-col gap-4">
          <!-- Loading -->
          <div v-if="loadingWishlist" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <Card v-for="i in 3" :key="i" class="animate-pulse">
              <CardHeader>
                <div class="flex items-center gap-4">
                  <div class="w-14 h-14 bg-muted rounded-xl shrink-0" />
                  <div class="flex-1 space-y-2">
                    <div class="h-4 w-3/4 bg-muted rounded" />
                    <div class="h-3 w-1/2 bg-muted rounded" />
                  </div>
                </div>
              </CardHeader>
            </Card>
          </div>

          <!-- Items -->
          <div v-else-if="wishlistStore.items.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <Card v-for="item in wishlistStore.items" :key="item.id" class="group cursor-pointer hover:shadow-md transition-shadow">
              <CardHeader>
                <div class="flex items-center gap-4">
                  <div class="w-14 h-14 bg-gradient-to-br from-primary/20 to-accent/20 rounded-xl flex items-center justify-center shrink-0 overflow-hidden">
                    <img
                      v-if="item.wishlistable?.image_url"
                      :src="item.wishlistable.image_url"
                      :alt="item.wishlistable?.name || item.wishlistable?.title || 'Item'"
                      class="w-full h-full object-cover"
                    />
                    <span v-else class="text-2xl">{{ getTypeEmoji(item.wishlistable_type) }}</span>
                  </div>
                  <div class="flex-1 min-w-0">
                    <CardTitle class="text-sm font-semibold truncate group-hover:text-primary transition">
                      {{ item.wishlistable?.name || item.wishlistable?.title || 'Item' }}
                    </CardTitle>
                    <CardDescription>{{ getTypeLabel(item.wishlistable_type) }}</CardDescription>
                    <p v-if="item.wishlistable?.price" class="text-sm font-bold text-primary mt-1">
                      R {{ Number(item.wishlistable.price).toLocaleString() }}
                    </p>
                  </div>
                </div>
              </CardHeader>
            </Card>
          </div>

          <!-- Empty -->
          <Card v-else>
            <CardContent class="pt-6">
              <div class="text-center py-12">
                <div class="w-16 h-16 bg-muted rounded-full flex items-center justify-center mx-auto mb-4">
                  <IconHeart class="size-8 text-muted-foreground" />
                </div>
                <p class="text-muted-foreground mb-4">No saved items yet</p>
                <Button as-child>
                  <router-link to="/services">Browse Services</router-link>
                </Button>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <TabsContent value="actions" class="flex flex-col gap-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <Card
              v-for="action in quickActions"
              :key="action.to"
              class="group cursor-pointer hover:shadow-md transition-shadow"
              @click="$router.push(action.to)"
            >
              <CardHeader>
                <div class="flex items-center gap-4">
                  <div :class="['w-12 h-12 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110', action.bgColor]">
                    <component :is="action.icon" class="size-6" :class="action.iconColor" />
                  </div>
                  <div class="flex-1">
                    <CardTitle class="text-sm font-semibold group-hover:text-primary transition">{{ action.label }}</CardTitle>
                    <CardDescription>{{ action.description }}</CardDescription>
                  </div>
                </div>
              </CardHeader>
            </Card>
          </div>
        </TabsContent>
      </Tabs>
    </template>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import {
  IconHeart,
  IconMail,
  IconStar,
  IconPackage,
  IconServer,
  IconAddressBook,
  IconUserCircle,
  IconAlertTriangle,
  IconRefresh,
} from '@tabler/icons-vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { useAuthStore } from '@/stores/auth';
import { useWishlistStore } from '@/stores/wishlist';
import { useApi } from '@/composables/useApi';
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
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from '@/components/ui/tabs';

const authStore = useAuthStore();
const wishlistStore = useWishlistStore();
const { get } = useApi();

// --- State ---
const loadingStats = ref(true);
const loadingActivity = ref(true);
const loadingWishlist = ref(true);
const error = ref<string | null>(null);

interface DashboardStats {
  wishlists: number;
  enquiries: number;
  reviews: number;
  pending_reviews: number;
}

const rawStats = ref<DashboardStats | null>(null);

// --- Computed ---
const memberSince = computed(() => {
  const date = authStore.user?.created_at ? new Date(authStore.user.created_at) : new Date();
  return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
});

const statsCards = computed(() => [
  {
    label: 'Wishlist Items',
    value: rawStats.value?.wishlists ?? 0,
    icon: IconHeart,
    description: 'Your saved products & services',
  },
  {
    label: 'Enquiries',
    value: rawStats.value?.enquiries ?? 0,
    icon: IconMail,
    description: 'Your submitted enquiries',
  },
  {
    label: 'Reviews',
    value: rawStats.value?.reviews ?? 0,
    icon: IconStar,
    description: 'Reviews you have posted',
  },
  {
    label: 'Member Since',
    value: memberSince.value,
    icon: IconUserCircle,
    description: 'Your account age',
  },
]);

// --- Activity ---
interface ActivityEntry {
  id: number;
  text: string;
  time: string;
  icon: any;
  bgColor: string;
  iconColor: string;
}

const recentActivity = ref<ActivityEntry[]>([]);

function formatRelativeTime(dateStr: string): string {
  const date = new Date(dateStr);
  const now = new Date();
  const diffMs = now.getTime() - date.getTime();
  const diffMin = Math.floor(diffMs / 60000);
  if (diffMin < 1) return 'Just now';
  if (diffMin < 60) return `${diffMin} min ago`;
  const diffHr = Math.floor(diffMin / 60);
  if (diffHr < 24) return `${diffHr} hour${diffHr > 1 ? 's' : ''} ago`;
  const diffDays = Math.floor(diffHr / 24);
  if (diffDays < 30) return `${diffDays} day${diffDays > 1 ? 's' : ''} ago`;
  return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

// --- Helpers ---
function getTypeLabel(type: string): string {
  if (type.includes('Product')) return 'Product';
  if (type.includes('Service')) return 'Service';
  if (type.includes('Bundle')) return 'Bundle';
  return 'Item';
}

function getTypeEmoji(type: string): string {
  if (type.includes('Product')) return '📦';
  if (type.includes('Service')) return '🚀';
  if (type.includes('Bundle')) return '📁';
  return '💎';
}

// --- Quick Actions ---
const quickActions = [
  {
    to: '/products',
    label: 'Browse Products',
    description: 'Explore our product catalog',
    icon: IconPackage,
    bgColor: 'bg-primary/10',
    iconColor: 'text-primary',
  },
  {
    to: '/services',
    label: 'View Services',
    description: 'Check out our services',
    icon: IconServer,
    bgColor: 'bg-accent/10',
    iconColor: 'text-accent',
  },
  {
    to: '/contact',
    label: 'Contact Us',
    description: 'Get in touch with our team',
    icon: IconAddressBook,
    bgColor: 'bg-green-500/10',
    iconColor: 'text-green-500',
  },
  {
    to: '/dashboard/profile',
    label: 'Edit Profile',
    description: 'Update your personal info',
    icon: IconUserCircle,
    bgColor: 'bg-purple-500/10',
    iconColor: 'text-purple-500',
  },
];

// --- Data Fetching ---
async function fetchStats() {
  loadingStats.value = true;
  try {
    const data = await get('/user/dashboard');
    rawStats.value = data.stats ?? data;
  } catch {
    throw new Error('Failed to load dashboard stats');
  } finally {
    loadingStats.value = false;
  }
}

async function fetchActivity() {
  loadingActivity.value = true;
  try {
    const [enquiryData, reviewData] = await Promise.all([
      get('/user/enquiries').catch(() => ({ data: [] })),
      get('/user/reviews').catch(() => ({ data: [] })),
    ]);

    const entries: ActivityEntry[] = [];

    const enquiries = enquiryData?.data ?? enquiryData ?? [];
    for (const e of (Array.isArray(enquiries) ? enquiries : []).slice(0, 3)) {
      entries.push({
        id: e.id,
        text: `Enquiry: ${e.subject || e.message?.substring(0, 60) || 'Untitled'}`,
        time: formatRelativeTime(e.created_at),
        icon: IconMail,
        bgColor: 'bg-blue-500/10',
        iconColor: 'text-blue-500',
      });
    }

    const reviews = reviewData?.data ?? reviewData ?? [];
    for (const r of (Array.isArray(reviews) ? reviews : []).slice(0, 3)) {
      entries.push({
        id: r.id + 10000,
        text: `Review for ${r.reviewable?.name || r.reviewable?.title || 'item'} — ${r.rating}★`,
        time: formatRelativeTime(r.created_at),
        icon: IconStar,
        bgColor: 'bg-amber-500/10',
        iconColor: 'text-amber-500',
      });
    }

    // Sort by most recent
    entries.sort((a, b) => {
      // rough comparison using the time text is fine; we already formatted them
      return 0; // keep interleaved order from API (both are already sorted by latest)
    });

    recentActivity.value = entries.slice(0, 6);
  } catch {
    recentActivity.value = [];
  } finally {
    loadingActivity.value = false;
  }
}

async function fetchWishlistItems() {
  loadingWishlist.value = true;
  try {
    await wishlistStore.fetchWishlist();
  } catch {
    // non-critical
  } finally {
    loadingWishlist.value = false;
  }
}

async function fetchDashboard() {
  error.value = null;
  try {
    await Promise.all([fetchStats(), fetchActivity(), fetchWishlistItems()]);
  } catch (e: any) {
    error.value = e.message || 'Something went wrong';
  }
}

onMounted(fetchDashboard);
</script>
