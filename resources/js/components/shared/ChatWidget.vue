<template>
  <Teleport to="body">
    <!-- Chat Button -->
    <button
      v-if="!isOpen"
      class="chat-button fixed bottom-6 right-6 z-40 bg-gradient-to-r from-primary to-accent text-white rounded-full p-4 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110"
      @click="toggleChat"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
      </svg>
      <span v-if="unreadCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
        {{ unreadCount }}
      </span>
    </button>

    <!-- Chat Window -->
    <div
      v-if="isOpen"
      class="chat-window fixed bottom-6 right-6 z-40 w-96 max-w-[calc(100vw-3rem)] h-[600px] max-h-[calc(100vh-6rem)] bg-card border border-border rounded-lg shadow-2xl flex flex-col overflow-hidden"
    >
      <!-- Header -->
      <div class="chat-header bg-gradient-to-r from-primary to-accent text-white p-4 flex items-center justify-between">
        <div>
          <h3 class="font-bold text-lg">Chat Support</h3>
          <p class="text-xs opacity-90">
            <span v-if="chatStore.isConnected" class="flex items-center gap-1">
              <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
              Online
            </span>
            <span v-else>Offline</span>
          </p>
        </div>
        <button @click="toggleChat" class="hover:bg-white/20 rounded-full p-2 transition">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>

      <!-- Messages -->
      <div ref="messagesContainer" class="chat-messages flex-1 overflow-y-auto p-4 space-y-3">
        <div
          v-for="message in chatStore.messages"
          :key="message.id"
          :class="[
            'message flex',
            message.is_from_admin ? 'justify-start' : 'justify-end'
          ]"
        >
          <div
            :class="[
              'message-bubble max-w-[80%] rounded-lg px-4 py-2',
              message.is_from_admin
                ? 'bg-muted text-foreground'
                : 'bg-gradient-to-r from-primary to-accent text-white'
            ]"
          >
            <p class="text-sm">{{ message.message }}</p>
            <span class="text-xs opacity-70 mt-1 block">
              {{ formatTime(message.created_at) }}
            </span>
          </div>
        </div>
        
        <div v-if="chatStore.isTyping" class="message flex justify-start">
          <div class="message-bubble bg-muted text-foreground rounded-lg px-4 py-2">
            <div class="flex gap-1">
              <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
              <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
              <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Input -->
      <div class="chat-input border-t border-border p-4">
        <form @submit.prevent="sendMessage" class="flex gap-2">
          <input
            v-model="messageInput"
            type="text"
            placeholder="Type your message..."
            class="flex-1 bg-muted text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
            @input="handleTyping"
          />
          <button
            type="submit"
            :disabled="!messageInput.trim() || !chatStore.isConnected"
            class="bg-primary hover:bg-accent text-white rounded-lg px-4 py-2 disabled:opacity-50 disabled:cursor-not-allowed transition"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
          </button>
        </form>
      </div>
    </div>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, computed, watch, nextTick, onMounted } from 'vue';
import { useChatStore } from '@/stores/chat';
import { useAuthStore } from '@/stores/auth';

const chatStore = useChatStore();
const authStore = useAuthStore();
const isOpen = ref(false);
const messageInput = ref('');
const messagesContainer = ref<HTMLElement | null>(null);
const typingTimeout = ref<number | null>(null);

const unreadCount = computed(() => chatStore.unreadCount);

onMounted(async () => {
  // Load existing sessions
  await chatStore.fetchSessions().catch(() => {
    console.error('Failed to fetch chat sessions');
  });

  // If no current session, create one
  if (!chatStore.currentSession && chatStore.sessions.length === 0) {
    await chatStore.createSession().catch(() => {
      console.error('Failed to create chat session');
    });
  } else if (chatStore.sessions.length > 0) {
    // Load messages from most recent session
    const latestSession = chatStore.sessions[0];
    await chatStore.fetchMessages(latestSession.id).catch(() => {
      console.error('Failed to fetch chat messages');
    });
  }
});

function toggleChat() {
  isOpen.value = !isOpen.value;
  if (isOpen.value) {
    nextTick(() => {
      scrollToBottom();
    });
  }
}

function sendMessage() {
  if (!messageInput.value.trim()) return;
  
  chatStore.sendMessage(messageInput.value.trim());
  messageInput.value = '';
  
  nextTick(() => {
    scrollToBottom();
  });
}

function handleTyping() {
  if (typingTimeout.value) {
    clearTimeout(typingTimeout.value);
  }
  
  chatStore.emitTyping(true);
  
  typingTimeout.value = window.setTimeout(() => {
    chatStore.emitTyping(false);
  }, 1000);
}

function scrollToBottom() {
  if (messagesContainer.value) {
    messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
  }
}

function formatTime(timestamp: string) {
  const date = new Date(timestamp);
  return date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
}

// Auto-scroll when new messages arrive
watch(() => chatStore.messages.length, () => {
  nextTick(() => {
    scrollToBottom();
  });
});
</script>

<style scoped>
.chat-button {
  animation: bounce-in 0.5s ease;
}

@keyframes bounce-in {
  0% {
    opacity: 0;
    transform: scale(0) translateY(100px);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

.chat-window {
  animation: slide-up 0.3s ease;
}

@keyframes slide-up {
  from {
    opacity: 0;
    transform: translateY(100px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.chat-messages::-webkit-scrollbar {
  width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
  background: transparent;
}

.chat-messages::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.3);
}
</style>
