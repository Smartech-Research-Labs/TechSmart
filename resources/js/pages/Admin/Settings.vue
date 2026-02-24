<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-3xl font-display font-bold text-foreground mb-2">Site Settings</h1>
        <p class="text-muted-foreground">Configure your website settings</p>
      </div>

      <!-- Settings Form -->
      <div class="space-y-6">
        <!-- General Settings -->
        <div class="bg-card border border-border rounded-lg p-8">
          <h2 class="text-xl font-bold text-foreground mb-6">General Settings</h2>
          <div class="space-y-6">
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Site Name</label>
              <input 
                type="text"
                value="TechSmart"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Site Description</label>
              <textarea 
                rows="3"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition resize-none"
              >Premier technology solutions provider in Africa</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-2">Contact Email</label>
                <input 
                  type="email"
                  value="info@techsmart.com"
                  class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-2">Phone Number</label>
                <input 
                  type="tel"
                  value="+1 234 567 8900"
                  class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Social Media -->
        <div class="bg-card border border-border rounded-lg p-8">
          <h2 class="text-xl font-bold text-foreground mb-6">Social Media Links</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Facebook</label>
              <input 
                type="url"
                placeholder="https://facebook.com/yourpage"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Twitter</label>
              <input 
                type="url"
                placeholder="https://twitter.com/yourhandle"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">LinkedIn</label>
              <input 
                type="url"
                placeholder="https://linkedin.com/company/yourcompany"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Instagram</label>
              <input 
                type="url"
                placeholder="https://instagram.com/yourprofile"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
              />
            </div>
          </div>
        </div>

        <!-- AI Settings -->
        <div class="bg-card border border-border rounded-lg p-8">
          <h2 class="text-xl font-bold text-foreground mb-6">AI Features</h2>
          <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-muted/30 rounded-lg">
              <div>
                <p class="text-foreground font-semibold">Enable AI Chat</p>
                <p class="text-sm text-muted-foreground">Allow AI-powered customer support</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-muted peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
              </label>
            </div>
            <div class="flex items-center justify-between p-4 bg-muted/30 rounded-lg">
              <div>
                <p class="text-foreground font-semibold">Content Generation</p>
                <p class="text-sm text-muted-foreground">AI-powered content suggestions</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-muted peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
              </label>
            </div>
          </div>
        </div>

        <!-- Save Button -->
        <div class="flex gap-4">
          <button class="bg-primary hover:bg-primary/90 text-white font-semibold px-8 py-3 rounded-lg transition">
            Save Changes
          </button>
          <button class="border border-border hover:border-border text-muted-foreground font-semibold px-8 py-3 rounded-lg transition">
            Reset
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
</script>
