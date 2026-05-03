<template>
  <PublicLayout>
    <!-- ═══════════════ HERO SECTION ═══════════════ -->
    <section class="relative min-h-[60vh] md:min-h-[70vh] flex items-center overflow-hidden">
      <Swiper
        :modules="[Autoplay, Pagination]"
        :slides-per-view="1"
        :autoplay="{ delay: 6000, disableOnInteraction: false }"
        :pagination="{ clickable: true }"
        :loop="true"
        class="hero-swiper w-full h-full"
      >
        <SwiperSlide v-for="slide in heroSlides" :key="slide.id">
          <div class="relative w-full min-h-[60vh] md:min-h-[70vh] flex items-center">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
              <img :src="slide.bg_image" :alt="slide.title" class="w-full h-full object-cover" />
              <div class="absolute inset-0 bg-black/60"></div>
            </div>

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
                    <router-link v-if="slide.cta_text_2" :to="slide.cta_link_2" class="px-8 py-3 border-2 border-white text-white text-sm font-semibold rounded-full hover:bg-white/10 transition-all">{{ slide.cta_text_2 }}</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </SwiperSlide>
      </Swiper>
    </section>

    <!-- ═══════════════ COUNTER BAR ═══════════════ -->
    <section class="py-6 md:py-8 shadow-lg" style="background-color: #262626;">
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
    <section class="py-12 md:py-16 bg-muted/30">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Solutions</p>
          <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight">Our Solutions</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
          <router-link v-for="service in allServices.slice(0, 8)" :key="service.id" :to="`/services/${service.slug}`" class="group block bg-white border border-border rounded-2xl overflow-hidden hover:border-primary/20 hover:shadow-md transition-all duration-300">
            <div class="aspect-[4/3] bg-gray-100 overflow-hidden relative">
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
          :autoplay="{ delay: 3000, disableOnInteraction: false }"
          :loop="true"
          :breakpoints="{ 480: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } }"
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
    <section v-if="allServices.length" class="py-12 md:py-16" style="background-color: #262626;">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-white text-xs font-semibold tracking-widest uppercase mb-3">Our Services</p>
          <h2 class="text-xl md:text-2xl font-bold text-white leading-tight">Services That Drive Growth</h2>
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
            <router-link :to="`/services/${service.slug}`" class="group block bg-white/10 rounded-2xl overflow-hidden border border-white/20 hover:border-white/40 hover:shadow-md transition-all duration-300">
              <div class="aspect-[4/3] bg-white/5 overflow-hidden relative">
                <img v-if="service.image_url" :src="service.image_url" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
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
              :src="settings.population_image || populationImage || '/images/population.png'"
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

    <!-- ═══════════════ CTA 1 — THEME COLOR ═══════════════ -->
    <section class="py-8 md:py-10">
      <div class="container mx-auto px-6">
        <div class="relative bg-gradient-to-br from-primary via-primary/85 to-accent rounded-3xl overflow-hidden shadow-lg">
          <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1633356122544-f134324ef6db?w=1200&q=40')] bg-cover bg-center"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-6 md:p-8 lg:p-10">
              <h2 class="text-xl md:text-2xl font-bold text-white leading-tight mb-3">Ready to Transform Your Business?</h2>
              <p class="text-white/90 text-xs leading-relaxed mb-2">Build innovative solutions with OmniviaTech. From custom software to AI-powered automation.</p>
              <p class="text-white/80 text-xs leading-relaxed mb-4">Expand your reach and grow revenue with us.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white text-primary text-xs font-semibold rounded-full hover:bg-white/90 transition-all shadow-md">
                Get Started
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <!-- <div class="hidden lg:flex items-center justify-end h-full min-h-[280px] py-8">
              <img src="https://images.unsplash.com/photo-1633356122544-f134324ef6db?w=500&h=400&fit=crop&q=80" alt="Technology" class="h-full max-h-[300px] object-cover rounded-2xl mr-6" />
            </div> -->
          </div>
        </div>
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
            <div class="relative rounded-2xl p-8 transition-all duration-300 overflow-hidden h-full shadow-lg hover:shadow-2xl transform group-hover:-translate-y-2" style="background-color: #1a1a1a; border: 1px solid #404040;" @mouseenter="$event.currentTarget.style.borderColor = '#3b82f6'" @mouseleave="$event.currentTarget.style.borderColor = '#404040'">
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
                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary transition-colors">{{ step.title }}</h3>
                <p class="text-white/80 text-sm leading-relaxed group-hover:text-white/90 transition-colors">{{ step.description }}</p>
              </div>

              <!-- Connector line (desktop only) -->
              <div v-if="idx < processSteps.length - 1" class="hidden lg:block absolute top-1/2 -right-3 w-6 h-px bg-gradient-to-r from-primary/60 to-transparent -translate-y-1/2"></div>
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
              <div class="relative rounded-2xl p-7 transition-all duration-300 overflow-hidden h-full shadow-lg hover:shadow-2xl transform group-hover:-translate-y-2" style="background-color: #262626; border: 1px solid #404040;" @mouseenter="$event.target.style.borderColor = '#3b82f6'" @mouseleave="$event.target.style.borderColor = '#404040'">              <!-- Animated background gradient -->
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
          :navigation="true"
          :autoplay="{ delay: 5000, disableOnInteraction: false }"
          :breakpoints="{ 480: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } }"
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
          :pagination="{ clickable: true }"
          :autoplay="{ delay: 5000, disableOnInteraction: false }"
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

    <!-- ═══════════════ CTA 2 — THEME COLOR ═══════════════ -->
    <section class="py-8 md:py-10">
      <div class="container mx-auto px-6">
        <div class="relative bg-gradient-to-br from-accent via-accent/85 to-primary rounded-3xl overflow-hidden shadow-lg">
          <div class="absolute inset-0 opacity-20 bg-[url('')] bg-cover bg-center"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-6 md:p-8 lg:p-10">
              <h2 class="text-xl md:text-2xl font-bold text-white leading-tight mb-3">Partner With Us</h2>
              <p class="text-white/90 text-xs leading-relaxed mb-2">Looking for innovators and problem-solvers to join our ecosystem. Expand your network and impact businesses.</p>
              <p class="text-white/80 text-xs leading-relaxed mb-4">Build expertise and earn with OmniviaTech.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white text-accent text-xs font-semibold rounded-full hover:bg-white/90 transition-all shadow-md">
                Apply Now
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <!-- <div class="hidden lg:flex items-center justify-end h-full min-h-[280px] py-8">
              <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&h=400&fit=crop&q=80" alt="Technology Partnership" class="h-full max-h-[300px] object-cover rounded-2xl mr-6" />
            </div> -->
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

      <!-- ═══════════════ CTA (MAROON) ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="relative bg-black rounded-2xl overflow-hidden">
          <div class="absolute inset-0 opacity-30 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
          <div class="absolute inset-0 bg-black/70"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-8 md:p-12 lg:p-14">
              <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Join Our Growing Team</h2>
              <p class="text-white/70 text-sm leading-relaxed mb-8">We're always looking for talented people who are passionate about technology and innovation.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg">
                Get In Touch
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
              <img :src="heroTech4" alt="Professional" class="h-full max-h-[350px] object-cover object-top" />
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

    <!-- ═══════════════ VIDEO CTA — AUTO-PLAY ON SCROLL ═══════════════ -->
    <section ref="videoCtaSection" class="relative w-full min-h-[70vh] md:min-h-[80vh] flex items-center justify-center overflow-hidden bg-neutral-900">
      <!-- Background video (auto-plays muted on scroll) -->
      <video
        ref="ctaVideoEl"
        class="absolute inset-0 w-full h-full object-cover"
        muted
        loop
        playsinline
        preload="metadata"
        :title="videoTitle"
      >
        <source :src="videoSrc" type="video/mp4" />
      </video>

      <!-- Dark overlay -->
      <div class="absolute inset-0 bg-black/50"></div>

      <!-- Content -->
      <div class="relative z-10 w-full">
        <div class="container mx-auto px-6 max-w-7xl">
          <div class="grid lg:grid-cols-2 items-center gap-8 lg:gap-12">
            <!-- Left: Text content -->
            <div class="text-center lg:text-left">
              <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight mb-4">
                Ready to Transform Your Business?
              </h2>
              <p class="text-white/90 text-sm leading-relaxed mb-3">
                Build innovative solutions with OmniviaTech. From custom software to AI-powered automation.
              </p>
              <p class="text-white/70 text-sm leading-relaxed mb-6">
                Expand your reach and grow revenue with us.
              </p>
              <router-link
                to="/contact"
                class="inline-flex items-center gap-2 px-8 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg"
              >
                Get Started
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <path d="M7 17L17 7M17 7H7M17 7v10"/>
                </svg>
              </router-link>
            </div>

            <!-- Right: Clickable video card with controls -->
            <div class="relative rounded-2xl overflow-hidden bg-black aspect-video group cursor-pointer border border-white/10 shadow-2xl" @click="toggleVideo">
              <!-- Play overlay when not actively playing with controls -->
              <transition name="fade">
                <div v-if="!videoPlaying" class="absolute inset-0 z-10 flex items-center justify-center">
                  <div class="absolute inset-0 bg-black/30"></div>
                  <button class="relative z-10 w-16 h-16 md:w-20 md:h-20 rounded-full bg-primary flex items-center justify-center shadow-2xl shadow-primary/40 transition-transform duration-200 group-hover:scale-110" aria-label="Play video">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M8 5v14l11-7z"/>
                    </svg>
                  </button>
                  <span class="absolute bottom-4 right-4 z-10 bg-black/70 text-white text-xs font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm">
                    {{ duration }}
                  </span>
                  <span class="absolute bottom-4 left-4 z-10 bg-primary/90 text-white text-xs font-semibold px-2.5 py-1 rounded-full flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <rect x="2" y="7" width="20" height="15" rx="2" ry="2"/>
                      <path d="M17 2l-5 5-5-5"/>
                    </svg>
                    CC
                  </span>
                </div>
              </transition>

              <!-- Active video player with sound + controls -->
              <video
                v-if="videoPlaying"
                ref="videoEl"
                class="absolute inset-0 w-full h-full object-cover"
                autoplay
                controls
                preload="metadata"
                :title="videoTitle"
                @ended="videoPlaying = false"
              >
                <source :src="videoSrc" type="video/mp4" />
                Your browser does not support the video tag.
              </video>
            </div>
          </div>
        </div>
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
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';
// @ts-ignore
import 'swiper/css';
// @ts-ignore
import 'swiper/css/pagination';
// @ts-ignore
import 'swiper/css/navigation';
import PublicLayout from '@/layouts/PublicLayout.vue';
import WishlistButton from '@/components/WishlistButton.vue';
import axios from 'axios';
import { useToast } from '@/composables';
import heroTechBg from '@/../img/tech-background.png';

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
    bg_image: 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&h=1080&fit=crop&q=80',
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
    bg_image: 'https://images.unsplash.com/photo-1633356122544-f134324ef6db?w=1920&h=1080&fit=crop&q=80',
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
    bg_image: 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=1920&h=1080&fit=crop&q=80',
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
    bg_image: 'https://images.unsplash.com/photo-1563206765-d96a38f1e23f?w=1920&h=1080&fit=crop&q=80',
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
    bg_image: 'https://images.unsplash.com/photo-1516321318423-f06f70e504cb?w=1920&h=1080&fit=crop&q=80',
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
    bg_image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1920&h=1080&fit=crop&q=80',
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
    bg_image: heroTechBg,
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

// Video CTA State
const videoSrc = 'resources/videos/omniviatech-solutions.mp4';
const videoTitle = 'OmniviaTech — Product Overview';
const duration = '2:45';
const videoPlaying = ref(false);
const videoEl = ref<HTMLVideoElement | null>(null);
const ctaVideoEl = ref<HTMLVideoElement | null>(null);
const videoCtaSection = ref<HTMLElement | null>(null);

function toggleVideo() {
  videoPlaying.value = !videoPlaying.value;
}

function shareVideo() {
  navigator.clipboard?.writeText(window.location.href);
}

function toggleFaq(idx: number) {
  openFaqIndex.value = openFaqIndex.value === idx ? null : idx;
}

// Auto-play background video on scroll into view
let ctaObserver: IntersectionObserver | null = null;

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

  // Auto-play video CTA when scrolled into view
  if (videoCtaSection.value && ctaVideoEl.value) {
    ctaObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          ctaVideoEl.value?.play().catch(() => {});
        } else {
          ctaVideoEl.value?.pause();
        }
      });
    }, { threshold: 0.3 });
    ctaObserver.observe(videoCtaSection.value);
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
</style>
