<template>
  <DashboardLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-3xl font-display font-bold text-foreground mb-2">My Enquiries</h1>
        <p class="text-muted-foreground">Track your service and product inquiries</p>
      </div>

      <!-- Enquiries List -->
      <div v-if="enquiries.length > 0" class="space-y-4">
        <div 
          v-for="enquiry in enquiries" 
          :key="enquiry.id"
          class="bg-card border border-border rounded-lg p-6 hover:border-primary transition"
        >
          <div class="flex items-start justify-between mb-4">
            <div>
              <h3 class="text-lg font-bold text-foreground mb-1">{{ enquiry.subject }}</h3>
              <p class="text-sm text-muted-foreground">{{ enquiry.date }}</p>
            </div>
            <span 
              :class="[
                'px-3 py-1 rounded-full text-xs font-semibold',
                enquiry.status === 'pending' && 'bg-amber-500/20 text-amber-400',
                enquiry.status === 'replied' && 'bg-blue-500/20 text-blue-400',
                enquiry.status === 'resolved' && 'bg-green-500/20 text-green-400'
              ]"
            >
              {{ enquiry.status.toUpperCase() }}
            </span>
          </div>
          
          <p class="text-muted-foreground mb-4">{{ enquiry.message }}</p>
          
          <div v-if="enquiry.reply" class="bg-muted/30 border border-border rounded-lg p-4 mb-4">
            <p class="text-sm text-muted-foreground mb-2">Reply from support:</p>
            <p class="text-muted-foreground">{{ enquiry.reply }}</p>
          </div>

          <div class="flex gap-3">
            <button class="text-sm text-primary hover:text-primary/80 font-semibold transition">
              View Details
            </button>
            <button v-if="enquiry.status !== 'resolved'" class="text-sm text-muted-foreground hover:text-foreground transition">
              Mark as Resolved
            </button>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="bg-card border border-border rounded-lg p-12 text-center">
        <div class="w-20 h-20 bg-muted rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-foreground mb-2">No Enquiries Yet</h3>
        <p class="text-muted-foreground mb-6">Have questions? Get in touch with us</p>
        <router-link 
          to="/contact"
          class="inline-block bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition"
        >
          Contact Us
        </router-link>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const enquiries = ref([
  {
    id: 1,
    subject: 'Custom Web Development Quote',
    message: 'I need a custom e-commerce platform for my business. Can you provide a detailed quote?',
    date: 'Feb 20, 2026',
    status: 'replied',
    reply: 'Thank you for your interest! We\'ll send you a detailed proposal within 24 hours.'
  },
  {
    id: 2,
    subject: 'Enterprise Bundle Inquiry',
    message: 'What does the enterprise bundle include? Do you offer custom packages?',
    date: 'Feb 18, 2026',
    status: 'pending',
    reply: null
  }
]);
</script>
