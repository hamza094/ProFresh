/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex'

Vue.use(Vuex)

import router from './router.js'

import store from "./store";

import VueBus from 'vue-bus';

Vue.use(VueBus);

import Vue from 'vue';

import VueSlideoutPanel from 'vue2-slideout-panel';

Vue.use(VueSlideoutPanel);

import VModal from 'vue-js-modal'
Vue.use(VModal)

import moment from 'moment';

import alertNotice from './mixins/alertNotice';
import currentStage from './mixins/currentStage';
import projectUpdate from './project/Update';


Vue.mixin(alertNotice);
Vue.mixin(currentStage);
Vue.mixin(projectUpdate);


Vue.filter('time',function(data){
   return  moment(data).format('h:mm:ss a');
})

Vue.filter('date',function(data){
   return  moment(data).format("MMM Do YY");
})

Vue.filter('datetime',function(data){
   return  moment(data).format("MMM Do YY h:mm:ss a");
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

import Chart from 'chart.js';

Vue.use(Datetime)

Vue.component('datetime', Datetime);

import { Settings } from 'luxon'
//set to display dates for English language
Settings.defaultLocale = 'en'

const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('project-button', require('./components/ProjectButton.vue').default);

Vue.component('project-form', require('./components/ProjectForm.vue').default);

Vue.component('project-status', require('./components/Project/Status.vue').default);

 Vue.component('project-features', require('./components/Project/Feature/FeatureSection.vue').default);

 Vue.component('project-stage', require('./components/Project/Stage.vue').default);

// Vue.component('project-panel', require('./components/Project/Panel/PanelArea.vue').default);

Vue.component('notifications', require('./components/Notification.vue').default);

 Vue.component('pagination', require('laravel-vue-pagination'));

// Vue.component('profile', require('./components/Profile/ProfilePage.vue').default);

Vue.component('navbar', require('./components/Navbar.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
     store,
     router,
});
