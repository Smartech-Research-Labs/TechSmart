/**
 * useThemeColors composable
 * Dynamically applies theme colors from the CMS settings onto CSS custom properties,
 * so the entire website reflects the Superadmin's chosen colour palette.
 *
 * Works with the existing CSS variable system: --primary, --accent, etc.
 */
import { watch, onMounted } from 'vue';
import { useCmsStore } from '@/stores/cms';

type ThemeColorMap = Record<string, string>;

// Default presets that match common brand palettes
export const themePresets: Record<string, ThemeColorMap> = {
  purple: {
    primary: '#ad0ec9',
    accent: '#3b82f6',
    ring: '#ad0ec9',
    'sidebar-primary': '#ad0ec9',
    'sidebar-ring': '#ad0ec9',
  },
  blue: {
    primary: '#2563eb',
    accent: '#06b6d4',
    ring: '#2563eb',
    'sidebar-primary': '#2563eb',
    'sidebar-ring': '#2563eb',
  },
  green: {
    primary: '#16a34a',
    accent: '#0d9488',
    ring: '#16a34a',
    'sidebar-primary': '#16a34a',
    'sidebar-ring': '#16a34a',
  },
  orange: {
    primary: '#ea580c',
    accent: '#f59e0b',
    ring: '#ea580c',
    'sidebar-primary': '#ea580c',
    'sidebar-ring': '#ea580c',
  },
  red: {
    primary: '#dc2626',
    accent: '#f43f5e',
    ring: '#dc2626',
    'sidebar-primary': '#dc2626',
    'sidebar-ring': '#dc2626',
  },
  teal: {
    primary: '#0d9488',
    accent: '#6366f1',
    ring: '#0d9488',
    'sidebar-primary': '#0d9488',
    'sidebar-ring': '#0d9488',
  },
  indigo: {
    primary: '#4f46e5',
    accent: '#8b5cf6',
    ring: '#4f46e5',
    'sidebar-primary': '#4f46e5',
    'sidebar-ring': '#4f46e5',
  },
  pink: {
    primary: '#ec4899',
    accent: '#f472b6',
    ring: '#ec4899',
    'sidebar-primary': '#ec4899',
    'sidebar-ring': '#ec4899',
  },
};

// ── Contrast guard ──────────────────────────────────────────────────────────
// The primary colour is used for small text on white/light-grey sections and as a
// background behind white text, so it must reach WCAG AA (4.5:1) in both roles.
// A CMS-chosen colour that is too light is darkened just enough, keeping its hue.
const PRIMARY_KEYS = new Set(['primary', 'ring', 'sidebar-primary', 'sidebar-ring']);
const LIGHTEST_SECTION_BG: [number, number, number] = [0xf1, 0xf5, 0xf9]; // slate-100 sections
const MIN_CONTRAST = 5; // a little above 4.5 so primary/10 tinted chips pass too

function parseHex(hex: string): [number, number, number] | null {
  const m = /^#?([0-9a-f]{3}|[0-9a-f]{6})$/i.exec(hex.trim());
  if (!m) return null;
  const h = m[1].length === 3 ? m[1].replace(/./g, (c) => c + c) : m[1];
  return [0, 2, 4].map((i) => parseInt(h.slice(i, i + 2), 16)) as [number, number, number];
}

function luminance([r, g, b]: [number, number, number]) {
  const lin = (c: number) => {
    const v = c / 255;
    return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
  };
  return 0.2126 * lin(r) + 0.7152 * lin(g) + 0.0722 * lin(b);
}

export function accessiblePrimary(hex: string): string {
  const rgb = parseHex(hex);
  if (!rgb) return hex;
  const bg = luminance(LIGHTEST_SECTION_BG);
  let current = rgb;
  for (let i = 0; i < 40 && (bg + 0.05) / (luminance(current) + 0.05) < MIN_CONTRAST; i++) {
    current = current.map((c) => Math.round(c * 0.97)) as [number, number, number];
  }
  return '#' + current.map((c) => c.toString(16).padStart(2, '0')).join('');
}

/**
 * Apply a set of CSS color variables onto :root (light) and .dark (dark).
 * Also stores the preset name in localStorage for instant application on reload.
 */
function applyColors(colors: ThemeColorMap) {
  const root = document.documentElement;
  for (const [key, value] of Object.entries(colors)) {
    if (value) {
      root.style.setProperty(`--${key}`, PRIMARY_KEYS.has(key) ? accessiblePrimary(value) : value);
    }
  }
}

/**
 * Apply theme from saved setting on initial load (before API response).
 * Uses localStorage for instant paint.
 */
export function initializeThemeColors() {
  const saved = localStorage.getItem('theme_preset');
  if (saved && themePresets[saved]) {
    applyColors(themePresets[saved]);
  }

  // Also check for custom colors
  const custom = localStorage.getItem('theme_custom_colors');
  if (custom) {
    try {
      applyColors(JSON.parse(custom));
    } catch {
      // ignore
    }
  }
}

/**
 * Vue composable to reactively sync theme colors from CMS settings.
 */
export function useThemeColors() {
  const cmsStore = useCmsStore();

  function applyFromSettings(settings: any) {
    if (!settings) return;

    const preset = settings.theme_preset;
    const customPrimary = settings.theme_primary_color;
    const customAccent = settings.theme_accent_color;

    if (preset && themePresets[preset]) {
      applyColors(themePresets[preset]);
      localStorage.setItem('theme_preset', preset);
      localStorage.removeItem('theme_custom_colors');
    }

    // Custom colors override preset
    if (customPrimary || customAccent) {
      const custom: ThemeColorMap = {};
      if (customPrimary) {
        custom.primary = customPrimary;
        custom.ring = customPrimary;
        custom['sidebar-primary'] = customPrimary;
        custom['sidebar-ring'] = customPrimary;
      }
      if (customAccent) {
        custom.accent = customAccent;
      }
      applyColors(custom);
      localStorage.setItem('theme_custom_colors', JSON.stringify(custom));
    }
  }

  // Watch CMS store for settings changes
  watch(
    () => cmsStore.homeData?.settings,
    (newSettings) => {
      if (newSettings) {
        applyFromSettings(newSettings);
      }
    },
    { immediate: true }
  );

  return {
    applyColors,
    applyFromSettings,
    themePresets,
    initializeThemeColors,
  };
}
