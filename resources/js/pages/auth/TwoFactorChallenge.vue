<script setup lang="ts">
import axios from 'axios'
import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Spinner } from '@/components/ui/spinner'
import AuthPageLayout from '@/layouts/AuthPageLayout.vue'

const router = useRouter()

const showRecoveryInput = ref(false)
const code = ref('')
const recoveryCode = ref('')
const errors = ref<Record<string, string[]>>({})
const processing = ref(false)

const authConfigContent = computed(() => {
  if (showRecoveryInput.value) {
    return {
      title: 'Recovery Code',
      description: 'Please confirm access to your account by entering one of your emergency recovery codes.',
      buttonText: 'login using an authentication code',
    }
  }
  return {
    title: 'Authentication Code',
    description: 'Enter the authentication code provided by your authenticator application.',
    buttonText: 'login using a recovery code',
  }
})

function toggleRecoveryMode() {
  showRecoveryInput.value = !showRecoveryInput.value
  errors.value = {}
  code.value = ''
  recoveryCode.value = ''
}

async function submit() {
  errors.value = {}
  processing.value = true

  const payload = showRecoveryInput.value
    ? { recovery_code: recoveryCode.value }
    : { code: code.value }

  try {
    await axios.get('/sanctum/csrf-cookie')
    await axios.post(
      '/two-factor-challenge',
      payload,
      { headers: { Accept: 'application/json' } },
    )
    router.push('/dashboard')
  } catch (err: any) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors ?? {}
    } else {
      const key = showRecoveryInput.value ? 'recovery_code' : 'code'
      errors.value = { [key]: ['Authentication failed. Please try again.'] }
    }
    code.value = ''
  } finally {
    processing.value = false
  }
}
</script>

<template>
  <AuthPageLayout>
    <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[380px]">
      <div class="flex flex-col space-y-2 text-center">
        <h1 class="text-2xl font-semibold tracking-tight">{{ authConfigContent.title }}</h1>
        <p class="text-sm text-muted-foreground">{{ authConfigContent.description }}</p>
      </div>

      <Card>
        <CardContent class="pt-6">
          <form class="space-y-4" @submit.prevent="submit">
            <template v-if="!showRecoveryInput">
              <div class="grid gap-2">
                <Label for="code">Authentication code</Label>
                <Input
                  id="code"
                  v-model="code"
                  type="text"
                  inputmode="numeric"
                  maxlength="6"
                  placeholder="000000"
                  autocomplete="one-time-code"
                  autofocus
                />
                <p v-if="errors.code" class="text-sm text-destructive">{{ errors.code[0] }}</p>
              </div>
            </template>

            <template v-else>
              <div class="grid gap-2">
                <Label for="recovery_code">Recovery code</Label>
                <Input
                  id="recovery_code"
                  v-model="recoveryCode"
                  type="text"
                  placeholder="Enter recovery code"
                  autofocus
                />
                <p v-if="errors.recovery_code" class="text-sm text-destructive">{{ errors.recovery_code[0] }}</p>
              </div>
            </template>

            <Button type="submit" class="w-full" :disabled="processing">
              <Spinner v-if="processing" class="mr-2" />
              Continue
            </Button>

            <div class="text-center text-sm text-muted-foreground">
              <span>or you can </span>
              <button
                type="button"
                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                @click="toggleRecoveryMode"
              >
                {{ authConfigContent.buttonText }}
              </button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  </AuthPageLayout>
</template>
