(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[17],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var emoji_mart_vue_fast_data_all_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! emoji-mart-vue-fast/data/all.json */ "./node_modules/emoji-mart-vue-fast/data/all.json");
var emoji_mart_vue_fast_data_all_json__WEBPACK_IMPORTED_MODULE_0___namespace = /*#__PURE__*/__webpack_require__.t(/*! emoji-mart-vue-fast/data/all.json */ "./node_modules/emoji-mart-vue-fast/data/all.json", 1);
/* harmony import */ var vue_mention__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-mention */ "./node_modules/vue-mention/dist/vue-mention.esm.js");
/* harmony import */ var emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! emoji-mart-vue-fast */ "./node_modules/emoji-mart-vue-fast/dist/emoji-mart.js");
/* harmony import */ var emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _SubscriptionChecker_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../SubscriptionChecker.vue */ "./resources/js/components/SubscriptionChecker.vue");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_4__);
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }





/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    Picker: emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2__["Picker"],
    Mentionable: vue_mention__WEBPACK_IMPORTED_MODULE_1__["Mentionable"],
    SubscriptionCheck: _SubscriptionChecker_vue__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  props: ['slug', 'members', 'owner', 'auth'],
  data: function data() {
    return {
      emojiIndex: new emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2__["EmojiIndex"](emoji_mart_vue_fast_data_all_json__WEBPACK_IMPORTED_MODULE_0__),
      message: '',
      typing: false,
      emojiModal: false,
      typingTimeout: null,
      user: null,
      fileName: '',
      file: '',
      items: [],
      conversations: [],
      errors: [],
      users: [].concat(_toConsumableArray(this.members), [this.owner])
    };
  },
  computed: {
    isSendDisabled: function isSendDisabled() {
      return this.message.trim().length === 0 && !this.file;
    }
  },
  methods: {
    isImage: function isImage(file) {
      return /\.(png|jpg|jpeg)$/i.test(file);
    },
    handleOpen: function handleOpen(key) {
      var _this = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _this.items = key === '@' ? _this.users : [];
            case 1:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }))();
    },
    handleApply: function handleApply(item, key) {
      var _this2 = this;
      return _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _this2.message = "".concat(_this2.message, "@").concat(item.username);
              _this2.message = _this2.message.replace('@undefined', '');
            case 2:
            case "end":
              return _context2.stop();
          }
        }, _callee2);
      }))();
    },
    showEmoji: function showEmoji(emoji) {
      if (!emoji) return;
      this.message += emoji["native"];
    },
    openFilePicker: function openFilePicker() {
      this.$refs.fileInput.click(); // Open file picker when button is clicked
    },
    fileUpload: function fileUpload(event) {
      this.file = event.target.files[0];
      if (this.file) {
        this.fileName = this.file.name;
      }
    },
    removeFile: function removeFile() {
      this.file = null;
      this.fileName = "";
      this.$refs.fileInput.value = ""; // Clear input field
    },
    send: function send() {
      var _this3 = this;
      if (this.message.length === 0 && !this.file) {
        this.$vToastify.warning("Please enter a message or upload a file.");
        return;
      }
      var formData = new FormData();
      if (this.message) {
        formData.append("message", this.message);
      }
      if (this.file) {
        formData.append("file", this.file);
      }
      axios.post('/api/v1/projects/' + this.slug + '/conversations', formData, {
        useProgress: true
      }).then(function (response) {
        _this3.message = '';
        _this3.file = null;
      })["catch"](function (error) {
        if (error.response && error.response.data.errors) {
          _this3.errors = error.response.data.errors; // Store errors
          Object.values(_this3.errors).forEach(function (err) {
            _this3.$vToastify.warning(err[0]); // Show each error as a toast
          });
        } else {
          _this3.$vToastify.error("Failed to send message.");
        }
      });
    },
    deleteConversation: function deleteConversation(id, index) {
      var _this4 = this;
      axios["delete"]('/api/v1/projects/' + this.slug + '/conversations/' + id, {
        useProgress: true
      }).then(function (response) {
        _this4.$vToastify.info("Conversation deleted sucessfully");
      })["catch"](function (error) {
        _this4.$vToastify.warning("Failed to delete project conversation");
      });
    },
    isTyping: _.debounce(function () {
      Echo["private"]("typing.".concat(this.slug)).whisper("typing-indicator", {
        user: this.auth,
        typing: true
      });
    }, 500),
    // Only fires every 500ms
    toggleEmojiModal: function toggleEmojiModal() {
      this.emojiModal = !this.emojiModal;
    },
    loadConversations: function loadConversations() {
      var _this5 = this;
      return axios.get('/api/v1/projects/' + this.slug + "/conversations").then(function (response) {
        _this5.conversations = response.data;
      })["catch"](function (error) {
        console.log(error);
        _this5.conversations = [];
      });
    },
    listenForNewMessage: function listenForNewMessage() {
      var _this6 = this;
      Echo["private"]("project.".concat(this.slug, ".conversations")).listen('NewMessage', function (e) {
        console.log('event fired');
        if (!_this6.conversations.data.find(function (conv) {
          return conv.id === e.id;
        })) {
          _this6.conversations.data.push(e);
        }
      }).error(function (error) {
        console.error('Echo error:', error);
      });
    },
    listenToDeleteConversation: function listenToDeleteConversation() {
      var _this7 = this;
      Echo["private"]("deleteConversation.".concat(this.slug)).listen('DeleteConversation', function (e) {
        var index = _this7.conversations.data.findIndex(function (c) {
          return c.id === e.conversation_id;
        });
        if (index !== -1) {
          _this7.conversations.data.splice(index, 1);
        }
        _this7.$vToastify.success("conversation deleted");
      });
    },
    listenToWhisperEvent: function listenToWhisperEvent() {
      var _this8 = this;
      Echo["private"]("typing.".concat(this.slug)).listenForWhisper('typing-indicator', function (e) {
        _this8.user = e.user;
        _this8.typing = e.typing;

        // remove is typing indicator after 0.3s
        setTimeout(function () {
          _this8.typing = false;
        }, 3000);
      });
    }
  },
  created: function created() {
    this.loadConversations();
    this.listenToWhisperEvent();
    this.listenForNewMessage();
    this.listenToDeleteConversation();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  computed: {
    isSubscribed: function isSubscribed() {
      //return this.$store.state.subscribeUser.subscription.subscribed;
      return true;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8 ***!
  \**************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm$user;
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "card chat-card mb-5"
  }, [_c("div", {
    staticClass: "card-header d-flex align-items-center justify-content-between bg-primary text-white",
    attrs: {
      id: "accordion"
    }
  }, [_c("div", {
    staticClass: "d-flex align-items-center"
  }, [_c("i", {
    staticClass: "fas fa-comment-alt mr-2"
  }), _vm._v(" "), _c("span", [_vm._v("Group Chat")]), _vm._v(" "), _vm.conversations.length ? _c("span", {
    staticClass: "badge badge-light ml-2"
  }, [_vm._v(_vm._s(_vm.conversations.length))]) : _vm._e(), _vm._v(" "), _c("span", {
    staticClass: "ml-1"
  }, [_vm._v("messages")])]), _vm._v(" "), _c("a", {
    staticClass: "btn btn-default btn-xs float-right",
    attrs: {
      type: "button",
      "data-toggle": "collapse",
      href: "#collapseOne-" + _vm.slug
    }
  }, [_c("i", {
    staticClass: "fas fa-angle-down"
  })])]), _vm._v(" "), _c("div", {
    staticClass: "collapse",
    attrs: {
      id: "collapseOne-" + _vm.slug
    }
  }, [_c("div", {
    staticClass: "card-body chat-panel"
  }, [_c("ul", {
    staticClass: "chat"
  }, [_vm._l(_vm.conversations.data, function (conversation, index) {
    return _c("li", {
      key: index
    }, [_c("div", {
      staticClass: "chat-body clearfix"
    }, [_c("div", {
      staticClass: "header"
    }, [_c("router-link", {
      attrs: {
        to: "/user/" + conversation.user.name + "/profile"
      }
    }, [conversation.user.avatar ? _c("img", {
      staticClass: "chat-user_image",
      attrs: {
        src: conversation.user.avatar,
        alt: "User Avatar"
      }
    }) : _vm._e()]), _vm._v(" "), _c("strong", {
      staticClass: "primary-font"
    }, [_vm._v("\r\n      " + _vm._s(conversation.user.name))])], 1), _vm._v(" "), conversation.message ? _c("p", {
      staticClass: "mt-2"
    }, [_c("span", {
      staticClass: "chat-message",
      domProps: {
        innerHTML: _vm._s(conversation.message)
      }
    })]) : _vm._e(), _vm._v(" "), conversation.file ? _c("p", {
      staticClass: "mt-2"
    }, [_vm.isImage(conversation.file) ? _c("span", [_c("img", {
      staticClass: "chat-image",
      attrs: {
        src: conversation.file,
        alt: ""
      }
    })]) : _c("span", [_c("a", {
      attrs: {
        href: conversation.file,
        target: "_blank"
      }
    }, [_vm._v(_vm._s(conversation.file))])])]) : _vm._e(), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", {
      staticClass: "float-right chat-time"
    }, [_c("i", [_vm._v(_vm._s(conversation.created_at))])]), _vm._v(" "), _vm.auth.uuid === conversation.user.uuid ? _c("button", {
      staticClass: "btn btn-link btn-sm",
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.deleteConversation(conversation.id, index);
        }
      }
    }, [_vm._v("Delete")]) : _c("button", {
      staticClass: "btn btn-link btn-sm disabled"
    }, [_vm._v("Delete")])])]);
  }), _vm._v(" "), _vm.typing ? _c("span", {
    staticClass: "help-block",
    staticStyle: {
      "font-style": "italic"
    }
  }, [_vm._v("\r\n              💬  @" + _vm._s(((_vm$user = _vm.user) === null || _vm$user === void 0 ? void 0 : _vm$user.name) || "Someone") + " is typing...\r\n          ")]) : _c("span", {
    staticClass: "help-block",
    staticStyle: {
      "font-style": "italic"
    }
  }, [_vm._v("\r\n                💬\r\n          ")])], 2)]), _vm._v(" "), _c("div", {
    staticClass: "card-footer gioj"
  }, [_c("div", {
    staticClass: "chat-floating"
  }, [_c("transition", {
    attrs: {
      name: "emoji-slide",
      mode: "out-in"
    }
  }, [_vm.emojiModal ? _c("Picker", {
    staticClass: "emoji-modal",
    attrs: {
      data: _vm.emojiIndex,
      set: "twitter",
      title: "Pick your emoji…",
      showPreview: false
    },
    on: {
      select: _vm.showEmoji
    }
  }) : _vm._e()], 1)], 1), _vm._v(" "), _c("Mentionable", {
    attrs: {
      keys: ["@"],
      items: _vm.items,
      offset: "6",
      "insert-space": ""
    },
    on: {
      open: _vm.handleOpen,
      apply: _vm.handleApply
    },
    scopedSlots: _vm._u([{
      key: "no-result",
      fn: function fn() {
        return [_c("div", {
          staticClass: "dim"
        }, [_vm._v("\r\n        No result\r\n      ")])];
      },
      proxy: true
    }, {
      key: "item-@",
      fn: function fn(_ref) {
        var item = _ref.item;
        return [_c("div", {
          staticClass: "user"
        }, [_c("img", {
          staticClass: "mention-user",
          attrs: {
            src: item.avatar,
            alt: "User Avatar"
          }
        }), _vm._v(" "), _c("span", {
          staticClass: "dim"
        }, [_vm._v(_vm._s(item.name))]), _vm._v(" "), _c("span", {
          staticClass: "dim"
        }, [_vm._v("(" + _vm._s(item.username) + ")")])])];
      }
    }])
  }, [_c("div", {
    staticClass: "position-relative w-100"
  }, [_c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.message,
      expression: "message"
    }],
    staticClass: "form-control mb-2",
    attrs: {
      placeholder: "Type your message here...",
      autofocus: "",
      row: "1"
    },
    domProps: {
      value: _vm.message
    },
    on: {
      keypress: function keypress($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
        if ($event.ctrlKey || $event.shiftKey || $event.altKey || $event.metaKey) return null;
        $event.preventDefault();
        return _vm.send();
      },
      keydown: _vm.isTyping,
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.message = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("i", {
    staticClass: "far fa-grin chat-emotion position-absolute",
    on: {
      click: _vm.toggleEmojiModal
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "d-flex align-items-center"
  }, [_c("button", {
    staticClass: "btn btn-light",
    on: {
      click: _vm.openFilePicker
    }
  }, [_c("i", {
    staticClass: "fas fa-paperclip"
  }), _vm._v(" Attach File\r\n    ")]), _vm._v(" "), _vm.file ? _c("div", {
    staticClass: "ml-2 d-flex align-items-center"
  }, [_c("i", {
    staticClass: "fas fa-file-alt mr-1"
  }), _vm._v(" "), _c("span", {
    staticClass: "file-name"
  }, [_vm._v(_vm._s(_vm.fileName))]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-sm text-danger p-0 ml-2 file-close-btn",
    on: {
      click: _vm.removeFile
    }
  }, [_vm._v("✖")])]) : _vm._e(), _vm._v(" "), _c("input", {
    ref: "fileInput",
    staticClass: "d-none",
    attrs: {
      type: "file"
    },
    on: {
      change: _vm.fileUpload
    }
  })])]), _vm._v(" "), _c("p", [_c("button", {
    staticClass: "btn btn-primary btn-sm float-right mb-2",
    attrs: {
      id: "btn-chat"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.send();
      }
    }
  }, [_vm._v("\r\n    Send\r\n    ")])])], 1)])]), _vm._v(" "), _c("vue-progress-bar")], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", [_c("b", [_c("i", [_vm._v("Start Group chat with project Members")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486 ***!
  \***************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [!_vm.isSubscribed ? _c("div", {
    staticClass: "alert alert-dark mt-2",
    attrs: {
      role: "alert"
    }
  }, [_c("b", [_vm._v("Only subscribed users can access this feature.")])]) : _vm._t("default")], 2);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.mention-item {\r\n  padding: 4px 10px;\r\n  border-radius: 4px;\n}\n.mention-selected {\r\n  background: rgb(192, 250, 153);\n}\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css");

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

/***/ "./resources/js/components/Project/Panel/Chat.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/Project/Panel/Chat.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Chat_vue_vue_type_template_id_96a9c2b8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Chat.vue?vue&type=template&id=96a9c2b8 */ "./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8");
/* harmony import */ var _Chat_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Chat.vue?vue&type=script&lang=js */ "./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css */ "./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Chat_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Chat_vue_vue_type_template_id_96a9c2b8__WEBPACK_IMPORTED_MODULE_0__["render"],
  _Chat_vue_vue_type_template_id_96a9c2b8__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Chat.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js":
/*!********************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css__WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8 ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_template_id_96a9c2b8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=template&id=96a9c2b8 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_template_id_96a9c2b8__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_template_id_96a9c2b8__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/SubscriptionChecker.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/SubscriptionChecker.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SubscriptionChecker.vue?vue&type=template&id=bc909486 */ "./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486");
/* harmony import */ var _SubscriptionChecker_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SubscriptionChecker.vue?vue&type=script&lang=js */ "./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SubscriptionChecker_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__["render"],
  _SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/SubscriptionChecker.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./SubscriptionChecker.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SubscriptionChecker.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486 ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./SubscriptionChecker.vue?vue&type=template&id=bc909486 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SubscriptionChecker.vue?vue&type=template&id=bc909486");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscriptionChecker_vue_vue_type_template_id_bc909486__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);