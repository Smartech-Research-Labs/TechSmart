<template>
  <PublicLayout>
    <!-- Loading -->
    <div v-if="loading" class="py-20 text-center">
      <div class="inline-block w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <template v-else-if="service">
      <!-- ═══════════════ 1. HERO SECTION ═══════════════ -->
      <section class="relative min-h-[50vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
          <img
            :src="getServiceImage(service) || service.image_url || heroLaptopDark"
            :alt="service.name"
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 py-16 md:py-24">
          <!-- Breadcrumbs -->
          <nav class="flex items-center gap-2 text-xs text-white/60 mb-6">
            <router-link to="/" class="hover:text-primary transition">Home</router-link>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <router-link to="/services" class="hover:text-primary transition">Services</router-link>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <span class="text-white font-medium">{{ service.name }}</span>
          </nav>

          <div class="max-w-2xl">
            <!-- Badges -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
              <span v-if="service.category" class="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full border border-primary/20">{{ service.category }}</span>
              <span v-if="service.category_group" class="px-3 py-1 text-xs font-medium bg-accent/10 text-accent-foreground rounded-full border border-border">{{ service.category_group }}</span>
              <span v-if="service.is_featured" class="px-3 py-1 text-xs font-semibold bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-full border border-amber-500/20">
                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Featured
              </span>
            </div>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">{{ service.name }}</h1>
            <p class="text-white/80 text-base md:text-lg leading-relaxed mb-8 max-w-xl">{{ service.short_description }}</p>

            <!-- CTA Buttons -->
            <div class="flex flex-wrap gap-3">
              <a href="#quote-form" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                Get a Quote
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </a>
              <a v-if="whatsappNumber" :href="`https://wa.me/${whatsappNumber}?text=Hi, I'm interested in ${encodeURIComponent(service.name)}`" target="_blank" class="inline-flex items-center gap-2 px-7 py-3 border border-green-500/30 bg-green-500/10 text-green-600 dark:text-green-400 text-sm font-semibold rounded-full hover:bg-green-500/20 transition-all">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.611.611l4.458-1.495A11.952 11.952 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.344 0-4.507-.793-6.226-2.127l-.354-.29-3.308 1.109 1.109-3.308-.29-.354A9.935 9.935 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                WhatsApp Us
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 2. ABOUT THE SERVICE ═══════════════ -->
      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left: Image -->
            <div class="relative rounded-2xl overflow-hidden">
              <img
                :src="getServiceImage(service) || service.image_url || heroLaptop"
                :alt="service.name"
                class="w-full aspect-[4/3] object-cover"
              />
            </div>

            <!-- Right: Description + Feature Highlights -->
            <div>
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About This Service</p>
              <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">{{ service.name }}</h2>
              <div class="text-muted-foreground text-sm leading-relaxed space-y-4 mb-8" v-html="service.description"></div>

              <!-- Quick Feature Highlights (first 4) -->
              <div v-if="features.length" class="space-y-3">
                <div v-for="(feature, i) in features.slice(0, 4)" :key="i" class="flex items-start gap-3">
                  <div class="mt-0.5 w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                  </div>
                  <span class="text-sm text-foreground font-medium">{{ typeof feature === 'string' ? feature : feature.title }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 3. FEATURE CARDS ═══════════════ -->
      <section v-if="features.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">What's Included</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Key Features & Deliverables</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Everything you get when you choose our {{ service.name }} service.</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            <div v-for="(feature, i) in features" :key="i" class="group bg-card border border-border rounded-xl p-5 hover:shadow-md hover:border-primary/20 transition-all">
              <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              </div>
              <h3 class="text-sm font-semibold text-foreground mb-1.5">{{ typeof feature === 'string' ? feature : feature.title }}</h3>
              <p v-if="typeof feature !== 'string' && feature.description" class="text-xs text-muted-foreground leading-relaxed">{{ feature.description }}</p>
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

      <!-- ═══════════════ 4. PROCESS / HOW IT WORKS ═══════════════ -->
      <section v-if="processSteps.length" class="py-10 md:py-14">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-8">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Approach</p>
            <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight mb-3">How We Deliver</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">A structured, transparent process designed for maximum impact.</p>
          </div>

          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 md:gap-3">
            <div v-for="(step, i) in processSteps" :key="i" class="relative">
              <div v-if="i < processSteps.length - 1" class="hidden lg:block absolute -top-1 left-1/2 z-10">
                <svg class="w-4 h-4 text-primary/30 -rotate-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
              </div>

              <div class="bg-card border border-border rounded-xl p-3 md:p-4 h-full hover:shadow-md hover:border-primary/20 transition-all text-center">
                <div class="w-8 h-8 md:w-10 md:h-10 mx-auto rounded-full bg-primary text-white text-xs md:text-sm font-bold flex items-center justify-center mb-2">{{ i + 1 }}</div>
                <h3 class="text-[11px] md:text-xs font-semibold text-foreground mb-1 leading-tight">{{ typeof step === 'string' ? step : step.title }}</h3>
                <p v-if="typeof step !== 'string' && step.description" class="text-[10px] md:text-[11px] text-muted-foreground leading-relaxed">{{ step.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ TECH STACK ═══════════════ -->
      <section class="py-10 md:py-14 bg-muted/20">
        <div class="container mx-auto px-6 max-w-5xl">
          <div class="text-center max-w-2xl mx-auto mb-8">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Toolkit</p>
            <h2 class="text-xl md:text-2xl font-bold text-foreground leading-tight mb-3">Technologies We Work With</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">We use battle-tested, modern tools to build solutions that are fast, scalable, and maintainable.</p>
          </div>

          <div class="flex flex-wrap justify-center gap-2 mb-8">
            <button v-for="cat in stackCategories" :key="cat.label" @click="activeStack = cat.label" class="px-4 py-1.5 rounded-full text-xs font-semibold border transition-all duration-200" :class="activeStack === cat.label ? 'bg-primary text-white border-primary shadow-sm shadow-primary/20' : 'border-border text-muted-foreground hover:border-primary/40 hover:text-primary'">{{ cat.label }}</button>
          </div>

          <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
            <div v-for="tech in activeStackTechs" :key="tech.name" class="group flex flex-col items-center gap-2 p-4 rounded-xl border border-border bg-card hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 cursor-default">
              <div class="w-10 h-10 flex items-center justify-center text-2xl shrink-0">
                <span v-html="tech.icon"></span>
              </div>
              <span class="text-[11px] font-semibold text-foreground text-center leading-tight group-hover:text-primary transition-colors">{{ tech.name }}</span>
            </div>
          </div>

          <p class="text-center text-muted-foreground text-xs mt-8">Don't see your stack? <router-link to="/contact" class="text-primary font-semibold hover:underline underline-offset-2">Talk to us — we adapt.</router-link></p>
        </div>
      </section>

      <!-- ═══════════════ 5. POPULATION IMPACTED ═══════════════ -->
      <section class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-3xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Global Impact</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Population Impacted</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Our solutions reach communities and organizations worldwide, driving data-driven decisions aligned with the UN's Sustainable Development Goals.</p>
          </div>

          <div class="grid lg:grid-cols-2 gap-8 items-stretch">
            <!-- Left: Globe Map -->
            <div class="rounded-2xl flex flex-col items-center justify-center min-h-[380px] relative overflow-hidden">
              <img :src="populationImg" alt="Population Impacted" class="absolute inset-0 w-full h-full object-contain" />
              <div class="absolute inset-0 bg-black/60"></div>
              <div class="relative flex flex-col items-center justify-center min-h-[380px] px-6">
              <p class="text-center mb-6">
                <span class="bg-primary text-white px-3 py-1.5 rounded text-sm font-semibold">Delivered</span>
                <span class="text-white/90 ml-2 text-sm italic">impactful projects across the globe.</span>
              </p>
              </div>
            </div>

            <!-- Right: Stats Grid -->
            <div class="grid grid-cols-2 gap-4 content-center">
              <div v-for="(stat, i) in impactStats" :key="i" class="bg-card border border-border rounded-xl p-5 text-center hover:shadow-sm hover:border-primary/20 transition-all">
                <div class="text-2xl md:text-3xl font-bold text-primary mb-1">{{ stat.value }}</div>
                <div class="text-muted-foreground text-xs font-medium">{{ stat.label }}</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 6. CASE STUDIES ═══════════════ -->
      <section class="py-14 md:py-20" :class="caseStudies.length ? '' : 'bg-muted/30'">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Success Stories</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Case Studies</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">See how our {{ service.name }} service has delivered real results for our clients.</p>
          </div>

          <div v-if="caseStudies.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <router-link v-for="cs in caseStudies" :key="cs.id" :to="`/case-studies/${cs.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all">
              <div class="aspect-[16/10] overflow-hidden">
                <img :src="cs.image_url || heroLaptop" :alt="cs.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              </div>
              <div class="p-5">
                <span v-if="cs.client_name" class="text-xs font-medium text-primary mb-2 block">{{ cs.client_name }}</span>
                <h3 class="text-base font-semibold text-foreground mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ cs.title }}</h3>
                <p class="text-xs text-muted-foreground line-clamp-2 mb-3">{{ cs.excerpt }}</p>
                <span class="text-xs font-semibold text-primary inline-flex items-center gap-1">
                  Read Case Study
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                </span>
              </div>
            </router-link>
          </div>

          <div v-else class="text-center py-10">
            <p class="text-muted-foreground text-sm">Case studies for this service are coming soon.</p>
          </div>

          <div class="text-center mt-8">
            <router-link to="/case-studies" class="inline-flex items-center gap-2 px-6 py-2.5 border border-border text-foreground text-sm font-medium rounded-full hover:bg-muted transition-all">
              View All Case Studies
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </router-link>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 7. BLOG / INSIGHTS ═══════════════ -->
      <section v-if="relatedBlogs.length" class="py-14 md:py-20" :class="caseStudies.length ? '' : 'bg-muted/30'">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Blog & Insights</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Related Articles</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Stay up to date with the latest insights about {{ service.category || service.name }}.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <router-link v-for="post in relatedBlogs.slice(0, 3)" :key="post.id" :to="`/blog/${post.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all">
              <div class="aspect-[16/10] overflow-hidden">
                <img :src="post.featured_image ? (post.featured_image.startsWith('http') ? post.featured_image : `/storage/${post.featured_image}`) : heroLaptop" :alt="post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              </div>
              <div class="p-5">
                <div class="flex items-center gap-2 mb-2">
                  <span v-if="post.category" class="text-[10px] font-medium bg-primary/10 text-primary px-2 py-0.5 rounded-full">{{ post.category }}</span>
                  <span class="text-[10px] text-muted-foreground">{{ formatDate(post.published_at) }}</span>
                </div>
                <h3 class="text-sm font-semibold text-foreground mb-1.5 group-hover:text-primary transition-colors line-clamp-2">{{ post.title }}</h3>
                <p class="text-xs text-muted-foreground line-clamp-2">{{ post.excerpt }}</p>
              </div>
            </router-link>
          </div>

          <div class="text-center mt-8">
            <router-link to="/blog" class="inline-flex items-center gap-2 px-6 py-2.5 border border-border text-foreground text-sm font-medium rounded-full hover:bg-muted transition-all">
              View All Articles
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </router-link>
          </div>
        </div>
      </section>

 <!-- ═══════════════ 8. RELATED SERVICES GRID ═══════════════ -->
      <section v-if="relatedServices.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">
              Explore More
            </p>

            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">
              Related Services
            </h2>

            <p class="text-muted-foreground text-sm leading-relaxed">
              Other services that complement {{ service.name }}.
            </p>
          </div>

<<<<<<< HEAD
          <Swiper
            :modules="[Autoplay, Navigation]"
            :slides-per-view="1"
            :space-between="20"
            :navigation="true"
            :autoplay="{ delay: 4000, disableOnInteraction: false }"
            :loop="relatedServices.length > 3"
            :breakpoints="{
              640: { slidesPerView: 2 },
              1024: { slidesPerView: 3 },
            }"
            class="related-swiper"
          >
            <SwiperSlide v-for="rel in relatedServices" :key="rel.id">
              <router-link :to="`/services/${rel.slug}`" class="group block bg-card border border-border rounded-xl overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all">
                <div class="aspect-[16/10] overflow-hidden">
                  <img :src="getServiceImage(rel) || rel.image_url || heroLaptop" :alt="rel.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </div>
                <div class="p-4">
                  <span v-if="rel.category" class="text-[10px] font-medium bg-primary/10 text-primary px-2 py-0.5 rounded-full">{{ rel.category }}</span>
                  <h3 class="text-sm font-semibold text-foreground mt-2 mb-1 group-hover:text-primary transition-colors">{{ rel.name }}</h3>
                  <p class="text-xs text-muted-foreground line-clamp-2">{{ rel.short_description }}</p>
                </div>
              </router-link>
            </SwiperSlide>
          </Swiper>
=======
          <!-- GRID LAYOUT -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <router-link
              v-for="rel in relatedServices"
              :key="rel.id"
              :to="`/services/${rel.slug}`"
              class="group flex flex-col bg-card border border-border rounded-2xl overflow-hidden hover:shadow-xl hover:border-primary/20 transition-all duration-300"
            >
              
              <!-- IMAGE -->
              <div class="relative h-56 overflow-hidden">
                <img
                  :src="getServiceImage(rel) || rel.image_url || heroTech7"
                  :alt="rel.name"
                  class="absolute inset-0 size-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
              </div>

              <!-- CONTENT -->
              <div class="flex flex-col flex-1 p-5">
                
                <span
                  v-if="rel.category"
                  class="w-fit text-[10px] font-medium bg-primary/10 text-primary px-2 py-1 rounded-full"
                >
                  {{ rel.category }}
                </span>

                <h3 class="text-base font-semibold text-foreground mt-3 mb-2 group-hover:text-primary transition-colors">
                  {{ rel.name }}
                </h3>

                <p class="text-sm text-muted-foreground line-clamp-3">
                  {{ rel.short_description }}
                </p>

              </div>
            </router-link>

          </div>
>>>>>>> 1d35d88c6706dd9b697d392f06392c3d55bff2cd
        </div>
      </section>

      <!-- ═══════════════ 8B. WHY CHOOSE US ═══════════════ -->
      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Us</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">The OmniviaTech Advantage</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Why leading organizations trust us for their {{ service.category || 'technology' }} needs.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="(benefit, i) in serviceBenefits" :key="i" class="group text-center">
              <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path v-if="i === 0" stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                  <path v-else-if="i === 1" stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  <path v-else-if="i === 2" stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                  <path v-else stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                </svg>
              </div>
              <h3 class="text-sm font-semibold text-foreground mb-2">{{ benefit.title }}</h3>
              <p class="text-xs text-muted-foreground leading-relaxed">{{ benefit.description }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 8C. INDUSTRIES / AREAS OF INTEREST ═══════════════ -->
      <section class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Industries We Serve</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Areas You Might Be Interested In</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Our {{ service.name }} service is tailored for various sectors and industries.</p>
          </div>

          <div v-if="industries.length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <router-link
              v-for="ind in industries.slice(0, 12)"
              :key="ind.id"
              :to="`/industries/${ind.slug}`"
              class="group flex flex-col items-center p-4 bg-card border border-border rounded-xl hover:shadow-md hover:border-primary/30 transition-all text-center"
            >
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary/5 to-accent/5 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <img
                  v-if="ind.icon_url"
                  :src="ind.icon_url"
                  :alt="ind.name"
                  class="w-7 h-7 object-contain"
                />
                <svg v-else class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                </svg>
              </div>
              <span class="text-xs font-medium text-foreground group-hover:text-primary transition-colors">{{ ind.name }}</span>
            </router-link>
          </div>
          <div v-else class="text-center py-10">
            <p class="text-muted-foreground text-sm">Industry-specific applications for this service are being added. <router-link to="/industries" class="text-primary font-semibold hover:underline">View all industries</router-link>.</p>
          </div>

          <div class="text-center mt-8">
            <router-link to="/industries" class="inline-flex items-center gap-2 px-6 py-2.5 border border-border text-foreground text-sm font-medium rounded-full hover:bg-muted transition-all">
              View All Industries
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </router-link>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 8D. TESTIMONIALS ═══════════════ -->
      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Client Testimonials</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">What Our Clients Say</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Hear from organizations that have transformed their operations with our solutions.</p>
          </div>

          <div v-if="testimonials.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="(testimonial, i) in testimonials.slice(0, 3)" :key="i" class="bg-card border border-border rounded-xl p-6 hover:shadow-md hover:border-primary/20 transition-all">
              <!-- Stars -->
              <div class="flex gap-1 mb-4">
                <svg v-for="s in 5" :key="s" class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
              </div>
              <!-- Quote -->
              <p class="text-sm text-muted-foreground leading-relaxed mb-4 italic">"{{ testimonial.content }}"</p>
              <!-- Author -->
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                  <span class="text-sm font-semibold text-primary">{{ testimonial.name?.charAt(0) || 'C' }}</span>
                </div>
                <div>
                  <p class="text-sm font-semibold text-foreground">{{ testimonial.name }}</p>
                  <p class="text-xs text-muted-foreground">{{ testimonial.position }}{{ testimonial.company ? `, ${testimonial.company}` : '' }}</p>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-10">
            <p class="text-muted-foreground text-sm">Testimonials for this service are being collected. <router-link to="/contact" class="text-primary font-semibold hover:underline">Share your experience</router-link>.</p>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 8E. FAQ SECTION ═══════════════ -->
      <section class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Frequently Asked Questions</p>
              <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Have Questions?</h2>
              <p class="text-muted-foreground text-sm leading-relaxed">Find answers to common questions about our {{ service.name }} service.</p>
            </div>

            <div v-if="faqs.length">
              <div class="space-y-3">
                <div
                  v-for="(faq, i) in faqs.slice(0, 6)"
                  :key="i"
                  class="bg-card border border-border rounded-xl overflow-hidden"
                >
                  <button
                    @click="toggleFaq(i)"
                    class="w-full flex items-center justify-between p-5 text-left"
                  >
                    <span class="text-sm font-semibold text-foreground pr-4">{{ faq.question }}</span>
                    <svg
                      :class="['w-5 h-5 text-muted-foreground transition-transform flex-shrink-0', openFaqIndex === i ? 'rotate-180' : '']"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      viewBox="0 0 24 24"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                  </button>
                  <div v-show="openFaqIndex === i" class="px-5 pb-5">
                    <p class="text-sm text-muted-foreground leading-relaxed">{{ faq.answer }}</p>
                  </div>
                </div>
              </div>

              <div class="text-center mt-8">
                <p class="text-sm text-muted-foreground mb-3">Still have questions?</p>
                <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-sm font-medium rounded-full hover:bg-primary/90 transition-all">
                  Contact Our Team
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </router-link>
              </div>
            </div>
            <div v-else class="text-center py-10">
              <p class="text-muted-foreground text-sm">FAQs for this service are being prepared. <router-link to="/contact" class="text-primary font-semibold hover:underline">Ask us anything</router-link>.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 8F. TRUST BADGES ═══════════════ -->
      <section class="py-10 md:py-14">
        <div class="container mx-auto px-6">
          <div class="text-center mb-8">
            <p class="text-xs text-muted-foreground font-medium uppercase tracking-wider">Trusted By Leading Organizations</p>
          </div>
          <div class="flex flex-wrap items-center justify-center gap-8 md:gap-12 opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-500">
            <div v-for="badge in trustBadges" :key="badge.name" class="flex flex-col items-center gap-2">
              <div class="w-16 h-16 bg-muted/50 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8 text-foreground/60" fill="currentColor" viewBox="0 0 24 24">
                  <path v-if="badge.icon === 'shield'" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                  <path v-else-if="badge.icon === 'award'" d="M12 15l-2 5.54.18-.55L8.5 18l-1.68 1.99.18-.55L5 20.98l3.54-2.09L12 15zm0 0l2 5.54-.18-.55 1.68 1.99L17.18 20l-.18.55 2 1.44-3.54-2.09L12 15zm0 0l-2-5.54-.18-.55-1.68-1.99.18.55-2-1.44 3.54 2.09L12 15zm0 0l2-5.54.18-.55 1.68-1.99-.18.55 2-1.44-3.54 2.09L12 15z"/>
                  <path v-else d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <span class="text-[10px] font-medium text-muted-foreground text-center">{{ badge.name }}</span>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ MISSION & VISION ═══════════════ -->
      <section class="py-12 md:py-16" style="background-color: #ffffff;">
        <div class="container mx-auto px-6 max-w-5xl">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Purpose</p>
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">Mission & Vision</h2>
            <p class="text-gray-600 text-sm leading-relaxed mt-3">The principles that shape every decision we make, and the future we are building toward.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative group rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl" style="background-color: #d311f5; border: 1px solid #d311f5;">
              <div class="absolute inset-0 opacity-0 group-hover:opacity-20 bg-gradient-to-br from-primary/20 to-primary/10 transition-opacity duration-500 pointer-events-none"></div>
              <div class="absolute -top-8 -right-8 w-32 h-32 bg-primary/5 rounded-full group-hover:scale-150 group-hover:bg-primary/10 transition-all duration-500 pointer-events-none"></div>
              <div class="h-1 w-full bg-gradient-to-r from-primary to-primary/40"></div>
              <div class="relative z-10 p-8">
                <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-3">Our Mission</h3>
                <p class="text-white/80 text-sm leading-relaxed mb-6">To empower businesses across Africa and beyond with innovative, scalable, and reliable technology solutions that drive measurable growth, improve operational efficiency, and create lasting impact in the communities we serve.</p>
                <ul class="space-y-3">
                  <li v-for="pillar in missionPillars" :key="pillar" class="flex items-start gap-3">
                    <div class="w-5 h-5 bg-white rounded-full flex items-center justify-center shrink-0 mt-0.5">
                      <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-white/75 text-xs leading-relaxed">{{ pillar }}</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="relative group rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl" style="background-color: #3b82f6; border: 1px solid #3b82f6;">
              <div class="absolute inset-0 opacity-0 group-hover:opacity-20 bg-gradient-to-br from-accent/20 to-accent/10 transition-opacity duration-500 pointer-events-none"></div>
              <div class="absolute -top-8 -right-8 w-32 h-32 bg-accent/5 rounded-full group-hover:scale-150 group-hover:bg-accent/10 transition-all duration-500 pointer-events-none"></div>
              <div class="h-1 w-full bg-gradient-to-r from-accent to-accent/40"></div>
              <div class="relative z-10 p-8">
                <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-3">Our Vision</h3>
                <p class="text-white/80 text-sm leading-relaxed mb-6">To be Africa's most trusted technology partner — a company recognised globally for building transformative digital infrastructure that bridges the gap between ambition and achievement for businesses of every size.</p>
                <div class="space-y-4">
                  <div v-for="horizon in visionHorizons" :key="horizon.label" class="flex items-start gap-3">
                    <div class="shrink-0 mt-0.5">
                      <span class="inline-block text-xs font-bold text-accent bg-white px-2 py-0.5 rounded-full">{{ horizon.label }}</span>
                    </div>
                    <span class="text-white/75 text-xs leading-relaxed">{{ horizon.text }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div v-for="val in missionValues" :key="val.label" class="text-center px-4 py-5 rounded-xl transition-all duration-200 hover:-translate-y-0.5" style="background-color: #1a1a1a; border: 1px solid #404040;">
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
    </template>

    <!-- Not Found -->
    <div v-else class="py-20 text-center">
      <h2 class="text-2xl font-bold text-foreground mb-2">Service Not Found</h2>
      <p class="text-muted-foreground mb-6">The service you're looking for doesn't exist or has been removed.</p>
      <router-link to="/services" class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition">Browse Services</router-link>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { Autoplay, Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import heroLaptop from '@/../img/Laptop.webp';
<<<<<<< HEAD
=======
import heroOrbit from '@/../img/Orbit.webp';
import populationImg from '@/../img/population.webp';
>>>>>>> 1d35d88c6706dd9b697d392f06392c3d55bff2cd
import svcApi from '@/../img/services/API Development.webp';
import svcCrmErp from '@/../img/services/CRM & ERP Development.webp';
import svcCustomWeb from '@/../img/services/Custom Web Development.webp';
import svcEcommerce from '@/../img/services/E-commerece Development.webp';
import svcMobileApp from '@/../img/services/Mobile App Development.webp';
import svcMobileApp2 from '@/../img/services/Mobile App.webp';
import svcPaidAds from '@/../img/services/Paid Ads.webp';
import svcSeo from '@/../img/services/SEO Optimization.webp';
<<<<<<< HEAD
import heroLaptopDark from '@/../img/tech-background.png';
=======
import heroLaptopDark from '@/../img/tech-background.webp';
import heroTechBg from '@/../img/tech-background.webp';
import heroTech from '@/../img/tech.webp';
import heroTech1 from '@/../img/tech1.webp';
import heroTech2 from '@/../img/tech2.webp';
import heroTech3 from '@/../img/tech3.webp';
import heroTech4 from '@/../img/tech4.webp';
import heroTech5 from '@/../img/tech5.webp';
import heroTech6 from '@/../img/tech6.webp';
import heroTech7 from '@/../img/tech7.webp';
import heroTech8 from '@/../img/tech8.webp';
>>>>>>> 1d35d88c6706dd9b697d392f06392c3d55bff2cd
import heroTechGlow from '@/../img/tech-glow.webp';
import PublicLayout from '@/layouts/PublicLayout.vue';
import api from '@/services/api';
import { useCmsStore } from '@/stores/cms';
// Swiper styles are imported globally in the main layout
// import 'swiper/css';
// import 'swiper/css/navigation';

const serviceImageMap: Record<string, string> = {
  'custom web development': svcCustomWeb,
  'web development': svcCustomWeb,
  'custom web app development': svcCustomWeb,
  'web app development': svcCustomWeb,
  'mobile app development': svcMobileApp,
  'mobile app': svcMobileApp2,
  'mobile development': svcMobileApp,
  'e-commerce development': svcEcommerce,
  'ecommerce development': svcEcommerce,
  'e-commerce': svcEcommerce,
  'crm & erp development': svcCrmErp,
  'crm & erp': svcCrmErp,
  'erp development': svcCrmErp,
  'crm development': svcCrmErp,
  'api development': svcApi,
  'api integration': svcApi,
  'api': svcApi,
  'seo optimization': svcSeo,
  'seo': svcSeo,
  'search engine optimization': svcSeo,
  'paid ads': svcPaidAds,
  'paid advertising': svcPaidAds,
  'ppc': svcPaidAds,
  'digital marketing': svcPaidAds,
  'social media marketing': svcPaidAds,
  'business intelligence': svcApi,
  'automation': svcApi,
  'testing': svcApi,
  'devops': svcApi,
  'cloud deployment': svcApi,
  'audit trail': svcCrmErp,
  'cybersecurity': svcCrmErp,
  'data protection': svcCrmErp,
  'ui/ux': svcCustomWeb,
  'ux design': svcCustomWeb,
  'website maintenance': svcCustomWeb,
  'conversion rate': svcCustomWeb,
  'performance': svcCustomWeb,
};

function getServiceImage(service: any): string | null {
  const title = (service.title || service.name || '').toLowerCase().trim();
  const slug = (service.slug || '').toLowerCase().trim();
  const category = (service.category || '').toLowerCase().trim();
  if (serviceImageMap[title]) return serviceImageMap[title];
  if (serviceImageMap[slug]) return serviceImageMap[slug];
  if (serviceImageMap[category]) return serviceImageMap[category];
  for (const [key, img] of Object.entries(serviceImageMap)) {
    if (title.includes(key) || slug.includes(key) || category.includes(key)) return img;
  }
  return svcCustomWeb;
}
<<<<<<< HEAD
=======
import { computed, ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Navigation } from 'swiper/modules';
import PublicLayout from '@/layouts/PublicLayout.vue';
import api from '@/services/api';
import { useCmsStore } from '@/stores/cms';
import { useToast } from '@/composables';
import heroCTAbg from '@/../img/tech8.webp';
// Swiper styles are imported globally in the main layout
// import 'swiper/css';
// import 'swiper/css/navigation';
>>>>>>> 1d35d88c6706dd9b697d392f06392c3d55bff2cd

const route = useRoute();
const cmsStore = useCmsStore();
const toast = useToast();
const settings = ref<any>({});
const loading = ref(true);
const service = ref<any>(null);
const relatedServices = ref<any[]>([]);
const caseStudies = ref<any[]>([]);
const relatedBlogs = ref<any[]>([]);
const features = ref<any[]>([]);
const processSteps = ref<any[]>([]);
const whatsappNumber = ref('');
const allServices = ref<any[]>([]);
const quoteForm = ref({ name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' });
const quoteFormSubmitting = ref(false);

// New sections data
const industries = ref<any[]>([]);
const testimonials = ref<any[]>([]);
const faqs = ref<any[]>([]);
const openFaqIndex = ref<number | null>(null);

// Service benefits (static - can be overridden by API)
const serviceBenefits = ref([
  { title: 'Expert Team', description: 'Our specialists bring years of experience and deep domain expertise to every project.' },
  { title: 'Fast Delivery', description: 'Agile methodology ensures quick turnaround without compromising quality.' },
  { title: 'Dedicated Support', description: '24/7 support and ongoing maintenance to keep your solutions running smoothly.' },
  { title: 'Proven Results', description: 'Track record of delivering measurable outcomes and ROI for our clients.' },
]);

// Trust badges
const trustBadges = ref([
  { name: 'ISO 27001 Certified', icon: 'shield' },
  { name: 'GDPR Compliant', icon: 'shield' },
  { name: 'Award Winner', icon: 'award' },
  { name: 'Verified Partner', icon: 'check' },
]);





// Impact stats (static fallback – CMS can override)
const impactStats = ref([
  { value: '20+', label: 'Countries Reached' },
  { value: '500K+', label: 'People Impacted' },
  { value: '150+', label: 'Projects Completed' },
  { value: '95%', label: 'Client Satisfaction' },
]);

// Tech stack
const stackCategories = [
  { label: 'Frontend' },
  { label: 'Backend' },
  { label: 'Mobile' },
  { label: 'Database' },
  { label: 'DevOps' },
  { label: 'Design' },
];

const stackData: Record<string, { name: string; icon: string }[]> = {
  Frontend: [
    { name: 'Vue.js', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#4fc08d"><path d="M24 1.61h-9.94L12 5.16 9.94 1.61H0l12 20.78ZM12 14.08 5.38 3.77h3.14L12 9.6l3.48-5.83h3.14Z"/></svg>' },
    { name: 'React', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#61dafb"><path d="M12 2.5c-2.5 0-4.5 1.5-6 3.5s-2.5 4.5-2.5 6 1 4 2.5 6 3.5 3.5 6 3.5 4.5-1.5 6-3.5 2.5-4.5 2.5-6-1-4-2.5-6S14.5 2.5 12 2.5zm0 1c1.8 0 3.4 1 4.5 2.5 1.2 1.5 1.8 3.5 1.8 5.5s-.6 4-1.8 5.5C15.4 18.5 13.8 19.5 12 19.5s-3.4-1-4.5-2.5C6.3 15.5 5.7 13.5 5.7 11.5s.6-4 1.8-5.5C8.6 4.5 10.2 3.5 12 3.5z"/></svg>' },
    { name: 'Next.js', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#000"><path d="M18.665 21.978C16.758 23.255 14.465 24 12 24 5.377 24 0 18.623 0 12S5.377 0 12 0s12 5.377 12 12c0 3.583-1.574 6.801-4.067 9.001L9.219 7.2H7.2v9.596h1.941V9.251l6.729 8.982c.626-.258 1.194-.587 1.695-.97L9.747 7.2H9.136v9.596h1.941V9.251l6.729 8.982c.626-.258 1.194-.587 1.695-.97z"/></svg>' },
    { name: 'TypeScript', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#3178c6"><path d="M3 3h18v18H3V3zm10.25 14.25v-2.25h1.5v2.25c0 .75.375 1.125 1.125 1.125h1.125c.75 0 1.125-.375 1.125-1.125v-2.25h1.5v2.25c0 1.5-1.05 2.475-2.625 2.475h-1.125c-1.575 0-2.625-.975-2.625-2.475zm-4.875-6.45h2.25v7.95h1.5v-7.95h2.25V7.5h-6v3.3z"/></svg>' },
    { name: 'Tailwind', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#06b6d4"><path d="M12 6C9.33 6 7.5 7.5 6.5 10c1-2 2.5-3 4.5-3s3.5 1 4.5 3c1-2 2.5-3 4.5-3-1-2.5-2.83-4-5.5-4zm0 12c2.67 0 4.5-1.5 5.5-4-1 2-2.5 3-4.5 3s-3.5-1-4.5-3c-1 2-2.5 3-4.5 3 1 2.5 2.83 4 5.5 4z"/></svg>' },
    { name: 'Alpine.js', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#77c1d2"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>' },
  ],
  Backend: [
    { name: 'Laravel', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#ff2d20"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm0 22C6.49 22 2 17.51 2 12S6.49 2 12 2s10 4.49 10 10-4.49 10-10 10z"/></svg>' },
    { name: 'Node.js', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#339933"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Python', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#3776ab"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'PHP', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#777bb4"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Go', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#00add8"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Rust', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#dea584"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
  ],
  Mobile: [
    { name: 'React Native', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#61dafb"><path d="M12 2.5c-2.5 0-4.5 1.5-6 3.5s-2.5 4.5-2.5 6 1 4 2.5 6 3.5 3.5 6 3.5 4.5-1.5 6-3.5 2.5-4.5 2.5-6-1-4-2.5-6S14.5 2.5 12 2.5z"/></svg>' },
    { name: 'Flutter', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#02569b"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Swift', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#f05138"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Kotlin', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#7f52ff"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Ionic', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#3880ff"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
  ],
  Database: [
    { name: 'MySQL', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#4479a1"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'PostgreSQL', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#4169e1"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'MongoDB', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#47a248"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Redis', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#dc382d"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'SQLite', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#003b57"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
  ],
  DevOps: [
    { name: 'Docker', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#2496ed"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'AWS', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#ff9900"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Kubernetes', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#326ce5"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'CI/CD', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#fc6d26"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Nginx', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#009639"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
  ],
  Design: [
    { name: 'Figma', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#f24e1e"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Adobe XD', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#ff61f6"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Sketch', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#f7b500"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Photoshop', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#31a8ff"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
    { name: 'Illustrator', icon: '<svg viewBox="0 0 24 24" width="24" height="24" fill="#ff9a00"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0z"/></svg>' },
  ],
};

const activeStack = ref('Frontend');

const activeStackTechs = computed(() => stackData[activeStack.value] || []);

function setCardBorderColor(event: MouseEvent, color: string) {}

// Mission & Vision
const missionPillars = [
  'Innovation-driven development for measurable business outcomes',
  'Scalable and secure architecture built for African and global markets',
  'Client-first partnership with transparent communication at every step',
];

const visionHorizons = [
  { label: '2026', text: 'Expand into 10 African markets with local delivery hubs' },
  { label: '2028', text: 'Launch a flagship SaaS platform serving 50,000+ businesses' },
  { label: '2030', text: 'Recognised as Africa\'s top technology partner globally' },
];

const missionValues = [
  { icon: '🚀', label: 'Innovation', desc: 'Pushing boundaries with emerging tech' },
  { icon: '🤝', label: 'Partnership', desc: 'Your success is our success' },
  { icon: '🎯', label: 'Excellence', desc: 'Relentless pursuit of quality' },
  { icon: '🌍', label: 'Impact', desc: 'Building for Africa & beyond' },
];

async function fetchService(slug: string) {
  loading.value = true;
  try {
    const { data: d } = await api.get(`/api/v1/services/${slug}`);
    service.value = d.service;
    relatedServices.value = d.related || [];
    caseStudies.value = d.case_studies || [];
    relatedBlogs.value = d.related_blogs || [];

    // Parse JSON features & process steps
    if (service.value) {
      try {
        const f = service.value.features;
        features.value = typeof f === 'string' ? JSON.parse(f) : (Array.isArray(f) ? f : []);
      } catch {
        features.value = [];
      }
      try {
        const p = service.value.process_steps;
        processSteps.value = typeof p === 'string' ? JSON.parse(p) : (Array.isArray(p) ? p : []);
      } catch {
        processSteps.value = [];
      }
    }
  } catch (e: any) {
    console.error('Failed to load service', e);
    service.value = null;
  } finally {
    loading.value = false;
  }
}

function formatDate(dateStr: string) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

// Toggle FAQ accordion
function toggleFaq(index: number) {
  openFaqIndex.value = openFaqIndex.value === index ? null : index;
}

// Fetch additional data for new sections
async function fetchAdditionalData() {
  try {
    // Fetch industries
    const industriesRes = await api.get('/api/v1/industries?limit=12');
    industries.value = industriesRes.data.data || industriesRes.data.industries || [];
  } catch {
    industries.value = [];
  }

  try {
    // Fetch testimonials/reviews
    const reviewsRes = await api.get('/api/v1/reviews?status=approved&limit=6');
    testimonials.value = reviewsRes.data.data || reviewsRes.data.reviews || [];
  } catch {
    testimonials.value = [];
  }

  try {
    // Fetch FAQs related to service category
    const category = service.value?.category || 'general';
    const faqsRes = await api.get(`/api/v1/faqs?category=${encodeURIComponent(category)}&limit=6`);
    faqs.value = faqsRes.data.data || faqsRes.data.faqs || [];
    // Fallback to general FAQs if none found
    if (faqs.value.length === 0) {
      const generalFaqsRes = await api.get('/api/v1/faqs?limit=6');
      faqs.value = generalFaqsRes.data.data || generalFaqsRes.data.faqs || [];
    }
  } catch {
    faqs.value = [];
  }

  try {
    // Fetch all services for quote form dropdown
    const servicesRes = await api.get('/api/v1/services?limit=50');
    allServices.value = servicesRes.data?.data || [];
  } catch {
    allServices.value = [];
  }
}

async function submitQuoteRequest() {
  quoteFormSubmitting.value = true;
  try {
    await api.post('/api/v1/enquiries', {
      type: 'quote', name: quoteForm.value.name, email: quoteForm.value.email,
      phone: quoteForm.value.phone, service: quoteForm.value.service,
      message: quoteForm.value.description, budget: quoteForm.value.budget, timeline: quoteForm.value.timeline,
    });
    toast.success('Quote request submitted! We will contact you within 24 hours.');
    quoteForm.value = { name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' };
  } catch { toast.error('Failed to submit quote request. Please try again.'); }
  finally { quoteFormSubmitting.value = false; }
}

onMounted(async () => {
  // Get settings from CMS store
  const cmsSettings = cmsStore.homeData?.settings;
  if (cmsSettings) {
    settings.value = cmsSettings;
    whatsappNumber.value = cmsSettings.whatsapp_number || (cmsSettings as any).whatsapp || '';
  }
  await fetchService(route.params.slug as string);
  // Fetch additional data after service is loaded
  await fetchAdditionalData();
});

watch(() => route.params.slug, (newSlug) => {
  if (newSlug) fetchService(newSlug as string);
});
</script>

<style scoped>
.related-swiper :deep(.swiper-button-next),
.related-swiper :deep(.swiper-button-prev) {
  color: hsl(var(--primary));
  --swiper-navigation-size: 24px;
}

.related-swiper :deep(.swiper-button-next::after),
.related-swiper :deep(.swiper-button-prev::after) {
  font-size: 18px;
  font-weight: bold;
}
</style>
