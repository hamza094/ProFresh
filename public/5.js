(window['webpackJsonp'] = window['webpackJsonp'] || []).push([
  [5],
  {
    /***/ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Notification.vue?vue&type=script&lang=js':
      /*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Notification.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony default export */ __webpack_exports__['default'] = {
          data: function data() {
            return {
              notifications: false,
            };
          },
          created: function created() {
            this.fetchNotifications();
            this.listenNotifications();
          },
          computed: {
            user: {
              get: function get() {
                return this.$store.state.currentUser.user;
              },
            },
          },
          methods: {
            fetchNotifications: function fetchNotifications() {
              var _this = this;
              axios.get('/api/v1/users/' + this.user.uuid + '/notifications').then(function (response) {
                _this.notifications = response.data;
                console.log(_this.notifications);
              });
            },
            markAsRead: function markAsRead(notification) {
              axios['delete']('/api/v1/users/' + this.user.uuid + '/notifications/' + notification.id).then(
                function (response) {
                  notification.read_at = new Date().toISOString();
                },
              );
            },
            listenNotifications: function listenNotifications() {
              var _this2 = this;
              Echo['private']('App.Models.User.' + this.user.id).notification(function (notification) {
                _this2.$vToastify.success('You have one new notification');
                _this2.fetchNotifications();
              });
            },
            getPostBody: function getPostBody(notification) {
              var body = this.stripTags(notification.message);
              return body.slice(0, 40) + (body.length > 40 ? '...' : '');
            },
            stripTags: function stripTags(text) {
              return text.replace(/(<([^>]+)>)/gi, '');
            },
          },
        };

        /***/
      },

    /***/ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Notification.vue?vue&type=template&id=6a4ce154':
      /*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Notification.vue?vue&type=template&id=6a4ce154 ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
          return _c('div', [
            _c(
              'li',
              {
                staticClass: 'dropdown mr-5',
              },
              [
                _c(
                  'a',
                  {
                    staticClass: 'notification',
                    attrs: {
                      href: '#',
                      'data-toggle': 'dropdown',
                    },
                  },
                  [
                    _c('i', {
                      staticClass: 'far fa-bell notification-icon',
                    }),
                    _vm._v(' '),
                    _vm.notifications.length
                      ? _c('span', {
                          staticClass: 'notification-count',
                        })
                      : _vm._e(),
                  ],
                ),
                _vm._v(' '),
                _c(
                  'ul',
                  {
                    staticClass: 'dropdown-menu dropdown-menu-right rt',
                  },
                  [
                    _c(
                      'div',
                      {
                        staticClass: 'notify-link',
                      },
                      [
                        _c(
                          'li',
                          {
                            staticClass: 'notification-header',
                          },
                          [_vm._v('Notifications')],
                        ),
                        _vm._v(' '),
                        !_vm.notifications.length
                          ? _c(
                              'li',
                              {
                                staticClass: 'mt-2 mr-4 ml-4',
                              },
                              [_vm._v('No new notifications')],
                            )
                          : _vm._e(),
                        _vm._v(' '),
                        _vm._l(_vm.notifications, function (notification) {
                          return _c(
                            'li',
                            {
                              key: notification.id,
                              staticClass: 'notification-list dropdown-item',
                              class: {
                                'notification-unread': !notification.read_at,
                              },
                            },
                            [
                              _c(
                                'router-link',
                                {
                                  staticClass: 'notification-wrapper',
                                  attrs: {
                                    to: notification.link.slice(7),
                                  },
                                  nativeOn: {
                                    click: function click($event) {
                                      return _vm.markAsRead(notification);
                                    },
                                  },
                                },
                                [
                                  notification.notifier.avatar
                                    ? _c('img', {
                                        staticClass: 'notification_avatar',
                                        attrs: {
                                          src: notification.notifier.avatar,
                                          alt: notification.notifier.name,
                                        },
                                      })
                                    : _vm._e(),
                                  _vm._v(' '),
                                  _c(
                                    'div',
                                    {
                                      staticClass: 'notification-content',
                                    },
                                    [
                                      _c(
                                        'div',
                                        {
                                          staticClass: 'notification-message',
                                        },
                                        [
                                          _c('strong', [_vm._v(_vm._s(notification.notifier.name))]),
                                          _vm._v('\n         ' + _vm._s(notification.message) + '\n        '),
                                          !notification.read_at
                                            ? _c('span', {
                                                staticClass: 'notification-unread_dot',
                                              })
                                            : _vm._e(),
                                        ],
                                      ),
                                      _vm._v(' '),
                                      _c(
                                        'small',
                                        {
                                          staticClass: 'notification-time',
                                        },
                                        [_c('i', [_vm._v(_vm._s(notification.created_at))])],
                                      ),
                                    ],
                                  ),
                                ],
                              ),
                            ],
                            1,
                          );
                        }),
                        _vm._v(' '),
                        _vm.notifications.length
                          ? _c(
                              'li',
                              {
                                staticClass: 'notification-footer',
                              },
                              [
                                _c(
                                  'router-link',
                                  {
                                    staticClass: 'notification-footer_view-all-links',
                                    attrs: {
                                      to: '/notifications',
                                    },
                                  },
                                  [_vm._v('\n    Show All Notifications\n  ')],
                                ),
                              ],
                              1,
                            )
                          : _vm._e(),
                      ],
                      2,
                    ),
                  ],
                ),
              ],
            ),
          ]);
        };
        var staticRenderFns = [];
        render._withStripped = true;

        /***/
      },

    /***/ './resources/js/components/Notification.vue':
      /*!**************************************************!*\
  !*** ./resources/js/components/Notification.vue ***!
  \**************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _Notification_vue_vue_type_template_id_6a4ce154__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! ./Notification.vue?vue&type=template&id=6a4ce154 */ './resources/js/components/Notification.vue?vue&type=template&id=6a4ce154',
          );
        /* harmony import */ var _Notification_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ =
          __webpack_require__(
            /*! ./Notification.vue?vue&type=script&lang=js */ './resources/js/components/Notification.vue?vue&type=script&lang=js',
          );
        /* empty/unused harmony star reexport */ /* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ =
          __webpack_require__(
            /*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ './node_modules/vue-loader/lib/runtime/componentNormalizer.js',
          );

        /* normalize component */

        var component = Object(
          _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__['default'],
        )(
          _Notification_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__['default'],
          _Notification_vue_vue_type_template_id_6a4ce154__WEBPACK_IMPORTED_MODULE_0__['render'],
          _Notification_vue_vue_type_template_id_6a4ce154__WEBPACK_IMPORTED_MODULE_0__['staticRenderFns'],
          false,
          null,
          null,
          null,
        );

        /* hot reload */
        if (false) {
          var api;
        }
        component.options.__file = 'resources/js/components/Notification.vue';
        /* harmony default export */ __webpack_exports__['default'] = component.exports;

        /***/
      },

    /***/ './resources/js/components/Notification.vue?vue&type=script&lang=js':
      /*!**************************************************************************!*\
  !*** ./resources/js/components/Notification.vue?vue&type=script&lang=js ***!
  \**************************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Notification_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Notification.vue?vue&type=script&lang=js */ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Notification.vue?vue&type=script&lang=js',
          );
        /* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__['default'] =
          _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Notification_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__[
            'default'
          ];

        /***/
      },

    /***/ './resources/js/components/Notification.vue?vue&type=template&id=6a4ce154':
      /*!********************************************************************************!*\
  !*** ./resources/js/components/Notification.vue?vue&type=template&id=6a4ce154 ***!
  \********************************************************************************/
      /*! exports provided: render, staticRenderFns */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Notification_vue_vue_type_template_id_6a4ce154__WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./Notification.vue?vue&type=template&id=6a4ce154 */ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Notification.vue?vue&type=template&id=6a4ce154',
          );
        /* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, 'render', function () {
          return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Notification_vue_vue_type_template_id_6a4ce154__WEBPACK_IMPORTED_MODULE_0__[
            'render'
          ];
        });

        /* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, 'staticRenderFns', function () {
          return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Notification_vue_vue_type_template_id_6a4ce154__WEBPACK_IMPORTED_MODULE_0__[
            'staticRenderFns'
          ];
        });

        /***/
      },
  },
]);
