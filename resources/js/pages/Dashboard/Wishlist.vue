<template>
  <DashboardLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-3xl font-display font-bold text-foreground mb-2">My Wishlist</h1>
        <p class="text-muted-foreground">Items you've saved for later</p>
      </div>

      <!-- Wishlist Items -->
      <div v-if="items.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="item in items" 
          :key="item.id"
          class="bg-card border border-border rounded-lg overflow-hidden hover:border-primary transition group"
        >
          <div class="aspect-video bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
            <span class="text-4xl">{{ item.icon }}</span>
          </div>
          <div class="p-6">
            <div class="flex items-start justify-between mb-2">
              <h3 class="text-lg font-bold text-foreground group-hover:text-primary transition">
                {{ item.name }}
              </h3>
              <button 
                @click="removeItem(item.id)"
                class="text-muted-foreground hover:text-red-400 transition"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <p class="text-muted-foreground text-sm mb-4">{{ item.type }}</p>
            <div class="flex items-center justify-between">
              <span class="text-primary font-bold">{{ item.price }}</span>
              <button class="text-sm text-muted-foreground hover:text-foreground transition">
                View Details →
              </button>
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
          class="inline-block bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition"
        >
          Browse Services
        </router-link>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const items = ref([
  { id: 1, name: 'Web Development', type: 'Service', price: '$2,999', icon: '🚀' },
  { id: 2, name: 'Cloud Solutions', type: 'Service', price: '$4,999', icon: '☁️' },
  { id: 3, name: 'Startup Bundle', type: 'Bundle', price: '$8,999', icon: '📦' }
]);

const removeItem = (id: number) => {
  items.value = items.value.filter(item => item.id !== id);
};
</script>
