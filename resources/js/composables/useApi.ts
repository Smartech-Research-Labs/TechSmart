import axios, { type AxiosInstance, type AxiosRequestConfig } from 'axios';
import { installApiCache } from '@/lib/apiCache';

// Global in-flight request counter for progress bar
let activeRequests = 0;
function getLoadingIndicator() {
   
  return (window as any).__loadingIndicator as { startLoading: (msg?: string, overlay?: boolean) => void; stopLoading: () => void } | undefined;
}

// Create axios instance with default config
const api: AxiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_URL || '/api/v1',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true,
});

// Request interceptor to add auth token + start global loading
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    // Track active requests for progress bar
    activeRequests++;
    if (activeRequests === 1) {
      getLoadingIndicator()?.startLoading();
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor for error handling + stop global loading
api.interceptors.response.use(
  (response) => {
    activeRequests = Math.max(0, activeRequests - 1);
    if (activeRequests === 0) {
      getLoadingIndicator()?.stopLoading();
    }
    return response;
  },
  (error) => {
    activeRequests = Math.max(0, activeRequests - 1);
    if (activeRequests === 0) {
      getLoadingIndicator()?.stopLoading();
    }

    // Handle 401 Unauthorized
    if (error.response?.status === 401) {
      localStorage.removeItem('token');
      // Redirect to login if not already there
      if (window.location.pathname !== '/login') {
        window.location.href = '/login';
      }
    }

    // Handle 403 Forbidden
    if (error.response?.status === 403) {
      console.error('Access denied');
    }

    // Handle 404 Not Found
    if (error.response?.status === 404) {
      console.error('Resource not found');
    }

    // Handle 500 Server Error
    if (error.response?.status === 500) {
      console.error('Server error');
    }

    return Promise.reject(error);
  }
);

export function useApi() {
  return {
    api,
    
    // Helper methods for common requests
    get: <T = any>(url: string, config?: AxiosRequestConfig) => 
      api.get<T>(url, config).then(res => res.data),
      
    post: <T = any>(url: string, data?: any, config?: AxiosRequestConfig) => 
      api.post<T>(url, data, config).then(res => res.data),
      
    put: <T = any>(url: string, data?: any, config?: AxiosRequestConfig) => 
      api.put<T>(url, data, config).then(res => res.data),
      
    patch: <T = any>(url: string, data?: any, config?: AxiosRequestConfig) => 
      api.patch<T>(url, data, config).then(res => res.data),
      
    delete: <T = any>(url: string, config?: AxiosRequestConfig) => 
      api.delete<T>(url, config).then(res => res.data),
  };
}

// Same public-content cache as the global axios instance
installApiCache(api);

export default api;
