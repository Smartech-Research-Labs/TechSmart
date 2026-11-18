<template>
  <PublicLayout>
    <!-- ═══════════════ HERO SECTION ═══════════════ -->
    <section v-if="specialization" class="relative min-h-[60vh] md:min-h-[70vh] flex items-center overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="specialization.hero_image || getDefaultHeroImage()" :alt="specialization.title" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/60"></div>
      </div>

      <!-- Content -->
      <div class="relative z-10 w-full">
        <div class="container mx-auto px-6 py-12 md:py-16">
          <div class="max-w-2xl">
            <p class="text-primary font-semibold text-xs tracking-widest uppercase mb-3">Our Specialization</p>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight text-white mb-6">{{ specialization.title }}</h1>
            <p class="text-white/90 text-base leading-relaxed mb-8 max-w-lg">{{ specialization.tagline }}</p>
            <div class="flex flex-wrap gap-4">
              <router-link to="/contact" class="inline-flex items-center gap-2 px-8 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                Get Started
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
              <router-link to="#learn-more" class="px-8 py-3 border-2 border-white text-white text-sm font-semibold rounded-full hover:bg-white/10 transition-all">Learn More</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ ABOUT THIS SPECIALIZATION ═══════════════ -->
    <section v-if="specialization" class="py-12 md:py-16">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
          <!-- Left - Image -->
          <div class="relative">
            <div class="rounded-2xl overflow-hidden shadow-lg">
              <img :src="specialization.description_image || heroLaptop" :alt="specialization.title" class="w-full aspect-[4/3] object-cover" />
            </div>
          </div>

          <!-- Right - Content -->
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About This Area</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">{{ specialization.title }}</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">{{ specialization.full_description }}</p>
            <p class="text-muted-foreground text-sm leading-relaxed mb-8">{{ specialization.extended_description }}</p>

            <div class="grid grid-cols-2 gap-4 mb-8">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="text-sm font-medium text-foreground">Proven Expertise</div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="text-sm font-medium text-foreground">Industry Best</div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="text-sm font-medium text-foreground">24/7 Support</div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                  <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="text-sm font-medium text-foreground">Fast Delivery</div>
              </div>
            </div>

            <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all">
              Schedule Consultation
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ WHY CHOOSE US FOR THIS AREA ═══════════════ -->
    <section v-if="whyChooseContent.length" class="py-12 md:py-16 bg-gray-900">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Choose Us</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight">Why Choose OmniviaTech for {{ specialization?.title }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="(reason, i) in whyChooseContent" :key="i" class="relative group">
            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1 z-20">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </div>
            <div class="relative rounded-2xl p-7 transition-all duration-300 overflow-hidden h-full shadow-lg hover:shadow-2xl transform group-hover:-translate-y-2 bg-gray-900 border border-white/10 hover:border-accent">
              <div class="absolute inset-0 opacity-0 group-hover:opacity-20 bg-gradient-to-br from-primary/20 to-primary/10 transition-opacity duration-500"></div>
              <div class="absolute -top-6 -right-6 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-150 group-hover:bg-primary/10 transition-all duration-500"></div>
              <div class="relative z-10">
                <div class="w-14 h-14 bg-gradient-to-br from-primary/30 to-primary/20 rounded-xl flex items-center justify-center mb-5 group-hover:from-primary/50 group-hover:to-primary/30 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <PageIcon :icon="reason.icon" />
                </div>
                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary transition-colors">{{ reason.title }}</h3>
                <p class="text-white/80 text-sm leading-relaxed group-hover:text-white/90 transition-colors">{{ reason.desc }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ WHAT WE OFFER ═══════════════ -->
    <section v-if="servicesForSpec.length" class="py-12 md:py-16">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Services</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight">What We Offer in {{ specialization?.title }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <router-link v-for="service in servicesForSpec" :key="service.id" :to="`/services/${service.slug}`" class="group block bg-card border border-border rounded-2xl p-6 hover:border-primary/20 hover:shadow-sm hover:-translate-y-1 transition-all duration-300">
            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-all">
              <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-foreground mb-2 group-hover:text-primary transition-colors">{{ service.title }}</h3>
            <p class="text-muted-foreground text-sm leading-relaxed">{{ service.description || 'Professional ' + service.title + ' solutions tailored to your needs.' }}</p>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ OUR WORKFLOW ═══════════════ -->
    <section v-if="workflowSteps.length" class="py-12 md:py-16 bg-muted/20">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Process</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight">How We Work</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div v-for="(step, i) in workflowSteps" :key="i" class="relative text-center">
            <div class="flex items-center justify-center mb-4">
              <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center font-bold text-lg">{{ i + 1 }}</div>
              <svg v-if="i < workflowSteps.length - 1" class="w-8 h-1 text-primary/20 absolute left-[60%]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </div>
            <h3 class="font-bold text-foreground mb-2">{{ step.title }}</h3>
            <p class="text-muted-foreground text-sm">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ TESTIMONIALS ═══════════════ -->
    <section v-if="testimonials.length" class="py-12 md:py-16">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Success Stories</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight">What Our Clients Say</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="testimonial in testimonials" :key="testimonial.id" class="bg-card border border-border rounded-2xl p-6 hover:shadow-lg transition-all">
            <div class="flex items-center mb-4">
              <div v-for="n in 5" :key="n" class="text-amber-400">★</div>
            </div>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">{{ testimonial.comment }}</p>
            <div class="border-t border-border pt-4">
              <div class="font-bold text-foreground text-sm">{{ testimonial.user_name }}</div>
              <div class="text-primary text-xs">{{ testimonial.company }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ REQUEST A QUOTE ═══════════════ -->
    <section class="py-12 md:py-16 bg-gray-900">
      <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-2xl mx-auto mb-10">
          <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-3">Get Started</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight mb-3">Request a Quote</h2>
          <p class="text-white/75 text-sm leading-relaxed">Tell us about your {{ specialization?.title }} project and we'll get back to you within 24 hours.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-14 items-center">
          <!-- Left - Form -->
          <div>
            <form @submit.prevent="submitQuoteRequest" class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <input v-model="quoteForm.name" type="text" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white" placeholder="Email *" />
              </div>
              <div class="grid grid-cols-2 gap-4">
                <input v-model="quoteForm.phone" type="tel" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all placeholder-white" placeholder="Phone *" />
                <select v-model="quoteForm.service" required class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all">
                  <option value="">Service Needed *</option>
                  <option v-for="service in servicesForSpec" :key="service.id" :value="service.title">{{ service.title }}</option>
                </select>
              </div>
              <textarea v-model="quoteForm.description" required rows="4" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm resize-none transition-all placeholder-white" placeholder="Project description..."></textarea>
              <div class="grid grid-cols-2 gap-4">
                <select v-model="quoteForm.budget" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all">
                  <option value="">Budget Range</option>
                  <option value="Under Ksh 10,000">Under Ksh 10,000</option>
                  <option value="Ksh 10,000 - Ksh 50,000">Ksh 10,000 - Ksh 50,000</option>
                  <option value="Ksh 50,000 - Ksh 200,000">Ksh 50,000 - Ksh 200,000</option>
                  <option value="Over Ksh 200,000">Over Ksh 200,000</option>
                </select>
                <select v-model="quoteForm.timeline" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 text-white text-sm transition-all">
                  <option value="">Timeline</option>
                  <option value="ASAP">ASAP</option>
                  <option value="1-2 months">1-2 months</option>
                  <option value="3-6 months">3-6 months</option>
                  <option value="6+ months">6+ months</option>
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
              <img :src="specialization?.quote_image || heroTech" :alt="specialization?.title" class="w-full h-full object-cover aspect-[4/3]" />
            </div>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import PageIcon from '@/components/PageIcon.vue';
import axios from 'axios';
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import heroLaptop from '@/../img/Laptop.webp';
import heroLaptopDark from '@/../img/tech-background.webp';
import heroTech from '@/../img/tech.webp';
import { useToast } from '@/composables';
import PublicLayout from '@/layouts/PublicLayout.vue';

const toast = useToast();

const route = useRoute();
const specialization = ref<any>(null);
const allServices = ref<any[]>([]);
const allTestimonials = ref<any[]>([]);
const loading = ref(true);

const quoteForm = ref({ name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' });
const quoteFormSubmitting = ref(false);

const workflowSteps = [
  { title: 'Discovery', description: 'We understand your business goals and requirements' },
  { title: 'Strategy', description: 'We create a detailed plan tailored to your needs' },
  { title: 'Development', description: 'Our team builds your solution with cutting-edge technology' },
  { title: 'Launch', description: 'We deploy and support your solution for success' },
];

const whyChooseReasons = [
  { icon: '⚡', title: 'Lightning Fast Delivery', desc: 'Quick turnaround without compromising quality.' },
  { icon: '🎯', title: 'Results-Driven', desc: 'Focused on measurable outcomes and ROI.' },
  { icon: '🤝', title: 'True Partnership', desc: 'We become an extension of your team.' },
  { icon: '💡', title: 'Innovation First', desc: 'Stay ahead with cutting-edge solutions.' },
  { icon: '🛡️', title: 'Security & Reliability', desc: 'Enterprise-grade security and 99.9% uptime.' },
  { icon: '💰', title: 'Cost-Effective', desc: 'Maximum value for your investment.' },
];

const servicesForSpec = computed(() => {
  const specTitle = specialization.value?.title?.toLowerCase() || '';
  return allServices.value.filter(s => 
    s.title?.toLowerCase().includes(specTitle) ||
    s.category?.toLowerCase().includes(specTitle)
  ).slice(0, 6) || allServices.value.slice(0, 6);
});

const whyChooseContent = computed(() => {
  return whyChooseReasons;
});

const testimonials = computed(() => {
  return allTestimonials.value.slice(0, 3);
});

const getDefaultHeroImage = () => {
  const images = [
    heroLaptopDark,
    heroTech,
    heroLaptop,
  ];
  return images[Math.floor(Math.random() * images.length)];
};

async function fetchSpecialization() {
  try {
    const specSlug = route.params.slug as string;
    
    // Try to fetch from API, or use mock data
    const { data } = await axios.get(`/api/v1/specializations/${specSlug}`).catch(() => ({
      data: { data: null }
    }));
    
    specialization.value = data?.data || {
      title: decodeURIComponent(specSlug).replaceAll('-', ' '),
      tagline: 'Industry-leading solutions tailored to your needs',
      full_description: 'Our specialized team brings years of expertise in this field.',
      extended_description: 'We deliver cutting-edge solutions that drive real business results.',
    };

    // Fetch services and testimonials
    const [servicesRes, testimonialsRes] = await Promise.all([
      axios.get('/api/v1/services').catch(() => ({ data: { data: [] } })),
      axios.get('/api/v1/reviews', { params: { limit: 6 } }).catch(() => ({ data: { data: [] } })),
    ]);

    allServices.value = servicesRes.data?.data || [];
    allTestimonials.value = testimonialsRes.data?.data || [];
  } catch (error) {
    console.error('Error fetching specialization:', error);
  } finally {
    loading.value = false;
  }
}

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

    quoteForm.value = { name: '', email: '', phone: '', service: '', description: '', budget: '', timeline: '' };
    toast.success('Quote request submitted! We will contact you within 24 hours.');
  } catch (error) {
    console.error('Error submitting quote:', error);
    toast.error('Failed to submit quote request. Please try again.');
  } finally {
    quoteFormSubmitting.value = false;
  }
}

onMounted(() => {
  fetchSpecialization();
});
</script>

<style scoped>
.specialization-page {
  width: 100%;
}
</style>
