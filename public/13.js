(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[13],{

/***/ "./resources/js/store/SingleTask":
/*!***************************************!*\
  !*** ./resources/js/store/SingleTask ***!
  \***************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
const state = {
  task:[],
  form:{
    description:'',
    due_at:'',
    notified:'',
    status_id:'',
    search:'',
  },
  errors:{},
};

const mutations = {
  setTask(state,task){
   state.task=task;
  },
};

const actions = {

};

/* harmony default export */ __webpack_exports__["default"] = ({
  namespaced: true,
  state,
  mutations,
  actions,
});

/***/ })

}]);