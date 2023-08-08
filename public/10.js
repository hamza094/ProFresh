(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[10],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Modal.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue2_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue2-editor */ "./node_modules/vue2-editor/dist/vue2-editor.esm.js");
/* harmony import */ var _utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../utils/TaskUtils */ "./resources/js/utils/TaskUtils.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_2__);



/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    VueEditor: vue2_editor__WEBPACK_IMPORTED_MODULE_0__["VueEditor"]
  },
  props: ['task', 'slug', 'state'],
  data: function data() {
    return {
      editing: 0,
      currentDate: new Date(),
      maxdateTime: null,
      edit: 0,
      memberPop: false,
      datePop: false,
      statuses: '',
      isEditable: false,
      due: '',
      form: {
        title: '',
        description: '',
        due_at: '',
        notified: '',
        status_id: '',
        search: ''
      },
      searchResults: "",
      taskMembers: [],
      model: {},
      errors: {},
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
  watch: {
    'form.search': Object(lodash__WEBPACK_IMPORTED_MODULE_2__["debounce"])(function (newSearch) {
      this.performSearch(newSearch);
    }, 500)
  },
  computed: {
    modifiedDate: function modifiedDate() {
      var modifiedDate = new Date(this.currentDate.getTime() + 30 * 60000);
      return modifiedDate.toISOString();
    },
    remainingTime: function remainingTime() {
      return Object(_utils_TaskUtils__WEBPACK_IMPORTED_MODULE_1__["calculateRemainingTime"])(this.task, this.currentDate);
    }
  },
  methods: {
    updateTitle: function updateTitle(id, task) {
      var _this = this;
      this.updateTask(id, task, {
        title: this.form.title
      }, function () {
        _this.editing = false;
        _this.errors = '';
      });
    },
    updateDescription: function updateDescription(id, task) {
      var _this2 = this;
      this.updateTask(id, task, {
        description: this.form.description
      }, function () {
        _this2.edit = false;
        _this2.errors = '';
      });
    },
    changeStatus: function changeStatus(statusId, task, id) {
      var _this3 = this;
      this.updateTask(id, task, {
        status_id: statusId
      }, function () {
        _this3.edit = false;
        _this3.errors = '';
      });
    },
    taskDue: function taskDue(id, task) {
      var _this4 = this;
      this.updateTask(id, task, {
        due_at: this.form.due_at,
        notified: this.form.notified
      }, function () {
        _this4.cancelDue();
      });
    },
    updateTask: function updateTask(id, task, data, additionalCallback) {
      var _this5 = this;
      if (this.areObjectsEqual(data, task)) {
        this.$vToastify.warning("Update not allowed. No changes were made.");
        return;
      }
      axios.put("/api/v1/projects/".concat(this.slug, "/task/").concat(id), data).then(function (response) {
        _this5.$vToastify.success(response.data.message);
        for (var key in response.data.task) {
          if (data.hasOwnProperty(key)) {
            task[key] = response.data.task[key];
          }
        }
        if (additionalCallback && typeof additionalCallback === 'function') {
          additionalCallback(response.data);
        }
      })["catch"](function (error) {
        _this5.errors = error.response.data.errors;
      });
    },
    areObjectsEqual: function areObjectsEqual(obj1, obj2) {
      return Object.keys(obj1).every(function (key) {
        return obj1[key] === obj2[key];
      });
    },
    closeTitleForm: function closeTitleForm(id, task) {
      this.editing = false;
      this.form.title = task.title;
      this.errors = '';
    },
    openTitleForm: function openTitleForm(id, task) {
      this.editing = id;
      this.form.title = task.title;
    },
    closeDescriptionForm: function closeDescriptionForm(id, task) {
      this.edit = false;
      this.form.description = task.description;
    },
    openDescriptionForm: function openDescriptionForm(id, task) {
      this.edit = id;
      this.form.description = task.description;
    },
    cancelDue: function cancelDue() {
      this.datePop = false;
      this.form.notified = '';
      this.form.due_at = '';
      this.errors = '';
    },
    modalClose: function modalClose() {
      this.$modal.hide('task-modal');
      this.errors = '';
      this.form = {};
      this.$emit('modal-closed');
    },
    performSearch: function performSearch(searchTerm) {
      var _this6 = this;
      axios.get("/api/v1/projects/".concat(this.slug, "/member/search"), {
        params: {
          search: this.form.search
        }
      }).then(function (response) {
        _this6.searchResults = response.data;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    addMember: function addMember(member, id) {
      this.taskMembers.push(member);
      this.searchResults = [];
      this.form.search = '';
    },
    removeMember: function removeMember(member, id) {
      this.taskMembers = this.taskMembers.filter(function (m) {
        return m !== member;
      });
    },
    assignMembers: function assignMembers(taskId) {
      var _this7 = this;
      if (this.taskMembers.length == 0) {
        return this.$vToastify.info('no member is selected to assign task');
      }
      var memberIds = this.taskMembers.map(function (member) {
        return member.id;
      });
      axios.patch("/api/v1/projects/".concat(this.slug, "/task/").concat(taskId, "/members"), {
        members: memberIds
      }).then(function (response) {
        _this7.taskMembers = [];
        _this7.task.members = response.data.taskMembers;
        _this7.errors = '';
        _this7.$vToastify.success(response.data.message);
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this7.errors = error.response.data.errors;
        }
      });
    },
    unassignMember: function unassignMember(taskId, memberId) {
      var _this8 = this;
      axios.patch("/api/v1/projects/".concat(this.slug, "/task/").concat(taskId, "/unassign"), {
        member: memberId
      }).then(function (response) {
        _this8.task.members = response.data.members;
        _this8.$vToastify.success(response.data.message);
      })["catch"](function (error) {
        console.log(error);
      });
    },
    hasError: function hasError(key) {
      return this.errors.hasOwnProperty(key);
    },
    getErrors: function getErrors(key) {
      if (this.hasError(key)) {
        return this.errors[key];
      }
      return [];
    },
    archive: function archive(taskId) {
      var _this9 = this;
      axios["delete"]("/api/v1/projects/".concat(this.slug, "/tasks/").concat(taskId, "/archive")).then(function (response) {
        //this.tasks=response.data.members;
        _this9.$vToastify.success(response.data.message);
      })["catch"](function (error) {
        console.log(error);
      });
    },
    trash: function trash() {
      console.log('delete');
    }
  },
  mounted: function mounted() {
    var _this10 = this;
    axios.get('/api/v1/task/statuses').then(function (response) {
      _this10.statuses = response.data;
    })["catch"]({});
  }
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
  }, [_c("div", {
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
  }) : _vm._e()]), _vm._v(" "), _c("div", {
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
    }, [_vm._v(_vm._s(member.username) + "\n      "), _c("span", {
      staticClass: "unassign-cross",
      on: {
        click: function click($event) {
          return _vm.unassignMember(_vm.task.id, member.id);
        }
      }
    }, [_vm._v("×")])])], 1);
  })], 2), _vm._v(" "), _vm.task.due_at ? _c("p", [_vm._m(2), _vm._v(" " + _vm._s(_vm._f("datetime")(_vm.task.due_at)))]) : _vm._e(), _vm._v(" "), _vm.task.notified ? _c("p", [_vm._m(3), _vm._v(_vm._s(_vm.task.notified) + " ")]) : _vm._e(), _vm._v(" "), _vm.task.due_at ? _c("p", [_c("small", [_c("b", [_vm._v("Days Left: ")]), _vm._v(_vm._s(this.remainingTime) + "  ")])]) : _vm._e()]), _vm._v(" "), _c("div", {
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
  }, [_vm._v("Cancel")])], 1) : _c("div", [_c("p", {
    staticClass: "task-description_content",
    domProps: {
      innerHTML: _vm._s(_vm.task.description)
    },
    on: {
      click: function click($event) {
        return _vm.openDescriptionForm(_vm.task.id, _vm.task);
      }
    }
  })])])]), _vm._v(" "), _c("div", {
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
    }, [_vm._v(_vm._s(status.label) + "\n                     "), _vm.task.status_id == status.id ? _c("span", [_c("i", {
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
  }), _vm._v(" "), _c("b", [_vm._v("Members")])]), _vm._v(" "), _c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.memberPop,
      expression: "memberPop"
    }],
    staticClass: "member-dropdown_item"
  }, [_vm._m(5), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.search,
      expression: "form.search"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "Search Members",
      name: "member",
      autocomplete: "off"
    },
    domProps: {
      value: _vm.form.search
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "search", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.hasError("members") ? _c("div", _vm._l(_vm.getErrors("members"), function (error) {
    return _c("span", {
      key: error,
      staticClass: "text-danger font-italic"
    }, [_vm._v("*" + _vm._s(error))]);
  }), 0) : _vm._e(), _vm._v(" "), _vm.hasError("members.0") ? _c("div", _vm._l(_vm.getErrors("members.0"), function (error) {
    return _c("span", {
      key: error,
      staticClass: "text-danger font-italic"
    }, [_vm._v("*" + _vm._s(error))]);
  }), 0) : _vm._e(), _vm._v(" "), _vm.searchResults.length > 0 && _vm.form.search ? _c("div", {
    staticClass: "member-list"
  }, _vm._l(_vm.searchResults, function (member) {
    return _c("div", {
      key: member.id,
      staticClass: "member-list_items"
    }, [_c("div", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.addMember(member, member.id);
        }
      }
    }, [_vm._v(_vm._s(member.name) + " (" + _vm._s(member.username) + ")\n              ")])]);
  }), 0) : _vm._e(), _vm._v(" "), _c("button", {
    staticClass: "mt-2 btn btn-sm btn-primary float-right",
    on: {
      click: function click($event) {
        return _vm.assignMembers(_vm.task.id);
      }
    }
  }, [_vm._v("Assign")]), _vm._v(" "), _vm.taskMembers.length > 0 ? _c("div", {
    staticClass: "mt-3",
    staticStyle: {
      height: "70px",
      width: "150px",
      "overflow-y": "scroll"
    }
  }, _vm._l(_vm.taskMembers, function (member) {
    return _c("div", [_c("span", [_vm._v(_vm._s(member.username) + " "), _c("span", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.removeMember(member, member.id);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-minus-circle"
    })])])]);
  }), 0) : _vm._e()])]), _vm._v(" "), _c("li", [_c("button", {
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
  }, [_c("span", [_vm._v("Due Date:\n\n                    \n                        "), _c("datetime", {
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
      selected: ""
    }
  }, [_vm._v("Choose...")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "1 Day Before"
    }
  }, [_vm._v("1 Day Before")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "2 Hours Before"
    }
  }, [_vm._v("2 Hours Before")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "15 Minutes Before"
    }
  }, [_vm._v("15 Minutes Before")]), _c("option", {
    attrs: {
      value: "5 Minutes Before"
    }
  }, [_vm._v("5 Minutes Before")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "At The Time"
    }
  }, [_vm._v("At The Time")])]), _vm._v(" "), _c("div", {
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
  }, [_vm._v("Set")])])])]), _vm._v(" "), _c("li", [_c("button", {
    staticClass: "btn btn-sm btn btn-sm btn-outline-info btn-block",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.archive(_vm.task.id);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-ban pr-1"
  }), _c("b", [_vm._v("Archive")])])]), _vm._v(" "), _c("li", [_c("button", {
    staticClass: "btn btn-sm btn btn-sm btn-outline-danger btn-block",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.trash();
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-trash-alt pr-1"
  }), _c("b", [_vm._v("\tDelete")])])])])])])])])]);
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
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "text-center m-1"
  }, [_c("small", [_c("b", [_vm._v("Assign Task To Member")])])]);
}];
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

/***/ "./resources/js/utils/TaskUtils.js":
/*!*****************************************!*\
  !*** ./resources/js/utils/TaskUtils.js ***!
  \*****************************************/
/*! exports provided: calculateRemainingTime */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "calculateRemainingTime", function() { return calculateRemainingTime; });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);

function calculateRemainingTime(task, currentDate) {
  if (task.due_at !== null) {
    var duration = moment__WEBPACK_IMPORTED_MODULE_0___default.a.duration(moment__WEBPACK_IMPORTED_MODULE_0___default()(task.due_at).diff(moment__WEBPACK_IMPORTED_MODULE_0___default()(currentDate)));
    if (duration.asMilliseconds() <= 0) {
      return 'Due date passed';
    }
    var days = duration.days();
    var hours = duration.hours();
    var minutes = duration.minutes();
    var messageParts = [];
    if (days > 0) {
      messageParts.push("".concat(days, " day(s)"));
    }
    if (hours > 0) {
      messageParts.push("".concat(hours, " hour(s)"));
    }
    if (minutes > 0) {
      messageParts.push("".concat(minutes, " minute(s)"));
    }
    return "".concat(messageParts.join(', '), " remaining");
  }
}

/***/ })

}]);