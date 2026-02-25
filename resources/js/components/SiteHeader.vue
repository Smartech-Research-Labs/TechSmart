<script setup lang="ts">
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { IconLogout, IconUserCircle, IconMoon, IconSun, IconDeviceDesktop } from '@tabler/icons-vue'
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

defineProps<{
  title?: string
}>()

const router = useRouter()
const authStore = useAuthStore()
const { appearance, updateAppearance } = useAppearance()

const user = computed(() => authStore.user)

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

        <Separator orientation="vertical" class="mx-1 data-[orientation=vertical]:h-4" />

        <!-- User dropdown -->
        <DropdownMenu>
          <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="relative h-8 gap-2 px-2">
              <Avatar class="h-7 w-7">
                <AvatarImage :src="user?.profile_photo_url" :alt="user?.name" />
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
