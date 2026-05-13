<template>
  <div class="min-h-screen flex flex-col text-foreground" style="background-color: #ffffff;">
    <!-- Site Header (GlobalMegaMenu) -->
    <GlobalMegaMenu />

    <!-- Content -->
    <main class="flex flex-1 flex-col items-center justify-center p-6 md:p-10">
      <slot />
    </main>

    <!-- Auth Footer -->
    <footer class="border-t py-4" style="background-color: #ffffff; border-color: rgba(255,255,255,0.1);">
      <div class="container mx-auto flex flex-col items-center justify-between gap-2 px-4 text-xs text-gray-500 sm:flex-row">
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
import GlobalMegaMenu from '@/components/GlobalMegaMenu.vue'
import { useCmsStore } from '@/stores/cms'

const cmsStore = useCmsStore()

const settings = computed(() => cmsStore.homeData?.settings as any)

onMounted(async () => {
  if (!cmsStore.homeData) {
    await cmsStore.fetchHomeData().catch(() => { /* ignore errors */ })
  }
})
</script>
