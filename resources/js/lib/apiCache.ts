import axios, { type AxiosAdapter, type AxiosInstance, type AxiosResponse, type InternalAxiosRequestConfig } from 'axios';

/**
 * Short-lived cache for public, read-only API content (home, products, packages, services,
 * blogs, reviews, FAQs …) so pages render instantly when revisited instead of showing a
 * spinner on every navigation.
 *
 * - Only GET requests to the allow-listed public endpoints below are cached.
 *   User, auth, chat, wishlist, cookie-consent and admin endpoints never are.
 * - Identical requests made at the same time share one network call.
 * - Any non-GET request (create / update / delete) clears the whole cache, so edits made
 *   in the admin or on the site show up immediately.
 * - Entries live for TTL_MS and are mirrored to sessionStorage so a page reload is instant too.
 */
const TTL_MS = 5 * 60 * 1000;
const STORAGE_KEY = 'api-cache-v1';

const CACHEABLE = /^\/api\/v1\/(home|packages|products|services|blogs?|reviews|case-studies|industries|faqs|bundles|specializations|pages)(\/|\?|$)/;

type Entry = { at: number; status: number; data: unknown; headers: Record<string, string> };

const store = new Map<string, Entry>();
const inflight = new Map<string, Promise<AxiosResponse>>();

// ── sessionStorage mirror (best-effort; storage may be unavailable) ──
try {
  const saved = JSON.parse(sessionStorage.getItem(STORAGE_KEY) || '{}') as Record<string, Entry>;
  const now = Date.now();
  for (const [k, v] of Object.entries(saved)) if (now - v.at < TTL_MS) store.set(k, v);
} catch { /* ignore */ }

let persistTimer: ReturnType<typeof setTimeout> | null = null;
function persist() {
  if (persistTimer) return;
  persistTimer = setTimeout(() => {
    persistTimer = null;
    try { sessionStorage.setItem(STORAGE_KEY, JSON.stringify(Object.fromEntries(store))); } catch { /* quota / disabled */ }
  }, 300);
}

export function clearApiCache() {
  store.clear();
  try { sessionStorage.removeItem(STORAGE_KEY); } catch { /* ignore */ }
}

function fullPath(config: InternalAxiosRequestConfig): string {
  const base = (config.baseURL || '').replace(/\/+$/, '');
  const url = config.url || '';
  if (/^https?:\/\//i.test(url)) {
    try { return new URL(url).pathname; } catch { return url; }
  }
  return url.startsWith('/') && !url.startsWith('/api') && base ? `${base}${url}` : (base && !url.startsWith('/') ? `${base}/${url}` : url);
}

function cacheKey(path: string, params: unknown): string {
  if (!params || typeof params !== 'object') return path;
  const sorted = Object.keys(params as Record<string, unknown>).sort()
    .filter((k) => (params as any)[k] !== undefined && (params as any)[k] !== null && (params as any)[k] !== '')
    .map((k) => `${encodeURIComponent(k)}=${encodeURIComponent(String((params as any)[k]))}`);
  return sorted.length ? `${path}?${sorted.join('&')}` : path;
}

function toResponse(entry: Entry, config: InternalAxiosRequestConfig): AxiosResponse {
  return { data: entry.data, status: entry.status, statusText: 'OK', headers: entry.headers, config, request: {} } as AxiosResponse;
}

const installed = new WeakSet<AxiosInstance>();

/** Wrap an axios instance's adapter with the public-content cache. */
export function installApiCache(instance: AxiosInstance) {
  if (installed.has(instance)) return;
  installed.add(instance);

  const baseAdapter = axios.getAdapter(instance.defaults.adapter as any) as AxiosAdapter;

  instance.defaults.adapter = async (config: InternalAxiosRequestConfig) => {
    const method = (config.method || 'get').toLowerCase();

    if (method !== 'get') {
      clearApiCache();
      return baseAdapter(config);
    }

    const path = fullPath(config);
    if (!CACHEABLE.test(path)) return baseAdapter(config);

    const key = cacheKey(path, config.params);
    const hit = store.get(key);
    if (hit && Date.now() - hit.at < TTL_MS) return toResponse(hit, config);

    const pending = inflight.get(key);
    if (pending) {
      const res = await pending;
      // Serve from the stored raw (unparsed) copy so each caller gets its own parsed object
      const stored = store.get(key);
      return stored ? toResponse(stored, config) : { ...res, config };
    }

    const request = baseAdapter(config).then((res) => {
      if (res.status >= 200 && res.status < 300) {
        const headers: Record<string, string> = {};
        const ct = (res.headers as any)?.['content-type'];
        if (ct) headers['content-type'] = String(ct);
        store.set(key, { at: Date.now(), status: res.status, data: res.data, headers });
        persist();
      }
      return res;
    }).finally(() => inflight.delete(key));

    inflight.set(key, request);
    return request;
  };
}

/**
 * Warm the cache for the main listing pages while the browser is idle, so the first
 * visit to those pages is instant too. Uses exactly the requests those pages make.
 */
export function prefetchPublicContent() {
  const conn = (navigator as any).connection;
  if (conn?.saveData || /(^|-)2g$/.test(conn?.effectiveType || '')) return;

  const requests: Array<[string, Record<string, unknown>?]> = [
    ['/api/v1/products', { page: 1 }],
    ['/api/v1/packages'],
    ['/api/v1/services'],
    ['/api/v1/bundles'],
    ['/api/v1/home/faqs'],
    ['/api/v1/reviews', { limit: 6 }],
    ['/api/v1/reviews', { limit: 8 }],
    ['/api/v1/blogs', { limit: 4 }],
  ];

  const idle: (cb: () => void) => void =
    (window as any).requestIdleCallback || ((cb: () => void) => setTimeout(cb, 1200));

  const next = () => {
    const item = requests.shift();
    if (!item) return;
    axios.get(item[0], item[1] ? { params: item[1] } : undefined).catch(() => {}).finally(() => idle(next));
  };
  idle(next);
}
