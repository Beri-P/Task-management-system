<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Sign in to your account
        </h2>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <div>
          <label for="email" class="sr-only">Email address</label>
          <input 
            id="email" 
            v-model="credentials.email" 
            type="email" 
            required 
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="Email address"
          >
        </div>
        <div>
          <label for="password" class="sr-only">Password</label>
          <input 
            id="password" 
            v-model="credentials.password" 
            type="password" 
            required 
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="Password"
          >
        </div>
        <div v-if="error" class="text-red-600 text-sm">{{ error }}</div>
        <button 
          type="submit" 
          :disabled="isLoading"
          class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
        >
          {{ isLoading ? 'Signing in...' : 'Sign in' }}
        </button>
      </form>
      <div class="text-sm text-gray-600">
        <p>Demo credentials:</p>
        <p>Admin: admin@example.com / password</p>
        <p>User: john@example.com / password</p>
      </div>
    </div>
  </div>
</template>

<script>
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

export default {
  name: 'LoginView',
  setup() {
    const authStore = useAuthStore()
    const router = useRouter()
    
    return {
      authStore,
      router
    }
  },
  data() {
    return {
      credentials: {
        email: '',
        password: ''
      },
      error: null,
      isLoading: false
    }
  },
  methods: {
    async handleLogin() {
      this.error = null
      this.isLoading = true
      
      try {
        await this.authStore.login(this.credentials)
        this.router.push('/dashboard')
      } catch (error) {
        this.error = error.error || 'Login failed'
      } finally {
        this.isLoading = false
      }
    }
  }
}
</script>