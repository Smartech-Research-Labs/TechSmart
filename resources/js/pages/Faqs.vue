<template>
  <PublicLayout>
    <!-- Hero -->
    <section class="py-16 md:py-20 bg-muted/30 border-b border-border">
      <div class="container mx-auto px-6">
        <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
        <h1 class="text-2xl md:text-3xl font-bold text-foreground mb-3">Frequently Asked Questions</h1>
        <p class="text-muted-foreground text-sm max-w-2xl">Find answers to the most common questions about our services.</p>
      </div>
    </section>

    <section class="py-12">
      <div class="container mx-auto px-6 max-w-3xl">
        <div class="space-y-2">
          <div v-for="(faq, i) in faqs" :key="i" class="bg-card border border-border rounded-lg overflow-hidden">
            <button @click="toggleFaq(i)" class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-muted/30 transition-colors">
              <span class="font-medium text-foreground text-sm pr-6">{{ faq.question }}</span>
              <svg :class="['w-4 h-4 text-muted-foreground shrink-0 transition-transform duration-200', openFaq === i && 'rotate-180']" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div v-show="openFaq === i" class="px-5 pb-4">
              <p class="text-muted-foreground text-sm leading-relaxed">{{ faq.answer }}</p>
            </div>
          </div>
        </div>

        <div class="mt-12 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-8 text-center">
          <h2 class="text-lg font-bold text-white mb-2">Still Have Questions?</h2>
          <p class="text-gray-400 text-sm mb-5">We're here to help. Contact our team for personalized assistance.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-semibold rounded-md hover:bg-primary/90 transition-all">
            Contact Us
          </router-link>
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
