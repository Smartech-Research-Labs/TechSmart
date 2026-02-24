<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-display font-bold text-foreground mb-2">Site Settings</h1>
          <p class="text-muted-foreground">Configure your website settings</p>
        </div>
        <Button :disabled="saving" @click="saveSettings">
          <Loader2 v-if="saving" class="mr-2 h-4 w-4 animate-spin" />
          {{ saving ? 'Saving...' : 'Save Changes' }}
        </Button>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex items-center justify-center py-24">
        <Loader2 class="h-8 w-8 animate-spin text-primary" />
        <span class="ml-3 text-muted-foreground">Loading settings...</span>
      </div>

      <!-- Settings Tabs -->
      <Tabs v-else default-value="general" class="space-y-6">
        <TabsList class="grid w-full grid-cols-5">
          <TabsTrigger value="general">General</TabsTrigger>
          <TabsTrigger value="contact">Contact</TabsTrigger>
          <TabsTrigger value="social">Social Links</TabsTrigger>
          <TabsTrigger value="seo">SEO</TabsTrigger>
          <TabsTrigger value="branding">Branding</TabsTrigger>
        </TabsList>

        <!-- ═══════ General ═══════ -->
        <TabsContent value="general">
          <Card>
            <CardHeader>
              <CardTitle>General Settings</CardTitle>
              <CardDescription>Basic information about your website</CardDescription>
            </CardHeader>
            <CardContent class="space-y-6">
              <div class="space-y-2">
                <Label for="site_name">Site Name</Label>
                <Input id="site_name" v-model="form.site_name" placeholder="Your site name" />
              </div>
              <div class="space-y-2">
                <Label for="tagline">Tagline</Label>
                <Input id="tagline" v-model="form.tagline" placeholder="A short tagline" />
              </div>
              <div class="space-y-2">
                <Label for="site_description">Site Description</Label>
                <textarea
                  id="site_description"
                  v-model="form.site_description"
                  rows="3"
                  class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition resize-none"
                  placeholder="Describe your website"
                />
              </div>
              <div class="space-y-2">
                <Label for="copyright_text">Copyright Text</Label>
                <Input id="copyright_text" v-model="form.copyright_text" placeholder="© 2026 Your Company" />
              </div>
              <div class="space-y-2">
                <Label for="marquee_text">Marquee / Announcement Text</Label>
                <Input id="marquee_text" v-model="form.marquee_text" placeholder="Scrolling announcement text" />
              </div>

              <!-- Maintenance Mode Toggle -->
              <div class="flex items-center justify-between p-4 bg-muted/30 rounded-lg">
                <div>
                  <p class="text-foreground font-semibold">Maintenance Mode</p>
                  <p class="text-sm text-muted-foreground">Put the site in maintenance mode (visitors see a "coming soon" page)</p>
                </div>
                <button
                  type="button"
                  :class="[
                    'relative inline-flex h-6 w-11 items-center rounded-full transition-colors',
                    form.maintenance_mode ? 'bg-primary' : 'bg-border'
                  ]"
                  @click="form.maintenance_mode = !form.maintenance_mode"
                >
                  <span
                    :class="[
                      'inline-block h-4 w-4 transform rounded-full bg-white transition-transform',
                      form.maintenance_mode ? 'translate-x-6' : 'translate-x-1'
                    ]"
                  />
                </button>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <!-- ═══════ Contact ═══════ -->
        <TabsContent value="contact">
          <Card>
            <CardHeader>
              <CardTitle>Contact Information</CardTitle>
              <CardDescription>How customers can reach you</CardDescription>
            </CardHeader>
            <CardContent class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <Label for="contact_email">Contact Email</Label>
                  <Input id="contact_email" v-model="form.contact_email" type="email" placeholder="info@example.com" />
                </div>
                <div class="space-y-2">
                  <Label for="contact_phone">Phone Number</Label>
                  <Input id="contact_phone" v-model="form.contact_phone" type="tel" placeholder="+1 234 567 8900" />
                </div>
              </div>
              <div class="space-y-2">
                <Label for="address">Street Address</Label>
                <Input id="address" v-model="form.address" placeholder="123 Main Street" />
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <Label for="city">City</Label>
                  <Input id="city" v-model="form.city" placeholder="City" />
                </div>
                <div class="space-y-2">
                  <Label for="country">Country</Label>
                  <Input id="country" v-model="form.country" placeholder="Country" />
                </div>
              </div>
              <div class="space-y-2">
                <Label for="whatsapp_number">WhatsApp Number</Label>
                <Input id="whatsapp_number" v-model="form.whatsapp_number" type="tel" placeholder="+1 234 567 8900" />
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <!-- ═══════ Social Links ═══════ -->
        <TabsContent value="social">
          <Card>
            <CardHeader>
              <CardTitle>Social Media Links</CardTitle>
              <CardDescription>Your social media profiles</CardDescription>
            </CardHeader>
            <CardContent>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <Label for="facebook_url">Facebook</Label>
                  <Input id="facebook_url" v-model="form.facebook_url" type="url" placeholder="https://facebook.com/yourpage" />
                </div>
                <div class="space-y-2">
                  <Label for="twitter_url">Twitter / X</Label>
                  <Input id="twitter_url" v-model="form.twitter_url" type="url" placeholder="https://twitter.com/yourhandle" />
                </div>
                <div class="space-y-2">
                  <Label for="linkedin_url">LinkedIn</Label>
                  <Input id="linkedin_url" v-model="form.linkedin_url" type="url" placeholder="https://linkedin.com/company/yours" />
                </div>
                <div class="space-y-2">
                  <Label for="instagram_url">Instagram</Label>
                  <Input id="instagram_url" v-model="form.instagram_url" type="url" placeholder="https://instagram.com/yourprofile" />
                </div>
                <div class="space-y-2">
                  <Label for="youtube_url">YouTube</Label>
                  <Input id="youtube_url" v-model="form.youtube_url" type="url" placeholder="https://youtube.com/@yourchannel" />
                </div>
                <div class="space-y-2">
                  <Label for="tiktok_url">TikTok</Label>
                  <Input id="tiktok_url" v-model="form.tiktok_url" type="url" placeholder="https://tiktok.com/@yourprofile" />
                </div>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <!-- ═══════ SEO ═══════ -->
        <TabsContent value="seo">
          <Card>
            <CardHeader>
              <CardTitle>SEO Settings</CardTitle>
              <CardDescription>Search engine optimisation defaults for your site</CardDescription>
            </CardHeader>
            <CardContent class="space-y-6">
              <div class="space-y-2">
                <Label for="meta_title">Default Meta Title</Label>
                <Input id="meta_title" v-model="form.meta_title" placeholder="My Awesome Site — Tagline" />
              </div>
              <div class="space-y-2">
                <Label for="meta_description">Default Meta Description</Label>
                <textarea
                  id="meta_description"
                  v-model="form.meta_description"
                  rows="3"
                  class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition resize-none"
                  placeholder="A brief description of your website for search engines"
                />
              </div>
              <div class="space-y-2">
                <Label for="meta_keywords">Meta Keywords</Label>
                <Input id="meta_keywords" v-model="form.meta_keywords" placeholder="keyword1, keyword2, keyword3" />
                <p class="text-xs text-muted-foreground">Comma-separated list of keywords</p>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <!-- ═══════ Branding ═══════ -->
        <TabsContent value="branding">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Logo Upload -->
            <Card>
              <CardHeader>
                <CardTitle>Site Logo</CardTitle>
                <CardDescription>PNG, JPG, SVG or WebP — max 4 MB</CardDescription>
              </CardHeader>
              <CardContent class="space-y-4">
                <div
                  v-if="logoPreview || form.logo_path"
                  class="flex items-center justify-center rounded-lg border border-border bg-muted/30 p-6"
                >
                  <img
                    :src="logoPreview || storageUrl(form.logo_path)"
                    alt="Site logo"
                    class="max-h-24 object-contain"
                  />
                </div>
                <div v-else class="flex items-center justify-center rounded-lg border border-dashed border-border bg-muted/20 p-10 text-muted-foreground text-sm">
                  No logo uploaded
                </div>
                <div class="flex items-center gap-3">
                  <input
                    ref="logoInput"
                    type="file"
                    accept="image/png,image/jpeg,image/svg+xml,image/webp"
                    class="hidden"
                    @change="onLogoSelected"
                  />
                  <Button variant="outline" :disabled="uploadingLogo" @click="($refs.logoInput as HTMLInputElement).click()">
                    Choose File
                  </Button>
                  <Button v-if="logoFile" :disabled="uploadingLogo" @click="uploadLogo">
                    <Loader2 v-if="uploadingLogo" class="mr-2 h-4 w-4 animate-spin" />
                    {{ uploadingLogo ? 'Uploading...' : 'Upload Logo' }}
                  </Button>
                  <span v-if="logoFile" class="text-sm text-muted-foreground truncate max-w-[180px]">{{ logoFile.name }}</span>
                </div>
              </CardContent>
            </Card>

            <!-- Favicon Upload -->
            <Card>
              <CardHeader>
                <CardTitle>Favicon</CardTitle>
                <CardDescription>PNG, JPG, ICO or SVG — max 1 MB</CardDescription>
              </CardHeader>
              <CardContent class="space-y-4">
                <div
                  v-if="faviconPreview || form.favicon_path"
                  class="flex items-center justify-center rounded-lg border border-border bg-muted/30 p-6"
                >
                  <img
                    :src="faviconPreview || storageUrl(form.favicon_path)"
                    alt="Favicon"
                    class="max-h-16 object-contain"
                  />
                </div>
                <div v-else class="flex items-center justify-center rounded-lg border border-dashed border-border bg-muted/20 p-10 text-muted-foreground text-sm">
                  No favicon uploaded
                </div>
                <div class="flex items-center gap-3">
                  <input
                    ref="faviconInput"
                    type="file"
                    accept="image/png,image/jpeg,image/x-icon,image/svg+xml"
                    class="hidden"
                    @change="onFaviconSelected"
                  />
                  <Button variant="outline" :disabled="uploadingFavicon" @click="($refs.faviconInput as HTMLInputElement).click()">
                    Choose File
                  </Button>
                  <Button v-if="faviconFile" :disabled="uploadingFavicon" @click="uploadFavicon">
                    <Loader2 v-if="uploadingFavicon" class="mr-2 h-4 w-4 animate-spin" />
                    {{ uploadingFavicon ? 'Uploading...' : 'Upload Favicon' }}
                  </Button>
                  <span v-if="faviconFile" class="text-sm text-muted-foreground truncate max-w-[180px]">{{ faviconFile.name }}</span>
                </div>
              </CardContent>
            </Card>
          </div>
        </TabsContent>
      </Tabs>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import { Loader2 } from 'lucide-vue-next';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';

// ── API & Toast ──
const { get, put, post } = useApi();
const toast = useToast();

// ── Loading / saving state ──
const loading = ref(true);
const saving = ref(false);
const uploadingLogo = ref(false);
const uploadingFavicon = ref(false);

// ── Form state ──
const form = reactive({
  // General
  site_name: '',
  tagline: '',
  site_description: '',
  copyright_text: '',
  marquee_text: '',
  maintenance_mode: false,
  // Contact
  contact_email: '',
  contact_phone: '',
  address: '',
  city: '',
  country: '',
  whatsapp_number: '',
  // Social
  facebook_url: '',
  twitter_url: '',
  linkedin_url: '',
  instagram_url: '',
  youtube_url: '',
  tiktok_url: '',
  // SEO
  meta_title: '',
  meta_description: '',
  meta_keywords: '',
  // Branding (paths only — used for preview)
  logo_path: '',
  favicon_path: '',
});

// ── File upload refs ──
const logoInput = ref<HTMLInputElement | null>(null);
const faviconInput = ref<HTMLInputElement | null>(null);
const logoFile = ref<File | null>(null);
const faviconFile = ref<File | null>(null);
const logoPreview = ref<string | null>(null);
const faviconPreview = ref<string | null>(null);

// ── Helpers ──
function storageUrl(path: string | null | undefined): string {
  if (!path) return '';
  if (path.startsWith('http')) return path;
  return `/storage/${path}`;
}

/** Flatten grouped settings response into our flat reactive form. */
function populateForm(grouped: Record<string, Record<string, string>>) {
  for (const group of Object.values(grouped)) {
    for (const [key, value] of Object.entries(group)) {
      if (key in form) {
        if (key === 'maintenance_mode') {
          (form as any)[key] = value === '1' || value === 'true' || value === true;
        } else {
          (form as any)[key] = value ?? '';
        }
      }
    }
  }
}

/** Convert our flat form into the array format the backend expects. */
function buildPayload() {
  const groupMap: Record<string, string> = {
    site_name: 'general',
    tagline: 'general',
    site_description: 'general',
    copyright_text: 'general',
    marquee_text: 'general',
    maintenance_mode: 'general',
    contact_email: 'contact',
    contact_phone: 'contact',
    address: 'contact',
    city: 'contact',
    country: 'contact',
    whatsapp_number: 'contact',
    facebook_url: 'social',
    twitter_url: 'social',
    linkedin_url: 'social',
    instagram_url: 'social',
    youtube_url: 'social',
    tiktok_url: 'social',
    meta_title: 'seo',
    meta_description: 'seo',
    meta_keywords: 'seo',
  };

  return Object.entries(groupMap).map(([key, group]) => ({
    key,
    value: key === 'maintenance_mode' ? ((form as any)[key] ? '1' : '0') : (form as any)[key],
    group,
  }));
}

// ── Fetch settings ──
async function fetchSettings() {
  loading.value = true;
  try {
    const data = await get('/admin/settings');
    populateForm(data.settings ?? data);
  } catch (e: any) {
    toast.error('Failed to load settings', e?.response?.data?.message ?? 'Please try again.');
  } finally {
    loading.value = false;
  }
}

// ── Save settings ──
async function saveSettings() {
  saving.value = true;
  try {
    await put('/admin/settings', { settings: buildPayload() });
    toast.success('Settings saved', 'Your changes have been saved successfully.');
  } catch (e: any) {
    toast.error('Save failed', e?.response?.data?.message ?? 'Please try again.');
  } finally {
    saving.value = false;
  }
}

// ── Logo ──
function onLogoSelected(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0];
  if (!file) return;
  logoFile.value = file;
  logoPreview.value = URL.createObjectURL(file);
}

async function uploadLogo() {
  if (!logoFile.value) return;
  uploadingLogo.value = true;
  try {
    const fd = new FormData();
    fd.append('logo', logoFile.value);
    const data = await post('/admin/settings/logo', fd, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });
    form.logo_path = data.logo_path ?? '';
    logoFile.value = null;
    if (logoPreview.value) { URL.revokeObjectURL(logoPreview.value); logoPreview.value = null; }
    toast.success('Logo uploaded', 'The site logo has been updated.');
  } catch (e: any) {
    toast.error('Upload failed', e?.response?.data?.message ?? 'Could not upload logo.');
  } finally {
    uploadingLogo.value = false;
  }
}

// ── Favicon ──
function onFaviconSelected(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0];
  if (!file) return;
  faviconFile.value = file;
  faviconPreview.value = URL.createObjectURL(file);
}

async function uploadFavicon() {
  if (!faviconFile.value) return;
  uploadingFavicon.value = true;
  try {
    const fd = new FormData();
    fd.append('favicon', faviconFile.value);
    const data = await post('/admin/settings/favicon', fd, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });
    form.favicon_path = data.favicon_path ?? '';
    faviconFile.value = null;
    if (faviconPreview.value) { URL.revokeObjectURL(faviconPreview.value); faviconPreview.value = null; }
    toast.success('Favicon uploaded', 'The site favicon has been updated.');
  } catch (e: any) {
    toast.error('Upload failed', e?.response?.data?.message ?? 'Could not upload favicon.');
  } finally {
    uploadingFavicon.value = false;
  }
}

// ── Init ──
onMounted(fetchSettings);
</script>
