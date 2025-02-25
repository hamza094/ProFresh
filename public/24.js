(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[24],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Meeting.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Meeting.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MeetingModal_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MeetingModal.vue */ "./resources/js/components/Project/MeetingModal.vue");
/* harmony import */ var _ViewModal_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ViewModal.vue */ "./resources/js/components/Project/ViewModal.vue");
/* harmony import */ var _auth__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../auth */ "./resources/js/auth.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _utils_zoomUtils__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../utils/zoomUtils */ "./resources/js/utils/zoomUtils.js");
/* harmony import */ var _utils_meetingUtils__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../utils/meetingUtils */ "./resources/js/utils/meetingUtils.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }






/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['projectSlug', 'projectMeetings', 'notAuthorize', 'members'],
  components: {
    MeetingModal: _MeetingModal_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    ViewModal: _ViewModal_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      showPrevious: false,
      client: null,
      auth: this.$store.state.currentUser.user,
      loadingId: null,
      shouldCleanUpZoom: false,
      activeMeetingId: null
    };
  },
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_3__["mapState"])('meeting', ['meetings', 'message'])), {}, {
    meetingStatusListener: function meetingStatusListener() {
      var _this = this;
      if (this.activeMeetingId) {
        Echo["private"]("meetingStatus.".concat(this.activeMeetingId)).listen('MeetingStatusUpdate', function (e) {
          _this.updateMeetingStatus({
            id: e.id,
            status: e.status
          });
        });
        return function () {
          Echo.leave("meetingStatus.".concat(_this.activeMeetingId));
        };
      }
    }
  }),
  watch: {
    meetingStatusListener: function meetingStatusListener(newListener, oldListener) {
      if (oldListener) oldListener();
    }
  },
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_3__["mapActions"])({
    fetchMeetings: 'meeting/fetchMeetings',
    updateMeetingStatus: 'meeting/updateMeetingStatus'
  })), {}, {
    shouldShowStartButton: function shouldShowStartButton(meeting, auth, notAuthorize) {
      return Object(_utils_meetingUtils__WEBPACK_IMPORTED_MODULE_5__["shouldShowStartButton"])(meeting, auth, notAuthorize);
    },
    shouldShowJoinButton: function shouldShowJoinButton(meeting, auth, members) {
      return Object(_utils_meetingUtils__WEBPACK_IMPORTED_MODULE_5__["shouldShowJoinButton"])(meeting, auth, members);
    },
    getMeeting: function getMeeting(meetingId) {
      this.$bus.$emit('view-meeting-modal', meetingId);
    },
    getResults: function getResults(page) {
      var slug = this.$route.params.slug;
      this.fetchMeetings({
        slug: slug,
        page: page,
        isPrevious: this.showPrevious
      });
    },
    showCurrentMeetings: function showCurrentMeetings() {
      this.showPrevious = false;
      this.getResults();
    },
    showPreviousMeetings: function showPreviousMeetings() {
      this.showPrevious = true;
      this.getResults();
    },
    openMeetingModal: function openMeetingModal() {
      this.$bus.emit('open-meeting-modal');
    },
    authorize: function authorize() {
      axios.get("/api/v1/oauth/zoom/redirect", {}).then(function (response) {
        window.location.href = response.data.redirectUrl;
      })["catch"](function (error) {});
    },
    initializeMeting: function initializeMeting(action, meeting) {
      var _this2 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var role, _yield$fetchTokens, _yield$fetchTokens2, zakTokenResponse, jwtTokenResponse, zak_token, jwt_token;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _this2.loadingId = _this2.$vToastify.loader('Initializing meeting. Please hold on...');
              if (action === 'start') {
                _this2.activeMeetingId = meeting.id;
              }
              _context.prev = 2;
              role = _this2.auth.id === meeting.owner.id ? 1 : 0;
              _context.next = 6;
              return Object(_utils_zoomUtils__WEBPACK_IMPORTED_MODULE_4__["fetchTokens"])(action, role, meeting.meeting_id, _this2.$vToastify);
            case 6:
              _yield$fetchTokens = _context.sent;
              _yield$fetchTokens2 = _slicedToArray(_yield$fetchTokens, 2);
              zakTokenResponse = _yield$fetchTokens2[0];
              jwtTokenResponse = _yield$fetchTokens2[1];
              zak_token = zakTokenResponse ? zakTokenResponse.zak_token : null;
              jwt_token = jwtTokenResponse.jwt_token;
              _context.next = 14;
              return Object(_utils_zoomUtils__WEBPACK_IMPORTED_MODULE_4__["setupAndJoinMeeting"])(action, meeting, jwt_token, zak_token, _this2.auth);
            case 14:
              _this2.$vToastify.success('Meeting initiated successfully!');
              _context.next = 20;
              break;
            case 17:
              _context.prev = 17;
              _context.t0 = _context["catch"](2);
              _this2.$vToastify.error('Meeting initiated failed!');
            case 20:
              _context.prev = 20;
              _this2.$vToastify.stopLoader(_this2.loadingId);
              _this2.loadingId = null;
              return _context.finish(20);
            case 24:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[2, 17, 20, 24]]);
      }))();
    },
    ribbonColor: function ribbonColor(status) {
      switch (status.toLowerCase()) {
        case 'waiting':
          return 'bg-yellow';
        case 'started':
          return 'bg-green';
        default:
          return 'bg-red';
      }
    }
  }),
  created: function created() {
    this.showCurrentMeetings();
    this.$bus.$on('initialize-meeting', this.initializeMeting);
  },
  beforeDestroy: function beforeDestroy() {
    if (this.meetingStatusListener) {
      this.meetingStatusListener();
    }
  },
  mounted: function mounted() {
    var _this3 = this;
    this.$bus.on('get-results', function () {
      _this3.showCurrentMeetings();
    });
  },
  destroyed: function destroyed() {
    this.$bus.$off('get-results');
    this.$bus.$off('initialize-meeting', this.initializeMeting);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Meeting.vue?vue&type=template&id=0b17330a":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Meeting.vue?vue&type=template&id=0b17330a ***!
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
  return _c("div", [_c("div", {
    attrs: {
      id: "meetingSDKElement"
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "project-info"
  }, [_c("div", {
    staticClass: "project-info_socre"
  }, [_c("p", {
    staticClass: "project-info_score-heading"
  }, [_vm._v("Meetings")]), _vm._v(" "), _vm.notAuthorize ? _c("p", {
    staticClass: "btn btn-sm btn-secondary",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.authorize.apply(null, arguments);
      }
    }
  }, [_vm._v("Authorize With Zoom")]) : _vm._e(), _vm._v(" "), !_vm.notAuthorize ? _c("button", {
    staticClass: "btn btn-sm btn-primary",
    on: {
      click: function click($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "pervent", undefined, $event.key, undefined)) return null;
        return _vm.openMeetingModal();
      }
    }
  }, [_vm._v("Create Meating")]) : _vm._e()]), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "btn-group",
    attrs: {
      role: "group"
    }
  }, [_c("button", {
    staticClass: "btn btn-link btn-sm meeting_button",
    "class": {
      active: !_vm.showPrevious
    },
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.showCurrentMeetings
    }
  }, [_vm._v("\n        Current Meetings\n      ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-link btn-sm meeting_button",
    "class": {
      active: _vm.showPrevious
    },
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.showPreviousMeetings
    }
  }, [_vm._v("\n        Previous Meetings\n      ")])]), _vm._v(" "), _vm.message ? _c("div", {
    staticClass: "alert alert-info"
  }, [_vm._v("\n      " + _vm._s(_vm.message) + "\n    ")]) : _vm._e(), _vm._v(" "), _vm._l(_vm.meetings.data, function (meeting, index) {
    return _c("div", {
      key: meeting.id
    }, [_c("div", {
      staticClass: "card mt-3 card-hover",
      on: {
        click: function click($event) {
          if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "pervent", undefined, $event.key, undefined)) return null;
          return _vm.getMeeting(meeting.id);
        }
      }
    }, [_c("div", {
      "class": ["ribbon", _vm.ribbonColor(meeting.status)]
    }, [_vm._v(_vm._s(meeting.status))]), _vm._v(" "), _c("div", {
      staticClass: "card-stamp"
    }, [_c("div", {
      staticClass: "card-stamp-icon bg-yellow"
    }, [_c("svg", {
      staticClass: "icon",
      attrs: {
        xmlns: "http://www.w3.org/2000/svg",
        width: "24",
        height: "24",
        viewBox: "0 0 24 24",
        "stroke-width": "2",
        stroke: "currentColor",
        fill: "none",
        "stroke-linecap": "round",
        "stroke-linejoin": "round"
      }
    }, [_c("path", {
      attrs: {
        stroke: "none",
        d: "M0 0h24v24H0z",
        fill: "none"
      }
    }), _c("path", {
      attrs: {
        d: "M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"
      }
    }), _c("path", {
      attrs: {
        d: "M9 17v1a3 3 0 0 0 6 0v-1"
      }
    })])])]), _vm._v(" "), meeting.status.toLowerCase() === "started" ? _c("div", {
      staticClass: "glowing-dot"
    }) : _vm._e(), _vm._v(" "), _c("div", {
      staticClass: "card-body"
    }, [_c("h3", {
      staticClass: "card-title"
    }, [_vm._v(_vm._s(meeting.topic))]), _vm._v(" "), _c("p", {
      staticClass: "text-secondary"
    }, [_vm._v(_vm._s(meeting.agenda))]), _vm._v(" "), _c("p", [_c("b", [_vm._v("Start Time:")]), _vm._v("  " + _vm._s(meeting.start_time) + "\n                    \t")]), _vm._v(" "), _c("p", [_c("b", [_vm._v("Timezone:")]), _vm._v(" \n                    \t\t" + _vm._s(meeting.timezone) + "\n                    ")]), _vm._v(" "), _c("p", [_c("b", [_vm._v("Created At:")]), _vm._v(" " + _vm._s(meeting.created_at))])])]), _vm._v(" "), _c("div", {
      staticClass: "card-footer"
    }, [_vm.shouldShowStartButton(meeting, _vm.auth, _vm.notAuthorize) ? _c("button", {
      staticClass: "btn btn-sm btn-primary",
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.initializeMeting("start", meeting);
        }
      }
    }, [_vm._v("\n                      Start Meeting\n                    ")]) : _vm.shouldShowJoinButton(meeting, _vm.auth, _vm.members) ? _c("button", {
      staticClass: "btn btn-sm btn-warning text-white",
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.initializeMeting("join", meeting);
        }
      }
    }, [_vm._v("Join Meeting")]) : _vm._e()])]);
  })], 2), _vm._v(" "), _c("pagination", {
    attrs: {
      data: _vm.meetings
    },
    on: {
      "pagination-change-page": _vm.getResults
    }
  }), _vm._v(" "), _c("MeetingModal", {
    attrs: {
      projectSlug: this.projectSlug
    }
  }), _vm._v(" "), _c("ViewModal", {
    attrs: {
      projectSlug: this.projectSlug,
      members: this.members,
      notAuthorize: this.notAuthorize
    }
  })], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/Meeting.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/Project/Meeting.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Meeting_vue_vue_type_template_id_0b17330a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Meeting.vue?vue&type=template&id=0b17330a */ "./resources/js/components/Project/Meeting.vue?vue&type=template&id=0b17330a");
/* harmony import */ var _Meeting_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Meeting.vue?vue&type=script&lang=js */ "./resources/js/components/Project/Meeting.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Meeting_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Meeting_vue_vue_type_template_id_0b17330a__WEBPACK_IMPORTED_MODULE_0__["render"],
  _Meeting_vue_vue_type_template_id_0b17330a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Meeting.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Meeting.vue?vue&type=script&lang=js":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Project/Meeting.vue?vue&type=script&lang=js ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Meeting_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Meeting.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Meeting.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Meeting_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Meeting.vue?vue&type=template&id=0b17330a":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/Project/Meeting.vue?vue&type=template&id=0b17330a ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Meeting_vue_vue_type_template_id_0b17330a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Meeting.vue?vue&type=template&id=0b17330a */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Meeting.vue?vue&type=template&id=0b17330a");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Meeting_vue_vue_type_template_id_0b17330a__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Meeting_vue_vue_type_template_id_0b17330a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);