(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[8],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['task', 'slug'],
  data: function data() {
    return {
      editing: 0,
      form: {
        title: '',
        editTitle: ''
      },
      model: {},
      errors: {}
    };
  },
  methods: {
    modalClose: function modalClose() {
      this.$modal.hide('task-modal');
      this.errors = '';
      this.form = {};
    },
    updateTitle: function updateTitle(id, task) {
      var _this = this;
      axios.put(this.url(this.slug, id), {
        title: this.form.editTitle
      }).then(function (response) {
        _this.$vToastify.success("Task Updated");
        _this.editing = false;
        task.title = _this.form.editTitle;
      })["catch"](function (error) {
        //this.taskErrors(error);
      });
    },
    closeEditForm: function closeEditForm(id, task) {
      this.editing = false;
      this.form.editTitle = task.title;
    },
    openTitleForm: function openTitleForm(id, task) {
      this.editing = id;
      this.form.editTitle = task.title;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091& ***!
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
  return _c("div", [_c("modal", {
    staticClass: "model-desin",
    attrs: {
      name: "task-modal",
      height: "auto",
      scrollable: true,
      width: "45%",
      clickToClose: false
    }
  }, [_c("div", {
    staticClass: "edit-border-top p-3 task-modal"
  }, [_c("div", {
    staticClass: "edit-border-bottom"
  }, [_c("div", {
    staticClass: "task-modal_content"
  }, [_vm.editing == _vm.task.id ? _c("span", [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.editTitle,
      expression: "form.editTitle"
    }],
    staticClass: "form-control",
    attrs: {
      name: "title"
    },
    domProps: {
      value: _vm.form.editTitle,
      textContent: _vm._s(_vm.task.title)
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "editTitle", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.updateTitle(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Update")]), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.closeTitleForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Cancel")])]) : _c("span", {
    staticClass: "task-modal_title",
    on: {
      click: function click($event) {
        return _vm.openTitleForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v(_vm._s(_vm.task.title))]), _vm._v(" "), _c("span", {
    staticClass: "task-modal_close float-right",
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
    staticClass: "panel-form mt-2"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("div", {
    staticClass: "task-feature"
  }, [_c("small", [_vm._v("labels")]), _vm._v(" "), _c("p", [_vm._v(_vm._s(_vm.task.status.label) + " - " + _vm._s(_vm.task.status.color))])]), _vm._v(" "), _c("div", {
    staticClass: "task-description"
  }, [_c("i", {
    staticClass: "fas fa-tasks-alt"
  }), _vm._v(" "), _c("h4", [_vm._v("Descriprion")]), _vm._v(" "), _c("p", [_vm._v("Vestibulum vestibulum eu lacus eget sagittis. Suspendisse vel odio ornare, euismod leo sit amet, fermentum nulla. Sed vel viverra ipsum. Nam quis urna tellus. In non augue blandit dolor lacinia consectetur eget eu enim. Donec luctus lacus vel sem vulputate, at bibendum nunc hendrerit. Sed vel turpis augue. Nullam vitae libero eu mauris ultricies sagittis et quis quam. Praesent placerat metus at velit pellentesque scelerisque. Aliquam erat volutpat. Morbi in felis in quam maximus egestas.")])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "task-option"
  }, [_c("small", [_vm._v("Task Options")]), _vm._v(" "), _c("h6", [_vm._v("Labels")]), _vm._v(" "), _c("ul", {
    staticClass: "task-option_labels mb-2"
  }, [_c("li", [_vm._v("Not Started")]), _vm._v(" "), _c("li", [_vm._v("Started")]), _vm._v(" "), _c("li", [_vm._v("In Progress")]), _vm._v(" "), _c("li", [_vm._v("Completed")])]), _vm._v(" "), _c("ul", [_c("li", [_c("button", {
    staticClass: "btn btn-xs btn-secondary"
  }, [_vm._v("\n          \t\t\t\t\tMembers\n          \t\t\t\t")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-xs btn-info"
  }, [_vm._v("\n          \t\t\t\t\tDue Date\n          \t\t\t\t")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-xs btn-warning"
  }, [_vm._v("\n          \t\t\t\t\tInactive\n          \t\t\t\t")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-xs btn-danger"
  }, [_vm._v("\n          \t\t\t\t\tDelete\n          \t\t\t\t")])])])])])])])])])], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Modal.vue?vue&type=template&id=041ce091& */ "./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091&");
/* harmony import */ var _Modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Modal.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Modal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Modal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Modal.vue?vue&type=template&id=041ce091& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);