<script setup lang="ts">
import { computed } from 'vue';

interface PaginationMeta {
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
  from?: number | null;
  to?: number | null;
}

const props = defineProps<{
  meta: PaginationMeta;
  maxVisible?: number;
  showInfo?: boolean;
}>();

const emit = defineEmits<{
  (e: 'page-change', page: number): void;
}>();

const maxVisible = computed(() => props.maxVisible ?? 5);

const pages = computed(() => {
  const total = props.meta.last_page;
  const current = props.meta.current_page;
  const max = maxVisible.value;

  if (total <= max) {
    return Array.from({ length: total }, (_, i) => i + 1);
  }

  const half = Math.floor(max / 2);
  let start = Math.max(1, current - half);
  let end = start + max - 1;

  if (end > total) {
    end = total;
    start = Math.max(1, end - max + 1);
  }

  const result: (number | string)[] = [];

  if (start > 1) {
    result.push(1);
    if (start > 2) result.push('...');
  }

  for (let i = start; i <= end; i++) {
    result.push(i);
  }

  if (end < total) {
    if (end < total - 1) result.push('...');
    result.push(total);
  }

  return result;
});

function goTo(page: number) {
  if (page >= 1 && page <= props.meta.last_page && page !== props.meta.current_page) {
    emit('page-change', page);
  }
}
</script>

<template>
  <div v-if="meta.last_page > 1" class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6">
    <!-- Info -->
    <p v-if="showInfo !== false" class="text-xs text-muted-foreground">
      Showing {{ meta.from ?? 1 }}–{{ meta.to ?? meta.total }} of {{ meta.total }} results
    </p>

    <!-- Controls -->
    <div class="flex items-center gap-1">
      <!-- Prev -->
      <button
        @click="goTo(meta.current_page - 1)"
        :disabled="meta.current_page <= 1"
        class="px-3 py-2 text-xs font-medium rounded-lg border border-border text-muted-foreground hover:bg-muted transition disabled:opacity-40 disabled:cursor-not-allowed"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
      </button>

      <!-- Pages -->
      <template v-for="(page, i) in pages" :key="i">
        <span v-if="page === '...'" class="px-2 py-2 text-xs text-muted-foreground">…</span>
        <button
          v-else
          @click="goTo(page as number)"
          :class="[
            'min-w-[36px] px-3 py-2 text-xs font-medium rounded-lg transition',
            page === meta.current_page
              ? 'bg-primary text-white shadow-sm'
              : 'border border-border text-muted-foreground hover:bg-muted'
          ]"
        >
          {{ page }}
        </button>
      </template>

      <!-- Next -->
      <button
        @click="goTo(meta.current_page + 1)"
        :disabled="meta.current_page >= meta.last_page"
        class="px-3 py-2 text-xs font-medium rounded-lg border border-border text-muted-foreground hover:bg-muted transition disabled:opacity-40 disabled:cursor-not-allowed"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
      </button>
    </div>
  </div>
</template>
