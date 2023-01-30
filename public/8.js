(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[8],{

/***/ "./node_modules/vuex-persistedstate/dist/vuex-persistedstate.es.js":
/*!*************************************************************************!*\
  !*** ./node_modules/vuex-persistedstate/dist/vuex-persistedstate.es.js ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var r=function(r){return function(r){return!!r&&"object"==typeof r}(r)&&!function(r){var t=Object.prototype.toString.call(r);return"[object RegExp]"===t||"[object Date]"===t||function(r){return r.$$typeof===e}(r)}(r)},e="function"==typeof Symbol&&Symbol.for?Symbol.for("react.element"):60103;function t(r,e){return!1!==e.clone&&e.isMergeableObject(r)?u(Array.isArray(r)?[]:{},r,e):r}function n(r,e,n){return r.concat(e).map(function(r){return t(r,n)})}function o(r){return Object.keys(r).concat(function(r){return Object.getOwnPropertySymbols?Object.getOwnPropertySymbols(r).filter(function(e){return r.propertyIsEnumerable(e)}):[]}(r))}function c(r,e){try{return e in r}catch(r){return!1}}function u(e,i,a){(a=a||{}).arrayMerge=a.arrayMerge||n,a.isMergeableObject=a.isMergeableObject||r,a.cloneUnlessOtherwiseSpecified=t;var f=Array.isArray(i);return f===Array.isArray(e)?f?a.arrayMerge(e,i,a):function(r,e,n){var i={};return n.isMergeableObject(r)&&o(r).forEach(function(e){i[e]=t(r[e],n)}),o(e).forEach(function(o){(function(r,e){return c(r,e)&&!(Object.hasOwnProperty.call(r,e)&&Object.propertyIsEnumerable.call(r,e))})(r,o)||(i[o]=c(r,o)&&n.isMergeableObject(e[o])?function(r,e){if(!e.customMerge)return u;var t=e.customMerge(r);return"function"==typeof t?t:u}(o,n)(r[o],e[o],n):t(e[o],n))}),i}(e,i,a):t(i,a)}u.all=function(r,e){if(!Array.isArray(r))throw new Error("first argument should be an array");return r.reduce(function(r,t){return u(r,t,e)},{})};var i=u;function a(r){var e=(r=r||{}).storage||window&&window.localStorage,t=r.key||"vuex";function n(r,e){var t=e.getItem(r);try{return"string"==typeof t?JSON.parse(t):"object"==typeof t?t:void 0}catch(r){}}function o(){return!0}function c(r,e,t){return t.setItem(r,JSON.stringify(e))}function u(r,e){return Array.isArray(e)?e.reduce(function(e,t){return function(r,e,t,n){return!/^(__proto__|constructor|prototype)$/.test(e)&&((e=e.split?e.split("."):e.slice(0)).slice(0,-1).reduce(function(r,e){return r[e]=r[e]||{}},r)[e.pop()]=t),r}(e,t,(n=r,void 0===(n=((o=t).split?o.split("."):o).reduce(function(r,e){return r&&r[e]},n))?void 0:n));var n,o},{}):r}function a(r){return function(e){return r.subscribe(e)}}(r.assertStorage||function(){e.setItem("@@",1),e.removeItem("@@")})(e);var f,s=function(){return(r.getState||n)(t,e)};return r.fetchBeforeUse&&(f=s()),function(n){r.fetchBeforeUse||(f=s()),"object"==typeof f&&null!==f&&(n.replaceState(r.overwrite?f:i(n.state,f,{arrayMerge:r.arrayMerger||function(r,e){return e},clone:!1})),(r.rehydrated||function(){})(n)),(r.subscriber||a)(n)(function(n,i){(r.filter||o)(n)&&(r.setState||c)(t,(r.reducer||u)(i,r.paths),e)})}}/* harmony default export */ __webpack_exports__["default"] = (a);
//# sourceMappingURL=vuex-persistedstate.es.js.map


/***/ }),

/***/ "./resources/js/store/currentUser":
/*!****************************************!*\
  !*** ./resources/js/store/currentUser ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _router_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../router.js */ "./resources/js/router.js");


const state = {
  user:{},
  errors:{},
  loggedIn:false
};
const getters = {};
const actions = {

  loginUser({commit,state,dispatch},user){
    axios.post('/api/v1/login',user,{
  }).then(response=>{

      dispatch('createUserToken',response);

      commit('setUser',response.data.user);
      commit('loggedIn',true);

      _router_js__WEBPACK_IMPORTED_MODULE_0__["default"].push('/home');
      commit('setErrors','');

     }).catch(error=>{
       commit('setErrors',error.response.data.errors);
  });
},

createUserToken({commit},response){
  let accessToken= JSON.stringify('Bearer ' + response.data.access_token);

  let bearerToken= accessToken.replace(/\\n/g, '');
  localStorage.setItem('token',bearerToken);
},

logoutUser({commit,state}){
   axios.post('/api/v1/logout',{
}).then(response=>{
    localStorage.removeItem('token');
    commit('setUser',null);
    commit('loggedIn',false);
    _router_js__WEBPACK_IMPORTED_MODULE_0__["default"].push('/login');
   }).catch(error=>{
     this.errors=error.response.data.errors;
});
}

};
const mutations = {
  setErrors(state,data){
    state.errors=data;
  },
  setUser(state,data){
    state.user=data;
  },
  loggedIn(state,data){
    state.loggedIn=data;
  },
};

/* harmony default export */ __webpack_exports__["default"] = ({
  namespaced: true,
  state,
  getters,
  actions,
  mutations
});


/***/ }),

/***/ "./resources/js/store/index.js":
/*!*************************************!*\
  !*** ./resources/js/store/index.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var vuex_persistedstate__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex-persistedstate */ "./node_modules/vuex-persistedstate/dist/vuex-persistedstate.es.js");
/* harmony import */ var _currentUser__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./currentUser */ "./resources/js/store/currentUser");




vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vuex__WEBPACK_IMPORTED_MODULE_1__["default"]);
/* harmony default export */ __webpack_exports__["default"] = (new vuex__WEBPACK_IMPORTED_MODULE_1__["default"].Store({
  plugins: [Object(vuex_persistedstate__WEBPACK_IMPORTED_MODULE_2__["default"])()],
  modules: {
    currentUser: _currentUser__WEBPACK_IMPORTED_MODULE_3__["default"]
  }
}));

/***/ })

}]);