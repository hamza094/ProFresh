(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[28],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['slug', 'notes', 'members', 'owner', 'access', 'ownerLogin'],
  watch: {
    query: function query(after, before) {
      this.searchUsers();
    }
  },
  data: function data() {
    return {
      form: {
        notes: ""
      },
      query: null,
      results: [],
      errors: {}
    };
  },
  methods: {
    ProjectNote: function ProjectNote() {
      var _this = this;
      axios.patch('/api/v1/projects/' + this.slug, {
        notes: this.form.notes
      }).then(function (response) {
        _this.$bus.emit('Panel', {
          notes: response.data.notes
        });
        _this.$vToastify.success("Notes Updated");
        _this.$bus.emit('score', {
          score: response.data.score
        });
        console.log(response.data.score);
      })["catch"](function (error) {
        if (error.response.data.errors && error.response.data.errors.notes[0]) {
          _this.$vToastify.warning(error.response.data.errors.notes[0]);
        }
        if (error.response.data.error) {
          _this.$vToastify.warning(error.response.data.error);
        }
        _this.form.notes = _this.notes;
      });
    },
    searchUsers: function searchUsers() {
      var _this2 = this;
      axios.get('/api/v1/users/search', {
        params: {
          query: this.query
        }
      }).then(function (response) {
        return _this2.results = response.data;
      })["catch"](function (error) {
        _this2.$vToastify.warning(error.response.data.error);
      });
    },
    inviteUser: function inviteUser(user) {
      var _this3 = this;
      axios.post('/api/v1/projects/' + this.slug + '/invitations', {
        email: user
      }).then(function (response) {
        _this3.query = '';
        _this3.results = '';
        _this3.$vToastify.success(response.data.msg);
      })["catch"](function (error) {
        _this3.query = '';
        _this3.results = '';
        _this3.$vToastify.warning(error.response.data.error);
      });
    },
    removeMember: function removeMember(id, member) {
      var _this4 = this;
      var self = this;
      this.sweetAlert('Yes, Remove Member').then(function (result) {
        if (result.value) {
          axios.get('/api/v1/projects/' + _this4.slug + '/remove/' + id).then(function (response) {
            _this4.$bus.emit('removeMember', {
              members: response.data.members
            });
            self.$vToastify.info(response.data.msg);
          })["catch"](function (error) {
            swal.fire("Failed!", "There was  an errors", "warning");
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09&":
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09& ***!
  \*******************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "project-note"
  }, [_c("div", {
    attrs: {
      id: "wrapper"
    }
  }, [_vm._m(0), _vm._v(" "), _vm.access ? _c("form", {
    attrs: {
      id: "paper",
      method: "post"
    },
    on: {
      keyup: function keyup($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
        $event.preventDefault();
        return _vm.ProjectNote.apply(null, arguments);
      }
    }
  }, [_c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.notes,
      expression: "form.notes"
    }],
    attrs: {
      placeholder: "Write Project Notes",
      id: "text",
      name: "notes",
      rows: "4"
    },
    domProps: {
      value: _vm.form.notes,
      textContent: _vm._s(this.notes)
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "notes", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("br")]) : _vm._e(), _vm._v(" "), !_vm.access ? _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.notes,
      expression: "form.notes"
    }],
    attrs: {
      placeholder: "Only project members and owners are allowed to write project notes.",
      id: "text",
      rows: "4",
      readonly: ""
    },
    domProps: {
      value: _vm.form.notes,
      textContent: _vm._s(this.notes)
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "notes", $event.target.value);
      }
    }
  }) : _vm._e(), _vm._v(" "), _c("br")])]), _vm._v(" "), _c("hr"), _vm._v(" "), _vm.access ? _c("div", {
    staticClass: "invite"
  }, [_vm._m(1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.query,
      expression: "query"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "Search user for invitation"
    },
    domProps: {
      value: _vm.query
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.query = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "invite-list"
  }, [_vm.results.length > 0 && _vm.query ? _c("ul", _vm._l(_vm.results.slice(0, 5), function (result) {
    return _c("li", {
      key: result.id
    }, [_c("div", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.inviteUser(result.url);
        }
      }
    }, [_vm._v(_vm._s(result.title) + " (" + _vm._s(result.searchable.email) + ")")])]);
  }), 0) : _vm._e()])]) : _vm._e(), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "project_members"
  }, [_vm._m(2), _vm._v(" "), _c("div", {
    staticClass: "collapse",
    attrs: {
      id: "memberProject"
    }
  }, [_c("div", {
    staticClass: "row"
  }, _vm._l(_vm.members, function (member) {
    return _c("div", {
      key: member.user_id
    }, [_c("div", {
      staticClass: "project_members-detail"
    }, [_c("router-link", {
      attrs: {
        to: "/user/" + member.username + "/profile"
      }
    }, [_c("img", {
      attrs: {
        src: member.avatar_path,
        alt: ""
      }
    }), _vm._v(" "), _c("p", [member.id == _vm.owner.id ? _c("span", {
      staticClass: "badge badge-success"
    }, [_vm._v("project owner\n                    ")]) : _vm._e(), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", [_vm._v(_vm._s(member.name))]), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", [_vm._v("(" + _vm._s(member.username) + ")")])]), _vm._v(" "), _c("p")]), _vm._v(" "), _vm.ownerLogin && member.id !== _vm.owner.id ? _c("a", {
      attrs: {
        rel: "",
        role: "button"
      },
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.removeMember(member.pivot.user_id, member);
        }
      }
    }, [_vm._v("x")]) : _vm._e()], 1)]);
  }), 0)])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", [_c("b", [_vm._v("Add Project Note:")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", [_c("b", [_vm._v("Project Invitations:")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "task-top"
  }, [_c("p", [_c("b", [_vm._v("Project Members")]), _c("a", {
    attrs: {
      "data-toggle": "collapse",
      href: "#memberProject",
      role: "button",
      "aria-expanded": "false",
      "aria-controls": "memberProject"
    }
  }, [_c("i", {
    staticClass: "fas fa-angle-down float-right"
  })])])]);
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

/***/ "./resources/js/components/Project/Panel/Features.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Features.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Features.vue?vue&type=template&id=50c2fb09& */ "./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09&");
/* harmony import */ var _Features_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Features.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Features_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Features.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Features.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Features.vue?vue&type=template&id=50c2fb09& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);