(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[11],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/Avatar.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/Avatar.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_cropperjs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-cropperjs */ "./node_modules/vue-cropperjs/dist/VueCropper.js");
/* harmony import */ var vue_cropperjs__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_cropperjs__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['user'],
  components: {
    VueCropper: vue_cropperjs__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  data: function data() {
    return {
      imageSrc: "",
      croppedImageSrc: "",
      avatar_path: this.user.avatar
    };
  },
  methods: {
    setImage: function setImage(e) {
      var _this = this;
      var file = e.target.files[0];
      if (!file.type.includes("image/")) {
        alert("Please select an image file");
        return;
      }
      if (typeof FileReader === "function") {
        var reader = new FileReader();
        reader.onload = function (event) {
          _this.imageSrc = event.target.result;

          // Rebuild cropperjs with the updated source
          _this.$refs.cropper.replace(event.target.result);
        };
        reader.readAsDataURL(file);
      } else {
        alert("Sorry, FileReader API not supported");
      }
    },
    cropImage: function cropImage() {
      // Get image data for post processing, e.g. upload or setting image src
      this.croppedImageSrc = this.$refs.cropper.getCroppedCanvas().toDataURL();
    },
    uploadImage: function uploadImage() {
      Vue.prototype.$userId = this.user.id;
      this.$vToastify.info({
        title: 'Loading...',
        body: 'User Avatar Uploading',
        position: "bottom-left",
        theme: "light",
        duration: 3000,
        mode: "loader"
      });
      this.$refs.cropper.getCroppedCanvas().toBlob(function (blob) {
        var profile = Vue.prototype.$userId;
        var formData = new FormData();
        // Append image file
        formData.append("avatar", blob);
        axios.post('/api/user/' + profile + '/avatar', formData).then(function (response) {
          window.location.reload();
        })["catch"](function (error) {
          //Vue.prototype.$notif;
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/Avatar.vue?vue&type=template&id=a240ef6c&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/Avatar.vue?vue&type=template&id=a240ef6c& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "col-md-2"
  }, [_c("div", {
    staticClass: "img-avatar",
    on: {
      click: function click($event) {
        return _vm.$modal.show("avatar-file");
      }
    }
  }, [!_vm.user.avatar ? _c("div", {
    staticClass: "img-avatar_name"
  }, [_vm._v("\n                " + _vm._s(_vm.user.name.substring(0, 1)) + "\n            ")]) : _c("div", [_c("img", {
    staticClass: "main-profile-img",
    attrs: {
      src: _vm.avatar_path,
      alt: ""
    }
  })]), _vm._v(" "), _vm._m(0)]), _vm._v(" "), _c("modal", {
    attrs: {
      name: "avatar-file",
      height: "auto"
    }
  }, [_c("div", {
    staticClass: "p-3 bg-white shadow rounded-lg img_avarar"
  }, [_c("input", {
    attrs: {
      type: "file",
      name: "avatar",
      id: "file",
      accept: "image/*",
      value: "Upload Avatar"
    },
    on: {
      change: _vm.setImage
    }
  }), _vm._v(" "), _c("img", {
    attrs: {
      src: _vm.imageSrc,
      width: "100"
    }
  }), _vm._v(" "), this.imageSrc ? _c("div", {
    staticClass: "my-3 d-flex align-items-center justify-content-center mx-auto"
  }, [_c("vue-cropper", {
    ref: "cropper",
    staticClass: "mr-2 w-50",
    attrs: {
      guides: true,
      src: _vm.imageSrc,
      aspectRatio: 0.9
    }
  }), _vm._v(" "), _c("img", {
    staticClass: "ml-2 w-50 bg-light",
    attrs: {
      src: _vm.croppedImageSrc
    }
  })], 1) : _vm._e(), _vm._v(" "), this.imageSrc ? _c("button", {
    staticClass: "btn panel-btn_close",
    on: {
      click: _vm.cropImage
    }
  }, [_vm._v("Crop")]) : _vm._e(), _vm._v(" "), this.croppedImageSrc ? _c("button", {
    staticClass: "btn panel-btn_save",
    on: {
      click: function click($event) {
        return _vm.uploadImage();
      }
    }
  }, [_vm._v("Upload")]) : _vm._e()])])], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "img-avatar_overlay"
  }, [_c("div", {
    staticClass: "img-avatar_overlay-text"
  }, [_vm._v("Update")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Profile/Avatar.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/Profile/Avatar.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Avatar_vue_vue_type_template_id_a240ef6c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Avatar.vue?vue&type=template&id=a240ef6c& */ "./resources/js/components/Profile/Avatar.vue?vue&type=template&id=a240ef6c&");
/* harmony import */ var _Avatar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Avatar.vue?vue&type=script&lang=js& */ "./resources/js/components/Profile/Avatar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Avatar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Avatar_vue_vue_type_template_id_a240ef6c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Avatar_vue_vue_type_template_id_a240ef6c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Profile/Avatar.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Profile/Avatar.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Profile/Avatar.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Avatar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Avatar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/Avatar.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Avatar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Profile/Avatar.vue?vue&type=template&id=a240ef6c&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/Profile/Avatar.vue?vue&type=template&id=a240ef6c& ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Avatar_vue_vue_type_template_id_a240ef6c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Avatar.vue?vue&type=template&id=a240ef6c& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/Avatar.vue?vue&type=template&id=a240ef6c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Avatar_vue_vue_type_template_id_a240ef6c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Avatar_vue_vue_type_template_id_a240ef6c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);