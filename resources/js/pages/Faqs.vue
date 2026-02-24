<template>
  <PublicLayout>
    <section class="py-24 bg-background">
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
          <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">FAQs</div>
            <h1 class="text-5xl font-bold text-foreground mb-6">Frequently Asked Questions</h1>
            <p class="text-xl text-muted-foreground">Find answers to the most common questions about our services.</p>
          </div>

          <div class="space-y-4">
            <div v-for="(faq, i) in faqs" :key="i" class="bg-card border border-border rounded-2xl overflow-hidden">
              <button @click="toggleFaq(i)" class="w-full flex items-center justify-between p-6 text-left">
                <h3 class="text-lg font-bold text-foreground pr-4">{{ faq.question }}</h3>
                <svg :class="['w-5 h-5 text-muted-foreground shrink-0 transition-transform', openFaq === i && 'rotate-180']" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
              </button>
              <div v-show="openFaq === i" class="px-6 pb-6">
                <p class="text-muted-foreground leading-relaxed">{{ faq.answer }}</p>
              </div>
            </div>
          </div>

          <div class="mt-16 text-center bg-card border border-border rounded-2xl p-10">
            <h2 class="text-2xl font-bold text-foreground mb-4">Still have questions?</h2>
            <p class="text-muted-foreground mb-6">We're here to help. Contact our team for personalized assistance.</p>
            <router-link to="/contact" class="inline-block px-8 py-4 bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 shadow-lg shadow-primary/25 transition-all">
              Contact Us
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

const openFaq = ref<number | null>(0);

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
];
</script>
