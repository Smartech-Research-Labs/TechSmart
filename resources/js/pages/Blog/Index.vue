<template>
  <PublicLayout>
    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="relative py-16 md:py-24 overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img :src="s.hero_bg_image || heroLaptopDark" alt="" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>
      </div>
      <div class="relative z-10 container mx-auto px-6">
        <div class="max-w-xl">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Our Blog</p>
          <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">Insights & Articles</h1>
          <p class="text-white/80 text-sm leading-relaxed mb-6">Industry news, tutorials, and insights from the world of technology.</p>
          <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Subscribe to Updates
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
          </router-link>
        </div>
      </div>
    </section>

    <!-- ═══════════════ BLOG STATS ═══════════════ -->
    <section class="py-10 bg-muted/30 border-y border-border">
      <div class="container mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div v-for="(stat, i) in blogStats" :key="i" class="text-center">
            <div class="text-2xl md:text-3xl font-bold text-primary mb-1">{{ stat.value }}</div>
            <div class="text-muted-foreground text-xs font-medium">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ WHY READ OUR BLOG ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-12">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">Why Read Our Blog</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-4">Expert Insights to Help You Succeed</h2>
          <p class="text-muted-foreground text-sm leading-relaxed">Stay ahead of the curve with practical advice, in-depth tutorials, and the latest trends from industry experts who understand the challenges your business faces.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <div v-for="prop in whyReadProps" :key="prop.label" class="bg-card border border-border rounded-xl p-6 hover:shadow-lg hover:border-primary/20 transition-all">
            <div class="w-11 h-11 bg-primary/10 rounded-xl flex items-center justify-center mb-4 text-xl">{{ prop.icon }}</div>
            <h3 class="text-sm font-bold text-foreground mb-2">{{ prop.label }}</h3>
            <p class="text-muted-foreground text-xs leading-relaxed">{{ prop.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ FILTERS ═══════════════ -->
    <section class="py-3 border-b border-border bg-background sticky top-16 z-30">
      <div class="container mx-auto px-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div class="flex flex-wrap gap-2">
            <button @click="selectedCategory = ''" :class="['px-4 py-1.5 rounded-full text-xs font-medium transition-all', !selectedCategory ? 'bg-primary text-white' : 'bg-card text-muted-foreground hover:text-foreground border border-border']">All</button>
            <button v-for="category in categories" :key="category" @click="selectedCategory = category" :class="['px-4 py-1.5 rounded-full text-xs font-medium transition-all', selectedCategory === category ? 'bg-primary text-white' : 'bg-card text-muted-foreground hover:text-foreground border border-border']">{{ category }}</button>
          </div>
          <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.35-4.35" /></svg>
            <input v-model="searchQuery" type="text" placeholder="Search articles..." class="pl-10 pr-4 py-1.5 bg-card border border-border rounded-full text-foreground placeholder-muted-foreground text-xs focus:outline-none focus:border-primary transition w-56" />
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ BLOG GRID ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="i in 8" :key="i" class="bg-card border border-border rounded-xl overflow-hidden animate-pulse">
            <div class="aspect-[4/3] bg-muted"></div>
            <div class="p-4 space-y-2"><div class="h-3 bg-muted rounded w-3/4"></div><div class="h-2 bg-muted rounded w-full"></div></div>
          </div>
        </div>

        <div v-else-if="blogs.length === 0" class="text-center py-16">
          <p class="text-muted-foreground text-sm">No articles found.</p>
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <router-link v-for="blog in blogs" :key="blog.id" :to="`/blog/${blog.slug}`" class="group bg-card border border-border rounded-xl overflow-hidden hover:border-primary/30 hover:shadow-lg transition-all">
            <div class="aspect-[4/3] bg-muted overflow-hidden">
              <img v-if="blog.featured_image" :src="blog.featured_image.startsWith('http') ? blog.featured_image : `/storage/${blog.featured_image}`" :alt="blog.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-accent/10">
                <svg class="w-8 h-8 text-muted-foreground/20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-center gap-2 mb-1.5">
                <span v-if="blog.category" class="text-[10px] font-medium text-primary bg-primary/10 px-2 py-0.5 rounded">{{ blog.category }}</span>
                <span class="text-muted-foreground text-[10px]">{{ formatDate(blog.published_at) }}</span>
              </div>
              <h3 class="text-xs font-semibold text-foreground mb-1 group-hover:text-primary transition-colors line-clamp-2">{{ blog.title }}</h3>
              <p class="text-muted-foreground text-[11px] line-clamp-2">{{ blog.excerpt }}</p>
            </div>
          </router-link>
        </div>

        <!-- Pagination -->
        <div v-if="totalPages > 1" class="flex justify-center mt-10 gap-1.5">
          <button v-for="page in totalPages" :key="page" @click="currentPage = page" :class="['w-8 h-8 rounded-lg text-xs font-medium transition', currentPage === page ? 'bg-primary text-white' : 'bg-card text-muted-foreground border border-border hover:border-primary']">{{ page }}</button>
        </div>
      </div>
    </section>

    <!-- ═══════════════ TESTIMONIALS ═══════════════ -->
    <section v-if="topReviews.length" class="py-14 md:py-20 bg-muted/20">
      <div class="container mx-auto px-6 max-w-6xl">
        <div class="text-center max-w-xl mx-auto mb-10">
          <p class="text-amber-600 dark:text-amber-400 text-xs font-semibold tracking-widest uppercase mb-2">Testimonials</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-3">What Our Readers Say</h2>
          <p class="text-muted-foreground text-xs leading-relaxed">Join thousands of professionals who trust our blog for their technology insights.</p>
        </div>

        <Swiper
          :modules="[Autoplay, Pagination]"
          :slides-per-view="1"
          :space-between="16"
          :pagination="testimonialsPagination"
          :autoplay="testimonialsAutoplay"
          :breakpoints="{ 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 }, 1280: { slidesPerView: 4 } }"
          class="testimonials-swiper pb-16"
        >
          <SwiperSlide v-for="review in topReviews" :key="review.id">
            <div class="rounded-lg p-5 h-full flex flex-col shadow-md hover:shadow-xl transition-all bg-gray-900 border border-white/10">
              <div class="flex gap-0.5 mb-3">
                <svg v-for="s in review.rating" :key="s" class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
              <p class="text-white/80 text-sm leading-relaxed mb-4 flex-1 line-clamp-3">"{{ review.comment }}"</p>
              <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                <div class="w-9 h-9 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                  {{ review.user_name?.charAt(0).toUpperCase() }}
                </div>
                <div class="min-w-0">
                  <div class="font-semibold text-white text-sm truncate">{{ review.user_name }}</div>
                  <div class="text-white/60 text-xs truncate">{{ review.company || 'Verified Client' }}</div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

    <!-- ═══════════════ FAQ ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6 max-w-3xl">
        <div class="text-center mb-10">
          <p class="text-primary text-xs font-semibold tracking-widest uppercase mb-3">FAQ</p>
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight">Frequently Asked Questions</h2>
          <p class="text-muted-foreground text-xs leading-relaxed mt-3">Everything you need to know about our blog and how we create content for you.</p>
        </div>

        <div class="space-y-3">
          <div v-for="(faq, idx) in blogFaqs" :key="idx" class="bg-card border border-border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <button @click="toggleFaq(idx)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/40 transition-colors">
              <span class="font-medium text-foreground text-sm pr-6">{{ faq.question }}</span>
              <svg class="w-5 h-5 text-muted-foreground shrink-0 transition-transform duration-200" :class="{ 'rotate-180': openFaqIndex === idx }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div v-show="openFaqIndex === idx" class="px-6 pb-5">
              <p class="text-muted-foreground text-sm leading-relaxed">{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ REQUEST A QUOTE ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div>
            <p class="text-accent text-xs font-semibold tracking-widest uppercase mb-2">Get Started</p>
            <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-2">Have a Project in Mind?</h2>
            <p class="text-muted-foreground text-sm mb-6">Let us know what you're working on and we'll help you bring it to life.</p>
            <form @submit.prevent="submitQuote" class="space-y-3">
              <div class="grid grid-cols-2 gap-3">
                <input v-model="quoteForm.name" type="text" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Full Name *" />
                <input v-model="quoteForm.email" type="email" required class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm" placeholder="Email *" />
              </div>
              <textarea v-model="quoteForm.message" required rows="3" class="w-full px-4 py-2.5 bg-muted/50 border border-border rounded-lg focus:outline-none focus:border-primary text-foreground text-sm resize-none" placeholder="Tell us about your project..."></textarea>
              <button type="submit" :disabled="quoteSubmitting" class="w-full px-5 py-3 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 disabled:opacity-50 transition-all">{{ quoteSubmitting ? 'Submitting...' : 'Get in Touch' }}</button>
            </form>
          </div>
          <div class="hidden lg:block">
            <div class="rounded-xl overflow-hidden"><img :src="s.quote_section_image || heroTech2" alt="Get a Quote" class="w-full h-full object-cover aspect-[4/3]" /></div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ CTA (MAROON) ═══════════════ -->
    <section class="py-14 md:py-20">
      <div class="container mx-auto px-6">
        <div class="relative bg-black rounded-2xl overflow-hidden">
          <div class="absolute inset-0 opacity-30 bg-cover bg-center" :style="{ backgroundImage: 'url(' + heroTechGlow + ')' }"></div>
          <div class="absolute inset-0 bg-black/70"></div>
          <div class="relative grid lg:grid-cols-2 items-center">
            <div class="p-8 md:p-12 lg:p-14">
              <h2 class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">Transform Your Business with Technology</h2>
              <p class="text-white/70 text-sm leading-relaxed mb-8">From ideation to deployment, we partner with you every step of the way.</p>
              <router-link to="/contact" class="inline-flex items-center gap-2 px-7 py-3 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary/90 transition-all shadow-lg">
                Start Your Project
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg>
              </router-link>
            </div>
            <div class="hidden lg:flex items-end justify-end h-full min-h-[300px]">
              <img :src="s.cta_professional_image || heroTech4" alt="Professional" class="h-full max-h-[350px] object-cover object-top" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════ OTHER AREAS ═══════════════ -->
    <section class="py-14 md:py-20 bg-muted/30">
      <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-8">
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-foreground leading-tight mb-3">Other Areas You Might Be Interested In</h2>
          <p class="text-muted-foreground text-sm">Explore more of what OmniviaTech has to offer.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <router-link v-for="area in otherAreas" :key="area.label" :to="area.to" class="group bg-card border border-border rounded-xl p-5 text-center hover:border-primary/40 hover:shadow-md transition-all">
            <div class="w-12 h-12 mx-auto bg-primary/10 rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary/20 transition"><span class="text-xl">{{ area.icon }}</span></div>
            <h3 class="text-xs font-semibold text-foreground group-hover:text-primary transition-colors">{{ area.label }}</h3>
          </router-link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import axios from 'axios';
import { Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref, computed, onMounted, watch } from 'vue';
import heroLaptopDark from '@/../img/tech-background.webp';
import heroTechGlow from '@/../img/tech-glow.webp';
import heroTech2 from '@/../img/tech2.webp';
import heroTech4 from '@/../img/tech4.webp';
import 'swiper/css';
import 'swiper/css/pagination';
import { useToast } from '@/composables';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useCmsStore } from '@/stores/cms';

const cmsStore = useCmsStore();
const s = computed(() => cmsStore.homeData?.settings || {} as any);
const toast = useToast();

interface Blog {
  id: number;
  title: string;
  slug: string;
  excerpt: string;
  featured_image: string | null;
  category: string | null;
  published_at: string;
}

const blogs = ref<Blog[]>([]);
const categories = ref<string[]>([]);
const selectedCategory = ref('');
const searchQuery = ref('');
const currentPage = ref(1);
const totalPages = ref(1);
const loading = ref(true);

const otherAreas = [
  { icon: '⚡', label: 'Services', to: '/services' },
  { icon: '📦', label: 'Products', to: '/products' },
  { icon: '💼', label: 'Bundles', to: '/bundles' },
  { icon: '📞', label: 'Contact', to: '/contact' },
];

const blogStats = [
  { value: '50+', label: 'Articles Published' },
  { value: '15+', label: 'Content Categories' },
  { value: '10k+', label: 'Monthly Readers' },
  { value: '5+', label: 'Expert Authors' },
];

const whyReadProps = [
  { icon: '📚', label: 'In-Depth Tutorials', desc: 'Step-by-step guides and tutorials that walk you through implementing real-world technology solutions from start to finish.' },
  { icon: '📊', label: 'Industry Insights', desc: 'Stay informed with the latest trends, market analysis, and emerging technologies shaping the business landscape.' },
  { icon: '🛡️', label: 'Best Practices', desc: 'Learn proven methodologies and industry best practices for cybersecurity, cloud migration, DevOps, and more.' },
  { icon: '💡', label: 'Practical Tips', desc: 'Actionable advice and tips you can immediately apply to improve your business operations and technology strategy.' },
];

// Quote Form
const quoteForm = ref({ name: '', email: '', message: '' });
const quoteSubmitting = ref(false);

async function submitQuote() {
  quoteSubmitting.value = true;
  try {
    await axios.post('/api/v1/enquiries', { type: 'contact', ...quoteForm.value });
    toast.success('Message sent! We will be in touch soon.');
    quoteForm.value = { name: '', email: '', message: '' };
  } catch { toast.error('Failed to submit. Please try again.'); }
  finally { quoteSubmitting.value = false; }
}

// Blog fetching
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
  } catch { /* silent */ }
}

// Testimonials
const topReviews = ref<any[]>([]);
const testimonialsPagination = { clickable: true, dynamicBullets: true };
const testimonialsAutoplay = { delay: 5000, disableOnInteraction: false };

async function loadReviews() {
  try {
    const { data } = await axios.get('/api/v1/reviews', { params: { limit: 8 } });
    topReviews.value = data.data || [];
  } catch { /* silent */ }
}

// FAQ
const openFaqIndex = ref<number | null>(null);

function toggleFaq(idx: number) {
  openFaqIndex.value = openFaqIndex.value === idx ? null : idx;
}

const blogFaqs = [
  { question: 'How often do you publish new articles?', answer: 'We publish new articles weekly, covering a wide range of technology topics including software development, cybersecurity, cloud computing, AI, and digital transformation.' },
  { question: 'Can I contribute a guest post to the blog?', answer: 'Absolutely! We welcome contributions from industry experts. Please reach out to us through our contact page with your topic proposal and writing samples for review.' },
  { question: 'How can I stay updated with new posts?', answer: 'The best way is to subscribe to our newsletter using the form above. You can also follow us on social media or bookmark our blog page and visit regularly.' },
  { question: 'Are the tutorials suitable for beginners?', answer: 'We write content for all skill levels. Each article includes a difficulty indicator and prerequisites section, so you can choose the content that matches your experience level.' },
  { question: 'Can I share or republish your content?', answer: 'You are welcome to share links to our articles on social media or with your network. For republication, please contact us to discuss licensing options.' },
  { question: 'Do you cover product reviews and comparisons?', answer: 'Yes, we regularly review and compare technology products, software tools, and services to help our readers make informed purchasing decisions for their businesses.' },
];

function formatDate(date: string) {
  if (!date) return '';
  return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

let searchTimeout: ReturnType<typeof setTimeout>;
watch(searchQuery, () => { clearTimeout(searchTimeout); searchTimeout = setTimeout(() => { currentPage.value = 1; fetchBlogs(); }, 400); });
watch(selectedCategory, () => { currentPage.value = 1; fetchBlogs(); });
watch(currentPage, fetchBlogs);

onMounted(() => { fetchBlogs(); fetchCategories(); loadReviews(); });
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
