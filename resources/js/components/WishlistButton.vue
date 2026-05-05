<template>
  <button
    @click.prevent.stop="handleToggle"
    :title="inWishlist ? 'Remove from wishlist' : 'Add to wishlist'"
    :class="[
      'inline-flex items-center justify-center rounded-full transition-all duration-200',
      sizeClass,
      inWishlist
        ? 'bg-red-500/10 text-red-500 hover:bg-red-500/20'
        : 'bg-black/30 text-white hover:bg-black/50 backdrop-blur-sm'
    ]"
    :disabled="toggling"
  >
    <svg
      class="transition-transform duration-200"
      :class="[iconClass, toggling && 'animate-pulse']"
      :fill="inWishlist ? 'currentColor' : 'none'"
      stroke="currentColor"
      stroke-width="2"
      viewBox="0 0 24 24"
    >
      <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
    </svg>
  </button>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from '@/composables';
import { useAuthStore } from '@/stores/auth';
import { useWishlistStore } from '@/stores/wishlist';

const props = withDefaults(defineProps<{
  type: string; // 'App\\Models\\Service' or 'App\\Models\\Product'
  itemId: number;
  size?: 'sm' | 'md';
}>(), {
  size: 'sm',
});

const wishlistStore = useWishlistStore();
const authStore = useAuthStore();
const toast = useToast();
const router = useRouter();
const toggling = ref(false);

const inWishlist = computed(() => wishlistStore.isInWishlist(props.type, props.itemId));

const sizeClass = computed(() => props.size === 'sm' ? 'w-8 h-8' : 'w-10 h-10');
const iconClass = computed(() => props.size === 'sm' ? 'w-4 h-4' : 'w-5 h-5');

async function handleToggle() {
  if (!authStore.isAuthenticated) {
    toast.error('Please login to add items to your wishlist');
    router.push('/login');
    return;
  }

  toggling.value = true;
  try {
    await wishlistStore.toggleWishlist(props.type, props.itemId);
    if (inWishlist.value) {
      toast.success('Added to wishlist!');
    } else {
      toast.success('Removed from wishlist');
    }
  } catch {
    toast.error('Failed to update wishlist');
  } finally {
    toggling.value = false;
  }
}
</script>
