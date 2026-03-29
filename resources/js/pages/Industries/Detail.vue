<template>
  <PublicLayout>
    <!-- Loading -->
    <div v-if="loading" class="py-20 text-center">
      <div class="inline-block w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <template v-else-if="industry">
      <!-- ═══════════════ 1. HERO ═══════════════ -->
      <section class="relative min-h-[50vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
          <img
            :src="industry.banner_image || industry.image || 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1920&h=1080&fit=crop&q=80'"
            :alt="industry.title"
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-gradient-to-r from-background/95 via-background/85 to-background/50 dark:from-background/95 dark:via-background/85 dark:to-background/60"></div>
        </div>
        <div class="relative z-10 container mx-auto px-6 py-16 md:py-24">
          <div class="max-w-2xl">
            <div class="flex items-center gap-2 mb-4">
              <span class="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full border border-primary/20">{{ industry.title }}</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-foreground leading-tight mb-4">{{ industry.title }}</h1>
            <p class="text-muted-foreground text-base md:text-lg leading-relaxed mb-8 max-w-xl">{{ industry.short_description }}</p>
            <div class="flex flex-wrap gap-3">
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                Get a Quote
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
              <router-link to="/industries" class="inline-flex items-center gap-2 px-7 py-3 border border-border bg-card text-foreground text-sm font-semibold rounded-full hover:bg-muted transition-all">
                All Industries
              </router-link>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 2. ABOUT / DESCRIPTION ═══════════════ -->
      <section v-if="industry.description" class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About This Industry</p>
              <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">{{ industry.title }} Solutions</h2>
              <div class="text-muted-foreground text-sm leading-relaxed space-y-3" v-html="formattedDescription"></div>
            </div>
            <div class="rounded-xl overflow-hidden">
              <img
                :src="industry.image || 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800&h=600&fit=crop&q=80'"
                :alt="industry.title"
                class="w-full h-full object-cover aspect-[4/3]"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 3. STATS ROW ═══════════════ -->
      <section v-if="industry.stats?.length" class="py-10 bg-muted/30 border-y border-border">
        <div class="container mx-auto px-6">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div v-for="(stat, i) in industry.stats" :key="i">
              <p class="text-2xl md:text-3xl font-bold text-primary mb-1">{{ stat.value }}</p>
              <p class="text-xs text-muted-foreground">{{ stat.label }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 4. SUB-SECTORS ═══════════════ -->
      <section v-if="industry.sub_sectors?.length" class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Sub-Sectors</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground mb-4">Specialized Areas We Serve</h2>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div
              v-for="(sub, i) in industry.sub_sectors"
              :key="i"
              class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 hover:shadow-md transition-all"
            >
              <div class="w-10 h-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4 text-lg">
                {{ sub.icon || '📋' }}
              </div>
              <h3 class="text-sm font-semibold text-foreground mb-2">{{ sub.name }}</h3>
              <p class="text-xs text-muted-foreground leading-relaxed">{{ sub.description }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 5. FEATURES ═══════════════ -->
      <section v-if="industry.features?.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Key Features</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground mb-4">What We Deliver</h2>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 max-w-4xl mx-auto">
            <div
              v-for="(feat, i) in industry.features"
              :key="i"
              class="flex gap-4 bg-card border border-border rounded-xl p-5 hover:border-primary/30 transition-all"
            >
              <div class="w-8 h-8 shrink-0 bg-primary/10 text-primary rounded-full flex items-center justify-center text-sm font-bold">
                {{ i + 1 }}
              </div>
              <div>
                <h3 class="text-sm font-semibold text-foreground mb-1">{{ feat.title }}</h3>
                <p class="text-xs text-muted-foreground leading-relaxed">{{ feat.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 6. PROCESS STEPS ═══════════════ -->
      <section v-if="industry.process_steps?.length" class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Process</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground mb-4">How We Work</h2>
          </div>
          <div class="max-w-3xl mx-auto space-y-4">
            <div
              v-for="(step, i) in industry.process_steps"
              :key="i"
              class="flex gap-6 items-start"
            >
              <div class="flex flex-col items-center shrink-0">
                <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center text-sm font-bold">
                  {{ i + 1 }}
                </div>
                <div v-if="i < industry.process_steps.length - 1" class="w-px flex-1 bg-border mt-2"></div>
              </div>
              <div class="pb-8">
                <h3 class="text-sm font-semibold text-foreground mb-1">{{ step.title }}</h3>
                <p class="text-xs text-muted-foreground leading-relaxed">{{ step.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 7. CTA ═══════════════ -->
      <section class="py-14 md:py-20 bg-gradient-to-r from-primary to-accent text-white">
        <div class="container mx-auto px-6 text-center max-w-2xl">
          <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ industry.cta_title || `Ready to Transform Your ${industry.title} Business?` }}</h2>
          <p class="text-white/80 text-sm leading-relaxed mb-6">{{ industry.cta_description || `Let our experts help you leverage cutting-edge technology in the ${industry.title} sector. Start your consultation today.` }}</p>
          <div class="flex flex-wrap justify-center gap-3">
            <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-white text-primary text-sm font-semibold rounded-full hover:bg-white/90 transition-all shadow-lg">
              Start a Project
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
            <router-link to="/services" class="inline-flex items-center gap-2 px-7 py-3 border border-white/30 text-white text-sm font-semibold rounded-full hover:bg-white/10 transition-all">
              View All Services
            </router-link>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 8. RELATED INDUSTRIES ═══════════════ -->
      <section v-if="relatedIndustries.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-10">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Explore More</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground mb-4">Other Industries</h2>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <router-link
              v-for="rel in relatedIndustries"
              :key="rel.id"
              :to="`/industries/${rel.slug}`"
              class="group bg-card border border-border rounded-xl overflow-hidden hover:border-primary/30 hover:shadow-lg transition-all"
            >
              <div class="aspect-[4/3] bg-muted overflow-hidden">
                <img v-if="rel.image" :src="rel.image" :alt="rel.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-accent/10">
                  <span class="text-3xl">🏢</span>
                </div>
              </div>
              <div class="p-4">
                <h3 class="text-sm font-semibold text-foreground group-hover:text-primary transition-colors">{{ rel.title }}</h3>
                <p class="text-xs text-muted-foreground line-clamp-2 mt-1">{{ rel.short_description }}</p>
              </div>
            </router-link>
          </div>
        </div>
      </section>
    </template>

    <!-- Not Found -->
    <div v-else class="py-20 text-center">
      <h2 class="text-xl font-bold text-foreground mb-2">Industry Not Found</h2>
      <p class="text-muted-foreground text-sm mb-6">The industry you're looking for doesn't exist or has been removed.</p>
      <router-link to="/industries" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition">
        Browse Industries
      </router-link>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useApi } from '@/composables/useApi';

const route = useRoute();
const router = useRouter();
const { get } = useApi();

interface Industry {
  id: number;
  title: string;
  slug: string;
  short_description: string;
  description: string;
  icon: string;
  image: string;
  banner_image: string;
  sub_sectors: { name: string; description: string; icon: string }[];
  process_steps: { title: string; description: string; icon: string }[];
  features: { title: string; description: string }[];
  stats: { value: string; label: string }[];
  cta_title: string;
  cta_description: string;
  meta_title: string;
  meta_description: string;
}

const loading = ref(true);
const industry = ref<Industry | null>(null);
const allIndustries = ref<Industry[]>([]);

const formattedDescription = computed(() => {
  if (!industry.value?.description) return '';
  return industry.value.description
    .split('\n')
    .filter(Boolean)
    .map(p => `<p>${p}</p>`)
    .join('');
});

const relatedIndustries = computed(() => {
  if (!industry.value) return [];
  return allIndustries.value
    .filter(i => i.id !== industry.value!.id)
    .slice(0, 4);
});

async function fetchIndustry(slug: string) {
  loading.value = true;
  try {
    const [detailData, listData] = await Promise.all([
      get(`/industries/${slug}`),
      get('/industries'),
    ]);
    industry.value = detailData.industry || null;
    allIndustries.value = listData.industries || [];

    // Update page title for SEO
    if (industry.value?.meta_title) {
      document.title = industry.value.meta_title;
    } else if (industry.value?.title) {
      document.title = `${industry.value.title} | Industries`;
    }
  } catch {
    industry.value = null;
  } finally {
    loading.value = false;
  }
}

onMounted(() => fetchIndustry(route.params.slug as string));

watch(() => route.params.slug, (newSlug) => {
  if (newSlug && route.path.startsWith('/industries/')) {
    fetchIndustry(newSlug as string);
    window.scrollTo(0, 0);
  }
});
</script>
