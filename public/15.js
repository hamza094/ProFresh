(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[15],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['slug', 'tasks', 'access'],
  data: function data() {
    return {
      editing: 0,
      form: {
        body: '',
        editbody: '',
        completed: ''
      },
      errors: {}
    };
  },
  methods: {
    getResults: function getResults() {
      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      this.$bus.emit('taskResults', {
        page: page
      });
    },
    add: function add() {
      var _this = this;
      axios.post('/api/v1/projects/' + this.slug + '/task', this.form).then(function (response) {
        _this.$vToastify.success("Project Task added");
        _this.form.body = "";
        _this.getResults();
        _this.$bus.emit('addScore');
      })["catch"](function (error) {
        _this.form.body = "";
        _this.taskErrors(error);
      });
    },
    url: function url($slug, $id) {
      return '/api/v1/projects/' + $slug + '/task/' + $id;
    },
    update: function update(id, task) {
      var _this2 = this;
      axios.put(this.url(this.slug, id), {
        body: this.form.editbody
      }).then(function (response) {
        _this2.$vToastify.success("Task Updated");
        _this2.editing = false;
        task.body = _this2.form.editbody;
      })["catch"](function (error) {
        _this2.taskErrors(error);
      });
    },
    closeEditForm: function closeEditForm(id, task) {
      this.editing = false;
      this.form.editbody = task.body;
    },
    markComplete: function markComplete(id, task) {
      var _this3 = this;
      axios.patch(this.url(this.slug, id) + '/status', {
        completed: true
      }).then(function (response) {
        _this3.$vToastify.success("Task Completed");
        task.completed = true;
      })["catch"](function (error) {
        _this3.$vToastify.warning("Task Status Updated failed");
      });
    },
    markUncomplete: function markUncomplete(id, task) {
      var _this4 = this;
      axios.patch(this.url(this.slug, id) + '/status', {
        completed: false
      }).then(function (response) {
        _this4.$vToastify.info("Task Marked Uncomplete");
        task.completed = false;
      })["catch"](function (error) {
        _this4.$vToastify.warning("Task Status Updated failed");
      });
    },
    remove: function remove(id, index) {
      var _this5 = this;
      axios["delete"](this.url(this.slug, id)).then(function (response) {
        _this5.getResults();
        _this5.$vToastify.info("Project Task deleted");
        _this5.$bus.emit('reduceScore');
      })["catch"](function (error) {
        _this5.$vToastify.warning("Task deletion failed");
      });
    },
    openEditForm: function openEditForm(id, task) {
      this.editing = id;
      this.form.editbody = task.body;
    },
    taskErrors: function taskErrors(error) {
      if (!error.response) {
        this.$vToastify.warning("An error occurred.");
        return;
      }
      var errors = error.response.data.errors;
      if (errors) {
        for (var key in errors) {
          if (errors.hasOwnProperty(key)) {
            this.$vToastify.warning(errors[key][0]);
          }
        }
      } else {
        this.$vToastify.warning("An error occurred.");
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251& ***!
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
  return _c("div", {
    staticClass: "task"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "collapse",
    attrs: {
      id: "taskProject"
    }
  }, [_c("div", {
    staticClass: "card card-body"
  }, [_c("div", {
    staticClass: "task-add"
  }, [_vm.access ? _c("form", {
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.add.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    attrs: {
      "for": "body"
    }
  }, [_vm._v("Add New Task")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.body,
      expression: "form.body"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      name: "body"
    },
    domProps: {
      value: _vm.form.body
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "body", $event.target.value);
      }
    }
  })])]) : _vm._e()]), _vm._v(" "), _vm.tasks ? _c("div", {
    staticClass: "task-list"
  }, [_c("p", {
    staticClass: "task-list_heading"
  }, [_vm._v("Project Tasks")]), _vm._v(" "), _vm._l(_vm.tasks.data, function (task, index) {
    return _c("div", {
      key: task.id
    }, [_c("p", {
      staticClass: "task-list_text"
    }, [_vm.editing == task.id ? _c("span", [_c("textarea", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: _vm.form.editbody,
        expression: "form.editbody"
      }],
      staticClass: "form-control",
      staticStyle: {
        resize: "none"
      },
      attrs: {
        name: "body",
        rows: "1",
        cols: "34"
      },
      domProps: {
        value: _vm.form.editbody,
        textContent: _vm._s(task.body)
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(_vm.form, "editbody", $event.target.value);
        }
      }
    }), _vm._v(" "), _c("span", {
      staticClass: "btn btn-link btn-sm",
      on: {
        click: function click($event) {
          return _vm.update(task.id, task);
        }
      }
    }, [_vm._v("Update")]), _vm._v(" "), _c("span", {
      staticClass: "btn btn-link btn-sm",
      on: {
        click: function click($event) {
          return _vm.closeEditForm(task.id, task);
        }
      }
    }, [_vm._v("Cancel")])]) : _c("span", {
      "class": {
        "task-list_text-body": task.completed == true
      }
    }, [_vm._v(_vm._s(task.body))]), _vm._v(" "), _vm.access ? _c("span", {
      staticClass: "float-right"
    }, [_c("span", [task.completed ? _c("input", {
      staticClass: "form-check-input",
      attrs: {
        type: "checkbox",
        checked: ""
      },
      on: {
        change: function change($event) {
          return _vm.markUncomplete(task.id, task);
        }
      }
    }) : _c("input", {
      staticClass: "form-check-input",
      attrs: {
        type: "checkbox",
        name: "completed"
      },
      on: {
        change: function change($event) {
          return _vm.markComplete(task.id, task);
        }
      }
    })]), _vm._v(" "), _c("span", {
      on: {
        click: function click($event) {
          return _vm.remove(task.id, index);
        }
      }
    }, [_c("i", {
      staticClass: "far fa-trash-alt",
      staticStyle: {
        color: "#E74C3C"
      }
    })]), _vm._v(" "), _c("span", {
      on: {
        click: function click($event) {
          return _vm.openEditForm(task.id, task);
        }
      }
    }, [_c("i", {
      staticClass: "far fa-edit",
      staticStyle: {
        color: "#2980B9"
      }
    })])]) : _vm._e(), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", {
      staticClass: "task-list_time"
    }, [_c("i", {
      staticClass: "far fa-clock"
    }), _vm._v(" " + _vm._s(task.created_at))])]), _vm._v(" "), _c("hr")]);
  }), _vm._v(" "), _c("pagination", {
    attrs: {
      data: _vm.tasks
    },
    on: {
      "pagination-change-page": _vm.getResults
    }
  })], 2) : _vm._e()])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "task-top"
  }, [_c("span", [_c("b", [_vm._v("Tasks")]), _vm._v(" "), _c("a", {
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
/* harmony import */ var _Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Task.vue?vue&type=template&id=468be251& */ "./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251&");
/* harmony import */ var _Task_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Task.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Task_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Task.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Task.vue?vue&type=template&id=468be251& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);