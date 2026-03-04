<script setup lang="ts">
import { computed, ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { IconLogout, IconUserCircle, IconMoon, IconSun, IconDeviceDesktop, IconBell } from '@tabler/icons-vue'
import { Separator } from '@/components/ui/separator'
import { SidebarTrigger } from '@/components/ui/sidebar'
import { Button } from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { useAuthStore } from '@/stores/auth'
import { useAppearance } from '@/composables/useAppearance'
import { useApi } from '@/composables/useApi'

defineProps<{
  title?: string
}>()

const router = useRouter()
const authStore = useAuthStore()
const { appearance, updateAppearance } = useAppearance()

const user = computed(() => authStore.user)

const avatarSrc = computed(() => String(user.value?.profile_photo_url || ''))

const themeIcon = computed(() => {
  if (appearance.value === 'dark') return IconMoon
  if (appearance.value === 'light') return IconSun
  return IconDeviceDesktop
})

function cycleTheme() {
  const themes = ['light', 'dark', 'system'] as const
  const idx = themes.indexOf(appearance.value as any)
  updateAppearance(themes[(idx + 1) % themes.length])
}

async function handleLogout() {
  await authStore.logout()
  router.push('/login')
}

// Notifications
const { get, post } = useApi()
const notifications = ref<any[]>([])
const unreadCount = ref(0)
const showNotifications = ref(false)

const isAdmin = computed(() => {
  const roles = user.value?.roles?.map((r: any) => r.name) || []
  return roles.includes('admin') || roles.includes('super-admin') || roles.includes('superadmin')
})

async function fetchNotifications() {
  if (!isAdmin.value) return
  try {
    const data = await get<any>('/admin/notifications')
    notifications.value = data.notifications || []
    unreadCount.value = data.unread_count || 0
  } catch { /* ignore */ }
}

async function markAllRead() {
  try {
    await post('/admin/notifications/read-all', {})
    unreadCount.value = 0
    notifications.value = notifications.value.map(n => ({ ...n, read: true }))
  } catch { /* ignore */ }
}

onMounted(() => {
  fetchNotifications()
  // Poll every 30 seconds
  setInterval(fetchNotifications, 30000)
})
</script>

<template>
  <header
    class="flex h-(--header-height) shrink-0 items-center gap-2 border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-(--header-height)"
  >
    <div class="flex w-full items-center gap-1 px-4 lg:gap-2 lg:px-6">
      <SidebarTrigger class="-ml-1" />
      <Separator
        orientation="vertical"
        class="mx-2 data-[orientation=vertical]:h-4"
      />
      <h1 class="text-base font-medium">
        {{ title || 'Dashboard' }}
      </h1>

      <!-- Right side actions -->
      <div class="ml-auto flex items-center gap-2">
        <!-- Theme toggle -->
        <Button variant="ghost" size="icon" class="h-8 w-8" @click="cycleTheme" :title="`Theme: ${appearance}`">
          <component :is="themeIcon" class="size-4" />
        </Button>

        <!-- Notification bell (admin only) -->
        <div v-if="isAdmin" class="relative">
          <Button variant="ghost" size="icon" class="h-8 w-8 relative" @click="showNotifications = !showNotifications">
            <IconBell class="size-4" />
            <span v-if="unreadCount > 0" class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-destructive text-white text-[10px] font-bold rounded-full flex items-center justify-center">
              {{ unreadCount > 9 ? '9+' : unreadCount }}
            </span>
          </Button>

          <!-- Notifications dropdown -->
          <div
            v-if="showNotifications"
            class="absolute right-0 top-10 w-80 bg-popover border border-border rounded-lg shadow-lg z-50 overflow-hidden"
          >
            <div class="flex items-center justify-between px-4 py-3 border-b border-border">
              <span class="text-sm font-semibold">Notifications</span>
              <button v-if="unreadCount > 0" @click="markAllRead" class="text-xs text-primary hover:underline">Mark all read</button>
            </div>
            <div class="max-h-72 overflow-y-auto">
              <div v-if="notifications.length === 0" class="py-8 text-center text-muted-foreground text-sm">No notifications</div>
              <div
                v-for="n in notifications.slice(0, 15)"
                :key="n.id"
                :class="['px-4 py-3 border-b border-border/50 last:border-0 text-sm', !n.read ? 'bg-primary/5' : '']"
              >
                <p class="text-foreground text-xs">{{ n.message }}</p>
                <p class="text-muted-foreground text-[10px] mt-1">{{ n.item_name }} · {{ n.time }}</p>
              </div>
            </div>
          </div>
        </div>

        <Separator orientation="vertical" class="mx-1 data-[orientation=vertical]:h-4" />

        <!-- User dropdown -->
        <DropdownMenu>
          <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="relative h-8 gap-2 px-2">
              <Avatar class="h-7 w-7">
                <AvatarImage :src="avatarSrc" :alt="user?.name" />
                <AvatarFallback class="text-xs">
                  {{ user?.name?.charAt(0)?.toUpperCase() || '?' }}
                </AvatarFallback>
              </Avatar>
              <span class="hidden text-sm font-medium sm:inline-block">{{ user?.name || 'User' }}</span>
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent class="w-56" align="end">
            <DropdownMenuLabel class="font-normal">
              <div class="flex flex-col space-y-1">
                <p class="text-sm font-medium">{{ user?.name }}</p>
                <p class="text-xs text-muted-foreground">{{ user?.email }}</p>
              </div>
            </DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuGroup>
              <DropdownMenuItem @click="router.push('/dashboard/profile')">
                <IconUserCircle class="mr-2 size-4" />
                Profile
              </DropdownMenuItem>
            </DropdownMenuGroup>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="handleLogout" class="text-destructive focus:text-destructive">
              <IconLogout class="mr-2 size-4" />
              Log out
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
    </div>
  </header>
</template>
