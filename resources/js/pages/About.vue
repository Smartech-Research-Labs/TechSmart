<template>
  <PublicLayout>
    <!-- Hero -->
    <section class="relative py-24 bg-background overflow-hidden">
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-72 h-72 bg-accent/10 rounded-full blur-3xl"></div>
      </div>
      <div class="relative container mx-auto px-4">
        <div class="max-w-4xl">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">About Us</div>
          <h1 class="text-5xl md:text-6xl font-bold text-foreground mb-6">Building the future of <span class="text-primary">technology</span></h1>
          <p class="text-xl text-muted-foreground leading-relaxed max-w-3xl">
            We are a team of passionate technologists dedicated to delivering cutting-edge solutions that empower businesses to thrive in the digital age.
          </p>
        </div>
      </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-20 bg-muted/30">
      <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12">
          <div class="bg-card border border-border rounded-2xl p-10">
            <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
              <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <h2 class="text-2xl font-bold text-foreground mb-4">Our Mission</h2>
            <p class="text-muted-foreground leading-relaxed">To empower businesses with innovative, reliable, and scalable technology solutions that drive growth, efficiency, and digital transformation across Africa and beyond.</p>
          </div>
          <div class="bg-card border border-border rounded-2xl p-10">
            <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center mb-6">
              <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </div>
            <h2 class="text-2xl font-bold text-foreground mb-4">Our Vision</h2>
            <p class="text-muted-foreground leading-relaxed">To be the leading tech solutions provider in Africa, recognized for our innovation, quality, and commitment to client success in every project we deliver.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Values -->
    <section class="py-20 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h2 class="text-4xl font-bold text-foreground mb-4">Our Core Values</h2>
          <p class="text-muted-foreground text-lg">The principles that guide everything we do</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="(value, i) in values" :key="i" class="text-center">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
              <span class="text-2xl">{{ value.emoji }}</span>
            </div>
            <h3 class="text-lg font-bold text-foreground mb-2">{{ value.title }}</h3>
            <p class="text-muted-foreground text-sm">{{ value.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Team CTA -->
    <section class="py-20 bg-muted/30">
      <div class="container mx-auto px-4 text-center max-w-3xl">
        <h2 class="text-4xl font-bold text-foreground mb-6">Join Our Growing Team</h2>
        <p class="text-muted-foreground text-lg mb-8">We're always looking for talented people who are passionate about technology and innovation.</p>
        <router-link to="/contact" class="inline-block px-8 py-4 bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 shadow-lg shadow-primary/25 transition-all">
          Get In Touch
        </router-link>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';

const values = [
  { emoji: '💡', title: 'Innovation', description: 'We embrace new technologies and creative solutions to solve complex problems.' },
  { emoji: '🤝', title: 'Integrity', description: 'Honest, transparent communication and ethical business practices at every step.' },
  { emoji: '🎯', title: 'Excellence', description: 'We set high standards and deliver quality that exceeds expectations.' },
  { emoji: '🚀', title: 'Impact', description: 'Every project we take on aims to create meaningful, lasting results.' },
];
</script>
