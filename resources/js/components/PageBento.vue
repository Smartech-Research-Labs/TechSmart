<template>
  <section class="page-bento">
    <div class="container mx-auto px-6">
      <div class="page-head">
        <p class="page-eyebrow">{{ eyebrow }}</p>
        <h2>{{ title }}</h2>
        <p v-if="text" class="page-head-copy">{{ text }}</p>
      </div>

      <div class="page-bento-grid">
        <article class="page-bento-media">
          <img :src="image" :alt="imageTitle" loading="lazy" />
          <div class="page-bento-shade" aria-hidden="true"></div>
          <h3>{{ imageTitle }}</h3>
          <div class="page-bento-stat">
            <span>{{ statLabel }}</span>
            <strong>{{ statValue }}<small v-if="statUnit">{{ statUnit }}</small></strong>
          </div>
          <svg class="page-bento-gauge" viewBox="0 0 120 120" aria-hidden="true">
            <circle cx="60" cy="60" r="46" pathLength="100" class="track" />
            <circle cx="60" cy="60" r="46" pathLength="100" class="value" :style="{ strokeDasharray: `${gauge * 0.75} 100` }" />
            <circle cx="60" cy="60" r="7" class="hub" />
          </svg>
        </article>

        <component
          :is="card.to ? 'router-link' : 'article'"
          v-for="card in cards.slice(0, 2)"
          :key="card.title"
          :to="card.to"
          class="page-bento-card"
        >
          <span class="page-chip"><PageIcon :icon="card.icon" /></span>
          <h3>{{ card.title }}</h3>
          <p>{{ card.text }}</p>
        </component>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import PageIcon from '@/components/PageIcon.vue';

export interface BentoCard {
  icon?: string;
  title: string;
  text: string;
  to?: string;
}

withDefaults(
  defineProps<{
    eyebrow: string;
    title: string;
    text?: string;
    image: string;
    imageTitle: string;
    statLabel: string;
    statValue: string | number;
    statUnit?: string;
    /** 0–100: how full the gauge arc is drawn */
    gauge?: number;
    cards: BentoCard[];
  }>(),
  { gauge: 78 },
);
</script>
