<script setup lang="ts">
import { ref, computed } from 'vue';
import type { HTMLAttributes } from 'vue';
import { useRouter } from 'vue-router';
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
import heroTechBg from '@/../img/tech-background.png';

const props = defineProps<{
  class?: HTMLAttributes['class'];
}>();

const router = useRouter();
const authStore = useAuthStore();
const cmsStore = useCmsStore();

const registerImage = computed(() => cmsStore.homeData?.settings?.register_page_image || heroTechBg);
const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  agree: false,
});
const errors = ref<Record<string, string>>({});
const processing = ref(false);
const googleProcessing = ref(false);
const showPassword = ref(false);
const showConfirmPassword = ref(false);

// Password strength
const passwordStrength = computed(() => {
  const p = form.value.password;
  if (!p) return 0;
  let score = 0;
  if (p.length >= 8) score++;
  if (p.length >= 12) score++;
  if (/[A-Z]/.test(p)) score++;
  if (/[0-9]/.test(p)) score++;
  if (/[^A-Za-z0-9]/.test(p)) score++;
  return score;
});

const strengthLabel = computed(() => {
  const s = passwordStrength.value;
  if (!form.value.password) return '';
  if (s <= 1) return 'Weak';
  if (s <= 2) return 'Fair';
  if (s <= 3) return 'Good';
  if (s <= 4) return 'Strong';
  return 'Very strong';
});

const strengthColor = computed(() => {
  const s = passwordStrength.value;
  if (s <= 1) return 'bg-destructive';
  if (s <= 2) return 'bg-amber-500';
  if (s <= 3) return 'bg-yellow-400';
  if (s <= 4) return 'bg-primary';
  return 'bg-emerald-400';
});

const strengthTextColor = computed(() => {
  const s = passwordStrength.value;
  if (s <= 1) return 'text-destructive';
  if (s <= 2) return 'text-amber-500';
  if (s <= 3) return 'text-yellow-500';
  if (s <= 4) return 'text-primary';
  return 'text-emerald-500';
});

const passwordsMatch = computed(() =>
  form.value.password_confirmation.length > 0 &&
  form.value.password === form.value.password_confirmation
);

const passwordsMismatch = computed(() =>
  form.value.password_confirmation.length > 0 &&
  form.value.password !== form.value.password_confirmation
);

async function handleSubmit() {
  errors.value = {};

  if (!form.value.agree) {
    errors.value.agree = 'You must agree to the terms to continue.';
    return;
  }

  if (passwordsMismatch.value) {
    errors.value.password_confirmation = 'Passwords do not match.';
    return;
  }

  processing.value = true;

  try {
    await authStore.register({
      name: form.value.name,
      email: form.value.email,
      password: form.value.password,
      password_confirmation: form.value.password_confirmation,
    });

    router.push('/dashboard');
  } catch (err: any) {
    if (err.response?.data?.errors) {
      const serverErrors = err.response.data.errors;
      for (const key in serverErrors) {
        errors.value[key] = Array.isArray(serverErrors[key])
          ? serverErrors[key][0]
          : serverErrors[key];
      }
    } else {
      errors.value.email = err.response?.data?.message || 'Registration failed. Please try again.';
    }
  } finally {
    processing.value = false;
  }
}

async function handleGoogleSignUp() {
  googleProcessing.value = true;
  try {
    window.location.href = `${import.meta.env.VITE_API_URL}/auth/google/redirect`;
  } catch {
    errors.value.email = 'Google sign-up failed. Please try again.';
    googleProcessing.value = false;
  }
}
</script>

<template>
  <div :class="cn('flex flex-col gap-6', props.class ?? '')">
    <Card class="overflow-hidden">
      <CardContent class="grid p-0 md:grid-cols-2">
        <!-- Form Side -->
        <div class="p-6 md:p-8">
          <div class="flex flex-col gap-6">
            <CardHeader class="p-0">
              <CardTitle class="text-2xl">
                Create your account
              </CardTitle>
              <CardDescription>
                Enter your details below to create your account
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
                <!-- Full Name -->
                <div class="grid gap-2">
                  <Label for="name">Full name</Label>
                  <Input
                    id="name"
                    v-model="form.name"
                    type="text"
                    placeholder="John Doe"
                    required
                    autofocus
                    autocomplete="name"
                    :class="errors.name ? 'border-destructive focus-visible:ring-destructive/20' : ''"
                  />
                  <p v-if="errors.name" class="text-xs text-destructive">{{ errors.name }}</p>
                </div>

                <!-- Email -->
                <div class="grid gap-2">
                  <Label for="email">Email</Label>
                  <Input
                    id="email"
                    v-model="form.email"
                    type="email"
                    placeholder="you@example.com"
                    required
                    autocomplete="email"
                    :class="errors.email ? 'border-destructive focus-visible:ring-destructive/20' : ''"
                  />
                  <p class="text-xs text-muted-foreground">We'll use this to contact you. We will not share your email with anyone.</p>
                  <p v-if="errors.email" class="text-xs text-destructive">{{ errors.email }}</p>
                </div>

                <!-- Password + Confirm side by side -->
                <div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div class="grid gap-2">
                      <Label for="password">Password</Label>
                      <div class="relative">
                        <Input
                          id="password"
                          v-model="form.password"
                          :type="showPassword ? 'text' : 'password'"
                          required
                          autocomplete="new-password"
                          placeholder="Min. 8 characters"
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

                    <!-- Confirm Password -->
                    <div class="grid gap-2">
                      <Label for="password_confirmation">Confirm password</Label>
                      <div class="relative">
                        <Input
                          id="password_confirmation"
                          v-model="form.password_confirmation"
                          :type="showConfirmPassword ? 'text' : 'password'"
                          required
                          autocomplete="new-password"
                          placeholder="Re-enter password"
                          class="pr-10"
                          :class="[
                            passwordsMatch ? 'border-primary focus-visible:ring-primary/20' : '',
                            passwordsMismatch ? 'border-destructive focus-visible:ring-destructive/20' : '',
                          ]"
                        />
                        <button
                          type="button"
                          @click="showConfirmPassword = !showConfirmPassword"
                          class="absolute inset-y-0 right-3 flex items-center text-muted-foreground hover:text-foreground transition-colors"
                          tabindex="-1"
                        >
                          <svg v-if="!showConfirmPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          </svg>
                          <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                          </svg>
                        </button>
                      </div>
                      <p v-if="passwordsMatch" class="flex items-center gap-1 text-xs text-primary">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Passwords match
                      </p>
                      <p v-if="errors.password_confirmation || passwordsMismatch" class="text-xs text-destructive">
                        {{ errors.password_confirmation || 'Passwords do not match' }}
                      </p>
                    </div>
                  </div>

                  <!-- Password strength meter -->
                  <div v-if="form.password" class="mt-3 space-y-1.5">
                    <div class="flex gap-1">
                      <div
                        v-for="i in 5"
                        :key="i"
                        :class="[
                          'h-1 flex-1 rounded-full transition-all duration-300',
                          i <= passwordStrength ? strengthColor : 'bg-muted'
                        ]"
                      ></div>
                    </div>
                    <p class="text-xs" :class="strengthTextColor">
                      {{ strengthLabel }} password
                      <span class="text-muted-foreground ml-1" v-if="passwordStrength < 3">— add uppercase, numbers &amp; symbols</span>
                    </p>
                  </div>
                  <p v-else class="text-xs text-muted-foreground mt-2">Must be at least 8 characters long.</p>
                </div>

                <!-- Terms agreement -->
                <div class="space-y-1.5">
                  <div class="flex items-start gap-2">
                    <button
                      type="button"
                      role="checkbox"
                      :aria-checked="form.agree"
                      @click="form.agree = !form.agree"
                      :class="[
                        'mt-0.5 h-4 w-4 shrink-0 rounded-sm border shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring transition-colors',
                        form.agree ? 'bg-primary border-primary text-primary-foreground' : '',
                        errors.agree ? 'border-destructive' : 'border-primary',
                      ]"
                    >
                      <svg v-if="form.agree" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                      </svg>
                    </button>
                    <Label class="text-sm font-normal leading-relaxed cursor-pointer" @click="form.agree = !form.agree">
                      I agree to the
                      <a href="/terms" class="underline underline-offset-4 hover:text-primary">Terms of Service</a>
                      and
                      <a href="/privacy" class="underline underline-offset-4 hover:text-primary">Privacy Policy</a>
                    </Label>
                  </div>
                  <p v-if="errors.agree" class="text-xs text-destructive ml-6">{{ errors.agree }}</p>
                </div>

                <!-- Submit -->
                <Button type="submit" class="w-full" :disabled="processing || googleProcessing">
                  <svg v-if="processing" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                  </svg>
                  {{ processing ? 'Creating account...' : 'Create Account' }}
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
                  @click="handleGoogleSignUp"
                >
                  <svg v-if="googleProcessing" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                  </svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4">
                    <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z" fill="currentColor" />
                  </svg>
                  {{ googleProcessing ? 'Redirecting...' : 'Sign up with Google' }}
                </Button>
              </div>
            </form>

            <!-- Login link -->
            <div class="text-center text-sm">
              Already have an account?
              <router-link to="/login" class="underline underline-offset-4 hover:text-primary">
                Sign in
              </router-link>
            </div>
          </div>
        </div>

        <!-- Image Side -->
        <div class="relative hidden bg-muted md:block">
          <img
            :src="registerImage"
            alt="OmniviaTech Sign Up"
            class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
          />
          <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-primary/5 to-accent/20 dark:from-primary/10 dark:via-transparent dark:to-accent/10"></div>
          <div class="absolute inset-0 flex flex-col items-center justify-center p-8">
            <div class="rounded-xl bg-background/80 dark:bg-background/60 backdrop-blur-sm border border-border/50 p-6 text-center max-w-xs">
              <div class="flex items-center justify-center gap-2 mb-3">
                <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                </svg>
                <span class="text-xl font-bold text-foreground">OmniviaTech</span>
              </div>
              <p class="text-sm text-muted-foreground">
                Join thousands of clients building with us
              </p>
            </div>
          </div>
        </div>
      </CardContent>
    </Card>

    <!-- Bottom text -->
    <div class="text-balance text-center text-xs text-muted-foreground [&_a]:underline [&_a]:underline-offset-4 [&_a]:hover:text-primary">
      By clicking continue, you agree to our <a href="/terms">Terms of Service</a> and <a href="/privacy">Privacy Policy</a>.
    </div>
  </div>
</template>
