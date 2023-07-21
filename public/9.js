(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[9],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue2_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue2-editor */ "./node_modules/vue2-editor/dist/vue2-editor.esm.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    VueEditor: vue2_editor__WEBPACK_IMPORTED_MODULE_0__["VueEditor"]
  },
  props: ['task', 'slug'],
  data: function data() {
    return {
      editing: 0,
      currentDate: new Date(),
      maxdateTime: null,
      edit: 0,
      memberPop: false,
      datePop: false,
      statuses: '',
      dateTime: '',
      due: '',
      form: {
        title: '',
        editTitle: '',
        discription: '',
        editDescription: ''
      },
      model: {},
      errors: {},
      customToolbar: [["bold", "italic", "underline"], [{
        list: "ordered"
      }, {
        list: "bullet"
      }], [{
        'header': [1, 2, 3, 4, 5, 6, false]
      }], ['blockquote'], [{
        'size': ['small', false, 'large', 'huge']
      }], ['link', 'unlink']]
    };
  },
  computed: {
    modifiedDate: function modifiedDate() {
      var modifiedDate = new Date(this.currentDate.getTime() + 30 * 60000);
      return modifiedDate.toISOString();
    },
    remainingMessage: function remainingMessage() {
      var duration = this.calculateDuration();
      var timeRemaining = this.calculateTimeRemaining(duration);
      if (timeRemaining <= 0) {
        return 'Due date passed';
      }
      var message = this.formatRemainingTime(duration);
      return message;
    }
  },
  methods: {
    calculateDuration: function calculateDuration() {
      return moment.duration(moment(this.dateTime).diff(moment(this.currentDate)));
    },
    calculateTimeRemaining: function calculateTimeRemaining(duration) {
      return Math.floor(duration.asMinutes());
    },
    formatRemainingTime: function formatRemainingTime(duration) {
      var units = ['day', 'hour', 'minute'];
      var values = [duration.days(), duration.hours(), duration.minutes()];
      for (var i = 0; i < units.length; i++) {
        if (values[i] > 0) {
          return "".concat(values[i], " ").concat(units[i], "(s) remaining");
        }
      }
    },
    taskDue: function taskDue() {
      this.datePop = false;
    },
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
    closeTitleForm: function closeTitleForm(id, task) {
      this.editing = false;
      this.form.editTitle = task.title;
    },
    openTitleForm: function openTitleForm(id, task) {
      this.editing = id;
      this.form.editTitle = task.title;
    },
    updateDescription: function updateDescription(id, task) {
      var _this2 = this;
      axios.put(this.url(this.slug, id), {
        description: this.form.editDescription
      }).then(function (response) {
        _this2.$vToastify.success("Task description Updated");
        _this2.edit = false;
        task.description = _this2.form.editDescription;
      })["catch"](function (error) {
        //this.taskErrors(error);
      });
    },
    closeDescriptionForm: function closeDescriptionForm(id, task) {
      this.edit = false;
      this.form.editDescription = task.description;
    },
    openDescriptionForm: function openDescriptionForm(id, task) {
      this.edit = id;
      this.form.editDescription = task.description;
    },
    assignMember: function assignMember() {
      console.log('assign Member');
    },
    dueDate: function dueDate() {
      console.log('due date');
    },
    inActive: function inActive() {
      console.log('in active');
    },
    trash: function trash() {
      console.log('delete');
    },
    changeStatus: function changeStatus(status) {
      console.log(status.label);
    }
  },
  mounted: function mounted() {
    var _this3 = this;
    axios.get('/api/v1/task/statuses').then(function (response) {
      _this3.statuses = response.data;
    })["catch"]({});
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
  return _c("div", {
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
    staticClass: "title-form form-control",
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
  }, [_c("p", [_vm._m(0), _vm._v(":\n          \t\t\t\t\t"), _c("span", {
    staticClass: "task-option_labels-component",
    style: {
      backgroundColor: _vm.task.status.color
    },
    on: {
      click: function click($event) {
        return _vm.changeStatus(_vm.status);
      }
    }
  }, [_vm._v(_vm._s(_vm.task.status.label))]), _vm._v(" "), _vm._m(1), _vm._v(" "), _c("span", {
    staticClass: "task-member"
  }, [_vm._v("M")]), _vm._v(" "), _c("span", {
    staticClass: "task-member"
  }, [_vm._v("A")]), _vm._v(" "), _c("span", {
    staticClass: "task-member"
  }, [_vm._v("S")])]), _vm._v(" "), this.dateTime ? _c("p", [_vm._m(2), _vm._v(" " + _vm._s(_vm._f("datetime")(this.dateTime)))]) : _vm._e(), _vm._v(" "), this.due ? _c("p", [_vm._m(3), _vm._v(_vm._s(this.due) + " ")]) : _vm._e(), _vm._v(" "), this.dateTime ? _c("p", [_vm._m(4), _vm._v(_vm._s(this.remainingMessage) + " ")]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "task-description"
  }, [_c("h4", [_vm._v("Descriprion")]), _vm._v(" "), _vm.edit == _vm.task.id ? _c("div", [_c("vue-editor", {
    attrs: {
      name: "discription",
      editorToolbar: _vm.customToolbar
    },
    model: {
      value: _vm.form.editDescription,
      callback: function callback($$v) {
        _vm.$set(_vm.form, "editDescription", $$v);
      },
      expression: "form.editDescription"
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.updateDescription(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Update")]), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.closeDescriptionForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Cancel")])], 1) : _c("div", [_c("p", {
    on: {
      click: function click($event) {
        return _vm.openDescriptionForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v(_vm._s(_vm.task.description))])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "task-option"
  }, [_vm._m(5), _vm._v(" "), _c("h5", {
    staticClass: "text-center"
  }, [_vm._v("Change Label")]), _vm._v(" "), _c("ul", {
    staticClass: "task-option_labels"
  }, _vm._l(_vm.statuses, function (status) {
    return _c("li", {
      key: status.id
    }, [_c("p", {
      staticClass: "task-option_labels-component",
      style: {
        backgroundColor: status.color
      },
      on: {
        click: function click($event) {
          return _vm.changeStatus(status);
        }
      }
    }, [_vm._v(_vm._s(status.label) + "\n                     "), _vm.task.status_id == status.id ? _c("span", [_c("i", {
      staticClass: "fas fa-check-circle",
      staticStyle: {
        color: "#2a971c"
      }
    })]) : _vm._e()])]);
  }), 0), _vm._v(" "), _c("ul", {
    staticClass: "task-option_features"
  }, [_c("li", [_c("button", {
    staticClass: "btn btn-sm btn-outline-primary btn-block member-dropdown",
    on: {
      click: function click($event) {
        $event.preventDefault();
        _vm.memberPop = !_vm.memberPop;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-user-alt pr-1"
  }), _vm._v(" "), _c("b", [_vm._v("Members")])]), _vm._v(" "), _c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.memberPop,
      expression: "memberPop"
    }],
    staticClass: "member-dropdown_item"
  }, [_vm._m(6), _vm._v(" "), _c("input", {
    staticClass: "form-control m-2",
    attrs: {
      type: "",
      placeholder: "Search Members",
      name: "member"
    }
  }), _vm._v(" "), _c("button", {
    staticClass: "btn btn-sm btn-primary float-right"
  }, [_vm._v("Assign")])])]), _vm._v(" "), _c("li", [_c("button", {
    staticClass: "btn btn-sm btn btn-sm btn-outline-success btn-block",
    on: {
      click: function click($event) {
        $event.preventDefault();
        _vm.datePop = !_vm.datePop;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-clock pr-1"
  }), _c("b", [_vm._v("Due Date")])]), _vm._v(" "), _c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.datePop,
      expression: "datePop"
    }],
    staticClass: "member-dropdown_item"
  }, [_c("span", [_vm._v("Due Date:\n                        "), _c("datetime", {
    attrs: {
      type: "datetime",
      "value-zone": "local",
      zone: "local",
      "min-datetime": _vm.modifiedDate
    },
    model: {
      value: _vm.dateTime,
      callback: function callback($$v) {
        _vm.dateTime = $$v;
      },
      expression: "dateTime"
    }
  })], 1), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.due,
      expression: "due"
    }],
    staticClass: "custom-select mr-sm-2",
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.due = $event.target.multiple ? $$selectedVal : $$selectedVal[0];
      }
    }
  }, [_c("option", {
    attrs: {
      selected: ""
    }
  }, [_vm._v("Choose...")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "1 Day Before"
    }
  }, [_vm._v("1 Day Before")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "2 Hours Before"
    }
  }, [_vm._v("2 Hours Before")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "15 Minutes Before"
    }
  }, [_vm._v("15 Minutes Before")]), _c("option", {
    attrs: {
      value: "5 Minutes Before"
    }
  }, [_vm._v("5 Minutes Before")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "At The Time"
    }
  }, [_vm._v("At The Time")])]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-sm btn-primary float-right mt-2",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.taskDue();
      }
    }
  }, [_vm._v("Set")])])]), _vm._v(" "), _c("li", [_c("button", {
    staticClass: "btn btn-sm btn btn-sm btn-outline-info btn-block",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.inActive();
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-ban pr-1"
  }), _c("b", [_vm._v("\tInactive")])])]), _vm._v(" "), _c("li", [_c("button", {
    staticClass: "btn btn-sm btn btn-sm btn-outline-danger btn-block",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.trash();
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-trash-alt pr-1"
  }), _c("b", [_vm._v("\tDelete")])])])])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("small", [_c("b", [_vm._v("Label")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("small", {
    staticClass: "ml-2"
  }, [_c("b", [_vm._v("Members:")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("small", [_c("b", [_vm._v("Task due: ")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("small", [_c("b", [_vm._v("Notified: ")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("small", [_c("b", [_vm._v("Days Left: ")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("span", {
    staticClass: "text-center ml-4"
  }, [_c("b", [_vm._v("Options")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "text-center m-1"
  }, [_c("small", [_c("b", [_vm._v("Assign Task To Member")])])]);
}];
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