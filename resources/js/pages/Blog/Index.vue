<template>
  <PublicLayout>
    <!-- Hero Section -->
    <section class="py-16 md:py-20 bg-muted/30 border-b border-border">
      <div class="container mx-auto px-6">
        <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Blog</p>
        <h1 class="text-2xl md:text-3xl font-bold text-foreground mb-3">Insights & Articles</h1>
        <p class="text-muted-foreground text-sm max-w-2xl">Industry news, tutorials, and insights from the world of technology.</p>
      </div>
    </section>

    <!-- Filters -->
    <section class="py-4 border-b border-border">
      <div class="container mx-auto px-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div class="flex flex-wrap gap-2">
            <button
              @click="selectedCategory = ''"
              :class="[
                'px-4 py-1.5 rounded-full text-xs font-medium transition-all',
                !selectedCategory
                  ? 'bg-primary text-white'
                  : 'bg-card text-muted-foreground hover:text-foreground border border-border'
              ]"
            >
              All
            </button>
            <button
              v-for="category in categories"
              :key="category"
              @click="selectedCategory = category"
              :class="[
                'px-4 py-1.5 rounded-full text-xs font-medium transition-all',
                selectedCategory === category
                  ? 'bg-primary text-white'
                  : 'bg-card text-muted-foreground hover:text-foreground border border-border'
              ]"
            >
              {{ category }}
            </button>
          </div>

          <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <circle cx="11" cy="11" r="8" />
              <path d="m21 21-4.35-4.35" />
            </svg>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search articles..."
              class="pl-10 pr-4 py-1.5 bg-card border border-border rounded-md text-foreground placeholder-muted-foreground text-xs focus:outline-none focus:border-primary transition w-56"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Blog Grid -->
    <section class="py-12">
      <div class="container mx-auto px-6">
        <div v-if="loading" class="text-center py-16">
          <div class="inline-block w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
          <p class="text-muted-foreground text-sm mt-3">Loading articles...</p>
        </div>

        <div v-else-if="blogs.length === 0" class="text-center py-16">
          <p class="text-muted-foreground text-sm">No articles found.</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <router-link
            v-for="blog in blogs"
            :key="blog.id"
            :to="`/blog/${blog.slug}`"
            class="group bg-card border border-border rounded-lg overflow-hidden hover:border-primary/30 hover:shadow-md transition-all duration-300"
          >
            <!-- Thumbnail -->
            <div class="aspect-[16/10] bg-muted overflow-hidden">
              <img
                v-if="blog.featured_image"
                :src="blog.featured_image.startsWith('http') ? blog.featured_image : `/storage/${blog.featured_image}`"
                :alt="blog.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/20 to-accent/20">
                <svg class="w-12 h-12 text-primary/40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
              </div>
            </div>

            <!-- Content -->
            <div class="p-5">
              <div class="flex items-center gap-2 mb-2">
                <span v-if="blog.category" class="text-[10px] font-medium text-primary bg-primary/10 px-2 py-0.5 rounded">
                  {{ blog.category }}
                </span>
                <span class="text-[10px] text-muted-foreground">
                  {{ formatDate(blog.published_at) }}
                </span>
              </div>
              <h3 class="text-sm font-semibold text-foreground mb-1.5 group-hover:text-primary transition-colors line-clamp-2">
                {{ blog.title }}
              </h3>
              <p class="text-muted-foreground text-xs line-clamp-2 mb-3">
                {{ blog.excerpt }}
              </p>
              <span class="text-primary text-xs font-medium">Read More &rarr;</span>
            </div>
          </router-link>
        </div>

        <!-- Pagination -->
        <div v-if="totalPages > 1" class="flex justify-center mt-10 gap-1.5">
          <button
            v-for="page in totalPages"
            :key="page"
            @click="currentPage = page"
            :class="[
              'w-8 h-8 rounded text-xs font-medium transition',
              currentPage === page
                ? 'bg-primary text-white'
                : 'bg-card text-muted-foreground border border-border hover:border-primary'
            ]"
          >
            {{ page }}
          </button>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import PublicLayout from '@/layouts/PublicLayout.vue';

interface Blog {
  id: number;
  title: string;
  slug: string;
  excerpt: string;
  featured_image: string | null;
  category: string | null;
  published_at: string;
  author?: { name: string };
}

const blogs = ref<Blog[]>([]);
const categories = ref<string[]>([]);
const selectedCategory = ref('');
const searchQuery = ref('');
const currentPage = ref(1);
const totalPages = ref(1);
const loading = ref(true);

async function fetchBlogs() {
  loading.value = true;
  try {
    const params: Record<string, any> = { page: currentPage.value };
    if (selectedCategory.value) params.category = selectedCategory.value;
    if (searchQuery.value) params.search = searchQuery.value;

    const response = await axios.get('/api/v1/blogs', { params });
    blogs.value = response.data.data || [];
    totalPages.value = response.data.last_page || 1;
  } catch (err) {
    console.error('Failed to fetch blogs:', err);
  } finally {
    loading.value = false;
  }
}

async function fetchCategories() {
  try {
    const response = await axios.get('/api/v1/blogs/categories');
    categories.value = response.data.categories || [];
  } catch {
    // Silently fail
  }
}

function formatDate(date: string) {
  if (!date) return '';
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
}

// Debounced search
let searchTimeout: ReturnType<typeof setTimeout>;
watch(searchQuery, () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    currentPage.value = 1;
    fetchBlogs();
  }, 400);
});

watch(selectedCategory, () => {
  currentPage.value = 1;
  fetchBlogs();
});

watch(currentPage, fetchBlogs);

onMounted(() => {
  fetchBlogs();
  fetchCategories();
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
