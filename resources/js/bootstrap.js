import _ from 'lodash';
window._ = _;

import Vue from 'vue';
window.Vue = Vue;

Vue.config.productionTip = false;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

Vue.prototype.$user = '';

import * as Popper from "@popperjs/core";
import jQuery from 'jquery';
import 'bootstrap';

window.Popper = Popper;
window.$ = window.jQuery = jQuery;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

axios.defaults.withCredentials = true;

axios.interceptors.request.use(function (config) {

  config.headers.common = {
    'Authorization': JSON.parse(localStorage.getItem("token")),
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }

  return config
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
    forceTLS: false,
    authEndpoint: 'http://localhost:8000/api/broadcasting/auth',
    auth: {
     headers: {
       Accept: 'application/json',
       Authorization: JSON.parse(localStorage.getItem("token"))
     },
    }
});
