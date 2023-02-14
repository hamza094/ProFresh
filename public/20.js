(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[20],{

/***/ "./resources/js/auth.js":
/*!******************************!*\
  !*** ./resources/js/auth.js ***!
  \******************************/
/*! exports provided: permission */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "permission", function() { return permission; });
function permission(auth, members, user) {
  var authId = auth.id;
  var member = members.find(function (member) {
    return member.id === authId;
  });
  var accessAllowed = false;
  var ownerLogin = false;
  if (member || user.id === authId) {
    accessAllowed = true;
  }
  if (user.id === authId) {
    ownerLogin = true;
  }
  return {
    accessAllowed: accessAllowed,
    ownerLogin: ownerLogin
  };
}

/***/ })

}]);