<script setup lang="ts">
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { IconLogout, IconUserCircle, IconMoon, IconSun, IconDeviceDesktop, IconBell, IconTrash, IconCheck, IconChecks } from '@tabler/icons-vue'
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
import { useNotificationStore } from '@/stores/notifications'
import { useAppearance } from '@/composables/useAppearance'

defineProps<{
  title?: string
}>()

const router = useRouter()
const authStore = useAuthStore()
const notifStore = useNotificationStore()
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
  notifStore.stopPolling()
  notifStore.disconnectSocket()
  await authStore.logout()
  router.push('/login')
}

// Notification panel state
const showNotifications = ref(false)
const notifTab = ref<'all' | 'unread'>('all')

const isAdmin = computed(() => {
  const roles = user.value?.roles?.map((r: any) => r.name) || []
  return roles.includes('admin') || roles.includes('super-admin') || roles.includes('superadmin')
})

const displayedNotifications = computed(() => {
  const list = notifTab.value === 'unread' ? notifStore.unreadNotifications : notifStore.sortedNotifications
  return list.slice(0, 20)
})

function getNotifIcon(type: string) {
  switch (type) {
    case 'Enquiry': return '📩'
    case 'Review': return '⭐'
    case 'Chat': return '💬'
    case 'Wishlist': return '❤️'
    case 'Newsletter': return '📧'
    default: return '🔔'
  }
}

// Close dropdown on outside click
function onClickOutside(e: MouseEvent) {
  const el = document.getElementById('notif-dropdown-wrapper')
  if (el && !el.contains(e.target as Node)) {
    showNotifications.value = false
  }
}

onMounted(() => {
  if (isAdmin.value) {
    notifStore.startPolling(30000)
    notifStore.initSocket()
  }
  document.addEventListener('click', onClickOutside)
})

onUnmounted(() => {
  notifStore.stopPolling()
  document.removeEventListener('click', onClickOutside)
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
        <div v-if="isAdmin" id="notif-dropdown-wrapper" class="relative">
          <Button variant="ghost" size="icon" class="h-8 w-8 relative" @click.stop="showNotifications = !showNotifications">
            <IconBell class="size-4" />
            <span v-if="notifStore.unreadCount > 0" class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-destructive text-white text-[10px] font-bold rounded-full flex items-center justify-center animate-pulse">
              {{ notifStore.unreadCount > 9 ? '9+' : notifStore.unreadCount }}
            </span>
          </Button>

          <!-- Notification Dropdown -->
          <Transition
            enter-active-class="transition ease-out duration-150"
            enter-from-class="opacity-0 scale-95 -translate-y-1"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 -translate-y-1"
          >
            <div
              v-if="showNotifications"
              class="absolute right-0 top-10 w-96 bg-popover border border-border rounded-xl shadow-xl z-50 overflow-hidden"
            >
              <!-- Header -->
              <div class="flex items-center justify-between px-4 py-3 border-b border-border bg-muted/30">
                <span class="text-sm font-semibold text-foreground">Notifications</span>
                <div class="flex items-center gap-2">
                  <button v-if="notifStore.unreadCount > 0" @click="notifStore.markAllRead()" class="text-[10px] text-primary hover:underline flex items-center gap-1">
                    <IconChecks class="size-3" /> Mark all read
                  </button>
                  <button v-if="notifStore.notifications.length > 0" @click="notifStore.deleteAllNotifications()" class="text-[10px] text-destructive hover:underline flex items-center gap-1">
                    <IconTrash class="size-3" /> Clear all
                  </button>
                </div>
              </div>

              <!-- Tabs -->
              <div class="flex border-b border-border">
                <button
                  @click="notifTab = 'all'"
                  :class="['flex-1 py-2 text-xs font-medium transition', notifTab === 'all' ? 'text-primary border-b-2 border-primary' : 'text-muted-foreground hover:text-foreground']"
                >
                  All ({{ notifStore.notifications.length }})
                </button>
                <button
                  @click="notifTab = 'unread'"
                  :class="['flex-1 py-2 text-xs font-medium transition', notifTab === 'unread' ? 'text-primary border-b-2 border-primary' : 'text-muted-foreground hover:text-foreground']"
                >
                  Unread ({{ notifStore.unreadCount }})
                </button>
              </div>

              <!-- Notification List -->
              <div class="max-h-80 overflow-y-auto">
                <div v-if="displayedNotifications.length === 0" class="py-10 text-center">
                  <span class="text-2xl block mb-2">🔔</span>
                  <p class="text-muted-foreground text-sm">No notifications</p>
                </div>
                <div
                  v-for="n in displayedNotifications"
                  :key="n.id"
                  :class="['group flex items-start gap-3 px-4 py-3 border-b border-border/50 last:border-0 hover:bg-muted/50 transition cursor-pointer', !n.read ? 'bg-primary/5' : '']"
                  @click="!n.read && notifStore.markAsRead(n.id)"
                >
                  <span class="text-lg mt-0.5 flex-shrink-0">{{ getNotifIcon(n.item_type) }}</span>
                  <div class="flex-1 min-w-0">
                    <p class="text-foreground text-xs leading-relaxed">{{ n.message }}</p>
                    <p class="text-muted-foreground text-[10px] mt-1">{{ n.time }}</p>
                  </div>
                  <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition flex-shrink-0">
                    <button
                      v-if="n.read"
                      @click.stop="notifStore.markAsUnread(n.id)"
                      class="p-1 text-muted-foreground hover:text-foreground rounded transition"
                      title="Mark as unread"
                    >
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <button
                      v-else
                      @click.stop="notifStore.markAsRead(n.id)"
                      class="p-1 text-muted-foreground hover:text-primary rounded transition"
                      title="Mark as read"
                    >
                      <IconCheck class="size-3" />
                    </button>
                    <button
                      @click.stop="notifStore.deleteNotification(n.id)"
                      class="p-1 text-muted-foreground hover:text-destructive rounded transition"
                      title="Delete"
                    >
                      <IconTrash class="size-3" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </Transition>
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
