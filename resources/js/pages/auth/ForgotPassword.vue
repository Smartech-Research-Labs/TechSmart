<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
import axios from 'axios'
import AuthPageLayout from '@/layouts/AuthPageLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Spinner } from '@/components/ui/spinner'

const email = ref('')
const status = ref('')
const errors = ref<Record<string, string[]>>({})
const processing = ref(false)

async function submit() {
  status.value = ''
  errors.value = {}
  processing.value = true

  try {
    await axios.get('/sanctum/csrf-cookie')
    const response = await axios.post(
      '/forgot-password',
      { email: email.value },
      { headers: { Accept: 'application/json' } },
    )
    status.value = response.data.status ?? 'We have emailed your password reset link.'
  } catch (err: any) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors ?? {}
    } else {
      errors.value = { email: ['Something went wrong. Please try again.'] }
    }
  } finally {
    processing.value = false
  }
}
</script>

<template>
  <AuthPageLayout>
    <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
      <div class="flex flex-col space-y-2 text-center">
        <h1 class="text-2xl font-semibold tracking-tight">Forgot password</h1>
        <p class="text-sm text-muted-foreground">Enter your email to receive a password reset link</p>
      </div>

      <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-green-600"
      >
        {{ status }}
      </div>

      <form class="space-y-6" @submit.prevent="submit">
        <div class="grid gap-2">
          <Label for="email">Email address</Label>
          <Input
            id="email"
            v-model="email"
            type="email"
            autocomplete="off"
            autofocus
            placeholder="email@example.com"
          />
          <p v-if="errors.email" class="text-sm text-destructive">{{ errors.email[0] }}</p>
        </div>

        <Button
          type="submit"
          class="w-full"
          :disabled="processing"
          data-test="email-password-reset-link-button"
        >
          <Spinner v-if="processing" class="mr-2" />
          Email password reset link
        </Button>
      </form>

      <div class="space-x-1 text-center text-sm text-muted-foreground">
        <span>Or, return to</span>
        <RouterLink to="/login" class="underline underline-offset-4 hover:text-primary">log in</RouterLink>
      </div>
    </div>
  </AuthPageLayout>
</template>
