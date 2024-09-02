(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[29],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Status.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Status.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['projectName', 'start', 'stage', 'completed', 'status', 'score'],
  data: function data() {
    return {
      isPop: false,
      loading: false
    };
  },
  watch: {
    isPop: function isPop(_isPop) {
      var _this = this;
      if (_isPop) {
        document.addEventListener('click', function (event) {
          return _this.$options.methods.handleClickOutside.call(_this, event, '.score-dropdown', _this.isPop);
        });
      }
    }
  },
  mounted: function mounted() {
    this.loading = true;
  },
  methods: {
    stagename: function stagename() {
      return this.currentStage(this.stage, this.completed);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "img-avatar"
  }, [_c("div", {
    staticClass: "img-avatar_name"
  }, [_vm._v("\n              " + _vm._s((_vm.projectName || "").substring(0, 1)) + "\n        ")])]), _vm._v(" "), _c("div", [_c("div", {
    staticClass: "score-dropdown",
    on: {
      click: function click($event) {
        _vm.isPop = !_vm.isPop;
      }
    }
  }, [_c("span", {
    staticClass: "score-point",
    "class": "score-point_" + _vm.status,
    attrs: {
      role: "button"
    }
  }, [_vm._v(_vm._s(_vm.score))]), _vm._v(" "), _c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.isPop,
      expression: "isPop"
    }],
    staticClass: "score-dropdown_item"
  }, [_c("div", {
    staticClass: "score"
  }, [_c("div", {
    staticClass: "score-content"
  }, [_c("p", {
    staticClass: "score-content_para"
  }, [_c("i", {
    staticClass: "far fa-clock"
  }), _vm._v("The project started " + _vm._s(_vm.start) + ". Currently in its\n                    "), _c("b", {
    domProps: {
      textContent: _vm._s(_vm.stagename())
    }
  }), _vm._v(" stage\n                    ")]), _vm._v(" "), _c("div", {
    staticClass: "score-content_point"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-3"
  }, [_c("p", {
    staticClass: "score-content_point-cold"
  }, [_c("span", [_c("span", {
    "class": "score-content_point-" + _vm.status + "_point"
  }, [_vm._v(_vm._s(_vm.score))]), _c("br"), _c("span", {
    "class": "score-content_point-" + _vm.status + "_status"
  }, [_vm._v(_vm._s(_vm.status))])])])]), _vm._v(" "), _vm._m(1)])])])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "score-content_point-para"
  }, [_c("b", [_vm._v("Top rating factors")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-md-9"
  }, [_c("div", [_c("div", [_c("p", {
    staticClass: "project-score"
  }, [_c("span", [_c("i", {
    staticClass: "fas fa-arrow-up"
  })]), _vm._v(" Score counts on the new task added.")]), _vm._v(" "), _c("p", {
    staticClass: "project-score"
  }, [_c("span", [_c("i", {
    staticClass: "fas fa-arrow-up"
  })]), _vm._v(" Score counts if project notes are available.\n                ")]), _vm._v(" "), _c("p", {
    staticClass: "project-score"
  }, [_c("span", [_c("i", {
    staticClass: "fas fa-arrow-up"
  })]), _vm._v("Score counts when a new member joins a project.")])])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/Status.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/Project/Status.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Status_vue_vue_type_template_id_7318ca1a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Status.vue?vue&type=template&id=7318ca1a */ "./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a");
/* harmony import */ var _Status_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Status.vue?vue&type=script&lang=js */ "./resources/js/components/Project/Status.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Status_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Status_vue_vue_type_template_id_7318ca1a__WEBPACK_IMPORTED_MODULE_0__["render"],
  _Status_vue_vue_type_template_id_7318ca1a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Status.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Status.vue?vue&type=script&lang=js":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Project/Status.vue?vue&type=script&lang=js ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Status.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Status.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a ***!
  \**********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_template_id_7318ca1a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Status.vue?vue&type=template&id=7318ca1a */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_template_id_7318ca1a__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_template_id_7318ca1a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);