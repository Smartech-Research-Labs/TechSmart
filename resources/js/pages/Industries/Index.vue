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

    <!-- ═══════════════ WHY CHOOSE US FOR INDUSTRIES ═══════════════ -->
    <section class="py-12 md:py-16">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Partner With Us</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground">Why Choose OmniviaTech for Your Industry</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="(reason, i) in industryReasons" :key="i" class="relative group">
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 z-20">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </div>
            <div class="relative rounded-2xl p-7 transition-all duration-300 overflow-hidden h-full shadow-lg hover:shadow-2xl transform group-hover:-translate-y-2" style="background-color: #262626; border: 1px solid #404040;">
              <div class="absolute inset-0 opacity-0 group-hover:opacity-20 bg-gradient-to-br from-primary/20 to-primary/10 transition-opacity duration-500"></div>
              <div class="absolute -top-6 -right-6 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-150 group-hover:bg-primary/10 transition-all duration-500"></div>
              <div class="relative z-10">
                <div class="w-14 h-14 bg-gradient-to-br from-primary/30 to-primary/20 rounded-xl flex items-center justify-center mb-5 group-hover:from-primary/50 group-hover:to-primary/30 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <span class="text-3xl" v-html="reason.icon"></span>
                </div>
                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary transition-colors">{{ reason.title }}</h3>
                <p class="text-white/80 text-sm leading-relaxed group-hover:text-white/90 transition-colors">{{ reason.desc }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ TESTIMONIALS CAROUSEL ═══════════════ -->
    <section v-if="topReviews.length" class="py-12 md:py-16 bg-muted/20">
      <div class="container mx-auto px-6 max-w-6xl">
          <div class="text-center max-w-xl mx-auto mb-10">
            <p class="text-amber-600 dark:text-amber-400 text-xs font-semibold tracking-widest uppercase mb-2">Testimonials</p>
            <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight mb-3">Industry Leaders Trust OmniviaTech</h2>
            <p class="text-muted-foreground text-xs leading-relaxed">See what industry leaders say about our specialized technology solutions.</p>
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
              <div class="rounded-lg p-5 h-full flex flex-col shadow-md hover:shadow-xl transition-all" style="background-color: #262626; border: 1px solid rgba(255,255,255,0.1);">
                <div class="flex gap-0.5 mb-3">
                  <svg v-for="s in review.rating" :key="s" class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                </div>
                <p class="text-white/80 text-sm leading-relaxed mb-4 flex-1 line-clamp-3">"{{ review.comment }}"</p>
                <div class="flex items-center gap-3 pt-4" style="border-top: 1px solid rgba(255,255,255,0.1)">
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

      <!-- ═══════════════ BLOG ═══════════════ -->
      <section v-if="recentBlogs.length" class="py-12 md:py-16 bg-muted/30">
        <div class="container mx-auto px-6 max-w-5xl">
          <div class="text-center max-w-2xl mx-auto mb-10">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Latest Insights</p>
            <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight">Industry Trends & Insights</h2>
            <p class="text-muted-foreground text-xs leading-relaxed mt-2">Learn from our blog about industry-specific technology trends and best practices.</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <router-link v-for="post in recentBlogs.slice(0, 4)" :key="post.id" :to="`/blog/${post.slug}`" class="group bg-white border border-border rounded-2xl overflow-hidden hover:border-primary/20 hover:shadow-md transition-all duration-300">
              <div class="aspect-[4/3] bg-gray-100 overflow-hidden">
                <img v-if="post.featured_image" :src="post.featured_image" :alt="post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/5 to-accent/5">
                  <svg class="w-10 h-10 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                </div>
              </div>
              <div class="p-5">
                <div class="flex items-center gap-2 mb-2">
                  <span class="text-xs font-medium text-primary bg-primary/10 px-2.5 py-1 rounded-full">{{ post.category }}</span>
                  <span class="text-muted-foreground text-xs">{{ formatDate(post.published_at) }}</span>
                </div>
                <h3 class="text-sm font-semibold text-foreground mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ post.title }}</h3>
                <p class="text-muted-foreground text-xs leading-relaxed line-clamp-2">{{ post.excerpt }}</p>
              </div>
            </router-link>
          </div>
        </div>
      </section>

      <!-- ═══════════════ FAQ ═══════════════ -->
      <section v-if="industriesFaqs.length" class="py-12 md:py-16 bg-muted/30">
        <div class="container mx-auto px-6 max-w-3xl">
          <div class="text-center mb-10">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
            <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight">Frequently Asked Questions About Our Industry Solutions</h2>
          </div>

          <div class="space-y-3">
            <div v-for="(faq, idx) in industriesFaqs" :key="idx" class="bg-white border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
              <button @click="toggleFaq(idx)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
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
import axios from 'axios';
import { Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref, computed, onMounted } from 'vue';
import heroLaptop from '@/../img/Laptop.webp';
import heroTechBg from '@/../img/tech-background.webp';
import { useApi } from '@/composables/useApi';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useCmsStore } from '@/stores/cms';
import 'swiper/css';
import 'swiper/css/pagination';

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

// Testimonials & Blog
const topReviews = ref<any[]>([]);
const recentBlogs = ref<any[]>([]);
const openFaqIndex = ref<number | null>(null);

const testimonialsPagination = {
  clickable: true,
  dynamicBullets: true,
};

const testimonialsAutoplay = {
  delay: 5000,
  disableOnInteraction: false,
};

  const industryReasons = [
  { icon: '🎯', title: 'Industry Specialization', desc: 'We have deep expertise in your specific industry, understanding regulatory requirements, workflows, and challenges.' },
  { icon: '📊', title: 'Data-Driven Solutions', desc: 'Our solutions leverage industry analytics and AI to provide actionable insights that drive business growth.' },
  { icon: '⚙️', title: 'Seamless Integration', desc: 'We integrate with your existing systems and workflows, ensuring minimal disruption during implementation.' },
  { icon: '🔒', title: 'Industry Compliance', desc: 'Full compliance with industry-specific regulations including HIPAA, PCI-DSS, GDPR, and more.' },
  { icon: '📈', title: 'Proven ROI', desc: 'Measurable results with documented success stories from leading companies in your industry.' },
  { icon: '🤝', title: 'Ongoing Partnership', desc: 'Long-term support and continuous optimization to adapt to industry changes and business growth.' },
];

const industriesFaqs = [
  { question: 'Can you deliver solutions for regulated industries?', answer: 'Yes, absolutely. We have extensive experience delivering solutions for highly regulated industries including healthcare, finance, and government. We ensure full compliance with all relevant regulations (HIPAA, GDPR, PCI-DSS, etc.) and maintain all necessary certifications.' },
  { question: 'How do you ensure data security for industry-specific solutions?', answer: 'Security is built into every layer. We implement industry-standard encryption, access controls, audit logging, regular penetration testing, and continuous monitoring. Our team stays updated on emerging threats specific to your industry.' },
  { question: 'Do you have experience with legacy systems in specific industries?', answer: 'Yes, we regularly work with legacy systems across industries. We can modernize existing solutions, migrate data safely, integrate new technologies with old systems, and ensure zero downtime during transitions.' },
  { question: 'How long do industry-specific implementations typically take?', answer: 'Timelines vary based on complexity and industry requirements. Simple implementations might take 8-12 weeks, while enterprise-wide transformations can take 6+ months. We break projects into phases for faster time-to-value.' },
  { question: 'Can you help with industry certifications (ISO, etc.)?', answer: 'We incorporate certification requirements into our development process and can assist with documentation and audit readiness. While we are not certification bodies, our solutions are designed to meet certification standards.' },
  { question: 'What industries have you worked with?', answer: 'We have delivered solutions for healthcare, finance, e-commerce, manufacturing, energy, agriculture, logistics, telecommunications, government, and more. Contact us to discuss your specific industry needs.' },
];

async function loadReviews() {
  try {
    const { data } = await axios.get('/api/v1/reviews', { params: { limit: 8 } });
    topReviews.value = data.data || [];
  } catch { console.log('Error loading reviews'); }
}

async function loadBlogs() {
  try {
    const { data } = await axios.get('/api/v1/blogs', { params: { limit: 4 } });
    recentBlogs.value = data.data || [];
  } catch { console.log('Error loading blogs'); }
}

function toggleFaq(index: number) {
  openFaqIndex.value = openFaqIndex.value === index ? null : index;
}

function formatDate(date: string) {
  return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

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

onMounted(() => {
  loadReviews();
  loadBlogs();
});
</script>
