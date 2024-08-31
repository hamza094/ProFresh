(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[17],{

/***/ "./resources/js/utils/meetingUtils.js":
/*!********************************************!*\
  !*** ./resources/js/utils/meetingUtils.js ***!
  \********************************************/
/*! exports provided: canStartMeeting, canJoinMeeting */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "canStartMeeting", function() { return canStartMeeting; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "canJoinMeeting", function() { return canJoinMeeting; });
function canStartMeeting(meeting, auth, isAuthorized) {
  console.log(meeting, auth, isAuthorized);
  return isAuthorized && meeting.owner.id === auth.id && meeting.status !== 'Started';
}
function canJoinMeeting(meeting, auth, members) {
  return meeting.owner.id !== auth.id && members.includes(auth);
}

/***/ })

}]);