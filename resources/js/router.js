import Vue from 'vue';
import Router from 'vue-router';
// Use the central Vuex store, not a direct module import (avoids case issues & keeps single source of truth)
import store from './store';

Vue.use(Router);

import Home from './components/Home.vue';
import Register from './components/Authentication/Register.vue';
import Login from './components/Authentication/Login.vue';
import TwoFACode from './components/Authentication/TwoFACode.vue';
import OAuth from './components/Authentication/OAuth.vue';
import ZoomAuth from './components/Authentication/ZoomAuth.vue';
import Dashboard from './components/Dashboard/ProjectDashboard.vue';
import ForgotPassword from './components/Authentication/ForgotPassword.vue';
import ResetPassword from './components/Authentication/ResetPassword.vue';
import VerifyPassword from './components/Authentication/VerifyPassword.vue';
import ProjectPage from './components/Project/ProjectPage.vue';
import Activities from './components/Project/Activities.vue';
import Projects from './components/Projects.vue';
import Profile from './components/Profile/ProfilePage.vue';
import Subscription from './components/Subscription.vue';
import AdminPanel from './components/Admin/Dashboard.vue';
import ProjectPanel from './components/Admin/Projects.vue';
import TaskPanel from './components/Admin/Tasks.vue';
import UserPanel from './components/Admin/Users.vue';
import NotFound from './components/Error.vue';
import UserNotification from './components/UserNotification.vue';

const FIVE_MINUTES = 5 * 60 * 1000;
const TWO_FA_PENDING_KEY = 'twofa_pending';
const TWO_FA_TIMESTAMP_KEY = 'twofa_timestamp';

const attachMeta = (meta, routes) =>
  routes.map((route) => ({
    ...route,
    meta: {
      ...(route.meta || {}),
      ...meta,
    },
  }));

const matchesMeta = (to, key) => to.matched.some((record) => record.meta?.[key]);

// Helper to validate pending 2FA state in localStorage
const isTwoFAPendingValid = () => {
  const twofaPending = localStorage.getItem(TWO_FA_PENDING_KEY);
  const twofaTimestamp = Number(localStorage.getItem(TWO_FA_TIMESTAMP_KEY));
  if (twofaPending !== 'true') return false;
  if (!twofaTimestamp) return true;

  const now = Date.now();
  if (Number.isNaN(twofaTimestamp) || now - twofaTimestamp > FIVE_MINUTES) {
    localStorage.removeItem(TWO_FA_PENDING_KEY);
    localStorage.removeItem(TWO_FA_TIMESTAMP_KEY);
    return false;
  }

  return true;
};

const guestRoutes = attachMeta({ guestOnly: true }, [
  {
    path: '/auth/callback/:provider',
    component: OAuth,
    name: 'OAuth',
  },
  {
    path: '/register',
    component: Register,
    name: 'Register',
  },
  {
    path: '/login',
    component: Login,
    name: 'Login',
  },
  {
    path: '/forgot-password',
    component: ForgotPassword,
    name: 'Forgot',
  },
  {
    path: '/api/v1/password/reset/:token',
    component: ResetPassword,
    name: 'Reset',
  },
]);

const authRoutes = attachMeta({ requiresAuth: true }, [
  {
    path: '/oauth/zoom/callback',
    component: ZoomAuth,
    name: 'ZoomAuth',
  },
  {
    path: '/home',
    component: Home,
    name: 'Home',
  },
  {
    path: '/admin/panel',
    component: AdminPanel,
    name: 'AdminPanel',
  },
  {
    path: '/admin/projects',
    component: ProjectPanel,
    name: 'ProjectPanel',
  },
  {
    path: '/admin/tasks',
    component: TaskPanel,
    name: 'TaskPanel',
  },
  {
    path: '/admin/users',
    component: UserPanel,
    name: 'UserPanel',
  },
  {
    path: '/dashboard',
    component: Dashboard,
    name: 'Dashboard',
  },
  {
    path: '/projects/:slug',
    component: ProjectPage,
    name: 'ProjectPage',
  },
  {
    path: '/project/:name/:slug/activities',
    component: Activities,
    name: 'Activities',
    props: true,
  },
  {
    path: '/projects',
    component: Projects,
    name: 'Projects',
  },
  {
    path: '/user/:uuid/profile',
    component: Profile,
    name: 'Profile',
  },
  {
    path: '/subscriptions',
    component: Subscription,
    name: 'Subscription',
  },
  {
    path: '/user-notifications',
    component: UserNotification,
    name: 'UserNotification',
  },
]);

const baseRoutes = [
  {
    path: '*',
    component: NotFound,
  },
  ...guestRoutes,
  ...authRoutes,
  {
    path: '/2fa/code',
    component: TwoFACode,
    name: 'TwoFACode',
    meta: { twofa: true },
  },
  {
    path: '/api/v1/email/verify/:user',
    component: VerifyPassword,
    name: 'verification.verify',
  },
];

const router = new Router({
  mode: 'history',
  linkActiveClass: 'font-semibold',
  routes: baseRoutes,
});

router.beforeEach((to, from, next) => {
  // Preserve existing Zoom SDK leave confirmation (non-auth concern)
  if (document.getElementById('zoom-sdk-video-canvas')) {
    const userConfirmed = globalThis.confirm(
      'Are you sure you want to leave this page? Your video session may be interrupted.',
    );
    if (!userConfirmed) return next(false);
  }

  const isLoggedIn = store.state.currentUser.loggedIn;
  const requiresAuth = matchesMeta(to, 'requiresAuth');
  const guestOnly = matchesMeta(to, 'guestOnly');
  const twofa = matchesMeta(to, 'twofa');

  // 2FA flow: allow only if pending & not yet fully logged in
  if (twofa) {
    if (isTwoFAPendingValid()) return next();
    return next(isLoggedIn ? '/home' : '/login');
  }

  if (requiresAuth && !isLoggedIn) {
    return next('/login');
  }

  if (guestOnly && isLoggedIn) {
    return next('/home');
  }

  return next();
});

export default router;
