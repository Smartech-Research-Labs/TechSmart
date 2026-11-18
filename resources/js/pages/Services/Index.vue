<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="s.hero_bg_image || heroLaptopDark" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Services</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Technology Solutions for Every Need</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">Comprehensive technology services designed to help your business innovate, scale, and succeed in the digital world.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Get a Free Quote
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ WHY CHOOSE US ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Us</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Why Businesses Trust Our Technology Services</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">With over a decade of experience delivering innovative technology solutions, we have built a reputation for excellence that spans across industries and continents. Our commitment to quality, innovation, and client success sets us apart.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="🏆" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Proven Track Record</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Over 500 projects delivered successfully across 15+ countries, serving clients ranging from startups to Fortune 500 enterprises.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="👥" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Expert Team</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Our team of 50+ certified engineers, architects, and consultants bring deep expertise in cutting-edge technologies and industry best practices.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="⚡" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Agile Delivery</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">We use agile methodologies to deliver solutions faster, with iterative development cycles that ensure your project stays on time and on budget.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="🔒" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Security First</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Every solution we build follows industry-standard security practices, including OWASP guidelines, regular audits, and compliance with data protection regulations.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="📈" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Scalable Solutions</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Our solutions are designed to grow with your business, from initial MVP to enterprise-scale deployments handling millions of users.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="🤝" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Dedicated Support</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">24/7 support with dedicated account managers, ensuring you have expert assistance whenever you need it throughout your project lifecycle.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ OUR PROCESS ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Process</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">How We Deliver Results</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">Our proven four-step process ensures every project is delivered with precision, transparency, and measurable business impact.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="text-center">
            <div class="w-16 h-16 mx-auto bg-primary rounded-full flex items-center justify-center mb-4"><span class="text-2xl font-bold text-white">1</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Discovery & Planning</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">We begin by understanding your business goals, challenges, and requirements through in-depth consultations and stakeholder interviews.</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 mx-auto bg-primary rounded-full flex items-center justify-center mb-4"><span class="text-2xl font-bold text-white">2</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Design & Architecture</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Our architects design scalable, secure solutions with detailed wireframes, system diagrams, and technology stack recommendations.</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 mx-auto bg-primary rounded-full flex items-center justify-center mb-4"><span class="text-2xl font-bold text-white">3</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Development & Testing</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Agile sprints with continuous integration, automated testing, and regular demos ensure quality and alignment with your vision.</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 mx-auto bg-primary rounded-full flex items-center justify-center mb-4"><span class="text-2xl font-bold text-white">4</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Deployment & Support</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Seamless deployment with monitoring, training, and ongoing support to ensure your solution performs optimally from day one.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ IMAGE LEFT + TEXT RIGHT ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="rounded-xl overflow-hidden">
            <img :src="s.services_page_image || heroLaptop" alt="Our Services" class="w-full h-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">What We Offer</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">End-to-End Digital Solutions</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">From custom software development to AI-powered automation, we provide the full spectrum of technology services your business needs to thrive in the modern economy.</p>
            <p class="text-muted-foreground text-sm leading-relaxed mb-6">Our team of experienced engineers and consultants work closely with you to understand your unique challenges and deliver solutions that create real, measurable impact.</p>
            <div class="flex flex-wrap gap-2">
              <span v-for="tag in ['Custom Software', 'Cloud & DevOps', 'AI & ML', 'Cybersecurity', 'Mobile Apps']" :key="tag" class="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full">{{ tag }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CATEGORY FILTER ═══════════════ -->
    <section class="py-3 bg-background border-y border-border sticky top-16 z-30">
      <div class="container mx-auto px-6">
        <div class="flex flex-wrap gap-2">
          <button @click="activeGroup = 'all'" :class="['px-4 py-1.5 rounded-full text-xs font-medium transition-all', activeGroup === 'all' ? 'bg-primary text-white' : 'bg-card border border-border text-muted-foreground hover:text-foreground']">All ({{ services.length }})</button>
          <button v-for="group in categoryGroups" :key="group" @click="activeGroup = group" :class="['px-4 py-1.5 rounded-full text-xs font-medium transition-all', activeGroup === group ? 'bg-primary text-white' : 'bg-card border border-border text-muted-foreground hover:text-foreground']">{{ group }}</button>
        </div>
      </div>
    </section>

    <!-- ═══════════════ SERVICE CARDS (4 per row, smaller) ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="i in 8" :key="i" class="bg-card border border-border rounded-xl overflow-hidden animate-pulse">
            <div class="aspect-[4/3] bg-muted"></div>
            <div class="p-4 space-y-2"><div class="h-3 bg-muted rounded w-3/4"></div><div class="h-2 bg-muted rounded w-full"></div></div>
          </div>
        </div>

        <template v-else-if="services.length">
          <template v-if="activeGroup === 'all'">
            <div v-for="group in categoryGroups" :key="group" class="mb-12 last:mb-0">
              <div class="flex items-center gap-4 mb-5">
                <h2 class="text-base font-bold text-foreground">{{ group }}</h2>
                <div class="flex-1 h-px bg-border"></div>
                <span class="text-[11px] text-muted-foreground">{{ groupedServices[group]?.length || 0 }} services</span>
              </div>
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <router-link v-for="service in groupedServices[group]" :key="service.id" :to="`/services/${service.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:border-primary/30 hover:shadow-lg transition-all">
                  <div class="aspect-[4/3] bg-muted overflow-hidden relative">
                    <img v-if="getServiceImage(service)" :src="getServiceImage(service)" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    <div v-else class="w-full h-full flex items-center justify-center"><PageIcon icon="💡" /></div>
                    <span class="absolute top-2 left-2 px-2 py-0.5 bg-primary/90 text-white text-[10px] font-medium rounded">{{ service.category }}</span>
                    <div class="absolute top-2 right-2 z-10" @click.prevent><WishlistButton type="App\\Models\\Service" :item-id="service.id" /></div>
                  </div>
                  <div class="p-4">
                    <h3 class="text-xs font-semibold text-foreground mb-1 group-hover:text-primary transition-colors line-clamp-2">{{ service.title }}</h3>
                    <p class="text-muted-foreground text-[11px] leading-relaxed line-clamp-2 mb-2">{{ service.excerpt || service.short_description }}</p>
                    <span class="text-primary font-medium text-[11px] flex items-center gap-1 group-hover:gap-1.5 transition-all">Learn More <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg></span>
                  </div>
                </router-link>
              </div>
            </div>
          </template>
          <template v-else>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
              <router-link v-for="service in filteredServices" :key="service.id" :to="`/services/${service.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:border-primary/30 hover:shadow-lg transition-all">
                <div class="aspect-[4/3] bg-muted overflow-hidden relative">
                  <img v-if="getServiceImage(service)" :src="getServiceImage(service)" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                  <img v-else-if="service.image_url" :src="service.image_url" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                  <div v-else class="w-full h-full flex items-center justify-center"><PageIcon icon="💡" /></div>
                  <span class="absolute top-2 left-2 px-2 py-0.5 bg-primary/90 text-white text-[10px] font-medium rounded">{{ service.category }}</span>
                  <div class="absolute top-2 right-2 z-10" @click.prevent><WishlistButton type="App\\Models\\Service" :item-id="service.id" /></div>
                </div>
                <div class="p-4">
                  <h3 class="text-xs font-semibold text-foreground mb-1 group-hover:text-primary transition-colors line-clamp-2">{{ service.title }}</h3>
                  <p class="text-muted-foreground text-[11px] leading-relaxed line-clamp-2 mb-2">{{ service.excerpt || service.short_description }}</p>
                  <span class="text-primary font-medium text-[11px] flex items-center gap-1 group-hover:gap-1.5 transition-all">Learn More <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg></span>
                </div>
              </router-link>
            </div>
          </template>
        </template>

        <div v-else class="text-center py-16">
          <h3 class="text-lg font-bold text-foreground mb-1">No services available</h3>
          <p class="text-muted-foreground text-sm">Please check back later.</p>
        </div>
      </div>
    </section>

      <!-- ═══════════════ TESTIMONIALS CAROUSEL ═══════════════ -->
      <section v-if="topReviews.length" class="py-14 md:py-20 bg-muted/20">
        <div class="container mx-auto px-6 max-w-6xl">
          <div class="text-center max-w-xl mx-auto mb-10">
            <p class="text-amber-600 dark:text-amber-400 text-xs font-semibold tracking-widest uppercase mb-2">Testimonials</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-3">What Our Clients Say About Our Services</h2>
            <p class="text-muted-foreground text-xs leading-relaxed">Trusted by hundreds of businesses for delivering quality technology solutions on time and on budget.</p>
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
              <div class="rounded-lg p-5 h-full flex flex-col shadow-md hover:shadow-xl transition-all bg-gray-900 border border-white/10">
                <div class="flex gap-0.5 mb-3">
                  <svg v-for="s in review.rating" :key="s" class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                </div>
                <p class="text-white/80 text-sm leading-relaxed mb-4 flex-1 line-clamp-3">"{{ review.comment }}"</p>
                <div class="flex items-center gap-3 pt-4 border-t border-white/10">
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

      <!-- ═══════════════ BLOG ═══════════════ -->
      <section v-if="recentBlogs.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6 max-w-5xl">
          <div class="text-center max-w-2xl mx-auto mb-10">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Latest Insights</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight">From Our Blog</h2>
            <p class="text-muted-foreground text-xs leading-relaxed mt-2">Learn more about technology trends, best practices, and case studies from our latest projects.</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <router-link v-for="post in recentBlogs.slice(0, 4)" :key="post.id" :to="`/blog/${post.slug}`" class="group bg-card border border-border rounded-2xl overflow-hidden hover:border-primary/20 hover:shadow-md transition-all duration-300">
              <div class="aspect-[4/3] bg-gray-100 overflow-hidden">
                <img v-if="post.featured_image" :src="blogImageUrl(post.featured_image)" :alt="post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
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

      <!-- ═══════════════ FAQ ═══════════════ -->
      <section v-if="servicesFaqs.length" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6 max-w-3xl">
          <div class="text-center mb-10">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight">Frequently Asked Questions About Our Services</h2>
          </div>

          <div class="space-y-3">
            <div v-for="(faq, idx) in servicesFaqs" :key="idx" class="bg-card border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
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

    <!-- ═══════════════ REQUEST A QUOTE ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-2">Get Started</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-2">Request a Quote</h2>
            <p class="text-muted-foreground text-sm mb-6">Tell us about your project and we'll get back to you within 24 hours.</p>
            <form @submit.prevent="submitQuote" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Email *" />
              </div>
              <div class="grid grid-cols-2 gap-3">
                <input v-model="quoteForm.phone" type="tel" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Phone *" />
                <select v-model="quoteForm.service" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm">
                  <option value="">Service Needed *</option>
                  <option v-for="s in services" :key="s.id" :value="s.title">{{ s.title }}</option>
                </select>
              </div>
              <textarea v-model="quoteForm.message" required rows="3" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm resize-none" placeholder="Project description..."></textarea>
              <button type="submit" :disabled="quoteSubmitting" class="w-full px-5 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all">{{ quoteSubmitting ? 'Submitting...' : 'Submit Quote Request' }}</button>
            </form>
          </div>
          <div class="hidden lg:block">
            <div class="rounded-xl overflow-hidden">
              <img :src="s.quote_section_image || heroTech2" alt="Get a Quote" class="w-full h-full object-cover aspect-[4/3]" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CTA (MAROON) ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="relative bg-black rounded-2xl overflow-hidden">
          <div class="absolute inset-0 opacity-30 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
          <div class="absolute inset-0 bg-black/70"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-8 md:p-12 lg:p-14">
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight mb-4">Need a Custom Solution?</h2>
              <p class="text-white/70 text-sm leading-relaxed mb-8">Tell us about your project and we will provide a free consultation and estimate tailored to your needs.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg">
                Get Free Consultation
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
              <img :src="s.cta_professional_image || heroTech4" alt="Professional" class="h-full max-h-[350px] object-cover object-top" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ OTHER AREAS ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-8">
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-3">Other Areas You Might Be Interested In</h2>
          <p class="text-muted-foreground text-sm">Explore more of what OmniviaTech has to offer.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <router-link v-for="area in otherAreas" :key="area.label" :to="area.to" class="group bg-card border border-border rounded-xl p-5 text-center hover:border-primary/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary/20 transition">
              <span class="text-xl"><PageIcon :icon="area.icon" /></span>
            </div>
            <h3 class="text-xs font-semibold text-foreground group-hover:text-primary transition-colors">{{ area.label }}</h3>
          </router-link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import PageIcon from '@/components/PageIcon.vue';
import { blogImageUrl } from '@/lib/blogImages';
import axios from 'axios';
import { Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref, computed, onMounted } from 'vue';
import heroLaptop from '@/../img/Laptop.webp';
import svcApi from '@/../img/services/API Development.webp';
import 'swiper/css';
import 'swiper/css/pagination';
import svcCrmErp from '@/../img/services/CRM & ERP Development.webp';
import svcCustomWeb from '@/../img/services/Custom Web Development.webp';
import svcEcommerce from '@/../img/services/E-commerece Development.webp';
import svcMobileApp from '@/../img/services/Mobile App Development.webp';
import svcMobileApp2 from '@/../img/services/Mobile App.webp';
import svcPaidAds from '@/../img/services/Paid Ads.webp';
import svcSeo from '@/../img/services/SEO Optimization.webp';
import heroLaptopDark from '@/../img/tech-background.webp';
import heroTechGlow from '@/../img/tech-glow.webp';
import heroTech2 from '@/../img/tech2.webp';
import heroTech4 from '@/../img/tech4.webp';
import WishlistButton from '@/components/WishlistButton.vue';
import { useToast } from '@/composables';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useCmsStore } from '@/stores/cms';

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

function getServiceImage(service: any): string | undefined {
  const title = (service.title || '').toLowerCase().trim();
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

const cmsStore = useCmsStore();
const s = computed(() => cmsStore.homeData?.settings || {} as any);
const toast = useToast();
const services = ref<any[]>([]);
const categoryGroups = ref<string[]>([]);
const groupedServices = ref<Record<string, any[]>>({});
const loading = ref(true);
const activeGroup = ref('all');

const filteredServices = computed(() => {
  if (activeGroup.value === 'all') return services.value;
  return services.value.filter((s: any) => s.category_group === activeGroup.value);
});

const otherAreas = [
  { icon: '📦', label: 'Products', to: '/products' },
  { icon: '💼', label: 'Bundles', to: '/bundles' },
  { icon: '📝', label: 'Blog', to: '/blog' },
  { icon: '📞', label: 'Contact', to: '/contact' },
];

// Quote Form
const quoteForm = ref({ name: '', email: '', phone: '', service: '', message: '' });
const quoteSubmitting = ref(false);

async function submitQuote() {
  quoteSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', { type: 'quote', ...quoteForm.value });
    toast.success('Quote request submitted! We will contact you within 24 hours.');
    quoteForm.value = { name: '', email: '', phone: '', service: '', message: '' };
  } catch { toast.error('Failed to submit. Please try again.'); }
  finally { quoteSubmitting.value = false; }
}

async function fetchServices() {
  loading.value = true;
  try {
    const { data } = await axios.get('/api/v1/services');
    const d = data.data || data;
    services.value = d.services || [];
    categoryGroups.value = d.category_groups || [];
    groupedServices.value = Object.fromEntries((d.grouped || []).map((group: any) => [group.name, group.services || []]));
  } catch (error) {
    console.error('Error fetching services:', error);
  } finally {
    loading.value = false;
  }
}

// Testimonials & Blog
const topReviews = ref<any[]>([]);
const recentBlogs = ref<any[]>([]);
const openFaqIndex = ref<number | null>(null);

const testimonialsPagination = {
  clickable: true,
  dynamicBullets: true,
};

const testimonialsAutoplay = {
  delay: 5000,
  disableOnInteraction: false,
};

const servicesFaqs = [
  { question: 'What services does OmniviaTech offer?', answer: 'We offer a comprehensive range of technology services including custom software development, mobile app development, web development, cloud infrastructure, AI/ML solutions, cybersecurity, API integration, and digital marketing services. Each service is tailored to meet your specific business needs.' },
  { question: 'How long does a typical project take?', answer: 'Project timelines vary based on scope and complexity. A simple website might take 4-8 weeks, while a complex enterprise application could take 3-6 months or longer. We use agile methodologies to provide regular updates and can break projects into phases for faster time-to-value.' },
  { question: 'What technologies does your team work with?', answer: 'Our team is proficient in modern web technologies (Vue.js, React, Angular), backend frameworks (Laravel, Node.js, Django), mobile platforms (iOS, Android, React Native), cloud platforms (AWS, Azure, GCP), and emerging technologies like AI/ML, blockchain, and IoT.' },
  { question: 'Do you provide ongoing support after project launch?', answer: 'Yes, we provide comprehensive post-launch support including bug fixes, performance optimization, security updates, and feature enhancements. We offer flexible support packages tailored to your business requirements.' },
  { question: 'How do you ensure quality in your projects?', answer: 'Quality is built into every phase of our development process. We follow industry best practices including code reviews, automated testing, continuous integration, security audits, and rigorous QA testing before deployment.' },
  { question: 'Can you work with existing legacy systems?', answer: 'Absolutely. We specialize in modernizing legacy systems, integrating them with new technologies, and migrating data safely. We assess your existing infrastructure and create a roadmap for seamless integration or migration.' },
];

async function loadReviews() {
  try {
    const { data } = await axios.get('/api/v1/reviews', { params: { limit: 8 } });
    topReviews.value = data.data || [];
  } catch { /* Error loading reviews */ }
}

async function loadBlogs() {
  try {
    const { data } = await axios.get('/api/v1/blogs', { params: { limit: 4 } });
    recentBlogs.value = data.data || [];
  } catch { /* Error loading blogs */ }
}

function toggleFaq(index: number) {
  openFaqIndex.value = openFaqIndex.value === index ? null : index;
}

function formatDate(date: string) {
  return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

onMounted(fetchServices);
onMounted(() => {
  loadReviews();
  loadBlogs();
});
</script>
