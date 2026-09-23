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
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">{{ service.name }}</h2>
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
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Key Features & Deliverables</h2>
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
                <span v-if="tech.icon" v-html="tech.icon"></span>
                <span
                  v-else
                  class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-[10px] font-bold"
                  :style="{ backgroundColor: tech.mono }"
                >{{ tech.name.slice(0, 2).toUpperCase() }}</span>
              </div>
              <span class="text-[11px] font-semibold text-foreground text-center leading-tight group-hover:text-primary transition-colors">{{ tech.name }}</span>
            </div>
          </div>

          <p class="text-center text-muted-foreground text-xs mt-8">Don't see your stack? <router-link to="/contact" class="text-primary font-semibold hover:underline underline-offset-2">Talk to us — we adapt.</router-link></p>
        </div>
      </section>


      <!-- ═══════════════ 6. CASE STUDIES ═══════════════ -->
      <section class="py-14 md:py-20" :class="caseStudies.length ? '' : 'bg-muted/30'">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Success Stories</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Case Studies</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">See how our {{ service.name }} service has delivered real results for our clients.</p>
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
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Related Articles</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Stay up to date with the latest insights about {{ service.category || service.name }}.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <router-link v-for="post in relatedBlogs.slice(0, 3)" :key="post.id" :to="`/blog/${post.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:shadow-lg hover:border-primary/20 transition-all">
              <div class="aspect-[16/10] overflow-hidden">
                <img :src="post.featured_image ? (post.featured_image.startsWith('http') ? post.featured_image : `/storage/${post.featured_image}`) : heroTech7" :alt="post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
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

            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">
              Related Services
            </h2>

            <p class="text-muted-foreground text-sm leading-relaxed">
              Other services that complement {{ service.name }}.
            </p>
          </div>

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
        </div>
      </section>

      <!-- ═══════════════ 8B. WHY CHOOSE US ═══════════════ -->
      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Us</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">The OmniviaTech Advantage</h2>
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
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Areas You Might Be Interested In</h2>
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
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">What Our Clients Say</h2>
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
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Have Questions?</h2>
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


       <!-- ═══════════════ REQUEST A QUOTE ═══════════════ -->
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
          <!-- Left - Form -->
          <div>
            <form @submit.prevent="submitQuoteRequest" class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <input v-model="quoteForm.name" type="text" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white/40" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white/40" placeholder="Email *" />
              </div>
              <div class="grid grid-cols-2 gap-4">
                <input v-model="quoteForm.phone" type="tel" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white/40" placeholder="Phone *" />
                <select v-model="quoteForm.service" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all">
                  <option value="" class="text-gray-900">Service Needed *</option>
                  <option v-for="service in allServices" :key="service.id" :value="service.title" class="text-gray-900">{{ service.title }}</option>
                </select>
              </div>
              <textarea v-model="quoteForm.description" required rows="4" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm resize-none transition-all placeholder-white/40" placeholder="Project description..."></textarea>
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
import heroLaptop from '@/../img/Laptop.webp';
import svcApi from '@/../img/services/API Development.webp';
import svcCrmErp from '@/../img/services/CRM & ERP Development.webp';
import svcCustomWeb from '@/../img/services/Custom Web Development.webp';
import svcEcommerce from '@/../img/services/E-commerece Development.webp';
import svcMobileApp from '@/../img/services/Mobile App Development.webp';
import svcMobileApp2 from '@/../img/services/Mobile App.webp';
import svcPaidAds from '@/../img/services/Paid Ads.webp';
import svcSeo from '@/../img/services/SEO Optimization.webp';
import heroLaptopDark from '@/../img/tech-background.webp';
import heroTech7 from '@/../img/tech7.webp';

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
import { computed, ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Navigation } from 'swiper/modules';
import PublicLayout from '@/layouts/PublicLayout.vue';
import api from '@/services/api';
import { useCmsStore } from '@/stores/cms';
import { useToast } from '@/composables';
// Swiper styles are imported globally in the main layout
// import 'swiper/css';
// import 'swiper/css/navigation';

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


// Tech stack
const stackCategories = [
  { label: 'Frontend' },
  { label: 'Backend' },
  { label: 'Mobile' },
  { label: 'Database' },
  { label: 'DevOps' },
  { label: 'Design' },
];

// Real brand icons where available; `mono` is an honest colored-initial
// fallback badge for tools we don't have an accurate logo path for,
// rather than reusing a generic circle as a fake logo.
const stackData: Record<string, { name: string; icon?: string; mono?: string }[]> = {
  Frontend: [
    { name: 'Vue.js', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#42b883" d="M78.8 10L64 35.4 49.2 10H0l64 110 64-110z"/><path fill="#35495e" d="M78.8 10L64 35.4 49.2 10H25.6L64 76l38.4-66z"/></svg>' },
    { name: 'React', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><circle cx="64" cy="64" r="11.4" fill="#61dafb"/><path fill="none" stroke="#61dafb" stroke-width="5" d="M64 30c19.9 0 36.6 5.4 36.6 12 0 6.6-16.7 12-36.6 12S27.4 48.6 27.4 42c0-6.6 16.7-12 36.6-12z"/><path fill="none" stroke="#61dafb" stroke-width="5" d="M47.1 47c9.95-17.2 23.1-29.7 29.6-26 6.5 3.7 4 20.6-5.95 37.8S47.7 88.7 41.2 85c-6.5-3.7-4-20.6 5.9-38z"/><path fill="none" stroke="#61dafb" stroke-width="5" d="M47.1 81C37.15 63.8 34.65 46.9 41.2 43.2c6.5-3.7 19.65 8.8 29.6 26S81.1 102.7 74.65 106.4C68.1 110.1 57.05 98.2 47.1 81z"/></svg>' },
    { name: 'Next.js', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><circle cx="64" cy="64" r="64" fill="#000"/><path fill="#fff" d="M48 100V28l60 76H92L48 44v56H48z"/></svg>' },
    { name: 'TypeScript', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><rect width="128" height="128" rx="6" fill="#3178c6"/><path fill="#fff" d="M22 72h20v-8H22v8zm0 12h20v-8H22v8zm0 12h10v-8H22v8zM72 48H32V32h40v16zm16 48c-6.6 0-12-5.4-12-12s5.4-12 12-12 12 5.4 12 12-5.4 12-12 12z"/><path fill="#fff" d="M56 96V56h16v8h8V56h16v40H80V72h-8v24H56z"/></svg>' },
    { name: 'Tailwind', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#38bdf8" d="M64 16C45.1 16 33.6 25.5 29 44.5c6.5-8.7 14-12 22.8-9.7 4.9 1.2 8.5 4.9 12.4 8.9C70.5 50.4 78.3 58.5 96 58.5c18.9 0 30.4-9.5 35-28.5-6.5 8.7-14 12-22.8 9.7-4.9-1.2-8.5-4.9-12.4-8.9C89.5 24.1 81.7 16 64 16zM29 58.5C10.1 58.5-1.4 68 -6 87c6.5-8.7 14-12 22.8-9.7 4.9 1.2 8.5 4.9 12.4 8.9C35.5 92.9 43.3 101 61 101c18.9 0 30.4-9.5 35-28.5-6.5 8.7-14 12-22.8 9.7-4.9-1.2-8.5-4.9-12.4-8.9C54.5 66.6 46.7 58.5 29 58.5z"/></svg>' },
    { name: 'Nuxt.js', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#00DC82" d="M72 28L40 84H8L64 0 120 84H88L56 28z" opacity=".6"/><path fill="#00DC82" d="M104 84L72 28 40 84h64z" opacity=".3"/></svg>' },
  ],
  Backend: [
    { name: 'Laravel', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#FF2D20" d="M124.3 23.5L102.5 5.3A7.2 7.2 0 0097.1 3H30.9a7.2 7.2 0 00-5.4 2.3L3.7 23.5A7.2 7.2 0 002 28.1v71.8a7.2 7.2 0 007.2 7.2h109.6a7.2 7.2 0 007.2-7.2V28.1a7.2 7.2 0 00-1.7-4.6zM64 92L26 54l10-10 28 28 28-28 10 10L64 92z"/></svg>' },
    { name: 'Node.js', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#83cd29" d="M112.8 85.3L67.4 111a7.2 7.2 0 01-6.8 0L15.2 85.3A7.2 7.2 0 0112 79V29a7.2 7.2 0 013.2-6.2L60.6 6.7a7.2 7.2 0 016.8 0l45.4 16.1A7.2 7.2 0 01116 29v50a7.2 7.2 0 01-3.2 6.3z"/><path fill="#fff" d="M64 29v70L28 79V49L64 29z" opacity=".5"/></svg>' },
    { name: 'Python', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#3572A5" d="M63.5 3C37.3 3 39 14 39 14v12h25v4H25S3 27.6 3 54.3C3 81 18.8 80 18.8 80H29V67.5S28.3 52 44 52h39.7S99 52.8 99 38V17C99 3.3 87 3 63.5 3zM51 19.5a5.5 5.5 0 110 11 5.5 5.5 0 010-11z"/><path fill="#FFD43B" d="M64.5 125C90.7 125 89 114 89 114v-12H64v-4h39S125 100.4 125 73.7C125 47 109.2 48 109.2 48H99V60.5S99.7 76 84 76H44.3S29 75.2 29 89V110C29 123.7 41 125 64.5 125zM77 108.5a5.5 5.5 0 110-11 5.5 5.5 0 010 11z"/></svg>' },
    { name: 'PHP', mono: '#777bb4' },
    { name: 'Go', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><circle cx="64" cy="64" r="56" fill="#00ADD8"/><path fill="#fff" d="M40 60h24v8H40zm0 16h40v8H40zm8-32h40v8H48z"/></svg>' },
    { name: 'Rust', mono: '#dea584' },
  ],
  Mobile: [
    { name: 'Flutter', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#54C5F8" d="M14 64L62 16h52L66 64 114 112H62L14 64z"/><path fill="#01579B" d="M62 112l26-26-14-14L38 112z"/><path fill="#29B6F6" d="M88 86L62 112l-12-12 26-26z"/></svg>' },
    { name: 'React Native', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><circle cx="64" cy="64" r="11.4" fill="#61dafb"/><path fill="none" stroke="#61dafb" stroke-width="5" d="M64 30c19.9 0 36.6 5.4 36.6 12 0 6.6-16.7 12-36.6 12S27.4 48.6 27.4 42c0-6.6 16.7-12 36.6-12zM47.1 47c9.95-17.2 23.1-29.7 29.6-26 6.5 3.7 4 20.6-5.95 37.8S47.7 88.7 41.2 85c-6.5-3.7-4-20.6 5.9-38zM47.1 81C37.15 63.8 34.65 46.9 41.2 43.2c6.5-3.7 19.65 8.8 29.6 26S81.1 102.7 74.65 106.4C68.1 110.1 57.05 98.2 47.1 81z"/></svg>' },
    { name: 'Kotlin', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#7F52FF" d="M8 8h56l-56 56V8zm0 112l56-56 56 56H8zm64-56L128 8v112L72 64z"/></svg>' },
    { name: 'Swift', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><rect width="128" height="128" rx="24" fill="#F05138"/><path fill="#fff" d="M96 72c0 17.7-14.3 32-32 32a32 32 0 01-20.7-7.6s13.7 4.1 26.7-8.4C56.5 83.9 37.4 69 28 48c14 15 36 24 50 24-9-9-17.5-22.8-17.5-37.5A32 32 0 0196 72z"/></svg>' },
    { name: 'Ionic', mono: '#3880ff' },
  ],
  Database: [
    { name: 'MySQL', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#00618A" d="M2 73.9c5.3.7 8.9 3 9.9 7.6 1.1 4.9-1.8 9.7-7.4 12.7L2 95v10.5l3.3-1.5c7.4-3.3 12.5-9 13.5-15.8.8-5.2-.8-10.3-4.4-14.3h91.2c-3.6 4-5.2 9.1-4.4 14.3 1 6.8 6.1 12.5 13.5 15.8l3.3 1.5V95l-2.5-1.3c-5.6-3-8.5-7.8-7.4-12.7 1-4.6 4.6-6.9 9.9-7.6V62.6H2v11.3z"/><path fill="#00618A" d="M2 23v9.3c5.3.7 8.9 3 9.9 7.6 1.1 4.9-1.8 9.7-7.4 12.7L2 53.5V64h124v-10.5l-2.5-1.5c-5.6-3-8.5-7.8-7.4-12.7 1-4.6 4.6-6.9 9.9-7.6V23H2z"/></svg>' },
    { name: 'PostgreSQL', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#336791" d="M93.8 24.2C87.4 17.7 78.7 14 69.5 14c-7.7 0-15 2.6-20.9 7.2-5.9-4.6-13.2-7.2-20.9-7.2C18.5 14 9.8 17.7 3.4 24.2A34.5 34.5 0 000 45c0 7.2 2.5 14.2 7.1 19.8 2.8 3.4 6.2 6.2 10 8.2v35h104V73c3.8-2 7.2-4.8 10-8.2C135.5 59.2 138 52.2 138 45c0-7.9-3-15.4-8.3-20.8z"/></svg>' },
    { name: 'MongoDB', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#4DB33D" d="M64 8C40.5 8 21.5 27 21.5 50.5c0 16.5 9.3 31 23 38.6V116h7v-25.1c.8.1 1.7.1 2.5.1s1.7 0 2.5-.1V116h7V89.1c13.7-7.6 23-22.1 23-38.6C86.5 27 67.5 8 64 8z"/></svg>' },
    { name: 'Redis', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#D82C20" d="M64 8L8 40v48l56 32 56-32V40L64 8zm0 10l44 25.4v38.8L64 107 20 82.2V43.4L64 18z"/></svg>' },
    { name: 'SQLite', mono: '#003b57' },
  ],
  DevOps: [
    { name: 'AWS', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#FF9900" d="M40 72c-9 4-15 12.5-15 22.5C25 108.3 35.7 119 49.5 119c5.3 0 10.3-1.7 14.3-4.7M88 72c9 4 15 12.5 15 22.5C103 108.3 92.3 119 78.5 119c-5.3 0-10.3-1.7-14.3-4.7"/><path fill="#232F3E" d="M64 9L20 33v30l44 24 44-24V33L64 9zm0 8l36 20v24L64 81 28 61V37L64 17z"/></svg>' },
    { name: 'Docker', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#2496ED" d="M124.8 52.1c-2-1.4-6.6-2-10.1-1.3-.4-3.4-2.4-6.4-5.9-9.1l-2-1.4-1.4 2c-1.8 2.7-2.4 7.2-2.2 10.7-.6-.3-1.6-.7-2.3-1.1-1.4-.8-3.9-1.8-6.8-1.7H8.2l-.3 1.7c-.6 3.7-.4 12.1 4.8 19.2 3.8 5.2 9.5 7.8 16.8 7.8 16 0 27.8-7.4 33.3-20.8 2.2.1 6.9.2 9.3-4.6l.5-1-1-.6zM56 52H46v10h10V52zm-13 0H33v10h10V52zm-13 0H20v10h10V52zm26-13H56v10h10V39zm-13 0H43v10h10V39zm-13 0H30v10h10V39zm13-13H56v10h10V26zm-13 0H43v10h10V26z"/></svg>' },
    { name: 'Kubernetes', mono: '#326ce5' },
    { name: 'GitHub CI', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#181717" d="M64 4C30.2 4 3 31.2 3 65c0 27 17.5 49.9 41.8 58 3 .6 4.1-1.3 4.1-2.9v-10.2c-16.9 3.7-20.4-8.1-20.4-8.1-2.7-6.9-6.7-8.7-6.7-8.7-5.5-3.7.4-3.7.4-3.7 6 .4 9.2 6.2 9.2 6.2 5.4 9.2 14.1 6.5 17.5 5 .5-3.9 2.1-6.5 3.8-8-13.4-1.5-27.5-6.7-27.5-29.9 0-6.6 2.4-12 6.2-16.2-.6-1.5-2.7-7.7.6-16 0 0 5.1-1.6 16.6 6.2 4.8-1.3 10-2 15.1-2s10.3.7 15.1 2c11.5-7.8 16.6-6.2 16.6-6.2 3.3 8.3 1.2 14.5.6 16 3.9 4.2 6.2 9.6 6.2 16.2 0 23.2-14.1 28.3-27.6 29.8 2.2 1.9 4.1 5.5 4.1 11.1v16.5c0 1.6 1.1 3.5 4.2 2.9C109.5 114.9 127 92 127 65 127 31.2 99.8 4 64 4z"/></svg>' },
    { name: 'DigitalOcean', icon: '<svg viewBox="0 0 128 128" width="24" height="24"><path fill="#0080FF" d="M64 112v-16c22 0 40-18 40-40S86 16 64 16 24 34 24 56h16c0-13 11-24 24-24s24 11 24 24-11 24-24 24v32z"/></svg>' },
  ],
  Design: [
    { name: 'Figma', mono: '#f24e1e' },
    { name: 'Adobe XD', mono: '#ff61f6' },
    { name: 'Sketch', mono: '#f7b500' },
    { name: 'Photoshop', mono: '#31a8ff' },
    { name: 'Illustrator', mono: '#ff9a00' },
  ],
};

const activeStack = ref('Frontend');

const activeStackTechs = computed(() => stackData[activeStack.value] || []);


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
