<template>
  <div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold">Task Management</h1>
          </div>
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700">{{ authStore.user?.name }}</span>
            <button 
              v-if="authStore.isAdmin" 
              @click="router.push('/admin')"
              class="px-3 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
              Admin Panel
            </button>
            <button 
              @click="handleLogout"
              class="px-3 py-2 text-sm bg-red-600 text-white rounded-md hover:bg-red-700"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <h2 class="text-2xl font-bold mb-4">My Tasks</h2>
        
        <div v-if="taskStore.isLoading" class="text-center py-8">
          Loading tasks...
        </div>

        <div v-else-if="taskStore.userTasks.length === 0" class="text-center py-8 text-gray-500">
          No tasks assigned yet.
        </div>

        <div v-else class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
          <TaskCard 
            v-for="task in taskStore.userTasks" 
            :key="task.id" 
            :task="task"
            @update-status="updateTaskStatus"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useAuthStore } from '../stores/auth'
import { useTaskStore } from '../stores/task'
import { useRouter } from 'vue-router'
import TaskCard from '../components/TaskCard.vue'

export default {
  name: 'DashboardView',
  components: {
    TaskCard
  },
  setup() {
    const authStore = useAuthStore()
    const taskStore = useTaskStore()
    const router = useRouter()
    
    return {
      authStore,
      taskStore,
      router
    }
  },
  async mounted() {
    await this.taskStore.fetchUserTasks()
  },
  methods: {
    async handleLogout() {
      await this.authStore.logout()
      this.router.push('/login')
    },
    async updateTaskStatus(taskId, status) {
      try {
        await this.taskStore.updateTaskStatus(taskId, status)
      } catch (error) {
        console.error('Error updating task status:', error)
      }
    }
  }
}
</script>