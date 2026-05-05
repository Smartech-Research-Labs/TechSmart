<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="s.hero_bg_image || heroLaptopDark" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Work</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Case Studies</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">See how we've helped organizations across Africa and beyond achieve measurable results through innovative technology solutions.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Start Your Project
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ FILTERS ═══════════════ -->
    <section class="py-3 bg-background border-y border-border sticky top-16 z-30">
      <div class="container mx-auto px-6">
        <div class="flex flex-wrap gap-2">
          <button @click="activeIndustry = ''" :class="['px-4 py-1.5 rounded-full text-xs font-medium transition-all', !activeIndustry ? 'bg-primary text-white' : 'bg-card border border-border text-muted-foreground hover:text-foreground']">All</button>
          <button v-for="ind in industries" :key="ind" @click="activeIndustry = ind" :class="['px-4 py-1.5 rounded-full text-xs font-medium transition-all', activeIndustry === ind ? 'bg-primary text-white' : 'bg-card border border-border text-muted-foreground hover:text-foreground']">{{ ind }}</button>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CASE STUDIES GRID ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <!-- Loading -->
        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="i in 6" :key="i" class="bg-card border border-border rounded-xl overflow-hidden animate-pulse">
            <div class="aspect-[16/10] bg-muted"></div>
            <div class="p-5 space-y-3">
              <div class="h-3 bg-muted rounded w-1/3"></div>
              <div class="h-4 bg-muted rounded w-3/4"></div>
              <div class="h-3 bg-muted rounded w-full"></div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else-if="!filteredCaseStudies.length" class="py-16 text-center">
          <svg class="w-16 h-16 mx-auto text-muted-foreground/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          <h3 class="text-lg font-semibold text-foreground mb-2">No case studies found</h3>
          <p class="text-sm text-muted-foreground">{{ activeIndustry ? 'Try selecting a different industry filter.' : 'Case studies will appear here as they are published.' }}</p>
        </div>

        <!-- Grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <router-link v-for="cs in filteredCaseStudies" :key="cs.id" :to="`/case-studies/${cs.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all">
            <div class="aspect-[16/10] overflow-hidden relative">
              <img :src="cs.image_url || cs.featured_image || heroTech7" :alt="cs.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <div v-if="cs.is_featured" class="absolute top-3 right-3 px-2 py-0.5 bg-amber-500 text-white text-[10px] font-semibold rounded-full">Featured</div>
            </div>
            <div class="p-5">
              <div class="flex items-center gap-2 mb-2">
                <span v-if="cs.industry" class="text-[10px] font-medium bg-primary/10 text-primary px-2 py-0.5 rounded-full">{{ cs.industry }}</span>
                <span v-if="cs.client_name" class="text-[10px] text-muted-foreground">{{ cs.client_name }}</span>
              </div>
              <h3 class="text-base font-semibold text-foreground mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ cs.title }}</h3>
              <p class="text-xs text-muted-foreground line-clamp-3 mb-4">{{ cs.excerpt }}</p>
              <div v-if="cs.technologies?.length" class="flex flex-wrap gap-1 mb-3">
                <span v-for="tech in cs.technologies.slice(0, 4)" :key="tech" class="px-1.5 py-0.5 text-[10px] bg-accent/10 text-accent-foreground rounded">{{ tech }}</span>
              </div>
              <span class="text-xs font-semibold text-primary inline-flex items-center gap-1">
                Read Case Study
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </span>
            </div>
          </router-link>
        </div>

        <!-- Pagination -->
        <div v-if="pagination.lastPage > 1" class="flex items-center justify-center gap-2 mt-10">
          <button
            v-for="page in pagination.lastPage"
            :key="page"
            @click="fetchCaseStudies(page)"
            :class="['w-9 h-9 rounded-lg text-sm font-medium transition', page === pagination.currentPage ? 'bg-primary text-white' : 'bg-card border border-border text-muted-foreground hover:border-primary']"
          >{{ page }}</button>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CTA ═══════════════ -->
    <section class="py-16 md:py-20 bg-black text-white">
      <div class="absolute inset-0 opacity-30 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
      <div class="relative container mx-auto px-6 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">Have a Project in Mind?</h2>
        <p class="text-white/70 text-sm max-w-lg mx-auto mb-8">Let's discuss how our expertise can help your organization achieve its goals. Reach out for a free consultation.</p>
        <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-white text-foreground text-sm font-semibold rounded-full hover:bg-white/90 transition-all shadow-lg">
          Get in Touch
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
        </router-link>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import heroLaptopDark from '@/../img/tech-background.png';
import heroTech7 from '@/../img/tech7.jpg';
import PublicLayout from '@/layouts/PublicLayout.vue';
import api from '@/services/api';
import { useCmsStore } from '@/stores/cms';

const cmsStore = useCmsStore();
const s = computed(() => cmsStore.homeData?.settings || {} as any);
const loading = ref(true);
const caseStudies = ref<any[]>([]);
const industries = ref<string[]>([]);
const activeIndustry = ref('');
const pagination = ref({
  currentPage: 1,
  lastPage: 1,
  total: 0,
});

const filteredCaseStudies = computed(() => {
  if (!activeIndustry.value) return caseStudies.value;
  return caseStudies.value.filter((cs: any) => cs.industry === activeIndustry.value);
});

async function fetchCaseStudies(page = 1) {
  loading.value = true;
  try {
    const { data } = await api.get('/api/v1/case-studies', {
      params: { page },
    });
    caseStudies.value = data.case_studies?.data || data.case_studies || [];
    industries.value = data.industries || [];
    if (data.case_studies?.current_page) {
      pagination.value = {
        currentPage: data.case_studies.current_page,
        lastPage: data.case_studies.last_page,
        total: data.case_studies.total,
      };
    }
  } catch (e) {
    console.error('Failed to load case studies', e);
  } finally {
    loading.value = false;
  }
}

onMounted(() => fetchCaseStudies());
</script>
