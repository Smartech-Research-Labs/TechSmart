<template>
  <div class="min-h-screen bg-background flex items-center justify-center px-4">
    <div class="text-center">
      <!-- 404 Illustration -->
      <div class="mb-8">
        <h1 class="text-9xl font-display font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
          404
        </h1>
      </div>

      <!-- Message -->
      <h2 class="text-3xl font-bold text-foreground mb-4">Page Not Found</h2>
      <p class="text-muted-foreground mb-8 max-w-md mx-auto">
        Sorry, we couldn't find the page you're looking for. The page might have been moved or deleted.
      </p>

      <!-- Action Buttons -->
      <div class="flex gap-4 justify-center">
        <router-link
          to="/"
          class="px-6 py-3 bg-gradient-to-r from-primary to-accent text-white font-semibold rounded-lg hover:shadow-xl transition"
        >
          Go Home
        </router-link>
        <button
          @click="$router.back()"
          class="px-6 py-3 bg-muted hover:bg-muted/80 text-foreground font-semibold rounded-lg transition"
        >
          Go Back
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// No logic needed
</script>
