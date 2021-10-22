import Home from './components/Home';
import Register from './components/Authentication/Register';
import Login from './components/Authentication/Login';
import Dashboard from './components/Dashboard/Dashboard';
import Projects from './components/Projects';
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

export default{
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
            path: "/dashboard",
            component: Dashboard,
            name: "Dashboard",
            beforeEnter: auth,
          },
          {
            path: "/projects",
            component: Projects,
            name: "Projects",
            beforeEnter: auth,
          },

    ]

 }   