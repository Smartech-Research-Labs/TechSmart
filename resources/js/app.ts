import axios from 'axios';
import { createPinia } from 'pinia';
import { createApp } from 'vue';
import { installPageSeo } from './lib/pageSeo';
import App from './App.vue';
import { installApiCache, prefetchPublicContent } from './lib/apiCache';
import router from './router';
import '../css/app.css';

// Serve repeat requests for public content from a short-lived cache (instant page loads)
installApiCache(axios);

// Create Vue app instance
const app = createApp(App);

// Create and use Pinia store
const pinia = createPinia();
app.use(pinia);

// Use Vue Router
app.use(router);

// The stylesheet is loaded without holding up the first paint (see app.blade.php), so wait
// until it is applied before starting; otherwise the app would flash unstyled.
function appStylesReady(): Promise<void> {
  const link = document.querySelector<HTMLLinkElement>('link[data-app-css]');
  if (!link) return Promise.resolve();
  return new Promise((resolve) => {
    const check = () => {
      if (link.rel === 'stylesheet' && link.sheet) resolve();
    };
    link.addEventListener('load', () => {
      if (link.rel !== 'stylesheet') link.rel = 'stylesheet';
      check();
    });
    link.addEventListener('error', () => resolve());
    setTimeout(resolve, 4000);
    check();
  });
}

// Mount once the styles and the first page's code are ready, so the still copy of the
// page in the HTML is swapped straight for the finished page, with no blank moment.
installPageSeo(router);
Promise.all([appStylesReady(), router.isReady()]).then(() => app.mount('#app'));

// Once the first page is up, quietly load the main listing pages' content in the background
router.isReady().then(prefetchPublicContent);
