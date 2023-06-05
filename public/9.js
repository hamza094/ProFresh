(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[9],{

/***/ "./resources/js/store/subscribeUser":
/*!******************************************!*\
  !*** ./resources/js/store/subscribeUser ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _router_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../router.js */ "./resources/js/router.js");


const state = {
  subscription:{},
  errors:{},
};

const getters = {};
const actions = {

  UserSubscription({commit,state,dispatch},user){
    axios.get('/api/v1/user/subscription',user,{
  }).then(response=>{
      commit('setSubscription',response.data.subscription);

      //commit('setErrors','');

     }).catch(error=>{
       //commit('setErrors',error.response.data.errors);
  });
},


deleteSubscription({commit,state}){
  
},

};
const mutations = {
  setErrors(state,data){
    state.errors=data;
  },
  setSubscription(state,data){
    state.subscription=data;
  },
};

/* harmony default export */ __webpack_exports__["default"] = ({
  namespaced: true,
  state,
  getters,
  actions,
  mutations
});


/***/ })

}]);