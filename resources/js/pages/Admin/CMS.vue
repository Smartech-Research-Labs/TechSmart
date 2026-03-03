<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-display font-bold text-foreground">CMS Management</h1>
          <p class="text-muted-foreground mt-1">Manage sliders, clients, counters, pages and site settings</p>
        </div>
      </div>

      <!-- Tabs -->
      <div class="border-b border-border">
        <nav class="-mb-px flex space-x-8 overflow-x-auto">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'pb-4 px-1 border-b-2 font-medium text-sm transition whitespace-nowrap',
              activeTab === tab.id
                ? 'border-primary text-primary'
                : 'border-transparent text-muted-foreground hover:text-foreground hover:border-border'
            ]"
          >
            {{ tab.label }}
            <span v-if="tab.count !== undefined" class="ml-1.5 text-xs bg-muted px-1.5 py-0.5 rounded-full">{{ tab.count }}</span>
          </button>
        </nav>
      </div>

      <!-- Loading Skeleton -->
      <div v-if="initialLoading" class="space-y-4">
        <div v-for="i in 3" :key="i" class="bg-card border border-border rounded-lg p-6 animate-pulse">
          <div class="h-5 w-1/3 bg-muted rounded mb-3" />
          <div class="h-4 w-2/3 bg-muted rounded mb-2" />
          <div class="h-4 w-1/2 bg-muted rounded" />
        </div>
      </div>

      <!-- Tab Content -->
      <div v-else class="mt-6">

        <!--  SLIDERS TAB  -->
        <div v-if="activeTab === 'sliders'" class="space-y-4">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-foreground">Hero Sliders</h2>
            <button @click="openSliderModal()" class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg transition text-sm font-semibold">
              + Add Slider
            </button>
          </div>

          <div v-if="sliders.length > 0" class="grid gap-4">
            <div v-for="slider in sliders" :key="slider.id" class="bg-card border border-border rounded-lg p-6 flex items-start justify-between hover:border-primary transition group">
              <div class="flex-1">
                <div class="flex items-center gap-3 mb-1">
                  <h3 class="text-lg font-bold text-foreground">{{ slider.heading }}</h3>
                  <span :class="slider.is_visible ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-muted-foreground'" class="px-2 py-0.5 rounded text-xs font-semibold">
                    {{ slider.is_visible ? 'Visible' : 'Hidden' }}
                  </span>
                </div>
                <p v-if="slider.subheading" class="text-sm text-muted-foreground">{{ slider.subheading }}</p>
                <div class="mt-2 flex items-center gap-4 text-xs text-muted-foreground">
                  <span>Order: {{ slider.order || 0 }}</span>
                  <span v-if="slider.cta_label">CTA: {{ slider.cta_label }}</span>
                </div>
              </div>
              <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition">
                <button @click="openSliderModal(slider)" class="px-3 py-1.5 text-sm bg-primary/10 text-primary rounded hover:bg-primary/20 transition">Edit</button>
                <button @click="confirmDelete('slider', slider)" class="px-3 py-1.5 text-sm bg-red-500/10 text-red-500 rounded hover:bg-red-500/20 transition">Delete</button>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12 bg-card border border-border rounded-lg">
            <p class="text-4xl mb-3"></p>
            <p class="text-muted-foreground">No sliders yet. Create your first hero slider!</p>
          </div>
        </div>

        <!--  CLIENTS TAB  -->
        <div v-if="activeTab === 'clients'" class="space-y-4">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-foreground">Client Logos</h2>
            <button @click="openClientModal()" class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg transition text-sm font-semibold">
              + Add Client
            </button>
          </div>

          <div v-if="clients.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div v-for="client in clients" :key="client.id" class="bg-card border border-border rounded-lg p-4 text-center group relative hover:border-primary transition">
              <img v-if="client.logo" :src="`/storage/${client.logo}`" :alt="client.name" class="h-16 w-auto mx-auto object-contain" onerror="this.src='/placeholder-logo.png'" />
              <div v-else class="h-16 flex items-center justify-center text-3xl"></div>
              <p class="mt-2 text-sm font-medium text-foreground">{{ client.name }}</p>
              <p v-if="client.website_url" class="text-xs text-muted-foreground truncate">{{ client.website_url }}</p>
              <div class="absolute inset-0 bg-background/90 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 rounded-lg">
                <button @click="openClientModal(client)" class="px-3 py-1.5 text-xs bg-primary text-white rounded">Edit</button>
                <button @click="confirmDelete('client', client)" class="px-3 py-1.5 text-xs bg-red-500 text-white rounded">Delete</button>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12 bg-card border border-border rounded-lg">
            <p class="text-4xl mb-3"></p>
            <p class="text-muted-foreground">No clients yet. Add your first client logo!</p>
          </div>
        </div>

        <!--  COUNTERS TAB  -->
        <div v-if="activeTab === 'counters'" class="space-y-4">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-foreground">Stats Counters</h2>
            <button @click="openCounterModal()" class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg transition text-sm font-semibold">
              + Add Counter
            </button>
          </div>

          <div v-if="counters.length > 0" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-for="counter in counters" :key="counter.id" class="bg-card border border-border rounded-lg p-6 hover:border-primary transition group">
              <div class="flex items-start justify-between">
                <div>
                  <div class="text-3xl font-bold text-primary">{{ counter.number }}{{ counter.suffix }}</div>
                  <div class="text-sm text-foreground mt-2">{{ counter.label }}</div>
                  <div class="text-xs text-muted-foreground mt-1">
                    <span v-if="counter.icon">Icon: {{ counter.icon }}</span>
                    <span :class="counter.is_visible !== false ? 'text-green-400' : 'text-red-400'" class="ml-2">
                      {{ counter.is_visible !== false ? 'Visible' : 'Hidden' }}
                    </span>
                  </div>
                </div>
                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition">
                  <button @click="openCounterModal(counter)" class="px-3 py-1 text-xs bg-primary/10 text-primary rounded">Edit</button>
                  <button @click="confirmDelete('counter', counter)" class="px-3 py-1 text-xs bg-red-500/10 text-red-500 rounded">Delete</button>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12 bg-card border border-border rounded-lg">
            <p class="text-4xl mb-3"></p>
            <p class="text-muted-foreground">No counters yet. Create stats for your homepage!</p>
          </div>
        </div>

        <!--  PAGES TAB  -->
        <div v-if="activeTab === 'pages'" class="space-y-4">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-foreground">Custom Pages</h2>
            <button @click="openPageModal()" class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-white rounded-lg hover:shadow-lg transition text-sm font-semibold">
              + Create Page
            </button>
          </div>

          <div v-if="pages.length > 0" class="space-y-4">
            <div v-for="page in pages" :key="page.id" class="bg-card border border-border rounded-lg p-6 flex items-start justify-between hover:border-primary transition group">
              <div class="flex-1">
                <h3 class="text-lg font-bold text-foreground">{{ page.title }}</h3>
                <p v-if="page.description" class="text-sm text-muted-foreground mt-1">{{ page.description }}</p>
                <div class="mt-3 flex items-center gap-4 text-xs text-muted-foreground">
                  <span>/{{ page.slug }}</span>
                  <span>{{ page.sections?.length || 0 }} sections</span>
                  <span :class="page.is_published ? 'text-green-400' : 'text-red-400'">{{ page.is_published ? 'Published' : 'Draft' }}</span>
                </div>
              </div>
              <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition">
                <button @click="openPageModal(page)" class="px-3 py-1.5 text-sm bg-primary/10 text-primary rounded hover:bg-primary/20 transition">Edit</button>
                <button @click="confirmDelete('page', page)" class="px-3 py-1.5 text-sm bg-red-500/10 text-red-500 rounded hover:bg-red-500/20 transition">Delete</button>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12 bg-card border border-border rounded-lg">
            <p class="text-4xl mb-3"></p>
            <p class="text-muted-foreground">No custom pages yet.</p>
          </div>
        </div>
      </div>
    </div>

    <!--  -->
    <!-- SLIDER MODAL -->
    <!--  -->
    <Teleport to="body">
      <div v-if="sliderModal.show" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @mousedown.self="sliderModal.show = false">
        <div class="bg-card border border-border rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-foreground">{{ sliderModal.editing ? 'Edit Slider' : 'Create Slider' }}</h2>
            <button @click="sliderModal.show = false" class="text-muted-foreground hover:text-foreground"></button>
          </div>
          <form @submit.prevent="submitSlider" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Heading <span class="text-red-400">*</span></label>
              <input v-model="sliderModal.form.heading" type="text" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
            </div>
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Subheading</label>
              <input v-model="sliderModal.form.subheading" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
            </div>
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Description</label>
              <textarea v-model="sliderModal.form.description" rows="3" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary resize-y" />
            </div>
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Background Image</label>
              <input type="file" @change="sliderModal.file = ($event.target as HTMLInputElement).files?.[0] || null" accept="image/*" class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90" />
              <img v-if="sliderModal.editing && sliderModal.form.background_image" :src="`/storage/${sliderModal.form.background_image}`" class="mt-2 h-20 rounded" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">CTA Label</label>
                <input v-model="sliderModal.form.cta_label" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">CTA URL</label>
                <input v-model="sliderModal.form.cta_url" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">CTA Label 2</label>
                <input v-model="sliderModal.form.cta_label_2" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">CTA URL 2</label>
                <input v-model="sliderModal.form.cta_url_2" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4 items-end">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Order</label>
                <input v-model.number="sliderModal.form.order" type="number" min="0" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
              <div class="flex items-center gap-2 pb-2">
                <input v-model="sliderModal.form.is_visible" type="checkbox" id="slider_visible" class="rounded border-border" />
                <label for="slider_visible" class="text-sm text-foreground">Visible</label>
              </div>
            </div>
            <div v-if="sliderModal.errors.length" class="bg-red-500/10 border border-red-500/30 rounded-lg p-3">
              <ul class="list-disc list-inside text-sm text-red-400 space-y-1">
                <li v-for="(e, i) in sliderModal.errors" :key="i">{{ e }}</li>
              </ul>
            </div>
            <div class="flex gap-3 pt-2">
              <button type="submit" :disabled="sliderModal.saving" class="flex-1 bg-primary hover:bg-primary/90 text-white font-semibold px-4 py-2.5 rounded-lg transition text-sm disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="sliderModal.saving" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                {{ sliderModal.saving ? 'Saving...' : (sliderModal.editing ? 'Update Slider' : 'Create Slider') }}
              </button>
              <button type="button" @click="sliderModal.show = false" class="px-4 py-2.5 bg-background border border-border text-foreground rounded-lg text-sm hover:border-primary transition">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!--  -->
    <!-- CLIENT MODAL -->
    <!--  -->
    <Teleport to="body">
      <div v-if="clientModal.show" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @mousedown.self="clientModal.show = false">
        <div class="bg-card border border-border rounded-xl w-full max-w-md max-h-[90vh] overflow-y-auto p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-foreground">{{ clientModal.editing ? 'Edit Client' : 'Add Client' }}</h2>
            <button @click="clientModal.show = false" class="text-muted-foreground hover:text-foreground"></button>
          </div>
          <form @submit.prevent="submitClient" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Name <span class="text-red-400">*</span></label>
              <input v-model="clientModal.form.name" type="text" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
            </div>
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Logo</label>
              <input type="file" @change="clientModal.file = ($event.target as HTMLInputElement).files?.[0] || null" accept="image/*" class="block w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90" />
              <img v-if="clientModal.editing && clientModal.form.logo" :src="`/storage/${clientModal.form.logo}`" class="mt-2 h-12 rounded" />
            </div>
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Website URL</label>
              <input v-model="clientModal.form.website_url" type="url" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="https://example.com" />
            </div>
            <div class="grid grid-cols-2 gap-4 items-end">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Order</label>
                <input v-model.number="clientModal.form.order" type="number" min="0" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
              <div class="flex items-center gap-2 pb-2">
                <input v-model="clientModal.form.is_visible" type="checkbox" id="client_visible" class="rounded border-border" />
                <label for="client_visible" class="text-sm text-foreground">Visible</label>
              </div>
            </div>
            <div v-if="clientModal.errors.length" class="bg-red-500/10 border border-red-500/30 rounded-lg p-3">
              <ul class="list-disc list-inside text-sm text-red-400 space-y-1">
                <li v-for="(e, i) in clientModal.errors" :key="i">{{ e }}</li>
              </ul>
            </div>
            <div class="flex gap-3 pt-2">
              <button type="submit" :disabled="clientModal.saving" class="flex-1 bg-primary hover:bg-primary/90 text-white font-semibold px-4 py-2.5 rounded-lg transition text-sm disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="clientModal.saving" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                {{ clientModal.saving ? 'Saving...' : (clientModal.editing ? 'Update Client' : 'Add Client') }}
              </button>
              <button type="button" @click="clientModal.show = false" class="px-4 py-2.5 bg-background border border-border text-foreground rounded-lg text-sm hover:border-primary transition">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!--  -->
    <!-- COUNTER MODAL -->
    <!--  -->
    <Teleport to="body">
      <div v-if="counterModal.show" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @mousedown.self="counterModal.show = false">
        <div class="bg-card border border-border rounded-xl w-full max-w-md max-h-[90vh] overflow-y-auto p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-foreground">{{ counterModal.editing ? 'Edit Counter' : 'Add Counter' }}</h2>
            <button @click="counterModal.show = false" class="text-muted-foreground hover:text-foreground"></button>
          </div>
          <form @submit.prevent="submitCounter" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Label <span class="text-red-400">*</span></label>
              <input v-model="counterModal.form.label" type="text" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g. Happy Clients" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Number <span class="text-red-400">*</span></label>
                <input v-model.number="counterModal.form.number" type="number" min="0" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Suffix</label>
                <input v-model="counterModal.form.suffix" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g. +, %, K" />
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Icon</label>
              <input v-model="counterModal.form.icon" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="e.g.  or icon class" />
            </div>
            <div class="grid grid-cols-2 gap-4 items-end">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Order</label>
                <input v-model.number="counterModal.form.order" type="number" min="0" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
              <div class="flex items-center gap-2 pb-2">
                <input v-model="counterModal.form.is_visible" type="checkbox" id="counter_visible" class="rounded border-border" />
                <label for="counter_visible" class="text-sm text-foreground">Visible</label>
              </div>
            </div>
            <div v-if="counterModal.errors.length" class="bg-red-500/10 border border-red-500/30 rounded-lg p-3">
              <ul class="list-disc list-inside text-sm text-red-400 space-y-1">
                <li v-for="(e, i) in counterModal.errors" :key="i">{{ e }}</li>
              </ul>
            </div>
            <div class="flex gap-3 pt-2">
              <button type="submit" :disabled="counterModal.saving" class="flex-1 bg-primary hover:bg-primary/90 text-white font-semibold px-4 py-2.5 rounded-lg transition text-sm disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="counterModal.saving" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                {{ counterModal.saving ? 'Saving...' : (counterModal.editing ? 'Update Counter' : 'Add Counter') }}
              </button>
              <button type="button" @click="counterModal.show = false" class="px-4 py-2.5 bg-background border border-border text-foreground rounded-lg text-sm hover:border-primary transition">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!--  -->
    <!-- PAGE MODAL -->
    <!--  -->
    <Teleport to="body">
      <div v-if="pageModal.show" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @mousedown.self="pageModal.show = false">
        <div class="bg-card border border-border rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-foreground">{{ pageModal.editing ? 'Edit Page' : 'Create Page' }}</h2>
            <button @click="pageModal.show = false" class="text-muted-foreground hover:text-foreground"></button>
          </div>
          <form @submit.prevent="submitPage" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Title <span class="text-red-400">*</span></label>
                <input v-model="pageModal.form.title" type="text" required class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">Slug</label>
                <input v-model="pageModal.form.slug" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" placeholder="auto-generated" />
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-foreground mb-1">Description</label>
              <textarea v-model="pageModal.form.description" rows="3" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary resize-y" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">SEO Title</label>
                <input v-model="pageModal.form.seo_title" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
              <div>
                <label class="block text-sm font-medium text-foreground mb-1">SEO Description</label>
                <input v-model="pageModal.form.seo_description" type="text" class="w-full px-3 py-2 bg-background border border-border rounded-lg text-foreground text-sm focus:outline-none focus:border-primary" />
              </div>
            </div>
            <div class="flex items-center gap-2">
              <input v-model="pageModal.form.is_published" type="checkbox" id="page_published" class="rounded border-border" />
              <label for="page_published" class="text-sm text-foreground">Published</label>
            </div>
            <div v-if="pageModal.errors.length" class="bg-red-500/10 border border-red-500/30 rounded-lg p-3">
              <ul class="list-disc list-inside text-sm text-red-400 space-y-1">
                <li v-for="(e, i) in pageModal.errors" :key="i">{{ e }}</li>
              </ul>
            </div>
            <div class="flex gap-3 pt-2">
              <button type="submit" :disabled="pageModal.saving" class="flex-1 bg-primary hover:bg-primary/90 text-white font-semibold px-4 py-2.5 rounded-lg transition text-sm disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="pageModal.saving" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                {{ pageModal.saving ? 'Saving...' : (pageModal.editing ? 'Update Page' : 'Create Page') }}
              </button>
              <button type="button" @click="pageModal.show = false" class="px-4 py-2.5 bg-background border border-border text-foreground rounded-lg text-sm hover:border-primary transition">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <!--  -->
    <!-- DELETE CONFIRMATION MODAL -->
    <!--  -->
    <Teleport to="body">
      <div v-if="deleteModal.show" class="fixed inset-0 z-50 flex items-center justify-center bg-muted/70 backdrop-blur-sm p-4" @mousedown.self="deleteModal.show = false">
        <div class="bg-card border border-border rounded-xl w-full max-w-md p-6">
          <div class="text-center">
            <div class="mx-auto w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </div>
            <h3 class="text-lg font-bold text-foreground mb-2">Delete {{ deleteModal.type }}</h3>
            <p class="text-muted-foreground text-sm mb-6">
              Are you sure you want to delete <span class="text-foreground font-semibold">{{ deleteModal.name }}</span>? This item will be moved to trash.
            </p>
            <div class="flex gap-3">
              <button @click="deleteModal.show = false" class="flex-1 px-4 py-2.5 bg-background border border-border text-foreground rounded-lg text-sm transition hover:border-primary">Cancel</button>
              <button @click="executeDelete" :disabled="deleteModal.deleting" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg text-sm transition disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="deleteModal.deleting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                {{ deleteModal.deleting ? 'Deleting...' : 'Delete' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';

const { get, post, put, delete: destroy } = useApi();
const toast = useToast();

//  State 
const activeTab = ref('sliders');
const initialLoading = ref(true);

const sliders = ref<any[]>([]);
const clients = ref<any[]>([]);
const counters = ref<any[]>([]);
const pages = ref<any[]>([]);

const tabs = computed(() => [
  { id: 'sliders', label: 'Sliders', count: sliders.value.length },
  { id: 'clients', label: 'Clients', count: clients.value.length },
  { id: 'counters', label: 'Counters', count: counters.value.length },
  { id: 'pages', label: 'Pages', count: pages.value.length },
]);

//  Fetch data 
async function fetchAll() {
  initialLoading.value = true;
  try {
    const [s, cl, co, p] = await Promise.all([
      get('/admin/sliders').catch(() => []),
      get('/admin/cms/clients').catch(() => []),
      get('/admin/cms/counters').catch(() => []),
      get('/admin/pages').catch(() => []),
    ]);
    sliders.value = Array.isArray(s) ? s : (s?.data ?? []);
    clients.value = Array.isArray(cl) ? cl : (cl?.data ?? []);
    counters.value = Array.isArray(co) ? co : (co?.data ?? []);
    pages.value = Array.isArray(p) ? p : (p?.data ?? []);
  } catch {
    toast.error('Failed to load CMS data');
  } finally {
    initialLoading.value = false;
  }
}

//  Slider Modal 
const sliderModal = reactive({
  show: false,
  editing: false,
  editId: null as number | null,
  saving: false,
  errors: [] as string[],
  file: null as File | null,
  form: {
    heading: '',
    subheading: '',
    description: '',
    background_image: '',
    cta_label: '',
    cta_url: '',
    cta_label_2: '',
    cta_url_2: '',
    is_visible: true,
    order: 0,
  },
});

function openSliderModal(slider?: any) {
  sliderModal.errors = [];
  sliderModal.file = null;
  if (slider) {
    sliderModal.editing = true;
    sliderModal.editId = slider.id;
    sliderModal.form = {
      heading: slider.heading || '',
      subheading: slider.subheading || '',
      description: slider.description || '',
      background_image: slider.background_image || '',
      cta_label: slider.cta_label || '',
      cta_url: slider.cta_url || '',
      cta_label_2: slider.cta_label_2 || '',
      cta_url_2: slider.cta_url_2 || '',
      is_visible: slider.is_visible !== false,
      order: slider.order || 0,
    };
  } else {
    sliderModal.editing = false;
    sliderModal.editId = null;
    sliderModal.form = { heading: '', subheading: '', description: '', background_image: '', cta_label: '', cta_url: '', cta_label_2: '', cta_url_2: '', is_visible: true, order: 0 };
  }
  sliderModal.show = true;
}

async function submitSlider() {
  sliderModal.errors = [];
  sliderModal.saving = true;
  try {
    const fd = new FormData();
    Object.entries(sliderModal.form).forEach(([k, v]) => {
      if (k !== 'background_image') fd.append(k, typeof v === 'boolean' ? (v ? '1' : '0') : String(v ?? ''));
    });
    if (sliderModal.file) fd.append('background_image', sliderModal.file);

    if (sliderModal.editing && sliderModal.editId) {
      fd.append('_method', 'PUT');
      await post(`/admin/sliders/${sliderModal.editId}`, fd, { headers: { 'Content-Type': 'multipart/form-data' } });
      toast.success('Slider updated');
    } else {
      await post('/admin/sliders', fd, { headers: { 'Content-Type': 'multipart/form-data' } });
      toast.success('Slider created');
    }
    sliderModal.show = false;
    await fetchAll();
  } catch (err: any) {
    const resp = err?.response?.data;
    sliderModal.errors = resp?.errors ? Object.values(resp.errors).flat() as string[] : [resp?.message || 'Failed to save slider'];
    toast.error(sliderModal.errors[0]);
  } finally {
    sliderModal.saving = false;
  }
}

//  Client Modal 
const clientModal = reactive({
  show: false,
  editing: false,
  editId: null as number | null,
  saving: false,
  errors: [] as string[],
  file: null as File | null,
  form: {
    name: '',
    logo: '',
    website_url: '',
    is_visible: true,
    order: 0,
  },
});

function openClientModal(client?: any) {
  clientModal.errors = [];
  clientModal.file = null;
  if (client) {
    clientModal.editing = true;
    clientModal.editId = client.id;
    clientModal.form = {
      name: client.name || '',
      logo: client.logo || '',
      website_url: client.website_url || '',
      is_visible: client.is_visible !== false,
      order: client.order || 0,
    };
  } else {
    clientModal.editing = false;
    clientModal.editId = null;
    clientModal.form = { name: '', logo: '', website_url: '', is_visible: true, order: 0 };
  }
  clientModal.show = true;
}

async function submitClient() {
  clientModal.errors = [];
  clientModal.saving = true;
  try {
    const fd = new FormData();
    fd.append('name', clientModal.form.name);
    fd.append('website_url', clientModal.form.website_url || '');
    fd.append('is_visible', clientModal.form.is_visible ? '1' : '0');
    fd.append('order', String(clientModal.form.order));
    if (clientModal.file) fd.append('logo', clientModal.file);

    if (clientModal.editing && clientModal.editId) {
      fd.append('_method', 'PUT');
      await post(`/admin/cms/clients/${clientModal.editId}`, fd, { headers: { 'Content-Type': 'multipart/form-data' } });
      toast.success('Client updated');
    } else {
      await post('/admin/cms/clients', fd, { headers: { 'Content-Type': 'multipart/form-data' } });
      toast.success('Client added');
    }
    clientModal.show = false;
    await fetchAll();
  } catch (err: any) {
    const resp = err?.response?.data;
    clientModal.errors = resp?.errors ? Object.values(resp.errors).flat() as string[] : [resp?.message || 'Failed to save client'];
    toast.error(clientModal.errors[0]);
  } finally {
    clientModal.saving = false;
  }
}

//  Counter Modal 
const counterModal = reactive({
  show: false,
  editing: false,
  editId: null as number | null,
  saving: false,
  errors: [] as string[],
  form: {
    label: '',
    number: 0,
    suffix: '',
    icon: '',
    is_visible: true,
    order: 0,
  },
});

function openCounterModal(counter?: any) {
  counterModal.errors = [];
  if (counter) {
    counterModal.editing = true;
    counterModal.editId = counter.id;
    counterModal.form = {
      label: counter.label || '',
      number: counter.number || 0,
      suffix: counter.suffix || '',
      icon: counter.icon || '',
      is_visible: counter.is_visible !== false,
      order: counter.order || 0,
    };
  } else {
    counterModal.editing = false;
    counterModal.editId = null;
    counterModal.form = { label: '', number: 0, suffix: '', icon: '', is_visible: true, order: 0 };
  }
  counterModal.show = true;
}

async function submitCounter() {
  counterModal.errors = [];
  counterModal.saving = true;
  try {
    const payload = { ...counterModal.form };
    if (counterModal.editing && counterModal.editId) {
      await put(`/admin/cms/counters/${counterModal.editId}`, payload);
      toast.success('Counter updated');
    } else {
      await post('/admin/cms/counters', payload);
      toast.success('Counter created');
    }
    counterModal.show = false;
    await fetchAll();
  } catch (err: any) {
    const resp = err?.response?.data;
    counterModal.errors = resp?.errors ? Object.values(resp.errors).flat() as string[] : [resp?.message || 'Failed to save counter'];
    toast.error(counterModal.errors[0]);
  } finally {
    counterModal.saving = false;
  }
}

//  Page Modal 
const pageModal = reactive({
  show: false,
  editing: false,
  editId: null as number | null,
  saving: false,
  errors: [] as string[],
  form: {
    title: '',
    slug: '',
    description: '',
    seo_title: '',
    seo_description: '',
    is_published: true,
  },
});

function openPageModal(page?: any) {
  pageModal.errors = [];
  if (page) {
    pageModal.editing = true;
    pageModal.editId = page.id;
    pageModal.form = {
      title: page.title || '',
      slug: page.slug || '',
      description: page.description || '',
      seo_title: page.seo_title || '',
      seo_description: page.seo_description || '',
      is_published: page.is_published !== false,
    };
  } else {
    pageModal.editing = false;
    pageModal.editId = null;
    pageModal.form = { title: '', slug: '', description: '', seo_title: '', seo_description: '', is_published: true };
  }
  pageModal.show = true;
}

async function submitPage() {
  pageModal.errors = [];
  pageModal.saving = true;
  try {
    const payload = { ...pageModal.form };
    if (pageModal.editing && pageModal.editId) {
      await put(`/admin/pages/${pageModal.editId}`, payload);
      toast.success('Page updated');
    } else {
      await post('/admin/pages', payload);
      toast.success('Page created');
    }
    pageModal.show = false;
    await fetchAll();
  } catch (err: any) {
    const resp = err?.response?.data;
    pageModal.errors = resp?.errors ? Object.values(resp.errors).flat() as string[] : [resp?.message || 'Failed to save page'];
    toast.error(pageModal.errors[0]);
  } finally {
    pageModal.saving = false;
  }
}

//  Delete Modal 
const deleteModal = reactive({
  show: false,
  type: '' as string,
  name: '' as string,
  id: null as number | null,
  deleting: false,
});

function confirmDelete(type: string, item: any) {
  deleteModal.type = type;
  deleteModal.name = item.heading || item.name || item.label || item.title || 'Item';
  deleteModal.id = item.id;
  deleteModal.deleting = false;
  deleteModal.show = true;
}

async function executeDelete() {
  if (!deleteModal.id) return;
  deleteModal.deleting = true;
  try {
    const urlMap: Record<string, string> = {
      slider: `/admin/sliders/${deleteModal.id}`,
      client: `/admin/cms/clients/${deleteModal.id}`,
      counter: `/admin/cms/counters/${deleteModal.id}`,
      page: `/admin/pages/${deleteModal.id}`,
    };
    await destroy(urlMap[deleteModal.type]);
    toast.success(`${deleteModal.type.charAt(0).toUpperCase() + deleteModal.type.slice(1)} deleted`);
    deleteModal.show = false;
    await fetchAll();
  } catch (err: any) {
    toast.error(err?.response?.data?.message || `Failed to delete ${deleteModal.type}`);
  } finally {
    deleteModal.deleting = false;
  }
}

//  Init 
onMounted(fetchAll);
</script>
