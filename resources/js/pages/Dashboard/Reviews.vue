<template>
  <DashboardLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-3xl font-display font-bold text-foreground mb-2">My Reviews</h1>
        <p class="text-muted-foreground">Reviews and feedback you've submitted</p>
      </div>

      <!-- Reviews List -->
      <div v-if="reviews.length > 0" class="space-y-4">
        <div 
          v-for="review in reviews" 
          :key="review.id"
          class="bg-card border border-border rounded-lg p-6 hover:border-primary transition"
        >
          <div class="flex items-start justify-between mb-4">
            <div>
              <h3 class="text-lg font-bold text-foreground mb-1">{{ review.itemName }}</h3>
              <p class="text-sm text-muted-foreground">{{ review.date }}</p>
            </div>
            <div class="flex items-center gap-1">
              <svg 
                v-for="i in 5" 
                :key="i"
                :class="[
                  'w-5 h-5',
                  i <= review.rating ? 'text-amber-400' : 'text-muted-foreground'
                ]"
                fill="currentColor" 
                viewBox="0 0 24 24"
              >
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
              </svg>
            </div>
          </div>
          
          <p class="text-muted-foreground mb-4">{{ review.comment }}</p>
          
          <div class="flex gap-3">
            <button class="text-sm text-primary hover:text-primary/80 font-semibold transition">
              Edit Review
            </button>
            <button class="text-sm text-muted-foreground hover:text-red-400 transition">
              Delete
            </button>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="bg-card border border-border rounded-lg p-12 text-center">
        <div class="w-20 h-20 bg-muted rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-foreground mb-2">No Reviews Yet</h3>
        <p class="text-muted-foreground mb-6">Share your experience with our services</p>
        <router-link 
          to="/services"
          class="inline-block bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition"
        >
          Browse Services
        </router-link>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const reviews = ref([
  {
    id: 1,
    itemName: 'Web Development Service',
    rating: 5,
    comment: 'Excellent service! The team delivered exactly what we needed on time and within budget. Highly recommended!',
    date: 'Feb 15, 2026'
  },
  {
    id: 2,
    itemName: 'Cloud Infrastructure Setup',
    rating: 4,
    comment: 'Great experience overall. The migration was smooth and the support team was very helpful.',
    date: 'Feb 10, 2026'
  }
]);
</script>
