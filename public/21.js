(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[21],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../utils/TaskUtils */ "./resources/js/utils/TaskUtils.js");
/* harmony import */ var _mixins_modalClose__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../mixins/modalClose */ "./resources/js/mixins/modalClose.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }



/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['task', 'state', 'slug', 'errors'],
  data: function data() {
    return {
      editing: 0
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])('SingleTask', ['form'])),
  methods: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('SingleTask', ['setErrors', 'updateTaskTitle', 'setForm'])), Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('task', ['updateTask'])), {}, {
    updateTitle: function updateTitle(id, task) {
      var _this = this;
      if (this.form.title === this.task.title) {
        return this.$vToastify.warning('No changes made.');
      }
      axios.put(Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__["url"])(this.slug, id), {
        title: this.form.title
      }, {
        useProgress: true
      }).then(function (response) {
        _this.$vToastify.success(response.data.message);
        _this.editing = false;
        _this.setErrors([]);
        _this.updateTaskTitle(response.data.task.title);
        _this.updateTask(response.data.task);
      })["catch"](function (error) {
        Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__["ErrorHandling"])(_this, error);
      });
    },
    closeTitleForm: function closeTitleForm(id, task) {
      this.editing = false;
      this.form.title = task.title;
      this.setErrors('');
    },
    openTitleForm: function openTitleForm(id, task) {
      this.editing = id;
      this.form.title = task.title;
    },
    modalClose: function modalClose() {
      Object(_mixins_modalClose__WEBPACK_IMPORTED_MODULE_2__["modalClose"])(this);
    }
  }),
  created: function created() {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true":
/*!***********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true ***!
  \***********************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm$errors, _vm$errors2;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("div", {
    staticClass: "edit-border-bottom"
  }, [_c("div", {
    staticClass: "task-modal_content"
  }, [_vm.editing == _vm.task.id ? _c("span", [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.title,
      expression: "form.title"
    }],
    staticClass: "title-form form-control",
    attrs: {
      name: "title"
    },
    domProps: {
      value: _vm.form.title,
      textContent: _vm._s(_vm.task.title)
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "title", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.updateTitle(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Update")]), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.closeTitleForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Cancel")])]) : _c("span", {
    staticClass: "task-modal_title",
    on: {
      click: function click($event) {
        return _vm.openTitleForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v(_vm._s(_vm.task.title))]), _vm._v(" "), _c("span", {
    staticClass: "task-modal_close float-right",
    attrs: {
      role: "button"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.modalClose.apply(null, arguments);
      }
    }
  }, [_vm._v("x")])]), _vm._v(" "), (_vm$errors = _vm.errors) !== null && _vm$errors !== void 0 && _vm$errors.title ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s((_vm$errors2 = _vm.errors) === null || _vm$errors2 === void 0 || (_vm$errors2 = _vm$errors2.title) === null || _vm$errors2 === void 0 ? void 0 : _vm$errors2[0])
    }
  }) : _vm._e()]), _vm._v(" "), _vm.state == "archived" ? _c("div", {
    staticClass: "alert alert-warning",
    attrs: {
      role: "alert"
    }
  }, [_vm._v("\nPlease note that this task is currently archived. Currently, you can only delete or unarchive this task.\n")]) : _vm._e()]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TopArea.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TopArea.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TopArea_vue_vue_type_template_id_e9f8c338_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TopArea.vue?vue&type=template&id=e9f8c338&scoped=true */ "./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true");
/* harmony import */ var _TopArea_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TopArea.vue?vue&type=script&lang=js */ "./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TopArea_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _TopArea_vue_vue_type_template_id_e9f8c338_scoped_true__WEBPACK_IMPORTED_MODULE_0__["render"],
  _TopArea_vue_vue_type_template_id_e9f8c338_scoped_true__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "e9f8c338",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Modal/TopArea.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TopArea.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true ***!
  \***********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_template_id_e9f8c338_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TopArea.vue?vue&type=template&id=e9f8c338&scoped=true */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_template_id_e9f8c338_scoped_true__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_template_id_e9f8c338_scoped_true__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

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