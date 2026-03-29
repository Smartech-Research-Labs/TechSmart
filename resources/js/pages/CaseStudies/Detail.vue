<template>
  <PublicLayout>
    <!-- Loading -->
    <div v-if="loading" class="py-20 text-center">
      <div class="inline-block w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <article v-else-if="caseStudy">
      <!-- ═══════════════ HERO ═══════════════ -->
      <section class="relative min-h-[45vh] flex items-end overflow-hidden">
        <div class="absolute inset-0">
          <img
            :src="caseStudy.image_url || caseStudy.featured_image || 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1920&h=1080&fit=crop&q=80'"
            :alt="caseStudy.title"
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-background via-background/60 to-transparent"></div>
        </div>
        <div class="relative z-10 container mx-auto px-6 pb-10">
          <!-- Breadcrumbs -->
          <nav class="flex items-center gap-2 text-xs text-muted-foreground mb-4">
            <router-link to="/" class="hover:text-primary transition">Home</router-link>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <router-link to="/case-studies" class="hover:text-primary transition">Case Studies</router-link>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <span class="text-foreground font-medium">{{ caseStudy.title }}</span>
          </nav>

          <div class="flex flex-wrap items-center gap-2 mb-3">
            <span v-if="caseStudy.industry" class="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full border border-primary/20">{{ caseStudy.industry }}</span>
            <span v-if="caseStudy.client_name" class="px-3 py-1 text-xs font-medium bg-card/80 text-foreground rounded-full border border-border">{{ caseStudy.client_name }}</span>
          </div>
          <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-foreground leading-tight max-w-3xl">{{ caseStudy.title }}</h1>
        </div>
      </section>

      <!-- ═══════════════ OVERVIEW ═══════════════ -->
      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="max-w-4xl mx-auto">
            <!-- Metrics Bar -->
            <div v-if="caseStudy.metrics?.length" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
              <div v-for="(metric, i) in caseStudy.metrics" :key="i" class="bg-card border border-border rounded-xl p-4 text-center hover:shadow-sm hover:border-primary/20 transition-all">
                <div class="text-xl md:text-2xl font-bold text-primary mb-0.5">{{ metric.value }}</div>
                <div class="text-xs text-muted-foreground font-medium">{{ metric.label }}</div>
              </div>
            </div>

            <!-- Excerpt -->
            <p v-if="caseStudy.excerpt" class="text-lg text-muted-foreground leading-relaxed mb-10">{{ caseStudy.excerpt }}</p>

            <!-- Client & Service Info -->
            <div class="flex flex-wrap gap-8 mb-12 p-6 bg-muted/30 rounded-xl border border-border">
              <div v-if="caseStudy.client_name">
                <p class="text-xs text-muted-foreground font-medium mb-1">Client</p>
                <div class="flex items-center gap-2">
                  <img v-if="caseStudy.client_logo" :src="caseStudy.client_logo" :alt="caseStudy.client_name" class="h-6 object-contain" />
                  <span class="text-sm font-semibold text-foreground">{{ caseStudy.client_name }}</span>
                </div>
              </div>
              <div v-if="caseStudy.industry">
                <p class="text-xs text-muted-foreground font-medium mb-1">Industry</p>
                <span class="text-sm font-semibold text-foreground">{{ caseStudy.industry }}</span>
              </div>
              <div v-if="caseStudy.service">
                <p class="text-xs text-muted-foreground font-medium mb-1">Service</p>
                <router-link :to="`/services/${caseStudy.service.slug}`" class="text-sm font-semibold text-primary hover:underline">{{ caseStudy.service.name }}</router-link>
              </div>
              <div v-if="caseStudy.technologies?.length">
                <p class="text-xs text-muted-foreground font-medium mb-1">Technologies</p>
                <div class="flex flex-wrap gap-1">
                  <span v-for="tech in caseStudy.technologies" :key="tech" class="px-2 py-0.5 text-xs bg-primary/10 text-primary rounded-full">{{ tech }}</span>
                </div>
              </div>
            </div>

            <!-- Challenge -->
            <div v-if="caseStudy.challenge" class="mb-10">
              <h2 class="text-lg font-bold text-foreground mb-3 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/20 flex items-center justify-center">
                  <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </span>
                The Challenge
              </h2>
              <div class="prose prose-sm max-w-none prose-p:text-muted-foreground" v-html="caseStudy.challenge"></div>
            </div>

            <!-- Solution -->
            <div v-if="caseStudy.solution" class="mb-10">
              <h2 class="text-lg font-bold text-foreground mb-3 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/20 flex items-center justify-center">
                  <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </span>
                Our Solution
              </h2>
              <div class="prose prose-sm max-w-none prose-p:text-muted-foreground" v-html="caseStudy.solution"></div>
            </div>

            <!-- Results -->
            <div v-if="caseStudy.results" class="mb-10">
              <h2 class="text-lg font-bold text-foreground mb-3 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/20 flex items-center justify-center">
                  <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                The Results
              </h2>
              <div class="prose prose-sm max-w-none prose-p:text-muted-foreground" v-html="caseStudy.results"></div>
            </div>

            <!-- Main Content -->
            <div v-if="caseStudy.content" class="prose prose-sm max-w-none prose-headings:text-foreground prose-p:text-muted-foreground prose-a:text-primary prose-strong:text-foreground mb-10" v-html="caseStudy.content"></div>

            <!-- Testimonial -->
            <div v-if="caseStudy.testimonial_quote" class="bg-muted/30 border border-border rounded-xl p-8 mb-10">
              <svg class="w-8 h-8 text-primary/30 mb-3" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
              <blockquote class="text-base text-foreground italic leading-relaxed mb-4">"{{ caseStudy.testimonial_quote }}"</blockquote>
              <div>
                <p v-if="caseStudy.testimonial_author" class="text-sm font-semibold text-foreground">{{ caseStudy.testimonial_author }}</p>
                <p v-if="caseStudy.testimonial_role" class="text-xs text-muted-foreground">{{ caseStudy.testimonial_role }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ RELATED CASE STUDIES ═══════════════ -->
      <section v-if="related.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">More Success Stories</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Related Case Studies</h2>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <router-link v-for="cs in related" :key="cs.id" :to="`/case-studies/${cs.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all">
              <div class="aspect-[16/10] overflow-hidden">
                <img :src="cs.image_url || cs.featured_image || 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop&q=80'" :alt="cs.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              </div>
              <div class="p-5">
                <span v-if="cs.client_name" class="text-xs font-medium text-primary mb-2 block">{{ cs.client_name }}</span>
                <h3 class="text-base font-semibold text-foreground mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ cs.title }}</h3>
                <p class="text-xs text-muted-foreground line-clamp-2">{{ cs.excerpt }}</p>
              </div>
            </router-link>
          </div>
        </div>
      </section>

      <!-- ═══════════════ CTA ═══════════════ -->
      <section class="py-16 md:py-20 bg-gradient-to-r from-red-800 via-red-700 to-red-900 text-white">
        <div class="container mx-auto px-6 text-center">
          <h2 class="text-2xl md:text-3xl font-bold mb-4">Want Similar Results?</h2>
          <p class="text-white/80 text-sm max-w-lg mx-auto mb-8">Let our experts help you achieve the same level of success. Contact us for a free consultation.</p>
          <div class="flex flex-wrap justify-center gap-3">
            <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-white text-red-800 text-sm font-semibold rounded-full hover:bg-white/90 transition-all shadow-lg">
              Start Your Project
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
            <router-link to="/services" class="px-7 py-3 border border-white/30 text-white text-sm font-medium rounded-full hover:bg-white/10 transition-all">View Our Services</router-link>
          </div>
        </div>
      </section>
    </article>

    <!-- Not Found -->
    <div v-else class="py-20 text-center">
      <h2 class="text-2xl font-bold text-foreground mb-2">Case Study Not Found</h2>
      <p class="text-muted-foreground mb-6">The case study you're looking for doesn't exist or has been removed.</p>
      <router-link to="/case-studies" class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition">View All Case Studies</router-link>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import PublicLayout from '@/layouts/PublicLayout.vue';
import api from '@/services/api';

const route = useRoute();
const loading = ref(true);
const caseStudy = ref<any>(null);
const related = ref<any[]>([]);

async function fetchCaseStudy(slug: string) {
  loading.value = true;
  try {
    const { data } = await api.get(`/api/v1/case-studies/${slug}`);
    caseStudy.value = data.case_study;
    related.value = data.related || [];
  } catch (e) {
    console.error('Failed to load case study', e);
    caseStudy.value = null;
  } finally {
    loading.value = false;
  }
}

onMounted(() => fetchCaseStudy(route.params.slug as string));

watch(() => route.params.slug, (newSlug) => {
  if (newSlug) fetchCaseStudy(newSlug as string);
});
</script>
