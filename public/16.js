(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[16],{

/***/ "./resources/js/utils/TaskUtils.js":
/*!*****************************************!*\
  !*** ./resources/js/utils/TaskUtils.js ***!
  \*****************************************/
/*! exports provided: calculateRemainingTime, url */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "calculateRemainingTime", function() { return calculateRemainingTime; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "url", function() { return url; });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);

function calculateRemainingTime(task, currentDate) {
  if (task.due_at !== null) {
    var duration = moment__WEBPACK_IMPORTED_MODULE_0___default.a.duration(moment__WEBPACK_IMPORTED_MODULE_0___default()(task.due_at).diff(moment__WEBPACK_IMPORTED_MODULE_0___default()(currentDate)));
    if (duration.asMilliseconds() <= 0) {
      return 'Due date passed';
    }
    var days = duration.days();
    var hours = duration.hours();
    var minutes = duration.minutes();
    var messageParts = [];
    if (days > 0) {
      messageParts.push("".concat(days, " day(s)"));
    }
    if (hours > 0) {
      messageParts.push("".concat(hours, " hour(s)"));
    }
    if (minutes > 0) {
      messageParts.push("".concat(minutes, " minute(s)"));
    }
    return "".concat(messageParts.join(', '), " remaining");
  }
}
function url($slug, $id) {
  return '/api/v1/projects/' + $slug + '/tasks/' + $id;
}

/*export function updateTask(slug, id, task, data, additionalCallback) {
  if (areObjectsEqual(data, task)) {
    this.$vToastify.warning("Update not allowed. No changes were made.");
    return;
  }

  axios.put(url(slug, id), data)
    .then(response => {
      this.$vToastify.success(response.data.message);
      if (additionalCallback) {
        additionalCallback(response.data); // Call additional callback if provided
      }
    })
    .catch(error => {
      console.logerror.response.data.errors;
    });
}

export function areObjectsEqual(obj1, obj2) {
  return Object.keys(obj1).every(key => obj1[key] === obj2[key]);
}*/

/***/ })

}]);