<template>
  <div class="project-detail-container">
    <div v-if="projectsStore.isLoading" class="loading">
      Cargando proyecto...
    </div>

    <div v-else class="project-content">
      <div class="project-header">
        <h1>{{ projectsStore.currentProject?.name }}</h1>
        <div class="project-actions">
          <button @click="showTaskForm = true" class="add-task-btn">
            + Nueva Tarea
          </button>
          <button @click="showEditForm = true" class="edit-btn">
            Editar Proyecto
          </button>
        </div>
      </div>

      <p class="project-description">
        {{ projectsStore.currentProject?.description || 'Sin descripción' }}
      </p>

      <div class="project-status">
        <span :class="`status-badge ${projectsStore.currentProject?.status}`">
          {{ projectsStore.currentProject?.status }}
        </span>
      </div>

      <div class="tasks-section">
        <h2>Tareas</h2>

        <div v-if="tasksStore.isLoading" class="loading">
          Cargando tareas...
        </div>

        <div v-else-if="tasksStore.tasks.length === 0" class="empty-tasks">
          <p>No hay tareas en este proyecto</p>
          <button @click="showTaskForm = true" class="add-task-btn">
            Crear primera tarea
          </button>
        </div>

        <div v-else class="tasks-list">
          <TaskItem
            v-for="task in tasksStore.tasks"
            :key="task.id"
            :task="task"
            @update="handleTaskUpdate"
            @delete="handleTaskDelete"
          />
        </div>
      </div>
    </div>

    <TaskFormModal
      v-if="showTaskForm"
      :project-id="route.params.id"
      @close="showTaskForm = false"
      @created="handleTaskCreated"
    />

    <ProjectFormModal
      v-if="showEditForm"
      :project="projectsStore.currentProject"
      mode="edit"
      @close="showEditForm = false"
      @updated="handleProjectUpdated"
    />
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useProjectsStore } from '@/stores/projects';
import { useTasksStore } from '@/stores/tasks';
import TaskItem from '@/components/tasks/TaskItem.vue';
import TaskFormModal from '@/components/tasks/TaskFormModal.vue';
import ProjectFormModal from '@/components/projects/ProjectFormModal.vue';

const route = useRoute();
const router = useRouter();
const projectsStore = useProjectsStore();
const tasksStore = useTasksStore();

const showTaskForm = ref(false);
const showEditForm = ref(false);

onMounted(() => {
  loadProjectAndTasks();
});

watch(() => route.params.id, () => {
  loadProjectAndTasks();
});

const loadProjectAndTasks = async () => {
  await projectsStore.fetchProjectById(route.params.id);
  await tasksStore.fetchTasksByProject(route.params.id);
};

const handleTaskCreated = (newTask) => {
  tasksStore.tasks.push(newTask);
  showTaskForm.value = false;
};

const handleTaskUpdate = async ({ id, status }) => {
  await tasksStore.updateTaskStatus(id, status);
};

const handleTaskDelete = (taskId) => {
  tasksStore.tasks = tasksStore.tasks.filter(task => task.id !== taskId);
};

const handleProjectUpdated = (updatedProject) => {
  projectsStore.currentProject = updatedProject;
  showEditForm.value = false;
};
</script>

<style scoped>
.project-detail-container {
  padding: 2rem;
  max-width: 800px;
  margin: 0 auto;
}

.project-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.project-actions {
  display: flex;
  gap: 1rem;
}

.add-task-btn, .edit-btn {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.add-task-btn {
  background-color: #4f46e5;
  color: white;
}

.edit-btn {
  background-color: #e5e7eb;
  color: #333;
}

.project-description {
  color: #666;
  margin-bottom: 1.5rem;
}

.project-status {
  margin-bottom: 2rem;
}

.status-badge {
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-weight: 500;
  text-transform: capitalize;
}

.status-badge.pending {
  background-color: #fef3c7;
  color: #92400e;
}

.status-badge.in_progress {
  background-color: #dbeafe;
  color: #1e40af;
}

.status-badge.completed {
  background-color: #dcfce7;
  color: #166534;
}

.tasks-section {
  margin
