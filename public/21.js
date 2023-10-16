(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[21],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Page.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Page.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Status_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Status.vue */ "./resources/js/components/Project/Status.vue");
/* harmony import */ var _Stage_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Stage.vue */ "./resources/js/components/Project/Stage.vue");
/* harmony import */ var _Panel_Task_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Panel/Task.vue */ "./resources/js/components/Project/Panel/Task.vue");
/* harmony import */ var _Panel_Features_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Panel/Features.vue */ "./resources/js/components/Project/Panel/Features.vue");
/* harmony import */ var _RecentActivities_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./RecentActivities.vue */ "./resources/js/components/Project/RecentActivities.vue");
/* harmony import */ var _Panel_Chat_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./Panel/Chat.vue */ "./resources/js/components/Project/Panel/Chat.vue");
/* harmony import */ var _auth__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../auth */ "./resources/js/auth.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }








/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    Status: _Status_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    Stage: _Stage_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    Task: _Panel_Task_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    PanelFeatues: _Panel_Features_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    RecentActivities: _RecentActivities_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
    Chat: _Panel_Chat_vue__WEBPACK_IMPORTED_MODULE_5__["default"]
  },
  data: function data() {
    return {
      color: '#301934',
      nameEdit: false,
      aboutEdit: false,
      projectname: '',
      projectabout: '',
      auth: this.$store.state.currentUser.user,
      conversations: [],
      chatusers: [],
      Hot_Score: 21,
      path: '',
      members: '',
      show: false
    };
  },
  created: function created() {
    var _this = this;
    var slug = this.$route.params.slug;
    this.loadProject(slug).then(function () {
      _this.show = true;
      _this.projectname = _this.project.name;
      _this.projectabout = _this.project.about;
      _this.members = _this.project.members;
      _this.archiveTask();
    })["catch"](function (error) {
      console.log(error.response.data.errors);
    });
  },
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_7__["mapState"])('project', ['project', 'user', 'getStage', 'tasks'])), {}, {
    permission: function permission() {
      var _permission2 = Object(_auth__WEBPACK_IMPORTED_MODULE_6__["permission"])(this.auth.id, this.project.members, this.user.id),
        access = _permission2.access,
        owner = _permission2.owner;
      return {
        access: access,
        owner: owner
      };
    },
    status: function status() {
      return this.project.score > this.Hot_Score ? 'hot' : 'cold';
    }
  }),
  methods: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_7__["mapActions"])('project', ['loadProject'])), Object(vuex__WEBPACK_IMPORTED_MODULE_7__["mapMutations"])('project', ['nameUpdate', 'aboutUpdate'])), {}, {
    updateName: function updateName() {
      var _this2 = this;
      axios.patch("/api/v1/projects/".concat(this.project.slug), {
        name: this.projectname
      }).then(function (response) {
        _this2.updateNameState(response.data.name, response.data.slug, response.data.message);
        _this2.updateUrl(response.data.slug);
      })["catch"](function (error) {
        _this2.nameEdit = false;
        _this2.projectname = _this2.project.name;
        _this2.showError(error);
      });
    },
    updateUrl: function updateUrl(url) {
      window.history.replaceState({
        additionalInformation: 'Updated the URL with Slug'
      }, 'Updated Project URL', "http://127.0.0.1:8000/projects/".concat(url));
    },
    updateNameState: function updateNameState(name, slug, msg) {
      this.nameUpdate(name, slug);
      this.projectname = name;
      this.nameEdit = false;
      this.$vToastify.success(msg);
    },
    cancelUpdate: function cancelUpdate() {
      this.nameEdit = false;
      this.projectname = this.project.name;
    },
    updateAbout: function updateAbout() {
      var _this3 = this;
      axios.patch("/api/v1/projects/".concat(this.project.slug), {
        about: this.projectabout
      }).then(function (response) {
        _this3.aboutUpdate(response.data.about);
        _this3.projectabout = response.data.about;
        _this3.aboutEdit = false;
        _this3.$vToastify.success(response.data.messge);
      })["catch"](function (error) {
        _this3.aboutEdit = false;
        _this3.projectabout = _this3.project.about;
        _this3.showError(error);
      });
    },
    editAbout: function editAbout() {
      this.aboutEdit = true;
      this.projectabout = this.project.about;
    },
    aboutCancel: function aboutCancel() {
      this.aboutEdit = false;
      this.projectabout = this.project.about;
    },
    restore: function restore() {
      this.performAction('Yes, Make live again!', axios.get("/api/v1/projects/".concat(this.project.slug, "/restore")));
    },
    //show error messages
    showError: function showError(err) {
      var _this4 = this;
      var _err$response$data = err.response.data,
        errors = _err$response$data.errors,
        error = _err$response$data.error;
      if (errors) {
        Object.keys(errors).forEach(function (field) {
          _this4.$vToastify.warning(errors[field][0]);
        });
      } else if (error) {
        this.$vToastify.warning(error);
      }
    },
    listenForActivity: function listenForActivity() {
      var _this5 = this;
      Echo.channel('activity').listen('ActivityLogged', function (e) {
        _this5.project.activities.unshift(e);
      });
    },
    listenForNewMessage: function listenForNewMessage() {
      var _this6 = this;
      Echo["private"]("conversations.".concat(this.getProjectSlug())).listen('NewMessage', function (e) {
        _this6.project.conversations.push(e);
      });
    },
    listenToDeleteConversation: function listenToDeleteConversation() {
      var _this7 = this;
      Echo["private"]("deleteConversation.".concat(this.getProjectSlug())).listen('DeleteConversation', function (e) {
        _this7.project.conversations.splice(_this7.project.conversations.indexOf(e), 1);
        _this7.$vToastify.success("conversation deleted");
      });
    },
    connectToEcho: function connectToEcho() {
      var _this8 = this;
      Echo.join("chatroom.".concat(this.getProjectSlug())).here(function (members) {
        _this8.chatusers = members;
      }).joining(function (auth) {
        _this8.chatusers.push(auth);
        _this8.$vToastify.info("".concat(auth.name, " joined project conversation"));
      }).leaving(function (auth) {
        _this8.chatusers.splice(_this8.chatusers.indexOf(auth), 1);
        _this8.$vToastify.info("".concat(auth.name, " leave project conversation"));
      });
    },
    archiveTask: function archiveTask() {
      var _this9 = this;
      this.$bus.on('archiveTask', function (taskId) {
        if (_this9.project.activities.subject_id !== null) {
          _this9.project.activities = _this9.project.activities.filter(function (activity) {
            return activity.subject_id !== taskId;
          });
        }
        console.log('eventliten');
      });
    },
    unarchiveTask: function unarchiveTask() {}
  }),
  mounted: function mounted() {
    this.listenForNewMessage();
    this.listenToDeleteConversation();
    this.listenForActivity();
    this.path = this.getProjectSlug();
    this.connectToEcho();
  },
  beforeDestroy: function beforeDestroy() {
    Echo.leave('chatroom.' + this.path);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Modal_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Modal.vue */ "./resources/js/components/Project/Panel/Modal.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }


//import SubscriptionCheck from '../../SubscriptionChecker.vue';
/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    TaskModal: _Modal_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: ['slug', 'access'],
  data: function data() {
    return {
      currentTasks: [],
      task_score: 2,
      state: 'active',
      form: {
        title: ''
      },
      errors: {}
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapState"])('task', ['tasks', 'message'])),
  methods: _objectSpread(_objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapActions"])({
    fetchTasks: 'task/fetchTasks',
    loadStatuses: 'SingleTask/loadStatuses'
  })), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapMutations"])('project', ['addScore', 'reduceScore'])), Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapMutations"])('SingleTask', ['setTask'])), {}, {
    getResults: function getResults(page) {
      var slug = this.$route.params.slug;
      this.fetchTasks({
        slug: slug,
        page: page
      });
    },
    archiveTasks: function archiveTasks() {
      var panel1Handle = this.$showPanel({
        component: 'archive-tasks',
        openOn: 'right',
        width: 440,
        disableBgClick: true,
        keepAlive: true,
        props: {
          slug: this.slug
        }
      });
      panel1Handle.promise.then(function (result) {});
    },
    openModal: function openModal(task) {
      this.setTask(task);
      this.$modal.show('task-modal');
    },
    add: function add() {
      var _this = this;
      axios.post('/api/v1/projects/' + this.slug + '/tasks', this.form).then(function (response) {
        _this.$vToastify.success("Project Task added");
        _this.form.title = "";
        _this.getResults(1);
        _this.addScore(_this.task_score);
      })["catch"](function (error) {
        _this.form.title = "";
        _this.$vToastify.warning(error.response.data.message);
      });
    },
    closeModal: function closeModal() {
      this.setTask([]);
    }
  }),
  created: function created() {
    this.getResults(1);
    this.loadStatuses();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['activities', 'slug', 'name'],
  data: function data() {
    return {
      icon: ''
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
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Status.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Status.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['projectName', 'start', 'stage', 'completed', 'status', 'score'],
  data: function data() {
    return {
      isPop: false,
      loading: false
    };
  },
  watch: {
    isPop: function isPop(_isPop) {
      var _this = this;
      if (_isPop) {
        document.addEventListener('click', function (event) {
          return _this.$options.methods.handleClickOutside.call(_this, event, '.score-dropdown', _this.isPop);
        });
      }
    }
  },
  mounted: function mounted() {
    this.loading = true;
  },
  methods: {
    stagename: function stagename() {
      return this.currentStage(this.stage, this.completed);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Page.vue?vue&type=template&id=e39e4560&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Page.vue?vue&type=template&id=e39e4560& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return this.show ? _c("div", [_c("div", {
    staticClass: "container-fluid"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-8 page pd-r"
  }, [_c("div", {
    staticClass: "page-top"
  }, [_c("div", [_c("span", [_c("span", {
    staticClass: "page-top_heading"
  }, [_vm._v("Projects ")]), _vm._v(" "), _c("span", {
    staticClass: "page-top_arrow"
  }, [_vm._v(" > ")]), _vm._v(" "), _c("span", [_vm._v(" " + _vm._s(_vm.project.name))])]), _vm._v(" "), _c("project-features", {
    attrs: {
      slug: _vm.project.slug,
      members: this.project.members,
      name: this.project.name
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "page-content"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-2"
  }, [_c("Status", {
    attrs: {
      projectName: _vm.project.name,
      start: _vm.project.created_at,
      stage: _vm.project.stage,
      completed: this.project.completed,
      status: this.status,
      score: this.project.score
    }
  })], 1), _vm._v(" "), _c("div", {
    staticClass: "col-md-10"
  }, [_c("div", {
    staticClass: "content"
  }, [_c("p", {
    staticClass: "content-name"
  }, [_vm.nameEdit ? _c("span", [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.projectname,
      expression: "projectname"
    }],
    staticClass: "form-control sm-6",
    attrs: {
      type: "text",
      name: "name"
    },
    domProps: {
      value: _vm.projectname
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.projectname = $event.target.value;
      }
    }
  })]) : _c("span", [_vm._v(_vm._s(_vm.project.name))]), _vm._v(" "), _vm.nameEdit ? _c("span", [_c("button", {
    staticClass: "btn btn-link btn-sm",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.updateName();
      }
    }
  }, [_vm._v("Update")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-link btn-sm",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.cancelUpdate();
      }
    }
  }, [_vm._v("Cancel")])]) : _c("span", [_vm.permission.access ? _c("button", {
    staticClass: "btn btn-link btn-sm",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        _vm.nameEdit = true;
      }
    }
  }, [_vm._v("Edit")]) : _vm._e()])]), _vm._v(" "), _c("p", {
    staticClass: "content-info"
  }, [_vm._v("\n\t\t\t\t\t\t\t\t\tCreated On\n\t\t\t\t\t\t\t\t\t"), _c("span", {
    staticClass: "content-dot"
  }), _vm._v("\n\t\t\t\t\t\t\t\t\t" + _vm._s(_vm.project.created_at) + "\n\t\t\t\t\t\t\t\t")]), _vm._v(" "), _c("p", {
    staticClass: "content-info"
  }, [_vm._v("\n\t\t\t\t\t\t\t\t\tCreated By"), _c("span", {
    staticClass: "content-dot"
  }), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-link",
    attrs: {
      to: "/user/" + _vm.user.id + "/profile"
    }
  }, [_vm._v(_vm._s(_vm.user.name))])], 1)]), _vm._v(" "), this.project.deleted_at ? _c("div", [_c("div", {
    staticClass: "alert alert-danger",
    attrs: {
      role: "alert"
    }
  }, [_vm._v("\n\t\t\t\t\t\t\t\t\tThis project is abandoned to access project features active this project,\n\t\t\t\t\t\t\t\t\tor it will be deleted automatically after " + _vm._s(this.project.days_limit) + " days from the abandoned date.\n\t\t\t\t\t\t\t\t\t"), _c("p", [_vm._v("Abandoned on: "), _c("b", {
    domProps: {
      textContent: _vm._s(this.project.deleted_at)
    }
  })]), _vm._v(" "), _c("a", {
    staticClass: "btn btn-info",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.restore();
      }
    }
  }, [_vm._v("Restore Project")])])]) : _vm._e()])]), _vm._v(" "), _c("hr"), _vm._v(" "), _c("p", {
    staticClass: "pro-info"
  }, [_vm._v("Project Detail")]), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("About")]), _vm._v(":\n\t\t\t\t\t\t\t\t"), _vm.aboutEdit ? _c("span", [_c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.projectabout,
      expression: "projectabout"
    }],
    staticClass: "form-control",
    attrs: {
      name: "name",
      rows: "4",
      cols: "30"
    },
    domProps: {
      value: _vm.projectabout,
      textContent: _vm._s(_vm.project.about)
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.projectabout = $event.target.value;
      }
    }
  })]) : _c("span", [_vm._v(" " + _vm._s(_vm.project.about) + " ")]), _vm._v(" "), _vm.aboutEdit ? _c("span", [_c("button", {
    staticClass: "btn btn-link btn-sm",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.updateAbout();
      }
    }
  }, [_vm._v("Update")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-link btn-sm",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.aboutCancel();
      }
    }
  }, [_vm._v("Cancel")])]) : _c("span", [_vm.permission.access ? _c("button", {
    staticClass: "btn btn-link btn-sm",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.editAbout();
      }
    }
  }, [_vm._v("Edit")]) : _vm._e()])]), _vm._v(" "), !_vm.project.postponed ? _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Postponed reason")]), _vm._v(": "), _c("span", [_vm._v(" The project is currently active.\n\t\t\t\t\t\t\tPlease try to avoid the project being postpone without any reason ")])]) : _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Postponed reason")]), _vm._v(": "), _c("span", [_vm._v(" " + _vm._s(_vm.project.postponed) + "  ")])])]), _vm._v(" "), _vm._m(0)]), _vm._v(" "), _c("br"), _vm._v(" "), _c("Stage", {
    attrs: {
      slug: _vm.project.slug,
      projectstage: _vm.project.stage,
      postponed: _vm.project.postponed,
      completed: _vm.project.completed,
      stage_updated: _vm.project.stage_updated_at,
      get_stage: this.getStage,
      access: _vm.permission.access
    }
  }), _vm._v(" "), _c("br"), _vm._v(" "), _c("hr"), _vm._v(" "), _c("h3", [_vm._v("RECENT ACTIVITIES")]), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("RecentActivities", {
    attrs: {
      activities: _vm.project.activities,
      slug: _vm.project.slug,
      name: _vm.project.name
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "col-md-5"
  }, [_c("div", {
    staticClass: "project-info"
  }, [_c("div", {
    staticClass: "project-info_socre"
  }, [_c("p", {
    staticClass: "project-info_score-heading"
  }, [_vm._v("Status")]), _vm._v(" "), _c("p", {
    staticClass: "project-info_score-point",
    "class": "project-info_score-point_" + this.status
  }, [_vm._v(_vm._s(this.project.score))])]), _vm._v(" "), _c("div", {
    staticClass: "project-info_rec"
  }, [_c("span", [_vm._v("Stage Updated")]), _vm._v(" "), _c("p", {
    domProps: {
      textContent: _vm._s(_vm.project.stage_updated_at)
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "project-info_rec"
  }, [_c("span", [_vm._v("Last modified")]), _vm._v(" "), _c("p", {
    domProps: {
      textContent: _vm._s(_vm.project.updated_at)
    }
  })])])])], 1)], 1)]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4 side_panel"
  }, [_vm._v("\n\t\t\tProject Side Panel\n\t\t\t"), _c("br"), _vm._v(" "), _c("Task", {
    attrs: {
      slug: _vm.project.slug,
      tasks: _vm.tasks,
      access: _vm.permission.access,
      projectMembers: this.project.members
    }
  }), _vm._v(" "), _c("hr"), _vm._v(" "), _c("PanelFeatues", {
    attrs: {
      slug: _vm.project.slug,
      notes: _vm.project.notes,
      members: _vm.project.members,
      owner: _vm.user,
      access: _vm.permission.access,
      ownerLogin: _vm.permission.owner
    }
  }), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", [_vm._m(1), _vm._v(" "), _vm._l(_vm.chatusers, function (user) {
    return _c("p", [_vm._v(_vm._s(user.name) + " "), _c("span", {
      staticClass: "chat-circle"
    })]);
  })], 2), _vm._v(" "), _c("hr"), _vm._v(" "), _c("Chat", {
    attrs: {
      slug: _vm.project.slug,
      conversations: _vm.project.conversations,
      users: _vm.project.members,
      auth: this.auth
    }
  })], 1)])])]) : _vm._e();
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-md-6"
  }, [_c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Tasks")]), _vm._v(": "), _c("span", [_vm._v(" Info ")])]), _vm._v(" "), _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Appointments")]), _vm._v(": "), _c("span", [_vm._v(" Info ")])]), _vm._v(" "), _c("p", {
    staticClass: "crm-info"
  }, [_c("b", [_vm._v("Other")]), _vm._v(": "), _c("span", [_vm._v(" Info ")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", [_c("b", [_vm._v("Online Users For Chat")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251& ***!
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
  return _c("div", {
    staticClass: "task"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "collapse",
    attrs: {
      id: "taskProject"
    }
  }, [_c("div", {
    staticClass: "card card-body"
  }, [!_vm.access ? _c("div", [_vm._v("Only the project owner and members are allowed to access this feature.")]) : _vm._e(), _vm._v(" "), _vm.access ? _c("div", [_c("div", {
    staticClass: "task-add"
  }, [_c("form", {
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.add.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_vm._m(1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.title,
      expression: "form.title"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      name: "title"
    },
    domProps: {
      value: _vm.form.title
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "title", $event.target.value);
      }
    }
  })])])]), _vm._v(" "), _c("p", {
    staticClass: "task-list_heading"
  }, [_vm._v(" " + _vm._s(this.message) + "\n    ")]), _vm.tasks ? _c("div", {
    staticClass: "task-list"
  }, [_c("span", {
    staticClass: "float-right"
  }, [_c("a", {
    staticClass: "panel-list_item",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.archiveTasks.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-tasks"
  })])]), _vm._v(" "), _c("p"), _vm._v(" "), _vm._l(_vm.tasks.data, function (task, index) {
    return _c("div", {
      key: task.id
    }, [_c("div", {
      staticClass: "card task-card_style",
      on: {
        click: function click($event) {
          return _vm.openModal(task);
        }
      }
    }, [task.status ? _c("div", {
      staticClass: "task-card_border",
      style: {
        borderColor: task.status.color
      }
    }) : _vm._e(), _vm._v(" "), _c("div", {
      staticClass: "card-body task-card_body"
    }, [_c("span", [_vm._v(_vm._s(task.title))]), _vm._v(" "), _c("span", {
      staticClass: "float-right mt-4"
    }, [_c("small", [_c("i", {
      staticClass: "far fa-clock"
    }), _vm._v(":" + _vm._s(_vm._f("date")(task.created_at)))])])])])]);
  }), _vm._v(" "), _c("modal", {
    staticClass: "model-desin",
    attrs: {
      name: "task-modal",
      height: "auto",
      scrollable: true,
      width: "65%",
      clickToClose: false
    },
    on: {
      "modal-closed": _vm.closeModal
    }
  }, [_c("TaskModal", {
    attrs: {
      slug: _vm.slug,
      state: _vm.state
    }
  })], 1), _vm._v(" "), _c("pagination", {
    attrs: {
      data: _vm.tasks
    },
    on: {
      "pagination-change-page": _vm.getResults
    }
  })], 2) : _vm._e()]) : _vm._e()])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "task-top"
  }, [_c("span", [_c("i", {
    staticClass: "fas fa-tasks"
  }), _vm._v(" "), _c("b", [_vm._v("Tasks")]), _vm._v(" "), _c("a", {
    attrs: {
      "data-toggle": "collapse",
      href: "#taskProject",
      role: "button",
      "aria-expanded": "false",
      "aria-controls": "taskProject"
    }
  }, [_c("i", {
    staticClass: "fas fa-angle-down float-right"
  })])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("label", {
    attrs: {
      "for": "body"
    }
  }, [_c("i", [_vm._v("Create a New Task")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "col-md-7 mb-5"
  }, [_c("div", {
    staticClass: "activity"
  }, [_c("ul", [_vm._l(this.activities, function (activity, index) {
    return _c("li", {
      key: activity.id
    }, [_c("span", {
      staticClass: "activity-icon",
      "class": _vm.activityColor(activity.description)
    }, [_c("i", {
      "class": _vm.activityIcon(activity.description)
    })]), _vm._v("\n            " + _vm._s(activity.description) + "\n             "), _c("p", {
      staticClass: "activity-info"
    }, [_c("span", {
      domProps: {
        textContent: _vm._s(activity.user.name)
      }
    }), _c("span", {
      staticClass: "activity-info_dot"
    }), _c("span", {
      domProps: {
        textContent: _vm._s(activity.time)
      }
    })])]);
  }), _vm._v(" "), _c("li", [_c("span", {
    staticClass: "activity-more"
  }, [_c("router-link", {
    staticClass: "dashboard-link",
    attrs: {
      to: "/project/" + this.name + "/" + this.slug + "/activities"
    }
  }, [_vm._v("View More")])], 1)])], 2)])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a& ***!
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
    staticClass: "img-avatar"
  }, [_c("div", {
    staticClass: "img-avatar_name"
  }, [_vm._v("\n              " + _vm._s((_vm.projectName || "").substring(0, 1)) + "\n        ")])]), _vm._v(" "), _c("div", [_c("div", {
    staticClass: "score-dropdown",
    on: {
      click: function click($event) {
        _vm.isPop = !_vm.isPop;
      }
    }
  }, [_c("span", {
    staticClass: "score-point",
    "class": "score-point_" + _vm.status,
    attrs: {
      role: "button"
    }
  }, [_vm._v(_vm._s(_vm.score))]), _vm._v(" "), _c("div", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.isPop,
      expression: "isPop"
    }],
    staticClass: "score-dropdown_item"
  }, [_c("div", {
    staticClass: "score"
  }, [_c("div", {
    staticClass: "score-content"
  }, [_c("p", {
    staticClass: "score-content_para"
  }, [_c("i", {
    staticClass: "far fa-clock"
  }), _vm._v("The project started " + _vm._s(_vm.start) + ". Currently in its\n                    "), _c("b", {
    domProps: {
      textContent: _vm._s(_vm.stagename())
    }
  }), _vm._v(" stage\n                    ")]), _vm._v(" "), _c("div", {
    staticClass: "score-content_point"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-3"
  }, [_c("p", {
    staticClass: "score-content_point-cold"
  }, [_c("span", [_c("span", {
    "class": "score-content_point-" + _vm.status + "_point"
  }, [_vm._v(_vm._s(_vm.score))]), _c("br"), _c("span", {
    "class": "score-content_point-" + _vm.status + "_status"
  }, [_vm._v(_vm._s(_vm.status))])])])]), _vm._v(" "), _vm._m(1)])])])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "score-content_point-para"
  }, [_c("b", [_vm._v("Top rating factors")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-md-9"
  }, [_c("div", [_c("div", [_c("p", {
    staticClass: "project-score"
  }, [_c("span", [_c("i", {
    staticClass: "fas fa-arrow-up"
  })]), _vm._v(" Score counts on the new task added.")]), _vm._v(" "), _c("p", {
    staticClass: "project-score"
  }, [_c("span", [_c("i", {
    staticClass: "fas fa-arrow-up"
  })]), _vm._v(" Score counts if project notes are available.\n                ")]), _vm._v(" "), _c("p", {
    staticClass: "project-score"
  }, [_c("span", [_c("i", {
    staticClass: "fas fa-arrow-up"
  })]), _vm._v("Score counts when a new member joins a project.")])])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/auth.js":
/*!******************************!*\
  !*** ./resources/js/auth.js ***!
  \******************************/
/*! exports provided: permission */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "permission", function() { return permission; });
function permission(auth, members, user) {
  var access = false;
  var owner = false;
  var member = members && members.find(function (member) {
    return member.id === auth;
  });
  if (member || user === auth) {
    access = true;
  }
  if (user === auth) {
    owner = true;
  }
  return {
    access: access,
    owner: owner
  };
}

/***/ }),

/***/ "./resources/js/components/Project/Page.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/Project/Page.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Page_vue_vue_type_template_id_e39e4560___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Page.vue?vue&type=template&id=e39e4560& */ "./resources/js/components/Project/Page.vue?vue&type=template&id=e39e4560&");
/* harmony import */ var _Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Page.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Page.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Page_vue_vue_type_template_id_e39e4560___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Page_vue_vue_type_template_id_e39e4560___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Page.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Page.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Project/Page.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Page.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Page.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Page.vue?vue&type=template&id=e39e4560&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Project/Page.vue?vue&type=template&id=e39e4560& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_template_id_e39e4560___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Page.vue?vue&type=template&id=e39e4560& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Page.vue?vue&type=template&id=e39e4560&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_template_id_e39e4560___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_template_id_e39e4560___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Project/Panel/Task.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/Project/Panel/Task.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Task.vue?vue&type=template&id=468be251& */ "./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251&");
/* harmony import */ var _Task_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Task.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Task_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Task.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Task.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Task.vue?vue&type=template&id=468be251& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Task.vue?vue&type=template&id=468be251&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Task_vue_vue_type_template_id_468be251___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Project/RecentActivities.vue":
/*!**************************************************************!*\
  !*** ./resources/js/components/Project/RecentActivities.vue ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _RecentActivities_vue_vue_type_template_id_7cf40d2e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./RecentActivities.vue?vue&type=template&id=7cf40d2e& */ "./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e&");
/* harmony import */ var _RecentActivities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./RecentActivities.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _RecentActivities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _RecentActivities_vue_vue_type_template_id_7cf40d2e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _RecentActivities_vue_vue_type_template_id_7cf40d2e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/RecentActivities.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./RecentActivities.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/RecentActivities.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_template_id_7cf40d2e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./RecentActivities.vue?vue&type=template&id=7cf40d2e& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/RecentActivities.vue?vue&type=template&id=7cf40d2e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_template_id_7cf40d2e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_RecentActivities_vue_vue_type_template_id_7cf40d2e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Project/Status.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/Project/Status.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Status_vue_vue_type_template_id_7318ca1a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Status.vue?vue&type=template&id=7318ca1a& */ "./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a&");
/* harmony import */ var _Status_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Status.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Status.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Status_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Status_vue_vue_type_template_id_7318ca1a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Status_vue_vue_type_template_id_7318ca1a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Status.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Status.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Project/Status.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Status.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Status.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a& ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_template_id_7318ca1a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Status.vue?vue&type=template&id=7318ca1a& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Status.vue?vue&type=template&id=7318ca1a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_template_id_7318ca1a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Status_vue_vue_type_template_id_7318ca1a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);