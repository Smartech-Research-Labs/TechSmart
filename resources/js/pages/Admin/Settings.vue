<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground mb-1">Site Settings</h1>
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
        <TabsList class="grid w-full grid-cols-3 sm:grid-cols-5 md:grid-cols-9">
          <TabsTrigger value="general">General</TabsTrigger>
          <TabsTrigger value="contact">Contact</TabsTrigger>
          <TabsTrigger value="social">Social Links</TabsTrigger>
          <TabsTrigger value="seo">SEO</TabsTrigger>
          <TabsTrigger value="branding">Branding</TabsTrigger>
          <TabsTrigger value="images">Images</TabsTrigger>
          <TabsTrigger value="theme">Theme</TabsTrigger>
          <TabsTrigger value="email">Email/SMTP</TabsTrigger>
          <TabsTrigger value="analytics">Analytics</TabsTrigger>
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
              <CardDescription>Search engine optimisation defaults for your site. Per-page SEO helps each page rank on Google individually.</CardDescription>
            </CardHeader>
            <CardContent class="space-y-6">
              <!-- Global Defaults -->
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

              <!-- Schema Markup -->
              <div class="border-t border-border pt-6">
                <h3 class="text-sm font-semibold text-foreground mb-4">Schema Markup / Structured Data</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="space-y-2">
                    <Label for="schema_org_type">Organization Type</Label>
                    <select id="schema_org_type" v-model="form.schema_org_type" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition">
                      <option value="Organization">Organization</option>
                      <option value="Corporation">Corporation</option>
                      <option value="LocalBusiness">Local Business</option>
                      <option value="ProfessionalService">Professional Service</option>
                      <option value="ITCompany">IT Company</option>
                    </select>
                  </div>
                  <div class="space-y-2">
                    <Label for="schema_org_name">Schema Organization Name</Label>
                    <Input id="schema_org_name" v-model="form.schema_org_name" placeholder="Smartech Research Labs" />
                  </div>
                  <div class="space-y-2">
                    <Label for="schema_org_logo">Schema Logo URL</Label>
                    <Input id="schema_org_logo" v-model="form.schema_org_logo" placeholder="https://yoursite.com/logo.png" />
                    <p class="text-xs text-muted-foreground">Full URL to logo for Google Knowledge Panel</p>
                  </div>
                  <div class="space-y-2">
                    <Label for="schema_same_as">Social Profiles for Schema (one per line)</Label>
                    <textarea id="schema_same_as" v-model="form.schema_same_as" rows="3" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition resize-none" placeholder="https://facebook.com/yourpage&#10;https://twitter.com/yourhandle&#10;https://linkedin.com/company/yours"></textarea>
                  </div>
                </div>
              </div>

              <!-- Breadcrumbs & Technical SEO -->
              <div class="border-t border-border pt-6">
                <h3 class="text-sm font-semibold text-foreground mb-4">Technical SEO</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="space-y-2">
                    <Label for="canonical_url">Canonical Base URL</Label>
                    <Input id="canonical_url" v-model="form.canonical_url" placeholder="https://smartechresearchlabs.co.ke" />
                    <p class="text-xs text-muted-foreground">Used to generate canonical URLs and breadcrumb markup</p>
                  </div>
                  <div class="space-y-2">
                    <Label for="og_image_default">Default Open Graph Image</Label>
                    <Input id="og_image_default" v-model="form.og_image_default" placeholder="https://yoursite.com/og-image.jpg" />
                    <p class="text-xs text-muted-foreground">1200×630px recommended for social sharing</p>
                  </div>
                  <div class="space-y-2">
                    <Label for="twitter_card_type">Twitter Card Type</Label>
                    <select id="twitter_card_type" v-model="form.twitter_card_type" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition">
                      <option value="summary_large_image">Summary Large Image</option>
                      <option value="summary">Summary</option>
                    </select>
                  </div>
                  <div class="space-y-2">
                    <Label for="twitter_handle">Twitter Handle</Label>
                    <Input id="twitter_handle" v-model="form.twitter_handle" placeholder="@smartechresearch" />
                  </div>
                </div>
              </div>

              <!-- Per-Page SEO -->
              <div class="border-t border-border pt-6">
                <h3 class="text-sm font-semibold text-foreground mb-1">Per-Page Meta Tags</h3>
                <p class="text-xs text-muted-foreground mb-4">Override meta title and description for individual pages to boost ranking</p>
                <div class="space-y-4">
                  <div v-for="pg in seoPages" :key="pg.key" class="bg-muted/30 border border-border rounded-lg p-4">
                    <h4 class="text-xs font-semibold text-foreground uppercase tracking-wide mb-3">{{ pg.label }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div class="space-y-1">
                        <Label class="text-xs">Title</Label>
                        <Input v-model="(form as any)[pg.key + '_meta_title']" :placeholder="pg.label + ' — Smartech Research Labs'" />
                      </div>
                      <div class="space-y-1">
                        <Label class="text-xs">Description</Label>
                        <Input v-model="(form as any)[pg.key + '_meta_description']" :placeholder="'Discover our ' + pg.label.toLowerCase() + '...'" />
                      </div>
                    </div>
                  </div>
                </div>
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
        <!-- ═══════ Images ═══════ -->
        <TabsContent value="images">
          <Card>
            <CardHeader>
              <CardTitle>Section Images</CardTitle>
              <CardDescription>Manage images used across the website. Upload images (auto-converted to WebP for optimization) or pick from the media gallery.</CardDescription>
            </CardHeader>
            <CardContent class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <ImageUploader v-model="form.hero_bg_image" label="Hero Background Image" description="Used as the main hero background on Home, Services, Products pages" field-id="hero_bg_image" />
                <ImageUploader v-model="form.about_section_image" label="About Section Image" description="Team/office photo for the About Us section on Home page" field-id="about_section_image" />
                <ImageUploader v-model="form.values_section_image" label="Core Values Image" description="Image for the Core Values section" field-id="values_section_image" />
                <ImageUploader v-model="form.cta_professional_image" label="CTA Professional Image" description="Person photo used in CTA / call-to-action sections" field-id="cta_professional_image" />
                <ImageUploader v-model="form.quote_section_image" label="Quote Section Image" description="Image for the Request a Quote section" field-id="quote_section_image" />
                <ImageUploader v-model="form.office_image" label="Office Image" description="Office/workspace photo for Contact and Home pages" field-id="office_image" />
                <ImageUploader v-model="form.services_page_image" label="Services Page Image" description="Main image on the Services listing page" field-id="services_page_image" />
                <ImageUploader v-model="form.products_page_image" label="Products Page Image" description="Main image on the Products listing page" field-id="products_page_image" />
              </div>

              <!-- Auth Page Images -->
              <div class="border-t border-border pt-6">
                <h3 class="text-sm font-semibold text-foreground mb-4">Authentication Pages</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <ImageUploader v-model="form.login_page_image" label="Login Page Image" description="Side image on the login page" field-id="login_page_image" />
                  <ImageUploader v-model="form.register_page_image" label="Sign Up Page Image" description="Side image on the registration page" field-id="register_page_image" />
                  <ImageUploader v-model="form.forgot_password_image" label="Forgot Password Image" description="Background image for the forgot password page" field-id="forgot_password_image" />
                  <ImageUploader v-model="form.industries_page_image" label="Industries Page Hero" description="Hero background for the Industries pages" field-id="industries_page_image" />
                </div>
              </div>

              <!-- Population Impacted -->
              <div class="border-t border-border pt-6">
                <h3 class="text-sm font-semibold text-foreground mb-4">Population Impacted</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <ImageUploader v-model="form.population_image" label="Population Section Image" description="Main image for the Population Impacted section" field-id="population_image" />
                </div>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <!-- ═══════ Theme ═══════ -->
        <TabsContent value="theme">
          <Card>
            <CardHeader>
              <CardTitle>Theme Colors</CardTitle>
              <CardDescription>Customize the color scheme of your entire website. Changes apply instantly to buttons, links, accents, and more.</CardDescription>
            </CardHeader>
            <CardContent class="space-y-8">
              <!-- Theme Presets -->
              <div>
                <Label class="mb-3 block">Quick Presets</Label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                  <button
                    v-for="preset in themePresets"
                    :key="preset.name"
                    type="button"
                    @click="applyPreset(preset)"
                    :class="[
                      'flex items-center gap-3 p-3 rounded-xl border-2 transition-all hover:shadow-md',
                      form.theme_preset === preset.name
                        ? 'border-primary bg-primary/5 shadow-sm'
                        : 'border-border hover:border-primary/40'
                    ]"
                  >
                    <div class="flex gap-1">
                      <div class="w-6 h-6 rounded-full shadow-inner" :style="{ background: preset.primary }"></div>
                      <div class="w-6 h-6 rounded-full shadow-inner" :style="{ background: preset.accent }"></div>
                    </div>
                    <span class="text-sm font-semibold text-foreground capitalize">{{ preset.name }}</span>
                  </button>
                </div>
              </div>

              <!-- Custom Colors -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <Label for="theme_primary_color">Primary Color</Label>
                  <div class="flex items-center gap-3">
                    <input
                      type="color"
                      id="theme_primary_color"
                      v-model="form.theme_primary_color"
                      class="w-12 h-12 rounded-lg border border-border cursor-pointer"
                    />
                    <Input v-model="form.theme_primary_color" placeholder="#d311f5" class="flex-1" />
                  </div>
                  <p class="text-xs text-muted-foreground">Used for buttons, links, active tabs, and primary accents</p>
                </div>
                <div class="space-y-2">
                  <Label for="theme_accent_color">Accent Color</Label>
                  <div class="flex items-center gap-3">
                    <input
                      type="color"
                      id="theme_accent_color"
                      v-model="form.theme_accent_color"
                      class="w-12 h-12 rounded-lg border border-border cursor-pointer"
                    />
                    <Input v-model="form.theme_accent_color" placeholder="#3b82f6" class="flex-1" />
                  </div>
                  <p class="text-xs text-muted-foreground">Used for secondary buttons, badges, and gradient endpoints</p>
                </div>
              </div>

              <!-- Live Preview -->
              <div>
                <Label class="mb-3 block">Live Preview</Label>
                <div class="p-6 bg-muted/30 rounded-2xl border border-border space-y-4">
                  <div class="flex flex-wrap gap-3">
                    <button :style="{ background: form.theme_primary_color || '#d311f5' }" class="px-6 py-2.5 text-white font-semibold rounded-lg shadow">Primary Button</button>
                    <button :style="{ background: form.theme_accent_color || '#3b82f6' }" class="px-6 py-2.5 text-white font-semibold rounded-lg shadow">Accent Button</button>
                    <button :style="{ border: '2px solid ' + (form.theme_primary_color || '#d311f5'), color: form.theme_primary_color || '#d311f5' }" class="px-6 py-2.5 font-semibold rounded-lg bg-transparent">Outline Button</button>
                  </div>
                  <div class="flex items-center gap-4">
                    <span :style="{ color: form.theme_primary_color || '#d311f5' }" class="font-semibold">Primary Text</span>
                    <span :style="{ color: form.theme_accent_color || '#3b82f6' }" class="font-semibold">Accent Text</span>
                  </div>
                  <div class="h-4 rounded-full overflow-hidden flex">
                    <div :style="{ background: form.theme_primary_color || '#d311f5' }" class="flex-1"></div>
                    <div :style="{ background: form.theme_accent_color || '#3b82f6' }" class="flex-1"></div>
                  </div>
                </div>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <!-- ═══════ Email / SMTP ═══════ -->
        <TabsContent value="email">
          <Card>
            <CardHeader>
              <CardTitle>Email / SMTP Configuration</CardTitle>
              <CardDescription>Configure your outgoing email server settings. These are used for sending enquiry notifications, newsletters, and system emails.</CardDescription>
            </CardHeader>
            <CardContent class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <Label for="mail_mailer">Mail Driver</Label>
                  <select id="mail_mailer" v-model="form.mail_mailer" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 transition">
                    <option value="smtp">SMTP</option>
                    <option value="mailgun">Mailgun</option>
                    <option value="ses">Amazon SES</option>
                    <option value="postmark">Postmark</option>
                    <option value="sendmail">Sendmail</option>
                    <option value="log">Log (Testing)</option>
                  </select>
                </div>
                <div class="space-y-2">
                  <Label for="mail_encryption">Encryption</Label>
                  <select id="mail_encryption" v-model="form.mail_encryption" class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 transition">
                    <option value="tls">TLS</option>
                    <option value="ssl">SSL</option>
                    <option value="">None</option>
                  </select>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <Label for="mail_host">SMTP Host</Label>
                  <Input id="mail_host" v-model="form.mail_host" placeholder="smtp.gmail.com" />
                </div>
                <div class="space-y-2">
                  <Label for="mail_port">SMTP Port</Label>
                  <Input id="mail_port" v-model="form.mail_port" placeholder="587" />
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <Label for="mail_username">SMTP Username</Label>
                  <Input id="mail_username" v-model="form.mail_username" placeholder="your-email@gmail.com" />
                </div>
                <div class="space-y-2">
                  <Label for="mail_password">SMTP Password</Label>
                  <Input id="mail_password" v-model="form.mail_password" type="password" placeholder="••••••••" />
                  <p class="text-xs text-muted-foreground">App password recommended for Gmail</p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <Label for="mail_from_address">From Address</Label>
                  <Input id="mail_from_address" v-model="form.mail_from_address" type="email" placeholder="noreply@smartechresearchlabs.co.ke" />
                </div>
                <div class="space-y-2">
                  <Label for="mail_from_name">From Name</Label>
                  <Input id="mail_from_name" v-model="form.mail_from_name" placeholder="Smartech Research Labs" />
                </div>
              </div>

              <!-- Notification Emails -->
              <div class="border-t border-border pt-6 space-y-4">
                <h3 class="text-sm font-semibold text-foreground">Notification Recipients</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="space-y-2">
                    <Label for="notification_email">Enquiry Notification Email</Label>
                    <Input id="notification_email" v-model="form.notification_email" type="email" placeholder="admin@smartechresearchlabs.co.ke" />
                    <p class="text-xs text-muted-foreground">Receives notifications for new enquiries and quote requests</p>
                  </div>
                  <div class="space-y-2">
                    <Label for="newsletter_from_email">Newsletter From Email</Label>
                    <Input id="newsletter_from_email" v-model="form.newsletter_from_email" type="email" placeholder="newsletter@smartechresearchlabs.co.ke" />
                  </div>
                </div>
              </div>
            </CardContent>
          </Card>
        </TabsContent>

        <!-- ═══════ Analytics / 3rd Party ═══════ -->
        <TabsContent value="analytics">
          <Card>
            <CardHeader>
              <CardTitle>Analytics &amp; Third-Party Integrations</CardTitle>
              <CardDescription>Connect analytics services and third-party integrations. Paste the tracking IDs — scripts are injected automatically.</CardDescription>
            </CardHeader>
            <CardContent class="space-y-6">
              <div class="space-y-2">
                <Label for="google_analytics_id">Google Analytics Measurement ID</Label>
                <Input id="google_analytics_id" v-model="form.google_analytics_id" placeholder="G-XXXXXXXXXX" />
                <p class="text-xs text-muted-foreground">Google Analytics 4 Measurement ID (starts with G-)</p>
              </div>
              <div class="space-y-2">
                <Label for="google_tag_manager_id">Google Tag Manager ID</Label>
                <Input id="google_tag_manager_id" v-model="form.google_tag_manager_id" placeholder="GTM-XXXXXXX" />
              </div>
              <div class="space-y-2">
                <Label for="facebook_pixel_id">Facebook Pixel ID</Label>
                <Input id="facebook_pixel_id" v-model="form.facebook_pixel_id" placeholder="123456789012345" />
              </div>
              <div class="space-y-2">
                <Label for="hotjar_id">Hotjar Site ID</Label>
                <Input id="hotjar_id" v-model="form.hotjar_id" placeholder="1234567" />
              </div>

              <div class="border-t border-border pt-6 space-y-4">
                <h3 class="text-sm font-semibold text-foreground">API Keys</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="space-y-2">
                    <Label for="google_maps_api_key">Google Maps API Key</Label>
                    <Input id="google_maps_api_key" v-model="form.google_maps_api_key" placeholder="AIzaSy..." />
                  </div>
                  <div class="space-y-2">
                    <Label for="recaptcha_site_key">reCAPTCHA Site Key</Label>
                    <Input id="recaptcha_site_key" v-model="form.recaptcha_site_key" placeholder="6Lc..." />
                  </div>
                </div>
              </div>

              <div class="border-t border-border pt-6 space-y-4">
                <h3 class="text-sm font-semibold text-foreground">Custom Scripts</h3>
                <div class="space-y-2">
                  <Label for="custom_head_scripts">Custom Head Scripts</Label>
                  <textarea
                    id="custom_head_scripts"
                    v-model="form.custom_head_scripts"
                    rows="4"
                    class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground font-mono text-xs placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition resize-none"
                    placeholder="<!-- Paste any custom scripts to inject in <head> -->"
                  />
                  <p class="text-xs text-muted-foreground">Added before &lt;/head&gt;. Use for chat widgets, pixel snippets, etc.</p>
                </div>
                <div class="space-y-2">
                  <Label for="custom_body_scripts">Custom Body Scripts</Label>
                  <textarea
                    id="custom_body_scripts"
                    v-model="form.custom_body_scripts"
                    rows="4"
                    class="w-full bg-background border border-border rounded-lg px-4 py-2.5 text-foreground font-mono text-xs placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition resize-none"
                    placeholder="<!-- Paste any custom scripts to inject before </body> -->"
                  />
                  <p class="text-xs text-muted-foreground">Added before &lt;/body&gt;. Use for analytics, tracking, etc.</p>
                </div>
              </div>
            </CardContent>
          </Card>
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
import ImageUploader from '@/components/ImageUploader.vue';

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
  // SEO — Global
  meta_title: '',
  meta_description: '',
  meta_keywords: '',
  // SEO — Schema Markup
  schema_org_type: 'Organization',
  schema_org_name: '',
  schema_org_logo: '',
  schema_same_as: '',
  // SEO — Technical
  canonical_url: '',
  og_image_default: '',
  twitter_card_type: 'summary_large_image',
  twitter_handle: '',
  // SEO — Per-Page
  home_meta_title: '',
  home_meta_description: '',
  about_meta_title: '',
  about_meta_description: '',
  services_meta_title: '',
  services_meta_description: '',
  products_meta_title: '',
  products_meta_description: '',
  blog_meta_title: '',
  blog_meta_description: '',
  contact_meta_title: '',
  contact_meta_description: '',
  case_studies_meta_title: '',
  case_studies_meta_description: '',
  industries_meta_title: '',
  industries_meta_description: '',
  faqs_meta_title: '',
  faqs_meta_description: '',
  // Branding (paths only — used for preview)
  logo_path: '',
  favicon_path: '',
  // Theme
  theme_preset: '',
  theme_primary_color: '',
  theme_accent_color: '',
  // Email / SMTP
  mail_mailer: 'smtp',
  mail_host: '',
  mail_port: '587',
  mail_username: '',
  mail_password: '',
  mail_encryption: 'tls',
  mail_from_address: '',
  mail_from_name: '',
  notification_email: '',
  newsletter_from_email: '',
  // Images
  hero_bg_image: '',
  about_section_image: '',
  values_section_image: '',
  cta_professional_image: '',
  quote_section_image: '',
  office_image: '',
  services_page_image: '',
  products_page_image: '',
  login_page_image: '',
  register_page_image: '',
  forgot_password_image: '',
  industries_page_image: '',
  population_image: '',
  // Analytics & 3rd Party
  google_analytics_id: '',
  google_tag_manager_id: '',
  facebook_pixel_id: '',
  hotjar_id: '',
  google_maps_api_key: '',
  recaptcha_site_key: '',
  custom_head_scripts: '',
  custom_body_scripts: '',
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
    schema_org_type: 'seo',
    schema_org_name: 'seo',
    schema_org_logo: 'seo',
    schema_same_as: 'seo',
    canonical_url: 'seo',
    og_image_default: 'seo',
    twitter_card_type: 'seo',
    twitter_handle: 'seo',
    home_meta_title: 'seo',
    home_meta_description: 'seo',
    about_meta_title: 'seo',
    about_meta_description: 'seo',
    services_meta_title: 'seo',
    services_meta_description: 'seo',
    products_meta_title: 'seo',
    products_meta_description: 'seo',
    blog_meta_title: 'seo',
    blog_meta_description: 'seo',
    contact_meta_title: 'seo',
    contact_meta_description: 'seo',
    case_studies_meta_title: 'seo',
    case_studies_meta_description: 'seo',
    industries_meta_title: 'seo',
    industries_meta_description: 'seo',
    faqs_meta_title: 'seo',
    faqs_meta_description: 'seo',
    theme_preset: 'theme',
    theme_primary_color: 'theme',
    theme_accent_color: 'theme',
    // Email / SMTP
    mail_mailer: 'email',
    mail_host: 'email',
    mail_port: 'email',
    mail_username: 'email',
    mail_password: 'email',
    mail_encryption: 'email',
    mail_from_address: 'email',
    mail_from_name: 'email',
    notification_email: 'email',
    newsletter_from_email: 'email',
    // Images
    hero_bg_image: 'images',
    about_section_image: 'images',
    values_section_image: 'images',
    cta_professional_image: 'images',
    quote_section_image: 'images',
    office_image: 'images',
    services_page_image: 'images',
    products_page_image: 'images',
    login_page_image: 'images',
    register_page_image: 'images',
    forgot_password_image: 'images',
    industries_page_image: 'images',
    population_image: 'images',
    // Analytics
    google_analytics_id: 'analytics',
    google_tag_manager_id: 'analytics',
    facebook_pixel_id: 'analytics',
    hotjar_id: 'analytics',
    google_maps_api_key: 'analytics',
    recaptcha_site_key: 'analytics',
    custom_head_scripts: 'analytics',
    custom_body_scripts: 'analytics',
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

// ── SEO Pages ──
const seoPages = [
  { key: 'home', label: 'Home' },
  { key: 'about', label: 'About Us' },
  { key: 'services', label: 'Services' },
  { key: 'products', label: 'Products' },
  { key: 'blog', label: 'Blog' },
  { key: 'contact', label: 'Contact' },
  { key: 'case_studies', label: 'Case Studies' },
  { key: 'industries', label: 'Industries' },
  { key: 'faqs', label: 'FAQs' },
];

// ── Theme Presets ──
const themePresets = [
  { name: 'purple', primary: '#d311f5', accent: '#3b82f6' },
  { name: 'blue', primary: '#2563eb', accent: '#06b6d4' },
  { name: 'green', primary: '#16a34a', accent: '#84cc16' },
  { name: 'orange', primary: '#ea580c', accent: '#f59e0b' },
  { name: 'red', primary: '#dc2626', accent: '#f43f5e' },
  { name: 'teal', primary: '#0d9488', accent: '#06b6d4' },
  { name: 'indigo', primary: '#4f46e5', accent: '#8b5cf6' },
  { name: 'pink', primary: '#db2777', accent: '#f472b6' },
];

function applyPreset(preset: { name: string; primary: string; accent: string }) {
  form.theme_preset = preset.name;
  form.theme_primary_color = preset.primary;
  form.theme_accent_color = preset.accent;
}

// ── Init ──
onMounted(fetchSettings);
</script>
