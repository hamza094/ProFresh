(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[19],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Modal_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Modal.vue */ "./resources/js/components/Project/Panel/Modal.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }


//import SubscriptionCheck from '../../SubscriptionChecker.vue';
/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    TaskModal: _Modal_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: ['slug', 'access'],
  data: function data() {
    return {
      currentTasks: [],
      task_score: 2,
      state: 'active',
      form: {
        title: ''
      },
      errors: {}
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapState"])('task', ['tasks', 'message'])),
  methods: _objectSpread(_objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])({
    fetchTasks: 'task/fetchTasks',
    loadStatuses: 'SingleTask/loadStatuses'
  })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapMutations"])('project', ['addScore', 'reduceScore'])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapMutations"])('SingleTask', ['setTask'])), {}, {
    getResults: function getResults(page) {
      var slug = this.$route.params.slug;
      this.fetchTasks({
        slug: slug,
        page: page
      });
    },
    archiveTasks: function archiveTasks() {
      var panel1Handle = this.$showPanel({
        component: 'archive-tasks',
        openOn: 'right',
        width: 440,
        disableBgClick: true,
        keepAlive: true,
        props: {
          slug: this.slug
        }
      });
      panel1Handle.promise.then(function (result) {});
    },
    openModal: function openModal(task) {
      this.setTask(task);
      this.$modal.show('task-modal');
    },
    add: function add() {
      var _this = this;
      axios.post('/api/v1/projects/' + this.slug + '/tasks', this.form).then(function (response) {
        _this.$vToastify.success("Project Task added");
        _this.form.title = "";
        _this.getResults(1);
        _this.addScore(_this.task_score);
      })["catch"](function (error) {
        _this.form.title = "";
        _this.$vToastify.warning(error.response.data.message);
      });
    },
    closeModal: function closeModal() {
      this.setTask([]);
    }
  }),
  created: function created() {
    this.getResults(1);
    this.loadStatuses();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251 ***!
  \**************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "task"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "collapse",
    attrs: {
      id: "taskProject"
    }
  }, [_c("div", {
    staticClass: "card card-body"
  }, [!_vm.access ? _c("div", [_vm._v("Only the project owner and members are allowed to access this feature.")]) : _vm._e(), _vm._v(" "), _vm.access ? _c("div", [_c("div", {
    staticClass: "task-add"
  }, [_c("form", {
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.add.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_vm._m(1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.title,
      expression: "form.title"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      name: "title"
    },
    domProps: {
      value: _vm.form.title
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "title", $event.target.value);
      }
    }
  })])])]), _vm._v(" "), _c("p", {
    staticClass: "task-list_heading"
  }, [_vm._v(" " + _vm._s(this.message) + "\n    ")]), _vm.tasks ? _c("div", {
    staticClass: "task-list"
  }, [_c("span", {
    staticClass: "float-right"
  }, [_c("a", {
    staticClass: "panel-list_item",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.archiveTasks.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-tasks"
  })])]), _vm._v(" "), _c("p"), _vm._v(" "), _vm._l(_vm.tasks.data, function (task, index) {
    return _c("div", {
      key: task.id
    }, [_c("div", {
      staticClass: "card task-card_style",
      on: {
        click: function click($event) {
          return _vm.openModal(task);
        }
      }
    }, [task.status ? _c("div", {
      staticClass: "task-card_border",
      style: {
        borderColor: task.status.color
      }
    }) : _vm._e(), _vm._v(" "), _c("div", {
      staticClass: "card-body task-card_body"
    }, [_c("span", [_vm._v(_vm._s(task.title))]), _vm._v(" "), _c("span", {
      staticClass: "float-right mt-4"
    }, [_c("small", [_c("i", {
      staticClass: "far fa-clock"
    }), _vm._v(":" + _vm._s(_vm._f("date")(task.created_at)))])])])])]);
  }), _vm._v(" "), _c("modal", {
    staticClass: "model-desin",
    attrs: {
      name: "task-modal",
      height: "auto",
      scrollable: true,
      width: "65%",
      clickToClose: false
    },
    on: {
      "modal-closed": _vm.closeModal
    }
  }, [_c("TaskModal", {
    attrs: {
      slug: _vm.slug,
      state: _vm.state
    }
  })], 1), _vm._v(" "), _c("pagination", {
    attrs: {
      data: _vm.tasks
    },
    on: {
      "pagination-change-page": _vm.getResults
    }
  })], 2) : _vm._e()]) : _vm._e()])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "task-top"
  }, [_c("span", [_c("i", {
    staticClass: "fas fa-tasks"
  }), _vm._v(" "), _c("b", [_vm._v("Tasks")]), _vm._v(" "), _c("a", {
    attrs: {
      "data-toggle": "collapse",
      href: "#taskProject",
      role: "button",
      "aria-expanded": "false",
      "aria-controls": "taskProject"
    }
  }, [_c("i", {
    staticClass: "fas fa-angle-down float-right"
  })])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "body"
    }
  }, [_c("i", [_vm._v("Create a New Task")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/Panel/Task.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/Project/Panel/Task.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Task_vue_vue_type_template_id_468be251__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Task.vue?vue&type=template&id=468be251 */ "./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251");
/* harmony import */ var _Task_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Task.vue?vue&type=script&lang=js */ "./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Task_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Task_vue_vue_type_template_id_468be251__WEBPACK_IMPORTED_MODULE_0__["render"],
  _Task_vue_vue_type_template_id_468be251__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Task.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js":
/*!********************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Task.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251 ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_template_id_468be251__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Task.vue?vue&type=template&id=468be251 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_template_id_468be251__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_template_id_468be251__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);