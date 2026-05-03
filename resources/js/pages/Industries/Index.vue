<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="heroImage" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Industries We Serve</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Technology Solutions Across Industries</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">We deliver specialized technology solutions tailored to the unique challenges of diverse industries — from healthcare and finance to manufacturing and agriculture.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Discuss Your Industry
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ ABOUT ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="rounded-xl overflow-hidden">
            <img :src="heroLaptop" alt="Industry Solutions" class="w-full h-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Deep Domain Expertise</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Solutions Built for Your Sector</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">Every industry operates differently. We bring decades of combined experience across multiple sectors to deliver technology solutions that address real-world challenges.</p>
            <p class="text-muted-foreground text-sm leading-relaxed mb-6">Our approach combines deep domain knowledge with cutting-edge technology to create solutions that drive efficiency, innovation, and growth in your specific industry.</p>
            <div class="flex flex-wrap gap-2">
              <span v-for="tag in ['IoT & Sensors', 'Data Analytics', 'Process Automation', 'Cloud Solutions', 'AI & ML']" :key="tag" class="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full">{{ tag }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ INDUSTRY CARDS ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Explore</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground mb-4">Industries We Transform</h2>
          <p class="text-muted-foreground text-sm">From healthcare to energy, discover how we help organizations leverage technology across every sector.</p>
        </div>

        <!-- Loading -->
        <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <div v-for="i in 8" :key="i" class="bg-card border border-border rounded-xl overflow-hidden animate-pulse">
            <div class="aspect-[4/3] bg-muted"></div>
            <div class="p-4 space-y-2"><div class="h-3 bg-muted rounded w-3/4"></div><div class="h-2 bg-muted rounded w-full"></div></div>
          </div>
        </div>

        <!-- Cards -->
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <router-link
            v-for="ind in industries"
            :key="ind.id"
            :to="`/industries/${ind.slug}`"
            class="group bg-card border border-border rounded-xl overflow-hidden hover:border-primary/30 hover:shadow-lg transition-all"
          >
            <div class="aspect-[4/3] bg-muted overflow-hidden relative">
              <img
                v-if="ind.image"
                :src="ind.image"
                :alt="ind.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-accent/10">
                <span class="text-4xl">{{ iconMap[ind.icon] || '🏢' }}</span>
              </div>
            </div>
            <div class="p-4">
              <h3 class="text-sm font-semibold text-foreground mb-1 group-hover:text-primary transition-colors">{{ ind.title }}</h3>
              <p class="text-muted-foreground text-xs leading-relaxed line-clamp-2">{{ ind.short_description }}</p>
              <!-- Stats chips -->
              <div v-if="ind.stats?.length" class="flex flex-wrap gap-1.5 mt-3">
                <span v-for="(stat, si) in ind.stats.slice(0, 2)" :key="si" class="text-[10px] font-medium text-primary bg-primary/10 px-2 py-0.5 rounded-full">
                  {{ stat.value }} {{ stat.label }}
                </span>
              </div>
            </div>
          </router-link>
        </div>

        <!-- Empty State -->
        <div v-if="!loading && industries.length === 0" class="text-center py-16">
          <p class="text-muted-foreground text-sm">No industries listed yet. Check back soon!</p>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CTA ═══════════════ -->
    <section class="py-14 md:py-20 bg-gradient-to-r from-primary to-accent text-white">
      <div class="container mx-auto px-6 text-center max-w-2xl">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">Don't See Your Industry?</h2>
        <p class="text-white/80 text-sm leading-relaxed mb-6">Our team has deep expertise across a wide range of sectors. Contact us to discuss how we can tailor our technology solutions for your unique industry needs.</p>
        <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-white text-primary text-sm font-semibold rounded-full hover:bg-white/90 transition-all shadow-lg">
          Talk to Our Experts
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
        </router-link>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useApi } from '@/composables/useApi';
import { useCmsStore } from '@/stores/cms';
import heroLaptop from '@/../img/Laptop.webp';
import heroTechBg from '@/../img/tech-background.png';

const { get } = useApi();
const cmsStore = useCmsStore();
const settings = computed(() => cmsStore.homeData?.settings ?? {});
const heroImage = computed(() => (settings.value as any)?.industries_page_image || heroTechBg);

interface Industry {
  id: number;
  title: string;
  slug: string;
  short_description: string;
  icon: string;
  image: string;
  stats: { value: string; label: string }[];
}

const loading = ref(true);
const industries = ref<Industry[]>([]);

const iconMap: Record<string, string> = {
  Healthcare: '🏥',
  Finance: '💰',
  Education: '🎓',
  Retail: '🛒',
  Logistics: '🚚',
  Manufacturing: '🏭',
  Agriculture: '🌾',
  Energy: '⚡',
  Government: '🏛️',
  Telecom: '📡',
};

onMounted(async () => {
  try {
    const data = await get('/industries');
    industries.value = data.industries || [];
  } catch {
    // silent
  } finally {
    loading.value = false;
  }
});
</script>
