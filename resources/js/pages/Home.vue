<template>
  <PublicLayout>
    <!-- Hero Section - Clean layout with navigation arrows -->
    <section v-if="sliders.length" class="relative">
      <Swiper
        :modules="[Autoplay, Pagination, EffectFade, Navigation]"
        :slides-per-view="1"
        :effect="'fade'"
        :autoplay="{ delay: 6000, disableOnInteraction: false }"
        :pagination="{ clickable: true }"
        :navigation="true"
        :loop="true"
        class="hero-swiper"
      >
        <SwiperSlide v-for="slide in sliders" :key="slide.id">
          <div class="relative min-h-[50vh] md:min-h-[60vh] flex items-center bg-gray-50 dark:bg-background">
            <div class="container mx-auto px-6 py-14 md:py-20">
              <div class="grid lg:grid-cols-2 gap-8 items-center">
                <div>
                  <h1 class="text-3xl md:text-4xl lg:text-[2.75rem] font-bold leading-[1.15] text-red-800 dark:text-red-400 mb-4">{{ slide.title }}</h1>
                  <p v-if="slide.description" class="text-muted-foreground text-sm md:text-base leading-relaxed mb-6 max-w-lg">{{ slide.description }}</p>
                  <div class="flex flex-wrap gap-3">
                    <router-link v-if="slide.cta_text && slide.cta_link" :to="slide.cta_link" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-500 text-white text-sm font-semibold rounded-full hover:bg-teal-600 transition-all duration-200">
                      {{ slide.cta_text }}
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10" /></svg>
                    </router-link>
                  </div>
                </div>
                <div class="hidden lg:block">
                  <img v-if="slide.image_url" :src="slide.image_url" :alt="slide.title" class="w-full h-auto max-h-[400px] object-contain rounded-lg" />
                </div>
              </div>
            </div>
          </div>
        </SwiperSlide>
      </Swiper>
    </section>

    <!-- Counter Bar - Purple gradient -->
    <section v-if="counters.length" class="bg-gradient-to-r from-purple-700 via-purple-600 to-purple-800 py-5">
      <div class="container mx-auto px-6">
        <div class="flex flex-wrap justify-between items-center gap-4">
          <div v-for="counter in counters" :key="counter.id" class="flex-1 min-w-[100px] text-center">
            <div class="text-xl md:text-2xl font-bold text-white mb-0.5">
              <span ref="counterRefs" :data-target="counter.number || counter.value" :data-suffix="counter.suffix || '+'">0</span>
            </div>
            <div class="text-white/70 text-[10px] font-medium tracking-wide uppercase">{{ counter.label || counter.title }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section - Image Left, Text Right -->
    <section class="py-14 md:py-16">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
          <div class="rounded-lg overflow-hidden">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop&q=80" alt="TechSmart Team" class="w-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-red-800 dark:text-red-400 text-xs font-semibold tracking-widest uppercase mb-2">About Us</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Your Trusted Technology Partner</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-5">We build innovative software solutions that transform businesses. With expertise spanning web development, mobile apps, AI automation, cloud infrastructure, digital marketing, and cybersecurity — we deliver results that matter.</p>
            <div class="grid grid-cols-2 gap-3 mb-6">
              <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-teal-500"></div><span class="text-foreground text-sm">Agile Development</span></div>
              <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-teal-500"></div><span class="text-foreground text-sm">Dedicated Support</span></div>
              <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-teal-500"></div><span class="text-foreground text-sm">Scalable Solutions</span></div>
              <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-teal-500"></div><span class="text-foreground text-sm">Africa-First Approach</span></div>
            </div>
            <router-link to="/about" class="inline-flex items-center gap-2 text-red-800 dark:text-red-400 text-sm font-semibold hover:gap-3 transition-all duration-200">
              Learn More <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- We Specialize In -->
    <section class="py-14 md:py-16 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-10">
          <p class="text-red-800 dark:text-red-400 text-xs font-semibold tracking-widest uppercase mb-2">Our Expertise</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">We Specialize In</h2>
          <p class="text-muted-foreground text-sm">End-to-end technology solutions crafted for the modern digital landscape.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="(spec, i) in specializations" :key="i" class="bg-card border border-border rounded-lg p-5 text-center hover:border-teal-400 hover:shadow-md transition-all group">
            <div class="w-12 h-12 mx-auto bg-teal-500/10 rounded-lg flex items-center justify-center mb-3 group-hover:bg-teal-500/20 transition">
              <span class="text-2xl">{{ spec.icon }}</span>
            </div>
            <h3 class="text-sm font-semibold text-foreground mb-1">{{ spec.title }}</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">{{ spec.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section - 4 per row -->
    <section class="py-14 md:py-16">
      <div class="container mx-auto px-6">
        <div class="max-w-xl mb-8">
          <p class="text-red-800 dark:text-red-400 text-xs font-semibold tracking-widest uppercase mb-2">What We Offer</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">Services That Drive Growth</h2>
          <p class="text-muted-foreground text-sm">End-to-end technology and marketing solutions tailored to your business needs.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <router-link
            v-for="service in allServices.slice(0, 8)"
            :key="service.id"
            :to="`/services/${service.slug}`"
            class="group bg-card rounded-lg overflow-hidden border border-border hover:border-teal-400/50 hover:shadow-md transition-all duration-300"
          >
            <div class="aspect-[16/10] bg-muted overflow-hidden relative">
              <img v-if="service.image_url" :src="service.image_url" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-teal-50 to-purple-50 dark:from-teal-900/20 dark:to-purple-900/20">
                <svg class="w-8 h-8 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
              </div>
              <div class="absolute top-2 right-2 z-10">
                <WishlistButton type="App\\Models\\Service" :item-id="service.id" />
              </div>
            </div>
            <div class="p-4">
              <h3 class="text-xs font-semibold text-foreground mb-1 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors line-clamp-2">{{ service.title }}</h3>
              <p class="text-muted-foreground text-[11px] leading-relaxed line-clamp-2 mb-2">{{ service.excerpt }}</p>
              <span class="text-teal-600 dark:text-teal-400 font-medium text-[11px] flex items-center gap-1 group-hover:gap-2 transition-all">
                Learn More <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
              </span>
            </div>
          </router-link>
        </div>

        <div class="mt-8 text-center">
          <router-link to="/services" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-500 text-white text-sm font-medium rounded-full hover:bg-teal-600 transition-all duration-200">
            View All Services
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10" /></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- CTA 1 - Dark Red/Maroon with Person -->
    <section class="py-14 md:py-16">
      <div class="container mx-auto px-6">
        <div class="relative rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 40%, #b91c1c 100%);">
          <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&h=600&fit=crop&q=60" class="w-full h-full object-cover" />
          </div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-8 md:p-12 lg:p-14">
              <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">From Nairobi to the World — Become a Tech Leader Today</h2>
              <p class="text-white/80 text-sm leading-relaxed mb-4">In line with our mission to empower businesses with cutting-edge technology, we partner with organizations to deliver transformative digital solutions worldwide.</p>
              <p class="text-white/80 text-sm leading-relaxed mb-6">Expand your digital footprint, build robust systems, impact users and grow revenue.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-500 text-white text-sm font-semibold rounded-full hover:bg-teal-600 transition-all">
                Get Started
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10" /></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex justify-end items-end h-full min-h-[320px]">
              <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=500&h=500&fit=crop&q=80&crop=top" alt="Professional" class="h-full max-h-[380px] object-cover object-top" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products - Carousel, 4 per view -->
    <section v-if="products.length" class="py-14 md:py-16 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-8">
          <div>
            <p class="text-red-800 dark:text-red-400 text-xs font-semibold tracking-widest uppercase mb-2">Our Products</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">Featured Products</h2>
          </div>
          <router-link to="/products" class="hidden sm:inline-flex items-center gap-1 text-teal-600 dark:text-teal-400 text-sm font-medium hover:gap-2 transition-all">
            View All <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg>
          </router-link>
        </div>

        <Swiper
          :modules="[Autoplay, Navigation]"
          :slides-per-view="1"
          :space-between="16"
          :navigation="true"
          :autoplay="{ delay: 4000, disableOnInteraction: false }"
          :breakpoints="{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 4 } }"
          class="products-swiper"
        >
          <SwiperSlide v-for="product in products" :key="product.id">
            <router-link :to="`/products/${product.slug}`" class="group bg-card rounded-lg overflow-hidden border border-border hover:border-teal-400/50 hover:shadow-md transition-all duration-300 block">
              <div class="aspect-[16/10] bg-muted overflow-hidden relative">
                <img v-if="product.image_url" :src="product.image_url" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                <div v-else class="w-full h-full flex items-center justify-center">
                  <svg class="w-8 h-8 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <div class="absolute top-2 right-2 z-10">
                  <WishlistButton type="App\\Models\\Product" :item-id="product.id" />
                </div>
              </div>
              <div class="p-4">
                <h3 class="text-xs font-semibold text-foreground mb-1 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors line-clamp-2">{{ product.name }}</h3>
                <p class="text-muted-foreground text-[11px] leading-relaxed line-clamp-2 mb-2">{{ product.excerpt }}</p>
                <span v-if="product.price_label" class="text-teal-600 dark:text-teal-400 font-bold text-sm">{{ product.price_label }}</span>
              </div>
            </router-link>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

    <!-- Population Impacted / Why Choose Us -->
    <section class="py-14 md:py-16">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-10">
          <p class="text-red-800 dark:text-red-400 text-xs font-semibold tracking-widest uppercase mb-2">Our Impact</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">Population Impacted</h2>
          <p class="text-muted-foreground text-sm">Delivering impactful technology solutions across organizations worldwide.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="(reason, i) in whyChooseUs" :key="i" class="bg-card border border-border rounded-lg p-5 text-center hover:shadow-md transition-all">
            <div class="w-12 h-12 mx-auto bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-3">
              <span class="text-xl">{{ reason.emoji }}</span>
            </div>
            <h3 class="text-sm font-semibold text-foreground mb-1">{{ reason.title }}</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">{{ reason.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials - Carousel -->
    <section v-if="topReviews.length" class="py-14 md:py-16 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-8">
          <p class="text-red-800 dark:text-red-400 text-xs font-semibold tracking-widest uppercase mb-2">Testimonials</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">What Our Clients Say</h2>
          <p class="text-muted-foreground text-sm">Trusted by businesses across Africa and beyond.</p>
        </div>

        <Swiper
          :modules="[Autoplay, Navigation]"
          :slides-per-view="1"
          :space-between="16"
          :navigation="true"
          :autoplay="{ delay: 5000, disableOnInteraction: false }"
          :breakpoints="{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }"
          class="testimonials-swiper"
        >
          <SwiperSlide v-for="review in topReviews" :key="review.id">
            <div class="bg-card border border-border rounded-lg p-5 h-full">
              <div class="flex gap-0.5 mb-3">
                <svg v-for="s in review.rating" :key="s" class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
              <p class="text-muted-foreground text-xs leading-relaxed mb-4 line-clamp-4">"{{ review.comment }}"</p>
              <div class="flex items-center gap-3 mt-auto">
                <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                  {{ review.user_name?.charAt(0).toUpperCase() }}
                </div>
                <div>
                  <div class="font-semibold text-foreground text-xs">{{ review.user_name }}</div>
                  <div class="text-muted-foreground text-[10px]">{{ review.company || 'Verified Client' }}</div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

    <!-- CTA 2 - Dark Red/Maroon with Person -->
    <section class="py-14 md:py-16">
      <div class="container mx-auto px-6">
        <div class="relative rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 40%, #b91c1c 100%);">
          <div class="absolute inset-0 opacity-15">
            <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&h=600&fit=crop&q=60" class="w-full h-full object-cover" />
          </div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-8 md:p-12 lg:p-14">
              <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Ready to Transform Your Business?</h2>
              <p class="text-white/80 text-sm leading-relaxed mb-6">Let us build something amazing together. Get a free consultation and discover how technology can accelerate your growth.</p>
              <div class="flex flex-wrap gap-3">
                <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-500 text-white text-sm font-semibold rounded-full hover:bg-teal-600 transition-all">
                  Apply Now
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10" /></svg>
                </router-link>
                <router-link to="/services" class="px-6 py-3 border border-white/30 text-white text-sm font-medium rounded-full hover:bg-white/10 transition-all">
                  Explore Services
                </router-link>
              </div>
            </div>
            <div class="hidden lg:flex justify-end items-end h-full min-h-[320px]">
              <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=500&h=500&fit=crop&q=80&crop=top" alt="Business Professional" class="h-full max-h-[380px] object-cover object-top" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Blog - 4 per row -->
    <section v-if="recentBlogs.length" class="py-14 md:py-16 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="max-w-xl mb-8">
          <p class="text-red-800 dark:text-red-400 text-xs font-semibold tracking-widest uppercase mb-2">Latest Insights</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">From Our Blog</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <router-link v-for="post in recentBlogs.slice(0, 4)" :key="post.id" :to="`/blog/${post.slug}`" class="group bg-card border border-border rounded-lg overflow-hidden hover:border-teal-400/50 hover:shadow-md transition-all duration-300">
            <div class="aspect-[16/10] bg-muted overflow-hidden">
              <img v-if="post.featured_image" :src="post.featured_image" :alt="post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-teal-50 to-purple-50 dark:from-teal-900/20 dark:to-purple-900/20">
                <svg class="w-8 h-8 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-center gap-2 mb-1.5">
                <span class="text-[10px] font-medium text-teal-600 dark:text-teal-400 bg-teal-500/10 px-2 py-0.5 rounded">{{ post.category }}</span>
                <span class="text-muted-foreground text-[10px]">{{ formatDate(post.published_at) }}</span>
              </div>
              <h3 class="text-xs font-semibold text-foreground mb-1 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors line-clamp-2">{{ post.title }}</h3>
              <p class="text-muted-foreground text-[11px] line-clamp-2">{{ post.excerpt }}</p>
            </div>
          </router-link>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section v-if="faqs.length" class="py-14 md:py-16">
      <div class="container mx-auto px-6 max-w-3xl">
        <div class="text-center mb-8">
          <p class="text-red-800 dark:text-red-400 text-xs font-semibold tracking-widest uppercase mb-2">FAQ</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">Frequently Asked Questions</h2>
        </div>
        <div class="space-y-2">
          <div v-for="(faq, idx) in faqs" :key="faq.id" class="bg-card border border-border rounded-lg overflow-hidden">
            <button @click="toggleFaq(idx)" class="w-full px-5 py-3 flex items-center justify-between text-left hover:bg-muted/30 transition-colors">
              <span class="font-medium text-foreground text-sm pr-6">{{ faq.question }}</span>
              <svg class="w-4 h-4 text-muted-foreground shrink-0 transition-transform duration-200" :class="{ 'rotate-180': openFaqIndex === idx }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div v-show="openFaqIndex === idx" class="px-5 pb-3">
              <p class="text-muted-foreground text-sm leading-relaxed">{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Request a Quote - Minimalistic with image right, form left -->
    <section class="py-14 md:py-16 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
          <div>
            <p class="text-red-800 dark:text-red-400 text-xs font-semibold tracking-widest uppercase mb-2">Get Started</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">Request a Quote</h2>
            <p class="text-muted-foreground text-sm mb-6">Tell us about your project and we will get back to you within 24 hours.</p>

            <form @submit.prevent="submitQuoteRequest" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-2.5 bg-background border border-border rounded-lg focus:outline-none focus:border-teal-500 text-foreground text-sm" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-2.5 bg-background border border-border rounded-lg focus:outline-none focus:border-teal-500 text-foreground text-sm" placeholder="Email *" />
              </div>
              <div class="grid grid-cols-2 gap-3">
                <input v-model="quoteForm.phone" type="tel" required class="w-full px-4 py-2.5 bg-background border border-border rounded-lg focus:outline-none focus:border-teal-500 text-foreground text-sm" placeholder="Phone *" />
                <select v-model="quoteForm.service" required class="w-full px-4 py-2.5 bg-background border border-border rounded-lg focus:outline-none focus:border-teal-500 text-foreground text-sm">
                  <option value="">Service Needed *</option>
                  <option v-for="service in allServices" :key="service.id" :value="service.title">{{ service.title }}</option>
                </select>
              </div>
              <textarea v-model="quoteForm.description" required rows="3" class="w-full px-4 py-2.5 bg-background border border-border rounded-lg focus:outline-none focus:border-teal-500 text-foreground text-sm resize-none" placeholder="Tell us about your project..."></textarea>
              <div class="grid grid-cols-2 gap-3">
                <select v-model="quoteForm.budget" class="w-full px-4 py-2.5 bg-background border border-border rounded-lg focus:outline-none focus:border-teal-500 text-foreground text-sm">
                  <option value="">Budget Range</option>
                  <option value="Under Ksh 10,000">Under Ksh 10,000</option>
                  <option value="Ksh 10,000 - Ksh 50,000">Ksh 10,000 - Ksh 50,000</option>
                  <option value="Ksh 50,000 - Ksh 200,000">Ksh 50,000 - Ksh 200,000</option>
                  <option value="Over Ksh 200,000">Over Ksh 200,000</option>
                </select>
                <select v-model="quoteForm.timeline" class="w-full px-4 py-2.5 bg-background border border-border rounded-lg focus:outline-none focus:border-teal-500 text-foreground text-sm">
                  <option value="">Timeline</option>
                  <option value="ASAP">ASAP</option>
                  <option value="1-2 months">1-2 months</option>
                  <option value="3-6 months">3-6 months</option>
                  <option value="6+ months">6+ months</option>
                </select>
              </div>
              <button type="submit" :disabled="quoteFormSubmitting" class="w-full px-5 py-3 bg-teal-500 text-white text-sm font-semibold rounded-lg hover:bg-teal-600 disabled:opacity-50 transition-all">
                {{ quoteFormSubmitting ? 'Submitting...' : 'Submit Quote Request' }}
              </button>
            </form>
          </div>
          <div class="hidden lg:block">
            <div class="rounded-lg overflow-hidden">
              <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800&h=600&fit=crop&q=80" alt="Get a Quote" class="w-full object-cover aspect-[4/3]" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Trusted By - Heading left, logo grid right (matches reference) -->
    <section v-if="clients.length" class="py-14 md:py-16">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-[280px_1fr] gap-10 items-start">
          <div>
            <h2 class="text-2xl font-bold text-red-800 dark:text-red-400 leading-tight mb-3">Trusted By</h2>
            <p class="text-muted-foreground text-sm mb-4">We are the go-to partner in empowering organizations and professionals with solutions and expertise globally</p>
            <router-link to="/about" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-500 text-white text-sm font-medium rounded-full hover:bg-teal-600 transition-all">
              View More
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10" /></svg>
            </router-link>
          </div>
          <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-7 gap-3">
            <a
              v-for="client in clients"
              :key="client.id"
              :href="client.website_url"
              target="_blank"
              rel="noopener"
              class="flex items-center justify-center p-3 bg-card border border-border rounded-lg hover:border-teal-400/50 hover:shadow-sm transition-all"
            >
              <img v-if="client.logo_url" :src="client.logo_url" :alt="client.name" class="max-h-10 max-w-full object-contain" />
              <span v-else class="text-muted-foreground font-medium text-[10px] text-center">{{ client.name }}</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter -->
    <section class="py-10 bg-purple-700">
      <div class="container mx-auto px-6 max-w-2xl text-center">
        <h3 class="text-lg font-bold text-white mb-2">Stay Updated</h3>
        <p class="text-white/70 text-sm mb-4">Join our newsletter for the latest industry news and exclusive offers.</p>
        <form @submit.prevent="submitNewsletter" class="flex gap-3 max-w-md mx-auto">
          <input v-model="newsletterEmail" type="email" required class="flex-1 px-4 py-2.5 bg-white/10 border border-white/20 rounded-full text-white text-sm placeholder:text-white/50 focus:outline-none focus:border-white/50" placeholder="Enter your email" />
          <button type="submit" :disabled="newsletterSubmitting" class="px-5 py-2.5 bg-teal-500 text-white text-sm font-semibold rounded-full hover:bg-teal-600 disabled:opacity-50 transition-all whitespace-nowrap">
            {{ newsletterSubmitting ? '...' : 'Subscribe' }}
          </button>
        </form>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, EffectFade, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';
import PublicLayout from '@/layouts/PublicLayout.vue';
import WishlistButton from '@/components/WishlistButton.vue';
import axios from 'axios';
import { useToast } from '@/composables';

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

const counterRefs = ref<HTMLElement[]>([]);
const openFaqIndex = ref<number | null>(null);

const specializations = [
  { icon: '\uD83D\uDCBB', title: 'Web Development', desc: 'Modern websites and web apps built with cutting-edge technologies.' },
  { icon: '\uD83D\uDCF1', title: 'Mobile Apps', desc: 'Native and cross-platform mobile solutions for iOS and Android.' },
  { icon: '\uD83E\uDD16', title: 'AI & Automation', desc: 'Intelligent systems that streamline operations and decisions.' },
  { icon: '\u2601\uFE0F', title: 'Cloud Solutions', desc: 'Scalable cloud infrastructure and migration services.' },
  { icon: '\uD83D\uDD12', title: 'Cybersecurity', desc: 'Protect your business with enterprise-grade security.' },
  { icon: '\uD83D\uDCCA', title: 'Data Analytics', desc: 'Turn raw data into actionable business insights.' },
  { icon: '\uD83C\uDFAF', title: 'Digital Marketing', desc: 'SEO, PPC, social media and content strategies.' },
  { icon: '\uD83D\uDED2', title: 'E-Commerce', desc: 'Complete online store solutions with payment integration.' },
];

const whyChooseUs = [
  { emoji: '\uD83D\uDE80', title: 'Rapid Delivery', description: 'We ship MVPs in weeks, not months. Agile sprints with weekly demos.' },
  { emoji: '\uD83C\uDFAF', title: 'Result-Focused', description: 'Every solution drives measurable business outcomes.' },
  { emoji: '\uD83D\uDEE1\uFE0F', title: 'Enterprise Security', description: 'Built with security-first architecture from day one.' },
  { emoji: '\uD83E\uDD1D', title: 'Dedicated Support', description: '24/7 priority support with dedicated project managers.' },
];

const quoteForm = ref({ name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' });
const quoteFormSubmitting = ref(false);
const newsletterEmail = ref('');
const newsletterSubmitting = ref(false);

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
        { id: 1, rating: 5, comment: 'Outstanding service! TechSmart built our e-commerce platform in record time. Sales increased by 200%.', user_name: 'David Okonkwo', company: 'CEO, AfricaTrade' },
        { id: 2, rating: 5, comment: 'Incredibly professional team. Delivered our mobile app ahead of schedule and under budget.', user_name: 'Sarah van der Merwe', company: 'CTO, FinSync SA' },
        { id: 3, rating: 5, comment: 'Automation solutions saved us 200+ hours monthly. CI/CD reduced deployment from days to minutes.', user_name: 'Michael Ndlovu', company: 'Operations, LogiTech' },
        { id: 4, rating: 5, comment: 'Transformed our outdated website into a modern platform that doubled our leads.', user_name: 'Grace Molefe', company: 'Marketing, GreenEnergy' },
        { id: 5, rating: 5, comment: 'Cybersecurity audit identified critical vulnerabilities. Potentially saved us millions.', user_name: 'James Pretorius', company: 'CISO, SecureBank' },
        { id: 6, rating: 5, comment: 'Best tech partner ever. Paid ads management tripled revenue in 6 months with 5x ROAS.', user_name: 'Amina Hassan', company: 'Founder, StyleHub' },
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
      if (category.faqs && Array.isArray(category.faqs)) allFaqs.push(...category.faqs);
    });
    faqs.value = allFaqs.slice(0, 8);
  } catch (error) {
    console.error('Error fetching FAQs:', error);
  }
}

async function submitQuoteRequest() {
  quoteFormSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', {
      type: 'quote', name: quoteForm.value.name, email: quoteForm.value.email, phone: quoteForm.value.phone,
      service: quoteForm.value.service, message: quoteForm.value.description, budget: quoteForm.value.budget, timeline: quoteForm.value.timeline,
    });
    toast.success('Quote request submitted! We will contact you within 24 hours.');
    quoteForm.value = { name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' };
  } catch { toast.error('Failed to submit. Please try again.'); }
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
.hero-swiper :deep(.swiper-pagination-bullet) { width: 8px; height: 8px; background: currentColor; opacity: 0.3; transition: all 0.3s; }
.hero-swiper :deep(.swiper-pagination-bullet-active) { opacity: 1; width: 20px; border-radius: 4px; }
.hero-swiper :deep(.swiper-button-prev),
.hero-swiper :deep(.swiper-button-next) { width: 36px; height: 36px; background: rgb(20 184 166); border-radius: 50%; color: white; }
.hero-swiper :deep(.swiper-button-prev::after),
.hero-swiper :deep(.swiper-button-next::after) { font-size: 14px; font-weight: 700; }
.products-swiper :deep(.swiper-button-prev),
.products-swiper :deep(.swiper-button-next),
.testimonials-swiper :deep(.swiper-button-prev),
.testimonials-swiper :deep(.swiper-button-next) { width: 32px; height: 32px; background: rgb(20 184 166); border-radius: 50%; color: white; }
.products-swiper :deep(.swiper-button-prev::after),
.products-swiper :deep(.swiper-button-next::after),
.testimonials-swiper :deep(.swiper-button-prev::after),
.testimonials-swiper :deep(.swiper-button-next::after) { font-size: 12px; font-weight: 700; }
</style>
