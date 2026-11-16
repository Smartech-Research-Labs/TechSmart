<template>
  <PublicLayout>
    <!-- Loading -->
    <div v-if="loading" class="container mx-auto px-4 md:px-6 max-w-6xl py-6">
      <div class="h-[60vh] rounded-3xl bg-slate-100 dark:bg-gray-800 animate-pulse"></div>
    </div>

    <div v-else-if="pkg" class="pkg-page">
      <!-- ═══════════════ HERO ═══════════════ -->
      <section class="container mx-auto px-4 md:px-6 max-w-6xl pt-6">
        <div class="relative overflow-hidden rounded-3xl min-h-[440px] md:min-h-[520px] flex flex-col">
          <img :src="tech1" alt="" class="absolute inset-0 w-full h-full object-cover" fetchpriority="high" />
          <div class="absolute inset-0 bg-gradient-to-b from-slate-900/55 via-slate-900/25 to-slate-900/60"></div>

          <!-- Back link -->
          <router-link
            to="/packages"
            class="relative z-10 m-5 self-start inline-flex items-center gap-1.5 rounded-full bg-white/15 backdrop-blur px-3.5 py-1.5 text-xs text-white hover:bg-white/25 transition-colors"
          >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            All packages
          </router-link>

          <!-- Centered copy -->
          <div class="relative z-10 flex-1 flex flex-col items-center justify-center text-center px-6 pb-20">
            <p v-if="pkg.tier_level || pkg.highlight_text" class="text-white/80 text-xs tracking-[0.2em] uppercase mb-4">
              {{ pkg.tier_level || pkg.highlight_text }}
            </p>
            <h1 class="text-4xl md:text-6xl font-light text-white tracking-tight leading-[1.1] max-w-3xl">
              {{ pkg.name }}.<br class="hidden md:block" />
              <span class="text-white/90"> Everything in one place.</span>
            </h1>
            <p v-if="pkg.short_description" class="mt-5 text-white/85 text-sm md:text-base font-light leading-relaxed max-w-xl">
              {{ pkg.short_description }}
            </p>
            <button
              type="button"
              @click="scrollToQuote"
              class="mt-7 inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-2.5 text-sm text-white hover:bg-slate-800 transition-colors"
            >
              Request a quote
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </button>
          </div>

          <!-- Bottom bar -->
          <div class="relative z-10 flex flex-wrap items-end justify-between gap-4 px-5 pb-5">
            <div class="flex items-center gap-3">
              <p class="text-[11px] leading-tight text-white/85">Professional support<br />Monthly maintenance</p>
              <div class="flex -space-x-2 rounded-full bg-white/20 backdrop-blur p-1">
                <span class="w-7 h-7 rounded-full bg-sky-500 ring-2 ring-white/70 flex items-center justify-center text-[11px]">⚡</span>
                <span class="w-7 h-7 rounded-full bg-emerald-500 ring-2 ring-white/70 flex items-center justify-center text-[11px]">🛡️</span>
                <span class="w-7 h-7 rounded-full bg-amber-500 ring-2 ring-white/70 flex items-center justify-center text-[11px]">🤝</span>
              </div>
            </div>
            <div class="flex items-center gap-4 text-[11px] text-white/90">
              <a
                :href="`https://wa.me/${whatsappDigits}?text=${encodeURIComponent('Hi, I am interested in the ' + (pkg?.name || 'website') + ' package')}`"
                target="_blank" rel="noopener noreferrer" class="hover:text-white"
              >WhatsApp ↗</a>
              <a :href="`mailto:${s.contact_email || 'info@omniviatech.com'}`" class="hover:text-white">Email ↗</a>
              <button type="button" @click="toggleWishlist" :disabled="wishlistLoading" class="hover:text-white">
                {{ isInWishlist ? 'Saved ♥' : 'Save ♡' }}
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ ABOUT ═══════════════ -->
      <section class="container mx-auto px-4 md:px-6 max-w-6xl pt-14 md:pt-20">
        <div class="grid md:grid-cols-2 gap-6 md:gap-10">
          <div>
            <span class="pill">About {{ pkg.name }}</span>
          </div>
          <div>
            <div
              v-if="pkg.description"
              v-html="pkg.description"
              class="statement text-foreground text-lg md:text-2xl font-light leading-snug tracking-tight"
            ></div>
            <p v-else class="text-foreground text-lg md:text-2xl font-light leading-snug tracking-tight">
              {{ pkg.short_description || 'A complete package designed to get your business online and growing — with professional support every step of the way.' }}
            </p>
          </div>
        </div>
      </section>

      <!-- ═══════════════ BENTO CARDS ═══════════════ -->
      <section class="container mx-auto px-4 md:px-6 max-w-6xl pt-10 md:pt-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <!-- Dark card -->
          <div class="rounded-3xl bg-slate-900 p-7 flex flex-col justify-between min-h-[290px]">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 5h18v11H3zM8 20h8M12 16v4M7 9h2m2 0h2m2 0h2"/></svg>
            <p class="mt-8 text-xl md:text-[1.4rem] font-light leading-snug text-white">
              {{ pkg.includes?.[0] || 'Professional website design' }}
              <span class="text-white/45"> {{ pkg.includes?.[1] ? 'with ' + pkg.includes[1].charAt(0).toLowerCase() + pkg.includes[1].slice(1) : 'with responsive layouts' }} —</span>
              everything set up for you,
              <span class="text-white/45">ready</span> from day one.
            </p>
            <div class="mt-6 flex items-center gap-3">
              <span class="relative inline-flex h-6 w-11 items-center rounded-full bg-sky-500" aria-hidden="true">
                <span class="absolute right-1 h-4 w-4 rounded-full bg-white ring-4 ring-sky-300/40"></span>
              </span>
              <span class="text-sm text-white/45">Monthly maintenance</span>
            </div>
          </div>

          <!-- Image card -->
          <div class="relative overflow-hidden rounded-3xl min-h-[290px]">
            <img :src="tech5" alt="" class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
            <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 whitespace-nowrap rounded-full bg-white/25 backdrop-blur-md px-4 py-2 text-sm text-white">
              {{ pkg.highlight_text || pkg.tier_level || 'Setup, training & support' }}
            </span>
          </div>

          <!-- Stats card -->
          <div class="rounded-3xl bg-slate-50 dark:bg-gray-900 border border-slate-100 dark:border-gray-800 p-7 flex flex-col">
            <p class="text-4xl md:text-5xl font-light tracking-tight text-foreground">
              <template v-if="Number(pkg.price)"><span class="text-xl align-top mr-1">KES</span>{{ formatPrice(Number(pkg.price)) }}</template>
              <template v-else>Custom</template>
            </p>
            <p class="mt-2 text-sm text-foreground">{{ pkg.price_label || 'One-time payment' }}</p>
            <p class="mt-2 text-xs text-muted-foreground leading-relaxed">All packages include professional support and monthly maintenance.</p>

            <div class="mt-auto pt-6 space-y-2.5">
              <div v-for="row in [
                { label: 'Included', value: pkg.includes?.length || 0 },
                { label: 'Key features', value: pkg.package_features?.length || 0 },
                { label: 'Support', value: '24/7', full: true },
              ]" :key="row.label" class="flex items-center gap-3">
                <span class="w-24 shrink-0 text-xs text-foreground">{{ row.label }}</span>
                <span class="flex flex-1 gap-1">
                  <span
                    v-for="d in 10"
                    :key="d"
                    class="h-2.5 w-2.5 rounded-full"
                    :class="(row.full || d <= Math.min(10, Number(row.value))) ? 'bg-sky-500' : 'bg-slate-200 dark:bg-gray-700'"
                  ></span>
                </span>
                <span class="w-8 text-right text-xs text-foreground">{{ row.value }}</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ FACTS IN NUMBERS ═══════════════ -->
      <section class="container mx-auto px-4 md:px-6 max-w-6xl pt-14 md:pt-16 pb-14 md:pb-16 border-b border-slate-100 dark:border-gray-800">
        <p class="text-center text-lg md:text-xl font-light text-foreground mb-10">A few more facts about this package in numbers</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-y-10 text-center">
          <div>
            <p class="text-3xl md:text-4xl font-light tracking-tight text-foreground">{{ pkg.includes?.length || 4 }}+</p>
            <p class="mt-1 text-xs text-muted-foreground">Items included</p>
          </div>
          <div>
            <p class="text-3xl md:text-4xl font-light tracking-tight text-foreground">{{ pkg.package_features?.length || 3 }}</p>
            <p class="mt-1 text-xs text-muted-foreground">Key features</p>
          </div>
          <div>
            <p class="text-3xl md:text-4xl font-light tracking-tight text-foreground">24/7</p>
            <p class="mt-1 text-xs text-muted-foreground">Support availability</p>
          </div>
          <div>
            <p class="text-3xl md:text-4xl font-light tracking-tight text-foreground">24h</p>
            <p class="mt-1 text-xs text-muted-foreground">Quote turnaround</p>
          </div>
        </div>
      </section>

      <!-- ═══════════════ WHAT'S INCLUDED ═══════════════ -->
      <section class="container mx-auto px-4 md:px-6 max-w-6xl py-14 md:py-20">
        <div class="grid lg:grid-cols-[minmax(0,5fr)_minmax(0,7fr)] gap-10">
          <div class="flex flex-col">
            <span class="pill self-start">What's included</span>
            <p class="mt-6 text-xl md:text-2xl font-light leading-snug tracking-tight text-foreground">
              Everything that comes with {{ pkg.name }} — from first launch to ongoing growth, we've got every detail covered for you.
            </p>
            <div class="mt-8 lg:mt-auto pt-6">
              <button type="button" @click="scrollToQuote" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-2.5 text-sm text-white hover:bg-slate-800 transition-colors">
                Get a quote
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </button>
            </div>
          </div>

          <ul class="rounded-3xl bg-slate-50 dark:bg-gray-900 border border-slate-100 dark:border-gray-800 px-6 md:px-8 py-2">
            <li
              v-for="(item, idx) in (pkg.includes?.length ? pkg.includes : ['Professional website design and development', 'Responsive design for all devices', 'SEO optimization included', '24/7 Support and maintenance'])"
              :key="idx"
              class="flex items-center gap-5 py-4 border-b border-slate-200/80 dark:border-gray-800 last:border-b-0"
            >
              <span class="text-xs tabular-nums text-muted-foreground w-6">{{ String(Number(idx) + 1).padStart(2, '0') }}</span>
              <span class="flex-1 text-sm md:text-base font-light text-foreground">{{ item }}</span>
              <span class="w-6 h-6 rounded-full bg-sky-500/10 flex items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-sky-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
              </span>
            </li>
          </ul>
        </div>

        <!-- Key features -->
        <div v-if="pkg.package_features?.length" class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          <div
            v-for="(feature, fi) in pkg.package_features"
            :key="feature.id"
            class="rounded-3xl p-7 min-h-[200px] flex flex-col"
            :class="Number(fi) % 3 === 0 ? 'bg-slate-900 text-white' : 'bg-slate-50 dark:bg-gray-900 border border-slate-100 dark:border-gray-800'"
          >
            <span
              class="self-start rounded-full px-3 py-1 text-[11px]"
              :class="Number(fi) % 3 === 0 ? 'bg-white/10 text-white/70' : 'bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-muted-foreground'"
            >Feature {{ String(Number(fi) + 1).padStart(2, '0') }}</span>
            <div v-if="feature.icon" class="mt-6 text-3xl">{{ feature.icon }}</div>
            <h3 class="mt-auto pt-6 text-lg font-normal" :class="Number(fi) % 3 === 0 ? 'text-white' : 'text-foreground'">{{ feature.title }}</h3>
            <p v-if="feature.description" class="mt-1 text-xs leading-relaxed" :class="Number(fi) % 3 === 0 ? 'text-white/55' : 'text-muted-foreground'">{{ feature.description }}</p>
          </div>
        </div>
      </section>

      <!-- ═══════════════ WHY THIS PACKAGE ═══════════════ -->
      <section class="container mx-auto px-4 md:px-6 max-w-6xl pb-14 md:pb-20">
        <div class="grid md:grid-cols-2 gap-6 md:gap-10 mb-10">
          <div><span class="pill">Why {{ pkg.name }}</span></div>
          <p class="text-lg md:text-2xl font-light leading-snug tracking-tight text-foreground">
            The right balance of functionality and value — built to grow with you, without starting from scratch.
          </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px rounded-3xl overflow-hidden bg-slate-100 dark:bg-gray-800 border border-slate-100 dark:border-gray-800">
          <div v-for="b in [
            { t: 'Perfect value', d: 'Optimized pricing that delivers maximum value without compromising on quality.' },
            { t: 'Proven results', d: 'Used by businesses that have achieved their online goals with this tier.' },
            { t: 'Growth-ready', d: 'Upgrade or customize as your business grows — no starting over.' },
            { t: 'Complete setup', d: 'Full configuration and launch support from our expert team.' },
            { t: 'Training included', d: 'Hands-on training so you can manage and update your site with confidence.' },
            { t: 'Peace of mind', d: 'Regular backups, security monitoring and compliance protection.' },
          ]" :key="b.t" class="bg-white dark:bg-gray-950 p-7">
            <h3 class="text-base font-normal text-foreground">{{ b.t }}</h3>
            <p class="mt-2 text-xs leading-relaxed text-muted-foreground">{{ b.d }}</p>
          </div>
        </div>
      </section>

      <!-- ═══════════════ TESTIMONIALS ═══════════════ -->
      <section v-if="topReviews.length" class="container mx-auto px-4 md:px-6 max-w-6xl pb-14 md:pb-20">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
          <span class="pill">Client stories</span>
          <p class="text-lg md:text-xl font-light text-foreground">What our clients say</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <div v-for="review in topReviews.slice(0, 3)" :key="review.id" class="rounded-3xl bg-slate-50 dark:bg-gray-900 border border-slate-100 dark:border-gray-800 p-7 flex flex-col">
            <div class="flex gap-1 mb-4">
              <span v-for="i in review.rating" :key="i" class="h-2.5 w-2.5 rounded-full bg-sky-500"></span>
            </div>
            <p class="text-sm font-light leading-relaxed text-foreground mb-6">"{{ review.comment }}"</p>
            <div class="mt-auto flex items-center gap-3">
              <div class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs">
                {{ review.user_name?.charAt(0).toUpperCase() }}
              </div>
              <div>
                <p class="text-sm text-foreground">{{ review.user_name }}</p>
                <p class="text-xs text-muted-foreground">{{ review.company || 'Verified Client' }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ CTA ═══════════════ -->
      <section class="container mx-auto px-4 md:px-6 max-w-6xl pb-14 md:pb-20">
        <div class="relative overflow-hidden rounded-3xl bg-slate-900 px-6 py-14 md:py-20 text-center">
          <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-sky-500/20 blur-3xl"></div>
          <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full bg-sky-500/10 blur-3xl"></div>
          <h2 class="relative text-3xl md:text-5xl font-light tracking-tight text-white leading-tight">Ready to get started?</h2>
          <p class="relative mt-4 text-sm md:text-base font-light text-white/60 max-w-xl mx-auto">
            Join the businesses growing with the {{ pkg.name }} package — with professional support every step of the way.
          </p>
          <div class="relative mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a
              :href="`https://wa.me/${whatsappDigits}?text=${encodeURIComponent('Hi, I am interested in the ' + (pkg?.name || 'website') + ' package')}`"
              target="_blank" rel="noopener noreferrer"
              class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3 text-sm text-slate-900 hover:bg-white/90 transition-colors"
            >
              Chat on WhatsApp
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </a>
            <router-link to="/contact" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/25 px-6 py-3 text-sm text-white hover:bg-white/10 transition-colors">
              Schedule a call
            </router-link>
          </div>
        </div>
      </section>

      <!-- ═══════════════ GET A QUOTE ═══════════════ -->
      <section id="quote-form" class="container mx-auto px-4 md:px-6 max-w-6xl pb-16 md:pb-24 scroll-mt-24">
        <div class="grid lg:grid-cols-[minmax(0,5fr)_minmax(0,7fr)] gap-10">
          <div>
            <span class="pill">Get a quote</span>
            <p class="mt-6 text-xl md:text-2xl font-light leading-snug tracking-tight text-foreground">
              Request a quote for {{ pkg.name }}. Our team will get back to you within 24 hours with a personalized proposal.
            </p>
            <div class="mt-8 space-y-3 text-sm">
              <a :href="`mailto:${s.contact_email || 'info@omniviatech.com'}`" class="flex items-center justify-between border-b border-slate-200 dark:border-gray-800 pb-3 text-foreground hover:text-sky-600 transition-colors">
                <span class="font-light">{{ s.contact_email || 'info@omniviatech.com' }}</span><span>↗</span>
              </a>
              <a
                :href="`https://wa.me/${whatsappDigits}`"
                target="_blank" rel="noopener noreferrer"
                class="flex items-center justify-between border-b border-slate-200 dark:border-gray-800 pb-3 text-foreground hover:text-sky-600 transition-colors"
              >
                <span class="font-light">WhatsApp +{{ whatsappDigits }}</span><span>↗</span>
              </a>
              <button
                type="button"
                @click="toggleWishlist"
                :disabled="wishlistLoading"
                class="w-full flex items-center justify-between border-b border-slate-200 dark:border-gray-800 pb-3 text-foreground hover:text-sky-600 transition-colors"
              >
                <span class="font-light">{{ isInWishlist ? 'Saved to your wishlist' : 'Save this package to your wishlist' }}</span><span>{{ isInWishlist ? '♥' : '♡' }}</span>
              </button>
            </div>
          </div>

          <form @submit.prevent="submitQuoteForm" class="rounded-3xl bg-slate-50 dark:bg-gray-900 border border-slate-100 dark:border-gray-800 p-6 md:p-8 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs text-muted-foreground mb-2">Full name *</label>
                <input v-model="quoteForm.name" type="text" required class="field" placeholder="Your full name" />
              </div>
              <div>
                <label class="block text-xs text-muted-foreground mb-2">Email address *</label>
                <input v-model="quoteForm.email" type="email" required class="field" placeholder="your@email.com" />
              </div>
              <div>
                <label class="block text-xs text-muted-foreground mb-2">Phone number *</label>
                <input v-model="quoteForm.phone" type="tel" required class="field" placeholder="+254 700 000000" />
              </div>
              <div>
                <label class="block text-xs text-muted-foreground mb-2">Company name</label>
                <input v-model="quoteForm.company" type="text" class="field" placeholder="Your company name" />
              </div>
            </div>
            <div>
              <label class="block text-xs text-muted-foreground mb-2">Tell us about your project</label>
              <textarea v-model="quoteForm.message" rows="4" class="field resize-none" placeholder="Share details about your project, requirements, or any specific questions..."></textarea>
            </div>
            <label for="agree" class="flex items-start gap-3 text-xs text-muted-foreground">
              <input v-model="quoteForm.agreeTerms" type="checkbox" id="agree" class="mt-0.5 rounded accent-sky-500" />
              I agree to receive email communications and understand my information will be used to provide a quote.
            </label>
            <div class="flex flex-wrap items-center justify-between gap-4">
              <p class="text-xs text-muted-foreground">We'll reply within 24 hours.</p>
              <button
                type="submit"
                :disabled="submittingQuote"
                class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-3 text-sm text-white hover:bg-slate-800 disabled:opacity-50 transition-colors"
              >
                {{ submittingQuote ? 'Sending…' : 'Send quote request' }}
                <svg v-if="!submittingQuote" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </button>
            </div>
          </form>
        </div>
      </section>
    </div>

    <!-- Error State -->
    <div v-else class="min-h-[60vh] flex items-center justify-center px-6">
      <div class="text-center">
        <span class="pill">404</span>
        <h1 class="mt-5 text-3xl font-light tracking-tight text-foreground mb-6">Package not found</h1>
        <router-link to="/packages" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-2.5 text-sm text-white hover:bg-slate-800 transition-colors">
          Back to packages
        </router-link>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { useCmsStore } from '@/stores/cms';
import { useToast } from '@/composables';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';
import tech1 from '@/../img/tech1.webp';
import tech5 from '@/../img/tech5.webp';

const route = useRoute();
const authStore = useAuthStore();
const cmsStore = useCmsStore();
const toast = useToast();
const s = computed(() => cmsStore.homeData?.settings || {} as any);
const whatsappDigits = computed(() => (s.value.whatsapp_number || s.value.contact_phone || '254710351517').replace(/[^0-9]/g, ''));
const pkg = ref<any>(null);
const loading = ref(true);
const wishlistLoading = ref(false);
const isInWishlist = ref(false);
const submittingQuote = ref(false);
const topReviews = ref<any[]>([]);
const quoteForm = ref({
  name: '',
  email: '',
  phone: '',
  company: '',
  message: '',
  agreeTerms: false,
});

const formatPrice = (price: number) => {
  return price.toLocaleString('en-KE', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });
};

const fetchPackage = async () => {
  try {
    loading.value = true;
    const response = await axios.get(`/api/v1/packages/${route.params.slug}`);
    pkg.value = response.data.data || response.data;
    await checkWishlistStatus();
  } catch (error) {
    console.error('Failed to fetch package:', error);
    pkg.value = null;
  } finally {
    loading.value = false;
  }
};

const checkWishlistStatus = async () => {
  if (!authStore.isAuthenticated || !pkg.value?.id) return;

  try {
    const response = await axios.get('/api/v1/user/wishlist');
    const wishlist = response.data.data || response.data;
    isInWishlist.value = wishlist.some(
      (item: any) => item.wishlistable_type === 'App\\Models\\Package' && item.wishlistable_id === pkg.value?.id
    );
  } catch (error) {
    console.error('Failed to check wishlist status:', error);
  }
};

const toggleWishlist = async () => {
  if (!authStore.isAuthenticated) {
    (authStore as any).showAuthModal = true;
    return;
  }

  if (!pkg.value?.id) return;

  try {
    wishlistLoading.value = true;

    if (isInWishlist.value) {
      // Remove from wishlist
      const wishlist = await axios.get('/api/v1/user/wishlist');
      const item = (wishlist.data.data || wishlist.data).find(
        (w: any) => w.wishlistable_type === 'App\\Models\\Package' && w.wishlistable_id === pkg.value?.id
      );
      if (item) {
        await axios.delete(`/api/v1/user/wishlist/${item.id}`);
      }
    } else {
      // Add to wishlist
      await axios.post('/api/v1/user/wishlist', {
        wishlistable_type: 'App\\Models\\Package',
        wishlistable_id: pkg.value?.id,
      });
    }

    isInWishlist.value = !isInWishlist.value;
  } catch (error) {
    console.error('Failed to toggle wishlist:', error);
  } finally {
    wishlistLoading.value = false;
  }
};

const scrollToQuote = () => {
  const quoteSection = document.getElementById('quote-form');
  if (quoteSection) {
    quoteSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};

const submitQuoteForm = async () => {
  submittingQuote.value = true;
  try {
    await axios.post('/api/v1/enquiries', {
      type: 'quote',
      name: quoteForm.value.name,
      email: quoteForm.value.email,
      phone: quoteForm.value.phone,
      company: quoteForm.value.company,
      service: pkg.value?.name,
      message: quoteForm.value.message,
    });
    toast.success('Quote request submitted! We will contact you within 24 hours.');
    quoteForm.value = {
      name: '',
      email: '',
      phone: '',
      company: '',
      message: '',
      agreeTerms: false,
    };
  } catch (error) {
    console.error('Failed to submit quote form:', error);
    toast.error('Failed to submit. Please try again.');
  } finally {
    submittingQuote.value = false;
  }
};

async function loadReviews() {
  try {
    const { data } = await axios.get('/api/v1/reviews', { params: { limit: 6 } });
    topReviews.value = data.data || [];
  } catch { /* silent */ }
}

onMounted(() => {
  if (!cmsStore.homeData) cmsStore.fetchHomeData().catch(() => {});
  fetchPackage();
  loadReviews();
});
</script>

<style scoped>
.pill {
  display: inline-flex;
  align-items: center;
  border-radius: 9999px;
  border: 1px solid rgb(226 232 240);
  padding: 0.3rem 0.85rem;
  font-size: 0.8rem;
  color: var(--color-foreground, inherit);
}
:global(.dark) .pill { border-color: rgb(55 65 81); }

.field {
  width: 100%;
  border-radius: 0.875rem;
  border: 1px solid rgb(226 232 240);
  background: white;
  padding: 0.75rem 1rem;
  font-size: 0.875rem;
  color: rgb(15 23 42);
  transition: border-color 0.15s, box-shadow 0.15s;
}
.field:focus { outline: none; border-color: rgb(14 165 233); box-shadow: 0 0 0 3px rgb(14 165 233 / 0.15); }
:global(.dark) .field { background: rgb(3 7 18); border-color: rgb(31 41 55); color: white; }

/* CMS description rendered as a large editorial statement */
.statement :deep(h2),
.statement :deep(h3) { font-weight: 400; margin: 1.25rem 0 0.5rem; }
.statement :deep(p) { margin-bottom: 1rem; }
.statement :deep(ul) { list-style: disc; padding-left: 1.25rem; font-size: 1rem; margin-bottom: 1rem; }
.statement :deep(li) { margin-bottom: 0.35rem; }
.statement :deep(strong) { font-weight: 500; }
</style>
