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
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Contact Us</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Get In Touch</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">Have a project in mind? Let's discuss how we can help your business grow with technology.</p>
          <a href="tel:+254710351517" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Call Us Now
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
          </a>
        </div>
      </div>
    </section>

    <!-- ═══════════════ HOW WE CAN HELP ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">How We Can Help</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Common Reasons Clients Contact Us</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">Whether you are looking to build a new software product, migrate to the cloud, strengthen your cybersecurity, or explore AI-driven automation, our team is ready to help. Here are some of the most common inquiries we receive.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">💻</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Custom Software Development</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Need a tailored web or mobile application? We build scalable, secure software solutions designed specifically for your business requirements and user needs.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">☁️</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Cloud Migration & Infrastructure</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Move your operations to the cloud with confidence. We plan, execute, and manage cloud migrations on AWS, Azure, and Google Cloud with zero downtime.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">🤖</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">AI & Automation Solutions</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Automate repetitive tasks, gain predictive insights, and enhance decision-making with our AI and machine learning services tailored to your industry.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">🔒</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Cybersecurity Assessment</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Protect your business from cyber threats with comprehensive security audits, vulnerability assessments, and implementation of robust defense strategies.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">📱</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Mobile App Development</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">From concept to launch, we design and develop native and cross-platform mobile applications for iOS and Android that users love.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-6 hover:shadow-lg transition-all">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4"><span class="text-2xl">📈</span></div>
            <h3 class="text-sm font-bold text-foreground mb-2">Digital Marketing & SEO</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">Boost your online presence with data-driven digital marketing strategies including SEO, content marketing, social media management, and paid advertising.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ IMAGE LEFT + TEXT RIGHT ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="rounded-xl overflow-hidden">
            <img :src="s.office_image || heroTech6" alt="Our Office" class="w-full h-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">We're Here to Help</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Let's Start a Conversation</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-6">Whether you need a quick consultation or a full project partnership, our team is ready to help you navigate the digital landscape.</p>

            <div class="space-y-3">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 shrink-0 bg-primary/10 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <div>
                  <div class="text-xs font-semibold text-foreground">Email</div>
                  <a href="mailto:info@omniviatech.com" class="text-muted-foreground text-sm hover:text-primary transition">info@omniviatech.com</a>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 shrink-0 bg-accent/10 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                </div>
                <div>
                  <div class="text-xs font-semibold text-foreground">Phone</div>
                  <a href="tel:+254710351517" class="text-muted-foreground text-sm hover:text-primary transition">+254 710 351 517</a>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 shrink-0 bg-green-500/10 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <div>
                  <div class="text-xs font-semibold text-foreground">Office</div>
                  <span class="text-muted-foreground text-sm">Nairobi, Kenya</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ VALUE CARDS ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-10">
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Why Work With Us</h2>
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

    <!-- ═══════════════ CONTACT FORM + MAP ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-10">
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-2">Send a Message</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-6">Contact Form</h2>
            <form @submit.prevent="submitContact" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <input v-model="form.name" type="text" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Your Name *" />
                <input v-model="form.email" type="email" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Email *" />
              </div>
              <div class="grid grid-cols-2 gap-3">
                <input v-model="form.phone" type="tel" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Phone" />
                <input v-model="form.subject" type="text" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Subject" />
              </div>
              <textarea v-model="form.message" required rows="4" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm resize-none" placeholder="Tell us about your project..."></textarea>
              <button type="submit" :disabled="submitting" class="w-full px-5 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all">{{ submitting ? 'Sending...' : 'Send Message' }}</button>
            </form>
          </div>

          <div class="space-y-4">
            <div class="aspect-video bg-muted rounded-xl overflow-hidden border border-border">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8!2d36.82!3d-1.28!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0!2sNairobi!5e0!3m2!1sen!2ske!4v1234567890"
                width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
            <div class="bg-card border border-border rounded-xl p-5">
              <h3 class="font-semibold text-foreground text-sm mb-2">Office Hours</h3>
              <div class="space-y-1 text-muted-foreground text-xs">
                <p>Monday - Friday: 8:00 AM - 6:00 PM</p>
                <p>Saturday: 9:00 AM - 1:00 PM</p>
                <p>Sunday: Closed</p>
              </div>
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
              <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Ready to Start Your Project?</h2>
              <p class="text-white/70 text-sm leading-relaxed mb-8">Book a free 30-minute consultation with one of our technology experts today.</p>
              <a href="https://wa.me/254710351517" target="_blank" class="inline-flex items-center gap-2 px-7 py-3 bg-green-600 text-white text-sm font-semibold rounded-full hover:bg-green-700 transition-all shadow-lg">
                WhatsApp Us
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" /></svg>
              </a>
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
import { ref, computed } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';
import { useToast } from '@/composables';
import { useCmsStore } from '@/stores/cms';
import heroLaptopDark from '@/../img/tech-background.png';
import heroTech6 from '@/../img/tech6.jpg';
import heroTech4 from '@/../img/tech4.jpg';
import heroTechGlow from '@/../img/tech-glow.webp';

const cmsStore = useCmsStore();
const s = computed(() => cmsStore.homeData?.settings || {} as any);
const toast = useToast();
const submitting = ref(false);
const form = ref({ name: '', email: '', phone: '', subject: '', message: '' });

const valueProps = [
  { icon: '⚡', title: 'Fast Response', desc: 'We respond within 24 hours' },
  { icon: '🎯', title: 'Expert Team', desc: 'Skilled technology professionals' },
  { icon: '💡', title: 'Free Consultation', desc: '30-minute discovery call' },
  { icon: '🌍', title: 'Africa-wide', desc: 'Serving clients across Africa' },
];

const otherAreas = [
  { icon: '⚡', label: 'Services', to: '/services' },
  { icon: '📦', label: 'Products', to: '/products' },
  { icon: '💼', label: 'Bundles', to: '/bundles' },
  { icon: '📝', label: 'Blog', to: '/blog' },
];

async function submitContact() {
  submitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', { type: 'contact', ...form.value });
    toast.success('Message sent successfully! We will get back to you soon.');
    form.value = { name: '', email: '', phone: '', subject: '', message: '' };
  } catch {
    toast.error('Failed to send message. Please try again.');
  } finally {
    submitting.value = false;
  }
}
</script>
