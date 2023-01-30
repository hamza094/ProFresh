(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Stage.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Stage.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['slug', 'projectstage', 'completed', 'stage_updated', 'postponed', 'get_stage', 'access'],
  data: function data() {
    return {
      activeStage: '',
      stagePop: false,
      reason: '',
      stages: {},
      status: '',
      stageUpdation: ''
    };
  },
  watch: {
    stagePop: function stagePop(_stagePop) {
      if (_stagePop) {
        document.addEventListener('click', this.offIfClickedOutside);
      }
    }
  },
  methods: {
    stageCondition: function stageCondition(stageId) {
      if (this.projectstage) {
        if (stageId == this.projectstage.id) {
          this.activeStage = "current";
          return 'current';
        }
        this.activeStage = "stages";
        return 'stages';
      }
      if (!this.projectstage) {
        if (this.completed) {
          this.activeStage = "closed";
          return 'closed';
        }
        this.activeStage = "postpone";
        return 'postpone';
      }
    },
    lastStage: function lastStage() {
      if (!this.projectstage && this.completed) {
        this.status = "Closed";
        return "closed";
      }
      if (!this.projectstage && !this.completed) {
        this.status = "Postponed";
        return "postpone";
      }
      if (this.projectstage && !this.completed) {
        this.status = "Clo/Pos..";
        return "stages";
      }
    },
    stageChange: function stageChange(stageId) {
      var _this = this;
      if (stageId !== this.get_stage) {
        axios.patch('/api/v1/projects/' + this.slug + '/stage', {
          stage: stageId
        }).then(function (response) {
          var project = response.data.project;
          _this.eventListener(0, project.stage, project.stage_updated_at, null, project.stage.id);
          _this.$vToastify.success("Updating project stage...");
        })["catch"](function (error) {
          _this.$vToastify.error("Error in Project Phase Conversion");
        });
      }
    },
    postpone: function postpone() {
      var _this2 = this;
      axios.patch('/api/v1/projects/' + this.slug + '/stage', {
        postponed: this.reason
      }).then(function (response) {
        var project = response.data.project;
        _this2.eventListener(0, null, project.stage_updated_at, project.reason, 0);
        _this2.$vToastify.success("Postponeding project...");
        _this2.$modal.hide('stage-reason');
      })["catch"](function (error) {
        _this2.$vToastify.error("Error in Project Postpone");
      });
    },
    projectClose: function projectClose() {
      var _this3 = this;
      axios.patch('/api/v1/projects/' + this.slug + '/stage', {
        completed: 'true'
      }).then(function (response) {
        _this3.eventListener(1, null, response.data.project.stage_updated_at, null, 0);
        _this3.$vToastify.success("Sucessfully closing project...");
      })["catch"](function (error) {
        _this3.$vToastify.error("Error in Project Closing");
      });
    },
    loadStages: function loadStages() {
      var _this4 = this;
      axios.get('/api/v1/stages').then(function (response) {
        _this4.stages = response.data;
      })["catch"](function (error) {
        console.log(error.response.data.errors);
      });
    },
    eventListener: function eventListener($completed, $currentStage, $stageUpdated, $reason, $getStage) {
      this.$bus.emit('stageListners', {
        completed: $completed,
        current_stage: $currentStage,
        stage_updated: $stageUpdated,
        postponed: $reason,
        getStage: $getStage
      });
    },
    offIfClickedOutside: function offIfClickedOutside(event) {
      if (!event.target.closest('.stage-dropdown')) {
        this.stagePop = false;
        document.removeEventListener('click', this.offIfClickedOutside);
      }
    }
  },
  mounted: function mounted() {
    this.loadStages();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("div", [_c("div", [_c("p", [_c("span", [_c("b", [_vm._v("Project Stage Last Updated:")]), _vm._v(" " + _vm._s(_vm.stage_updated))])])]), _vm._v(" "), _vm.access ? _c("div", {
    staticClass: "row"
  }, [_vm._l(_vm.stages, function (stage) {
    return _c("div", {
      key: stage.id,
      staticClass: "arrow-pointer-pd",
      on: {
        click: function click($event) {
          return _vm.stageChange(stage.id);
        }
      }
    }, [_c("p", {
      staticClass: "arrow-pointer",
      "class": _vm.stageCondition(stage.id)
    }, [_c("span", {
      staticClass: "arrow-pointer-span"
    }, [_vm._v(_vm._s(stage.id) + ". " + _vm._s(stage.name))])])]);
  }), _vm._v(" "), _c("div", {
    staticClass: "stage-dropdown",
    on: {
      click: function click($event) {
        _vm.stagePop = !_vm.stagePop;
      }
    }
  }, [_c("p", {
    staticClass: "arrow-pointer",
    "class": _vm.lastStage()
  }, [_c("span", {
    staticClass: "arrow-pointer-span"
  }, [_vm._v(_vm._s(_vm.status) + " "), _c("i", {
    staticClass: "fas fa-angle-double-down"
  })])]), _vm._v(" "), _c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.stagePop,
      expression: "stagePop"
    }],
    staticClass: "stage-dropdown_item"
  }, [_c("ul", [!_vm.completed ? _c("li", {
    staticClass: "stage-dropdown_item-content",
    on: {
      click: _vm.projectClose
    }
  }, [_vm._v("Closure")]) : _vm._e(), _vm._v(" "), _vm.projectstage ? _c("li", {
    staticClass: "stage-dropdown_item-content",
    on: {
      click: function click($event) {
        return _vm.$modal.show("stage-reason");
      }
    }
  }, [_vm._v("Postponed")]) : _vm._e()])])])], 2) : _c("div", [_c("h5", [_vm._v("Only project members and owners are allowed to change the project stage.")])])]), _vm._v(" "), _c("div", [_c("modal", {
    attrs: {
      name: "stage-reason",
      clickToClose: false
    }
  }, [_c("div", {
    staticClass: "panel-top_content"
  }, [_c("span", {
    staticClass: "panel-heading"
  }, [_vm._v("Project Satge Postponed")]), _vm._v(" "), _c("span", {
    staticClass: "panel-exit float-right",
    attrs: {
      role: "button"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.$modal.hide("stage-reason");
      }
    }
  }, [_vm._v("x")])]), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "panel-top_content"
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "unqstage"
    }
  }, [_vm._v("Reason of project to be Postponed:")]), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.reason,
      expression: "reason"
    }],
    staticClass: "custom-select",
    attrs: {
      id: "unqstage",
      name: "unqstage",
      title: "Some placeholder text..."
    },
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.reason = $event.target.multiple ? $$selectedVal : $$selectedVal[0];
      }
    }
  }, [_c("option", {
    attrs: {
      value: "Junk Project"
    }
  }, [_vm._v("Junk Project")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "Unable to reach"
    }
  }, [_vm._v("Unable to reach")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "Not intrested"
    }
  }, [_vm._v("Not intrested")])])])]), _vm._v(" "), _c("div", {
    staticClass: "panel-bottom"
  }, [_c("div", {
    staticClass: "panel-top_content float-right"
  }, [_c("button", {
    staticClass: "btn panel-btn_close",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.$modal.hide("stage-reason");
      }
    }
  }, [_vm._v("Cancel")]), _vm._v(" "), _c("button", {
    staticClass: "btn panel-btn_save",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.postpone.apply(null, arguments);
      }
    }
  }, [_vm._v("Save")])])])])], 1)]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/Stage.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/Project/Stage.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Stage_vue_vue_type_template_id_7359140d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Stage.vue?vue&type=template&id=7359140d& */ "./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d&");
/* harmony import */ var _Stage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Stage.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Stage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Stage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Stage_vue_vue_type_template_id_7359140d___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Stage_vue_vue_type_template_id_7359140d___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Stage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Stage.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Project/Stage.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Stage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Stage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d& ***!
  \**********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_template_id_7359140d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Stage.vue?vue&type=template&id=7359140d& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_template_id_7359140d___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_template_id_7359140d___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);