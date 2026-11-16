<template>
  <router-link
    :to="pkg.slug ? `/packages/${pkg.slug}` : '/packages'"
    class="group relative flex flex-col rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300"
  >
    <!-- Gradient header -->
    <div class="relative z-10 px-6 pt-7 pb-6 text-center text-white" :style="{ background: theme.gradient }">
      <span v-if="pkg.is_featured" class="absolute top-3 right-3 bg-white/25 text-white text-[10px] font-semibold tracking-widest uppercase px-2.5 py-0.5 rounded-full">
        Popular
      </span>
      <h3 class="text-2xl font-semibold uppercase tracking-wide">{{ pkg.name }}</h3>
      <div class="mx-auto my-2 h-px w-3/5 bg-white/80"></div>
      <p v-if="Number(pkg.price)" class="text-sm uppercase tracking-wide text-white/95">
        KES {{ formatPrice(pkg.price) }} / {{ pkg.price_label || 'Month' }}
      </p>
      <p v-else class="text-sm uppercase tracking-wide text-white/95">Custom quote</p>
      <!-- Notch pointing into the body -->
      <span class="absolute left-1/2 -bottom-2 w-4 h-4 -translate-x-1/2 rotate-45" :style="{ background: theme.mid }"></span>
    </div>

    <!-- White body -->
    <div class="flex-1 bg-white dark:bg-gray-900 px-6 pt-8 pb-8 text-center">
      <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">
        {{ pkg.short_description }}
      </p>
      <ul class="mx-auto w-[88%]">
        <li
          v-for="(item, idx) in (pkg.includes || []).slice(0, maxFeatures)"
          :key="idx"
          class="py-2.5 text-[11px] text-gray-600 dark:text-gray-300 border-b border-gray-400/70 dark:border-gray-600"
        >
          <template v-if="splitFeature(item).lead">
            <strong class="font-bold text-gray-900 dark:text-white">{{ splitFeature(item).lead }}</strong>
            {{ ' ' + splitFeature(item).rest }}
          </template>
          <template v-else>{{ item }}</template>
        </li>
      </ul>
    </div>

    <!-- Gradient footer -->
    <div class="relative px-6 py-7 text-center" :style="{ background: theme.gradient }">
      <!-- Notch from the body pointing into the footer -->
      <span class="absolute left-1/2 -top-2 w-4 h-4 -translate-x-1/2 rotate-45 bg-white dark:bg-gray-900"></span>
      <span
        class="relative inline-block bg-white rounded-md px-8 py-2.5 text-sm font-semibold uppercase tracking-wide shadow-md transition-transform duration-200 group-hover:scale-105"
        :style="{ color: theme.text }"
      >
        Order now
      </span>
    </div>
  </router-link>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(defineProps<{
  pkg: any;
  /** Position in the list — picks the colour theme (cyan, pink, orange, violet, repeating) */
  index?: number;
  maxFeatures?: number;
}>(), {
  index: 0,
  maxFeatures: 5,
});

// Gradient themes mirror the pricing-table design
const themes = [
  { gradient: 'linear-gradient(90deg, #22d3ee, #3b82f6)', mid: '#2eaaf2', text: '#2563eb' }, // cyan → blue
  { gradient: 'linear-gradient(90deg, #ec4899, #f43f5e)', mid: '#f0437b', text: '#e11d48' }, // pink → red
  { gradient: 'linear-gradient(90deg, #f97316, #facc15)', mid: '#faa016', text: '#ea580c' }, // orange → yellow
  { gradient: 'linear-gradient(90deg, #8b5cf6, #d946ef)', mid: '#b251f2', text: '#9333ea' }, // violet → fuchsia
];

const theme = computed(() => themes[props.index % themes.length]);

function formatPrice(price: number | string) {
  return Number(price).toLocaleString('en-KE', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

// Bold the leading quantity of a feature ("100 GB storage" -> **100** GB storage)
function splitFeature(item: string) {
  const m = /^(\S*\d\S*)\s+(.*)$/.exec(String(item ?? ''));
  return m ? { lead: m[1], rest: m[2] } : { lead: '', rest: String(item ?? '') };
}
</script>
