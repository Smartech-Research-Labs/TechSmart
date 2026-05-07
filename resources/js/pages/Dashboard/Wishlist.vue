<template>
  <DashboardLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-xl font-display font-bold text-foreground mb-1">My Wishlist</h1>
        <p class="text-muted-foreground">Items you've saved for later</p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="i in 3" :key="i" class="bg-card border border-border rounded-lg overflow-hidden animate-pulse">
          <div class="aspect-video bg-muted" />
          <div class="p-6 space-y-3">
            <div class="h-5 w-3/4 bg-muted rounded" />
            <div class="h-4 w-1/3 bg-muted rounded" />
            <div class="h-4 w-1/2 bg-muted rounded" />
          </div>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-card border border-border rounded-lg p-12 text-center">
        <div class="w-16 h-16 bg-destructive/10 rounded-full flex items-center justify-center mx-auto mb-4">
          <IconAlertTriangle class="size-8 text-destructive" />
        </div>
        <h3 class="text-lg font-semibold text-foreground mb-2">Failed to load wishlist</h3>
        <p class="text-muted-foreground mb-4">{{ error }}</p>
        <button
          @click="loadWishlist"
          class="inline-block bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition"
        >
          Retry
        </button>
      </div>

      <!-- Wishlist Items -->
      <div v-else-if="wishlistStore.items.length > 0">
        <div class="mb-6">
          <input v-model="searchQuery" type="text" placeholder="Search wishlist items..." class="w-full sm:w-80 px-4 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
        </div>
        <div v-if="searchQuery && filteredItems.length === 0" class="py-8 text-center text-muted-foreground">No items match your search.</div>
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="item in filteredItems"
          :key="item.id"
          class="bg-card border border-border rounded-lg overflow-hidden hover:border-primary transition group"
        >
          <div class="aspect-video bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center overflow-hidden">
            <img
              v-if="item.wishlistable?.image_url"
              :src="item.wishlistable.image_url"
              :alt="item.wishlistable?.name || item.wishlistable?.title || 'Item'"
              class="w-full h-full object-cover"
            />
            <span v-else class="text-4xl">{{ getTypeEmoji(item.wishlistable_type) }}</span>
          </div>
          <div class="p-6">
            <div class="flex items-start justify-between mb-2">
              <h3 class="text-lg font-bold text-foreground group-hover:text-primary transition">
                {{ item.wishlistable?.name || item.wishlistable?.title || 'Item' }}
              </h3>
              <button
                @click="handleRemove(item.id)"
                :disabled="removingId === item.id"
                class="text-muted-foreground hover:text-red-400 transition disabled:opacity-50"
              >
                <svg v-if="removingId === item.id" class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <p class="text-muted-foreground text-sm mb-4">{{ getTypeLabel(item.wishlistable_type) }}</p>
            <div class="flex items-center justify-between">
              <span v-if="item.wishlistable?.price" class="text-primary font-bold">
                Ksh {{ Number(item.wishlistable.price).toLocaleString() }}
              </span>
              <span v-else class="text-muted-foreground text-sm">â€”</span>
              <router-link
                v-if="item.wishlistable?.slug"
                :to="getDetailLink(item)"
                class="text-sm text-muted-foreground hover:text-foreground transition"
              >
                View Details â†’
              </router-link>
            </div>
          </div>
        </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="bg-card border border-border rounded-lg p-12 text-center">
        <div class="w-20 h-20 bg-muted rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-foreground mb-2">Your Wishlist is Empty</h3>
        <p class="text-muted-foreground mb-6">Start adding items you're interested in</p>
        <router-link
          to="/services"
          class="inline-block bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition"
        >
          Browse Services
        </router-link>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { IconAlertTriangle } from '@tabler/icons-vue';
import { ref, onMounted, computed } from 'vue';
import { useToast } from '@/composables/useToast';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { useWishlistStore } from '@/stores/wishlist';

const wishlistStore = useWishlistStore();
const toast = useToast();

const loading = ref(true);
const error = ref<string | null>(null);
const removingId = ref<number | null>(null);
const searchQuery = ref('');

const filteredItems = computed(() => {
  if (!searchQuery.value) return wishlistStore.items;
  const q = searchQuery.value.toLowerCase();
  return wishlistStore.items.filter((item: any) =>
    (item.wishlistable?.name || '').toLowerCase().includes(q) ||
    (item.wishlistable?.title || '').toLowerCase().includes(q) ||
    getTypeLabel(item.wishlistable_type).toLowerCase().includes(q)
  );
});

function getTypeLabel(type: string): string {
  if (type.includes('Product')) return 'Product';
  if (type.includes('Service')) return 'Service';
  if (type.includes('Bundle')) return 'Bundle';
  return 'Item';
}

function getTypeEmoji(type: string): string {
  if (type.includes('Product')) return '📦';
  if (type.includes('Service')) return '🚀';
  if (type.includes('Bundle')) return '📋';
  return '💎';
}

function getDetailLink(item: any): string {
  const slug = item.wishlistable?.slug;
  if (!slug) return '#';
  if (item.wishlistable_type.includes('Product')) return `/products/${slug}`;
  if (item.wishlistable_type.includes('Service')) return `/services/${slug}`;
  if (item.wishlistable_type.includes('Bundle')) return `/bundles/${slug}`;
  return '#';
}

async function loadWishlist() {
  loading.value = true;
  error.value = null;
  try {
    await wishlistStore.fetchWishlist();
  } catch (err: any) {
    error.value = err.response?.data?.message || err.message || 'Failed to load wishlist';
  } finally {
    loading.value = false;
  }
}

async function handleRemove(id: number) {
  removingId.value = id;
  try {
    await wishlistStore.removeFromWishlist(id);
    toast.success('Removed', 'Item removed from your wishlist.');
  } catch (err: any) {
    toast.error('Error', err.response?.data?.message || 'Failed to remove item. Please try again.');
  } finally {
    removingId.value = null;
  }
}

onMounted(loadWishlist);
</script>
