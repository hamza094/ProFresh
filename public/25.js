(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[25],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Activities.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      activities: {},
      status: 'all',
      auth: '3ade7132-9cc4-4e03-972b-6e4170ec3663',
      //this.$store.state.currentUser.user.id,
      current: ''
    };
  },
  methods: {
    getActivities: function getActivities() {
      var _this = this;
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities').then(function (response) {
        _this.activities = response.data;
      })["catch"](function (error) {
        console.log(error.response.data.errors);
      });
      this.current = 'All Project Activities';
    },
    activityIcon: function activityIcon(description) {
      if (description.startsWith("Task")) {
        return 'fas fa-tasks';
      }
      if (description.startsWith("Project invitation") || description.startsWith("Project member")) {
        return 'fas fa-user';
      }
      return 'fab fa-pagelines';
    },
    activityColor: function activityColor(description) {
      if (description.startsWith("Task")) {
        return 'activity-icon_primary';
      }
      if (description.startsWith("Project invitation") || description.startsWith("Project member")) {
        return 'activity-icon_green';
      }
      return 'activity-icon_purple';
    },
    getResults: function getResults() {
      var _this2 = this;
      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?page=' + page).then(function (response) {
        _this2.activities = response.data;
      });
    },
    allActivities: function allActivities() {
      this.status = "all";
      this.getActivities();
    },
    myActivities: function myActivities() {
      var _this3 = this;
      this.status = "my";
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?mine=' + this.auth).then(function (response) {
        _this3.activities = response.data;
        _this3.current = 'My Project Activities';
      });
    },
    projectActivities: function projectActivities() {
      var _this4 = this;
      this.status = "project";
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?specifics=1').then(function (response) {
        _this4.activities = response.data;
        _this4.current = 'Project Specified Activities';
      });
    },
    taskActivities: function taskActivities() {
      var _this5 = this;
      this.status = "task";
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?tasks=1').then(function (response) {
        _this5.activities = response.data;
        _this5.current = 'Project Tasks Activities';
      });
    },
    memberActivities: function memberActivities() {
      var _this6 = this;
      this.status = "member";
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?members=1').then(function (response) {
        _this6.activities = response.data;
        _this6.current = 'Project Members Activities';
      });
    }
  },
  created: function created() {
    this.getActivities();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee& ***!
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
  return _c("div", [_c("div", {
    staticClass: "container-fluid"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-8 page pd-r"
  }, [_c("div", {
    staticClass: "page-top"
  }, [_c("div", [_c("span", [_c("span", {
    staticClass: "page-top_heading"
  }, [_vm._v("Projects ")]), _vm._v(" "), _c("span", {
    staticClass: "page-top_arrow"
  }, [_vm._v(" > ")]), _vm._v(" "), _c("span", [_c("router-link", {
    staticClass: "dashboard-link",
    attrs: {
      to: "/project/" + this.$route.params.slug
    }
  }, [_vm._v(_vm._s(this.$route.params.name))])], 1), _vm._v(" "), _c("span", {
    staticClass: "page-top_arrow"
  }, [_vm._v(" > ")]), _vm._v(" "), _c("span", [_vm._v("\n   Activities >\n   "), _c("span", {
    staticClass: "ml-2"
  }, [_vm._v(_vm._s(this.current))])])])])]), _vm._v(" "), _c("div", {
    staticClass: "container mt-3"
  }, [_c("div", {
    staticClass: "activity mb-5"
  }, [this.activities.data == null ? _c("div", {
    staticClass: "mt-3"
  }, [_c("h3", {
    staticClass: "text-center"
  }, [_vm._v("No related activities found")])]) : _vm._e(), _vm._v(" "), _c("ul", _vm._l(this.activities.data, function (activity, index) {
    return _c("li", {
      key: activity.id
    }, [_c("span", {
      staticClass: "activity-icon",
      "class": _vm.activityColor(activity.description)
    }, [_c("i", {
      "class": _vm.activityIcon(activity.description)
    })]), _vm._v("\n             " + _vm._s(activity.description) + "\n              "), _c("p", {
      staticClass: "activity-info"
    }, [_c("span", {
      domProps: {
        textContent: _vm._s(activity.user.name)
      }
    }), _c("span", {
      staticClass: "activity-info_dot"
    }), _c("span", {
      domProps: {
        textContent: _vm._s(activity.time)
      }
    })])]);
  }), 0)])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "card"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "card-body activity-search"
  }, [_c("ul", [_c("li", [_c("a", {
    staticClass: "activity-icon_secondary",
    "class": {
      Activityfont: _vm.status == "all"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.allActivities.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-layer-group activity-icon_secondary mr-3"
  }), _vm._v("All Activities")])]), _vm._v(" "), _c("li", [_c("a", {
    staticClass: "'activity-icon_purple",
    "class": {
      Activityfont: _vm.status == "my"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.myActivities.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-user activity-icon_purple mr-3"
  }), _vm._v(" My Activities")])]), _vm._v(" "), _c("li", [_c("a", {
    staticClass: "activity-icon_green",
    "class": {
      Activityfont: _vm.status == "project"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.projectActivities.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "far fa-star activity-icon_green mr-3"
  }), _vm._v(" Project Activities")])]), _vm._v(" "), _c("li", [_c("a", {
    staticClass: "activity-icon_primary",
    "class": {
      Activityfont: _vm.status == "task"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.taskActivities();
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-tasks activity-icon_primary mr-3"
  }), _vm._v(" Task Activities")])]), _vm._v(" "), _c("li", [_c("a", {
    staticClass: "activity-icon_danger",
    "class": {
      Activityfont: _vm.status == "member"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.memberActivities();
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-tasks activity-icon_danger mr-3"
  }), _vm._v(" Member Activities")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "mt-4"
  }, [_c("pagination", {
    attrs: {
      data: _vm.activities
    },
    on: {
      "pagination-change-page": _vm.getResults
    }
  })], 1)])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header"
  }, [_c("p", [_vm._v("Search Related Activities:")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent(
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */,
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options =
    typeof scriptExports === 'function' ? scriptExports.options : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) {
    // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
          injectStyles.call(
            this,
            (options.functional ? this.parent : this).$root.$options.shadowRoot
          )
        }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection(h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing ? [].concat(existing, hook) : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/js/components/Project/Activities.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/Project/Activities.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Activities.vue?vue&type=template&id=1793b4ee& */ "./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&");
/* harmony import */ var _Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Activities.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Activities.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Project/Activities.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Activities.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Activities.vue?vue&type=template&id=1793b4ee& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);