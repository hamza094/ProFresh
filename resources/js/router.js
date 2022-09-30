import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import Home from './components/Home';
import Register from './components/Authentication/Register';
import Login from './components/Authentication/Login';
import Dashboard from './components/Dashboard/Dashboard';
import ForgotPassword from './components/Authentication/ForgotPassword';
import ResetPassword from './components/Authentication/ResetPassword';
import VerifyPassword from './components/Authentication/VerifyPassword';
import Project from './components/Project/Page';
import Google from './components/Google';
import Activities from './components/Project/Activities';
import Projects from './components/Projects';
import Profile from './components/Profile/ProfilePage';
import NotFound from './components/Error';

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
            path: '/google',
            component: Google,
            name: "Google",
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
            path: "/project/:name/:slug/activities",
            component: Activities,
            name: "Activities",
            props: true, 
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
