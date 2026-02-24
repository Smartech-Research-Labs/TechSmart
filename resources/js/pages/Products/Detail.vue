<template>
  <PublicLayout>
    <div class="container mx-auto px-4 py-20">
      <div class="mb-12">
        <h1 class="text-5xl font-display font-bold text-foreground mb-4">{{ product.name }}</h1>
        <p class="text-xl text-muted-foreground">{{ product.tagline }}</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
          <div class="bg-card border border-border rounded-2xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-foreground mb-6">Product Details</h2>
            <div class="prose prose-invert max-w-none">
              <p class="text-muted-foreground mb-4">{{ product.description }}</p>
            </div>
          </div>

          <div class="bg-card border border-border rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-foreground mb-6">Features & Benefits</h2>
            <ul class="space-y-3">
              <li v-for="feature in product.features" :key="feature" class="flex items-start">
                <span class="text-primary mr-3">✓</span>
                <span class="text-muted-foreground">{{ feature }}</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="lg:col-span-1">
          <div class="bg-card border border-border rounded-2xl p-6 sticky top-8">
            <div class="mb-6">
              <p class="text-sm text-muted-foreground mb-2">Starting at</p>
              <p class="text-3xl font-bold text-foreground">{{ product.price }}</p>
            </div>
            <router-link 
              to="/contact" 
              class="block w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-lg text-center transition mb-3"
            >
              Purchase Now
            </router-link>
            <router-link 
              to="/contact" 
              class="block w-full border border-primary hover:bg-primary/10 text-primary font-semibold py-3 px-6 rounded-lg text-center transition"
            >
              Request Demo
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
import PublicLayout from '@/layouts/PublicLayout.vue';

const route = useRoute();
const slug = route.params.slug as string;

const product = ref({
  name: 'Product Name',
  tagline: 'Innovative solutions for modern businesses',
  description: 'Loading product details...',
  price: '$999',
  features: [
    'Feature description',
    'Additional capabilities',
    'Comprehensive support'
  ]
});

onMounted(() => {
  // TODO: Fetch product details from API using slug
  // For now, using placeholder data
  product.value = {
    name: slug.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
    tagline: 'Cutting-edge technology product',
    description: `This product delivers exceptional value for businesses looking to streamline their operations. Built with the latest technology and best practices, it provides a robust solution that scales with your needs.`,
    price: '$999',
    features: [
      'Easy integration with existing systems',
      'User-friendly interface',
      'Advanced analytics and reporting',
      'Regular updates and improvements',
      '24/7 customer support',
      'Scalable architecture'
    ]
  };
});
</script>
