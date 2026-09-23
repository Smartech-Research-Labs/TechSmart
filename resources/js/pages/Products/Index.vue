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
          <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Our Products</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Cutting-Edge Solutions</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">Ready-to-deploy products designed to power your business from day one.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Request a Demo
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ KEY FEATURES ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Key Features</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">What Makes Our Products Stand Out</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">Every product in our catalog is built with modern technology stacks, following industry best practices for performance, security, and scalability. Here is what you can expect from any OmniviaTech product.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">⚡</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Lightning-Fast Performance</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Optimized for speed with efficient code, CDN delivery, and caching strategies that ensure sub-second load times across all devices and network conditions.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">🔐</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Enterprise-Grade Security</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Multi-layered security with encryption at rest and in transit, role-based access control, two-factor authentication, and regular security audits and penetration testing.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">📱</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Responsive & Mobile-First</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Every product is designed mobile-first, ensuring seamless experiences across desktop, tablet, and mobile devices with adaptive layouts and touch-friendly interfaces.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">🔄</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Seamless Integrations</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">RESTful APIs, webhooks, and pre-built connectors for popular platforms like Salesforce, Stripe, Slack, and more, enabling effortless integration with your existing tools.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">📊</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Advanced Analytics</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Built-in dashboards, real-time reporting, and customizable metrics give you deep insights into user behavior, system performance, and business outcomes.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">🌍</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Multi-Region Deployment</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Deploy across multiple regions for low-latency access worldwide. Our products support multi-language, multi-currency, and localized content out of the box.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ IMAGE LEFT + TEXT RIGHT ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="rounded-xl overflow-hidden">
            <img :src="s.products_page_image || heroOrbit" alt="Our Products" class="w-full h-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Why Our Products</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Built for Performance & Scale</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">Our products are engineered with modern technology stacks, designed for reliability, and optimized for the African market. Every solution undergoes rigorous testing to ensure it meets enterprise-grade standards.</p>
            <p class="text-muted-foreground text-sm leading-relaxed">Whether you need a ready-made SaaS platform or a customizable toolkit, our products give you the head start you need.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ VALUE CARDS ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-2">Value Proposition</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-3">Why Choose Our Products</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="(val, i) in valueProps" :key="i" class="bg-card border border-border rounded-xl p-5 text-center hover:border-primary/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3"><span class="text-xl">{{ val.icon }}</span></div>
            <h3 class="text-xs font-semibold text-foreground mb-1">{{ val.title }}</h3>
            <p class="text-muted-foreground text-[11px] leading-relaxed">{{ val.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ PRODUCTS GRID (4 per row) ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="mb-8">
          <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-2">Browse Products</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight">Our Product Catalog</h2>
        </div>

        <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="i in 8" :key="i" class="bg-card border border-border rounded-xl overflow-hidden animate-pulse">
            <div class="aspect-[4/3] bg-muted"></div>
            <div class="p-4 space-y-2"><div class="h-3 bg-muted rounded w-3/4"></div><div class="h-2 bg-muted rounded w-full"></div></div>
          </div>
        </div>

        <div v-else-if="products.length === 0" class="text-center py-16">
          <h3 class="text-lg font-bold text-foreground mb-1">No products available</h3>
          <p class="text-muted-foreground text-sm">Check back soon for new releases.</p>
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <router-link v-for="product in products" :key="product.id" :to="`/products/${product.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:border-accent/30 hover:shadow-lg transition-all">
            <div class="aspect-[4/3] bg-muted overflow-hidden relative">
              <img v-if="getProductImage(product)" :src="getProductImage(product)" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <img v-else-if="product.image_url" :src="product.image_url" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <div v-else class="w-full h-full flex items-center justify-center">
                <svg class="w-8 h-8 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
              </div>
              <div class="absolute top-2 right-2 z-10" @click.prevent>
                <WishlistButton type="App\\Models\\Product" :item-id="product.id" />
              </div>
            </div>
            <div class="p-4">
              <h3 class="text-xs font-semibold text-foreground mb-1 group-hover:text-accent transition-colors line-clamp-2">{{ product.name }}</h3>
              <p class="text-muted-foreground text-[11px] leading-relaxed line-clamp-2 mb-2">{{ product.excerpt || product.short_description }}</p>
              <div class="flex items-center justify-between">
                <span class="text-primary font-medium text-[11px] flex items-center gap-1">View <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" /></svg></span>
              </div>
            </div>
          </router-link>
        </div>

        <!-- Pagination -->
        <PaginationControls :meta="paginationMeta" @page-change="onPageChange" />
      </div>
    </section>

    <!-- ═══════════════ REQUEST A QUOTE ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-2">Get Started</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-2">Request a Quote</h2>
            <p class="text-muted-foreground text-sm mb-6">Interested in our products? Let us know your requirements.</p>
            <form @submit.prevent="submitQuote" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Email *" />
              </div>
              <input v-model="quoteForm.phone" type="tel" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Phone *" />
              <textarea v-model="quoteForm.message" required rows="3" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm resize-none" placeholder="Which products are you interested in?"></textarea>
              <button type="submit" :disabled="quoteSubmitting" class="w-full px-5 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all">{{ quoteSubmitting ? 'Submitting...' : 'Submit Request' }}</button>
            </form>
          </div>
          <div class="hidden lg:block">
            <div class="rounded-xl overflow-hidden"><img :src="s.quote_section_image || heroTech2" alt="Get a Quote" class="w-full h-full object-cover aspect-[4/3]" /></div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CTA (MAROON) ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="relative bg-black rounded-2xl overflow-hidden">
          <div class="absolute inset-0 opacity-30 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
          <div class="absolute inset-0 bg-black/70"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-8 md:p-12 lg:p-14">
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight mb-4">Need Something Custom?</h2>
              <p class="text-white/70 text-sm leading-relaxed mb-8">We build tailored products to match your exact business requirements.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg">
                Contact Us
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
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-8">
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-3">Other Areas You Might Be Interested In</h2>
          <p class="text-muted-foreground text-sm">Explore more of what OmniviaTech has to offer.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
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
import axios from 'axios';
import { ref, computed, onMounted } from 'vue';
import heroOrbit from '@/../img/Orbit.webp';
import heroLaptopDark from '@/../img/tech-background.webp';
import heroTechGlow from '@/../img/tech-glow.webp';
import heroTech2 from '@/../img/tech2.webp';
import heroTech4 from '@/../img/tech4.webp';
import PaginationControls from '@/components/ui/pagination/PaginationControls.vue';
import WishlistButton from '@/components/WishlistButton.vue';
import { useToast } from '@/composables';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useCmsStore } from '@/stores/cms';
import svcCustomWeb from '@/../img/services/Custom Web Development.webp';
import svcEcommerce from '@/../img/services/E-commerece Development.webp';
import svcApi from '@/../img/services/API Development.webp';
import svcCrmErp from '@/../img/services/CRM & ERP Development.webp';
import svcMobileApp from '@/../img/services/Mobile App Development.webp';
import svcSeo from '@/../img/services/SEO Optimization.webp';

const productImageMap: Record<string, string> = {
  'smartcms-pro': svcCustomWeb,
  'smartshop-platform': svcEcommerce,
  'smartanalytics-dashboard': svcSeo,
  'smartchat-ai': svcApi,
  'smartsecure-firewall': svcCrmErp,
  'smartbackup-cloud': svcMobileApp,
};

function getProductImage(product: any): string | undefined {
  const slug = (product.slug || '').toLowerCase().trim();
  if (productImageMap[slug]) return productImageMap[slug];
  return undefined;
}

const cmsStore = useCmsStore();
const s = computed(() => cmsStore.homeData?.settings || {} as any);
const toast = useToast();
const products = ref<any[]>([]);
const loading = ref(true);
const paginationMeta = ref({ current_page: 1, last_page: 1, per_page: 12, total: 0, from: null as number | null, to: null as number | null });

const valueProps = [
  { icon: '🚀', title: 'Ready to Deploy', desc: 'Launch in days, not months' },
  { icon: '🔧', title: 'Fully Customizable', desc: 'Adapt to your workflow' },
  { icon: '🔒', title: 'Enterprise Security', desc: 'Built-in security features' },
  { icon: '📊', title: 'Analytics Built-in', desc: 'Data insights out of the box' },
];

const otherAreas = [
  { icon: '⚡', label: 'Services', to: '/services' },
  { icon: '💼', label: 'Bundles', to: '/bundles' },
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

async function fetchProducts(page = 1) {
  loading.value = true;
  try {
    const { data } = await axios.get('/api/v1/products', { params: { page } });
    products.value = data.data || [];
    paginationMeta.value = {
      current_page: data.current_page ?? 1,
      last_page: data.last_page ?? 1,
      per_page: data.per_page ?? 12,
      total: data.total ?? 0,
      from: data.from ?? null,
      to: data.to ?? null,
    };
  } catch (error) {
    console.error('Error fetching products:', error);
  } finally {
    loading.value = false;
  }
}

function onPageChange(page: number) {
  fetchProducts(page);
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

onMounted(fetchProducts);
</script>
