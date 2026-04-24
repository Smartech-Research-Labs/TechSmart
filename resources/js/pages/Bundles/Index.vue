<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&h=1080&fit=crop&q=80" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/80 to-white/40 dark:from-background/95 dark:via-background/80 dark:to-background/40"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Value Bundles</p>
          <h1 class="text-3xl md:text-4xl font-bold text-foreground leading-tight mb-4">Save More with Curated Packages</h1>
          <p class="text-muted-foreground text-sm leading-relaxed mb-6">Pre-configured service bundles designed to deliver maximum value for your business.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Get a Custom Bundle
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
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop&q=80" alt="Bundles" class="w-full h-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Bundled Solutions</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">More Value, Less Hassle</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">Our curated bundles combine essential services and products into cost effective packages. Each bundle is carefully designed by our experts to address common business challenges.</p>
            <p class="text-muted-foreground text-sm leading-relaxed">Save up to 40% compared to purchasing individual services, and get everything you need to launch, grow, or transform your business.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ VALUE CARDS ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-10">
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Why Choose Our Bundles</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="(val, i) in valueProps" :key="i" class="bg-card border border-border rounded-xl p-5 text-center hover:border-primary/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3"><span class="text-xl">{{ val.icon }}</span></div>
            <h3 class="text-xs font-semibold text-foreground mb-1">{{ val.title }}</h3>
            <p class="text-muted-foreground text-[11px] leading-relaxed">{{ val.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ BUNDLES GRID ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="mb-8">
          <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-2">Packages</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight">Available Bundles</h2>
        </div>

        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          <div v-for="i in 3" :key="i" class="bg-card border border-border rounded-xl p-6 animate-pulse">
            <div class="h-5 bg-muted rounded w-1/2 mb-3"></div>
            <div class="h-8 bg-muted rounded w-1/3 mb-4"></div>
            <div class="space-y-2"><div class="h-3 bg-muted rounded w-full"></div><div class="h-3 bg-muted rounded w-3/4"></div></div>
          </div>
        </div>

        <div v-else-if="bundles.length === 0" class="text-center py-16">
          <h3 class="text-lg font-bold text-foreground mb-1">No bundles available</h3>
          <p class="text-muted-foreground text-sm">Check back soon for new packages.</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          <div v-for="bundle in bundles" :key="bundle.id" class="bg-card border border-border rounded-xl p-6 hover:border-accent/30 hover:shadow-lg transition-all" :class="{ 'ring-2 ring-primary border-primary': bundle.is_featured }">
            <div v-if="bundle.is_featured" class="inline-block text-[10px] font-semibold text-primary bg-primary/10 px-2 py-0.5 rounded mb-3">Most Popular</div>
            <h3 class="text-base font-bold text-foreground mb-1">{{ bundle.name }}</h3>
            <div class="flex items-baseline gap-1 mb-3">
              <span class="text-2xl font-bold text-accent">Ksh {{ Number(bundle.price).toLocaleString() }}</span>
              <span v-if="bundle.original_price" class="text-xs text-muted-foreground line-through">Ksh {{ Number(bundle.original_price).toLocaleString() }}</span>
            </div>
            <p class="text-muted-foreground text-xs leading-relaxed mb-4">{{ bundle.description }}</p>
            <ul class="space-y-2 mb-6">
              <li v-for="item in (bundle.items || [])" :key="item.id" class="flex items-center gap-2 text-sm text-foreground">
                <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                {{ item.title || item.name }}
              </li>
            </ul>
            <router-link :to="`/contact?bundle=${bundle.slug || bundle.id}`" class="block text-center w-full px-4 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-all">Get Started</router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ REQUEST A QUOTE ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-2">Custom Package</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">Need a Custom Bundle?</h2>
            <p class="text-muted-foreground text-sm mb-6">We can create a tailored package that fits your exact needs and budget.</p>
            <form @submit.prevent="submitQuote" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Email *" />
              </div>
              <input v-model="quoteForm.phone" type="tel" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Phone *" />
              <textarea v-model="quoteForm.message" required rows="3" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm resize-none" placeholder="Describe your requirements..."></textarea>
              <button type="submit" :disabled="quoteSubmitting" class="w-full px-5 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all">{{ quoteSubmitting ? 'Submitting...' : 'Request Custom Bundle' }}</button>
            </form>
          </div>
          <div class="hidden lg:block">
            <div class="rounded-xl overflow-hidden"><img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800&h=600&fit=crop&q=80" alt="Custom Bundle" class="w-full h-full object-cover aspect-[4/3]" /></div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CTA (MAROON) ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="relative bg-gradient-to-br from-red-900 via-red-800 to-red-900 rounded-2xl overflow-hidden">
          <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&q=40')] bg-cover bg-center"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-8 md:p-12 lg:p-14">
              <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Let's Build Your Perfect Package</h2>
              <p class="text-red-100/80 text-sm leading-relaxed mb-8">Every business is unique. Let us design a custom bundle that addresses your specific needs and maximizes your ROI.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg">
                Talk to Us
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
              <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=500&h=600&fit=crop&q=80" alt="Professional" class="h-full max-h-[350px] object-cover object-top" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ OTHER AREAS ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-8">
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Other Areas You Might Be Interested In</h2>
          <p class="text-muted-foreground text-sm">Explore more of what OmniviaTech has to offer.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <router-link v-for="area in otherAreas" :key="area.label" :to="area.to" class="group bg-card border border-border rounded-xl p-5 text-center hover:border-primary/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary/20 transition"><span class="text-xl">{{ area.icon }}</span></div>
            <h3 class="text-xs font-semibold text-foreground group-hover:text-primary transition-colors">{{ area.label }}</h3>
          </router-link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';
import { useToast } from '@/composables';

const toast = useToast();
const bundles = ref<any[]>([]);
const loading = ref(true);

const valueProps = [
  { icon: '💰', title: 'Cost Savings', desc: 'Save up to 40% on bundled services' },
  { icon: '🎯', title: 'Expert Curated', desc: 'Designed by our specialists' },
  { icon: '⚡', title: 'Quick Start', desc: 'Launch your project faster' },
  { icon: '🔄', title: 'Flexible Options', desc: 'Customizable to fit your needs' },
];

const otherAreas = [
  { icon: '⚡', label: 'Services', to: '/services' },
  { icon: '📦', label: 'Products', to: '/products' },
  { icon: '📝', label: 'Blog', to: '/blog' },
  { icon: '📞', label: 'Contact', to: '/contact' },
];

const quoteForm = ref({ name: '', email: '', phone: '', message: '' });
const quoteSubmitting = ref(false);

async function submitQuote() {
  quoteSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', { type: 'quote', ...quoteForm.value });
    toast.success('Request submitted! We will contact you within 24 hours.');
    quoteForm.value = { name: '', email: '', phone: '', message: '' };
  } catch { toast.error('Failed to submit. Please try again.'); }
  finally { quoteSubmitting.value = false; }
}

async function fetchBundles() {
  loading.value = true;
  try {
    const { data } = await axios.get('/api/v1/bundles');
    bundles.value = data.data || data.bundles || [];
  } catch (error) {
    console.error('Error fetching bundles:', error);
  } finally {
    loading.value = false;
  }
}

onMounted(fetchBundles);
</script>
