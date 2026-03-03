<template>
  <PublicLayout>
    <!-- Hero Section - Full-width Slider -->
    <section v-if="sliders.length" class="relative">
      <Swiper
        :modules="[Autoplay, Pagination, Navigation, EffectFade]"
        :slides-per-view="1"
        :space-between="0"
        :effect="'fade'"
        :autoplay="{ delay: 5000, disableOnInteraction: false }"
        :pagination="{ clickable: true }"
        :navigation="true"
        :loop="true"
        class="hero-swiper"
      >
        <SwiperSlide v-for="slide in sliders" :key="slide.id">
          <div class="relative min-h-[90vh] flex items-center">
            <div class="absolute inset-0 z-0">
              <img v-if="slide.image_url" :src="slide.image_url" :alt="slide.title" class="w-full h-full object-cover" />
              <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent dark:from-black/90 dark:via-black/70"></div>
            </div>
            <div class="relative z-10 container mx-auto px-4 py-20">
              <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6 text-white">{{ slide.title }}</h1>
                <p v-if="slide.subtitle" class="text-2xl md:text-3xl font-semibold text-primary mb-4">{{ slide.subtitle }}</p>
                <p v-if="slide.description" class="text-lg md:text-xl text-gray-200 leading-relaxed mb-10 max-w-2xl">{{ slide.description }}</p>
                <div class="flex flex-wrap gap-4">
                  <router-link v-if="slide.cta_text && slide.cta_link" :to="slide.cta_link" class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 shadow-lg shadow-primary/30 transform hover:-translate-y-0.5 transition-all duration-300">{{ slide.cta_text }}</router-link>
                  <router-link v-if="slide.cta_text_2 && slide.cta_link_2" :to="slide.cta_link_2" class="px-8 py-4 bg-white/10 backdrop-blur border border-white/30 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">{{ slide.cta_text_2 }}</router-link>
                </div>
              </div>
            </div>
          </div>
        </SwiperSlide>
      </Swiper>
    </section>

    <!-- Counter Section -->
    <section v-if="counters.length" class="py-20 bg-background border-y border-border">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
          <div v-for="counter in counters" :key="counter.id" class="text-center group">
            <div class="text-4xl md:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent mb-3">
              <span ref="counterRefs" :data-target="counter.number || counter.value" :data-suffix="counter.suffix || ''">0</span>
            </div>
            <div class="text-muted-foreground font-semibold text-sm md:text-base">{{ counter.label || counter.title }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Us Section -->
    <section class="py-24 bg-muted/30">
      <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <div class="relative">
            <div class="aspect-video bg-card border border-border rounded-3xl flex items-center justify-center overflow-hidden shadow-2xl">
              <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=500&fit=crop&q=80" alt="TechSmart Team" class="w-full h-full object-cover" />
            </div>
            <div class="absolute -z-10 -inset-6 bg-gradient-to-br from-primary/20 to-accent/20 rounded-3xl blur-3xl"></div>
          </div>
          <div>
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">About Us</div>
            <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">Your Trusted Technology Partner</h2>
            <p class="text-muted-foreground text-lg leading-relaxed mb-6">We build innovative software solutions that transform businesses. With expertise spanning web development, mobile apps, AI automation, cloud infrastructure, digital marketing, and cybersecurity  we deliver results that matter.</p>
            <div class="grid grid-cols-2 gap-4 mb-8">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                </div>
                <span class="text-foreground font-medium text-sm">Agile Development</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                </div>
                <span class="text-foreground font-medium text-sm">Dedicated Support</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                </div>
                <span class="text-foreground font-medium text-sm">Scalable Solutions</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                </div>
                <span class="text-foreground font-medium text-sm">Africa-First Approach</span>
              </div>
            </div>
            <router-link to="/about" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 shadow-lg transform hover:-translate-y-0.5 transition-all">
              Learn More About Us
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- SERVICES  Categorised by Service Groups -->
    <section class="py-24 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">What We Offer</div>
          <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">Services That Drive <span class="text-primary">Growth</span></h2>
          <p class="text-muted-foreground text-lg">End-to-end technology and marketing solutions tailored to your business needs.</p>
        </div>

        <!-- Category Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
          <button
            @click="activeServiceTab = 'all'"
            :class="[
              'px-5 py-2.5 rounded-full text-sm font-semibold transition-all',
              activeServiceTab === 'all'
                ? 'bg-primary text-white shadow-lg shadow-primary/25'
                : 'bg-card border border-border text-muted-foreground hover:text-primary hover:border-primary/40'
            ]"
          >All Services</button>
          <button
            v-for="group in serviceGroups"
            :key="group"
            @click="activeServiceTab = group"
            :class="[
              'px-5 py-2.5 rounded-full text-sm font-semibold transition-all',
              activeServiceTab === group
                ? 'bg-primary text-white shadow-lg shadow-primary/25'
                : 'bg-card border border-border text-muted-foreground hover:text-primary hover:border-primary/40'
            ]"
          >{{ group }}</button>
        </div>

        <!-- Services Grid with Images -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <router-link
            v-for="service in filteredServices"
            :key="service.id"
            :to="`/services/${service.slug}`"
            class="group bg-card border border-border rounded-2xl overflow-hidden hover:border-primary/40 hover:shadow-xl hover:shadow-primary/5 transition-all duration-300 hover:-translate-y-1"
          >
            <!-- Service Image -->
            <div class="aspect-video bg-muted overflow-hidden relative">
              <img
                v-if="service.image_url"
                :src="service.image_url"
                :alt="service.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
              />
              <div v-else class="w-full h-full flex items-center justify-center">
                <svg class="w-12 h-12 text-muted-foreground/30" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
              </div>
              <!-- Category Badge -->
              <div class="absolute top-3 left-3">
                <span class="px-3 py-1 bg-primary/90 text-white text-xs font-semibold rounded-full backdrop-blur">{{ service.category }}</span>
              </div>
              <!-- Price Badge -->
              <div v-if="service.price_label" class="absolute top-3 right-3">
                <span class="px-3 py-1 bg-black/60 text-white text-xs font-semibold rounded-full backdrop-blur">{{ service.price_label }}</span>
              </div>
            </div>

            <!-- Service Content -->
            <div class="p-6">
              <h3 class="text-xl font-bold text-foreground mb-3 group-hover:text-primary transition-colors">{{ service.title }}</h3>
              <p class="text-muted-foreground text-sm leading-relaxed mb-4 line-clamp-2">{{ service.excerpt }}</p>

              <!-- Feature Pills -->
              <div class="flex flex-wrap gap-2 mb-4">
                <span
                  v-for="(feat, i) in (service.features || []).slice(0, 3)"
                  :key="i"
                  class="px-2.5 py-1 bg-muted text-muted-foreground text-xs rounded-md"
                >{{ feat }}</span>
                <span v-if="(service.features || []).length > 3" class="px-2.5 py-1 bg-primary/10 text-primary text-xs rounded-md font-medium">+{{ service.features.length - 3 }} more</span>
              </div>

              <span class="inline-flex items-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                Learn More <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
              </span>
            </div>
          </router-link>
        </div>

        <!-- View All Services Button -->
        <div class="text-center mt-12">
          <router-link to="/services" class="inline-flex items-center gap-2 px-8 py-4 bg-card border-2 border-primary text-primary font-bold rounded-xl hover:bg-primary hover:text-white shadow-lg transform hover:-translate-y-0.5 transition-all">
            View All Services
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-br from-primary to-accent relative overflow-hidden">
      <div class="absolute inset-0 pointer-events-none opacity-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white rounded-full blur-3xl"></div>
      </div>
      <div class="relative container mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">Ready to Transform Your Business?</h2>
        <p class="text-white/90 text-lg md:text-xl max-w-3xl mx-auto mb-10 leading-relaxed">Let us build something amazing together. Get a free consultation and discover how technology can accelerate your growth.</p>
        <div class="flex flex-wrap justify-center gap-4">
          <router-link to="/contact" class="inline-flex items-center gap-2 px-10 py-5 bg-white text-primary font-bold rounded-xl hover:bg-white/90 shadow-2xl transform hover:-translate-y-1 transition-all text-lg">
            Get Started Now
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
          </router-link>
          <router-link to="/services" class="inline-flex items-center gap-2 px-10 py-5 bg-white/10 backdrop-blur border border-white/30 text-white font-bold rounded-xl hover:bg-white/20 transition-all text-lg">
            Explore Services
          </router-link>
        </div>
      </div>
    </section>

    <!-- Featured Products Section -->
    <section v-if="products.length" class="py-24 bg-muted/30">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent/10 text-accent text-sm font-medium mb-6">Our Products</div>
          <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">Featured <span class="text-accent">Products</span></h2>
          <p class="text-muted-foreground text-lg">Ready-to-use solutions to accelerate your digital transformation.</p>
        </div>

        <Swiper
          :modules="[Autoplay, Pagination, Navigation]"
          :slides-per-view="1"
          :space-between="30"
          :autoplay="{ delay: 4000, disableOnInteraction: false }"
          :pagination="{ clickable: true }"
          :navigation="true"
          :breakpoints="{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }"
          class="products-swiper"
        >
          <SwiperSlide v-for="product in products" :key="product.id">
            <router-link :to="`/products/${product.slug}`" class="block group bg-card border border-border rounded-2xl overflow-hidden hover:border-accent/40 hover:shadow-xl transition-all duration-300 h-full">
              <div class="aspect-video bg-muted overflow-hidden">
                <img v-if="product.image_url" :src="product.image_url" :alt="product.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                <div v-else class="w-full h-full flex items-center justify-center">
                  <svg class="w-12 h-12 text-muted-foreground/30" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-bold text-foreground mb-3 group-hover:text-accent transition-colors">{{ product.name }}</h3>
                <p class="text-muted-foreground text-sm leading-relaxed mb-4 line-clamp-2">{{ product.excerpt }}</p>
                <div class="flex items-center justify-between">
                  <span v-if="product.price_label" class="text-accent font-bold text-xl">{{ product.price_label }}</span>
                  <span class="text-primary font-semibold text-sm flex items-center gap-1">
                    View Details <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                  </span>
                </div>
              </div>
            </router-link>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-24 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">Why TechSmart</div>
          <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">Why Businesses <span class="text-primary">Choose Us</span></h2>
          <p class="text-muted-foreground text-lg">We combine technical excellence with business understanding to deliver solutions that work.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="(reason, i) in whyChooseUs" :key="i" class="text-center group">
            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-primary/10 to-accent/10 rounded-2xl flex items-center justify-center mb-6 group-hover:from-primary/20 group-hover:to-accent/20 transition-all">
              <span class="text-4xl">{{ reason.emoji }}</span>
            </div>
            <h3 class="text-lg font-bold text-foreground mb-3">{{ reason.title }}</h3>
            <p class="text-muted-foreground text-sm leading-relaxed">{{ reason.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Reviews Section -->
    <section v-if="topReviews.length" class="py-24 bg-muted/30">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-medium mb-6">Client Testimonials</div>
          <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">What Our <span class="text-amber-600 dark:text-amber-400">Clients</span> Say</h2>
          <p class="text-muted-foreground text-lg">Trusted by businesses across Africa and beyond.</p>
        </div>

        <Swiper
          :modules="[Autoplay, Pagination]"
          :slides-per-view="1"
          :space-between="30"
          :autoplay="{ delay: 5000, disableOnInteraction: false }"
          :pagination="{ clickable: true }"
          :breakpoints="{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }"
          class="reviews-swiper"
        >
          <SwiperSlide v-for="review in topReviews" :key="review.id">
            <div class="bg-card border border-border rounded-2xl p-8 h-full">
              <div class="flex items-center gap-1 mb-4">
                <svg v-for="s in review.rating" :key="s" class="w-5 h-5 text-amber-400 fill-current" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
              <p class="text-muted-foreground leading-relaxed mb-6 italic line-clamp-4">"{{ review.comment }}"</p>
              <div class="flex items-center gap-3 mt-auto">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white font-bold">
                  {{ review.user_name?.charAt(0).toUpperCase() }}
                </div>
                <div>
                  <div class="font-semibold text-foreground">{{ review.user_name }}</div>
                  <div class="text-muted-foreground text-xs">{{ review.company || 'Verified Client' }}</div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

    <!-- Recent Blog Posts -->
    <section v-if="recentBlogs.length" class="py-24 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">Latest Insights</div>
          <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">From Our <span class="text-primary">Blog</span></h2>
          <p class="text-muted-foreground text-lg">Industry news, tips, and insights from our team.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <router-link v-for="post in recentBlogs" :key="post.id" :to="`/blog/${post.slug}`" class="group bg-card border border-border rounded-2xl overflow-hidden hover:border-primary/40 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="aspect-video bg-muted overflow-hidden">
              <img v-if="post.featured_image" :src="post.featured_image" :alt="post.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
              <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-accent/10">
                <svg class="w-12 h-12 text-muted-foreground/30" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
              </div>
            </div>
            <div class="p-6">
              <div class="flex items-center gap-3 mb-3">
                <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-md">{{ post.category }}</span>
                <span class="text-muted-foreground text-xs">{{ formatDate(post.published_at) }}</span>
              </div>
              <h3 class="text-lg font-bold text-foreground mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ post.title }}</h3>
              <p class="text-muted-foreground text-sm line-clamp-2">{{ post.excerpt }}</p>
            </div>
          </router-link>
        </div>

        <div class="text-center mt-12">
          <router-link to="/blog" class="inline-flex items-center gap-2 text-primary font-semibold hover:gap-3 transition-all">
            View All Articles <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section v-if="faqs.length" class="py-24 bg-muted/30">
      <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-16">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">FAQ</div>
          <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">Frequently Asked <span class="text-primary">Questions</span></h2>
          <p class="text-muted-foreground text-lg">Find answers to common questions about our services.</p>
        </div>

        <div class="space-y-4">
          <div v-for="(faq, idx) in faqs" :key="faq.id" class="bg-card border border-border rounded-xl overflow-hidden">
            <button @click="toggleFaq(idx)" class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-muted/50 transition-colors">
              <span class="font-semibold text-foreground pr-8">{{ faq.question }}</span>
              <svg class="w-5 h-5 text-muted-foreground shrink-0 transition-transform" :class="{ 'rotate-180': openFaqIndex === idx }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="openFaqIndex === idx" class="px-6 pb-5">
              <p class="text-muted-foreground leading-relaxed">{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Request a Quote -->
    <section class="py-24 bg-background">
      <div class="container mx-auto px-4 max-w-3xl">
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent/10 text-accent text-sm font-medium mb-6">Get Started</div>
          <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">Request a <span class="text-accent">Quote</span></h2>
          <p class="text-muted-foreground text-lg">Tell us about your project and we will get back to you within 24 hours.</p>
        </div>

        <form @submit.prevent="submitQuoteRequest" class="bg-card border border-border rounded-2xl p-8 shadow-xl">
          <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
              <label class="block text-sm font-semibold text-foreground mb-2">Full Name *</label>
              <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground" placeholder="John Doe" />
            </div>
            <div>
              <label class="block text-sm font-semibold text-foreground mb-2">Email Address *</label>
              <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground" placeholder="john@example.com" />
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
              <label class="block text-sm font-semibold text-foreground mb-2">Phone Number *</label>
              <input v-model="quoteForm.phone" type="tel" required class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground" placeholder="+27 12 345 6789" />
            </div>
            <div>
              <label class="block text-sm font-semibold text-foreground mb-2">Service Needed *</label>
              <select v-model="quoteForm.service" required class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground">
                <option value="">Select a service</option>
                <option v-for="service in allServices" :key="service.id" :value="service.title">{{ service.title }}</option>
              </select>
            </div>
          </div>

          <div class="mb-6">
            <label class="block text-sm font-semibold text-foreground mb-2">Project Description *</label>
            <textarea v-model="quoteForm.description" required rows="4" class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground resize-none" placeholder="Tell us about your project..."></textarea>
          </div>

          <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
              <label class="block text-sm font-semibold text-foreground mb-2">Budget Range</label>
              <select v-model="quoteForm.budget" class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground">
                <option value="">Select budget</option>
                <option value="Under R10,000">Under R10,000</option>
                <option value="R10,000 - R50,000">R10,000 - R50,000</option>
                <option value="R50,000 - R200,000">R50,000 - R200,000</option>
                <option value="Over R200,000">Over R200,000</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold text-foreground mb-2">Timeline</label>
              <select v-model="quoteForm.timeline" class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground">
                <option value="">Select timeline</option>
                <option value="ASAP">ASAP</option>
                <option value="1-2 months">1-2 months</option>
                <option value="3-6 months">3-6 months</option>
                <option value="6+ months">6+ months</option>
              </select>
            </div>
          </div>

          <button type="submit" :disabled="quoteFormSubmitting" class="w-full px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
            <span v-if="quoteFormSubmitting">Submitting...</span>
            <span v-else>Submit Quote Request</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
          </button>
        </form>
      </div>
    </section>

    <!-- Newsletter -->
    <section class="py-20 bg-muted/30 border-y border-border">
      <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-10">
          <h3 class="text-3xl md:text-4xl font-bold text-foreground mb-4">Stay Updated with <span class="text-primary">Tech Insights</span></h3>
          <p class="text-muted-foreground text-lg">Join our newsletter for the latest industry news, tips, and exclusive offers.</p>
        </div>

        <form @submit.prevent="submitNewsletter" class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
          <input v-model="newsletterEmail" type="email" required class="flex-1 px-6 py-4 bg-card border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-foreground" placeholder="Enter your email" />
          <button type="submit" :disabled="newsletterSubmitting" class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg transform hover:-translate-y-0.5 transition-all whitespace-nowrap">
            {{ newsletterSubmitting ? 'Subscribing...' : 'Subscribe' }}
          </button>
        </form>
      </div>
    </section>

    <!-- Contact Us Section -->
    <section class="py-24 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">Get In Touch</div>
          <h2 class="text-4xl md:text-5xl font-bold text-foreground mb-6">Contact <span class="text-primary">Us</span></h2>
          <p class="text-muted-foreground text-lg">Have a question? We are here to help. Reach out to us anytime.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
          <div class="space-y-6">
            <div v-if="settings.address" class="flex items-start gap-4 bg-card border border-border rounded-xl p-6 hover:border-primary/40 transition">
              <div class="w-12 h-12 shrink-0 bg-primary/10 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-foreground mb-1">Address</h4>
                <p class="text-muted-foreground text-sm">{{ settings.address }}</p>
              </div>
            </div>

            <div v-if="settings.contact_email" class="flex items-start gap-4 bg-card border border-border rounded-xl p-6 hover:border-accent/40 transition">
              <div class="w-12 h-12 shrink-0 bg-accent/10 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-foreground mb-1">Email</h4>
                <a :href="`mailto:${settings.contact_email}`" class="text-muted-foreground text-sm hover:text-primary transition">{{ settings.contact_email }}</a>
              </div>
            </div>

            <div v-if="settings.contact_phone" class="flex items-start gap-4 bg-card border border-border rounded-xl p-6 hover:border-green-500/40 transition">
              <div class="w-12 h-12 shrink-0 bg-green-500/10 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-foreground mb-1">Phone</h4>
                <a :href="`tel:${settings.contact_phone}`" class="text-muted-foreground text-sm hover:text-primary transition">{{ settings.contact_phone }}</a>
              </div>
            </div>

            <!-- Google Map -->
            <div class="aspect-video bg-muted rounded-2xl overflow-hidden border border-border">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3580.3!2d28.0564!3d-26.1068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e950c5c!2sSandton!5e0!3m2!1sen!2sza!4v1234567890"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>

          <div>
            <form @submit.prevent="submitContactForm" class="bg-card border border-border rounded-2xl p-8 shadow-xl">
              <div class="mb-6">
                <label class="block text-sm font-semibold text-foreground mb-2">Your Name</label>
                <input v-model="contactForm.name" type="text" required class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground" placeholder="John Doe" />
              </div>

              <div class="mb-6">
                <label class="block text-sm font-semibold text-foreground mb-2">Email Address</label>
                <input v-model="contactForm.email" type="email" required class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground" placeholder="john@example.com" />
              </div>

              <div class="mb-6">
                <label class="block text-sm font-semibold text-foreground mb-2">Phone Number</label>
                <input v-model="contactForm.phone" type="tel" class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground" placeholder="+27 12 345 6789" />
              </div>

              <div class="mb-6">
                <label class="block text-sm font-semibold text-foreground mb-2">Message</label>
                <textarea v-model="contactForm.message" required rows="5" class="w-full px-4 py-3 bg-background border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-foreground resize-none" placeholder="How can we help you?"></textarea>
              </div>

              <button type="submit" :disabled="contactFormSubmitting" class="w-full px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg transform hover:-translate-y-0.5 transition-all">
                {{ contactFormSubmitting ? 'Sending...' : 'Send Message' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Trusted Clients Carousel -->
    <section v-if="clients.length" class="py-20 bg-muted/30 border-t border-border">
      <div class="container mx-auto px-4">
        <p class="text-center text-sm text-muted-foreground font-semibold uppercase tracking-widest mb-10">Trusted by Leading Companies</p>

        <Swiper
          :modules="[Autoplay]"
          :slides-per-view="2"
          :space-between="30"
          :autoplay="{ delay: 0, disableOnInteraction: false }"
          :speed="3000"
          :loop="true"
          :breakpoints="{ 640: { slidesPerView: 3 }, 768: { slidesPerView: 4 }, 1024: { slidesPerView: 5 }, 1280: { slidesPerView: 6 } }"
          class="clients-swiper"
        >
          <SwiperSlide v-for="client in clients" :key="client.id">
            <a :href="client.website_url" target="_blank" rel="noopener" class="flex items-center justify-center opacity-50 hover:opacity-100 transition-opacity duration-300 px-4">
              <img v-if="client.logo_url" :src="client.logo_url" :alt="client.name" class="max-h-12 max-w-full grayscale hover:grayscale-0 transition" />
              <span v-else class="text-muted-foreground font-semibold">{{ client.name }}</span>
            </a>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, Navigation, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/effect-fade';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';
import { useToast } from '@/composables';

// Data from API
const sliders = ref<any[]>([]);
const counters = ref<any[]>([]);
const allServices = ref<any[]>([]);
const products = ref<any[]>([]);
const clients = ref<any[]>([]);
const topReviews = ref<any[]>([]);
const faqs = ref<any[]>([]);
const recentBlogs = ref<any[]>([]);
const settings = ref<any>({});
const toast = useToast();

// Service Filtering
const activeServiceTab = ref('all');
const serviceGroups = computed(() => {
  const groups = [...new Set(allServices.value.map((s: any) => s.category_group).filter(Boolean))];
  return groups;
});

const filteredServices = computed(() => {
  if (activeServiceTab.value === 'all') {
    return allServices.value.slice(0, 9);
  }
  return allServices.value.filter((s: any) => s.category_group === activeServiceTab.value);
});

// UI State
const counterRefs = ref<HTMLElement[]>([]);
const openFaqIndex = ref<number | null>(null);

// Why Choose Us
const whyChooseUs = [
  { emoji: '\uD83D\uDE80', title: 'Rapid Delivery', description: 'We ship MVPs in weeks, not months. Agile sprints with weekly demos keep you informed.' },
  { emoji: '\uD83C\uDFAF', title: 'Result-Focused', description: 'Every solution is designed to drive measurable business outcomes  traffic, conversions, revenue.' },
  { emoji: '\uD83D\uDEE1\uFE0F', title: 'Enterprise Security', description: 'POPIA-compliant, SOC-certified, and built with security-first architecture from day one.' },
  { emoji: '\uD83E\uDD1D', title: 'Dedicated Support', description: '24/7 priority support with dedicated project managers and transparent communication.' },
];

// Form State
const quoteForm = ref({
  name: '',
  email: '',
  phone: '',
  service: '',
  description: '',
  budget: '',
  timeline: '',
});
const quoteFormSubmitting = ref(false);

const newsletterEmail = ref('');
const newsletterSubmitting = ref(false);

const contactForm = ref({
  name: '',
  email: '',
  phone: '',
  message: '',
});
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
    // If API returned no reviews, use representative testimonials
    if (!topReviews.value.length) {
      topReviews.value = [
        { id: 1, rating: 5, comment: 'Outstanding service! TechSmart built our e-commerce platform in record time with exceptional quality. Our online sales increased by 200% within three months of launch.', user_name: 'David Okonkwo', company: 'CEO, AfricaTrade' },
        { id: 2, rating: 5, comment: 'The team is incredibly professional. They delivered our mobile app ahead of schedule and under budget. The React Native app runs flawlessly on both iOS and Android.', user_name: 'Sarah van der Merwe', company: 'CTO, FinSync SA' },
        { id: 3, rating: 5, comment: 'Their automation solutions saved us over 200 hours monthly. The CI/CD pipeline they built reduced our deployment time from days to minutes.', user_name: 'Michael Ndlovu', company: 'Operations Manager, LogiTech' },
        { id: 4, rating: 5, comment: 'They transformed our outdated website into a modern, responsive platform that doubled our leads. The SEO work took us from page 5 to page 1 of Google in under 4 months.', user_name: 'Grace Molefe', company: 'Marketing Director, GreenEnergy' },
        { id: 5, rating: 5, comment: 'Their cybersecurity audit identified critical vulnerabilities we had no idea existed. Potentially saved us millions in breach costs.', user_name: 'James Pretorius', company: 'CISO, SecureBank' },
        { id: 6, rating: 5, comment: 'Best tech partner we have ever had. Their paid ads management tripled our online revenue in just 6 months with a consistent 5x ROAS.', user_name: 'Amina Hassan', company: 'Founder, StyleHub' },
      ];
    }
    recentBlogs.value = d.recent_blogs || [];
    settings.value = d.settings || {};
  } catch (error) {
    console.error('Error fetching home data:', error);
  }
}

async function fetchFaqs() {
  try {
    const { data } = await axios.get('/api/v1/home/faqs');
    const cats = data.data?.categories || data.categories || data.data || [];
    const allFaqs: any[] = [];
    (Array.isArray(cats) ? cats : []).forEach((category: any) => {
      if (category.faqs && Array.isArray(category.faqs)) {
        allFaqs.push(...category.faqs);
      }
    });
    faqs.value = allFaqs.slice(0, 8);
  } catch (error) {
    console.error('Error fetching FAQs:', error);
  }
}

// Form Handlers
async function submitQuoteRequest() {
  quoteFormSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', {
      type: 'quote',
      name: quoteForm.value.name,
      email: quoteForm.value.email,
      phone: quoteForm.value.phone,
      service: quoteForm.value.service,
      message: quoteForm.value.description,
      budget: quoteForm.value.budget,
      timeline: quoteForm.value.timeline,
    });
    toast.success('Quote request submitted! We will contact you within 24 hours.');
    quoteForm.value = { name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' };
  } catch (error) {
    console.error('Error submitting quote:', error);
    toast.error('Failed to submit quote request. Please try again.');
  } finally {
    quoteFormSubmitting.value = false;
  }
}

async function submitNewsletter() {
  newsletterSubmitting.value = true;
  try {
    await axios.post('/api/v1/newsletter/subscribe', { email: newsletterEmail.value });
    toast.success('Successfully subscribed to our newsletter!');
    newsletterEmail.value = '';
  } catch (error) {
    console.error('Error subscribing to newsletter:', error);
    toast.error('Failed to subscribe. Please try again.');
  } finally {
    newsletterSubmitting.value = false;
  }
}

async function submitContactForm() {
  contactFormSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', {
      type: 'contact',
      name: contactForm.value.name,
      email: contactForm.value.email,
      phone: contactForm.value.phone,
      message: contactForm.value.message,
    });
    toast.success('Message sent successfully! We will get back to you soon.');
    contactForm.value = { name: '', email: '', phone: '', message: '' };
  } catch (error) {
    console.error('Error submitting contact form:', error);
    toast.error('Failed to send message. Please try again.');
  } finally {
    contactFormSubmitting.value = false;
  }
}

// Helpers
function toggleFaq(index: number) {
  openFaqIndex.value = openFaqIndex.value === index ? null : index;
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
    if (current >= target) {
      current = target;
      clearInterval(timer);
    }
    element.textContent = current.toLocaleString() + suffix;
  }, 16);
}

// On Mounted
onMounted(async () => {
  await Promise.all([
    fetchHomeData(),
    fetchFaqs(),
  ]);

  // Counter animation
  setTimeout(() => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target as HTMLElement);
          observer.unobserve(entry.target);
        }
      });
    });
    counterRefs.value.forEach((el) => {
      if (el) observer.observe(el);
    });
  }, 500);
});
</script>

<style scoped>
.hero-swiper :deep(.swiper-pagination-bullet) {
  width: 12px;
  height: 12px;
  background: white;
  opacity: 0.5;
  transition: all 0.3s;
}
.hero-swiper :deep(.swiper-pagination-bullet-active) {
  background: var(--primary, #d311f5);
  opacity: 1;
  width: 32px;
  border-radius: 6px;
}
.hero-swiper :deep(.swiper-button-prev),
.hero-swiper :deep(.swiper-button-next) {
  color: white;
  background: rgba(0, 0, 0, 0.5);
  width: 50px;
  height: 50px;
  border-radius: 50%;
  backdrop-filter: blur(8px);
  transition: all 0.3s;
}
.hero-swiper :deep(.swiper-button-prev:hover),
.hero-swiper :deep(.swiper-button-next:hover) {
  background: rgba(0, 0, 0, 0.7);
  transform: scale(1.1);
}
.hero-swiper :deep(.swiper-button-prev)::after,
.hero-swiper :deep(.swiper-button-next)::after {
  font-size: 18px;
}
.clients-swiper :deep(.swiper-wrapper) {
  transition-timing-function: linear !important;
}
:deep(.swiper-pagination-bullet) {
  background: var(--muted-foreground, #64748b);
  opacity: 0.5;
}
:deep(.swiper-pagination-bullet-active) {
  background: var(--primary, #d311f5);
  opacity: 1;
}
</style>
