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
import currentStage from './mixins/currentStage';
import conversation from './mixins/conversation';
import Chart from 'chart.js';
import 'animate.css';
import "cropperjs/dist/cropper.css"
import swal from 'sweetalert2';
import VueToastify from "vue-toastify";
import { Datetime } from 'vue-datetime';
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css';
import { Settings } from 'luxon'


Vue.use(Vuex);
Vue.use(VueBus);
Vue.use(VTooltip);
Vue.use(VueSlideoutPanel);
Vue.use(VModal);
Vue.use(Datetime)

Vue.component('datetime', Datetime);
const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent)

window.momenttz = require('moment-timezone');
window.moment = require('moment');
window.swal=swal;

import router from './router.js'
import store from "./store";

Vue.mixin(alertNotice);
Vue.mixin(currentStage);
Vue.mixin(conversation);


Vue.filter('time',function(data){
   return  moment(data).format('h:mm:ss a');
})

Vue.filter('date',function(data){
   return  moment(data).format("MMM Do YY");
})

Vue.filter('datetime',function(data){
   return  moment(data).format("MMM Do YY h:mm:ss a");
})


Vue.use(VueToastify, {
    position:"bottom-left",
    theme:"light",
    successDuration:2050,
    warningInfoDuration:2050,
    errorDuration:2050,
    canPause:false
});


//set to display dates for English language
Settings.defaultLocale = 'en'


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
