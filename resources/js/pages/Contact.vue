<template>
  <PublicLayout>
    <section class="relative py-24 bg-background overflow-hidden">
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
      </div>
      <div class="relative container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
          <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium mb-6">Contact Us</div>
            <h1 class="text-5xl font-bold text-foreground mb-6">Get in touch</h1>
            <p class="text-xl text-muted-foreground">Have a project in mind? Let's discuss how we can help.</p>
          </div>

          <div class="grid md:grid-cols-3 gap-8 mb-12">
            <div class="bg-card border border-border rounded-2xl p-6 text-center">
              <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
              </div>
              <h3 class="font-bold text-foreground mb-1">Email</h3>
              <p class="text-muted-foreground text-sm">info@techsmart.co.za</p>
            </div>
            <div class="bg-card border border-border rounded-2xl p-6 text-center">
              <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
              </div>
              <h3 class="font-bold text-foreground mb-1">Phone</h3>
              <p class="text-muted-foreground text-sm">+27 12 345 6789</p>
            </div>
            <div class="bg-card border border-border rounded-2xl p-6 text-center">
              <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
              </div>
              <h3 class="font-bold text-foreground mb-1">Office</h3>
              <p class="text-muted-foreground text-sm">Johannesburg, South Africa</p>
            </div>
          </div>

          <form @submit.prevent class="bg-card border border-border rounded-2xl p-8 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <label class="block text-sm font-medium text-foreground mb-2">Your Name</label>
                <input type="text" placeholder="John Doe" class="w-full px-4 py-3 bg-background border border-border rounded-xl text-foreground placeholder-muted-foreground focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition" />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-2">Email Address</label>
                <input type="email" placeholder="john@example.com" class="w-full px-4 py-3 bg-background border border-border rounded-xl text-foreground placeholder-muted-foreground focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition" />
              </div>
            </div>
            <div class="mb-6">
              <label class="block text-sm font-medium text-foreground mb-2">Subject</label>
              <input type="text" placeholder="Project inquiry" class="w-full px-4 py-3 bg-background border border-border rounded-xl text-foreground placeholder-muted-foreground focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition" />
            </div>
            <div class="mb-6">
              <label class="block text-sm font-medium text-foreground mb-2">Message</label>
              <textarea rows="6" placeholder="Tell us about your project..." class="w-full px-4 py-3 bg-background border border-border rounded-xl text-foreground placeholder-muted-foreground focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition resize-none"></textarea>
            </div>
            <button type="submit" class="w-full md:w-auto px-8 py-4 bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 shadow-lg shadow-primary/25 transition-all">
              Send Message
            </button>
          </form>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>
