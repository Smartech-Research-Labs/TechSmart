<script setup lang="ts">
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import AuthPageLayout from '@/layouts/AuthPageLayout.vue';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const error = ref('');
const processing = ref(true);

onMounted(async () => {
  const token = route.query.token as string;
  const errorParam = route.query.error as string;

  if (errorParam) {
    error.value = 'Google authentication failed. Please try again.';
    processing.value = false;
    return;
  }

  if (!token) {
    error.value = 'No authentication token received.';
    processing.value = false;
    return;
  }

  try {
    // Store the token
    authStore.token = token;
    localStorage.setItem('token', token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    // Fetch the user data
    await authStore.fetchUser();

    // Redirect to dashboard
    router.push('/dashboard');
  } catch (err: any) {
    error.value = 'Authentication failed. Please try again.';
    processing.value = false;
  }
});
</script>

<template>
  <AuthPageLayout>
    <div class="mx-auto flex w-full flex-col items-center justify-center space-y-6 sm:w-[380px]">
      <!-- Loading state -->
      <div v-if="processing" class="flex flex-col items-center gap-4">
        <svg class="w-10 h-10 animate-spin text-primary" viewBox="0 0 24 24" fill="none">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        <p class="text-muted-foreground">Completing Google sign-in...</p>
      </div>

      <!-- Error state -->
      <div v-else-if="error" class="flex flex-col items-center gap-4 text-center">
        <div class="w-12 h-12 rounded-full bg-destructive/10 flex items-center justify-center">
          <svg class="w-6 h-6 text-destructive" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
        <p class="text-destructive">{{ error }}</p>
        <router-link
          to="/login"
          class="text-sm text-primary hover:underline underline-offset-4"
        >
          Back to login
        </router-link>
      </div>
    </div>
  </AuthPageLayout>
</template>
