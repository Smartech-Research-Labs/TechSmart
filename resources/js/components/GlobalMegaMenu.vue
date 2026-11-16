<template>
  <nav class="sticky top-0 z-40 border-b border-[#3a3a3a] bg-slate-950/95">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-3 lg:px-6">
      <router-link to="/" class="flex items-center gap-3 text-white">
        <img
          v-if="settings?.logo_url || settings?.logo_path"
          :src="settings?.logo_url || `/storage/${settings?.logo_path}`"
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

      <div class="relative hidden lg:flex items-center gap-1">
        <router-link
          to="/"
          class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10"
          exact-active-class="text-primary"
        >Home</router-link>

        <router-link to="/about" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10">Why Us</router-link>

        <div class="mega-trigger" @mouseenter="hoverOpen('what')" @mouseleave="hoverClose">
          <button
            @click.prevent="toggleMega('what')"
            class="nav-link flex items-center gap-1 px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10"
            :class="{ 'text-primary': megaOpen === 'what' }"
            type="button"
          >
            What We Offer
            <svg class="w-3.5 h-3.5 transition-transform duration-100" :class="{ 'rotate-180': megaOpen === 'what' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
          </button>

          <div v-if="megaOpen === 'what'" class="mega-dropdown fixed left-1/2 top-[74px] z-50 mt-2 w-[min(94vw,1160px)] -translate-x-1/2 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl animate-mega-in">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-3">
              <p class="text-sm font-semibold text-slate-900">What We Offer</p>
              <button type="button" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-900" @click="closeMega" aria-label="Close mega menu">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6l-12 12"/></svg>
              </button>
            </div>
            <div class="grid max-h-[62vh] gap-5 overflow-y-auto px-6 py-5 text-slate-900 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_minmax(0,1fr)_260px]">
              <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">Services</p>
                <p class="mt-2 text-sm text-slate-600">Explore our top technology services and solutions.</p>
                <div class="mt-4 space-y-3">
                  <router-link
                    v-for="item in serviceLinks"
                    :key="item.label"
                    :to="item.to"
                    @mouseenter="setActivePreview(item)"
                    @focus="setActivePreview(item)"
                    @click="closeMega"
                    class="group flex w-full items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-left transition hover:border-primary/40"
                  >
                    <img :src="item.img" alt="" decoding="async" class="h-12 w-12 rounded-2xl object-cover border border-slate-200" />
                    <div class="min-w-0">
                      <p class="text-sm font-semibold text-slate-900 group-hover:text-primary">{{ item.label }}</p>
                      <p class="text-xs text-slate-500">{{ item.desc }}</p>
                    </div>
                  </router-link>
                </div>
              </div>

              <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">Company</p>
                <p class="mt-2 text-sm text-slate-600">Find out what makes OmniviaTech different.</p>
                <div class="mt-4 space-y-2">
                  <router-link v-for="item in companyLinks" :key="item.label" :to="item.to" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 hover:border-primary/40 transition">
                    <img :src="item.img" alt="" decoding="async" class="h-10 w-10 rounded-xl object-cover border border-slate-200" />
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
                  <router-link v-for="item in resourceLinks" :key="item.label" :to="item.to" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 hover:border-primary/40 transition">
                    <img :src="item.img" alt="" decoding="async" class="h-10 w-10 rounded-xl object-cover border border-slate-200" />
                    <div class="min-w-0">
                      <p class="font-semibold text-slate-900">{{ item.label }}</p>
                      <p class="text-xs text-slate-500">{{ item.desc }}</p>
                    </div>
                  </router-link>
                </div>
              </div>

              <div class="rounded-3xl border border-slate-200 p-4 bg-white">
                <div class="relative overflow-hidden rounded-3xl">
                  <img :src="activePreview.img" :alt="activePreview.label" decoding="async" class="h-44 w-full object-cover transition duration-300" />
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
        </div>

        <div class="mega-trigger" @mouseenter="hoverOpen('solutions')" @mouseleave="hoverClose">
          <button @click.prevent="toggleMega('solutions')" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10" :class="{ 'text-primary': megaOpen === 'solutions' }">Solutions <svg class="w-3.5 h-3.5 inline-block ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg></button>
          <div v-if="megaOpen === 'solutions'" class="mega-dropdown fixed left-1/2 top-[74px] z-50 mt-2 w-[min(94vw,980px)] -translate-x-1/2 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl animate-mega-in">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-3">
              <p class="text-sm font-semibold text-slate-900">Solutions</p>
              <button type="button" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-900" @click="closeMega" aria-label="Close mega menu">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6l-12 12"/></svg>
              </button>
            </div>
            <div class="grid max-h-[58vh] gap-4 overflow-y-auto px-6 py-5 md:grid-cols-2 lg:grid-cols-4">
              <router-link v-for="item in solutionsLinks" :key="item.label" :to="item.to" class="rounded-2xl border border-slate-200 bg-white p-4 transition hover:border-primary/40">
                <img :src="item.img" alt="" decoding="async" class="h-16 w-full rounded-xl object-cover" />
                <p class="mt-3 text-sm font-semibold text-slate-900">{{ item.label }}</p>
                <p class="mt-1 text-xs text-slate-600">{{ item.desc }}</p>
              </router-link>
            </div>
          </div>
        </div>

        <div class="mega-trigger" @mouseenter="hoverOpen('company')" @mouseleave="hoverClose">
          <button @click.prevent="toggleMega('company')" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10" :class="{ 'text-primary': megaOpen === 'company' }">Company <svg class="w-3.5 h-3.5 inline-block ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg></button>
          <div v-if="megaOpen === 'company'" class="mega-dropdown fixed left-1/2 top-[74px] z-50 mt-2 w-[min(94vw,920px)] -translate-x-1/2 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl animate-mega-in">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-3">
              <p class="text-sm font-semibold text-slate-900">Company</p>
              <button type="button" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-900" @click="closeMega" aria-label="Close mega menu">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6l-12 12"/></svg>
              </button>
            </div>
            <div class="grid max-h-[58vh] gap-4 overflow-y-auto px-6 py-5 md:grid-cols-2 lg:grid-cols-3">
              <router-link v-for="item in companyLinks" :key="item.label" :to="item.to" class="rounded-2xl border border-slate-200 bg-white p-4 transition hover:border-primary/40">
                <img :src="item.img" alt="" decoding="async" class="h-16 w-full rounded-xl object-cover" />
                <p class="mt-3 text-sm font-semibold text-slate-900">{{ item.label }}</p>
                <p class="mt-1 text-xs text-slate-600">{{ item.desc }}</p>
              </router-link>
            </div>
          </div>
        </div>

        <div class="mega-trigger" @mouseenter="hoverOpen('marketplace')" @mouseleave="hoverClose">
          <button @click.prevent="toggleMega('marketplace')" class="nav-link px-3 py-2 text-white/80 hover:text-primary transition font-medium text-sm rounded-lg hover:bg-white/10" :class="{ 'text-primary': megaOpen === 'marketplace' }">Marketplace <svg class="w-3.5 h-3.5 inline-block ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg></button>
          <div v-if="megaOpen === 'marketplace'" class="mega-dropdown fixed left-1/2 top-[74px] z-50 mt-2 w-[min(94vw,1100px)] -translate-x-1/2 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl animate-mega-in">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-3">
              <p class="text-sm font-semibold text-slate-900">Marketplace</p>
              <button type="button" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-900" @click="closeMega" aria-label="Close mega menu">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6l-12 12"/></svg>
              </button>
            </div>
            <div class="max-h-[60vh] overflow-y-auto px-6 py-5">
              <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">Marketplace</p>
              <p class="mt-2 text-sm text-slate-600">Our SaaS products from the CMS.</p>
              <div class="mt-4 grid gap-4 grid-cols-2 md:grid-cols-4">
                <div v-for="p in marketProducts" :key="p.id" class="rounded-2xl border border-slate-200 bg-white p-3">
                  <router-link :to="`/products/${p.slug}`" class="block" @click="closeMega">
                    <img v-if="p.image_url" :src="p.image_url" alt="" decoding="async" class="h-24 w-full object-cover rounded-md mb-2" />
                    <p class="font-semibold text-slate-900">{{ p.name }}</p>
                    <p class="text-xs text-slate-500">{{ p.excerpt }}</p>
                  </router-link>
                </div>
                <div v-if="!marketProducts || marketProducts.length === 0" class="text-sm text-slate-600">No products yet. <router-link to="/products" class="text-primary">View products</router-link></div>
              </div>
            </div>
          </div>
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
      enter-active-class="transition duration-150 ease-out"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition duration-100 ease-in"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div v-if="mobileMenuOpen" class="border-t border-slate-800 bg-slate-950/95 lg:hidden">
        <div class="space-y-1 px-4 py-4">
          <div class="mb-2 flex items-center justify-between px-1">
            <p class="text-sm font-semibold text-slate-200">Menu</p>
            <button type="button" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-900 hover:text-white" @click="mobileMenuOpen = false" aria-label="Close mobile menu">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6l-12 12"/></svg>
            </button>
          </div>
          <router-link to="/" class="block rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition">Home</router-link>

          <button
            @click="mobileExpanded = mobileExpanded === 'what' ? null : 'what'"
            class="flex w-full items-center justify-between rounded-2xl border border-slate-800 bg-slate-900 px-4 py-3 text-left text-sm font-medium text-slate-200 hover:border-primary/40 transition"
            type="button"
          >
            <span>What We Offer</span>
            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': mobileExpanded === 'what' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div v-show="mobileExpanded === 'what'" class="grid grid-cols-1 gap-3 px-3 pt-2">
            <router-link v-for="item in serviceLinks" :key="item.label" :to="item.to" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm text-slate-200 hover:bg-slate-900 hover:text-primary transition" @click="mobileMenuOpen = false">
              <img :src="item.img" alt="" class="h-10 w-10 rounded-xl object-cover border border-slate-800" />
              <span>{{ item.label }}</span>
            </router-link>
          </div>

          <button
            @click="mobileExpanded = mobileExpanded === 'solutions' ? null : 'solutions'"
            class="flex w-full items-center justify-between rounded-2xl border border-slate-800 bg-slate-900 px-4 py-3 text-left text-sm font-medium text-slate-200 hover:border-primary/40 transition"
            type="button"
          >
            <span>Solutions</span>
            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': mobileExpanded === 'solutions' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div v-show="mobileExpanded === 'solutions'" class="grid grid-cols-2 gap-3 px-3 pt-2">
            <router-link v-for="item in solutionsLinks" :key="item.label" :to="item.to" class="rounded-2xl border border-slate-800 bg-slate-900 p-3 text-sm text-slate-200 hover:border-primary/40 hover:text-primary transition" @click="mobileMenuOpen = false">
              <img :src="item.img" alt="" class="mb-2 h-16 w-full rounded-xl object-cover" />
              <span class="block font-medium">{{ item.label }}</span>
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
          <div v-show="mobileExpanded === 'company'" class="grid grid-cols-1 gap-3 px-3 pt-2">
            <router-link v-for="item in companyLinks" :key="item.label" :to="item.to" class="flex items-center gap-3 rounded-2xl border border-slate-800 bg-slate-900 px-4 py-3 text-sm text-slate-200 hover:border-primary/40 hover:text-primary transition" @click="mobileMenuOpen = false">
              <img :src="item.img" alt="" class="h-10 w-10 rounded-xl object-cover border border-slate-800" />
              <div>
                <span class="block font-medium">{{ item.label }}</span>
                <span class="block text-xs text-slate-400">{{ item.desc }}</span>
              </div>
            </router-link>
          </div>

          <button
            @click="mobileExpanded = mobileExpanded === 'marketplace' ? null : 'marketplace'"
            class="flex w-full items-center justify-between rounded-2xl border border-slate-800 bg-slate-900 px-4 py-3 text-left text-sm font-medium text-slate-200 hover:border-primary/40 transition"
            type="button"
          >
            <span>Marketplace</span>
            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': mobileExpanded === 'marketplace' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div v-show="mobileExpanded === 'marketplace'" class="grid grid-cols-2 gap-3 px-3 pt-2">
            <router-link v-for="p in marketProducts" :key="p.id" :to="`/products/${p.slug}`" class="rounded-2xl border border-slate-800 bg-slate-900 p-3 text-sm text-slate-200 hover:border-primary/40 hover:text-primary transition" @click="mobileMenuOpen = false">
              <img v-if="p.image_url" :src="p.image_url" alt="" class="mb-2 h-16 w-full rounded-xl object-cover" />
              <span class="block font-medium">{{ p.name }}</span>
            </router-link>
          </div>

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
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import laptopInDark from '@/../img/laptop-in-dark.webp';
import defaultLogo from '@/../img/Omnivatech-logo.webp';
import apiDevelopmentImage from '@/../img/services/API Development.webp';
import crmErpDevelopmentImage from '@/../img/services/CRM & ERP Development.webp';
import customWebDevelopmentImage from '@/../img/services/Custom Web Development.webp';
import eCommerceDevelopmentImage from '@/../img/services/E-commerece Development.webp';
import mobileAppDevelopmentImage from '@/../img/services/Mobile App Development.webp';
import paidAdsImage from '@/../img/services/Paid Ads.webp';
import seoOptimizationImage from '@/../img/services/SEO Optimization.webp';
import tech1 from '@/../img/tech1.webp';
import tech2 from '@/../img/tech2.webp';
import tech3 from '@/../img/tech3.webp';
import tech4 from '@/../img/tech4.webp';
import tech5 from '@/../img/tech5.webp';
import tech6 from '@/../img/tech6.webp';
import ThemeToggle from '@/components/shared/ThemeToggle.vue';
import { useAuthStore } from '@/stores/auth';
import { useCmsStore } from '@/stores/cms';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const cmsStore = useCmsStore();

const settings = computed(() => cmsStore.homeData?.settings);

const mobileMenuOpen = ref(false);
const megaOpen = ref<string | null>(null);
const mobileExpanded = ref<string | null>(null);

const serviceLinks = [
  { to: '/services/custom-web-development', label: 'Custom Web Development', desc: 'Enterprise websites and portals', img: customWebDevelopmentImage },
  { to: '/services/mobile-app-development', label: 'Mobile App Development', desc: 'iOS and Android app solutions', img: mobileAppDevelopmentImage },
  { to: '/services/e-commerce-development', label: 'E-commerce Development', desc: 'Stores and marketplaces', img: eCommerceDevelopmentImage },
  { to: '/services/crm-erp-development', label: 'CRM & ERP Development', desc: 'Business systems and automation', img: crmErpDevelopmentImage },
  { to: '/services/api-development-integration', label: 'API Integration', desc: 'Secure backend and integrations', img: apiDevelopmentImage },
  { to: '/services/seo-optimization-analytics', label: 'SEO Optimization & Analytics', desc: 'Boost organic traffic and search rankings', img: seoOptimizationImage },
  { to: '/services/paid-ads-management', label: 'Paid Ads Management', desc: 'Strategic advertising across platforms', img: paidAdsImage },
];

const solutionsLinks = [
  {
    to: '/services',
    label: 'Services',
    desc: 'Custom development and digital solutions',
    img: customWebDevelopmentImage,
  },
  {
    to: '/packages',
    label: 'Packages',
    desc: 'Ready-made website packages',
    img: tech3,
  },
  {
    to: '/bundles',
    label: 'Bundles',
    desc: 'Packaged offerings for faster delivery',
    img: paidAdsImage,
  },
  {
    to: '/products',
    label: 'Products',
    desc: 'Ready SaaS products built by our team',
    img: apiDevelopmentImage,
  },
  {
    to: '/industries',
    label: 'Industries',
    desc: 'Solutions tailored by sector',
    img: eCommerceDevelopmentImage,
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

function setActivePreview(item: PreviewItem) {
  activePreview.value = item;
}

function navigateTo(to: string) {
  mobileMenuOpen.value = false;
  megaOpen.value = null;
  router.push(to);
}

// ── Snappy open/close ─────────────────────────────────────────
// Menus open on hover (desktop) with a tiny intent delay so sweeping the cursor
// across the nav doesn't flash panels; once a menu is open, moving to a sibling
// switches instantly. A short close delay lets the cursor cross the gap into the panel.
const HOVER_OPEN_DELAY = 60;
const HOVER_CLOSE_DELAY = 160;
let hoverTimer: ReturnType<typeof setTimeout> | null = null;
const openedByHover = ref(false);
const canHover = typeof window !== 'undefined' && window.matchMedia?.('(hover: hover) and (pointer: fine)').matches;

function clearHoverTimer() {
  if (hoverTimer) { clearTimeout(hoverTimer); hoverTimer = null; }
}

function hoverOpen(key: string) {
  if (!canHover) return;
  clearHoverTimer();
  if (megaOpen.value === key) return;
  if (megaOpen.value) {
    megaOpen.value = key;
    openedByHover.value = true;
    return;
  }
  hoverTimer = setTimeout(() => {
    megaOpen.value = key;
    openedByHover.value = true;
  }, HOVER_OPEN_DELAY);
}

function hoverClose() {
  if (!canHover) return;
  clearHoverTimer();
  // Menus pinned open by a click stay open until clicked away
  if (!openedByHover.value) return;
  hoverTimer = setTimeout(() => { megaOpen.value = null; }, HOVER_CLOSE_DELAY);
}

function toggleMega(key: string) {
  clearHoverTimer();
  // Clicking a menu that hover just opened pins it open instead of closing it
  if (megaOpen.value === key && openedByHover.value) {
    openedByHover.value = false;
    return;
  }
  megaOpen.value = megaOpen.value === key ? null : key;
  openedByHover.value = false;
}

function closeMega() {
  clearHoverTimer();
  megaOpen.value = null;
  openedByHover.value = false;
}

function handleKeydown(event: KeyboardEvent) {
  if (event.key === 'Escape' && megaOpen.value) closeMega();
}

// Close menus as soon as navigation happens (links inside panels don't all call closeMega)
watch(() => route.fullPath, () => {
  closeMega();
  mobileMenuOpen.value = false;
});

// Warm the browser cache with every menu image while idle, so panels appear fully painted
function preloadMenuImages() {
  const urls = new Set<string>();
  [...serviceLinks, ...solutionsLinks, ...companyLinks, ...resourceLinks].forEach((i) => urls.add(i.img));
  urls.forEach((src) => {
    const img = new Image();
    img.decoding = 'async';
    img.src = src;
  });
}

function handleDocumentClick(event: MouseEvent) {
  if (!megaOpen.value) return;
  const target = event.target as HTMLElement | null;
  if (!target) return;
  
  const isMegaRelated = target.closest('.mega-trigger') || target.closest('.mega-dropdown');
  if (!isMegaRelated) {
    megaOpen.value = null;
  }
}

// marketplace products from cms store
const marketProducts = computed(() => cmsStore.homeData?.featured_products || []);

onMounted(() => {
  document.addEventListener('click', handleDocumentClick);
  document.addEventListener('keydown', handleKeydown);
  const idle = (window as any).requestIdleCallback || ((cb: () => void) => setTimeout(cb, 1200));
  idle(preloadMenuImages);
});

onBeforeUnmount(() => {
  clearHoverTimer();
  document.removeEventListener('click', handleDocumentClick);
  document.removeEventListener('keydown', handleKeydown);
});

async function handleLogout() {
  await authStore.logout();
  router.push('/login');
}
</script>

<style scoped>
.animate-mega-in {
  animation: mega-in 90ms cubic-bezier(0.2, 0, 0, 1);
}

@keyframes mega-in {
  from { opacity: 0; transform: translateY(-4px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
