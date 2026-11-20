<template>
  <section class="page-image-cards">
    <div class="container mx-auto px-6">
      <div class="page-head">
        <p class="page-eyebrow">{{ eyebrow }}</p>
        <h2>{{ title }}</h2>
        <p v-if="text" class="page-head-copy">{{ text }}</p>
      </div>
      <div class="page-image-grid">
        <component
          :is="item.to ? 'router-link' : 'article'"
          v-for="item in items"
          :key="item.title"
          :to="item.to"
          class="page-image-card"
        >
          <img :src="item.image" :alt="item.title" loading="lazy" />
          <span class="page-image-shade" aria-hidden="true"></span>
          <span class="page-image-copy">
            <span class="page-chip page-chip-glass"><PageIcon :icon="item.icon" /></span>
            <span class="page-image-title">{{ item.title }}</span>
            <span class="page-image-text">{{ item.text }}</span>
          </span>
        </component>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import PageIcon from '@/components/PageIcon.vue';

export interface ImageCard {
  image: string;
  icon?: string;
  title: string;
  text: string;
  to?: string;
}

defineProps<{ eyebrow: string; title: string; text?: string; items: ImageCard[] }>();
</script>
