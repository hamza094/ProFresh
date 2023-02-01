(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[13],{

/***/ "./resources/js/mixins/activitiesDesign.js":
/*!*************************************************!*\
  !*** ./resources/js/mixins/activitiesDesign.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      activityData: {
        "Task": {
          icon: 'fas fa-tasks',
          color: 'activity-icon_primary'
        },
        "Project invitation": {
          icon: 'fas fa-user',
          color: 'activity-icon_green'
        },
        "Project member": {
          icon: 'fas fa-user',
          color: 'activity-icon_green'
        }
      }
    };
  },
  methods: {
    activityIcon: function activityIcon(description) {
      var prefix = Object.keys(this.activityData).find(function (prefix) {
        return description.startsWith(prefix);
      }) || 'default';
      return this.activityData[prefix] && this.activityData[prefix].icon || 'fab fa-pagelines';
    },
    activityColor: function activityColor(description) {
      var prefix = Object.keys(this.activityData).find(function (prefix) {
        return description.startsWith(prefix);
      }) || 'default';
      return this.activityData[prefix] && this.activityData[prefix].color || 'activity-icon_purple';
    }
  }
});

/***/ })

}]);