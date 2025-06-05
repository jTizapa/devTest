<template>
  <form @submit.prevent="handleLogin">
    <div>
      <label>Email</label>
      <input v-model="form.email" type="email" required>
    </div>
    <div>
      <label>Password</label>
      <input v-model="form.password" type="password" required>
    </div>
    <button type="submit">Login</button>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();
const form = ref({
  email: '',
  password: ''
});

const handleLogin = async () => {
  const success = await authStore.login(form.value);
  if (success) {
    router.push('/dashboard');
  }
};
</script>
