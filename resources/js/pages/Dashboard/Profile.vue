<template>
  <DashboardLayout>
    <div class="space-y-8">
      <!-- Page Header -->
      <div>
        <h1 class="text-3xl font-display font-bold text-foreground mb-2">My Profile</h1>
        <p class="text-muted-foreground">Manage your personal information and account settings</p>
      </div>

      <!-- Profile Form -->
      <div class="bg-card border border-border rounded-lg p-8">
        <form @submit.prevent="updateProfile" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Full Name</label>
              <input 
                v-model="form.name"
                type="text"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                placeholder="John Doe"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Email Address</label>
              <input 
                v-model="form.email"
                type="email"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                placeholder="john@example.com"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Phone Number</label>
              <input 
                v-model="form.phone"
                type="tel"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
                placeholder="+1 234 567 8900"
              />
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
              class="bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition"
            >
              Save Changes
            </button>
            <button 
              type="button"
              class="border border-border hover:border-border text-muted-foreground font-semibold px-6 py-2.5 rounded-lg transition"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>

      <!-- Password Change -->
      <div class="bg-card border border-border rounded-lg p-8">
        <h2 class="text-xl font-bold text-foreground mb-6">Change Password</h2>
        <form @submit.prevent="updatePassword" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-muted-foreground mb-2">Current Password</label>
            <input 
              v-model="passwordForm.current"
              type="password"
              class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
            />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">New Password</label>
              <input 
                v-model="passwordForm.new"
                type="password"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-muted-foreground mb-2">Confirm New Password</label>
              <input 
                v-model="passwordForm.confirm"
                type="password"
                class="w-full bg-muted/50 border border-border rounded-lg px-4 py-2.5 text-foreground focus:border-primary focus:outline-none transition"
              />
            </div>
          </div>

          <button 
            type="submit"
            class="bg-primary hover:bg-primary/90 text-white font-semibold px-6 py-2.5 rounded-lg transition"
          >
            Update Password
          </button>
        </form>
      </div>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

const authStore = useAuthStore();

const form = ref({
  name: authStore.user?.name || '',
  email: authStore.user?.email || '',
  phone: '',
  company: '',
  bio: ''
});

const passwordForm = ref({
  current: '',
  new: '',
  confirm: ''
});

const updateProfile = () => {
  // TODO: API call to update profile
  console.log('Update profile:', form.value);
};

const updatePassword = () => {
  // TODO: API call to update password
  console.log('Update password');
};
</script>
