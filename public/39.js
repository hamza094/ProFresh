(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[39],{

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


/***/ })

}]);