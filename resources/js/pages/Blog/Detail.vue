<template>
  <PublicLayout>
    <div v-if="loading" class="py-20 text-center">
      <div class="inline-block w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <article v-else-if="blog" class="py-12">
      <!-- Hero -->
      <div class="relative mb-12">
        <div v-if="blog.featured_image" class="h-[400px] overflow-hidden rounded-2xl">
          <img
            :src="blogImageUrl(blog.featured_image)"
            :alt="blog.title"
            loading="eager"
            class="w-full h-full object-cover"
          />
        </div>
        <div v-else class="h-[400px] overflow-hidden rounded-2xl">
          <img :src="heroTechBg" :alt="blog.title" class="w-full h-full object-cover" />
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-background via-background/30 to-transparent rounded-2xl"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8">
          <div class="flex flex-wrap items-center gap-3 mb-3">
            <span v-if="blog.category" class="px-3 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full backdrop-blur-sm">
              {{ blog.category }}
            </span>
            <span class="text-xs text-white/70">
              {{ formatDate(blog.published_at) }}
            </span>
            <span class="text-xs text-white/70">·</span>
            <span class="text-xs text-white/70">{{ blog.reading_time }} min read</span>
            <span class="text-xs text-white/70">·</span>
            <span class="text-xs text-white/70">{{ blog.views?.toLocaleString() }} views</span>
          </div>
          <h1 class="text-2xl md:text-4xl font-display font-bold text-white leading-tight max-w-3xl">
            {{ blog.title }}
          </h1>
        </div>
      </div>

      <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
          <!-- Left Sidebar -->
          <aside class="w-full lg:w-60 xl:w-72 shrink-0 order-2 lg:order-1">
            <div class="lg:sticky lg:top-24 space-y-8">
              <!-- Categories -->
              <div v-if="categories.length" class="bg-card border border-border rounded-xl p-5">
                <h3 class="text-sm font-bold text-foreground mb-4 flex items-center gap-2">
                  <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                  Categories
                </h3>
                <div class="space-y-1">
                  <router-link
                    v-for="cat in categories"
                    :key="cat"
                    :to="`/blog?category=${encodeURIComponent(cat)}`"
                    class="flex items-center justify-between px-3 py-2 text-xs text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition"
                  >
                    <span>{{ cat }}</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                  </router-link>
                </div>
              </div>

              <!-- Recent Blogs -->
              <div v-if="recent.length" class="bg-card border border-border rounded-xl p-5">
                <h3 class="text-sm font-bold text-foreground mb-4 flex items-center gap-2">
                  <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  Recent Posts
                </h3>
                <div class="space-y-3">
                  <router-link
                    v-for="post in recent"
                    :key="post.id"
                    :to="`/blog/${post.slug}`"
                    class="flex gap-3 group"
                  >
                    <div class="w-14 h-14 shrink-0 rounded-lg overflow-hidden bg-muted">
                      <img
                        v-if="post.featured_image"
                        :src="blogImageUrl(post.featured_image)"
                        :alt="post.title"
                        class="w-full h-full object-cover"
                      />
                      <div v-else class="w-full h-full flex items-center justify-center text-muted-foreground/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                      </div>
                    </div>
                    <div class="min-w-0 flex-1">
                      <h4 class="text-xs font-semibold text-foreground group-hover:text-primary transition line-clamp-2 leading-snug">{{ post.title }}</h4>
                      <span class="text-[10px] text-muted-foreground mt-1 block">{{ formatDate(post.published_at) }}</span>
                    </div>
                  </router-link>
                </div>
              </div>

            </div>
          </aside>

          <!-- Main Content -->
          <div class="flex-1 min-w-0 order-1 lg:order-2">
            <!-- Author -->
            <div v-if="blog.author" class="flex items-center gap-3 mb-8 pb-6 border-b border-border">
              <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-lg text-primary font-bold shrink-0">
                {{ blog.author.name?.charAt(0) }}
              </div>
              <div>
                <p class="text-sm font-medium text-foreground">{{ blog.author.name }}</p>
                <p class="text-xs text-muted-foreground">Author</p>
              </div>
            </div>

            <!-- Content -->
            <div
              class="prose prose-lg max-w-none prose-headings:text-foreground prose-headings:font-display prose-p:text-muted-foreground prose-a:text-primary prose-strong:text-foreground prose-code:text-primary prose-pre:bg-card prose-blockquote:border-primary mb-8"
              v-html="blog.content"
            />

            <!-- Tags -->
            <div v-if="blog.tags?.length" class="flex flex-wrap gap-2 mb-8">
              <span
                v-for="tag in blog.tags"
                :key="tag"
                class="px-3 py-1 text-xs bg-card text-muted-foreground border border-border rounded-full"
              >
                #{{ tag }}
              </span>
            </div>

            <!-- Share -->
            <div class="flex items-center gap-4 py-6 border-t border-b border-border mb-8">
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
            <div v-if="related.length">
              <h3 class="text-lg font-bold text-foreground mb-6">Related Articles</h3>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <router-link
                  v-for="post in related"
                  :key="post.id"
                  :to="`/blog/${post.slug}`"
                  class="group bg-card border border-border rounded-xl overflow-hidden hover:border-primary transition"
                >
                  <div class="aspect-[16/10] bg-card overflow-hidden">
                    <img
                      v-if="post.featured_image"
                      :src="blogImageUrl(post.featured_image)"
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

          <!-- Right Sidebar -->
          <aside class="w-full lg:w-60 xl:w-72 shrink-0 order-3">
            <div class="lg:sticky lg:top-24 space-y-8">
              <!-- Most Viewed -->
              <div v-if="mostViewed.length" class="bg-card border border-border rounded-xl p-5">
                <h3 class="text-sm font-bold text-foreground mb-4 flex items-center gap-2">
                  <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                  Most Viewed
                </h3>
                <div class="space-y-3">
                  <router-link
                    v-for="(post, i) in mostViewed"
                    :key="post.id"
                    :to="`/blog/${post.slug}`"
                    class="flex gap-3 group"
                  >
                    <span class="w-6 h-6 shrink-0 rounded-md bg-primary/10 text-primary text-xs font-bold flex items-center justify-center">{{ i + 1 }}</span>
                    <div class="min-w-0 flex-1">
                      <h4 class="text-xs font-semibold text-foreground group-hover:text-primary transition line-clamp-2 leading-snug">{{ post.title }}</h4>
                      <span class="text-[10px] text-muted-foreground mt-1 block">{{ post.views?.toLocaleString() }} views</span>
                    </div>
                  </router-link>
                </div>
              </div>

              <!-- Tags Cloud -->
              <div v-if="tags.length" class="bg-card border border-border rounded-xl p-5">
                <h3 class="text-sm font-bold text-foreground mb-4 flex items-center gap-2">
                  <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                  Tags
                </h3>
                <div class="flex flex-wrap gap-1.5">
                  <span
                    v-for="tag in tags.slice(0, 15)"
                    :key="tag"
                    class="px-2 py-0.5 text-[10px] bg-muted text-muted-foreground rounded-md hover:bg-primary/10 hover:text-primary cursor-default transition"
                  >
                    #{{ tag }}
                  </span>
                </div>
              </div>
            </div>
          </aside>
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
import { blogImageUrl } from '@/lib/blogImages';
import axios from 'axios';
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import heroTechBg from '@/../img/tech-background.webp';
import PublicLayout from '@/layouts/PublicLayout.vue';

const route = useRoute();

const blog = ref<any>(null);
const related = ref<any[]>([]);
const categories = ref<string[]>([]);
const recent = ref<any[]>([]);
const mostViewed = ref<any[]>([]);
const loading = ref(true);

const currentUrl = computed(() => window.location.href);

const tags = computed(() => {
  const allTags = new Set<string>();
  if (blog.value?.tags?.length) blog.value.tags.forEach((t: string) => allTags.add(t));
  recent.value.forEach((p: any) => p.tags?.forEach((t: string) => allTags.add(t)));
  mostViewed.value.forEach((p: any) => p.tags?.forEach((t: string) => allTags.add(t)));
  return Array.from(allTags);
});

async function fetchBlog(slug: string) {
  loading.value = true;
  blog.value = null;
  try {
    const response = await axios.get(`/api/v1/blogs/${slug}`);
    blog.value = response.data.blog;
    related.value = response.data.related || [];
    categories.value = response.data.categories || [];
    recent.value = response.data.recent || [];
    mostViewed.value = response.data.most_viewed || [];

    if (blog.value?.seo_title || blog.value?.title) {
      document.title = `${blog.value.seo_title || blog.value.title} - OmniviaTech`;
    }

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
