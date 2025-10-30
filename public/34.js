(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[34],{

/***/ "./resources/js/utils/meetingUtils.js":
/*!********************************************!*\
  !*** ./resources/js/utils/meetingUtils.js ***!
  \********************************************/
/*! exports provided: shouldShowStartButton, shouldShowJoinButton */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "shouldShowStartButton", function() { return shouldShowStartButton; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "shouldShowJoinButton", function() { return shouldShowJoinButton; });
function shouldShowStartButton(meeting, auth, notAuthorize) {
  return !notAuthorize && meeting.owner.id === auth.id && meeting.status.toLowerCase() !== 'started';
}
function shouldShowJoinButton(meeting, auth, members) {
  return meeting.owner.id !== auth.id && members.includes(auth);
}

/***/ })

}]);