<template>
  <div>
    <h2>Registro</h2>
    <form @submit.prevent="register">
      <label for="nombre">Nombre:</label>
      <input type="text" v-model="nombre" required />

      <label for="apellidos">Apellidos:</label>
      <input type="text" v-model="apellidos" required />

      <label for="email">Correo electrónico:</label>
      <input type="email" v-model="email" required />

      <label for="password">Contraseña:</label>
      <input type="password" v-model="password" required />

      <button type="submit">Registrar</button>
    </form>
    <p v-if="error">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserRegister',
  data() {
    return {
      nombre: '',
      apellidos: '',
      email: '',
      password: '',
      error: ''
    };
  },
  methods: {
    async register() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/user', {
          nombre: this.nombre,
          apellidos: this.apellidos,
          rol: 'user',
          email: this.email,
          password: this.password
        });
        console.log(response.data);
        this.$router.push('/login');
      } catch (error) {
        this.error = 'Error al registrar el usuario';
        console.error(error.response.data);
      }
    }
  }
};
</script>
