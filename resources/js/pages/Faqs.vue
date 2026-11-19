<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="heroLaptopDark" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Frequently Asked Questions</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">Find answers to the most common questions about our services, products, and processes.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Still Have Questions?
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ SUPPORT CHANNELS ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Support Channels</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Multiple Ways to Get Help</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">We believe in making support accessible. Choose the channel that works best for you, and our team will respond promptly to ensure your questions are answered.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-card border border-border rounded-xl p-6 text-center hover:shadow-lg transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="📧" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Email Support</h3>
            <p class="text-muted-foreground text-xs leading-relaxed mb-3">Send us a detailed inquiry and receive a comprehensive response within 24 hours during business days.</p>
            <a href="mailto:reachout@omniviatech.co.ke" class="text-primary text-xs font-semibold hover:underline">reachout@omniviatech.co.ke</a>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 text-center hover:shadow-lg transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="📞" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Phone Support</h3>
            <p class="text-muted-foreground text-xs leading-relaxed mb-3">Speak directly with our team for urgent inquiries or to schedule a detailed project consultation call.</p>
            <a href="tel:+254710351517" class="text-primary text-xs font-semibold hover:underline">+254 710 351 517</a>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 text-center hover:shadow-lg transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="💬" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">WhatsApp</h3>
            <p class="text-muted-foreground text-xs leading-relaxed mb-3">Reach us instantly on WhatsApp for quick questions, project updates, or to schedule meetings with our team.</p>
            <a href="https://wa.me/254710351517" target="_blank" class="text-primary text-xs font-semibold hover:underline">Chat on WhatsApp</a>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 text-center hover:shadow-lg transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-4"><PageIcon icon="🏢" /></div>
            <h3 class="text-sm font-bold text-foreground mb-2">In-Person Visit</h3>
            <p class="text-muted-foreground text-xs leading-relaxed mb-3">Visit our office in Nairobi for face-to-face consultations, project reviews, or partnership discussions.</p>
            <span class="text-muted-foreground text-xs">Nairobi, Kenya</span>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ FAQ CATEGORIES ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ Categories</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Browse by Topic</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">Our FAQs cover a wide range of topics. Here are the most common categories clients ask about when working with OmniviaTech.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl mx-auto">
          <div class="bg-card border border-border rounded-xl p-5">
            <h3 class="text-sm font-bold text-foreground mb-2">Services & Solutions</h3>
            <ul class="text-muted-foreground text-xs space-y-1">
              <li>What services do you offer?</li>
              <li>Do you handle both web and mobile?</li>
              <li>Can you integrate with my existing tools?</li>
              <li>What technologies do you specialize in?</li>
            </ul>
          </div>
          <div class="bg-card border border-border rounded-xl p-5">
            <h3 class="text-sm font-bold text-foreground mb-2">Pricing & Payments</h3>
            <ul class="text-muted-foreground text-xs space-y-1">
              <li>How much does a project cost?</li>
              <li>What payment methods do you accept?</li>
              <li>Do you offer payment plans?</li>
              <li>Is there a free consultation?</li>
            </ul>
          </div>
          <div class="bg-card border border-border rounded-xl p-5">
            <h3 class="text-sm font-bold text-foreground mb-2">⏱️ Timeline & Delivery</h3>
            <ul class="text-muted-foreground text-xs space-y-1">
              <li>How long does development take?</li>
              <li>What is your development process?</li>
              <li>Do you provide progress updates?</li>
              <li>Can I see the product before launch?</li>
            </ul>
          </div>
          <div class="bg-card border border-border rounded-xl p-5">
            <h3 class="text-sm font-bold text-foreground mb-2">Security & Compliance</h3>
            <ul class="text-muted-foreground text-xs space-y-1">
              <li>How do you protect my data?</li>
              <li>Are you GDPR compliant?</li>
              <li>Do you perform security audits?</li>
              <li>What about data backups?</li>
            </ul>
          </div>
          <div class="bg-card border border-border rounded-xl p-5">
            <h3 class="text-sm font-bold text-foreground mb-2">Partnership & Support</h3>
            <ul class="text-muted-foreground text-xs space-y-1">
              <li>Do you offer ongoing maintenance?</li>
              <li>What is your support response time?</li>
              <li>Can we schedule regular check-ins?</li>
              <li>Do you work with international clients?</li>
            </ul>
          </div>
          <div class="bg-card border border-border rounded-xl p-5">
            <h3 class="text-sm font-bold text-foreground mb-2">Getting Started</h3>
            <ul class="text-muted-foreground text-xs space-y-1">
              <li>How do I start a project with you?</li>
              <li>What information do you need?</li>
              <li>Do you sign NDAs?</li>
              <li>Can I visit your office?</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ IMAGE LEFT + TEXT RIGHT ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="rounded-xl overflow-hidden">
            <img :src="heroTech6" alt="Support" class="w-full h-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">We're Here to Help</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Everything You Need to Know</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">We understand that choosing a technology partner is a big decision. That's why we've compiled answers to the most frequently asked questions about our services, process, and pricing.</p>
            <p class="text-muted-foreground text-sm leading-relaxed">Can't find what you're looking for? Don't hesitate to reach out — our team is always happy to help.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ FAQ ACCORDION ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6 max-w-3xl">
        <div class="text-center mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-2">Answers</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-3">Common Questions</h2>
        </div>

        <!-- Search FAQs -->
        <div class="relative mb-6">
          <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.35-4.35" /></svg>
          <input v-model="searchQuery" type="text" placeholder="Search FAQs..." class="w-full pl-11 pr-4 py-2.5 bg-card border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" />
        </div>

        <div class="space-y-2">
          <div v-for="(faq, i) in filteredFaqs" :key="i" class="bg-card border border-border rounded-lg overflow-hidden">
            <button @click="toggleFaq(i)" class="w-full flex items-center justify-between px-5 py-3 text-left hover:bg-muted/30 transition-colors">
              <span class="font-medium text-foreground text-sm pr-6">{{ faq.question }}</span>
              <svg :class="['w-4 h-4 text-muted-foreground shrink-0 transition-transform duration-200', openFaq === i && 'rotate-180']" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div v-show="openFaq === i" class="px-5 pb-4">
              <p class="text-muted-foreground text-sm leading-relaxed">{{ faq.answer }}</p>
            </div>
          </div>
        </div>

        <div v-if="filteredFaqs.length === 0" class="text-center py-8">
          <p class="text-muted-foreground text-sm">No matching questions found.</p>
        </div>
      </div>
    </section>

    <!-- ═══════════════ VALUE CARDS ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-10">
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-3">Why Businesses Chose Us</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="(val, i) in valueProps" :key="i" class="bg-card border border-border rounded-xl p-5 text-center hover:border-primary/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3"><span class="text-xl"><PageIcon :icon="val.icon" /></span></div>
            <h3 class="text-xs font-semibold text-foreground mb-1">{{ val.title }}</h3>
            <p class="text-muted-foreground text-[11px] leading-relaxed">{{ val.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ REQUEST A QUOTE ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-2">Get Started</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-2">Request a Quote</h2>
            <p class="text-muted-foreground text-sm mb-6">Ready to move forward? Tell us about your project.</p>
            <form @submit.prevent="submitQuote" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Email *" />
              </div>
              <textarea v-model="quoteForm.message" required rows="3" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm resize-none" placeholder="Tell us about your project..."></textarea>
              <button type="submit" :disabled="quoteSubmitting" class="w-full px-5 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all">{{ quoteSubmitting ? 'Submitting...' : 'Submit Request' }}</button>
            </form>
          </div>
          <div class="hidden lg:block">
            <div class="rounded-xl overflow-hidden"><img :src="heroTech2" alt="Get a Quote" class="w-full h-full object-cover aspect-[4/3]" /></div>
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
              <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight mb-4">Still Have Questions?</h2>
              <p class="text-white/70 text-sm leading-relaxed mb-8">Our team is ready to help. Reach out for personalized guidance on any of our services or products.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg">
                Contact Us
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
              <img :src="heroTech4" alt="Professional" class="h-full max-h-[350px] object-cover object-top" />
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
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary/20 transition"><span class="text-xl"><PageIcon :icon="area.icon" /></span></div>
            <h3 class="text-xs font-semibold text-foreground group-hover:text-primary transition-colors">{{ area.label }}</h3>
          </router-link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import axios from 'axios';
import { ref, computed } from 'vue';
import heroLaptopDark from '@/../img/tech-background.webp';
import heroTechGlow from '@/../img/tech-glow.webp';
import heroTech2 from '@/../img/tech2.webp';
import heroTech4 from '@/../img/tech4.webp';
import heroTech6 from '@/../img/tech6.webp';
import PageIcon from '@/components/PageIcon.vue';
import { useToast } from '@/composables/useToast';
import PublicLayout from '@/layouts/PublicLayout.vue';

const toast = useToast();
const openFaq = ref<number | null>(0);
const searchQuery = ref('');

function toggleFaq(i: number) {
  openFaq.value = openFaq.value === i ? null : i;
}

const faqs = [
  { question: 'What services do you offer?', answer: 'We offer web development, mobile app development, automation & AI, SaaS development, e-commerce solutions, and deployment & hosting services.' },
  { question: 'How can I get started?', answer: 'Simply contact us through our contact form or give us a call. We\'ll schedule a free consultation to discuss your needs and provide a detailed proposal.' },
  { question: 'What technologies do you use?', answer: 'We work with Laravel, Vue.js, React, React Native, Flutter, Node.js, Python, PostgreSQL, Docker, Kubernetes, AWS, and many more modern technologies.' },
  { question: 'How long does a typical project take?', answer: 'Project timelines vary based on complexity. A simple website might take 2-4 weeks, while a full SaaS platform could take 3-6 months. We provide detailed timelines during planning.' },
  { question: 'Do you offer ongoing support?', answer: 'Yes! We offer 24/7 monitoring, maintenance packages, and priority support plans. We believe in long-term partnerships with our clients.' },
  { question: 'What is your pricing model?', answer: 'We offer both fixed-price projects and time-and-materials engagements. We\'ll recommend the best model based on your project requirements.' },
  { question: 'Do you work with startups?', answer: 'Absolutely! We love working with startups and can help you build your MVP, scale your product, and optimize for growth.' },
  { question: 'Can you help with existing projects?', answer: 'Yes, we can take over maintenance, add features, fix bugs, or completely refactor existing codebases. We conduct thorough code reviews before starting.' },
];

const filteredFaqs = computed(() => {
  if (!searchQuery.value) return faqs;
  const q = searchQuery.value.toLowerCase();
  return faqs.filter(f => f.question.toLowerCase().includes(q) || f.answer.toLowerCase().includes(q));
});

const valueProps = [
  { icon: '⚡', title: 'Fast Delivery', desc: 'Agile processes for quick turnaround' },
  { icon: '🎯', title: 'Expert Team', desc: 'Experienced technology professionals' },
  { icon: '🔒', title: 'Secure & Reliable', desc: 'Enterprise-grade security standards' },
  { icon: '🌍', title: '24/7 Support', desc: 'Round the clock assistance' },
];

const otherAreas = [
  { icon: '⚡', label: 'Services', to: '/services' },
  { icon: '📦', label: 'Products', to: '/products' },
  { icon: '💼', label: 'Bundles', to: '/bundles' },
  { icon: '📞', label: 'Contact', to: '/contact' },
];

const quoteForm = ref({ name: '', email: '', message: '' });
const quoteSubmitting = ref(false);

async function submitQuote() {
  quoteSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', { type: 'contact', ...quoteForm.value });
    toast.success('Request submitted! We will contact you soon.');
    quoteForm.value = { name: '', email: '', message: '' };
  } catch { toast.error('Failed to submit. Please try again.'); }
  finally { quoteSubmitting.value = false; }
}
</script>
