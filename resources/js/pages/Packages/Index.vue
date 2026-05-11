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
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Offerings</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Scalable Packages for Growth</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">From startups to enterprises, we have the perfect solution. Each package is carefully designed to provide maximum value with professional support included.</p>
        </div>

        <div v-if="loading" class="text-center py-12">
          <div class="inline-block">
            <div class="w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
          </div>
        </div>

        <div v-else-if="packages.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <router-link
            v-for="pkg in packages"
            :key="pkg.id"
            :to="`/packages/${pkg.slug}`"
            class="group relative bg-card border border-border rounded-xl overflow-hidden hover:border-primary/50 hover:shadow-lg transition-all duration-300"
          >
            <!-- Featured Badge -->
            <div v-if="pkg.is_featured" class="absolute top-4 left-4 z-10 bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full">
              Featured
            </div>

            <!-- Image -->
            <div class="h-48 md:h-40 bg-muted overflow-hidden">
              <img
                v-if="pkg.image"
                :src="pkg.image_url"
                :alt="pkg.name"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              />
              <div v-else class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                <span class="text-4xl">📦</span>
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <!-- Highlight Text -->
              <p v-if="pkg.highlight_text" class="text-primary text-xs font-semibold tracking-widest uppercase mb-2">
                {{ pkg.highlight_text }}
              </p>

              <!-- Tier Level -->
              <p v-if="pkg.tier_level" class="text-muted-foreground text-xs mb-3">
                {{ pkg.tier_level }}
              </p>

              <!-- Title -->
              <h3 class="text-lg md:text-base font-bold text-foreground mb-2 leading-tight group-hover:text-primary transition-colors">
                {{ pkg.name }}
              </h3>

              <!-- Price -->
              <div v-if="pkg.price" class="mb-4">
                <div class="flex items-baseline gap-2">
                  <span class="text-2xl md:text-xl font-bold text-primary">KES {{ formatPrice(pkg.price) }}</span>
                  <span v-if="pkg.price_label" class="text-xs text-muted-foreground">{{ pkg.price_label }}</span>
                </div>
              </div>

              <!-- Description -->
              <p class="text-muted-foreground text-xs md:text-xs leading-relaxed mb-4 line-clamp-2">
                {{ pkg.short_description }}
              </p>

              <!-- Features Preview -->
              <div v-if="pkg.includes && pkg.includes.length > 0" class="space-y-2 mb-6">
                <div v-for="(item, idx) in pkg.includes.slice(0, 3)" :key="idx" class="flex items-start gap-2 text-xs">
                  <span class="text-primary mt-0.5">✓</span>
                  <span class="text-muted-foreground">{{ item }}</span>
                </div>
                <div v-if="pkg.includes.length > 3" class="text-xs text-primary font-semibold">
                  +{{ pkg.includes.length - 3 }} more
                </div>
              </div>

              <!-- Button -->
              <div class="flex items-center gap-2 text-primary text-sm font-semibold group-hover:gap-3 transition-all">
                View Details
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path d="M7 17L17 7M17 7H7M17 7v10"/>
                </svg>
              </div>
            </div>
          </router-link>
        </div>

        <div v-else class="text-center py-12">
          <p class="text-muted-foreground">No packages available at the moment.</p>
        </div>
      </div>
    </section>

    <!-- ═══════════════ WHY CHOOSE OUR PACKAGES ═══════════════ -->
    <section class="py-14 md:py-20 bg-[#262626]">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Our Packages</p>
          <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Complete Solutions with Premium Support</h2>
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

    <!-- ═══════════════ CTA SECTION ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="bg-primary/10 border border-primary/20 rounded-xl p-8 md:p-12 text-center">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Ready to Get Started?</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Don't Know Which Package is Right for You?</h2>
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
              href="https://wa.me/254711223344?text=Hi%2C%20I%20would%20like%20to%20know%20more%20about%20your%20website%20packages"
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
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';
import heroLaptopDark from "@/../img/laptop-in-dark.webp";

const router = useRouter();
const packages = ref([]);
const loading = ref(true);

const formatPrice = (price: number) => {
  return price.toLocaleString('en-KE', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });
};

onMounted(async () => {
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
