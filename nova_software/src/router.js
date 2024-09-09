import { createRouter, createWebHistory } from "vue-router";
import UserRegister from "./components/UserRegister.vue";
import UserLogin from "./components/UserLogin.vue";
import UserWelcome from "./components/UserWelcome.vue";

const routes = [
  {
    path: "/register",
    name: "UserRegister",
    component: UserRegister,
  },
  {
    path: "/login",
    name: "UserLogin",
    component: UserLogin,
  },
  {
    path: "/welcome",
    name: "UserWelcome",
    component: UserWelcome,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
