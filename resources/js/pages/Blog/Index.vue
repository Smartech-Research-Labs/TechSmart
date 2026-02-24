<template>
  <PublicLayout>
    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-br from-card to-background">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-display font-bold text-foreground mb-4">Our Blog</h1>
        <p class="text-muted-foreground text-lg max-w-2xl mx-auto">
          Insights, tutorials, and news from the world of technology
        </p>
      </div>
    </section>

    <!-- Filters -->
    <section class="py-8 border-b border-border">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <!-- Categories -->
          <div class="flex flex-wrap gap-2">
            <button
              @click="selectedCategory = ''"
              :class="[
                'px-4 py-2 rounded-full text-sm font-medium transition',
                !selectedCategory
                  ? 'bg-primary text-foreground'
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
                'px-4 py-2 rounded-full text-sm font-medium transition',
                selectedCategory === category
                  ? 'bg-primary text-foreground'
                  : 'bg-card text-muted-foreground hover:text-foreground border border-border'
              ]"
            >
              {{ category }}
            </button>
          </div>

          <!-- Search -->
          <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <circle cx="11" cy="11" r="8" />
              <path d="m21 21-4.35-4.35" />
            </svg>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search articles..."
              class="pl-10 pr-4 py-2 bg-card border border-border rounded-lg text-foreground placeholder-muted-foreground text-sm focus:outline-none focus:border-primary transition w-64"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Blog Grid -->
    <section class="py-16">
      <div class="container mx-auto px-4">
        <div v-if="loading" class="text-center py-20">
          <div class="inline-block w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
          <p class="text-muted-foreground mt-4">Loading articles...</p>
        </div>

        <div v-else-if="blogs.length === 0" class="text-center py-20">
          <p class="text-muted-foreground text-lg">No articles found.</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <router-link
            v-for="blog in blogs"
            :key="blog.id"
            :to="`/blog/${blog.slug}`"
            class="group bg-card border border-border rounded-xl overflow-hidden hover:border-primary transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/10"
          >
            <!-- Thumbnail -->
            <div class="aspect-[16/10] bg-card overflow-hidden">
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
            <div class="p-6">
              <div class="flex items-center gap-3 mb-3">
                <span v-if="blog.category" class="px-2.5 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full">
                  {{ blog.category }}
                </span>
                <span class="text-xs text-muted-foreground">
                  {{ formatDate(blog.published_at) }}
                </span>
              </div>
              <h3 class="text-lg font-bold text-foreground mb-2 group-hover:text-primary transition line-clamp-2">
                {{ blog.title }}
              </h3>
              <p class="text-sm text-muted-foreground line-clamp-3 mb-4">
                {{ blog.excerpt }}
              </p>
              <div class="flex items-center justify-between">
                <div v-if="blog.author" class="flex items-center gap-2">
                  <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-xs text-primary font-bold">
                    {{ blog.author.name?.charAt(0) }}
                  </div>
                  <span class="text-xs text-muted-foreground">{{ blog.author.name }}</span>
                </div>
                <span class="text-primary text-sm font-semibold group-hover:translate-x-1 transition-transform">
                  Read More →
                </span>
              </div>
            </div>
          </router-link>
        </div>

        <!-- Pagination -->
        <div v-if="totalPages > 1" class="flex justify-center mt-12 gap-2">
          <button
            v-for="page in totalPages"
            :key="page"
            @click="currentPage = page"
            :class="[
              'w-10 h-10 rounded-lg text-sm font-medium transition',
              currentPage === page
                ? 'bg-primary text-foreground'
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
