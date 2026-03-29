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
    primary: '#d311f5',
    accent: '#3b82f6',
    ring: '#d311f5',
    'sidebar-primary': '#d311f5',
    'sidebar-ring': '#d311f5',
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

/**
 * Apply a set of CSS color variables onto :root (light) and .dark (dark).
 * Also stores the preset name in localStorage for instant application on reload.
 */
function applyColors(colors: ThemeColorMap) {
  const root = document.documentElement;
  for (const [key, value] of Object.entries(colors)) {
    if (value) {
      root.style.setProperty(`--${key}`, value);
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
