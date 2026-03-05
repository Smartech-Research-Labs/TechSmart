import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';
import { io, Socket } from 'socket.io-client';

export interface DMUser {
  id: number;
  name: string;
  email: string;
  avatar?: string;
  is_online: boolean;
  last_seen_at?: string;
}

export interface DMMessage {
  id: number;
  conversation_id: number;
  sender_id: number;
  receiver_id: number;
  body: string;
  status: 'sent' | 'delivered' | 'read';
  delivered_at?: string;
  read_at?: string;
  created_at: string;
  sender?: { id: number; name: string };
}

export interface DMConversation {
  id: number;
  partner: DMUser | null;
  last_message: {
    body: string;
    sender_id: number;
    status: string;
    created_at: string;
  } | null;
  unread_count: number;
  last_message_at: string | null;
}

export const useDirectMessageStore = defineStore('directMessages', () => {
  const socket = ref<Socket | null>(null);
  const conversations = ref<DMConversation[]>([]);
  const activeConversation = ref<DMConversation | null>(null);
  const messages = ref<DMMessage[]>([]);
  const onlineUsers = ref<DMUser[]>([]);
  const isConnected = ref(false);
  const isTyping = ref(false);
  const typingUser = ref<string | null>(null);
  const loading = ref(false);

  const totalUnread = computed(() =>
    conversations.value.reduce((sum, c) => sum + (c.unread_count || 0), 0)
  );

  // Socket.IO
  function initSocket(userId: number) {
    if (socket.value?.connected) return;

    socket.value = io(import.meta.env.VITE_SOCKET_URL || 'http://localhost:3000', {
      auth: { userId },
      transports: ['websocket', 'polling'],
    });

    socket.value.on('connect', () => {
      isConnected.value = true;
      socket.value?.emit('dm-register', { userId });
    });

    socket.value.on('disconnect', () => {
      isConnected.value = false;
    });

    // Incoming DM
    socket.value.on('dm-message', (msg: DMMessage) => {
      // Add to messages if this conversation is open
      if (activeConversation.value?.id === msg.conversation_id) {
        messages.value.push(msg);
        // Auto mark as read since we're looking at the conversation
        markConversationRead(msg.conversation_id);
        socket.value?.emit('dm-read', { conversationId: msg.conversation_id, userId });
      }

      // Update conversation list
      const conv = conversations.value.find(c => c.id === msg.conversation_id);
      if (conv) {
        conv.last_message = {
          body: msg.body,
          sender_id: msg.sender_id,
          status: msg.status,
          created_at: msg.created_at,
        };
        conv.last_message_at = msg.created_at;
        if (activeConversation.value?.id !== msg.conversation_id) {
          conv.unread_count++;
        }
      }
    });

    // Message status updates (delivery/read receipts)
    socket.value.on('dm-status-update', (data: { messageId: number; status: 'delivered' | 'read' }) => {
      const msg = messages.value.find(m => m.id === data.messageId);
      if (msg) msg.status = data.status;
    });

    // Typing indicator
    socket.value.on('dm-typing', (data: { conversationId: number; userName: string; isTyping: boolean }) => {
      if (activeConversation.value?.id === data.conversationId) {
        isTyping.value = data.isTyping;
        typingUser.value = data.isTyping ? data.userName : null;
      }
    });

    // Presence updates
    socket.value.on('user-presence', (data: { userId: number; isOnline: boolean }) => {
      // Update in online users list
      const u = onlineUsers.value.find(u => u.id === data.userId);
      if (u) u.is_online = data.isOnline;

      // Update in conversations
      conversations.value.forEach(c => {
        if (c.partner?.id === data.userId) {
          c.partner.is_online = data.isOnline;
        }
      });
    });
  }

  function disconnectSocket() {
    socket.value?.disconnect();
    socket.value = null;
    isConnected.value = false;
  }

  // API calls
  async function fetchConversations() {
    loading.value = true;
    try {
      const { data } = await axios.get('/api/v1/user/dm/conversations');
      conversations.value = data.data || data || [];
    } catch {
      // ignore
    } finally {
      loading.value = false;
    }
  }

  async function fetchMessages(conversationId: number) {
    loading.value = true;
    try {
      const { data } = await axios.get(`/api/v1/user/dm/conversations/${conversationId}/messages`);
      messages.value = (data.data || data || []).reverse();

      // Update unread count for this conversation
      const conv = conversations.value.find(c => c.id === conversationId);
      if (conv) conv.unread_count = 0;
    } catch {
      // ignore
    } finally {
      loading.value = false;
    }
  }

  async function sendMessage(receiverId: number, body: string) {
    try {
      const { data } = await axios.post('/api/v1/user/dm/send', {
        receiver_id: receiverId,
        body,
      });

      const msg = data.message;
      messages.value.push(msg);

      // Update conversation
      const convId = data.conversation_id;
      let conv = conversations.value.find(c => c.id === convId);
      if (conv) {
        conv.last_message = { body: msg.body, sender_id: msg.sender_id, status: msg.status, created_at: msg.created_at };
        conv.last_message_at = msg.created_at;
      }

      // Emit via socket for real-time delivery
      if (socket.value?.connected) {
        socket.value.emit('dm-send', {
          conversationId: convId,
          receiverId,
          message: msg,
        });
      }

      return msg;
    } catch (err) {
      throw err;
    }
  }

  async function markConversationRead(conversationId: number) {
    try {
      await axios.post(`/api/v1/user/dm/conversations/${conversationId}/read`);
    } catch {
      // ignore
    }
  }

  async function fetchOnlineUsers() {
    try {
      const { data } = await axios.get('/api/v1/user/dm/users/online');
      onlineUsers.value = data.users || [];
    } catch {
      // ignore
    }
  }

  function emitTyping(conversationId: number, userName: string, isTypingNow: boolean) {
    if (!socket.value?.connected) return;
    socket.value.emit('dm-typing', { conversationId, userName, isTyping: isTypingNow });
  }

  function setActiveConversation(conv: DMConversation | null) {
    activeConversation.value = conv;
    if (conv) {
      fetchMessages(conv.id);
      if (socket.value?.connected) {
        socket.value.emit('dm-join', { conversationId: conv.id });
      }
    } else {
      messages.value = [];
    }
  }

  return {
    socket,
    conversations,
    activeConversation,
    messages,
    onlineUsers,
    isConnected,
    isTyping,
    typingUser,
    loading,
    totalUnread,
    initSocket,
    disconnectSocket,
    fetchConversations,
    fetchMessages,
    sendMessage,
    markConversationRead,
    fetchOnlineUsers,
    emitTyping,
    setActiveConversation,
  };
});
