import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

interface Slider {
  id: number;
  title: string;
  subtitle: string;
  image_url: string;
  cta_text?: string;
  cta_link?: string;
  order: number;
}

interface Counter {
  id: number;
  title: string;
  value: number;
  suffix?: string;
  icon?: string;
  order: number;
}

interface Client {
  id: number;
  name: string;
  logo_url: string;
  website_url?: string;
}

interface TeamMember {
  id: number;
  name: string;
  position: string;
  bio?: string;
  image_url?: string;
  email?: string;
  linkedin_url?: string;
  twitter_url?: string;
}

interface Service {
  id: number;
  title: string;
  slug: string;
  excerpt?: string;
  icon?: string;
  category?: string;
  is_featured: boolean;
}

interface Product {
  id: number;
  name: string;
  slug: string;
  excerpt?: string;
  price?: number;
  image_url?: string;
  category?: string;
  is_featured: boolean;
}

interface Bundle {
  id: number;
  name: string;
  slug: string;
  description?: string;
  price?: number;
  discount_percentage?: number;
  is_featured: boolean;
}

interface MapDataPoint {
  id: number;
  county: string;
  latitude: number;
  longitude: number;
  value: number;
  label?: string;
}

interface Settings {
  site_name?: string;
  tagline?: string;
  contact_email?: string;
  contact_phone?: string;
  address?: string;
  logo_path?: string;
  logo_url?: string;
  marquee_text?: string;
  facebook_url?: string;
  twitter_url?: string;
  linkedin_url?: string;
  instagram_url?: string;
  youtube_url?: string;
  tiktok_url?: string;
  whatsapp_number?: string;
  copyright_text?: string;
}

interface HomeData {
  sliders: Slider[];
  counters: Counter[];
  featured_services: Service[];
  featured_products: Product[];
  featured_bundles: Bundle[];
  clients: Client[];
  recent_blogs: any[];
  settings: Settings;
}

export const useCmsStore = defineStore('cms', () => {
  const homeData = ref<HomeData | null>(null);
  const team = ref<TeamMember[]>([]);
  const mapData = ref<MapDataPoint[]>([]);
  const loading = ref(false);
  const error = ref<string | null>(null);

  async function fetchHomeData() {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.get('/api/v1/home');
      homeData.value = response.data;
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch home data';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function fetchTeam() {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.get('/api/v1/home/team');
      team.value = response.data.team;
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch team';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  async function fetchMapData() {
    loading.value = true;
    error.value = null;
    try {
      const response = await axios.get('/api/v1/home/map-data');
      mapData.value = response.data.map_data;
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch map data';
      throw err;
    } finally {
      loading.value = false;
    }
  }

  function clearCache() {
    homeData.value = null;
    team.value = [];
    mapData.value = [];
  }

  return {
    homeData,
    team,
    mapData,
    loading,
    error,
    fetchHomeData,
    fetchTeam,
    fetchMapData,
    clearCache,
  };
});
