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
      <!-- Greeting & Overview Bar -->
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-2">
        <div class="flex items-center gap-4">
          <Avatar class="h-14 w-14 ring-2 ring-primary/20 ring-offset-2 ring-offset-background">
            <AvatarImage :src="String(overview?.user?.profile_photo_url || '')" :alt="overview?.user?.name" />
            <AvatarFallback class="text-lg font-semibold bg-primary/10 text-primary">
              {{ overview?.user?.name?.charAt(0)?.toUpperCase() || '?' }}
            </AvatarFallback>
          </Avatar>
          <div>
            <h1 class="text-2xl font-bold text-foreground">
              {{ greeting }}, {{ overview?.user?.display_name || overview?.user?.name?.split(' ')[0] || 'Admin' }}!
            </h1>
            <p class="text-sm text-muted-foreground mt-0.5">
              {{ currentDateFormatted }} &middot; {{ currentTime }}
            </p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <!-- Celebration badges -->
          <Badge v-if="overview?.is_birthday" variant="outline" class="border-pink-300 bg-pink-500/10 text-pink-600 dark:text-pink-400 gap-1.5 py-1.5 px-3">
            🎂 Happy Birthday!
          </Badge>
          <Badge v-if="overview?.join_anniversary" variant="outline" class="border-amber-300 bg-amber-500/10 text-amber-600 dark:text-amber-400 gap-1.5 py-1.5 px-3">
            🎉 Work Anniversary!
          </Badge>
          <!-- Profile Completion -->
          <div v-if="overview?.user?.profile_completion !== undefined" class="hidden sm:flex items-center gap-2 bg-card border border-border rounded-lg px-3 py-2">
            <div class="relative w-10 h-10">
              <svg class="w-10 h-10 -rotate-90" viewBox="0 0 36 36">
                <circle cx="18" cy="18" r="15.5" fill="none" stroke="currentColor" stroke-width="2.5" class="text-muted/30" />
                <circle cx="18" cy="18" r="15.5" fill="none" stroke="currentColor" stroke-width="2.5" class="text-primary" stroke-linecap="round"
                  :stroke-dasharray="`${(overview.user.profile_completion / 100) * 97.4} 97.4`" />
              </svg>
              <span class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-foreground">{{ overview.user.profile_completion }}%</span>
            </div>
            <div class="text-xs">
              <div class="font-medium text-foreground">Profile</div>
              <div class="text-muted-foreground">Complete</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 gap-4 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
        <!-- Loading skeleton -->
        <template v-if="loadingStats">
          <Card v-for="i in 8" :key="i" class="animate-pulse">
            <CardHeader>
              <div class="h-4 w-24 bg-muted rounded" />
              <div class="h-8 w-16 bg-muted rounded mt-2" />
            </CardHeader>
            <CardFooter class="flex-col items-start gap-1.5">
              <div class="h-3 w-32 bg-muted rounded" />
            </CardFooter>
          </Card>
        </template>

        <!-- Real stat cards with trends -->
        <template v-else>
          <Card v-for="stat in statsCards" :key="stat.label" class="group relative overflow-hidden hover:shadow-md transition-shadow">
            <CardHeader>
              <div class="flex items-center justify-between">
                <CardDescription class="text-xs font-medium uppercase tracking-wide">{{ stat.label }}</CardDescription>
                <div :class="['w-10 h-10 rounded-xl flex items-center justify-center', stat.bgColor]">
                  <component :is="stat.icon" class="size-5" :class="stat.iconColor" />
                </div>
              </div>
              <CardTitle class="text-3xl font-bold tabular-nums mt-1">
                {{ stat.value }}
              </CardTitle>
            </CardHeader>
            <CardFooter class="flex-col items-start gap-1">
              <div v-if="stat.trend !== null" class="flex items-center gap-1.5 text-xs">
                <span :class="[
                  'flex items-center gap-0.5 font-semibold px-1.5 py-0.5 rounded-full',
                  stat.trend > 0 ? 'text-emerald-600 bg-emerald-500/10' : stat.trend < 0 ? 'text-red-600 bg-red-500/10' : 'text-muted-foreground bg-muted'
                ]">
                  <IconTrendingUp v-if="stat.trend > 0" class="size-3" />
                  <IconTrendingDown v-else-if="stat.trend < 0" class="size-3" />
                  <IconMinus v-else class="size-3" />
                  {{ Math.abs(stat.trend) }}%
                </span>
                <span class="text-muted-foreground">vs last month</span>
              </div>
              <div v-else class="text-xs text-muted-foreground">{{ stat.description }}</div>
            </CardFooter>
            <!-- Decorative gradient -->
            <div :class="['absolute top-0 right-0 w-24 h-24 rounded-full -mr-8 -mt-8 opacity-[0.07]', stat.decorColor]" />
          </Card>
        </template>
      </div>

      <!-- Charts Row -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Users Chart -->
        <Card>
          <CardHeader>
            <div class="flex items-center justify-between">
              <div>
                <CardTitle class="text-base">User Growth</CardTitle>
                <CardDescription>New registrations over 6 months</CardDescription>
              </div>
              <Badge variant="outline" class="gap-1">
                <IconUsers class="size-3" />
                {{ rawStats?.users || 0 }} total
              </Badge>
            </div>
          </CardHeader>
          <CardContent>
            <div v-if="loadingStats" class="h-44 animate-pulse bg-muted/50 rounded-lg" />
            <div v-else class="h-44 flex items-end gap-2">
              <div v-for="(bar, idx) in usersChartData" :key="idx" class="flex-1 flex flex-col items-center gap-1">
                <span class="text-[10px] font-medium text-foreground tabular-nums">{{ bar.count }}</span>
                <div
                  class="w-full rounded-t-md bg-primary/80 hover:bg-primary transition-colors relative group/bar"
                  :style="{ height: `${bar.percentage}%`, minHeight: bar.count > 0 ? '8px' : '2px' }"
                >
                  <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-popover border text-foreground text-[10px] px-2 py-1 rounded shadow-md opacity-0 group-hover/bar:opacity-100 transition whitespace-nowrap z-10">
                    {{ bar.label }}: {{ bar.count }}
                  </div>
                </div>
                <span class="text-[10px] text-muted-foreground">{{ bar.shortLabel }}</span>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Enquiries Chart -->
        <Card>
          <CardHeader>
            <div class="flex items-center justify-between">
              <div>
                <CardTitle class="text-base">Enquiry Trends</CardTitle>
                <CardDescription>Customer enquiries over 6 months</CardDescription>
              </div>
              <Badge variant="outline" class="gap-1">
                <IconMail class="size-3" />
                {{ rawStats?.enquiries || 0 }} total
              </Badge>
            </div>
          </CardHeader>
          <CardContent>
            <div v-if="loadingStats" class="h-44 animate-pulse bg-muted/50 rounded-lg" />
            <div v-else class="h-44 flex items-end gap-2">
              <div v-for="(bar, idx) in enquiriesChartData" :key="idx" class="flex-1 flex flex-col items-center gap-1">
                <span class="text-[10px] font-medium text-foreground tabular-nums">{{ bar.count }}</span>
                <div
                  class="w-full rounded-t-md bg-blue-500/80 hover:bg-blue-500 transition-colors relative group/bar"
                  :style="{ height: `${bar.percentage}%`, minHeight: bar.count > 0 ? '8px' : '2px' }"
                >
                  <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-popover border text-foreground text-[10px] px-2 py-1 rounded shadow-md opacity-0 group-hover/bar:opacity-100 transition whitespace-nowrap z-10">
                    {{ bar.label }}: {{ bar.count }}
                  </div>
                </div>
                <span class="text-[10px] text-muted-foreground">{{ bar.shortLabel }}</span>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      <!-- Middle Row: Activity + System Health -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Recent Activity (takes 2 cols) -->
        <Card class="lg:col-span-2">
          <CardHeader>
            <div class="flex items-center justify-between">
              <div>
                <CardTitle class="text-base">Recent Activity</CardTitle>
                <CardDescription>Latest actions across your platform</CardDescription>
              </div>
              <Button variant="ghost" size="icon" class="h-8 w-8" @click="fetchActivity">
                <IconRefresh class="size-4" />
              </Button>
            </div>
          </CardHeader>
          <CardContent>
            <!-- Loading -->
            <div v-if="loadingActivity" class="space-y-3">
              <div v-for="i in 5" :key="i" class="flex items-start gap-3 animate-pulse">
                <div class="w-9 h-9 bg-muted rounded-lg shrink-0" />
                <div class="flex-1 space-y-2">
                  <div class="h-4 w-3/4 bg-muted rounded" />
                  <div class="h-3 w-1/2 bg-muted rounded" />
                </div>
              </div>
            </div>

            <!-- Empty -->
            <div v-else-if="activityItems.length === 0" class="text-center py-10 text-muted-foreground text-sm">
              <IconActivity class="size-10 mx-auto mb-2 opacity-30" />
              No recent activity found.
            </div>

            <!-- Activity list -->
            <div v-else class="space-y-1 max-h-[400px] overflow-y-auto pr-1">
              <div
                v-for="item in activityItems"
                :key="item.id"
                class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-muted/50 transition-colors"
              >
                <div :class="['w-9 h-9 rounded-lg flex items-center justify-center shrink-0 text-sm font-semibold', typeBadgeClasses(item.type)]">
                  {{ typeEmoji(item.type) }}
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-center gap-2">
                    <p class="text-sm font-medium text-foreground truncate">{{ item.message }}</p>
                    <Badge variant="secondary" class="shrink-0 text-[10px] px-1.5 py-0 h-4">{{ item.type }}</Badge>
                  </div>
                  <p v-if="item.detail" class="text-xs text-muted-foreground truncate mt-0.5">{{ item.detail }}</p>
                  <div class="flex items-center gap-2 mt-1 text-[11px] text-muted-foreground">
                    <span v-if="item.user" class="font-medium">{{ item.user }}</span>
                    <span v-if="item.user && item.time">&middot;</span>
                    <span>{{ item.time }}</span>
                  </div>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- System Health + Recent Logins -->
        <div class="space-y-4">
          <!-- System Health -->
          <Card>
            <CardHeader>
              <CardTitle class="text-base flex items-center gap-2">
                <IconServer class="size-4 text-primary" />
                System Health
              </CardTitle>
            </CardHeader>
            <CardContent class="space-y-3">
              <template v-if="loadingOverview">
                <div v-for="i in 4" :key="i" class="flex justify-between items-center animate-pulse">
                  <div class="h-3 w-20 bg-muted rounded" />
                  <div class="h-3 w-16 bg-muted rounded" />
                </div>
              </template>
              <template v-else-if="overview?.system_health">
                <div class="flex justify-between items-center text-sm">
                  <span class="text-muted-foreground">PHP Version</span>
                  <Badge variant="outline">{{ overview.system_health.php_version }}</Badge>
                </div>
                <div class="flex justify-between items-center text-sm">
                  <span class="text-muted-foreground">Laravel</span>
                  <Badge variant="outline">{{ overview.system_health.laravel_version }}</Badge>
                </div>
                <div class="flex justify-between items-center text-sm">
                  <span class="text-muted-foreground">Storage</span>
                  <Badge variant="outline">{{ overview.system_health.storage_used }}</Badge>
                </div>
                <div class="flex justify-between items-center text-sm">
                  <span class="text-muted-foreground">Database</span>
                  <Badge variant="outline">{{ overview.system_health.db_size }}</Badge>
                </div>
              </template>
            </CardContent>
          </Card>

          <!-- Recent Logins -->
          <Card>
            <CardHeader>
              <CardTitle class="text-base flex items-center gap-2">
                <IconShieldCheck class="size-4 text-primary" />
                Recent Logins
              </CardTitle>
            </CardHeader>
            <CardContent class="space-y-2">
              <template v-if="loadingOverview">
                <div v-for="i in 3" :key="i" class="flex gap-3 items-center animate-pulse">
                  <div class="w-8 h-8 bg-muted rounded-lg" />
                  <div class="flex-1 space-y-1.5">
                    <div class="h-3 w-24 bg-muted rounded" />
                    <div class="h-2.5 w-20 bg-muted rounded" />
                  </div>
                </div>
              </template>
              <template v-else-if="overview?.recent_logins?.length">
                <div
                  v-for="(login, idx) in overview.recent_logins"
                  :key="idx"
                  class="flex items-start gap-3 p-2 rounded-lg hover:bg-muted/50 transition-colors"
                >
                  <div class="w-8 h-8 rounded-lg bg-muted flex items-center justify-center shrink-0">
                    <IconDeviceDesktop v-if="login.device === 'Desktop'" class="size-4 text-muted-foreground" />
                    <IconDeviceMobile v-else class="size-4 text-muted-foreground" />
                  </div>
                  <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-foreground truncate">{{ login.browser }} on {{ login.platform }}</p>
                    <p class="text-[10px] text-muted-foreground">{{ login.ip_address }} &middot; {{ formatLoginTime(login.logged_in_at) }}</p>
                  </div>
                </div>
              </template>
              <div v-else class="text-center text-xs text-muted-foreground py-4">No login history</div>
            </CardContent>
          </Card>
        </div>
      </div>

      <!-- Quick Actions -->
      <Card>
        <CardHeader>
          <CardTitle class="text-base">Quick Actions</CardTitle>
          <CardDescription>Jump to common admin tasks</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <button
              v-for="action in quickActions"
              :key="action.to"
              @click="$router.push(action.to)"
              class="flex flex-col items-center gap-2 p-4 rounded-xl border border-border hover:border-primary/30 hover:bg-primary/5 transition-all group"
            >
              <div :class="['w-11 h-11 rounded-xl flex items-center justify-center transition-colors group-hover:scale-110 transition-transform', action.bgColor]">
                <span class="text-xl">{{ action.emoji }}</span>
              </div>
              <span class="text-xs font-medium text-foreground group-hover:text-primary transition-colors text-center leading-tight">{{ action.label }}</span>
            </button>
          </div>
        </CardContent>
      </Card>

      <!-- Additional Charts Row -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Reviews Chart -->
        <Card>
          <CardHeader>
            <div class="flex items-center justify-between">
              <div>
                <CardTitle class="text-base">Reviews Analytics</CardTitle>
                <CardDescription>Customer reviews over 6 months</CardDescription>
              </div>
              <Badge variant="outline" class="gap-1">
                <IconStar class="size-3" />
                {{ rawStats?.reviews || 0 }} total
              </Badge>
            </div>
          </CardHeader>
          <CardContent>
            <div v-if="loadingStats" class="h-44 animate-pulse bg-muted/50 rounded-lg" />
            <div v-else class="h-44 flex items-end gap-2">
              <div v-for="(bar, idx) in reviewsChartData" :key="idx" class="flex-1 flex flex-col items-center gap-1">
                <span class="text-[10px] font-medium text-foreground tabular-nums">{{ bar.count }}</span>
                <div
                  class="w-full rounded-t-md bg-amber-500/80 hover:bg-amber-500 transition-colors relative group/bar"
                  :style="{ height: `${bar.percentage}%`, minHeight: bar.count > 0 ? '8px' : '2px' }"
                >
                  <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-popover border text-foreground text-[10px] px-2 py-1 rounded shadow-md opacity-0 group-hover/bar:opacity-100 transition whitespace-nowrap z-10">
                    {{ bar.label }}: {{ bar.count }}
                  </div>
                </div>
                <span class="text-[10px] text-muted-foreground">{{ bar.shortLabel }}</span>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Content Distribution Pie/Bar Chart -->
        <Card>
          <CardHeader>
            <div class="flex items-center justify-between">
              <div>
                <CardTitle class="text-base">Content Distribution</CardTitle>
                <CardDescription>Breakdown of content types</CardDescription>
              </div>
            </div>
          </CardHeader>
          <CardContent>
            <div v-if="loadingStats" class="h-44 animate-pulse bg-muted/50 rounded-lg" />
            <div v-else class="space-y-3">
              <div v-for="item in contentDistribution" :key="item.label" class="space-y-1">
                <div class="flex justify-between text-xs">
                  <span class="text-foreground font-medium">{{ item.label }}</span>
                  <span class="text-muted-foreground">{{ item.count }}</span>
                </div>
                <div class="h-2 bg-muted rounded-full overflow-hidden">
                  <div 
                    :class="['h-full rounded-full transition-all', item.color]" 
                    :style="{ width: `${item.percentage}%` }"
                  />
                </div>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      <!-- Recent Users Table -->
      <Card>
        <CardHeader>
          <div class="flex items-center justify-between">
            <div>
              <CardTitle class="text-base">Recent Users</CardTitle>
              <CardDescription>Latest registered accounts</CardDescription>
            </div>
            <Button variant="outline" size="sm" @click="$router.push('/admin/users')">
              View All
            </Button>
          </div>
        </CardHeader>
        <CardContent>
          <div v-if="loadingUsers" class="space-y-3">
            <div v-for="i in 5" :key="i" class="flex gap-3 animate-pulse">
              <div class="w-10 h-10 bg-muted rounded-full" />
              <div class="flex-1 space-y-2">
                <div class="h-4 w-1/3 bg-muted rounded" />
                <div class="h-3 w-1/2 bg-muted rounded" />
              </div>
            </div>
          </div>
          <div v-else-if="recentUsers.length === 0" class="text-center py-8 text-muted-foreground text-sm">
            <IconUsers class="size-10 mx-auto mb-2 opacity-30" />
            No users found.
          </div>
          <div v-else class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b border-border">
                  <th class="text-left py-3 px-2 font-medium text-muted-foreground">User</th>
                  <th class="text-left py-3 px-2 font-medium text-muted-foreground">Email</th>
                  <th class="text-left py-3 px-2 font-medium text-muted-foreground">Role</th>
                  <th class="text-left py-3 px-2 font-medium text-muted-foreground">Joined</th>
                  <th class="text-left py-3 px-2 font-medium text-muted-foreground">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in recentUsers" :key="user.id" class="border-b border-border/50 hover:bg-muted/30 transition-colors">
                  <td class="py-3 px-2">
                    <div class="flex items-center gap-3">
                      <Avatar class="h-8 w-8">
                        <AvatarImage :src="user.avatar" :alt="user.name" />
                        <AvatarFallback class="text-xs bg-primary/10 text-primary">
                          {{ user.name?.charAt(0)?.toUpperCase() || '?' }}
                        </AvatarFallback>
                      </Avatar>
                      <span class="font-medium text-foreground">{{ user.name }}</span>
                    </div>
                  </td>
                  <td class="py-3 px-2 text-muted-foreground">{{ user.email }}</td>
                  <td class="py-3 px-2">
                    <Badge :variant="user.role === 'admin' || user.role === 'super-admin' ? 'default' : 'secondary'" class="text-[10px]">
                      {{ user.role || 'user' }}
                    </Badge>
                  </td>
                  <td class="py-3 px-2 text-muted-foreground text-xs">{{ formatUserDate(user.created_at) }}</td>
                  <td class="py-3 px-2">
                    <span :class="['inline-flex items-center gap-1 text-xs font-medium', user.email_verified_at ? 'text-emerald-600' : 'text-amber-600']">
                      <span :class="['w-2 h-2 rounded-full', user.email_verified_at ? 'bg-emerald-500' : 'bg-amber-500']" />
                      {{ user.email_verified_at ? 'Verified' : 'Pending' }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>

      <!-- Server Metrics -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Performance Metrics -->
        <Card>
          <CardHeader>
            <CardTitle class="text-base flex items-center gap-2">
              <IconActivity class="size-4 text-primary" />
              Performance
            </CardTitle>
          </CardHeader>
          <CardContent class="space-y-4">
            <div class="space-y-2">
              <div class="flex justify-between text-xs">
                <span class="text-muted-foreground">Response Time</span>
                <span class="text-foreground font-medium">{{ overview?.system_health?.response_time || '45ms' }}</span>
              </div>
              <div class="h-2 bg-muted rounded-full overflow-hidden">
                <div class="h-full w-[25%] bg-emerald-500 rounded-full" />
              </div>
            </div>
            <div class="space-y-2">
              <div class="flex justify-between text-xs">
                <span class="text-muted-foreground">Memory Usage</span>
                <span class="text-foreground font-medium">{{ overview?.system_health?.memory_usage || '62%' }}</span>
              </div>
              <div class="h-2 bg-muted rounded-full overflow-hidden">
                <div class="h-full w-[62%] bg-blue-500 rounded-full" />
              </div>
            </div>
            <div class="space-y-2">
              <div class="flex justify-between text-xs">
                <span class="text-muted-foreground">CPU Load</span>
                <span class="text-foreground font-medium">{{ overview?.system_health?.cpu_load || '28%' }}</span>
              </div>
              <div class="h-2 bg-muted rounded-full overflow-hidden">
                <div class="h-full w-[28%] bg-violet-500 rounded-full" />
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Traffic Sources -->
        <Card>
          <CardHeader>
            <CardTitle class="text-base flex items-center gap-2">
              <IconChartBar class="size-4 text-primary" />
              Traffic Sources
            </CardTitle>
          </CardHeader>
          <CardContent class="space-y-3">
            <div v-for="source in trafficSources" :key="source.name" class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="text-base">{{ source.icon }}</span>
                <span class="text-sm text-foreground">{{ source.name }}</span>
              </div>
              <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-foreground">{{ source.percentage }}%</span>
                <div class="w-16 h-1.5 bg-muted rounded-full overflow-hidden">
                  <div :class="['h-full rounded-full', source.color]" :style="{ width: `${source.percentage}%` }" />
                </div>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Top Pages -->
        <Card>
          <CardHeader>
            <CardTitle class="text-base flex items-center gap-2">
              <IconFileDescription class="size-4 text-primary" />
              Top Pages
            </CardTitle>
          </CardHeader>
          <CardContent class="space-y-2">
            <div v-for="(page, idx) in topPages" :key="page.path" class="flex items-center justify-between py-1.5">
              <div class="flex items-center gap-2">
                <span class="text-xs text-muted-foreground font-mono">{{ idx + 1 }}.</span>
                <span class="text-sm text-foreground truncate max-w-[120px]">{{ page.name }}</span>
              </div>
              <span class="text-xs text-muted-foreground">{{ page.views }} views</span>
            </div>
          </CardContent>
        </Card>
      </div>
    </template>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
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
  IconTrendingUp,
  IconTrendingDown,
  IconMinus,
  IconServer,
  IconShieldCheck,
  IconDeviceDesktop,
  IconDeviceMobile,
  IconActivity,
  IconChartBar,
  IconFileDescription,
} from '@tabler/icons-vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';
import {
  Card,
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
const loadingOverview = ref(true);
const loadingUsers = ref(true);
const error = ref<string | null>(null);

interface ChartDataPoint {
  label: string;
  count: number;
}

interface DashboardStats {
  services: number;
  products: number;
  bundles: number;
  blogs: number;
  enquiries: number;
  reviews: number;
  users: number;
  chat_sessions: number;
  trends?: {
    users_this_month: number;
    users_last_month: number;
    enquiries_this_month: number;
    enquiries_last_month: number;
    reviews_this_month: number;
    reviews_last_month: number;
  };
  users_chart?: ChartDataPoint[];
  enquiries_chart?: ChartDataPoint[];
  reviews_chart?: ChartDataPoint[];
}

interface RecentUser {
  id: number;
  name: string;
  email: string;
  avatar?: string;
  role?: string;
  created_at: string;
  email_verified_at?: string;
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

interface OverviewData {
  user: {
    name: string;
    display_name?: string;
    profile_photo_url?: string;
    profile_completion?: number;
    member_since?: string;
  };
  is_birthday: boolean;
  join_anniversary: boolean;
  system_health: {
    php_version: string;
    laravel_version: string;
    storage_used: string;
    db_size: string;
  };
  recent_logins: Array<{
    ip_address: string;
    device: string;
    browser: string;
    platform: string;
    logged_in_at: string;
  }>;
}

const rawStats = ref<DashboardStats | null>(null);
const activityItems = ref<ActivityItem[]>([]);
const overview = ref<OverviewData | null>(null);
const recentUsers = ref<RecentUser[]>([]);

// --- Live clock ---
const currentTime = ref('');
const currentDateFormatted = ref('');
let clockInterval: ReturnType<typeof setInterval>;

function updateClock() {
  const now = new Date();
  currentTime.value = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
  currentDateFormatted.value = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
}

const greeting = computed(() => {
  const hour = new Date().getHours();
  if (hour < 12) return 'Good Morning';
  if (hour < 17) return 'Good Afternoon';
  return 'Good Evening';
});

// --- Chart data processing ---
function processChartData(data: ChartDataPoint[] | undefined) {
  if (!data || data.length === 0) return [];
  const max = Math.max(...data.map(d => d.count), 1);
  return data.map(d => ({
    label: d.label,
    shortLabel: d.label.substring(0, 3),
    count: d.count,
    percentage: Math.round((d.count / max) * 100),
  }));
}

const usersChartData = computed(() => processChartData(rawStats.value?.users_chart));
const enquiriesChartData = computed(() => processChartData(rawStats.value?.enquiries_chart));
const reviewsChartData = computed(() => processChartData(rawStats.value?.reviews_chart));

// --- Content distribution for pie chart ---
const contentDistribution = computed(() => {
  const s = rawStats.value;
  if (!s) return [];
  const items = [
    { label: 'Services', count: s.services, color: 'bg-violet-500' },
    { label: 'Products', count: s.products, color: 'bg-cyan-500' },
    { label: 'Bundles', count: s.bundles, color: 'bg-teal-500' },
    { label: 'Blog Posts', count: s.blogs, color: 'bg-rose-500' },
    { label: 'Enquiries', count: s.enquiries, color: 'bg-emerald-500' },
  ];
  const total = items.reduce((sum, i) => sum + i.count, 0);
  return items.map(i => ({
    ...i,
    percentage: total > 0 ? Math.round((i.count / total) * 100) : 0,
  }));
});

// --- Traffic sources (static demo data) ---
const trafficSources = [
  { name: 'Direct', icon: '🔗', percentage: 40, color: 'bg-blue-500' },
  { name: 'Search', icon: '🔍', percentage: 30, color: 'bg-emerald-500' },
  { name: 'Social', icon: '📱', percentage: 20, color: 'bg-pink-500' },
  { name: 'Referral', icon: '🔄', percentage: 10, color: 'bg-amber-500' },
];

// --- Top pages (static demo data) ---
const topPages = [
  { name: 'Home', path: '/', views: 2453 },
  { name: 'Services', path: '/services', views: 1842 },
  { name: 'Products', path: '/products', views: 1205 },
  { name: 'Contact', path: '/contact', views: 976 },
  { name: 'About', path: '/about', views: 654 },
];

// --- Format user date ---
function formatUserDate(dateStr: string): string {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

// --- Trend calculation ---
function calcTrend(current: number, previous: number): number {
  if (previous === 0) return current > 0 ? 100 : 0;
  return Math.round(((current - previous) / previous) * 100);
}

// --- Stat cards with trends ---
const statsCards = computed(() => {
  const s = rawStats.value;
  if (!s) return [];
  const t = s.trends;

  return [
    {
      label: 'Total Users',
      value: s.users,
      icon: IconUsers,
      bgColor: 'bg-blue-500/10',
      iconColor: 'text-blue-600',
      decorColor: 'bg-blue-500',
      description: 'Registered accounts',
      trend: t ? calcTrend(t.users_this_month, t.users_last_month) : null,
    },
    {
      label: 'Enquiries',
      value: s.enquiries,
      icon: IconMail,
      bgColor: 'bg-emerald-500/10',
      iconColor: 'text-emerald-600',
      decorColor: 'bg-emerald-500',
      description: 'Customer messages',
      trend: t ? calcTrend(t.enquiries_this_month, t.enquiries_last_month) : null,
    },
    {
      label: 'Reviews',
      value: s.reviews,
      icon: IconStar,
      bgColor: 'bg-amber-500/10',
      iconColor: 'text-amber-600',
      decorColor: 'bg-amber-500',
      description: 'Customer feedback',
      trend: t ? calcTrend(t.reviews_this_month, t.reviews_last_month) : null,
    },
    {
      label: 'Services',
      value: s.services,
      icon: IconBriefcase,
      bgColor: 'bg-violet-500/10',
      iconColor: 'text-violet-600',
      decorColor: 'bg-violet-500',
      description: 'Active listings',
      trend: null,
    },
    {
      label: 'Products',
      value: s.products,
      icon: IconPackage,
      bgColor: 'bg-cyan-500/10',
      iconColor: 'text-cyan-600',
      decorColor: 'bg-cyan-500',
      description: 'In catalog',
      trend: null,
    },
    {
      label: 'Bundles',
      value: s.bundles,
      icon: IconStack2,
      bgColor: 'bg-teal-500/10',
      iconColor: 'text-teal-600',
      decorColor: 'bg-teal-500',
      description: 'Package deals',
      trend: null,
    },
    {
      label: 'Blog Posts',
      value: s.blogs,
      icon: IconArticle,
      bgColor: 'bg-rose-500/10',
      iconColor: 'text-rose-600',
      decorColor: 'bg-rose-500',
      description: 'Published articles',
      trend: null,
    },
    {
      label: 'Chat Sessions',
      value: s.chat_sessions,
      icon: IconMessageCircle,
      bgColor: 'bg-indigo-500/10',
      iconColor: 'text-indigo-600',
      decorColor: 'bg-indigo-500',
      description: 'AI conversations',
      trend: null,
    },
  ];
});

// --- Activity helpers ---
function typeBadgeClasses(type: string): string {
  const map: Record<string, string> = {
    enquiry: 'bg-blue-500/10',
    product: 'bg-green-500/10',
    service: 'bg-indigo-500/10',
    blog: 'bg-purple-500/10',
    review: 'bg-amber-500/10',
    user: 'bg-cyan-500/10',
    chat: 'bg-pink-500/10',
    bundle: 'bg-teal-500/10',
  };
  return map[type?.toLowerCase()] ?? 'bg-muted';
}

function typeEmoji(type: string): string {
  const map: Record<string, string> = {
    enquiry: '📩',
    product: '📦',
    service: '🚀',
    blog: '✍️',
    review: '⭐',
    user: '👤',
    chat: '💬',
    bundle: '📁',
  };
  return map[type?.toLowerCase()] ?? '🔔';
}

function formatLoginTime(dateStr: string): string {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  const now = new Date();
  const diffMs = now.getTime() - d.getTime();
  const diffMins = Math.floor(diffMs / 60000);
  if (diffMins < 1) return 'Just now';
  if (diffMins < 60) return `${diffMins}m ago`;
  const diffHours = Math.floor(diffMins / 60);
  if (diffHours < 24) return `${diffHours}h ago`;
  const diffDays = Math.floor(diffHours / 24);
  if (diffDays < 7) return `${diffDays}d ago`;
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
}

// --- Quick Actions ---
const quickActions = [
  { to: '/admin/services', label: 'Services', emoji: '🚀', bgColor: 'bg-blue-500/10' },
  { to: '/admin/products', label: 'Products', emoji: '📦', bgColor: 'bg-green-500/10' },
  { to: '/admin/bundles', label: 'Bundles', emoji: '📁', bgColor: 'bg-teal-500/10' },
  { to: '/admin/blogs', label: 'Blogs', emoji: '✍️', bgColor: 'bg-purple-500/10' },
  { to: '/admin/enquiries', label: 'Enquiries', emoji: '💬', bgColor: 'bg-pink-500/10' },
  { to: '/admin/reviews', label: 'Reviews', emoji: '⭐', bgColor: 'bg-amber-500/10' },
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
  } catch {
    activityItems.value = [];
  } finally {
    loadingActivity.value = false;
  }
}

async function fetchOverview() {
  loadingOverview.value = true;
  try {
    const data = await get<any>('/admin/dashboard/overview');
    overview.value = (data as any).data ?? data;
  } catch {
    overview.value = null;
  } finally {
    loadingOverview.value = false;
  }
}

async function fetchUsers() {
  loadingUsers.value = true;
  try {
    const data = await get<any>('/admin/users?limit=10&sort=created_at&order=desc');
    const users = (data as any).data ?? data ?? [];
    recentUsers.value = Array.isArray(users) ? users.slice(0, 10) : [];
  } catch {
    recentUsers.value = [];
  } finally {
    loadingUsers.value = false;
  }
}

async function fetchAll() {
  error.value = null;
  try {
    await Promise.all([fetchStats(), fetchActivity(), fetchOverview(), fetchUsers()]);
  } catch (e: any) {
    error.value = e.message || 'Something went wrong';
  }
}

onMounted(() => {
  updateClock();
  clockInterval = setInterval(updateClock, 30000);
  fetchAll();
});

onUnmounted(() => {
  clearInterval(clockInterval);
});
</script>
