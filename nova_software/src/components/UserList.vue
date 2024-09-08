<template>
  <div>
    <h1>Lista de Usuarios</h1>

    <!-- Formulario para agregar un nuevo usuario -->
    <div>
      <h2>Añadir Nuevo Usuario</h2>
      <form @submit.prevent="addUser">
        <div>
          <label for="nombre">Nombre:</label>
          <input v-model="newUser.nombre" type="text" id="nombre" required>
        </div>
        <div>
          <label for="apellidos">Apellidos:</label>
          <input v-model="newUser.apellidos" type="text" id="apellidos" required>
        </div>
        <div>
          <label for="rol">Rol:</label>
          <input v-model="newUser.rol" type="text" id="rol" required>
        </div>
        <div>
          <label for="estatus">Estatus:</label>
          <input v-model="newUser.estatus" type="text" id="estatus" required>
        </div>
        <div>
          <label for="fecha_alta">Fecha Alta:</label>
          <input v-model="newUser.fecha_alta" type="date" id="fecha_alta" required>
        </div>
        <div>
          <label for="fecha_baja">Fecha Baja:</label>
          <input v-model="newUser.fecha_baja" type="date" id="fecha_baja">
        </div>
        <div>
          <label for="fecha_modificacion">Fecha Modificación:</label>
          <input v-model="newUser.fecha_modificacion" type="date" id="fecha_modificacion">
        </div>
        <button type="submit">Añadir Usuario</button>
      </form>
    </div>

    <!-- Tabla de usuarios -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Rol</th>
          <th>Estatus</th>
          <th>Fecha Alta</th>
          <th>Fecha Baja</th>
          <th>Fecha Modificación</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.nombre }}</td>
          <td>{{ user.apellidos }}</td>
          <td>{{ user.rol }}</td>
          <td>{{ user.estatus }}</td>
          <td>{{ user.fecha_alta }}</td>
          <td>{{ user.fecha_baja }}</td>
          <td>{{ user.fecha_modificacion }}</td>
          <td>
            <!-- Botones de Acción -->
            <button @click="editUser(user)">Editar</button>
            <button @click="deleteUser(user.id)">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import apiService from '../apiService.js';

export default {
  data() {
    return {
      users: [],
      newUser: {
        nombre: '',
        apellidos: '',
        rol: '',
        estatus: '',
        fecha_alta: '',
        fecha_baja: '',
        fecha_modificacion: ''
      },
      isEditing: false,
      editUserId: null
    };
  },
  methods: {
    loadUsers() {
      apiService.getAllUsers()
        .then(response => {
          this.users = response.data;
        })
        .catch(error => {
          console.error('Error al cargar los usuarios:', error);
        });
    },
    addUser() {
      if (this.isEditing) {
        // Cuando está en modo de edición, actualiza el usuario
        apiService.updateUser(this.editUserId, this.newUser)
          .then(() => {
            alert('Usuario actualizado con éxito');
            this.loadUsers(); 
            this.resetForm(); 
          })
          .catch(error => {
            console.error('Error al actualizar el usuario:', error);
          });
      } else {
        // Cuando no esta en modo edición crea un nuevo usuario
        apiService.createUser(this.newUser)
          .then(() => {
            alert('Usuario añadido con éxito');
            this.loadUsers();
            this.resetForm();
          })
          .catch(error => {
            console.error('Error al añadir el usuario:', error);
          });
      }
    },
    deleteUser(id) {
      if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        apiService.deleteUser(id)
          .then(() => {
            alert('Usuario eliminado con éxito');
            this.loadUsers();
          })
          .catch(error => {
            console.error('Error al eliminar el usuario:', error);
          });
      }
    },
    editUser(user) {
      this.isEditing = true;
      this.editUserId = user.id;
      this.newUser = { ...user };
    },
    resetForm() {
      this.newUser = {
        nombre: '',
        apellidos: '',
        rol: '',
        estatus: '',
        fecha_alta: '',
        fecha_baja: '',
        fecha_modificacion: ''
      };
      this.isEditing = false;
      this.editUserId = null;
    }
  },
  mounted() {
    this.loadUsers();
  }
};
</script>

<style>
table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  border: 1px solid black;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

form {
  margin-bottom: 20px;
}

form div {
  margin-bottom: 10px;
}

form label {
  display: inline-block;
  width: 150px;
}

button {
  margin-right: 10px;
}
</style>
