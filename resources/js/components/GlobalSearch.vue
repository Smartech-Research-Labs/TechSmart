<template>
  <Teleport to="body">
    <!-- Backdrop -->
    <Transition
      enter-active-class="transition ease-out duration-150"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="open" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50" @click="close" />
    </Transition>

    <!-- Search Panel -->
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 scale-95 -translate-y-4"
      enter-to-class="opacity-100 scale-100 translate-y-0"
      leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100 scale-100 translate-y-0"
      leave-to-class="opacity-0 scale-95 -translate-y-4"
    >
      <div
        v-if="open"
        class="fixed top-[15%] left-1/2 -translate-x-1/2 w-full max-w-xl bg-popover border border-border rounded-xl shadow-2xl z-50 overflow-hidden"
        @click.stop
      >
        <!-- Search Input -->
        <div class="flex items-center gap-3 px-4 py-3 border-b border-border">
          <IconSearch class="size-5 text-muted-foreground shrink-0" />
          <input
            ref="searchInput"
            v-model="query"
            type="text"
            placeholder="Search users, services, products, blogs..."
            class="flex-1 bg-transparent text-foreground text-sm placeholder:text-muted-foreground focus:outline-none"
            @input="handleSearch"
            @keydown.escape="close"
            @keydown.down.prevent="moveSelection(1)"
            @keydown.up.prevent="moveSelection(-1)"
            @keydown.enter.prevent="selectCurrent"
          />
          <div class="flex items-center gap-1.5 shrink-0">
            <span v-if="loading" class="w-4 h-4 border-2 border-primary border-t-transparent rounded-full animate-spin" />
            <kbd class="hidden sm:inline-flex items-center gap-0.5 px-1.5 py-0.5 text-[10px] font-mono bg-muted text-muted-foreground rounded border border-border">ESC</kbd>
          </div>
        </div>

        <!-- Type Filters -->
        <div class="flex items-center gap-1.5 px-4 py-2 border-b border-border/50 overflow-x-auto">
          <button
            v-for="filter in typeFilters"
            :key="filter.value"
            @click="selectedType = filter.value; handleSearch()"
            :class="[
              'px-2.5 py-1 text-xs rounded-full border transition whitespace-nowrap',
              selectedType === filter.value
                ? 'bg-primary text-primary-foreground border-primary'
                : 'bg-muted/50 text-muted-foreground border-border hover:border-primary/30'
            ]"
          >
            {{ filter.label }}
          </button>
        </div>

        <!-- Results -->
        <div class="max-h-80 overflow-y-auto">
          <!-- No query state - show suggestions -->
          <div v-if="!query.trim() && suggestions.length > 0" class="p-2">
            <p class="text-[10px] uppercase tracking-wider text-muted-foreground px-2 py-1 font-medium">Quick Navigation</p>
            <button
              v-for="(sug, idx) in suggestions"
              :key="sug.url"
              @click="navigateTo(sug.url)"
              :class="[
                'w-full flex items-center gap-3 px-3 py-2 rounded-lg text-left transition',
                selectedIndex === idx ? 'bg-primary/10 text-primary' : 'hover:bg-muted/50 text-foreground'
              ]"
            >
              <span class="text-base">{{ sug.icon }}</span>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium truncate">{{ sug.title }}</p>
                <p class="text-xs text-muted-foreground truncate">{{ sug.description }}</p>
              </div>
            </button>
          </div>

          <!-- Loading -->
          <div v-else-if="loading && !results.length" class="p-6 text-center">
            <div class="w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin mx-auto mb-2" />
            <p class="text-sm text-muted-foreground">Searching...</p>
          </div>

          <!-- No Results -->
          <div v-else-if="query.trim() && !loading && !results.length && hasSearched" class="p-8 text-center">
            <IconSearchOff class="size-10 mx-auto mb-2 text-muted-foreground/30" />
            <p class="text-sm text-muted-foreground">No results found for "{{ query }}"</p>
            <p class="text-xs text-muted-foreground mt-1">Try a different search term or category</p>
          </div>

          <!-- Grouped Results -->
          <div v-else-if="results.length > 0" class="p-2 space-y-1">
            <div v-for="(group, groupIdx) in groupedResults" :key="group.type">
              <p class="text-[10px] uppercase tracking-wider text-muted-foreground px-2 py-1 font-medium flex items-center gap-1.5">
                {{ group.type }}
                <span class="bg-muted px-1.5 rounded-full">{{ group.items.length }}</span>
              </p>
              <button
                v-for="(item, itemIdx) in group.items"
                :key="`${group.type}-${item.id}`"
                @click="navigateToResult(item)"
                :class="[
                  'w-full flex items-center gap-3 px-3 py-2 rounded-lg text-left transition',
                  getFlatIndex(groupIdx, itemIdx) === selectedIndex ? 'bg-primary/10 text-primary' : 'hover:bg-muted/50 text-foreground'
                ]"
              >
                <div :class="['w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-sm', resultBgClass(group.type)]">
                  {{ resultEmoji(group.type) }}
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium truncate" v-html="highlightMatch(item.title, query)" />
                  <p v-if="item.subtitle" class="text-xs text-muted-foreground truncate">{{ item.subtitle }}</p>
                </div>
                <span class="text-[10px] text-muted-foreground bg-muted px-1.5 py-0.5 rounded shrink-0">{{ group.type }}</span>
              </button>
            </div>

            <!-- Total count -->
            <p v-if="totalResults > results.length" class="text-center text-xs text-muted-foreground py-2">
              Showing {{ results.length }} of {{ totalResults }} results
            </p>
          </div>
        </div>

        <!-- Footer -->
        <div class="flex items-center justify-between px-4 py-2 border-t border-border/50 text-[10px] text-muted-foreground">
          <div class="flex items-center gap-3">
            <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 bg-muted rounded border border-border font-mono">↑↓</kbd> Navigate</span>
            <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 bg-muted rounded border border-border font-mono">↵</kbd> Select</span>
            <span class="flex items-center gap-1"><kbd class="px-1 py-0.5 bg-muted rounded border border-border font-mono">esc</kbd> Close</span>
          </div>
          <span>Smartech Search</span>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, computed, watch, nextTick, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import { IconSearch, IconSearchOff } from '@tabler/icons-vue';
import { useApi } from '@/composables/useApi';

const props = defineProps<{ modelValue: boolean }>();
const emit = defineEmits<{ (e: 'update:modelValue', value: boolean): void }>();

const router = useRouter();
const { get } = useApi();

const open = computed({
  get: () => props.modelValue,
  set: (v) => emit('update:modelValue', v),
});

const query = ref('');
const selectedType = ref('all');
const loading = ref(false);
const hasSearched = ref(false);
const selectedIndex = ref(0);
const searchInput = ref<HTMLInputElement | null>(null);

interface SearchResult {
  id: number;
  title: string;
  subtitle?: string;
  type: string;
  url?: string;
}

interface Suggestion {
  title: string;
  description: string;
  url: string;
  icon: string;
}

const results = ref<SearchResult[]>([]);
const totalResults = ref(0);
const suggestions = ref<Suggestion[]>([]);

const typeFilters = [
  { value: 'all', label: 'All' },
  { value: 'users', label: 'Users' },
  { value: 'services', label: 'Services' },
  { value: 'products', label: 'Products' },
  { value: 'pages', label: 'Pages' },
  { value: 'blogs', label: 'Blogs' },
  { value: 'enquiries', label: 'Enquiries' },
];

// Group results by type
const groupedResults = computed(() => {
  const groups: { type: string; items: SearchResult[] }[] = [];
  const map = new Map<string, SearchResult[]>();
  for (const r of results.value) {
    if (!map.has(r.type)) map.set(r.type, []);
    map.get(r.type)!.push(r);
  }
  for (const [type, items] of map) {
    groups.push({ type, items });
  }
  return groups;
});

// Calculate flat index for keyboard navigation
function getFlatIndex(groupIdx: number, itemIdx: number): number {
  let idx = 0;
  for (let g = 0; g < groupIdx; g++) {
    idx += groupedResults.value[g].items.length;
  }
  return idx + itemIdx;
}

// Total flat items count for navigation bounds
const flatItemsCount = computed(() => {
  if (!query.value.trim() && suggestions.value.length) return suggestions.value.length;
  return results.value.length;
});

// Debounced search
let searchTimeout: ReturnType<typeof setTimeout>;
function handleSearch() {
  clearTimeout(searchTimeout);
  selectedIndex.value = 0;
  if (!query.value.trim()) {
    results.value = [];
    hasSearched.value = false;
    return;
  }
  loading.value = true;
  searchTimeout = setTimeout(async () => {
    try {
      const params = new URLSearchParams({ q: query.value, type: selectedType.value });
      const data = await get<any>(`/admin/search?${params}`);
      const payload = (data as any).data ?? data;
      results.value = payload.all ?? [];
      totalResults.value = payload.total ?? results.value.length;
      hasSearched.value = true;
    } catch {
      results.value = [];
    } finally {
      loading.value = false;
    }
  }, 300);
}

// Fetch suggestions on first open
async function fetchSuggestions() {
  try {
    const data = await get<any>('/admin/search/suggestions');
    suggestions.value = (data as any).data ?? data ?? [];
  } catch {
    suggestions.value = [];
  }
}

// Keyboard navigation
function moveSelection(delta: number) {
  const count = flatItemsCount.value;
  if (count === 0) return;
  selectedIndex.value = (selectedIndex.value + delta + count) % count;
}

function selectCurrent() {
  if (!query.value.trim() && suggestions.value.length) {
    const sug = suggestions.value[selectedIndex.value];
    if (sug) navigateTo(sug.url);
    return;
  }
  if (results.value[selectedIndex.value]) {
    navigateToResult(results.value[selectedIndex.value]);
  }
}

function navigateTo(url: string) {
  close();
  router.push(url);
}

function navigateToResult(item: SearchResult) {
  close();
  const typeRoutes: Record<string, string> = {
    user: '/admin/users',
    service: '/admin/services',
    product: '/admin/products',
    page: '/admin/pages',
    blog: '/admin/blogs',
    bundle: '/admin/bundles',
    enquiry: '/admin/enquiries',
  };
  const base = typeRoutes[item.type] || '/admin';
  router.push(base);
}

function close() {
  open.value = false;
  query.value = '';
  results.value = [];
  hasSearched.value = false;
  selectedIndex.value = 0;
}

// Helpers
function resultBgClass(type: string): string {
  const map: Record<string, string> = {
    user: 'bg-blue-500/10', service: 'bg-indigo-500/10', product: 'bg-green-500/10',
    page: 'bg-gray-500/10', blog: 'bg-purple-500/10', bundle: 'bg-teal-500/10', enquiry: 'bg-pink-500/10',
  };
  return map[type] ?? 'bg-muted';
}

function resultEmoji(type: string): string {
  const map: Record<string, string> = {
    user: '👤', service: '🚀', product: '📦',
    page: '📄', blog: '✍️', bundle: '📁', enquiry: '📩',
  };
  return map[type] ?? '🔍';
}

function highlightMatch(text: string, q: string): string {
  if (!q.trim()) return text;
  const escaped = q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  const regex = new RegExp(`(${escaped})`, 'gi');
  return text.replace(regex, '<mark class="bg-primary/20 text-primary rounded px-0.5">$1</mark>');
}

// Global keyboard shortcut
function handleGlobalKeydown(e: KeyboardEvent) {
  if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
    e.preventDefault();
    open.value = !open.value;
  }
}

// Focus input when opened
watch(open, (isOpen) => {
  if (isOpen) {
    nextTick(() => searchInput.value?.focus());
    if (suggestions.value.length === 0) fetchSuggestions();
  }
});

onMounted(() => {
  document.addEventListener('keydown', handleGlobalKeydown);
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleGlobalKeydown);
});
</script>
