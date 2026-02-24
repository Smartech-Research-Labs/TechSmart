<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { SelectIcon, SelectTrigger, type SelectTriggerProps } from "reka-ui"
import { ChevronDown } from "lucide-vue-next"
import { cn } from "@/lib/utils"

const props = defineProps<SelectTriggerProps & { class?: HTMLAttributes["class"], size?: "sm" | "default" }>()
</script>

<template>
  <SelectTrigger
    v-bind="props"
    :class="cn(
      'flex w-full items-center justify-between gap-2 rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs ring-offset-background data-placeholder:text-muted-foreground focus:outline-none focus:ring-1 focus:ring-ring disabled:cursor-not-allowed disabled:opacity-50 [&>span]:line-clamp-1 whitespace-nowrap',
      props.size === 'sm' && 'h-8 text-xs',
      props.class,
    )"
  >
    <slot />
    <SelectIcon as-child>
      <ChevronDown class="size-4 shrink-0 opacity-50" />
    </SelectIcon>
  </SelectTrigger>
</template>
