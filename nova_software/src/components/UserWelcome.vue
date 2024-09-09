<template>
  <div>
    <h2>Lista de Usuarios</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Email</th>
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
          <td>{{ user.login_credentials.email }}</td>
          <td>{{ user.rol }}</td>
          <td>{{ user.estatus }}</td>
          <td>{{ user.fecha_alta }}</td>
          <td>{{ user.fecha_baja }}</td>
          <td>{{ user.fecha_modificacion }}</td>
          <td>
            <button @click="openEditModal(user)">Editar</button>
            <button @click="deleteUser(user.id)">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal de edición -->
    <div v-if="showEditModal">
      <div>
        <h3>Editar Usuario</h3>
        <form @submit.prevent="updateUser">
          <div>
            <label>Nombre:</label>
            <input v-model="editUserForm.nombre" type="text" />
          </div>
          <div>
            <label>Apellidos:</label>
            <input v-model="editUserForm.apellidos" type="text" />
          </div>
          <div>
            <label>Email:</label>
            <input v-model="editUserForm.email" type="email" />
          </div>
          <div>
            <label>Rol:</label>
            <select v-model="editUserForm.rol">
              <option value="admin">Admin</option>
              <option value="user">User</option>
            </select>
          </div>
          <div>
            <label>Estatus:</label>
            <select v-model="editUserForm.estatus">
              <option value="activo">Activo</option>
              <option value="inactivo">Inactivo</option>
            </select>
          </div>
          <button type="submit">Guardar Cambios</button>
          <button @click="closeEditModal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserTable',
  data() {
    return {
      users: [],
      showEditModal: false,
      editUserForm: {
        id: null,
        nombre: '',
        apellidos: '',
        email: '',
        rol: 'user',
        estatus: 'activo',
      },
    };
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/user');
        this.users = response.data;
      } catch (error) {
        console.error("Error al obtener los usuarios:", error);
      }
    },
    openEditModal(user) {
      this.editUserForm = { ...user, email: user.login_credentials.email }; 
      this.showEditModal = true;  //* Muestra el modal
    },
    closeEditModal() {
      this.showEditModal = false;  //* Oculta el modal
    },
    async updateUser() {
      try {
        const { id, nombre, apellidos, email, rol, estatus } = this.editUserForm;
        await axios.put(`http://127.0.0.1:8000/api/user/${id}`, {
          nombre,
          apellidos,
          email,
          rol,
          estatus,
        });
        this.fetchUsers();  
        this.closeEditModal();  // Cierra el modal
      } catch (error) {
        console.error("Error al actualizar el usuario:", error);
        alert('No se pudo actualizar el usuario.');
      }
    },
    async deleteUser(id) {
      if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        try {
          await axios.delete(`http://127.0.0.1:8000/api/user/${id}`);
          this.users = this.users.filter(user => user.id !== id);
          alert('Usuario eliminado exitosamente.');
        } catch (error) {
          console.error("Error al eliminar el usuario:", error);
          alert('No se pudo eliminar el usuario.');
        }
      }
    }
  }
};
</script>
