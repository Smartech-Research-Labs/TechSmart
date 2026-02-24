import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';
import { io, Socket } from 'socket.io-client';

interface ChatMessage {
  id: number;
  chat_session_id: number;
  user_id?: number;
  admin_id?: number;
  guest_name?: string;
  message: string;
  is_from_admin: boolean;
  created_at: string;
}

interface ChatSession {
  id: number;
  user_id?: number;
  guest_name?: string;
  guest_email?: string;
  status: 'active' | 'closed';
  assigned_admin_id?: number;
  created_at: string;
  updated_at: string;
  unread_count?: number;
  last_message?: ChatMessage;
}

export const useChatStore = defineStore('chat', () => {
  const socket = ref<Socket | null>(null);
  const currentSession = ref<ChatSession | null>(null);
  const messages = ref<ChatMessage[]>([]);
  const sessions = ref<ChatSession[]>([]);
  const isConnected = ref(false);
  const isTyping = ref(false);
  const loading = ref(false);
  const error = ref<string | null>(null);

  const unreadCount = computed(() => 
    sessions.value.reduce((total, session) => total + (session.unread_count || 0), 0)
  );

  function initializeSocket(userId?: number) {
    if (socket.value?.connected) return;

    // Connect to Socket.IO server (update URL when server is deployed)
    socket.value = io(import.meta.env.VITE_SOCKET_URL || 'http://localhost:3000', {
      auth: {
        userId,
      },
    });

    socket.value.on('connect', () => {
      isConnected.value = true;
      console.log('Socket connected');
    });

    socket.value.on('disconnect', () => {
      isConnected.value = false;
      console.log('Socket disconnected');
    });

    socket.value.on('new-message', (message: ChatMessage) => {
      // Add message to current session if it matches
      if (currentSession.value?.id === message.chat_session_id) {
        messages.value.push(message);
      }

      // Update session in list
      const sessionIndex = sessions.value.findIndex(s => s.id === message.chat_session_id);
      if (sessionIndex !== -1) {
        sessions.value[sessionIndex].last_message = message;
        if (message.is_from_admin && currentSession.value?.id !== message.chat_session_id) {
          sessions.value[sessionIndex].unread_count = 
            (sessions.value[sessionIndex].unread_count || 0) + 1;
        }
      }
    });

    socket.value.on('typing-status', (data: { sessionId: number; isTyping: boolean }) => {
      if (currentSession.value?.id === data.sessionId) {
        isTyping.value = data.isTyping;
      }
    });

    socket.value.on('session-assigned', (data: { sessionId: number; adminId: number }) => {
      const session = sessions.value.find(s => s.id === data.sessionId);
      if (session) {
        session.assigned_admin_id = data.adminId;
      }
    });
  }

  function disconnectSocket() {
    if (socket.value) {
      socket.value.disconnect();
      socket.value = null;
      isConnected.value = false;
    }
  }

  async function fetchSessions() {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.get('/api/v1/user/chat/sessions');
      sessions.value = response.data.sessions;
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch sessions';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function createSession(data?: { guest_name?: string; guest_email?: string }) {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.post('/api/v1/user/chat/sessions', data || {});
      currentSession.value = response.data.session;
      sessions.value.unshift(response.data.session);
      
      // Join socket room
      if (socket.value?.connected) {
        socket.value.emit('join-session', { sessionId: response.data.session.id });
      }
      
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to create session';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function fetchMessages(sessionId: number) {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.get(`/api/v1/user/chat/sessions/${sessionId}/messages`);
      messages.value = response.data.messages;
      currentSession.value = sessions.value.find(s => s.id === sessionId) || null;
      
      // Mark as read
      const session = sessions.value.find(s => s.id === sessionId);
      if (session) {
        session.unread_count = 0;
      }
      
      // Join socket room
      if (socket.value?.connected) {
        socket.value.emit('join-session', { sessionId });
      }
      
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch messages';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  function sendMessage(message: string) {
    if (!currentSession.value || !socket.value?.connected) {
      error.value = 'Not connected to chat';
      return;
    }

    const messageData = {
      sessionId: currentSession.value.id,
      message,
      timestamp: new Date().toISOString(),
    };

    socket.value.emit('send-message', messageData);

    // Optimistically add message
    messages.value.push({
      id: Date.now(), // temporary ID
      chat_session_id: currentSession.value.id,
      message,
      is_from_admin: false,
      created_at: messageData.timestamp,
    });
  }

  function emitTyping(isTypingNow: boolean) {
    if (!currentSession.value || !socket.value?.connected) return;

    socket.value.emit('typing', {
      sessionId: currentSession.value.id,
      isTyping: isTypingNow,
    });
  }

  function closeSession() {
    if (currentSession.value && socket.value?.connected) {
      socket.value.emit('leave-session', { sessionId: currentSession.value.id });
    }
    currentSession.value = null;
    messages.value = [];
  }

  return {
    socket,
    currentSession,
    messages,
    sessions,
    isConnected,
    isTyping,
    loading,
    error,
    unreadCount,
    initializeSocket,
    disconnectSocket,
    fetchSessions,
    createSession,
    fetchMessages,
    sendMessage,
    emitTyping,
    closeSession,
  };
});
