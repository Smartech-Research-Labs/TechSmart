<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="heroTechBg" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About Us</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Building the Future of Technology</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">We are a team of passionate technologists dedicated to delivering cutting-edge solutions that empower businesses to thrive in the digital age.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Work With Us
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ OUR JOURNEY ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Journey</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">A Decade of Innovation & Growth</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">From a small startup to a leading technology provider, our journey reflects our commitment to delivering exceptional value to clients and communities across Africa and beyond.</p>
        </div>
        <div class="max-w-3xl mx-auto">
          <div class="relative border-l-2 border-primary/30 pl-8 space-y-10">
            <div>
              <div class="absolute -left-2.5 w-5 h-5 bg-primary rounded-full border-4 border-background"></div>
              <h3 class="text-sm font-bold text-foreground mb-1">2014 — The Beginning</h3>
              <p class="text-muted-foreground text-xs leading-relaxed">OmniviaTech was founded with a small but passionate team of developers determined to bridge the technology gap in emerging markets.</p>
            </div>
            <div>
              <div class="absolute -left-2.5 w-5 h-5 bg-primary rounded-full border-4 border-background"></div>
              <h3 class="text-sm font-bold text-foreground mb-1">2016 — First Major Milestone</h3>
              <p class="text-muted-foreground text-xs leading-relaxed">Delivered our 50th project, expanding into cloud infrastructure and enterprise software solutions for mid-size businesses across East Africa.</p>
            </div>
            <div>
              <div class="absolute -left-2.5 w-5 h-5 bg-primary rounded-full border-4 border-background"></div>
              <h3 class="text-sm font-bold text-foreground mb-1">2018 — Regional Expansion</h3>
              <p class="text-muted-foreground text-xs leading-relaxed">Opened offices in multiple African countries, bringing our team to 30+ professionals and serving clients across West, East, and Southern Africa.</p>
            </div>
            <div>
              <div class="absolute -left-2.5 w-5 h-5 bg-primary rounded-full border-4 border-background"></div>
              <h3 class="text-sm font-bold text-foreground mb-1">2020 — Digital Acceleration</h3>
              <p class="text-muted-foreground text-xs leading-relaxed">Launched our suite of AI and automation products, helping businesses adapt to the rapidly changing digital landscape during the global shift to remote operations.</p>
            </div>
            <div>
              <div class="absolute -left-2.5 w-5 h-5 bg-primary rounded-full border-4 border-background"></div>
              <h3 class="text-sm font-bold text-foreground mb-1">2023 — Global Reach</h3>
              <p class="text-muted-foreground text-xs leading-relaxed">Surpassed 500 projects delivered with a team of 50+ experts, serving clients in 15+ countries and expanding our product portfolio to meet global demand.</p>
            </div>
            <div>
              <div class="absolute -left-2.5 w-5 h-5 bg-primary rounded-full border-4 border-background"></div>
              <h3 class="text-sm font-bold text-foreground mb-1">Today & Beyond</h3>
              <p class="text-muted-foreground text-xs leading-relaxed">Continuing to innovate in AI, cloud computing, and cybersecurity, with a growing focus on sustainability and inclusive technology access for underserved communities.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ WHAT SETS US APART ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">What Sets Us Apart</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">The OmniviaTech Advantage</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">In a crowded technology landscape, our clients choose us for the unique combination of expertise, local understanding, and global standards that we bring to every engagement.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
          <div class="bg-card border border-border rounded-xl p-6">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0"><span class="text-2xl">🌍</span></div>
              <div>
                <h3 class="text-sm font-bold text-foreground mb-2">Deep Local Expertise, Global Standards</h3>
                <p class="text-muted-foreground text-xs leading-relaxed">We understand the unique challenges of operating in African markets while delivering solutions that meet international quality and security benchmarks.</p>
              </div>
            </div>
          </div>
          <div class="bg-card border border-border rounded-xl p-6">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0"><span class="text-2xl">🎓</span></div>
              <div>
                <h3 class="text-sm font-bold text-foreground mb-2">Continuous Learning Culture</h3>
                <p class="text-muted-foreground text-xs leading-relaxed">Our team invests hundreds of hours annually in certifications, conferences, and research to stay at the forefront of technology innovation.</p>
              </div>
            </div>
          </div>
          <div class="bg-card border border-border rounded-xl p-6">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0"><span class="text-2xl">💼</span></div>
              <div>
                <h3 class="text-sm font-bold text-foreground mb-2">Business-First Approach</h3>
                <p class="text-muted-foreground text-xs leading-relaxed">We do not just build technology; we solve business problems. Every solution is designed with measurable ROI and strategic business outcomes in mind.</p>
              </div>
            </div>
          </div>
          <div class="bg-card border border-border rounded-xl p-6">
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0"><span class="text-2xl">🤝</span></div>
              <div>
                <h3 class="text-sm font-bold text-foreground mb-2">Long-Term Partnerships</h3>
                <p class="text-muted-foreground text-xs leading-relaxed">Over 80% of our clients return for additional projects, reflecting the trust and value we build through transparent communication and consistent delivery.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ IMAGE LEFT + TEXT RIGHT ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="rounded-xl overflow-hidden">
            <img :src="heroLaptop" alt="OmniviaTech Team" class="w-full h-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Story</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Technology That Transforms</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">Founded with a vision to make world-class technology accessible to businesses across Africa, OmniviaTech has grown into a trusted partner for organizations of all sizes.</p>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">We combine deep technical expertise with genuine understanding of African business landscapes to deliver solutions that work in the real world.</p>
            <div class="grid grid-cols-3 gap-4 pt-4">
              <div class="text-center">
                <div class="text-xl font-bold text-primary">10+</div>
                <div class="text-muted-foreground text-[11px]">Years Experience</div>
              </div>
              <div class="text-center">
                <div class="text-xl font-bold text-primary">500+</div>
                <div class="text-muted-foreground text-[11px]">Projects Completed</div>
              </div>
              <div class="text-center">
                <div class="text-xl font-bold text-primary">200+</div>
                <div class="text-muted-foreground text-[11px]">Happy Clients</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ MISSION & VISION CARDS ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-5">
          <div class="bg-card border border-border rounded-xl p-8">
            <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <h2 class="text-lg font-bold text-foreground mb-3">Our Mission</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">To empower businesses with innovative, reliable, and scalable technology solutions that drive growth, efficiency, and digital transformation across Africa and beyond.</p>
          </div>
          <div class="bg-card border border-border rounded-xl p-8">
            <div class="w-10 h-10 bg-accent/10 rounded-xl flex items-center justify-center mb-4">
              <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </div>
            <h2 class="text-lg font-bold text-foreground mb-3">Our Vision</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">To be the leading tech solutions provider in Africa, recognized for our innovation, quality, and commitment to client success in every project we deliver.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CORE VALUES (4 per row) ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-2">What We Believe</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Our Core Values</h2>
          <p class="text-muted-foreground text-sm">The principles that guide everything we do.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="(val, i) in values" :key="i" class="bg-card border border-border rounded-xl p-5 text-center hover:border-primary/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3"><span class="text-xl">{{ val.emoji }}</span></div>
            <h3 class="text-xs font-semibold text-foreground mb-1">{{ val.title }}</h3>
            <p class="text-muted-foreground text-[11px] leading-relaxed">{{ val.description }}</p>
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
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-2">Start Your Project</h2>
            <p class="text-muted-foreground text-sm mb-6">Tell us what you're looking for and let's build something great together.</p>
            <form @submit.prevent="submitQuote" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Email *" />
              </div>
              <input v-model="quoteForm.phone" type="tel" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Phone" />
              <textarea v-model="quoteForm.message" required rows="3" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm resize-none" placeholder="What can we help with?"></textarea>
              <button type="submit" :disabled="quoteSubmitting" class="w-full px-5 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all">{{ quoteSubmitting ? 'Submitting...' : 'Send Inquiry' }}</button>
            </form>
          </div>
          <div class="hidden lg:block">
            <div class="rounded-xl overflow-hidden"><img :src="heroTech2" alt="Start a Project" class="w-full h-full object-cover aspect-[4/3]" /></div>
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
              <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Join Our Growing Team</h2>
              <p class="text-white/70 text-sm leading-relaxed mb-8">We're always looking for talented people who are passionate about technology and innovation.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg">
                Get In Touch
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
import { ref } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';
import { useToast } from '@/composables';
import heroTechBg from '@/../img/tech-background.png';
import heroLaptop from '@/../img/Laptop.webp';
import heroTech2 from '@/../img/tech2.jpg';
import heroTech4 from '@/../img/tech4.jpg';
import heroTechGlow from '@/../img/tech-glow.webp';

const toast = useToast();

const values = [
  { emoji: '💡', title: 'Innovation', description: 'We embrace new technologies and creative solutions to solve complex problems.' },
  { emoji: '🤝', title: 'Integrity', description: 'Honest, transparent communication and ethical business practices.' },
  { emoji: '🎯', title: 'Excellence', description: 'We set high standards and deliver quality that exceeds expectations.' },
  { emoji: '🚀', title: 'Impact', description: 'Every project aims to create meaningful, lasting results.' },
];

const otherAreas = [
  { icon: '⚡', label: 'Services', to: '/services' },
  { icon: '📦', label: 'Products', to: '/products' },
  { icon: '💼', label: 'Bundles', to: '/bundles' },
  { icon: '📝', label: 'Blog', to: '/blog' },
];

const quoteForm = ref({ name: '', email: '', phone: '', message: '' });
const quoteSubmitting = ref(false);

async function submitQuote() {
  quoteSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', { type: 'contact', ...quoteForm.value });
    toast.success('Inquiry sent! We will contact you soon.');
    quoteForm.value = { name: '', email: '', phone: '', message: '' };
  } catch { toast.error('Failed to submit. Please try again.'); }
  finally { quoteSubmitting.value = false; }
}
</script>
