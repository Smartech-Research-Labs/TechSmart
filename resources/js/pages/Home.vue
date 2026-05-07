<template>
  <PublicLayout>
 <!-- ═══════════════ HERO + COUNTER WRAPPER ═══════════════ -->
<div class="relative overflow-hidden">

  <!-- Shared background layer — stretches behind both hero AND counter -->
  <div class="absolute inset-0 z-0">
    <img
      v-if="heroSlides.length"
      :src="heroSlides[currentHeroSlide]?.bg_image"
      :alt="heroSlides[currentHeroSlide]?.title"
      class="w-full h-full object-cover"
    />
    <div class="absolute inset-0 bg-black/60"></div>
  </div>

  <!-- ═══════════════ HERO SECTION ═══════════════ -->
  <section class="relative min-h-[60vh] md:min-h-[70vh] flex items-center">
    <Swiper
      :modules="[Autoplay, Pagination]"
      :slides-per-view="1"
      :autoplay="heroAutoplay"
      :pagination="heroPagination"
      :loop="true"
      class="hero-swiper w-full h-full"
      @slide-change="(swiper) => currentHeroSlide = swiper.realIndex"
    >
      <SwiperSlide v-for="slide in heroSlides" :key="slide.id">
        <div class="relative w-full min-h-[60vh] md:min-h-[70vh] flex items-center">
          <!-- Content -->
          <div class="relative z-10 w-full">
            <div class="container mx-auto px-6 py-12 md:py-16">
              <div class="max-w-2xl">
                <p class="text-primary font-semibold text-xs tracking-widest uppercase mb-3">{{ slide.subtitle }}</p>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight text-white mb-6">{{ slide.title }}</h1>
                <p class="text-white/90 text-base leading-relaxed mb-8 max-w-lg">{{ slide.description }}</p>
                <div class="flex flex-wrap gap-4">
                  <router-link :to="slide.cta_link" class="inline-flex items-center gap-2 px-8 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                    {{ slide.cta_text }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                  </router-link>
                  <router-link v-if="slide.cta_text_2" :to="slide.cta_link_2" class="px-8 py-3 border-2 border-white text-sm font-semibold rounded-full hover:bg-white/10 transition-all" style="color: #fff;">{{ slide.cta_text_2 }}</router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </SwiperSlide>
    </Swiper>
  </section>

  <!-- ═══════════════ COUNTER BAR ═══════════════ -->
  <section class="relative z-10 py-6 md:py-8" style="border-top: 1px solid rgba(255,255,255,0.12);">
    <div class="container mx-auto px-6 max-w-5xl">
      <div class="flex flex-wrap justify-between items-center gap-8">
        <div v-for="counter in countersFinal" :key="counter.id" class="flex-1 min-w-[140px] text-center">
          <div class="text-2xl md:text-3xl font-bold text-white mb-2">
            <span ref="counterRefs" :data-target="counter.number || counter.value" :data-suffix="counter.suffix || '+'">0</span>
          </div>
          <div class="text-white/80 text-xs font-semibold tracking-wide">{{ counter.label || counter.title }}</div>
        </div>
      </div>
    </div>
  </section>

</div>

    <!-- Trusted By -->
    <section class="py-12 border-y border-border bg-muted/30">
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
    <section class="py-12 md:py-16">
      <div class="container mx-auto px-6 max-w-5xl">
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
            <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight mb-4">Your Trusted Technology Partner</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">OmniviaTech is a leading technology company dedicated to empowering businesses with innovative digital solutions. We combine deep technical expertise with a passion for solving real-world challenges.</p>
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
    <section class="py-12 md:py-16" style="background-color: #262626;">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-white text-xs font-semibold tracking-widest uppercase mb-3">Solutions</p>
          <h2 class="text-xl md:text-2xl font-bold text-white leading-tight">Our Solutions</h2>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="grid grid-cols-2 md:grid-cols-4 gap-5">
          <div v-for="i in 8" :key="i" class="bg-white/10 border border-white/20 rounded-2xl overflow-hidden animate-pulse">
            <div class="aspect-[4/3] bg-white/5"></div>
            <div class="p-5 space-y-2">
              <div class="h-3 bg-white/10 rounded w-3/4"></div>
              <div class="h-2 bg-white/10 rounded w-full"></div>
            </div>
          </div>
        </div>

        <!-- Services from API -->
        <template v-else-if="allServices.length">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            <router-link v-for="service in allServices.slice(0, 8)" :key="service.id" :to="`/services/${service.slug}`" class="group block bg-white/10 border border-white/20 rounded-2xl overflow-hidden hover:border-white/40 hover:shadow-md transition-all duration-300">
              <div class="aspect-[4/3] bg-white/5 overflow-hidden relative">
                <img v-if="getServiceImage(service)" :src="getServiceImage(service)" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div v-else-if="service.image_url" class="w-full h-full overflow-hidden">
                  <img :src="service.image_url" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </div>
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-white/10 to-white/5">
                  <span class="text-3xl">{{ service.icon || '💡' }}</span>
                </div>
              </div>
              <div class="p-5">
                <h3 class="text-sm font-semibold text-white mb-2 group-hover:text-white/95 transition-colors line-clamp-2">{{ service.title }}</h3>
                <p class="text-white/75 text-xs leading-relaxed line-clamp-2 mb-3">{{ service.excerpt || service.short_description }}</p>
                <span class="text-white/90 font-medium text-xs flex items-center gap-1 group-hover:gap-2 transition-all">
                  Learn More <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
                </span>
              </div>
            </router-link>
          </div>
        </template>

        <!-- Fallback: Static Featured Services -->
        <template v-else>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            <router-link v-for="service in featuredServices" :key="service.id" :to="`/services/${service.slug}`" class="group block bg-white/10 border border-white/20 rounded-2xl overflow-hidden hover:border-white/40 hover:shadow-md transition-all duration-300">
              <div class="aspect-[4/3] bg-white/5 overflow-hidden relative">
                <img :src="service.image" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              </div>
              <div class="p-5">
                <h3 class="text-sm font-semibold text-white mb-2 group-hover:text-white/95 transition-colors line-clamp-2">{{ service.title }}</h3>
                <p class="text-white/75 text-xs leading-relaxed line-clamp-2 mb-3">{{ service.excerpt }}</p>
                <span class="text-white/90 font-medium text-xs flex items-center gap-1 group-hover:gap-2 transition-all">
                  Learn More <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
                </span>
              </div>
            </router-link>
          </div>
        </template>

        <div class="text-center mt-10">
          <router-link to="/services" class="inline-flex items-center gap-2 px-7 py-3 border-2 border-white text-white text-sm font-semibold rounded-full hover:bg-white hover:text-gray-900 transition-all">
            View All Services
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>


    <!-- ═══════════════ CTA (WHITE BACKGROUND, FULL WIDTH) ═══════════════ -->
  <section class="py-14 md:py-20 w-full bg-white">
    <div class="w-full px-0">
      
      <div class="relative w-full overflow-hidden bg-white">
        
        <!-- Soft background accent (optional visual depth) -->
        <div class="absolute inset-0 opacity-10 bg-cover bg-white"></div>

        <div class="relative grid lg:grid-cols-2 items-center">

          <!-- TEXT SIDE -->
          <div class="p-8 md:p-12 lg:p-16">
            
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight mb-4">
              Join Our Growing Team
            </h2>

            <p class="text-gray-600 text-sm leading-relaxed mb-8 max-w-md">
              We're always looking for talented people who are passionate about technology and innovation.
            </p>

            <router-link 
              to="/contact" 
              class="inline-flex items-center gap-2 px-7 py-3 bg-black text-white text-sm font-semibold rounded-full hover:bg-gray-900 transition-all shadow-md"
            >
              Get In Touch
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M7 17L17 7M17 7H7M17 7v10"/>
              </svg>
            </router-link>

          </div>

          <!-- IMAGE SIDE -->
          <div class="hidden lg:flex items-end rounded-xl justify-end h-full min-h-[200px] bg-gray-50">
            <img 
              :src="heroTech4" 
              alt="Professional" 
              class="h-full max-h-[380px] object-cover object-top w-full"
            />
          </div>

        </div>
      </div>

    </div>
  </section>

  
    <!-- ═══════════════ WE SPECIALIZE IN ═══════════════ -->
    <section class="py-12 md:py-16" style="background-color: #262626;">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-white text-xs font-semibold tracking-widest uppercase mb-3">What We Do</p>
          <h2 class="text-xl md:text-2xl font-bold text-white leading-tight">We Specialize In</h2>
          <p class="text-white/80 text-sm leading-relaxed">End-to-end technology and digital solutions designed to help your business thrive in the modern economy.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <router-link v-for="(spec, i) in specializations" :key="i" :to="`/specializations/${spec.title.toLowerCase().replace(/\\s+/g, '-')}`" class="relative bg-white/10 border border-white/20 rounded-2xl p-6 text-center hover:border-white/40 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group overflow-hidden cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-white/2 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10">
              <div class="w-14 h-14 mx-auto bg-white/15 rounded-xl flex items-center justify-center mb-4 group-hover:bg-white/25 transition-all duration-300 shadow-sm">
                <span class="text-2xl">{{ spec.icon }}</span>
              </div>
              <h3 class="text-sm font-bold text-white mb-2 group-hover:text-white/90 transition-colors">{{ spec.title }}</h3>
              <p class="text-white/75 text-xs leading-relaxed">{{ spec.desc }}</p>
            </div>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ INDUSTRIES WE SERVE ═══════════════ -->
    <section class="py-12 md:py-16 bg-muted/20">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Industries</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight">Industries We Serve</h2>
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
            <router-link :to="`/industries#${industry.title.toLowerCase()}`" class="group block bg-white border border-border rounded-xl overflow-hidden hover:border-accent/40 hover:shadow-md transition-all duration-300 h-full">
              <div class="aspect-video bg-gray-100 overflow-hidden">
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
            View All Industries
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ SERVICES CAROUSEL ═══════════════ -->
    <section v-if="allServices.length || featuredServices.length" class="py-12 md:py-16" style="background-color: #262626;">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-white text-xs font-semibold tracking-widest uppercase mb-3">Our Services</p>
          <h2 class="text-xl md:text-2xl font-bold text-white leading-tight">Services That Drive Growth</h2>
        </div>

        <Swiper
          :modules="[Autoplay, Navigation]"
          :slides-per-view="1"
          :space-between="20"
          :navigation="servicesNavigation"
          :autoplay="servicesAutoplay"
          :breakpoints="servicesBreakpoints"
          class="cards-swiper"
        >
          <SwiperSlide v-for="service in (allServices.length ? allServices.slice(0, 8) : featuredServices)" :key="service.id">
            <router-link :to="`/services/${service.slug}`" class="group block bg-white/10 rounded-2xl overflow-hidden border border-white/20 hover:border-white/40 hover:shadow-md transition-all duration-300">
              <div class="aspect-[4/3] bg-white/5 overflow-hidden relative">
                <img v-if="service.image_url || service.image" :src="service.image_url || service.image" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-white/10 to-white/5">
                  <span class="text-3xl">{{ service.icon || '💡' }}</span>
                </div>
                <div class="absolute top-3 right-3 z-10">
                  <WishlistButton type="App\\Models\\Service" :item-id="service.id" />
                </div>
              </div>
              <div class="p-5">
                <h3 class="text-sm font-semibold text-white mb-2 group-hover:text-white/95 transition-colors line-clamp-2">{{ service.title }}</h3>
                <p class="text-white/75 text-xs leading-relaxed line-clamp-2 mb-3">{{ service.excerpt || service.short_description }}</p>
                <div class="flex items-center justify-end">
                  <span class="text-white/90 font-medium text-xs flex items-center gap-1 group-hover:gap-2 transition-all">
                    Learn More <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
                  </span>
                </div>
              </div>
            </router-link>
          </SwiperSlide>
        </Swiper>
      </div>
  </section>

       <!-- ═══════════════ POPULATION IMPACTED ═══════════════ -->
    <section class="py-12 md:py-16">
      <div class="container mx-auto px-6 max-w-5xl">

        <!-- Header -->
        <div class="text-center mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Global Impact</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight">Population Impacted</h2>
        </div>

        <!-- Two-column grid -->
        <div class="grid lg:grid-cols-2 gap-8 items-stretch">

          <!-- ── LEFT: population.png image ── -->
          <div class="relative rounded-2xl overflow-hidden min-h-[420px]">
            <img
              :src="settings.population_image || '/images/population.png'"
              alt="Global population impacted by OmniviaTech"
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
                :navigation="impactSliderNavigation"
                :autoplay="impactSliderAutoplay"
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
            class="bg-white border border-border rounded-xl p-5 text-center hover:shadow-md hover:border-primary/20 transition-all"
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

    <!-- ═══════════════ CTA SECTION (VIDEO BACKGROUND) ═══════════════ --> 
    <!-- <section class="w-full min-h-[600px] relative"> -->

      <!-- VIDEO BACKGROUND -->
      <!-- <video 
        autoplay 
        muted 
        loop 
        playsinline 
        class="absolute inset-0 w-full h-[400px] object-contain"
      >
        <source :src="videoCTA" type="video/mp4" />
      </video> -->
      
      <!-- OVERLAY -->
      <!-- <div class="absolute inset-0 bg-black/60"></div> -->

      <!-- STATIC CENTERED CONTENT -->
      <!--
      <div class="absolute inset-0 z-10 flex flex-col justify-center items-center text-center px-6 md:px-0">
        
        <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4 max-w-3xl">
          View What We Have to Offer Your Business
        </h1>

        <p class="text-white/70 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
          Explore digital solutions tailored to help your business grow, improve efficiency, and strengthen your online presence.
        </p>

        <a 
          href="#" 
          class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-all shadow-lg"
        >
          Explore Services
        </a>

      </div>
      -->

    <!-- </section> -->

       <!-- ═══════════════ CTA SECTION (FIXED IMAGE BACKGROUND) ═══════════════ --> 
    <section class="w-full min-h-[600px] relative">
      <div 
        class="relative min-h-[540px] text-white overflow-hidden bg-fixed bg-cover bg-center"
        :style="{ backgroundImage: 'url(' + heroCTAbg + ')' }"
      >
        
        <div class="absolute inset-0 bg-black/60"></div>
        
        <!-- STATIC CENTERED CONTENT -->
        <div class="absolute inset-0 z-10 flex flex-col justify-center items-center text-center px-6 md:px-0">
          
          <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4 max-w-3xl">
            View What We Have to Offer Your Business
          </h1>

          <p class="text-white/70 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
            Explore digital solutions tailored to help your business grow, improve efficiency, and strengthen your online presence.
          </p>

          <a 
            href="#" 
            class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-all shadow-lg"
          >
            Explore Services
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path d="M7 17L17 7M17 7H7M17 7v10"/>
            </svg>
          </a>

        </div>

      </div>
    </section>

    <!-- ═══════════════ TECH STACK ═══════════════ -->
    <section class="py-12 md:py-16 bg-muted/20">
      <div class="container mx-auto px-6 max-w-5xl">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Toolkit</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight mb-3">
            Technologies We Work With
          </h2>
          <p class="text-muted-foreground text-sm leading-relaxed">
            We use battle-tested, modern tools to build solutions that are fast, scalable, and maintainable.
          </p>
        </div>

        <!-- Stack tabs -->
        <div class="flex flex-wrap justify-center gap-2 mb-8">
          <button
            v-for="cat in stackCategories"
            :key="cat.label"
            @click="activeStack = cat.label"
            class="px-4 py-1.5 rounded-full text-xs font-semibold border transition-all duration-200"
            :class="activeStack === cat.label
              ? 'bg-primary text-white border-primary shadow-sm shadow-primary/20'
              : 'border-border text-muted-foreground hover:border-primary/40 hover:text-primary'"
          >
            {{ cat.label }}
          </button>
        </div>

        <!-- Tech grid -->
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
          <div
            v-for="tech in activeStackTechs"
            :key="tech.name"
            class="group flex flex-col items-center gap-2 p-4 rounded-xl border border-border bg-card hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 cursor-default"
          >
            <!-- Icon / Logo -->
            <div class="w-10 h-10 flex items-center justify-center text-2xl shrink-0">
              <span v-html="tech.icon"></span>
            </div>
            <span class="text-[11px] font-semibold text-foreground text-center leading-tight group-hover:text-primary transition-colors">
              {{ tech.name }}
            </span>
          </div>
        </div>

        <!-- Bottom note -->
        <p class="text-center text-muted-foreground text-xs mt-8">
          Don't see your stack?
          <router-link to="/contact" class="text-primary font-semibold hover:underline underline-offset-2">
            Talk to us — we adapt.
          </router-link>
        </p>

      </div>
    </section>


 

    <!-- ═══════════════ PROCESS ═══════════════ -->
    <section class="py-12 md:py-16" style="background-color: #262626;">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Process</p>
          <h2 class="text-xl md:text-2xl font-bold text-white">How we bring your ideas to life</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="(step, idx) in processSteps" :key="idx" class="relative group">
            <!-- Arrow Indicator -->
            <div class="absolute top-8 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 z-20">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </div>

            <!-- Card -->
            <div class="relative rounded-2xl p-8 transition-all duration-300 overflow-hidden h-full shadow-lg hover:shadow-2xl transform group-hover:-translate-y-2" style="background-color: #ffffff; border: 1px solid #404040;" @mouseenter="setCardBorderColor($event, '#3b82f6')" @mouseleave="setCardBorderColor($event, '#404040')">
              <!-- Animated background gradient -->
              <div class="absolute inset-0 opacity-0 group-hover:opacity-20 bg-gradient-to-br from-primary/20 to-primary/10 transition-opacity duration-500"></div>
              
              <!-- Decorative element -->
              <div class="absolute -top-6 -right-6 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-150 group-hover:bg-primary/10 transition-all duration-500"></div>

              <!-- Content -->
              <div class="relative z-10 text-center">
                <!-- Number Circle -->
                <div class="w-16 h-16 bg-gradient-to-br from-primary/30 to-primary/20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:from-primary/50 group-hover:to-primary/30 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <span class="text-3xl font-bold text-primary">{{ idx + 1 }}</span>
                </div>

                <!-- Title & Description -->
                <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors">{{ step.title }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed group-hover:text-gray-900 transition-colors">{{ step.description }}</p>
              </div>

              <!-- Connector line (desktop only) -->
              <div v-if="idx < processSteps.length - 1" class="hidden lg:block absolute top-1/2 -right-3 w-6 h-px bg-[#d311f5] to-transparent -translate-y-1/2"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

   <!-- ═══════════════ MISSION & VISION ═══════════════ -->
  <section class="py-12 md:py-16" style="background-color: #ffffff;">
    <div class="container mx-auto px-6 max-w-5xl">
 
      <!-- Header -->
      <div class="text-center max-w-2xl mx-auto mb-12">
        <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Purpose</p>
        <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">Mission & Vision</h2>
        <p class="text-gray-600 text-sm leading-relaxed mt-3">
          The principles that shape every decision we make, and the future we are building toward.
        </p>
      </div>
 
      <!-- Two cards side by side -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 
        <!-- Mission Card -->
        <div class="relative group rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
             style="background-color: #d311f5; border: 1px solid #d311f5;"
             @mouseenter="setCardBorderColor($event, '#3b82f6')"
             @mouseleave="setCardBorderColor($event, '#404040')">
 
          <!-- Animated background gradient on hover -->
          <div class="absolute inset-0 opacity-0 group-hover:opacity-20 bg-gradient-to-br from-primary/20 to-primary/10 transition-opacity duration-500 pointer-events-none"></div>
 
          <!-- Decorative circle -->
          <div class="absolute -top-8 -right-8 w-32 h-32 bg-primary/5 rounded-full group-hover:scale-150 group-hover:bg-primary/10 transition-all duration-500 pointer-events-none"></div>
 
          <!-- Top accent bar -->
          <div class="h-1 w-full bg-gradient-to-r from-primary to-primary/40"></div>
 
          <div class="relative z-10 p-8">
            <!-- Icon -->
            <div class="w-14 h-14 bg-[#ffffff] rounded-xl flex items-center justify-center mb-6 group-hover:from-primary/50 group-hover:to-primary/30 group-hover:scale-110 transition-all duration-300 shadow-md">
              <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
 
            <h3 class="text-lg font-bold text-white mb-3 group-hover:text-[#ffffff] transition-colors">Our Mission</h3>
 
            <p class="text-white/80 text-sm leading-relaxed mb-6">
              To empower businesses across Africa and beyond with innovative, scalable, and reliable technology solutions that drive measurable growth, improve operational efficiency, and create lasting impact in the communities we serve.
            </p>
 
            <!-- Mission pillars -->
            <ul class="space-y-3">
              <li v-for="pillar in missionPillars" :key="pillar" class="flex items-start gap-3">
                <div class="w-5 h-5 bg-[#ffffff] rounded-full flex items-center justify-center shrink-0 mt-0.5">
                  <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <span class="text-white/75 text-xs leading-relaxed">{{ pillar }}</span>
              </li>
            </ul>
          </div>
        </div>
 
        <!-- Vision Card -->
        <div class="relative group rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
             style="background-color: #3b82f6; border: 1px solid #3b82f6;"
             @mouseenter="setCardBorderColor($event, '#3b82f6')"
             @mouseleave="setCardBorderColor($event, '#404040')">
 
          <div class="absolute inset-0 opacity-0 group-hover:opacity-20 bg-gradient-to-br from-accent/20 to-accent/10 transition-opacity duration-500 pointer-events-none"></div>
          <div class="absolute -top-8 -right-8 w-32 h-32 bg-accent/5 rounded-full group-hover:scale-150 group-hover:bg-accent/10 transition-all duration-500 pointer-events-none"></div>
 
          <!-- Top accent bar (accent color) -->
          <div class="h-1 w-full bg-gradient-to-r from-accent to-accent/40"></div>
 
          <div class="relative z-10 p-8">
            <!-- Icon -->
            <div class="w-14 h-14 bg-[#ffffff] rounded-xl flex items-center justify-center mb-6 group-hover:from-accent/50 group-hover:to-accent/30 group-hover:scale-110 transition-all duration-300 shadow-md">
              <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </div>
 
            <h3 class="text-lg font-bold text-white mb-3 group-hover:text-[#ffffff] transition-colors">Our Vision</h3>
 
            <p class="text-white/80 text-sm leading-relaxed mb-6">
              To be Africa's most trusted technology partner — a company recognised globally for building transformative digital infrastructure that bridges the gap between ambition and achievement for businesses of every size.
            </p>
 
            <!-- Vision horizons -->
            <div class="space-y-4">
              <div v-for="horizon in visionHorizons" :key="horizon.label" class="flex items-start gap-3">
                <div class="shrink-0 mt-0.5">
                  <span class="inline-block text-xs font-bold text-accent bg-[#ffffff] px-2 py-0.5 rounded-full">{{ horizon.label }}</span>
                </div>
                <span class="text-white/75 text-xs leading-relaxed">{{ horizon.text }}</span>
              </div>
            </div>
          </div>
        </div>
 
      </div>
 
      <!-- Bottom values strip -->
      <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div v-for="val in missionValues" :key="val.label"
             class="text-center px-4 py-5 rounded-xl transition-all duration-200 hover:-translate-y-0.5"
             style="background-color: #1a1a1a; border: 1px solid #404040;">
          <div class="text-2xl mb-2">{{ val.icon }}</div>
          <div class="text-white font-semibold text-xs mb-1">{{ val.label }}</div>
          <div class="text-white/55 text-xs leading-snug">{{ val.desc }}</div>
        </div>
      </div>
 
    </div>
  </section>

      <!-- ═══════════════ CTA (FULL WIDTH, NO RADIUS) ═══════════════ -->
  <section class="py-14 md:py-20 w-full">
    <div class="w-full px-0">
      <div class="relative bg-black w-full overflow-hidden">
        
        <div class="absolute inset-0 opacity-30 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
        <div class="absolute inset-0 bg-black/70"></div>

        <div class="relative grid lg:grid-cols-2 items-center">
          
          <div class="p-8 md:p-12 lg:p-14">
            <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">
              Join Our Growing Team
            </h2>

            <p class="text-white/70 text-sm leading-relaxed mb-8">
              We're always looking for talented people who are passionate about technology and innovation.
            </p>

            <router-link 
              to="/contact" 
              class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-all shadow-lg"
            >
              Get In Touch
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M7 17L17 7M17 7H7M17 7v10"/>
              </svg>
            </router-link>
          </div>

          <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
            <img :src="heroTech4" alt="Professional" class="h-full max-h-[350px] object-cover object-top w-full" />
          </div>

        </div>
      </div>
    </div>
  </section>
   
   

    

     <!-- ═══════════════ WHY CHOOSE US ═══════════════ -->
    <section class="py-12 md:py-16">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Us</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground">Why OmniviaTech?</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="(reason, i) in whyUsReasons" :key="i" class="relative group">
            <!-- Card with Arrow -->
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 z-20">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </div>
            <!-- Card -->
              <div class="relative rounded-2xl p-7 transition-all duration-300 overflow-hidden h-full shadow-lg hover:shadow-2xl transform group-hover:-translate-y-2" style="background-color: #262626; border: 1px solid #404040;" @mouseenter="setCardBorderColor($event, '#3b82f6')" @mouseleave="setCardBorderColor($event, '#404040')">              <!-- Animated background gradient -->
              <div class="absolute inset-0 opacity-0 group-hover:opacity-20 bg-gradient-to-br from-primary/20 to-primary/10 transition-opacity duration-500"></div>
              
              <!-- Decorative element -->
              <div class="absolute -top-6 -right-6 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-150 group-hover:bg-primary/10 transition-all duration-500"></div>
              
              <!-- Content -->
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

       <!-- ═══════════════ CTA SECTION (FIXED IMAGE BACKGROUND) ═══════════════ --> 
    <section class="w-full min-h-[600px] relative">
      <div 
        class="relative min-h-[540px] text-white overflow-hidden bg-fixed bg-cover bg-center"
        :style="{ backgroundImage: 'url(' + heroCTAbg + ')' }"
      >
        
        <div class="absolute inset-0 bg-black/60"></div>
        
        <!-- STATIC CENTERED CONTENT -->
        <div class="absolute inset-0 z-10 flex flex-col justify-center items-center text-center px-6 md:px-0">
          
          <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4 max-w-3xl">
            View What We Have to Offer Your Business
          </h1>

          <p class="text-white/70 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
            Explore digital solutions tailored to help your business grow, improve efficiency, and strengthen your online presence.
          </p>

          <a 
            href="#" 
            class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-all shadow-lg"
          >
            Explore Services
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path d="M7 17L17 7M17 7H7M17 7v10"/>
            </svg>
          </a>

        </div>

      </div>
    </section>

    <!-- ═══════════════ PRODUCTS CAROUSEL ═══════════════ -->
    <section v-if="products.length" class="py-12 md:py-16 bg-muted/20">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Our Products</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight">Featured Products</h2>
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
            <router-link :to="`/products/${product.slug}`" class="group block bg-white rounded-2xl overflow-hidden border border-border hover:border-accent/20 hover:shadow-md transition-all duration-300">
              <div class="aspect-[4/3] bg-gray-100 overflow-hidden relative">
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

         <!-- ═══════════════ CTA (FULL WIDTH, NO RADIUS) ═══════════════ -->
  <section class="py-14 md:py-20 w-full">
    <div class="w-full px-0">
      <div class="relative bg-black w-full overflow-hidden">
        
        <div class="absolute inset-0 opacity-30 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
        <div class="absolute inset-0 bg-black/70"></div>

        <div class="relative grid lg:grid-cols-2 items-center">
          
          <div class="p-8 md:p-12 lg:p-14">
            <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">
              Join Our Growing Team
            </h2>

            <p class="text-white/70 text-sm leading-relaxed mb-8">
              We're always looking for talented people who are passionate about technology and innovation.
            </p>

            <router-link 
              to="/contact" 
              class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-all shadow-lg"
            >
              Get In Touch
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M7 17L17 7M17 7H7M17 7v10"/>
              </svg>
            </router-link>
          </div>

          <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
            <img :src="heroTech4" alt="Professional" class="h-full max-h-[350px] object-cover object-top w-full" />
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
          <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight mb-3">What Our Clients Say</h2>
          <p class="text-muted-foreground text-xs leading-relaxed">Trusted by businesses across Africa and beyond.</p>
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

    <!-- ═══════════════ CTA SECTION (FIXED IMAGE BACKGROUND) ═══════════════ --> 
    <section class="w-full min-h-[600px] relative">
      <div 
        class="relative min-h-[540px] text-white overflow-hidden bg-fixed bg-cover bg-center"
        :style="{ backgroundImage: 'url(' + heroTechBg + ')' }"
      >
        
        <div class="absolute inset-0 bg-black/60"></div>
        
        <!-- STATIC CENTERED CONTENT -->
        <div class="absolute inset-0 z-10 flex flex-col justify-center items-center text-center px-6 md:px-0">
          
          <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4 max-w-3xl">
            View What We Have to Offer Your Business
          </h1>

          <p class="text-white/70 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
            Explore digital solutions tailored to help your business grow, improve efficiency, and strengthen your online presence.
          </p>

          <a 
            href="#" 
            class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-all shadow-lg"
          >
            Explore Services
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path d="M7 17L17 7M17 7H7M17 7v10"/>
            </svg>
          </a>

        </div>

      </div>
    </section>

       <!-- ═══════════════ SECURITY & COMPLIANCE ═══════════════ -->
  <section class="py-12 md:py-16 bg-muted/20">
    <div class="container mx-auto px-6 max-w-5xl">
 
      <!-- Header -->
      <div class="text-center max-w-2xl mx-auto mb-12">
        <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Enterprise Ready</p>
        <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight">Security & Compliance</h2>
        <p class="text-muted-foreground text-sm leading-relaxed mt-3">
          Built with enterprise-grade security at every layer. Your data stays protected, your operations stay compliant.
        </p>
      </div>
 
      <!-- Top row: Uptime SLA hero + certifications grid -->
      <div class="grid lg:grid-cols-3 gap-6 mb-6">
 
        <!-- SLA / Uptime Hero Card -->
        <div class="lg:col-span-1 relative rounded-2xl overflow-hidden flex flex-col justify-between min-h-[240px]"
             style="background-color: #0f172a; border: 1px solid #1e3a5f;">
          <!-- subtle grid background -->
          <div class="absolute inset-0 opacity-10"
               style="background-image: linear-gradient(rgba(59,130,246,0.4) 1px, transparent 1px), linear-gradient(90deg, rgba(59,130,246,0.4) 1px, transparent 1px); background-size: 28px 28px;"></div>
 
          <div class="relative z-10 p-7 flex flex-col h-full justify-between">
            <div>
              <div class="flex items-center gap-2 mb-4">
                <div class="w-2.5 h-2.5 rounded-full bg-green-400 animate-pulse"></div>
                <span class="text-green-400 text-xs font-semibold tracking-wide uppercase">All Systems Operational</span>
              </div>
              <div class="text-5xl font-bold text-white mb-1">99.9<span class="text-primary text-3xl">%</span></div>
              <div class="text-white/60 text-xs mb-5">Guaranteed Uptime SLA</div>
            </div>
            <div class="space-y-2">
              <div v-for="sla in upTimeMetrics" :key="sla.label" class="flex items-center justify-between">
                <span class="text-white/60 text-xs">{{ sla.label }}</span>
                <span class="text-white text-xs font-semibold">{{ sla.value }}</span>
              </div>
            </div>
          </div>
        </div>
 
        <!-- Certifications grid -->
        <div class="lg:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-4">
          <div v-for="cert in certifications" :key="cert.name"
               class="group relative rounded-xl p-5 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md bg-white border border-border"
               :class="cert.highlight ? 'border-primary/30' : ''">
            <!-- Badge glow on hover -->
            <div class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                 style="box-shadow: inset 0 0 0 1px rgba(59,130,246,0.3);"></div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 transition-transform duration-300 group-hover:scale-110"
                 :style="{ backgroundColor: cert.bgColor }">
              <svg class="w-6 h-6" :class="cert.iconColor" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path :d="cert.iconPath" />
              </svg>
            </div>
            <div class="text-foreground font-bold text-sm mb-0.5">{{ cert.name }}</div>
            <div class="text-muted-foreground text-xs leading-snug">{{ cert.desc }}</div>
            <div v-if="cert.badge" class="mt-2 text-xs font-semibold px-2 py-0.5 rounded-full"
                 style="background-color: rgba(34,197,94,0.1); color: #16a34a;">{{ cert.badge }}</div>
          </div>
        </div>
      </div>
 
      <!-- Security practices row -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div v-for="(practice, idx) in securityPractices" :key="idx"
             class="group relative rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl overflow-hidden"
             style="background-color: #262626; border: 1px solid #404040;"
             @mouseenter="setCardBorderColor($event, '#3b82f6')"
             @mouseleave="setCardBorderColor($event, '#404040')">
 
          <div class="absolute inset-0 opacity-0 group-hover:opacity-15 bg-gradient-to-br from-primary/20 to-primary/10 transition-opacity duration-500 pointer-events-none"></div>
          <div class="absolute -top-4 -right-4 w-16 h-16 bg-primary/5 rounded-full group-hover:scale-150 transition-all duration-500 pointer-events-none"></div>
 
          <div class="relative z-10">
            <div class="w-11 h-11 bg-gradient-to-br from-primary/30 to-primary/20 rounded-xl flex items-center justify-center mb-4 group-hover:from-primary/50 group-hover:to-primary/30 group-hover:scale-110 transition-all duration-300">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path :d="practice.icon" />
              </svg>
            </div>
            <h3 class="text-sm font-bold text-white mb-2 group-hover:text-primary transition-colors">{{ practice.title }}</h3>
            <p class="text-white/70 text-xs leading-relaxed">{{ practice.desc }}</p>
          </div>
        </div>
      </div>
 
      <!-- GDPR / Privacy / Data strip -->
      <div class="rounded-2xl overflow-hidden" style="background-color: #1a1a1a; border: 1px solid #2d2d2d;">
        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x" style="border-color: #2d2d2d;">
          <div v-for="(policy, idx) in privacyPolicies" :key="idx" class="group flex items-start gap-4 p-6 hover:bg-white/5 transition-colors duration-200">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 transition-all duration-300 group-hover:scale-110"
                 :style="{ backgroundColor: policy.bgColor }">
              <svg class="w-5 h-5" :class="policy.iconColor" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path :d="policy.icon" />
              </svg>
            </div>
            <div>
              <div class="text-white text-sm font-semibold mb-1 group-hover:text-primary transition-colors">{{ policy.title }}</div>
              <div class="text-white/60 text-xs leading-relaxed">{{ policy.desc }}</div>
            </div>
          </div>
        </div>
      </div>
 
      <!-- Bottom CTA -->
      <div class="text-center mt-10">
        <p class="text-muted-foreground text-xs mb-4">Need a detailed security briefing or compliance documentation?</p>
        <router-link to="/contact"
          class="inline-flex items-center gap-2 px-7 py-3 border border-primary text-primary text-sm font-semibold rounded-full hover:bg-primary hover:text-white transition-all">
          Request Security Briefing
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
        </router-link>
      </div>
 
    </div>
  </section>

    <!-- ═══════════════ CTA — VIDEO + COPY ═══════════════ -->
<section class="py-12 md:py-16" style="background-color: #ffffff;">
  <div class="container mx-auto px-6 max-w-8xl">

    <h2 class="sr-only">Call to action section with auto-playing video on the left and a description on the right</h2>

    <div class="cta-wrap">

      <div class="video-side">
        <video autoplay muted loop playsinline>
          <source :src="videoCTA" type="video/mp4" />
          Your browser does not support the video tag.
        </video>
        <div class="video-overlay"></div>
        <!-- <div class="live-badge">
          <div class="live-dot"></div>
          <span class="live-text">Live demo</span>
        </div> -->
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

        <div class="trust-row">
          <div class="trust-stat">
            <div class="num">200+</div>
            <div class="lbl">Projects delivered</div>
          </div>
          <div class="trust-sep"></div>
          <div class="trust-stat">
            <div class="num">30+</div>
            <div class="lbl">Countries reached</div>
          </div>
          <div class="trust-sep"></div>
          <div class="trust-stat">
            <div class="num">10 yrs</div>
            <div class="lbl">Of excellence</div>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>


     



     <!-- ═══════════════ CORE VALUES ═══════════════ -->
    <section class="py-12 md:py-16">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-2">Our Foundation</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight mb-3">Our Core Values</h2>
          <p class="text-muted-foreground text-xs leading-relaxed max-w-2xl mx-auto">These principles guide every decision we make and every solution we deliver.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
          <div v-for="(value, i) in coreValues" :key="i" class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-br from-primary/20 to-primary/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
            <div class="relative rounded-lg p-6 transition-all duration-300 h-full flex flex-col transform group-hover:-translate-y-1 shadow-md hover:shadow-lg" style="background-color: #262626; border: 1px solid rgba(79, 124, 192, 0.2);">
              <div class="w-12 h-12 shrink-0 rounded-lg flex items-center justify-center text-xl mb-4 bg-gradient-to-br from-primary/30 to-primary/20 group-hover:from-primary/50 group-hover:to-primary/30">
                {{ value.icon }}
              </div>
              <h3 class="text-base font-bold text-white mb-3 group-hover:text-primary transition-colors">{{ value.title }}</h3>
              <p class="text-white/75 text-sm leading-relaxed flex-1">{{ value.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

 



    <!-- ═══════════════ CTA (FULL WIDTH, NO RADIUS) ═══════════════ -->
  <section class="py-14 md:py-20 w-full">
    <div class="w-full px-0">
      <div class="relative bg-black w-full overflow-hidden">
        
        <div class="absolute inset-0 opacity-30 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
        <div class="absolute inset-0 bg-black/70"></div>

        <div class="relative grid lg:grid-cols-2 items-center">
          
          <div class="p-8 md:p-12 lg:p-14">
            <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">
              Join Our Growing Team
            </h2>

            <p class="text-white/70 text-sm leading-relaxed mb-8">
              We're always looking for talented people who are passionate about technology and innovation.
            </p>

            <router-link 
              to="/contact" 
              class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-all shadow-lg"
            >
              Get In Touch
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M7 17L17 7M17 7H7M17 7v10"/>
              </svg>
            </router-link>
          </div>

          <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
            <img :src="heroTech4" alt="Professional" class="h-full max-h-[350px] object-cover object-top w-full" />
          </div>

        </div>
      </div>
    </div>
  </section>

      <!-- ═══════════════ TRUSTED BY (SPLIT LAYOUT) ═══════════════ -->
    <section class="py-12 md:py-16 bg-muted/20">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
          <!-- Left: Copy -->
          <div class="lg:col-span-4 lg:sticky lg:top-28">
            <h2 class="text-2xl md:text-3xl font-bold text-primary leading-tight mb-5">Trusted By</h2>
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
    <section class="py-12 md:py-16" style="background-color: #262626;">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Get Started</p>
          <h2 class="text-xl md:text-2xl font-bold text-white leading-tight mb-3">Request a Quote</h2>
          <p class="text-white/75 text-sm leading-relaxed">Tell us about your project and we'll get back to you within 24 hours.</p>
        </div>
      </div>
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
          <!-- Left - Form -->
          <div>
            <form @submit.prevent="submitQuoteRequest" class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <input v-model="quoteForm.name" type="text" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all placeholder-white" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all placeholder-white" placeholder="Email *" />
              </div>
              <div class="grid grid-cols-2 gap-4">
                <input v-model="quoteForm.phone" type="tel" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all placeholder-white" placeholder="Phone *" />
                <select v-model="quoteForm.service" required class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm transition-all">
                  <option value="">Service Needed *</option>
                  <option v-for="service in allServices" :key="service.id" :value="service.title">{{ service.title }}</option>
                </select>
              </div>
              <textarea v-model="quoteForm.description" required rows="4" class="w-full px-5 py-3 bg-muted/30 border border-border rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-foreground text-sm resize-none transition-all placeholder-white" placeholder="Project description..."></textarea>
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

   

    <!-- ═══════════════ BLOG ═══════════════ -->
    <section v-if="recentBlogs.length" class="py-12 md:py-16 bg-muted/30">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Latest Insights</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight">From Our Blog</h2>
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

    <!-- ═══════════════ NEWSLETTER ═══════════════ -->
    <section class="py-12" style="background-color: #262626; border-top: 1px solid rgba(255,255,255,0.1); border-bottom: 1px solid rgba(255,255,255,0.1);">
      <div class="container mx-auto px-6 max-w-2xl text-center">
        <h3 class="text-xl font-bold text-white mb-2">Stay Updated</h3>
        <p class="text-white/75 text-sm mb-6">Join our newsletter for the latest industry news and exclusive offers.</p>
        <form @submit.prevent="submitNewsletter" class="flex gap-4 max-w-lg mx-auto">
          <input v-model="newsletterEmail" type="email" required class="flex-1 px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white/40" placeholder="Enter your email" />
          <button type="submit" :disabled="newsletterSubmitting" class="px-7 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 disabled:opacity-50 transition-all shadow-sm whitespace-nowrap">
            {{ newsletterSubmitting ? '...' : 'Subscribe' }}
          </button>
        </form>
      </div>
    </section>

    <!-- ═══════════════ FAQ ═══════════════ -->
    <section v-if="faqs.length" class="py-12 md:py-16 bg-muted/30">
      <div class="container mx-auto px-6 max-w-3xl">
        <div class="text-center mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight">Frequently Asked Questions</h2>
        </div>

        <div class="space-y-3">
          <div v-for="(faq, idx) in faqs" :key="faq.id" class="bg-white border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
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

       <!-- ═══════════════ CTA — VIDEO MAIN ═══════════════ -->
    <section ref="videoCtaSectionMain" class="py-12 md:py-16">
      <div class="container mx-auto px-6 max-w-5xl">
 
        <!-- Video card -->
        <div class="relative rounded-xl w-full overflow-hidden bg-black aspect-video">
          <video
            ref="videoElMain"
            class="absolute inset-0 w-full h-full object-cover"
            muted
            autoplay
            controls
            loop
            playsinline
            preload="auto"
            :title="videoTitleMain"
          >
            <source :src="videoSrcMain" type="video/mp4" />
            Your browser does not support the video tag.
          </video>
        </div>
 
        <!-- Caption bar -->
        <div class="mt-3 flex items-center gap-3 px-1">
          <div class="flex items-center gap-1.5">
            <div class="w-2 h-2 rounded-full bg-primary animate-pulse" />
            <span class="text-white/50 text-xs">{{ captionMain }}</span>
          </div>
          <div class="ml-auto">
            <button
              class="text-white/40 hover:text-white/80 transition-colors text-xs flex items-center gap-1.5"
              @click="shareVideo(videoTitleMain)"
            >
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="18" cy="5" r="3"/>
                <circle cx="6" cy="12" r="3"/>
                <circle cx="18" cy="19" r="3"/>
                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
              </svg>
              Share
            </button>
          </div>
        </div>
 
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import axios from 'axios';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref, computed, onMounted, onUnmounted } from 'vue';
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
import heroTechBg from '../../img/tech-background.png';
import heroTech2 from '../../img/tech-closeup.jpg';
import heroTechGlow from '../../img/tech-glow.webp';
import heroTech1 from '../../img/tech2.jpg';
import heroTech5 from '../../img/tech3.jpg';
import heroTech4 from '../../img/tech4.jpg';
import heroCTAbg from '../../img/tech4.jpg';
import heroTech6 from '../../img/tech7.jpg';
import videoSolutions from '../../videos/omniviatech-solutions.mp4';
import videoCTA from '../../videos/omniviatech.mp4';
import WishlistButton from '../components/WishlistButton.vue';
import { useToast } from '../composables';
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
const impactProjectsApi = ref<any[]>([]);
const toast = useToast();

const activeStack = ref('All')

const stackCategories = [
  { label: 'All' },
  { label: 'Frontend' },
  { label: 'Backend' },
  { label: 'Mobile' },
  { label: 'Cloud & DevOps' },
  { label: 'Databases' },
  // { label: 'AI & Data' },
]

const techStack = [
  // Frontend
  { name: 'Vue.js',       icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#42b883" d="M78.8 10L64 35.4 49.2 10H0l64 110 64-110z"/><path fill="#35495e" d="M78.8 10L64 35.4 49.2 10H25.6L64 76l38.4-66z"/></svg>',     category: 'Frontend' },
  { name: 'React',        icon: '<svg viewBox="0 0 128 128" width="28" height="28"><circle cx="64" cy="64" r="11.4" fill="#61dafb"/><path fill="none" stroke="#61dafb" stroke-width="5" d="M64 30c19.9 0 36.6 5.4 36.6 12 0 6.6-16.7 12-36.6 12S27.4 48.6 27.4 42c0-6.6 16.7-12 36.6-12z"/><path fill="none" stroke="#61dafb" stroke-width="5" d="M47.1 47c9.95-17.2 23.1-29.7 29.6-26 6.5 3.7 4 20.6-5.95 37.8S47.7 88.7 41.2 85c-6.5-3.7-4-20.6 5.9-38z"/><path fill="none" stroke="#61dafb" stroke-width="5" d="M47.1 81C37.15 63.8 34.65 46.9 41.2 43.2c6.5-3.7 19.65 8.8 29.6 26S81.1 102.7 74.65 106.4C68.1 110.1 57.05 98.2 47.1 81z"/></svg>', category: 'Frontend' },
  { name: 'TypeScript',   icon: '<svg viewBox="0 0 128 128" width="28" height="28"><rect width="128" height="128" rx="6" fill="#3178c6"/><path fill="#fff" d="M22 72h20v-8H22v8zm0 12h20v-8H22v8zm0 12h10v-8H22v8zM72 48H32V32h40v16zm16 48c-6.6 0-12-5.4-12-12s5.4-12 12-12 12 5.4 12 12-5.4 12-12 12z"/><path fill="#fff" d="M56 96V56h16v8h8V56h16v40H80V72h-8v24H56z"/></svg>', category: 'Frontend' },
  { name: 'Next.js',      icon: '<svg viewBox="0 0 128 128" width="28" height="28"><circle cx="64" cy="64" r="64" fill="#000"/><path fill="#fff" d="M48 100V28l60 76H92L48 44v56H48z"/></svg>', category: 'Frontend' },
  { name: 'Tailwind',     icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#38bdf8" d="M64 16C45.1 16 33.6 25.5 29 44.5c6.5-8.7 14-12 22.8-9.7 4.9 1.2 8.5 4.9 12.4 8.9C70.5 50.4 78.3 58.5 96 58.5c18.9 0 30.4-9.5 35-28.5-6.5 8.7-14 12-22.8 9.7-4.9-1.2-8.5-4.9-12.4-8.9C89.5 24.1 81.7 16 64 16zM29 58.5C10.1 58.5-1.4 68 -6 87c6.5-8.7 14-12 22.8-9.7 4.9 1.2 8.5 4.9 12.4 8.9C35.5 92.9 43.3 101 61 101c18.9 0 30.4-9.5 35-28.5-6.5 8.7-14 12-22.8 9.7-4.9-1.2-8.5-4.9-12.4-8.9C54.5 66.6 46.7 58.5 29 58.5z"/></svg>', category: 'Frontend' },
  { name: 'Nuxt.js',      icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#00DC82" d="M72 28L40 84H8L64 0 120 84H88L56 28z" opacity=".6"/><path fill="#00DC82" d="M104 84L72 28 40 84h64z" opacity=".3"/></svg>', category: 'Frontend' },
  { name: 'Angular', icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#DD0031" d="M64 10L16 28l8 64 40 22 40-22 8-64z"/><path fill="#C3002F" d="M64 10v104l40-22 8-64z"/><path fill="#fff" d="M64 26l24 72h-8l-6-16H54l-6 16h-8l24-72zm0 18l-10 28h20l-10-28z"/></svg>', category: 'Frontend' },
  { name: 'Svelte', icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#FF3E00" d="M64 8c-22 0-40 18-40 40 0 13 6 25 16 32l-6 20 22-10c2 0 4 0 6 0 22 0 40-18 40-40S86 8 64 8z"/></svg>', category: 'Frontend' },
  // Backend
  { name: 'Laravel',      icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#FF2D20" d="M124.3 23.5L102.5 5.3A7.2 7.2 0 0097.1 3H30.9a7.2 7.2 0 00-5.4 2.3L3.7 23.5A7.2 7.2 0 002 28.1v71.8a7.2 7.2 0 007.2 7.2h109.6a7.2 7.2 0 007.2-7.2V28.1a7.2 7.2 0 00-1.7-4.6zM64 92L26 54l10-10 28 28 28-28 10 10L64 92z"/></svg>', category: 'Backend' },
  { name: 'Node.js',      icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#83cd29" d="M112.8 85.3L67.4 111a7.2 7.2 0 01-6.8 0L15.2 85.3A7.2 7.2 0 0112 79V29a7.2 7.2 0 013.2-6.2L60.6 6.7a7.2 7.2 0 016.8 0l45.4 16.1A7.2 7.2 0 01116 29v50a7.2 7.2 0 01-3.2 6.3z"/><path fill="#fff" d="M64 29v70L28 79V49L64 29z" opacity=".5"/></svg>', category: 'Backend' },
  { name: 'Python',       icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#3572A5" d="M63.5 3C37.3 3 39 14 39 14v12h25v4H25S3 27.6 3 54.3C3 81 18.8 80 18.8 80H29V67.5S28.3 52 44 52h39.7S99 52.8 99 38V17C99 3.3 87 3 63.5 3zM51 19.5a5.5 5.5 0 110 11 5.5 5.5 0 010-11z"/><path fill="#FFD43B" d="M64.5 125C90.7 125 89 114 89 114v-12H64v-4h39S125 100.4 125 73.7C125 47 109.2 48 109.2 48H99V60.5S99.7 76 84 76H44.3S29 75.2 29 89V110C29 123.7 41 125 64.5 125zM77 108.5a5.5 5.5 0 110-11 5.5 5.5 0 010 11z"/></svg>', category: 'Backend' },
  { name: 'FastAPI',      icon: '<svg viewBox="0 0 128 128" width="28" height="28"><circle cx="64" cy="64" r="60" fill="#009688"/><path fill="#fff" d="M72 28L44 68h24l-12 32 40-48H72z"/></svg>', category: 'Backend' },
  { name: 'GraphQL',      icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#E10098" d="M64 8L12 38v60l52 30 52-30V38L64 8zm0 8l44 25.4v50.8L64 117 20 92.2V41.4L64 16zm-4 20v16H44l16-16zm8 0l16 16H68V36zm-28 24h8v20H40V60zm40 0h8v20h-8V60zm-20 0h8v20h-8V60zm-20 24h16l-16 16v-16zm24 0h16v16l-16-16zm-4 8l16 16H44l16-16z"/></svg>', category: 'Backend' },
  { name: 'REST APIs',    icon: '<svg viewBox="0 0 128 128" width="28" height="28"><rect x="8" y="32" width="112" height="64" rx="8" fill="#6366f1"/><path fill="#fff" d="M24 56h12v16H24V56zm16 0h12v16H40V56zm16 0h12v16H56V56zm16 0h12v16H72V56zm16 0h12v16H88V56z" opacity=".6"/><text x="64" y="70" text-anchor="middle" fill="#fff" font-size="16" font-weight="bold" font-family="monospace">API</text></svg>', category: 'Backend' },
  { name: 'NestJS', icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#E0234E" d="M64 8l48 28v56L64 120 16 92V36z"/><path fill="#fff" d="M64 20l34 20v44L64 104 30 84V40z"/></svg>', category: 'Backend' },
  { name: 'Go', icon: '<svg viewBox="0 0 128 128" width="28" height="28"><circle cx="64" cy="64" r="56" fill="#00ADD8"/><path fill="#fff" d="M40 60h24v8H40zm0 16h40v8H40zm8-32h40v8H48z"/></svg>', category: 'Backend' },

  // Mobile
  { name: 'Flutter',      icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#54C5F8" d="M14 64L62 16h52L66 64 114 112H62L14 64z"/><path fill="#01579B" d="M62 112l26-26-14-14L38 112z"/><path fill="#29B6F6" d="M88 86L62 112l-12-12 26-26z"/></svg>', category: 'Mobile' },
  { name: 'React Native', icon: '<svg viewBox="0 0 128 128" width="28" height="28"><circle cx="64" cy="64" r="11.4" fill="#61dafb"/><path fill="none" stroke="#61dafb" stroke-width="5" d="M64 30c19.9 0 36.6 5.4 36.6 12 0 6.6-16.7 12-36.6 12S27.4 48.6 27.4 42c0-6.6 16.7-12 36.6-12zM47.1 47c9.95-17.2 23.1-29.7 29.6-26 6.5 3.7 4 20.6-5.95 37.8S47.7 88.7 41.2 85c-6.5-3.7-4-20.6 5.9-38zM47.1 81C37.15 63.8 34.65 46.9 41.2 43.2c6.5-3.7 19.65 8.8 29.6 26S81.1 102.7 74.65 106.4C68.1 110.1 57.05 98.2 47.1 81z"/></svg>', category: 'Mobile' },
  { name: 'Kotlin',       icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#7F52FF" d="M8 8h56l-56 56V8zm0 112l56-56 56 56H8zm64-56L128 8v112L72 64z"/></svg>', category: 'Mobile' },
  { name: 'Swift',        icon: '<svg viewBox="0 0 128 128" width="28" height="28"><rect width="128" height="128" rx="24" fill="#F05138"/><path fill="#fff" d="M96 72c0 17.7-14.3 32-32 32a32 32 0 01-20.7-7.6s13.7 4.1 26.7-8.4C56.5 83.9 37.4 69 28 48c14 15 36 24 50 24-9-9-17.5-22.8-17.5-37.5A32 32 0 0196 72z"/></svg>', category: 'Mobile' },

  // Cloud & DevOps
  { name: 'AWS',          icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#FF9900" d="M40 72c-9 4-15 12.5-15 22.5C25 108.3 35.7 119 49.5 119c5.3 0 10.3-1.7 14.3-4.7M88 72c9 4 15 12.5 15 22.5C103 108.3 92.3 119 78.5 119c-5.3 0-10.3-1.7-14.3-4.7"/><path fill="#232F3E" d="M64 9L20 33v30l44 24 44-24V33L64 9zm0 8l36 20v24L64 81 28 61V37L64 17z"/></svg>', category: 'Cloud & DevOps' },
  { name: 'Docker',       icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#2496ED" d="M124.8 52.1c-2-1.4-6.6-2-10.1-1.3-.4-3.4-2.4-6.4-5.9-9.1l-2-1.4-1.4 2c-1.8 2.7-2.4 7.2-2.2 10.7-.6-.3-1.6-.7-2.3-1.1-1.4-.8-3.9-1.8-6.8-1.7H8.2l-.3 1.7c-.6 3.7-.4 12.1 4.8 19.2 3.8 5.2 9.5 7.8 16.8 7.8 16 0 27.8-7.4 33.3-20.8 2.2.1 6.9.2 9.3-4.6l.5-1-1-.6zM56 52H46v10h10V52zm-13 0H33v10h10V52zm-13 0H20v10h10V52zm26-13H56v10h10V39zm-13 0H43v10h10V39zm-13 0H30v10h10V39zm13-13H56v10h10V26zm-13 0H43v10h10V26z"/></svg>', category: 'Cloud & DevOps' },
  { name: 'GitHub CI',    icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#181717" d="M64 4C30.2 4 3 31.2 3 65c0 27 17.5 49.9 41.8 58 3 .6 4.1-1.3 4.1-2.9v-10.2c-16.9 3.7-20.4-8.1-20.4-8.1-2.7-6.9-6.7-8.7-6.7-8.7-5.5-3.7.4-3.7.4-3.7 6 .4 9.2 6.2 9.2 6.2 5.4 9.2 14.1 6.5 17.5 5 .5-3.9 2.1-6.5 3.8-8-13.4-1.5-27.5-6.7-27.5-29.9 0-6.6 2.4-12 6.2-16.2-.6-1.5-2.7-7.7.6-16 0 0 5.1-1.6 16.6 6.2 4.8-1.3 10-2 15.1-2s10.3.7 15.1 2c11.5-7.8 16.6-6.2 16.6-6.2 3.3 8.3 1.2 14.5.6 16 3.9 4.2 6.2 9.6 6.2 16.2 0 23.2-14.1 28.3-27.6 29.8 2.2 1.9 4.1 5.5 4.1 11.1v16.5c0 1.6 1.1 3.5 4.2 2.9C109.5 114.9 127 92 127 65 127 31.2 99.8 4 64 4z"/></svg>', category: 'Cloud & DevOps' },
  // { name: 'Kubernetes',   icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#326CE5" d="M64 6L8 36v56l56 30 56-30V36L64 6zm0 8l48 26v48L64 114 16 88V40L64 14z"/><path fill="#326CE5" d="M52 52h24v24H52z" opacity=".5"/></svg>', category: 'Cloud & DevOps' },
  { name: 'Firebase',     icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#FFC400" d="M18 100L36 30l22 22L18 100z"/><path fill="#F57F17" d="M58 52L80 8l28 92L58 52z"/><path fill="#FF6F00" d="M18 100l62-8 28 8H18z" opacity=".8"/><path fill="#FFC400" d="M36 30l22 22 22-44L36 30z" opacity=".7"/></svg>', category: 'Cloud & DevOps' },
  { name: 'Linux',        icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#dd4814" d="M64 8C34 8 10 32 10 62c0 18 8.7 33.9 22 43.8V104h4v8h56v-8h4V105.8C109.3 95.9 118 80 118 62 118 32 94 8 64 8z"/><path fill="#fff" d="M47 54a9 9 0 100 18 9 9 0 000-18zm34 0a9 9 0 100 18 9 9 0 000-18z"/></svg>', category: 'Cloud & DevOps' },
  { name: 'DigitalOcean', icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#0080FF" d="M64 112v-16c22 0 40-18 40-40S86 16 64 16 24 34 24 56h16c0-13 11-24 24-24s24 11 24 24-11 24-24 24v32z"/></svg>', category: 'Cloud & DevOps' },
  // Databases
  { name: 'MySQL',        icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#00618A" d="M2 73.9c5.3.7 8.9 3 9.9 7.6 1.1 4.9-1.8 9.7-7.4 12.7L2 95v10.5l3.3-1.5c7.4-3.3 12.5-9 13.5-15.8.8-5.2-.8-10.3-4.4-14.3h91.2c-3.6 4-5.2 9.1-4.4 14.3 1 6.8 6.1 12.5 13.5 15.8l3.3 1.5V95l-2.5-1.3c-5.6-3-8.5-7.8-7.4-12.7 1-4.6 4.6-6.9 9.9-7.6V62.6H2v11.3z"/><path fill="#00618A" d="M2 23v9.3c5.3.7 8.9 3 9.9 7.6 1.1 4.9-1.8 9.7-7.4 12.7L2 53.5V64h124v-10.5l-2.5-1.5c-5.6-3-8.5-7.8-7.4-12.7 1-4.6 4.6-6.9 9.9-7.6V23H2z"/></svg>', category: 'Databases' },
  { name: 'PostgreSQL',   icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#336791" d="M93.8 24.2C87.4 17.7 78.7 14 69.5 14c-7.7 0-15 2.6-20.9 7.2-5.9-4.6-13.2-7.2-20.9-7.2C18.5 14 9.8 17.7 3.4 24.2A34.5 34.5 0 000 45c0 7.2 2.5 14.2 7.1 19.8 2.8 3.4 6.2 6.2 10 8.2v35h104V73c3.8-2 7.2-4.8 10-8.2C135.5 59.2 138 52.2 138 45c0-7.9-3-15.4-8.3-20.8z"/></svg>', category: 'Databases' },
  { name: 'MongoDB',      icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#4DB33D" d="M64 8C40.5 8 21.5 27 21.5 50.5c0 16.5 9.3 31 23 38.6V116h7v-25.1c.8.1 1.7.1 2.5.1s1.7 0 2.5-.1V116h7V89.1c13.7-7.6 23-22.1 23-38.6C86.5 27 67.5 8 64 8z"/></svg>', category: 'Databases' },
  { name: 'Redis',        icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#D82C20" d="M64 8L8 40v48l56 32 56-32V40L64 8zm0 10l44 25.4v38.8L64 107 20 82.2V43.4L64 18z"/></svg>', category: 'Databases' },
  { name: 'Supabase',     icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#3ECF8E" d="M72 12L24 76h48V12z"/><path fill="#1C1C1C" d="M56 116l48-64H56v64z" opacity=".7"/></svg>', category: 'Databases' },

  // AI & Data
  // { name: 'TensorFlow',   icon: '<svg viewBox="0 0 128 128" width="28" height="28"><path fill="#FF6F00" d="M64 8L8 40v48l56 32 56-32V40L64 8zm0 10l44 25.4v38.8L64 107 20 82.2V43.4L64 18z"/><path fill="#FF6F00" d="M50 50v28l14 8 14-8V50l-14-8z" opacity=".5"/></svg>', category: 'AI & Data' },
  // { name: 'OpenAI',       icon: '<svg viewBox="0 0 128 128" width="28" height="28"><circle cx="64" cy="64" r="56" fill="#10a37f"/><path fill="#fff" d="M64 28c-9.9 0-18.8 4.9-24.2 12.4A28.1 28.1 0 0028 64c0 15.5 12.5 28 28 28 9.9 0 18.8-4.9 24.2-12.4A28.1 28.1 0 00100 64c0-15.5-12.5-28-28-28-2.7 0-5.4.4-7.9 1.1" opacity=".8"/></svg>', category: 'AI & Data' },
  // { name: 'Pandas',       icon: '<svg viewBox="0 0 128 128" width="28" height="28"><rect x="20" y="10" width="20" height="108" rx="6" fill="#150458"/><rect x="88" y="10" width="20" height="108" rx="6" fill="#E70488"/><rect x="40" y="42" width="48" height="20" rx="4" fill="#150458"/><rect x="40" y="66" width="48" height="20" rx="4" fill="#E70488"/></svg>', category: 'AI & Data' },
  // { name: 'LangChain',    icon: '<svg viewBox="0 0 128 128" width="28" height="28"><rect width="128" height="128" rx="20" fill="#1C3D5A"/><path fill="#38bdf8" d="M24 64l20-20 20 20-20 20L24 64zm40 0l20-20 20 20-20 20L64 64z"/></svg>', category: 'AI & Data' },
  // { name: 'n8n',          icon: '<svg viewBox="0 0 128 128" width="28" height="28"><rect width="128" height="128" rx="20" fill="#EA4B71"/><circle cx="40" cy="64" r="16" fill="#fff"/><circle cx="88" cy="64" r="16" fill="#fff"/><rect x="56" y="60" width="16" height="8" fill="#fff"/></svg>', category: 'AI & Data' },
  // { name: 'Jupyter',      icon: '<svg viewBox="0 0 128 128" width="28" height="28"><circle cx="64" cy="64" r="56" fill="#F37626"/><path fill="#fff" d="M64 24c-11 0-20 9-20 20v40c0 11 9 20 20 20s20-9 20-20V44c0-11-9-20-20-20zm0 8a12 12 0 110 24 12 12 0 010-24z" opacity=".9"/></svg>', category: 'AI & Data' },
]

const activeStackTechs = computed(() =>
  activeStack.value === 'All'
    ? techStack
    : techStack.filter(t => t.category === activeStack.value)
)

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

const featuredServices = [
  {
    id: 'custom-web-development',
    title: 'Custom Website Development',
    slug: 'custom-web-development',
    excerpt: 'Tailored websites and web applications built to match your brand and business goals.',
    image: customWebDevelopmentImage,
  },
  {
    id: 'api-development',
    title: 'API Development',
    slug: 'api-development',
    excerpt: 'Scalable APIs for integrations, automation, and secure data exchange.',
    image: apiDevelopmentImage,
  },
  {
    id: 'crm-erp-development',
    title: 'CRM & ERP Development',
    slug: 'crm-erp-development',
    excerpt: 'Custom CRM and ERP systems to streamline operations and improve productivity.',
    image: crmErpDevelopmentImage,
  },
  {
    id: 'ecommerce-development',
    title: 'E-commerce Development',
    slug: 'ecommerce-development',
    excerpt: 'High-converting online stores built for seamless shopping experiences.',
    image: eCommerceDevelopmentImage,
  },
  {
    id: 'mobile-app-development',
    title: 'Mobile App Development',
    slug: 'mobile-app-development',
    excerpt: 'Native and cross-platform apps for iOS and Android that drive engagement.',
    image: mobileAppDevelopmentImage,
  },
  {
    id: 'paid-ads-management',
    title: 'Paid Ads Management',
    slug: 'paid-ads-management',
    excerpt: 'Performance campaigns that increase traffic and conversions.',
    image: paidAdsImage,
  },
  {
    id: 'seo-optimization',
    title: 'SEO Optimization',
    slug: 'seo-optimization',
    excerpt: 'Search engine optimization to improve your online visibility.',
    image: seoOptimizationImage,
  },
  {
    id: 'mobile-app-strategy',
    title: 'Mobile App Strategy',
    slug: 'mobile-app-strategy',
    excerpt: 'Strategic mobile planning and development for business growth.',
    image: mobileAppImage,
  },
];

const serviceImagePaths: Record<string, string> = {
  'api development': apiDevelopmentImage,
  'api developer': apiDevelopmentImage,
  'api design': apiDevelopmentImage,
  'crm & erp development': crmErpDevelopmentImage,
  'crm erp development': crmErpDevelopmentImage,
  'custom web development': customWebDevelopmentImage,
  'custom website development': customWebDevelopmentImage,
  'website development': customWebDevelopmentImage,
  'web development': customWebDevelopmentImage,
  'e-commerece development': eCommerceDevelopmentImage,
  'ecommerce development': eCommerceDevelopmentImage,
  'e-commerce development': eCommerceDevelopmentImage,
  'mobile app development': mobileAppDevelopmentImage,
  'mobile application development': mobileAppDevelopmentImage,
  'mobile app': mobileAppImage,
  'paid ads': paidAdsImage,
  'paid ads management': paidAdsImage,
  'seo optimization': seoOptimizationImage,
  'search engine optimization': seoOptimizationImage,
};

function getServiceImage(service: any) {
  const key = (service.title || service.name || service.slug || '').toString().trim().toLowerCase();
  if (!key) {
    return '';
  }

  if (service.image) {
    return service.image;
  }

  if (service.image_url) {
    return service.image_url;
  }

  if (serviceImagePaths[key]) {
    return serviceImagePaths[key];
  }

  if (key.includes('custom website') || key.includes('custom web') || key.includes('website development') || key.includes('web development')) {
    return customWebDevelopmentImage;
  }

  if (key.includes('ecommerce') || key.includes('e-commerce') || key.includes('online store') || key.includes('shop')) {
    return eCommerceDevelopmentImage;
  }

  if (key.includes('api')) {
    return apiDevelopmentImage;
  }

  if (key.includes('crm')) {
    return crmErpDevelopmentImage;
  }

  if (key.includes('seo')) {
    return seoOptimizationImage;
  }

  if (key.includes('ads')) {
    return paidAdsImage;
  }

  if (key.includes('mobile app') || key.includes('mobile application') || key.includes('app development')) {
    return mobileAppDevelopmentImage;
  }

  return '';
}

const currentHeroSlide = ref(0)


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
    cta_text: 'Get Started',
    cta_link: '/contact',
    cta_text_2: 'Our Services',
    cta_link_2: '/services',
    bg_image: heroTech6,
  },
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

// Removed unused `whyFeatures` block to satisfy lint rules

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

const heroAutoplay = { delay: 6000, disableOnInteraction: false } as any;
const heroPagination = { clickable: true } as any;
const industriesAutoplay = { delay: 3000, disableOnInteraction: false } as any;
const industriesBreakpoints = { 480: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } } as any;
const servicesAutoplay = { delay: 4000, disableOnInteraction: false } as any;
const servicesBreakpoints = industriesBreakpoints;
const servicesNavigation = true as any;
const impactSliderNavigation = { prevEl: '.pop-prev', nextEl: '.pop-next' } as any;
const impactSliderAutoplay = { delay: 5000, disableOnInteraction: false } as any;
const productsAutoplay = { delay: 5000, disableOnInteraction: false } as any;
const productsBreakpoints = industriesBreakpoints;
const testimonialsPagination = { clickable: true } as any;
const testimonialsAutoplay = { delay: 5000, disableOnInteraction: false } as any;

// UI State
const counterRefs = ref<HTMLElement[]>([]);
const openFaqIndex = ref<number | null>(null);

// Video CTA State — Three unique video sections
const videoSrcMain = videoSolutions;  // Main CTA video
const videoTitleMain = 'OmniviaTech — Product Overview';
const captionMain = 'Watch our short overview to see how OmniviaTech can help your organization.';
const videoElMain = ref<HTMLVideoElement | null>(null);
const videoCtaSectionMain = ref<HTMLElement | null>(null);

// Solutions Background Video
const videoElSolutions = ref<HTMLVideoElement | null>(null);
const videoSectionSolutions = ref<HTMLElement | null>(null);

function shareVideo(title: string) {
  const shareText = `${title} — Watch now at ${window.location.href}`;
  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard.writeText(shareText).then(() => {
      toast.success('Video link copied to clipboard.');
    }).catch(() => {
      toast.error('Unable to copy link.');
    });
  } else {
    toast.info('Copy this link: ' + window.location.href);
  }
}

function toggleFaq(idx: number) {
  openFaqIndex.value = openFaqIndex.value === idx ? null : idx;
}

function setCardBorderColor(event: MouseEvent, color: string) {
  const target = event.currentTarget;
  if (target instanceof HTMLElement) {
    target.style.borderColor = color;
  }
}

// Auto-play background video on scroll into view
let ctaObserver: IntersectionObserver | null = null;

// Form State
const quoteForm = ref({ name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' });
const quoteFormSubmitting = ref(false);
const newsletterEmail = ref('');
const newsletterSubmitting = ref(false);
// contact form state removed (not used on this page)


// ─── Mission & Vision Data ───────────────────────────────────────────────────
 
const missionPillars = [
  'Deliver technology that solves real, measurable business problems.',
  'Make enterprise-grade digital tools accessible to businesses of every size.',
  'Build long-term partnerships, not just one-off projects.',
]
 
const visionHorizons = [
  { label: 'Near-term',  text: 'Be the preferred digital transformation partner for SMEs and enterprises across East Africa.' },
  { label: 'Mid-term',   text: 'Expand our footprint to 30+ African markets with localised, compliant solutions.' },
  { label: 'Long-term',  text: 'Set the benchmark globally for African-built enterprise technology.' },
]
 
const missionValues = [
  { icon: '🎯', label: 'Impact-Driven',  desc: 'Every line of code serves a purpose.' },
  { icon: '🤝', label: 'Partnership',    desc: 'We grow when our clients grow.' },
  { icon: '🔬', label: 'Innovation',     desc: 'Constantly pushing what is possible.' },
  { icon: '🌍', label: 'Pan-African',    desc: 'Built for Africa, ready for the world.' },
]
 
// ─── Security & Compliance Data ──────────────────────────────────────────────
 
const upTimeMetrics = [
  { label: 'Average Response Time', value: '< 200 ms' },
  { label: 'Incident Response',     value: '< 30 min' },
  { label: 'Data Backup Frequency', value: 'Every 6 hrs' },
  { label: 'Recovery Time Obj.',    value: '< 4 hrs' },
]
 
const certifications = [
  {
    name: 'ISO 27001',
    desc: 'Information security management',
    bgColor: 'rgba(59,130,246,0.12)',
    iconColor: 'text-blue-500',
    iconPath: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
    badge: 'Certified',
    highlight: true,
  },
  {
    name: 'GDPR',
    desc: 'EU data protection & privacy',
    bgColor: 'rgba(16,185,129,0.12)',
    iconColor: 'text-emerald-500',
    iconPath: 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
    badge: 'Compliant',
  },
  {
    name: 'SOC 2 Type II',
    desc: 'Security, availability & confidentiality',
    bgColor: 'rgba(139,92,246,0.12)',
    iconColor: 'text-violet-500',
    iconPath: 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
    badge: 'Audited',
  },
  {
    name: 'PCI DSS',
    desc: 'Payment card data security',
    bgColor: 'rgba(245,158,11,0.12)',
    iconColor: 'text-amber-500',
    iconPath: 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
    badge: 'Level 1',
  },
  {
    name: 'HIPAA',
    desc: 'Health data privacy standards',
    bgColor: 'rgba(239,68,68,0.12)',
    iconColor: 'text-red-500',
    iconPath: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
  },
  {
    name: 'NIST CSF',
    desc: 'Cybersecurity framework alignment',
    bgColor: 'rgba(6,182,212,0.12)',
    iconColor: 'text-cyan-500',
    iconPath: 'M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01',
  },
]
 
const securityPractices = [
  {
    title: 'End-to-End Encryption',
    desc: 'All data in transit and at rest is encrypted with AES-256 and TLS 1.3 protocols.',
    icon: 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
  },
  {
    title: 'Penetration Testing',
    desc: 'Bi-annual third-party penetration tests with public disclosure of remediation outcomes.',
    icon: 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18',
  },
  {
    title: 'Role-Based Access',
    desc: 'Granular RBAC ensures staff and clients only access what they need, nothing more.',
    icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
  },
  {
    title: '24 / 7 Monitoring',
    desc: 'Automated threat detection with a dedicated security operations centre for real-time response.',
    icon: 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
  },
]
 
const privacyPolicies = [
  {
    title: 'GDPR & Data Privacy',
    desc: 'We never sell your data. Full data subject access, erasure, and portability rights honoured within 72 hours.',
    bgColor: 'rgba(16,185,129,0.15)',
    iconColor: 'text-emerald-500',
    icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
  },
  {
    title: 'Data Residency',
    desc: 'Choose where your data lives. We offer in-region storage across Kenya, South Africa, EU, and US zones.',
    bgColor: 'rgba(59,130,246,0.15)',
    iconColor: 'text-blue-500',
    icon: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
  },
  {
    title: 'Vendor Risk Management',
    desc: 'All third-party vendors are vetted against our security policy. Sub-processors are listed in our DPA.',
    bgColor: 'rgba(139,92,246,0.15)',
    iconColor: 'text-violet-500',
    icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
  },
]
 
// ─── Shared utility (already exists in your codebase) ────────────────────────
// function setCardBorderColor(event: MouseEvent, color: string) {
//   const el = event.currentTarget as HTMLElement
//   if (el) el.style.borderColor = color
// }

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
        { id: 1, rating: 5, comment: 'Outstanding service! OmniviaTech built our e-commerce platform in record time with exceptional quality. Our online sales increased by 200% within three months.', user_name: 'David Okonkwo', company: 'CEO, AfricaTrade' },
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

// contact form handler removed (not used in this page)

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

  // Auto-play main video CTA when scrolled into view
  if (videoCtaSectionMain.value && videoElMain.value) {
    ctaObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          videoElMain.value?.play().catch(() => {});
        } else {
          videoElMain.value?.pause();
        }
      });
    }, { threshold: 0.3 });
    ctaObserver.observe(videoCtaSectionMain.value);
  }

  // Auto-play solutions background video
  if (videoSectionSolutions.value && videoElSolutions.value) {
    const solutionsObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          videoElSolutions.value?.play().catch(() => {});
        } else {
          videoElSolutions.value?.pause();
        }
      });
    }, { threshold: 0.2 });
    solutionsObserver.observe(videoSectionSolutions.value);
  }
});

onUnmounted(() => {
  if (ctaObserver) ctaObserver.disconnect();
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

   .video-docker video {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .video-docker::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 20%;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 1;
    }
</style>


<style>
.cta-wrap {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 420px;
  border-radius: var(--border-radius-xl);
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
.live-badge {
  position: absolute;
  top: 16px;
  left: 16px;
  display: flex;
  align-items: center;
  gap: 6px;
  background: rgba(0,0,0,0.55);
  border: 0.5px solid rgba(255,255,255,0.15);
  border-radius: 999px;
  padding: 5px 12px;
}
.live-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #d311f5;
  animation: livePulse 1.6s ease-in-out infinite;
}
@keyframes livePulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(0.85); }
}
.live-text {
  font-size: 11px;
  font-weight: 500;
  color: rgba(255,255,255,0.8);
  letter-spacing: 0.06em;
  text-transform: uppercase;
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
  font-size: 26px;
  font-weight: 700;
  color: #fff;
  line-height: 1.28;
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
.trust-row {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-top: 36px;
  padding-top: 28px;
  border-top: 0.5px solid rgba(255,255,255,0.08);
}
.trust-stat { text-align: left; }
.trust-stat .num {
  font-size: 18px;
  font-weight: 600;
  color: #fff;
  line-height: 1;
}
.trust-stat .lbl {
  font-size: 11px;
  color: rgba(255,255,255,0.4);
  margin-top: 3px;
}
.trust-sep {
  width: 0.5px;
  height: 32px;
  background: rgba(255,255,255,0.12);
}
</style>