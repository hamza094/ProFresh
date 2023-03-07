(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[12],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['projects'],
  methods: {
    becomeMember: function becomeMember(slug) {
      var _this = this;
      axios.get('/api/v1/projects/' + slug + '/accept-invitation', {}).then(function (response) {
        _this.$vToastify.success(response.data.message);
        _this.$bus.emit('acceptInvitation', {
          project: response.data.project
        });
      })["catch"](function (error) {
        console.log(error);
        _this.$vToastify.warning("Error! Try Again");
      });
    },
    rejectInvitation: function rejectInvitation(slug) {
      var _this2 = this;
      axios.get('/api/v1/projects/' + slug + '/cancel', {}).then(function (response) {
        _this2.$vToastify.info("The project request has rejected");
      })["catch"](function (error) {
        _this2.$vToastify.warning("Error! Try Again");
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1& ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("p", {
    staticClass: "pro-info"
  }, [_vm._v("Project Invitations")]), _vm._v(" "), this.projects ? _c("div", {
    staticClass: "row"
  }, _vm._l(this.projects, function (project) {
    return _c("div", {
      staticClass: "col-md-5"
    }, [_c("div", {
      staticClass: "card invitation border-secondary"
    }, [_c("div", {
      staticClass: "card-header text-center"
    }, [_vm._v("\n        Project Name: \n        "), _c("router-link", {
      attrs: {
        to: "/projects/" + project.slug
      }
    }, [_vm._v(_vm._s(project.name))])], 1), _vm._v(" "), _c("div", {
      staticClass: "card-body mt-1 text-center"
    }, [_c("p", [_vm._v("Owner Name: \n    "), _c("router-link", {
      attrs: {
        to: "/user/" + project.user.id + "/profile",
        target: "_blank"
      }
    }, [_vm._v(_vm._s(project.user.name))])], 1), _vm._v(" "), _c("p", {
      staticClass: "text-center"
    }, [_c("button", {
      staticClass: "btn btn-primary btn-sm",
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.becomeMember(project.slug);
        }
      }
    }, [_vm._v("Become Member")]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-danger btn-sm",
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.rejectInvitation(project.slug);
        }
      }
    }, [_vm._v("Ignore Invitation")])])]), _vm._v(" "), _c("div", {
      staticClass: "card-footer"
    }, [_c("p", [_vm._v(" 📨\n    Invitation Received On:: "), _c("b", [_vm._v(_vm._s(project.invitation_sent_at))])])])])]);
  }), 0) : _c("div", [_c("h3", [_vm._v("No project Invitation found")])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Profile/ProjectInvitation.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/Profile/ProjectInvitation.vue ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProjectInvitation.vue?vue&type=template&id=485fb2b1& */ "./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1&");
/* harmony import */ var _ProjectInvitation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProjectInvitation.vue?vue&type=script&lang=js& */ "./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProjectInvitation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Profile/ProjectInvitation.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProjectInvitation.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProjectInvitation.vue?vue&type=template&id=485fb2b1& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProjectInvitation.vue?vue&type=template&id=485fb2b1&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectInvitation_vue_vue_type_template_id_485fb2b1___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);