<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="tech1" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-2xl">
          <router-link to="/packages" class="inline-flex items-center gap-2 text-primary text-xs font-semibold tracking-widest uppercase mb-4 hover:gap-3 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            Back to Packages
          </router-link>
          <p v-if="pkg?.tier_level" class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">{{ pkg.tier_level }}</p>
          <h1 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-4">{{ pkg?.name }}</h1>
          <p class="text-white/80 text-base leading-relaxed mb-6">{{ pkg?.short_description }}</p>
        </div>
      </div>
    </section>

    <div v-if="loading" class="min-h-screen flex items-center justify-center">
      <div class="inline-block">
        <div class="w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
      </div>
    </div>

    <div v-else-if="pkg">
      <!-- ═══════════════ MAIN CONTENT ═══════════════ -->
      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="grid lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
              <!-- Price Section -->
              <div class="mb-8 pb-8 border-b border-border">
                <div v-if="pkg?.price" class="flex items-baseline gap-3 mb-4">
                  <span class="text-4xl font-bold text-primary">KES {{ formatPrice(pkg.price) }}</span>
                  <span v-if="pkg?.price_label" class="text-muted-foreground">{{ pkg.price_label }}</span>
                </div>
                <p class="text-muted-foreground">All packages include professional support and monthly maintenance.</p>
              </div>

              <!-- Description -->
              <div v-if="pkg?.description" class="mb-8 pb-8 border-b border-border">
                <div v-html="pkg.description" class="prose prose-invert max-w-none text-muted-foreground [&>h2]:text-2xl [&>h2]:font-bold [&>h2]:text-foreground [&>h2]:mb-4 [&>h2]:mt-0 [&>h3]:text-xl [&>h3]:font-bold [&>h3]:text-foreground [&>h3]:mb-3 [&>h3]:mt-4 [&>p]:leading-relaxed [&>p]:mb-4 [&>ul]:list-disc [&>ul]:list-inside [&>ul]:mb-4 [&>li]:text-muted-foreground [&>li]:mb-2 [&>strong]:font-semibold [&>strong]:text-foreground"></div>
              </div>

              <!-- Features List -->
              <div v-if="pkg?.includes && pkg.includes.length > 0" class="mb-8 pb-8 border-b border-border">
                <h2 class="text-2xl font-bold text-foreground mb-6">What's Included</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div v-for="(item, idx) in pkg.includes" :key="idx" class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-muted-foreground text-sm">{{ item }}</span>
                  </div>
                </div>
              </div>

              <!-- Features from packageFeatures -->
              <div v-if="pkg?.package_features && pkg.package_features.length > 0" class="mb-8">
                <h2 class="text-2xl font-bold text-foreground mb-6">Key Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div v-for="feature in pkg.package_features" :key="feature.id" class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
                    <div v-if="feature.icon" class="text-3xl mb-3">{{ feature.icon }}</div>
                    <h3 class="text-sm font-bold text-foreground mb-2">{{ feature.title }}</h3>
                    <p v-if="feature.description" class="text-muted-foreground text-xs leading-relaxed">{{ feature.description }}</p>
                  </div>
                </div>
              </div>

              <!-- Fallback Content if no features -->
              <div v-if="!pkg?.includes || pkg.includes.length === 0" class="mb-8 pb-8 border-b border-border">
                <h2 class="text-2xl font-bold text-foreground mb-6">Package Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-muted-foreground text-sm">Professional website design and development</span>
                  </div>
                  <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-muted-foreground text-sm">Responsive design for all devices</span>
                  </div>
                  <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-muted-foreground text-sm">SEO optimization included</span>
                  </div>
                  <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-muted-foreground text-sm">24/7 Support and maintenance</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
              <!-- Sticky Card -->
              <div class="sticky top-24 bg-gray-900 border border-white/10 rounded-xl p-6 space-y-4">
                <!-- Price Highlight -->
                <div v-if="pkg?.price" class="text-center pb-4 border-b border-white/10">
                  <div class="text-3xl font-bold text-primary mb-2">KES {{ formatPrice(pkg.price) }}</div>
                  <p class="text-white/60 text-xs">{{ pkg?.price_label || 'One-time payment' }}</p>
                </div>

                <!-- Wishlist Button -->
                <button
                  @click="toggleWishlist"
                  :disabled="wishlistLoading"
                  class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg transition-all"
                  :class="isInWishlist
                    ? 'bg-purple-700 border border-purple-600 text-white hover:bg-purple-800'
                    : 'bg-purple-600 border border-purple-600 text-white hover:bg-purple-700'
                  "
                >
                  <svg v-if="isInWishlist" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                  </svg>
                  {{ isInWishlist ? 'Added to Wishlist' : 'Add to Wishlist' }}
                </button>

                <!-- Contact Buttons -->
                <div class="space-y-3 pt-2">
                  <a
                    :href="`https://wa.me/${whatsappDigits}?text=${encodeURIComponent('Hi, I am interested in the ' + (pkg?.name || 'website') + ' package')}`"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#25D366] text-white rounded-lg hover:bg-[#20ba5a] transition-all text-sm font-semibold"
                  >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-5.031 1.378c-3.055 2.116-4.922 5.636-4.922 9.28 0 5.494 4.479 9.968 9.973 9.968a9.9 9.9 0 005.461-1.64l.084.05c1.046.31 2.151.271 3.182-.12 1.034-.394 1.978-1.247 2.583-2.335.338-.627.56-1.316.645-2.019.085-.703.041-1.425-.128-2.117-.326-1.379-1.045-2.656-2.066-3.704-2.23-2.216-5.392-3.606-8.809-3.606z"/>
                    </svg>
                    Chat on WhatsApp
                  </a>

                  <a
                    :href="`mailto:${s.contact_email || 'reachout@omniviatech.co.ke'}`"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-sm font-semibold"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email Us
                  </a>

                  <button
                    @click="scrollToQuote"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all text-sm font-semibold"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Get a Quote
                  </button>
                </div>

                <!-- Trust Badges -->
                <div class="pt-4 border-t border-white/10 space-y-3 text-center">
                  <div class="flex items-center justify-center gap-2 text-white/70 text-xs">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Professional Support
                  </div>
                  <div class="flex items-center justify-center gap-2 text-white/70 text-xs">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Monthly Maintenance
                  </div>
                  <div class="flex items-center justify-center gap-2 text-white/70 text-xs">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    24/7 Availability
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ WHY CHOOSE THIS PACKAGE ═══════════════ -->
      <section class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why This Package</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Why Choose {{ pkg?.name || 'This Package' }}</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">Discover the unique benefits and advantages of this package tier designed specifically for your business stage.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
              <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground mb-2">Perfect Value</h3>
              <p class="text-muted-foreground text-sm leading-relaxed">Optimized pricing that delivers maximum value for your investment without compromising on quality.</p>
            </div>

            <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
              <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground mb-2">Proven Results</h3>
              <p class="text-muted-foreground text-sm leading-relaxed">Used by hundreds of successful businesses that have achieved their online goals with this tier.</p>
            </div>

            <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
              <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground mb-2">Growth-Ready</h3>
              <p class="text-muted-foreground text-sm leading-relaxed">Easily upgrade or customize as your business grows without starting from scratch.</p>
            </div>

            <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
              <div class="w-12 h-12 bg-amber-500/20 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground mb-2">Expert Support</h3>
              <p class="text-muted-foreground text-sm leading-relaxed">Dedicated support team ready to help you get the most out of your package investment.</p>
            </div>

            <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
              <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground mb-2">Peace of Mind</h3>
              <p class="text-muted-foreground text-sm leading-relaxed">Regular backups, security monitoring, and compliance protection included in all services.</p>
            </div>

            <div class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
              <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
              </div>
              <h3 class="text-lg font-bold text-foreground mb-2">Lightning Speed</h3>
              <p class="text-muted-foreground text-sm leading-relaxed">Optimized performance that ensures fast loading times and excellent user experience.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ SPLIT SECTION - IMAGE + TEXT ═══════════════ -->
      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left - Image -->
            <div class="relative">
              <div class="rounded-2xl overflow-hidden shadow-lg">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&h=500&fit=crop&q=80" alt="Package Features" loading="lazy" decoding="async" class="w-full aspect-[4/3] object-cover" />
              </div>
            </div>

            <!-- Right - Content -->
            <div>
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Package Features in Detail</p>
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-6">What Makes {{ pkg?.name || 'This Package' }} Special</h2>
              <p class="text-muted-foreground text-sm leading-relaxed mb-6">This package is designed with the perfect balance of functionality and affordability. Whether you're just starting out or looking to enhance your existing presence, {{ pkg?.name || 'this package' }} provides all the essential tools you need.</p>

              <div class="space-y-4">
                <div class="flex items-start gap-4">
                  <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                  </div>
                  <div>
                    <h3 class="font-bold text-foreground mb-1">Complete Setup</h3>
                    <p class="text-muted-foreground text-sm">Full website configuration and launch support from our expert team.</p>
                  </div>
                </div>

                <div class="flex items-start gap-4">
                  <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  </div>
                  <div>
                    <h3 class="font-bold text-foreground mb-1">Training Included</h3>
                    <p class="text-muted-foreground text-sm">Comprehensive training to help you manage and maintain your website.</p>
                  </div>
                </div>

                <div class="flex items-start gap-4">
                  <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                  </div>
                  <div>
                    <h3 class="font-bold text-foreground mb-1">Ongoing Support</h3>
                    <p class="text-muted-foreground text-sm">Continuous maintenance and updates to keep your site secure and performing.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ TESTIMONIALS ═══════════════ -->
      <section v-if="topReviews.length" class="py-14 md:py-20 bg-gray-900">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Customer Success</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight mb-4">What Our Clients Say</h2>
            <p class="text-white/70 text-sm leading-relaxed">See how businesses like yours have achieved results working with us.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div v-for="review in topReviews.slice(0, 3)" :key="review.id" class="bg-white/5 border border-white/10 rounded-xl p-6 hover:border-primary/40 hover:bg-primary/5 transition-all">
              <div class="flex items-center gap-1 mb-4">
                <span v-for="i in review.rating" :key="i" class="text-amber-500">★</span>
              </div>
              <p class="text-white/80 text-sm leading-relaxed mb-4">"{{ review.comment }}"</p>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                  <span class="text-sm font-bold text-primary">{{ review.user_name?.charAt(0).toUpperCase() }}</span>
                </div>
                <div>
                  <p class="text-sm font-bold text-white">{{ review.user_name }}</p>
                  <p class="text-xs text-white/60">{{ review.company || 'Verified Client' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ COMPARISON CTA ═══════════════ -->
      <section class="py-14 md:py-20 bg-primary/5 border-y border-border">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Ready to Get Started?</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-8">
              Join hundreds of successful businesses using the {{ pkg?.name || 'Professional' }} package. Start building your online presence today with professional support every step of the way.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
              <a
                :href="`https://wa.me/${whatsappDigits}?text=${encodeURIComponent('Hi, I am interested in the ' + (pkg?.name || 'website') + ' package')}`"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all"
              >
                Get Started Now
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </a>
              <router-link
                to="/contact"
                class="inline-flex items-center justify-center gap-2 px-8 py-3 border-2 border-primary text-primary text-sm font-semibold rounded-full hover:bg-primary/10 transition-all"
              >
                Schedule a Call
              </router-link>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ GET A QUOTE FORM ═══════════════ -->
      <section id="quote-form" class="py-14 md:py-20 bg-muted/30">
        <div class="container mx-auto px-6">
          <div class="max-w-2xl mx-auto">
            <div class="text-center mb-12">
              <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Get Started Today</p>
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Request a Quote for {{ pkg?.name || 'This Package' }}</h2>
              <p class="text-muted-foreground text-sm leading-relaxed">Fill out the form below and our team will get back to you within 24 hours with a personalized quote and consultation.</p>
            </div>

            <form @submit.prevent="submitQuoteForm" class="bg-card border border-border rounded-2xl p-8 space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-semibold text-foreground mb-2">Full Name *</label>
                  <input
                    v-model="quoteForm.name"
                    type="text"
                    required
                    class="w-full px-4 py-3 bg-background border border-border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:border-primary transition-all"
                    placeholder="Your full name"
                  />
                </div>

                <div>
                  <label class="block text-sm font-semibold text-foreground mb-2">Email Address *</label>
                  <input
                    v-model="quoteForm.email"
                    type="email"
                    required
                    class="w-full px-4 py-3 bg-background border border-border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:border-primary transition-all"
                    placeholder="your@email.com"
                  />
                </div>

                <div>
                  <label class="block text-sm font-semibold text-foreground mb-2">Phone Number *</label>
                  <input
                    v-model="quoteForm.phone"
                    type="tel"
                    required
                    class="w-full px-4 py-3 bg-background border border-border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:border-primary transition-all"
                    placeholder="+254 700 000000"
                  />
                </div>

                <div>
                  <label class="block text-sm font-semibold text-foreground mb-2">Company Name</label>
                  <input
                    v-model="quoteForm.company"
                    type="text"
                    class="w-full px-4 py-3 bg-background border border-border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:border-primary transition-all"
                    placeholder="Your company name"
                  />
                </div>
              </div>

              <div>
                <label class="block text-sm font-semibold text-foreground mb-2">Tell us about your project</label>
                <textarea
                  v-model="quoteForm.message"
                  rows="4"
                  class="w-full px-4 py-3 bg-background border border-border rounded-lg text-foreground placeholder-muted-foreground focus:outline-none focus:border-primary transition-all resize-none"
                  placeholder="Share details about your project, requirements, or any specific questions..."
                ></textarea>
              </div>

              <div class="flex items-center gap-3">
                <input
                  v-model="quoteForm.agreeTerms"
                  type="checkbox"
                  id="agree"
                  class="rounded"
                />
                <label for="agree" class="text-sm text-muted-foreground">
                  I agree to receive email communications and understand my information will be used to provide a quote.
                </label>
              </div>

              <button
                type="submit"
                :disabled="submittingQuote"
                class="w-full px-8 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all flex items-center justify-center gap-2"
              >
                <span v-if="!submittingQuote">Send Quote Request</span>
                <span v-else>Sending...</span>
              </button>

              <p class="text-xs text-muted-foreground text-center">We'll get back to you within 24 hours at the email you provide.</p>
            </form>
          </div>
        </div>
      </section>
    </div>

    <!-- Error State -->
    <div v-else class="min-h-screen flex items-center justify-center">
      <div class="text-center">
        <h1 class="text-2xl font-bold text-foreground mb-4">Package Not Found</h1>
        <router-link to="/packages" class="text-primary hover:underline">
          Back to Packages
        </router-link>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { useCmsStore } from '@/stores/cms';
import { useToast } from '@/composables';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';
import tech1 from '@/../img/tech1.webp';

const route = useRoute();
const authStore = useAuthStore();
const cmsStore = useCmsStore();
const toast = useToast();
const s = computed(() => cmsStore.homeData?.settings || {} as any);
const whatsappDigits = computed(() => (s.value.whatsapp_number || s.value.contact_phone || '254710351517').replace(/[^0-9]/g, ''));
const pkg = ref<any>(null);
const loading = ref(true);
const wishlistLoading = ref(false);
const isInWishlist = ref(false);
const submittingQuote = ref(false);
const topReviews = ref<any[]>([]);
const quoteForm = ref({
  name: '',
  email: '',
  phone: '',
  company: '',
  message: '',
  agreeTerms: false,
});

const formatPrice = (price: number) => {
  return price.toLocaleString('en-KE', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });
};

const fetchPackage = async () => {
  try {
    loading.value = true;
    const response = await axios.get(`/api/v1/packages/${route.params.slug}`);
    pkg.value = response.data.data || response.data;
    await checkWishlistStatus();
  } catch (error) {
    console.error('Failed to fetch package:', error);
    pkg.value = null;
  } finally {
    loading.value = false;
  }
};

const checkWishlistStatus = async () => {
  if (!authStore.isAuthenticated || !pkg.value?.id) return;

  try {
    const response = await axios.get('/api/v1/user/wishlist');
    const wishlist = response.data.data || response.data;
    isInWishlist.value = wishlist.some(
      (item: any) => item.wishlistable_type === 'App\\Models\\Package' && item.wishlistable_id === pkg.value?.id
    );
  } catch (error) {
    console.error('Failed to check wishlist status:', error);
  }
};

const toggleWishlist = async () => {
  if (!authStore.isAuthenticated) {
    (authStore as any).showAuthModal = true;
    return;
  }

  if (!pkg.value?.id) return;

  try {
    wishlistLoading.value = true;

    if (isInWishlist.value) {
      // Remove from wishlist
      const wishlist = await axios.get('/api/v1/user/wishlist');
      const item = (wishlist.data.data || wishlist.data).find(
        (w: any) => w.wishlistable_type === 'App\\Models\\Package' && w.wishlistable_id === pkg.value?.id
      );
      if (item) {
        await axios.delete(`/api/v1/user/wishlist/${item.id}`);
      }
    } else {
      // Add to wishlist
      await axios.post('/api/v1/user/wishlist', {
        wishlistable_type: 'App\\Models\\Package',
        wishlistable_id: pkg.value?.id,
      });
    }

    isInWishlist.value = !isInWishlist.value;
  } catch (error) {
    console.error('Failed to toggle wishlist:', error);
  } finally {
    wishlistLoading.value = false;
  }
};

const scrollToQuote = () => {
  const quoteSection = document.getElementById('quote-form');
  if (quoteSection) {
    quoteSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
};

const submitQuoteForm = async () => {
  submittingQuote.value = true;
  try {
    await axios.post('/api/v1/enquiries', {
      type: 'quote',
      name: quoteForm.value.name,
      email: quoteForm.value.email,
      phone: quoteForm.value.phone,
      company: quoteForm.value.company,
      service: pkg.value?.name,
      message: quoteForm.value.message,
    });
    toast.success('Quote request submitted! We will contact you within 24 hours.');
    quoteForm.value = {
      name: '',
      email: '',
      phone: '',
      company: '',
      message: '',
      agreeTerms: false,
    };
  } catch (error) {
    console.error('Failed to submit quote form:', error);
    toast.error('Failed to submit. Please try again.');
  } finally {
    submittingQuote.value = false;
  }
};

async function loadReviews() {
  try {
    const { data } = await axios.get('/api/v1/reviews', { params: { limit: 6 } });
    topReviews.value = data.data || [];
  } catch { /* silent */ }
}

onMounted(() => {
  if (!cmsStore.homeData) cmsStore.fetchHomeData().catch(() => {});
  fetchPackage();
  loadReviews();
});
</script>
