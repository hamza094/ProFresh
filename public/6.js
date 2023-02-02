(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[6],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/Edit.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/Edit.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['user'],
  data: function data() {
    return {
      owner: this.user,
      errors: {},
      form: {
        name: this.user.name,
        email: this.user.email,
        company: this.user.company,
        mobile: this.user.mobile,
        position: this.user.position,
        address: this.user.address,
        password: this.user.password,
        bio: this.user.bio
      }
    };
  },
  methods: {
    modalClose: function modalClose() {
      this.$modal.hide('edit-profile');
      this.errors = '';
    },
    updateProfile: function updateProfile() {
      var _this = this;
      axios.patch('/api/profile/user/' + this.user.id, {
        name: this.form.name,
        email: this.form.email,
        company: this.form.company,
        mobile: this.form.mobile,
        bio: this.form.bio,
        address: this.form.address,
        position: this.form.position,
        password: this.form.password
      }).then(function (response) {
        _this.$vToastify.success("Profile Updated Successfully");
        _this.user.name = _this.form.name;
        _this.user.email = _this.form.email;
        _this.user.company = _this.form.company;
        _this.user.mobile = _this.form.mobile;
        _this.user.bio = _this.form.bio;
        _this.user.address = _this.form.address;
        _this.user.position = _this.form.position;
        _this.$modal.hide('edit-profile');
      })["catch"](function (error) {
        console.log(error.response.data.errors);
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/Edit.vue?vue&type=template&id=0aead6bb&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/Edit.vue?vue&type=template&id=0aead6bb& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("modal", {
    staticClass: "model-desin",
    attrs: {
      name: "edit-profile",
      height: "auto",
      scrollable: true,
      shiftX: 0.98,
      width: "38%",
      clickToClose: false
    }
  }, [_c("div", {
    staticClass: "edit-border-top p-3 animate__animated animate__slideInRight"
  }, [_c("div", {
    staticClass: "edit-border-bottom"
  }, [_c("div", {
    staticClass: "panel-top_content"
  }, [_c("span", {
    staticClass: "panel-heading"
  }, [_vm._v("Edit Profile " + _vm._s(_vm.user.name))]), _vm._v(" "), _c("span", {
    staticClass: "panel-exit float-right",
    attrs: {
      role: "button"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.modalClose.apply(null, arguments);
      }
    }
  }, [_vm._v("x")])])]), _vm._v(" "), _c("div", {
    staticClass: "panel-form"
  }, [_c("form", {
    attrs: {
      action: ""
    },
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.updateProfile.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "panel-top_content"
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "lastname"
    }
  }, [_vm._v("Name:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.name,
      expression: "form.name"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "lastname",
      name: "name"
    },
    domProps: {
      value: _vm.form.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.name ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.name[0])
    }
  }) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "email"
    }
  }, [_vm._v("Email:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.email,
      expression: "form.email"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "email",
      name: "email"
    },
    domProps: {
      value: _vm.form.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "email", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.email ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.email[0])
    }
  }) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "company"
    }
  }, [_vm._v("Company:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.company,
      expression: "form.company"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "company",
      name: "company"
    },
    domProps: {
      value: _vm.form.company
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "company", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.company ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.company[0])
    }
  }) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "mobile"
    }
  }, [_vm._v("Mobile:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.mobile,
      expression: "form.mobile"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "mobile",
      name: "mobile"
    },
    domProps: {
      value: _vm.form.mobile
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "mobile", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.mobile ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.mobile[0])
    }
  }) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "position"
    }
  }, [_vm._v("Position:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.position,
      expression: "form.position"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "position"
    },
    domProps: {
      value: _vm.form.position
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "position", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.position ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.position[0])
    }
  }) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "address"
    }
  }, [_vm._v("Address:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.address,
      expression: "form.address"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "address"
    },
    domProps: {
      value: _vm.form.address
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "address", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.address ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.address[0])
    }
  }) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "status"
    }
  }, [_vm._v("Password:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.password,
      expression: "form.password"
    }],
    staticClass: "form-control",
    attrs: {
      type: "password",
      id: "password",
      name: "password"
    },
    domProps: {
      value: _vm.form.password
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "password", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.password ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.password[0])
    }
  }) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "bio"
    }
  }, [_vm._v("Your Bio:")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.bio,
      expression: "form.bio"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "bio",
      name: "bio"
    },
    domProps: {
      value: _vm.form.bio
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "bio", $event.target.value);
      }
    }
  }, [_vm._v(_vm._s(_vm.user.bio))]), _vm._v(" "), _vm.errors.bio ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.bio[0])
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "panel-bottom"
  }, [_c("div", {
    staticClass: "panel-top_content float-right"
  }, [_c("button", {
    staticClass: "btn panel-btn_close",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.modalClose.apply(null, arguments);
      }
    }
  }, [_vm._v("Cancel")]), _vm._v(" "), _c("button", {
    staticClass: "btn panel-btn_save"
  }, [_vm._v("Update")])])])])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Profile/Edit.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/Profile/Edit.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Edit_vue_vue_type_template_id_0aead6bb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Edit.vue?vue&type=template&id=0aead6bb& */ "./resources/js/components/Profile/Edit.vue?vue&type=template&id=0aead6bb&");
/* harmony import */ var _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Edit.vue?vue&type=script&lang=js& */ "./resources/js/components/Profile/Edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Edit_vue_vue_type_template_id_0aead6bb___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Edit_vue_vue_type_template_id_0aead6bb___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Profile/Edit.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Profile/Edit.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Profile/Edit.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Edit.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/Edit.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Profile/Edit.vue?vue&type=template&id=0aead6bb&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Profile/Edit.vue?vue&type=template&id=0aead6bb& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_0aead6bb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Edit.vue?vue&type=template&id=0aead6bb& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/Edit.vue?vue&type=template&id=0aead6bb&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_0aead6bb___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_0aead6bb___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);