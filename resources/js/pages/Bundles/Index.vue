<template>
  <PublicLayout>
    <div class="container mx-auto px-4 py-20">
      <div class="mb-12">
        <h1 class="text-5xl font-display font-bold text-foreground mb-4">Value Bundles</h1>
        <p class="text-xl text-muted-foreground">Save more with our curated service packages</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-card border border-border rounded-2xl p-8 hover:border-accent transition">
          <div class="text-center mb-6">
            <h3 class="text-2xl font-bold text-foreground mb-2">Starter Bundle</h3>
            <div class="text-4xl font-bold text-primary mb-2">$2,499</div>
            <p class="text-muted-foreground">Perfect for small businesses</p>
          </div>
          <ul class="space-y-3 mb-8">
            <li class="flex items-center gap-2 text-muted-foreground">
              <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
              Website Development
            </li>
            <li class="flex items-center gap-2 text-muted-foreground">
              <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
              Basic SEO
            </li>
            <li class="flex items-center gap-2 text-muted-foreground">
              <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
              3 Months Support
            </li>
          </ul>
          <button class="w-full px-6 py-3 bg-gradient-to-r from-primary to-accent text-white font-semibold rounded-lg">
            Get Started
          </button>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>
