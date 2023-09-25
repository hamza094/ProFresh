(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[11],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../utils/TaskUtils */ "./resources/js/utils/TaskUtils.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_2__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }



/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['slug'],
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])('SingleTask', ['form', 'errors', 'task'])),
  data: function data() {
    return {
      searchResults: "",
      taskMembers: []
    };
  },
  watch: {
    'form.search': Object(lodash__WEBPACK_IMPORTED_MODULE_2__["debounce"])(function (newSearch) {
      this.performSearch(newSearch);
    }, 500)
  },
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('SingleTask', ['setErrors', 'updateTaskMembers'])), {}, {
    performSearch: function performSearch(searchTerm) {
      var _this = this;
      axios.get("/api/v1/projects/".concat(this.slug, "/member/search"), {
        params: {
          search: this.form.search
        }
      }).then(function (response) {
        _this.searchResults = response.data;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    addMember: function addMember(member, id) {
      this.taskMembers.push(member);
      this.searchResults = [];
      this.form.search = '';
    },
    removeMember: function removeMember(member, id) {
      this.taskMembers = this.taskMembers.filter(function (m) {
        return m !== member;
      });
    },
    assignMembers: function assignMembers(taskId) {
      var _this2 = this;
      if (!this.taskMembers.length) {
        return this.$vToastify.info('no member is selected to assign task');
      }
      var memberIds = this.taskMembers.map(function (member) {
        return member.id;
      });
      axios.patch(Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__["url"])(this.slug, taskId) + '/assign', {
        members: memberIds
      }).then(function (response) {
        _this2.assignSuccessfull(response);
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this2.setErrors(error.response.data.errors);
        }
      });
    },
    assignSuccessfull: function assignSuccessfull(response) {
      this.taskMembers = [];
      this.setErrors([]);
      this.updateTaskMembers(response.data.taskMembers);
      this.$bus.emit('close-members-popup');
      this.$vToastify.success(response.data.message);
    },
    getErrors: function getErrors(key) {
      if (this.hasError(key)) {
        return this.errors[key];
      }
      return [];
    },
    hasError: function hasError(key) {
      return this.errors.hasOwnProperty(key);
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94& ***!
  \****************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "member-dropdown_item"
  }, [_vm._m(0), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.search,
      expression: "form.search"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "Search Members",
      name: "member",
      autocomplete: "off"
    },
    domProps: {
      value: _vm.form.search
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "search", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.hasError("members") ? _c("div", _vm._l(_vm.getErrors("members"), function (error) {
    return _c("span", {
      key: error,
      staticClass: "text-danger font-italic"
    }, [_vm._v("*" + _vm._s(error))]);
  }), 0) : _vm._e(), _vm._v(" "), _vm.hasError("members.0") ? _c("div", _vm._l(_vm.getErrors("members.0"), function (error) {
    return _c("span", {
      key: error,
      staticClass: "text-danger font-italic"
    }, [_vm._v("*" + _vm._s(error))]);
  }), 0) : _vm._e(), _vm._v(" "), _vm.searchResults.length > 0 && _vm.form.search ? _c("div", {
    staticClass: "member-list"
  }, _vm._l(_vm.searchResults, function (member) {
    return _c("div", {
      key: member.id,
      staticClass: "member-list_items"
    }, [_c("div", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.addMember(member, member.id);
        }
      }
    }, [_vm._v(_vm._s(member.name) + " (" + _vm._s(member.username) + ")\n      ")])]);
  }), 0) : _vm._e(), _vm._v(" "), _c("button", {
    staticClass: "mt-2 btn btn-sm btn-primary float-right",
    on: {
      click: function click($event) {
        return _vm.assignMembers(_vm.task.id);
      }
    }
  }, [_vm._v("Assign")]), _vm._v(" "), _vm.taskMembers.length > 0 ? _c("div", {
    staticClass: "mt-3",
    staticStyle: {
      height: "70px",
      width: "150px",
      "overflow-y": "scroll"
    }
  }, _vm._l(_vm.taskMembers, function (member) {
    return _c("div", [_c("span", [_vm._v(_vm._s(member.username) + " "), _c("span", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.removeMember(member, member.id);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-minus-circle"
    })])])]);
  }), 0) : _vm._e()]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "text-center m-1"
  }, [_c("small", [_c("b", [_vm._v("Assign Task To Member")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TaskMembers.vue ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TaskMembers_vue_vue_type_template_id_832a0e94___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TaskMembers.vue?vue&type=template&id=832a0e94& */ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94&");
/* harmony import */ var _TaskMembers_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TaskMembers.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TaskMembers_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TaskMembers_vue_vue_type_template_id_832a0e94___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TaskMembers_vue_vue_type_template_id_832a0e94___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Modal/TaskMembers.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TaskMembers.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94& ***!
  \****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_template_id_832a0e94___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TaskMembers.vue?vue&type=template&id=832a0e94& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskMembers.vue?vue&type=template&id=832a0e94&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_template_id_832a0e94___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskMembers_vue_vue_type_template_id_832a0e94___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/utils/TaskUtils.js":
/*!*****************************************!*\
  !*** ./resources/js/utils/TaskUtils.js ***!
  \*****************************************/
/*! exports provided: calculateRemainingTime, url */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "calculateRemainingTime", function() { return calculateRemainingTime; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "url", function() { return url; });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);

function calculateRemainingTime(task, currentDate) {
  if (task.due_at !== null) {
    var duration = moment__WEBPACK_IMPORTED_MODULE_0___default.a.duration(moment__WEBPACK_IMPORTED_MODULE_0___default()(task.due_at).diff(moment__WEBPACK_IMPORTED_MODULE_0___default()(currentDate)));
    if (duration.asMilliseconds() <= 0) {
      return 'Due date passed';
    }
    var days = duration.days();
    var hours = duration.hours();
    var minutes = duration.minutes();
    var messageParts = [];
    if (days > 0) {
      messageParts.push("".concat(days, " day(s)"));
    }
    if (hours > 0) {
      messageParts.push("".concat(hours, " hour(s)"));
    }
    if (minutes > 0) {
      messageParts.push("".concat(minutes, " minute(s)"));
    }
    return "".concat(messageParts.join(', '), " remaining");
  }
}
function url($slug, $id) {
  return '/api/v1/projects/' + $slug + '/tasks/' + $id;
}

/*export function updateTask(slug, id, task, data, additionalCallback) {
  if (areObjectsEqual(data, task)) {
    this.$vToastify.warning("Update not allowed. No changes were made.");
    return;
  }

  axios.put(url(slug, id), data)
    .then(response => {
      this.$vToastify.success(response.data.message);
      if (additionalCallback) {
        additionalCallback(response.data); // Call additional callback if provided
      }
    })
    .catch(error => {
      console.logerror.response.data.errors;
    });
}

export function areObjectsEqual(obj1, obj2) {
  return Object.keys(obj1).every(key => obj1[key] === obj2[key]);
}*/

/***/ })

}]);