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
            :src="industry.banner_image || industry.image || heroTechBg"
            :alt="industry.title"
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-black/50"></div>
        </div>
        <div class="relative z-10 container mx-auto px-6 py-16 md:py-24">
          <div class="max-w-2xl">
            <div class="flex items-center gap-2 mb-4">
              <span class="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full border border-primary/20">{{ industry.title }}</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">{{ industry.title }}</h1>
            <p class="text-white/80 text-base md:text-lg leading-relaxed mb-8 max-w-xl">{{ industry.short_description }}</p>
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
        <PageHeroAside :image="pageImg.population" :title="`Transform your ${industry.title} business`" />
      </section>

      <PageBento v-bind="bentoBlock" />

      <!-- ═══════════════ 2. ABOUT / DESCRIPTION ═══════════════ -->
      <section v-if="industry.description" class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About This Industry</p>
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">{{ industry.title }} Solutions</h2>
              <div class="text-muted-foreground text-sm leading-relaxed space-y-3" v-html="formattedDescription"></div>
            </div>
            <div class="rounded-xl overflow-hidden">
              <img
                :src="industry.image || heroLaptop"
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
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground mb-4">Specialized Areas We Serve</h2>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div
              v-for="(sub, i) in industry.sub_sectors"
              :key="i"
              class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 hover:shadow-md transition-all"
            >
              <div class="w-10 h-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4 text-lg">
                <PageIcon :icon="sub.icon || '📋'" />
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
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground mb-4">What We Deliver</h2>
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
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground mb-4">How We Work</h2>
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
      <PageSplit v-bind="splitBlock" />

      <section class="py-14 md:py-20 bg-gradient-to-r from-primary to-accent text-white">
        <div class="container mx-auto px-6 text-center max-w-2xl">
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">{{ industry.cta_title || `Ready to Transform Your ${industry.title} Business?` }}</h2>
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

      <!-- ═══════════════ 8. TESTIMONIALS CAROUSEL ═══════════════ -->
            <section v-if="topReviews.length" class="py-12 md:py-16 bg-muted/20">
              <div class="container mx-auto px-6 max-w-6xl">
                <div class="text-center max-w-xl mx-auto mb-10">
                  <p class="text-amber-600 dark:text-amber-400 text-xs font-semibold tracking-widest uppercase mb-2">Testimonials</p>
                  <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-3">Success Stories from {{ industry.title }} Leaders</h2>
                  <p class="text-muted-foreground text-xs leading-relaxed">See how our solutions have transformed {{ industry.title }} businesses.</p>
                </div>

                <Swiper
                  :modules="[Autoplay, Pagination]"
                  :slides-per-view="1"
                  :space-between="16"
                  :pagination="testimonialsPagination"
                  :autoplay="testimonialsAutoplay"
                  :breakpoints="{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 }, 1280: { slidesPerView: 4 } }"
                  class="testimonials-swiper pb-16"
                >
                  <SwiperSlide v-for="review in topReviews" :key="review.id">
                    <div class="rounded-lg p-5 h-full flex flex-col shadow-md hover:shadow-xl transition-all bg-gray-900 border border-white/10">
                      <div class="flex gap-0.5 mb-3">
                        <svg v-for="s in review.rating" :key="s" class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                      </div>
                      <p class="text-white/80 text-sm leading-relaxed mb-4 flex-1 line-clamp-3">"{{ review.comment }}"</p>
                      <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                        <div class="w-9 h-9 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                          {{ review.user_name?.charAt(0).toUpperCase() }}
                        </div>
                        <div class="min-w-0">
                          <div class="font-semibold text-white text-sm truncate">{{ review.user_name }}</div>
                          <div class="text-white/60 text-xs truncate">{{ review.company || 'Verified Client' }}</div>
                        </div>
                      </div>
                    </div>
                  </SwiperSlide>
                </Swiper>
              </div>
            </section>

            <!-- ═══════════════ 9. FAQ ═══════════════ -->
            <section v-if="industryFaqs.length" class="py-12 md:py-16 bg-muted/30">
              <div class="container mx-auto px-6 max-w-3xl">
                <div class="text-center mb-10">
                  <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
                  <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight">Common Questions About {{ industry.title }} Solutions</h2>
                </div>

                <div class="space-y-3">
                  <div v-for="(faq, idx) in industryFaqs" :key="idx" class="bg-card border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <button @click="toggleFaq(idx)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/40 transition-colors">
                      <span class="font-medium text-foreground text-sm pr-6">{{ faq.question }}</span>
                      <svg class="w-5 h-5 text-muted-foreground shrink-0 transition-transform duration-200" :class="{ 'rotate-180': openFaqIndex === idx }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div v-show="openFaqIndex === idx" class="px-6 pb-5">
                      <p class="text-muted-foreground text-sm leading-relaxed">{{ faq.answer }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <!-- ═══════════════ 10. RELATED INDUSTRIES ═══════════════ -->
      <PageImageCards v-bind="cardsBlock" />

      <section v-if="relatedIndustries.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-10">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Explore More</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground mb-4">Other Industries</h2>
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
                  <PageIcon icon="🏢" />
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
import axios from 'axios';
import { Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import heroLaptop from '@/../img/Laptop.webp';
import heroTechBg from '@/../img/tech-background.webp';
import PageBento from '@/components/PageBento.vue';
import PageHeroAside from '@/components/PageHeroAside.vue';
import PageIcon from '@/components/PageIcon.vue';
import PageImageCards from '@/components/PageImageCards.vue';
import PageSplit from '@/components/PageSplit.vue';
import { useApi } from '@/composables/useApi';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { pageImg } from '@/lib/pageImages';
import 'swiper/css';
import 'swiper/css/pagination';

const route = useRoute();
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

// Testimonials & FAQ
const topReviews = ref<any[]>([]);
const openFaqIndex = ref<number | null>(null);

const testimonialsPagination = {
  clickable: true,
  dynamicBullets: true,
};

const testimonialsAutoplay = {
  delay: 5000,
  disableOnInteraction: false,
};

const industryFaqs = computed(() => {
  if (!industry.value) return [];
  return [
    { question: `What are the key challenges in the ${industry.value.title} industry?`, answer: `The ${industry.value.title} industry faces unique challenges including regulatory compliance, operational efficiency, data management, security, and the need for digital transformation. We understand these challenges deeply and design solutions that address them specifically.` },
    { question: `How can technology improve our ${industry.value.title} business?`, answer: `Technology can streamline operations, reduce costs, improve customer experience, enable data-driven decision-making, enhance security, and open new revenue streams. Our solutions are built specifically for ${industry.value.title} use cases.` },
    { question: `Is your solution compliant with industry standards?`, answer: `Yes, our solutions are designed with industry compliance in mind, meeting all relevant regulatory requirements specific to the ${industry.value.title} sector including data protection, security, and operational standards.` },
    { question: `How long does implementation take in this industry?`, answer: `Implementation timelines depend on complexity and current infrastructure. Typical timelines range from 8 weeks for moderate implementations to 6+ months for complex enterprise transformations. We can break projects into phases for faster value delivery.` },
    { question: `Can you integrate with our existing systems?`, answer: `Absolutely. We specialize in integrating new solutions with legacy systems specific to the ${industry.value.title} industry. We ensure minimal disruption and data integrity during the transition.` },
    { question: `What kind of support do you provide post-launch?`, answer: `We provide comprehensive post-launch support including 24/7 monitoring, regular updates, security patches, performance optimization, and feature enhancements. Our team stays with you to ensure continuous improvement.` },
  ];
});

async function loadReviews() {
  try {
    const { data } = await axios.get('/api/v1/reviews', { params: { limit: 8 } });
    topReviews.value = data.data || [];
  } catch { /* Error loading reviews */ }
}

function toggleFaq(index: number) {
  openFaqIndex.value = openFaqIndex.value === index ? null : index;
}

async function fetchIndustry(slug: string) {
  loading.value = true;
  try {
    const [detailData, listData] = await Promise.all([
      get(`/industries/${slug}`),
      get('/industries'),
    ]);
    industry.value = detailData.industry || null;
    allIndustries.value = listData.industries || [];
  } catch {
    industry.value = null;
  } finally {
    loading.value = false;
  }
}

onMounted(() => fetchIndustry(route.params.slug as string));
onMounted(() => loadReviews());

watch(() => route.params.slug, (newSlug) => {
  if (newSlug && route.path.startsWith('/industries/')) {
    fetchIndustry(newSlug as string);
    window.scrollTo(0, 0);
  }
});

// Inner-page design blocks (bento row, split panel, image cards)
const bentoBlock = computed(() => ({
  eyebrow: 'Industry Focus',
  title: `Technology Built for ${industry.value?.title || 'Your Industry'}`,
  image: industry.value?.image || pageImg.population,
  imageTitle: `${industry.value?.title || 'Industry'} Solutions That Deliver`,
  statLabel: industry.value?.stats?.[0]?.label || 'Projects delivered',
  statValue: industry.value?.stats?.[0]?.value || '500+',
  statUnit: '',
  cards: [
    { icon: '🎯', title: 'Sector Know-How', text: 'We understand the workflows, regulations and customers in your industry, so solutions fit how you really work.' },
    { icon: '📊', title: 'Measurable Outcomes', text: 'We track the results that matter in your sector, from faster service to lower costs and better reporting.' },
  ],
}));
const splitBlock = computed(() => ({
  eyebrow: 'How We Help',
  title: `${industry.value?.title || 'Industry'} Transformation Made Easy`,
  text: 'We bring proven solutions, adapt them to your exact needs and support your team every step of the way.',
  points: ['Compliance-aware, secure solutions', 'Integrations with the tools you already use'],
  image: pageImg.tech4,
  statLabel: 'Client satisfaction',
  statValue: '95',
  statUnit: '%',
  statIcon: '🏆',
  note: 'Proven across Africa and beyond',
  noteIcon: '🌍',
}));
const cardsBlock = {
  "eyebrow": "Keep Exploring",
  "title": "See How We Deliver",
  "items": [
    {
      "icon": "🏆",
      "title": "Case Studies",
      "text": "Real projects and the results they delivered.",
      "to": "/case-studies",
      "image": pageImg.tech7
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
