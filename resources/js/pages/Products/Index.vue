<template>
  <PublicLayout>
    <!-- Hero -->
    <section class="py-16 md:py-20 bg-muted/30 border-b border-border">
      <div class="container mx-auto px-6">
        <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Our Products</p>
        <h1 class="text-2xl md:text-3xl font-bold text-foreground mb-3">Cutting-Edge Solutions</h1>
        <p class="text-muted-foreground text-sm max-w-2xl">Ready-to-deploy products designed to power your business from day one.</p>
      </div>
    </section>

    <!-- Products Grid -->
    <section class="py-12">
      <div class="container mx-auto px-6">
        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="i in 6" :key="i" class="bg-card border border-border rounded-lg overflow-hidden animate-pulse">
            <div class="aspect-[16/10] bg-muted"></div>
            <div class="p-5 space-y-2">
              <div class="h-4 bg-muted rounded w-3/4"></div>
              <div class="h-3 bg-muted rounded w-full"></div>
            </div>
          </div>
        </div>

        <div v-else-if="products.length === 0" class="text-center py-16">
          <h3 class="text-lg font-bold text-foreground mb-1">No products available</h3>
          <p class="text-muted-foreground text-sm">Check back soon for new releases.</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <router-link
            v-for="product in products"
            :key="product.id"
            :to="`/products/${product.slug}`"
            class="group bg-card border border-border rounded-lg overflow-hidden hover:border-accent/30 hover:shadow-md transition-all duration-300"
          >
            <div class="aspect-[16/10] bg-muted overflow-hidden relative">
              <img v-if="product.image_url" :src="product.image_url" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <div v-else class="w-full h-full flex items-center justify-center">
                <svg class="w-10 h-10 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
              </div>
              <div class="absolute top-2 right-2 z-10" @click.prevent>
                <WishlistButton type="App\\Models\\Product" :item-id="product.id" />
              </div>
            </div>
            <div class="p-5">
              <h3 class="text-sm font-semibold text-foreground mb-1.5 group-hover:text-accent transition-colors">{{ product.name }}</h3>
              <p class="text-muted-foreground text-xs leading-relaxed line-clamp-2 mb-3">{{ product.excerpt }}</p>
              <div class="flex items-center justify-between">
                <span v-if="product.price_label" class="text-accent font-bold text-sm">{{ product.price_label }}</span>
                <span class="text-primary font-medium text-xs flex items-center gap-1">View <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg></span>
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 md:py-20">
      <div class="container mx-auto px-6">
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-8 md:p-12 text-center">
          <h2 class="text-xl md:text-2xl font-bold text-white mb-3">Need Something Custom?</h2>
          <p class="text-gray-400 text-sm mb-6 max-w-lg mx-auto">We build tailored products to match your exact business requirements.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-semibold rounded-md hover:bg-primary/90 transition-all">
            Contact Us
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
          </router-link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import WishlistButton from '@/components/WishlistButton.vue';
import axios from 'axios';

const products = ref<any[]>([]);
const loading = ref(true);

async function fetchProducts() {
  loading.value = true;
  try {
    const { data } = await axios.get('/api/v1/products');
    products.value = data.data || data.products || [];
  } catch (error) {
    console.error('Error fetching products:', error);
  } finally {
    loading.value = false;
  }
}

onMounted(fetchProducts);
</script>
