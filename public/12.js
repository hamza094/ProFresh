(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[12],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils_TaskUtils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../utils/TaskUtils */ "./resources/js/utils/TaskUtils.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _Modal_TopArea_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Modal/TopArea.vue */ "./resources/js/components/Project/Panel/Modal/TopArea.vue");
/* harmony import */ var _Modal_TaskDescription_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Modal/TaskDescription.vue */ "./resources/js/components/Project/Panel/Modal/TaskDescription.vue");
/* harmony import */ var _Modal_TaskMembers_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Modal/TaskMembers.vue */ "./resources/js/components/Project/Panel/Modal/TaskMembers.vue");
/* harmony import */ var _mixins_modalClose__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../../mixins/modalClose */ "./resources/js/mixins/modalClose.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }






/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    TopPanel: _Modal_TopArea_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    TaskDescription: _Modal_TaskDescription_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    TaskMembers: _Modal_TaskMembers_vue__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  props: ['slug', 'state', 'projectMembers'],
  data: function data() {
    return {
      currentDate: new Date(),
      maxdateTime: null,
      memberPop: false,
      datePop: false,
      isEditable: false,
      due: '',
      model: {}
    };
  },
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapState"])('SingleTask', ['task', 'errors', 'form', 'statuses', 'due_notifies'])), {}, {
    modifiedDate: function modifiedDate() {
      var modifiedDate = new Date(this.currentDate.getTime() + 30 * 60000);
      return modifiedDate.toISOString();
    },
    remainingTime: function remainingTime() {
      return Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_0__["calculateRemainingTime"])(this.task, this.currentDate);
    }
  }),
  created: function created() {
    var _this = this;
    this.$bus.on('close-members-popup', function () {
      _this.memberPop = false;
    });
  },
  methods: _objectSpread(_objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapMutations"])('task', ['removeTaskFromState', 'pushArchivedTask', 'removeArchivedTask'])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapMutations"])('SingleTask', ['setErrors', 'updateTaskStatus', 'updateTaskDue', 'unassignTaskMember', 'setForm'])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])({
    fetchTasks: 'task/fetchTasks'
  })), {}, {
    changeStatus: function changeStatus(statusId, task, id) {
      var _this2 = this;
      axios.put(Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_0__["url"])(this.slug, id), {
        status_id: statusId
      }).then(function (response) {
        _this2.$vToastify.success(response.data.message);
        _this2.setErrors([]);
        _this2.updateTaskStatus(response.data.task.status);
      })["catch"](function (error) {
        var _error$response$data$, _error$response;
        _this2.$vToastify.warning((_error$response$data$ = error === null || error === void 0 || (_error$response = error.response) === null || _error$response === void 0 || (_error$response = _error$response.data) === null || _error$response === void 0 || (_error$response = _error$response.errors) === null || _error$response === void 0 || (_error$response = _error$response.task) === null || _error$response === void 0 ? void 0 : _error$response[0]) !== null && _error$response$data$ !== void 0 ? _error$response$data$ : 'An error occurred.');
        _this2.setErrors(error.response.data.errors);
      });
    },
    taskDue: function taskDue(id, task) {
      var _this3 = this;
      axios.put(Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_0__["url"])(this.slug, id), {
        due_at: this.form.due_at,
        notified: this.form.notified
      }).then(function (response) {
        _this3.$vToastify.success(response.data.message);
        _this3.setErrors([]);
        _this3.updateTaskDue(_this3.form.due_at, response.data.task.notified);
        _this3.cancelDue();
      })["catch"](function (error) {
        _this3.setErrors(error.response.data.errors);
      });
    },
    cancelDue: function cancelDue() {
      this.datePop = false;
      this.form.notified = '';
      this.form.due_at = '';
      this.setErrors([]);
    },
    unassignMember: function unassignMember(taskId, memberId) {
      var _this4 = this;
      axios.patch(Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_0__["url"])(this.slug, taskId) + '/unassign', {
        member: memberId
      }).then(function (response) {
        _this4.unassignTaskMember(response.data.member.id);
        _this4.$vToastify.success(response.data.message);
        _this4.setErrors([]);
      })["catch"](function (error) {
        _this4.setErrors(error.response.data.errors);
      });
    },
    archive: function archive(task, taskId) {
      var _this5 = this;
      axios["delete"](Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_0__["url"])(this.slug, taskId) + '/archive').then(function (response) {
        console.log('success');
        _this5.$vToastify.warning(response.data.message);
        _this5.removeTaskFromState(taskId);
        _this5.pushArchivedTask(task);
        _this5.$bus.emit('archiveTask', {
          task: task
        });
        Object(_mixins_modalClose__WEBPACK_IMPORTED_MODULE_5__["modalClose"])(_this5);
      })["catch"](function (error) {
        console.log(error);
      });
    },
    unArchive: function unArchive(task, taskId) {
      var _this6 = this;
      axios.get(Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_0__["url"])(this.slug, taskId) + '/unarchive').then(function (response) {
        _this6.$vToastify.success(response.data.message);
        _this6.removeArchivedTask(taskId);
        _this6.fetchTasks({
          slug: _this6.$route.params.slug,
          page: 1
        });
        Object(_mixins_modalClose__WEBPACK_IMPORTED_MODULE_5__["modalClose"])(_this6);
        _this6.$bus.emit('unarchiveTask', {
          task: task
        });
      })["catch"](function (error) {
        _this6.setErrors(error.response.data.errors);
      });
    },
    trash: function trash(task, taskId) {
      var _this7 = this;
      axios["delete"](Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_0__["url"])(this.slug, taskId) + '/delete').then(function (response) {
        _this7.$vToastify.success(response.data.message);
        _this7.removeArchivedTask(taskId);
      })["catch"](function (error) {
        console.log(error);
      });
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue2_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue2-editor */ "./node_modules/vue2-editor/dist/vue2-editor.esm.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _utils_TaskUtils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../utils/TaskUtils */ "./resources/js/utils/TaskUtils.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }



/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['task', 'slug', 'errors'],
  components: {
    VueEditor: vue2_editor__WEBPACK_IMPORTED_MODULE_0__["VueEditor"]
  },
  data: function data() {
    return {
      edit: 0,
      customToolbar: [["bold", "italic", "underline"], [{
        list: "ordered"
      }, {
        list: "bullet"
      }], [{
        'header': [1, 2, 3, 4, 5, 6, false]
      }], ['blockquote'], [{
        'size': ['small', false, 'large', 'huge']
      }], ['link', 'unlink']]
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapState"])('SingleTask', ['form'])),
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapMutations"])('SingleTask', ['setErrors', 'updateTaskDescription'])), {}, {
    updateDescription: function updateDescription(id, task) {
      var _this = this;
      if (this.form.description === this.task.description) {
        return this.$vToastify.warning('No changes made.');
      }
      axios.put(Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_2__["url"])(this.slug, id), {
        description: this.form.description
      }).then(function (response) {
        _this.$vToastify.success(response.data.message);
        _this.edit = false;
        _this.setErrors([]);
        _this.updateTaskDescription(response.data.task.description);
      })["catch"](function (error) {
        _this.setErrors(error.response.data.errors);
      });
    },
    closeDescriptionForm: function closeDescriptionForm(id, task) {
      this.edit = false;
      this.form.description = task.description;
    },
    openDescriptionForm: function openDescriptionForm(id, task) {
      this.edit = id;
      this.form.description = task.description;
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../utils/TaskUtils */ "./resources/js/utils/TaskUtils.js");
/* harmony import */ var _mixins_modalClose__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../mixins/modalClose */ "./resources/js/mixins/modalClose.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }



/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['task', 'state', 'slug', 'errors'],
  data: function data() {
    return {
      editing: 0
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])('SingleTask', ['form'])),
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('SingleTask', ['setErrors', 'updateTaskTitle', 'setForm'])), {}, {
    updateTitle: function updateTitle(id, task) {
      var _this = this;
      if (this.form.title === this.task.title) {
        return this.$vToastify.warning('No changes made.');
      }
      axios.put(Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__["url"])(this.slug, id), {
        title: this.form.title
      }).then(function (response) {
        _this.$vToastify.success(response.data.message);
        _this.editing = false;
        _this.setErrors([]);
        _this.updateTaskTitle(response.data.task.title);
      })["catch"](function (error) {
        _this.setErrors(error.response.data.errors);
      });
    },
    closeTitleForm: function closeTitleForm(id, task) {
      this.editing = false;
      this.form.title = task.title;
      this.setErrors('');
    },
    openTitleForm: function openTitleForm(id, task) {
      this.editing = id;
      this.form.title = task.title;
    },
    modalClose: function modalClose() {
      Object(_mixins_modalClose__WEBPACK_IMPORTED_MODULE_2__["modalClose"])(this);
    }
  }),
  created: function created() {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "edit-border-top p-3 task-modal"
  }, [_c("TopPanel", {
    attrs: {
      task: _vm.task,
      state: _vm.state,
      slug: _vm.slug,
      errors: _vm.errors
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "panel-form mt-2"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("div", {
    staticClass: "task-feature"
  }, [_c("p", [_vm._m(0), _vm._v(":\n          \t\t\t\t\t"), _c("span", {
    staticClass: "task-option_labels-component",
    style: {
      backgroundColor: _vm.task.status.color
    }
  }, [_vm._v(_vm._s(_vm.task.status.label))]), _vm._v(" "), _vm._m(1), _vm._v(" "), _vm._l(_vm.task.members, function (member) {
    return _c("span", {
      key: member.id,
      staticClass: "task-member-container"
    }, [_c("router-link", {
      staticClass: "task-member mr-1",
      attrs: {
        to: "/user/".concat(member.id, "/profile"),
        target: "_blank"
      }
    }, [_vm._v(_vm._s(member.name.charAt(0)))]), _vm._v(" "), _c("span", {
      staticClass: "task-member-username"
    }, [_vm._v(_vm._s(member.username) + "\n                     "), _c("span", {
      staticClass: "unassign-cross",
      on: {
        click: function click($event) {
          return _vm.unassignMember(_vm.task.id, member.id);
        }
      }
    }, [_vm._v("×")])])], 1);
  })], 2), _vm._v(" "), _vm.errors.member ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.member)
    }
  }) : _vm._e(), _vm._v(" "), _c("p"), _vm._v(" "), _vm.task.due_at ? _c("p", [_vm._m(2), _vm._v(" " + _vm._s(_vm._f("datetime")(_vm.task.due_at)))]) : _vm._e(), _vm._v(" "), _vm.task.notified ? _c("p", [_vm._m(3), _vm._v(_vm._s(_vm.task.notified) + " ")]) : _vm._e(), _vm._v(" "), _vm.task.due_at ? _c("p", [_c("small", [_c("b", [_vm._v("Days Left: ")]), _vm._v(_vm._s(this.remainingTime) + "  ")])]) : _vm._e()]), _vm._v(" "), _c("TaskDescription", {
    attrs: {
      task: _vm.task,
      slug: _vm.slug,
      errors: _vm.errors
    }
  })], 1), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "task-option"
  }, [_vm._m(4), _vm._v(" "), _c("h5", {
    staticClass: "text-center"
  }, [_vm._v("Change Label")]), _vm._v(" "), _c("ul", {
    staticClass: "task-option_labels"
  }, _vm._l(_vm.statuses, function (status) {
    return _c("li", {
      key: status.id
    }, [_c("p", {
      staticClass: "task-option_labels-component",
      style: {
        backgroundColor: status.color
      },
      on: {
        click: function click($event) {
          return _vm.changeStatus(status.id, _vm.task, _vm.task.id);
        }
      }
    }, [_vm._v("\n                      " + _vm._s(status.label) + "\n                     "), _vm.task.status_id == status.id ? _c("span", [_c("i", {
      staticClass: "fas fa-check-circle",
      staticStyle: {
        color: "#2a971c"
      }
    })]) : _vm._e()])]);
  }), 0), _vm._v(" "), _c("ul", {
    staticClass: "task-option_features"
  }, [_c("li", [_c("button", {
    staticClass: "btn btn-sm btn-outline-primary btn-block member-dropdown",
    on: {
      click: function click($event) {
        $event.preventDefault();
        _vm.memberPop = !_vm.memberPop;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-user-alt pr-1"
  }), _vm._v(" "), _c("b", [_vm._v("Members")])]), _vm._v(" "), _c("TaskMembers", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.memberPop,
      expression: "memberPop"
    }],
    attrs: {
      slug: _vm.slug
    }
  })], 1), _vm._v(" "), _c("li", [_c("button", {
    staticClass: "btn btn-sm btn btn-sm btn-outline-success btn-block",
    on: {
      click: function click($event) {
        $event.preventDefault();
        _vm.datePop = !_vm.datePop;
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-clock pr-1"
  }), _c("b", [_vm._v("Due Date")])]), _vm._v(" "), _c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.datePop,
      expression: "datePop"
    }],
    staticClass: "member-dropdown_item"
  }, [_c("span", [_vm._v("Due Date:\n                        "), _c("datetime", {
    attrs: {
      type: "datetime",
      "value-zone": "local",
      zone: "local",
      "min-datetime": _vm.modifiedDate
    },
    model: {
      value: _vm.form.due_at,
      callback: function callback($$v) {
        _vm.$set(_vm.form, "due_at", $$v);
      },
      expression: "form.due_at"
    }
  })], 1), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.notified,
      expression: "form.notified"
    }],
    staticClass: "custom-select mr-sm-2",
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.form, "notified", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c("option", {
    attrs: {
      value: ""
    }
  }, [_vm._v("Choose Option")]), _vm._v(" "), _vm._l(_vm.due_notifies, function (notify) {
    return _c("option", {
      domProps: {
        value: notify
      }
    }, [_vm._v(_vm._s(notify))]);
  })], 2), _vm._v(" "), _c("div", {
    staticClass: "float-right mt-2"
  }, [_c("button", {
    staticClass: "btn btn-sm btn-secondary",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.cancelDue();
      }
    }
  }, [_vm._v("Cancel")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-sm btn-primary",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.taskDue(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Set")])])])]), _vm._v(" "), _c("li", [_vm.state == "active" ? _c("button", {
    staticClass: "btn btn-sm btn btn-sm btn-outline-info btn-block",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.archive(_vm.task, _vm.task.id);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-ban pr-1"
  }), _c("b", [_vm._v("Archive")])]) : _c("button", {
    staticClass: "btn btn-sm btn btn-sm btn-outline-secondary btn-block",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.unArchive(_vm.task, _vm.task.id);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-ban pr-1"
  }), _c("b", [_vm._v("UnArchive")])])]), _vm._v(" "), _c("li", [_vm.state == "archived" ? _c("button", {
    staticClass: "btn btn-sm btn btn-sm btn-outline-danger btn-block",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.trash(_vm.task, _vm.task.id);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-trash-alt pr-1"
  }), _c("b", [_vm._v("\tDelete")])]) : _vm._e()])])])])])])], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("small", [_c("b", [_vm._v("Label")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("small", {
    staticClass: "ml-2"
  }, [_c("b", [_vm._v("Members:")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("small", [_c("b", [_vm._v("Task due: ")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("small", [_c("b", [_vm._v("Notified: ")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("span", {
    staticClass: "text-center ml-4"
  }, [_c("b", [_vm._v("Options")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=template&id=ea9580ce&":
/*!********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=template&id=ea9580ce& ***!
  \********************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "task-description"
  }, [_c("p", {
    staticClass: "task-description_container"
  }, [_c("span", {
    staticClass: "task-description_heading"
  }, [_vm._v("Description:")]), _vm._v(" "), _vm.errors.description ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.description)
    }
  }) : _vm._e()]), _vm._v(" "), _vm.edit == _vm.task.id ? _c("div", [_c("vue-editor", {
    attrs: {
      name: "description",
      editorToolbar: _vm.customToolbar
    },
    model: {
      value: _vm.form.description,
      callback: function callback($$v) {
        _vm.$set(_vm.form, "description", $$v);
      },
      expression: "form.description"
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.updateDescription(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Update")]), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.closeDescriptionForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Cancel")])], 1) : _c("div", [_vm.task.description ? _c("p", {
    staticClass: "task-description_content",
    domProps: {
      innerHTML: _vm._s(_vm.task.description)
    },
    on: {
      click: function click($event) {
        return _vm.openDescriptionForm(_vm.task.id, _vm.task);
      }
    }
  }) : _c("div", [_c("p", {
    staticClass: "task-description_content"
  }, [_vm._v("Sorry! currently no task description present. "), _c("span", {
    staticClass: "task-description_content-link",
    on: {
      click: function click($event) {
        return _vm.openDescriptionForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v(" Click here to add description")])])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "edit-border-bottom"
  }, [_c("div", {
    staticClass: "task-modal_content"
  }, [_vm.editing == _vm.task.id ? _c("span", [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.title,
      expression: "form.title"
    }],
    staticClass: "title-form form-control",
    attrs: {
      name: "title"
    },
    domProps: {
      value: _vm.form.title,
      textContent: _vm._s(_vm.task.title)
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "title", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.updateTitle(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Update")]), _vm._v(" "), _c("span", {
    staticClass: "btn btn-link btn-sm",
    on: {
      click: function click($event) {
        return _vm.closeTitleForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v("Cancel")])]) : _c("span", {
    staticClass: "task-modal_title",
    on: {
      click: function click($event) {
        return _vm.openTitleForm(_vm.task.id, _vm.task);
      }
    }
  }, [_vm._v(_vm._s(_vm.task.title))]), _vm._v(" "), _c("span", {
    staticClass: "task-modal_close float-right",
    attrs: {
      role: "button"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.modalClose.apply(null, arguments);
      }
    }
  }, [_vm._v("x")])]), _vm._v(" "), _vm.errors.title ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.title[0])
    }
  }) : _vm._e()]), _vm._v(" "), _vm.state == "archived" ? _c("div", {
    staticClass: "alert alert-warning",
    attrs: {
      role: "alert"
    }
  }, [_vm._v("\nPlease note that this task is currently archived. Currently, you can only delete or unarchive this task.\n")]) : _vm._e()]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Modal.vue?vue&type=template&id=041ce091& */ "./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091&");
/* harmony import */ var _Modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Modal.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Modal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Modal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Modal.vue?vue&type=template&id=041ce091& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=template&id=041ce091&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Modal_vue_vue_type_template_id_041ce091___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TaskDescription.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TaskDescription.vue ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TaskDescription_vue_vue_type_template_id_ea9580ce___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TaskDescription.vue?vue&type=template&id=ea9580ce& */ "./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=template&id=ea9580ce&");
/* harmony import */ var _TaskDescription_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TaskDescription.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TaskDescription_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TaskDescription_vue_vue_type_template_id_ea9580ce___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TaskDescription_vue_vue_type_template_id_ea9580ce___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Modal/TaskDescription.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskDescription_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TaskDescription.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskDescription_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=template&id=ea9580ce&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=template&id=ea9580ce& ***!
  \********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskDescription_vue_vue_type_template_id_ea9580ce___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TaskDescription.vue?vue&type=template&id=ea9580ce& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TaskDescription.vue?vue&type=template&id=ea9580ce&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskDescription_vue_vue_type_template_id_ea9580ce___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TaskDescription_vue_vue_type_template_id_ea9580ce___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TopArea.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TopArea.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TopArea_vue_vue_type_template_id_e9f8c338_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TopArea.vue?vue&type=template&id=e9f8c338&scoped=true& */ "./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true&");
/* harmony import */ var _TopArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TopArea.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TopArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TopArea_vue_vue_type_template_id_e9f8c338_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TopArea_vue_vue_type_template_id_e9f8c338_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "e9f8c338",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Modal/TopArea.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TopArea.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true& ***!
  \************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_template_id_e9f8c338_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./TopArea.vue?vue&type=template&id=e9f8c338&scoped=true& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal/TopArea.vue?vue&type=template&id=e9f8c338&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_template_id_e9f8c338_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_TopArea_vue_vue_type_template_id_e9f8c338_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/mixins/modalClose.js":
/*!*******************************************!*\
  !*** ./resources/js/mixins/modalClose.js ***!
  \*******************************************/
/*! exports provided: modalClose */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "modalClose", function() { return modalClose; });
function modalClose(context) {
  context.$modal.hide('task-modal');
  context.$modal.hide('archive-task-modal');
  context.setErrors('');
  context.setForm({});
  context.$emit('modal-closed');
}

/***/ })

}]);