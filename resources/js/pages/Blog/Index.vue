<template>
  <PublicLayout>
    <router-link v-if="featured" :to="`/blog/${featured.slug}`" class="blog-feature group">
      <img :src="imageFor(featured)" :alt="featured.title" loading="eager" />
      <span class="blog-feature-shade"></span>
      <span class="blog-feature-copy">
        <span class="blog-feature-label">Featured</span>
        <h1>{{ featured.title }}</h1>
        <span class="blog-feature-excerpt">{{ featured.excerpt }}</span>
      </span>
      <ArrowUpRight class="blog-feature-arrow" :stroke-width="1.5" aria-hidden="true" />
    </router-link>

    <section class="blog-list">
      <div class="container mx-auto px-6">
        <div class="blog-list-head">
          <component :is="featured ? 'h2' : 'h1'">{{ listTitle }}</component>
          <label class="blog-search">
            <Search :size="16" aria-hidden="true" />
            <span class="sr-only">Search articles</span>
            <input v-model="searchQuery" type="search" placeholder="Search articles" />
          </label>
        </div>

        <div v-if="categories.length" class="blog-filters" aria-label="Filter by category">
          <button type="button" :class="{ active: !selectedCategory }" @click="selectedCategory = ''">All</button>
          <button
            v-for="category in categories"
            :key="category"
            type="button"
            :class="{ active: selectedCategory === category }"
            @click="selectedCategory = category"
          >
            {{ category }}
          </button>
        </div>

        <div v-if="loading" class="blog-grid">
          <div v-for="i in 6" :key="i" class="animate-pulse">
            <div class="blog-card-image bg-muted"></div>
            <div class="mt-5 h-5 w-3/4 rounded bg-muted"></div>
            <div class="mt-3 h-4 w-full rounded bg-muted"></div>
          </div>
        </div>

        <p v-else-if="!gridPosts.length && !featured" class="py-16 text-center text-muted-foreground">
          No articles match your search.
        </p>

        <div v-else class="blog-grid">
          <router-link v-for="blog in gridPosts" :key="blog.id" :to="`/blog/${blog.slug}`" class="blog-card group">
            <span class="blog-card-image"><img :src="imageFor(blog)" :alt="blog.title" loading="lazy" /></span>
            <span v-if="blog.category" class="blog-card-category">{{ blog.category }}</span>
            <h3>{{ blog.title }}</h3>
            <p>{{ blog.excerpt }}</p>
            <span class="blog-byline">
              <span class="blog-avatar">O</span>
              OmniviaTech Team <i></i> {{ formatDate(blog.published_at) }}
            </span>
          </router-link>
        </div>

        <div v-if="hasMore" class="mt-12 text-center">
          <button type="button" class="blog-more" :disabled="loadingMore" @click="loadMore">
            {{ loadingMore ? 'Loading...' : 'Load more' }}
          </button>
        </div>
      </div>
    </section>

    <PageCta
      eyebrow="Work with us"
      title="Let’s get started on something great"
      text="Bring us your website, software or growth challenge and we will help you plan the next step."
    />
  </PublicLayout>
</template>

<script setup lang="ts">
import axios from 'axios';
import { ArrowUpRight, Search } from 'lucide-vue-next';
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import heroTechBg from '@/../img/tech-background.webp';
import PageCta from '@/components/PageCta.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { blogImageUrl } from '@/lib/blogImages';

interface Blog {
  id: number;
  title: string;
  slug: string;
  excerpt: string;
  featured_image: string | null;
  category: string | null;
  published_at: string;
}

const route = useRoute();
const blogs = ref<Blog[]>([]);
const categories = ref<string[]>([]);
const selectedCategory = ref(String(route.query.category || ''));
const searchQuery = ref(String(route.query.search || ''));
const currentPage = ref(1);
const lastPage = ref(1);
const loading = ref(true);
const loadingMore = ref(false);
let latestRequest = 0;

const isFiltered = computed(() => !!selectedCategory.value || !!searchQuery.value.trim());
const featured = computed(() => (isFiltered.value ? null : blogs.value[0] || null));
const gridPosts = computed(() => (featured.value ? blogs.value.slice(1) : blogs.value));
const hasMore = computed(() => !loading.value && currentPage.value < lastPage.value);
const listTitle = computed(() => {
  if (searchQuery.value.trim()) return 'Search results';
  return selectedCategory.value || 'Recent blog posts';
});

const imageFor = (blog: Blog) => blogImageUrl(blog.featured_image) || heroTechBg;

function formatDate(date: string) {
  if (!date) return '';
  return new Date(date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
}

async function fetchBlogs(page = 1) {
  const request = ++latestRequest;
  if (page === 1) loading.value = true;
  else loadingMore.value = true;

  try {
    const params: Record<string, string | number> = { page };
    if (selectedCategory.value) params.category = selectedCategory.value;
    if (searchQuery.value.trim()) params.search = searchQuery.value.trim();

    const { data } = await axios.get('/api/v1/blogs', { params });
    if (request !== latestRequest) return;

    blogs.value = page === 1 ? data.data || [] : [...blogs.value, ...(data.data || [])];
    currentPage.value = data.current_page || page;
    lastPage.value = data.last_page || 1;
  } catch (error) {
    console.error('Failed to fetch blogs:', error);
  } finally {
    if (request === latestRequest) {
      loading.value = false;
      loadingMore.value = false;
    }
  }
}

const loadMore = () => fetchBlogs(currentPage.value + 1);

let searchTimeout: ReturnType<typeof setTimeout>;
watch(searchQuery, () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => fetchBlogs(), 300);
});
watch(selectedCategory, () => fetchBlogs());
watch(() => route.query, (query) => {
  selectedCategory.value = String(query.category || '');
  searchQuery.value = String(query.search || '');
});

onMounted(async () => {
  fetchBlogs();
  try {
    const { data } = await axios.get('/api/v1/blogs/categories');
    categories.value = data.categories || [];
  } catch {
    categories.value = [];
  }
});
</script>
