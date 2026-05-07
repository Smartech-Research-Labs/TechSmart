import axios from 'axios';
import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

interface WishlistItem {
  id: number;
  wishlistable_type: string;
  wishlistable_id: number;
  wishlistable: {
    id: number;
    name?: string;
    title?: string;
    slug: string;
    price?: number;
    image_url?: string;
    excerpt?: string;
  };
  created_at: string;
}

export const useWishlistStore = defineStore('wishlist', () => {
  const items = ref<WishlistItem[]>([]);
  const loading = ref(false);
  const error = ref<string | null>(null);

  const itemCount = computed(() => items.value.length);
  const productIds = computed(() => 
    items.value
      .filter(item => item.wishlistable_type === 'App\\Models\\Product')
      .map(item => item.wishlistable_id)
  );
  const bundleIds = computed(() => 
    items.value
      .filter(item => item.wishlistable_type === 'App\\Models\\Bundle')
      .map(item => item.wishlistable_id)
  );

  function isInWishlist(type: string, id: number): boolean {
    return items.value.some(
      item => item.wishlistable_type === type && item.wishlistable_id === id
    );
  }

  async function fetchWishlist() {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.get('/api/v1/user/wishlist');
      items.value = response.data.wishlist;
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch wishlist';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function addToWishlist(type: string, id: number) {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.post('/api/v1/user/wishlist', {
        wishlistable_type: type,
        wishlistable_id: id,
      });
      
      // Optimistically add to local state
      if (response.data.wishlist_item) {
        items.value.push(response.data.wishlist_item);
      }
      
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to add to wishlist';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function removeFromWishlist(wishlistItemId: number) {
    loading.value = true;
    error.value = null;
    try {
      await axios.delete(`/api/v1/user/wishlist/${wishlistItemId}`);
      
      // Optimistically remove from local state
      items.value = items.value.filter(item => item.id !== wishlistItemId);
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to remove from wishlist';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function toggleWishlist(type: string, id: number) {
    const existing = items.value.find(
      item => item.wishlistable_type === type && item.wishlistable_id === id
    );

    if (existing) {
      await removeFromWishlist(existing.id);
    } else {
      await addToWishlist(type, id);
    }
  }

  function clearWishlist() {
    items.value = [];
  }

  return {
    items,
    loading,
    error,
    itemCount,
    productIds,
    bundleIds,
    isInWishlist,
    fetchWishlist,
    addToWishlist,
    removeFromWishlist,
    toggleWishlist,
    clearWishlist,
  };
});
