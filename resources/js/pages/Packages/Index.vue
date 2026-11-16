<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="heroLaptopDark" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Packages</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Website Solutions for Every Business</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">Choose the perfect package that matches your business needs and budget. All packages include professional support and ongoing maintenance.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Get a Consultation
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ PACKAGES GRID ═══════════════ -->
    <section class="py-14 md:py-20 bg-slate-100 dark:bg-gray-900/40">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Offerings</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Scalable Packages for Growth</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">From startups to enterprises, we have the perfect solution. Each package is carefully designed to provide maximum value with professional support included.</p>
        </div>

        <div v-if="loading" class="text-center py-12">
          <div class="inline-block">
            <div class="w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
          </div>
        </div>

        <div
          v-else-if="packages.length > 0"
          class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-stretch mx-auto"
          :class="packages.length > 3 ? 'lg:grid-cols-4' : 'lg:grid-cols-3 max-w-5xl'"
        >
          <PackageCard v-for="(pkg, i) in packages" :key="pkg.id" :pkg="pkg" :index="i" />
        </div>

        <div v-else class="text-center py-12">
          <p class="text-muted-foreground">No packages available at the moment.</p>
        </div>
      </div>
    </section>

    <!-- ═══════════════ WHY CHOOSE OUR PACKAGES ═══════════════ -->
    <section class="py-14 md:py-20 bg-gray-900">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Our Packages</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight mb-4">Complete Solutions with Premium Support</h2>
          <p class="text-white/70 text-sm leading-relaxed">Each package includes everything you need to succeed online, with dedicated support from our expert team.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="rounded-xl p-6 border border-white/10 hover:border-primary/40 hover:bg-primary/5 transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">🎯</span></div>
            <h3 class="text-sm font-bold text-white mb-2">Custom-Tailored</h3>
            <p class="text-white/70 text-xs leading-relaxed">Each package is designed to meet specific business needs with flexibility to scale as you grow.</p>
          </div>

          <div class="rounded-xl p-6 border border-white/10 hover:border-primary/40 hover:bg-primary/5 transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">🛡️</span></div>
            <h3 class="text-sm font-bold text-white mb-2">Full Security</h3>
            <p class="text-white/70 text-xs leading-relaxed">SSL certificates, regular backups, malware protection, and GDPR compliance included in all packages.</p>
          </div>

          <div class="rounded-xl p-6 border border-white/10 hover:border-primary/40 hover:bg-primary/5 transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">⚡</span></div>
            <h3 class="text-sm font-bold text-white mb-2">Optimized Performance</h3>
            <p class="text-white/70 text-xs leading-relaxed">Lightning-fast loading times, CDN delivery, and automatic optimization for search engines.</p>
          </div>

          <div class="rounded-xl p-6 border border-white/10 hover:border-primary/40 hover:bg-primary/5 transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">📱</span></div>
            <h3 class="text-sm font-bold text-white mb-2">Mobile Ready</h3>
            <p class="text-white/70 text-xs leading-relaxed">Fully responsive design that works perfectly on all devices and screen sizes.</p>
          </div>

          <div class="rounded-xl p-6 border border-white/10 hover:border-primary/40 hover:bg-primary/5 transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">🤝</span></div>
            <h3 class="text-sm font-bold text-white mb-2">Expert Support</h3>
            <p class="text-white/70 text-xs leading-relaxed">Dedicated support team available to help with training, updates, and troubleshooting.</p>
          </div>

          <div class="rounded-xl p-6 border border-white/10 hover:border-primary/40 hover:bg-primary/5 transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">📊</span></div>
            <h3 class="text-sm font-bold text-white mb-2">Analytics Included</h3>
            <p class="text-white/70 text-xs leading-relaxed">Google Analytics, Search Console integration, and performance reports included.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ PACKAGE COMPARISON ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Package Features</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Everything You Need to Succeed</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">Compare our packages and find the perfect fit for your business goals. All packages include professional support and ongoing maintenance.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground">Professional Design</h3>
            </div>
            <p class="text-muted-foreground text-sm leading-relaxed">Custom-designed websites tailored to your brand identity with modern, responsive layouts that impress visitors.</p>
          </div>

          <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground">SEO Optimized</h3>
            </div>
            <p class="text-muted-foreground text-sm leading-relaxed">Built with SEO best practices to help your website rank higher in search results and attract organic traffic.</p>
          </div>

          <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground">Secure & Protected</h3>
            </div>
            <p class="text-muted-foreground text-sm leading-relaxed">Enterprise-level security with SSL certificates, regular backups, malware protection, and GDPR compliance.</p>
          </div>

          <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 10h4.764a2 2 0 011.789 2.894l-3.646 7.23a2 2 0 01-1.789 1.106H2a2 2 0 01-2-2V8a2 2 0 012-2h1.657a2 2 0 011.414.586l2.828 2.829a2 2 0 001.414.586h2.657a2 2 0 012 2v.5z"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground">Lightning Fast</h3>
            </div>
            <p class="text-muted-foreground text-sm leading-relaxed">Optimized for speed with CDN delivery, automatic caching, and performance enhancements for instant loading.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ TESTIMONIALS ═══════════════ -->
    <section v-if="topReviews.length" class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Success Stories</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">What Our Clients Say</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">Discover how our packages have transformed businesses across different industries.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="review in topReviews.slice(0, 3)" :key="review.id" class="bg-card border border-border rounded-xl p-6">
            <div class="flex items-center gap-1 mb-4">
              <span v-for="i in review.rating" :key="i" class="text-amber-500">★</span>
            </div>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">"{{ review.comment }}"</p>
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                <span class="text-sm font-bold text-primary">{{ review.user_name?.charAt(0).toUpperCase() }}</span>
              </div>
              <div>
                <p class="text-sm font-bold text-foreground">{{ review.user_name }}</p>
                <p class="text-xs text-muted-foreground">{{ review.company || 'Verified Client' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ SPLIT SECTION - IMAGE + TEXT ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <!-- Left - Image -->
          <div class="relative">
            <div class="rounded-2xl overflow-hidden shadow-lg">
              <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&h=500&fit=crop&q=80" alt="Package Development" loading="lazy" decoding="async" class="w-full aspect-[4/3] object-cover" />
            </div>
          </div>

          <!-- Right - Content -->
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Our Packages</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-6">Complete Website Solutions Built for Success</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-6">Our packages are designed by industry experts with years of experience in web development, SEO, and digital marketing. Each tier is carefully crafted to provide maximum value at every stage of your business growth.</p>

            <div class="space-y-4 mb-8">
              <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                  <h3 class="font-bold text-foreground mb-1">No Hidden Costs</h3>
                  <p class="text-muted-foreground text-sm">Transparent pricing with all features clearly listed. What you see is what you get.</p>
                </div>
              </div>

              <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                  <h3 class="font-bold text-foreground mb-1">24/7 Support</h3>
                  <p class="text-muted-foreground text-sm">Our support team is always available to help with any questions or issues.</p>
                </div>
              </div>

              <div class="flex items-start gap-4">
                <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                  <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                  <h3 class="font-bold text-foreground mb-1">Future-Proof</h3>
                  <p class="text-muted-foreground text-sm">Regular updates and enhancements keep your website modern and secure.</p>
                </div>
              </div>
            </div>

            <router-link to="/contact" class="inline-flex items-center gap-2 px-8 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all">
              Get Started Today
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CLIENTS SECTION ═══════════════ -->
    <section v-if="clients.length" class="py-14 md:py-20 bg-gray-900">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Partners</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight mb-4">Trusted by Leading Companies</h2>
          <p class="text-white/70 text-sm leading-relaxed">Businesses across various industries rely on our packages to power their online presence.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-center">
          <a
            v-for="client in clients.filter((c) => c.logo_url)"
            :key="client.id"
            :href="client.website_url || undefined"
            target="_blank"
            rel="noopener"
            class="flex items-center justify-center h-20 bg-white/5 rounded-xl border border-white/10 hover:border-primary/40 hover:bg-primary/5 transition-all p-4"
          >
            <img :src="client.logo_url" :alt="client.name" class="max-h-10 max-w-full object-contain" loading="lazy" />
          </a>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CTA SECTION ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="bg-primary/10 border border-primary/20 rounded-xl p-8 md:p-12 text-center">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Ready to Get Started?</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Don't Know Which Package is Right for You?</h2>
          <p class="text-muted-foreground text-sm leading-relaxed mb-8 max-w-2xl mx-auto">
            Our experts are ready to help you choose the perfect package and create a customized solution that meets your specific business goals.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <router-link
              to="/contact"
              class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all"
            >
              Schedule a Consultation
            </router-link>
            <a
              :href="`https://wa.me/${(s.whatsapp_number || s.contact_phone || '').replace(/[^0-9]/g, '')}?text=${encodeURIComponent('Hi, I would like to know more about your website packages')}`"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-white/10 border border-white/20 text-foreground text-sm font-semibold rounded-full hover:bg-white/20 transition-all"
            >
              Chat on WhatsApp
            </a>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { computed, ref, onMounted } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';
import PackageCard from '@/components/PackageCard.vue';
import heroLaptopDark from '@/../img/laptop-in-dark.webp';
import { useCmsStore } from '@/stores/cms';

const cmsStore = useCmsStore();
const s = computed(() => cmsStore.homeData?.settings || {} as any);
const clients = computed(() => cmsStore.homeData?.clients || []);
const packages = ref<any[]>([]);
const topReviews = ref<any[]>([]);
const loading = ref(true);

async function loadReviews() {
  try {
    const { data } = await axios.get('/api/v1/reviews', { params: { limit: 6 } });
    topReviews.value = data.data || [];
  } catch { /* silent */ }
}

onMounted(async () => {
  if (!cmsStore.homeData) cmsStore.fetchHomeData().catch(() => {});
  loadReviews();
  try {
    const response = await axios.get('/api/v1/packages');
    packages.value = response.data;
  } catch (error) {
    console.error('Failed to fetch packages:', error);
  } finally {
    loading.value = false;
  }
});
</script>
