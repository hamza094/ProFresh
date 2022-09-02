import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import Home from './components/Home.vue';
import Register from './components/Authentication/Register.vue';
import Login from './components/Authentication/Login.vue';
import Dashboard from './components/Dashboard/Dashboard.vue';
import ForgotPassword from './components/Authentication/ForgotPassword.vue';
import ResetPassword from './components/Authentication/ResetPassword.vue';
import VerifyPassword from './components/Authentication/VerifyPassword.vue';
import Project from './components/Project/Page.vue';
import Projects from './components/Projects.vue';
import Profile from './components/Profile/ProfilePage.vue';
import NotFound from './components/Error.vue';

const guest = (to, from, next) => {
  if (!JSON.parse(localStorage.getItem("token"))) {
    return next()
  } else {
    return next('/home')
  }
}
const auth = (to, from, next) => {
  // Solve a bug where user isn't yet loaded but the app runs
  if (JSON.parse(localStorage.getItem("token"))) {
    return next()
  } else {
    return next('/login')
  }
}

let router = new Router({
    mode: 'history',
    linkActiveClass: 'font-semibold',
    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/home',
            component: Home,
            name: "Home",
            beforeEnter: auth,
        },
        {
            path: '/register',
            component: Register,
            name: 'Register',
            beforeEnter: guest,
        },
        {
            path: '/login',
            component: Login,
            name: 'Login',
            beforeEnter: guest,
        },
        {
            path: '/forgot-password',
            component: ForgotPassword,
            name: 'Forgot',
            beforeEnter: guest,
        },
        {
            path: '/api/v1/password/reset/:token',
            component: ResetPassword,
            name: 'Reset',
            beforeEnter: guest,
        },
        {
            path:'/api/v1/email/verify/:id',
            component: VerifyPassword,
            name: "verification.verify",
        },
        {
            path: "/dashboard",
            component: Dashboard,
            name: "Dashboard",
            beforeEnter: auth,
          },
          {
            path: "/project/:slug",
            component: Project,
            name: "Project",
            beforeEnter: auth,
          },
          {
            path: "/projects",
            component: Projects,
            name: "Projects",
            beforeEnter: auth,
          },
          {
            path: "/user/:id/profile",
            component: Profile,
            name: "Profile",
            beforeEnter: auth,
          },
    ]

 })

 export default router
