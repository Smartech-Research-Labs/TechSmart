<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="s.hero_bg_image || 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&h=1080&fit=crop&q=80'" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/80 to-white/40 dark:from-background/95 dark:via-background/80 dark:to-background/40"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Services</p>
          <h1 class="text-3xl md:text-4xl font-bold text-foreground leading-tight mb-4">Technology Solutions for Every Need</h1>
          <p class="text-muted-foreground text-sm leading-relaxed mb-6">Comprehensive technology services designed to help your business innovate, scale, and succeed in the digital world.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Get a Free Quote
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ IMAGE LEFT + TEXT RIGHT ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="rounded-xl overflow-hidden">
            <img :src="s.services_page_image || 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800&h=600&fit=crop&q=80'" alt="Our Services" class="w-full h-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">What We Offer</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">End-to-End Digital Solutions</h2>
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
                    <img v-if="service.image_url" :src="service.image_url" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    <div v-else class="w-full h-full flex items-center justify-center"><span class="text-3xl">💡</span></div>
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
                  <img v-if="service.image_url" :src="service.image_url" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                  <div v-else class="w-full h-full flex items-center justify-center"><span class="text-3xl">💡</span></div>
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

    <!-- ═══════════════ REQUEST A QUOTE ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-2">Get Started</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">Request a Quote</h2>
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
              <img :src="s.quote_section_image || 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800&h=600&fit=crop&q=80'" alt="Get a Quote" class="w-full h-full object-cover aspect-[4/3]" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CTA (MAROON) ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="relative bg-gradient-to-br from-red-900 via-red-800 to-red-900 rounded-2xl overflow-hidden">
          <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&q=40')] bg-cover bg-center"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-8 md:p-12 lg:p-14">
              <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Need a Custom Solution?</h2>
              <p class="text-red-100/80 text-sm leading-relaxed mb-8">Tell us about your project and we will provide a free consultation and estimate tailored to your needs.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg">
                Get Free Consultation
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
              <img :src="s.cta_professional_image || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=500&h=600&fit=crop&q=80'" alt="Professional" class="h-full max-h-[350px] object-cover object-top" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ OTHER AREAS ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-8">
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Other Areas You Might Be Interested In</h2>
          <p class="text-muted-foreground text-sm">Explore more of what OmniviaTech has to offer.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <router-link v-for="area in otherAreas" :key="area.label" :to="area.to" class="group bg-card border border-border rounded-xl p-5 text-center hover:border-primary/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary/20 transition">
              <span class="text-xl">{{ area.icon }}</span>
            </div>
            <h3 class="text-xs font-semibold text-foreground group-hover:text-primary transition-colors">{{ area.label }}</h3>
          </router-link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import WishlistButton from '@/components/WishlistButton.vue';
import axios from 'axios';
import { useToast } from '@/composables';
import { useCmsStore } from '@/stores/cms';

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
    groupedServices.value = d.grouped || {};
  } catch (error) {
    console.error('Error fetching services:', error);
  } finally {
    loading.value = false;
  }
}

onMounted(fetchServices);
</script>
