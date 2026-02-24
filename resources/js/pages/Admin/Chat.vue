<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-3xl font-display font-bold text-foreground mb-2">Chat Management</h1>
        <p class="text-muted-foreground">Monitor and manage customer chat conversations</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-card border border-border rounded-lg p-6">
          <p class="text-muted-foreground text-sm mb-1">Total Sessions</p>
          <p class="text-3xl font-bold text-foreground">{{ stats.total_sessions }}</p>
        </div>
        <div class="bg-card border border-border rounded-lg p-6">
          <p class="text-muted-foreground text-sm mb-1">Open</p>
          <p class="text-3xl font-bold text-green-400">{{ stats.open_sessions }}</p>
        </div>
        <div class="bg-card border border-border rounded-lg p-6">
          <p class="text-muted-foreground text-sm mb-1">Closed</p>
          <p class="text-3xl font-bold text-muted-foreground">{{ stats.closed_sessions }}</p>
        </div>
        <div class="bg-card border border-border rounded-lg p-6">
          <p class="text-muted-foreground text-sm mb-1">Unread Messages</p>
          <p class="text-3xl font-bold text-amber-400">{{ stats.unread_messages }}</p>
        </div>
      </div>

      <!-- Two-Panel Layout -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" style="min-height: 600px;">
        <!-- Left Panel: Session List -->
        <div class="lg:col-span-1 bg-card border border-border rounded-lg flex flex-col overflow-hidden">
          <!-- Status Filter -->
          <div class="p-4 border-b border-border">
            <div class="flex gap-2">
              <button
                v-for="f in statusFilters"
                :key="f.value"
                @click="setStatusFilter(f.value)"
                :class="[
                  'px-3 py-1.5 rounded-md text-sm font-medium transition',
                  statusFilter === f.value
                    ? 'bg-primary text-primary-foreground'
                    : 'bg-muted text-muted-foreground hover:bg-muted/80'
                ]"
              >
                {{ f.label }}
              </button>
            </div>
          </div>

          <!-- Sessions List -->
          <div class="flex-1 overflow-y-auto divide-y divide-border">
            <!-- Loading -->
            <div v-if="sessionsLoading" class="p-8 text-center text-muted-foreground">
              <svg class="animate-spin h-6 w-6 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
              </svg>
              Loading sessions…
            </div>

            <!-- Error -->
            <div v-else-if="sessionsError" class="p-8 text-center text-red-400">
              <p class="mb-2">Failed to load sessions.</p>
              <button @click="fetchSessions" class="text-primary underline text-sm">Retry</button>
            </div>

            <!-- Empty -->
            <div v-else-if="sessions.length === 0" class="p-8 text-center text-muted-foreground">
              No chat sessions found.
            </div>

            <!-- Session Items -->
            <div
              v-else
              v-for="session in sessions"
              :key="session.id"
              @click="selectSession(session)"
              :class="[
                'p-4 cursor-pointer transition hover:bg-muted/20',
                selectedSession?.id === session.id ? 'bg-muted/30 border-l-2 border-l-primary' : ''
              ]"
            >
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-foreground font-bold text-sm shrink-0 relative">
                  {{ session.user?.name?.charAt(0) ?? '?' }}
                  <span
                    v-if="session.status === 'open'"
                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-card"
                  ></span>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between gap-2 mb-0.5">
                    <h3 class="text-foreground font-semibold text-sm truncate">{{ session.user?.name ?? 'Unknown' }}</h3>
                    <span class="text-xs text-muted-foreground whitespace-nowrap">{{ formatDate(session.created_at) }}</span>
                  </div>
                  <p class="text-muted-foreground text-xs truncate mb-1.5">{{ session.subject || 'No subject' }}</p>
                  <div class="flex items-center gap-2">
                    <span :class="[
                      'px-2 py-0.5 rounded text-xs font-semibold',
                      session.status === 'open' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-muted-foreground'
                    ]">
                      {{ session.status }}
                    </span>
                    <span
                      v-if="session.unread_count > 0"
                      class="px-2 py-0.5 bg-primary/20 text-primary rounded-full text-xs font-semibold"
                    >
                      {{ session.unread_count }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Panel: Message Thread -->
        <div class="lg:col-span-2 bg-card border border-border rounded-lg flex flex-col overflow-hidden">
          <!-- No session selected -->
          <div v-if="!selectedSession" class="flex-1 flex items-center justify-center text-muted-foreground">
            <div class="text-center">
              <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
              </svg>
              <p>Select a conversation to view messages</p>
            </div>
          </div>

          <template v-else>
            <!-- Thread Header -->
            <div class="p-4 border-b border-border flex items-center justify-between">
              <div>
                <h2 class="text-foreground font-semibold">{{ selectedSession.user?.name ?? 'Unknown' }}</h2>
                <p class="text-xs text-muted-foreground">{{ selectedSession.subject || 'No subject' }}</p>
              </div>
              <div class="flex items-center gap-2">
                <span :class="[
                  'px-2 py-1 rounded text-xs font-semibold',
                  selectedSession.status === 'open' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-muted-foreground'
                ]">
                  {{ selectedSession.status }}
                </span>
                <button
                  v-if="selectedSession.status === 'open'"
                  @click="closeSession"
                  :disabled="closingSession"
                  class="px-3 py-1.5 bg-red-500/20 text-red-400 hover:bg-red-500/30 rounded-md text-xs font-medium transition disabled:opacity-50"
                >
                  {{ closingSession ? 'Closing…' : 'Close Session' }}
                </button>
              </div>
            </div>

            <!-- Messages Area -->
            <div ref="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4">
              <!-- Messages Loading -->
              <div v-if="messagesLoading" class="flex items-center justify-center h-full text-muted-foreground">
                <svg class="animate-spin h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                Loading messages…
              </div>

              <!-- Messages Error -->
              <div v-else-if="messagesError" class="flex items-center justify-center h-full text-red-400">
                <div class="text-center">
                  <p class="mb-2">Failed to load messages.</p>
                  <button @click="fetchMessages(selectedSession!.id)" class="text-primary underline text-sm">Retry</button>
                </div>
              </div>

              <!-- No messages -->
              <div v-else-if="messages.length === 0" class="flex items-center justify-center h-full text-muted-foreground">
                No messages yet.
              </div>

              <!-- Message bubbles -->
              <template v-else>
                <div
                  v-for="msg in messages"
                  :key="msg.id"
                  :class="[
                    'flex',
                    msg.sender_type === 'admin' ? 'justify-end' : 'justify-start'
                  ]"
                >
                  <div
                    :class="[
                      'max-w-[75%] rounded-lg px-4 py-2.5',
                      msg.sender_type === 'admin'
                        ? 'bg-primary text-primary-foreground rounded-br-sm'
                        : 'bg-muted text-foreground rounded-bl-sm'
                    ]"
                  >
                    <p class="text-xs font-semibold mb-1 opacity-70">
                      {{ msg.sender?.name ?? (msg.sender_type === 'admin' ? 'Admin' : 'User') }}
                    </p>
                    <p class="text-sm whitespace-pre-wrap break-words">{{ msg.message }}</p>
                    <p :class="[
                      'text-xs mt-1',
                      msg.sender_type === 'admin' ? 'text-primary-foreground/60' : 'text-muted-foreground'
                    ]">
                      {{ formatTime(msg.created_at) }}
                    </p>
                  </div>
                </div>
              </template>
            </div>

            <!-- Reply Input -->
            <div v-if="selectedSession.status === 'open'" class="p-4 border-t border-border">
              <form @submit.prevent="sendReply" class="flex gap-3">
                <input
                  v-model="replyText"
                  type="text"
                  placeholder="Type your reply…"
                  class="flex-1 bg-muted border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50"
                  :disabled="sendingReply"
                />
                <button
                  type="submit"
                  :disabled="!replyText.trim() || sendingReply"
                  class="px-5 py-2.5 bg-primary text-primary-foreground rounded-lg font-medium text-sm hover:bg-primary/90 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ sendingReply ? 'Sending…' : 'Send' }}
                </button>
              </form>
            </div>

            <!-- Closed notice -->
            <div v-else class="p-4 border-t border-border text-center text-muted-foreground text-sm">
              This session is closed. No further replies can be sent.
            </div>
          </template>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';

// ── Types ───────────────────────────────────────────────────────────
interface User {
  id: number;
  name: string;
  email?: string;
}

interface ChatSession {
  id: number;
  user_id: number;
  subject: string | null;
  status: 'open' | 'closed';
  assigned_admin_id: number | null;
  created_at: string;
  user?: User;
  assigned_admin?: User;
  unread_count: number;
}

interface ChatMessage {
  id: number;
  chat_session_id: number;
  sender_id: number;
  sender_type: 'user' | 'admin';
  message: string;
  is_read: boolean;
  created_at: string;
  sender?: User;
}

interface Stats {
  total_sessions: number;
  open_sessions: number;
  closed_sessions: number;
  unread_messages: number;
}

// ── Composables ─────────────────────────────────────────────────────
const { get, post } = useApi();
const toast = useToast();

// ── State ───────────────────────────────────────────────────────────
const stats = ref<Stats>({ total_sessions: 0, open_sessions: 0, closed_sessions: 0, unread_messages: 0 });

const sessions = ref<ChatSession[]>([]);
const sessionsLoading = ref(false);
const sessionsError = ref(false);

const statusFilter = ref<string>('');
const statusFilters = [
  { label: 'All', value: '' },
  { label: 'Open', value: 'open' },
  { label: 'Closed', value: 'closed' },
];

const selectedSession = ref<ChatSession | null>(null);

const messages = ref<ChatMessage[]>([]);
const messagesLoading = ref(false);
const messagesError = ref(false);
const messagesContainer = ref<HTMLElement | null>(null);

const replyText = ref('');
const sendingReply = ref(false);
const closingSession = ref(false);

// ── Helpers ─────────────────────────────────────────────────────────
function formatDate(dateStr: string): string {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  const now = new Date();
  const diff = now.getTime() - d.getTime();
  const mins = Math.floor(diff / 60000);
  if (mins < 1) return 'Just now';
  if (mins < 60) return `${mins}m ago`;
  const hours = Math.floor(mins / 60);
  if (hours < 24) return `${hours}h ago`;
  const days = Math.floor(hours / 24);
  if (days < 7) return `${days}d ago`;
  return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
}

function formatTime(dateStr: string): string {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
}

function scrollToBottom() {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
  });
}

// ── API Calls ───────────────────────────────────────────────────────
async function fetchStats() {
  try {
    const data = await get<Stats>('/admin/chat/stats');
    stats.value = data;
  } catch {
    // Silently fail — stats are non-critical
  }
}

async function fetchSessions() {
  sessionsLoading.value = true;
  sessionsError.value = false;
  try {
    const params: Record<string, string> = {};
    if (statusFilter.value) params.status = statusFilter.value;
    const data = await get<any>('/admin/chat/sessions', { params });
    sessions.value = data.data ?? data;
  } catch {
    sessionsError.value = true;
  } finally {
    sessionsLoading.value = false;
  }
}

async function fetchMessages(sessionId: number) {
  messagesLoading.value = true;
  messagesError.value = false;
  messages.value = [];
  try {
    const data = await get<any>(`/admin/chat/sessions/${sessionId}/messages`);
    messages.value = data.data ?? data;
    scrollToBottom();

    // Refresh stats since reading marks messages as read
    fetchStats();

    // Update unread count for the selected session locally
    const idx = sessions.value.findIndex((s) => s.id === sessionId);
    if (idx !== -1) sessions.value[idx].unread_count = 0;
  } catch {
    messagesError.value = true;
  } finally {
    messagesLoading.value = false;
  }
}

async function selectSession(session: ChatSession) {
  selectedSession.value = session;
  await fetchMessages(session.id);
}

function setStatusFilter(value: string) {
  statusFilter.value = value;
  selectedSession.value = null;
  messages.value = [];
  fetchSessions();
}

async function sendReply() {
  if (!replyText.value.trim() || !selectedSession.value) return;
  sendingReply.value = true;
  try {
    const data = await post<ChatMessage>(`/admin/chat/sessions/${selectedSession.value.id}/reply`, {
      message: replyText.value.trim(),
    });
    messages.value.push(data.data ?? data);
    replyText.value = '';
    scrollToBottom();
    toast.success('Reply sent');
  } catch {
    toast.error('Failed to send reply', 'Please try again.');
  } finally {
    sendingReply.value = false;
  }
}

async function closeSession() {
  if (!selectedSession.value) return;
  closingSession.value = true;
  try {
    await post(`/admin/chat/sessions/${selectedSession.value.id}/close`);
    selectedSession.value.status = 'closed';
    // Update in list
    const idx = sessions.value.findIndex((s) => s.id === selectedSession.value!.id);
    if (idx !== -1) sessions.value[idx].status = 'closed';
    toast.success('Session closed');
    fetchStats();
  } catch {
    toast.error('Failed to close session', 'Please try again.');
  } finally {
    closingSession.value = false;
  }
}

// ── Init ────────────────────────────────────────────────────────────
onMounted(() => {
  fetchStats();
  fetchSessions();
});
</script>
