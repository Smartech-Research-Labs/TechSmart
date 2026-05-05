<template>
  <nav class="sticky top-0 z-40 border-b border-[#3a3a3a] bg-slate-950/95 backdrop-blur-xl">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-3 lg:px-6">
      <router-link to="/" class="flex items-center gap-3 text-white">
        <img
          v-if="settings?.logo_path"
          :src="`/storage/${settings.logo_path}`"
          alt="Logo"
          class="h-9 w-auto"
        />
        <img
          v-else
          :src="defaultLogo"
          alt="OmniviaTech Logo"
          class="h-9 w-auto"
        />
        <span class="text-lg font-semibold tracking-tight">{{ settings?.site_name || 'OmniviaTech' }}</span>
      </router-link>

      <div class="hidden lg:flex items-center gap-1">
        <router-link
          to="/"
          class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10"
          exact-active-class="text-primary"
        >Home</router-link>

        <router-link to="/about" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10">Why Us</router-link>

        <div class="relative" @mouseenter="openMega('what')" @mouseleave="scheduleClose()">
          <button
            @click.prevent="megaOpen = megaOpen === 'what' ? null : 'what'"
            class="nav-link flex items-center gap-1 px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10"
            :class="{ 'text-primary': megaOpen === 'what' }"
            type="button"
          >
            What We Offer
            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': megaOpen === 'what' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
          </button>

          <transition enter-active-class="transition duration-150 ease-out" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
            <div v-show="megaOpen === 'what'" @mouseenter="clearClose()" @mouseleave="scheduleClose()" class="absolute left-0 top-full z-50 mt-2 w-screen overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl lg:w-screen">
              <div class="grid gap-6 px-6 py-6 text-slate-900 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_minmax(0,1fr)_280px]">
                <div>
                  <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">Services</p>
                  <p class="mt-2 text-sm text-slate-600">Explore our top technology services and solutions.</p>
                  <div class="mt-4 space-y-3">
                    <button
                      v-for="item in serviceLinks"
                      :key="item.label"
                      @mouseenter="setActivePreview(item)"
                      @focus="setActivePreview(item)"
                      @click="navigateTo(item.to)"
                      class="group flex w-full items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-left transition hover:border-primary/40"
                    >
                      <img :src="item.img" alt="" class="h-12 w-12 rounded-2xl object-cover border border-slate-200" />
                      <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-900 group-hover:text-primary">{{ item.label }}</p>
                        <p class="text-xs text-slate-500">{{ item.desc }}</p>
                      </div>
                    </button>
                  </div>
                </div>

                <div>
                  <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">Company</p>
                  <p class="mt-2 text-sm text-slate-600">Find out what makes OmniviaTech different.</p>
                  <div class="mt-4 space-y-2">
                    <router-link v-for="item in companyLinks" :key="item.label" @mouseenter="setActivePreview(item)" :to="item.to" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 hover:border-primary/40 transition">
                      <img :src="item.img" alt="" class="h-10 w-10 rounded-xl object-cover border border-slate-200" />
                      <div class="min-w-0">
                        <p class="font-semibold text-slate-900">{{ item.label }}</p>
                        <p class="text-xs text-slate-500">{{ item.desc }}</p>
                      </div>
                    </router-link>
                  </div>
                </div>

                <div>
                  <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">More links</p>
                  <p class="mt-2 text-sm text-slate-600">Navigate the rest of the site with fast access.</p>
                  <div class="mt-4 space-y-2">
                    <router-link v-for="item in resourceLinks" :key="item.label" @mouseenter="setActivePreview(item)" :to="item.to" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 hover:border-primary/40 transition">
                      <img :src="item.img" alt="" class="h-10 w-10 rounded-xl object-cover border border-slate-200" />
                      <div class="min-w-0">
                        <p class="font-semibold text-slate-900">{{ item.label }}</p>
                        <p class="text-xs text-slate-500">{{ item.desc }}</p>
                      </div>
                    </router-link>
                  </div>
                </div>

                <div class="rounded-3xl border border-slate-200 p-6 bg-white">
                  <div class="relative overflow-hidden rounded-3xl">
                    <img :src="activePreview.img" :alt="activePreview.label" class="h-56 w-full object-cover transition duration-300" />
                    <div class="absolute inset-0 bg-gradient-to-t from-white via-white/80 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                      <p class="text-xs uppercase tracking-[0.3em] text-sky-600">Preview</p>
                      <p class="mt-2 text-lg font-semibold text-slate-900">{{ activePreview.label }}</p>
                      <p class="mt-1 text-sm text-slate-600">{{ activePreview.desc }}</p>
                    </div>
                  </div>
                  <div class="mt-6 rounded-3xl bg-slate-50 p-4 text-slate-700">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Featured</p>
                    <p class="mt-2 text-sm leading-relaxed">Preview the latest tech visuals while you explore the menu. Hover a service or company card to update the image instantly.</p>
                  </div>
                </div>
              </div>
            </div>
          </transition>
        </div>

        <div class="relative" @mouseenter="openMega('solutions')" @mouseleave="scheduleClose()">
          <button @click.prevent="megaOpen = megaOpen === 'solutions' ? null : 'solutions'" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10" :class="{ 'text-primary': megaOpen === 'solutions' }">Solutions <svg class="w-3.5 h-3.5 inline-block ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg></button>
          <transition>
            <div v-show="megaOpen === 'solutions'" @mouseenter="clearClose()" @mouseleave="scheduleClose()" class="absolute left-0 top-full z-50 mt-2 w-44 rounded-2xl border border-slate-800 bg-slate-950/95 shadow-lg">
              <div class="py-2">
                <router-link to="/services" class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-900">Services</router-link>
                <router-link to="/bundles" class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-900">Bundles</router-link>
                <router-link to="/products" class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-900">Products</router-link>
                <router-link to="/industries" class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-900">Industries</router-link>
              </div>
            </div>
          </transition>
        </div>

        <div class="relative" @mouseenter="openMega('company')" @mouseleave="scheduleClose()">
          <button @click.prevent="megaOpen = megaOpen === 'company' ? null : 'company'" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10" :class="{ 'text-primary': megaOpen === 'company' }">Company <svg class="w-3.5 h-3.5 inline-block ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg></button>
          <transition>
            <div v-show="megaOpen === 'company'" @mouseenter="clearClose()" @mouseleave="scheduleClose()" class="absolute left-0 top-full z-50 mt-2 w-56 rounded-2xl border border-slate-800 bg-slate-950/95 shadow-lg">
              <div class="py-2">
                <router-link v-for="item in companyLinks" :key="item.label" :to="item.to" class="block px-4 py-2 text-sm text-slate-200 hover:bg-slate-900">{{ item.label }}</router-link>
              </div>
            </div>
          </transition>
        </div>

        <div class="relative" @mouseenter="openMega('marketplace')" @mouseleave="scheduleClose()">
          <button @click.prevent="megaOpen = megaOpen === 'marketplace' ? null : 'marketplace'" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10" :class="{ 'text-primary': megaOpen === 'marketplace' }">Marketplace <svg class="w-3.5 h-3.5 inline-block ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg></button>
          <transition>
            <div v-show="megaOpen === 'marketplace'" @mouseenter="clearClose()" @mouseleave="scheduleClose()" class="absolute left-0 top-full z-50 mt-2 w-screen overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl lg:w-screen">
              <div class="px-6 py-6">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">Marketplace</p>
                <p class="mt-2 text-sm text-slate-600">Our SaaS products from the CMS.</p>
                <div class="mt-4 grid gap-4 grid-cols-2 md:grid-cols-4">
                  <div v-for="p in marketProducts" :key="p.id" class="rounded-2xl border border-slate-200 bg-white p-3">
                    <router-link :to="`/products/${p.slug}`" class="block">
                      <img v-if="p.image_url" :src="p.image_url" alt="" class="h-24 w-full object-cover rounded-md mb-2" />
                      <p class="font-semibold text-slate-900">{{ p.name }}</p>
                      <p class="text-xs text-slate-500">{{ p.excerpt }}</p>
                    </router-link>
                  </div>
                  <div v-if="!marketProducts || marketProducts.length === 0" class="text-sm text-slate-600">No products yet. <router-link to="/products" class="text-primary">View products</router-link></div>
                </div>
              </div>
            </div>
          </transition>
        </div>

        <router-link to="/blog" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10">Blog</router-link>
        <router-link to="/contact" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10">Contact Us</router-link>
      </div>

      <div class="hidden lg:flex items-center gap-3">
        <ThemeToggle />
        <template v-if="authStore.isAuthenticated">
          <router-link
            to="/dashboard"
            class="text-sm text-slate-300 hover:text-primary transition"
          >Dashboard</router-link>
          <button
            type="button"
            class="rounded-full border border-slate-700 px-4 py-2 text-sm text-slate-200 hover:border-primary hover:text-primary transition"
            @click="handleLogout"
          >Logout</button>
        </template>
        <template v-else>
          <router-link
            to="/login"
            class="text-sm text-slate-300 hover:text-primary transition"
          >Login</router-link>
          <router-link
            to="/register"
            class="rounded-full bg-gradient-to-r from-primary to-cyan-500 px-4 py-2 text-sm font-semibold text-slate-950 shadow-lg shadow-cyan-500/30 hover:opacity-95 transition"
          >Get Started</router-link>
        </template>
      </div>

      <div class="flex lg:hidden items-center gap-2">
        <ThemeToggle />
        <button
          @click="mobileMenuOpen = !mobileMenuOpen"
          class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-800 bg-slate-900 text-white/90 transition hover:bg-slate-800"
          type="button"
          aria-label="Toggle navigation"
        >
          <svg v-if="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
          <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
    </div>

    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div v-if="mobileMenuOpen" class="border-t border-slate-800 bg-slate-950/95 lg:hidden">
        <div class="space-y-1 px-4 py-4">
          <router-link to="/" class="block rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition">Home</router-link>

          <button
            @click="mobileExpanded = mobileExpanded === 'solutions' ? null : 'solutions'"
            class="flex w-full items-center justify-between rounded-2xl border border-slate-800 bg-slate-900 px-4 py-3 text-left text-sm font-medium text-slate-200 hover:border-primary/40 transition"
            type="button"
          >
            <span>Solutions</span>
            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': mobileExpanded === 'solutions' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div v-show="mobileExpanded === 'solutions'" class="space-y-2 px-3 pt-2">
            <router-link v-for="item in serviceLinks" :key="item.label" :to="item.to" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition" @click="mobileMenuOpen = false">
              <img :src="item.img" alt="" class="h-10 w-10 rounded-xl object-cover border border-slate-800" />
              <span>{{ item.label }}</span>
            </router-link>
          </div>

          <button
            @click="mobileExpanded = mobileExpanded === 'company' ? null : 'company'"
            class="flex w-full items-center justify-between rounded-2xl border border-slate-800 bg-slate-900 px-4 py-3 text-left text-sm font-medium text-slate-200 hover:border-primary/40 transition"
            type="button"
          >
            <span>Company</span>
            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': mobileExpanded === 'company' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div v-show="mobileExpanded === 'company'" class="space-y-2 px-3 pt-2">
            <router-link v-for="item in companyLinks" :key="item.label" :to="item.to" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition" @click="mobileMenuOpen = false">
              <img :src="item.img" alt="" class="h-10 w-10 rounded-xl object-cover border border-slate-800" />
              <span>{{ item.label }}</span>
            </router-link>
          </div>

          <router-link to="/products" class="block rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition" @click="mobileMenuOpen = false">Marketplace</router-link>
          <router-link to="/blog" class="block rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition" @click="mobileMenuOpen = false">Resources</router-link>
          <router-link to="/contact" class="block rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition" @click="mobileMenuOpen = false">Contact</router-link>

          <div class="pt-3 border-t border-slate-800">
            <template v-if="authStore.isAuthenticated">
              <router-link to="/dashboard" class="block rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition" @click="mobileMenuOpen = false">Dashboard</router-link>
              <button @click="handleLogout" class="w-full rounded-2xl border border-slate-800 bg-slate-900 px-4 py-3 text-left text-sm text-slate-200 hover:border-primary/40 hover:text-primary transition">Logout</button>
            </template>
            <template v-else>
              <router-link to="/login" class="block rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition" @click="mobileMenuOpen = false">Login</router-link>
              <router-link to="/register" class="block rounded-2xl bg-primary px-4 py-3 text-sm font-semibold text-slate-950 hover:opacity-95 transition" @click="mobileMenuOpen = false">Get Started</router-link>
            </template>
          </div>
        </div>
      </div>
    </transition>
  </nav>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';
import laptopInDark from '@/../img/laptop-in-dark.webp';
import defaultLogo from '@/../img/Omnivatech-logo.png';
import apiDevelopmentImage from '@/../img/services/API Development.webp';
import crmErpDevelopmentImage from '@/../img/services/CRM & ERP Development.webp';
import customWebDevelopmentImage from '@/../img/services/Custom Web Development.webp';
import eCommerceDevelopmentImage from '@/../img/services/E-commerece Development.webp';
import mobileAppDevelopmentImage from '@/../img/services/Mobile App Development.webp';
import paidAdsImage from '@/../img/services/Paid Ads.webp';
import seoOptimizationImage from '@/../img/services/SEO Optimization.webp';
import tech1 from '@/../img/tech1.jpg';
import tech2 from '@/../img/tech2.jpg';
import tech3 from '@/../img/tech3.jpg';
import tech4 from '@/../img/tech4.jpg';
import tech5 from '@/../img/tech5.jpg';
import tech6 from '@/../img/tech6.jpg';
import ThemeToggle from '@/components/shared/ThemeToggle.vue';
import { useAuthStore } from '@/stores/auth';
import { useCmsStore } from '@/stores/cms';

const router = useRouter();
const authStore = useAuthStore();
const cmsStore = useCmsStore();

const settings = computed(() => cmsStore.homeData?.settings);

const mobileMenuOpen = ref(false);
const megaOpen = ref<string | null>(null);
const mobileExpanded = ref<string | null>(null);

const serviceLinks = [
  {
    to: '/services',
    label: 'Custom Web Development',
    desc: 'Enterprise websites and portals',
    img: customWebDevelopmentImage,
  },
  {
    to: '/services',
    label: 'Mobile App Development',
    desc: 'iOS and Android app solutions',
    img: mobileAppDevelopmentImage,
  },
  {
    to: '/services',
    label: 'E-commerce Development',
    desc: 'Stores and marketplaces',
    img: eCommerceDevelopmentImage,
  },
  {
    to: '/services',
    label: 'CRM & ERP Development',
    desc: 'Business systems and automation',
    img: crmErpDevelopmentImage,
  },
  {
    to: '/services',
    label: 'API Integration',
    desc: 'Secure backend and integrations',
    img: apiDevelopmentImage,
  },
  {
    to: '/services',
    label: 'SEO & Paid Ads',
    desc: 'Growth marketing and performance',
    img: seoOptimizationImage,
  },
  {
    to: '/services',
    label: 'App Launch Support',
    desc: 'Launch, monitor, and optimize',
    img: paidAdsImage,
  },
];

const companyLinks = [
  {
    to: '/about',
    label: 'About Us',
    desc: 'Our mission and team',
    img: laptopInDark,
  },
  {
    to: '/case-studies',
    label: 'Case Studies',
    desc: 'Real world digital impact',
    img: tech1,
  },
  {
    to: '/faqs',
    label: 'FAQs',
    desc: 'Answers to common questions',
    img: tech2,
  },
];

const resourceLinks = [
  {
    to: '/blog',
    label: 'Blog',
    desc: 'Insights and latest announcements',
    img: tech3,
  },
  {
    to: '/contact',
    label: 'Contact',
    desc: 'Talk to our team',
    img: tech4,
  },
  {
    to: '/products',
    label: 'Marketplace',
    desc: 'Software products and bundles',
    img: tech5,
  },
  {
    to: '/bundles',
    label: 'Bundles',
    desc: 'Package deals for faster delivery',
    img: tech6,
  },
];

type PreviewItem = {
  label: string;
  desc: string;
  img: string;
  to?: string;
};

const activePreview = ref<PreviewItem>(serviceLinks[0]);

let closeTimer: ReturnType<typeof setTimeout> | null = null;

function setActivePreview(item: PreviewItem) {
  activePreview.value = item;
}

function navigateTo(to: string) {
  mobileMenuOpen.value = false;
  megaOpen.value = null;
  router.push(to);
}

function scheduleClose(ms = 250) {
  if (closeTimer) clearTimeout(closeTimer);
  closeTimer = setTimeout(() => {
    megaOpen.value = null;
  }, ms);
}

function clearClose() {
  if (closeTimer) {
    clearTimeout(closeTimer);
    closeTimer = null;
  }
}

function openMega(key: string) {
  clearClose();
  megaOpen.value = key;
}

// marketplace products from cms store
const marketProducts = computed(() => cmsStore.homeData?.featured_products || []);

async function handleLogout() {
  await authStore.logout();
  router.push('/login');
}
</script>
