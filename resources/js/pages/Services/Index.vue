<template>
  <PublicLayout>
    <!-- Hero -->
    <section class="relative py-24 bg-background overflow-hidden">
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-20 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
      </div>
      <div class="relative container mx-auto px-4">
        <div class="max-w-4xl">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">Our Services</div>
          <h1 class="text-5xl md:text-6xl font-bold text-foreground mb-6">Technology solutions for <span class="text-primary">every need</span></h1>
          <p class="text-xl text-muted-foreground max-w-3xl">Comprehensive technology services designed to help your business innovate, scale, and succeed in the digital world.</p>
        </div>
      </div>
    </section>

    <!-- Services Grid -->
    <section class="py-20 bg-muted/30">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <router-link
            v-for="service in services"
            :key="service.slug"
            :to="`/services/${service.slug}`"
            class="group bg-card border border-border rounded-2xl p-8 hover:border-primary/40 hover:shadow-xl hover:shadow-primary/5 transition-all duration-300 hover:-translate-y-1"
          >
            <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary/20 transition-colors">
              <span class="text-2xl">{{ service.emoji }}</span>
            </div>
            <h3 class="text-xl font-bold text-foreground mb-3 group-hover:text-primary transition-colors">{{ service.title }}</h3>
            <p class="text-muted-foreground text-sm leading-relaxed mb-6">{{ service.description }}</p>
            <ul class="space-y-2 mb-6">
              <li v-for="(feat, i) in service.features" :key="i" class="text-muted-foreground text-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                {{ feat }}
              </li>
            </ul>
            <span class="inline-flex items-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
              Learn more <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </span>
          </router-link>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-background">
      <div class="container mx-auto px-4 text-center max-w-3xl">
        <h2 class="text-4xl font-bold text-foreground mb-6">Need a custom solution?</h2>
        <p class="text-muted-foreground text-lg mb-8">Tell us about your project and we'll provide a free consultation and estimate.</p>
        <router-link to="/contact" class="inline-block px-8 py-4 bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 shadow-lg shadow-primary/25 transition-all">
          Get Free Consultation
        </router-link>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';

const services = [
  { title: 'Web Development', slug: 'web-development', emoji: '🌐', description: 'Custom web applications built with modern frameworks like Laravel, Vue, React and Next.js.', features: ['Single Page Applications', 'Progressive Web Apps', 'API Development', 'CMS & Portals'] },
  { title: 'Mobile App Development', slug: 'mobile-app-development', emoji: '📱', description: 'Native and cross-platform mobile apps for iOS and Android with stunning UX.', features: ['React Native & Flutter', 'Native iOS & Android', 'App Store Deployment', 'Push Notifications'] },
  { title: 'Automation & AI', slug: 'automation', emoji: '⚡', description: 'Intelligent automation, AI integrations, and workflow optimization solutions.', features: ['Workflow Automation', 'AI Chatbots', 'Data Processing', 'Machine Learning'] },
  { title: 'SaaS Development', slug: 'saas-development', emoji: '☁️', description: 'End-to-end SaaS product development with multi-tenant architecture and billing.', features: ['Multi-tenant Architecture', 'Subscription Billing', 'Analytics Dashboard', 'API Integrations'] },
  { title: 'E-Commerce Solutions', slug: 'e-commerce', emoji: '🛒', description: 'Custom online stores, marketplace platforms, and payment integrations.', features: ['Custom Stores', 'Payment Gateways', 'Inventory Management', 'Order Tracking'] },
  { title: 'Deployment & Hosting', slug: 'deployment-hosting', emoji: '🚀', description: 'Cloud infrastructure, CI/CD pipelines, and managed hosting solutions.', features: ['AWS, GCP, Azure', 'Docker & Kubernetes', 'CI/CD Pipelines', '24/7 Monitoring'] },
];
</script>
