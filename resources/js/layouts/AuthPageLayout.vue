<template>
  <div class="min-h-screen flex flex-col text-foreground" style="background-color: #262626;">
    <!-- Auth Header -->
    <header class="sticky top-0 z-30 border-b backdrop-blur supports-[backdrop-filter]:bg-black/40" style="background-color: rgba(38, 38, 38, 0.95);">
      <div class="container mx-auto flex h-14 items-center justify-between px-4">
        <router-link to="/" class="flex items-center gap-2 group">
          <img
            v-if="settings?.logo_path"
            :src="`/storage/${settings.logo_path}`"
            alt="Logo"
            class="h-8 w-auto"
          />
          <div v-else class="w-8 h-8 bg-gradient-to-br from-primary to-primary/70 rounded-lg flex items-center justify-center">
            <span class="text-primary-foreground font-bold text-sm">TS</span>
          </div>
          <span class="text-lg font-bold text-white group-hover:text-primary transition-colors">{{ settings?.site_name || 'OmniviaTech' }}</span>
        </router-link>

        <div class="flex items-center gap-2">
          <Button variant="ghost" size="icon" class="h-8 w-8" @click="cycleTheme" :title="`Theme: ${appearance}`">
            <IconSun v-if="appearance === 'light'" class="size-4" />
            <IconMoon v-else-if="appearance === 'dark'" class="size-4" />
            <IconDeviceDesktop v-else class="size-4" />
          </Button>
          <router-link v-if="showLogin" to="/login">
            <Button variant="ghost" size="sm">Sign in</Button>
          </router-link>
          <router-link v-if="showRegister" to="/register">
            <Button variant="outline" size="sm">Sign up</Button>
          </router-link>
        </div>
      </div>
    </header>

    <!-- Content -->
    <main class="flex flex-1 flex-col items-center justify-center p-6 md:p-10">
      <slot />
    </main>

    <!-- Auth Footer -->
    <footer class="border-t py-4" style="background-color: rgba(38, 38, 38, 0.95); border-color: rgba(255,255,255,0.1);">
      <div class="container mx-auto flex flex-col items-center justify-between gap-2 px-4 text-xs text-white/60 sm:flex-row">
        <p>&copy; {{ new Date().getFullYear() }} {{ settings?.site_name || 'OmniviaTech' }}. All rights reserved.</p>
        <div class="flex items-center gap-4">
          <router-link to="/" class="hover:text-white transition-colors">Home</router-link>
          <router-link to="/contact" class="hover:text-white transition-colors">Contact</router-link>
          <router-link to="/faqs" class="hover:text-white transition-colors">FAQs</router-link>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { IconSun, IconMoon, IconDeviceDesktop } from '@tabler/icons-vue'
import { Button } from '@/components/ui/button'
import { useAppearance } from '@/composables/useAppearance'
import { useCmsStore } from '@/stores/cms'
import type { Appearance } from '@/types'

const route = useRoute()
const cmsStore = useCmsStore()
const { appearance, updateAppearance } = useAppearance()

const settings = computed(() => cmsStore.homeData?.settings)

onMounted(async () => {
  if (!cmsStore.homeData) {
    await cmsStore.fetchHomeData().catch(() => {})
  }
})

const showLogin = computed(() => route.name !== 'login')
const showRegister = computed(() => route.name !== 'register')

const themes: Appearance[] = ['light', 'dark', 'system']

function cycleTheme() {
  const idx = themes.indexOf(appearance.value)
  updateAppearance(themes[(idx + 1) % themes.length])
}
</script>
