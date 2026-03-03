import { ref } from 'vue';
import { useApi } from './useApi';
import { useToast } from './useToast';

/**
 * A wrapper around useApi that provides automatic loading state
 * tracking and optional toast notifications for API operations.
 *
 * Usage:
 *   const { loading, execute, fetchData } = useLoadingApi();
 *   await execute(() => api.post('/admin/blogs', data), 'Blog created!');
 */
export function useLoadingApi() {
  const { get, post, put, patch, delete: destroy, api } = useApi();
  const toast = useToast();
  const loading = ref(false);
  const operationLoading = ref(false);

  /**
   * Execute an async function with loading state and optional toast.
   * Returns { data, error } — never throws.
   */
  async function execute<T = any>(
    fn: () => Promise<T>,
    successMessage?: string,
    errorMessage?: string,
  ): Promise<{ data: T | null; error: any }> {
    operationLoading.value = true;
    try {
      const data = await fn();
      if (successMessage) toast.success(successMessage);
      return { data, error: null };
    } catch (err: any) {
      const msg = errorMessage
        || err?.response?.data?.message
        || err?.message
        || 'Something went wrong';
      toast.error(msg);
      return { data: null, error: err };
    } finally {
      operationLoading.value = false;
    }
  }

  /**
   * Convenience wrapper for GET requests that manages `loading` state.
   */
  async function fetchData<T = any>(url: string): Promise<T | null> {
    loading.value = true;
    try {
      return await get<T>(url);
    } catch {
      return null;
    } finally {
      loading.value = false;
    }
  }

  return {
    api,
    get,
    post,
    put,
    patch,
    delete: destroy,
    loading,
    operationLoading,
    execute,
    fetchData,
    toast,
  };
}
