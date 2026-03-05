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
            :src="service.image_url || 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&h=1080&fit=crop&q=80'"
            :alt="service.name"
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-gradient-to-r from-background/95 via-background/85 to-background/50 dark:from-background/95 dark:via-background/85 dark:to-background/60"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 py-16 md:py-24">
          <!-- Breadcrumbs -->
          <nav class="flex items-center gap-2 text-xs text-muted-foreground mb-6">
            <router-link to="/" class="hover:text-primary transition">Home</router-link>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <router-link to="/services" class="hover:text-primary transition">Services</router-link>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <span class="text-foreground font-medium">{{ service.name }}</span>
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

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-foreground leading-tight mb-4">{{ service.name }}</h1>
            <p class="text-muted-foreground text-base md:text-lg leading-relaxed mb-8 max-w-xl">{{ service.short_description }}</p>

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
            <!-- Left: Image with Price Badge -->
            <div class="relative rounded-2xl overflow-hidden">
              <img
                :src="service.image_url || 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800&h=600&fit=crop&q=80'"
                :alt="service.name"
                class="w-full aspect-[4/3] object-cover"
              />
              <!-- Price Badge Overlay -->
              <div v-if="service.price_from" class="absolute bottom-4 left-4 bg-white/95 dark:bg-card/95 backdrop-blur px-4 py-2 rounded-xl shadow-lg">
                <p class="text-xs text-muted-foreground">{{ service.price_label || 'Starting from' }}</p>
                <p class="text-xl font-bold text-primary">KES {{ Number(service.price_from).toLocaleString() }}</p>
              </div>
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

      <!-- ═══════════════ 4. PROCESS / HOW IT WORKS ═══════════════ -->
      <section v-if="processSteps.length" class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Approach</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">How We Deliver</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">A structured, transparent process designed for maximum impact.</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="(step, i) in processSteps" :key="i" class="relative">
              <!-- Connector Arrow -->
              <div v-if="i < processSteps.length - 1" class="hidden lg:block absolute top-10 -right-3 z-10">
                <svg class="w-6 h-6 text-primary/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
              </div>

              <div class="bg-card border border-border rounded-xl p-6 h-full hover:shadow-md hover:border-primary/20 transition-all text-center">
                <!-- Step Number -->
                <div class="w-12 h-12 mx-auto rounded-full bg-primary text-white text-lg font-bold flex items-center justify-center mb-4">{{ i + 1 }}</div>
                <h3 class="text-sm font-semibold text-foreground mb-2">{{ typeof step === 'string' ? step : step.title }}</h3>
                <p v-if="typeof step !== 'string' && step.description" class="text-xs text-muted-foreground leading-relaxed">{{ step.description }}</p>
              </div>
            </div>
          </div>
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
            <div class="bg-gradient-to-br from-red-800 via-red-700 to-red-900 rounded-2xl p-8 flex flex-col items-center justify-center min-h-[380px]">
              <p class="text-center mb-6">
                <span class="bg-primary text-white px-3 py-1.5 rounded text-sm font-semibold">Delivered</span>
                <span class="text-white/90 ml-2 text-sm italic">impactful projects across the globe.</span>
              </p>
              <div class="flex-1 flex items-center justify-center w-full px-4">
                <svg viewBox="0 0 1000 500" class="w-full max-w-[400px] h-auto opacity-90" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g fill="white" fill-opacity="0.85">
                    <path d="M150,100 L180,80 L220,75 L260,85 L280,100 L290,120 L285,145 L270,170 L250,190 L220,195 L200,200 L180,210 L160,220 L140,215 L130,200 L125,180 L120,160 L125,140 L135,120 Z"/>
                    <path d="M170,220 L185,225 L195,240 L190,260 L180,270 L170,265 L165,250 L160,235 Z"/>
                    <path d="M220,270 L240,265 L260,270 L275,290 L280,320 L275,360 L265,390 L250,410 L235,420 L225,400 L220,370 L215,340 L210,310 L215,290 Z"/>
                    <path d="M440,80 L460,75 L480,80 L500,85 L510,95 L505,115 L500,130 L490,140 L470,145 L455,140 L445,130 L440,115 L435,100 Z"/>
                    <path d="M460,160 L480,155 L500,160 L520,175 L530,200 L535,230 L530,260 L525,290 L515,320 L500,340 L485,350 L470,340 L460,320 L455,290 L450,260 L448,230 L450,200 L452,175 Z"/>
                    <path d="M530,70 L570,60 L620,55 L670,60 L720,70 L760,85 L790,100 L800,120 L790,145 L770,160 L740,170 L710,175 L680,170 L650,165 L620,155 L590,150 L560,140 L540,125 L530,105 Z"/>
                    <path d="M640,175 L660,180 L670,200 L665,225 L655,245 L640,255 L630,240 L625,220 L630,195 Z"/>
                    <path d="M710,180 L730,175 L745,185 L750,200 L740,215 L725,220 L715,210 L710,195 Z"/>
                    <path d="M750,310 L780,300 L810,305 L835,315 L845,335 L840,355 L825,370 L800,375 L775,370 L760,355 L755,335 Z"/>
                    <path d="M420,85 L430,80 L438,88 L435,98 L425,100 L418,95 Z"/>
                    <path d="M810,100 L818,95 L825,100 L822,115 L815,125 L808,118 L805,108 Z"/>
                    <path d="M540,150 L560,145 L575,155 L580,170 L570,180 L555,178 L545,170 Z"/>
                  </g>
                  <g>
                    <circle cx="200" cy="150" r="6" fill="#10b981" class="animate-pulse"/>
                    <circle cx="475" cy="115" r="6" fill="#10b981" class="animate-pulse"/>
                    <circle cx="490" cy="260" r="6" fill="#10b981" class="animate-pulse"/>
                    <circle cx="650" cy="120" r="6" fill="#10b981" class="animate-pulse"/>
                    <circle cx="780" cy="340" r="6" fill="#10b981" class="animate-pulse"/>
                    <circle cx="650" cy="215" r="6" fill="#10b981" class="animate-pulse"/>
                    <circle cx="250" cy="340" r="6" fill="#10b981" class="animate-pulse"/>
                    <circle cx="740" cy="200" r="6" fill="#10b981" class="animate-pulse"/>
                  </g>
                </svg>
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
      <section v-if="caseStudies.length" class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Success Stories</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Case Studies</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">See how our {{ service.name }} service has delivered real results for our clients.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <router-link v-for="cs in caseStudies" :key="cs.id" :to="`/case-studies/${cs.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all">
              <div class="aspect-[16/10] overflow-hidden">
                <img :src="cs.image_url || 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop&q=80'" :alt="cs.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
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
                <img :src="post.featured_image ? (post.featured_image.startsWith('http') ? post.featured_image : `/storage/${post.featured_image}`) : 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&h=400&fit=crop&q=80'" :alt="post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
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

      <!-- ═══════════════ 8. RELATED SERVICES CAROUSEL ═══════════════ -->
      <section v-if="relatedServices.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Explore More</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Related Services</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Other services that complement {{ service.name }}.</p>
          </div>

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
                  <img :src="rel.image_url || 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=600&h=400&fit=crop&q=80'" :alt="rel.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </div>
                <div class="p-4">
                  <span v-if="rel.category" class="text-[10px] font-medium bg-primary/10 text-primary px-2 py-0.5 rounded-full">{{ rel.category }}</span>
                  <h3 class="text-sm font-semibold text-foreground mt-2 mb-1 group-hover:text-primary transition-colors">{{ rel.name }}</h3>
                  <p class="text-xs text-muted-foreground line-clamp-2">{{ rel.short_description }}</p>
                </div>
              </router-link>
            </SwiperSlide>
          </Swiper>
        </div>
      </section>

      <!-- ═══════════════ 9. CTA BANNER ═══════════════ -->
      <section class="py-16 md:py-20 bg-gradient-to-r from-red-800 via-red-700 to-red-900 text-white">
        <div class="container mx-auto px-6 text-center">
          <h2 class="text-2xl md:text-3xl font-bold mb-4">Ready to Get Started?</h2>
          <p class="text-white/80 text-sm max-w-lg mx-auto mb-8">Let our experts help you leverage {{ service.name }} to transform your business. Contact us today for a free consultation.</p>
          <div class="flex flex-wrap justify-center gap-3">
            <a href="#quote-form" class="inline-flex items-center gap-2 px-7 py-3 bg-white text-red-800 text-sm font-semibold rounded-full hover:bg-white/90 transition-all shadow-lg">
              Request a Quote
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </a>
            <router-link to="/contact" class="px-7 py-3 border border-white/30 text-white text-sm font-medium rounded-full hover:bg-white/10 transition-all">Contact Us</router-link>
          </div>
        </div>
      </section>

      <!-- ═══════════════ 10. QUOTE / ENQUIRY FORM ═══════════════ -->
      <section id="quote-form" class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="max-w-2xl mx-auto">
            <div class="text-center mb-10">
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Get in Touch</p>
              <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Request a Quote</h2>
              <p class="text-muted-foreground text-sm leading-relaxed">Fill out the form below and our team will get back to you within 24 hours.</p>
            </div>

            <form @submit.prevent="submitQuote" class="space-y-5">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                  <label class="block text-xs font-medium text-foreground mb-1.5">Full Name *</label>
                  <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" placeholder="Your name" />
                </div>
                <div>
                  <label class="block text-xs font-medium text-foreground mb-1.5">Email Address *</label>
                  <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" placeholder="you@company.com" />
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                  <label class="block text-xs font-medium text-foreground mb-1.5">Phone</label>
                  <input v-model="quoteForm.phone" type="tel" class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" placeholder="+254 7XX XXX XXX" />
                </div>
                <div>
                  <label class="block text-xs font-medium text-foreground mb-1.5">Company</label>
                  <input v-model="quoteForm.company" type="text" class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition" placeholder="Your company name" />
                </div>
              </div>

              <div>
                <label class="block text-xs font-medium text-foreground mb-1.5">Service</label>
                <input :value="service.name" disabled class="w-full px-4 py-2.5 rounded-lg border border-border bg-muted text-foreground text-sm cursor-not-allowed" />
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                  <label class="block text-xs font-medium text-foreground mb-1.5">Budget Range</label>
                  <select v-model="quoteForm.budget" class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition">
                    <option value="">Select budget range</option>
                    <option value="< KES 50,000">&lt; KES 50,000</option>
                    <option value="KES 50,000 - 150,000">KES 50,000 - 150,000</option>
                    <option value="KES 150,000 - 500,000">KES 150,000 - 500,000</option>
                    <option value="KES 500,000 - 1,000,000">KES 500,000 - 1,000,000</option>
                    <option value="KES 1,000,000+">KES 1,000,000+</option>
                  </select>
                </div>
                <div>
                  <label class="block text-xs font-medium text-foreground mb-1.5">Timeline</label>
                  <select v-model="quoteForm.timeline" class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition">
                    <option value="">Select timeline</option>
                    <option value="ASAP">ASAP</option>
                    <option value="1-2 weeks">1-2 weeks</option>
                    <option value="1 month">1 month</option>
                    <option value="2-3 months">2-3 months</option>
                    <option value="3-6 months">3-6 months</option>
                    <option value="Flexible">Flexible</option>
                  </select>
                </div>
              </div>

              <div>
                <label class="block text-xs font-medium text-foreground mb-1.5">Project Details *</label>
                <textarea v-model="quoteForm.message" required rows="4" class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition resize-none" placeholder="Describe your project requirements, goals, and any specific needs..."></textarea>
              </div>

              <button type="submit" :disabled="quoteSubmitting" class="w-full sm:w-auto px-8 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 disabled:opacity-50 disabled:cursor-not-allowed">
                <span v-if="quoteSubmitting" class="inline-flex items-center gap-2">
                  <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                  Submitting...
                </span>
                <span v-else>Submit Quote Request</span>
              </button>

              <!-- Success Message -->
              <div v-if="quoteSuccess" class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm font-medium text-green-700 dark:text-green-400">Thank you! Your quote request has been submitted. We'll be in touch within 24 hours.</p>
              </div>

              <!-- Error Message -->
              <div v-if="quoteError" class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <p class="text-sm font-medium text-red-700 dark:text-red-400">{{ quoteError }}</p>
              </div>
            </form>
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
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Navigation } from 'swiper/modules';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useCmsStore } from '@/stores/cms';
import api from '@/services/api';

import 'swiper/css';
import 'swiper/css/navigation';

const route = useRoute();
const cmsStore = useCmsStore();

const loading = ref(true);
const service = ref<any>(null);
const relatedServices = ref<any[]>([]);
const caseStudies = ref<any[]>([]);
const relatedBlogs = ref<any[]>([]);
const features = ref<any[]>([]);
const processSteps = ref<any[]>([]);
const whatsappNumber = ref('');

// Quote form
const quoteForm = ref({
  name: '',
  email: '',
  phone: '',
  company: '',
  budget: '',
  timeline: '',
  message: '',
});
const quoteSubmitting = ref(false);
const quoteSuccess = ref(false);
const quoteError = ref('');

// Impact stats (static fallback – CMS can override)
const impactStats = ref([
  { value: '20+', label: 'Countries Reached' },
  { value: '500K+', label: 'People Impacted' },
  { value: '150+', label: 'Projects Completed' },
  { value: '95%', label: 'Client Satisfaction' },
]);

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

async function submitQuote() {
  quoteSubmitting.value = true;
  quoteSuccess.value = false;
  quoteError.value = '';
  try {
    await api.post('/api/v1/enquiries', {
      name: quoteForm.value.name,
      email: quoteForm.value.email,
      phone: quoteForm.value.phone,
      company: quoteForm.value.company,
      subject: `Quote Request: ${service.value?.name}`,
      message: `Service: ${service.value?.name}\nBudget: ${quoteForm.value.budget}\nTimeline: ${quoteForm.value.timeline}\n\n${quoteForm.value.message}`,
      source: 'service_quote',
    });
    quoteSuccess.value = true;
    quoteForm.value = { name: '', email: '', phone: '', company: '', budget: '', timeline: '', message: '' };
  } catch (e: any) {
    quoteError.value = e.response?.data?.message || 'Something went wrong. Please try again.';
  } finally {
    quoteSubmitting.value = false;
  }
}

function formatDate(dateStr: string) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

onMounted(async () => {
  // Get whatsapp from CMS settings
  const settings = cmsStore.homeData?.settings;
  if (settings) {
    whatsappNumber.value = settings.whatsapp_number || (settings as any).whatsapp || '';
  }
  await fetchService(route.params.slug as string);
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
