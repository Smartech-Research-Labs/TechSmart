<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import AuthPageLayout from '@/layouts/AuthPageLayout.vue'
import { Button } from '@/components/ui/button'
import { Spinner } from '@/components/ui/spinner'
import { Card, CardContent } from '@/components/ui/card'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const status = ref('')
const processing = ref(false)

async function resend() {
  status.value = ''
  processing.value = true

  try {
    await axios.get('/sanctum/csrf-cookie')
    const response = await axios.post(
      '/email/verification-notification',
      {},
      { headers: { Accept: 'application/json' } },
    )
    status.value = response.data.status ?? 'A new verification link has been sent to your email address.'
  } catch {
    status.value = 'Something went wrong. Please try again.'
  } finally {
    processing.value = false
  }
}

async function handleLogout() {
  await authStore.logout()
  router.push('/login')
}
</script>

<template>
  <AuthPageLayout>
    <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[400px]">
      <div class="flex flex-col space-y-2 text-center">
        <h1 class="text-2xl font-semibold tracking-tight">Verify email</h1>
        <p class="text-sm text-muted-foreground">Please verify your email by clicking the link we sent.</p>
      </div>

      <Card>
        <CardContent class="pt-6 space-y-6 text-center">
          <div
            v-if="status"
            class="text-sm font-medium text-green-600"
          >
            {{ status }}
          </div>

          <Button
            :disabled="processing"
            variant="secondary"
            @click="resend"
          >
            <Spinner v-if="processing" class="mr-2" />
            Resend verification email
          </Button>

          <button
            type="button"
            class="mx-auto block text-sm underline underline-offset-4 hover:text-primary text-muted-foreground"
            @click="handleLogout"
          >
            Log out
          </button>
        </CardContent>
      </Card>
    </div>
  </AuthPageLayout>
</template>
