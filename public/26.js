(window['webpackJsonp'] = window['webpackJsonp'] || []).push([
  [26],
  {
    /***/ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js':
      /*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _mixins_activityMixins__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
          /*! @/mixins/activityMixins */ './resources/js/mixins/activityMixins.js',
        );

        /* harmony default export */ __webpack_exports__['default'] = {
          mixins: [_mixins_activityMixins__WEBPACK_IMPORTED_MODULE_0__['default']],
          props: ['activities', 'slug', 'name'],
          data: function data() {
            return {
              icon: '',
            };
          },
          watch: {},
          methods: {
            // Fetch activities design from mixin
            activityIcon: function activityIcon(description) {
              return this.getIcon(description);
            },
            activityColor: function activityColor(description) {
              return this.getColor(description);
            },
          },
        };

        /***/
      },

    /***/ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e':
      /*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e ***!
  \********************************************************************************************************************************************************************************************************************************************************/
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
              staticClass: 'col-md-7 mb-5',
            },
            [
              _c(
                'div',
                {
                  staticClass: 'activity',
                },
                [
                  _c(
                    'ul',
                    [
                      _vm._l(this.activities, function (activity, index) {
                        return _c(
                          'li',
                          {
                            key: activity.id,
                          },
                          [
                            _c(
                              'span',
                              {
                                staticClass: 'activity-icon',
                                class: _vm.activityColor(activity.description),
                              },
                              [
                                _c('i', {
                                  class: _vm.activityIcon(activity.description),
                                }),
                              ],
                            ),
                            _vm._v('\n            ' + _vm._s(activity.description) + '\n             '),
                            _c(
                              'p',
                              {
                                staticClass: 'activity-info',
                              },
                              [
                                _c('span', {
                                  domProps: {
                                    textContent: _vm._s(activity.user.name),
                                  },
                                }),
                                _c('span', {
                                  staticClass: 'activity-info_dot',
                                }),
                                _c('span', {
                                  domProps: {
                                    textContent: _vm._s(activity.time),
                                  },
                                }),
                              ],
                            ),
                          ],
                        );
                      }),
                      _vm._v(' '),
                      _c('li', [
                        _c(
                          'span',
                          {
                            staticClass: 'activity-more',
                          },
                          [
                            _c(
                              'router-link',
                              {
                                staticClass: 'dashboard-link',
                                attrs: {
                                  to: '/project/' + this.name + '/' + this.slug + '/activities',
                                },
                              },
                              [_vm._v('View More')],
                            ),
                          ],
                          1,
                        ),
                      ]),
                    ],
                    2,
                  ),
                ],
              ),
            ],
          );
        };
        var staticRenderFns = [];
        render._withStripped = true;

        /***/
      },

    /***/ './resources/js/components/Project/RecentActivities.vue':
      /*!**************************************************************!*\
  !*** ./resources/js/components/Project/RecentActivities.vue ***!
  \**************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _RecentActivities_vue_vue_type_template_id_7cf40d2e__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! ./RecentActivities.vue?vue&type=template&id=7cf40d2e */ './resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e',
          );
        /* harmony import */ var _RecentActivities_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ =
          __webpack_require__(
            /*! ./RecentActivities.vue?vue&type=script&lang=js */ './resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js',
          );
        /* empty/unused harmony star reexport */ /* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ =
          __webpack_require__(
            /*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ './node_modules/vue-loader/lib/runtime/componentNormalizer.js',
          );

        /* normalize component */

        var component = Object(
          _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__['default'],
        )(
          _RecentActivities_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__['default'],
          _RecentActivities_vue_vue_type_template_id_7cf40d2e__WEBPACK_IMPORTED_MODULE_0__['render'],
          _RecentActivities_vue_vue_type_template_id_7cf40d2e__WEBPACK_IMPORTED_MODULE_0__['staticRenderFns'],
          false,
          null,
          null,
          null,
        );

        /* hot reload */
        if (false) {
          var api;
        }
        component.options.__file = 'resources/js/components/Project/RecentActivities.vue';
        /* harmony default export */ __webpack_exports__['default'] = component.exports;

        /***/
      },

    /***/ './resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js':
      /*!**************************************************************************************!*\
  !*** ./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js ***!
  \**************************************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./RecentActivities.vue?vue&type=script&lang=js */ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js',
          );
        /* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__['default'] =
          _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__[
            'default'
          ];

        /***/
      },

    /***/ './resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e':
      /*!********************************************************************************************!*\
  !*** ./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e ***!
  \********************************************************************************************/
      /*! exports provided: render, staticRenderFns */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_template_id_7cf40d2e__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./RecentActivities.vue?vue&type=template&id=7cf40d2e */ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e',
          );
        /* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, 'render', function () {
          return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_template_id_7cf40d2e__WEBPACK_IMPORTED_MODULE_0__[
            'render'
          ];
        });

        /* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, 'staticRenderFns', function () {
          return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_template_id_7cf40d2e__WEBPACK_IMPORTED_MODULE_0__[
            'staticRenderFns'
          ];
        });

        /***/
      },
  },
]);
