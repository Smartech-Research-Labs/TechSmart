<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="heroTechBg" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Bundle Package</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">{{ bundle.name }}</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">{{ bundle.tagline }}</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Get This Bundle
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <div class="container mx-auto px-4 py-12">
      <div class="mb-12">
        <div class="inline-block bg-primary/10 border border-primary text-primary px-4 py-1 rounded-full text-sm font-semibold mb-4">
          BUNDLE PACKAGE
        </div>
        <h1 class="text-5xl font-display font-bold text-foreground mb-4">{{ bundle.name }}</h1>
        <p class="text-xl text-muted-foreground">{{ bundle.tagline }}</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
          <div class="bg-card border border-border rounded-2xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-foreground mb-6">Bundle Overview</h2>
            <div class="prose prose-invert max-w-none">
              <p class="text-muted-foreground mb-4">{{ bundle.description }}</p>
            </div>
          </div>

          <div class="bg-card border border-border rounded-2xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-foreground mb-6">What's Included</h2>
            <div class="space-y-4">
              <div v-for="item in bundle.includes" :key="item" class="flex items-start p-4 bg-muted/30 rounded-lg">
                <span class="text-primary mr-4 text-xl">✓</span>
                <div>
                  <p class="text-foreground font-semibold">{{ item }}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-card border border-border rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-foreground mb-6">Bundle Benefits</h2>
            <ul class="space-y-3">
              <li v-for="benefit in bundle.benefits" :key="benefit" class="flex items-start">
                <span class="text-primary mr-3">✓</span>
                <span class="text-muted-foreground">{{ benefit }}</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="lg:col-span-1">
          <div class="bg-card border border-border rounded-2xl p-6 sticky top-8">
            <div class="mb-6">
              <p class="text-sm text-muted-foreground mb-2">Bundle Price</p>
              <p class="text-3xl font-bold text-foreground mb-1">{{ bundle.price }}</p>
              <p class="text-sm text-primary">{{ bundle.savings }}</p>
            </div>
            <router-link 
              to="/contact" 
              class="block w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-lg text-center transition mb-3"
            >
              Get This Bundle
            </router-link>
            <router-link 
              to="/contact" 
              class="block w-full border border-primary hover:bg-primary/10 text-primary font-semibold py-3 px-6 rounded-lg text-center transition"
            >
              Learn More
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import heroTechBg from '@/../img/tech-background.webp';
import PublicLayout from '@/layouts/PublicLayout.vue';

const route = useRoute();
const slug = route.params.slug as string;

const bundle = ref({
  name: 'Bundle Name',
  tagline: 'Complete package solution',
  description: 'Loading bundle details...',
  price: '$2,499',
  savings: 'Save 30% compared to individual purchase',
  includes: ['Item 1', 'Item 2', 'Item 3'],
  benefits: ['Benefit 1', 'Benefit 2']
});

onMounted(() => {
  // TODO: Fetch bundle details from API using slug
  // For now, using placeholder data
  bundle.value = {
    name: slug.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
    tagline: 'Everything you need in one comprehensive package',
    description: `This bundle package combines our most popular services and products into a complete solution designed to accelerate your business growth. Get everything you need at a significant discount.`,
    price: '$2,499',
    savings: 'Save 30% compared to individual purchases',
    includes: [
      'Complete web application development',
      'Mobile app (iOS & Android)',
      'Cloud infrastructure setup',
      'AI-powered features integration',
      '1 year of priority support'
    ],
    benefits: [
      'Cost-effective solution',
      'Seamless integration across all components',
      'Dedicated project manager',
      'Priority support and updates',
      'Flexible payment options',
      'Comprehensive documentation and training'
    ]
  };
});
</script>
