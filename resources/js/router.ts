import { START_LOCATION, createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';
import { onEngaged } from '@/lib/engagement';
import { useAuthStore } from '@/stores/auth';

const routes: RouteRecordRaw[] = [
  // Public routes
  {
    path: '/',
    name: 'home',
    component: () => import('@/pages/Home.vue'),
    meta: { title: 'Home' },
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('@/pages/About.vue'),
    meta: { title: 'About Us' },
  },
  {
    path: '/services',
    name: 'services',
    component: () => import('@/pages/Services/Index.vue'),
    meta: { title: 'Services' },
  },
  {
    path: '/services/:slug',
    name: 'service-detail',
    component: () => import('@/pages/Services/Detail.vue'),
    meta: { title: 'Service' },
  },
  {
    path: '/products',
    name: 'products',
    component: () => import('@/pages/Products/Index.vue'),
    meta: { title: 'Products' },
  },
  {
    path: '/products/:slug',
    name: 'product-detail',
    component: () => import('@/pages/Products/Detail.vue'),
    meta: { title: 'Product' },
  },
  {
    path: '/bundles',
    name: 'bundles',
    component: () => import('@/pages/Bundles/Index.vue'),
    meta: { title: 'Bundles' },
  },
  {
    path: '/bundles/:slug',
    name: 'bundle-detail',
    component: () => import('@/pages/Bundles/Detail.vue'),
    meta: { title: 'Bundle' },
  },
  {
    path: '/packages',
    name: 'packages',
    component: () => import('@/pages/Packages/Index.vue'),
    meta: { title: 'Packages' },
  },
  {
    path: '/packages/:slug',
    name: 'package-detail',
    component: () => import('@/pages/Packages/Detail.vue'),
    meta: { title: 'Package' },
  },
  {
    path: '/faqs',
    name: 'faqs',
    component: () => import('@/pages/Faqs.vue'),
    meta: { title: 'FAQs' },
  },
  {
    path: '/privacy',
    name: 'privacy',
    component: () => import('@/pages/Legal.vue'),
    meta: { title: 'Privacy Policy', legalPage: 'privacy' },
  },
  {
    path: '/terms',
    name: 'terms',
    component: () => import('@/pages/Legal.vue'),
    meta: { title: 'Terms of Service', legalPage: 'terms' },
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('@/pages/Contact.vue'),
    meta: { title: 'Contact Us' },
  },

  // Blog routes
  {
    path: '/blog',
    name: 'blog',
    component: () => import('@/pages/Blog/Index.vue'),
    meta: { title: 'Blog' },
  },
  {
    path: '/blog/:slug',
    name: 'blog-detail',
    component: () => import('@/pages/Blog/Detail.vue'),
    meta: { title: 'Blog Post' },
  },

  // Case Studies
  {
    path: '/case-studies',
    name: 'case-studies',
    component: () => import('@/pages/CaseStudies/Index.vue'),
    meta: { title: 'Case Studies' },
  },
  {
    path: '/case-studies/:slug',
    name: 'case-study-detail',
    component: () => import('@/pages/CaseStudies/Detail.vue'),
    meta: { title: 'Case Study' },
  },
  {
    path: '/industries',
    name: 'industries',
    component: () => import('@/pages/Industries/Index.vue'),
    meta: { title: 'Industries' },
  },
  {
    path: '/industries/:slug',
    name: 'industry-detail',
    component: () => import('@/pages/Industries/Detail.vue'),
    meta: { title: 'Industry' },
  },
  {
    path: '/specializations/:slug',
    name: 'specialization',
    component: () => import('@/pages/Specialization.vue'),
    meta: { title: 'Specialization' },
  },

  // Auth routes
  {
    path: '/login',
    name: 'login',
    component: () => import('@/pages/auth/Login.vue'),
    meta: { title: 'Login', guest: true },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/pages/auth/Register.vue'),
    meta: { title: 'Register', guest: true },
  },
  {
    path: '/forgot-password',
    name: 'forgot-password',
    component: () => import('@/pages/auth/ForgotPassword.vue'),
    meta: { title: 'Forgot Password', guest: true },
  },
  {
    path: '/reset-password/:token',
    name: 'reset-password',
    component: () => import('@/pages/auth/ResetPassword.vue'),
    meta: { title: 'Reset Password', guest: true },
  },
  {
    path: '/confirm-password',
    name: 'confirm-password',
    component: () => import('@/pages/auth/ConfirmPassword.vue'),
    meta: { title: 'Confirm Password', requiresAuth: true },
  },
  {
    path: '/verify-email',
    name: 'verify-email',
    component: () => import('@/pages/auth/VerifyEmail.vue'),
    meta: { title: 'Verify Email', requiresAuth: true },
  },
  {
    path: '/two-factor-challenge',
    name: 'two-factor-challenge',
    component: () => import('@/pages/auth/TwoFactorChallenge.vue'),
    meta: { title: 'Two-Factor Authentication', guest: true },
  },
  {
    path: '/auth/google/callback',
    name: 'google-callback',
    component: () => import('@/pages/auth/GoogleCallback.vue'),
    meta: { title: 'Google Sign-In', guest: true },
  },

  // User dashboard routes
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('@/pages/Dashboard/Index.vue'),
    meta: { title: 'Dashboard', requiresAuth: true },
  },
  {
    path: '/dashboard/profile',
    name: 'profile',
    component: () => import('@/pages/Dashboard/Profile.vue'),
    meta: { title: 'My Profile', requiresAuth: true },
  },
  {
    path: '/dashboard/wishlist',
    name: 'wishlist',
    component: () => import('@/pages/Dashboard/Wishlist.vue'),
    meta: { title: 'My Wishlist', requiresAuth: true },
  },
  {
    path: '/dashboard/enquiries',
    name: 'enquiries',
    component: () => import('@/pages/Dashboard/Enquiries.vue'),
    meta: { title: 'My Enquiries', requiresAuth: true },
  },
  {
    path: '/dashboard/reviews',
    name: 'reviews',
    component: () => import('@/pages/Dashboard/Reviews.vue'),
    meta: { title: 'My Reviews', requiresAuth: true },
  },
  {
    path: '/dashboard/messages',
    name: 'messages',
    component: () => import('@/pages/Dashboard/Messages.vue'),
    meta: { title: 'Messages', requiresAuth: true },
  },

  // Admin routes
  {
    path: '/admin',
    name: 'admin',
    component: () => import('@/pages/Admin/Index.vue'),
    meta: { title: 'Admin Dashboard', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/pages',
    name: 'admin-pages',
    component: () => import('@/pages/Admin/Pages.vue'),
    meta: { title: 'Manage Pages', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/services',
    name: 'admin-services',
    component: () => import('@/pages/Admin/Services.vue'),
    meta: { title: 'Manage Services', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/products',
    name: 'admin-products',
    component: () => import('@/pages/Admin/Products.vue'),
    meta: { title: 'Manage Products', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/bundles',
    name: 'admin-bundles',
    component: () => import('@/pages/Admin/Bundles.vue'),
    meta: { title: 'Manage Bundles', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/reviews',
    name: 'admin-reviews',
    component: () => import('@/pages/Admin/Reviews.vue'),
    meta: { title: 'Manage Reviews', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/enquiries',
    name: 'admin-enquiries',
    component: () => import('@/pages/Admin/Enquiries.vue'),
    meta: { title: 'Manage Enquiries', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/chat',
    name: 'admin-chat',
    component: () => import('@/pages/Admin/Chat.vue'),
    meta: { title: 'Chat Management', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/media',
    name: 'admin-media',
    component: () => import('@/pages/Admin/Media.vue'),
    meta: { title: 'Media Library', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/settings',
    name: 'admin-settings',
    component: () => import('@/pages/Admin/Settings.vue'),
    meta: { title: 'Site Settings', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/cms',
    name: 'admin-cms',
    component: () => import('@/pages/Admin/CMS.vue'),
    meta: { title: 'CMS Management', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/blogs',
    name: 'admin-blogs',
    component: () => import('@/pages/Admin/Blogs.vue'),
    meta: { title: 'Manage Blog', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/case-studies',
    name: 'admin-case-studies',
    component: () => import('@/pages/Admin/CaseStudies.vue'),
    meta: { title: 'Manage Case Studies', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/industries',
    name: 'admin-industries',
    component: () => import('@/pages/Admin/Industries.vue'),
    meta: { title: 'Manage Industries', requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/clients',
    name: 'admin-clients',
    component: () => import('@/pages/Admin/Clients.vue'),
    meta: { title: 'Trusted By (Clients/Partners)', requiresAuth: true, requiresAdmin: true },
  },

  // SuperAdmin-only routes
  {
    path: '/admin/users',
    name: 'admin-users',
    component: () => import('@/pages/Admin/Users.vue'),
    meta: { title: 'User Management', requiresAuth: true, requiresSuperAdmin: true },
  },
  {
    path: '/admin/roles',
    name: 'admin-roles',
    component: () => import('@/pages/Admin/Roles.vue'),
    meta: { title: 'Roles & Permissions', requiresAuth: true, requiresSuperAdmin: true },
  },
  {
    path: '/admin/audit-logs',
    name: 'admin-audit-logs',
    component: () => import('@/pages/Admin/AuditLogs.vue'),
    meta: { title: 'Audit Logs', requiresAuth: true, requiresSuperAdmin: true },
  },
  {
    path: '/admin/media-library',
    name: 'admin-media-library',
    component: () => import('@/pages/Admin/MediaLibrary.vue'),
    meta: { title: 'Media Library', requiresAuth: true, requiresAdmin: true },
  },

  // 404 Not Found
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: () => import('@/pages/NotFound.vue'),
    meta: { title: 'Page Not Found' },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return {
        ...savedPosition,
        behavior: 'instant',
      };
    }
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'instant',
        top: 80, // Account for fixed header
      };
    }
    return {
      top: 0,
      behavior: 'instant',
    };
  },
});

// Navigation guards
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const requiresAdmin = to.matched.some(record => record.meta.requiresAdmin);
  const requiresSuperAdmin = to.matched.some(record => record.meta.requiresSuperAdmin);
  const guestOnly = to.matched.some(record => record.meta.guest);

  // Set page title
  const appName = import.meta.env.VITE_APP_NAME || 'OmniviaTech';
  // A public page's first load keeps the full title the server already sent
  if (from !== START_LOCATION || to.meta.requiresAuth || to.meta.guest) {
    document.title = to.meta.title ? `${to.meta.title} - ${appName}` : appName;
  }

  // Fetch user if token exists but user not loaded. Only block navigation on it for routes
  // whose access depends on who is logged in — public pages render immediately and the
  // user loads in the background (App.vue also triggers this on startup).
  if (authStore.token && !authStore.user) {
    const needsUser = requiresAuth || requiresAdmin || requiresSuperAdmin || guestOnly;
    const pending = authStore.fetchUser().catch(() => {
      // Token invalid, will be handled by store
    });
    if (needsUser) await pending;
  }

  // Guest only routes (login, register) - redirect if authenticated
  if (guestOnly && authStore.isAuthenticated) {
    return next({ name: 'dashboard' });
  }

  // Protected routes - require authentication
  if (requiresAuth && !authStore.isAuthenticated) {
    return next({
      name: 'login',
      query: { redirect: to.fullPath },
    });
  }

  // Admin routes - require admin role
  if (requiresAdmin && !authStore.isAdmin) {
    return next({ name: 'dashboard' });
  }

  // SuperAdmin routes - require superadmin role
  if (requiresSuperAdmin && !authStore.isSuperAdmin) {
    return next({ name: 'admin' });
  }

  next();
});

// Prefetch the code for public pages once the visitor starts interacting and the browser is idle,
// so clicking a nav link renders instantly instead of waiting on a JS chunk download.
// Skipped on data-saver / very slow connections. Auth-only and admin pages are not prefetched.
router.isReady().then(() => {
  const conn = (navigator as any).connection;
  if (conn?.saveData || /(^|-)2g$/.test(conn?.effectiveType || '')) return;

  const loaders = router.getRoutes()
    .filter((r) => !r.meta.requiresAuth && !r.meta.requiresAdmin && !r.meta.requiresSuperAdmin && !r.meta.guest)
    .map((r) => r.components?.default)
    .filter((c): c is () => Promise<unknown> => typeof c === 'function');

  const idle: (cb: () => void) => void =
    (window as any).requestIdleCallback || ((cb: () => void) => setTimeout(cb, 1500));

  // Load one chunk per idle slot so prefetching never competes with the current page
  const next = () => {
    const load = loaders.shift();
    if (!load) return;
    load().catch(() => {}).finally(() => idle(next));
  };
  onEngaged(() => idle(next));
});

export default router;
