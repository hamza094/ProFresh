(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Navbar.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  computed: {
    loggedIn: {
      get: function get() {
        return this.$store.state.currentUser.loggedIn;
      }
    }
  },
  methods: {
    signOut: function signOut() {
      this.$store.dispatch('currentUser/logoutUser');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "container-fluid"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-1 panel-left"
  }, [_c("div", {
    staticClass: "panel"
  }, [_vm._m(0), _vm._v(" "), _vm.loggedIn === true ? _c("div", [_c("router-link", {
    staticClass: "panel-list_item",
    attrs: {
      to: "/dashboard"
    }
  }, [_c("p", [_c("span", {
    staticClass: "icon"
  }, [_c("i", {
    staticClass: "icon-logo far fa-calendar"
  }), _vm._v(" "), _c("span", {
    staticClass: "icon-name"
  }, [_vm._v("Dashboard")])])])]), _vm._v(" "), _c("router-link", {
    staticClass: "panel-list_item",
    attrs: {
      to: "/projects"
    }
  }, [_c("p", [_c("span", {
    staticClass: "icon"
  }, [_c("i", {
    staticClass: "icon-logo fab fa-product-hunt"
  }), _vm._v(" "), _c("span", {
    staticClass: "icon-name"
  }, [_vm._v("Projects")])])])]), _vm._v(" "), _c("project-button"), _vm._v(" "), _c("router-link", {
    staticClass: "panel-list_item",
    attrs: {
      to: "/subscriptions"
    }
  }, [_c("p", [_c("span", {
    staticClass: "icon"
  }, [_c("i", {
    staticClass: "icon-logo far fa-credit-card"
  }), _vm._v(" "), _c("span", {
    staticClass: "icon-name"
  }, [_vm._v("Subsctiption")])])])]), _vm._v(" "), _c("a", {
    staticClass: "panel-list_item",
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.signOut();
      }
    }
  }, [_vm._m(1)])], 1) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-11 panel-right"
  }, [_c("nav", {
    staticClass: "navbar navbar-expand-md navbar-light bg-white"
  }, [_c("router-link", {
    staticClass: "navbar-brand",
    attrs: {
      to: "/home"
    }
  }, [_c("b", [_vm._v("Profresh")])]), _vm._v(" "), _vm._m(2), _vm._v(" "), _c("div", {
    staticClass: "collapse navbar-collapse",
    attrs: {
      id: "navbarSupportedContent"
    }
  }, [_c("ul", {
    staticClass: "navbar-nav mr-auto"
  }), _vm._v(" "), _c("ul", {
    staticClass: "navbar-nav ml-auto"
  }, [!_vm.loggedIn ? _c("li", {
    staticClass: "nav-item"
  }, [_c("router-link", {
    staticClass: "nav-link",
    attrs: {
      to: "/login"
    }
  }, [_vm._v("Sign In")])], 1) : _vm._e(), _vm._v(" "), !_vm.loggedIn ? _c("li", {
    staticClass: "nav-item"
  }, [_c("router-link", {
    staticClass: "nav-link",
    attrs: {
      to: "/register"
    }
  }, [_vm._v("Sign Up")])], 1) : _vm._e(), _vm._v(" "), _vm.loggedIn ? _c("notifications", {
    staticClass: "mr-3"
  }) : _vm._e()], 1)])], 1), _vm._v(" "), _c("router-view")], 1)])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("a", {
    attrs: {
      href: "/"
    }
  }, [_c("img", {
    staticClass: "main-img",
    attrs: {
      src: "/img/profresh.png",
      alt: ""
    }
  })]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", [_c("span", {
    staticClass: "icon"
  }, [_c("i", {
    staticClass: "icon-logo fas fa-sign-out-alt"
  }), _c("span", {
    staticClass: "icon-name"
  }, [_vm._v("Logout")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("button", {
    staticClass: "navbar-toggler",
    attrs: {
      type: "button",
      "data-toggle": "collapse",
      "data-target": "#navbarSupportedContent",
      "aria-controls": "navbarSupportedContent",
      "aria-expanded": "false",
      "aria-label": "Toggle navigation"
    }
  }, [_c("span", {
    staticClass: "navbar-toggler-icon"
  })]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Navbar.vue":
/*!********************************************!*\
  !*** ./resources/js/components/Navbar.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navbar.vue?vue&type=template&id=6dde423b& */ "./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b&");
/* harmony import */ var _Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Navbar.vue?vue&type=script&lang=js& */ "./resources/js/components/Navbar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Navbar.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Navbar.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./resources/js/components/Navbar.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Navbar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./Navbar.vue?vue&type=template&id=6dde423b& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_6dde423b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);