import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import Home from './components/Home';
import Register from './components/Authentication/Register';
import Login from './components/Authentication/Login';
import OAuth from './components/Authentication/OAuth';
import ZoomAuth from './components/Authentication/ZoomAuth';
import Dashboard from './components/Dashboard/Dashboard';
import ForgotPassword from './components/Authentication/ForgotPassword';
import ResetPassword from './components/Authentication/ResetPassword';
import VerifyPassword from './components/Authentication/VerifyPassword';
import Project from './components/Project/Page';
import Activities from './components/Project/Activities';
import Projects from './components/Projects';
import Profile from './components/Profile/ProfilePage';
import Subscription from './components/Subscription';
import AdminPanel from './components/Admin/Dashboard';
import ProjectPanel from './components/Admin/Projects';
import TaskPanel from './components/Admin/Tasks';
import UserPanel from './components/Admin/Users';
import NotFound from './components/Error';

const guest = (to, from, next) => {
  const token = localStorage.getItem("token");
  if (!token) {
   return next();
  }
   return next('/home');
 };

const auth = (to, from, next) => {
  const token = localStorage.getItem("token");
  if (token) {
    return next();
  }
    return next('/login');
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
           path: '/auth/callback/:provider',
           component: OAuth,
           name: "OAuth",
           beforeEnter: guest,
        },
        {
           path: '/oauth/zoom/callback',
           component: ZoomAuth,
           name: "ZoomAuth",
           beforeEnter: auth,
        },
        {
            path: '/home',
            component: Home,
            name: "Home",
            beforeEnter: auth,
        },
        {
            path: '/admin/panel',
            component: AdminPanel,
            name: "AdminPanel",
            beforeEnter: auth,
        },
        {
            path: '/admin/projects',
            component: ProjectPanel,
            name: "ProjectPanel",
            beforeEnter: auth,
        },
        {
            path: '/admin/tasks',
            component: TaskPanel,
            name: "TaskPanel",
            beforeEnter: auth,
        },
        {
            path: '/admin/users',
            component: UserPanel,
            name: "UserPanel",
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
            path: "/projects/:slug",
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
          {
            path: "/subscriptions",
            component: Subscription,
            name: "Subscription",
            beforeEnter: auth,
          },
    ]

 })

router.beforeEach((to, from, next) => {
  if (document.getElementById('zoom-sdk-video-canvas')) {
    const userConfirmed = window.confirm('Are you sure you want to leave this page? Your video session may be interrupted.')
    if (userConfirmed) {
      next()
    } else {
      next(false)
    }
  } else {
    next()
  }
})

 export default router
