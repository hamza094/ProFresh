/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Vuex from 'vuex';
import VueBus from 'vue-bus';
import VTooltip from 'v-tooltip';
import VueSlideoutPanel from 'vue2-slideout-panel';
import VModal from 'vue-js-modal';
import moment from 'moment';
import "emoji-mart-vue-fast/css/emoji-mart.css";
import alertNotice from './mixins/alertNotice';
import errorHandling from './mixins/errorHandling';
import currentStage from './mixins/currentStage';
import popup from './mixins/popup';
import conversation from './mixins/conversation';
import activitiesDesign from './mixins/activitiesDesign';
import Chart from 'chart.js';
import 'animate.css';
import "cropperjs/dist/cropper.css"
import swal from 'sweetalert2';
import VueToastify from "vue-toastify";
import { Datetime } from 'vue-datetime';
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css';
import VCalendar from 'v-calendar';

Vue.use(Vuex);
Vue.use(VueBus);
Vue.use(VTooltip);
Vue.use(VueSlideoutPanel);
Vue.use(VModal);
Vue.use(Datetime)

Vue.component('datetime', Datetime);
const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent)

import { VueSpinners } from '@saeris/vue-spinners'

Vue.use(VueSpinners)

window.momenttz = require('moment-timezone');
window.moment = require('moment');
window.swal=swal;

import router from './router.js'
import store from "./store";

Vue.mixin(alertNotice);
Vue.mixin(currentStage);
Vue.mixin(conversation);
Vue.mixin(activitiesDesign);
Vue.mixin(errorHandling);

Vue.filter('time',function(data){
   return  moment(data).format('h:mm:ss a');
})

Vue.filter('date',function(data){
   return  moment(data).format("MMM Do YY");
})

Vue.filter('reciept_date',function(data){
   return  moment(data).format("MMM Do YYYY");
})

Vue.filter('datetime',function(data){
   return  moment(data).format("MMM Do YY h:mm:ss a");
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
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '7px',
  transition: {
    opacity: '0.6s',
    speed: '3s',
    opacity: '0.6s',
    termination: 1800
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}
Vue.use(VueProgressBar, options)

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

Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
    el: '#app',
     store,
     router,
});
