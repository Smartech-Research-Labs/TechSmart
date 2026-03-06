<template>
  <PublicLayout>
    <!-- ═══════════════ HERO SECTION ═══════════════ -->
    <section class="relative min-h-[60vh] md:min-h-[70vh] flex items-center">
      <!-- Tech Background Image -->
      <div class="absolute inset-0 z-0">
        <img :src="settings.hero_bg_image || 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&h=1080&fit=crop&q=80'" alt="Technology Background" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-r from-background/95 via-background/80 to-background/40 dark:from-background/95 dark:via-background/80 dark:to-background/50"></div>
      </div>

      <!-- Slider Content -->
      <div class="relative z-10 w-full">
        <Swiper
          :modules="[Autoplay, Pagination]"
          :slides-per-view="1"
          :autoplay="{ delay: 6000, disableOnInteraction: false }"
          :pagination="{ clickable: true }"
          :loop="true"
          class="hero-swiper"
        >
          <SwiperSlide v-for="slide in sliders" :key="slide.id">
            <div class="container mx-auto px-6 py-16 md:py-24">
              <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div class="max-w-lg">
                  <p v-if="slide.subtitle" class="text-primary font-semibold text-xs tracking-widest uppercase mb-3">{{ slide.subtitle }}</p>
                  <h1 class="text-3xl md:text-4xl lg:text-[2.75rem] font-bold leading-tight text-foreground mb-4">{{ slide.title }}</h1>
                  <p v-if="slide.description" class="text-muted-foreground text-sm leading-relaxed mb-8 max-w-md">{{ slide.description }}</p>
                  <div class="flex flex-wrap gap-3">
                    <router-link v-if="slide.cta_text && slide.cta_link" :to="slide.cta_link" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                      {{ slide.cta_text }}
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                    </router-link>
                    <router-link v-if="slide.cta_text_2 && slide.cta_link_2" :to="slide.cta_link_2" class="px-7 py-3 border border-border text-foreground text-sm font-medium rounded-full hover:bg-muted transition-all">{{ slide.cta_text_2 }}</router-link>
                  </div>
                </div>
                <div class="hidden lg:block">
                  <img v-if="slide.image_url" :src="slide.image_url" :alt="slide.title" class="w-full max-h-[400px] object-contain rounded-xl" />
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>

        <!-- Fallback if no sliders -->
        <div v-if="!sliders.length && !loading" class="container mx-auto px-6 py-16 md:py-24">
          <div class="max-w-lg">
            <p class="text-primary font-semibold text-xs tracking-widest uppercase mb-3">Welcome to Smartech Research Labs</p>
            <h1 class="text-3xl md:text-4xl lg:text-[2.75rem] font-bold leading-tight text-foreground mb-4">Innovative Technology Solutions for Africa</h1>
            <p class="text-muted-foreground text-sm leading-relaxed mb-8">We build software, automate workflows, and drive digital transformation for businesses across the continent.</p>
            <router-link to="/services" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
              Read More
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ COUNTER BAR (TEAL/CYAN GRADIENT) ═══════════════ -->
    <section class="bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-400 py-6 shadow-lg">
      <div class="container mx-auto px-6">
        <div class="flex flex-wrap justify-between items-center gap-8">
          <div v-for="counter in countersFinal" :key="counter.id" class="flex-1 min-w-[120px] text-center">
            <div class="text-2xl md:text-3xl font-bold text-white mb-1">
              <span ref="counterRefs" :data-target="counter.number || counter.value" :data-suffix="counter.suffix || '+'">0</span>
            </div>
            <div class="text-white/80 text-xs font-medium tracking-wide">{{ counter.label || counter.title }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Trusted By -->
    <section class="py-16 border-y border-border bg-muted/30">
      <div class="container mx-auto px-4">
        <p class="text-center text-sm text-muted-foreground font-medium uppercase tracking-widest mb-10">Trusted by innovative companies</p>
        <div v-if="clients.length" class="flex flex-wrap items-center justify-center gap-12 md:gap-16">
          <div v-for="client in clients" :key="client.id" class="opacity-50 hover:opacity-100 transition-opacity duration-300">
            <img :src="client.logo_url" :alt="client.name" class="max-h-10 grayscale hover:grayscale-0 transition" />
          </div>
        </div>
        <div v-else class="flex flex-wrap items-center justify-center gap-10 md:gap-14">
          <div v-for="name in fallbackPartners" :key="name" class="opacity-40 hover:opacity-80 transition-opacity">
            <span class="text-foreground font-bold text-lg tracking-wide">{{ name }}</span>
          </div>
        </div>
      </div>
    </section>

 

    <!-- ═══════════════ ABOUT US ═══════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
          <!-- Left - Image -->
          <div class="relative">
            <div class="rounded-2xl overflow-hidden shadow-lg">
              <img :src="settings.about_section_image || 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop&q=80'" alt="Our Team" class="w-full aspect-[4/3] object-cover" />
            </div>
            <!-- Experience Badge -->
            <div class="absolute -bottom-6 -right-6 md:bottom-6 md:right-6 bg-primary text-white rounded-2xl p-5 shadow-xl">
              <div class="text-3xl font-bold">10+</div>
              <div class="text-xs font-medium text-primary-foreground/80">Years of<br/>Excellence</div>
            </div>
          </div>

          <!-- Right - Content -->
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About Us</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Your Trusted Technology Partner</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">Smartech Research Labs is a leading technology company dedicated to empowering businesses with innovative digital solutions. We combine deep technical expertise with a passion for solving real-world challenges.</p>
            <p class="text-muted-foreground text-sm leading-relaxed mb-8">From startups to enterprises, we help organizations harness the power of technology to improve efficiency, scale operations, and drive growth across Africa and beyond.</p>

            <div class="grid grid-cols-2 gap-4 mb-8">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-foreground text-sm font-medium">Proven Track Record</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <span class="text-foreground text-sm font-medium">Fast Delivery</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <span class="text-foreground text-sm font-medium">Expert Team</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-500/10 rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-foreground text-sm font-medium">24/7 Support</span>
              </div>
            </div>

            <router-link to="/about" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-sm">
              Learn More About Us
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
          </div>
        </div>
      </div>
    </section>

      <!-- ═══════════════ OUR SOLUTIONS (IMAGE CARDS) ═══════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-10">
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Solutions</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">Our Solutions</h2>
          </div>
          <router-link to="/services" class="hidden sm:inline-flex items-center gap-2 px-6 py-2.5 border border-primary text-primary text-xs font-semibold rounded-full hover:bg-primary hover:text-white transition-all">
            View All
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
          <router-link v-for="service in allServices.slice(0, 8)" :key="service.id" :to="`/services/${service.slug}`" class="group block bg-card border border-border rounded-2xl overflow-hidden hover:border-primary/20 hover:shadow-sm transition-all duration-300">
            <div class="aspect-[4/3] bg-muted overflow-hidden relative">
              <img v-if="service.image_url" :src="service.image_url" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/5 to-accent/5">
                <span class="text-3xl">{{ service.icon || '💡' }}</span>
              </div>
            </div>
            <div class="p-5">
              <h3 class="text-sm font-semibold text-foreground mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ service.title }}</h3>
              <p class="text-muted-foreground text-xs leading-relaxed line-clamp-2 mb-3">{{ service.excerpt || service.short_description }}</p>
              <span class="text-primary font-medium text-xs flex items-center gap-1 group-hover:gap-2 transition-all">
                Learn More <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
              </span>
            </div>
          </router-link>
        </div>

        <div class="text-center mt-10 sm:hidden">
          <router-link to="/services" class="inline-flex items-center gap-2 px-7 py-3 border border-primary text-primary text-sm font-semibold rounded-full hover:bg-primary hover:text-white transition-all">
            View All Services
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

   

   

    <!-- ═══════════════ WE SPECIALIZE IN ═══════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">What We Do</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">We Specialize In</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">End-to-end technology and digital solutions designed to help your business thrive in the modern economy.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
          <div v-for="(spec, i) in specializations" :key="i" class="bg-card border border-border rounded-2xl p-6 text-center hover:border-primary/30 hover:shadow-sm transition-all duration-300 group">
            <div class="w-14 h-14 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors">
              <span class="text-2xl">{{ spec.icon }}</span>
            </div>
            <h3 class="text-sm font-semibold text-foreground mb-2">{{ spec.title }}</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">{{ spec.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ INDUSTRIES WE SERVE ═══════════════ -->
    <section class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-10">
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Industries</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">Industries We Serve</h2>
          </div>
          <router-link to="/industries" class="hidden sm:inline-flex items-center gap-2 px-6 py-2.5 border border-accent text-accent text-xs font-semibold rounded-full hover:bg-accent hover:text-white transition-all">
            View All
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
          <router-link v-for="(industry, i) in industries" :key="i" :to="`/industries#${industry.title.toLowerCase()}`" class="group block bg-card border border-border rounded-2xl overflow-hidden hover:border-accent/20 hover:shadow-sm transition-all duration-300">
            <div class="aspect-[4/3] bg-muted overflow-hidden">
              <img :src="industry.image" :alt="industry.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
            </div>
            <div class="p-5 text-center">
              <div class="w-10 h-10 mx-auto bg-accent/10 rounded-lg flex items-center justify-center mb-3 group-hover:bg-accent/20 transition-colors">
                <span class="text-lg">{{ industry.icon }}</span>
              </div>
              <h3 class="text-sm font-semibold text-foreground mb-1 group-hover:text-accent transition-colors">{{ industry.title }}</h3>
              <p class="text-muted-foreground text-xs leading-relaxed">{{ industry.desc }}</p>
            </div>
          </router-link>
        </div>

        <div class="text-center mt-10 sm:hidden">
          <router-link to="/industries" class="inline-flex items-center gap-2 px-7 py-3 border border-accent text-accent text-sm font-semibold rounded-full hover:bg-accent hover:text-white transition-all">
            View All Industries
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ SERVICES CAROUSEL ═══════════════ -->
    <section v-if="allServices.length" class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-10">
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Services</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">Services That Drive Growth</h2>
          </div>
          <router-link to="/services" class="hidden sm:inline-flex items-center gap-2 px-6 py-2.5 border border-primary text-primary text-xs font-semibold rounded-full hover:bg-primary hover:text-white transition-all">
            View All
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>

        <Swiper
          :modules="[Autoplay, Navigation]"
          :slides-per-view="1"
          :space-between="20"
          :navigation="true"
          :autoplay="{ delay: 4000, disableOnInteraction: false }"
          :breakpoints="{ 480: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } }"
          class="cards-swiper"
        >
          <SwiperSlide v-for="service in allServices" :key="service.id">
            <router-link :to="`/services/${service.slug}`" class="group block bg-card rounded-2xl overflow-hidden border border-border hover:border-primary/20 hover:shadow-sm transition-all duration-300">
              <div class="aspect-[4/3] bg-muted overflow-hidden relative">
                <img v-if="service.image_url" :src="service.image_url" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/5 to-accent/5">
                  <span class="text-3xl">{{ service.icon || '💡' }}</span>
                </div>
                <div class="absolute top-3 right-3 z-10">
                  <WishlistButton type="App\\Models\\Service" :item-id="service.id" />
                </div>
              </div>
              <div class="p-5">
                <h3 class="text-sm font-semibold text-foreground mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ service.title }}</h3>
                <p class="text-muted-foreground text-xs leading-relaxed line-clamp-2 mb-3">{{ service.excerpt || service.short_description }}</p>
                <div class="flex items-center justify-between">
                  <span v-if="service.price_label" class="text-primary font-bold text-sm">{{ service.price_label }}</span>
                  <span class="text-primary font-medium text-xs flex items-center gap-1 group-hover:gap-2 transition-all">
                    Learn More <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
                  </span>
                </div>
              </div>
            </router-link>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

    <!-- ═══════════════ CTA 1 — MAROON/RED ═══════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="relative bg-gradient-to-br from-red-900 via-red-800 to-red-900 rounded-3xl overflow-hidden shadow-lg">
          <div class="absolute inset-0 opacity-15 bg-[url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&q=40')] bg-cover bg-center"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-10 md:p-14 lg:p-16">
              <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight mb-5">Ready to Transform Your Business with Technology?</h2>
              <p class="text-red-100/80 text-sm leading-relaxed mb-4">Let us build innovative solutions that drive real results. From custom software to AI-powered automation — we deliver digital transformation that matters.</p>
              <p class="text-red-100/70 text-sm leading-relaxed mb-8">Expand your reach, build your digital presence, impact customers and grow revenue.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-md">
                Get Started
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex items-end justify-end h-full min-h-[380px]">
              <img :src="settings.cta_professional_image || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=500&h=600&fit=crop&q=80'" alt="Professional" class="h-full max-h-[420px] object-cover object-top" />
            </div>
          </div>
        </div>
      </div>
    </section>

     <!-- ═══════════════ WHY CHOOSE US ═══════════════ -->
    <section class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Us</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Why Smartech Research Labs?</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">We go beyond just building software — we build partnerships that drive lasting impact.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="(reason, i) in whyUsReasons" :key="i" class="relative bg-card border border-border rounded-2xl p-8 hover:border-primary/30 hover:shadow-md transition-all duration-300 group overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-bl-full group-hover:bg-primary/10 transition-colors"></div>
            <div class="relative">
              <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-5 group-hover:bg-primary/20 transition-colors">
                <span class="text-2xl" v-html="reason.icon"></span>
              </div>
              <h3 class="text-base font-bold text-foreground mb-3">{{ reason.title }}</h3>
              <p class="text-muted-foreground text-sm leading-relaxed">{{ reason.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ PRODUCTS CAROUSEL ═══════════════ -->
    <section v-if="products.length" class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-10">
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Our Products</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">Featured Products</h2>
          </div>
          <router-link to="/products" class="hidden sm:inline-flex items-center gap-2 px-6 py-2.5 border border-accent text-accent text-xs font-semibold rounded-full hover:bg-accent hover:text-white transition-all">
            View All
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>

        <Swiper
          :modules="[Autoplay, Navigation]"
          :slides-per-view="1"
          :space-between="20"
          :navigation="true"
          :autoplay="{ delay: 5000, disableOnInteraction: false }"
          :breakpoints="{ 480: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } }"
          class="cards-swiper"
        >
          <SwiperSlide v-for="product in products" :key="product.id">
            <router-link :to="`/products/${product.slug}`" class="group block bg-card rounded-2xl overflow-hidden border border-border hover:border-accent/20 hover:shadow-sm transition-all duration-300">
              <div class="aspect-[4/3] bg-muted overflow-hidden relative">
                <img v-if="product.image_url" :src="product.image_url" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-accent/5 to-primary/5">
                  <svg class="w-10 h-10 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <div class="absolute top-3 right-3 z-10">
                  <WishlistButton type="App\\Models\\Product" :item-id="product.id" />
                </div>
              </div>
              <div class="p-5">
                <h3 class="text-sm font-semibold text-foreground mb-2 group-hover:text-accent transition-colors line-clamp-2">{{ product.name }}</h3>
                <p class="text-muted-foreground text-xs leading-relaxed line-clamp-2 mb-3">{{ product.excerpt || product.short_description }}</p>
                <div class="flex items-center justify-between">
                  <span v-if="product.price" class="text-accent font-bold text-sm">Ksh {{ Number(product.price).toLocaleString() }}</span>
                  <span v-else-if="product.price_label" class="text-accent font-bold text-sm">{{ product.price_label }}</span>
                  <span class="text-primary font-medium text-xs flex items-center gap-1 group-hover:gap-2 transition-all">View <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg></span>
                </div>
              </div>
            </router-link>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

  <!-- ═══════════════ POPULATION IMPACTED ═══════════════ -->
<section class="py-16 md:py-24">
  <div class="container mx-auto px-6">

    <!-- Header -->
    <div class="text-center max-w-4xl mx-auto mb-12">
      <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">
        Global Impact
      </p>
      <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">
        Population Impacted
      </h2>
      <p class="text-muted-foreground text-sm leading-relaxed">
        In line with our mission to partner with organizations worldwide, providing them with
        data-driven insights and transformative training, we have partnered with several
        organizations within the NGO, private, and public sectors to achieve the UN's
        Sustainable Development Goals (SDGs).
      </p>
    </div>

    <!-- Two-column grid -->
    <div class="grid lg:grid-cols-2 gap-8 items-stretch">

      <!-- ── LEFT: population.png image ── -->
      <div class="relative rounded-2xl overflow-hidden min-h-[420px]">
        <img
          :src="settings.population_image || populationImage || '/images/population.png'"
          alt="Global population impacted by Smartech Research Labs"
          class="w-full h-full object-cover"
        />
        <!-- Subtle overlay so the image doesn't feel flat -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none" />
        <!-- Optional caption badge at bottom-left -->
        <div class="absolute bottom-5 left-5 right-5">
          <span class="inline-block bg-primary text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow">
            Delivering impact across {{ impactStats[0]?.value ?? '30+' }} countries
          </span>
        </div>
      </div>

      <!-- ── RIGHT: Project carousel ── -->
      <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl overflow-hidden flex flex-col min-h-[420px]">

        <!-- Carousel header -->
        <div class="px-6 pt-6 pb-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
          <h3 class="text-sm font-semibold text-foreground uppercase tracking-widest">
            Featured Projects
          </h3>
          <!-- Slide counter -->
          <span class="text-xs text-muted-foreground tabular-nums">
            {{ activeSlide + 1 }} / {{ impactProjects.length }}
          </span>
        </div>

        <div class="flex-1 relative">
          <Swiper
            :modules="[Autoplay, Navigation]"
            :slides-per-view="1"
            :space-between="0"
            :navigation="{
              prevEl: '.pop-prev',
              nextEl: '.pop-next',
            }"
            :autoplay="{ delay: 5000, disableOnInteraction: false }"
            :loop="true"
            @slide-change="onSlideChange"
            class="h-full"
          >
            <SwiperSlide
              v-for="(project, i) in impactProjects"
              :key="i"
            >
              <div class="flex flex-col h-full p-6 gap-4">

                <!-- Project image -->
                <div class="rounded-xl overflow-hidden bg-white dark:bg-gray-900 flex items-center justify-center h-48 shrink-0">
                  <img
                    v-if="project.image"
                    :src="project.image"
                    :alt="project.title"
                    class="w-full h-full object-cover"
                  />
                  <!-- Placeholder if no image -->
                  <div
                    v-else
                    class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700"
                  >
                    <span class="text-muted-foreground text-xs">No image available</span>
                  </div>
                </div>

                <!-- Project meta -->
                <div class="flex items-center gap-2 flex-wrap">
                  <span class="bg-primary/10 text-primary text-xs font-semibold px-2.5 py-1 rounded-full">
                    {{ project.sector ?? 'Research' }}
                  </span>
                  <span class="text-muted-foreground text-xs">
                    {{ project.location }}
                  </span>
                </div>

                <!-- Title -->
                <h3 class="text-lg md:text-xl font-bold text-foreground leading-snug">
                  {{ project.title }}
                </h3>

                <!-- Description -->
                <p class="text-muted-foreground text-sm leading-relaxed line-clamp-3 flex-1">
                  {{ project.description }}
                </p>

                <!-- CTA button -->
                <div class="pt-2">
                  <RouterLink
                    :to="`/case-studies/${project.case_study_slug}`"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors"
                  >
                    View Case Study
                    <!-- Arrow icon -->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-4 h-4"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                  </RouterLink>
                </div>

              </div>
            </SwiperSlide>
          </Swiper>

          <!-- Custom nav arrows — positioned at bottom-right -->
          <div class="absolute bottom-6 right-6 flex items-center gap-2 z-10">
            <button
              class="pop-prev w-8 h-8 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 flex items-center justify-center hover:border-primary hover:text-primary transition-colors disabled:opacity-30"
              aria-label="Previous project"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </button>
            <button
              class="pop-next w-8 h-8 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 flex items-center justify-center hover:border-primary hover:text-primary transition-colors"
              aria-label="Next project"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
          </div>
        </div>

      </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-10">
      <div
        v-for="(stat, i) in impactStats.slice(0, 4)"
        :key="i"
        class="bg-card border border-border rounded-xl p-5 text-center hover:shadow-sm hover:border-primary/20 transition-all"
      >
        <div class="text-2xl md:text-3xl font-bold text-primary mb-1">{{ stat.value }}</div>
        <div class="text-muted-foreground text-xs font-medium">{{ stat.label }}</div>
      </div>
    </div>

    <!-- Link to all case studies -->
    <div class="text-center mt-10">
      <RouterLink
        to="/case-studies"
        class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline underline-offset-4"
      >
        Browse all case studies
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </RouterLink>
    </div>

  </div>
</section>

      <!-- Process -->
    <section class="py-24 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">Our Process</div>
          <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">How we bring your <span class="text-primary">ideas</span> to life</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="(step, idx) in processSteps" :key="idx" class="relative text-center">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6 relative">
              <span class="text-2xl font-bold text-primary">{{ idx + 1 }}</span>
              <div v-if="idx < processSteps.length - 1" class="hidden lg:block absolute top-1/2 left-full w-full h-px bg-border -translate-y-1/2"></div>
            </div>
            <h3 class="text-lg font-bold text-foreground mb-2">{{ step.title }}</h3>
            <p class="text-muted-foreground text-sm">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ TESTIMONIALS CAROUSEL ═══════════════ -->
    <section v-if="topReviews.length" class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-12">
          <p class="text-amber-600 dark:text-amber-400 text-xs font-semibold tracking-widest uppercase mb-3">Testimonials</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">What Our Clients Say</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">Trusted by businesses across Africa and beyond.</p>
        </div>

        <Swiper
          :modules="[Autoplay, Pagination]"
          :slides-per-view="1"
          :space-between="24"
          :pagination="{ clickable: true }"
          :autoplay="{ delay: 5000, disableOnInteraction: false }"
          :breakpoints="{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }"
          class="testimonials-swiper pb-14"
        >
          <SwiperSlide v-for="review in topReviews" :key="review.id">
            <div class="bg-card border border-border rounded-2xl p-6 h-full flex flex-col shadow-sm">
              <div class="flex gap-1 mb-4">
                <svg v-for="s in review.rating" :key="s" class="w-5 h-5 text-amber-400 fill-current" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
              <p class="text-muted-foreground text-sm leading-relaxed mb-5 flex-1 line-clamp-5">"{{ review.comment }}"</p>
              <div class="flex items-center gap-3 pt-4 border-t border-border">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                  {{ review.user_name?.charAt(0).toUpperCase() }}
                </div>
                <div class="min-w-0">
                  <div class="font-semibold text-foreground text-sm truncate">{{ review.user_name }}</div>
                  <div class="text-muted-foreground text-xs truncate">{{ review.company || 'Verified Client' }}</div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

     <!-- ═══════════════ CORE VALUES ═══════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-[1fr_1.2fr] gap-14 items-center">
          <!-- Left - Content -->
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Foundation</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Our Core Values</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-8">These principles guide every decision we make and every solution we deliver.</p>

            <div class="space-y-4">
              <div v-for="(value, i) in coreValues" :key="i" class="flex items-start gap-4 p-4 rounded-xl hover:bg-muted/30 transition-colors group">
                <div class="w-12 h-12 shrink-0 rounded-xl flex items-center justify-center text-xl" :class="value.bgClass">
                  {{ value.icon }}
                </div>
                <div>
                  <h3 class="text-sm font-bold text-foreground mb-1 group-hover:text-primary transition-colors">{{ value.title }}</h3>
                  <p class="text-muted-foreground text-xs leading-relaxed">{{ value.desc }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Right - Image -->
          <div class="relative">
            <div class="rounded-2xl overflow-hidden shadow-lg">
              <img :src="settings.values_section_image || 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop&q=80'" alt="Our Values" class="w-full aspect-[4/3] object-cover" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CTA 2 — DARK MAROON ═══════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="relative bg-gradient-to-br from-red-900 via-rose-900 to-red-900 rounded-3xl overflow-hidden shadow-lg">
          <div class="absolute inset-0 opacity-15 bg-[url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1200&q=40')] bg-cover bg-center"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-10 md:p-14 lg:p-16">
              <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight mb-5">Partner With Us — Build the Future Together</h2>
              <p class="text-red-100/80 text-sm leading-relaxed mb-4">In line with our mission to empower businesses with cutting-edge technology, we are looking for innovators, creators, and problem-solvers to join our ecosystem.</p>
              <p class="text-red-100/70 text-sm leading-relaxed mb-8">Expand your professional network, build expertise, impact businesses, and earn.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-md">
                Apply Now
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex items-end justify-end h-full min-h-[350px]">
              <img :src="settings.cta_professional_image || 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=500&h=600&fit=crop&q=80'" alt="Business Professional" class="h-full max-h-[400px] object-cover object-top" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ TRUSTED BY (SPLIT LAYOUT) ═══════════════ -->
    <section class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
          <!-- Left: Copy -->
          <div class="lg:col-span-4 lg:sticky lg:top-28">
            <h2 class="text-3xl md:text-4xl font-bold text-primary leading-tight mb-5">Trusted By</h2>
            <p class="text-muted-foreground text-base leading-relaxed mb-8">We are the go-to partner in empowering organizations and professionals with solutions and expertise globally</p>
            <router-link to="/about" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-sm">
              View More
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
          </div>

          <!-- Right: Logo Grid -->
          <div class="lg:col-span-8">
            <div v-if="clients.length" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 border-l border-t border-border">
              <a
                v-for="client in clients.slice(0, 42)"
                :key="client.id"
                :href="client.website_url || '#'"
                target="_blank"
                rel="noopener"
                class="aspect-square bg-card border-r border-b border-border flex items-center justify-center p-3 hover:bg-primary/5 transition-colors group"
              >
                <img
                  v-if="client.logo_url"
                  :src="client.logo_url"
                  :alt="client.name"
                  class="max-h-12 max-w-full object-contain transition-transform duration-300 group-hover:scale-110"
                />
                <span v-else class="text-muted-foreground font-semibold text-[11px] text-center leading-tight group-hover:text-primary transition-colors">{{ client.name }}</span>
              </a>
            </div>
            <div v-else class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 border-l border-t border-border">
              <div
                v-for="name in fallbackPartners"
                :key="name"
                class="aspect-square bg-card border-r border-b border-border flex items-center justify-center p-3 hover:bg-primary/5 transition-colors group"
              >
                <span class="text-muted-foreground font-semibold text-[11px] text-center leading-tight group-hover:text-primary transition-colors">{{ name }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  

    <!-- ═══════════════ REQUEST A QUOTE ═══════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
          <!-- Left - Form -->
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Get Started</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Request a Quote</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-8">Tell us about your project and we'll get back to you within 24 hours.</p>

            <form @submit.prevent="submitQuoteRequest" class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <input v-model="quoteForm.name" type="text" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all" placeholder="Email *" />
              </div>
              <div class="grid grid-cols-2 gap-4">
                <input v-model="quoteForm.phone" type="tel" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all" placeholder="Phone *" />
                <select v-model="quoteForm.service" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all">
                  <option value="">Service Needed *</option>
                  <option v-for="service in allServices" :key="service.id" :value="service.title">{{ service.title }}</option>
                </select>
              </div>
              <textarea v-model="quoteForm.description" required rows="4" class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm resize-none transition-all" placeholder="Project description..."></textarea>
              <div class="grid grid-cols-2 gap-4">
                <select v-model="quoteForm.budget" class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all">
                  <option value="">Budget Range</option>
                  <option value="Under Ksh 10,000">Under Ksh 10,000</option>
                  <option value="Ksh 10,000 - Ksh 50,000">Ksh 10,000 - Ksh 50,000</option>
                  <option value="Ksh 50,000 - Ksh 200,000">Ksh 50,000 - Ksh 200,000</option>
                  <option value="Over Ksh 200,000">Over Ksh 200,000</option>
                </select>
                <select v-model="quoteForm.timeline" class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all">
                  <option value="">Timeline</option>
                  <option value="ASAP">ASAP</option>
                  <option value="1-2 months">1-2 months</option>
                  <option value="3-6 months">3-6 months</option>
                  <option value="6+ months">6+ months</option>
                </select>
              </div>
              <button type="submit" :disabled="quoteFormSubmitting" class="w-full px-6 py-3.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 disabled:opacity-50 transition-all shadow-sm">
                {{ quoteFormSubmitting ? 'Submitting...' : 'Submit Quote Request' }}
              </button>
            </form>
          </div>

          <!-- Right - Image -->
          <div class="hidden lg:block">
            <div class="rounded-2xl overflow-hidden shadow-sm">
              <img :src="settings.quote_section_image || 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800&h=600&fit=crop&q=80'" alt="Get a Quote" class="w-full h-full object-cover aspect-[4/3]" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CONTACT US ═══════════════ -->
    <section class="py-16 md:py-24 bg-muted/20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
          <!-- Left - Image & Contact Info -->
          <div>
            <div class="rounded-2xl overflow-hidden shadow-lg mb-8">
              <img :src="settings.office_image || 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=500&fit=crop&q=80'" alt="Our Office" class="w-full aspect-[4/3] object-cover" />
            </div>
            <div class="space-y-4">
              <div v-if="settings.address" class="flex items-center gap-4">
                <div class="w-11 h-11 shrink-0 bg-primary/10 rounded-xl flex items-center justify-center">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <span class="text-muted-foreground text-sm">{{ settings.address }}</span>
              </div>
              <div v-if="settings.contact_email" class="flex items-center gap-4">
                <div class="w-11 h-11 shrink-0 bg-accent/10 rounded-xl flex items-center justify-center">
                  <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <a :href="`mailto:${settings.contact_email}`" class="text-muted-foreground text-sm hover:text-primary transition">{{ settings.contact_email }}</a>
              </div>
              <div v-if="settings.contact_phone" class="flex items-center gap-4">
                <div class="w-11 h-11 shrink-0 bg-green-500/10 rounded-xl flex items-center justify-center">
                  <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                </div>
                <a :href="`tel:${settings.contact_phone}`" class="text-muted-foreground text-sm hover:text-primary transition">{{ settings.contact_phone }}</a>
              </div>
            </div>
          </div>

          <!-- Right - Form -->
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Get In Touch</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Contact Us</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-8">Have a question? We're here to help. Send us a message and we'll respond promptly.</p>

            <form @submit.prevent="submitContactForm" class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <input v-model="contactForm.name" type="text" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all" placeholder="Full Name *" />
                <input v-model="contactForm.email" type="email" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all" placeholder="Email *" />
              </div>
              <input v-model="contactForm.phone" type="tel" class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all" placeholder="Phone Number" />
              <textarea v-model="contactForm.message" required rows="5" class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm resize-none transition-all" placeholder="How can we help you?"></textarea>
              <button type="submit" :disabled="contactFormSubmitting" class="w-full px-6 py-3.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 disabled:opacity-50 transition-all shadow-sm">
                {{ contactFormSubmitting ? 'Sending...' : 'Send Message' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ BLOG ═══════════════ -->
    <section v-if="recentBlogs.length" class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-10">
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Latest Insights</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">From Our Blog</h2>
          </div>
          <router-link to="/blog" class="hidden sm:inline-flex items-center gap-2 text-primary font-semibold text-sm hover:gap-3 transition-all">
            View All <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
          </router-link>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <router-link v-for="post in recentBlogs.slice(0, 4)" :key="post.id" :to="`/blog/${post.slug}`" class="group bg-card border border-border rounded-2xl overflow-hidden hover:border-primary/20 hover:shadow-sm transition-all duration-300">
            <div class="aspect-[4/3] bg-muted overflow-hidden">
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

    <!-- ═══════════════ NEWSLETTER ═══════════════ -->
    <section class="py-12 bg-muted/20 border-y border-border">
      <div class="container mx-auto px-6 max-w-2xl text-center">
        <h3 class="text-xl font-bold text-foreground mb-2">Stay Updated</h3>
        <p class="text-muted-foreground text-sm mb-6">Join our newsletter for the latest industry news and exclusive offers.</p>
        <form @submit.prevent="submitNewsletter" class="flex gap-4 max-w-lg mx-auto">
          <input v-model="newsletterEmail" type="email" required class="flex-1 px-5 py-3 bg-card border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all" placeholder="Enter your email" />
          <button type="submit" :disabled="newsletterSubmitting" class="px-7 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 disabled:opacity-50 transition-all shadow-sm whitespace-nowrap">
            {{ newsletterSubmitting ? '...' : 'Subscribe' }}
          </button>
        </form>
      </div>
    </section>

    <!-- ═══════════════ FAQ ═══════════════ -->
    <section v-if="faqs.length" class="py-16 md:py-24">
      <div class="container mx-auto px-6 max-w-3xl">
        <div class="text-center mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Frequently Asked Questions</h2>
        </div>

        <div class="space-y-3">
          <div v-for="(faq, idx) in faqs" :key="faq.id" class="bg-card border border-border rounded-xl overflow-hidden shadow-sm">
            <button @click="toggleFaq(idx)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/30 transition-colors">
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
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import PublicLayout from '@/layouts/PublicLayout.vue';
import WishlistButton from '@/components/WishlistButton.vue';
import axios from 'axios';
import { useToast } from '@/composables';

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
const impactProjectsApi = ref<any[]>([]);
const toast = useToast();

// Static Data
const specializations = [
  { icon: '\uD83D\uDCBB', title: 'Software Development', desc: 'Custom web & mobile applications' },
  { icon: '\uD83E\uDD16', title: 'AI & Automation', desc: 'Intelligent workflow automation' },
  { icon: '\u2601\uFE0F', title: 'Cloud Solutions', desc: 'Scalable cloud infrastructure' },
  { icon: '\uD83D\uDD12', title: 'Cybersecurity', desc: 'Enterprise security solutions' },
  { icon: '\uD83D\uDCF1', title: 'Mobile Apps', desc: 'iOS & Android development' },
  { icon: '\uD83D\uDCCA', title: 'Data Analytics', desc: 'Data-driven business insights' },
  { icon: '\uD83C\uDFAF', title: 'Digital Marketing', desc: 'SEO, PPC & social media' },
  { icon: '\uD83D\uDEE0\uFE0F', title: 'IT Consulting', desc: 'Strategic technology advisory' },
];

const impactStatsFallback = [
  { value: '500+', label: 'Projects Delivered' },
  { value: '200+', label: 'Happy Clients' },
  { value: '50+', label: 'Team Members' },
  { value: '15+', label: 'Countries Served' },
  { value: '99%', label: 'Client Satisfaction' },
  { value: '24/7', label: 'Support Available' },
  { value: '10+', label: 'Years Experience' },
  { value: '1M+', label: 'Users Impacted' },
];
const impactStats = computed(() => {
  if (counters.value.length >= 4) {
    return counters.value.map((c: any) => ({ value: c.value ?? c.count_value, label: c.label ?? c.title }));
  }
  return impactStatsFallback;
});

const fallbackPartners = ['Safaricom', 'Microsoft', 'Google Cloud', 'Amazon AWS', 'MTN Group', 'Equity Bank', 'KCB Group', 'Jumia'];

const countersFallback = [
  { id: 'f1', number: 500, suffix: '+', label: 'Projects Delivered' },
  { id: 'f2', number: 200, suffix: '+', label: 'Happy Clients' },
  { id: 'f3', number: 50, suffix: '+', label: 'Team Experts' },
  { id: 'f4', number: 15, suffix: '+', label: 'Countries Served' },
];
const countersFinal = computed(() => counters.value.length ? counters.value : countersFallback);

const impactProjectsFallback = [
  { id: 1, title: 'E-Commerce Platform', category: 'Web Development', location: 'Kenya', image: 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop&q=80' },
  { id: 2, title: 'Banking Mobile App', category: 'Mobile Apps', location: 'South Africa', image: 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=600&h=400&fit=crop&q=80' },
  { id: 3, title: 'Healthcare Portal', category: 'Healthcare', location: 'Nigeria', image: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600&h=400&fit=crop&q=80' },
  { id: 4, title: 'Logistics Dashboard', category: 'Analytics', location: 'Ethiopia', image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop&q=80' },
  { id: 5, title: 'EdTech Platform', category: 'Education', location: 'Ghana', image: 'https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=600&h=400&fit=crop&q=80' },
  { id: 6, title: 'Fintech Solution', category: 'Finance', location: 'Rwanda', image: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop&q=80' },
];
const impactProjects = computed(() => impactProjectsApi.value.length ? impactProjectsApi.value : impactProjectsFallback);

const industries = [
  { icon: '🏥', title: 'Healthcare', desc: 'Digital health solutions', image: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&h=600&fit=crop&q=80' },
  { icon: '🏦', title: 'Finance', desc: 'Fintech & banking systems', image: 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=600&fit=crop&q=80' },
  { icon: '📚', title: 'Education', desc: 'E-learning platforms', image: 'https://images.unsplash.com/photo-1427504494785-e7fdc53a351f?w=800&h=600&fit=crop&q=80' },
  { icon: '🛒', title: 'Retail', desc: 'E-commerce solutions', image: 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?w=800&h=600&fit=crop&q=80' },
  { icon: '🚚', title: 'Logistics', desc: 'Supply chain management', image: 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&h=600&fit=crop&q=80' },
  { icon: '🏭', title: 'Manufacturing', desc: 'Industrial automation', image: 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=800&h=600&fit=crop&q=80' },
  { icon: '🌾', title: 'Agriculture', desc: 'AgriTech solutions', image: 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&h=600&fit=crop&q=80' },
  { icon: '⚡', title: 'Energy', desc: 'Smart energy systems', image: 'https://images.unsplash.com/photo-1497440828260-c8e08f4d4c3d?w=800&h=600&fit=crop&q=80' },
];

const processSteps = [
  { title: 'Discovery', description: 'We understand your business goals and requirements' },
  { title: 'Strategy', description: 'We create a detailed plan tailored to your needs' },
  { title: 'Development', description: 'Our team builds your solution with cutting-edge technology' },
  { title: 'Launch', description: 'We deploy and support your solution for success' },
];

const whyFeatures = [
  { title: 'Expert Team', description: 'Experienced developers and consultants' },
  { title: 'Proven Track Record', description: '500+ successful projects delivered' },
  { title: 'Agile Methodology', description: 'Fast iterations and continuous improvement' },
  { title: '24/7 Support', description: 'Always here when you need us' },
];

const whyUsReasons = [
  { icon: '⚡', title: 'Lightning Fast Delivery', desc: 'We deliver solutions quickly without compromising quality. Your time-to-market matters.' },
  { icon: '🎯', title: 'Results-Driven Approach', desc: 'Every solution is built with measurable outcomes in mind. We focus on ROI, not just features.' },
  { icon: '🤝', title: 'True Partnership', desc: 'We become an extension of your team. Your success is our success.' },
  { icon: '💡', title: 'Innovation First', desc: 'We stay ahead of trends and bring cutting-edge solutions to your business.' },
  { icon: '🛡️', title: 'Security & Reliability', desc: 'Enterprise-grade security, 99.9% uptime, and continuous monitoring.' },
  { icon: '💰', title: 'Cost-Effective Solutions', desc: 'Maximum value for your investment. No hidden fees, transparent pricing.' },
];

const coreValues = [
  { icon: '🚀', title: 'Innovation', desc: 'We embrace cutting-edge technology and creative problem-solving.', bgClass: 'bg-primary/10' },
  { icon: '🤝', title: 'Integrity', desc: 'Honesty and transparency in everything we do.', bgClass: 'bg-accent/10' },
  { icon: '👥', title: 'Collaboration', desc: 'We work closely with our clients to achieve shared goals.', bgClass: 'bg-green-500/10' },
  { icon: '⭐', title: 'Excellence', desc: 'We deliver high-quality solutions that exceed expectations.', bgClass: 'bg-amber-500/10' },
];

// UI State
const counterRefs = ref<HTMLElement[]>([]);
const openFaqIndex = ref<number | null>(null);

// Form State
const quoteForm = ref({ name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' });
const quoteFormSubmitting = ref(false);
const newsletterEmail = ref('');
const newsletterSubmitting = ref(false);
const contactForm = ref({ name: '', email: '', phone: '', message: '' });
const contactFormSubmitting = ref(false);

// Fetch Data
async function fetchHomeData() {
  try {
    const { data } = await axios.get('/api/v1/home');
    const d = data.data || data;
    sliders.value = d.sliders || [];
    counters.value = d.counters || [];
    allServices.value = d.all_services || d.featured_services || [];
    products.value = d.featured_products || [];
    clients.value = d.clients || [];
    topReviews.value = d.top_reviews || [];
    if (!topReviews.value.length) {
      topReviews.value = [
        { id: 1, rating: 5, comment: 'Outstanding service! Smartech Research Labs built our e-commerce platform in record time with exceptional quality. Our online sales increased by 200% within three months.', user_name: 'David Okonkwo', company: 'CEO, AfricaTrade' },
        { id: 2, rating: 5, comment: 'The team is incredibly professional. They delivered our mobile app ahead of schedule and under budget. Runs flawlessly on both iOS and Android.', user_name: 'Sarah van der Merwe', company: 'CTO, FinSync SA' },
        { id: 3, rating: 5, comment: 'Their automation solutions saved us over 200 hours monthly. The CI/CD pipeline they built reduced our deployment time from days to minutes.', user_name: 'Michael Ndlovu', company: 'Operations Manager, LogiTech' },
        { id: 4, rating: 5, comment: 'They transformed our outdated website into a modern, responsive platform that doubled our leads. SEO took us from page 5 to page 1 in under 4 months.', user_name: 'Grace Molefe', company: 'Marketing Director, GreenEnergy' },
        { id: 5, rating: 5, comment: 'Their cybersecurity audit identified critical vulnerabilities we had no idea existed. Potentially saved us millions in breach costs.', user_name: 'James Pretorius', company: 'CISO, SecureBank' },
        { id: 6, rating: 5, comment: 'Best tech partner we have ever had. Their paid ads management tripled our online revenue in just 6 months with a consistent 5x ROAS.', user_name: 'Amina Hassan', company: 'Founder, StyleHub' },
      ];
    }
    recentBlogs.value = d.recent_blogs || [];
    impactProjectsApi.value = d.impact_projects || [];
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

// Tracks the active slide index for the "1 / N" counter
const activeSlide = ref(0)
function onSlideChange(swiper: { realIndex: number }) {
  activeSlide.value = swiper.realIndex
}

// populationImage comes from the CMS (see note below).
// Fall back to the local asset if not set.
const props = defineProps<{
  populationImage?: string   // CMS-managed URL for population.png
  impactProjects: {
    title: string
    description: string
    image: string
    location: string
    sector?: string
    case_study_slug: string  // used to build /case-studies/:slug
  }[]
  impactStats: {
    value: string
    label: string
  }[]
}>()

async function submitQuoteRequest() {
  quoteFormSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', {
      type: 'quote', name: quoteForm.value.name, email: quoteForm.value.email,
      phone: quoteForm.value.phone, service: quoteForm.value.service,
      message: quoteForm.value.description, budget: quoteForm.value.budget, timeline: quoteForm.value.timeline,
    });
    toast.success('Quote request submitted! We will contact you within 24 hours.');
    quoteForm.value = { name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' };
  } catch { toast.error('Failed to submit quote request. Please try again.'); }
  finally { quoteFormSubmitting.value = false; }
}

async function submitNewsletter() {
  newsletterSubmitting.value = true;
  try {
    await axios.post('/api/v1/newsletter/subscribe', { email: newsletterEmail.value });
    toast.success('Successfully subscribed!');
    newsletterEmail.value = '';
  } catch { toast.error('Failed to subscribe.'); }
  finally { newsletterSubmitting.value = false; }
}

async function submitContactForm() {
  contactFormSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', {
      type: 'contact', name: contactForm.value.name, email: contactForm.value.email,
      phone: contactForm.value.phone, message: contactForm.value.message,
    });
    toast.success('Message sent successfully!');
    contactForm.value = { name: '', email: '', phone: '', message: '' };
  } catch { toast.error('Failed to send message.'); }
  finally { contactFormSubmitting.value = false; }
}

function toggleFaq(index: number) { openFaqIndex.value = openFaqIndex.value === index ? null : index; }

function formatDate(dateStr: string) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
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

onMounted(async () => {
  await Promise.all([fetchHomeData(), fetchFaqs()]);
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

.trusted-swiper :deep(.swiper-wrapper) { transition-timing-function: linear !important; }
</style>
