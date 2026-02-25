<template>
  <Teleport to="body">
    <Transition name="loading-fade">
      <div v-if="isLoading" class="loading-overlay">
        <!-- Top progress bar -->
        <div class="loading-bar">
          <div class="loading-bar-inner" />
        </div>
        
        <!-- Optional full-screen overlay spinner for heavy operations -->
        <div v-if="showOverlay" class="loading-spinner-overlay" @click.self="showOverlay = false">
          <div class="loading-card">
            <svg class="loading-spinner" viewBox="0 0 50 50">
              <circle class="loading-spinner-path" cx="25" cy="25" r="20" fill="none" stroke-width="4" />
            </svg>
            <p class="loading-text">{{ message || 'Loading...' }}</p>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, watch, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'

const isLoading = ref(false)
const showOverlay = ref(false)
const message = ref('')
let routeTimer: ReturnType<typeof setTimeout> | null = null

const router = useRouter()

// Route transition loading
router.beforeEach(() => {
  // Small delay so instant navigations don't flash
  routeTimer = setTimeout(() => {
    isLoading.value = true
  }, 150)
})

router.afterEach(() => {
  if (routeTimer) {
    clearTimeout(routeTimer)
    routeTimer = null
  }
  // Small delay so the bar animation completes
  setTimeout(() => {
    isLoading.value = false
  }, 200)
})

// Expose global loading API
function startLoading(msg?: string, overlay = false) {
  message.value = msg || ''
  showOverlay.value = overlay
  isLoading.value = true
}

function stopLoading() {
  isLoading.value = false
  showOverlay.value = false
  message.value = ''
}

// Make available globally
window.__loadingIndicator = { startLoading, stopLoading }

onUnmounted(() => {
  if (routeTimer) clearTimeout(routeTimer)
})

defineExpose({ startLoading, stopLoading })
</script>

<style scoped>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 9999;
  pointer-events: none;
}

.loading-bar {
  height: 3px;
  width: 100%;
  background: transparent;
  overflow: hidden;
}

.loading-bar-inner {
  height: 100%;
  width: 40%;
  background: linear-gradient(90deg, hsl(var(--primary)), hsl(var(--primary) / 0.6), hsl(var(--primary)));
  border-radius: 2px;
  animation: loading-slide 1.2s ease-in-out infinite;
}

@keyframes loading-slide {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(350%); }
}

.loading-spinner-overlay {
  position: fixed;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: hsl(var(--background) / 0.5);
  backdrop-filter: blur(4px);
  pointer-events: auto;
  z-index: 10000;
}

.loading-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  padding: 2rem;
  border-radius: 1rem;
  background: hsl(var(--card));
  border: 1px solid hsl(var(--border));
  box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
}

.loading-spinner {
  width: 40px;
  height: 40px;
  animation: rotate 1.4s linear infinite;
}

.loading-spinner-path {
  stroke: hsl(var(--primary));
  stroke-linecap: round;
  animation: dash 1.4s ease-in-out infinite;
}

@keyframes rotate {
  100% { transform: rotate(360deg); }
}

@keyframes dash {
  0% { stroke-dasharray: 1, 150; stroke-dashoffset: 0; }
  50% { stroke-dasharray: 90, 150; stroke-dashoffset: -35; }
  100% { stroke-dasharray: 90, 150; stroke-dashoffset: -124; }
}

.loading-text {
  font-size: 0.875rem;
  color: hsl(var(--muted-foreground));
  font-weight: 500;
}

.loading-fade-enter-active,
.loading-fade-leave-active {
  transition: opacity 0.2s ease;
}

.loading-fade-enter-from,
.loading-fade-leave-to {
  opacity: 0;
}
</style>
