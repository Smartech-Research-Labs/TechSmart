<script setup lang="ts">
import LoginForm from '@/components/LoginForm.vue';
import AuthPageLayout from '@/layouts/AuthPageLayout.vue';
</script>

<template>
  <AuthPageLayout>
    <div class="w-full max-w-sm md:max-w-4xl">
      <LoginForm />
    </div>
  </AuthPageLayout>
</template>
