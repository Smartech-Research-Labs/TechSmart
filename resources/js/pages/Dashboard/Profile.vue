<template>
  <DashboardLayout>
    <div class="space-y-6">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-xl font-display font-bold text-foreground">My Profile</h1>
          <p class="text-muted-foreground text-sm">Manage your personal information and account settings</p>
        </div>
        <!-- Profile Completion -->
        <div v-if="profileData?.profile_completion !== undefined" class="flex items-center gap-3 bg-card border border-border rounded-lg px-4 py-2.5">
          <div class="relative w-10 h-10 shrink-0">
            <svg class="w-10 h-10 -rotate-90" viewBox="0 0 36 36">
              <circle cx="18" cy="18" r="15.5" fill="none" stroke="currentColor" stroke-width="2.5" class="text-muted/30" />
              <circle cx="18" cy="18" r="15.5" fill="none" stroke="currentColor" stroke-width="2.5" class="text-primary" stroke-linecap="round"
                :stroke-dasharray="`${(profileData.profile_completion / 100) * 97.4} 97.4`" />
            </svg>
            <span class="absolute inset-0 flex items-center justify-center text-[10px] font-bold">{{ profileData.profile_completion }}%</span>
          </div>
          <div class="text-xs">
            <div class="font-medium text-foreground">Profile Completion</div>
            <div class="text-muted-foreground">{{ profileData.profile_completion < 100 ? 'Complete your profile to unlock all features' : 'Your profile is complete!' }}</div>
          </div>
        </div>
      </div>

      <!-- Avatar Section -->
      <div class="bg-card border border-border rounded-lg p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
          <div class="relative group">
            <div class="w-24 h-24 rounded-2xl overflow-hidden ring-2 ring-primary/10 ring-offset-2 ring-offset-background">
              <img
                :src="avatarPreview || profileData?.profile_photo_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(form.name)}&background=6366f1&color=fff&size=96`"
                :alt="form.name"
                class="w-full h-full object-cover"
              />
            </div>
            <button
              @click="showAvatarPicker = true"
              class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition cursor-pointer"
            >
              <IconCamera class="size-6 text-white" />
            </button>
          </div>
          <div class="flex-1">
            <h3 class="text-lg font-semibold text-foreground">{{ form.name || 'Your Name' }}</h3>
            <p class="text-sm text-muted-foreground">{{ form.email }}</p>
            <p v-if="profileData?.member_since" class="text-xs text-muted-foreground mt-1">
              Member since {{ new Date(profileData.member_since).toLocaleDateString('en-US', { month: 'long', year: 'numeric' }) }}
            </p>
            <div class="flex items-center gap-2 mt-3">
              <button
                @click="showAvatarPicker = true"
                class="text-xs bg-primary hover:bg-primary/90 text-white px-3 py-1.5 rounded-lg transition flex items-center gap-1.5"
              >
                <IconCamera class="size-3" />
                Change Avatar
              </button>
              <button
                v-if="avatarFile"
                @click="uploadAvatar"
                :disabled="uploadingAvatar"
                class="text-xs bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg transition disabled:opacity-50 flex items-center gap-1.5"
              >
                <svg v-if="uploadingAvatar" class="animate-spin size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                Save Photo
              </button>
              <button
                v-if="profileData?.avatar || avatarFile"
                @click="avatarFile ? cancelAvatarSelect() : removeAvatar()"
                class="text-xs border border-border hover:border-destructive/50 text-muted-foreground hover:text-destructive px-3 py-1.5 rounded-lg transition"
              >
                {{ avatarFile ? 'Cancel' : 'Remove Photo' }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Avatar Picker Modal -->
      <Teleport to="body">
        <div
          v-if="showAvatarPicker"
          class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
          @click.self="showAvatarPicker = false"
        >
          <div class="bg-card border border-border rounded-xl shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-4 border-b border-border">
              <h3 class="text-lg font-semibold text-foreground">Choose Avatar</h3>
              <button @click="showAvatarPicker = false" class="text-muted-foreground hover:text-foreground transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <div class="p-4">
              <AvatarPicker
                :current-avatar="profileData?.profile_photo_url"
                :user-name="form.name"
                @select="handleAvatarPresetSelect"
                @upload="handleAvatarUpload"
              />
            </div>
          </div>
        </div>
      </Teleport>

      <!-- Tabs -->
      <div class="border-b border-border">
        <nav class="flex gap-6 -mb-px">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'pb-3 text-sm font-medium border-b-2 transition-colors whitespace-nowrap',
              activeTab === tab.id
                ? 'border-primary text-primary'
                : 'border-transparent text-muted-foreground hover:text-foreground hover:border-border'
            ]"
          >
            <component :is="tab.icon" class="size-4 inline-block mr-1.5 -mt-0.5" />
            {{ tab.label }}
          </button>
        </nav>
      </div>

      <!-- Tab: Profile -->
      <div v-if="activeTab === 'profile'" class="space-y-6">
        <div class="bg-card border border-border rounded-lg p-6 sm:p-8">
          <h2 class="text-base font-semibold text-foreground mb-6">Personal Information</h2>
          <form @submit.prevent="handleUpdateProfile" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Full Name *</label>
                <input v-model="form.name" type="text" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" :class="profileErrors.name ? 'border-destructive' : ''" placeholder="John Doe" />
                <p v-if="profileErrors.name" class="text-xs text-destructive mt-1">{{ profileErrors.name }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Display Name</label>
                <input v-model="form.display_name" type="text" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" placeholder="How you want to be called" />
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Email Address *</label>
                <input v-model="form.email" type="email" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" :class="profileErrors.email ? 'border-destructive' : ''" placeholder="john@example.com" />
                <p v-if="profileErrors.email" class="text-xs text-destructive mt-1">{{ profileErrors.email }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Phone Number</label>
                <input v-model="form.phone" type="tel" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" :class="profileErrors.phone ? 'border-destructive' : ''" placeholder="+254 712 345 678" />
                <p v-if="profileErrors.phone" class="text-xs text-destructive mt-1">{{ profileErrors.phone }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Company</label>
                <input v-model="form.company" type="text" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" placeholder="Your Company" />
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Date of Birth</label>
                <input v-model="form.date_of_birth" type="date" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" />
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Gender</label>
                <select v-model="form.gender" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition">
                  <option value="">Prefer not to say</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Country</label>
                <input v-model="form.country" type="text" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" placeholder="Kenya" />
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">City</label>
                <input v-model="form.city" type="text" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" placeholder="Nairobi" />
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Timezone</label>
                <select v-model="form.timezone" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition">
                  <option value="Africa/Nairobi">Africa/Nairobi (EAT)</option>
                  <option value="Africa/Lagos">Africa/Lagos (WAT)</option>
                  <option value="Africa/Johannesburg">Africa/Johannesburg (SAST)</option>
                  <option value="Africa/Cairo">Africa/Cairo (EET)</option>
                  <option value="Europe/London">Europe/London (GMT)</option>
                  <option value="America/New_York">America/New York (EST)</option>
                  <option value="America/Chicago">America/Chicago (CST)</option>
                  <option value="America/Los_Angeles">America/Los Angeles (PST)</option>
                  <option value="Asia/Dubai">Asia/Dubai (GST)</option>
                  <option value="Asia/Kolkata">Asia/Kolkata (IST)</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-1.5">Address</label>
              <input v-model="form.address" type="text" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" placeholder="123 Main Street" />
            </div>

            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-1.5">Bio</label>
              <textarea v-model="form.bio" rows="3" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition resize-none" placeholder="Tell us about yourself..." />
            </div>

            <!-- Social Links -->
            <div>
              <h3 class="text-sm font-semibold text-foreground mb-3">Social Links</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs text-muted-foreground mb-1">LinkedIn</label>
                  <input v-model="socialLinks.linkedin" type="url" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" placeholder="https://linkedin.com/in/username" />
                </div>
                <div>
                  <label class="block text-xs text-muted-foreground mb-1">Twitter / X</label>
                  <input v-model="socialLinks.twitter" type="url" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" placeholder="https://x.com/username" />
                </div>
                <div>
                  <label class="block text-xs text-muted-foreground mb-1">GitHub</label>
                  <input v-model="socialLinks.github" type="url" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" placeholder="https://github.com/username" />
                </div>
                <div>
                  <label class="block text-xs text-muted-foreground mb-1">Website</label>
                  <input v-model="socialLinks.website" type="url" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" placeholder="https://example.com" />
                </div>
              </div>
            </div>

            <div class="flex gap-3 pt-2">
              <button type="submit" :disabled="savingProfile" class="bg-primary hover:bg-primary/90 text-white font-medium px-5 py-2.5 text-sm rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                <svg v-if="savingProfile" class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                {{ savingProfile ? 'Saving...' : 'Save Changes' }}
              </button>
              <button type="button" @click="resetProfileForm" class="border border-border hover:border-border text-muted-foreground font-medium px-5 py-2.5 text-sm rounded-lg transition">Cancel</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Tab: Security -->
      <div v-if="activeTab === 'security'" class="space-y-6">
        <div class="bg-card border border-border rounded-lg p-6 sm:p-8">
          <h2 class="text-base font-semibold text-foreground mb-6">Change Password</h2>
          <form @submit.prevent="handleChangePassword" class="space-y-5">
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-1.5">Current Password</label>
              <input v-model="passwordForm.current_password" type="password" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" :class="passwordErrors.current_password ? 'border-destructive' : ''" />
              <p v-if="passwordErrors.current_password" class="text-xs text-destructive mt-1">{{ passwordErrors.current_password }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">New Password</label>
                <input v-model="passwordForm.password" type="password" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" :class="passwordErrors.password ? 'border-destructive' : ''" />
                <p v-if="passwordErrors.password" class="text-xs text-destructive mt-1">{{ passwordErrors.password }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-muted-foreground mb-1.5">Confirm New Password</label>
                <input v-model="passwordForm.password_confirmation" type="password" class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/30 transition" :class="passwordErrors.password_confirmation ? 'border-destructive' : ''" />
                <p v-if="passwordErrors.password_confirmation" class="text-xs text-destructive mt-1">{{ passwordErrors.password_confirmation }}</p>
              </div>
            </div>
            <button type="submit" :disabled="savingPassword" class="bg-primary hover:bg-primary/90 text-white font-medium px-5 py-2.5 text-sm rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
              <svg v-if="savingPassword" class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
              </svg>
              {{ savingPassword ? 'Updating...' : 'Update Password' }}
            </button>
          </form>
        </div>

        <!-- Account Info -->
        <div class="bg-card border border-border rounded-lg p-6 sm:p-8">
          <h2 class="text-base font-semibold text-foreground mb-4">Account Information</h2>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between items-center py-2 border-b border-border/50">
              <span class="text-muted-foreground">Account Status</span>
              <span class="inline-flex items-center gap-1.5 font-medium text-emerald-600"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Active</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-border/50">
              <span class="text-muted-foreground">Email Verified</span>
              <span :class="authStore.user?.email_verified_at ? 'text-emerald-600' : 'text-amber-600'" class="font-medium">
                {{ authStore.user?.email_verified_at ? 'Verified' : 'Not Verified' }}
              </span>
            </div>
            <div v-if="authStore.user?.roles?.length" class="flex justify-between items-center py-2 border-b border-border/50">
              <span class="text-muted-foreground">Roles</span>
              <div class="flex gap-1.5">
                <span v-for="role in authStore.user.roles" :key="role.id" class="text-xs bg-primary/10 text-primary px-2 py-0.5 rounded-full font-medium">
                  {{ role.name }}
                </span>
              </div>
            </div>
            <div v-if="authStore.user?.last_login_at" class="flex justify-between items-center py-2">
              <span class="text-muted-foreground">Last Login</span>
              <span class="font-medium text-foreground">{{ new Date(String(authStore.user.last_login_at)).toLocaleString() }}</span>
            </div>
          </div>
        </div>

        <!-- Email Two-Factor Authentication -->
        <div class="bg-card border border-border rounded-lg p-6 sm:p-8">
          <div class="flex items-start justify-between gap-4">
            <div>
              <h2 class="text-base font-semibold text-foreground">Email Two-Factor Authentication</h2>
              <p class="text-sm text-muted-foreground mt-1">
                When enabled, you'll receive a 6-digit verification code via email each time you sign in. This adds an extra layer of security to your account.
              </p>
            </div>
            <button
              @click="toggleTwoFactorEmail"
              :disabled="toggling2FA"
              :class="[
                'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-background disabled:opacity-50',
                twoFactorEmailEnabled ? 'bg-primary' : 'bg-muted-foreground/30'
              ]"
            >
              <span
                :class="[
                  'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                  twoFactorEmailEnabled ? 'translate-x-5' : 'translate-x-0'
                ]"
              />
            </button>
          </div>
          <div class="mt-4 flex items-center gap-2 text-sm">
            <span
              :class="[
                'inline-flex items-center gap-1.5 font-medium',
                twoFactorEmailEnabled ? 'text-emerald-600' : 'text-muted-foreground'
              ]"
            >
              <span :class="['w-2 h-2 rounded-full', twoFactorEmailEnabled ? 'bg-emerald-500' : 'bg-muted-foreground/40']"></span>
              {{ twoFactorEmailEnabled ? 'Enabled' : 'Disabled' }}
            </span>
            <span v-if="twoFactorMessage" class="text-xs text-muted-foreground ml-2">{{ twoFactorMessage }}</span>
          </div>
        </div>
      </div>

      <!-- Tab: Sessions -->
      <div v-if="activeTab === 'sessions'" class="space-y-4">
        <div class="bg-card border border-border rounded-lg p-6 sm:p-8">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h2 class="text-base font-semibold text-foreground">Login History</h2>
              <p class="text-sm text-muted-foreground mt-0.5">Your recent sign-in sessions</p>
            </div>
            <button @click="fetchSessions" class="text-xs text-primary hover:text-primary/80 transition flex items-center gap-1">
              <IconRefresh class="size-3.5" />
              Refresh
            </button>
          </div>

          <div v-if="loadingSessions" class="space-y-3">
            <div v-for="i in 5" :key="i" class="flex gap-4 animate-pulse p-3">
              <div class="w-10 h-10 bg-muted rounded-lg" />
              <div class="flex-1 space-y-2">
                <div class="h-4 w-1/3 bg-muted rounded" />
                <div class="h-3 w-2/3 bg-muted rounded" />
              </div>
            </div>
          </div>

          <div v-else-if="sessions.length === 0" class="text-center py-10 text-muted-foreground text-sm">
            <IconShieldCheck class="size-10 mx-auto mb-2 opacity-30" />
            No login history found.
          </div>

          <div v-else class="divide-y divide-border/50">
            <div
              v-for="(session, idx) in sessions"
              :key="idx"
              class="flex items-start gap-4 py-3 first:pt-0 last:pb-0"
            >
              <div class="w-10 h-10 rounded-lg bg-muted flex items-center justify-center shrink-0">
                <IconDeviceDesktop v-if="session.device === 'Desktop'" class="size-5 text-muted-foreground" />
                <IconDeviceMobile v-else class="size-5 text-muted-foreground" />
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-foreground">{{ session.browser || 'Unknown' }} on {{ session.platform || 'Unknown' }}</p>
                <p class="text-xs text-muted-foreground mt-0.5">
                  {{ session.ip_address || 'Unknown IP' }}
                  <span v-if="session.location"> &middot; {{ session.location }}</span>
                </p>
              </div>
              <div class="text-xs text-muted-foreground text-right shrink-0">
                <p>{{ session.device || 'Unknown' }}</p>
                <p class="mt-0.5">{{ formatDate(session.logged_in_at) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab: Activity -->
      <div v-if="activeTab === 'activity'" class="space-y-4">
        <div class="bg-card border border-border rounded-lg p-6 sm:p-8">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h2 class="text-base font-semibold text-foreground">Activity Log</h2>
              <p class="text-sm text-muted-foreground mt-0.5">Your recent actions on the platform</p>
            </div>
            <button @click="fetchActivityLog" class="text-xs text-primary hover:text-primary/80 transition flex items-center gap-1">
              <IconRefresh class="size-3.5" />
              Refresh
            </button>
          </div>

          <div v-if="loadingActivityLog" class="space-y-3">
            <div v-for="i in 5" :key="i" class="flex gap-3 animate-pulse p-2">
              <div class="w-8 h-8 bg-muted rounded-lg" />
              <div class="flex-1 space-y-2">
                <div class="h-4 w-1/2 bg-muted rounded" />
                <div class="h-3 w-1/3 bg-muted rounded" />
              </div>
            </div>
          </div>

          <div v-else-if="activityLog.length === 0" class="text-center py-10 text-muted-foreground text-sm">
            <IconActivity class="size-10 mx-auto mb-2 opacity-30" />
            No activity yet.
          </div>

          <div v-else class="space-y-1">
            <div
              v-for="item in activityLog"
              :key="`${item.type}-${item.id}`"
              class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-muted/50 transition-colors"
            >
              <div :class="['w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-sm', activityBgClass(item.type)]">
                {{ activityEmoji(item.type) }}
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-foreground">{{ item.message }}</p>
                <p v-if="item.detail" class="text-xs text-muted-foreground truncate mt-0.5">{{ item.detail }}</p>
                <p class="text-[11px] text-muted-foreground mt-1">{{ item.time }}</p>
              </div>
              <span class="text-[10px] bg-muted text-muted-foreground px-1.5 py-0.5 rounded-full shrink-0">{{ item.type }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, reactive, watch, onMounted } from 'vue';
import {
  IconCamera,
  IconUser,
  IconShieldCheck,
  IconDeviceDesktop,
  IconDeviceMobile,
  IconRefresh,
  IconActivity,
  IconHistory,
} from '@tabler/icons-vue';
import { useAuthStore } from '@/stores/auth';
import { useToast } from '@/composables/useToast';
import { useApi } from '@/composables/useApi';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import AvatarPicker from '@/components/AvatarPicker.vue';

const authStore = useAuthStore();
const toast = useToast();
const { get, post, put, del } = useApi();

// --- Tabs ---
const tabs = [
  { id: 'profile' as const, label: 'Profile', icon: IconUser },
  { id: 'security' as const, label: 'Security', icon: IconShieldCheck },
  { id: 'sessions' as const, label: 'Sessions', icon: IconDeviceDesktop },
  { id: 'activity' as const, label: 'Activity', icon: IconHistory },
];
const activeTab = ref<'profile' | 'security' | 'sessions' | 'activity'>('profile');

// --- Profile data from API ---
interface ProfileResponse {
  name: string;
  display_name?: string;
  email: string;
  phone?: string;
  company?: string;
  bio?: string;
  avatar?: string;
  date_of_birth?: string;
  gender?: string;
  address?: string;
  city?: string;
  country?: string;
  timezone?: string;
  language?: string;
  social_links?: Record<string, string>;
  notification_preferences?: Record<string, boolean>;
  profile_photo_url?: string;
  profile_completion?: number;
  member_since?: string;
  account_age_days?: number;
  last_login_at?: string;
  [key: string]: unknown;
}

const profileData = ref<ProfileResponse | null>(null);

// --- Profile form ---
const form = ref({
  name: '',
  display_name: '',
  email: '',
  phone: '',
  company: '',
  bio: '',
  date_of_birth: '',
  gender: '',
  address: '',
  city: '',
  country: '',
  timezone: 'Africa/Nairobi',
});

const socialLinks = ref({
  linkedin: '',
  twitter: '',
  github: '',
  website: '',
});

const savingProfile = ref(false);
const profileErrors = reactive<Record<string, string>>({});

// --- Avatar ---
const avatarFile = ref<File | null>(null);
const avatarPreview = ref<string | null>(null);
const uploadingAvatar = ref(false);
const showAvatarPicker = ref(false);

function handleAvatarSelect(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0];
  if (!file) return;
  if (file.size > 5 * 1024 * 1024) {
    toast.error('File too large', 'Avatar must be under 5MB');
    return;
  }
  avatarFile.value = file;
  avatarPreview.value = URL.createObjectURL(file);
}

// Handle uploaded file from AvatarPicker
function handleAvatarUpload(file: File) {
  if (file.size > 5 * 1024 * 1024) {
    toast.error('File too large', 'Avatar must be under 5MB');
    return;
  }
  avatarFile.value = file;
  avatarPreview.value = URL.createObjectURL(file);
}

// Handle selected preset avatar (URL)
async function handleAvatarPresetSelect(url: string) {
  showAvatarPicker.value = false;
  uploadingAvatar.value = true;
  try {
    // Send the preset avatar URL to be saved
    const data = await post<any>('/user/profile/avatar', { avatar_url: url });
    const user = (data as any).data?.user ?? (data as any).user;
    if (user) authStore.user = user;
    toast.success('Avatar updated', 'Your profile avatar has been changed.');
    fetchProfile();
  } catch (err: any) {
    toast.error('Update failed', err.response?.data?.message || 'Could not update avatar.');
  } finally {
    uploadingAvatar.value = false;
  }
}

function cancelAvatarSelect() {
  avatarFile.value = null;
  if (avatarPreview.value) {
    URL.revokeObjectURL(avatarPreview.value);
    avatarPreview.value = null;
  }
}

async function uploadAvatar() {
  if (!avatarFile.value) return;
  uploadingAvatar.value = true;
  try {
    const formData = new FormData();
    formData.append('avatar', avatarFile.value);
    const data = await post<any>('/user/profile/avatar', formData);
    const user = (data as any).data?.user ?? (data as any).user;
    if (user) authStore.user = user;
    toast.success('Avatar updated', 'Your profile photo has been changed.');
    cancelAvatarSelect();
    fetchProfile();
  } catch (err: any) {
    toast.error('Upload failed', err.response?.data?.message || 'Could not upload avatar.');
  } finally {
    uploadingAvatar.value = false;
  }
}

async function removeAvatar() {
  try {
    await del('/user/profile/avatar');
    toast.success('Avatar removed', 'Your profile photo has been removed.');
    fetchProfile();
  } catch (err: any) {
    toast.error('Failed', err.response?.data?.message || 'Could not remove avatar.');
  }
}

// --- Populate form from profile data ---
function populateForm(data: ProfileResponse) {
  form.value.name = data.name || '';
  form.value.display_name = data.display_name || '';
  form.value.email = data.email || '';
  form.value.phone = data.phone || '';
  form.value.company = data.company || '';
  form.value.bio = data.bio || '';
  form.value.date_of_birth = data.date_of_birth || '';
  form.value.gender = data.gender || '';
  form.value.address = data.address || '';
  form.value.city = data.city || '';
  form.value.country = data.country || '';
  form.value.timezone = data.timezone || 'Africa/Nairobi';

  const sl = data.social_links || {};
  socialLinks.value.linkedin = sl.linkedin || '';
  socialLinks.value.twitter = sl.twitter || '';
  socialLinks.value.github = sl.github || '';
  socialLinks.value.website = sl.website || '';
}

function resetProfileForm() {
  if (profileData.value) populateForm(profileData.value);
  Object.keys(profileErrors).forEach(k => delete profileErrors[k]);
}

// --- Fetch profile ---
async function fetchProfile() {
  try {
    const data = await get<any>('/user/profile/full');
    profileData.value = (data as any).data ?? data;
    if (profileData.value) {
      populateForm(profileData.value);
      // Set 2FA state from user data
      if ((profileData.value as any).two_factor_email_enabled !== undefined) {
        twoFactorEmailEnabled.value = !!(profileData.value as any).two_factor_email_enabled;
      }
    }
  } catch {
    // fallback to auth store
    if (authStore.user) {
      populateForm(authStore.user as any);
      if ((authStore.user as any).two_factor_email_enabled !== undefined) {
        twoFactorEmailEnabled.value = !!(authStore.user as any).two_factor_email_enabled;
      }
    }
  }
}

// --- Save profile ---
async function handleUpdateProfile() {
  Object.keys(profileErrors).forEach(k => delete profileErrors[k]);
  savingProfile.value = true;

  const payload: Record<string, unknown> = { ...form.value };
  // Build social links
  const links: Record<string, string> = {};
  if (socialLinks.value.linkedin) links.linkedin = socialLinks.value.linkedin;
  if (socialLinks.value.twitter) links.twitter = socialLinks.value.twitter;
  if (socialLinks.value.github) links.github = socialLinks.value.github;
  if (socialLinks.value.website) links.website = socialLinks.value.website;
  if (Object.keys(links).length) payload.social_links = links;

  try {
    const data = await put<any>('/user/profile/full', payload);
    const user = (data as any).data?.user ?? (data as any).user;
    if (user) authStore.user = user;
    toast.success('Profile updated', 'Your profile has been saved successfully.');
    fetchProfile();
  } catch (err: any) {
    const resp = err.response;
    if (resp?.status === 422 && resp.data?.errors) {
      for (const [field, msgs] of Object.entries(resp.data.errors)) {
        profileErrors[field] = Array.isArray(msgs) ? msgs[0] as string : String(msgs);
      }
    } else {
      toast.error('Update failed', resp?.data?.message || 'Could not update your profile.');
    }
  } finally {
    savingProfile.value = false;
  }
}

// --- Password ---
const passwordForm = ref({ current_password: '', password: '', password_confirmation: '' });
const savingPassword = ref(false);
const passwordErrors = reactive<Record<string, string>>({});

async function handleChangePassword() {
  Object.keys(passwordErrors).forEach(k => delete passwordErrors[k]);
  savingPassword.value = true;
  try {
    await authStore.changePassword({
      current_password: passwordForm.value.current_password,
      password: passwordForm.value.password,
      password_confirmation: passwordForm.value.password_confirmation,
    });
    toast.success('Password updated', 'Your password has been changed successfully.');
    passwordForm.value = { current_password: '', password: '', password_confirmation: '' };
  } catch (err: any) {
    const resp = err.response;
    if (resp?.status === 422 && resp.data?.errors) {
      for (const [field, msgs] of Object.entries(resp.data.errors)) {
        passwordErrors[field] = Array.isArray(msgs) ? msgs[0] as string : String(msgs);
      }
    } else if (resp?.status === 422 && resp.data?.message) {
      passwordErrors.current_password = resp.data.message;
    } else {
      toast.error('Update failed', 'Could not change your password.');
    }
  } finally {
    savingPassword.value = false;
  }
}

// --- Two-Factor Email Authentication ---
const twoFactorEmailEnabled = ref(true);
const toggling2FA = ref(false);
const twoFactorMessage = ref('');

async function toggleTwoFactorEmail() {
  toggling2FA.value = true;
  twoFactorMessage.value = '';
  try {
    const data = await post<any>('/auth/2fa/toggle', {});
    const result = (data as any).data ?? data;
    twoFactorEmailEnabled.value = result.two_factor_email_enabled;
    twoFactorMessage.value = result.message;
    toast.success('2FA Updated', result.message);
    setTimeout(() => { twoFactorMessage.value = ''; }, 5000);
  } catch (err: any) {
    toast.error('Failed', err.response?.data?.message || 'Could not update 2FA settings.');
  } finally {
    toggling2FA.value = false;
  }
}

// --- Sessions ---
interface SessionEntry {
  ip_address: string;
  device: string;
  browser: string;
  platform: string;
  location?: string;
  logged_in_at: string;
}
const sessions = ref<SessionEntry[]>([]);
const loadingSessions = ref(false);

async function fetchSessions() {
  loadingSessions.value = true;
  try {
    const data = await get<any>('/user/profile/sessions');
    sessions.value = (data as any).data ?? data ?? [];
  } catch {
    sessions.value = [];
  } finally {
    loadingSessions.value = false;
  }
}

// --- Activity Log ---
interface ActivityEntry {
  id: number;
  type: string;
  message: string;
  detail?: string;
  time: string;
}
const activityLog = ref<ActivityEntry[]>([]);
const loadingActivityLog = ref(false);

async function fetchActivityLog() {
  loadingActivityLog.value = true;
  try {
    const data = await get<any>('/user/profile/activity');
    activityLog.value = (data as any).data ?? data ?? [];
  } catch {
    activityLog.value = [];
  } finally {
    loadingActivityLog.value = false;
  }
}

function activityBgClass(type: string): string {
  const map: Record<string, string> = { review: 'bg-amber-500/10', enquiry: 'bg-blue-500/10', wishlist: 'bg-pink-500/10' };
  return map[type] ?? 'bg-muted';
}

function activityEmoji(type: string): string {
  const map: Record<string, string> = { review: '⭐', enquiry: '📩', wishlist: '❤️' };
  return map[type] ?? '📋';
}

function formatDate(dateStr: string): string {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleString('en-US', {
    month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit',
  });
}

// --- Tab watchers to lazy-load data ---
watch(activeTab, (tab) => {
  if (tab === 'sessions' && sessions.value.length === 0) fetchSessions();
  if (tab === 'activity' && activityLog.value.length === 0) fetchActivityLog();
});

// --- Init ---
onMounted(() => {
  fetchProfile();
});
</script>
