<template>
  <div id="app" class="min-h-screen bg-background text-foreground">
    <!-- Global Loading Indicator -->
    <LoadingIndicator />

    <RouterView />
    
    <!-- Toast Notifications -->
    <ToastContainer />
    
    <!-- Chat Widget (shown on all pages for authenticated users) -->
    <ChatWidget v-if="authStore.isAuthenticated" />
  </div>
</template>

<script setup lang="ts">
import { defineAsyncComponent, onMounted } from 'vue';
import { RouterView } from 'vue-router';
import LoadingIndicator from '@/components/shared/LoadingIndicator.vue';
import ToastContainer from '@/components/shared/ToastContainer.vue';
import { initializeTheme } from '@/composables/useAppearance';
import { initializeThemeColors, useThemeColors } from '@/composables/useThemeColors';
import { useAuthStore } from '@/stores/auth';

// Chat (and its socket.io client) is only needed by signed-in users, so it loads on demand
const ChatWidget = defineAsyncComponent(() => import('@/components/shared/ChatWidget.vue'));

// Initialize theme before mount (SSR-safe)
initializeTheme();

// Instant theme color application from localStorage (no flash)
initializeThemeColors();

const authStore = useAuthStore();

// Activate reactive theme colour syncing from CMS settings
useThemeColors();

onMounted(async () => {
  // Initialize auth if token exists
  if (authStore.token && !authStore.user) {
    await authStore.fetchUser().catch(() => {
      console.error('Failed to fetch user on mount');
    });
  }

  // Initialize socket connection if authenticated
  if (authStore.isAuthenticated) {
    const { useChatStore } = await import('@/stores/chat');
    useChatStore().initializeSocket(authStore.user?.id);
  }
});
</script>

<style>
#app {
  font-family: var(--font-sans), system-ui, -apple-system, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
