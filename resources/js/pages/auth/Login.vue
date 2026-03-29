<script setup lang="ts">
import AuthPageLayout from '@/layouts/AuthPageLayout.vue';
import LoginForm from '@/components/LoginForm.vue';
</script>

<template>
  <AuthPageLayout>
    <div class="w-full max-w-sm md:max-w-4xl">
      <LoginForm />
    </div>
  </AuthPageLayout>
</template>
