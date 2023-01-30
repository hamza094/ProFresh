(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

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
      project: [],
      user: {},
      getStage: 0,
      nameEdit: false,
      projectname: "",
      aboutEdit: false,
      projectabout: "",
      auth: this.$store.state.currentUser.user,
      members: [],
      conversations: [],
      chatusers: [],
      accessAllowed: false,
      ownerLogin: false,
      path: '',
      status: 'cold'
    };
  },
  methods: {
    loadProject: function loadProject() {
      var _this = this;
      axios.get('/api/v1/projects/' + this.$route.params.slug).then(function (response) {
        _this.project = response.data;
        _this.members = _this.project.members;
        _this.user = response.data.user[0];
        _this.checkPermission();
        _this.getStage = _this.project.stage.id;
        _this.projectname = _this.project.name;
        _this.daysLimit = _this.project.days_limit;
        _this.members.unshift(_this.project.user[0]);
        _this.$bus.emit('projectSlug', {
          slug: response.data.slug
        });
      })["catch"](function (error) {
        console.log(error.response.data.errors);
      });
    },
    checkPermission: function checkPermission() {
      var _permission = Object(_auth__WEBPACK_IMPORTED_MODULE_6__["permission"])(this.auth, this.members, this.user),
        accessAllowed = _permission.accessAllowed,
        ownerLogin = _permission.ownerLogin;
      this.accessAllowed = accessAllowed;
      this.ownerLogin = ownerLogin;
    },
    //Update project name methods
    updateName: function updateName() {
      var _this2 = this;
      axios.patch('/api/v1/projects/' + this.project.slug, {
        name: this.projectname
      }).then(function (response) {
        _this2.updateUrl(response.data.slug);
        _this2.updateNameState(response.data.name, response.data.slug, response.data.msg);
      })["catch"](function (error) {
        _this2.nameEdit = false;
        _this2.projectname = _this2.project.name;
        _this2.showError(error);
      });
    },
    updateUrl: function updateUrl(url) {
      var nextURL = 'http://127.0.0.1:8000/project/' + url;
      var nextTitle = 'Project new url';
      var nextState = {
        additionalInformation: 'Updated the URL with Slug'
      };
      window.history.replaceState(nextState, nextTitle, nextURL);
    },
    updateNameState: function updateNameState(name, slug, msg) {
      this.project.name = name;
      this.project.slug = slug;
      this.projectname = name;
      this.nameEdit = false;
      this.$vToastify.success(msg);
    },
    cancelUpdate: function cancelUpdate() {
      this.nameEdit = false;
      this.projectname = this.project.name;
    },
    //update project about methods
    updateAbout: function updateAbout() {
      var _this3 = this;
      axios.patch('/api/v1/projects/' + this.project.slug, {
        about: this.projectabout
      }).then(function (response) {
        _this3.project.about = response.data.about;
        _this3.projectabout = response.data.about;
        _this3.aboutEdit = false;
        _this3.$vToastify.success(response.data.msg);
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
      this.performAction('Yes, Make live again!', axios.get('/api/v1/projects/' + this.project.slug + '/restore'));
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
      Echo["private"]('conversations.' + this.getProjectSlug()).listen('NewMessage', function (e) {
        _this6.project.conversations.push(e);
      });
    },
    listenToDeleteConversation: function listenToDeleteConversation() {
      var _this7 = this;
      Echo["private"]('deleteConversation.' + this.getProjectSlug()).listen('DeleteConversation', function (e) {
        _this7.project.conversations.splice(_this7.project.conversations.indexOf(e), 1);
        _this7.$vToastify.success("conversation deleted");
      });
    },
    updateStage: function updateStage(data) {
      this.project.stage_updated_at = data.stage_updated;
      this.project.stage = data.current_stage;
      this.project.completed = data.completed;
      this.project.postponed = data.postponed;
      this.getStage = data.getStage;
    },
    updateTasks: function updateTasks(data) {
      var _this8 = this;
      axios.get("/api/v1/projects/".concat(this.project.slug, "?page=").concat(data.page)).then(function (response) {
        _this8.project.tasks = response.data.tasks;
        _this8.project.activities = response.data.activities;
      });
    }
  },
  created: function created() {
    var _this9 = this;
    this.loadProject();
    this.$bus.$on('stageListners', this.updateStage);
    this.$bus.$on('taskResults', this.updateTasks);
    this.$bus.$on('Panel', function (data) {
      _this9.project.notes = data.notes;
    });
    this.$bus.$on('removeMember', function (data) {
      _this9.project.members = data.members;
    });
    this.$bus.$on('addScore', function () {
      _this9.project.score += 2;
    });
    this.$bus.$on('reduceScore', function () {
      _this9.project.score -= 2;
    });
    this.$bus.$on('score', function (data) {
      _this9.project.score = data.score;
    });
  },
  mounted: function mounted() {
    var _this10 = this;
    this.listenForNewMessage();
    this.listenToDeleteConversation();
    //this.listenForActivity();

    this.path = this.getProjectSlug();
    Echo.join('chatroom.' + this.getProjectSlug()).here(function (members) {
      _this10.chatusers = members;
    }).joining(function (auth) {
      _this10.chatusers.push(auth);
      _this10.$vToastify.info(auth.name + ' ' + 'joined project conversation');
    }).leaving(function (auth) {
      _this10.chatusers.splice(_this10.chatusers.indexOf(auth), 1);
      _this10.$vToastify.info(auth.name + ' ' + 'leave project conversation');
    });
  },
  beforeDestroy: function beforeDestroy() {
    Echo.leave('chatroom.' + this.path);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['slug', 'notes', 'members', 'owner', 'access', 'ownerLogin'],
  watch: {
    query: function query(after, before) {
      this.searchUsers();
    }
  },
  data: function data() {
    return {
      form: {
        notes: ""
      },
      query: null,
      results: [],
      errors: {}
    };
  },
  methods: {
    ProjectNote: function ProjectNote() {
      var _this = this;
      axios.patch('/api/v1/projects/' + this.slug, {
        notes: this.form.notes
      }).then(function (response) {
        _this.$bus.emit('Panel', {
          notes: response.data.notes
        });
        _this.$vToastify.success("Notes Updated");
        _this.$bus.emit('score', {
          score: response.data.score
        });
        console.log(response.data.score);
      })["catch"](function (error) {
        if (error.response.data.errors && error.response.data.errors.notes[0]) {
          _this.$vToastify.warning(error.response.data.errors.notes[0]);
        }
        if (error.response.data.error) {
          _this.$vToastify.warning(error.response.data.error);
        }
        _this.form.notes = _this.notes;
      });
    },
    searchUsers: function searchUsers() {
      var _this2 = this;
      axios.get('/api/v1/users/search', {
        params: {
          query: this.query
        }
      }).then(function (response) {
        return _this2.results = response.data;
      })["catch"](function (error) {
        _this2.$vToastify.warning(error.response.data.error);
      });
    },
    inviteUser: function inviteUser(user) {
      var _this3 = this;
      axios.post('/api/v1/projects/' + this.slug + '/invitations', {
        email: user
      }).then(function (response) {
        _this3.query = '';
        _this3.results = '';
        _this3.$vToastify.success(response.data.msg);
      })["catch"](function (error) {
        _this3.query = '';
        _this3.results = '';
        _this3.$vToastify.warning(error.response.data.error);
      });
    },
    removeMember: function removeMember(id, member) {
      var _this4 = this;
      var self = this;
      this.sweetAlert('Yes, Remove Member').then(function (result) {
        if (result.value) {
          axios.get('/api/v1/projects/' + _this4.slug + '/remove/' + id).then(function (response) {
            _this4.$bus.emit('removeMember', {
              members: response.data.members
            });
            self.$vToastify.info(response.data.msg);
          })["catch"](function (error) {
            swal.fire("Failed!", "There was  an errors", "warning");
          });
        }
      });
    }
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['slug', 'tasks', 'access'],
  data: function data() {
    return {
      editing: 0,
      form: {
        body: '',
        editbody: '',
        completed: ''
      },
      errors: {}
    };
  },
  methods: {
    getResults: function getResults() {
      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      this.$bus.emit('taskResults', {
        page: page
      });
    },
    add: function add() {
      var _this = this;
      axios.post('/api/v1/projects/' + this.slug + '/task', this.form).then(function (response) {
        _this.$vToastify.success("Project Task added");
        _this.form.body = "";
        _this.getResults();
        _this.$bus.emit('addScore');
      })["catch"](function (error) {
        _this.form.body = "";
        _this.taskErrors(error);
      });
    },
    url: function url($slug, $id) {
      return '/api/v1/projects/' + $slug + '/task/' + $id;
    },
    update: function update(id, task) {
      var _this2 = this;
      axios.put(this.url(this.slug, id), {
        body: this.form.editbody
      }).then(function (response) {
        _this2.$vToastify.success("Task Updated");
        _this2.editing = false;
        task.body = _this2.form.editbody;
      })["catch"](function (error) {
        _this2.taskErrors(error);
      });
    },
    closeEditForm: function closeEditForm(id, task) {
      this.editing = false;
      this.form.editbody = task.body;
    },
    markComplete: function markComplete(id, task) {
      var _this3 = this;
      axios.patch(this.url(this.slug, id) + '/status', {
        completed: true
      }).then(function (response) {
        _this3.$vToastify.success("Task Completed");
        task.completed = true;
      })["catch"](function (error) {
        _this3.$vToastify.warning("Task Status Updated failed");
      });
    },
    markUncomplete: function markUncomplete(id, task) {
      var _this4 = this;
      axios.patch(this.url(this.slug, id) + '/status', {
        completed: false
      }).then(function (response) {
        _this4.$vToastify.info("Task Marked Uncomplete");
        task.completed = false;
      })["catch"](function (error) {
        _this4.$vToastify.warning("Task Status Updated failed");
      });
    },
    remove: function remove(id, index) {
      var _this5 = this;
      axios["delete"](this.url(this.slug, id)).then(function (response) {
        _this5.getResults();
        _this5.$vToastify.info("Project Task deleted");
        _this5.$bus.emit('reduceScore');
      })["catch"](function (error) {
        _this5.$vToastify.warning("Task deletion failed");
      });
    },
    openEditForm: function openEditForm(id, task) {
      this.editing = id;
      this.form.editbody = task.body;
    },
    taskErrors: function taskErrors(error) {
      if (!error.response) {
        this.$vToastify.warning("An error occurred.");
        return;
      }
      var errors = error.response.data.errors;
      if (errors) {
        for (var key in errors) {
          if (errors.hasOwnProperty(key)) {
            this.$vToastify.warning(errors[key][0]);
          }
        }
      } else {
        this.$vToastify.warning("An error occurred.");
      }
    }
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
    activityIcon: function activityIcon(description) {
      if (description.startsWith("Task")) {
        return 'fas fa-tasks';
      }
      if (description.startsWith("Project invitation") || description.startsWith("Project member")) {
        return 'fas fa-user';
      }
      return 'fab fa-pagelines';
    },
    activityColor: function activityColor(description) {
      if (description.startsWith("Task")) {
        return 'activity-icon_primary';
      }
      if (description.startsWith("Project invitation") || description.startsWith("Project member")) {
        return 'activity-icon_green';
      }
      return 'activity-icon_purple';
    }
  },
  mounted: function mounted() {}
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
      if (_isPop) {
        document.addEventListener('click', this.emptyIfClickedOutside);
      }
    }
  },
  mounted: function mounted() {
    this.loading = true;
  },
  methods: {
    emptyIfClickedOutside: function emptyIfClickedOutside(event) {
      if (!event.target.closest('.score-dropdown')) {
        this.isPop = false;
        document.removeEventListener('click', this.emptyIfClickedOutside);
      }
    },
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
  return _c("div", [_c("div", {
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
  }, [_vm._v("Cancel")])]) : _c("span", [_vm.accessAllowed ? _c("button", {
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
  }, [_vm._v("Cancel")])]) : _c("span", [_vm.accessAllowed ? _c("button", {
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
      access: this.accessAllowed
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
      tasks: _vm.project.tasks,
      access: this.accessAllowed
    }
  }), _vm._v(" "), _c("hr"), _vm._v(" "), _c("PanelFeatues", {
    attrs: {
      slug: _vm.project.slug,
      notes: _vm.project.notes,
      members: _vm.project.members,
      owner: _vm.user,
      access: this.accessAllowed,
      ownerLogin: this.ownerLogin
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
  })], 1)])])]);
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09&":
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09& ***!
  \*******************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "project-note"
  }, [_c("div", {
    attrs: {
      id: "wrapper"
    }
  }, [_vm._m(0), _vm._v(" "), _vm.access ? _c("form", {
    attrs: {
      id: "paper",
      method: "post"
    },
    on: {
      keyup: function keyup($event) {
        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) return null;
        $event.preventDefault();
        return _vm.ProjectNote.apply(null, arguments);
      }
    }
  }, [_c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.notes,
      expression: "form.notes"
    }],
    attrs: {
      placeholder: "Write Project Notes",
      id: "text",
      name: "notes",
      rows: "4"
    },
    domProps: {
      value: _vm.form.notes,
      textContent: _vm._s(this.notes)
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "notes", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("br")]) : _vm._e(), _vm._v(" "), !_vm.access ? _c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.notes,
      expression: "form.notes"
    }],
    attrs: {
      placeholder: "Only project members and owners are allowed to write project notes.",
      id: "text",
      rows: "4",
      readonly: ""
    },
    domProps: {
      value: _vm.form.notes,
      textContent: _vm._s(this.notes)
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "notes", $event.target.value);
      }
    }
  }) : _vm._e(), _vm._v(" "), _c("br")])]), _vm._v(" "), _c("hr"), _vm._v(" "), _vm.access ? _c("div", {
    staticClass: "invite"
  }, [_vm._m(1), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.query,
      expression: "query"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      placeholder: "Search user for invitation"
    },
    domProps: {
      value: _vm.query
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.query = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "invite-list"
  }, [_vm.results.length > 0 && _vm.query ? _c("ul", _vm._l(_vm.results.slice(0, 5), function (result) {
    return _c("li", {
      key: result.id
    }, [_c("div", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.inviteUser(result.url);
        }
      }
    }, [_vm._v(_vm._s(result.title) + " (" + _vm._s(result.searchable.email) + ")")])]);
  }), 0) : _vm._e()])]) : _vm._e(), _vm._v(" "), _c("hr"), _vm._v(" "), _c("div", {
    staticClass: "project_members"
  }, [_vm._m(2), _vm._v(" "), _c("div", {
    staticClass: "collapse",
    attrs: {
      id: "memberProject"
    }
  }, [_c("div", {
    staticClass: "row"
  }, _vm._l(_vm.members, function (member) {
    return _c("div", {
      key: member.user_id
    }, [_c("div", {
      staticClass: "project_members-detail"
    }, [_c("router-link", {
      attrs: {
        to: "/user/" + member.username + "/profile"
      }
    }, [_c("img", {
      attrs: {
        src: member.avatar_path,
        alt: ""
      }
    }), _vm._v(" "), _c("p", [member.id == _vm.owner.id ? _c("span", {
      staticClass: "badge badge-success"
    }, [_vm._v("project owner\n                    ")]) : _vm._e(), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", [_vm._v(_vm._s(member.name))]), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", [_vm._v("(" + _vm._s(member.username) + ")")])]), _vm._v(" "), _c("p")]), _vm._v(" "), _vm.ownerLogin && member.id !== _vm.owner.id ? _c("a", {
      attrs: {
        rel: "",
        role: "button"
      },
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.removeMember(member.pivot.user_id, member);
        }
      }
    }, [_vm._v("x")]) : _vm._e()], 1)]);
  }), 0)])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", [_c("b", [_vm._v("Add Project Note:")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", [_c("b", [_vm._v("Project Invitations:")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "task-top"
  }, [_c("p", [_c("b", [_vm._v("Project Members")]), _c("a", {
    attrs: {
      "data-toggle": "collapse",
      href: "#memberProject",
      role: "button",
      "aria-expanded": "false",
      "aria-controls": "memberProject"
    }
  }, [_c("i", {
    staticClass: "fas fa-angle-down float-right"
  })])])]);
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
  }, [_c("div", {
    staticClass: "task-add"
  }, [_vm.access ? _c("form", {
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.add.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    attrs: {
      "for": "body"
    }
  }, [_vm._v("Add New Task")]), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.body,
      expression: "form.body"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      name: "body"
    },
    domProps: {
      value: _vm.form.body
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "body", $event.target.value);
      }
    }
  })])]) : _vm._e()]), _vm._v(" "), _vm.tasks ? _c("div", {
    staticClass: "task-list"
  }, [_c("p", {
    staticClass: "task-list_heading"
  }, [_vm._v("Project Tasks")]), _vm._v(" "), _vm._l(_vm.tasks.data, function (task, index) {
    return _c("div", {
      key: task.id
    }, [_c("p", {
      staticClass: "task-list_text"
    }, [_vm.editing == task.id ? _c("span", [_c("textarea", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: _vm.form.editbody,
        expression: "form.editbody"
      }],
      staticClass: "form-control",
      staticStyle: {
        resize: "none"
      },
      attrs: {
        name: "body",
        rows: "1",
        cols: "34"
      },
      domProps: {
        value: _vm.form.editbody,
        textContent: _vm._s(task.body)
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(_vm.form, "editbody", $event.target.value);
        }
      }
    }), _vm._v(" "), _c("span", {
      staticClass: "btn btn-link btn-sm",
      on: {
        click: function click($event) {
          return _vm.update(task.id, task);
        }
      }
    }, [_vm._v("Update")]), _vm._v(" "), _c("span", {
      staticClass: "btn btn-link btn-sm",
      on: {
        click: function click($event) {
          return _vm.closeEditForm(task.id, task);
        }
      }
    }, [_vm._v("Cancel")])]) : _c("span", {
      "class": {
        "task-list_text-body": task.completed == true
      }
    }, [_vm._v(_vm._s(task.body))]), _vm._v(" "), _vm.access ? _c("span", {
      staticClass: "float-right"
    }, [_c("span", [task.completed ? _c("input", {
      staticClass: "form-check-input",
      attrs: {
        type: "checkbox",
        checked: ""
      },
      on: {
        change: function change($event) {
          return _vm.markUncomplete(task.id, task);
        }
      }
    }) : _c("input", {
      staticClass: "form-check-input",
      attrs: {
        type: "checkbox",
        name: "completed"
      },
      on: {
        change: function change($event) {
          return _vm.markComplete(task.id, task);
        }
      }
    })]), _vm._v(" "), _c("span", {
      on: {
        click: function click($event) {
          return _vm.remove(task.id, index);
        }
      }
    }, [_c("i", {
      staticClass: "far fa-trash-alt",
      staticStyle: {
        color: "#E74C3C"
      }
    })]), _vm._v(" "), _c("span", {
      on: {
        click: function click($event) {
          return _vm.openEditForm(task.id, task);
        }
      }
    }, [_c("i", {
      staticClass: "far fa-edit",
      staticStyle: {
        color: "#2980B9"
      }
    })])]) : _vm._e(), _vm._v(" "), _c("br"), _vm._v(" "), _c("span", {
      staticClass: "task-list_time"
    }, [_c("i", {
      staticClass: "far fa-clock"
    }), _vm._v(" " + _vm._s(task.created_at))])]), _vm._v(" "), _c("hr")]);
  }), _vm._v(" "), _c("pagination", {
    attrs: {
      data: _vm.tasks
    },
    on: {
      "pagination-change-page": _vm.getResults
    }
  })], 2) : _vm._e()])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "task-top"
  }, [_c("span", [_c("b", [_vm._v("Tasks")]), _vm._v(" "), _c("a", {
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
  }), _vm._v("The project started " + _vm._s(_vm.start) + ". Currently in its\n                        "), _c("b", {
    domProps: {
      textContent: _vm._s(_vm.stagename())
    }
  }), _vm._v(" stage\n                      ")]), _vm._v(" "), _c("div", {
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
  })]), _vm._v(" Score counts if project notes are available.\n                                 ")]), _vm._v(" "), _c("p", {
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
  var authId = auth.id;
  var member = members.find(function (member) {
    return member.user_id === authId;
  });
  var accessAllowed = false;
  var ownerLogin = false;
  if (member || user.id === authId) {
    accessAllowed = true;
  }
  if (user.id === authId) {
    ownerLogin = true;
  }
  return {
    accessAllowed: accessAllowed,
    ownerLogin: ownerLogin
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

/***/ "./resources/js/components/Project/Panel/Features.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Features.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Features.vue?vue&type=template&id=50c2fb09& */ "./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09&");
/* harmony import */ var _Features_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Features.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Features_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Panel/Features.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Features.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Features.vue?vue&type=template&id=50c2fb09& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Panel/Features.vue?vue&type=template&id=50c2fb09&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Features_vue_vue_type_template_id_50c2fb09___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



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