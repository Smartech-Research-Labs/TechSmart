<template>
  <PublicLayout>
    <!-- Loading State -->
    <div v-if="loading" class="min-h-screen flex items-center justify-center">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
    </div>

    <template v-else-if="service">
      <!-- Hero Banner with Service Image -->
      <section class="relative py-24 bg-background overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
          <img v-if="service.image_url" :src="service.image_url" :alt="service.title" class="w-full h-full object-cover opacity-10" />
          <div class="absolute inset-0 bg-gradient-to-b from-background via-background/90 to-background"></div>
        </div>
        <div class="relative container mx-auto px-4">
          <div class="flex items-center gap-2 mb-6">
            <router-link to="/services" class="text-muted-foreground hover:text-primary transition text-sm">Services</router-link>
            <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
            <span v-if="service.category_group" class="text-muted-foreground text-sm">{{ service.category_group }}</span>
            <svg v-if="service.category_group" class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
            <span class="text-primary text-sm font-medium">{{ service.title }}</span>
          </div>
          <div class="max-w-4xl">
            <div class="flex flex-wrap gap-3 mb-6">
              <span v-if="service.category" class="px-3 py-1 bg-primary/10 text-primary text-sm font-medium rounded-full">{{ service.category }}</span>
              <span v-if="service.price_label" class="px-3 py-1 bg-accent/10 text-accent text-sm font-medium rounded-full">{{ service.price_label }}</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-foreground mb-6">{{ service.title }}</h1>
            <p class="text-xl text-muted-foreground max-w-3xl">{{ service.short_description || service.excerpt }}</p>
          </div>
        </div>
      </section>

      <!-- Main Content -->
      <section class="py-16">
        <div class="container mx-auto px-4">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Content -->
            <div class="lg:col-span-2 space-y-12">
              <!-- Service Image -->
              <div v-if="service.image_url" class="aspect-video rounded-2xl overflow-hidden border border-border shadow-xl">
                <img :src="service.image_url" :alt="service.title" class="w-full h-full object-cover" />
              </div>

              <!-- Description -->
              <div class="bg-card border border-border rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-foreground mb-6">Service Overview</h2>
                <div class="prose prose-lg max-w-none text-muted-foreground" v-html="service.description"></div>
              </div>

              <!-- Key Features -->
              <div v-if="service.features && service.features.length" class="bg-card border border-border rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-foreground mb-6">Key Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div v-for="(feature, i) in service.features" :key="i" class="flex items-start gap-3 p-4 bg-muted/30 rounded-xl">
                    <div class="w-8 h-8 shrink-0 bg-primary/10 rounded-lg flex items-center justify-center mt-0.5">
                      <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <span class="text-foreground font-medium text-sm">{{ feature }}</span>
                  </div>
                </div>
              </div>

              <!-- Process Steps -->
              <div v-if="service.process_steps && service.process_steps.length" class="bg-card border border-border rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-foreground mb-8">Our Process</h2>
                <div class="space-y-6">
                  <div v-for="(step, i) in service.process_steps" :key="i" class="flex items-start gap-6">
                    <div class="w-12 h-12 shrink-0 bg-gradient-to-br from-primary to-accent rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                      {{ i + 1 }}
                    </div>
                    <div class="flex-1 pt-1">
                      <h3 class="text-lg font-bold text-foreground mb-1">{{ step.title || step }}</h3>
                      <p v-if="step.description" class="text-muted-foreground text-sm">{{ step.description }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1 space-y-6">
              <!-- Request Quote Card -->
              <div class="bg-card border border-border rounded-2xl p-6 sticky top-24">
                <h3 class="text-xl font-bold text-foreground mb-2">Get a Quote</h3>
                <p class="text-muted-foreground text-sm mb-4">Interested in this service? Contact us for a personalized quote.</p>
                <div v-if="service.price_from" class="mb-4 p-4 bg-primary/5 border border-primary/20 rounded-xl">
                  <p class="text-xs text-muted-foreground mb-1">Starting from</p>
                  <p class="text-3xl font-bold text-primary">R{{ Number(service.price_from).toLocaleString() }}</p>
                </div>
                <router-link to="/contact" class="block w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-xl text-center transition shadow-lg shadow-primary/25 mb-3">
                  Request This Service
                </router-link>
                <a :href="`https://wa.me/${whatsappNumber}?text=${encodeURIComponent('Hi! I am interested in your ' + service.title + ' service.')}`" target="_blank" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-xl text-center transition">
                  WhatsApp Us
                </a>
              </div>

              <!-- Service Info -->
              <div class="bg-card border border-border rounded-2xl p-6">
                <h3 class="text-lg font-bold text-foreground mb-4">Service Details</h3>
                <div class="space-y-4">
                  <div v-if="service.category" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                      <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    </div>
                    <div>
                      <p class="text-xs text-muted-foreground">Category</p>
                      <p class="text-sm font-semibold text-foreground">{{ service.category }}</p>
                    </div>
                  </div>
                  <div v-if="service.category_group" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-accent/10 rounded-lg flex items-center justify-center">
                      <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <div>
                      <p class="text-xs text-muted-foreground">Group</p>
                      <p class="text-sm font-semibold text-foreground">{{ service.category_group }}</p>
                    </div>
                  </div>
                  <div v-if="service.price_label" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center">
                      <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                      <p class="text-xs text-muted-foreground">Pricing</p>
                      <p class="text-sm font-semibold text-foreground">{{ service.price_label }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Related Services -->
      <section v-if="relatedServices.length" class="py-16 bg-muted/30 border-t border-border">
        <div class="container mx-auto px-4">
          <h2 class="text-3xl font-bold text-foreground mb-10">Related Services</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <router-link
              v-for="related in relatedServices"
              :key="related.id"
              :to="`/services/${related.slug}`"
              class="group bg-card border border-border rounded-2xl overflow-hidden hover:border-primary/40 hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
            >
              <div class="aspect-video bg-muted overflow-hidden relative">
                <img v-if="related.image_url" :src="related.image_url" :alt="related.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                <div class="absolute top-3 left-3">
                  <span class="px-3 py-1 bg-primary/90 text-white text-xs font-semibold rounded-full backdrop-blur">{{ related.category }}</span>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-lg font-bold text-foreground mb-2 group-hover:text-primary transition-colors">{{ related.title }}</h3>
                <p class="text-muted-foreground text-sm line-clamp-2">{{ related.excerpt || related.short_description }}</p>
              </div>
            </router-link>
          </div>
        </div>
      </section>

      <!-- CTA -->
      <section class="py-20 bg-background">
        <div class="container mx-auto px-4 text-center max-w-3xl">
          <h2 class="text-4xl font-bold text-foreground mb-6">Ready to get started?</h2>
          <p class="text-muted-foreground text-lg mb-8">Let us help you bring your project to life with our {{ service.title }} service.</p>
          <div class="flex flex-wrap justify-center gap-4">
            <router-link to="/contact" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 shadow-lg transition-all">
              Get Free Consultation
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </router-link>
            <router-link to="/services" class="inline-flex items-center gap-2 px-8 py-4 bg-card border-2 border-primary text-primary font-bold rounded-xl hover:bg-primary hover:text-white transition-all">
              View All Services
            </router-link>
          </div>
        </div>
      </section>
    </template>

    <!-- Not Found -->
    <div v-else class="min-h-screen flex items-center justify-center">
      <div class="text-center">
        <h2 class="text-3xl font-bold text-foreground mb-4">Service Not Found</h2>
        <p class="text-muted-foreground mb-8">The service you are looking for does not exist.</p>
        <router-link to="/services" class="px-6 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 transition">
          Back to Services
        </router-link>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const service = ref<any>(null);
const relatedServices = ref<any[]>([]);
const loading = ref(true);
const whatsappNumber = ref('');

async function fetchService(slug: string) {
  loading.value = true;
  try {
    const { data } = await axios.get(`/api/v1/services/${slug}`);
    const d = data.data || data;
    service.value = d.service || d;
    relatedServices.value = d.related || [];

    // Parse features/process_steps if they are JSON strings
    if (typeof service.value.features === 'string') {
      try { service.value.features = JSON.parse(service.value.features); } catch {}
    }
    if (typeof service.value.process_steps === 'string') {
      try { service.value.process_steps = JSON.parse(service.value.process_steps); } catch {}
    }
  } catch (error: any) {
    console.error('Error fetching service:', error);
    service.value = null;
  } finally {
    loading.value = false;
  }
}

// Also try to get whatsapp from home settings
async function fetchSettings() {
  try {
    const { data } = await axios.get('/api/v1/home');
    const d = data.data || data;
    whatsappNumber.value = d.settings?.whatsapp_number || '';
  } catch {}
}

// Watch for route changes (navigating between service details)
watch(() => route.params.slug, (newSlug) => {
  if (newSlug) {
    fetchService(newSlug as string);
    window.scrollTo(0, 0);
  }
});

onMounted(() => {
  const slug = route.params.slug as string;
  if (slug) {
    fetchService(slug);
    fetchSettings();
  }
});
</script>
