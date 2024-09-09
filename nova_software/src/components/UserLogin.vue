<template>
  <div>
    <h2>Iniciar Sesión</h2>
    <form @submit.prevent="login">
      <label for="email">Correo electrónico:</label>
      <input type="email" v-model="email" required />

      <label for="password">Contraseña:</label>
      <input type="password" v-model="password" required />

      <button type="submit">Iniciar Sesión</button>
    </form>
    <p v-if="error">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserLogin',
  data() {
    return {
      email: '',
      password: '',
      error: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', {
          email: this.email,
          password: this.password
        });

        //* Verifica si el login fue exitoso
        if (response.data.success) {
          this.$router.push('/welcome'); 
        } else {
          this.error = 'Correo o contraseña incorrectos';
        }
      } catch (error) {
        this.error = 'Error al iniciar sesión';
        console.error(error.response.data);
      }
    }
  }
};
</script>
