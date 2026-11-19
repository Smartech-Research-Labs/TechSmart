<template>
  <div class="fixed bottom-24 right-6 z-50 flex flex-col items-end gap-3">
    <!-- Chat Button -->
    <Transition
      enter-active-class="transition-all duration-300 ease-out"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition-all duration-200 ease-in"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <button
        v-show="!isChatOpen"
        @click="openChat"
        class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-accent to-primary text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center group relative"
        aria-label="Open chat"
      >
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <!-- Pulse indicator -->
        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white dark:border-card animate-pulse"></span>
      </button>
    </Transition>

    <!-- Chat Window -->
    <Transition
      enter-active-class="transition-all duration-300 ease-out"
      enter-from-class="opacity-0 scale-95 translate-y-4"
      enter-to-class="opacity-100 scale-100 translate-y-0"
      leave-active-class="transition-all duration-200 ease-in"
      leave-from-class="opacity-100 scale-100 translate-y-0"
      leave-to-class="opacity-0 scale-95 translate-y-4"
    >
      <div v-show="isChatOpen" class="w-80 sm:w-96 bg-card border border-border rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[500px]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary to-accent px-4 py-3 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
            </div>
            <div>
              <h3 class="text-white font-semibold text-sm">OmniviaTech AI</h3>
              <p class="text-white/70 text-xs flex items-center gap-1">
                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                Online
              </p>
            </div>
          </div>
          <button @click="closeChat" class="text-white/80 hover:text-white transition p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Messages -->
        <div ref="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4 bg-muted/20 min-h-[280px] max-h-[320px]">
          <div v-for="(message, index) in messages" :key="index" :class="['flex', message.isUser ? 'justify-end' : 'justify-start']">
            <div :class="[
              'max-w-[80%] rounded-2xl px-4 py-2.5 text-sm',
              message.isUser 
                ? 'bg-primary text-white rounded-br-md' 
                : 'bg-card border border-border text-foreground rounded-bl-md'
            ]">
              <p class="whitespace-pre-wrap">{{ message.text }}</p>
              <span class="text-[10px] mt-1 block" :class="message.isUser ? 'text-white/60' : 'text-muted-foreground'">
                {{ formatTime(message.timestamp) }}
              </span>
            </div>
          </div>
          <div v-if="isTyping" class="flex justify-start">
            <div class="bg-card border border-border rounded-2xl rounded-bl-md px-4 py-3">
              <div class="flex gap-1.5">
                <span class="w-2 h-2 bg-muted-foreground/50 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                <span class="w-2 h-2 bg-muted-foreground/50 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                <span class="w-2 h-2 bg-muted-foreground/50 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Input -->
        <div class="p-3 bg-card border-t border-border">
          <form @submit.prevent="sendMessage" class="flex gap-2">
            <input
              v-model="inputMessage"
              type="text"
              placeholder="Type your message..."
              class="flex-1 px-4 py-2.5 bg-muted/50 border border-border rounded-xl focus:outline-none focus:border-primary text-foreground text-sm"
              :disabled="isTyping"
            />
            <button
              type="submit"
              :disabled="!inputMessage.trim() || isTyping"
              class="w-10 h-10 bg-primary hover:bg-primary/90 disabled:opacity-50 text-white rounded-xl flex items-center justify-center transition"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
              </svg>
            </button>
          </form>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup lang="ts">
import { ref, nextTick } from 'vue';

// The chat store (and its socket.io client) is only loaded once a visitor actually sends a message
const loadChatStore = () => import('@/stores/chat').then((m) => m.useChatStore());

interface Message {
  text: string;
  isUser: boolean;
  timestamp: Date;
}

const isChatOpen = ref(false);
const inputMessage = ref('');
const isTyping = ref(false);
const messagesContainer = ref<HTMLElement | null>(null);

const messages = ref<Message[]>([
  {
    text: "Hello! 👋 I'm OmniviaTech AI, your virtual assistant. How can I help you today?\n\nI can assist with:\n• Service inquiries\n• Product information\n• Pricing questions\n• Technical support",
    isUser: false,
    timestamp: new Date()
  }
]);

const openChat = () => {
  isChatOpen.value = true;
};

const closeChat = () => {
  isChatOpen.value = false;
};

const formatTime = (date: Date) => {
  return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
};

const scrollToBottom = async () => {
  await nextTick();
  if (messagesContainer.value) {
    messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
  }
};

const sendMessage = async () => {
  if (!inputMessage.value.trim() || isTyping.value) return;

  const userMessage = inputMessage.value.trim();
  messages.value.push({
    text: userMessage,
    isUser: true,
    timestamp: new Date()
  });
  inputMessage.value = '';
  scrollToBottom();

  isTyping.value = true;

  try {
    // Try to get AI response
    await (await loadChatStore()).sendMessage(userMessage);
    
    setTimeout(() => {
      isTyping.value = false;
      messages.value.push({
        text: getDefaultResponse(userMessage),
        isUser: false,
        timestamp: new Date()
      });
      scrollToBottom();
    }, 1000 + Math.random() * 1000);
  } catch (error) {
    setTimeout(() => {
      isTyping.value = false;
      messages.value.push({
        text: getDefaultResponse(userMessage),
        isUser: false,
        timestamp: new Date()
      });
      scrollToBottom();
    }, 800);
  }
};

const getDefaultResponse = (query: string): string => {
  const q = query.toLowerCase();
  
  if (q.includes('price') || q.includes('cost') || q.includes('pricing')) {
    return "Our pricing varies based on project scope and requirements. For accurate pricing:\n\n• Request a quote through our website\n• Call us at +254 710 351 517\n• Email reachout@omniviatech.co.ke\n\nWe offer competitive rates and flexible payment plans!";
  }
  
  if (q.includes('service') || q.includes('offer')) {
    return "We offer a wide range of services:\n\n🖥️ Software Development\n📱 Mobile App Development\n☁️ Cloud Solutions\n🔒 Cybersecurity\n📊 Data Analytics\n🤖 AI & Automation\n🎯 Digital Marketing\n\nVisit our Services page for more details!";
  }
  
  if (q.includes('contact') || q.includes('call') || q.includes('reach')) {
    return "You can reach us through:\n\n📧 Email: reachout@omniviatech.co.ke\n📞 Phone: +254 710 351 517\n💬 WhatsApp: +254 710 351 517\n\nOur team responds within 24 hours!";
  }
  
  if (q.includes('hello') || q.includes('hi') || q.includes('hey')) {
    return "Hello! Great to hear from you! 😊\n\nHow can I assist you today? Feel free to ask about our services, products, or anything else!";
  }
  
  return "Thank you for your message! Our team will review your inquiry and get back to you soon.\n\nFor immediate assistance:\n📞 +254 710 351 517\n📧 reachout@omniviatech.co.ke\n\nIs there anything specific I can help you with?";
};

</script>
