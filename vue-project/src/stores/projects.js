import { defineStore } from 'pinia';
import api from '@/composables/useApi';
import { ref } from 'vue';

export const useProjectsStore = defineStore('projects', () => {
  const projects = ref([]);
  const currentProject = ref(null);
  const isLoading = ref(false);

  const fetchProjects = async () => {
    isLoading.value = true;
    try {
      const { data } = await api.get('/projects');
      projects.value = data;
    } catch (error) {
      console.error('Error fetching projects:', error);
    } finally {
      isLoading.value = false;
    }
  };

  const createProject = async (projectData) => {
    try {
      const { data } = await api.post('/projects', projectData);
      projects.value.push(data);
      return data;
    } catch (error) {
      console.error('Error creating project:', error);
      throw error;
    }
  };

  const fetchProjectById = async (id) => {
    isLoading.value = true;
    try {
      const { data } = await api.get(`/projects/${id}`);
      currentProject.value = data;
      return data;
    } catch (error) {
      console.error('Error fetching project:', error);
      throw error;
    } finally {
      isLoading.value = false;
    }
  };

  return { projects, currentProject, isLoading, fetchProjects, createProject, fetchProjectById };
});
