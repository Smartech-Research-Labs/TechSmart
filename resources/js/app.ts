import axios from 'axios';
import { createPinia } from 'pinia';
import { createApp } from 'vue';
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

// Mount app
app.mount('#app');

// Once the first page is up, quietly load the main listing pages' content in the background
router.isReady().then(prefetchPublicContent);
