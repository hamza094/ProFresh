(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[27],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Stage.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Stage.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['slug', 'stage_updated', 'postponed_reason', 'get_stage', 'access'],
  data: function data() {
    return {
      reason: '',
      stages: {},
      selectedStage: 0
    };
  },
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('project', ['updateStage'])), {}, {
    getStageClass: function getStageClass(stage) {
      if (this.get_stage === stage.id) {
        if (stage.name === "Postponed") return "postpone";
        if (stage.name === "Completed") return "closed";
        return "current";
      }
      return "stages";
    },
    handleStageClick: function handleStageClick(stage) {
      if (stage.name === "Postponed") {
        this.selectedStage = stage.id;
        this.$modal.show("stage-reason");
      } else {
        this.stageChange(stage.id);
      }
    },
    updateProject: function updateProject(data) {
      var _this = this;
      this.$Progress.start();
      axios.patch("/api/v1/projects/".concat(this.slug, "/stage"), data).then(function (response) {
        _this.$Progress.finish();
        var project = response.data.project;
        var eventData = {
          current_stage: project.stage || null,
          stage_updated: project.stage_updated_at,
          postponed_reason: project.postponed_reason || null,
          getStage: project.stage ? project.stage.id : 0
        };
        _this.updateStage(eventData);
        _this.$vToastify.success("Successfully update");
      })["catch"](function (error) {
        _this.$Progress.fail();
        _this.$vToastify.error("Error in Project Phase Conversion");
      });
      this.selectedStage = 0;
    },
    stageChange: function stageChange(stageId) {
      if (stageId === this.get_stage) {
        return this.$vToastify.error("Stage already selected");
      }
      this.updateProject({
        stage: stageId
      });
    },
    postpone: function postpone() {
      this.updateProject({
        stage: this.selectedStage,
        postponed_reason: this.reason
      });
      this.$modal.hide('stage-reason');
    },
    loadStages: function loadStages() {
      var _this2 = this;
      axios.get('/api/v1/stages').then(function (response) {
        _this2.stages = response.data;
      })["catch"](function (error) {
        console.log(error.response.data.errors);
      });
    }
  }),
  mounted: function mounted() {
    this.loadStages();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
  }, [_c("ul", {
    staticClass: "d-flex flex-wrap ml-2 list-unstyled m-0 p-0 w-100"
  }, _vm._l(_vm.stages, function (stage) {
    return _c("li", {
      key: stage.id,
      staticClass: "arrow-pointer-pd me-3",
      on: {
        click: function click($event) {
          return _vm.handleStageClick(stage);
        }
      }
    }, [_c("p", {
      staticClass: "arrow-pointer",
      "class": _vm.getStageClass(stage)
    }, [_c("span", {
      staticClass: "arrow-pointer-span"
    }, [_vm._v(_vm._s(stage.id) + ". " + _vm._s(stage.name))])])]);
  }), 0)]) : _c("div", [_c("h5", [_vm._v("Only project members and owners are allowed to change the project stage.")])])]), _vm._v(" "), _c("div", [_c("modal", {
    attrs: {
      name: "stage-reason",
      clickToClose: false,
      height: 260,
      adaptive: true
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
  }, [_vm._v("\r\n        x\r\n      ")])]), _vm._v(" "), _c("div", {
    staticClass: "panel-top_content"
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "label-name",
    attrs: {
      "for": "unqstage"
    }
  }, [_vm._v("Reason of project to be Postponed:")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.reason,
      expression: "reason"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      name: "unqstage",
      id: "unqstage"
    },
    domProps: {
      value: _vm.reason
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.reason = $event.target.value;
      }
    }
  })])]), _vm._v(" "), _c("div", {
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
  }, [_vm._v("Save")])])])], 1)]);
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
/* harmony import */ var _Stage_vue_vue_type_template_id_7359140d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Stage.vue?vue&type=template&id=7359140d */ "./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d");
/* harmony import */ var _Stage_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Stage.vue?vue&type=script&lang=js */ "./resources/js/components/Project/Stage.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Stage_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Stage_vue_vue_type_template_id_7359140d__WEBPACK_IMPORTED_MODULE_0__["render"],
  _Stage_vue_vue_type_template_id_7359140d__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/Project/Stage.vue?vue&type=script&lang=js":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Project/Stage.vue?vue&type=script&lang=js ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Stage.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Stage.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_template_id_7359140d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Stage.vue?vue&type=template&id=7359140d */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Stage.vue?vue&type=template&id=7359140d");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_template_id_7359140d__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Stage_vue_vue_type_template_id_7359140d__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);