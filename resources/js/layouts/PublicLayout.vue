<template>
  <div class="public-layout min-h-screen flex flex-col bg-background text-foreground">
    <!-- Top Bar -->
    <TopBar />

    <!-- Navigation -->
    <nav class="navbar sticky top-0 z-30 bg-card/90 backdrop-blur-xl border-b border-border">
      <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
          <!-- Logo -->
          <router-link to="/" class="flex items-center gap-3 group">
            <img
              v-if="settings?.logo_path"
              :src="`/storage/${settings.logo_path}`"
              alt="Logo"
              class="h-10 w-auto"
            />
            <div v-else class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-lg flex items-center justify-center">
              <span class="text-white font-bold text-xl">TS</span>
            </div>
            <span class="text-xl font-display font-bold text-foreground group-hover:text-primary transition">
              {{ settings?.site_name || 'TechSmart' }}
            </span>
          </router-link>

          <!-- Desktop Menu -->
          <div class="hidden lg:flex items-center gap-6">
            <router-link
              v-for="link in navLinks"
              :key="link.to"
              :to="link.to"
              class="nav-link text-muted-foreground hover:text-primary transition font-medium text-sm"
              active-class="text-primary"
            >
              {{ link.label }}
            </router-link>
          </div>

          <!-- Right Side: Theme Toggle + Auth -->
          <div class="hidden lg:flex items-center gap-3">
            <ThemeToggle />

            <template v-if="authStore.isAuthenticated">
              <router-link
                to="/dashboard"
                class="text-sm text-muted-foreground hover:text-primary transition"
              >
                Dashboard
              </router-link>
              <button
                @click="handleLogout"
                class="px-4 py-2 text-sm bg-card border border-border hover:border-primary text-foreground rounded-lg transition"
              >
                Logout
              </button>
            </template>
            <template v-else>
              <router-link
                to="/login"
                class="px-4 py-2 text-sm text-muted-foreground hover:text-foreground transition"
              >
                Login
              </router-link>
              <router-link
                to="/register"
                class="px-5 py-2 text-sm bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:shadow-primary/25 transform hover:scale-105 transition font-semibold"
              >
                Get Started
              </router-link>
            </template>
          </div>

          <!-- Mobile Menu Button -->
          <div class="flex lg:hidden items-center gap-2">
            <ThemeToggle />
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="text-foreground p-2"
            >
              <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile Menu -->
        <transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 -translate-y-2"
          enter-to-class="opacity-100 translate-y-0"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 translate-y-0"
          leave-to-class="opacity-0 -translate-y-2"
        >
          <div v-if="mobileMenuOpen" class="lg:hidden mt-4 pb-4 space-y-2">
            <router-link
              v-for="link in navLinks"
              :key="link.to"
              :to="link.to"
              class="block py-2.5 px-3 rounded-lg text-muted-foreground hover:text-primary hover:bg-muted transition"
              @click="mobileMenuOpen = false"
            >
              {{ link.label }}
            </router-link>

            <div class="pt-3 border-t border-border space-y-2">
              <template v-if="authStore.isAuthenticated">
                <router-link to="/dashboard" class="block py-2.5 px-3 text-muted-foreground hover:text-primary transition" @click="mobileMenuOpen = false">
                  Dashboard
                </router-link>
                <button @click="handleLogout" class="w-full text-left py-2.5 px-3 text-muted-foreground hover:text-primary transition">
                  Logout
                </button>
              </template>
              <template v-else>
                <router-link to="/login" class="block py-2.5 px-3 text-muted-foreground hover:text-primary transition" @click="mobileMenuOpen = false">
                  Login
                </router-link>
                <router-link to="/register" class="block py-2.5 px-3 text-primary font-semibold" @click="mobileMenuOpen = false">
                  Get Started
                </router-link>
              </template>
            </div>
          </div>
        </transition>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- World-Class Footer -->
    <footer class="relative bg-card text-foreground overflow-hidden">
      <!-- Decorative gradient orbs -->
      <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>

      <!-- Newsletter Strip -->
      <div class="relative border-b border-border">
        <div class="container mx-auto px-4 py-12">
          <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
              <h3 class="text-2xl font-display font-bold mb-1">Stay in the loop</h3>
              <p class="text-muted-foreground text-sm">Subscribe to our newsletter for the latest updates &amp; offers</p>
            </div>
            <form @submit.prevent="handleNewsletter" class="flex w-full md:w-auto gap-2">
              <input
                v-model="newsletterEmail"
                type="email"
                placeholder="Enter your email"
                required
                class="flex-1 md:w-72 px-4 py-3 bg-card border border-border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:border-primary transition text-sm"
              />
              <button
                type="submit"
                class="px-6 py-3 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg hover:shadow-primary/25 transition font-semibold text-sm whitespace-nowrap"
              >
                Subscribe
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Main Footer Content -->
      <div class="relative container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12">
          <!-- Brand Column -->
          <div class="lg:col-span-2">
            <router-link to="/" class="flex items-center gap-3 mb-6">
              <div class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-xl">TS</span>
              </div>
              <span class="text-xl font-display font-bold text-foreground">
                {{ settings?.site_name || 'TechSmart' }}
              </span>
            </router-link>
            <p class="text-muted-foreground text-sm leading-relaxed mb-6 max-w-sm">
              {{ settings?.tagline || 'Empowering businesses with innovative technology solutions. We deliver cutting-edge services that drive growth and digital transformation.' }}
            </p>
            <!-- Social Links -->
            <div class="flex items-center gap-4">
              <a v-if="settings?.facebook_url" :href="settings.facebook_url" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-lg bg-card hover:bg-primary text-muted-foreground hover:text-foreground transition-all duration-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
              <a v-if="settings?.twitter_url" :href="settings.twitter_url" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-lg bg-card hover:bg-primary text-muted-foreground hover:text-foreground transition-all duration-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
              </a>
              <a v-if="settings?.linkedin_url" :href="settings.linkedin_url" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-lg bg-card hover:bg-primary text-muted-foreground hover:text-foreground transition-all duration-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
              </a>
              <a v-if="settings?.instagram_url" :href="settings.instagram_url" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-lg bg-card hover:bg-primary text-muted-foreground hover:text-foreground transition-all duration-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div>
            <h4 class="text-sm font-semibold text-foreground uppercase tracking-wider mb-5">Quick Links</h4>
            <ul class="space-y-3">
              <li v-for="link in footerQuickLinks" :key="link.to">
                <router-link :to="link.to" class="text-muted-foreground hover:text-primary transition text-sm flex items-center gap-2">
                  <span class="w-1 h-1 rounded-full bg-primary/50"></span>
                  {{ link.label }}
                </router-link>
              </li>
            </ul>
          </div>

          <!-- Support -->
          <div>
            <h4 class="text-sm font-semibold text-foreground uppercase tracking-wider mb-5">Support</h4>
            <ul class="space-y-3">
              <li v-for="link in footerSupportLinks" :key="link.to">
                <router-link :to="link.to" class="text-muted-foreground hover:text-primary transition text-sm flex items-center gap-2">
                  <span class="w-1 h-1 rounded-full bg-accent/50"></span>
                  {{ link.label }}
                </router-link>
              </li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div>
            <h4 class="text-sm font-semibold text-foreground uppercase tracking-wider mb-5">Get in Touch</h4>
            <ul class="space-y-4">
              <li v-if="settings?.contact_email" class="flex items-start gap-3 text-sm text-muted-foreground">
                <svg class="w-4 h-4 mt-0.5 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <a :href="`mailto:${settings.contact_email}`" class="hover:text-primary transition">{{ settings.contact_email }}</a>
              </li>
              <li v-if="settings?.contact_phone" class="flex items-start gap-3 text-sm text-muted-foreground">
                <svg class="w-4 h-4 mt-0.5 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <a :href="`tel:${settings.contact_phone}`" class="hover:text-primary transition">{{ settings.contact_phone }}</a>
              </li>
              <li v-if="settings?.address" class="flex items-start gap-3 text-sm text-muted-foreground">
                <svg class="w-4 h-4 mt-0.5 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>{{ settings.address }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="relative border-t border-border">
        <div class="container mx-auto px-4 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
          <p class="text-xs text-muted-foreground">
            &copy; {{ new Date().getFullYear() }} {{ settings?.site_name || 'TechSmart' }}. All rights reserved.
          </p>
          <div class="flex items-center gap-6 text-xs text-muted-foreground">
            <router-link to="/privacy" class="hover:text-primary transition">Privacy Policy</router-link>
            <router-link to="/terms" class="hover:text-primary transition">Terms of Service</router-link>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { useCmsStore } from '@/stores/cms';
import { useToast } from '@/composables';
import TopBar from '@/components/shared/TopBar.vue';
import ThemeToggle from '@/components/shared/ThemeToggle.vue';
import axios from 'axios';

const router = useRouter();
const authStore = useAuthStore();
const cmsStore = useCmsStore();
const { success } = useToast();

const mobileMenuOpen = ref(false);
const newsletterEmail = ref('');

const settings = computed(() => cmsStore.homeData?.settings);

const navLinks = [
  { to: '/', label: 'Home' },
  { to: '/about', label: 'About' },
  { to: '/services', label: 'Services' },
  { to: '/products', label: 'Products' },
  { to: '/bundles', label: 'Bundles' },
  { to: '/blog', label: 'Blog' },
  { to: '/contact', label: 'Contact' },
];

const footerQuickLinks = [
  { to: '/about', label: 'About Us' },
  { to: '/services', label: 'Services' },
  { to: '/products', label: 'Products' },
  { to: '/bundles', label: 'Bundles' },
  { to: '/blog', label: 'Blog' },
];

const footerSupportLinks = [
  { to: '/faqs', label: 'FAQs' },
  { to: '/contact', label: 'Contact Us' },
  { to: '/privacy', label: 'Privacy Policy' },
  { to: '/terms', label: 'Terms of Service' },
];

onMounted(async () => {
  if (!cmsStore.homeData) {
    await cmsStore.fetchHomeData().catch(() => {
      console.error('Failed to fetch home data');
    });
  }
});

async function handleLogout() {
  await authStore.logout();
  success('Logged out successfully');
  router.push('/login');
}

async function handleNewsletter() {
  if (!newsletterEmail.value) return;
  try {
    await axios.post('/api/v1/newsletter/subscribe', { email: newsletterEmail.value });
    success('Subscribed successfully!');
    newsletterEmail.value = '';
  } catch {
    // Silently handle
  }
}
</script>

<style scoped>
.nav-link {
  position: relative;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(to right, var(--color-primary), var(--color-accent));
  transition: width 0.3s ease;
}

.nav-link:hover::after,
.nav-link.router-link-active::after {
  width: 100%;
}
</style>
