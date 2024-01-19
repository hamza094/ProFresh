(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[13],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************/
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
  data: function data() {
    return {
      form: {
        role: '',
        permission: ''
      },
      permissions: []
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])('roles', ['roles'])),
  methods: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])({
    loadRoles: 'roles/loadRoles',
    addNewRole: 'roles/addNewRole'
  })), Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('roles', ['setRoles', 'addRole', 'roleDelete'])), {}, {
    addPermission: function addPermission() {
      var _this = this;
      axios.post('/api/v1/admin/permissions', {
        permission: this.form.permission
      }).then(function (response) {
        _this.$vToastify.success(response.data.message);
        _this.form.permission = "";
        _this.loadPermissions();
      })["catch"](function (error) {
        console.log(error);
      });
    },
    removePermission: function removePermission(permissionId) {
      var _this2 = this;
      axios["delete"]('/api/v1/admin/permissions/' + permissionId).then(function (response) {
        _this2.$vToastify.success("Permission Deleted Successfully");
        _this2.loadPermissions();
      })["catch"](function (error) {
        _this2.$vToastify.warning('Error! Contact Admin support');
      });
    },
    assignPermission: function assignPermission(permissionId, roleId) {
      var _this3 = this;
      axios.get('/api/v1/admin/assign/roles/' + roleId + '/permissions/' + permissionId).then(function (response) {
        _this3.$vToastify.success(response.data.message);
        _this3.loadPermissions();
      })["catch"](function (error) {
        console.log(error);
      });
    },
    unAssignPermission: function unAssignPermission(permissionId, roleId) {
      var _this4 = this;
      axios.get('/api/v1/admin/unAssign/roles/' + roleId + '/permissions/' + permissionId).then(function (response) {
        _this4.$vToastify.success(response.data.message);
        _this4.loadRoles();
      })["catch"](function (error) {
        console.log(error);
      });
    },
    assignUserRole: function assignUserRole(roleId, userId) {
      var _this5 = this;
      axios.get('/api/v1/admin/assign/users/' + userId + '/roles/' + roleId).then(function (response) {
        _this5.$vToastify.success(response.data.message);
        _this5.loadUsers();
      })["catch"](function (error) {
        console.log(error);
      });
    },
    loadPermissions: function loadPermissions() {
      var _this6 = this;
      axios.get('/api/v1/admin/permissions').then(function (response) {
        _this6.permissions = response.data;
      })["catch"](function (error) {
        _this6.$vToastify.warning('Error! Contact Admin support');
      });
    }
  }),
  mounted: function mounted() {
    this.loadRoles();
    this.loadPermissions();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=template&id=7e4372e2":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=template&id=7e4372e2 ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "row mt-3 mb-5"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-header"
  }, [_vm._v("\n               Roles\n             ")]), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_vm._v("\n               Add New Role\n               "), _c("div", {
    staticClass: "ms-2 d-inline-block"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.role,
      expression: "form.role"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      name: "role",
      autocomplete: "off"
    },
    domProps: {
      value: _vm.form.role
    },
    on: {
      keyup: function keyup($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
        return _vm.addRole();
      },
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "role", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mt-3"
  })])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-header"
  }, [_vm._v("\n               Permissions\n             ")]), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_vm._v("\n               Add New Permission\n               "), _c("div", {
    staticClass: "ms-2 d-inline-block"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.permission,
      expression: "form.permission"
    }],
    staticClass: "form-control form-control-sm",
    attrs: {
      type: "text",
      name: "role",
      autocomplete: "off"
    },
    domProps: {
      value: _vm.form.permission
    },
    on: {
      keyup: function keyup($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
        return _vm.addPermission();
      },
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "permission", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "mt-3"
  }, _vm._l(_vm.permissions, function (permission) {
    return _c("div", {
      key: permission.id
    }, [_c("p"), _c("div", {
      staticClass: "dropdown"
    }, [_vm._v("\n                         " + _vm._s(permission.name) + " "), _c("a", {
      staticClass: "dropdown-toggle text-secondary",
      attrs: {
        href: "#",
        "data-bs-toggle": "dropdown",
        "aria-haspopup": "true",
        "aria-expanded": "false"
      }
    }, [_vm._v("Assign to role\n                          ")]), _vm._v(" "), _c("div", {
      staticClass: "dropdown-menu dropdown-menu-end"
    }, _vm._l(_vm.roles, function (role) {
      return _c("div", {
        key: role.id
      }, [_c("a", {
        "class": {
          "dropdown-item": true,
          active: _vm.user && _vm.user.roles && _vm.hasRole(_vm.user.roles, role)
        },
        on: {
          click: function click($event) {
            return _vm.assignUserRole(role.id, _vm.user.id);
          }
        }
      }, [_vm._v("\n                " + _vm._s(role.name) + "\n            ")])]);
    }), 0), _vm._v(" "), _c("span", {
      staticClass: "float-right"
    }, [_c("span", [_c("button", {
      staticClass: "btn btn-sm btn-danger",
      on: {
        click: function click($event) {
          return _vm.removePermission(permission.id);
        }
      }
    }, [_vm._v("Delete")])])])]), _vm._v(" "), _c("p")]);
  }), 0)])])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Admin/RolesAndPermissions.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/Admin/RolesAndPermissions.vue ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _RolesAndPermissions_vue_vue_type_template_id_7e4372e2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./RolesAndPermissions.vue?vue&type=template&id=7e4372e2 */ "./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=template&id=7e4372e2");
/* harmony import */ var _RolesAndPermissions_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./RolesAndPermissions.vue?vue&type=script&lang=js */ "./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _RolesAndPermissions_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _RolesAndPermissions_vue_vue_type_template_id_7e4372e2__WEBPACK_IMPORTED_MODULE_0__["render"],
  _RolesAndPermissions_vue_vue_type_template_id_7e4372e2__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Admin/RolesAndPermissions.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=script&lang=js":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=script&lang=js ***!
  \***************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RolesAndPermissions_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./RolesAndPermissions.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RolesAndPermissions_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=template&id=7e4372e2":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=template&id=7e4372e2 ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_RolesAndPermissions_vue_vue_type_template_id_7e4372e2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./RolesAndPermissions.vue?vue&type=template&id=7e4372e2 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Admin/RolesAndPermissions.vue?vue&type=template&id=7e4372e2");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_RolesAndPermissions_vue_vue_type_template_id_7e4372e2__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_RolesAndPermissions_vue_vue_type_template_id_7e4372e2__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);