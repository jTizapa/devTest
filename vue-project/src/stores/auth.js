import { defineStore } from 'pinia';
import api from '../composables/useAuth';
import { ref } from 'vue';

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null);
  const isAuthenticated = ref(false);

  const login = async (credentials) => {
    try {
      const { data } = await api.post('/login', credentials);
      localStorage.setItem('auth_token', data.access_token);
      isAuthenticated.value = true;
      await fetchUser();
      return true;
    } catch (error) {
      console.error('Login error:', error);
      return false;
    }
  };

  const register = async (userData) => {
    try {
      const { data } = await api.post('/register', userData);
      localStorage.setItem('auth_token', data.access_token);
      isAuthenticated.value = true;
      await fetchUser();
      return true;
    } catch (error) {
      console.error('Register error:', error);
      return false;
    }
  };

  const logout = async () => {
    try {
      await api.post('/logout');
      localStorage.removeItem('auth_token');
      user.value = null;
      isAuthenticated.value = false;
    } catch (error) {
      console.error('Logout error:', error);
    }
  };

  const fetchUser = async () => {
    try {
      const { data } = await api.get('/user');
      user.value = data;
      isAuthenticated.value = true;
    } catch (error) {
      console.error('Fetch user error:', error);
      isAuthenticated.value = false;
    }
  };

  return { user, isAuthenticated, login, register, logout, fetchUser };
});
