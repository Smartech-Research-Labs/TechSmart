<template>
  <section class="page-cta">
    <div class="container mx-auto px-6 text-center">
      <p class="page-eyebrow">{{ eyebrow }}</p>
      <h2>{{ title }}</h2>
      <p class="page-cta-copy">{{ text }}</p>
      <div class="flex flex-wrap justify-center gap-3">
        <router-link to="/contact" class="page-cta-primary">Talk to our team</router-link>
        <router-link to="/packages" class="page-cta-secondary">View packages</router-link>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
withDefaults(defineProps<{ eyebrow?: string; title?: string; text?: string }>(), {
  eyebrow: 'Get started',
  title: 'Let’s build something useful for your business',
  text: 'Tell us what you need and our Nairobi team will help you choose the right next step.',
});
</script>
