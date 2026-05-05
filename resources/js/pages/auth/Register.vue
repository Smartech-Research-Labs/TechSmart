<script setup lang="ts">
import SignupForm from '@/components/SignupForm.vue';
import AuthPageLayout from '@/layouts/AuthPageLayout.vue';
</script>

<template>
  <AuthPageLayout>
    <div class="w-full max-w-sm md:max-w-4xl">
      <SignupForm />
    </div>
  </AuthPageLayout>
</template>