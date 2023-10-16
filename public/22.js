(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[22],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FeatureDropdown.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/FeatureDropdown.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['featurePop'],
  data: function data() {
    return {};
  },
  methods: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Edit__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Edit */ "./resources/js/components/Profile/Edit.vue");
/* harmony import */ var _Avatar__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Avatar */ "./resources/js/components/Profile/Avatar.vue");
/* harmony import */ var _ProjectInvitation_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ProjectInvitation.vue */ "./resources/js/components/Profile/ProjectInvitation.vue");
/* harmony import */ var _FeatureDropdown_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../FeatureDropdown.vue */ "./resources/js/components/FeatureDropdown.vue");
/* harmony import */ var _auth__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../auth */ "./resources/js/auth.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }






/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    EditProfile: _Edit__WEBPACK_IMPORTED_MODULE_0__["default"],
    UserAvatar: _Avatar__WEBPACK_IMPORTED_MODULE_1__["default"],
    ProjectInvitation: _ProjectInvitation_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    FeatureDropdown: _FeatureDropdown_vue__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  data: function data() {
    return {
      auth: this.$store.state.currentUser.user.id,
      owner: false,
      featurePop: false
    };
  },
  watch: {
    userPop: function userPop(featurePop) {
      var _this = this;
      document.addEventListener('click', function (event) {
        return _this.$options.methods.handleClickOutside.call(_this, event, '.feature-dropdown', _this.featurePop);
      });
    }
  },
  created: function created() {
    this.loadUser();
  },
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_5__["mapMutations"])('profile', ['updateUser', 'updateUserAvatar', 'updateInvitations'])), {}, {
    loadUser: function loadUser() {
      var _this2 = this;
      axios.get('/api/v1/users/' + this.$route.params.id).then(function (response) {
        var user = response.data.user;
        _this2.updateUser(user);
        _this2.updateUserAvatar(user.avatar);
        _this2.updateInvitations(user.invited_projects);
        _this2.owner = _this2.user.id === _this2.auth;
      })["catch"](function (error) {
        console.log(error.response.data.errors);
      });
    },
    deleteAvatar: function deleteAvatar() {
      var _this3 = this;
      this.sweetAlert('Yes, delete it!').then(function (result) {
        if (result.value) {
          _this3.$vToastify.loader("Please Wait Removing Avatar");
          axios.patch('/api/v1/users/' + _this3.user.id + '/avatar_remove').then(function (response) {
            _this3.$vToastify.info(response.data.message);
            _this3.user.avatar = null;
            _this3.userAvatar = null;
          })["catch"](function (error) {
            swal.fire("Failed!", "There was something wrong.", "warning");
          })["finally"](function () {
            _this3.$vToastify.stopLoader();
          });
        }
      });
    },
    deleteProfile: function deleteProfile() {
      var _this4 = this;
      this.sweetAlert('Yes, delete it!').then(function (result) {
        if (result.value) {
          axios["delete"]('/api/v1/users/' + _this4.user.id).then(function (response) {
            _this4.$vToastify.success(response.data.message);
            _this4.$store.dispatch('currentUser/deleteUser');
          })["catch"](function (error) {
            swal.fire("Failed!", "There was something wrong.", "warning");
          });
        }
      });
    }
  }),
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_5__["mapState"])('profile', ['user', 'userAvatar', 'invitations']))
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************/
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
  props: ['projects'],
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('profile', ['updateInvitations'])), {}, {
    becomeMember: function becomeMember(slug) {
      var _this = this;
      axios.get('/api/v1/projects/' + slug + '/accept-invitation', {}).then(function (response) {
        _this.$vToastify.success(response.data.message);
        _this.updateInvitations(response.data.project.id);
      })["catch"](function (error) {
        console.log(error);
        _this.$vToastify.warning("Error! Try Again");
      });
    },
    rejectInvitation: function rejectInvitation(slug) {
      var _this2 = this;
      axios.get('/api/v1/projects/' + slug + '/ignore', {}).then(function (response) {
        _this2.$vToastify.info(response.data.message);
        _this2.updateInvitations(response.data.project.id);
      })["catch"](function (error) {
        _this2.$vToastify.warning("Error! Try Again");
      });
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FeatureDropdown.vue?vue&type=template&id=2cf7ee0c&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/FeatureDropdown.vue?vue&type=template&id=2cf7ee0c& ***!
  \************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("span", {
    staticClass: "feature-dropdown",
    on: {
      click: function click($event) {
        _vm.featurePop = !_vm.featurePop;
      }
    }
  }, [_vm._m(0), _vm._v(" "), _c("span", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.featurePop,
      expression: "featurePop"
    }],
    staticClass: "feature-dropdown_item"
  }, [_vm._t("default")], 2)]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("span", {
    staticClass: "btn btn-light btn-sm"
  }, [_c("i", {
    staticClass: "fas fa-ellipsis-v"
  })]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92& ***!
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
  }, [_c("span", [_c("span", {
    staticClass: "page-top_heading"
  }, [_vm._v("Profile ")]), _vm._v(" "), _c("span", {
    staticClass: "page-top_arrow"
  }, [_vm._v(" > ")]), _vm._v(" "), _c("span", [_vm._v(" " + _vm._s(_vm.user.name))])]), _vm._v(" "), _vm.owner ? _c("div", {
    staticClass: "float-right"
  }, [_c("button", {
    staticClass: "btn btn-primary btn-sm",
    on: {
      click: function click($event) {
        return _vm.$modal.show("edit-profile");
      }
    }
  }, [_vm._v("Edit Profile\n    ")]), _vm._v(" "), _c("FeatureDropdown", {
    attrs: {
      featurePop: this.featurePop
    }
  }, [_vm.owner ? _c("ul", [_vm.user.avatar ? _c("li", {
    staticClass: "feature-dropdown_item-content",
    on: {
      click: _vm.deleteAvatar
    }
  }, [_c("i", {
    staticClass: "far fa-user-circle"
  }), _vm._v(" Remove Avatar")]) : _vm._e(), _vm._v(" "), _c("li", {
    staticClass: "feature-dropdown_item-content",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.deleteProfile();
      }
    }
  }, [_c("i", {
    staticClass: "far fa-trash-alt"
  }), _vm._v("Delete Profile")])]) : _vm._e()])], 1) : _vm._e()]), _vm._v(" "), _c("EditProfile", {
    attrs: {
      user: _vm.user
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "page-content"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("UserAvatar", {
    attrs: {
      userId: _vm.user.id,
      avatar: _vm.userAvatar,
      name: _vm.user.name
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "col-md-10"
  }, [_c("div", {
    staticClass: "content"
  }, [_c("p", {
    staticClass: "content-name"
  }, [_vm._v(_vm._s(_vm.user.name))]), _vm._v(" "), _vm.user.info ? _c("p", {
    staticClass: "content-info"
  }, [_vm.user.info.company || _vm.user.info.position ? [_vm.user.info.company ? _c("span", [_vm._v(_vm._s(_vm.user.info.company))]) : _vm._e(), _vm._v(" "), _vm.user.info.company && _vm.user.info.position ? _c("span", {
    staticClass: "content-dot"
  }) : _vm._e(), _vm._v(" "), _vm.user.info.position ? _c("span", [_vm._v(_vm._s(_vm.user.info.position))]) : _vm._e()] : _c("span", [_vm._v("Not Defined")])], 2) : _vm._e()])])], 1), _vm._v(" "), _c("hr"), _vm._v(" "), _c("p", {
    staticClass: "pro-info"
  }, [_vm._v("Profile Detail")]), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Email")]), _vm._v(": \n        "), _c("span", [_vm._v(" " + _vm._s(_vm.user.email) + " ")])]), _vm._v(" "), _vm.user.info ? _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Mobile")]), _vm._v(":"), _c("span", [_vm._v("\n       " + _vm._s(_vm.user.info.mobile ? _vm.user.info.mobile : "Not Defined"))])]) : _vm._e(), _vm._v(" "), _vm.user.info ? _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Address")]), _vm._v(":"), _c("span", [_vm._v("\n        " + _vm._s(_vm.user.info.address ? _vm.user.info.address : "Not Defined"))])]) : _vm._e(), _vm._v(" "), _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Created At")]), _vm._v(": "), _c("span", [_vm._v(" " + _vm._s(_vm.user.created_at) + " ")])]), _vm._v(" "), _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Updated At")]), _vm._v(": "), _c("span", [_vm._v(" " + _vm._s(_vm.user.updated_at) + " ")])]), _vm._v(" "), _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Last Seen")]), _vm._v(": "), _c("span", [_vm._v(" " + _vm._s(_vm.user.updated_at) + " ")])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_vm.user.info ? _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Bio")]), _vm._v(":"), _c("span", [_vm._v(_vm._s(_vm.user.info.bio ? _vm.user.info.bio : "Donec in odio eget risus placerat molestie. Etiam augue turpis, tristique nec accumsan a, vehicula vitae quam. Sed imperdiet vulputate mi in molestie. Sed lacus quam, suscipit ut velit et, commodo sagittis leo."))])]) : _vm._e()])]), _vm._v(" "), _c("hr"), _vm._v(" "), _vm.owner ? _c("div", [_c("ProjectInvitation", {
    attrs: {
      projects: _vm.invitations
    }
  })], 1) : _vm._e()])], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1& ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("p", {
    staticClass: "pro-info"
  }, [_vm._v("Project Invitations")]), _vm._v(" "), this.projects ? _c("div", {
    staticClass: "row"
  }, _vm._l(this.projects, function (project) {
    return _c("div", {
      staticClass: "col-md-5"
    }, [_c("div", {
      staticClass: "card invitation border-secondary"
    }, [_c("div", {
      staticClass: "card-header text-center"
    }, [_vm._v("\n        Project Name: \n        "), _c("router-link", {
      attrs: {
        to: "/projects/" + project.slug
      }
    }, [_vm._v(_vm._s(project.name))])], 1), _vm._v(" "), _c("div", {
      staticClass: "card-body mt-1 text-center"
    }, [_c("p", [_vm._v("Owner Name: \n    "), _c("router-link", {
      attrs: {
        to: "/user/" + project.user.id + "/profile",
        target: "_blank"
      }
    }, [_vm._v(_vm._s(project.user.name))])], 1), _vm._v(" "), _c("p", {
      staticClass: "text-center"
    }, [_c("button", {
      staticClass: "btn btn-primary btn-sm",
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.becomeMember(project.slug);
        }
      }
    }, [_vm._v("Become Member")]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-danger btn-sm",
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.rejectInvitation(project.slug);
        }
      }
    }, [_vm._v("Ignore Invitation")])])]), _vm._v(" "), _c("div", {
      staticClass: "card-footer"
    }, [_c("p", [_vm._v(" 📨\n    Invitation Received On:: "), _c("b", [_vm._v(_vm._s(project.invitation_sent_at))])])])])]);
  }), 0) : _c("div", [_c("h3", [_vm._v("No project Invitation found")])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/auth.js":
/*!******************************!*\
  !*** ./resources/js/auth.js ***!
  \******************************/
/*! exports provided: permission */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "permission", function() { return permission; });
function permission(auth, members, user) {
  var access = false;
  var owner = false;
  var member = members && members.find(function (member) {
    return member.id === auth;
  });
  if (member || user === auth) {
    access = true;
  }
  if (user === auth) {
    owner = true;
  }
  return {
    access: access,
    owner: owner
  };
}

/***/ }),

/***/ "./resources/js/components/FeatureDropdown.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/FeatureDropdown.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _FeatureDropdown_vue_vue_type_template_id_2cf7ee0c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FeatureDropdown.vue?vue&type=template&id=2cf7ee0c& */ "./resources/js/components/FeatureDropdown.vue?vue&type=template&id=2cf7ee0c&");
/* harmony import */ var _FeatureDropdown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FeatureDropdown.vue?vue&type=script&lang=js& */ "./resources/js/components/FeatureDropdown.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _FeatureDropdown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FeatureDropdown_vue_vue_type_template_id_2cf7ee0c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _FeatureDropdown_vue_vue_type_template_id_2cf7ee0c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/FeatureDropdown.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/FeatureDropdown.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/FeatureDropdown.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureDropdown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./FeatureDropdown.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FeatureDropdown.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureDropdown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/FeatureDropdown.vue?vue&type=template&id=2cf7ee0c&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/FeatureDropdown.vue?vue&type=template&id=2cf7ee0c& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureDropdown_vue_vue_type_template_id_2cf7ee0c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./FeatureDropdown.vue?vue&type=template&id=2cf7ee0c& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FeatureDropdown.vue?vue&type=template&id=2cf7ee0c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureDropdown_vue_vue_type_template_id_2cf7ee0c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureDropdown_vue_vue_type_template_id_2cf7ee0c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Profile/ProfilePage.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/Profile/ProfilePage.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProfilePage.vue?vue&type=template&id=150abd92& */ "./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92&");
/* harmony import */ var _ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProfilePage.vue?vue&type=script&lang=js& */ "./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Profile/ProfilePage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProfilePage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProfilePage.vue?vue&type=template&id=150abd92& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Profile/ProjectInvitation.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/Profile/ProjectInvitation.vue ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProjectInvitation.vue?vue&type=template&id=485fb2b1& */ "./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1&");
/* harmony import */ var _ProjectInvitation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProjectInvitation.vue?vue&type=script&lang=js& */ "./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProjectInvitation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Profile/ProjectInvitation.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProjectInvitation.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProjectInvitation.vue?vue&type=template&id=485fb2b1& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);