(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[11],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Navbar.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }

/* harmony default export */ __webpack_exports__["default"] = ({
  computed: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])('currentUser', ['user'])), Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])('subscribeUser', ['subscription'])), {}, {
    loggedIn: function loggedIn() {
      return this.$store.state.currentUser.loggedIn;
    },
    showAlertNotice: function showAlertNotice() {
      return this.loggedIn && this.subscriptionLoaded && !this.subscription.subscribed;
    },
    subscriptionLoaded: function subscriptionLoaded() {
      return Object.keys(this.subscription).length !== 0;
    }
  }),
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])('subscribeUser', ['userLogout'])), {}, {
    signOut: function signOut() {
      this.$store.dispatch('currentUser/logoutUser');
      this.userLogout();
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
  }, [_vm._m(0), _vm._v(" "), _vm.loggedIn ? _c("div", [_c("router-link", {
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
      to: "/user/".concat(this.user.id, "/profile")
    }
  }, [_c("p", [_c("span", {
    staticClass: "icon"
  }, [_c("i", {
    staticClass: "icon-logo fas fa-user-circle"
  }), _vm._v(" "), _c("span", {
    staticClass: "icon-name"
  }, [_vm._v("Profile")])])])]), _vm._v(" "), _c("router-link", {
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
  }, [_vm._v("Subsctiption")])])])]), _vm._v(" "), _c("router-link", {
    staticClass: "panel-list_item",
    attrs: {
      to: "/admin/panel"
    }
  }, [_c("p", [_c("span", {
    staticClass: "icon"
  }, [_c("i", {
    staticClass: "icon-logo fas fa-user-lock"
  }), _vm._v(" "), _c("span", {
    staticClass: "icon-name"
  }, [_vm._v("Admin Panel")])])])]), _vm._v(" "), _c("a", {
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
  }) : _vm._e()], 1)])], 1), _vm._v(" "), _vm.loggedIn && _vm.showAlertNotice ? _c("div", {
    staticClass: "alert alert-dark mt-2",
    attrs: {
      role: "alert"
    }
  }, [_c("b", [_vm._v("  Upgrade your experience now!\n        "), _c("router-link", {
    attrs: {
      to: "/subscriptions"
    }
  }, [_c("span", [_vm._v("Subscribe")])]), _vm._v(" now to unlock all features. ")], 1)]) : _vm._e(), _vm._v(" "), _c("router-view")], 1)])]);
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
/* harmony import */ var _Navbar_vue_vue_type_template_id_6dde423b__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navbar.vue?vue&type=template&id=6dde423b */ "./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b");
/* harmony import */ var _Navbar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Navbar.vue?vue&type=script&lang=js */ "./resources/js/components/Navbar.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Navbar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Navbar_vue_vue_type_template_id_6dde423b__WEBPACK_IMPORTED_MODULE_0__["render"],
  _Navbar_vue_vue_type_template_id_6dde423b__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/Navbar.vue?vue&type=script&lang=js":
/*!********************************************************************!*\
  !*** ./resources/js/components/Navbar.vue?vue&type=script&lang=js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Navbar.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b":
/*!**************************************************************************!*\
  !*** ./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_6dde423b__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./Navbar.vue?vue&type=template&id=6dde423b */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Navbar.vue?vue&type=template&id=6dde423b");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_6dde423b__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Navbar_vue_vue_type_template_id_6dde423b__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);