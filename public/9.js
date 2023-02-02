(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[9],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ProjectForm.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ProjectForm.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      form: {
        stage_id: 1,
        tasks: [{
          body: ''
        }]
      },
      stages: [],
      errors: {},
      taskError: ''
    };
  },
  methods: {
    closePanel: function closePanel() {
      this.$emit("closePanel", {});
      this.errors = {};
      this.taskError = '';
      this.form = {};
    },
    loadStages: function loadStages() {
      var _this = this;
      axios.get('/api/v1/stages').then(function (response) {
        _this.stages = response.data;
      })["catch"](function (error) {
        console.log(error.response.data.errors);
      });
    },
    addTask: function addTask() {
      this.form.tasks.push({
        body: ''
      });
    },
    removeTask: function removeTask() {
      this.form.tasks.pop({
        body: ''
      });
    },
    projectSubmit: function projectSubmit() {
      var _this2 = this;
      axios.post('/api/v1/projects', this.form).then(function (response) {
        _this2.$vToastify.success("New project created");
        _this2.form = "";
        _this2.closePanel();
        setTimeout(function () {
          _this2.$router.push('/projects/' + response.data.slug);
        }, 3000);
      })["catch"](function (error) {
        if (error.response.data.message.includes('The tasks.')) {
          _this2.taskError = error.response.data.message;
          _this2.errors = '';
        } else {
          _this2.errors = error.response.data.errors;
          _this2.taskError = '';
        }
      });
    }
  },
  mounted: function mounted() {
    this.loadStages();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ProjectForm.vue?vue&type=template&id=2114e83c&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ProjectForm.vue?vue&type=template&id=2114e83c& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "panel"
  }, [_c("div", {
    staticClass: "panel-top"
  }, [_c("div", {
    staticClass: "panel-top_content"
  }, [_c("span", {
    staticClass: "panel-heading"
  }, [_vm._v("Add New Project")]), _vm._v(" "), _c("span", {
    staticClass: "panel-exit float-right",
    attrs: {
      role: "button"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.closePanel.apply(null, arguments);
      }
    }
  }, [_vm._v("x")])])]), _vm._v(" "), _c("div", {
    staticClass: "panel-form"
  }, [_c("form", {
    attrs: {
      action: ""
    }
  }, [_c("div", {
    staticClass: "panel-top_content"
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Name:*")]), _vm._v(" "), _c("input", {
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
      name: "name",
      placeholder: "Enter value"
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
      "for": "about"
    }
  }, [_vm._v("About:*")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.about,
      expression: "form.about"
    }],
    staticClass: "form-control",
    attrs: {
      id: "about",
      name: "about",
      placeholder: "Enter project about",
      rows: "5"
    },
    domProps: {
      value: _vm.form.about
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "about", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.about ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.about[0])
    }
  }) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "Tasks"
    }
  }, [_vm._v("Select Stage:*")]), _vm._v(" "), _c("br"), _vm._v(" "), _vm._l(this.stages, function (stage) {
    return _c("div", {
      staticClass: "form-check form-check-inline"
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: _vm.form.stage_id,
        expression: "form.stage_id"
      }],
      key: stage.id,
      staticClass: "form-check-input",
      attrs: {
        type: "radio",
        name: "stage_id"
      },
      domProps: {
        value: stage.id,
        checked: _vm._q(_vm.form.stage_id, stage.id)
      },
      on: {
        change: function change($event) {
          return _vm.$set(_vm.form, "stage_id", stage.id);
        }
      }
    }), _vm._v(" "), _c("label", {
      staticClass: "form-check-label",
      attrs: {
        "for": "inlineRadio1"
      }
    }, [_vm._v(_vm._s(stage.name))])]);
  })], 2), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "Tasks"
    }
  }, [_vm._v("Need Some Tasks?:\n                "), _vm.taskError ? _c("span", {
    staticClass: "text-danger font-italic"
  }, [_vm._v(" " + _vm._s(this.taskError))]) : _vm._e()]), _vm._v(" "), _vm._l(_vm.form.tasks, function (task) {
    return _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: task.body,
        expression: "task.body"
      }],
      staticClass: "form-control model-input mb-2",
      attrs: {
        type: "text",
        placeholder: "Task...",
        name: "task"
      },
      domProps: {
        value: task.body
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(task, "body", $event.target.value);
        }
      }
    });
  }), _vm._v(" "), _vm.form.tasks && _vm.form.tasks.length < 3 ? _c("button", {
    staticClass: "btn btn-primary btn-sm",
    attrs: {
      type: "btn"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.addTask.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-plus-circle"
  }), _vm._v(" Add new Task Field\n                ")]) : _vm._e(), _vm._v(" "), _vm.form.tasks && _vm.form.tasks.length > 1 ? _c("button", {
    staticClass: "btn btn-danger btn-sm",
    attrs: {
      type: "btn"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.removeTask.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "fa fa-minus-circle",
    attrs: {
      "aria-hidden": "true"
    }
  }), _vm._v(" Remove Task Field\n                ")]) : _vm._e()], 2), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "note"
    }
  }, [_vm._v("Note:")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.note,
      expression: "form.note"
    }],
    staticClass: "form-control",
    attrs: {
      id: "note",
      name: "note",
      placeholder: "Write project about",
      rows: "4"
    },
    domProps: {
      value: _vm.form.note
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "note", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.note ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.note[0])
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
        return _vm.closePanel.apply(null, arguments);
      }
    }
  }, [_vm._v("Cancel")]), _vm._v(" "), _c("button", {
    staticClass: "btn panel-btn_save",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.projectSubmit.apply(null, arguments);
      }
    }
  }, [_vm._v("Save")])])])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/ProjectForm.vue":
/*!*************************************************!*\
  !*** ./resources/js/components/ProjectForm.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProjectForm_vue_vue_type_template_id_2114e83c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProjectForm.vue?vue&type=template&id=2114e83c& */ "./resources/js/components/ProjectForm.vue?vue&type=template&id=2114e83c&");
/* harmony import */ var _ProjectForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProjectForm.vue?vue&type=script&lang=js& */ "./resources/js/components/ProjectForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProjectForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProjectForm_vue_vue_type_template_id_2114e83c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ProjectForm_vue_vue_type_template_id_2114e83c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ProjectForm.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/ProjectForm.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/components/ProjectForm.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./ProjectForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ProjectForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ProjectForm.vue?vue&type=template&id=2114e83c&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/ProjectForm.vue?vue&type=template&id=2114e83c& ***!
  \********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectForm_vue_vue_type_template_id_2114e83c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./ProjectForm.vue?vue&type=template&id=2114e83c& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ProjectForm.vue?vue&type=template&id=2114e83c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectForm_vue_vue_type_template_id_2114e83c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectForm_vue_vue_type_template_id_2114e83c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);