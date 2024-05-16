(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[24],{

/***/ "./resources/js/mixins/modalClose.js":
/*!*******************************************!*\
  !*** ./resources/js/mixins/modalClose.js ***!
  \*******************************************/
/*! exports provided: modalClose */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "modalClose", function() { return modalClose; });
function modalClose(context) {
  context.$modal.hide('task-modal');
  context.$modal.hide('archive-task-modal');
  context.setErrors('');
  context.setForm({});
  context.$emit('modal-closed');
}

/***/ })

}]);