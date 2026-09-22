<template>
  <PublicLayout>

    <!-- ═══════════════════════════════════════════
         HERO — unchanged
    ═══════════════════════════════════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="heroTechBg" alt="Building the Future of Technology" fetchpriority="high" loading="eager" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About Us</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Building the Future of Technology</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">We are a team of passionate technologists dedicated to delivering cutting-edge solutions that empower businesses to thrive in the digital age.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Work With Us
            <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         WHO WE ARE — text left, image right
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-14 items-center">

          <!-- Text -->
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Who We Are</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-5">
              OmniviaTech Technologies — <span class="text-primary">Your Digital Growth Partner</span>
            </h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">
              OmniviaTech Technologies is a full-spectrum digital solutions company headquartered in Nairobi, Kenya. We design, build, and scale technology that powers ambitious businesses — from lean startups to established enterprises — across Africa and the globe.
            </p>
            <p class="text-muted-foreground text-sm leading-relaxed mb-6">
              Our multidisciplinary team of engineers, designers, and strategists brings together global best practices and deep local market intelligence to create products that are not only technically sound, but commercially impactful. We specialise in web and mobile development, cloud infrastructure, AI-driven automation, and end-to-end digital transformation consulting.
            </p>

            <!-- Stats row -->
            <div class="grid grid-cols-3 gap-4 pt-2">
              <div class="border border-border rounded-xl p-4 text-center bg-card">
                <div class="text-2xl font-bold text-primary mb-0.5">3+</div>
                <div class="text-gray-500 text-[11px] leading-snug">Years of Excellence</div>
              </div>
              <div class="border border-border rounded-xl p-4 text-center bg-card">
                <div class="text-2xl font-bold text-primary mb-0.5">120+</div>
                <div class="text-gray-500 text-[11px] leading-snug">Projects Delivered</div>
              </div>
              <div class="border border-border rounded-xl p-4 text-center bg-card">
                <div class="text-2xl font-bold text-primary mb-0.5">80+</div>
                <div class="text-gray-500 text-[11px] leading-snug">Happy Clients</div>
              </div>
            </div>
          </div>

          <!-- Image -->
          <div class="relative">
            <div class="rounded-2xl overflow-hidden shadow-2xl">
              <img :src="heroLaptop" alt="OmniviaTech Team at Work" class="w-full h-full object-cover aspect-[4/3]" />
            </div>
            <!-- floating accent badge -->
            <div class="absolute -bottom-5 -left-5 bg-primary text-white rounded-2xl px-5 py-4 shadow-xl shadow-primary/30 hidden md:block">
              <div class="text-xl font-bold">95%</div>
              <div class="text-[11px] text-white/80">Client Satisfaction</div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         SERVICES WE OFFER — card grid
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">What We Do</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Services We Offer</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">
            A complete range of technology services crafted to accelerate your business in the digital economy.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          <div
            v-for="(svc, i) in services"
            :key="i"
            class="group relative bg-card border border-border rounded-2xl p-6 hover:border-primary/50 hover:shadow-xl transition-all duration-300 overflow-hidden"
          >
            <!-- subtle hover glow -->
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-gradient-to-br from-primary/5 to-transparent pointer-events-none rounded-2xl"></div>

            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary/20 transition">
              <span class="text-2xl">{{ svc.icon }}</span>
            </div>
            <h3 class="text-sm font-bold text-foreground mb-2 group-hover:text-primary transition-colors">{{ svc.title }}</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">{{ svc.desc }}</p>

            <!-- arrow on hover -->
            <div class="absolute top-5 right-5 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-1 group-hover:translate-x-0">
              <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </div>
          </div>
        </div>

        <div class="text-center mt-10">
          <router-link to="/services" class="inline-flex items-center gap-2 px-7 py-3 border border-primary text-primary text-sm font-semibold rounded-full hover:bg-primary hover:text-white transition-all">
            View All Services
            <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         INDUSTRIES WE SERVE — Swiper carousel
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Industries We Serve</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Built for Every Sector</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">
            We have partnered with organisations across a broad spectrum of industries, tailoring our approach to the specific realities of each sector.
          </p>
        </div>

        <Swiper
          :modules="[Autoplay, Pagination]"
          :slides-per-view="1"
          :space-between="16"
          :loop="true"
          :pagination="{ clickable: true, dynamicBullets: true }"
          :autoplay="{ delay: 3500, disableOnInteraction: false }"
          :breakpoints="{ 480: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 }, 1280: { slidesPerView: 5 } }"
          class="industries-swiper pb-12"
        >
          <SwiperSlide v-for="(ind, i) in industries" :key="i">
            <div class="group bg-card border border-border rounded-2xl p-6 text-center hover:border-primary/50 hover:shadow-lg transition-all duration-300 cursor-default">
              <div class="w-14 h-14 mx-auto bg-primary/10 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-primary/20 group-hover:scale-110 transition-all duration-300">
                <span class="text-3xl">{{ ind.icon }}</span>
              </div>
              <h3 class="text-sm font-semibold text-foreground group-hover:text-primary transition-colors mb-1">{{ ind.name }}</h3>
               <p class="text-gray-500 text-[11px] leading-relaxed">{{ ind.blurb }}</p>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         WHY CHOOSE US — dark card grid
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24 bg-muted/30">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Us</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Why OmniviaTech?</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">
            In a crowded technology landscape, our clients keep coming back because of the unique combination of expertise, integrity, and results we deliver.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <div
            v-for="(reason, i) in whyUsReasons"
            :key="i"
            class="relative group rounded-2xl p-7 transition-all duration-300 overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-1.5 border border-[#333] hover:border-[#d311f580]"
            style="background-color: #1c1c1c;"
          >
            <div class="absolute -top-8 -right-8 w-28 h-28 bg-primary/5 rounded-full group-hover:scale-150 group-hover:bg-primary/10 transition-all duration-500"></div>
            <div class="relative z-10">
              <div class="w-14 h-14 bg-gradient-to-br from-primary/30 to-primary/10 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-all duration-300 shadow-md">
                <span class="text-2xl">{{ reason.icon }}</span>
              </div>
              <h3 class="text-base font-bold text-white mb-2 group-hover:text-primary transition-colors">{{ reason.title }}</h3>
              <p class="text-white/70 text-sm leading-relaxed group-hover:text-white/90 transition-colors">{{ reason.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         OUR APPROACH — text left, image right (second split)
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-14 items-center">

          <!-- Text -->
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">How We Work</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-5">
              A Process Built Around <span class="text-primary">Your Success</span>
            </h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">
              At OmniviaTech, we do not simply hand over a product and walk away. We embed ourselves in your business reality — understanding your goals, constraints, and growth trajectory — before a single line of code is written.
            </p>
            <p class="text-muted-foreground text-sm leading-relaxed mb-6">
              Our agile delivery methodology means you see working software early and often, with continuous feedback loops that keep the final product tightly aligned to your evolving needs. From discovery workshops to post-launch support, we are with you at every stage.
            </p>

            <!-- Process steps -->
            <div class="space-y-4">
              <div v-for="(step, i) in processSteps" :key="i" class="flex items-start gap-4">
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                  <span class="text-primary text-xs font-bold">{{ String(i + 1).padStart(2, '0') }}</span>
                </div>
                <div>
                  <h4 class="text-sm font-semibold text-foreground mb-0.5">{{ step.title }}</h4>
                  <p class="text-muted-foreground text-xs leading-relaxed">{{ step.desc }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Image -->
          <div class="relative">
            <div class="rounded-2xl overflow-hidden shadow-2xl">
              <img :src="heroTech2" alt="Our Approach" class="w-full h-full object-cover aspect-[4/3]" />
            </div>
            <!-- floating accent -->
            <div class="absolute -top-5 -right-5 bg-card border border-border rounded-2xl px-5 py-4 shadow-xl hidden md:block">
              <div class="text-xl font-bold text-foreground">Agile</div>
              <div class="text-[11px] text-muted-foreground">Delivery Model</div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         OUR JOURNEY — vertical timeline (2023–Now)
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Journey</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">From Day One to Today</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">
            A short time in business, but every milestone has been intentional — growing steadily, sustainably, and always client-first.
          </p>
        </div>

        <div class="max-w-3xl mx-auto">
          <div class="relative pl-10 space-y-10 before:absolute before:left-3.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-gradient-to-b before:from-primary before:to-primary/20">
            <div v-for="(milestone, i) in journey" :key="i" class="relative group">
              <!-- dot -->
              <div class="absolute -left-10 top-1 w-5 h-5 rounded-full border-4 border-background flex-shrink-0 transition-transform group-hover:scale-125" :class="i === journey.length - 1 ? 'bg-primary shadow-lg shadow-primary/40' : 'bg-primary/60'"></div>

              <div class="bg-card border border-border rounded-xl p-5 hover:border-primary/40 hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-2">
                  <span class="text-xs font-bold text-primary bg-primary/10 px-3 py-1 rounded-full">{{ milestone.year }}</span>
                  <h3 class="text-sm font-bold text-foreground">{{ milestone.title }}</h3>
                </div>
                <p class="text-muted-foreground text-xs leading-relaxed">{{ milestone.desc }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         MISSION & VISION
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Purpose</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">Mission &amp; Vision</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
          <!-- Mission -->
          <div class="relative bg-card border border-border rounded-2xl p-8 overflow-hidden group hover:border-primary/40 hover:shadow-xl transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full pointer-events-none group-hover:bg-primary/10 transition-colors duration-500"></div>
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-5">
              <svg aria-hidden="true" class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-foreground mb-3">Our Mission</h3>
            <p class="text-muted-foreground text-sm leading-relaxed">
              To empower businesses with innovative, reliable, and scalable technology solutions that drive growth, efficiency, and digital transformation — delivering measurable impact for every client we serve.
            </p>
          </div>

          <!-- Vision -->
          <div class="relative bg-card border border-border rounded-2xl p-8 overflow-hidden group hover:border-accent/40 hover:shadow-xl transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-accent/5 rounded-bl-full pointer-events-none group-hover:bg-accent/10 transition-colors duration-500"></div>
            <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-5">
              <svg aria-hidden="true" class="w-6 h-6 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-foreground mb-3">Our Vision</h3>
            <p class="text-muted-foreground text-sm leading-relaxed">
              To become the most trusted and innovative technology partner in Africa — recognized globally for building solutions that uplift businesses, communities, and economies through the power of smart technology.
            </p>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         CORE VALUES
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">What We Believe</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Our Core Values</h2>
          <p class="text-muted-foreground text-sm">The principles that guide every decision, every project, every interaction.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          <div
            v-for="(val, i) in values"
            :key="i"
            class="group bg-card border border-border rounded-2xl p-6 text-center hover:border-primary/40 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
          >
            <div class="w-14 h-14 mx-auto bg-primary/10 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-primary/20 group-hover:scale-110 transition-all">
              <span class="text-2xl">{{ val.emoji }}</span>
            </div>
            <h3 class="text-sm font-bold text-foreground mb-2 group-hover:text-primary transition-colors">{{ val.title }}</h3>
            <p class="text-gray-500 text-[11px] leading-relaxed">{{ val.description }}</p>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         CTA — DARK BANNER (Join Our Team)
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="relative bg-black rounded-2xl overflow-hidden">
          <div class="absolute inset-0 opacity-30 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
          <div class="absolute inset-0 bg-black/70"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-8 md:p-12 lg:p-14">
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Careers</p>
              <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Join Our Growing Team</h2>
              <p class="text-white/70 text-sm leading-relaxed mb-8">
                We are always looking for talented, curious people who are passionate about technology and want to build things that matter. If that sounds like you, let's talk.
              </p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg">
                Get In Touch
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
              <img :src="heroTech4" alt="Join OmniviaTech" class="h-full max-h-[350px] object-cover object-top" />
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         TESTIMONIALS CAROUSEL
    ═══════════════════════════════════════════ -->
    <section v-if="topReviews.length" class="py-16 md:py-24 bg-muted/30">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-xl mx-auto mb-12">
          <p class="text-amber-500 text-xs font-semibold tracking-widest uppercase mb-2">Testimonials</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">What Our Clients Say</h2>
          <p class="text-muted-foreground text-xs">Trusted by businesses across Africa and beyond.</p>
        </div>

        <Swiper
          :modules="[Autoplay, Pagination]"
          :slides-per-view="1"
          :space-between="16"
          :pagination="{ clickable: true, dynamicBullets: true }"
          :autoplay="{ delay: 5000, disableOnInteraction: false }"
          :breakpoints="{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 }, 1280: { slidesPerView: 4 } }"
          class="testimonials-swiper pb-14"
        >
          <SwiperSlide v-for="review in topReviews" :key="review.id">
            <div class="rounded-xl p-5 h-full flex flex-col shadow-md hover:shadow-xl transition-all" style="background-color: #1c1c1c; border: 1px solid rgba(255,255,255,0.08);">
              <div class="flex gap-0.5 mb-3">
                <svg v-for="s in review.rating" :key="s" class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20" role="img" :aria-label="`${review.rating} out of 5 stars`">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
              </div>
              <p class="text-white/80 text-sm leading-relaxed mb-4 flex-1 line-clamp-4">"{{ review.comment }}"</p>
              <div class="flex items-center gap-3 pt-4" style="border-top: 1px solid rgba(255,255,255,0.08)">
                <div class="w-9 h-9 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                  {{ review.user_name?.charAt(0).toUpperCase() }}
                </div>
                <div class="min-w-0">
                  <div class="font-semibold text-white text-sm truncate">{{ review.user_name }}</div>
                  <div class="text-white/50 text-xs truncate">{{ review.company || 'Verified Client' }}</div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         REQUEST A QUOTE — modern split form
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24">
      <div class="container mx-auto px-6">
        <div class="max-w-5xl mx-auto bg-card border border-border rounded-2xl overflow-hidden shadow-xl">
          <div class="grid lg:grid-cols-2">

            <!-- Left panel — info -->
            <div class="relative p-10 flex flex-col justify-between bg-primary overflow-hidden">
              <div class="absolute inset-0 opacity-10" :style="{ backgroundImage: 'url(' + heroTechBg + ')', backgroundSize: 'cover' }"></div>
              <div class="relative z-10">
                <p class="text-white/70 text-xs font-semibold tracking-widest uppercase mb-3">Get Started</p>
                <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Start Your Project With Us</h2>
                <p class="text-white/80 text-sm leading-relaxed mb-8">
                  Have an idea or challenge? Fill in the form and one of our consultants will reach out within 24 hours to discuss how we can help.
                </p>

                <!-- contact bullets -->
                <div class="space-y-4">
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                      <svg aria-hidden="true" class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-white/80 text-sm">hello@omniviatech.com</span>
                  </div>
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                      <svg aria-hidden="true" class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <span class="text-white/80 text-sm">+254 700 000 000</span>
                  </div>
                  <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                      <svg aria-hidden="true" class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-white/80 text-sm">Nairobi, Kenya</span>
                  </div>
                </div>
              </div>

              <!-- decorative circle -->
              <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full"></div>
              <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/5 rounded-full"></div>
            </div>

            <!-- Right panel — form -->
            <div class="p-10">
              <h3 class="text-lg font-bold text-foreground mb-6">Send Us an Inquiry</h3>
              <form @submit.prevent="submitQuote" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-xs font-medium text-foreground mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm placeholder:text-muted-foreground/50" placeholder="John Doe" />
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-foreground mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm placeholder:text-muted-foreground/50" placeholder="john@company.com" />
                  </div>
                </div>
                <div>
                  <label class="block text-xs font-medium text-foreground mb-1.5">Phone Number</label>
                  <input v-model="quoteForm.phone" type="tel" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm placeholder:text-muted-foreground/50" placeholder="+254 700 000 000" />
                </div>
                <div>
                  <label class="block text-xs font-medium text-foreground mb-1.5">Service Interested In</label>
                  <select v-model="quoteForm.service" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm">
                    <option value="" disabled>Select a service...</option>
                    <option v-for="svc in services" :key="svc.title" :value="svc.title">{{ svc.title }}</option>
                    <option value="Other">Other / Not sure yet</option>
                  </select>
                </div>
                <div>
                  <label class="block text-xs font-medium text-foreground mb-1.5">Tell Us About Your Project <span class="text-red-500">*</span></label>
                  <textarea v-model="quoteForm.message" required rows="4" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm resize-none placeholder:text-muted-foreground/50" placeholder="Briefly describe what you need..."></textarea>
                </div>
                <button
                  type="submit"
                  :disabled="quoteSubmitting"
                  class="w-full px-5 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all flex items-center justify-center gap-2"
                >
                  <svg v-if="quoteSubmitting" aria-hidden="true" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                  {{ quoteSubmitting ? 'Submitting...' : 'Send Inquiry' }}
                  <svg v-if="!quoteSubmitting" aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         BLOG
    ═══════════════════════════════════════════ -->
    <section v-if="recentBlogs.length" class="py-16 md:py-24 bg-muted/30">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Latest Insights</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">From Our Blog</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <router-link v-for="post in recentBlogs.slice(0, 4)" :key="post.id" :to="`/blog/${post.slug}`" class="group bg-white border border-border rounded-2xl overflow-hidden hover:border-primary/20 hover:shadow-lg transition-all duration-300">
            <div class="aspect-[4/3] bg-gray-100 overflow-hidden">
              <img v-if="post.featured_image" :src="post.featured_image.startsWith('http') ? post.featured_image : `/storage/${post.featured_image}`" :alt="post.title" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/5 to-accent/5">
                <svg aria-hidden="true" class="w-10 h-10 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
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


    <!-- ═══════════════════════════════════════════
         FAQ
    ═══════════════════════════════════════════ -->
    <section v-if="aboutFaqs.length" class="py-16 md:py-24">
      <div class="container mx-auto px-6 max-w-3xl">
        <div class="text-center mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">Frequently Asked Questions</h2>
        </div>
        <div class="space-y-3">
          <div v-for="(faq, idx) in aboutFaqs" :key="idx" class="bg-card border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <button @click="toggleFaq(idx)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/30 transition-colors">
              <span class="font-medium text-foreground text-sm pr-6">{{ faq.question }}</span>
              <svg aria-hidden="true" class="w-5 h-5 text-muted-foreground shrink-0 transition-transform duration-200" :class="{ 'rotate-180': openFaqIndex === idx }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div v-show="openFaqIndex === idx" class="px-6 pb-5">
              <p class="text-muted-foreground text-sm leading-relaxed">{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ═══════════════════════════════════════════
         EXPLORE MORE (bottom CTA grid)
    ═══════════════════════════════════════════ -->
    <section class="py-16 md:py-24 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-10">
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Other Areas You Might Be Interested In</h2>
          <p class="text-muted-foreground text-sm">Explore more of what OmniviaTech has to offer.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          <router-link v-for="area in otherAreas" :key="area.label" :to="area.to" class="group bg-card border border-border rounded-xl p-5 text-center hover:border-primary/40 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary/20 transition"><span class="text-xl">{{ area.icon }}</span></div>
            <h3 class="text-xs font-semibold text-foreground group-hover:text-primary transition-colors">{{ area.label }}</h3>
          </router-link>
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<script setup lang="ts">
import axios from 'axios';
import { Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref } from 'vue';
import heroLaptop   from '@/../img/Laptop.webp';
import heroTechBg   from '@/../img/tech-background.webp';
import heroTechGlow from '@/../img/tech-glow.webp';
import heroTech2    from '@/../img/tech2.webp';
import heroTech4    from '@/../img/tech4.webp';
import { useToast } from '@/composables';
import PublicLayout  from '@/layouts/PublicLayout.vue';
import 'swiper/css';
import 'swiper/css/pagination';

const toast = useToast();
const topReviews  = ref<any[]>([]);
const recentBlogs = ref<any[]>([]);
const openFaqIndex = ref<number | null>(null);

// ─── Static data ────────────────────────────────────────

const services = [
  { icon: '🌐', title: 'Web Development',        desc: 'Custom, performant websites and web applications built with modern frameworks and best practices.' },
  { icon: '📱', title: 'Mobile App Development', desc: 'Native and cross-platform mobile apps for iOS and Android that users love.' },
  { icon: '☁️', title: 'Cloud Infrastructure',   desc: 'Scalable, secure cloud architecture on AWS, Azure, and GCP — from setup to ongoing management.' },
  { icon: '🤖', title: 'AI & Automation',         desc: 'Intelligent automation, machine learning models, and AI integrations that streamline your operations.' },
  { icon: '🔒', title: 'Cybersecurity',           desc: 'Enterprise-grade security audits, penetration testing, and ongoing monitoring to protect your business.' },
  { icon: '🔄', title: 'Digital Transformation',  desc: 'End-to-end consulting and implementation to modernise legacy systems and processes.' },
];

const industries = [
  { icon: '🏦', name: 'Fintech',            blurb: 'Secure, compliant financial platforms and payment systems.' },
  { icon: '🏥', name: 'Healthcare',         blurb: 'Digital health solutions that improve patient outcomes.' },
  { icon: '🛒', name: 'E-Commerce',         blurb: 'High-converting online stores and marketplace platforms.' },
  { icon: '🏗️', name: 'Real Estate',        blurb: 'Property portals, CRMs, and tenant management systems.' },
  { icon: '🏭', name: 'Manufacturing',      blurb: 'ERP integrations and industrial IoT solutions.' },
  { icon: '📡', name: 'Telecommunications', blurb: 'Customer portals, billing systems, and network tools.' },
  { icon: '🎓', name: 'Education',          blurb: 'LMS platforms and digital learning environments.' },
  { icon: '🚚', name: 'Logistics',          blurb: 'Fleet management, tracking, and supply chain software.' },
  { icon: '🏨', name: 'Hospitality',        blurb: 'Booking systems, PMS, and guest experience platforms.' },
];

const whyUsReasons = [
  { icon: '🌍', title: 'Deep Local, Global Standards', desc: 'We understand African markets intimately while delivering solutions that meet international quality and security benchmarks.' },
  { icon: '🚀', title: 'Proven Delivery',               desc: 'A growing portfolio of successful projects with a 95% client satisfaction rate — results speak louder than promises.' },
  { icon: '🎓', title: 'Certified Expert Team',         desc: 'Engineers, designers, and strategists who invest continuously in staying at the cutting edge of technology.' },
  { icon: '⚡', title: 'Agile & Transparent',           desc: 'Iterative delivery, clear communication, and no surprises — you are always in the loop on your project.' },
  { icon: '🔒', title: 'Security-First Mindset',        desc: 'Security is never an afterthought. We embed best practices into every layer of every solution we build.' },
  { icon: '🤝', title: 'Long-Term Partnerships',        desc: 'Over 80% of our clients return for follow-on work. We are invested in your long-term success, not just the project.' },
];

const processSteps = [
  { title: 'Discovery & Strategy',    desc: 'We start with deep listening — understanding your goals, users, and constraints before proposing any solution.' },
  { title: 'Design & Prototyping',    desc: 'Wireframes and interactive prototypes validated with your team before development begins.' },
  { title: 'Agile Development',        desc: 'Iterative sprints with regular demos so you see progress early and can provide continuous feedback.' },
  { title: 'Testing & Launch',         desc: 'Rigorous QA across devices and environments, then a carefully managed go-live.' },
  { title: 'Support & Growth',         desc: 'Post-launch monitoring, maintenance, and feature enhancements as your business evolves.' },
];

const journey = [
  {
    year: '2023 — Founded',
    title: 'The Beginning',
    desc: 'OmniviaTech Technologies was established in Nairobi by a small, passionate team of developers determined to deliver world-class digital solutions to African businesses.',
  },
  {
    year: '2024 — First Milestones',
    title: 'Building Momentum',
    desc: 'Completed our first 50 projects spanning web development, cloud infrastructure, and mobile apps. Grew our team and onboarded clients across East Africa.',
  },
  {
    year: '2025 — Expanding Footprint',
    title: 'Growing the Portfolio',
    desc: 'Launched our AI and automation service line. Surpassed 100 projects delivered and expanded our client base to include organisations across multiple African countries.',
  },
  {
    year: '2026 — Today & Beyond',
    title: 'Scaling New Heights',
    desc: 'Now a team of 20+ certified professionals serving 80+ clients, with an expanding focus on fintech, cybersecurity, and inclusive technology for underserved communities.',
  },
];

const values = [
  { emoji: '💡', title: 'Innovation',  description: 'We embrace new technologies and creative approaches to solve problems others cannot.' },
  { emoji: '🤝', title: 'Integrity',   description: 'Honest, transparent communication and ethical practices — always, without exception.' },
  { emoji: '🎯', title: 'Excellence',  description: 'High standards on every project. We only deliver work we are truly proud of.' },
  { emoji: '🚀', title: 'Impact',      description: 'Every solution is designed to create meaningful, lasting results for clients and communities.' },
];

const otherAreas = [
  { icon: '⚡', label: 'Services', to: '/services' },
  { icon: '📦', label: 'Products', to: '/products' },
  { icon: '💼', label: 'Bundles',  to: '/bundles' },
  { icon: '📝', label: 'Blog',     to: '/blog' },
];

const aboutFaqs = [
  { question: 'When was OmniviaTech founded?', answer: 'OmniviaTech was founded in 2023 and has been growing steadily since, delivering technology solutions across East Africa and beyond.' },
  { question: 'What industries do you serve?', answer: 'We serve fintech, healthcare, e-commerce, real estate, manufacturing, logistics, hospitality, telecommunications, and education sectors, among others.' },
  { question: 'Where are you based?', answer: 'Our primary office is in Nairobi, Kenya. We serve clients remotely across Africa and globally via our distributed engagement model.' },
  { question: 'What makes OmniviaTech different?', answer: 'Our combination of deep technical expertise, genuine understanding of African market dynamics, and a business-first approach ensures every solution delivers measurable ROI.' },
  { question: 'Do you offer ongoing support after launch?', answer: 'Absolutely. We provide post-launch maintenance, monitoring, updates, and feature enhancements as your business grows and evolves.' },
  { question: 'What technologies do you work with?', answer: 'We specialise in modern web and mobile frameworks, AWS/Azure/GCP cloud infrastructure, AI and ML, cybersecurity, and IoT — staying current through continuous learning.' },
];

// ─── Helpers ────────────────────────────────────────────

function toggleFaq(index: number) {
  openFaqIndex.value = openFaqIndex.value === index ? null : index;
}

function formatDate(date: string) {
  return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

// ─── API calls ──────────────────────────────────────────

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

loadReviews();
loadBlogs();

// ─── Quote form ─────────────────────────────────────────

const quoteForm = ref({ name: '', email: '', phone: '', service: '', message: '' });
const quoteSubmitting = ref(false);

async function submitQuote() {
  quoteSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', { type: 'contact', ...quoteForm.value });
    toast.success('Inquiry sent! We will contact you soon.');
    quoteForm.value = { name: '', email: '', phone: '', service: '', message: '' };
  } catch {
    toast.error('Failed to submit. Please try again.');
  } finally {
    quoteSubmitting.value = false;
  }
}
</script>
