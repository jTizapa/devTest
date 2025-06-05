<template>
  <div class="dashboard-container">
    <header class="dashboard-header">
      <h1>Mis Proyectos</h1>
      <button @click="showProjectForm = true" class="add-project-btn">
        + Nuevo Proyecto
      </button>
    </header>

    <div v-if="projectsStore.isLoading" class="loading">
      Cargando proyectos...
    </div>

    <div v-else-if="projectsStore.projects.length === 0" class="empty-state">
      <p>No tienes proyectos aún</p>
      <button @click="showProjectForm = true" class="add-project-btn">
        Crear mi primer proyecto
      </button>
    </div>

    <div v-else class="projects-grid">
      <div
        v-for="project in projectsStore.projects"
        :key="project.id"
        class="project-card"
        @click="goToProject(project.id)"
      >
        <h3>{{ project.name }}</h3>
        <p class="description">{{ project.description || 'Sin descripción' }}</p>
        <div class="project-footer">
          <span :class="`status-badge ${project.status}`">
            {{ project.status }}
          </span>
          <span class="task-count">
            {{ project.tasks_count || 0 }} tareas
          </span>
        </div>
      </div>
    </div>

    <ProjectFormModal
      v-if="showProjectForm"
      @close="showProjectForm = false"
      @created="handleProjectCreated"
    />
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useProjectsStore } from '@/stores/projects';
import { useRouter } from 'vue-router';
import ProjectFormModal from '@/components/projects/ProjectFormModal.vue';

const projectsStore = useProjectsStore();
const router = useRouter();
const showProjectForm = ref(false);

onMounted(async () => {
  await projectsStore.fetchProjects();
});

const goToProject = (projectId) => {
  router.push(`/projects/${projectId}`);
};

const handleProjectCreated = (newProject) => {
  projectsStore.projects.push(newProject);
  showProjectForm.value = false;
};
</script>

<style scoped>
.dashboard-container {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.add-project-btn {
  background-color: #4f46e5;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
}

.projects-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.5rem;
}

.project-card {
  background: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: transform 0.2s;
}

.project-card:hover {
  transform: translateY(-5px);
}

.project-card h3 {
  margin-top: 0;
  color: #333;
}

.description {
  color: #666;
  margin: 0.5rem 0 1rem;
  font-size: 0.9rem;
}

.project-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 1rem;
  font-size: 0.8rem;
}

.status-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 12px;
  font-weight: 500;
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

.task-count {
  color: #666;
}

.empty-state {
  text-align: center;
  padding: 4rem;
  background: white;
  border-radius: 8px;
}

.loading {
  text-align: center;
  padding: 2rem;
  color: #666;
}
</style>
