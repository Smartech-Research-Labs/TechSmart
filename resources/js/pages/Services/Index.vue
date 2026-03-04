<template>
  <PublicLayout>
    <!-- Hero -->
    <section class="py-16 md:py-20 bg-muted/30 border-b border-border">
      <div class="container mx-auto px-6">
        <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Services</p>
        <h1 class="text-2xl md:text-3xl font-bold text-foreground mb-3">Technology Solutions for Every Need</h1>
        <p class="text-muted-foreground text-sm max-w-2xl">Comprehensive technology services designed to help your business innovate, scale, and succeed in the digital world.</p>
      </div>
    </section>

    <!-- Category Filter Tabs -->
    <section class="py-4 bg-background border-b border-border sticky top-16 z-30">
      <div class="container mx-auto px-6">
        <div class="flex flex-wrap gap-2">
          <button
            @click="activeGroup = 'all'"
            :class="[
              'px-4 py-1.5 rounded-full text-xs font-medium transition-all',
              activeGroup === 'all'
                ? 'bg-primary text-white'
                : 'bg-card border border-border text-muted-foreground hover:text-foreground'
            ]"
          >All ({{ services.length }})</button>
          <button
            v-for="group in categoryGroups"
            :key="group"
            @click="activeGroup = group"
            :class="[
              'px-4 py-1.5 rounded-full text-xs font-medium transition-all',
              activeGroup === group
                ? 'bg-primary text-white'
                : 'bg-card border border-border text-muted-foreground hover:text-foreground'
            ]"
          >{{ group }}</button>
        </div>
      </div>
    </section>

    <!-- Loading State -->
    <section v-if="loading" class="py-16">
      <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="i in 6" :key="i" class="bg-card border border-border rounded-lg overflow-hidden animate-pulse">
            <div class="aspect-[16/10] bg-muted"></div>
            <div class="p-5 space-y-2">
              <div class="h-4 bg-muted rounded w-3/4"></div>
              <div class="h-3 bg-muted rounded w-full"></div>
              <div class="h-3 bg-muted rounded w-2/3"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Grouped Services -->
    <section v-else class="py-12">
      <div class="container mx-auto px-6">
        <template v-if="activeGroup === 'all'">
          <div v-for="group in categoryGroups" :key="group" class="mb-14 last:mb-0">
            <div class="flex items-center gap-4 mb-6">
              <h2 class="text-lg font-bold text-foreground">{{ group }}</h2>
              <div class="flex-1 h-px bg-border"></div>
              <span class="text-xs text-muted-foreground">{{ groupedServices[group]?.length || 0 }} services</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <ServiceCard v-for="service in groupedServices[group]" :key="service.id" :service="service" />
            </div>
          </div>
        </template>
        <template v-else>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <ServiceCard v-for="service in filteredServices" :key="service.id" :service="service" />
          </div>
        </template>

        <div v-if="!loading && services.length === 0" class="text-center py-16">
          <svg class="w-12 h-12 mx-auto text-muted-foreground/20 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
          <h3 class="text-lg font-bold text-foreground mb-1">No services available</h3>
          <p class="text-muted-foreground text-sm">Please check back later.</p>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 md:py-20">
      <div class="container mx-auto px-6">
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-8 md:p-12 text-center">
          <h2 class="text-xl md:text-2xl font-bold text-white mb-3">Need a Custom Solution?</h2>
          <p class="text-gray-400 text-sm mb-6 max-w-lg mx-auto">Tell us about your project and we will provide a free consultation and estimate.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-semibold rounded-md hover:bg-primary/90 transition-all">
            Get Free Consultation
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
          </router-link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, defineComponent, h } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import WishlistButton from '@/components/WishlistButton.vue';
import axios from 'axios';

//  Service Card Component (inline) 
const ServiceCard = defineComponent({
  props: { service: { type: Object, required: true } },
  setup(props) {
    return () => h('router-link', {
      to: `/services/${props.service.slug}`,
      class: 'group bg-card border border-border rounded-lg overflow-hidden hover:border-primary/30 hover:shadow-md transition-all duration-300 block'
    }, [
      // Image
      h('div', { class: 'aspect-[16/10] bg-muted overflow-hidden relative' }, [
        props.service.image_url
          ? h('img', { src: props.service.image_url, alt: props.service.title, class: 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' })
          : h('div', { class: 'w-full h-full flex items-center justify-center' }, [
              h('svg', { class: 'w-10 h-10 text-muted-foreground/20', fill: 'none', stroke: 'currentColor', 'stroke-width': '1', viewBox: '0 0 24 24' }, [
                h('path', { d: 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4' })
              ])
            ]),
        h('div', { class: 'absolute top-2 left-2' }, [
          h('span', { class: 'px-2 py-0.5 bg-primary/90 text-white text-[10px] font-medium rounded' }, props.service.category)
        ]),
        h('div', { class: 'absolute top-2 right-2 z-10', onClick: (e: Event) => e.preventDefault() }, [
          h(WishlistButton, { type: 'App\\Models\\Service', itemId: props.service.id })
        ]),
      ]),
      // Content
      h('div', { class: 'p-5' }, [
        h('h3', { class: 'text-sm font-semibold text-foreground mb-1.5 group-hover:text-primary transition-colors' }, props.service.title),
        h('p', { class: 'text-muted-foreground text-xs leading-relaxed mb-3 line-clamp-2' }, props.service.excerpt || props.service.short_description),
        h('span', { class: 'inline-flex items-center gap-1 text-primary font-medium text-xs group-hover:gap-2 transition-all' }, [
          'Learn More',
          h('svg', { class: 'w-3 h-3', fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
            h('path', { d: 'M9 5l7 7-7 7' })
          ])
        ])
      ])
    ]);
  }
});

//  Data 
const services = ref<any[]>([]);
const categories = ref<string[]>([]);
const categoryGroups = ref<string[]>([]);
const groupedServices = ref<Record<string, any[]>>({});
const loading = ref(true);
const activeGroup = ref('all');

const filteredServices = computed(() => {
  if (activeGroup.value === 'all') return services.value;
  return services.value.filter((s: any) => s.category_group === activeGroup.value);
});

async function fetchServices() {
  loading.value = true;
  try {
    const { data } = await axios.get('/api/v1/services');
    const d = data.data || data;
    services.value = d.services || [];
    categories.value = d.categories || [];
    categoryGroups.value = d.category_groups || [];
    groupedServices.value = d.grouped || {};
  } catch (error) {
    console.error('Error fetching services:', error);
  } finally {
    loading.value = false;
  }
}

onMounted(fetchServices);
</script>
