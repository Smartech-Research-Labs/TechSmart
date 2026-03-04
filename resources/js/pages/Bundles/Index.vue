<template>
  <PublicLayout>
    <!-- Hero -->
    <section class="py-16 md:py-20 bg-muted/30 border-b border-border">
      <div class="container mx-auto px-6">
        <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Value Bundles</p>
        <h1 class="text-2xl md:text-3xl font-bold text-foreground mb-3">Save More with Curated Packages</h1>
        <p class="text-muted-foreground text-sm max-w-2xl">Pre-configured service bundles designed to deliver maximum value for your business.</p>
      </div>
    </section>

    <!-- Bundles Grid -->
    <section class="py-12">
      <div class="container mx-auto px-6">
        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="i in 3" :key="i" class="bg-card border border-border rounded-lg p-6 animate-pulse">
            <div class="h-5 bg-muted rounded w-1/2 mb-3"></div>
            <div class="h-8 bg-muted rounded w-1/3 mb-4"></div>
            <div class="space-y-2">
              <div class="h-3 bg-muted rounded w-full"></div>
              <div class="h-3 bg-muted rounded w-3/4"></div>
            </div>
          </div>
        </div>

        <div v-else-if="bundles.length === 0" class="text-center py-16">
          <h3 class="text-lg font-bold text-foreground mb-1">No bundles available</h3>
          <p class="text-muted-foreground text-sm">Check back soon for new packages.</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="bundle in bundles"
            :key="bundle.id"
            class="bg-card border border-border rounded-lg p-6 hover:border-accent/30 hover:shadow-md transition-all duration-300"
            :class="{ 'ring-2 ring-primary border-primary': bundle.is_featured }"
          >
            <div v-if="bundle.is_featured" class="inline-block text-[10px] font-semibold text-primary bg-primary/10 px-2 py-0.5 rounded mb-3">Most Popular</div>
            <h3 class="text-base font-bold text-foreground mb-1">{{ bundle.name }}</h3>
            <div class="flex items-baseline gap-1 mb-3">
              <span class="text-2xl font-bold text-accent">Ksh {{ Number(bundle.price).toLocaleString() }}</span>
              <span v-if="bundle.original_price" class="text-xs text-muted-foreground line-through">Ksh {{ Number(bundle.original_price).toLocaleString() }}</span>
            </div>
            <p class="text-muted-foreground text-xs leading-relaxed mb-4">{{ bundle.description }}</p>
            <ul class="space-y-2 mb-6">
              <li v-for="item in (bundle.items || [])" :key="item.id" class="flex items-center gap-2 text-sm text-foreground">
                <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                {{ item.title || item.name }}
              </li>
            </ul>
            <router-link :to="`/contact?bundle=${bundle.slug || bundle.id}`" class="block text-center w-full px-4 py-2.5 bg-primary text-white text-sm font-semibold rounded-md hover:bg-primary/90 transition-all">
              Get Started
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 md:py-20">
      <div class="container mx-auto px-6">
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-8 md:p-12 text-center">
          <h2 class="text-xl md:text-2xl font-bold text-white mb-3">Need a Custom Bundle?</h2>
          <p class="text-gray-400 text-sm mb-6 max-w-lg mx-auto">We can create a tailored package that fits your exact needs and budget.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-semibold rounded-md hover:bg-primary/90 transition-all">
            Talk to Us
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
import axios from 'axios';

const bundles = ref<any[]>([]);
const loading = ref(true);

async function fetchBundles() {
  loading.value = true;
  try {
    const { data } = await axios.get('/api/v1/bundles');
    bundles.value = data.data || data.bundles || [];
  } catch (error) {
    console.error('Error fetching bundles:', error);
  } finally {
    loading.value = false;
  }
}

onMounted(fetchBundles);
</script>
