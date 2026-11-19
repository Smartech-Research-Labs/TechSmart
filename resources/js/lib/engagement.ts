/**
 * Runs work once the visitor first interacts with the page (scroll, tap, key press, mouse move).
 *
 * Background extras — prefetching other pages, rotating the hero, scrolling the ticker — wait
 * for this so they never compete with the first page load for bandwidth or the main thread.
 * Adds the `engaged` class to <html> at the same moment, for CSS animations that should wait too.
 */
const EVENTS = ['scroll', 'wheel', 'pointerdown', 'pointermove', 'keydown', 'touchstart'] as const;

let engaged = false;
const callbacks: Array<() => void> = [];

function markEngaged() {
  if (engaged) return;
  engaged = true;
  EVENTS.forEach((event) => window.removeEventListener(event, markEngaged));
  document.documentElement.classList.add('engaged');
  callbacks.splice(0).forEach((callback) => callback());
}

if (typeof window !== 'undefined') {
  EVENTS.forEach((event) => window.addEventListener(event, markEngaged, { passive: true }));
}

export function onEngaged(callback: () => void) {
  if (engaged) callback();
  else callbacks.push(callback);
}
