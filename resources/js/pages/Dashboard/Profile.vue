<template>
  <DashboardLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-xl font-display font-bold text-foreground mb-1">My Profile</h1>
        <p class="text-muted-foreground">Manage your personal information and account settings</p>
      </div>

      <!-- Profile Form -->
      <div class="bg-card border border-border rounded-lg p-8">
        <form @submit.prevent="handleUpdateProfile" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Full Name</label>
              <input
                v-model="form.name"
                type="text"
                class="w-full bg-muted/50 border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                :class="profileErrors.name ? 'border-destructive' : 'border-border'"
                placeholder="John Doe"
              />
              <p v-if="profileErrors.name" class="text-xs text-destructive mt-1">{{ profileErrors.name }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Email Address</label>
              <input
                v-model="form.email"
                type="email"
                class="w-full bg-muted/50 border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                :class="profileErrors.email ? 'border-destructive' : 'border-border'"
                placeholder="john@example.com"
              />
              <p v-if="profileErrors.email" class="text-xs text-destructive mt-1">{{ profileErrors.email }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Phone Number</label>
              <input
                v-model="form.phone"
                type="tel"
                class="w-full bg-muted/50 border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                :class="profileErrors.phone ? 'border-destructive' : 'border-border'"
                placeholder="+27 12 345 6789"
              />
              <p v-if="profileErrors.phone" class="text-xs text-destructive mt-1">{{ profileErrors.phone }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Company</label>
              <input
                v-model="form.company"
                type="text"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                placeholder="Your Company"
              />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-muted-foreground mb-2">Bio</label>
            <textarea
              v-model="form.bio"
              rows="4"
              class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition resize-none"
              placeholder="Tell us about yourself..."
            ></textarea>
          </div>

          <div class="flex gap-4">
            <button
              type="submit"
              :disabled="savingProfile"
              class="bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
            >
              <svg v-if="savingProfile" class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
              </svg>
              {{ savingProfile ? 'Saving...' : 'Save Changes' }}
            </button>
            <button
              type="button"
              @click="resetProfileForm"
              class="border border-border hover:border-border text-muted-foreground font-medium px-4 py-2 text-sm rounded-lg transition"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>

      <!-- Password Change -->
      <div class="bg-card border border-border rounded-lg p-8">
        <h2 class="text-xl font-bold text-foreground mb-6">Change Password</h2>
        <form @submit.prevent="handleChangePassword" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-muted-foreground mb-2">Current Password</label>
            <input
              v-model="passwordForm.current_password"
              type="password"
              class="w-full bg-muted/50 border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
              :class="passwordErrors.current_password ? 'border-destructive' : 'border-border'"
            />
            <p v-if="passwordErrors.current_password" class="text-xs text-destructive mt-1">{{ passwordErrors.current_password }}</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">New Password</label>
              <input
                v-model="passwordForm.password"
                type="password"
                class="w-full bg-muted/50 border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                :class="passwordErrors.password ? 'border-destructive' : 'border-border'"
              />
              <p v-if="passwordErrors.password" class="text-xs text-destructive mt-1">{{ passwordErrors.password }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Confirm New Password</label>
              <input
                v-model="passwordForm.password_confirmation"
                type="password"
                class="w-full bg-muted/50 border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                :class="passwordErrors.password_confirmation ? 'border-destructive' : 'border-border'"
              />
              <p v-if="passwordErrors.password_confirmation" class="text-xs text-destructive mt-1">{{ passwordErrors.password_confirmation }}</p>
            </div>
          </div>

          <button
            type="submit"
            :disabled="savingPassword"
            class="bg-primary hover:bg-primary/90 text-white font-medium px-4 py-2 text-sm rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
          >
            <svg v-if="savingPassword" class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
            </svg>
            {{ savingPassword ? 'Updating...' : 'Update Password' }}
          </button>
        </form>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, reactive, watch } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useToast } from '@/composables/useToast';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const authStore = useAuthStore();
const toast = useToast();

// --- Profile form ---
const form = ref({
  name: authStore.user?.name || '',
  email: authStore.user?.email || '',
  phone: (authStore.user as any)?.phone || '',
  company: (authStore.user as any)?.company || '',
  bio: (authStore.user as any)?.bio || '',
});

const savingProfile = ref(false);
const profileErrors = reactive<Record<string, string>>({});

// Keep form in sync if user data loads later
watch(() => authStore.user, (u) => {
  if (u) {
    form.value.name = u.name || '';
    form.value.email = u.email || '';
    form.value.phone = (u as any)?.phone || '';
    form.value.company = (u as any)?.company || '';
    form.value.bio = (u as any)?.bio || '';
  }
}, { immediate: true });

function resetProfileForm() {
  form.value.name = authStore.user?.name || '';
  form.value.email = authStore.user?.email || '';
  form.value.phone = (authStore.user as any)?.phone || '';
  form.value.company = (authStore.user as any)?.company || '';
  form.value.bio = (authStore.user as any)?.bio || '';
  Object.keys(profileErrors).forEach(k => delete profileErrors[k]);
}

async function handleUpdateProfile() {
  Object.keys(profileErrors).forEach(k => delete profileErrors[k]);
  savingProfile.value = true;

  try {
    await authStore.updateProfile({
      name: form.value.name,
      email: form.value.email,
      phone: form.value.phone,
      company: form.value.company,
      bio: form.value.bio,
    } as any);

    toast.success('Profile updated', 'Your profile has been saved successfully.');
  } catch (err: any) {
    const resp = err.response;
    if (resp?.status === 422 && resp.data?.errors) {
      for (const [field, msgs] of Object.entries(resp.data.errors)) {
        profileErrors[field] = Array.isArray(msgs) ? msgs[0] : String(msgs);
      }
    } else {
      toast.error('Update failed', resp?.data?.message || 'Could not update your profile. Please try again.');
    }
  } finally {
    savingProfile.value = false;
  }
}

// --- Password form ---
const passwordForm = ref({
  current_password: '',
  password: '',
  password_confirmation: '',
});

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
        passwordErrors[field] = Array.isArray(msgs) ? msgs[0] : String(msgs);
      }
    } else if (resp?.status === 422 && resp.data?.message) {
      passwordErrors.current_password = resp.data.message;
    } else {
      toast.error('Update failed', 'Could not change your password. Please try again.');
    }
  } finally {
    savingPassword.value = false;
  }
}
</script>
