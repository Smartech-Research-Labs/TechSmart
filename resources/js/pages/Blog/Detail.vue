<template>
  <PublicLayout>
    <div v-if="loading" class="py-20 text-center">
      <div class="inline-block w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <article v-else-if="blog" class="py-12">
      <!-- Hero -->
      <div class="relative">
        <div v-if="blog.featured_image" class="h-[400px] overflow-hidden">
          <img
            :src="blog.featured_image.startsWith('http') ? blog.featured_image : `/storage/${blog.featured_image}`"
            :alt="blog.title"
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-background via-background/50 to-transparent"></div>
        </div>
        <div v-else class="h-[400px] overflow-hidden">
          <img :src="heroTechBg" :alt="blog.title" class="w-full h-full object-cover" />
          <div class="absolute inset-0 bg-black/50"></div>
        </div>
      </div>

      <div class="container mx-auto px-4 max-w-4xl -mt-20 relative z-10">
        <!-- Meta -->
        <div class="flex flex-wrap items-center gap-3 mb-4">
          <span v-if="blog.category" class="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full">
            {{ blog.category }}
          </span>
          <span class="text-sm text-muted-foreground">
            {{ formatDate(blog.published_at) }}
          </span>
          <span class="text-sm text-muted-foreground">·</span>
          <span class="text-sm text-muted-foreground">{{ blog.reading_time }} min read</span>
          <span class="text-sm text-muted-foreground">·</span>
          <span class="text-sm text-muted-foreground">{{ blog.views?.toLocaleString() }} views</span>
        </div>

        <!-- Title -->
        <h1 class="text-3xl md:text-5xl font-display font-bold text-foreground mb-6 leading-tight">
          {{ blog.title }}
        </h1>

        <!-- Author -->
        <div v-if="blog.author" class="flex items-center gap-3 mb-10 pb-8 border-b border-border">
          <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-lg text-primary font-bold">
            {{ blog.author.name?.charAt(0) }}
          </div>
          <div>
            <p class="text-sm font-medium text-foreground">{{ blog.author.name }}</p>
            <p class="text-xs text-muted-foreground">Author</p>
          </div>
        </div>

        <!-- Content -->
        <div
          class="prose prose-lg max-w-none prose-headings:text-foreground prose-headings:font-display prose-p:text-muted-foreground prose-a:text-primary prose-strong:text-foreground prose-code:text-primary prose-pre:bg-card prose-blockquote:border-primary mb-12"
          v-html="blog.content"
        />

        <!-- Tags -->
        <div v-if="blog.tags?.length" class="flex flex-wrap gap-2 mb-12">
          <span
            v-for="tag in blog.tags"
            :key="tag"
            class="px-3 py-1 text-xs bg-card text-muted-foreground border border-border rounded-full"
          >
            #{{ tag }}
          </span>
        </div>

        <!-- Share -->
        <div class="flex items-center gap-4 py-6 border-t border-b border-border mb-12">
          <span class="text-sm font-medium text-foreground">Share:</span>
          <a
            :href="`https://twitter.com/intent/tweet?text=${encodeURIComponent(blog.title)}&url=${encodeURIComponent(currentUrl)}`"
            target="_blank"
            class="w-8 h-8 flex items-center justify-center rounded-lg bg-card text-muted-foreground hover:text-primary hover:bg-primary/10 transition"
          >
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <a
            :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`"
            target="_blank"
            class="w-8 h-8 flex items-center justify-center rounded-lg bg-card text-muted-foreground hover:text-primary hover:bg-primary/10 transition"
          >
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <a
            :href="`https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(currentUrl)}&title=${encodeURIComponent(blog.title)}`"
            target="_blank"
            class="w-8 h-8 flex items-center justify-center rounded-lg bg-card text-muted-foreground hover:text-primary hover:bg-primary/10 transition"
          >
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
        </div>

        <!-- Related Posts -->
        <div v-if="related.length" class="mb-12">
          <h3 class="text-2xl font-display font-bold text-foreground mb-8">Related Articles</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <router-link
              v-for="post in related"
              :key="post.id"
              :to="`/blog/${post.slug}`"
              class="group bg-card border border-border rounded-xl overflow-hidden hover:border-primary transition"
            >
              <div class="aspect-[16/10] bg-card overflow-hidden">
                <img
                  v-if="post.featured_image"
                  :src="post.featured_image.startsWith('http') ? post.featured_image : `/storage/${post.featured_image}`"
                  :alt="post.title"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
              </div>
              <div class="p-4">
                <h4 class="text-sm font-bold text-foreground group-hover:text-primary transition line-clamp-2">
                  {{ post.title }}
                </h4>
                <span class="text-xs text-muted-foreground mt-2 block">{{ formatDate(post.published_at) }}</span>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </article>

    <!-- Not Found -->
    <div v-else class="py-20 text-center">
      <h2 class="text-2xl font-bold text-foreground mb-4">Article Not Found</h2>
      <router-link to="/blog" class="text-primary hover:underline">← Back to Blog</router-link>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import axios from 'axios';
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import heroTechBg from '@/../img/tech-background.png';
import PublicLayout from '@/layouts/PublicLayout.vue';

const route = useRoute();
const router = useRouter();

const blog = ref<any>(null);
const related = ref<any[]>([]);
const loading = ref(true);

const currentUrl = computed(() => window.location.href);

async function fetchBlog(slug: string) {
  loading.value = true;
  blog.value = null;
  try {
    const response = await axios.get(`/api/v1/blogs/${slug}`);
    blog.value = response.data.blog;
    related.value = response.data.related || [];

    // Update page title for SEO
    if (blog.value?.seo_title || blog.value?.title) {
      document.title = `${blog.value.seo_title || blog.value.title} - OmniviaTech`;
    }

    // Add meta description
    if (blog.value?.seo_description) {
      let meta = document.querySelector('meta[name="description"]');
      if (!meta) {
        meta = document.createElement('meta');
        meta.setAttribute('name', 'description');
        document.head.appendChild(meta);
      }
      meta.setAttribute('content', blog.value.seo_description);
    }
  } catch {
    blog.value = null;
  } finally {
    loading.value = false;
  }
}

function formatDate(date: string) {
  if (!date) return '';
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
}

watch(() => route.params.slug, (newSlug) => {
  if (newSlug) fetchBlog(newSlug as string);
});

onMounted(() => {
  const slug = route.params.slug as string;
  if (slug) fetchBlog(slug);
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
</style>
