<template>
  <AdminLayout>
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
              {{ stat.change }}
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

    <!-- Recent Enquiries Table -->
    <Tabs default-value="enquiries" class="w-full flex-col justify-start gap-6">
      <div class="flex items-center justify-between">
        <TabsList>
          <TabsTrigger value="enquiries">
            Recent Enquiries
          </TabsTrigger>
          <TabsTrigger value="content">
            Content Overview
          </TabsTrigger>
          <TabsTrigger value="activity">
            Recent Activity
          </TabsTrigger>
        </TabsList>
        <div class="flex items-center gap-2">
          <Button variant="outline" size="sm" as-child>
            <router-link to="/admin/enquiries">View All</router-link>
          </Button>
        </div>
      </div>

      <TabsContent value="enquiries" class="relative flex flex-col gap-4 overflow-auto">
        <div class="overflow-hidden rounded-lg border">
          <Table>
            <TableHeader class="bg-muted sticky top-0 z-10">
              <TableRow>
                <TableHead>Name</TableHead>
                <TableHead>Subject</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Date</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="enquiry in recentEnquiries" :key="enquiry.id">
                <TableCell>
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary text-sm font-semibold">
                      {{ enquiry.name.charAt(0) }}
                    </div>
                    <span class="font-medium">{{ enquiry.name }}</span>
                  </div>
                </TableCell>
                <TableCell>{{ enquiry.subject }}</TableCell>
                <TableCell>
                  <Badge :variant="enquiry.status === 'Resolved' ? 'default' : 'outline'">
                    {{ enquiry.status }}
                  </Badge>
                </TableCell>
                <TableCell class="text-muted-foreground">{{ enquiry.date }}</TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>
      </TabsContent>

      <TabsContent value="content" class="flex flex-col gap-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <Card v-for="item in contentOverview" :key="item.label">
            <CardHeader>
              <div class="flex items-center gap-3">
                <span class="text-2xl">{{ item.emoji }}</span>
                <div>
                  <CardDescription>{{ item.label }}</CardDescription>
                  <CardTitle class="text-2xl font-semibold tabular-nums">{{ item.count }}</CardTitle>
                </div>
              </div>
            </CardHeader>
          </Card>
        </div>
      </TabsContent>

      <TabsContent value="activity" class="flex flex-col gap-4">
        <Card>
          <CardContent class="pt-6">
            <div class="space-y-4">
              <div v-for="activity in recentActivity" :key="activity.id" class="flex items-start gap-3">
                <div :class="['w-2 h-2 rounded-full mt-2 shrink-0', activity.dotColor]" />
                <div>
                  <p class="text-sm text-foreground">{{ activity.text }}</p>
                  <p class="text-xs text-muted-foreground">{{ activity.time }}</p>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>
      </TabsContent>
    </Tabs>

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

    <!-- System Status -->
    <Card>
      <CardHeader>
        <CardTitle>System Status</CardTitle>
        <CardDescription>Current health of your platform services</CardDescription>
      </CardHeader>
      <CardContent>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
          <div v-for="item in systemStatus" :key="item.label" class="flex items-center justify-between p-3 rounded-lg border">
            <span class="text-sm text-muted-foreground">{{ item.label }}</span>
            <Badge :variant="item.status === 'Online' || item.status === 'Healthy' || item.status === 'Running' || item.status === 'Active' ? 'default' : 'outline'">
              {{ item.status }}
            </Badge>
          </div>
        </div>
      </CardContent>
    </Card>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { IconTrendingUp, IconTrendingDown } from '@tabler/icons-vue';
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
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from '@/components/ui/tabs';

const stats = ref([
  {
    label: 'Total Services',
    value: 12,
    change: '+3',
    trendUp: true,
    trendText: 'Trending up this month',
    description: 'Compared to last month',
  },
  {
    label: 'Total Products',
    value: 28,
    change: '+5',
    trendUp: true,
    trendText: 'Growing catalog',
    description: 'New products added recently',
  },
  {
    label: 'Active Enquiries',
    value: 45,
    change: '+12',
    trendUp: true,
    trendText: 'Strong engagement',
    description: 'Customer interest increasing',
  },
  {
    label: 'Total Reviews',
    value: 156,
    change: 'Stable',
    trendUp: false,
    trendText: 'Steady performance',
    description: 'Review volume consistent',
  },
]);

const quickActions = [
  { to: '/admin/services', label: 'Add Service', description: 'Create new service listing', emoji: '🚀', bgColor: 'bg-blue-500/10' },
  { to: '/admin/products', label: 'Add Product', description: 'Create new product', emoji: '📦', bgColor: 'bg-green-500/10' },
  { to: '/admin/blogs', label: 'Write Blog', description: 'Create new blog post', emoji: '✍️', bgColor: 'bg-purple-500/10' },
  { to: '/admin/pages', label: 'Manage Pages', description: 'Edit website pages', emoji: '📄', bgColor: 'bg-amber-500/10' },
  { to: '/admin/enquiries', label: 'Enquiries', description: 'View customer messages', emoji: '💬', bgColor: 'bg-pink-500/10' },
  { to: '/admin/cms', label: 'CMS Editor', description: 'Edit homepage content', emoji: '🎨', bgColor: 'bg-cyan-500/10' },
];

const recentEnquiries = [
  { id: 1, name: 'John Doe', subject: 'Custom Web Development', status: 'Pending', date: 'Today' },
  { id: 2, name: 'Sarah Smith', subject: 'Enterprise Bundle', status: 'Replied', date: 'Yesterday' },
  { id: 3, name: 'Mike Johnson', subject: 'Mobile App Quote', status: 'Resolved', date: '2 days ago' },
  { id: 4, name: 'Emily Brown', subject: 'SaaS Consultation', status: 'Pending', date: '3 days ago' },
];

const systemStatus = [
  { label: 'Website', status: 'Online' },
  { label: 'Database', status: 'Healthy' },
  { label: 'API', status: 'Running' },
  { label: 'Storage', status: '62% Used' },
  { label: 'Cache', status: 'Active' },
];

const contentOverview = [
  { label: 'Services', count: 12, emoji: '🚀' },
  { label: 'Products', count: 28, emoji: '📦' },
  { label: 'Bundles', count: 6, emoji: '📁' },
  { label: 'Blog Posts', count: 18, emoji: '📝' },
  { label: 'Pages', count: 8, emoji: '📄' },
];

const recentActivity = [
  { id: 1, text: 'New enquiry from John Doe', time: '5 min ago', dotColor: 'bg-blue-500' },
  { id: 2, text: 'Product "Cloud Suite" updated', time: '1 hour ago', dotColor: 'bg-green-500' },
  { id: 3, text: 'Blog post published', time: '3 hours ago', dotColor: 'bg-purple-500' },
  { id: 4, text: 'New review (5 stars)', time: '1 day ago', dotColor: 'bg-amber-500' },
  { id: 5, text: 'Service pricing updated', time: '2 days ago', dotColor: 'bg-pink-500' },
];
</script>
