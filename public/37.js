(window['webpackJsonp'] = window['webpackJsonp'] || []).push([
  [37],
  {
    /***/ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&':
      /*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Activities.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        function _typeof(o) {
          '@babel/helpers - typeof';
          return (
            (_typeof =
              'function' == typeof Symbol && 'symbol' == typeof Symbol.iterator
                ? function (o) {
                    return typeof o;
                  }
                : function (o) {
                    return o && 'function' == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype
                      ? 'symbol'
                      : typeof o;
                  }),
            _typeof(o)
          );
        }
        function _regeneratorRuntime() {
          'use strict';
          /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime =
            function _regeneratorRuntime() {
              return e;
            };
          var t,
            e = {},
            r = Object.prototype,
            n = r.hasOwnProperty,
            o =
              Object.defineProperty ||
              function (t, e, r) {
                t[e] = r.value;
              },
            i = 'function' == typeof Symbol ? Symbol : {},
            a = i.iterator || '@@iterator',
            c = i.asyncIterator || '@@asyncIterator',
            u = i.toStringTag || '@@toStringTag';
          function define(t, e, r) {
            return (Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]);
          }
          try {
            define({}, '');
          } catch (t) {
            define = function define(t, e, r) {
              return (t[e] = r);
            };
          }
          function wrap(t, e, r, n) {
            var i = e && e.prototype instanceof Generator ? e : Generator,
              a = Object.create(i.prototype),
              c = new Context(n || []);
            return (o(a, '_invoke', { value: makeInvokeMethod(t, r, c) }), a);
          }
          function tryCatch(t, e, r) {
            try {
              return { type: 'normal', arg: t.call(e, r) };
            } catch (t) {
              return { type: 'throw', arg: t };
            }
          }
          e.wrap = wrap;
          var h = 'suspendedStart',
            l = 'suspendedYield',
            f = 'executing',
            s = 'completed',
            y = {};
          function Generator() {}
          function GeneratorFunction() {}
          function GeneratorFunctionPrototype() {}
          var p = {};
          define(p, a, function () {
            return this;
          });
          var d = Object.getPrototypeOf,
            v = d && d(d(values([])));
          v && v !== r && n.call(v, a) && (p = v);
          var g = (GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p));
          function defineIteratorMethods(t) {
            ['next', 'throw', 'return'].forEach(function (e) {
              define(t, e, function (t) {
                return this._invoke(e, t);
              });
            });
          }
          function AsyncIterator(t, e) {
            function invoke(r, o, i, a) {
              var c = tryCatch(t[r], t, o);
              if ('throw' !== c.type) {
                var u = c.arg,
                  h = u.value;
                return h && 'object' == _typeof(h) && n.call(h, '__await')
                  ? e.resolve(h.__await).then(
                      function (t) {
                        invoke('next', t, i, a);
                      },
                      function (t) {
                        invoke('throw', t, i, a);
                      },
                    )
                  : e.resolve(h).then(
                      function (t) {
                        ((u.value = t), i(u));
                      },
                      function (t) {
                        return invoke('throw', t, i, a);
                      },
                    );
              }
              a(c.arg);
            }
            var r;
            o(this, '_invoke', {
              value: function value(t, n) {
                function callInvokeWithMethodAndArg() {
                  return new e(function (e, r) {
                    invoke(t, n, e, r);
                  });
                }
                return (r = r
                  ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg)
                  : callInvokeWithMethodAndArg());
              },
            });
          }
          function makeInvokeMethod(e, r, n) {
            var o = h;
            return function (i, a) {
              if (o === f) throw new Error('Generator is already running');
              if (o === s) {
                if ('throw' === i) throw a;
                return { value: t, done: !0 };
              }
              for (n.method = i, n.arg = a; ; ) {
                var c = n.delegate;
                if (c) {
                  var u = maybeInvokeDelegate(c, n);
                  if (u) {
                    if (u === y) continue;
                    return u;
                  }
                }
                if ('next' === n.method) n.sent = n._sent = n.arg;
                else if ('throw' === n.method) {
                  if (o === h) throw ((o = s), n.arg);
                  n.dispatchException(n.arg);
                } else 'return' === n.method && n.abrupt('return', n.arg);
                o = f;
                var p = tryCatch(e, r, n);
                if ('normal' === p.type) {
                  if (((o = n.done ? s : l), p.arg === y)) continue;
                  return { value: p.arg, done: n.done };
                }
                'throw' === p.type && ((o = s), (n.method = 'throw'), (n.arg = p.arg));
              }
            };
          }
          function maybeInvokeDelegate(e, r) {
            var n = r.method,
              o = e.iterator[n];
            if (o === t)
              return (
                (r.delegate = null),
                ('throw' === n &&
                  e.iterator['return'] &&
                  ((r.method = 'return'), (r.arg = t), maybeInvokeDelegate(e, r), 'throw' === r.method)) ||
                  ('return' !== n &&
                    ((r.method = 'throw'),
                    (r.arg = new TypeError("The iterator does not provide a '" + n + "' method")))),
                y
              );
            var i = tryCatch(o, e.iterator, r.arg);
            if ('throw' === i.type) return ((r.method = 'throw'), (r.arg = i.arg), (r.delegate = null), y);
            var a = i.arg;
            return a
              ? a.done
                ? ((r[e.resultName] = a.value),
                  (r.next = e.nextLoc),
                  'return' !== r.method && ((r.method = 'next'), (r.arg = t)),
                  (r.delegate = null),
                  y)
                : a
              : ((r.method = 'throw'),
                (r.arg = new TypeError('iterator result is not an object')),
                (r.delegate = null),
                y);
          }
          function pushTryEntry(t) {
            var e = { tryLoc: t[0] };
            (1 in t && (e.catchLoc = t[1]),
              2 in t && ((e.finallyLoc = t[2]), (e.afterLoc = t[3])),
              this.tryEntries.push(e));
          }
          function resetTryEntry(t) {
            var e = t.completion || {};
            ((e.type = 'normal'), delete e.arg, (t.completion = e));
          }
          function Context(t) {
            ((this.tryEntries = [{ tryLoc: 'root' }]), t.forEach(pushTryEntry, this), this.reset(!0));
          }
          function values(e) {
            if (e || '' === e) {
              var r = e[a];
              if (r) return r.call(e);
              if ('function' == typeof e.next) return e;
              if (!isNaN(e.length)) {
                var o = -1,
                  i = function next() {
                    for (; ++o < e.length; ) if (n.call(e, o)) return ((next.value = e[o]), (next.done = !1), next);
                    return ((next.value = t), (next.done = !0), next);
                  };
                return (i.next = i);
              }
            }
            throw new TypeError(_typeof(e) + ' is not iterable');
          }
          return (
            (GeneratorFunction.prototype = GeneratorFunctionPrototype),
            o(g, 'constructor', { value: GeneratorFunctionPrototype, configurable: !0 }),
            o(GeneratorFunctionPrototype, 'constructor', { value: GeneratorFunction, configurable: !0 }),
            (GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, 'GeneratorFunction')),
            (e.isGeneratorFunction = function (t) {
              var e = 'function' == typeof t && t.constructor;
              return !!e && (e === GeneratorFunction || 'GeneratorFunction' === (e.displayName || e.name));
            }),
            (e.mark = function (t) {
              return (
                Object.setPrototypeOf
                  ? Object.setPrototypeOf(t, GeneratorFunctionPrototype)
                  : ((t.__proto__ = GeneratorFunctionPrototype), define(t, u, 'GeneratorFunction')),
                (t.prototype = Object.create(g)),
                t
              );
            }),
            (e.awrap = function (t) {
              return { __await: t };
            }),
            defineIteratorMethods(AsyncIterator.prototype),
            define(AsyncIterator.prototype, c, function () {
              return this;
            }),
            (e.AsyncIterator = AsyncIterator),
            (e.async = function (t, r, n, o, i) {
              void 0 === i && (i = Promise);
              var a = new AsyncIterator(wrap(t, r, n, o), i);
              return e.isGeneratorFunction(r)
                ? a
                : a.next().then(function (t) {
                    return t.done ? t.value : a.next();
                  });
            }),
            defineIteratorMethods(g),
            define(g, u, 'Generator'),
            define(g, a, function () {
              return this;
            }),
            define(g, 'toString', function () {
              return '[object Generator]';
            }),
            (e.keys = function (t) {
              var e = Object(t),
                r = [];
              for (var n in e) r.push(n);
              return (
                r.reverse(),
                function next() {
                  for (; r.length; ) {
                    var t = r.pop();
                    if (t in e) return ((next.value = t), (next.done = !1), next);
                  }
                  return ((next.done = !0), next);
                }
              );
            }),
            (e.values = values),
            (Context.prototype = {
              constructor: Context,
              reset: function reset(e) {
                if (
                  ((this.prev = 0),
                  (this.next = 0),
                  (this.sent = this._sent = t),
                  (this.done = !1),
                  (this.delegate = null),
                  (this.method = 'next'),
                  (this.arg = t),
                  this.tryEntries.forEach(resetTryEntry),
                  !e)
                )
                  for (var r in this) 't' === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t);
              },
              stop: function stop() {
                this.done = !0;
                var t = this.tryEntries[0].completion;
                if ('throw' === t.type) throw t.arg;
                return this.rval;
              },
              dispatchException: function dispatchException(e) {
                if (this.done) throw e;
                var r = this;
                function handle(n, o) {
                  return ((a.type = 'throw'), (a.arg = e), (r.next = n), o && ((r.method = 'next'), (r.arg = t)), !!o);
                }
                for (var o = this.tryEntries.length - 1; o >= 0; --o) {
                  var i = this.tryEntries[o],
                    a = i.completion;
                  if ('root' === i.tryLoc) return handle('end');
                  if (i.tryLoc <= this.prev) {
                    var c = n.call(i, 'catchLoc'),
                      u = n.call(i, 'finallyLoc');
                    if (c && u) {
                      if (this.prev < i.catchLoc) return handle(i.catchLoc, !0);
                      if (this.prev < i.finallyLoc) return handle(i.finallyLoc);
                    } else if (c) {
                      if (this.prev < i.catchLoc) return handle(i.catchLoc, !0);
                    } else {
                      if (!u) throw new Error('try statement without catch or finally');
                      if (this.prev < i.finallyLoc) return handle(i.finallyLoc);
                    }
                  }
                }
              },
              abrupt: function abrupt(t, e) {
                for (var r = this.tryEntries.length - 1; r >= 0; --r) {
                  var o = this.tryEntries[r];
                  if (o.tryLoc <= this.prev && n.call(o, 'finallyLoc') && this.prev < o.finallyLoc) {
                    var i = o;
                    break;
                  }
                }
                i && ('break' === t || 'continue' === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null);
                var a = i ? i.completion : {};
                return (
                  (a.type = t),
                  (a.arg = e),
                  i ? ((this.method = 'next'), (this.next = i.finallyLoc), y) : this.complete(a)
                );
              },
              complete: function complete(t, e) {
                if ('throw' === t.type) throw t.arg;
                return (
                  'break' === t.type || 'continue' === t.type
                    ? (this.next = t.arg)
                    : 'return' === t.type
                      ? ((this.rval = this.arg = t.arg), (this.method = 'return'), (this.next = 'end'))
                      : 'normal' === t.type && e && (this.next = e),
                  y
                );
              },
              finish: function finish(t) {
                for (var e = this.tryEntries.length - 1; e >= 0; --e) {
                  var r = this.tryEntries[e];
                  if (r.finallyLoc === t) return (this.complete(r.completion, r.afterLoc), resetTryEntry(r), y);
                }
              },
              catch: function _catch(t) {
                for (var e = this.tryEntries.length - 1; e >= 0; --e) {
                  var r = this.tryEntries[e];
                  if (r.tryLoc === t) {
                    var n = r.completion;
                    if ('throw' === n.type) {
                      var o = n.arg;
                      resetTryEntry(r);
                    }
                    return o;
                  }
                }
                throw new Error('illegal catch attempt');
              },
              delegateYield: function delegateYield(e, r, n) {
                return (
                  (this.delegate = { iterator: values(e), resultName: r, nextLoc: n }),
                  'next' === this.method && (this.arg = t),
                  y
                );
              },
            }),
            e
          );
        }
        function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
          try {
            var info = gen[key](arg);
            var value = info.value;
          } catch (error) {
            reject(error);
            return;
          }
          if (info.done) {
            resolve(value);
          } else {
            Promise.resolve(value).then(_next, _throw);
          }
        }
        function _asyncToGenerator(fn) {
          return function () {
            var self = this,
              args = arguments;
            return new Promise(function (resolve, reject) {
              var gen = fn.apply(self, args);
              function _next(value) {
                asyncGeneratorStep(gen, resolve, reject, _next, _throw, 'next', value);
              }
              function _throw(err) {
                asyncGeneratorStep(gen, resolve, reject, _next, _throw, 'throw', err);
              }
              _next(undefined);
            });
          };
        }
        /* harmony default export */ __webpack_exports__['default'] = {
          data: function data() {
            return {
              activities: {},
              status: 'all',
              auth: this.$store.state.currentUser.user,
              current: '',
            };
          },
          methods: {
            // Fetch activities design from mixin
            activityIcon: function activityIcon(description) {
              return this.getIcon(description);
            },
            activityColor: function activityColor(description) {
              return this.getColor(description);
            },
            getData: function getData(suffix) {
              var _this = this;
              return _asyncToGenerator(
                /*#__PURE__*/ _regeneratorRuntime().mark(function _callee() {
                  return _regeneratorRuntime().wrap(function _callee$(_context) {
                    while (1)
                      switch ((_context.prev = _context.next)) {
                        case 0:
                          _context.next = 2;
                          return axios
                            .get('/api/v1/projects/'.concat(_this.$route.params.slug, '/activities').concat(suffix))
                            .then(function (response) {
                              _this.activities = response.data;
                            })
                            ['catch'](function (error) {
                              console.log(error.response.data.errors);
                            });
                        case 2:
                        case 'end':
                          return _context.stop();
                      }
                  }, _callee);
                }),
              )();
            },
            getActivities: function getActivities() {
              this.getData('');
              this.current = 'All Project Activities';
            },
            getResults: function getResults() {
              var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
              this.getData('?page='.concat(page));
            },
            allActivities: function allActivities() {
              this.status = 'all';
              this.getActivities();
            },
            myActivities: function myActivities() {
              this.status = 'my';
              this.getData('?mine='.concat(this.auth.id));
              this.current = 'My Project Activities';
            },
            projectActivities: function projectActivities() {
              this.status = 'project';
              this.getData('?specifics=1');
              this.current = 'Project Specified Activities';
            },
            taskActivities: function taskActivities() {
              this.status = 'task';
              this.getData('?tasks=1');
              this.current = 'Project Tasks Activities';
            },
            memberActivities: function memberActivities() {
              this.status = 'member';
              this.getData('?members=1');
              this.current = 'Project Members Activities';
            },
          },
          created: function created() {
            this.getActivities();
          },
        };

        /***/
      },

    /***/ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&':
      /*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee& ***!
  \***************************************************************************************************************************************************************************************************************************************************/
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
              'div',
              {
                staticClass: 'container-fluid',
              },
              [
                _c(
                  'div',
                  {
                    staticClass: 'row',
                  },
                  [
                    _c(
                      'div',
                      {
                        staticClass: 'col-md-8 page pd-r',
                      },
                      [
                        _c(
                          'div',
                          {
                            staticClass: 'page-top',
                          },
                          [
                            _c('div', [
                              _c('span', [
                                _c(
                                  'span',
                                  {
                                    staticClass: 'page-top_heading',
                                  },
                                  [_vm._v('Projects ')],
                                ),
                                _vm._v(' '),
                                _c(
                                  'span',
                                  {
                                    staticClass: 'page-top_arrow',
                                  },
                                  [_vm._v(' > ')],
                                ),
                                _vm._v(' '),
                                _c(
                                  'span',
                                  [
                                    _c(
                                      'router-link',
                                      {
                                        staticClass: 'dashboard-link',
                                        attrs: {
                                          to: '/projects/' + this.$route.params.slug,
                                        },
                                      },
                                      [_vm._v(_vm._s(this.$route.params.name))],
                                    ),
                                  ],
                                  1,
                                ),
                                _vm._v(' '),
                                _c(
                                  'span',
                                  {
                                    staticClass: 'page-top_arrow',
                                  },
                                  [_vm._v(' > ')],
                                ),
                                _vm._v(' '),
                                _c('span', [
                                  _vm._v('\n   Activities >\n   '),
                                  _c(
                                    'span',
                                    {
                                      staticClass: 'ml-2',
                                    },
                                    [_vm._v(_vm._s(this.current))],
                                  ),
                                ]),
                              ]),
                            ]),
                          ],
                        ),
                        _vm._v(' '),
                        _c(
                          'div',
                          {
                            staticClass: 'container mt-3',
                          },
                          [
                            _c(
                              'div',
                              {
                                staticClass: 'activity mb-5',
                              },
                              [
                                this.activities.data == null
                                  ? _c(
                                      'div',
                                      {
                                        staticClass: 'mt-3',
                                      },
                                      [
                                        _c(
                                          'h3',
                                          {
                                            staticClass: 'text-center',
                                          },
                                          [_vm._v('No related activities found')],
                                        ),
                                      ],
                                    )
                                  : _vm._e(),
                                _vm._v(' '),
                                _c(
                                  'ul',
                                  _vm._l(this.activities.data, function (activity, index) {
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
                                        _vm._v('\n             ' + _vm._s(activity.description) + '\n              '),
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
                                  0,
                                ),
                              ],
                            ),
                          ],
                        ),
                      ],
                    ),
                    _vm._v(' '),
                    _c(
                      'div',
                      {
                        staticClass: 'col-md-4',
                      },
                      [
                        _c(
                          'div',
                          {
                            staticClass: 'card',
                          },
                          [
                            _vm._m(0),
                            _vm._v(' '),
                            _c(
                              'div',
                              {
                                staticClass: 'card-body activity-search',
                              },
                              [
                                _c('ul', [
                                  _c('li', [
                                    _c(
                                      'a',
                                      {
                                        staticClass: 'activity-icon_secondary',
                                        class: {
                                          Activityfont: _vm.status == 'all',
                                        },
                                        attrs: {
                                          href: '',
                                        },
                                        on: {
                                          click: function click($event) {
                                            $event.preventDefault();
                                            return _vm.allActivities.apply(null, arguments);
                                          },
                                        },
                                      },
                                      [
                                        _c('i', {
                                          staticClass: 'fas fa-layer-group activity-icon_secondary mr-3',
                                        }),
                                        _vm._v('All Activities'),
                                      ],
                                    ),
                                  ]),
                                  _vm._v(' '),
                                  _c('li', [
                                    _c(
                                      'a',
                                      {
                                        staticClass: "'activity-icon_purple",
                                        class: {
                                          Activityfont: _vm.status == 'my',
                                        },
                                        attrs: {
                                          href: '',
                                        },
                                        on: {
                                          click: function click($event) {
                                            $event.preventDefault();
                                            return _vm.myActivities.apply(null, arguments);
                                          },
                                        },
                                      },
                                      [
                                        _c('i', {
                                          staticClass: 'fas fa-user activity-icon_purple mr-3',
                                        }),
                                        _vm._v(' My Activities'),
                                      ],
                                    ),
                                  ]),
                                  _vm._v(' '),
                                  _c('li', [
                                    _c(
                                      'a',
                                      {
                                        staticClass: 'activity-icon_green',
                                        class: {
                                          Activityfont: _vm.status == 'project',
                                        },
                                        attrs: {
                                          href: '',
                                        },
                                        on: {
                                          click: function click($event) {
                                            $event.preventDefault();
                                            return _vm.projectActivities.apply(null, arguments);
                                          },
                                        },
                                      },
                                      [
                                        _c('i', {
                                          staticClass: 'far fa-star activity-icon_green mr-3',
                                        }),
                                        _vm._v(' Project Activities'),
                                      ],
                                    ),
                                  ]),
                                  _vm._v(' '),
                                  _c('li', [
                                    _c(
                                      'a',
                                      {
                                        staticClass: 'activity-icon_primary',
                                        class: {
                                          Activityfont: _vm.status == 'task',
                                        },
                                        attrs: {
                                          href: '',
                                        },
                                        on: {
                                          click: function click($event) {
                                            $event.preventDefault();
                                            return _vm.taskActivities();
                                          },
                                        },
                                      },
                                      [
                                        _c('i', {
                                          staticClass: 'fas fa-tasks activity-icon_primary mr-3',
                                        }),
                                        _vm._v(' Task Activities'),
                                      ],
                                    ),
                                  ]),
                                  _vm._v(' '),
                                  _c('li', [
                                    _c(
                                      'a',
                                      {
                                        staticClass: 'activity-icon_danger',
                                        class: {
                                          Activityfont: _vm.status == 'member',
                                        },
                                        attrs: {
                                          href: '',
                                        },
                                        on: {
                                          click: function click($event) {
                                            $event.preventDefault();
                                            return _vm.memberActivities();
                                          },
                                        },
                                      },
                                      [
                                        _c('i', {
                                          staticClass: 'fas fa-tasks activity-icon_danger mr-3',
                                        }),
                                        _vm._v(' Member Activities'),
                                      ],
                                    ),
                                  ]),
                                ]),
                              ],
                            ),
                          ],
                        ),
                        _vm._v(' '),
                        _c(
                          'div',
                          {
                            staticClass: 'mt-4',
                          },
                          [
                            _c('pagination', {
                              attrs: {
                                data: _vm.activities,
                              },
                              on: {
                                'pagination-change-page': _vm.getResults,
                              },
                            }),
                          ],
                          1,
                        ),
                      ],
                    ),
                  ],
                ),
              ],
            ),
          ]);
        };
        var staticRenderFns = [
          function () {
            var _vm = this,
              _c = _vm._self._c;
            return _c(
              'div',
              {
                staticClass: 'card-header',
              },
              [_c('p', [_vm._v('Search Related Activities:')])],
            );
          },
        ];
        render._withStripped = true;

        /***/
      },

    /***/ './node_modules/vue-loader/lib/runtime/componentNormalizer.js':
      /*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, 'default', function () {
          return normalizeComponent;
        });
        /* globals __VUE_SSR_CONTEXT__ */

        // IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
        // This module is a runtime utility for cleaner component module output and will
        // be included in the final webpack user bundle.

        function normalizeComponent(
          scriptExports,
          render,
          staticRenderFns,
          functionalTemplate,
          injectStyles,
          scopeId,
          moduleIdentifier /* server only */,
          shadowMode /* vue-cli only */,
        ) {
          // Vue.extend constructor export interop
          var options = typeof scriptExports === 'function' ? scriptExports.options : scriptExports;

          // render functions
          if (render) {
            options.render = render;
            options.staticRenderFns = staticRenderFns;
            options._compiled = true;
          }

          // functional template
          if (functionalTemplate) {
            options.functional = true;
          }

          // scopedId
          if (scopeId) {
            options._scopeId = 'data-v-' + scopeId;
          }

          var hook;
          if (moduleIdentifier) {
            // server build
            hook = function (context) {
              // 2.3 injection
              context =
                context || // cached call
                (this.$vnode && this.$vnode.ssrContext) || // stateful
                (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext); // functional
              // 2.2 with runInNewContext: true
              if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
                context = __VUE_SSR_CONTEXT__;
              }
              // inject component styles
              if (injectStyles) {
                injectStyles.call(this, context);
              }
              // register component module identifier for async chunk inferrence
              if (context && context._registeredComponents) {
                context._registeredComponents.add(moduleIdentifier);
              }
            };
            // used by ssr in case component is cached and beforeCreate
            // never gets called
            options._ssrRegister = hook;
          } else if (injectStyles) {
            hook = shadowMode
              ? function () {
                  injectStyles.call(this, (options.functional ? this.parent : this).$root.$options.shadowRoot);
                }
              : injectStyles;
          }

          if (hook) {
            if (options.functional) {
              // for template-only hot-reload because in that case the render fn doesn't
              // go through the normalizer
              options._injectStyles = hook;
              // register for functional component in vue file
              var originalRender = options.render;
              options.render = function renderWithStyleInjection(h, context) {
                hook.call(context);
                return originalRender(h, context);
              };
            } else {
              // inject component registration as beforeCreate hook
              var existing = options.beforeCreate;
              options.beforeCreate = existing ? [].concat(existing, hook) : [hook];
            }
          }

          return {
            exports: scriptExports,
            options: options,
          };
        }

        /***/
      },

    /***/ './resources/js/components/Project/Activities.vue':
      /*!********************************************************!*\
  !*** ./resources/js/components/Project/Activities.vue ***!
  \********************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! ./Activities.vue?vue&type=template&id=1793b4ee& */ './resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&',
          );
        /* harmony import */ var _Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ =
          __webpack_require__(
            /*! ./Activities.vue?vue&type=script&lang=js& */ './resources/js/components/Project/Activities.vue?vue&type=script&lang=js&',
          );
        /* empty/unused harmony star reexport */ /* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ =
          __webpack_require__(
            /*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ './node_modules/vue-loader/lib/runtime/componentNormalizer.js',
          );

        /* normalize component */

        var component = Object(
          _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__['default'],
        )(
          _Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__['default'],
          _Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__['render'],
          _Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__['staticRenderFns'],
          false,
          null,
          null,
          null,
        );

        /* hot reload */
        if (false) {
          var api;
        }
        component.options.__file = 'resources/js/components/Project/Activities.vue';
        /* harmony default export */ __webpack_exports__['default'] = component.exports;

        /***/
      },

    /***/ './resources/js/components/Project/Activities.vue?vue&type=script&lang=js&':
      /*!*********************************************************************************!*\
  !*** ./resources/js/components/Project/Activities.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
      /*! exports provided: default */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Activities.vue?vue&type=script&lang=js& */ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&',
          );
        /* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__['default'] =
          _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[
            'default'
          ];

        /***/
      },

    /***/ './resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&':
      /*!***************************************************************************************!*\
  !*** ./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee& ***!
  \***************************************************************************************/
      /*! exports provided: render, staticRenderFns */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__ =
          __webpack_require__(
            /*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Activities.vue?vue&type=template&id=1793b4ee& */ './node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&',
          );
        /* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, 'render', function () {
          return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__[
            'render'
          ];
        });

        /* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, 'staticRenderFns', function () {
          return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__[
            'staticRenderFns'
          ];
        });

        /***/
      },
  },
]);
