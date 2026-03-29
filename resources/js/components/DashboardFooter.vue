<template>
  <footer class="border-t bg-background/95 backdrop-blur px-4 py-3 lg:px-6">
    <div class="flex flex-col items-center justify-between gap-2 text-xs text-muted-foreground sm:flex-row">
      <p>&copy; {{ new Date().getFullYear() }} Smartech Research Labs. All rights reserved.</p>
      <div class="flex items-center gap-4">
        <router-link to="/contact" class="hover:text-foreground transition-colors">Support</router-link>
        <router-link to="/faqs" class="hover:text-foreground transition-colors">FAQs</router-link>
        <router-link to="/" class="hover:text-foreground transition-colors">Home</router-link>
      </div>
    </div>
  </footer>
</template>
