<template>
  <PublicLayout>
    <div class="container mx-auto px-4 py-20">
      <div class="mb-12">
        <h1 class="text-5xl font-display font-bold text-foreground mb-4">{{ service.title }}</h1>
        <p class="text-xl text-muted-foreground">{{ service.description }}</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
          <div class="bg-card border border-border rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-foreground mb-6">Service Overview</h2>
            <div class="prose prose-invert max-w-none">
              <p class="text-muted-foreground mb-4">{{ service.content }}</p>
            </div>
          </div>

          <div class="mt-8 bg-card border border-border rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-foreground mb-6">Key Features</h2>
            <ul class="space-y-3">
              <li v-for="feature in service.features" :key="feature" class="flex items-start">
                <span class="text-primary mr-3">✓</span>
                <span class="text-muted-foreground">{{ feature }}</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="lg:col-span-1">
          <div class="bg-card border border-border rounded-2xl p-6 sticky top-8">
            <h3 class="text-xl font-bold text-foreground mb-4">Request This Service</h3>
            <p class="text-muted-foreground mb-6">Contact us to learn more about this service and get a custom quote.</p>
            <router-link 
              to="/contact" 
              class="block w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-lg text-center transition"
            >
              Get in Touch
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

const service = ref({
  title: 'Service Details',
  description: 'Comprehensive technology solutions for your business',
  content: 'Loading service details...',
  features: [
    'Professional service delivery',
    'Expert technical support',
    'Scalable solutions',
    'Timely project completion'
  ]
});

onMounted(() => {
  // TODO: Fetch service details from API using slug
  // For now, using placeholder data
  service.value = {
    title: slug.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
    description: 'Professional technology services tailored to your needs',
    content: `This service provides comprehensive solutions for modern businesses. Our team of experts will work with you to understand your requirements and deliver results that exceed expectations.`,
    features: [
      'Custom solution development',
      'Expert consultation and support',
      'Scalable and flexible architecture',
      'Timely delivery and deployment',
      'Ongoing maintenance and updates'
    ]
  };
});
</script>
