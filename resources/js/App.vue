<template>
  <div id="app" class="min-h-screen bg-background text-foreground">
    <RouterView />
    
    <!-- Toast Notifications -->
    <ToastContainer />
    
    <!-- Chat Widget (shown on all pages for authenticated users) -->
    <ChatWidget v-if="authStore.isAuthenticated" />
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { RouterView } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { useChatStore } from '@/stores/chat';
import { initializeTheme } from '@/composables/useAppearance';
import ToastContainer from '@/components/shared/ToastContainer.vue';
import ChatWidget from '@/components/shared/ChatWidget.vue';

// Initialize theme before mount (SSR-safe)
initializeTheme();

const authStore = useAuthStore();
const chatStore = useChatStore();

onMounted(async () => {
  // Initialize auth if token exists
  if (authStore.token && !authStore.user) {
    await authStore.fetchUser().catch(() => {
      console.error('Failed to fetch user on mount');
    });
  }

  // Initialize socket connection if authenticated
  if (authStore.isAuthenticated) {
    chatStore.initializeSocket(authStore.user?.id);
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
