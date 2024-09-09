<template>
  <div>
    <nav>
      <router-link to="/register">Registro</router-link>
      <router-link to="/login">Iniciar Sesión</router-link>
    </nav>
    <!-- <h1>Hello World</h1> -->
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>