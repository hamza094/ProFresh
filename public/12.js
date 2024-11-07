(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[12],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../utils/TaskUtils */ "./resources/js/utils/TaskUtils.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_2__);
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }



/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['slug', 'taskId'],
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])('SingleTask', ['form', 'errors', 'task'])),
  data: function data() {
    return {
      searchResults: "",
      taskMembers: []
    };
  },
  watch: {
    'form.search': Object(lodash__WEBPACK_IMPORTED_MODULE_2__["debounce"])(function (newSearch) {
      this.performSearch(newSearch);
    }, 500)
  },
  created: function created() {
    var _this = this;
    this.$bus.on('toggleMember', function () {
      _this.taskMembers = [];
      _this.setErrors([]);
      _this.form.search = '';
    });
  },
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('SingleTask', ['setErrors', 'updateTaskMembers'])), {}, {
    performSearch: function performSearch(searchTerm) {
      var _this2 = this;
      axios.get("/api/v1/projects/".concat(this.slug, "/tasks/").concat(this.taskId, "/member/search"), {
        params: {
          search: this.form.search
        }
      }).then(function (response) {
        _this2.searchResults = response.data;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    addMember: function addMember(member, id) {
      var memberExists = this.taskMembers.some(function (m) {
        return m.id === member.id;
      });
      if (memberExists) {
        return this.$vToastify.warning("Member already listed");
      }
      this.taskMembers.push(member);
      this.searchResults = [];
      this.form.search = '';
    },
    removeMember: function removeMember(member, id) {
      this.taskMembers = this.taskMembers.filter(function (m) {
        return m !== member;
      });
    },
    assignMembers: function assignMembers(taskId) {
      var _this3 = this;
      if (!this.taskMembers.length) {
        return this.$vToastify.info('no member is selected to assign task');
      }
      var memberIds = this.taskMembers.map(function (member) {
        return member.id;
      });
      axios.patch(Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__["url"])(this.slug, taskId) + '/assign', {
        members: memberIds
      }).then(function (response) {
        _this3.assignSuccessfull(response);
      })["catch"](function (error) {
        Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__["ErrorHandling"])(_this3, error);
      });
    },
    assignSuccessfull: function assignSuccessfull(response) {
      this.taskMembers = [];
      this.setErrors([]);
      this.updateTaskMembers(response.data.taskMembers);
      this.$bus.emit('close-members-popup');
      this.$vToastify.success(response.data.message);
    },
    getErrors: function getErrors(key) {
      if (this.hasError(key)) {
        return this.errors[key];
      }
      return [];
    },
    hasError: function hasError(key) {
      if (this.errors && _typeof(this.errors) === 'object' && this.errors.hasOwnProperty(key)) {
        return true;
      }
      return false;
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94":
/*!***************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94 ***!
  \***************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "member-dropdown_item"
  }, [_vm._m(0), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.search,
      expression: "form.search"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "Search Members",
      name: "member",
      autocomplete: "off"
    },
    domProps: {
      value: _vm.form.search
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "search", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.hasError("members") ? _c("div", _vm._l(_vm.getErrors("members"), function (error) {
    return _c("span", {
      key: error,
      staticClass: "text-danger font-italic"
    }, [_vm._v("*" + _vm._s(error))]);
  }), 0) : _vm._e(), _vm._v(" "), _vm.hasError("members.0") ? _c("div", _vm._l(_vm.getErrors("members.0"), function (error) {
    return _c("span", {
      key: error,
      staticClass: "text-danger font-italic"
    }, [_vm._v("*" + _vm._s(error))]);
  }), 0) : _vm._e(), _vm._v(" "), _vm.searchResults.length > 0 && _vm.form.search ? _c("div", {
    staticClass: "member-list"
  }, _vm._l(_vm.searchResults, function (member) {
    return _c("div", {
      key: member.id,
      staticClass: "member-list_items"
    }, [_c("div", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.addMember(member, member.id);
        }
      }
    }, [_vm._v(_vm._s(member.name) + " (" + _vm._s(member.username) + ")\n      ")])]);
  }), 0) : _vm._e(), _vm._v(" "), _c("button", {
    staticClass: "mt-2 btn btn-sm btn-primary float-right",
    on: {
      click: function click($event) {
        return _vm.assignMembers(_vm.task.id);
      }
    }
  }, [_vm._v("Assign")]), _vm._v(" "), _vm.taskMembers.length > 0 ? _c("div", {
    staticClass: "mt-3",
    staticStyle: {
      height: "70px",
      width: "150px",
      "overflow-y": "scroll"
    }
  }, _vm._l(_vm.taskMembers, function (member) {
    return _c("div", [_c("span", [_vm._v(_vm._s(member.username) + " "), _c("span", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.removeMember(member, member.id);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-minus-circle"
    })])])]);
  }), 0) : _vm._e()]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "text-center m-1"
  }, [_c("small", [_c("b", [_vm._v("Assign Task To Member")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TaskMembers.vue ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TaskMembers_vue_vue_type_template_id_832a0e94__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TaskMembers.vue?vue&type=template&id=832a0e94 */ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94");
/* harmony import */ var _TaskMembers_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TaskMembers.vue?vue&type=script&lang=js */ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TaskMembers_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _TaskMembers_vue_vue_type_template_id_832a0e94__WEBPACK_IMPORTED_MODULE_0__["render"],
  _TaskMembers_vue_vue_type_template_id_832a0e94__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Modal/TaskMembers.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TaskMembers.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94 ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_template_id_832a0e94__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TaskMembers.vue?vue&type=template&id=832a0e94 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_template_id_832a0e94__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_template_id_832a0e94__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/utils/TaskUtils.js":
/*!*****************************************!*\
  !*** ./resources/js/utils/TaskUtils.js ***!
  \*****************************************/
/*! exports provided: calculateRemainingTime, url, ErrorHandling */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "calculateRemainingTime", function() { return calculateRemainingTime; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "url", function() { return url; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ErrorHandling", function() { return ErrorHandling; });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);

function calculateRemainingTime(task, currentDate) {
  if (task.due_at_utc !== null) {
    var dueDate = moment__WEBPACK_IMPORTED_MODULE_0___default.a.utc(task.due_at_utc);
    var now = moment__WEBPACK_IMPORTED_MODULE_0___default.a.utc(currentDate);
    var duration = moment__WEBPACK_IMPORTED_MODULE_0___default.a.duration(dueDate.diff(now));
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
function ErrorHandling(component, error) {
  var _error$response, _error$response2;
  var toastMessage = (error === null || error === void 0 || (_error$response = error.response) === null || _error$response === void 0 || (_error$response = _error$response.data) === null || _error$response === void 0 || (_error$response = _error$response.errors) === null || _error$response === void 0 || (_error$response = _error$response.task) === null || _error$response === void 0 ? void 0 : _error$response[0]) || (error === null || error === void 0 || (_error$response2 = error.response) === null || _error$response2 === void 0 || (_error$response2 = _error$response2.data) === null || _error$response2 === void 0 ? void 0 : _error$response2.message) || 'An error occurred';
  component.$vToastify.warning(toastMessage);
  if (error.response) {
    return component.setErrors(error.response.data.errors);
  }
}

/***/ })

}]);