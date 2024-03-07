(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[12],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/TasksData.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Dashboard/TasksData.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      form: {
        created: '',
        assigned: ''
      }
    };
  },
  methods: {
    overDueTasks: function overDueTasks() {
      console.log('overdue');
    },
    remainingTasks: function remainingTasks() {
      console.log('remaining');
    },
    completedTasks: function completedTasks() {
      console.log('completed');
    },
    allTasks: function allTasks() {
      console.log('all');
    }
  },
  computed: {},
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/TasksData.vue?vue&type=template&id=67ca343c":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Dashboard/TasksData.vue?vue&type=template&id=67ca343c ***!
  \***************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "col-md-7"
  }, [_c("div", {
    staticClass: "card",
    staticStyle: {
      height: "28rem"
    }
  }, [_c("div", {
    staticClass: "card-header d-flex justify-content-between"
  }, [_vm._m(0), _vm._v(" "), _c("span", {
    staticClass: "float-right d-flex"
  }, [_c("div", {
    staticClass: "form-check mr-3"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.created,
      expression: "form.created"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "checkbox",
      value: "",
      id: "assignedTasks"
    },
    domProps: {
      checked: Array.isArray(_vm.form.created) ? _vm._i(_vm.form.created, "") > -1 : _vm.form.created
    },
    on: {
      change: function change($event) {
        var $$a = _vm.form.created,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = "",
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.form, "created", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.form, "created", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.form, "created", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "assignedTasks"
    }
  }, [_vm._v("\n        Assigned Tasks\n      ")])]), _vm._v(" "), _c("div", {
    staticClass: "form-check"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.assigned,
      expression: "form.assigned"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "checkbox",
      value: "",
      id: "createdTasks"
    },
    domProps: {
      checked: Array.isArray(_vm.form.assigned) ? _vm._i(_vm.form.assigned, "") > -1 : _vm.form.assigned
    },
    on: {
      change: function change($event) {
        var $$a = _vm.form.assigned,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = "",
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.form, "assigned", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.form, "assigned", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.form, "assigned", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "createdTasks"
    }
  }, [_vm._v("\n        Created Tasks\n      ")])])])]), _vm._v(" "), _c("div", {
    staticClass: "card-body card-body-scrollable card-body-scrollable-shadow"
  }, [_c("div", {
    staticClass: "divide-y"
  }, [_c("div", [_c("div", {
    staticClass: "row"
  }, [_c("ul", {
    staticClass: "nav nav-pills"
  }, [_c("li", {
    staticClass: "nav-pills_listitems btn btn-link",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.allTasks.apply(null, arguments);
      }
    }
  }, [_vm._v("all tasks")]), _vm._v(" "), _c("li", {
    staticClass: "nav-pills_listitems btn btn-link",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.overDueTasks.apply(null, arguments);
      }
    }
  }, [_vm._v("overdue tasks")]), _vm._v(" "), _c("li", {
    staticClass: "nav-pills_listitems btn btn-link",
    on: {
      click: function click($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "pervent", undefined, $event.key, undefined)) return null;
        return _vm.remainingTasks.apply(null, arguments);
      }
    }
  }, [_vm._v("remaining  tasks")]), _vm._v(" "), _c("li", {
    staticClass: "nav-pills_listitems btn btn-link",
    on: {
      click: function click($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "pervent", undefined, $event.key, undefined)) return null;
        return _vm.completedTasks.apply(null, arguments);
      }
    }
  }, [_vm._v("completed tasks")])]), _vm._v(" "), _c("div", {
    staticClass: "horizontal-line"
  }), _vm._v(" "), _c("div", {
    staticClass: "col-auto"
  }), _vm._v(" "), _vm._m(1)])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("span", {
    staticClass: "float-left"
  }, [_vm._v("Your Tasks > "), _c("b")]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col"
  }, [_c("div", {}), _vm._v(" "), _c("div", {
    staticClass: "text-secondary"
  })]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Dashboard/TasksData.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/Dashboard/TasksData.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TasksData_vue_vue_type_template_id_67ca343c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TasksData.vue?vue&type=template&id=67ca343c */ "./resources/js/components/Dashboard/TasksData.vue?vue&type=template&id=67ca343c");
/* harmony import */ var _TasksData_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TasksData.vue?vue&type=script&lang=js */ "./resources/js/components/Dashboard/TasksData.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TasksData_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _TasksData_vue_vue_type_template_id_67ca343c__WEBPACK_IMPORTED_MODULE_0__["render"],
  _TasksData_vue_vue_type_template_id_67ca343c__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Dashboard/TasksData.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Dashboard/TasksData.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Dashboard/TasksData.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TasksData_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./TasksData.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/TasksData.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TasksData_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Dashboard/TasksData.vue?vue&type=template&id=67ca343c":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Dashboard/TasksData.vue?vue&type=template&id=67ca343c ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TasksData_vue_vue_type_template_id_67ca343c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./TasksData.vue?vue&type=template&id=67ca343c */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/TasksData.vue?vue&type=template&id=67ca343c");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TasksData_vue_vue_type_template_id_67ca343c__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TasksData_vue_vue_type_template_id_67ca343c__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);