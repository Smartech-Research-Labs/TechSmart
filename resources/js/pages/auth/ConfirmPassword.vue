<script setup lang="ts">
import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Spinner } from '@/components/ui/spinner'
import AuthPageLayout from '@/layouts/AuthPageLayout.vue'

const router = useRouter()

const password = ref('')
const errors = ref<Record<string, string[]>>({})
const processing = ref(false)

async function submit() {
  errors.value = {}
  processing.value = true

  try {
    await axios.get('/sanctum/csrf-cookie')
    await axios.post(
      '/user/confirm-password',
      { password: password.value },
      { headers: { Accept: 'application/json' } },
    )
    router.push('/dashboard')
  } catch (err: any) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors ?? {}
    } else {
      errors.value = { password: ['Something went wrong. Please try again.'] }
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
        <h1 class="text-2xl font-semibold tracking-tight">Confirm your password</h1>
        <p class="text-sm text-muted-foreground">This is a secure area of the application. Please confirm your password before continuing.</p>
      </div>

      <Card>
        <CardContent class="pt-6">
          <form class="space-y-6" @submit.prevent="submit">
            <div class="grid gap-2">
              <Label for="password">Password</Label>
              <Input
                id="password"
                v-model="password"
                type="password"
                autocomplete="current-password"
                autofocus
              />
              <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password[0] }}</p>
            </div>

            <Button
              type="submit"
              class="w-full"
              :disabled="processing"
              data-test="confirm-password-button"
            >
              <Spinner v-if="processing" class="mr-2" />
              Confirm Password
            </Button>
          </form>
        </CardContent>
      </Card>
    </div>
  </AuthPageLayout>
</template>
