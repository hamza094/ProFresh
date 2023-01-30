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
import currentStage from './mixins/currentStage';
import conversation from './mixins/conversation';
import Datetime from 'vue-datetime/dist/vue-datetime.css';
import 'vue-datetime/dist/vue-datetime.css';
import Chart from 'chart.js';
import { Settings } from 'luxon';
import VueUploadComponent from 'vue-upload-component';
import VueProgressBar from 'vue-progressbar';
import router from './router.js'
import store from "./store";

Vue.use(Vuex);
Vue.use(VueBus);
Vue.use(VTooltip);
Vue.use(VueSlideoutPanel);
Vue.use(VModal);

Vue.mixin(alertNotice);
Vue.mixin(currentStage);
Vue.mixin(conversation);

Vue.filter('time', function(data) {
  return moment(data).format('h:mm:ss a');
});

Vue.filter('date', function(data) {
  return moment(data).format("MMM Do YY");
});

Vue.filter('datetime', function(data) {
  return moment(data).format("MMM Do YY h:mm:ss a");
});

window.moment = require('moment');
window.momenttz = require('moment-timezone');

import 'animate.css';
import "cropperjs/dist/cropper.css"

import swal from 'sweetalert2';
window.swal = swal;

import VueToastify from "vue-toastify";
Vue.use(VueToastify, {
  position: "bottom-left",
  theme: "light",
  successDuration: 2050,
  warningInfoDuration: 2050,
  errorDuration: 2050,
  canPause: false
});

Vue.use(Datetime);
Vue.component('datetime', Datetime);

Settings.defaultLocale = 'en';

Vue.use(VueUploadComponent);
Vue.component('file-upload', VueUploadComponent);

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

Vue.use(VueProgressBar, options);

const components = [    ['project-button', './components/ProjectButton.vue'],
  ['project-form', './components/ProjectForm.vue'],
  ['project-status', './components/Project/Status.vue'],
  ['project-features', './components/Project/Feature/FeatureSection.vue'],
  ['project-stage', './components/Project/Stage.vue'],
  ['notifications', './components/Notification.vue'],
  ['pagination', 'laravel-vue-pagination'],
  ['profile', './components/Profile/ProfilePge.vue'],
  ['navbar', './components/Navbar.vue'],
];

components.forEach(([name, path]) => {
  Vue.component(name, () => import(`${path}`).then(m => m.default))
});


const app = new Vue({
    el: '#app',
     store,
     router,
});
