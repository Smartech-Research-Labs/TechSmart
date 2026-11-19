<template>
  <PublicLayout>
    <div v-if="loading" class="py-20 text-center">
      <div class="inline-block w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <template v-else-if="product">
      <section class="relative min-h-[50vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
          <img
            :src="getProductImage(product) || product.image_url || heroLaptopDark"
            :alt="product.name"
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 py-16 md:py-24">
          <nav class="flex items-center gap-2 text-xs text-white/60 mb-6">
            <router-link to="/" class="hover:text-primary transition">Home</router-link>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <router-link to="/products" class="hover:text-primary transition">Products</router-link>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <span class="text-white font-medium">{{ product.name }}</span>
          </nav>

          <div class="max-w-2xl">
            <div class="flex flex-wrap items-center gap-2 mb-4">
              <span v-if="product.category" class="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full border border-primary/20">{{ product.category }}</span>
              <span v-if="product.is_featured" class="px-3 py-1 text-xs font-semibold bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-full border border-amber-500/20">
                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Featured
              </span>
            </div>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">{{ product.name }}</h1>
            <p class="text-white/80 text-base md:text-lg leading-relaxed mb-8 max-w-xl">{{ product.short_description }}</p>

            <div class="flex flex-wrap gap-3">
              <a :href="`/contact`" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                Get a Quote
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </a>
              <a href="/contact" class="inline-flex items-center gap-2 px-7 py-3 border border-white/20 bg-white/10 text-white text-sm font-semibold rounded-full hover:bg-white/20 transition-all">
                Request Demo
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </a>
            </div>
          </div>
        </div>
      </section>

      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="relative rounded-2xl overflow-hidden">
              <img
                :src="getProductImage(product) || product.image_url || heroLaptop"
                :alt="product.name"
                class="w-full aspect-[4/3] object-cover"
              />
            </div>

            <div>
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About This Product</p>
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">{{ product.name }}</h2>
              <div class="text-muted-foreground text-sm leading-relaxed space-y-4 mb-8" v-html="product.description || '<p>Loading description...</p>'"></div>

              <div v-if="featureList.length" class="space-y-3">
                <div v-for="(feature, i) in featureList.slice(0, 4)" :key="i" class="flex items-start gap-3">
                  <div class="mt-0.5 w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                  </div>
                  <span class="text-sm text-foreground font-medium">{{ feature }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section v-if="featureList.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Key Features</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Features & Capabilities</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Everything {{ product.name }} includes to power your business.</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            <div v-for="(feature, i) in featureList" :key="i" class="group bg-card border border-border rounded-xl p-5 hover:shadow-md hover:border-primary/20 transition-all">
              <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              </div>
              <h3 class="text-sm font-semibold text-foreground mb-1.5">{{ feature }}</h3>
            </div>
          </div>
        </div>
      </section>

      <section v-if="specKeys.length" class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Technical Specifications</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Specifications</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Detailed technical information about {{ product.name }}.</p>
          </div>

          <div class="max-w-3xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div v-for="key in specKeys" :key="key" class="bg-card border border-border rounded-xl p-5 hover:shadow-md hover:border-primary/20 transition-all">
                <p class="text-xs font-medium text-muted-foreground mb-1">{{ key }}</p>
                <p class="text-sm font-semibold text-foreground">{{ product.specifications[key] }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Success Stories</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Case Studies</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">See how our {{ product.name }} product has delivered real results for our clients.</p>
          </div>

          <div v-if="caseStudies.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <router-link v-for="cs in caseStudies" :key="cs.id" :to="`/case-studies/${cs.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all">
              <div class="aspect-[16/10] overflow-hidden">
                <img :src="cs.image_url || heroTech7" :alt="cs.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
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
            <p class="text-muted-foreground text-sm">Case studies for this product are coming soon.</p>
          </div>

          <div class="text-center mt-8">
            <router-link to="/case-studies" class="inline-flex items-center gap-2 px-6 py-2.5 border border-border text-foreground text-sm font-medium rounded-full hover:bg-muted transition-all">
              View All Case Studies
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </router-link>
          </div>
        </div>
      </section>

      <section v-if="relatedBlogs.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Blog & Insights</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Related Articles</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Stay up to date with insights about {{ product.category || product.name }}.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <router-link v-for="post in relatedBlogs.slice(0, 3)" :key="post.id" :to="`/blog/${post.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all">
              <div class="aspect-[16/10] overflow-hidden">
                <img :src="blogImageUrl(post.featured_image) || heroTech7" :alt="post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
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

      <section v-if="relatedProducts.length" class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Explore More</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Other Products You Might Be Interested In</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Discover more products that complement {{ product.name }}.</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <router-link
              v-for="rel in relatedProducts"
              :key="rel.id"
              :to="`/products/${rel.slug}`"
              class="group flex flex-col bg-card border border-border rounded-2xl overflow-hidden hover:shadow-xl hover:border-primary/20 transition-all duration-300"
            >
              <div class="relative h-56 overflow-hidden">
                <img
                  :src="getProductImage(rel) || rel.image_url || heroTech7"
                  :alt="rel.name"
                  class="absolute inset-0 size-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
              </div>

              <div class="flex flex-col flex-1 p-5">
                <span v-if="rel.category" class="w-fit text-[10px] font-medium bg-primary/10 text-primary px-2 py-1 rounded-full">{{ rel.category }}</span>
                <h3 class="text-base font-semibold text-foreground mt-3 mb-2 group-hover:text-primary transition-colors">{{ rel.name }}</h3>
                <p class="text-sm text-muted-foreground line-clamp-3">{{ rel.short_description }}</p>
              </div>
            </router-link>
          </div>
        </div>
      </section>

      <section class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Us</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">The OmniviaTech Advantage</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Why leading organizations trust us for their {{ product.category || 'technology' }} needs.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="(benefit, i) in productBenefits" :key="i" class="group text-center">
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

      <section class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Industries We Serve</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Areas You Might Be Interested In</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Our {{ product.name }} product serves various sectors and industries.</p>
          </div>

          <div v-if="industries.length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <router-link v-for="ind in industries.slice(0, 12)" :key="ind.id" :to="`/industries/${ind.slug}`" class="group flex flex-col items-center p-4 bg-card border border-border rounded-xl hover:shadow-md hover:border-primary/30 transition-all text-center">
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary/5 to-accent/5 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <img v-if="ind.icon_url" :src="ind.icon_url" :alt="ind.name" class="w-7 h-7 object-contain" />
                <svg v-else class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                </svg>
              </div>
              <span class="text-xs font-medium text-foreground group-hover:text-primary transition-colors">{{ ind.name }}</span>
            </router-link>
          </div>
          <div v-else class="text-center py-10">
            <p class="text-muted-foreground text-sm">Industry-specific applications for this product are being added. <router-link to="/industries" class="text-primary font-semibold hover:underline">View all industries</router-link>.</p>
          </div>

          <div class="text-center mt-8">
            <router-link to="/industries" class="inline-flex items-center gap-2 px-6 py-2.5 border border-border text-foreground text-sm font-medium rounded-full hover:bg-muted transition-all">
              View All Industries
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </router-link>
          </div>
        </div>
      </section>

      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Client Testimonials</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">What Our Clients Say</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Hear from organizations that use {{ product.name }}.</p>
          </div>

          <div v-if="testimonials.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="(testimonial, i) in testimonials.slice(0, 3)" :key="i" class="bg-card border border-border rounded-xl p-6 hover:shadow-md hover:border-primary/20 transition-all">
              <div class="flex gap-1 mb-4">
                <svg v-for="s in 5" :key="s" class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
              </div>
              <p class="text-sm text-muted-foreground leading-relaxed mb-4 italic">"{{ testimonial.content }}"</p>
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
            <p class="text-muted-foreground text-sm">Testimonials for this product are being collected. <router-link to="/contact" class="text-primary font-semibold hover:underline">Share your experience</router-link>.</p>
          </div>
        </div>
      </section>

      <section class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Frequently Asked Questions</p>
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Have Questions?</h2>
              <p class="text-muted-foreground text-sm leading-relaxed">Find answers to common questions about {{ product.name }}.</p>
            </div>

            <div v-if="faqs.length">
              <div class="space-y-3">
                <div v-for="(faq, i) in faqs.slice(0, 6)" :key="i" class="bg-card border border-border rounded-xl overflow-hidden">
                  <button @click="toggleFaq(i)" class="w-full flex items-center justify-between p-5 text-left">
                    <span class="text-sm font-semibold text-foreground pr-4">{{ faq.question }}</span>
                    <svg :class="['w-5 h-5 text-muted-foreground transition-transform flex-shrink-0', openFaqIndex === i ? 'rotate-180' : '']" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
              <p class="text-muted-foreground text-sm">FAQs for this product are being prepared. <router-link to="/contact" class="text-primary font-semibold hover:underline">Ask us anything</router-link>.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="py-14 md:py-20 bg-gray-900">
        <div class="container mx-auto px-6 max-w-5xl">
          <div class="text-center max-w-2xl mx-auto mb-10">
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Get Started</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight mb-3">Request a Quote</h2>
            <p class="text-white/75 text-sm leading-relaxed">Tell us about your project and we'll get back to you within 24 hours.</p>
          </div>
        </div>
        <div class="container mx-auto px-6 max-w-5xl">
          <div class="grid lg:grid-cols-2 gap-14 items-center">
            <div>
              <form @submit.prevent="submitQuoteRequest" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                  <input v-model="quoteForm.name" type="text" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white/40" placeholder="Full Name *" />
                  <input v-model="quoteForm.email" type="email" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white/40" placeholder="Email *" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <input v-model="quoteForm.phone" type="tel" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white/40" placeholder="Phone *" />
                  <select v-model="quoteForm.product" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all">
                    <option value="" class="text-gray-900">Product Interested In *</option>
                    <option :value="product.name" selected class="text-gray-900">{{ product.name }}</option>
                  </select>
                </div>
                <textarea v-model="quoteForm.message" required rows="4" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm resize-none transition-all placeholder-white/40" placeholder="Tell us about your requirements..."></textarea>
                <div class="grid grid-cols-2 gap-4">
                  <select v-model="quoteForm.budget" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all">
                    <option value="" class="text-gray-900">Budget Range</option>
                    <option value="Under Ksh 10,000" class="text-gray-900">Under Ksh 10,000</option>
                    <option value="Ksh 10,000 - Ksh 50,000" class="text-gray-900">Ksh 10,000 - Ksh 50,000</option>
                    <option value="Ksh 50,000 - Ksh 200,000" class="text-gray-900">Ksh 50,000 - Ksh 200,000</option>
                    <option value="Over Ksh 200,000" class="text-gray-900">Over Ksh 200,000</option>
                  </select>
                  <select v-model="quoteForm.timeline" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all">
                    <option value="" class="text-gray-900">Timeline</option>
                    <option value="ASAP" class="text-gray-900">ASAP</option>
                    <option value="1-2 months" class="text-gray-900">1-2 months</option>
                    <option value="3-6 months" class="text-gray-900">3-6 months</option>
                    <option value="6+ months" class="text-gray-900">6+ months</option>
                  </select>
                </div>
                <button type="submit" :disabled="quoteSubmitting" class="w-full px-6 py-3.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 disabled:opacity-50 transition-all shadow-sm">
                  {{ quoteSubmitting ? 'Submitting...' : 'Submit Quote Request' }}
                </button>
              </form>
            </div>

            <div class="hidden lg:block">
              <div class="rounded-2xl overflow-hidden shadow-sm">
                <img :src="settings.quote_section_image || 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800&h=600&fit=crop&q=80'" alt="Get a Quote" class="w-full h-full object-cover aspect-[4/3]" />
              </div>
            </div>
          </div>
        </div>
      </section>
    </template>

    <div v-else class="py-20 text-center">
      <h2 class="text-2xl font-bold text-foreground mb-2">Product Not Found</h2>
      <p class="text-muted-foreground mb-6">The product you're looking for doesn't exist or has been removed.</p>
      <router-link to="/products" class="px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition">Browse Products</router-link>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { computed, ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import heroLaptop from '@/../img/Laptop.webp';
import svcApi from '@/../img/services/API Development.webp';
import svcCrmErp from '@/../img/services/CRM & ERP Development.webp';
import svcCustomWeb from '@/../img/services/Custom Web Development.webp';
import svcEcommerce from '@/../img/services/E-commerece Development.webp';
import svcMobileApp from '@/../img/services/Mobile App Development.webp';
import svcSeo from '@/../img/services/SEO Optimization.webp';
import heroLaptopDark from '@/../img/tech-background.webp';
import heroTech7 from '@/../img/tech7.webp';
import { useToast } from '@/composables/useToast';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { blogImageUrl } from '@/lib/blogImages';
import { productImageMap as sharedProductImageMap } from '@/lib/productImages';
import api from '@/services/api';
import { useCmsStore } from '@/stores/cms';

// Default cover images per product slug (shared across product pages)
const productImageMap = sharedProductImageMap;

function getProductImage(product: any): string | undefined {
  const slug = (product.slug || '').toLowerCase().trim();
  if (productImageMap[slug]) return productImageMap[slug];
  return undefined;
}

const route = useRoute();
const cmsStore = useCmsStore();
const toast = useToast();
const settings = ref<any>({});
const loading = ref(true);
const product = ref<any>(null);
const relatedProducts = ref<any[]>([]);
const caseStudies = ref<any[]>([]);
const relatedBlogs = ref<any[]>([]);
const industries = ref<any[]>([]);
const testimonials = ref<any[]>([]);
const faqs = ref<any[]>([]);
const openFaqIndex = ref<number | null>(null);
const quoteForm = ref({ name: '', email: '', phone: '', product: '', message: '', budget: '', timeline: '' });
const quoteSubmitting = ref(false);

const featureList = computed(() => {
  if (!product.value) return [];
  const f = product.value.features;
  if (typeof f === 'string') {
    try { return JSON.parse(f); } catch { return []; }
  }
  return Array.isArray(f) ? f : [];
});

const specKeys = computed(() => {
  if (!product.value?.specifications) return [];
  const s = product.value.specifications;
  const obj = typeof s === 'string' ? (() => { try { return JSON.parse(s); } catch { return {}; } })() : s;
  return Object.keys(obj || {});
});

const productBenefits = ref([
  { title: 'Expert Team', description: 'Our specialists bring years of experience and deep domain expertise to every project.' },
  { title: 'Fast Delivery', description: 'Agile methodology ensures quick turnaround without compromising quality.' },
  { title: 'Dedicated Support', description: '24/7 support and ongoing maintenance to keep your solutions running smoothly.' },
  { title: 'Proven Results', description: 'Track record of delivering measurable outcomes and ROI for our clients.' },
]);


function formatDate(dateStr: string) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function toggleFaq(index: number) {
  openFaqIndex.value = openFaqIndex.value === index ? null : index;
}

async function fetchProduct(slug: string) {
  loading.value = true;
  try {
    const { data: d } = await api.get(`/api/v1/products/${slug}`);
    product.value = d.product;
    relatedProducts.value = d.related || [];
    caseStudies.value = d.case_studies || [];
    relatedBlogs.value = d.related_blogs || [];
  } catch (e: any) {
    console.error('Failed to load product', e);
    product.value = null;
  } finally {
    loading.value = false;
  }
}

async function fetchAdditionalData() {
  try {
    const industriesRes = await api.get('/api/v1/industries?limit=12');
    industries.value = industriesRes.data.data || industriesRes.data.industries || [];
  } catch { industries.value = []; }

  try {
    const category = product.value?.category || 'general';
    const faqsRes = await api.get(`/api/v1/faqs?category=${encodeURIComponent(category)}&limit=6`);
    faqs.value = faqsRes.data.data || faqsRes.data.faqs || [];
    if (faqs.value.length === 0) {
      const generalFaqsRes = await api.get('/api/v1/faqs?limit=6');
      faqs.value = generalFaqsRes.data.data || generalFaqsRes.data.faqs || [];
    }
  } catch { faqs.value = []; }

  if (product.value?.reviews?.length) {
    testimonials.value = product.value.reviews.map((r: any) => ({
      content: r.content || r.comment,
      name: r.user?.name || r.user_name || 'Anonymous',
      position: r.position || '',
      company: r.company || '',
    }));
  } else {
    testimonials.value = [];
  }
}

async function submitQuoteRequest() {
  quoteSubmitting.value = true;
  try {
    await api.post('/api/v1/enquiries', {
      type: 'quote', name: quoteForm.value.name, email: quoteForm.value.email,
      phone: quoteForm.value.phone, service: quoteForm.value.product,
      message: quoteForm.value.message, budget: quoteForm.value.budget, timeline: quoteForm.value.timeline,
    });
    toast.success('Quote request submitted! We will contact you within 24 hours.');
    quoteForm.value = { name: '', email: '', phone: '', product: '', message: '', budget: '', timeline: '' };
  } catch { toast.error('Failed to submit quote request. Please try again.'); }
  finally { quoteSubmitting.value = false; }
}

onMounted(async () => {
  const cmsSettings = cmsStore.homeData?.settings;
  if (cmsSettings) settings.value = cmsSettings;
  await fetchProduct(route.params.slug as string);
  await fetchAdditionalData();
});
</script>
