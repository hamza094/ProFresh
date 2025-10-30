(window['webpackJsonp'] = window['webpackJsonp'] || []).push([
  [2],
  {
    /***/ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Feature/FeatureSection.vue?vue&type=script&lang=js':
      /*!****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Feature/FeatureSection.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var js_file_download__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
          /*! js-file-download */ './node_modules/js-file-download/file-download.js',
        );
        /* harmony import */ var js_file_download__WEBPACK_IMPORTED_MODULE_0___default =
          /*#__PURE__*/ __webpack_require__.n(js_file_download__WEBPACK_IMPORTED_MODULE_0__);
        /* harmony import */ var _Message_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
          /*! ./Message.vue */ './resources/js/components/Project/Feature/Message.vue',
        );
        /* harmony import */ var _FeatureDropdown_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
          /*! ../../FeatureDropdown.vue */ './resources/js/components/FeatureDropdown.vue',
        );

        /* harmony default export */ __webpack_exports__['default'] = {
          components: {
            ProjectMessage: _Message_vue__WEBPACK_IMPORTED_MODULE_1__['default'],
            FeatureDropdown: _FeatureDropdown_vue__WEBPACK_IMPORTED_MODULE_2__['default'],
          },
          props: ['slug', 'members', 'name'],
          data: function data() {
            return {
              projectmembers: this.members,
              featurePop: false,
              errors: {},
            };
          },
          watch: {
            stagePop: function stagePop(featurePop) {
              var _this = this;
              if (featurePop) {
                document.addEventListener('click', function (event) {
                  return _this.$options.methods.handleClickOutside.call(
                    _this,
                    event,
                    '.feature-dropdown',
                    _this.featurePop,
                  );
                });
              }
            },
          },
          methods: {
            abandon: function abandon() {
              this.performAction('Yes, abandon it!', axios['delete']('/api/v1/projects/' + this.slug));
            },
            deleteProject: function deleteProject() {
              this.performAction('Yes, delete it!', axios.get('/api/v1/projects/' + this.slug + '/delete'));
            },
            exportProject: function exportProject() {
              var _this2 = this;
              axios
                .get('/api/v1/projects/' + this.slug + '/export', {
                  responseType: 'blob',
                  headers: {
                    Accept: 'multipart/form-data',
                  },
                })
                .then(function (response) {
                  js_file_download__WEBPACK_IMPORTED_MODULE_0___default()(
                    response.data,
                    'Project ' + _this2.slug + '.xls',
                  );
                })
                ['catch'](function (error) {
                  console.log(error.response.data);
                });
            },
          },
        };

        /***/
      },

    /***/ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Feature/FeatureSection.vue?vue&type=template&id=2f9b7169':
      /*!**************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Feature/FeatureSection.vue?vue&type=template&id=2f9b7169 ***!
  \**************************************************************************************************************************************************************************************************************************************************************/
      /*! exports provided: render, staticRenderFns */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, 'render', function () {
          return render;
        });
        /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, 'staticRenderFns', function () {
          return staticRenderFns;
        });
        var render = function render() {
          var _vm = this,
            _c = _vm._self._c;
          return _c(
            'div',
            {
              staticClass: 'float-right',
            },
            [
              _c(
                'FeatureDropdown',
                {
                  attrs: {
                    featurePop: this.featurePop,
                  },
                },
                [
                  _c('ul', [
                    _c(
                      'li',
                      {
                        staticClass: 'feature-dropdown_item-content',
                        on: {
                          click: function click($event) {
                            return _vm.abandon();
                          },
                        },
                      },
                      [
                        _c('i', {
                          staticClass: 'fas fa-eye-slash',
                        }),
                        _vm._v(' Abandon'),
                      ],
                    ),
                    _vm._v(' '),
                    _c(
                      'li',
                      {
                        staticClass: 'feature-dropdown_item-content',
                        on: {
                          click: function click($event) {
                            return _vm.$modal.show('project-message');
                          },
                        },
                      },
                      [
                        _c('i', {
                          staticClass: 'far fa-envelope',
                        }),
                        _vm._v('Send Mail or Sms'),
                      ],
                    ),
                    _vm._v(' '),
                    _c(
                      'li',
                      {
                        staticClass: 'feature-dropdown_item-content',
                        on: {
                          click: function click($event) {
                            return _vm.exportProject();
                          },
                        },
                      },
                      [
                        _c('i', {
                          staticClass: 'fas fa-upload',
                        }),
                        _vm._v(' Export'),
                      ],
                    ),
                    _vm._v(' '),
                    _c(
                      'li',
                      {
                        staticClass: 'feature-dropdown_item-content',
                        on: {
                          click: _vm.deleteProject,
                        },
                      },
                      [
                        _c('i', {
                          staticClass: 'fas fa-ban',
                        }),
                        _vm._v(' Delete'),
                      ],
                    ),
                  ]),
                ],
              ),
              _vm._v(' '),
              _c('ProjectMessage', {
                attrs: {
                  slug: _vm.slug,
                  members: _vm.members,
                },
              }),
            ],
            1,
          );
        };
        var staticRenderFns = [];
        render._withStripped = true;

        /***/
      },

    /***/ './node_modules/js-file-download/file-download.js':
      /*!********************************************************!*\
  !*** ./node_modules/js-file-download/file-download.js ***!
  \********************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        module.exports = function (data, filename, mime, bom) {
          var blobData = typeof bom !== 'undefined' ? [bom, data] : [data];
          var blob = new Blob(blobData, { type: mime || 'application/octet-stream' });
          if (typeof window.navigator.msSaveBlob !== 'undefined') {
            // IE workaround for "HTML7007: One or more blob URLs were
            // revoked by closing the blob for which they were created.
            // These URLs will no longer resolve as the data backing
            // the URL has been freed."
            window.navigator.msSaveBlob(blob, filename);
          } else {
            var blobURL =
              window.URL && window.URL.createObjectURL
                ? window.URL.createObjectURL(blob)
                : window.webkitURL.createObjectURL(blob);
            var tempLink = document.createElement('a');
            tempLink.style.display = 'none';
            tempLink.href = blobURL;
            tempLink.setAttribute('download', filename);

            // Safari thinks _blank anchor are pop ups. We only want to set _blank
            // target if the browser does not support the HTML5 download attribute.
            // This allows you to download files in desktop safari if pop up blocking
            // is enabled.
            if (typeof tempLink.download === 'undefined') {
              tempLink.setAttribute('target', '_blank');
            }

            document.body.appendChild(tempLink);
            tempLink.click();

            // Fixes "webkit blob resource error 1"
            setTimeout(function () {
              document.body.removeChild(tempLink);
              window.URL.revokeObjectURL(blobURL);
            }, 200);
          }
        };

        /***/
      },

    /***/ './resources/js/components/Project/Feature/FeatureSection.vue':
      /*!********************************************************************!*\
  !*** ./resources/js/components/Project/Feature/FeatureSection.vue ***!
  \********************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _FeatureSection_vue_vue_type_template_id_2f9b7169__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! ./FeatureSection.vue?vue&type=template&id=2f9b7169 */ './resources/js/components/Project/Feature/FeatureSection.vue?vue&type=template&id=2f9b7169',
          );
        /* harmony import */ var _FeatureSection_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ =
          __webpack_require__(
            /*! ./FeatureSection.vue?vue&type=script&lang=js */ './resources/js/components/Project/Feature/FeatureSection.vue?vue&type=script&lang=js',
          );
        /* empty/unused harmony star reexport */ /* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ =
          __webpack_require__(
            /*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ './node_modules/vue-loader/lib/runtime/componentNormalizer.js',
          );

        /* normalize component */

        var component = Object(
          _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__['default'],
        )(
          _FeatureSection_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__['default'],
          _FeatureSection_vue_vue_type_template_id_2f9b7169__WEBPACK_IMPORTED_MODULE_0__['render'],
          _FeatureSection_vue_vue_type_template_id_2f9b7169__WEBPACK_IMPORTED_MODULE_0__['staticRenderFns'],
          false,
          null,
          null,
          null,
        );

        /* hot reload */
        if (false) {
          var api;
        }
        component.options.__file = 'resources/js/components/Project/Feature/FeatureSection.vue';
        /* harmony default export */ __webpack_exports__['default'] = component.exports;

        /***/
      },

    /***/ './resources/js/components/Project/Feature/FeatureSection.vue?vue&type=script&lang=js':
      /*!********************************************************************************************!*\
  !*** ./resources/js/components/Project/Feature/FeatureSection.vue?vue&type=script&lang=js ***!
  \********************************************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureSection_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./FeatureSection.vue?vue&type=script&lang=js */ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Feature/FeatureSection.vue?vue&type=script&lang=js',
          );
        /* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__['default'] =
          _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureSection_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__[
            'default'
          ];

        /***/
      },

    /***/ './resources/js/components/Project/Feature/FeatureSection.vue?vue&type=template&id=2f9b7169':
      /*!**************************************************************************************************!*\
  !*** ./resources/js/components/Project/Feature/FeatureSection.vue?vue&type=template&id=2f9b7169 ***!
  \**************************************************************************************************/
      /*! exports provided: render, staticRenderFns */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureSection_vue_vue_type_template_id_2f9b7169__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./FeatureSection.vue?vue&type=template&id=2f9b7169 */ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Feature/FeatureSection.vue?vue&type=template&id=2f9b7169',
          );
        /* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, 'render', function () {
          return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureSection_vue_vue_type_template_id_2f9b7169__WEBPACK_IMPORTED_MODULE_0__[
            'render'
          ];
        });

        /* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, 'staticRenderFns', function () {
          return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_FeatureSection_vue_vue_type_template_id_2f9b7169__WEBPACK_IMPORTED_MODULE_0__[
            'staticRenderFns'
          ];
        });

        /***/
      },
  },
]);
