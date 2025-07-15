<template>
  <div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-start mb-4">
      <h3 class="text-lg font-semibold">{{ task.title }}</h3>
      <select 
        :value="task.status" 
        @change="$emit('update-status', task.id, $event.target.value)"
        class="text-sm border rounded px-2 py-1"
      >
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
      </select>
    </div>
    
    <p class="text-gray-600 mb-4">{{ task.description }}</p>
    
    <div class="flex justify-between items-center text-sm">
      <span 
        :class="statusClass"
        class="px-2 py-1 rounded-full"
      >
        {{ formatStatus(task.status) }}
      </span>
      <span class="text-gray-500">
        Due: {{ formatDate(task.deadline) }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TaskCard',
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  emits: ['update-status'],
  computed: {
    statusClass() {
      const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        in_progress: 'bg-blue-100 text-blue-800',
        completed: 'bg-green-100 text-green-800'
      }
      return classes[this.task.status] || 'bg-gray-100 text-gray-800'
    }
  },
  methods: {
    formatStatus(status) {
      return status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString()
    }
  }
}
</script>