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

import * as Popper from '@popperjs/core';
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
  // Merge headers instead of overwriting defaults to preserve CSRF header, etc.
  config.headers = config.headers || {};
  try {
    config.headers.Authorization = JSON.parse(localStorage.getItem('token'));
  } catch {
    // ignore malformed token in localStorage
  }
  if (!config.headers['Content-Type']) config.headers['Content-Type'] = 'application/json';
  if (!config.headers.Accept) config.headers.Accept = 'application/json';

  return config;
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Read CSRF token from the meta tag instead of relying on a global script
const tokenMeta = document.head.querySelector('meta[name="csrf-token"]');
if (tokenMeta) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.content;
} else {
  console.error('CSRF token meta tag not found: <meta name="csrf-token" content="...">');
}

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
      Authorization: JSON.parse(localStorage.getItem('token')),
    },
  },
});
