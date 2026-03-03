import { ref } from 'vue';

const activeRequests = ref(0);
const isGlobalLoading = ref(false);

/**
 * Composable to track global loading state.
 * Increments/decrements a counter so overlapping requests work correctly.
 */
export function useGlobalLoading() {
  function startLoading() {
    activeRequests.value++;
    isGlobalLoading.value = true;
  }

  function stopLoading() {
    activeRequests.value = Math.max(0, activeRequests.value - 1);
    if (activeRequests.value === 0) {
      isGlobalLoading.value = false;
    }
  }

  return {
    isGlobalLoading,
    activeRequests,
    startLoading,
    stopLoading,
  };
}
