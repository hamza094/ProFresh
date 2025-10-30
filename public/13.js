(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[13],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingDetail.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/MeetingDetail.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    label: String,
    value: [String, Number],
    isEditing: Boolean
  },
  computed: {
    statusBadgeClass: function statusBadgeClass() {
      return this.value === 'Started' ? 'badge badge-success' : '';
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/ViewModal.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/ViewModal.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _MeetingDetail_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MeetingDetail.vue */ "./resources/js/components/Project/MeetingDetail.vue");
/* harmony import */ var _utils_meetingUtils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../utils/meetingUtils */ "./resources/js/utils/meetingUtils.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }



/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    MeetingDetail: _MeetingDetail_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  props: ['projectSlug', 'notAuthorize', 'members'],
  data: function data() {
    return {
      meeting: [],
      isEditing: false,
      errors: {},
      loader: false,
      loading: false,
      loaderId: null,
      auth: this.$store.state.currentUser.user,
      form: {
        meeting_id: '',
        topic: '',
        agenda: '',
        start_time: '',
        duration: '',
        join_before_host: '',
        timezone: '',
        password: ''
      }
    };
  },
  created: function created() {
    this.$bus.$on('view-meeting-modal', this.getMeeting);
  },
  beforeDestroy: function beforeDestroy() {
    this.$bus.$off('view-meeting-modal', this.getMeeting);
  },
  methods: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapMutations"])('meeting', {
    updateMeetingInState: 'meetingUpdate',
    removeMeetingFromState: 'removeMeetingFromState'
  })), {}, {
    emitInitializeMeting: function emitInitializeMeting(action, meeting) {
      this.$bus.$emit('initialize-meeting', action, meeting);
      this.meetingModalClose();
    },
    canStartMeeting: function canStartMeeting(meeting) {
      return Object(_utils_meetingUtils__WEBPACK_IMPORTED_MODULE_2__["canStartMeeting"])(meeting, this.auth, !this.notAuthorize);
    },
    canJoinMeeting: function canJoinMeeting(meeting) {
      return Object(_utils_meetingUtils__WEBPACK_IMPORTED_MODULE_2__["canJoinMeeting"])(meeting, this.auth, this.members);
    },
    updateMeeting: function updateMeeting(id) {
      var _this = this;
      this.initiliazeUpdateMeeting();
      var filteredForm = this.filterForm();
      axios.patch("/api/v1/projects/".concat(this.projectSlug, "/meetings/").concat(id), filteredForm).then(function (response) {
        _this.meeting = response.data.meeting;
        _this.updateMeetingInState(_this.meeting);
        _this.$vToastify.success(response.data.message);
        _this.meetingEditClose();
      })["catch"](function (error) {
        _this.handleErrorResponse(error);
      })["finally"](function () {
        _this.setLoading('', 'stop');
        _this.loading = false;
      });
    },
    deleteMeeting: function deleteMeeting(meeting) {
      var _this2 = this;
      this.setLoading('Deleting meeting, please wait...', 'start');
      this.loader = true;
      axios["delete"]("/api/v1/projects/".concat(this.projectSlug, "/meetings/").concat(meeting)).then(function (response) {
        _this2.meetingModalClose();
        _this2.removeMeetingFromState(meeting);
        _this2.$vToastify.success(response.data.message);
      })["catch"](function (error) {
        _this2.$vToastify.error('Meeting deletion failed');
      })["finally"](function () {
        _this2.setLoading('', 'stop');
        _this2.loader = false;
      });
    },
    getMeeting: function getMeeting(meetingId) {
      var _this3 = this;
      this.$modal.show('ViewMeeting');
      axios.get("/api/v1/projects/".concat(this.projectSlug, "/meetings/").concat(meetingId)).then(function (response) {
        _this3.meeting = response.data;
        _this3.form.agenda = _this3.meeting.agenda;
      })["catch"](function (error) {
        _this3.$vToastify.error('Meeting Loading failed');
      });
    },
    meetingEdit: function meetingEdit() {
      this.isEditing = true;
    },
    meetingEditClose: function meetingEditClose() {
      this.isEditing = false;
      this.form = {};
      this.errors = {};
      this.form.agenda = this.meeting.agenda;
    },
    meetingModalClose: function meetingModalClose() {
      this.$modal.hide('ViewMeeting');
      this.meeting = [];
    },
    filterForm: function filterForm() {
      return Object.fromEntries(Object.entries(this.form).filter(function (_ref) {
        var _ref2 = _slicedToArray(_ref, 2),
          key = _ref2[0],
          value = _ref2[1];
        return value !== null && value !== '';
      }));
    },
    initiliazeUpdateMeeting: function initiliazeUpdateMeeting() {
      this.form.meeting_id = this.meeting.meeting_id;
      this.form.start_time = this.convertToISO(this.form.start_time);
      this.errors = {};
      this.loading = true;
      this.setLoading('Updating meeting, please wait...', 'start');
    },
    setLoading: function setLoading(message, action) {
      if (action === 'start') {
        this.loaderId = this.$vToastify.loader(message);
      } else {
        this.$vToastify.stopLoader(this.loaderId);
        this.loaderId = null;
      }
    },
    convertToISO: function convertToISO(date) {
      return date ? new Date(date).toISOString() : date;
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingDetail.vue?vue&type=template&id=9fba0d0a&scoped=true":
/*!*****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/MeetingDetail.vue?vue&type=template&id=9fba0d0a&scoped=true ***!
  \*****************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("li", [_c("b", [_vm._v(_vm._s(_vm.label) + ": ")]), _vm._v(" "), _vm._t("default", function () {
    return [_c("span", {
      staticClass: "meeting_item"
    }, [_c("span", {
      "class": _vm.statusBadgeClass
    }, [_vm._v(_vm._s(_vm.value))])])];
  })], 2);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/ViewModal.vue?vue&type=template&id=2f3d50d2":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/ViewModal.vue?vue&type=template&id=2f3d50d2 ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", [_c("modal", {
    staticClass: "model-desin",
    attrs: {
      name: "ViewMeeting",
      height: "auto",
      scrollable: true,
      width: "40%",
      clickToClose: false
    }
  }, [_c("div", {
    staticClass: "edit-border-top p-3"
  }, [_vm.meeting.status === "Started" ? _c("div", {
    staticClass: "glowing-dot"
  }) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "edit-border-bottom"
  }, [_c("div", {
    staticClass: "panel-top_content"
  }, [_c("span", {
    staticClass: "meeting_heading"
  }, [_vm._v(_vm._s(_vm.meeting.topic))]), _vm._v(" "), _vm.isEditing ? _c("div", {
    staticClass: "form-group row"
  }, [_c("div", {
    staticClass: "col-md-9"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.topic,
      expression: "form.topic"
    }],
    staticClass: "form-control",
    attrs: {
      placeholder: "Edit meeting title"
    },
    domProps: {
      value: _vm.form.topic
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "topic", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.topic ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.topic[0])
    }
  }) : _vm._e()])]) : _vm._e(), _vm._v(" "), !_vm.isEditing ? _c("span", {
    staticClass: "panel-exit float-right",
    attrs: {
      role: "button"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.meetingModalClose.apply(null, arguments);
      }
    }
  }, [_vm._v("x")]) : _vm._e()])]), _vm._v(" "), _vm.meeting ? _c("div", {
    staticClass: "meeting"
  }, [_c("ul", {
    staticClass: "meeting_list"
  }, [!_vm.isEditing ? _c("meeting-detail", {
    attrs: {
      label: "Meeting ID",
      value: _vm.meeting.meeting_id
    }
  }) : _vm._e(), _vm._v(" "), _c("meeting-detail", {
    attrs: {
      label: "Agenda",
      isEditing: _vm.isEditing
    }
  }, [!_vm.isEditing ? [_c("span", [_vm._v(_vm._s(_vm.meeting.agenda))])] : [_c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.agenda,
      expression: "form.agenda"
    }],
    staticClass: "form-control",
    domProps: {
      value: _vm.form.agenda
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "agenda", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.agenda ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.agenda[0])
    }
  }) : _vm._e()]], 2), _vm._v(" "), _c("meeting-detail", {
    attrs: {
      label: "Start Time",
      isEditing: _vm.isEditing
    }
  }, [!_vm.isEditing ? [_c("span", [_vm._v(_vm._s(_vm.meeting.start_time))])] : [_c("datetime", {
    attrs: {
      type: "datetime",
      value: _vm.meeting.start_time,
      "value-zone": "local",
      zone: "local",
      format: "YYYY-MM-DD HH:mm:ss"
    },
    model: {
      value: _vm.form.start_time,
      callback: function callback($$v) {
        _vm.$set(_vm.form, "start_time", $$v);
      },
      expression: "form.start_time"
    }
  }), _vm._v(" "), _vm.errors.start_time ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.start_time[0])
    }
  }) : _vm._e()]], 2), _vm._v(" "), _c("meeting-detail", {
    attrs: {
      label: "Meeting Duration",
      isEditing: _vm.isEditing
    }
  }, [!_vm.isEditing ? [_c("span", [_vm._v(_vm._s(_vm.meeting.duration) + " Minutes")])] : [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.duration,
      expression: "form.duration"
    }],
    staticClass: "form-control",
    attrs: {
      id: "duration"
    },
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.form, "duration", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c("option", {
    attrs: {
      value: "",
      disabled: "",
      selected: ""
    }
  }, [_vm._v("Select Meeting Duration")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "15"
    }
  }, [_vm._v("15 minutes")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "30"
    }
  }, [_vm._v("30 minutes")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "45"
    }
  }, [_vm._v("45 minutes")])]), _vm._v(" "), _vm.errors.duration ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.duration[0])
    }
  }) : _vm._e()]], 2), _vm._v(" "), !_vm.isEditing ? _c("meeting-detail", {
    attrs: {
      label: "Status",
      value: _vm.meeting.status
    }
  }) : _vm._e(), _vm._v(" "), !_vm.isEditing && _vm.meeting.owner ? _c("meeting-detail", {
    attrs: {
      label: "Created By",
      value: _vm.meeting.owner.name
    }
  }) : _vm._e(), _vm._v(" "), !_vm.isEditing ? _c("meeting-detail", {
    attrs: {
      label: "Created At",
      value: _vm.meeting.created_at
    }
  }) : _vm._e(), _vm._v(" "), _c("meeting-detail", {
    attrs: {
      label: "Timezone",
      isEditing: _vm.isEditing
    }
  }, [!_vm.isEditing ? [_c("span", [_vm._v(_vm._s(_vm.meeting.timezone))])] : [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.timezone,
      expression: "form.timezone"
    }],
    staticClass: "form-control",
    domProps: {
      value: _vm.form.timezone
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "timezone", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.timezone ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.timezone[0])
    }
  }) : _vm._e()]], 2), _vm._v(" "), _c("meeting-detail", {
    attrs: {
      label: "Password",
      isEditing: _vm.isEditing
    }
  }, [!_vm.isEditing ? [_c("span", [_vm._v(_vm._s(_vm.meeting.password))])] : [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.password,
      expression: "form.password"
    }],
    staticClass: "form-control",
    domProps: {
      value: _vm.form.password
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "password", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.password ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.password[0])
    }
  }) : _vm._e()]], 2), _vm._v(" "), !_vm.isEditing ? _c("meeting-detail", {
    attrs: {
      label: "Updated At",
      value: _vm.meeting.updated_at
    }
  }) : _vm._e(), _vm._v(" "), _c("meeting-detail", {
    attrs: {
      label: "Join Before Host",
      isEditing: _vm.isEditing
    }
  }, [!_vm.isEditing ? [_c("span", [_vm._v(_vm._s(_vm.meeting.join_before_host))])] : [_c("div", {
    staticClass: "form-check form-check-inline"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.join_before_host,
      expression: "form.join_before_host"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "radio",
      id: "joinBefore",
      name: "joinBeforeHost"
    },
    domProps: {
      value: true,
      checked: _vm._q(_vm.form.join_before_host, true)
    },
    on: {
      change: function change($event) {
        return _vm.$set(_vm.form, "join_before_host", true);
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "joinBefore"
    }
  }, [_vm._v("Yes")])]), _vm._v(" "), _c("div", {
    staticClass: "form-check form-check-inline"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.join_before_host,
      expression: "form.join_before_host"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "radio",
      id: "joinAfter",
      name: "joinBeforeHost"
    },
    domProps: {
      value: false,
      checked: _vm._q(_vm.form.join_before_host, false)
    },
    on: {
      change: function change($event) {
        return _vm.$set(_vm.form, "join_before_host", false);
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label",
    attrs: {
      "for": "joinAfter"
    }
  }, [_vm._v("No")])]), _vm._v(" "), _c("br"), _vm._v(" "), _vm.errors.join_before_host ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.join_before_host[0])
    }
  }) : _vm._e(), _vm._v(" "), _c("br")]], 2), _vm._v(" "), !_vm.isEditing && Object.keys(_vm.meeting).length > 0 ? _c("li", [_vm.canStartMeeting(_vm.meeting) ? _c("button", {
    staticClass: "btn btn-secondary btn-sm",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.emitInitializeMeting("start", _vm.meeting);
      }
    }
  }, [_vm._v("Start Meeting As Owner")]) : _vm.canJoinMeeting(_vm.meeting) ? _c("button", {
    staticClass: "btn btn-secondary btn-sm",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.emitInitializeMeting("join", _vm.meeting);
      }
    }
  }, [_vm._v("Join Meeting")]) : _vm._e()]) : _vm._e()], 1), _vm._v(" "), Object.keys(_vm.meeting).length > 0 ? _c("div", {
    staticClass: "mt-3"
  }, [!_vm.isEditing ? _c("div", [_c("button", {
    staticClass: "btn btn-danger float-right mb-3",
    attrs: {
      disabled: _vm.loader
    },
    on: {
      click: function click($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "pervent", undefined, $event.key, undefined)) return null;
        return _vm.deleteMeeting(_vm.meeting.id);
      }
    }
  }, [_vm._v(_vm._s(_vm.loader ? "Deleting..." : "Delete"))]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary float-left mb-3",
    on: {
      click: function click($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "pervent", undefined, $event.key, undefined)) return null;
        return _vm.meetingEdit();
      }
    }
  }, [_vm._v("Edit")])]) : _c("div", [_c("button", {
    staticClass: "btn btn-info float-right mb-3",
    on: {
      click: function click($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "pervent", undefined, $event.key, undefined)) return null;
        return _vm.meetingEditClose();
      }
    }
  }, [_vm._v("Close")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary float-left mb-3",
    attrs: {
      disabled: _vm.loading
    },
    on: {
      click: function click($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "pervent", undefined, $event.key, undefined)) return null;
        return _vm.updateMeeting(_vm.meeting.id);
      }
    }
  }, [_vm._v(_vm._s(_vm.loading ? "Saving..." : "Save"))])])]) : _vm._e()]) : _vm._e()])])], 1);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\r\n/* your styles here */\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./resources/js/components/Project/MeetingDetail.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/Project/MeetingDetail.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MeetingDetail_vue_vue_type_template_id_9fba0d0a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MeetingDetail.vue?vue&type=template&id=9fba0d0a&scoped=true */ "./resources/js/components/Project/MeetingDetail.vue?vue&type=template&id=9fba0d0a&scoped=true");
/* harmony import */ var _MeetingDetail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MeetingDetail.vue?vue&type=script&lang=js */ "./resources/js/components/Project/MeetingDetail.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _MeetingDetail_vue_vue_type_style_index_0_id_9fba0d0a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css */ "./resources/js/components/Project/MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _MeetingDetail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _MeetingDetail_vue_vue_type_template_id_9fba0d0a_scoped_true__WEBPACK_IMPORTED_MODULE_0__["render"],
  _MeetingDetail_vue_vue_type_template_id_9fba0d0a_scoped_true__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "9fba0d0a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/MeetingDetail.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/MeetingDetail.vue?vue&type=script&lang=js":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/Project/MeetingDetail.vue?vue&type=script&lang=js ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./MeetingDetail.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingDetail.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/Project/MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_style_index_0_id_9fba0d0a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingDetail.vue?vue&type=style&index=0&id=9fba0d0a&scoped=true&lang=css");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_style_index_0_id_9fba0d0a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_style_index_0_id_9fba0d0a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_style_index_0_id_9fba0d0a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_style_index_0_id_9fba0d0a_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/Project/MeetingDetail.vue?vue&type=template&id=9fba0d0a&scoped=true":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/Project/MeetingDetail.vue?vue&type=template&id=9fba0d0a&scoped=true ***!
  \*****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_template_id_9fba0d0a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./MeetingDetail.vue?vue&type=template&id=9fba0d0a&scoped=true */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/MeetingDetail.vue?vue&type=template&id=9fba0d0a&scoped=true");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_template_id_9fba0d0a_scoped_true__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_MeetingDetail_vue_vue_type_template_id_9fba0d0a_scoped_true__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Project/ViewModal.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/Project/ViewModal.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ViewModal_vue_vue_type_template_id_2f3d50d2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ViewModal.vue?vue&type=template&id=2f3d50d2 */ "./resources/js/components/Project/ViewModal.vue?vue&type=template&id=2f3d50d2");
/* harmony import */ var _ViewModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ViewModal.vue?vue&type=script&lang=js */ "./resources/js/components/Project/ViewModal.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ViewModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _ViewModal_vue_vue_type_template_id_2f3d50d2__WEBPACK_IMPORTED_MODULE_0__["render"],
  _ViewModal_vue_vue_type_template_id_2f3d50d2__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/ViewModal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/ViewModal.vue?vue&type=script&lang=js":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/Project/ViewModal.vue?vue&type=script&lang=js ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ViewModal.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/ViewModal.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewModal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/ViewModal.vue?vue&type=template&id=2f3d50d2":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/Project/ViewModal.vue?vue&type=template&id=2f3d50d2 ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewModal_vue_vue_type_template_id_2f3d50d2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./ViewModal.vue?vue&type=template&id=2f3d50d2 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/ViewModal.vue?vue&type=template&id=2f3d50d2");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewModal_vue_vue_type_template_id_2f3d50d2__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewModal_vue_vue_type_template_id_2f3d50d2__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/utils/meetingUtils.js":
/*!********************************************!*\
  !*** ./resources/js/utils/meetingUtils.js ***!
  \********************************************/
/*! exports provided: shouldShowStartButton, shouldShowJoinButton */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "shouldShowStartButton", function() { return shouldShowStartButton; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "shouldShowJoinButton", function() { return shouldShowJoinButton; });
function shouldShowStartButton(meeting, auth, notAuthorize) {
  return !notAuthorize && meeting.owner.id === auth.id && meeting.status.toLowerCase() !== 'started';
}
function shouldShowJoinButton(meeting, auth, members) {
  return meeting.owner.id !== auth.id && members.includes(auth);
}

/***/ })

}]);