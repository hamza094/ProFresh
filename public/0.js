(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingModal.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/MeetingModal.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['projectSlug'],
  components: {},
  data: function data() {
    return {
      form: {
        topic: '',
        agenda: '',
        joinBeforeHost: '',
        duration: '',
        strttm: '',
        timezone: ''
      }
    };
  },
  mounted: function mounted() {
    var _this = this;
    $this.$Bus.on('open-meeting-modal', function () {
      _this.$modal.show('MeetingModal');
    });
  },
  destroyed: function destroyed() {
    $this.$Bus.$off('open-meeting-modal');
  },
  methods: {
    createMeeting: function createMeeting() {
      // Send the form data object with Axios
      axios.post("/api/v1/projects/".concat(this.projectSlug, "/zoom/meeting/create"), this.form).then(function (response) {
        console.log(response);
      })["catch"](function (error) {
        console.error(error);
      });
    },
    meetingModal: function meetingModal() {
      this.$modal.show('MeetingModal');
    },
    modalClose: function modalClose() {
      this.$modal.hide('MeetingModal');
      this.form = Object.assign({}, this.$options.data().form);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingModal.vue?vue&type=template&id=06e4b51a":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/MeetingModal.vue?vue&type=template&id=06e4b51a ***!
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
      name: "MeetingModal",
      height: "auto",
      scrollable: true,
      width: "40%",
      clickToClose: false
    }
  }, [_c("div", {
    staticClass: "edit-border-top p-3"
  }, [_c("div", {
    staticClass: "edit-border-bottom"
  }, [_c("div", {
    staticClass: "panel-top_content"
  }, [_c("span", {
    staticClass: "panel-heading"
  }, [_vm._v("Create A New Project Meeting")]), _vm._v(" "), _c("span", {
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
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.createMeeting();
      }
    }
  }, [_c("div", {
    staticClass: "panel-top_content"
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "topic"
    }
  }, [_vm._v("Topic:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.topic,
      expression: "form.topic"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      id: "topic",
      name: "topic",
      placeholder: "Title for meeting"
    },
    domProps: {
      value: _vm.form.topic
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "topic", $event.target.value);
      }
    }
  }), _vm._v(" "), this.errors ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("*" + _vm._s(this.errors))]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "agenda"
    }
  }, [_vm._v("Agenda:")]), _vm._v(" "), _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.agenda,
      expression: "form.agenda"
    }],
    staticClass: "form-control",
    attrs: {
      name: "agenda",
      rows: "3",
      placeholder: "Enter meeting agenda here"
    },
    domProps: {
      value: _vm.form.agenda
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "agenda", $event.target.value);
      }
    }
  }), _vm._v(" "), this.errors ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("*" + _vm._s(this.errors))]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "password"
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
      name: "password",
      place: "Enter unique meeting passcode"
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
  }), _vm._v(" "), this.errors ? _c("p", {
    staticClass: "text-danger"
  }, [_vm._v("*" + _vm._s(this.errors))]) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("p", [_c("b", [_vm._v("Join Befor Host:")])]), _vm._v(" "), _c("div", {
    staticClass: "form-check form-check-inline"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.joinBeforeHost,
      expression: "form.joinBeforeHost"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "radio",
      id: "joinBefore",
      name: "joinBeforeHost",
      value: "true"
    },
    domProps: {
      checked: _vm._q(_vm.form.joinBeforeHost, "true")
    },
    on: {
      change: function change($event) {
        return _vm.$set(_vm.form, "joinBeforeHost", "true");
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "joinBefore"
    }
  }, [_vm._v("Yes")])]), _vm._v(" "), _c("div", {
    staticClass: "form-check form-check-inline"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.joinBeforeHost,
      expression: "form.joinBeforeHost"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "radio",
      id: "joinAfter",
      name: "joinBeforeHost",
      value: "false"
    },
    domProps: {
      checked: _vm._q(_vm.form.joinBeforeHost, "false")
    },
    on: {
      change: function change($event) {
        return _vm.$set(_vm.form, "joinBeforeHost", "false");
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "joinAfter"
    }
  }, [_vm._v("No")])]), _vm._v(" "), this.errors ? _c("p", {
    staticClass: "text-danger"
  }) : _vm._e()]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    attrs: {
      "for": "duration"
    }
  }, [_c("b", [_vm._v("Duration:")])]), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.duration,
      expression: "form.duration"
    }],
    staticClass: "form-control",
    attrs: {
      id: "duration"
    },
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.form, "duration", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c("option", {
    attrs: {
      value: "",
      disabled: "",
      selected: ""
    }
  }, [_vm._v("Select Meeting Duration")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "15"
    }
  }, [_vm._v("15 minutes")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "30"
    }
  }, [_vm._v("30 minutes")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "45"
    }
  }, [_vm._v("45 minutes")])])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    attrs: {
      "for": "strttm"
    }
  }, [_c("b", [_vm._v("Start Time:")])]), _vm._v(" "), _c("datetime", {
    attrs: {
      type: "datetime",
      "value-zone": "local",
      zone: "local"
    },
    model: {
      value: _vm.form.strttm,
      callback: function callback($$v) {
        _vm.$set(_vm.form, "strttm", $$v);
      },
      expression: "form.strttm"
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "panel-bottom"
  }, [_c("div", {
    staticClass: "panel-top_content float-left"
  }), _vm._v(" "), _c("div", {
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
    staticClass: "btn panel-btn_save",
    attrs: {
      type: "submit"
    }
  }, [_vm._v("Create")])])])])])])])], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/MeetingModal.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/Project/MeetingModal.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MeetingModal_vue_vue_type_template_id_06e4b51a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MeetingModal.vue?vue&type=template&id=06e4b51a */ "./resources/js/components/Project/MeetingModal.vue?vue&type=template&id=06e4b51a");
/* harmony import */ var _MeetingModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MeetingModal.vue?vue&type=script&lang=js */ "./resources/js/components/Project/MeetingModal.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _MeetingModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _MeetingModal_vue_vue_type_template_id_06e4b51a__WEBPACK_IMPORTED_MODULE_0__["render"],
  _MeetingModal_vue_vue_type_template_id_06e4b51a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/MeetingModal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/MeetingModal.vue?vue&type=script&lang=js":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Project/MeetingModal.vue?vue&type=script&lang=js ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./MeetingModal.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingModal.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/MeetingModal.vue?vue&type=template&id=06e4b51a":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Project/MeetingModal.vue?vue&type=template&id=06e4b51a ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingModal_vue_vue_type_template_id_06e4b51a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./MeetingModal.vue?vue&type=template&id=06e4b51a */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingModal.vue?vue&type=template&id=06e4b51a");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingModal_vue_vue_type_template_id_06e4b51a__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingModal_vue_vue_type_template_id_06e4b51a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);