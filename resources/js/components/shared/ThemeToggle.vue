<template>
  <button
    @click="cycleTheme"
    class="relative inline-flex items-center justify-center w-9 h-9 rounded-lg transition-colors hover:bg-white/10"
    :title="`Theme: ${appearance}`"
    aria-label="Toggle theme"
  >
    <!-- Sun (light) -->
    <svg
      v-if="resolvedAppearance === 'light'"
      class="w-[18px] h-[18px] text-yellow-500"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      viewBox="0 0 24 24"
    >
      <circle cx="12" cy="12" r="5" />
      <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
    </svg>
    <!-- Moon (dark) -->
    <svg
      v-else-if="resolvedAppearance === 'dark'"
      class="w-[18px] h-[18px] text-primary"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      viewBox="0 0 24 24"
    >
      <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
    </svg>
    <!-- System -->
    <svg
      v-else
      class="w-[18px] h-[18px] text-muted-foreground"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      viewBox="0 0 24 24"
    >
      <rect x="2" y="3" width="20" height="14" rx="2" />
      <path d="M8 21h8M12 17v4" />
    </svg>
  </button>
</template>

<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import type { Appearance } from '@/types';

const { appearance, resolvedAppearance, updateAppearance } = useAppearance();

const themes: Appearance[] = ['light', 'dark', 'system'];

function cycleTheme() {
  const currentIndex = themes.indexOf(appearance.value);
  const next = themes[(currentIndex + 1) % themes.length];
  updateAppearance(next);
}
</script>
