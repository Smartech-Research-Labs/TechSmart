import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import App from './App.vue';
import '../css/app.css';

// Create Vue app instance
const app = createApp(App);

// Create and use Pinia store
const pinia = createPinia();
app.use(pinia);

// Use Vue Router
app.use(router);

// Mount app
app.mount('#app');
