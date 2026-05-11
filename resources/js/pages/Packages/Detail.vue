<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="pkg?.image || heroLaptopDark" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-2xl">
          <router-link to="/packages" class="inline-flex items-center gap-2 text-primary text-xs font-semibold tracking-widest uppercase mb-4 hover:gap-3 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            Back to Packages
          </router-link>
          <p v-if="pkg?.tier_level" class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">{{ pkg.tier_level }}</p>
          <h1 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-4">{{ pkg?.name }}</h1>
          <p class="text-white/80 text-base leading-relaxed mb-6">{{ pkg?.short_description }}</p>
        </div>
      </div>
    </section>

    <div v-if="loading" class="min-h-screen flex items-center justify-center">
      <div class="inline-block">
        <div class="w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
      </div>
    </div>

    <div v-else-if="pkg">
      <!-- ═══════════════ MAIN CONTENT ═══════════════ -->
      <section class="py-14 md:py-20">
        <div class="container mx-auto px-6">
          <div class="grid lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
              <!-- Price Section -->
              <div class="mb-8 pb-8 border-b border-border">
                <div v-if="pkg.price" class="flex items-baseline gap-3 mb-4">
                  <span class="text-4xl font-bold text-primary">KES {{ formatPrice(pkg.price) }}</span>
                  <span v-if="pkg.price_label" class="text-muted-foreground">{{ pkg.price_label }}</span>
                </div>
                <p class="text-muted-foreground">All packages include professional support and monthly maintenance.</p>
              </div>

              <!-- Description -->
              <div v-if="pkg.description" class="mb-8 pb-8 border-b border-border">
                <h2 class="text-2xl font-bold text-foreground mb-4">Overview</h2>
                <p class="text-muted-foreground leading-relaxed whitespace-pre-wrap">{{ pkg.description }}</p>
              </div>

              <!-- Features List -->
              <div v-if="pkg.includes && pkg.includes.length > 0" class="mb-8 pb-8 border-b border-border">
                <h2 class="text-2xl font-bold text-foreground mb-6">What's Included</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div v-for="(item, idx) in pkg.includes" :key="idx" class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-muted-foreground text-sm">{{ item }}</span>
                  </div>
                </div>
              </div>

              <!-- Features from packageFeatures -->
              <div v-if="pkg.package_features && pkg.package_features.length > 0" class="mb-8">
                <h2 class="text-2xl font-bold text-foreground mb-6">Key Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div v-for="feature in pkg.package_features" :key="feature.id" class="bg-card border border-border rounded-xl p-6 hover:border-primary/30 transition-all">
                    <div v-if="feature.icon" class="text-3xl mb-3">{{ feature.icon }}</div>
                    <h3 class="text-sm font-bold text-foreground mb-2">{{ feature.title }}</h3>
                    <p v-if="feature.description" class="text-muted-foreground text-xs leading-relaxed">{{ feature.description }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
              <!-- Sticky Card -->
              <div class="sticky top-24 bg-[#262626] border border-white/10 rounded-xl p-6 space-y-4">
                <!-- Price Highlight -->
                <div class="text-center pb-4 border-b border-white/10">
                  <div class="text-3xl font-bold text-primary mb-2">KES {{ formatPrice(pkg.price) }}</div>
                  <p class="text-white/60 text-xs">{{ pkg.price_label }}</p>
                </div>

                <!-- Wishlist Button -->
                <button
                  @click="toggleWishlist"
                  :disabled="wishlistLoading"
                  class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg transition-all"
                  :class="isInWishlist
                    ? 'bg-primary/20 border border-primary text-primary hover:bg-primary/30'
                    : 'bg-primary/10 border border-primary/30 text-primary/70 hover:bg-primary/20 hover:border-primary'
                  "
                >
                  <svg v-if="isInWishlist" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                  </svg>
                  {{ isInWishlist ? 'Added to Wishlist' : 'Add to Wishlist' }}
                </button>

                <!-- Contact Buttons -->
                <div class="space-y-3 pt-2">
                  <a
                    href="https://wa.me/254711223344?text=Hi%2C%20I%20am%20interested%20in%20the%20website%20package%3A%20"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#25D366] text-white rounded-lg hover:bg-[#20ba5a] transition-all text-sm font-semibold"
                  >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-5.031 1.378c-3.055 2.116-4.922 5.636-4.922 9.28 0 5.494 4.479 9.968 9.973 9.968a9.9 9.9 0 005.461-1.64l.084.05c1.046.31 2.151.271 3.182-.12 1.034-.394 1.978-1.247 2.583-2.335.338-.627.56-1.316.645-2.019.085-.703.041-1.425-.128-2.117-.326-1.379-1.045-2.656-2.066-3.704-2.23-2.216-5.392-3.606-8.809-3.606z"/>
                    </svg>
                    Chat on WhatsApp
                  </a>

                  <a
                    href="mailto:sales@omniviatech.com"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-sm font-semibold"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email Us
                  </a>

                  <button
                    @click="startLiveChat"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all text-sm font-semibold"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Live Chat
                  </button>
                </div>

                <!-- Trust Badges -->
                <div class="pt-4 border-t border-white/10 space-y-3 text-center">
                  <div class="flex items-center justify-center gap-2 text-white/70 text-xs">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Professional Support
                  </div>
                  <div class="flex items-center justify-center gap-2 text-white/70 text-xs">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Monthly Maintenance
                  </div>
                  <div class="flex items-center justify-center gap-2 text-white/70 text-xs">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    24/7 Availability
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════════ COMPARISON CTA ═══════════════ -->
      <section class="py-14 md:py-20 bg-primary/5 border-y border-border">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-foreground leading-tight mb-4">Need a Custom Package?</h2>
            <p class="text-muted-foreground text-sm leading-relaxed mb-8">
              Our packages are flexible and can be customized to match your unique business requirements. Get in touch with our team to discuss a tailored solution.
            </p>
            <router-link
              to="/contact"
              class="inline-flex items-center gap-2 px-8 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all"
            >
              Get a Custom Quote
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
            </router-link>
          </div>
        </div>
      </section>
    </div>

    <!-- Error State -->
    <div v-else class="min-h-screen flex items-center justify-center">
      <div class="text-center">
        <h1 class="text-2xl font-bold text-foreground mb-4">Package Not Found</h1>
        <router-link to="/packages" class="text-primary hover:underline">
          Back to Packages
        </router-link>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import PublicLayout from '@/layouts/PublicLayout.vue';
import axios from 'axios';
import heroLaptopDark from "@/../img/laptop-in-dark.webp";

const route = useRoute();
const authStore = useAuthStore();
const pkg = ref(null);
const loading = ref(true);
const wishlistLoading = ref(false);
const isInWishlist = ref(false);

const formatPrice = (price: number) => {
  return price.toLocaleString('en-KE', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });
};

const fetchPackage = async () => {
  try {
    loading.value = true;
    const response = await axios.get(`/api/v1/packages/${route.params.slug}`);
    pkg.value = response.data;
    await checkWishlistStatus();
  } catch (error) {
    console.error('Failed to fetch package:', error);
  } finally {
    loading.value = false;
  }
};

const checkWishlistStatus = async () => {
  if (!authStore.isAuthenticated || !pkg.value) return;

  try {
    const response = await axios.get('/api/v1/user/wishlist');
    const wishlist = response.data.data || response.data;
    isInWishlist.value = wishlist.some(
      (item: any) => item.wishlistable_type === 'App\\Models\\Package' && item.wishlistable_id === pkg.value.id
    );
  } catch (error) {
    console.error('Failed to check wishlist status:', error);
  }
};

const toggleWishlist = async () => {
  if (!authStore.isAuthenticated) {
    authStore.showAuthModal = true;
    return;
  }

  try {
    wishlistLoading.value = true;

    if (isInWishlist.value) {
      // Remove from wishlist
      const wishlist = await axios.get('/api/v1/user/wishlist');
      const item = (wishlist.data.data || wishlist.data).find(
        (w: any) => w.wishlistable_type === 'App\\Models\\Package' && w.wishlistable_id === pkg.value.id
      );
      if (item) {
        await axios.delete(`/api/v1/user/wishlist/${item.id}`);
      }
    } else {
      // Add to wishlist
      await axios.post('/api/v1/user/wishlist', {
        wishlistable_type: 'App\\Models\\Package',
        wishlistable_id: pkg.value.id,
      });
    }

    isInWishlist.value = !isInWishlist.value;
  } catch (error) {
    console.error('Failed to toggle wishlist:', error);
  } finally {
    wishlistLoading.value = false;
  }
};

const startLiveChat = () => {
  // Trigger live chat widget - adjust based on your chat provider
  if (window.$crisp) {
    window.$crisp.push(['do', 'chat:open']);
  }
};

onMounted(() => {
  fetchPackage();
});
</script>
