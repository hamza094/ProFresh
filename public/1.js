(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Modal_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Modal.vue */ "./resources/js/components/Project/Panel/Modal.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    TaskModal: _Modal_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: ['slug'],
  data: function data() {
    return {
      state: 'archived'
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapState"])('task', ['archivedTasks', 'message'])),
  methods: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])('task', ['loadArchiveTasks'])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapMutations"])('SingleTask', ['setTask'])), {}, {
    closePanel: function closePanel() {
      this.$emit("closePanel", {});
    },
    openModal: function openModal(task) {
      this.setTask(task);
      this.$modal.show('archive-task-modal');
    },
    closeModal: function closeModal() {
      this.setTask([]);
    }
  }),
  created: function created() {
    var slug = this.$route.params.slug;
    this.loadArchiveTasks(slug);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=template&id=95cdfd90&scoped=true":
/*!**********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=template&id=95cdfd90&scoped=true ***!
  \**********************************************************************************************************************************************************************************************************************************************************************/
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
  }, [_vm._v(_vm._s(this.message))]), _vm._v(" "), _c("span", {
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
    staticClass: "panel-top_content"
  }, [_vm.archivedTasks && _vm.archivedTasks.length > 0 ? _c("div", _vm._l(_vm.archivedTasks, function (task, index) {
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
    }, [_c("span", [_vm._v(_vm._s(task.title))])])])]);
  }), 0) : _c("div", [_c("p", [_vm._v("Sorry, no tasks found.")])]), _vm._v(" "), _c("modal", {
    staticClass: "model-desin archive-modal",
    attrs: {
      name: "archive-task-modal",
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
  })], 1)], 1)]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\r\n/* Your component-specific styles here */\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./resources/js/components/Project/Panel/ArchiveTasks.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/Project/Panel/ArchiveTasks.vue ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ArchiveTasks_vue_vue_type_template_id_95cdfd90_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ArchiveTasks.vue?vue&type=template&id=95cdfd90&scoped=true */ "./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=template&id=95cdfd90&scoped=true");
/* harmony import */ var _ArchiveTasks_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ArchiveTasks.vue?vue&type=script&lang=js */ "./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _ArchiveTasks_vue_vue_type_style_index_0_id_95cdfd90_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css */ "./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _ArchiveTasks_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _ArchiveTasks_vue_vue_type_template_id_95cdfd90_scoped_true__WEBPACK_IMPORTED_MODULE_0__["render"],
  _ArchiveTasks_vue_vue_type_template_id_95cdfd90_scoped_true__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "95cdfd90",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/ArchiveTasks.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=script&lang=js":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=script&lang=js ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ArchiveTasks.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css ***!
  \************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_style_index_0_id_95cdfd90_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=style&index=0&id=95cdfd90&scoped=true&lang=css");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_style_index_0_id_95cdfd90_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_style_index_0_id_95cdfd90_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_style_index_0_id_95cdfd90_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_style_index_0_id_95cdfd90_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=template&id=95cdfd90&scoped=true":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=template&id=95cdfd90&scoped=true ***!
  \**********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_template_id_95cdfd90_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ArchiveTasks.vue?vue&type=template&id=95cdfd90&scoped=true */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/ArchiveTasks.vue?vue&type=template&id=95cdfd90&scoped=true");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_template_id_95cdfd90_scoped_true__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ArchiveTasks_vue_vue_type_template_id_95cdfd90_scoped_true__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);