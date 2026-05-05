import { defineStore } from 'pinia';
import type { Socket } from 'socket.io-client';
import { io } from 'socket.io-client';
import { ref, computed } from 'vue';
import { useNotificationSound } from '@/composables/useNotificationSound';

interface AppNotification {
  id: string;
  message: string;
  item_type: string;
  item_name: string;
  item_id?: number;
  user_name: string;
  read: boolean;
  time: string;
  created_at: string;
}

export const useNotificationStore = defineStore('notifications', () => {
  const notifications = ref<AppNotification[]>([]);
  const unreadCount = ref(0);
  const loading = ref(false);
  const socket = ref<Socket | null>(null);
  const soundEnabled = ref(true);
  
  // Sound utility
  const { playChime, playMessageChime, toggleSound: toggleSoundUtil, audioEnabled } = useNotificationSound();

  const sortedNotifications = computed(() =>
    [...notifications.value].sort(
      (a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
    )
  );

  const unreadNotifications = computed(() => notifications.value.filter(n => !n.read));
  const readNotifications = computed(() => notifications.value.filter(n => n.read));

  async function fetchNotifications() {
    loading.value = true;
    try {
      const token = localStorage.getItem('token');
      const res = await fetch(`${import.meta.env.VITE_API_URL || '/api/v1'}/admin/notifications`, {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/json',
        },
      });
      if (!res.ok) return;
      const data = await res.json();
      notifications.value = data.notifications || [];
      unreadCount.value = data.unread_count || 0;
    } catch {
      // silently fail
    } finally {
      loading.value = false;
    }
  }

  async function markAsRead(id: string) {
    try {
      const token = localStorage.getItem('token');
      await fetch(`${import.meta.env.VITE_API_URL || '/api/v1'}/admin/notifications/${id}/read`, {
        method: 'POST',
        headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' },
      });
      const n = notifications.value.find(n => n.id === id);
      if (n) {
        n.read = true;
        unreadCount.value = Math.max(0, unreadCount.value - 1);
      }
    } catch { /* ignore */ }
  }

  async function markAsUnread(id: string) {
    try {
      const token = localStorage.getItem('token');
      await fetch(`${import.meta.env.VITE_API_URL || '/api/v1'}/admin/notifications/${id}/unread`, {
        method: 'POST',
        headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' },
      });
      const n = notifications.value.find(n => n.id === id);
      if (n) {
        n.read = false;
        unreadCount.value++;
      }
    } catch { /* ignore */ }
  }

  async function markAllRead() {
    try {
      const token = localStorage.getItem('token');
      await fetch(`${import.meta.env.VITE_API_URL || '/api/v1'}/admin/notifications/read-all`, {
        method: 'POST',
        headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' },
      });
      notifications.value.forEach(n => (n.read = true));
      unreadCount.value = 0;
    } catch { /* ignore */ }
  }

  async function deleteNotification(id: string) {
    try {
      const token = localStorage.getItem('token');
      await fetch(`${import.meta.env.VITE_API_URL || '/api/v1'}/admin/notifications/${id}`, {
        method: 'DELETE',
        headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' },
      });
      const idx = notifications.value.findIndex(n => n.id === id);
      if (idx >= 0) {
        if (!notifications.value[idx].read) {
          unreadCount.value = Math.max(0, unreadCount.value - 1);
        }
        notifications.value.splice(idx, 1);
      }
    } catch { /* ignore */ }
  }

  async function deleteAllNotifications() {
    try {
      const token = localStorage.getItem('token');
      await fetch(`${import.meta.env.VITE_API_URL || '/api/v1'}/admin/notifications`, {
        method: 'DELETE',
        headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' },
      });
      notifications.value = [];
      unreadCount.value = 0;
    } catch { /* ignore */ }
  }

  // Socket.IO real-time notifications
  function initSocket() {
    if (socket.value?.connected) return;

    socket.value = io(import.meta.env.VITE_SOCKET_URL || 'http://localhost:3000', {
      transports: ['websocket', 'polling'],
    });

    socket.value.on('connect', () => {
      socket.value?.emit('register-admin', {
        token: localStorage.getItem('token'),
      });
    });

    socket.value.on('notification', (data: AppNotification) => {
      notifications.value.unshift(data);
      unreadCount.value++;
      
      // Play notification sound based on type
      if (soundEnabled.value) {
        if (data.item_type === 'Chat' || data.item_type === 'Message' || data.item_type === 'DirectMessage') {
          playMessageChime();
        } else {
          playChime();
        }
      }
    });
    
    // Listen for various alert types
    socket.value.on('server-alert', (data: AppNotification) => {
      notifications.value.unshift({
        ...data,
        item_type: 'ServerAlert',
      });
      unreadCount.value++;
      if (soundEnabled.value) playChime();
    });
    
    socket.value.on('audit-log', (data: AppNotification) => {
      notifications.value.unshift({
        ...data,
        item_type: 'AuditLog',
      });
      unreadCount.value++;
      if (soundEnabled.value) playChime();
    });
  }

  function disconnectSocket() {
    socket.value?.disconnect();
    socket.value = null;
  }

  // Poll as fallback
  let pollInterval: ReturnType<typeof setInterval> | null = null;

  function startPolling(intervalMs = 30000) {
    stopPolling();
    fetchNotifications();
    pollInterval = setInterval(fetchNotifications, intervalMs);
  }

  function stopPolling() {
    if (pollInterval) {
      clearInterval(pollInterval);
      pollInterval = null;
    }
  }

  // Toggle notification sound
  function toggleSound() {
    soundEnabled.value = !soundEnabled.value;
    return soundEnabled.value;
  }

  return {
    notifications,
    unreadCount,
    loading,
    soundEnabled,
    sortedNotifications,
    unreadNotifications,
    readNotifications,
    fetchNotifications,
    markAsRead,
    markAsUnread,
    markAllRead,
    deleteNotification,
    deleteAllNotifications,
    initSocket,
    disconnectSocket,
    startPolling,
    stopPolling,
    toggleSound,
    playChime,
    playMessageChime,
  };
});
