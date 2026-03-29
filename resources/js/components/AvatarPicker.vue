<template>
  <div class="space-y-4">
    <!-- Current Avatar Preview -->
    <div class="flex items-center gap-4">
      <div class="relative group">
        <div class="w-20 h-20 rounded-2xl overflow-hidden ring-2 ring-primary/10 ring-offset-2 ring-offset-background">
          <img
            :src="selectedAvatar || currentAvatar || defaultAvatar"
            :alt="userName"
            class="w-full h-full object-cover"
          />
        </div>
        <button
          v-if="selectedAvatar || currentAvatar"
          @click="clearSelection"
          class="absolute -top-1 -right-1 w-6 h-6 bg-destructive text-destructive-foreground rounded-full flex items-center justify-center text-xs shadow-md hover:bg-destructive/90 transition"
        >
          ×
        </button>
      </div>
      <div class="flex-1">
        <h4 class="text-sm font-medium text-foreground">Profile Avatar</h4>
        <p class="text-xs text-muted-foreground">Upload your own image or choose from our animal avatars</p>
      </div>
    </div>

    <!-- Tabs: Upload / Choose -->
    <div class="flex gap-2 border-b border-border">
      <button
        @click="activeTab = 'upload'"
        :class="['px-4 py-2 text-sm font-medium border-b-2 transition', activeTab === 'upload' ? 'border-primary text-primary' : 'border-transparent text-muted-foreground hover:text-foreground']"
      >
        Upload Image
      </button>
      <button
        @click="activeTab = 'animals'"
        :class="['px-4 py-2 text-sm font-medium border-b-2 transition', activeTab === 'animals' ? 'border-primary text-primary' : 'border-transparent text-muted-foreground hover:text-foreground']"
      >
        Animal Avatars
      </button>
    </div>

    <!-- Upload Tab -->
    <div v-if="activeTab === 'upload'" class="space-y-3">
      <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-border rounded-xl cursor-pointer hover:border-primary/50 hover:bg-muted/30 transition">
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
          <svg class="w-8 h-8 mb-2 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
          </svg>
          <p class="text-sm text-muted-foreground">Click to upload or drag and drop</p>
          <p class="text-xs text-muted-foreground mt-1">PNG, JPG, GIF up to 5MB</p>
        </div>
        <input type="file" accept="image/*" class="hidden" @change="handleFileSelect" />
      </label>
    </div>

    <!-- Animal Avatars Tab -->
    <div v-if="activeTab === 'animals'" class="space-y-3">
      <div class="grid grid-cols-5 sm:grid-cols-8 gap-2">
        <button
          v-for="avatar in animalAvatars"
          :key="avatar.id"
          @click="selectAvatar(avatar.url)"
          :class="[
            'relative p-1 rounded-xl border-2 transition-all hover:scale-105',
            selectedAvatar === avatar.url ? 'border-primary ring-2 ring-primary/30' : 'border-transparent hover:border-primary/30'
          ]"
        >
          <img
            :src="avatar.url"
            :alt="avatar.name"
            class="w-12 h-12 rounded-lg object-cover"
          />
          <span v-if="selectedAvatar === avatar.url" class="absolute -top-1 -right-1 w-4 h-4 bg-primary text-white rounded-full flex items-center justify-center text-[10px]">
            ✓
          </span>
        </button>
      </div>
    </div>

    <!-- Action Buttons -->
    <div v-if="selectedAvatar" class="flex gap-2 pt-2">
      <button
        @click="confirmSelection"
        class="flex-1 bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition"
      >
        Use This Avatar
      </button>
      <button
        @click="clearSelection"
        class="px-4 py-2 border border-border text-muted-foreground font-medium text-sm rounded-lg hover:border-primary/30 transition"
      >
        Cancel
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';

const props = defineProps<{
  currentAvatar?: string;
  userName?: string;
}>();

const emit = defineEmits<{
  (e: 'select', url: string): void;
  (e: 'upload', file: File): void;
  (e: 'remove'): void;
}>();

const activeTab = ref<'upload' | 'animals'>('animals');
const selectedAvatar = ref<string | null>(null);

// Generate default avatar URL
const defaultAvatar = computed(() => {
  const name = props.userName || 'User';
  return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=6366f1&color=fff&size=96`;
});

// Animal avatars - using DiceBear API for consistent, professional avatars
const animalAvatars = [
  // DiceBear Adventurer-Neutral style with animal-like appearances
  { id: 'cat', name: 'Cat', url: 'https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=Felix&backgroundColor=b6e3f4' },
  { id: 'dog', name: 'Dog', url: 'https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=Buddy&backgroundColor=c0aede' },
  { id: 'rabbit', name: 'Rabbit', url: 'https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=Bunny&backgroundColor=d1d4f9' },
  { id: 'bear', name: 'Bear', url: 'https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=Bear&backgroundColor=ffd5dc' },
  { id: 'bird', name: 'Bird', url: 'https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=Tweety&backgroundColor=ffdfbf' },
  { id: 'fish', name: 'Fish', url: 'https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=Nemo&backgroundColor=b6e3f4' },
  { id: 'fox', name: 'Fox', url: 'https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=Foxy&backgroundColor=ffd5dc' },
  { id: 'owl', name: 'Owl', url: 'https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=Owl&backgroundColor=c0aede' },
  // More animal-themed avatars using different styles
  { id: 'lion', name: 'Lion', url: 'https://api.dicebear.com/7.x/bottts/svg?seed=Lion&backgroundColor=ffdfbf' },
  { id: 'tiger', name: 'Tiger', url: 'https://api.dicebear.com/7.x/bottts/svg?seed=Tiger&backgroundColor=ffd5dc' },
  { id: 'elephant', name: 'Elephant', url: 'https://api.dicebear.com/7.x/bottts/svg?seed=Elephant&backgroundColor=d1d4f9' },
  { id: 'monkey', name: 'Monkey', url: 'https://api.dicebear.com/7.x/bottts/svg?seed=Monkey&backgroundColor=c0aede' },
  { id: 'panda', name: 'Panda', url: 'https://api.dicebear.com/7.x/bottts/svg?seed=Panda&backgroundColor=b6e3f4' },
  { id: 'wolf', name: 'Wolf', url: 'https://api.dicebear.com/7.x/bottts/svg?seed=Wolf&backgroundColor=d1d4f9' },
  { id: 'deer', name: 'Deer', url: 'https://api.dicebear.com/7.x/bottts/svg?seed=Deer&backgroundColor=ffdfbf' },
  { id: 'penguin', name: 'Penguin', url: 'https://api.dicebear.com/7.x/bottts/svg?seed=Penguin&backgroundColor=b6e3f4' },
  // Fun avatars using shapes style
  { id: 'koala', name: 'Koala', url: 'https://api.dicebear.com/7.x/fun-emoji/svg?seed=Koala' },
  { id: 'giraffe', name: 'Giraffe', url: 'https://api.dicebear.com/7.x/fun-emoji/svg?seed=Giraffe' },
  { id: 'zebra', name: 'Zebra', url: 'https://api.dicebear.com/7.x/fun-emoji/svg?seed=Zebra' },
  { id: 'hippo', name: 'Hippo', url: 'https://api.dicebear.com/7.x/fun-emoji/svg?seed=Hippo' },
  { id: 'dolphin', name: 'Dolphin', url: 'https://api.dicebear.com/7.x/fun-emoji/svg?seed=Dolphin' },
  { id: 'turtle', name: 'Turtle', url: 'https://api.dicebear.com/7.x/fun-emoji/svg?seed=Turtle' },
  { id: 'unicorn', name: 'Unicorn', url: 'https://api.dicebear.com/7.x/fun-emoji/svg?seed=Unicorn' },
  { id: 'dragon', name: 'Dragon', url: 'https://api.dicebear.com/7.x/fun-emoji/svg?seed=Dragon' },
];

function selectAvatar(url: string) {
  selectedAvatar.value = url;
}

function handleFileSelect(event: Event) {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (!file) return;
  
  // Validate file size (5MB max)
  if (file.size > 5 * 1024 * 1024) {
    alert('File too large. Maximum size is 5MB.');
    return;
  }
  
  // Create preview
  const url = URL.createObjectURL(file);
  selectedAvatar.value = url;
  
  // Emit the file for upload
  emit('upload', file);
}

function confirmSelection() {
  if (selectedAvatar.value) {
    emit('select', selectedAvatar.value);
  }
}

function clearSelection() {
  if (selectedAvatar.value?.startsWith('blob:')) {
    URL.revokeObjectURL(selectedAvatar.value);
  }
  selectedAvatar.value = null;
}
</script>
