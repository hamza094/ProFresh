/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import'./bootstrap';
import '../sass/app.scss';

import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';
import VueBus from 'vue-bus';
import VTooltip from 'v-tooltip';
import VueSlideoutPanel from 'vue2-slideout-panel';
import VModal from 'vue-js-modal';
import moment from 'moment';
import momenttz from 'moment-timezone';
import "emoji-mart-vue-fast/css/emoji-mart.css";
import alertNotice from './mixins/alertNotice';
import errorHandling from './mixins/errorHandling';
import currentStage from './mixins/currentStage';
import popup from './mixins/popup';
import conversation from './mixins/conversation';
import Chart from 'chart.js';
import 'animate.css';
import "cropperjs/dist/cropper.css"
import VueToastify from "vue-toastify";
import { Datetime } from 'vue-datetime';
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css';
import VCalendar from 'v-calendar';
import PortalVue from 'portal-vue';

Vue.use(PortalVue);
Vue.use(Vuex);
Vue.use(VueBus);
Vue.use(VTooltip);
Vue.use(VueSlideoutPanel);
Vue.use(VModal);
Vue.use(Datetime)

Vue.component('datetime', Datetime);
import VueUploadComponent from 'vue-upload-component'
Vue.component('file-upload', VueUploadComponent)

import { VueSpinners } from '@saeris/vue-spinners'

Vue.use(VueSpinners)

window.momenttz = momenttz;
window.moment = moment;

import router from './router.js'
import store from "./store";

Vue.mixin(alertNotice);
Vue.mixin(currentStage);
Vue.mixin(conversation);
Vue.mixin(errorHandling);

Vue.filter('time',function(data){
   return  moment(data).format('h:mm:ss a');
})

Vue.filter('date',function(data){
   return  moment(data).format("MMM Do YY");
})

Vue.filter('shortDate', function (value) { 
  return moment(value, 'MMMM Do YYYY, h:mm:ss a').format('MMM Do YY');
});

Vue.filter('reciept_date',function(data){
   return  moment(data).format("MMM Do YYYY");
})

Vue.filter('datetime',function(data){
   return  moment(data).format("MMM Do YY h:mm:ss a");
})

Vue.filter('msgTime',function(data){
   return  moment(data).calendar();
})

Vue.use(VCalendar, {
  componentPrefix: 'vc',               
});

import { Settings } from 'luxon'
Settings.defaultLocale = 'en'

Vue.use(VueToastify, {
    position:"bottom-left",
    theme:"light",
    successDuration:2050,
    warningInfoDuration:2050,
    errorDuration:2050,
    canPause:false
});

import VueProgressBar from 'vue-progressbar'

const options = {
  color: '#12344D',
  failedColor: '#800000',
  thickness: '4px',
  autoRevert: true,
  location: 'top',
  inverse: false,
  autoFinish:false
}
Vue.use(VueProgressBar, options)

axios.interceptors.request.use(config => {
  if (config.useProgress) {
    Vue.prototype.$Progress.start();
  }
  return config;
}, error => {
  if (error.config && error.config.useProgress) {
    Vue.prototype.$Progress.fail();
  }
  return Promise.reject(error);
});

axios.interceptors.response.use(response => {
  if (response.config.useProgress) {
    Vue.prototype.$Progress.finish();
  }
  return response;
}, error => {
  if (error.config && error.config.useProgress) {
    Vue.prototype.$Progress.fail();
  }
  return Promise.reject(error);
});

Vue.prototype.$axios = axios;

axios.defaults.useProgress = false;

const components = [    ['project-button', './components/ProjectButton.vue'],
  ['archive-tasks', './components/Project/Panel/ArchiveTasks.vue'],
  ['project-form', './components/ProjectForm.vue'],
  ['project-status', './components/Project/Status.vue'],
  ['project-features', './components/Project/Feature/FeatureSection.vue'],
  ['project-stage', './components/Project/Stage.vue'],
  ['notifications', './components/Notification.vue'],
  ['profile', './components/Profile/ProfilePge.vue'],
  ['navbar', './components/Navbar.vue'],
];

components.forEach(([name, path]) => {
  Vue.component(name, () => import(`${path}`).then(m => m.default))
});

import LaravelVuePagination from 'laravel-vue-pagination';
Vue.component('pagination', LaravelVuePagination);

const app = new Vue({
    el: '#app',
     store,
     router,
});
