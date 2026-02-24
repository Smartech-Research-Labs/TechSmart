<template>
  <PublicLayout>
    <div class="container mx-auto px-4 py-20">
      <div class="mb-12">
        <h1 class="text-5xl font-display font-bold text-foreground mb-4">Our Products</h1>
        <p class="text-xl text-muted-foreground">Cutting-edge solutions to power your business</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-card border border-border rounded-2xl overflow-hidden hover:border-primary transition">
          <div class="h-48 bg-muted"></div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-foreground mb-3">Sample Product</h3>
            <p class="text-muted-foreground mb-4">Description of the product</p>
            <div class="flex items-center justify-between">
              <span class="text-primary font-bold text-xl">$999</span>
              <button class="px-4 py-2 bg-primary text-white rounded-lg">View Details</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>
