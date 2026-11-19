<template>
  <PublicLayout>
    <div v-if="loading" class="py-24 text-center">
      <div class="inline-block h-8 w-8 animate-spin rounded-full border-2 border-primary border-t-transparent"></div>
    </div>

    <template v-else-if="blog">
      <section class="post-title-band">
        <div class="container mx-auto px-6">
          <router-link to="/blog" class="post-back"><ArrowLeft :size="15" aria-hidden="true" /> Blog</router-link>
          <span v-if="blog.category">{{ blog.category }}</span>
        </div>
      </section>

      <section class="post-layout">
        <div class="container mx-auto px-6">
          <div class="post-grid">
            <article class="min-w-0">
              <img class="post-image" :src="blogImageUrl(blog.featured_image) || heroTechBg" :alt="blog.title" loading="eager" />
              <h1>{{ blog.title }}</h1>
              <p class="post-meta">
                By OmniviaTech Team - {{ formatDate(blog.published_at) }}
                <template v-if="blog.category"> - {{ blog.category }}</template>
                - {{ readingTime }} min read
              </p>

              <div class="article-body" v-html="blog.content"></div>

              <div class="post-actions">
                <div class="post-tags">
                  <router-link v-for="tag in visibleTags" :key="tag" :to="{ path: '/blog', query: { search: tag } }">{{ tag }}</router-link>
                </div>
                <div class="post-share" aria-label="Share this article">
                  <a :href="`https://www.linkedin.com/shareArticle?mini=true&url=${encodedUrl}&title=${encodedTitle}`" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                  <a :href="`https://twitter.com/intent/tweet?text=${encodedTitle}&url=${encodedUrl}`" target="_blank" rel="noopener noreferrer">X</a>
                  <a :href="`https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`" target="_blank" rel="noopener noreferrer">Facebook</a>
                </div>
              </div>

              <nav v-if="previous || next" class="post-pager" aria-label="More articles">
                <router-link v-if="previous" :to="`/blog/${previous.slug}`"><ArrowLeft :size="16" aria-hidden="true" /> Previous post</router-link>
                <span v-else></span>
                <router-link v-if="next" :to="`/blog/${next.slug}`">Next post <ArrowRight :size="16" aria-hidden="true" /></router-link>
              </nav>

              <form class="post-form" @submit.prevent="submitQuestion">
                <h2>Ask us about this topic</h2>
                <p>Send your question and our team will reply by email.</p>
                <label class="sr-only" for="post-message">Your question</label>
                <textarea id="post-message" v-model="form.message" required rows="5" placeholder="Your question"></textarea>
                <div>
                  <label class="sr-only" for="post-name">Your name</label>
                  <input id="post-name" v-model="form.name" required maxlength="255" placeholder="Your name" />
                  <label class="sr-only" for="post-email">Your email</label>
                  <input id="post-email" v-model="form.email" required type="email" maxlength="255" placeholder="Your email" />
                </div>
                <button type="submit" :disabled="submitting">{{ submitting ? 'Sending...' : 'Send question' }}</button>
              </form>
            </article>

            <aside class="post-sidebar">
              <div v-if="categories.length" class="post-panel">
                <h2>Categories</h2>
                <router-link v-for="category in categories" :key="category" class="post-category" :to="{ path: '/blog', query: { category } }">{{ category }}</router-link>
              </div>

              <form class="post-search" role="search" @submit.prevent="search">
                <label class="sr-only" for="post-search">Search articles</label>
                <input id="post-search" v-model="searchTerm" type="search" placeholder="Search articles" />
                <button type="submit" aria-label="Search"><Search :size="17" /></button>
              </form>

              <div v-if="mostViewed.length" class="post-panel">
                <h2>Top posts</h2>
                <router-link v-for="(post, index) in mostViewed" :key="post.id" class="post-top" :to="`/blog/${post.slug}`">
                  <span>{{ index + 1 }}</span>
                  <strong>{{ post.title }}</strong>
                </router-link>
              </div>

              <div v-if="readingList.length">
                <h2 class="post-side-title">Keep reading</h2>
                <div class="post-thumbs">
                  <router-link v-for="post in readingList" :key="post.id" :to="`/blog/${post.slug}`" :title="post.title">
                    <img :src="blogImageUrl(post.featured_image) || heroTechBg" :alt="post.title" loading="lazy" />
                  </router-link>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </section>

      <PageCta title="Need help putting this into practice?" />
    </template>

    <section v-else class="py-24 text-center">
      <h1 class="mb-4 text-2xl font-bold text-foreground">Article not found</h1>
      <router-link to="/blog" class="text-primary hover:underline">Back to the blog</router-link>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import axios from 'axios';
import { ArrowLeft, ArrowRight, Search } from 'lucide-vue-next';
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import heroTechBg from '@/../img/tech-background.webp';
import PageCta from '@/components/PageCta.vue';
import { useToast } from '@/composables/useToast';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { blogImageUrl } from '@/lib/blogImages';

const route = useRoute();
const router = useRouter();
const toast = useToast();

const blog = ref<any>(null);
const related = ref<any[]>([]);
const categories = ref<string[]>([]);
const recent = ref<any[]>([]);
const mostViewed = ref<any[]>([]);
const previous = ref<any>(null);
const next = ref<any>(null);
const loading = ref(true);
const submitting = ref(false);
const searchTerm = ref('');
const form = ref({ name: '', email: '', message: '' });

const encodedUrl = computed(() => encodeURIComponent(window.location.href));
const encodedTitle = computed(() => encodeURIComponent(blog.value?.title || ''));
const visibleTags = computed(() => (blog.value?.tags || []).slice(0, 5));
const readingTime = computed(() => {
  const words = String(blog.value?.content || '').replace(/<[^>]+>/g, ' ').trim().split(/\s+/).length;
  return Math.max(1, Math.ceil(words / 220));
});
const readingList = computed(() => {
  const posts = new Map([...related.value, ...recent.value].map((post) => [post.id, post]));
  return [...posts.values()].slice(0, 6);
});

async function fetchBlog(slug: string) {
  loading.value = true;
  blog.value = null;
  try {
    const { data } = await axios.get(`/api/v1/blogs/${slug}`);
    blog.value = data.blog;
    related.value = data.related || [];
    categories.value = data.categories || [];
    recent.value = data.recent || [];
    mostViewed.value = data.most_viewed || [];
    previous.value = data.previous || null;
    next.value = data.next || null;
  } catch {
    blog.value = null;
  } finally {
    loading.value = false;
  }
}

function formatDate(date: string) {
  if (!date) return '';
  return new Date(date).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
}

function search() {
  router.push({ path: '/blog', query: searchTerm.value.trim() ? { search: searchTerm.value.trim() } : {} });
}

async function submitQuestion() {
  submitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', {
      type: 'general',
      subject: `Question about: ${String(blog.value.title).slice(0, 220)}`,
      ...form.value,
    });
    toast.success('Thanks. Your question has been sent.');
    form.value = { name: '', email: '', message: '' };
  } catch {
    toast.error('We could not send your question. Please try again.');
  } finally {
    submitting.value = false;
  }
}

watch(() => route.params.slug, (slug) => {
  if (slug) fetchBlog(String(slug));
});

onMounted(() => fetchBlog(String(route.params.slug)));
</script>
