(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var emoji_mart_vue_fast_data_all_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! emoji-mart-vue-fast/data/all.json */ "./node_modules/emoji-mart-vue-fast/data/all.json");
var emoji_mart_vue_fast_data_all_json__WEBPACK_IMPORTED_MODULE_0___namespace = /*#__PURE__*/__webpack_require__.t(/*! emoji-mart-vue-fast/data/all.json */ "./node_modules/emoji-mart-vue-fast/data/all.json", 1);
/* harmony import */ var vue_mention__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-mention */ "./node_modules/vue-mention/dist/vue-mention.esm.js");
/* harmony import */ var emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! emoji-mart-vue-fast */ "./node_modules/emoji-mart-vue-fast/dist/emoji-mart.js");
/* harmony import */ var emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }



var emojiIndex = new emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2__["EmojiIndex"](emoji_mart_vue_fast_data_all_json__WEBPACK_IMPORTED_MODULE_0__);
/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    Picker: emoji_mart_vue_fast__WEBPACK_IMPORTED_MODULE_2__["Picker"],
    Mentionable: vue_mention__WEBPACK_IMPORTED_MODULE_1__["Mentionable"]
  },
  props: ['conversations', 'slug', 'users', 'auth'],
  data: function data() {
    return {
      emojiIndex: emojiIndex,
      message: '',
      typing: false,
      emojiModal: false,
      user: this.auth,
      file: '',
      items: []
    };
  },
  methods: {
    onOpen: function onOpen(key) {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.items = key === '@' ? _this2.users : '';
              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onApply: function onApply(item, key) {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this3.message = _this3.message + '@' + item.username;
                _this3.message = _this3.message.replace('@undefined', '');
              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    showEmoji: function showEmoji(emoji) {
      if (!emoji) return false;
      this.message = !this.message ? emoji["native"] : this.message + emoji["native"];
    },
    fileUpload: function fileUpload() {
      var _this4 = this;
      this.file = this.$refs.file.files[0];
      var formData = new FormData();
      formData.append("file", this.file);
      this.$Progress.start();
      this.$vToastify.info('Be patient file uploading');
      axios.post('/api/v1/projects/' + this.slug + '/conversations', formData).then(function (response) {
        _this4.$Progress.finish();
        _this4.$vToastify.success("File Uploaded");
      })["catch"](function (error) {
        _this4.$vToastify.error("Failed to upload a file.");
        _this4.$Progress.fail();
      });
    },
    send: function send() {
      var _this5 = this;
      if (this.message.length !== 0) {
        axios.post('/api/v1/projects/' + this.slug + '/conversations', {
          message: this.message
        }).then(function (response) {
          _this5.message = '';
        })["catch"](function (error) {
          _this5.$vToastify.warning("Error! Try Again");
        });
      }
    },
    deleteConversation: function deleteConversation(id, index) {
      var _this6 = this;
      axios["delete"]('/api/v1/projects/' + this.slug + '/conversations/' + id).then(function (response) {
        _this6.$vToastify.info("Wait a sec..");
      })["catch"](function (error) {
        _this6.$vToastify.warning("Task deletion failed");
      });
    },
    isTyping: function isTyping() {
      var channel = Echo["private"]('typing.' + this.getProjectSlug());
      var _this = this;
      setTimeout(function () {
        channel.whisper('typing-indicator', {
          user: _this.$store.state.currentUser.user,
          typing: true
        });
      }, 300);
    },
    chatEmotion: function chatEmotion() {
      this.emojiModal = !this.emojiModal;
    }
  },
  created: function created() {
    var _this7 = this;
    var _this = this;
    Echo["private"]('typing.' + this.getProjectSlug()).listenForWhisper('typing-indicator', function (e) {
      _this7.user = e.user;
      _this7.typing = e.typing;

      // remove is typing indicator after 0.9s
      setTimeout(function () {
        _this.typing = false;
      }, 900);
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8& ***!
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
  return _c("div", [_c("div", {
    staticClass: "card chat-card mb-5"
  }, [_c("div", {
    staticClass: "card-header text-white bg-primary",
    attrs: {
      id: "accordion"
    }
  }, [_c("span", [_c("i", {
    staticClass: "fas fa-comment-alt"
  }), _vm._v("\r\n     Group chat  \r\n     "), _vm.conversations ? _c("span", {
    staticClass: "badge badge-secondary"
  }, [_vm._v("\r\n     " + _vm._s(_vm.conversations.length) + "\r\n   ")]) : _vm._e(), _vm._v(" messages\r\n   ")]), _vm._v(" "), _c("a", {
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
  }, [_vm._l(_vm.conversations, function (conversation, index) {
    return _c("li", {
      key: index
    }, [_c("div", {
      staticClass: "chat-body clearfix"
    }, [_c("div", {
      staticClass: "header"
    }, [_c("router-link", {
      attrs: {
        to: "/user/" + conversation.user[0].name + "/profile"
      }
    }, [_c("img", {
      staticClass: "chat-user_image",
      attrs: {
        src: conversation.user[0].avatar_path,
        alt: "User Avatar"
      }
    })]), _vm._v(" "), _c("strong", {
      staticClass: "primary-font"
    }, [_vm._v("\r\n      " + _vm._s(conversation.user[0].name))])], 1), _vm._v(" "), conversation.message ? _c("p", {
      staticClass: "mt-2"
    }, [_c("span", {
      staticClass: "chat-message",
      domProps: {
        innerHTML: _vm._s(conversation.message)
      }
    })]) : _vm._e(), _vm._v(" "), conversation.file ? _c("p", {
      staticClass: "mt-2"
    }, [conversation.file.includes(".png" || false || false) ? _c("span", [_c("img", {
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
    }, [_c("i", [_vm._v(_vm._s(conversation.created_at))])]), _vm._v(" "), _vm.auth.id == conversation.user[0].id ? _c("button", {
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
  }, [_vm._v("\r\n              💬  @" + _vm._s(_vm.user.name) + " is typing...\r\n          ")]) : _c("span", {
    staticClass: "help-block",
    staticStyle: {
      "font-style": "italic"
    }
  }, [_vm._v("\r\n                💬\r\n          ")])], 2)]), _vm._v(" "), _c("div", {
    staticClass: "card-footer gioj"
  }, [_c("div", {
    staticClass: "chat-floating"
  }, [_vm.emojiModal ? _c("Picker", {
    staticClass: "emojiModal",
    attrs: {
      data: _vm.emojiIndex,
      set: "twitter",
      title: "Pick your emoji…",
      showPreview: false
    },
    on: {
      select: _vm.showEmoji
    }
  }) : _vm._e()], 1), _vm._v(" "), _c("Mentionable", {
    attrs: {
      keys: ["@"],
      items: _vm.items,
      offset: "6",
      "insert-space": ""
    },
    on: {
      open: _vm.onOpen,
      apply: _vm.onApply
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
            src: item.avatar_path,
            alt: "User Avatar"
          }
        }), _vm._v(" "), _c("span", {
          staticClass: "dim"
        }, [_vm._v("\r\n          " + _vm._s(item.name) + "\r\n        ")]), _vm._v(" "), _c("span", {
          staticClass: "dim"
        }, [_vm._v("\r\n          (" + _vm._s(item.username) + ")\r\n        ")])])];
      }
    }])
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
  })]), _vm._v(" "), _c("p", [_c("span", {
    staticClass: "input-group-btn"
  }, [_c("i", {
    staticClass: "far fa-grin chat-emotion",
    on: {
      click: function click($event) {
        return _vm.chatEmotion();
      }
    }
  }), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary btn-sm",
    attrs: {
      id: "btn-chat"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.send();
      }
    }
  }, [_vm._v("Send")])]), _vm._v(" "), _c("input", {
    ref: "file",
    staticClass: "inputfile btn btn-sm mt-2",
    attrs: {
      type: "file",
      name: "file",
      value: "upload file",
      accept: "image/jpeg,image/png,application/pdf"
    },
    on: {
      change: function change($event) {
        return _vm.fileUpload();
      }
    }
  })])], 1)])]), _vm._v(" "), _c("vue-progress-bar")], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.mention-item {\r\n  padding: 4px 10px;\r\n  border-radius: 4px;\n}\n.mention-selected {\r\n  background: rgb(192, 250, 153);\n}\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css&");

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
/* harmony import */ var _Chat_vue_vue_type_template_id_96a9c2b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Chat.vue?vue&type=template&id=96a9c2b8& */ "./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8&");
/* harmony import */ var _Chat_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Chat.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css& */ "./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Chat_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Chat_vue_vue_type_template_id_96a9c2b8___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Chat_vue_vue_type_template_id_96a9c2b8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css& ***!
  \*****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader??ref--6-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--6-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=style&index=0&id=96a9c2b8&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_96a9c2b8_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_template_id_96a9c2b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=template&id=96a9c2b8& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Chat.vue?vue&type=template&id=96a9c2b8&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_template_id_96a9c2b8___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_template_id_96a9c2b8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);