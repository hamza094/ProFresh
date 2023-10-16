(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[17],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _SubscriptionChecker_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../SubscriptionChecker.vue */ "./resources/js/components/SubscriptionChecker.vue");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    SubscriptionCheck: _SubscriptionChecker_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
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
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('project', ['noteScore', 'updateScore', 'detachMember'])), {}, {
    ProjectNote: function ProjectNote() {
      var _this = this;
      axios.patch('/api/v1/projects/' + this.slug, {
        notes: this.form.notes
      }).then(function (response) {
        _this.updateNotes(response.data.notes);
        _this.$vToastify.success("Notes Updated");
        _this.noteScore(response.data.score);
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
        _this3.$vToastify.success(response.data.message);
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
            _this4.detachMember(memberId);
            self.$vToastify.info(response.data.message);
          })["catch"](function (error) {
            swal.fire("Failed!", "There was  an errors", "warning");
          });
        }
      });
    }
  })
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
  }, [_vm._m(0), _vm._v(" "), _c("SubscriptionCheck", [_vm.access ? _c("form", {
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
  }) : _vm._e()]), _vm._v(" "), _c("br")], 1)]), _vm._v(" "), _c("hr"), _vm._v(" "), _vm.access ? _c("div", {
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
      key: member.id
    }, [_c("div", {
      staticClass: "project_members-detail"
    }, [_c("router-link", {
      attrs: {
        to: "/user/" + member.id + "/profile"
      }
    }, [member.avatar ? _c("img", {
      attrs: {
        src: member.avatar,
        alt: ""
      }
    }) : _vm._e(), _vm._v(" "), _c("p", [member.id == _vm.owner.id ? _c("span", {
      staticClass: "badge badge-success"
    }, [_vm._v("project owner\n                    ")]) : _vm._e(), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", [_vm._v(_vm._s(member.name))]), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", [_vm._v("(" + _vm._s(member.username) + ")")])]), _vm._v(" "), _c("p")]), _vm._v(" "), _vm.ownerLogin && member.id !== _vm.owner.id ? _c("a", {
      attrs: {
        rel: "",
        role: "button"
      },
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.removeMember(member.id, member);
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