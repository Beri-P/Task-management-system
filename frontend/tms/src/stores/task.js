import { defineStore } from 'pinia'
import axios from 'axios'

const API_URL = 'http://localhost:8000/api'

export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: [],
    userTasks: [],
    users: [],
    isLoading: false
  }),

  actions: {
    async fetchTasks() {
      this.isLoading = true
      try {
        const response = await axios.get(`${API_URL}/tasks`)
        this.tasks = response.data
      } catch (error) {
        console.error('Error fetching tasks:', error)
      } finally {
        this.isLoading = false
      }
    },

    async fetchUserTasks() {
      this.isLoading = true
      try {
        const response = await axios.get(`${API_URL}/user/tasks`)
        this.userTasks = response.data
      } catch (error) {
        console.error('Error fetching user tasks:', error)
      } finally {
        this.isLoading = false
      }
    },

    async fetchUsers() {
      try {
        const response = await axios.get(`${API_URL}/users`)
        this.users = response.data
      } catch (error) {
        console.error('Error fetching users:', error)
      }
    },

    async createTask(task) {
      try {
        const response = await axios.post(`${API_URL}/tasks`, task)
        this.tasks.push(response.data)
        return response.data
      } catch (error) {
        throw error.response?.data || error
      }
    },

    async updateTaskStatus(taskId, status) {
      try {
        const response = await axios.patch(`${API_URL}/tasks/${taskId}/status`, { status })
        const index = this.userTasks.findIndex(t => t.id === taskId)
        if (index !== -1) {
          this.userTasks[index] = response.data
        }
        return response.data
      } catch (error) {
        throw error.response?.data || error
      }
    },

    async createUser(user) {
      try {
        const response = await axios.post(`${API_URL}/users`, user)
        this.users.push(response.data)
        return response.data
      } catch (error) {
        throw error.response?.data || error
      }
    },

    async deleteUser(userId) {
      try {
        await axios.delete(`${API_URL}/users/${userId}`)
        this.users = this.users.filter(u => u.id !== userId)
      } catch (error) {
        throw error.response?.data || error
      }
    }
  }
})