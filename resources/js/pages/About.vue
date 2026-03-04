<template>
  <PublicLayout>
    <!-- Hero -->
    <section class="py-16 md:py-20 bg-muted/30 border-b border-border">
      <div class="container mx-auto px-6">
        <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">About Us</p>
        <h1 class="text-2xl md:text-3xl font-bold text-foreground mb-3">Building the Future of Technology</h1>
        <p class="text-muted-foreground text-sm max-w-2xl">We are a team of passionate technologists dedicated to delivering cutting-edge solutions that empower businesses to thrive in the digital age.</p>
      </div>
    </section>

    <!-- Image + Text -->
    <section class="py-16 md:py-20">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="rounded-lg overflow-hidden">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop&q=80" alt="TechSmart Team" class="w-full h-full object-cover aspect-[4/3]" />
          </div>
          <div>
            <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Story</p>
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Technology That Transforms</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-4">Founded with a vision to make world-class technology accessible to businesses across Africa, TechSmart has grown into a trusted partner for organizations of all sizes.</p>
            <p class="text-muted-foreground text-sm leading-relaxed">We combine deep technical expertise with genuine understanding of African business landscapes to deliver solutions that work in the real world.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Mission & Vision Cards -->
    <section class="py-16 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-6">
          <div class="bg-card border border-border rounded-lg p-8">
            <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <h2 class="text-lg font-bold text-foreground mb-3">Our Mission</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">To empower businesses with innovative, reliable, and scalable technology solutions that drive growth, efficiency, and digital transformation across Africa and beyond.</p>
          </div>
          <div class="bg-card border border-border rounded-lg p-8">
            <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
              <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </div>
            <h2 class="text-lg font-bold text-foreground mb-3">Our Vision</h2>
            <p class="text-muted-foreground text-sm leading-relaxed">To be the leading tech solutions provider in Africa, recognized for our innovation, quality, and commitment to client success in every project we deliver.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Core Values -->
    <section class="py-16 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">What We Believe</p>
          <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-3">Our Core Values</h2>
          <p class="text-muted-foreground text-sm">The principles that guide everything we do.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div v-for="(value, i) in values" :key="i" class="text-center">
            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mx-auto mb-4">
              <span class="text-xl">{{ value.emoji }}</span>
            </div>
            <h3 class="text-sm font-semibold text-foreground mb-2">{{ value.title }}</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">{{ value.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-8 md:p-12 text-center">
          <h2 class="text-xl md:text-2xl font-bold text-white mb-3">Join Our Growing Team</h2>
          <p class="text-gray-400 text-sm mb-6 max-w-lg mx-auto">We're always looking for talented people who are passionate about technology and innovation.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-semibold rounded-md hover:bg-primary/90 transition-all">
            Get In Touch
          </router-link>
        </div>
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
