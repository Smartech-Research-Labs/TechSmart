<script setup lang="ts">
import axios from 'axios'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Spinner } from '@/components/ui/spinner'
import AuthPageLayout from '@/layouts/AuthPageLayout.vue'

const route = useRoute()
const router = useRouter()

const token = route.params.token as string
const emailFromQuery = (route.query.email as string) ?? ''

const email = ref(emailFromQuery)
const password = ref('')
const passwordConfirmation = ref('')
const errors = ref<Record<string, string[]>>({})
const processing = ref(false)

async function submit() {
  errors.value = {}
  processing.value = true

  try {
    await axios.get('/sanctum/csrf-cookie')
    await axios.post(
      '/reset-password',
      {
        token,
        email: email.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value,
      },
      { headers: { Accept: 'application/json' } },
    )
    router.push('/login')
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
        <h1 class="text-2xl font-semibold tracking-tight">Reset password</h1>
        <p class="text-sm text-muted-foreground">Please enter your new password below</p>
      </div>

      <form class="space-y-6" @submit.prevent="submit">
        <div class="grid gap-6">
          <div class="grid gap-2">
            <Label for="email">Email</Label>
            <Input
              id="email"
              v-model="email"
              type="email"
              autocomplete="email"
              class="mt-1 block w-full"
              readonly
            />
            <p v-if="errors.email" class="text-sm text-destructive">{{ errors.email[0] }}</p>
          </div>

          <div class="grid gap-2">
            <Label for="password">Password</Label>
            <Input
              id="password"
              v-model="password"
              type="password"
              autocomplete="new-password"
              class="mt-1 block w-full"
              autofocus
              placeholder="Password"
            />
            <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password[0] }}</p>
          </div>

          <div class="grid gap-2">
            <Label for="password_confirmation">Confirm Password</Label>
            <Input
              id="password_confirmation"
              v-model="passwordConfirmation"
              type="password"
              autocomplete="new-password"
              class="mt-1 block w-full"
              placeholder="Confirm password"
            />
            <p v-if="errors.password_confirmation" class="text-sm text-destructive">{{ errors.password_confirmation[0] }}</p>
          </div>

          <Button
            type="submit"
            class="mt-4 w-full"
            :disabled="processing"
            data-test="reset-password-button"
          >
            <Spinner v-if="processing" class="mr-2" />
            Reset password
          </Button>
        </div>
      </form>
    </div>
  </AuthPageLayout>
</template>
