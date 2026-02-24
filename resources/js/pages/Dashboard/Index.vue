<template>
  <DashboardLayout>
    <!-- Section Cards -->
    <div
      class="*:data-[slot=card]:from-primary/5 *:data-[slot=card]:to-card dark:*:data-[slot=card]:bg-card grid grid-cols-1 gap-4 *:data-[slot=card]:bg-gradient-to-t *:data-[slot=card]:shadow-xs @xl/main:grid-cols-2 @5xl/main:grid-cols-4"
    >
      <Card v-for="stat in stats" :key="stat.label" class="@container/card">
        <CardHeader>
          <CardDescription>{{ stat.label }}</CardDescription>
          <CardTitle class="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
            {{ stat.value }}
          </CardTitle>
          <CardAction>
            <Badge variant="outline">
              <IconTrendingUp v-if="stat.trendUp" />
              <IconTrendingDown v-else />
              {{ stat.trend }}
            </Badge>
          </CardAction>
        </CardHeader>
        <CardFooter class="flex-col items-start gap-1.5 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            {{ stat.trendText }}
            <IconTrendingUp v-if="stat.trendUp" class="size-4" />
            <IconTrendingDown v-else class="size-4" />
          </div>
          <div class="text-muted-foreground">
            {{ stat.description }}
          </div>
        </CardFooter>
      </Card>
    </div>

    <!-- Tabs: Activity + Saved Items -->
    <Tabs default-value="activity" class="w-full flex-col justify-start gap-6">
      <div class="flex items-center justify-between">
        <TabsList>
          <TabsTrigger value="activity">
            Recent Activity
          </TabsTrigger>
          <TabsTrigger value="saved">
            Saved Items
          </TabsTrigger>
          <TabsTrigger value="actions">
            Quick Actions
          </TabsTrigger>
        </TabsList>
      </div>

      <TabsContent value="activity" class="flex flex-col gap-4">
        <Card>
          <CardContent class="pt-6">
            <div class="space-y-4">
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
        <div v-if="savedItems.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <Card v-for="item in savedItems" :key="item.id" class="group cursor-pointer hover:shadow-md transition-shadow">
            <CardHeader>
              <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-primary/20 to-accent/20 rounded-xl flex items-center justify-center text-2xl shrink-0">
                  {{ item.icon }}
                </div>
                <div class="flex-1 min-w-0">
                  <CardTitle class="text-sm font-semibold truncate group-hover:text-primary transition">{{ item.name }}</CardTitle>
                  <CardDescription>{{ item.type }}</CardDescription>
                  <p class="text-sm font-bold text-primary mt-1">{{ item.price }}</p>
                </div>
              </div>
            </CardHeader>
          </Card>
        </div>
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
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import {
  IconTrendingUp,
  IconTrendingDown,
  IconHeart,
  IconMail,
  IconStar,
  IconPackage,
  IconServer,
  IconAddressBook,
  IconUserCircle,
} from '@tabler/icons-vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { useAuthStore } from '@/stores/auth';
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

const enquiriesCount = ref(3);
const reviewsCount = ref(2);
const wishlistCount = ref(3);

const memberSince = computed(() => {
  const date = authStore.user?.created_at ? new Date(authStore.user.created_at) : new Date();
  return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
});

const stats = computed(() => [
  {
    label: 'Wishlist Items',
    value: wishlistCount.value,
    trend: '+2',
    trendUp: true,
    trendText: 'Items added recently',
    description: 'Your saved products & services',
  },
  {
    label: 'Enquiries',
    value: enquiriesCount.value,
    trend: '1 pending',
    trendUp: false,
    trendText: 'Awaiting response',
    description: 'Your submitted enquiries',
  },
  {
    label: 'Reviews',
    value: reviewsCount.value,
    trend: '4.5 avg',
    trendUp: true,
    trendText: 'Great average rating',
    description: 'Reviews you have posted',
  },
  {
    label: 'Active Projects',
    value: 1,
    trend: 'Active',
    trendUp: true,
    trendText: 'Projects in progress',
    description: `Member since ${memberSince.value}`,
  },
]);

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

const recentActivity = [
  { id: 1, text: 'Enquiry submitted for Web Development', time: '2 hours ago', icon: IconMail, bgColor: 'bg-blue-500/10', iconColor: 'text-blue-500' },
  { id: 2, text: 'Review posted for Cloud Infrastructure', time: '1 day ago', icon: IconStar, bgColor: 'bg-amber-500/10', iconColor: 'text-amber-500' },
  { id: 3, text: 'Added Startup Bundle to wishlist', time: '3 days ago', icon: IconHeart, bgColor: 'bg-pink-500/10', iconColor: 'text-pink-500' },
  { id: 4, text: 'Profile information updated', time: '1 week ago', icon: IconUserCircle, bgColor: 'bg-green-500/10', iconColor: 'text-green-500' },
];

const savedItems = ref([
  { id: 1, name: 'Web Development', type: 'Service', price: 'R 2,999', icon: '🚀' },
  { id: 2, name: 'Cloud Solutions', type: 'Service', price: 'R 4,999', icon: '☁️' },
  { id: 3, name: 'Startup Bundle', type: 'Bundle', price: 'R 8,999', icon: '📦' },
]);

onMounted(async () => {
  // TODO: Fetch real dashboard stats from API
});
</script>
