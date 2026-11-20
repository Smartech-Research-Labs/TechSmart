<template>
  <section class="page-split page-bare" :class="{ 'page-split-reverse': reverse }">
    <div class="page-split-panel">
      <p class="page-eyebrow">{{ eyebrow }}</p>
      <h2>{{ title }}</h2>
      <p class="page-split-copy">{{ text }}</p>
      <ul v-if="points?.length" class="page-checks">
        <li v-for="point in points" :key="point">
          <span class="page-check" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12l5 5L20 7" /></svg>
          </span>
          {{ point }}
        </li>
      </ul>
      <component
        :is="isExternal ? 'a' : 'router-link'"
        v-if="ctaTo"
        :to="isExternal ? undefined : ctaTo"
        :href="isExternal ? ctaTo : undefined"
        class="page-btn"
      >
        {{ ctaLabel }}
        <span class="page-btn-arrow" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 6l6 6-6 6" /></svg>
        </span>
      </component>
    </div>

    <div class="page-split-media">
      <img :src="image" :alt="title" loading="lazy" />
      <div class="page-glass-stack">
        <div class="page-glass page-glass-stat">
          <span class="page-glass-label">{{ statLabel }}</span>
          <div class="page-glass-row">
            <span class="page-glass-ring" aria-hidden="true"><PageIcon :icon="statIcon" /></span>
            <strong>{{ statValue }}</strong>
            <small v-if="statUnit">{{ statUnit }}</small>
          </div>
        </div>
        <div v-if="note" class="page-glass page-glass-note">
          <PageIcon :icon="noteIcon" />
          <span>{{ note }}</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import PageIcon from '@/components/PageIcon.vue';

const props = withDefaults(
  defineProps<{
    eyebrow: string;
    title: string;
    text: string;
    points?: string[];
    image: string;
    ctaLabel?: string;
    ctaTo?: string;
    statLabel: string;
    statValue: string | number;
    statUnit?: string;
    statIcon?: string;
    note?: string;
    noteIcon?: string;
    reverse?: boolean;
  }>(),
  { ctaLabel: 'Get Started', ctaTo: '/contact', statIcon: '⚡', noteIcon: '🚀' },
);

const isExternal = computed(() => /^(https?:|mailto:|tel:|#)/.test(props.ctaTo || ''));
</script>
