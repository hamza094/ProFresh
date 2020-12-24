/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Vue from 'vue';

import VueSlideoutPanel from 'vue2-slideout-panel';

Vue.use(VueSlideoutPanel);

import VModal from 'vue-js-modal'
Vue.use(VModal)

import moment from 'moment';

Vue.filter('timeExactDate',function(data){
   return  moment(data).fromNow();
})

Vue.filter('timeDate',function(data){
   return  moment(data).format("MMM Do YY");
})

window.momenttz = require('moment-timezone');
window.moment = require('moment');

import 'animate.css';

import "cropperjs/dist/cropper.css"

import swal from 'sweetalert2';

window.swal=swal;

import VueToastify from "vue-toastify";
Vue.use(VueToastify, {
    position:"bottom-left",
    theme:"light",
    successDuration:2050,
    warningInfoDuration:2050,
    errorDuration:2050,
    canPause:false
});

import { Datetime } from 'vue-datetime';
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css';

Vue.use(Datetime)

Vue.component('datetime', Datetime);

import { Settings } from 'luxon'
//set to display dates for English language
Settings.defaultLocale = 'en'


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('dynamic-nav', require('./components/DynamicNav.vue').default);
Vue.component('project-button', require('./components/ProjectButton.vue').default);
Vue.component('project-form', require('./components/ProjectForm.vue').default);
Vue.component('single-project', require('./components/SingleProject.vue').default);
Vue.component('file', require('./components/File.vue').default);
Vue.component('project-edit', require('./components/ProjectEdit.vue').default);
Vue.component('project-stage', require('./components/Stage.vue').default);
Vue.component('project-panel', require('./components/ProjectPanel.vue').default);
const routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue').default },
  { path: '/projects', component: require('./components/Project.vue').default },
  { path: '/contacts', component: require('./components/Contact.vue').default },
  { path: '/accounts', component: require('./components/Account.vue').default },
  { path: '/deals', component: require('./components/Deal.vue').default },
  { path: '*', component:require('./components/Error.vue').default}
]

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
    mode: 'history',
  routes // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
     router
});
