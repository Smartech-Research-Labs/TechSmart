<template>
  <DashboardLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground">Messages</h1>
          <p class="text-muted-foreground text-sm mt-0.5">Chat with other users</p>
        </div>
        <Button variant="outline" size="sm" @click="showNewChat = true">
          <IconPlus class="size-4 mr-1.5" />
          New Chat
        </Button>
      </div>

      <!-- Two-Panel Chat Layout -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-0 border border-border rounded-lg overflow-hidden bg-card" style="min-height: 600px; max-height: calc(100vh - 220px);">
        <!-- Left Panel: Conversation List -->
        <div class="lg:col-span-1 border-r border-border flex flex-col">
          <!-- Search -->
          <div class="p-3 border-b border-border">
            <div class="relative">
              <IconSearch class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-muted-foreground" />
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search conversations..."
                class="w-full pl-9 pr-3 py-2 text-sm bg-muted/50 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/30 text-foreground placeholder:text-muted-foreground"
              />
            </div>
          </div>

          <!-- Conversations -->
          <div class="flex-1 overflow-y-auto">
            <!-- Loading -->
            <div v-if="dmStore.loading && dmStore.conversations.length === 0" class="p-8 text-center text-muted-foreground">
              <svg class="animate-spin h-5 w-5 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
              </svg>
              Loading...
            </div>

            <!-- Empty -->
            <div v-else-if="filteredConversations.length === 0" class="p-8 text-center text-muted-foreground">
              <IconMessages class="size-10 mx-auto mb-3 opacity-40" />
              <p class="text-sm">{{ searchQuery ? 'No matching conversations' : 'No conversations yet' }}</p>
              <button @click="showNewChat = true" class="text-primary text-sm mt-2 underline">Start a conversation</button>
            </div>

            <!-- Conversation Items -->
            <div
              v-for="conv in filteredConversations"
              :key="conv.id"
              @click="selectConversation(conv)"
              :class="[
                'flex items-center gap-3 px-4 py-3 cursor-pointer transition border-b border-border/50 hover:bg-muted/60',
                dmStore.activeConversation?.id === conv.id ? 'bg-muted/80' : ''
              ]"
            >
              <!-- Avatar with online indicator -->
              <div class="relative flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-semibold text-sm">
                  {{ getInitials(conv.partner?.name) }}
                </div>
                <span
                  v-if="conv.partner?.is_online"
                  class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-card rounded-full"
                />
              </div>

              <!-- Info -->
              <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium text-foreground truncate">{{ conv.partner?.name || 'Unknown' }}</p>
                  <span class="text-[11px] text-muted-foreground flex-shrink-0">{{ formatTime(conv.last_message_at) }}</span>
                </div>
                <div class="flex items-center justify-between mt-0.5">
                  <p class="text-xs text-muted-foreground truncate pr-2">
                    <template v-if="conv.last_message">
                      <span v-if="conv.last_message.sender_id === authStore.user?.id" class="text-muted-foreground/70">You: </span>
                      {{ conv.last_message.body }}
                    </template>
                    <template v-else>No messages yet</template>
                  </p>
                  <span
                    v-if="conv.unread_count > 0"
                    class="flex-shrink-0 bg-primary text-primary-foreground text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center"
                  >
                    {{ conv.unread_count > 9 ? '9+' : conv.unread_count }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Panel: Chat Area -->
        <div class="lg:col-span-2 flex flex-col">
          <!-- No conversation selected -->
          <div v-if="!dmStore.activeConversation" class="flex-1 flex flex-col items-center justify-center text-muted-foreground gap-3">
            <IconMessages class="size-16 opacity-30" />
            <p class="text-sm">Select a conversation or start a new one</p>
          </div>

          <!-- Active conversation -->
          <template v-else>
            <!-- Chat Header -->
            <div class="flex items-center gap-3 px-4 py-3 border-b border-border bg-muted/30">
              <div class="relative">
                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-semibold text-sm">
                  {{ getInitials(dmStore.activeConversation.partner?.name) }}
                </div>
                <span
                  v-if="dmStore.activeConversation.partner?.is_online"
                  class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-muted/30 rounded-full"
                />
              </div>
              <div>
                <p class="text-sm font-medium text-foreground">{{ dmStore.activeConversation.partner?.name }}</p>
                <p class="text-[11px] text-muted-foreground">
                  <template v-if="dmStore.activeConversation.partner?.is_online">
                    <span class="text-green-500">Online</span>
                  </template>
                  <template v-else-if="dmStore.activeConversation.partner?.last_seen_at">
                    Last seen {{ formatTime(dmStore.activeConversation.partner.last_seen_at) }}
                  </template>
                  <template v-else>Offline</template>
                </p>
              </div>
            </div>

            <!-- Messages Area -->
            <div ref="messagesContainer" class="flex-1 overflow-y-auto px-4 py-4 space-y-3" style="min-height: 0;">
              <!-- Loading messages -->
              <div v-if="dmStore.loading" class="flex items-center justify-center py-8">
                <svg class="animate-spin h-5 w-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
              </div>

              <!-- Messages -->
              <template v-else>
                <div v-if="dmStore.messages.length === 0" class="text-center text-muted-foreground text-sm py-8">
                  No messages yet. Say hi!
                </div>

                <div
                  v-for="msg in dmStore.messages"
                  :key="msg.id"
                  :class="[
                    'flex',
                    msg.sender_id === authStore.user?.id ? 'justify-end' : 'justify-start'
                  ]"
                >
                  <div
                    :class="[
                      'max-w-[75%] rounded-2xl px-4 py-2 text-sm',
                      msg.sender_id === authStore.user?.id
                        ? 'bg-primary text-primary-foreground rounded-br-md'
                        : 'bg-muted text-foreground rounded-bl-md'
                    ]"
                  >
                    <p class="whitespace-pre-wrap break-words">{{ msg.body }}</p>
                    <div :class="[
                      'flex items-center gap-1.5 mt-1',
                      msg.sender_id === authStore.user?.id ? 'justify-end' : 'justify-start'
                    ]">
                      <span :class="[
                        'text-[10px]',
                        msg.sender_id === authStore.user?.id ? 'text-primary-foreground/60' : 'text-muted-foreground'
                      ]">
                        {{ formatMsgTime(msg.created_at) }}
                      </span>
                      <!-- Delivery ticks for sent messages -->
                      <template v-if="msg.sender_id === authStore.user?.id">
                        <!-- Single tick: sent -->
                        <svg v-if="msg.status === 'sent'" class="w-3.5 h-3.5 text-primary-foreground/60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                          <polyline points="20 6 9 17 4 12" />
                        </svg>
                        <!-- Double tick: delivered -->
                        <svg v-else-if="msg.status === 'delivered'" class="w-4 h-4 text-primary-foreground/60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                          <polyline points="18 6 7 17 2 12" />
                          <polyline points="22 6 11 17" />
                        </svg>
                        <!-- Blue double tick: read -->
                        <svg v-else-if="msg.status === 'read'" class="w-4 h-4 text-sky-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                          <polyline points="18 6 7 17 2 12" />
                          <polyline points="22 6 11 17" />
                        </svg>
                      </template>
                    </div>
                  </div>
                </div>

                <!-- Typing indicator -->
                <div v-if="dmStore.isTyping" class="flex justify-start">
                  <div class="bg-muted rounded-2xl rounded-bl-md px-4 py-2">
                    <div class="flex items-center gap-1">
                      <div class="w-2 h-2 bg-muted-foreground/50 rounded-full animate-bounce" style="animation-delay: 0ms" />
                      <div class="w-2 h-2 bg-muted-foreground/50 rounded-full animate-bounce" style="animation-delay: 150ms" />
                      <div class="w-2 h-2 bg-muted-foreground/50 rounded-full animate-bounce" style="animation-delay: 300ms" />
                    </div>
                  </div>
                </div>
              </template>
            </div>

            <!-- Input Area -->
            <div class="border-t border-border p-3">
              <form @submit.prevent="handleSend" class="flex items-end gap-2">
                <div class="flex-1 relative">
                  <textarea
                    ref="messageInput"
                    v-model="newMessage"
                    @keydown.enter.exact.prevent="handleSend"
                    @input="onTyping"
                    placeholder="Type a message..."
                    rows="1"
                    class="w-full px-4 py-2.5 text-sm bg-muted/50 border border-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 text-foreground placeholder:text-muted-foreground resize-none max-h-32 overflow-y-auto"
                  />
                </div>
                <Button
                  type="submit"
                  size="icon"
                  :disabled="!newMessage.trim() || sending"
                  class="rounded-xl h-10 w-10 flex-shrink-0"
                >
                  <IconSend class="size-4" />
                </Button>
              </form>
            </div>
          </template>
        </div>
      </div>
    </div>

    <!-- New Chat Dialog -->
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="showNewChat" class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <div class="fixed inset-0 bg-black/50" @click="showNewChat = false" />
          <div class="relative bg-card border border-border rounded-xl shadow-xl w-full max-w-md max-h-[70vh] flex flex-col z-10">
            <div class="flex items-center justify-between p-4 border-b border-border">
              <h3 class="font-semibold text-foreground">New Conversation</h3>
              <button @click="showNewChat = false" class="p-1 hover:bg-muted rounded-md">
                <IconX class="size-4 text-muted-foreground" />
              </button>
            </div>

            <!-- Search users -->
            <div class="p-4 border-b border-border">
              <div class="relative">
                <IconSearch class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-muted-foreground" />
                <input
                  v-model="userSearch"
                  @input="searchUsers"
                  type="text"
                  placeholder="Search users..."
                  class="w-full pl-9 pr-3 py-2 text-sm bg-muted/50 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary/30 text-foreground placeholder:text-muted-foreground"
                  autofocus
                />
              </div>
            </div>

            <!-- Online users section -->
            <div class="flex-1 overflow-y-auto">
              <div v-if="dmStore.onlineUsers.length > 0" class="px-4 pt-3 pb-1">
                <p class="text-xs font-medium text-muted-foreground uppercase tracking-wide mb-2">Online Now</p>
              </div>
              <div
                v-for="user in filteredUsers"
                :key="user.id"
                @click="startConversation(user)"
                class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-muted/60 transition"
              >
                <div class="relative">
                  <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-semibold text-xs">
                    {{ getInitials(user.name) }}
                  </div>
                  <span v-if="user.is_online" class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-card rounded-full" />
                </div>
                <div>
                  <p class="text-sm font-medium text-foreground">{{ user.name }}</p>
                  <p class="text-xs text-muted-foreground">{{ user.is_online ? 'Online' : 'Offline' }}</p>
                </div>
              </div>

              <div v-if="filteredUsers.length === 0" class="p-8 text-center text-muted-foreground text-sm">
                {{ userSearch ? 'No users found' : 'No users available' }}
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, computed, watch, nextTick, onMounted, onUnmounted } from 'vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { Button } from '@/components/ui/button';
import { useAuthStore } from '@/stores/auth';
import { useDirectMessageStore, type DMConversation, type DMUser } from '@/stores/directMessages';
import {
  IconMessages,
  IconPlus,
  IconSearch,
  IconSend,
  IconX,
} from '@tabler/icons-vue';
import axios from 'axios';

const authStore = useAuthStore();
const dmStore = useDirectMessageStore();

const searchQuery = ref('');
const newMessage = ref('');
const sending = ref(false);
const showNewChat = ref(false);
const userSearch = ref('');
const messagesContainer = ref<HTMLElement | null>(null);
const messageInput = ref<HTMLTextAreaElement | null>(null);

let typingTimeout: ReturnType<typeof setTimeout> | null = null;

// Filtered conversations
const filteredConversations = computed(() => {
  if (!searchQuery.value.trim()) return dmStore.conversations;
  const q = searchQuery.value.toLowerCase();
  return dmStore.conversations.filter(c =>
    c.partner?.name?.toLowerCase().includes(q)
  );
});

// Available users for new chat
const filteredUsers = computed(() => {
  const currentId = authStore.user?.id;
  let users = dmStore.onlineUsers.filter(u => u.id !== currentId);
  if (userSearch.value.trim()) {
    const q = userSearch.value.toLowerCase();
    users = users.filter(u => u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q));
  }
  // Sort: online first
  return users.sort((a, b) => (b.is_online ? 1 : 0) - (a.is_online ? 1 : 0));
});

function selectConversation(conv: DMConversation) {
  dmStore.setActiveConversation(conv);
}

async function handleSend() {
  if (!newMessage.value.trim() || sending.value) return;
  const partnerId = dmStore.activeConversation?.partner?.id;
  if (!partnerId) return;

  sending.value = true;
  try {
    await dmStore.sendMessage(partnerId, newMessage.value.trim());
    newMessage.value = '';
    nextTick(() => scrollToBottom());
  } finally {
    sending.value = false;
  }
}

function onTyping() {
  if (!dmStore.activeConversation) return;
  dmStore.emitTyping(dmStore.activeConversation.id, authStore.user?.name || 'User', true);
  if (typingTimeout) clearTimeout(typingTimeout);
  typingTimeout = setTimeout(() => {
    if (dmStore.activeConversation) {
      dmStore.emitTyping(dmStore.activeConversation.id, authStore.user?.name || 'User', false);
    }
  }, 2000);
}

async function startConversation(user: DMUser) {
  // Check if conversation exists
  const existing = dmStore.conversations.find(c => c.partner?.id === user.id);
  if (existing) {
    dmStore.setActiveConversation(existing);
    showNewChat.value = false;
    return;
  }
  // Send an initial empty fetch to create or find conversation
  showNewChat.value = false;
  try {
    await dmStore.sendMessage(user.id, 'Hi!');
    await dmStore.fetchConversations();
    const newConv = dmStore.conversations.find(c => c.partner?.id === user.id);
    if (newConv) dmStore.setActiveConversation(newConv);
  } catch {
    // ignore
  }
}

async function searchUsers() {
  // Refetch online users when searching
  await dmStore.fetchOnlineUsers();
}

function scrollToBottom() {
  if (messagesContainer.value) {
    messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
  }
}

function getInitials(name?: string): string {
  if (!name) return '?';
  return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
}

function formatTime(dateStr?: string | null): string {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  const now = new Date();
  const diff = now.getTime() - d.getTime();
  const mins = Math.floor(diff / 60000);
  if (mins < 1) return 'Just now';
  if (mins < 60) return `${mins}m`;
  const hrs = Math.floor(mins / 60);
  if (hrs < 24) return `${hrs}h`;
  const days = Math.floor(hrs / 24);
  if (days < 7) return `${days}d`;
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
}

function formatMsgTime(dateStr: string): string {
  return new Date(dateStr).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
}

// Watch for new messages to scroll
watch(() => dmStore.messages.length, () => {
  nextTick(() => scrollToBottom());
});

onMounted(() => {
  const userId = authStore.user?.id;
  if (userId) {
    dmStore.initSocket(userId);
    dmStore.fetchConversations();
    dmStore.fetchOnlineUsers();
  }
});

onUnmounted(() => {
  if (typingTimeout) clearTimeout(typingTimeout);
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

textarea {
  field-sizing: content;
}
</style>
