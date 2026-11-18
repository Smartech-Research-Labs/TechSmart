import axios from 'axios';
import { START_LOCATION, type Router } from 'vue-router';

// The first page load already has the right tags from the server. This keeps
// them correct when a visitor moves between pages inside the app.
function setMeta(attr: 'name' | 'property', key: string, content: string) {
  let tag = document.head.querySelector<HTMLMetaElement>(`meta[${attr}="${key}"]`);
  if (!tag) {
    tag = document.createElement('meta');
    tag.setAttribute(attr, key);
    document.head.appendChild(tag);
  }
  tag.content = content;
}

function applyPageSeo(seo: any) {
  document.title = seo.title;
  setMeta('name', 'description', seo.description);
  setMeta('name', 'robots', seo.robots);
  setMeta('property', 'og:title', seo.title);
  setMeta('property', 'og:description', seo.description);
  setMeta('property', 'og:url', seo.canonical);
  setMeta('property', 'og:type', seo.type);
  setMeta('property', 'og:image', seo.image);
  setMeta('name', 'twitter:title', seo.title);
  setMeta('name', 'twitter:description', seo.description);
  setMeta('name', 'twitter:image', seo.image);

  let canonical = document.head.querySelector<HTMLLinkElement>('link[rel="canonical"]');
  if (!canonical) {
    canonical = document.createElement('link');
    canonical.rel = 'canonical';
    document.head.appendChild(canonical);
  }
  canonical.href = seo.canonical;

  document.getElementById('page-article-schema')?.remove();
  let breadcrumbs = document.getElementById('page-breadcrumb-schema');
  if (!seo.breadcrumb_schema) {
    breadcrumbs?.remove();
    return;
  }
  if (!breadcrumbs) {
    breadcrumbs = document.createElement('script');
    breadcrumbs.id = 'page-breadcrumb-schema';
    breadcrumbs.setAttribute('type', 'application/ld+json');
    document.head.appendChild(breadcrumbs);
  }
  breadcrumbs.textContent = JSON.stringify(seo.breadcrumb_schema);
}

export function installPageSeo(router: Router) {
  let latest = 0;

  router.afterEach((to, from, failure) => {
    if (failure || from === START_LOCATION || to.path === from.path || to.meta.requiresAuth) return;

    const request = ++latest;
    axios
      .get('/api/v1/seo/resolve', { params: { path: to.path } })
      .then(({ data }) => {
        if (request === latest) applyPageSeo(data);
      })
      .catch(() => {});
  });
}
