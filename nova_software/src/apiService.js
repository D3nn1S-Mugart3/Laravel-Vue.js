import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/control-user";

export default {
  getAllUsers() {
    return axios.get(API_URL);
  },
  createUser(userData) {
    return axios.post(API_URL, userData);
  },
  getUserById(id) {
    return axios.get(`${API_URL}/${id}`);
  },
  updateUser(id, userData) {
    return axios.put(`${API_URL}/${id}`, userData);
  },
  deleteUser(id) {
    return axios.delete(`${API_URL}/${id}`);
  },
};
