(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[11],{

/***/ "./resources/js/mixins/taskModal.js":
/*!******************************************!*\
  !*** ./resources/js/mixins/taskModal.js ***!
  \******************************************/
/*! exports provided: modalClose */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "modalClose", function() { return modalClose; });
function modalClose(context) {
  context.$modal.hide('task-modal');
  context.$modal.hide('archive-task-modal');
  context.setErrors('');
  context.form = {};
  context.$emit('modal-closed');
}

/***/ })

}]);