<template>
  <PublicLayout>
    <!-- ═══════════════ HERO + COUNTER WRAPPER ═══════════════ -->
    <div class="relative overflow-hidden min-h-[64vh] md:min-h-[78vh]">
      <!-- Shared background layer — stretches behind both hero AND counter -->
      <div class="absolute inset-0 z-0 w-full h-full">
        <!-- All slide backgrounds are rendered up front (stacked) so they download immediately
             and switching slides is just an opacity change — no network wait on each slide. -->
        <img
          v-for="(slide, i) in heroSlides"
          :key="slide.id"
          :src="slide.bg_image"
          :alt="i === currentHeroSlide ? slide.title : ''"
          :aria-hidden="i !== currentHeroSlide"
          :fetchpriority="i === 0 ? 'high' : 'low'"
          :decoding="i === 0 ? 'sync' : 'async'"
          loading="eager"
          class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700"
          :class="i === currentHeroSlide ? 'opacity-100' : 'opacity-0'"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/55 to-black/40"></div>
      </div>

      <!-- ═══════════════ HERO SECTION ═══════════════ -->
      <section class="relative min-h-[64vh] md:min-h-[78vh] flex items-center z-10">
        <Swiper
          :modules="[Autoplay, Pagination]"
          :slides-per-view="1"
          :autoplay="heroAutoplay"
          :pagination="heroPagination"
          :loop="true"
          class="hero-swiper w-full h-full"
          @slide-change="(swiper: any) => currentHeroSlide = swiper.realIndex"
        >
          <SwiperSlide v-for="slide in heroSlides" :key="slide.id">
            <div class="relative w-full min-h-[64vh] md:min-h-[78vh] flex items-center">
              <div class="relative z-10 w-full">
                <div class="container mx-auto px-6 py-16 md:py-20">
                  <div class="max-w-3xl">
                    <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs font-semibold tracking-widest uppercase text-primary mb-6">
                      {{ slide.subtitle }}
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-[1.05] tracking-tight text-white mb-6">{{ slide.title }}</h1>
                    <p class="text-white/80 text-base md:text-lg leading-relaxed mb-10 max-w-xl">{{ slide.description }}</p>
                    <div class="flex flex-wrap items-center gap-4">
                      <router-link :to="slide.cta_link" class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
                        {{ slide.cta_text }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                      </router-link>
                      <router-link v-if="slide.cta_text_2" :to="slide.cta_link_2" class="inline-flex items-center px-8 py-3.5 border border-white/30 text-white text-sm font-semibold rounded-full hover:bg-white/10 hover:border-white/50 transition-all">
                        {{ slide.cta_text_2 }}
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </section>

      <!-- ═══════════════ COUNTER BAR ═══════════════ -->
      <section class="relative z-10 py-8 md:py-10 border-t border-white/10 bg-black/20 backdrop-blur-sm">
        <div class="container mx-auto px-6 max-w-5xl">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div v-for="counter in countersFinal" :key="counter.id" class="text-center">
              <div class="text-3xl md:text-4xl font-bold text-white mb-1.5 tabular-nums">
                <span ref="counterRefs" :data-target="counter.number || counter.value" :data-suffix="counter.suffix || '+'">0</span>
              </div>
              <div class="text-white/60 text-xs font-semibold tracking-wide uppercase">{{ counter.label || counter.title }}</div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- ═══════════════ TRUSTED BY ═══════════════ -->
    <section v-if="clients.length" class="py-10 border-y border-border bg-muted/30">
      <div class="container mx-auto px-4">
        <p class="text-center text-xs text-muted-foreground font-semibold uppercase tracking-widest mb-8">Trusted by innovative companies</p>
        <div class="flex flex-wrap items-center justify-center gap-12 md:gap-16">
          <a
            v-for="client in clients.filter((c) => c.logo_url)"
            :key="client.id"
            :href="client.website_url || undefined"
            target="_blank"
            rel="noopener"
            class="opacity-50 hover:opacity-100 transition-opacity duration-300"
          >
            <img :src="client.logo_url" :alt="client.name" class="max-h-10 grayscale hover:grayscale-0 transition" decoding="async" />
          </a>
        </div>
      </div>
    </section>

    <!-- ═══════════════ ABOUT US ═══════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
          <div class="relative">
            <div class="rounded-2xl overflow-hidden shadow-lg">
              <img :src="settings.about_section_image || 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop&q=80'" alt="Our Team" decoding="async" class="w-full aspect-[4/3] object-cover" />
            </div>
            <div class="absolute -bottom-6 -right-6 md:bottom-6 md:right-6 bg-primary text-white rounded-2xl p-5 shadow-xl">
              <div class="text-3xl font-bold">10+</div>
              <div class="text-xs font-medium text-white">Years of<br/>Excellence</div>
            </div>
          </div>

          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About Us</p>
            <h2 class="text-3xl md:text-4xl font-bold text-foreground leading-tight tracking-tight mb-5">Your trusted technology partner</h2>
            <p class="text-muted-foreground text-base leading-relaxed mb-4">{{ settings.site_name || 'OmniviaTech' }} is a technology company dedicated to empowering businesses with innovative digital solutions. We combine deep technical expertise with a passion for solving real-world challenges.</p>
            <p class="text-muted-foreground text-base leading-relaxed mb-8">From startups to enterprises, we help organizations harness the power of technology to improve efficiency, scale operations, and drive growth.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-9">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-foreground text-sm font-medium">Proven track record</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <span class="text-foreground text-sm font-medium">Fast delivery</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <span class="text-foreground text-sm font-medium">Expert team</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-500/10 rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-foreground text-sm font-medium">24/7 support</span>
              </div>
            </div>

            <router-link to="/about" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-sm">
              Discover our story
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ WHAT WE DO (SERVICES) ═══════════════ -->
    <section class="py-16 md:py-24 bg-gray-900">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">What We Do</p>
          <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight tracking-tight">Services built to move your business forward</h2>
        </div>

        <!-- Niche / capability chips -->
        <div class="flex flex-wrap justify-center gap-2.5 mb-12">
          <span
            v-for="spec in specializations"
            :key="spec.title"
            class="inline-flex items-center gap-1.5 bg-white/5 border border-white/10 rounded-full px-3.5 py-1.5 text-xs font-medium text-white/80"
          >
            <span>{{ spec.icon }}</span>{{ spec.title }}
          </span>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <div v-for="i in 8" :key="i" class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden animate-pulse">
            <div class="aspect-[4/3] bg-white/5"></div>
            <div class="p-5 space-y-2">
              <div class="h-3 bg-white/10 rounded w-3/4"></div>
              <div class="h-2 bg-white/10 rounded w-full"></div>
            </div>
          </div>
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <router-link
            v-for="service in (allServices.length ? allServices.slice(0, 8) : featuredServices)"
            :key="service.id"
            :to="`/services/${service.slug}`"
            class="group block bg-white/5 border border-white/10 rounded-2xl overflow-hidden hover:border-primary/40 hover:bg-white/[0.07] transition-all duration-300"
          >
            <div class="aspect-[4/3] bg-white/5 overflow-hidden relative">
              <img
                v-if="getServiceImage(service) || service.image_url || service.image"
                :src="getServiceImage(service) || service.image_url || service.image"
                :alt="service.title"
               
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-white/10 to-white/5">
                <span class="text-3xl">{{ service.icon || '💡' }}</span>
              </div>
              <div class="absolute top-3 right-3 z-10">
                <WishlistButton type="App\\Models\\Service" :item-id="service.id" />
              </div>
            </div>
            <div class="p-5">
              <h3 class="text-sm font-semibold text-white mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ service.title }}</h3>
              <p class="text-white/60 text-xs leading-relaxed line-clamp-2 mb-3">{{ service.excerpt || service.short_description }}</p>
              <span class="text-white/80 font-medium text-xs flex items-center gap-1 group-hover:gap-2 group-hover:text-primary transition-all">
                Learn more <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
              </span>
            </div>
          </router-link>
        </div>

        <div class="text-center mt-12">
          <router-link to="/services" class="inline-flex items-center gap-2 px-7 py-3 border border-white/20 text-white text-sm font-semibold rounded-full hover:bg-white hover:text-gray-900 hover:border-white transition-all">
            View all services
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ PRODUCTS ═══════════════ -->
    <section v-if="products.length" class="py-16 md:py-24">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex flex-wrap items-end justify-between gap-6 mb-10">
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Marketplace</p>
            <h2 class="text-3xl md:text-4xl font-bold text-foreground leading-tight tracking-tight">Ready-made products</h2>
          </div>
          <router-link to="/products" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline underline-offset-4 shrink-0">
            View all products
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </router-link>
        </div>

        <Swiper
          :modules="[Autoplay, Navigation]"
          :slides-per-view="1"
          :space-between="20"
          :navigation="servicesNavigation"
          :autoplay="productsAutoplay"
          :breakpoints="productsBreakpoints"
          class="cards-swiper"
        >
          <SwiperSlide v-for="product in products" :key="product.id">
            <router-link :to="`/products/${product.slug}`" class="group block bg-card rounded-2xl overflow-hidden border border-border hover:border-primary/30 hover:shadow-lg transition-all duration-300 h-full flex flex-col">
              <div class="aspect-[4/3] bg-muted overflow-hidden relative shrink-0">
                <img v-if="getProductImage(product) || product.image_url" :src="getProductImage(product) || product.image_url" :alt="product.name" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-accent/5 to-primary/5">
                  <svg class="w-10 h-10 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <div class="absolute top-3 right-3 z-10">
                  <WishlistButton type="App\\Models\\Product" :item-id="product.id" />
                </div>
              </div>
              <div class="p-5 flex flex-col flex-grow">
                <h3 class="text-sm font-semibold text-foreground mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ product.name }}</h3>
                <p class="text-muted-foreground text-xs leading-relaxed line-clamp-2 mb-3 flex-grow">{{ product.excerpt || product.short_description }}</p>
                <span class="text-primary font-medium text-xs flex items-center gap-1 group-hover:gap-2 transition-all">View <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg></span>
              </div>
            </router-link>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

    <!-- ═══════════════ INDUSTRIES WE SERVE ═══════════════ -->
    <section class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Industries</p>
          <h2 class="text-3xl md:text-4xl font-bold text-foreground leading-tight tracking-tight">Industries we serve</h2>
        </div>

        <Swiper
          :modules="[Autoplay]"
          :slides-per-view="1"
          :space-between="16"
          :autoplay="industriesAutoplay"
          :loop="true"
          :breakpoints="industriesBreakpoints"
          @mouseenter="($refs.industriesSwiper as any)?.$el.__swiper.autoplay.stop()"
          @mouseleave="($refs.industriesSwiper as any)?.$el.__swiper.autoplay.start()"
          ref="industriesSwiper"
          class="industries-carousel"
        >
          <SwiperSlide v-for="(industry, i) in industries" :key="i">
            <router-link :to="`/industries#${industry.title.toLowerCase()}`" class="group block bg-card border border-border rounded-2xl overflow-hidden hover:border-accent/40 hover:shadow-md transition-all duration-300 h-full">
              <div class="aspect-video bg-muted overflow-hidden">
                <img :src="industry.image" :alt="industry.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
              </div>
              <div class="p-4 text-center">
                <div class="w-9 h-9 mx-auto bg-accent/15 rounded-lg flex items-center justify-center mb-2 group-hover:bg-accent/25 transition-colors">
                  <span class="text-base">{{ industry.icon }}</span>
                </div>
                <h3 class="text-xs font-bold text-foreground mb-1 group-hover:text-accent transition-colors line-clamp-2">{{ industry.title }}</h3>
                <p class="text-muted-foreground text-xs leading-snug line-clamp-2">{{ industry.desc }}</p>
              </div>
            </router-link>
          </SwiperSlide>
        </Swiper>

        <div class="text-center mt-10 sm:hidden">
          <router-link to="/industries" class="inline-flex items-center gap-2 px-7 py-3 border border-accent text-accent text-sm font-semibold rounded-full hover:bg-accent hover:text-white transition-all">
            View all industries
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ WHY CHOOSE US ═══════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Us</p>
          <h2 class="text-3xl md:text-4xl font-bold text-foreground leading-tight tracking-tight">Why {{ settings.site_name || 'OmniviaTech' }}?</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div
            v-for="(reason, i) in whyUsReasons"
            :key="i"
            class="relative rounded-2xl p-7 bg-gray-900 border border-white/10 hover:border-primary/40 hover:-translate-y-1 transition-all duration-300 shadow-sm hover:shadow-xl"
          >
            <div class="w-12 h-12 bg-primary/15 rounded-xl flex items-center justify-center mb-5">
              <span class="text-2xl">{{ reason.icon }}</span>
            </div>
            <h3 class="text-base font-bold text-white mb-2.5">{{ reason.title }}</h3>
            <p class="text-white/60 text-sm leading-relaxed">{{ reason.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ PROCESS ═══════════════ -->
    <section class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-2xl mx-auto mb-14">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Process</p>
          <h2 class="text-3xl md:text-4xl font-bold text-foreground leading-tight tracking-tight">How we bring your ideas to life</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="(step, idx) in processSteps" :key="idx" class="relative">
            <div class="rounded-2xl p-7 bg-card border border-border h-full shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
              <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-5">
                <span class="text-lg font-bold text-primary">{{ Number(idx) + 1 }}</span>
              </div>
              <h3 class="text-base font-bold text-foreground mb-2">{{ step.title }}</h3>
              <p class="text-muted-foreground text-sm leading-relaxed">{{ step.description }}</p>
            </div>
            <div v-if="Number(idx) < processSteps.length - 1" class="hidden lg:block absolute top-1/2 -right-3 w-6 h-px bg-border -translate-y-1/2"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ EXPLORE WHAT WE OFFER ═══════════════ -->
    <section class="bg-gray-50 dark:bg-gray-900/40 py-16 md:py-20 w-full">
      <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-8">
          <p class="text-xs font-semibold tracking-widest uppercase text-muted-foreground mb-2">Quick Links</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground tracking-tight mb-2">Everything we offer</h2>
          <p class="text-sm text-muted-foreground leading-relaxed">Jump straight to what you're looking for.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <router-link to="/services" class="rounded-2xl overflow-hidden h-36 flex flex-col justify-between p-4 transition-transform duration-200 hover:-translate-y-1 bg-blue-700">
            <div class="w-9 h-9 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
              <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
              <p class="text-sm font-medium text-white mb-0.5">Services</p>
              <p class="text-xs text-white/70 leading-snug">Web, mobile &amp; cloud solutions</p>
            </div>
          </router-link>

          <router-link to="/industries" class="rounded-2xl overflow-hidden h-36 flex flex-col justify-between p-4 transition-transform duration-200 hover:-translate-y-1 bg-emerald-600">
            <div class="w-9 h-9 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
              <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
              <p class="text-sm font-medium text-white mb-0.5">Industries</p>
              <p class="text-xs text-white/70 leading-snug">Sector-specific expertise</p>
            </div>
          </router-link>

          <router-link to="/products" class="rounded-2xl overflow-hidden h-36 flex flex-col justify-between p-4 transition-transform duration-200 hover:-translate-y-1 bg-amber-600">
            <div class="w-9 h-9 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
              <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div>
              <p class="text-sm font-medium text-white mb-0.5">Marketplace</p>
              <p class="text-xs text-white/70 leading-snug">Ready-made digital products</p>
            </div>
          </router-link>

          <router-link to="/case-studies" class="rounded-2xl overflow-hidden h-36 flex flex-col justify-between p-4 transition-transform duration-200 hover:-translate-y-1 bg-rose-600">
            <div class="w-9 h-9 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
              <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0012 18.469a3.374 3.374 0 00-2.495-1.022l-.548-.547z"/></svg>
            </div>
            <div>
              <p class="text-sm font-medium text-white mb-0.5">Case Studies</p>
              <p class="text-xs text-white/70 leading-snug">See our work in action</p>
            </div>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ PACKAGES ═══════════════ -->
    <section class="bg-slate-100 dark:bg-gray-900/40 py-16 md:py-24">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Offerings</p>
          <h2 class="text-3xl md:text-4xl font-bold text-foreground leading-tight tracking-tight mb-3">Scalable packages for growth</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">From startups to enterprises — every package is built for maximum value, with professional support included.</p>
        </div>

        <div
          class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-stretch mx-auto"
          :class="displayPackages.length > 3 ? 'lg:grid-cols-4' : 'lg:grid-cols-3 max-w-5xl'"
        >
          <PackageCard v-for="(pkg, i) in displayPackages" :key="pkg.id" :pkg="pkg" :index="i" />
        </div>

        <div class="text-center mt-12">
          <router-link to="/packages" class="inline-flex items-center gap-2 px-7 py-3 border border-primary text-primary text-sm font-semibold rounded-full hover:bg-primary hover:text-white transition-all">
            Compare all packages
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ TESTIMONIALS CAROUSEL ═══════════════ -->
    <section v-if="topReviews.length" class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Testimonials</p>
          <h2 class="text-3xl md:text-4xl font-bold text-foreground leading-tight tracking-tight">What our clients say</h2>
        </div>

        <Swiper
          :modules="[Autoplay, Pagination]"
          :slides-per-view="1"
          :space-between="16"
          :pagination="testimonialsPagination"
          :autoplay="testimonialsAutoplay"
          :breakpoints="{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }"
          class="testimonials-swiper pb-16"
        >
          <SwiperSlide v-for="review in topReviews" :key="review.id">
            <div class="rounded-2xl p-6 h-full flex flex-col bg-gray-900 border border-white/10 shadow-sm hover:shadow-lg transition-all">
              <div class="flex gap-0.5 mb-4">
                <svg v-for="s in review.rating" :key="s" class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
              <p class="text-white/80 text-sm leading-relaxed mb-5 flex-1 line-clamp-4">&ldquo;{{ review.comment }}&rdquo;</p>
              <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                <div class="w-9 h-9 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                  {{ review.user_name?.charAt(0).toUpperCase() }}
                </div>
                <div class="min-w-0">
                  <div class="font-semibold text-white text-sm truncate">{{ review.user_name }}</div>
                  <div class="text-white/50 text-xs truncate">{{ review.company || 'Verified Client' }}</div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

    <!-- ═══════════════ CTA — VIDEO + COPY ═══════════════ -->
    <section class="py-16 md:py-24 bg-background">
      <div class="container mx-auto px-6 max-w-6xl">
        <h2 class="sr-only">Call to action section with auto-playing video on the left and a description on the right</h2>
        <div class="cta-wrap">
          <div class="video-side">
            <video autoplay muted loop playsinline>
              <source :src="videoCTA" type="video/mp4" />
              <track kind="captions" src="/captions/cta-video.vtt" srclang="en" label="English" />
              Your browser does not support the video tag.
            </video>
            <div class="video-overlay"></div>
          </div>

          <div class="copy-side">
            <p class="eyebrow">What we offer</p>
            <h2 class="headline">Built to power<br/>your <span>next big</span><br/>idea</h2>
            <div class="divider"></div>
            <p class="body-text">From custom software to end-to-end digital transformation — our solutions are engineered to scale with your ambitions and deliver measurable results from day one.</p>

            <div class="cta-row">
              <router-link to="/services" class="btn-primary">
                Explore services
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
              <router-link to="/about" class="btn-ghost">Watch our story</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ BLOG ═══════════════ -->
    <section v-if="recentBlogs.length" class="py-16 md:py-24 bg-muted/30">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Latest Insights</p>
          <h2 class="text-3xl md:text-4xl font-bold text-foreground leading-tight tracking-tight">From our blog</h2>
        </div>

        <Swiper
          :modules="[Autoplay, Navigation]"
          :slides-per-view="1"
          :space-between="20"
          :navigation="blogNavigation"
          :autoplay="blogAutoplay"
          :breakpoints="blogBreakpoints"
          class="cards-swiper"
        >
          <SwiperSlide v-for="post in recentBlogs" :key="post.id">
            <router-link :to="`/blog/${post.slug}`" class="group block bg-card border border-border rounded-2xl overflow-hidden hover:border-primary/30 hover:shadow-lg transition-all duration-300">
              <div class="aspect-[4/3] bg-muted overflow-hidden">
                <img v-if="getBlogImage(post)" :src="getBlogImage(post)" :alt="post.title" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
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
          </SwiperSlide>
        </Swiper>

        <div class="text-center mt-12">
          <router-link to="/blog" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline underline-offset-4">
            View all articles
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ FAQ ═══════════════ -->
    <section v-if="faqs.length" class="py-16 md:py-24">
      <div class="container mx-auto px-6 max-w-3xl">
        <div class="text-center mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
          <h2 class="text-3xl md:text-4xl font-bold text-foreground leading-tight tracking-tight">Frequently asked questions</h2>
        </div>

        <div class="space-y-3">
          <div v-for="(faq, idx) in faqs" :key="faq.id" class="bg-card border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
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

    <!-- ═══════════════ FINAL CTA ═══════════════ -->
    <section class="w-full relative overflow-hidden">
      <div class="relative min-h-[420px] bg-gray-950 flex items-center">
        <div class="absolute inset-0 opacity-25 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-black/70"></div>

        <div class="relative z-10 w-full text-center px-6 py-20">
          <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight tracking-tight mb-4 max-w-2xl mx-auto">
            Let's build something great together
          </h2>
          <p class="text-white/70 text-base leading-relaxed mb-10 max-w-xl mx-auto">
            Tell us about your project and our team will get back to you within 24 hours.
          </p>
          <div class="flex flex-wrap items-center justify-center gap-4">
            <router-link to="/contact" class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
              Start a project
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
            <router-link to="/case-studies" class="inline-flex items-center px-8 py-3.5 border border-white/30 text-white text-sm font-semibold rounded-full hover:bg-white/10 hover:border-white/50 transition-all">
              View our work
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ COOKIE CONSENT BANNER ═══════════════ -->
    <div v-if="showCookieConsent" class="fixed bottom-0 left-0 right-0 z-50 p-4 sm:p-6">
      <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-2xl">
        <div class="p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
          <!-- Message -->
          <p class="text-gray-800 text-sm leading-relaxed flex-1">
            We use cookies to enhance your browsing experience, analyze site traffic, and personalize content. You can manage your preferences or decline non-essential cookies.
          </p>

          <!-- Action Buttons -->
          <div class="flex flex-wrap gap-2 sm:gap-3 justify-end w-full sm:w-auto">
            <!-- Preferences Button (Gray) -->
            <button
              @click="showPreferencesModal = true"
              class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white text-sm font-semibold rounded-lg transition-colors duration-200 whitespace-nowrap"
            >
              Preferences
            </button>

            <!-- Decline Button (Red) -->
            <button
              @click="declineCookies()"
              class="px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors duration-200 whitespace-nowrap"
            >
              Decline
            </button>

            <!-- Accept Button (Green) -->
            <button
              @click="acceptAllCookies()"
              class="px-5 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg transition-colors duration-200 whitespace-nowrap"
            >
              Accept
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ═══════════════ COOKIE SUCCESS CARD ═══════════════ -->
    <div v-if="showCookieSuccessCard" class="fixed top-6 right-6 z-50 max-w-sm">
      <div class="bg-green-700 text-white rounded-lg shadow-lg p-4 sm:p-5 flex items-start gap-3 animate-in fade-in slide-in-from-top-2 duration-300">
        <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="flex-1 min-w-0">
          <p class="text-sm sm:text-base font-semibold">Cookie preferences saved</p>
          <p class="text-xs sm:text-sm text-green-100 mt-1">Your settings have been applied successfully.</p>
        </div>
        <button @click="showCookieSuccessCard = false" class="flex-shrink-0 text-green-100 hover:text-white transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- ═══════════════ COOKIE PREFERENCES MODAL ═══════════════ -->
    <div v-if="showPreferencesModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
      <div class="bg-white rounded-lg shadow-2xl max-w-md w-full">
        <!-- Modal Header -->
        <div class="border-b border-gray-200 p-5">
          <h3 class="text-lg font-bold text-gray-900">Cookie Preferences</h3>
        </div>

        <!-- Modal Content -->
        <div class="p-5 space-y-4">
          <!-- Necessary (Always Enabled) -->
          <div class="flex items-start gap-3">
            <input
              type="checkbox"
              id="modal-necessary"
              v-model="cookiePreferences.necessary"
              disabled
              checked
              class="w-4 h-4 mt-1 rounded cursor-not-allowed opacity-60"
            />
            <div class="flex-1">
              <label for="modal-necessary" class="block font-semibold text-gray-900 text-sm cursor-not-allowed">
                Necessary Cookies
              </label>
              <p class="text-xs text-gray-600 mt-1">
                Essential for site functionality (always enabled)
              </p>
            </div>
          </div>

          <!-- Analytics -->
          <div class="flex items-start gap-3">
            <input
              type="checkbox"
              id="modal-analytics"
              v-model="cookiePreferences.analytics"
              class="w-4 h-4 mt-1 rounded cursor-pointer"
            />
            <div class="flex-1">
              <label for="modal-analytics" class="block font-semibold text-gray-900 text-sm cursor-pointer">
                Analytics Cookies
              </label>
              <p class="text-xs text-gray-600 mt-1">
                Help us understand how you use our site to improve your experience
              </p>
            </div>
          </div>

          <!-- Marketing -->
          <div class="flex items-start gap-3">
            <input
              type="checkbox"
              id="modal-marketing"
              v-model="cookiePreferences.marketing"
              class="w-4 h-4 mt-1 rounded cursor-pointer"
            />
            <div class="flex-1">
              <label for="modal-marketing" class="block font-semibold text-gray-900 text-sm cursor-pointer">
                Marketing Cookies
              </label>
              <p class="text-xs text-gray-600 mt-1">
                Personalized ads and content recommendations based on your interests
              </p>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 p-5 flex gap-3">
          <button
            @click="showPreferencesModal = false"
            class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 text-sm font-semibold rounded-lg transition-colors duration-200"
          >
            Cancel
          </button>
          <button
            @click="saveAndClosePreferences()"
            class="flex-1 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg transition-colors duration-200"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import axios from 'axios';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref, computed, onMounted } from 'vue';
import { useCmsStore } from '@/stores/cms';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import heroTech3 from '../../img/Laptop.webp';
import apiDevelopmentImage from '../../img/services/API Development.webp';
import crmErpDevelopmentImage from '../../img/services/CRM & ERP Development.webp';
import customWebDevelopmentImage from '../../img/services/Custom Web Development.webp';
import eCommerceDevelopmentImage from '../../img/services/E-commerece Development.webp';
import mobileAppDevelopmentImage from '../../img/services/Mobile App Development.webp';
import mobileAppImage from '../../img/services/Mobile App.webp';
import paidAdsImage from '../../img/services/Paid Ads.webp';
import seoOptimizationImage from '../../img/services/SEO Optimization.webp';
import heroTechBg from '../../img/tech-background.webp';
import heroTech2 from '../../img/tech-closeup.webp';
import heroTechGlow from '../../img/tech-glow.webp';
import heroTech1 from '../../img/tech2.webp';
import heroTech5 from '../../img/tech3.webp';
import heroCTAbg from '../../img/tech4.webp';
import heroTech6 from '../../img/tech7.webp';
import techImg1 from '../../img/tech1.webp';
import techImg2 from '../../img/tech2.webp';
import techImg3 from '../../img/tech3.webp';
import techImg4 from '../../img/tech4.webp';
import techImg5 from '../../img/tech5.webp';
import techImg6 from '../../img/tech6.webp';
import videoCTA from '../../videos/omniviatech.mp4';
import WishlistButton from '../components/WishlistButton.vue';
import PackageCard from '../components/PackageCard.vue';
import PublicLayout from '../layouts/PublicLayout.vue';

// Data
const loading = ref(true);
const sliders = ref<any[]>([]);
const counters = ref<any[]>([]);
const allServices = ref<any[]>([]);
const products = ref<any[]>([]);
const clients = ref<any[]>([]);
const topReviews = ref<any[]>([]);
const faqs = ref<any[]>([]);
const recentBlogs = ref<any[]>([]);
const settings = ref<any>({});
const packages = ref<any[]>([]);

// Shown until real packages exist in the CMS, so the section is never empty
const fallbackPackages = [
  {
    id: 'starter', slug: '', name: 'Starter', price: 15000, price_label: 'Month', is_featured: false,
    short_description: 'Everything a new business needs to launch a fast, professional online presence.',
    includes: ['5 Page responsive website', '1 Year free domain & hosting', '5 Professional email accounts', 'Basic on-page SEO setup', '24/7 Email support'],
  },
  {
    id: 'business', slug: '', name: 'Business', price: 35000, price_label: 'Month', is_featured: true,
    short_description: 'For growing teams that need more pages, integrations and marketing tools.',
    includes: ['15 Page custom website', '10GB SSD hosting & SSL', '20 Professional email accounts', 'Advanced SEO & Google Analytics', '24/7 Priority support'],
  },
  {
    id: 'premium', slug: '', name: 'Premium', price: 75000, price_label: 'Month', is_featured: false,
    short_description: 'A complete digital platform with e-commerce, automation and dedicated support.',
    includes: ['Unlimited pages & e-commerce store', '50GB SSD cloud hosting', 'Unlimited email accounts', 'CRM & payment integrations', '24/7 Dedicated account manager'],
  },
];

const displayPackages = computed<any[]>(() => (packages.value.length ? packages.value : fallbackPackages));


// Static Data — niches shown as quick-scan chips in the Services section
const specializations = [
  { icon: '💻', title: 'Software Development' },
  { icon: '🤖', title: 'AI & Automation' },
  { icon: '☁️', title: 'Cloud Solutions' },
  { icon: '🔒', title: 'Cybersecurity' },
  { icon: '📱', title: 'Mobile Apps' },
  { icon: '📊', title: 'Data Analytics' },
  { icon: '🎯', title: 'Digital Marketing' },
  { icon: '🛠️', title: 'IT Consulting' },
];

const featuredServices = [
  // ════════════════════════════════════════════
  // 🔹 DEVELOPMENT SOLUTIONS
  // ════════════════════════════════════════════
  {
    id: 1,
    name: 'Custom Web Development',
    title: 'Custom Web Development',
    slug: 'custom-web-development',
    excerpt: 'Stunning, high-performance websites and web applications built with Laravel, Vue.js, React, and Next.js — tailored to your brand and business goals.',
    image: customWebDevelopmentImage,
    icon: 'code',
  },
  {
    id: 2,
    name: 'Mobile App Development',
    title: 'Mobile App Development',
    slug: 'mobile-app-development',
    excerpt: 'Native and cross-platform mobile apps for iOS and Android that users love — built with React Native, Flutter, and native Swift/Kotlin.',
    image: mobileAppDevelopmentImage,
    icon: 'smartphone',
  },
  {
    id: 3,
    name: 'E-Commerce Development',
    title: 'E-Commerce Development',
    slug: 'e-commerce-development',
    excerpt: 'Custom online stores, marketplace platforms, and payment integrations that drive revenue 24/7 with local and international payment gateways.',
    image: eCommerceDevelopmentImage,
    icon: 'shopping-cart',
  },
  {
    id: 4,
    name: 'API Development & Integration',
    title: 'API Development & Integration',
    slug: 'api-development-integration',
    excerpt: 'RESTful and GraphQL API development, third-party integrations, and headless architecture for seamless data flow between systems.',
    image: apiDevelopmentImage,
    icon: 'plug',
  },
  {
    id: 5,
    name: 'CRM & ERP System Development',
    title: 'CRM & ERP System Development',
    slug: 'crm-erp-development',
    excerpt: 'Custom CRM and ERP systems that streamline your operations, automate workflows, and provide 360-degree visibility into your business.',
    image: crmErpDevelopmentImage,
    icon: 'building',
  },

  // ════════════════════════════════════════════
  // 🔹 GROWTH & MARKETING SOLUTIONS
  // ════════════════════════════════════════════
  {
    id: 6,
    name: 'SEO Optimization & Google Analytics',
    title: 'SEO Optimization & Google Analytics',
    slug: 'seo-optimization-analytics',
    excerpt: 'Data-driven SEO strategies that boost organic traffic, improve search rankings, and integrate with Google Analytics for measurable results.',
    image: seoOptimizationImage,
    icon: 'search',
  },
  {
    id: 7,
    name: 'Paid Ads Management',
    title: 'Paid Ads Management',
    slug: 'paid-ads-management',
    excerpt: 'Strategic paid advertising across Facebook, Google, and LinkedIn — maximizing ROI with data-driven targeting and creative optimization.',
    image: paidAdsImage,
    icon: 'megaphone',
  },
  {
    id: 8,
    name: 'Conversion Rate Optimization',
    title: 'Conversion Rate Optimization',
    slug: 'conversion-rate-optimization',
    excerpt: 'Turn more visitors into customers with data-driven CRO — A/B testing, UX analysis, funnel optimization, and behavioural analytics.',
    image: customWebDevelopmentImage,
    icon: 'trending-up',
  },
];

const serviceImagePaths: Record<string, string> = {
  'api development': apiDevelopmentImage,
  'api development & integration': apiDevelopmentImage,
  'api developer': apiDevelopmentImage,
  'api design': apiDevelopmentImage,
  'crm & erp development': crmErpDevelopmentImage,
  'crm & erp system development': crmErpDevelopmentImage,
  'crm erp development': crmErpDevelopmentImage,
  'custom web development': customWebDevelopmentImage,
  'custom website development': customWebDevelopmentImage,
  'website development': customWebDevelopmentImage,
  'web development': customWebDevelopmentImage,
  'e-commerece development': eCommerceDevelopmentImage,
  'e-commerce development': eCommerceDevelopmentImage,
  'ecommerce development': eCommerceDevelopmentImage,
  'mobile app development': mobileAppDevelopmentImage,
  'mobile application development': mobileAppDevelopmentImage,
  'mobile app': mobileAppImage,
  'paid ads': paidAdsImage,
  'paid ads management': paidAdsImage,
  'seo optimization': seoOptimizationImage,
  'seo optimization & google analytics': seoOptimizationImage,
  'search engine optimization': seoOptimizationImage,
  'conversion rate optimization': customWebDevelopmentImage,
  'social media marketing strategy': customWebDevelopmentImage,
  'social media marketing': customWebDevelopmentImage,
  'business intelligence & analytics': customWebDevelopmentImage,
  'business intelligence': customWebDevelopmentImage,
  'automation & testing': customWebDevelopmentImage,
  'audit trail development': customWebDevelopmentImage,
  'ui/ux design & prototyping': customWebDevelopmentImage,
  'ui/ux design': customWebDevelopmentImage,
  'ux design': customWebDevelopmentImage,
  'cloud deployment & devops': customWebDevelopmentImage,
  'cloud deployment': customWebDevelopmentImage,
  'devops': customWebDevelopmentImage,
  'performance optimization': customWebDevelopmentImage,
  'website maintenance & support': customWebDevelopmentImage,
  'website maintenance': customWebDevelopmentImage,
  'cybersecurity & data protection': customWebDevelopmentImage,
  'cybersecurity': customWebDevelopmentImage,
  'data protection': customWebDevelopmentImage,
};

const productImageMap: Record<string, string> = {
  'smartcms-pro': customWebDevelopmentImage,
  'smartshop-platform': eCommerceDevelopmentImage,
  'smartanalytics-dashboard': seoOptimizationImage,
  'smartchat-ai': apiDevelopmentImage,
  'smartsecure-firewall': crmErpDevelopmentImage,
  'smartbackup-cloud': mobileAppDevelopmentImage,
};

function getProductImage(product: any) {
  const slug = (product.slug || '').toString().trim().toLowerCase();
  if (productImageMap[slug]) return productImageMap[slug];
  return '';
}

const blogImageMap: Record<string, string> = {
  '10 ways ai is transforming south african businesses in 2025': techImg1,
  'why every business needs a cybersecurity strategy in 2025': techImg2,
  'the complete guide to choosing the right tech stack for your startup': techImg3,
  'how cloud migration can cut your it costs by 40%': techImg4,
  'building a world-class e-commerce experience in south africa': techImg5,
  'popia compliance checklist: what your business must do in 2025': techImg6,
};

function getBlogImage(blog: any) {
  // First, use featured_image from API if available
  if (blog.featured_image) {
    return blog.featured_image.startsWith('http')
      ? blog.featured_image
      : `/storage/${blog.featured_image}`;
  }

  // Fallback to title-based mapping for demo content
  const title = (blog.title || '').toString().trim().toLowerCase();
  if (blogImageMap[title]) return blogImageMap[title];

  // Final fallback: return empty string (will show placeholder in template)
  return '';
}

function getServiceImage(service: any) {
  const key = (service.title || service.name || service.slug || '').toString().trim().toLowerCase();
  if (!key) {
    return '';
  }

  if (serviceImagePaths[key]) {
    return serviceImagePaths[key];
  }

  // Fallback matching for various service types
  if (key.includes('custom website') || key.includes('custom web') || key.includes('website development') || key.includes('web development')) {
    return customWebDevelopmentImage;
  }

  if (key.includes('ecommerce') || key.includes('e-commerce') || key.includes('online store') || key.includes('shop')) {
    return eCommerceDevelopmentImage;
  }

  if (key.includes('api')) {
    return apiDevelopmentImage;
  }

  if (key.includes('crm') || key.includes('erp')) {
    return crmErpDevelopmentImage;
  }

  if (key.includes('seo') || key.includes('optimization') || key.includes('analytics')) {
    return seoOptimizationImage;
  }

  if (key.includes('ads') || key.includes('paid') || key.includes('marketing')) {
    return paidAdsImage;
  }

  if (key.includes('mobile app') || key.includes('mobile application') || key.includes('app development')) {
    return mobileAppDevelopmentImage;
  }

  // Default to a generic image if nothing matches
  return customWebDevelopmentImage;
}

const currentHeroSlide = ref(0);

// Start downloading the first hero image as soon as this module is evaluated,
// before Vue renders the template, so it's ready by the time the <img> mounts.
if (typeof document !== 'undefined' && !document.querySelector(`link[rel="preload"][href="${heroTechBg}"]`)) {
  const link = document.createElement('link');
  link.rel = 'preload';
  link.as = 'image';
  link.href = heroTechBg;
  link.setAttribute('fetchpriority', 'high');
  document.head.appendChild(link);
}

const heroSlides = [
  {
    id: 1,
    subtitle: 'Welcome to OmniviaTech',
    title: 'Innovative Technology Solutions',
    description: 'Empowering businesses with cutting-edge technology and digital transformation services across the globe.',
    cta_text: 'Explore Solutions',
    cta_link: '/services',
    cta_text_2: 'Learn More',
    cta_link_2: '/about',
    bg_image: heroTechBg,
  },
  {
    id: 2,
    subtitle: 'AI & Automation',
    title: 'Transform Your Workflows',
    description: 'Leverage artificial intelligence and automation to streamline your business processes and increase productivity.',
    cta_text: 'Discover AI Solutions',
    cta_link: '/services',
    cta_text_2: 'Get Demo',
    cta_link_2: '/contact',
    bg_image: heroCTAbg,
  },
  {
    id: 3,
    subtitle: 'Cloud Infrastructure',
    title: 'Scale Your Business with Cloud',
    description: 'Enterprise-grade cloud solutions designed for reliability, security, and unlimited scalability.',
    cta_text: 'Cloud Services',
    cta_link: '/services',
    cta_text_2: 'Schedule Call',
    cta_link_2: '/contact',
    bg_image: heroTech1,
  },
  {
    id: 4,
    subtitle: 'Cybersecurity',
    title: 'Protect Your Digital Assets',
    description: 'Comprehensive security solutions to safeguard your business from evolving cyber threats.',
    cta_text: 'Security Solutions',
    cta_link: '/services',
    cta_text_2: 'Assess Risk',
    cta_link_2: '/contact',
    bg_image: heroTech2,
  },
  {
    id: 5,
    subtitle: 'Mobile Development',
    title: 'Build Powerful Mobile Apps',
    description: 'Create engaging iOS and Android applications that delight users and drive business growth.',
    cta_text: 'Mobile Solutions',
    cta_link: '/services',
    cta_text_2: 'See Portfolio',
    cta_link_2: '/case-studies',
    bg_image: heroTech3,
  },
  {
    id: 6,
    subtitle: 'Digital Transformation',
    title: 'Modernize Your Enterprise',
    description: 'End-to-end digital transformation services to help your organization thrive in the modern digital economy.',
    cta_text: 'Start Transformation',
    cta_link: '/services',
    cta_text_2: 'Contact Us',
    cta_link_2: '/contact',
    bg_image: heroTech5,
  },
  {
    id: 7,
    subtitle: 'Innovation & Excellence',
    title: 'Your Technology Partner',
    description: 'From concept to deployment, we deliver world-class technology solutions tailored to your unique business needs.',
    cta_text: 'Start Your Project',
    cta_link: '/contact',
    cta_text_2: 'Our Services',
    cta_link_2: '/services',
    bg_image: heroTech6,
  },
];

const countersFallback = [
  { id: 'f1', number: 500, suffix: '+', label: 'Projects Delivered' },
  { id: 'f2', number: 200, suffix: '+', label: 'Happy Clients' },
  { id: 'f3', number: 50, suffix: '+', label: 'Team Experts' },
  { id: 'f4', number: 15, suffix: '+', label: 'Countries Served' },
];
const countersFinal = computed(() => counters.value.length ? counters.value : countersFallback);

const industries = [
  { icon: '🏥', title: 'Healthcare', desc: 'Digital health solutions', image: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&h=600&fit=crop&q=80' },
  { icon: '🏦', title: 'Finance', desc: 'Fintech & banking systems', image: 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=600&fit=crop&q=80' },
  { icon: '📚', title: 'Education', desc: 'E-learning platforms', image: 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&h=600&fit=crop&q=80' },
  { icon: '🛒', title: 'Retail', desc: 'E-commerce solutions', image: 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?w=800&h=600&fit=crop&q=80' },
  { icon: '🚚', title: 'Logistics', desc: 'Supply chain management', image: 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&h=600&fit=crop&q=80' },
  { icon: '🏭', title: 'Manufacturing', desc: 'Industrial automation', image: 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=800&h=600&fit=crop&q=80' },
  { icon: '🌾', title: 'Agriculture', desc: 'AgriTech solutions', image: 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&h=600&fit=crop&q=80' },
  { icon: '⚡', title: 'Energy', desc: 'Smart energy systems', image: 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800&h=600&fit=crop&q=80' },
];

const processSteps = [
  { title: 'Discovery', description: 'We understand your business goals and requirements' },
  { title: 'Strategy', description: 'We create a detailed plan tailored to your needs' },
  { title: 'Development', description: 'Our team builds your solution with cutting-edge technology' },
  { title: 'Launch', description: 'We deploy and support your solution for success' },
];

const whyUsReasons = [
  { icon: '⚡', title: 'Lightning Fast Delivery', desc: 'We deliver solutions quickly without compromising quality. Your time-to-market matters.' },
  { icon: '🎯', title: 'Results-Driven Approach', desc: 'Every solution is built with measurable outcomes in mind. We focus on ROI, not just features.' },
  { icon: '🤝', title: 'True Partnership', desc: 'We become an extension of your team. Your success is our success.' },
  { icon: '💡', title: 'Innovation First', desc: 'We stay ahead of trends and bring cutting-edge solutions to your business.' },
  { icon: '🔒', title: 'Security & Reliability', desc: 'We follow security best practices and keep your systems monitored and up to date.' },
  { icon: '💰', title: 'Cost-Effective Solutions', desc: 'Maximum value for your investment, with no hidden fees.' },
];

const heroAutoplay = { delay: 6000, disableOnInteraction: false } as any;
const heroPagination = { clickable: true } as any;
const industriesAutoplay = { delay: 3000, disableOnInteraction: false } as any;
const industriesBreakpoints = { 480: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } } as any;
const servicesNavigation = true as any;
const productsAutoplay = { delay: 5000, disableOnInteraction: false } as any;
const productsBreakpoints = industriesBreakpoints;
const blogAutoplay = { delay: 4500, disableOnInteraction: false } as any;
const blogBreakpoints = { 480: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } } as any;
const blogNavigation = true as any;
const testimonialsPagination = { clickable: true } as any;
const testimonialsAutoplay = { delay: 5000, disableOnInteraction: false } as any;

const cmsStore = useCmsStore();

// UI State
const counterRefs = ref<HTMLElement[]>([]);
const openFaqIndex = ref<number | null>(null);

// Fetch Data
async function fetchHomeData() {
  try {
    // Shared, cached request — the layout fetches the same payload
    const data = await cmsStore.fetchHomeData();
    const d = data.data || data;
    sliders.value = d.sliders || [];
    counters.value = d.counters || [];
    allServices.value = d.all_services || d.featured_services || [];
    products.value = d.featured_products || [];
    clients.value = d.clients || [];
    topReviews.value = d.top_reviews || [];
    recentBlogs.value = d.recent_blogs || [];
    settings.value = d.settings || {};
  } catch (error) {
    console.error('Error fetching home data:', error);
  } finally {
    loading.value = false;
  }
}

async function fetchFaqs() {
  try {
    const { data } = await axios.get('/api/v1/home/faqs');
    const cats = data.data?.categories || data.categories || data.data || [];
    const allFaqs: any[] = [];
    (Array.isArray(cats) ? cats : []).forEach((category: any) => {
      if (category.faqs && Array.isArray(category.faqs)) allFaqs.push(...category.faqs);
    });
    faqs.value = allFaqs.slice(0, 8);
  } catch (error) {
    console.error('Error fetching FAQs:', error);
  }
}

async function fetchPackages() {
  try {
    const { data } = await axios.get('/api/v1/packages');
    packages.value = Array.isArray(data) ? data : (data.data || []);
  } catch (error) {
    console.error('Error fetching packages:', error);
  }
}

const showCookieConsent = ref(true);
const showPreferencesModal = ref(false);
const showCookieSuccessCard = ref(false);
const cookiePreferences = ref({
  necessary: true,
  analytics: false,
  marketing: false,
});

function formatDate(dateStr: string) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function toggleFaq(idx: number) {
  openFaqIndex.value = openFaqIndex.value === idx ? null : idx;
}

function animateCounter(element: HTMLElement) {
  const target = parseInt(element.dataset.target || '0');
  const suffix = element.dataset.suffix || '';
  const duration = 2000;
  const step = Math.ceil(target / (duration / 16));
  let current = 0;
  const timer = setInterval(() => {
    current += step;
    if (current >= target) { current = target; clearInterval(timer); }
    element.textContent = current.toLocaleString() + suffix;
  }, 16);
}

// Generate or retrieve visitor ID
function getOrCreateVisitorId(): string {
  let visitorId = localStorage.getItem('visiterId');
  if (!visitorId) {
    // Create a unique visitor ID based on browser fingerprinting
    const browserData = `${navigator.userAgent}-${navigator.language}-${new Date().getTimezoneOffset()}`;
    visitorId = 'visitor_' + btoa(browserData).replace(/[^a-zA-Z0-9]/g, '').substring(0, 32) + '_' + Date.now();
    localStorage.setItem('visiterId', visitorId);
  }
  return visitorId;
}

// Cookie Consent Handlers
async function acceptAllCookies() {
  cookiePreferences.value = {
    necessary: true,
    analytics: true,
    marketing: true,
  };
  await saveCookiePreferences(true);
}

async function declineCookies() {
  cookiePreferences.value = {
    necessary: true,
    analytics: false,
    marketing: false,
  };
  await saveCookiePreferences(false);
}

async function saveCookiePreferences(acceptAll: boolean = false) {
  try {
    const visitorId = getOrCreateVisitorId();

    const payload = {
      visitor_id: visitorId,
      necessary_cookies: true,
      analytics_cookies: cookiePreferences.value.analytics,
      marketing_cookies: cookiePreferences.value.marketing,
      accept_all: acceptAll,
      source: 'homepage',
    };

    // Send to backend
    const response = await axios.post('/api/v1/cookies/consent', payload);

    // Save locally
    localStorage.setItem('cookieConsent', JSON.stringify(cookiePreferences.value));
    localStorage.setItem('cookieConsentDate', new Date().toISOString());
    localStorage.setItem('cookieConsentId', response.data.data?.id);

    showCookieConsent.value = false;
    showCookieSuccessCard.value = true;
    setTimeout(() => { showCookieSuccessCard.value = false; }, 3500);
  } catch (error) {
    console.error('Failed to save cookie preferences:', error);
    // Still save locally even if API fails
    localStorage.setItem('cookieConsent', JSON.stringify(cookiePreferences.value));
    localStorage.setItem('cookieConsentDate', new Date().toISOString());
    showCookieConsent.value = false;
    showCookieSuccessCard.value = true;
    setTimeout(() => { showCookieSuccessCard.value = false; }, 3500);
  }
}

async function saveAndClosePreferences() {
  await saveCookiePreferences(false);
  showPreferencesModal.value = false;
}

onMounted(async () => {
  // Start loading page content immediately — don't wait on the cookie consent lookup
  const contentLoaded = Promise.all([fetchHomeData(), fetchFaqs(), fetchPackages()]);

  // Check if user has already given cookie consent
  const savedCookieConsent = localStorage.getItem('cookieConsent');
  if (savedCookieConsent) {
    cookiePreferences.value = JSON.parse(savedCookieConsent);
    showCookieConsent.value = false;
  } else {
    // Try to fetch existing consent from backend
    try {
      const visitorId = getOrCreateVisitorId();
      const response = await axios.get('/api/v1/cookies/consent', {
        params: { visitor_id: visitorId }
      });
      if (response.data.has_consent && response.data.data) {
        cookiePreferences.value = {
          necessary: response.data.data.necessary_cookies,
          analytics: response.data.data.analytics_cookies,
          marketing: response.data.data.marketing_cookies,
        };
        showCookieConsent.value = false;
      }
    } catch (error) {
      // No existing cookie consent found
    }
  }

  await contentLoaded;
  setTimeout(() => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) { animateCounter(entry.target as HTMLElement); observer.unobserve(entry.target); }
      });
    });
    counterRefs.value.forEach((el) => { if (el) observer.observe(el); });
  }, 500);
});
</script>

<style scoped>
.hero-swiper :deep(.swiper-pagination-bullet) { width: 8px; height: 8px; background: var(--color-primary); opacity: 0.3; transition: all 0.3s; }
.hero-swiper :deep(.swiper-pagination-bullet-active) { opacity: 1; width: 20px; border-radius: 4px; }

.cards-swiper :deep(.swiper-button-prev),
.cards-swiper :deep(.swiper-button-next) { color: var(--color-primary); width: 32px; height: 32px; background: hsl(var(--card)); border: 1px solid hsl(var(--border)); border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
.cards-swiper :deep(.swiper-button-prev)::after,
.cards-swiper :deep(.swiper-button-next)::after { font-size: 12px; font-weight: bold; }

.testimonials-swiper :deep(.swiper-pagination-bullet) { width: 8px; height: 8px; background: var(--color-primary); opacity: 0.3; }
.testimonials-swiper :deep(.swiper-pagination-bullet-active) { opacity: 1; }

/* Fix WCAG contrast: darken primary button backgrounds for better text contrast */
a.bg-primary.text-white,
button.bg-primary.text-white {
  background-color: #b80ed1;
  background-color: color-mix(in srgb, #d311f5, black 10%);
}
a.bg-primary.text-white:hover,
button.bg-primary.text-white:hover {
  background-color: #a80cc4;
  background-color: color-mix(in srgb, #d311f5, black 18%);
}
</style>

<style>
.cta-wrap {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 420px;
  border-radius: 1rem;
  overflow: hidden;
  border: 0.5px solid rgba(255,255,255,0.08);
  background: #0f0f0f;
}
.video-side {
  position: relative;
  background: #000;
  overflow: hidden;
  min-height: 360px;
}
.video-side video {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.video-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, transparent 60%, #0f0f0f 100%);
  pointer-events: none;
}
.copy-side {
  padding: 48px 44px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: #0f0f0f;
}
.eyebrow {
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: #d311f5;
  margin: 0 0 14px;
}
.headline {
  font-size: 28px;
  font-weight: 700;
  color: #fff;
  line-height: 1.25;
  margin: 0 0 16px;
}
.headline span {
  color: #d311f5;
}
.body-text {
  font-size: 14px;
  color: rgba(255,255,255,0.58);
  line-height: 1.75;
  margin: 0 0 32px;
  max-width: 340px;
}
.cta-row {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}
.btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  background: #d311f5;
  color: #fff;
  font-size: 13px;
  font-weight: 600;
  border-radius: 999px;
  text-decoration: none;
  transition: opacity 0.18s;
}
.btn-primary:hover { opacity: 0.88; }
.btn-primary svg { width: 14px; height: 14px; }
.btn-ghost {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 12px 24px;
  background: transparent;
  color: rgba(255,255,255,0.65);
  font-size: 13px;
  font-weight: 600;
  border-radius: 999px;
  border: 0.5px solid rgba(255,255,255,0.18);
  text-decoration: none;
  transition: border-color 0.18s, color 0.18s;
}
.btn-ghost:hover { border-color: rgba(255,255,255,0.45); color: #fff; }
.divider {
  width: 36px;
  height: 2px;
  background: #d311f5;
  margin: 0 0 28px;
  border-radius: 2px;
}

@media (max-width: 900px) {
  .cta-wrap {
    grid-template-columns: 1fr;
  }
  .video-side {
    min-height: 260px;
  }
  .video-overlay {
    background: linear-gradient(to bottom, transparent 60%, #0f0f0f 100%);
  }
  .copy-side {
    padding: 36px 28px;
  }
}
</style>
