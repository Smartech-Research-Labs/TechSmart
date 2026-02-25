<script setup lang="ts">
import AuthPageLayout from '@/layouts/AuthPageLayout.vue';
import SignupForm from '@/components/SignupForm.vue';
</script>

<template>
  <AuthPageLayout>
    <div class="w-full max-w-sm md:max-w-4xl">
      <SignupForm />
    </div>
  </AuthPageLayout>
</template>