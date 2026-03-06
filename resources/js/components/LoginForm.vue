<script setup lang="ts">
import { ref, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { useCmsStore } from '@/stores/cms';
import { cn } from '@/lib/utils';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card';
import axios from 'axios';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const cmsStore = useCmsStore();

const loginImage = computed(() => cmsStore.homeData?.settings?.login_page_image || '/images/login-hero.jpg');

const form = ref({
  email: '',
  password: '',
  remember: false,
});
const errors = ref<Record<string, string>>({});
const processing = ref(false);
const googleProcessing = ref(false);
const showPassword = ref(false);

// 2FA state
const requires2FA = ref(false);
const twoFactorCode = ref('');
const twoFactorEmail = ref('');
const emailHint = ref('');
const resending = ref(false);
const resendSuccess = ref('');

async function handleSubmit() {
  if (requires2FA.value) {
    await verify2FACode();
    return;
  }

  processing.value = true;
  errors.value = {};

  try {
    const response = await axios.post('/api/v1/auth/login', {
      email: form.value.email,
      password: form.value.password,
    });

    // Check if 2FA is required
    if (response.data.requires_2fa) {
      requires2FA.value = true;
      twoFactorEmail.value = form.value.email;
      emailHint.value = response.data.email_hint || '';
      return;
    }

    // Normal login - store token
    authStore.token = response.data.token;
    authStore.user = response.data.user;
    localStorage.setItem('token', response.data.token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;

    const redirect = (route.query.redirect as string) || '/dashboard';
    router.push(redirect);
  } catch (err: any) {
    if (err.response?.data?.errors) {
      const serverErrors = err.response.data.errors;
      for (const key in serverErrors) {
        errors.value[key] = Array.isArray(serverErrors[key])
          ? serverErrors[key][0]
          : serverErrors[key];
      }
    } else {
      errors.value.email = err.response?.data?.message || 'Login failed. Please try again.';
    }
  } finally {
    processing.value = false;
  }
}

async function verify2FACode() {
  processing.value = true;
  errors.value = {};

  try {
    const response = await axios.post('/api/v1/auth/2fa/verify', {
      email: twoFactorEmail.value,
      code: twoFactorCode.value,
    });

    // Login successful after 2FA
    authStore.token = response.data.token;
    authStore.user = response.data.user;
    localStorage.setItem('token', response.data.token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;

    const redirect = (route.query.redirect as string) || '/dashboard';
    router.push(redirect);
  } catch (err: any) {
    errors.value.code = err.response?.data?.message || 'Invalid verification code.';
    twoFactorCode.value = '';
  } finally {
    processing.value = false;
  }
}

async function resend2FACode() {
  resending.value = true;
  resendSuccess.value = '';
  errors.value = {};

  try {
    const response = await axios.post('/api/v1/auth/2fa/resend', {
      email: twoFactorEmail.value,
    });
    resendSuccess.value = response.data.message;
    setTimeout(() => { resendSuccess.value = ''; }, 5000);
  } catch (err: any) {
    errors.value.code = err.response?.data?.message || 'Failed to resend code.';
  } finally {
    resending.value = false;
  }
}

function backToLogin() {
  requires2FA.value = false;
  twoFactorCode.value = '';
  twoFactorEmail.value = '';
  emailHint.value = '';
  errors.value = {};
}

async function handleGoogleSignIn() {
  googleProcessing.value = true;
  try {
    const response = await axios.get('/api/v1/auth/google/redirect');
    window.location.href = response.data.url;
  } catch (err) {
    errors.value.email = 'Google sign-in failed. Please try again.';
    googleProcessing.value = false;
  }
}
</script>

<template>
  <div :class="cn('flex flex-col gap-6', $attrs.class ?? '')">
    <Card class="overflow-hidden">
      <CardContent class="grid p-0 md:grid-cols-2">
        <!-- Form Side -->
        <div class="p-6 md:p-8">
          <div class="flex flex-col gap-6">
            <!-- 2FA Verification View -->
            <template v-if="requires2FA">
              <CardHeader class="p-0">
                <CardTitle class="text-2xl">
                  Verify Your Identity
                </CardTitle>
                <CardDescription>
                  We've sent a 6-digit verification code to <strong>{{ emailHint }}</strong>
                </CardDescription>
              </CardHeader>

              <!-- Success banner -->
              <div
                v-if="resendSuccess"
                class="flex items-start gap-3 p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-sm text-emerald-600 dark:text-emerald-400"
              >
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ resendSuccess }}</span>
              </div>

              <!-- Error banner -->
              <div
                v-if="errors.code"
                class="flex items-start gap-3 p-3 rounded-lg bg-destructive/10 border border-destructive/20 text-sm text-destructive"
              >
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ errors.code }}</span>
              </div>

              <form @submit.prevent="handleSubmit">
                <div class="flex flex-col gap-6">
                  <div class="grid gap-2">
                    <Label for="twoFactorCode">Verification Code</Label>
                    <Input
                      id="twoFactorCode"
                      v-model="twoFactorCode"
                      type="text"
                      inputmode="numeric"
                      maxlength="6"
                      placeholder="000000"
                      autocomplete="one-time-code"
                      autofocus
                      class="text-center text-2xl tracking-[0.5em] font-mono"
                    />
                  </div>

                  <Button type="submit" class="w-full" :disabled="processing || twoFactorCode.length !== 6">
                    <svg v-if="processing" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    {{ processing ? 'Verifying...' : 'Verify & Sign In' }}
                  </Button>

                  <div class="flex items-center justify-between text-sm">
                    <button
                      type="button"
                      class="text-muted-foreground hover:text-foreground underline-offset-4 hover:underline transition-colors"
                      @click="backToLogin"
                    >
                      &larr; Back to login
                    </button>
                    <button
                      type="button"
                      class="text-primary hover:text-primary/80 underline-offset-4 hover:underline transition-colors"
                      :disabled="resending"
                      @click="resend2FACode"
                    >
                      {{ resending ? 'Sending...' : 'Resend code' }}
                    </button>
                  </div>
                </div>
              </form>
            </template>

            <!-- Normal Login View -->
            <template v-else>
            <CardHeader class="p-0">
              <CardTitle class="text-2xl">
                Welcome back
              </CardTitle>
              <CardDescription>
                Sign in to your account to continue
              </CardDescription>
            </CardHeader>

            <!-- Error banner -->
            <div
              v-if="errors.email && !form.email"
              class="flex items-start gap-3 p-3 rounded-lg bg-destructive/10 border border-destructive/20 text-sm text-destructive"
            >
              <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <span>{{ errors.email }}</span>
            </div>

            <form @submit.prevent="handleSubmit">
              <div class="flex flex-col gap-6">
                <!-- Email -->
                <div class="grid gap-2">
                  <Label for="email">Email</Label>
                  <Input
                    id="email"
                    v-model="form.email"
                    type="email"
                    placeholder="you@example.com"
                    required
                    autofocus
                    autocomplete="email"
                    :class="errors.email ? 'border-destructive focus-visible:ring-destructive/20' : ''"
                  />
                  <p v-if="errors.email" class="text-xs text-destructive">{{ errors.email }}</p>
                </div>

                <!-- Password -->
                <div class="grid gap-2">
                  <div class="flex items-center">
                    <Label for="password">Password</Label>
                    <router-link
                      to="/forgot-password"
                      class="ml-auto text-sm underline-offset-2 hover:underline"
                    >
                      Forgot your password?
                    </router-link>
                  </div>
                  <div class="relative">
                    <Input
                      id="password"
                      v-model="form.password"
                      :type="showPassword ? 'text' : 'password'"
                      required
                      autocomplete="current-password"
                      placeholder="••••••••"
                      class="pr-10"
                      :class="errors.password ? 'border-destructive focus-visible:ring-destructive/20' : ''"
                    />
                    <button
                      type="button"
                      @click="showPassword = !showPassword"
                      class="absolute inset-y-0 right-3 flex items-center text-muted-foreground hover:text-foreground transition-colors"
                      tabindex="-1"
                    >
                      <svg v-if="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                      </svg>
                    </button>
                  </div>
                  <p v-if="errors.password" class="text-xs text-destructive">{{ errors.password }}</p>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-2">
                  <button
                    type="button"
                    role="checkbox"
                    :aria-checked="form.remember"
                    @click="form.remember = !form.remember"
                    :class="[
                      'peer h-4 w-4 shrink-0 rounded-sm border border-primary shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring transition-colors',
                      form.remember ? 'bg-primary text-primary-foreground' : 'bg-background'
                    ]"
                  >
                    <svg v-if="form.remember" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="20 6 9 17 4 12" />
                    </svg>
                  </button>
                  <Label class="text-sm font-normal cursor-pointer" @click="form.remember = !form.remember">
                    Remember me
                  </Label>
                </div>

                <!-- Submit -->
                <Button type="submit" class="w-full" :disabled="processing || googleProcessing">
                  <svg v-if="processing" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                  </svg>
                  {{ processing ? 'Signing in...' : 'Sign in' }}
                </Button>

                <!-- Divider -->
                <div class="relative text-center text-sm after:absolute after:inset-0 after:top-1/2 after:z-0 after:flex after:items-center after:border-t after:border-border">
                  <span class="relative z-10 bg-card px-2 text-muted-foreground">
                    Or continue with
                  </span>
                </div>

                <!-- Google -->
                <Button
                  variant="outline"
                  class="w-full"
                  type="button"
                  :disabled="googleProcessing || processing"
                  @click="handleGoogleSignIn"
                >
                  <svg v-if="googleProcessing" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                  </svg>
                  <svg v-else class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                  </svg>
                  {{ googleProcessing ? 'Redirecting...' : 'Login with Google' }}
                </Button>
              </div>
            </form>

            <!-- Sign up link -->
            <div class="text-center text-sm">
              Don&apos;t have an account?
              <router-link to="/register" class="underline underline-offset-4 hover:text-primary">
                Sign up
              </router-link>
            </div>
            </template>
          </div>
        </div>

        <!-- Image Side -->
        <div class="relative hidden bg-muted md:block">
          <img
            :src="loginImage"
            alt="Smartech Research Labs Login"
            class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
          />
          <!-- Fallback gradient overlay when no image -->
          <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-primary/5 to-accent/20 dark:from-primary/10 dark:via-transparent dark:to-accent/10"></div>
          <!-- Branding overlay -->
          <div class="absolute inset-0 flex flex-col items-center justify-center p-8">
            <div class="rounded-xl bg-background/80 dark:bg-background/60 backdrop-blur-sm border border-border/50 p-6 text-center max-w-xs">
              <div class="flex items-center justify-center gap-2 mb-3">
                <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                </svg>
                <span class="text-xl font-bold text-foreground">Smartech Research Labs</span>
              </div>
              <p class="text-sm text-muted-foreground">
                Innovative Technology Solutions
              </p>
            </div>
          </div>
        </div>
      </CardContent>
    </Card>

    <!-- Trust badges -->
    <div class="text-balance text-center text-xs text-muted-foreground [&_a]:underline [&_a]:underline-offset-4 [&_a]:hover:text-primary">
      By clicking continue, you agree to our <a href="/terms">Terms of Service</a> and <a href="/privacy">Privacy Policy</a>.
    </div>
  </div>
</template>
