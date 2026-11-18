import tech1 from '@/../img/tech1.webp';
import tech2 from '@/../img/tech2.webp';
import tech3 from '@/../img/tech3.webp';
import tech4 from '@/../img/tech4.webp';
import tech5 from '@/../img/tech5.webp';
import tech6 from '@/../img/tech6.webp';

// The default blog covers ship with the site, so they load even if the server's
// storage folder is missing them. Images uploaded in admin still come from /storage.
const bundledCovers: Record<string, string> = {
  'blog/tech1.webp': tech1,
  'blog/tech2.webp': tech2,
  'blog/tech3.webp': tech3,
  'blog/tech4.webp': tech4,
  'blog/tech5.webp': tech5,
  'blog/tech6.webp': tech6,
};

export function blogImageUrl(path?: string | null): string {
  if (!path) return '';
  if (path.startsWith('http')) return path;
  const clean = path.replace(/^\/+/, '').replace(/^storage\//, '');
  return bundledCovers[clean] || `/storage/${clean}`;
}
