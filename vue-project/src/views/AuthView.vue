<template>
  <div class="auth-container">
    <div class="auth-forms">
      <!-- Formulario de Login -->
      <div v-if="activeForm === 'login'" class="form-container">
        <h2>Iniciar Sesión</h2>
        <form @submit.prevent="handleLogin">
          <div class="form-group">
            <label>Email</label>
            <input v-model="loginForm.email" type="email" required>
          </div>
          <div class="form-group">
            <label>Contraseña</label>
            <input v-model="loginForm.password" type="password" required>
          </div>
          <button type="submit" :disabled="authStore.isLoading">
            {{ authStore.isLoading ? 'Cargando...' : 'Iniciar Sesión' }}
          </button>
          <p class="switch-form" @click="activeForm = 'register'">
            ¿No tienes cuenta? Regístrate
          </p>
        </form>
      </div>

      <!-- Formulario de Registro -->
      <div v-else class="form-container">
        <h2>Registro</h2>
        <form @submit.prevent="handleRegister">
          <div class="form-group">
            <label>Nombre</label>
            <input v-model="registerForm.name" type="text" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input v-model="registerForm.email" type="email" required>
          </div>
          <div class="form-group">
            <label>Contraseña</label>
            <input v-model="registerForm.password" type="password" required>
          </div>
          <div class="form-group">
            <label>Confirmar Contraseña</label>
            <input v-model="registerForm.password_confirmation" type="password" required>
          </div>
          <button type="submit" :disabled="authStore.isLoading">
            {{ authStore.isLoading ? 'Cargando...' : 'Registrarse' }}
          </button>
          <p class="switch-form" @click="activeForm = 'login'">
            ¿Ya tienes cuenta? Inicia Sesión
          </p>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();

const activeForm = ref('login');

const loginForm = ref({
  email: '',
  password: ''
});

const registerForm = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const handleLogin = async () => {
  const success = await authStore.login(loginForm.value);
  if (success) {
    router.push('/dashboard');
  }
};

const handleRegister = async () => {
  if (registerForm.value.password !== registerForm.value.password_confirmation) {
    alert('Las contraseñas no coinciden');
    return;
  }

  const success = await authStore.register(registerForm.value);
  if (success) {
    router.push('/dashboard');
  }
};
</script>

<style scoped>
.auth-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f5f5f5;
}

.auth-forms {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

.form-container {
  width: 100%;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.form-group input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

button {
  width: 100%;
  padding: 0.75rem;
  background-color: #4f46e5;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 1rem;
}

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.switch-form {
  margin-top: 1rem;
  text-align: center;
  color: #4f46e5;
  cursor: pointer;
  text-decoration: underline;
}

h2 {
  text-align: center;
  margin-bottom: 1.5rem;
  color: #333;
}
</style>
