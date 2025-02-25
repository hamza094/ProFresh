(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[18],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _SubscriptionChecker_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../SubscriptionChecker.vue */ "./resources/js/components/SubscriptionChecker.vue");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_2__);
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }



/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    SubscriptionCheck: _SubscriptionChecker_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  props: ['slug', 'notes', 'members', 'owner', 'access', 'ownerLogin'],
  data: function data() {
    return {
      form: {
        notes: ""
      },
      query: null,
      isLoading: false,
      results: [],
      errors: {},
      pendingMembers: []
    };
  },
  watch: {
    'query': Object(lodash__WEBPACK_IMPORTED_MODULE_2__["debounce"])(function (newQuery) {
      this.searchUsers(newQuery);
    }, 500)
  },
  created: function created() {
    this.loadPendingRequests();
  },
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('project', ['updateNotes', 'noteScore', 'updateScore', 'detachMember'])), {}, {
    ProjectNote: function ProjectNote() {
      var _this = this;
      this.$Progress.start();
      document.getElementById('text').blur();
      axios.patch('/api/v1/projects/' + this.slug, {
        notes: this.form.notes
      }).then(function (_ref) {
        var data = _ref.data;
        var project = data.project,
          message = data.message;
        _this.$Progress.finish();
        _this.updateNotes(project.notes);
        _this.$vToastify.success(message);
        _this.noteScore(project.score);
      })["catch"](function (error) {
        _this.$Progress.fail();
        var dataErrors = error.response.data.errors;
        if (dataErrors && dataErrors.notes[0]) {
          _this.$vToastify.warning(dataErrors.notes[0]);
        }
        if (error.response.data.error) {
          _this.$vToastify.warning(error.response.data.error);
        }
        _this.form.notes = _this.notes;
      })["finally"](function () {
        document.getElementById('focus-target').focus();
      });
    },
    searchUsers: function searchUsers(query) {
      var _this2 = this;
      if (!this.query) {
        this.results = [];
        return;
      }
      this.isLoading = true;
      axios.get('/api/v1/users/search', {
        params: {
          query: this.query
        }
      }).then(function (response) {
        _this2.results = response.data;
      })["catch"](function (error) {
        _this2.$vToastify.warning(error.response.data.error);
      })["finally"](function () {
        _this2.isLoading = false;
      });
    },
    inviteUser: function inviteUser(userEmail) {
      var _this3 = this;
      axios.post('/api/v1/projects/' + this.slug + '/invitations', {
        email: userEmail
      }, {
        useProgress: true
      }).then(function (response) {
        _this3.query = '';
        _this3.results = '';
        _this3.$vToastify.success(response.data.message);
      })["catch"](function (error) {
        var _error$response, _error$response2;
        _this3.query = '';
        _this3.results = '';
        var errors = (_error$response = error.response) === null || _error$response === void 0 || (_error$response = _error$response.data) === null || _error$response === void 0 ? void 0 : _error$response.errors;
        if (((_error$response2 = error.response) === null || _error$response2 === void 0 ? void 0 : _error$response2.status) === 422 && errors) {
          Object.values(errors).flat().forEach(function (message) {
            _this3.$vToastify.warning(message);
          });
        } else {
          var _error$response3;
          _this3.$vToastify.warning(((_error$response3 = error.response) === null || _error$response3 === void 0 || (_error$response3 = _error$response3.data) === null || _error$response3 === void 0 ? void 0 : _error$response3.error) || "An unexpected error occurred.");
        }
      });
    },
    removeMember: function removeMember(id, member) {
      var _this4 = this;
      var self = this;
      this.sweetAlert('Yes, Remove Member').then(function (result) {
        if (result.value) {
          axios.get('/api/v1/projects/' + _this4.slug + '/remove/member/' + id, {
            useProgress: true
          }).then(function (response) {
            _this4.detachMember(response.data.user.uuid);
            self.$vToastify.info(response.data.message);
          })["catch"](function (error) {
            var _error$response4;
            _this4.$vToastify.warning(((_error$response4 = error.response) === null || _error$response4 === void 0 || (_error$response4 = _error$response4.data) === null || _error$response4 === void 0 ? void 0 : _error$response4.error) || "Failed to remove the member. Try again.");
          });
        }
      });
    },
    cancelRequest: function cancelRequest(userId) {
      var _this5 = this;
      this.sweetAlert("Yes, cancel request").then(function (result) {
        if (!result.value) return;
        axios.get("/api/v1/projects/".concat(_this5.slug, "/cancel/invitation/users/").concat(userId), {
          useProgress: true
        }).then(function (response) {
          _this5.pendingMembers = _this5.pendingMembers.filter(function (pendingMember) {
            return pendingMember.uuid !== userId;
          });
          _this5.$vToastify.info(response.data.message);
        })["catch"](function (error) {
          var _error$response5;
          _this5.$vToastify.warning(((_error$response5 = error.response) === null || _error$response5 === void 0 || (_error$response5 = _error$response5.data) === null || _error$response5 === void 0 ? void 0 : _error$response5.message) || "Failed to cancel the request. Try again.");
        });
      });
    },
    loadPendingRequests: function loadPendingRequests() {
      var _this6 = this;
      axios.get("/api/v1/projects/".concat(this.slug, "/pending/invitations")).then(function (response) {
        _this6.pendingMembers = response.data.pending_invitations;
      })["catch"](function (error) {
        var _error$response6;
        _this6.$vToastify.warning(((_error$response6 = error.response) === null || _error$response6 === void 0 || (_error$response6 = _error$response6.data) === null || _error$response6 === void 0 ? void 0 : _error$response6.message) || "Failed to load pending invitations.");
      });
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  computed: {
    isSubscribed: function isSubscribed() {
      //return this.$store.state.subscribeUser.subscription.subscribed;
      return true;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09 ***!
  \******************************************************************************************************************************************************************************************************************************************************/
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
      input: [function ($event) {
        if ($event.target.composing) return;
        _vm.query = $event.target.value;
      }, _vm.searchUsers]
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "invite-list"
  }, [_c("ul", [_vm.isLoading ? _c("li", {
    staticClass: "loading-spinner-container"
  }, [_c("div", {
    staticClass: "loading-spinner"
  })]) : !_vm.isLoading && _vm.query && _vm.results.length === 0 ? _c("li", [_vm._v("\n          No users found.\n        ")]) : _vm.results.length > 0 && _vm.query ? _vm._l(_vm.results.slice(0, 5), function (result) {
    return _c("li", {
      key: result.id
    }, [_c("div", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.inviteUser(result.email);
        }
      }
    }, [_vm._v("\n            " + _vm._s(result.name) + " (" + _vm._s(result.email) + ")\n          ")])]);
  }) : _vm._e()], 2)])]) : _vm._e(), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
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
      key: member.id,
      staticClass: "col-6"
    }, [_c("div", {
      staticClass: "project_members-detail text-center"
    }, [_c("router-link", {
      attrs: {
        to: "/user/" + member.uuid + "/profile"
      }
    }, [member.avatar ? _c("img", {
      staticClass: "img-fluid rounded-circle",
      attrs: {
        src: member.avatar,
        alt: ""
      }
    }) : _vm._e(), _vm._v(" "), _c("p", [member.uuid == _vm.owner.uuid ? _c("span", {
      staticClass: "badge badge-success"
    }, [_vm._v("project owner\n                    ")]) : _vm._e(), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", [_vm._v(_vm._s(member.name))]), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", [_vm._v("(" + _vm._s(member.username) + ")")])]), _vm._v(" "), _c("p")]), _vm._v(" "), _vm.ownerLogin && member.uuid !== _vm.owner.uuid ? _c("a", {
      staticClass: "text-danger",
      attrs: {
        rel: "",
        role: "button"
      },
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.removeMember(member.uuid, member);
        }
      }
    }, [_vm._v("Remove")]) : _vm._e()], 1)]);
  }), 0)])]), _vm._v(" "), _c("div", {
    staticClass: "project_members"
  }, [_vm._m(3), _vm._v(" "), _c("div", {
    staticClass: "collapse",
    attrs: {
      id: "pendingMembers"
    }
  }, [_c("div", {
    staticClass: "row"
  }, [_vm.pendingMembers.length ? _vm._l(_vm.pendingMembers, function (member) {
    return _c("div", {
      key: member.id,
      staticClass: "col-6"
    }, [_c("div", {
      staticClass: "project_members-detail text-center"
    }, [_c("router-link", {
      attrs: {
        to: "/user/" + member.uuid + "/profile"
      }
    }, [member.avatar ? _c("img", {
      staticClass: "img-fluid rounded-circle",
      attrs: {
        src: member.avatar,
        alt: ""
      }
    }) : _vm._e(), _vm._v(" "), _c("p", [_c("span", [_vm._v(_vm._s(member.name))]), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", [_vm._v("(" + _vm._s(member.username) + ")")])]), _vm._v(" "), _c("p")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(member.invitation_sent_at))]), _vm._v(" "), _c("br"), _vm._v(" "), _vm.ownerLogin && member.uuid !== _vm.owner.uuid ? _c("a", {
      staticClass: "text-danger",
      attrs: {
        rel: "",
        role: "button"
      },
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.cancelRequest(member.uuid, member);
        }
      }
    }, [_vm._v("Cancel")]) : _vm._e()], 1)]);
  }) : [_vm._m(4)]], 2)])])]);
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
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "task-top"
  }, [_c("p", [_c("b", [_vm._v("Pending Members")]), _c("a", {
    attrs: {
      "data-toggle": "collapse",
      href: "#pendingMembers",
      role: "button",
      "aria-expanded": "false",
      "aria-controls": "pendingMembers"
    }
  }, [_c("i", {
    staticClass: "fas fa-angle-down float-right"
  })])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-12 text-center"
  }, [_c("p", [_vm._v("No pending or invited members found.")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486 ***!
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
  return _c("div", [!_vm.isSubscribed ? _c("div", {
    staticClass: "alert alert-dark mt-2",
    attrs: {
      role: "alert"
    }
  }, [_c("b", [_vm._v("Only subscribed users can access this feature.")])]) : _vm._t("default")], 2);
};
var staticRenderFns = [];
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
/* harmony import */ var _Features_vue_vue_type_template_id_50c2fb09__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Features.vue?vue&type=template&id=50c2fb09 */ "./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09");
/* harmony import */ var _Features_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Features.vue?vue&type=script&lang=js */ "./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Features_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Features_vue_vue_type_template_id_50c2fb09__WEBPACK_IMPORTED_MODULE_0__["render"],
  _Features_vue_vue_type_template_id_50c2fb09__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js":
/*!************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Features.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09 ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_template_id_50c2fb09__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Features.vue?vue&type=template&id=50c2fb09 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_template_id_50c2fb09__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_template_id_50c2fb09__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/SubscriptionChecker.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/SubscriptionChecker.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SubscriptionChecker.vue?vue&type=template&id=bc909486 */ "./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486");
/* harmony import */ var _SubscriptionChecker_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SubscriptionChecker.vue?vue&type=script&lang=js */ "./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SubscriptionChecker_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__["render"],
  _SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/SubscriptionChecker.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./SubscriptionChecker.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486 ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./SubscriptionChecker.vue?vue&type=template&id=bc909486 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);