<template>
  <PublicLayout>
    <div v-if="loading" class="py-20 text-center">
      <div class="inline-block w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <template v-else-if="bundle">
      <!-- ═══════════════ HERO ═══════════════ -->
      <section class="relative py-16 md:py-24 overflow-hidden">
        <div class="absolute inset-0 z-0">
          <img :src="bundle.image || heroTechBg" alt="" class="w-full h-full object-cover" />
          <div class="absolute inset-0 bg-black/50"></div>
        </div>
        <div class="relative z-10 container mx-auto px-6">
          <div class="max-w-xl">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Bundle Package</p>
            <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">{{ bundle.name }}</h1>
            <p v-if="bundle.short_description" class="text-white/80 text-sm leading-relaxed mb-6">{{ bundle.short_description }}</p>
            <router-link :to="`/contact?bundle=${bundle.slug}`" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
              Get This Bundle
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
          </div>
        </div>
        <PageHeroAside :image="pageImg.tech" :title="`Get the ${bundle.name} bundle`" :to="`/contact?bundle=${bundle.slug}`" :label="'Get This Bundle'" />
      </section>

      <PageBento v-bind="bentoBlock" />

      <div class="container mx-auto px-6 py-14 md:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <div class="lg:col-span-2 space-y-6">
            <div v-if="bundle.description" class="bg-card border border-border rounded-2xl p-8">
              <h2 class="text-xl font-bold text-foreground mb-4">Bundle Overview</h2>
              <div class="prose prose-sm max-w-none prose-p:text-muted-foreground" v-html="bundle.description"></div>
            </div>

            <div v-if="whatsIncluded.length" class="bg-card border border-border rounded-2xl p-8">
              <h2 class="text-xl font-bold text-foreground mb-4">What's Included</h2>
              <div class="space-y-3">
                <div v-for="(item, i) in whatsIncluded" :key="i" class="flex items-start gap-3 p-4 bg-muted/30 rounded-lg">
                  <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                  <span class="text-foreground text-sm font-medium">{{ item }}</span>
                </div>
              </div>
            </div>

            <div v-if="bundle.items?.length" class="bg-card border border-border rounded-2xl p-8">
              <h2 class="text-xl font-bold text-foreground mb-4">Bundled Services &amp; Products</h2>
              <div class="grid sm:grid-cols-2 gap-3">
                <div v-for="item in bundle.items" :key="item.id" class="flex items-center gap-3 p-3 bg-muted/30 rounded-lg">
                  <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center shrink-0 text-primary text-sm font-bold">
                    {{ item.quantity || 1 }}×
                  </div>
                  <span class="text-foreground text-sm font-medium">{{ item.bundleable?.name || item.bundleable?.title || 'Item' }}</span>
                </div>
              </div>
            </div>
          </div>

          <div class="lg:col-span-1">
            <div class="bg-card border border-border rounded-2xl p-6 sticky top-24">
              <div class="mb-6">
                <p class="text-xs text-muted-foreground font-medium mb-1">Bundle Price</p>
                <p class="text-3xl font-bold text-foreground mb-1">Ksh {{ Number(bundle.price).toLocaleString() }}</p>
                <p v-if="bundle.price_label" class="text-sm text-primary">{{ bundle.price_label }}</p>
              </div>
              <router-link
                :to="`/contact?bundle=${bundle.slug}`"
                class="block w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-lg text-center transition mb-3"
              >
                Get This Bundle
              </router-link>
              <router-link to="/bundles" class="block w-full border border-border hover:bg-muted text-foreground font-semibold py-3 px-6 rounded-lg text-center transition">
                View All Bundles
              </router-link>
            </div>
          </div>
        </div>
      </div>
      <PageSplit v-bind="splitBlock" />

      <PageImageCards v-bind="cardsBlock" />

    </template>

    <!-- Not Found -->
    <div v-else class="py-20 text-center">
      <h2 class="text-2xl font-bold text-foreground mb-2">Bundle Not Found</h2>
      <p class="text-muted-foreground mb-6">The bundle you're looking for doesn't exist or has been removed.</p>
      <router-link to="/bundles" class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition">Browse Bundles</router-link>
    </div>
    <PageProcess />
    <PageCta title="Need this bundle adapted to your business?" />
  </PublicLayout>
</template>

<script setup lang="ts">
import { computed, ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import heroTechBg from '@/../img/tech-background.webp';
import PageBento from '@/components/PageBento.vue';
import PageCta from '@/components/PageCta.vue';
import PageHeroAside from '@/components/PageHeroAside.vue';
import PageImageCards from '@/components/PageImageCards.vue';
import PageProcess from '@/components/PageProcess.vue';
import PageSplit from '@/components/PageSplit.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { pageImg } from '@/lib/pageImages';
import api from '@/services/api';

const route = useRoute();
const loading = ref(true);
const bundle = ref<any>(null);

const whatsIncluded = computed(() => {
  const w = bundle.value?.whats_included;
  if (!w) return [];
  return Array.isArray(w) ? w : [];
});

async function fetchBundle(slug: string) {
  loading.value = true;
  try {
    const { data } = await api.get(`/api/v1/bundles/${slug}`);
    bundle.value = data;
  } catch (e) {
    console.error('Failed to load bundle', e);
    bundle.value = null;
  } finally {
    loading.value = false;
  }
}

onMounted(() => fetchBundle(route.params.slug as string));

watch(() => route.params.slug, (newSlug) => {
  if (newSlug) fetchBundle(newSlug as string);
});

// Inner-page design blocks (bento row, split panel, image cards)
const bentoBlock = computed(() => ({
  eyebrow: 'Bundle Overview',
  title: `Why Choose ${bundle.value?.name || 'This Bundle'}`,
  image: bundle.value?.image || pageImg.tech2,
  imageTitle: 'Services and Products, Combined',
  statLabel: 'Items included',
  statValue: String(bundle.value?.items?.length || whatsIncluded.value.length || 1),
  statUnit: '',
  cards: [
    { icon: '💰', title: 'Better Value', text: bundle.value?.short_description || 'Bundled pricing costs less than buying each service separately.' },
    { icon: '🤝', title: 'One Team, One Plan', text: 'A single point of contact manages every part of your bundle from kickoff to launch and beyond.' },
  ],
}));
const splitBlock = computed(() => ({
  eyebrow: 'Tailored For You',
  title: 'Adapting Your Bundle Made Easy',
  text: 'Need to add, swap or remove something? We will adjust this bundle to fit your goals, timeline and budget.',
  points: ['Mix and match services and products', 'One contract, one invoice, one team'],
  image: pageImg.tech5,
  statLabel: 'Bundles delivered',
  statValue: '60',
  statUnit: '+',
  statIcon: '📦',
  note: 'One partner for everything digital',
  noteIcon: '🤝',
  ctaLabel: 'Get This Bundle',
  ctaTo: `/contact?bundle=${bundle.value?.slug || ''}`,
}));
const cardsBlock = {
  "eyebrow": "Explore More",
  "title": "Other Ways We Can Help",
  "items": [
    {
      "icon": "💼",
      "title": "All Bundles",
      "text": "Compare all of our solution bundles.",
      "to": "/bundles",
      "image": pageImg.tech2
    },
    {
      "icon": "💻",
      "title": "Our Services",
      "text": "Web, mobile, cloud and automation built around your goals.",
      "to": "/services",
      "image": pageImg.svcCustomWeb
    },
    {
      "icon": "🚀",
      "title": "Products",
      "text": "Ready-made software you can deploy and grow with.",
      "to": "/products",
      "image": pageImg.orbit
    }
  ]
};

</script>
