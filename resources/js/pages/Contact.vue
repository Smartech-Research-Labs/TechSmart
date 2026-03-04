<template>
  <PublicLayout>
    <!-- Hero -->
    <section class="py-16 md:py-20 bg-muted/30 border-b border-border">
      <div class="container mx-auto px-6">
        <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Contact Us</p>
        <h1 class="text-2xl md:text-3xl font-bold text-foreground mb-3">Get In Touch</h1>
        <p class="text-muted-foreground text-sm max-w-2xl">Have a project in mind? Let's discuss how we can help.</p>
      </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="py-12">
      <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-4 mb-12">
          <div class="flex items-start gap-4 p-4 bg-card border border-border rounded-lg">
            <div class="w-10 h-10 shrink-0 bg-primary/10 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <div>
              <h3 class="font-semibold text-foreground text-sm mb-0.5">Email</h3>
              <p class="text-muted-foreground text-xs">info@techsmart.co.ke</p>
            </div>
          </div>
          <div class="flex items-start gap-4 p-4 bg-card border border-border rounded-lg">
            <div class="w-10 h-10 shrink-0 bg-accent/10 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
            </div>
            <div>
              <h3 class="font-semibold text-foreground text-sm mb-0.5">Phone</h3>
              <p class="text-muted-foreground text-xs">+254 710 351 517</p>
            </div>
          </div>
          <div class="flex items-start gap-4 p-4 bg-card border border-border rounded-lg">
            <div class="w-10 h-10 shrink-0 bg-green-500/10 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
            <div>
              <h3 class="font-semibold text-foreground text-sm mb-0.5">Office</h3>
              <p class="text-muted-foreground text-xs">Nairobi, Kenya</p>
            </div>
          </div>
        </div>

        <!-- Form + Map Grid -->
        <div class="grid lg:grid-cols-2 gap-10">
          <form @submit.prevent="submitContact" class="bg-card border border-border rounded-lg p-6">
            <div class="grid grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-xs font-semibold text-foreground mb-1.5">Your Name</label>
                <input v-model="form.name" type="text" required class="w-full px-4 py-2.5 bg-background border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 text-foreground text-sm" placeholder="John Doe" />
              </div>
              <div>
                <label class="block text-xs font-semibold text-foreground mb-1.5">Email Address</label>
                <input v-model="form.email" type="email" required class="w-full px-4 py-2.5 bg-background border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 text-foreground text-sm" placeholder="john@example.com" />
              </div>
            </div>
            <div class="mb-4">
              <label class="block text-xs font-semibold text-foreground mb-1.5">Phone Number</label>
              <input v-model="form.phone" type="tel" class="w-full px-4 py-2.5 bg-background border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 text-foreground text-sm" placeholder="+254 710 351 517" />
            </div>
            <div class="mb-4">
              <label class="block text-xs font-semibold text-foreground mb-1.5">Subject</label>
              <input v-model="form.subject" type="text" class="w-full px-4 py-2.5 bg-background border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 text-foreground text-sm" placeholder="Project inquiry" />
            </div>
            <div class="mb-4">
              <label class="block text-xs font-semibold text-foreground mb-1.5">Message</label>
              <textarea v-model="form.message" required rows="5" class="w-full px-4 py-2.5 bg-background border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 text-foreground text-sm resize-none" placeholder="Tell us about your project..."></textarea>
            </div>
            <button type="submit" :disabled="submitting" class="w-full px-5 py-3 bg-primary text-white text-sm font-semibold rounded-md hover:bg-primary/90 disabled:opacity-50 transition-all">
              {{ submitting ? 'Sending...' : 'Send Message' }}
            </button>
          </form>

          <div class="space-y-4">
            <div class="aspect-video bg-muted rounded-lg overflow-hidden border border-border">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8!2d36.82!3d-1.28!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0!2sNairobi!5e0!3m2!1sen!2ske!4v1234567890"
                width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>
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

const toast = useToast();
const submitting = ref(false);
const form = ref({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: '',
});

async function submitContact() {
  submitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', {
      type: 'contact',
      name: form.value.name,
      email: form.value.email,
      phone: form.value.phone,
      subject: form.value.subject,
      message: form.value.message,
    });
    toast.success('Message sent successfully! We will get back to you soon.');
    form.value = { name: '', email: '', phone: '', subject: '', message: '' };
  } catch (error) {
    console.error('Error submitting contact form:', error);
    toast.error('Failed to send message. Please try again.');
  } finally {
    submitting.value = false;
  }
}
</script>
