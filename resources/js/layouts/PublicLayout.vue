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
              {{ settings?.site_name || 'Smartech Research Labs' }}
            </span>
          </router-link>

          <!-- Desktop Mega Menu -->
          <div class="hidden lg:flex items-center gap-1">
            <!-- Home -->
            <router-link to="/" class="nav-link px-3 py-2 text-muted-foreground hover:text-primary transition font-medium text-sm rounded-lg hover:bg-muted/50" active-class="text-primary">Home</router-link>

            <!-- Solutions Dropdown -->
            <div class="relative group" @mouseenter="openDropdown = 'solutions'" @mouseleave="openDropdown = null">
              <button class="nav-link px-3 py-2 text-muted-foreground hover:text-primary transition font-medium text-sm rounded-lg hover:bg-muted/50 flex items-center gap-1" :class="{ 'text-primary': isSolutionsActive }">
                Solutions
                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'solutions' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
              </button>
              <transition enter-active-class="transition duration-150 ease-out" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                <div v-show="openDropdown === 'solutions'" class="absolute top-full left-0 mt-1 w-[540px] bg-card border border-border rounded-xl shadow-xl p-5 z-50">
                  <div class="grid grid-cols-2 gap-1">
                    <router-link v-for="item in solutionsMenu" :key="item.to" :to="item.to" class="flex items-start gap-3 p-3 rounded-lg hover:bg-muted/50 transition group/item">
                      <div class="w-10 h-10 shrink-0 rounded-lg flex items-center justify-center text-lg" :class="item.bgClass">{{ item.icon }}</div>
                      <div>
                        <div class="text-sm font-semibold text-foreground group-hover/item:text-primary transition">{{ item.label }}</div>
                        <div class="text-xs text-muted-foreground mt-0.5">{{ item.desc }}</div>
                      </div>
                    </router-link>
                  </div>
                </div>
              </transition>
            </div>

            <!-- Company Dropdown -->
            <div class="relative group" @mouseenter="openDropdown = 'company'" @mouseleave="openDropdown = null">
              <button class="nav-link px-3 py-2 text-muted-foreground hover:text-primary transition font-medium text-sm rounded-lg hover:bg-muted/50 flex items-center gap-1" :class="{ 'text-primary': isCompanyActive }">
                Company
                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'company' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
              </button>
              <transition enter-active-class="transition duration-150 ease-out" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                <div v-show="openDropdown === 'company'" class="absolute top-full left-0 mt-1 w-[320px] bg-card border border-border rounded-xl shadow-xl p-4 z-50">
                  <div class="space-y-1">
                    <router-link v-for="item in companyMenu" :key="item.to" :to="item.to" class="flex items-center gap-3 p-3 rounded-lg hover:bg-muted/50 transition group/item">
                      <div class="w-9 h-9 shrink-0 rounded-lg flex items-center justify-center text-base" :class="item.bgClass">{{ item.icon }}</div>
                      <div>
                        <div class="text-sm font-semibold text-foreground group-hover/item:text-primary transition">{{ item.label }}</div>
                        <div class="text-xs text-muted-foreground mt-0.5">{{ item.desc }}</div>
                      </div>
                    </router-link>
                  </div>
                </div>
              </transition>
            </div>

            <!-- Blog -->
            <router-link to="/blog" class="nav-link px-3 py-2 text-muted-foreground hover:text-primary transition font-medium text-sm rounded-lg hover:bg-muted/50" active-class="text-primary">Blog</router-link>

            <!-- Contact -->
            <router-link to="/contact" class="nav-link px-3 py-2 text-muted-foreground hover:text-primary transition font-medium text-sm rounded-lg hover:bg-muted/50" active-class="text-primary">Contact</router-link>
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
          <div v-if="mobileMenuOpen" class="lg:hidden mt-4 pb-4 space-y-1">
            <router-link to="/" class="block py-2.5 px-3 rounded-lg text-muted-foreground hover:text-primary hover:bg-muted transition" @click="mobileMenuOpen = false">Home</router-link>
            
            <!-- Solutions Group -->
            <div>
              <button @click="mobileExpanded = mobileExpanded === 'solutions' ? null : 'solutions'" class="w-full flex items-center justify-between py-2.5 px-3 rounded-lg text-muted-foreground hover:text-primary hover:bg-muted transition">
                <span>Solutions</span>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': mobileExpanded === 'solutions' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
              </button>
              <div v-show="mobileExpanded === 'solutions'" class="ml-3 pl-3 border-l border-border space-y-1">
                <router-link v-for="item in solutionsMenu" :key="item.to" :to="item.to" class="flex items-center gap-2 py-2 px-3 rounded-lg text-sm text-muted-foreground hover:text-primary hover:bg-muted transition" @click="mobileMenuOpen = false">
                  <span>{{ item.icon }}</span> {{ item.label }}
                </router-link>
              </div>
            </div>
            
            <!-- Company Group -->
            <div>
              <button @click="mobileExpanded = mobileExpanded === 'company' ? null : 'company'" class="w-full flex items-center justify-between py-2.5 px-3 rounded-lg text-muted-foreground hover:text-primary hover:bg-muted transition">
                <span>Company</span>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': mobileExpanded === 'company' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
              </button>
              <div v-show="mobileExpanded === 'company'" class="ml-3 pl-3 border-l border-border space-y-1">
                <router-link v-for="item in companyMenu" :key="item.to" :to="item.to" class="flex items-center gap-2 py-2 px-3 rounded-lg text-sm text-muted-foreground hover:text-primary hover:bg-muted transition" @click="mobileMenuOpen = false">
                  <span>{{ item.icon }}</span> {{ item.label }}
                </router-link>
              </div>
            </div>
            
            <router-link to="/blog" class="block py-2.5 px-3 rounded-lg text-muted-foreground hover:text-primary hover:bg-muted transition" @click="mobileMenuOpen = false">Blog</router-link>
            <router-link to="/contact" class="block py-2.5 px-3 rounded-lg text-muted-foreground hover:text-primary hover:bg-muted transition" @click="mobileMenuOpen = false">Contact</router-link>

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

    <!-- Breadcrumbs (visible on non-home pages) -->
    <nav v-if="route.path !== '/'" aria-label="Breadcrumb" class="bg-muted/30 border-b border-border">
      <div class="container mx-auto px-4 py-2 flex items-center gap-1.5 text-xs text-muted-foreground">
        <router-link to="/" class="hover:text-primary transition">Home</router-link>
        <template v-for="(crumb, i) in breadcrumbs" :key="crumb.path">
          <svg class="w-3 h-3 text-muted-foreground/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6" /></svg>
          <router-link
            v-if="i < breadcrumbs.length - 1"
            :to="crumb.path"
            class="hover:text-primary transition"
          >
            {{ crumb.label }}
          </router-link>
          <span v-else class="text-foreground font-medium">{{ crumb.label }}</span>
        </template>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- Modern Footer -->
    <footer class="bg-gray-950 text-gray-300">
      <!-- Newsletter Strip -->
      <div class="border-b border-gray-800">
        <div class="container mx-auto px-4 py-8">
          <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
              <h3 class="text-lg font-bold text-white mb-1">Stay Ahead with Smartech</h3>
              <p class="text-gray-400 text-sm">Get the latest insights, news, and exclusive offers delivered to your inbox.</p>
            </div>
            <form @submit.prevent="handleNewsletter" class="flex gap-3 w-full md:w-auto">
              <input v-model="newsletterEmail" type="email" required placeholder="Enter your email" class="flex-1 md:w-72 px-5 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white text-sm placeholder-gray-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/30 transition" />
              <button type="submit" class="px-6 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition whitespace-nowrap">Subscribe</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Main Footer Grid -->
      <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10">
          <!-- Brand Column -->
          <div class="lg:col-span-2">
            <router-link to="/" class="flex items-center gap-2 mb-5">
              <img
                v-if="settings?.logo_path"
                :src="`/storage/${settings.logo_path}`"
                alt="Logo"
                class="h-10 w-auto brightness-0 invert"
              />
              <div v-else class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-xl">TS</span>
              </div>
              <span class="text-lg font-bold text-white">
                {{ settings?.site_name || 'Smartech Research Labs' }}
              </span>
            </router-link>
            <p class="text-gray-400 text-sm leading-relaxed mb-6 max-w-sm">
              {{ settings?.tagline || 'Empowering businesses with innovative technology solutions that drive growth and digital transformation across Africa and beyond.' }}
            </p>
            <!-- Social Links -->
            <div class="flex items-center gap-3 mb-6">
              <a v-if="settings?.facebook_url" :href="settings.facebook_url" target="_blank" rel="noopener" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-primary text-gray-400 hover:text-white transition-all duration-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
              <a v-if="settings?.twitter_url" :href="settings.twitter_url" target="_blank" rel="noopener" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-primary text-gray-400 hover:text-white transition-all duration-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
              </a>
              <a v-if="settings?.linkedin_url" :href="settings.linkedin_url" target="_blank" rel="noopener" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-primary text-gray-400 hover:text-white transition-all duration-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
              </a>
              <a v-if="settings?.instagram_url" :href="settings.instagram_url" target="_blank" rel="noopener" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-primary text-gray-400 hover:text-white transition-all duration-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              </a>
              <a v-if="settings?.youtube_url" :href="settings.youtube_url" target="_blank" rel="noopener" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-800 hover:bg-red-600 text-gray-400 hover:text-white transition-all duration-300">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
              </a>
            </div>
            <!-- Working Hours -->
            <div class="text-sm">
              <div class="flex items-center gap-2 text-gray-400 mb-1">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Mon - Fri: 8:00 AM - 6:00 PM</span>
              </div>
              <div class="flex items-center gap-2 text-gray-400">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Sat: 9:00 AM - 1:00 PM</span>
              </div>
            </div>
          </div>

          <!-- Services Links -->
          <div>
            <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-5">Our Services</h4>
            <ul class="space-y-2.5">
              <li v-for="link in footerServicesLinks" :key="link.to">
                <router-link :to="link.to" class="text-gray-400 hover:text-primary transition text-sm flex items-center gap-2">
                  <svg class="w-3 h-3 text-primary/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                  {{ link.label }}
                </router-link>
              </li>
            </ul>
          </div>

          <!-- Quick Links -->
          <div>
            <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-5">Quick Links</h4>
            <ul class="space-y-2.5">
              <li v-for="link in footerQuickLinks" :key="link.to">
                <router-link :to="link.to" class="text-gray-400 hover:text-primary transition text-sm flex items-center gap-2">
                  <svg class="w-3 h-3 text-primary/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                  {{ link.label }}
                </router-link>
              </li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div>
            <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-5">Get in Touch</h4>
            <ul class="space-y-4">
              <li v-if="settings?.contact_email" class="flex items-start gap-3 text-sm">
                <svg class="w-4 h-4 mt-0.5 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <a :href="`mailto:${settings.contact_email}`" class="text-gray-400 hover:text-primary transition">{{ settings.contact_email }}</a>
              </li>
              <li v-if="settings?.contact_phone" class="flex items-start gap-3 text-sm">
                <svg class="w-4 h-4 mt-0.5 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <a :href="`tel:${settings.contact_phone}`" class="text-gray-400 hover:text-primary transition">{{ settings.contact_phone }}</a>
              </li>
              <li v-if="settings?.address" class="flex items-start gap-3 text-sm">
                <svg class="w-4 h-4 mt-0.5 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-gray-400">{{ settings.address }}</span>
              </li>
            </ul>

            <!-- Payment Methods -->
            <div class="mt-6">
              <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">We Accept</h5>
              <div class="flex flex-wrap items-center gap-2">
                <div class="h-8 px-3 bg-gray-800 rounded-md flex items-center justify-center" title="Visa">
                  <span class="text-xs font-bold text-blue-400 tracking-wide">VISA</span>
                </div>
                <div class="h-8 px-2 bg-gray-800 rounded-md flex items-center justify-center" title="Mastercard">
                  <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full bg-red-500 -mr-1.5"></div>
                    <div class="w-4 h-4 rounded-full bg-yellow-500 opacity-80"></div>
                  </div>
                </div>
                <div class="h-8 px-3 bg-gray-800 rounded-md flex items-center justify-center" title="M-Pesa">
                  <span class="text-xs font-bold text-green-400">M-PESA</span>
                </div>
                <div class="h-8 px-3 bg-gray-800 rounded-md flex items-center justify-center" title="PayPal">
                  <span class="text-xs font-bold text-blue-300">Pay<span class="text-blue-500">Pal</span></span>
                </div>
                <div class="h-8 px-3 bg-gray-800 rounded-md flex items-center justify-center" title="Bank Transfer">
                  <span class="text-xs font-bold text-gray-300">BANK</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="border-t border-gray-800">
        <div class="container mx-auto px-4 py-5 flex flex-col md:flex-row items-center justify-between gap-4">
          <p class="text-sm text-gray-500">
            &copy; {{ new Date().getFullYear() }} {{ settings?.site_name || 'Smartech Research Labs' }}. All rights reserved.
          </p>
          <div class="flex items-center gap-6 text-sm text-gray-500">
            <router-link to="/privacy" class="hover:text-primary transition">Privacy Policy</router-link>
            <router-link to="/terms" class="hover:text-primary transition">Terms of Service</router-link>
            <router-link to="/sitemap" class="hover:text-primary transition">Sitemap</router-link>
          </div>
        </div>
      </div>
    </footer>

    <!-- WhatsApp Floating Button (Bottom Left) -->
    <WhatsAppButton />
    
    <!-- Chat Button with AI (Bottom Right) -->
    <FloatingChatButton />
    
    <!-- Scroll to Top Button (Bottom Right, above chat) -->
    <ScrollToTopButton />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, watchEffect, onUnmounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { useCmsStore } from '@/stores/cms';
import { useToast } from '@/composables';
import TopBar from '@/components/shared/TopBar.vue';
import ThemeToggle from '@/components/shared/ThemeToggle.vue';
import WhatsAppButton from '@/components/WhatsAppButton.vue';
import ScrollToTopButton from '@/components/ScrollToTopButton.vue';
import FloatingChatButton from '@/components/FloatingChatButton.vue';
import axios from 'axios';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const cmsStore = useCmsStore();
const { success } = useToast();

const mobileMenuOpen = ref(false);
const newsletterEmail = ref('');
const openDropdown = ref<string | null>(null);
const mobileExpanded = ref<string | null>(null);

const settings = computed(() => cmsStore.homeData?.settings);

// Mega menu data
const solutionsMenu = [
  { to: '/services', label: 'Services', desc: 'Technology & digital solutions', icon: '💡', bgClass: 'bg-primary/10' },
  { to: '/products', label: 'Products', desc: 'Ready-made software products', icon: '📦', bgClass: 'bg-accent/10' },
  { to: '/bundles', label: 'Bundles', desc: 'Discounted solution packages', icon: '🎁', bgClass: 'bg-green-500/10' },
  { to: '/industries', label: 'Industries', desc: 'Sector-specific solutions', icon: '🏭', bgClass: 'bg-amber-500/10' },
];

const companyMenu = [
  { to: '/about', label: 'About Us', desc: 'Our story & mission', icon: '🏢', bgClass: 'bg-primary/10' },
  { to: '/case-studies', label: 'Case Studies', desc: 'Success stories & projects', icon: '📊', bgClass: 'bg-accent/10' },
  { to: '/faqs', label: 'FAQs', desc: 'Common questions', icon: '❓', bgClass: 'bg-green-500/10' },
];

const isSolutionsActive = computed(() => ['/services', '/products', '/bundles', '/industries'].some(p => route.path.startsWith(p)));
const isCompanyActive = computed(() => ['/about', '/case-studies', '/faqs'].some(p => route.path.startsWith(p)));

// ── SEO: JSON-LD Schema Markup ──
const seoScriptEl = ref<HTMLScriptElement | null>(null);
const breadcrumbScriptEl = ref<HTMLScriptElement | null>(null);

const pageNameMap: Record<string, string> = {
  '/': 'Home',
  '/about': 'About Us',
  '/services': 'Services',
  '/products': 'Products',
  '/bundles': 'Bundles',
  '/case-studies': 'Case Studies',
  '/blog': 'Blog',
  '/contact': 'Contact',
  '/industries': 'Industries',
  '/faqs': 'FAQs',
};

watchEffect(() => {
  const s = settings.value;
  if (!s) return;
  const baseUrl = s.canonical_url || window.location.origin;

  // Organization / Website schema
  const orgSchema: any = {
    '@context': 'https://schema.org',
    '@type': s.schema_org_type || 'Organization',
    name: s.schema_org_name || s.site_name || 'Smartech Research Labs',
    url: baseUrl,
    description: s.meta_description || s.site_description || '',
  };
  if (s.schema_org_logo || s.logo_path) {
    orgSchema.logo = s.schema_org_logo || `${baseUrl}/storage/${s.logo_path}`;
  }
  if (s.schema_same_as) {
    orgSchema.sameAs = s.schema_same_as.split(',').map((u: string) => u.trim()).filter(Boolean);
  }
  if (s.contact_email) orgSchema.email = s.contact_email;
  if (s.contact_phone) orgSchema.telephone = s.contact_phone;
  if (s.address) {
    orgSchema.address = {
      '@type': 'PostalAddress',
      streetAddress: s.address,
      ...(s.city && { addressLocality: s.city }),
      ...(s.country && { addressCountry: s.country }),
    };
  }

  // Inject org schema
  if (!seoScriptEl.value) {
    seoScriptEl.value = document.createElement('script');
    seoScriptEl.value.type = 'application/ld+json';
    seoScriptEl.value.id = 'srl-org-schema';
    document.head.appendChild(seoScriptEl.value);
  }
  seoScriptEl.value.textContent = JSON.stringify(orgSchema);

  // Breadcrumb schema
  const path = route.path;
  const pageName = pageNameMap[path] || path.split('/').pop()?.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) || 'Page';
  const breadcrumbItems: any[] = [
    { '@type': 'ListItem', position: 1, name: 'Home', item: baseUrl },
  ];
  if (path !== '/') {
    const segments = path.split('/').filter(Boolean);
    let accumulated = '';
    segments.forEach((seg, i) => {
      accumulated += `/${seg}`;
      const segName = pageNameMap[accumulated] || seg.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
      breadcrumbItems.push({
        '@type': 'ListItem',
        position: i + 2,
        name: segName,
        item: `${baseUrl}${accumulated}`,
      });
    });
  }

  const breadcrumbSchema = {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: breadcrumbItems,
  };

  if (!breadcrumbScriptEl.value) {
    breadcrumbScriptEl.value = document.createElement('script');
    breadcrumbScriptEl.value.type = 'application/ld+json';
    breadcrumbScriptEl.value.id = 'srl-breadcrumb-schema';
    document.head.appendChild(breadcrumbScriptEl.value);
  }
  breadcrumbScriptEl.value.textContent = JSON.stringify(breadcrumbSchema);

  // Update meta tags
  const pageKey = path === '/' ? 'home' : path.split('/')[1]?.replace(/-/g, '_');
  const metaTitle = (s as any)[`${pageKey}_meta_title`] || s.meta_title || s.site_name;
  const metaDesc = (s as any)[`${pageKey}_meta_description`] || s.meta_description || '';

  document.title = metaTitle;
  let descTag = document.querySelector('meta[name="description"]') as HTMLMetaElement;
  if (!descTag) {
    descTag = document.createElement('meta');
    descTag.name = 'description';
    document.head.appendChild(descTag);
  }
  descTag.content = metaDesc;

  // OG tags
  setMetaTag('og:title', metaTitle);
  setMetaTag('og:description', metaDesc);
  setMetaTag('og:url', `${baseUrl}${path}`);
  if (s.og_image_default) setMetaTag('og:image', s.og_image_default);
  if (s.twitter_card_type) setMetaTag('twitter:card', s.twitter_card_type);
  if (s.twitter_handle) setMetaTag('twitter:site', s.twitter_handle);
});

function setMetaTag(property: string, content: string) {
  const attr = property.startsWith('twitter:') ? 'name' : 'property';
  let tag = document.querySelector(`meta[${attr}="${property}"]`) as HTMLMetaElement;
  if (!tag) {
    tag = document.createElement('meta');
    tag.setAttribute(attr, property);
    document.head.appendChild(tag);
  }
  tag.content = content;
}

onUnmounted(() => {
  seoScriptEl.value?.remove();
  breadcrumbScriptEl.value?.remove();
});

// ── Visible Breadcrumbs ──
const breadcrumbs = computed(() => {
  const segments = route.path.split('/').filter(Boolean);
  let accumulated = '';
  return segments.map(seg => {
    accumulated += `/${seg}`;
    return {
      path: accumulated,
      label: pageNameMap[accumulated] || seg.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()),
    };
  });
});

const navLinks = [
  { to: '/', label: 'Home' },
  { to: '/about', label: 'About' },
  { to: '/services', label: 'Services' },
  { to: '/products', label: 'Products' },
  { to: '/bundles', label: 'Bundles' },
  { to: '/industries', label: 'Industries' },
  { to: '/case-studies', label: 'Case Studies' },
  { to: '/blog', label: 'Blog' },
  { to: '/contact', label: 'Contact' },
];

const footerServicesLinks = [
  { to: '/services', label: 'All Services' },
  { to: '/products', label: 'Products' },
  { to: '/bundles', label: 'Solution Bundles' },
  { to: '/industries', label: 'Industries' },
  { to: '/case-studies', label: 'Case Studies' },
];

const footerQuickLinks = [
  { to: '/about', label: 'About Us' },
  { to: '/blog', label: 'Blog & Insights' },
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
