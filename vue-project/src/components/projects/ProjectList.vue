<template>
  <div>
    <h2>My Projects</h2>
    <div v-if="isLoading">Loading projects...</div>
    <ul v-else>
      <li v-for="project in projects" :key="project.id">
        <router-link :to="`/projects/${project.id}`">{{ project.name }}</router-link>
        <span :class="`status-${project.status}`">{{ project.status }}</span>
      </li>
    </ul>
    <button @click="showForm = true">Add New Project</button>

    <ProjectForm
      v-if="showForm"
      @submit="handleCreateProject"
      @cancel="showForm = false"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useProjectsStore } from '@/stores/projects';
import ProjectForm from './ProjectForm.vue';

const projectsStore = useProjectsStore();
const showForm = ref(false);

const { projects, isLoading } = storeToRefs(projectsStore);

onMounted(async () => {
  await projectsStore.fetchProjects();
});

const handleCreateProject = async (projectData) => {
  try {
    await projectsStore.createProject(projectData);
    showForm.value = false;
  } catch (error) {
    console.error('Error creating project:', error);
  }
};
</script>

<style scoped>
.status-active { color: green; }
.status-pending { color: orange; }
.status-completed { color: blue; }
</style>
