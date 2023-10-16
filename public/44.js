(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[44],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProjectChart_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProjectChart.vue */ "./resources/js/components/Dashboard/ProjectChart.vue");

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    ProjectChart: _ProjectChart_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      projects: {},
      projectState: "",
      projectsCount: 0,
      message: ''
    };
  },
  methods: {
    activeProjects: function activeProjects() {
      var _this = this;
      axios.get(this.url()).then(function (_ref) {
        var data = _ref.data;
        return _this.getData(data);
      });
      this.projectState = "Active";
    },
    memberProjects: function memberProjects() {
      var _this2 = this;
      axios.get(this.url() + '?member=true').then(function (_ref2) {
        var data = _ref2.data;
        return _this2.getData(data);
      });
      this.projectState = "Member";
    },
    abandonedProjects: function abandonedProjects() {
      var _this3 = this;
      axios.get(this.url() + '?abandoned=true').then(function (_ref3) {
        var data = _ref3.data;
        return _this3.getData(data);
      });
      this.projectState = "Abandoned";
    },
    url: function url() {
      return '/api/v1/user/projects';
    },
    getData: function getData(data) {
      this.projects = data.projects, this.projectsCount = data.projectsCount, this.message = data.message;
    },
    stage: function stage(project) {
      return this.currentStage(project.stage, project.completed);
    }
  },
  mounted: function mounted() {
    this.activeProjects();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("div", {
    staticClass: "page-top"
  }, [_vm._v("Welcome To Your Dashboard")]), _vm._v(" "), _c("div", {
    staticClass: "dashboard-project m-4"
  }, [_c("p", {
    staticClass: "dashboard-heading float-left"
  }, [_c("b", [_vm._v("Total\n                "), _c("span", [_vm._v(_vm._s(_vm.projectState) + " Projects:")]), _vm._v("\n\t\t\t\t\t\t\t\t" + _vm._s(_vm.projectsCount) + "\n            ")])]), _vm._v(" "), _c("span", {
    staticClass: "float-right"
  }, [_c("button", {
    staticClass: "btn btn-sm btn-primary",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.activeProjects.apply(null, arguments);
      }
    }
  }, [_vm._v("Active Projects")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-sm btn-success",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.memberProjects.apply(null, arguments);
      }
    }
  }, [_vm._v("Projects Member")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-sm btn-danger",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.abandonedProjects.apply(null, arguments);
      }
    }
  }, [_vm._v("Abandoned Projects")])])]), _vm._v(" "), _c("br"), _c("br"), _vm._v(" "), _c("div", {
    staticClass: "dashboard"
  }, [_c("div", {
    staticClass: "row"
  }, [_vm.message ? _c("div", {
    staticClass: "m-3"
  }, [_c("h5", [_c("b", [_vm._v(_vm._s(_vm.message) + " in " + _vm._s(_vm.projectState) + " Projects")])])]) : _vm._e(), _vm._v(" "), _vm._l(_vm.projects, function (project) {
    return _c("div", {
      staticClass: "col-md-4"
    }, [_c("router-link", {
      staticClass: "dashboard-link",
      attrs: {
        to: "/projects/" + project.slug
      }
    }, [_c("div", {
      staticClass: "dashboard-projects mt-5"
    }, [_c("span", {
      staticClass: "float-right"
    }, [_c("b", [_vm._v(_vm._s(_vm.projectState))])]), _vm._v(" "), _c("p", {
      staticClass: "mt-3"
    }, [_vm._v(_vm._s(project.name))]), _vm._v(" "), _c("p", [_vm._v("Project Stage: "), _c("span", {
      domProps: {
        textContent: _vm._s(_vm.stage(project))
      }
    })]), _vm._v(" "), _c("p", [_vm._v("Project Status:\n\t\t\t\t    "), _c("span", [_vm._v(" " + _vm._s(project.status))])]), _vm._v(" "), _c("p", [_vm._v("Created At: " + _vm._s(project.created_at))])])])], 1);
  })], 2)]), _vm._v(" "), _c("div", {
    staticClass: "dashboard-project_info m-4"
  }, [_vm._m(0), _vm._v(" "), _c("br"), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("ProjectChart")], 1), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  })])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "float-left"
  }, [_c("b", [_vm._v("Your Projects Info")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Dashboard/Dashboard.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/Dashboard/Dashboard.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=template&id=c3d42bc4& */ "./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4&");
/* harmony import */ var _Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=script&lang=js& */ "./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Dashboard/Dashboard.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Dashboard.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Dashboard.vue?vue&type=template&id=c3d42bc4& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);