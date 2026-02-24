import axios, { type AxiosInstance, type AxiosRequestConfig } from 'axios';

// Create axios instance with default config
const api: AxiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_URL || '/api/v1',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true,
});

// Request interceptor to add auth token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor for error handling
api.interceptors.response.use(
  (response) => response,
  (error) => {
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

export default api;
