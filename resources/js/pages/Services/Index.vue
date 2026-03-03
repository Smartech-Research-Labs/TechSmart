<template>
  <PublicLayout>
    <!-- Hero -->
    <section class="relative py-24 bg-background overflow-hidden">
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-20 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-accent/10 rounded-full blur-3xl"></div>
      </div>
      <div class="relative container mx-auto px-4">
        <div class="max-w-4xl">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">Our Services</div>
          <h1 class="text-5xl md:text-6xl font-bold text-foreground mb-6">Technology solutions for <span class="text-primary">every need</span></h1>
          <p class="text-xl text-muted-foreground max-w-3xl">Comprehensive technology services designed to help your business innovate, scale, and succeed in the digital world.</p>
        </div>
      </div>
    </section>

    <!-- Category Filter Tabs -->
    <section class="py-6 bg-muted/30 border-y border-border sticky top-16 z-30 backdrop-blur">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-3">
          <button
            @click="activeGroup = 'all'"
            :class="[
              'px-5 py-2.5 rounded-full text-sm font-semibold transition-all',
              activeGroup === 'all'
                ? 'bg-primary text-white shadow-lg shadow-primary/25'
                : 'bg-card border border-border text-muted-foreground hover:text-primary hover:border-primary/40'
            ]"
          >All Services ({{ services.length }})</button>
          <button
            v-for="group in categoryGroups"
            :key="group"
            @click="activeGroup = group"
            :class="[
              'px-5 py-2.5 rounded-full text-sm font-semibold transition-all',
              activeGroup === group
                ? 'bg-primary text-white shadow-lg shadow-primary/25'
                : 'bg-card border border-border text-muted-foreground hover:text-primary hover:border-primary/40'
            ]"
          >{{ group }}</button>
        </div>
      </div>
    </section>

    <!-- Loading State -->
    <section v-if="loading" class="py-24">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="i in 6" :key="i" class="bg-card border border-border rounded-2xl overflow-hidden animate-pulse">
            <div class="aspect-video bg-muted"></div>
            <div class="p-6 space-y-3">
              <div class="h-6 bg-muted rounded w-3/4"></div>
              <div class="h-4 bg-muted rounded w-full"></div>
              <div class="h-4 bg-muted rounded w-2/3"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Grouped Services -->
    <section v-else class="py-16">
      <div class="container mx-auto px-4">
        <template v-if="activeGroup === 'all'">
          <div v-for="group in categoryGroups" :key="group" class="mb-20 last:mb-0">
            <div class="flex items-center gap-4 mb-10">
              <h2 class="text-3xl font-bold text-foreground">{{ group }}</h2>
              <div class="flex-1 h-px bg-border"></div>
              <span class="text-sm text-muted-foreground font-medium">{{ groupedServices[group]?.length || 0 }} services</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <ServiceCard v-for="service in groupedServices[group]" :key="service.id" :service="service" />
            </div>
          </div>
        </template>
        <template v-else>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <ServiceCard v-for="service in filteredServices" :key="service.id" :service="service" />
          </div>
        </template>

        <div v-if="!loading && services.length === 0" class="text-center py-24">
          <svg class="w-16 h-16 mx-auto text-muted-foreground/30 mb-6" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
          <h3 class="text-2xl font-bold text-foreground mb-2">No services available</h3>
          <p class="text-muted-foreground">Please check back later.</p>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-br from-primary to-accent relative overflow-hidden">
      <div class="absolute inset-0 pointer-events-none opacity-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-white rounded-full blur-3xl"></div>
      </div>
      <div class="relative container mx-auto px-4 text-center max-w-3xl">
        <h2 class="text-4xl font-bold text-white mb-6">Need a custom solution?</h2>
        <p class="text-white/90 text-lg mb-8">Tell us about your project and we will provide a free consultation and estimate.</p>
        <router-link to="/contact" class="inline-flex items-center gap-2 px-10 py-5 bg-white text-primary font-bold rounded-xl hover:bg-white/90 shadow-2xl transform hover:-translate-y-1 transition-all text-lg">
          Get Free Consultation
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
        </router-link>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, defineComponent, h } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';

//  Service Card Component (inline) 
const ServiceCard = defineComponent({
  props: { service: { type: Object, required: true } },
  setup(props) {
    return () => h('router-link', {
      to: `/services/${props.service.slug}`,
      class: 'group bg-card border border-border rounded-2xl overflow-hidden hover:border-primary/40 hover:shadow-xl hover:shadow-primary/5 transition-all duration-300 hover:-translate-y-1 block'
    }, [
      // Image
      h('div', { class: 'aspect-video bg-muted overflow-hidden relative' }, [
        props.service.image_url
          ? h('img', { src: props.service.image_url, alt: props.service.title, class: 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500' })
          : h('div', { class: 'w-full h-full flex items-center justify-center' }, [
              h('svg', { class: 'w-12 h-12 text-muted-foreground/30', fill: 'none', stroke: 'currentColor', 'stroke-width': '1', viewBox: '0 0 24 24' }, [
                h('path', { d: 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4' })
              ])
            ]),
        h('div', { class: 'absolute top-3 left-3' }, [
          h('span', { class: 'px-3 py-1 bg-primary/90 text-white text-xs font-semibold rounded-full backdrop-blur' }, props.service.category)
        ]),
        props.service.price_label
          ? h('div', { class: 'absolute top-3 right-3' }, [
              h('span', { class: 'px-3 py-1 bg-black/60 text-white text-xs font-semibold rounded-full backdrop-blur' }, props.service.price_label)
            ])
          : null,
      ]),
      // Content
      h('div', { class: 'p-6' }, [
        h('h3', { class: 'text-xl font-bold text-foreground mb-3 group-hover:text-primary transition-colors' }, props.service.title),
        h('p', { class: 'text-muted-foreground text-sm leading-relaxed mb-4 line-clamp-2' }, props.service.excerpt || props.service.short_description),
        h('div', { class: 'flex flex-wrap gap-2 mb-4' }, [
          ...(props.service.features || []).slice(0, 4).map((feat: string, i: number) =>
            h('span', { key: i, class: 'px-2.5 py-1 bg-muted text-muted-foreground text-xs rounded-md' }, feat)
          ),
          (props.service.features || []).length > 4
            ? h('span', { class: 'px-2.5 py-1 bg-primary/10 text-primary text-xs rounded-md font-medium' }, `+${props.service.features.length - 4} more`)
            : null,
        ]),
        h('span', { class: 'inline-flex items-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all' }, [
          'Learn More',
          h('svg', { class: 'w-4 h-4', fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
            h('path', { d: 'M17 8l4 4m0 0l-4 4m4-4H3' })
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
