window._ = require('lodash');

window.Vue = require('vue');

Vue.config.productionTip = false
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

 /*let authorizations=require('./authorizations');

 Vue.prototype.authorize = function (...params) {
     if (! window.App.signedIn) return false;

     if (typeof params[0] === 'string') {
         return authorizations[params[0]](params[1]);
     }

     return params[0](window.App.user);
 };*/

 Vue.prototype.signedIn = window.App.signedIn;

 Vue.prototype.$user = '';

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

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

 window.Pusher = require('pusher-js');

 window.Echo = new Echo({
     broadcaster: 'pusher',
     key: process.env.MIX_PUSHER_APP_KEY,
     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
     encrypted: true,
     forceTLS: false,
     authEndpoint: 'http://127.0.0.1:8000/api/broadcasting/auth',
     auth: {
      headers: {
        Accept: 'application/json',
        Authorization: JSON.parse(localStorage.getItem("token"))
      },
     }
 });
