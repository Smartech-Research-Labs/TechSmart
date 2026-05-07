import axios from 'axios';
import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import type { User } from '@/types';

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null);
  const token = ref<string | null>(localStorage.getItem('token'));
  const loading = ref(false);
  const error = ref<string | null>(null);

  const isAuthenticated = computed(() => !!token.value && !!user.value);
  const isAdmin = computed(() => user.value?.roles?.some(role => ['admin', 'superadmin'].includes(role.name)) ?? false);
  const isSuperAdmin = computed(() => user.value?.roles?.some(role => role.name === 'superadmin') ?? false);
  const isEditor = computed(() => user.value?.roles?.some(role => ['editor', 'admin', 'superadmin'].includes(role.name)) ?? false);

  // Set axios default headers if token exists
  if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;
  }

  async function login(credentials: { email: string; password: string }) {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.post('/api/v1/auth/login', credentials);
      token.value = response.data.token;
      user.value = response.data.user;
      
      localStorage.setItem('token', response.data.token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
      
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Login failed';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function register(data: {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
  }) {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.post('/api/v1/auth/register', data);
      token.value = response.data.token;
      user.value = response.data.user;
      
      localStorage.setItem('token', response.data.token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
      
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Registration failed';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function fetchUser() {
    if (!token.value) return;
    
    loading.value = true;
    try {
      const response = await axios.get('/api/v1/auth/user');
      user.value = response.data.user;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch user';
      // If token is invalid, clear auth state
      if (err.response?.status === 401) {
        logout();
      }
    } finally {
      loading.value = false;
    }
  }

  async function logout() {
    loading.value = true;
    try {
      if (token.value) {
        await axios.post('/api/v1/auth/logout');
      }
    } catch (err) {
      console.error('Logout error:', err);
    } finally {
      user.value = null;
      token.value = null;
      localStorage.removeItem('token');
      delete axios.defaults.headers.common['Authorization'];
      loading.value = false;
    }
  }

  async function updateProfile(data: Partial<User>) {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.put('/api/v1/user/profile', data);
      user.value = response.data.user;
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Profile update failed';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function changePassword(data: {
    current_password: string;
    password: string;
    password_confirmation: string;
  }) {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.put('/api/v1/user/password', data);
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Password change failed';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  return {
    user,
    token,
    loading,
    error,
    isAuthenticated,
    isAdmin,
    isSuperAdmin,
    isEditor,
    login,
    register,
    fetchUser,
    logout,
    updateProfile,
    changePassword,
  };
});
