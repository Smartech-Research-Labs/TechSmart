<template>
  <div class="space-y-2">
    <Label v-if="label" :for="fieldId">{{ label }}</Label>
    <p v-if="description" class="text-xs text-muted-foreground">{{ description }}</p>

    <!-- Preview -->
    <div v-if="modelValue" class="relative group">
      <img :src="modelValue" :alt="label || 'Image'" class="w-full h-32 object-cover rounded-lg border border-border" />
      <button
        @click="$emit('update:modelValue', '')"
        class="absolute top-2 right-2 bg-red-500/90 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition"
        title="Remove image"
      >
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" /></svg>
      </button>
    </div>

    <!-- URL input + actions -->
    <div class="flex gap-2">
      <Input
        :id="fieldId"
        :value="modelValue"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
        placeholder="Enter image URL or use buttons below..."
        class="flex-1"
      />
    </div>

    <div class="flex gap-2">
      <button
        type="button"
        @click="triggerUpload"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium border border-border rounded-md hover:bg-muted transition text-foreground"
      >
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" />
        </svg>
        Upload
      </button>
      <button
        type="button"
        @click="showGallery = true"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium border border-border rounded-md hover:bg-muted transition text-foreground"
      >
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
          <circle cx="8.5" cy="8.5" r="1.5" />
          <polyline points="21 15 16 10 5 21" />
        </svg>
        Gallery
      </button>
      <span v-if="uploading" class="text-xs text-muted-foreground flex items-center gap-1">
        <svg class="animate-spin w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
        </svg>
        Uploading...
      </span>
    </div>

    <!-- Hidden file input -->
    <input
      ref="fileInput"
      type="file"
      accept="image/png,image/jpeg,image/jpg,image/webp,image/gif,image/svg+xml"
      class="hidden"
      @change="handleFileSelect"
    />

    <!-- Gallery Modal -->
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="showGallery" class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <div class="fixed inset-0 bg-black/50" @click="showGallery = false" />
          <div class="relative bg-card border border-border rounded-xl shadow-xl w-full max-w-3xl max-h-[80vh] flex flex-col z-10">
            <div class="flex items-center justify-between p-4 border-b border-border">
              <h3 class="font-semibold text-foreground">Media Gallery</h3>
              <button @click="showGallery = false" class="p-1 hover:bg-muted rounded-md">
                <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4">
              <!-- Loading -->
              <div v-if="galleryLoading" class="flex items-center justify-center py-12">
                <svg class="animate-spin h-6 w-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
              </div>

              <!-- Empty -->
              <div v-else-if="galleryImages.length === 0" class="text-center py-12 text-muted-foreground">
                <p class="text-sm">No images uploaded yet.</p>
                <button @click="showGallery = false; triggerUpload()" class="text-primary text-sm mt-2 underline">Upload one now</button>
              </div>

              <!-- Grid -->
              <div v-else class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                <div
                  v-for="img in galleryImages"
                  :key="img.path"
                  @click="selectFromGallery(img)"
                  :class="[
                    'relative group cursor-pointer rounded-lg overflow-hidden border-2 transition aspect-square',
                    modelValue === img.url ? 'border-primary ring-2 ring-primary/30' : 'border-border hover:border-primary/50'
                  ]"
                >
                  <img :src="img.url" :alt="img.name" class="w-full h-full object-cover" />
                  <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition" />
                  <div v-if="modelValue === img.url" class="absolute top-1 right-1 bg-primary text-white rounded-full p-0.5">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12" /></svg>
                  </div>
                  <div class="absolute bottom-0 left-0 right-0 bg-black/60 px-1.5 py-0.5 opacity-0 group-hover:opacity-100 transition">
                    <p class="text-white text-[10px] truncate">{{ img.name }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup lang="ts">
import axios from 'axios';
import { ref, watch } from 'vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface GalleryImage {
  path: string;
  url: string;
  name: string;
  size: number;
  last_modified: number;
}

const props = withDefaults(defineProps<{
  modelValue: string;
  label?: string;
  description?: string;
  fieldId?: string;
  folder?: string;
  convertWebp?: boolean;
}>(), {
  fieldId: () => `img-${Math.random().toString(36).slice(2, 8)}`,
  folder: 'media',
  convertWebp: true,
});

const emit = defineEmits<{
  'update:modelValue': [value: string];
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const uploading = ref(false);
const showGallery = ref(false);
const galleryImages = ref<GalleryImage[]>([]);
const galleryLoading = ref(false);

function triggerUpload() {
  fileInput.value?.click();
}

async function handleFileSelect(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0];
  if (!file) return;

  uploading.value = true;
  try {
    const fd = new FormData();
    fd.append('image', file);
    fd.append('folder', props.folder);
    fd.append('convert_webp', props.convertWebp ? '1' : '0');

    const { data } = await axios.post('/api/v1/admin/media/upload', fd, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });

    emit('update:modelValue', data.url);
  } catch (err: any) {
    console.error('Upload failed:', err);
  } finally {
    uploading.value = false;
    if (fileInput.value) fileInput.value.value = '';
  }
}

function selectFromGallery(img: GalleryImage) {
  emit('update:modelValue', img.url);
  showGallery.value = false;
}

// Fetch gallery when opened
watch(showGallery, async (open) => {
  if (!open || galleryImages.value.length > 0) return;
  galleryLoading.value = true;
  try {
    const { data } = await axios.get('/api/v1/admin/media');
    galleryImages.value = data.images || [];
  } catch {
    // ignore
  } finally {
    galleryLoading.value = false;
  }
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
</style>
