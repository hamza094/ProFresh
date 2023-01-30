(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/ForgotPassword.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Authentication/ForgotPassword.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      errors: {},
      form: {
        email: ''
      }
    };
  },
  methods: {
    resetLink: function resetLink() {
      var _this = this;
      axios.post('/api/v1/forgot-password', this.form, {}).then(function (response) {
        _this.$vToastify.success("Reset Email sent successfully check your inbox");
      })["catch"](function (error) {
        _this.errors = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/Login.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Authentication/Login.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      user: {
        email: '',
        password: '',
        remember: ''
      }
    };
  },
  computed: {
    errors: {
      get: function get() {
        return this.$store.state.currentUser.errors;
      }
    }
  },
  methods: {
    login: function login() {
      this.$store.dispatch('currentUser/loginUser', this.user);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/Register.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Authentication/Register.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      errors: {},
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  methods: {
    RegisterUser: function RegisterUser() {
      var _this = this;
      axios.post('/api/v1/register', this.form, {}).then(function (response) {
        swal.fire("Account Registered", "Please Verify your account and login", "success");
        _this.$router.push('/login');
      })["catch"](function (error) {
        _this.errors = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/ResetPassword.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Authentication/ResetPassword.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      errors: {},
      form: {
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  methods: {
    resetPassword: function resetPassword() {
      var _this = this;
      axios.post('/api/v1/reset-password', {
        email: this.form.email,
        password: this.form.password,
        password_confirmation: this.form.password_confirmation,
        token: this.$route.params.token
      }).then(function (response) {
        swal.fire("Password Changed", "Please Login to continue", "success");
        _this.$router.push('/login');
      })["catch"](function (error) {
        _this.errors = error.response.data.errors;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProjectChart_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProjectChart.vue */ "./resources/js/components/Dashboard/ProjectChart.vue");

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    ProjectChart: _ProjectChart_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      projects: {},
      projectState: "",
      projectsCount: 0,
      message: ''
    };
  },
  methods: {
    activeProjects: function activeProjects() {
      var _this = this;
      axios.get(this.url()).then(function (_ref) {
        var data = _ref.data;
        return _this.getData(data);
      });
      this.projectState = "Active";
    },
    memberProjects: function memberProjects() {
      var _this2 = this;
      axios.get(this.url() + '?member=true').then(function (_ref2) {
        var data = _ref2.data;
        return _this2.getData(data);
      });
      this.projectState = "Member";
    },
    abandonedProjects: function abandonedProjects() {
      var _this3 = this;
      axios.get(this.url() + '?abandoned=true').then(function (_ref3) {
        var data = _ref3.data;
        return _this3.getData(data);
      });
      this.projectState = "Abandoned";
    },
    url: function url() {
      return '/api/v1/user/projects';
    },
    getData: function getData(data) {
      this.projects = data.projects, this.projectsCount = data.projectsCount, this.message = data.message;
    },
    stage: function stage(project) {
      return this.currentStage(project.stage, project.completed);
    }
  },
  mounted: function mounted() {
    this.activeProjects();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/ProjectChart.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Dashboard/ProjectChart.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_chartjs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-chartjs */ "./node_modules/vue-chartjs/es/index.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  "extends": vue_chartjs__WEBPACK_IMPORTED_MODULE_0__["Bar"],
  data: function data() {
    return {
      chartdata: {
        labels: ['Active', 'Invited', 'Trash'],
        datasets: [{
          label: 'Project created by month',
          backgroundColor: '#12344D',
          data: [4, 3, 2]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    };
  },
  mounted: function mounted() {
    this.renderChart(this.chartdata, this.options);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Error.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Error.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {};
  },
  methods: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Home.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Home.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  computed: {
    user: {
      get: function get() {
        return this.$store.state.currentUser.user;
      }
    }
  },
  methods: {
    resendMail: function resendMail() {
      var _this = this;
      axios.post('/api/v1/email/resend/' + this.user.id, {}).then(function (response) {
        _this.$vToastify.success("Verification link sent successfully");
      })["catch"](function (error) {
        _this.$vToastify.warning("Error! Please try again");
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {


/*  import EditProfile from './EditProfile'
  import ProfileAvatar from './ProfileAvatar'
  import ProjectInvitation from './ProjectInvitation.vue'

export default{
	props:['user','members'],
	components: {EditProfile,ProfileAvatar,ProjectInvitation},
	data(){
		return{
            avatar_path:this.user.avatar_path,
            profilePop:false,
		};
	},

	watch:{
        userPop(profilePop){
            if(profilePop){
                document.addEventListener('click',this.closeIfClickedOutside);
            }
        }
    },

	methods:{

        closeIfClickedOutside(event){
            if(!event.target.closest('.feature-dropdown')){
                this.profilePop=false;
                document.removeEventListener('click',this.closeIfClickedOutside);
            }
        },

      deleteAvatar(){
      var self = this;
      this.sweetAlert('Yes, delete it!').then((result) => {
      if (result.value) {
      axios.patch('/api/user/'+this.user.id+'/avatar-delete').then(function(){
       self.redirectSuccess('Project avatar has been deleted',
        '/api/profile/user/'+this.user.id);
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },

    deleteProfile(){
      var self = this;
      this.sweetAlert('Yes, delete it!').then((result) => {
      if (result.value) {
      axios.delete('/api/profile/user'+this.user.id).then(function(){
      self.redirectSuccess('Profile deleted successfully','/');
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },

    }
}	*/

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Activities.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      activities: {},
      status: 'all',
      auth: '3ade7132-9cc4-4e03-972b-6e4170ec3663',
      //this.$store.state.currentUser.user.id,
      current: ''
    };
  },
  methods: {
    getActivities: function getActivities() {
      var _this = this;
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities').then(function (response) {
        _this.activities = response.data;
      })["catch"](function (error) {
        console.log(error.response.data.errors);
      });
      this.current = 'All Project Activities';
    },
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
    },
    getResults: function getResults() {
      var _this2 = this;
      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?page=' + page).then(function (response) {
        _this2.activities = response.data;
      });
    },
    allActivities: function allActivities() {
      this.status = "all";
      this.getActivities();
    },
    myActivities: function myActivities() {
      var _this3 = this;
      this.status = "my";
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?mine=' + this.auth).then(function (response) {
        _this3.activities = response.data;
        _this3.current = 'My Project Activities';
      });
    },
    projectActivities: function projectActivities() {
      var _this4 = this;
      this.status = "project";
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?specifics=1').then(function (response) {
        _this4.activities = response.data;
        _this4.current = 'Project Specified Activities';
      });
    },
    taskActivities: function taskActivities() {
      var _this5 = this;
      this.status = "task";
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?tasks=1').then(function (response) {
        _this5.activities = response.data;
        _this5.current = 'Project Tasks Activities';
      });
    },
    memberActivities: function memberActivities() {
      var _this6 = this;
      this.status = "member";
      axios.get('/api/v1/projects/' + this.$route.params.slug + '/activities?members=1').then(function (response) {
        _this6.activities = response.data;
        _this6.current = 'Project Members Activities';
      });
    }
  },
  created: function created() {
    this.getActivities();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Projects.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Projects.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {};
  },
  methods: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/ForgotPassword.vue?vue&type=template&id=94c20acc&":
/*!**************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Authentication/ForgotPassword.vue?vue&type=template&id=94c20acc& ***!
  \**************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "container"
  }, [_c("div", {
    staticClass: "row justify-content-center"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("div", {
    staticClass: "form"
  }, [_c("div", {
    staticClass: "form-header"
  }, [_vm._v("Forgot Password")]), _vm._v(" "), _c("h5", [_vm._v("Enter Email address to get password reset link")]), _vm._v(" "), _c("div", {
    staticClass: "form-body"
  }, [_c("form", {
    attrs: {
      method: "POST"
    },
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.resetLink.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "email"
    }
  }, [_vm._v("E-Mail Address")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.email,
      expression: "form.email"
    }],
    staticClass: "form-control",
    attrs: {
      id: "email",
      type: "email",
      name: "email",
      required: "",
      autocomplete: "email",
      autofocus: ""
    },
    domProps: {
      value: _vm.form.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "email", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.email ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.email[0])
    }
  }) : _vm._e()])]), _vm._v(" "), _vm._m(0)])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("button", {
    staticClass: "form-btn mb-3",
    attrs: {
      type: "submit"
    }
  }, [_vm._v("\r\n                                    Send Reset Link\r\n                                ")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/Login.vue?vue&type=template&id=edf0d646&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Authentication/Login.vue?vue&type=template&id=edf0d646& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "container"
  }, [_c("div", {
    staticClass: "row justify-content-center"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("div", {
    staticClass: "form"
  }, [_c("div", {
    staticClass: "form-header"
  }, [_vm._v("Sign In")]), _vm._v(" "), _c("div", {
    staticClass: "form-body"
  }, [_c("form", {
    attrs: {
      method: "POST"
    },
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.login();
      }
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "email"
    }
  }, [_vm._v("E-Mail Address")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.user.email,
      expression: "user.email"
    }],
    staticClass: "form-control",
    attrs: {
      id: "email",
      type: "email",
      name: "email",
      required: "",
      autocomplete: "email",
      autofocus: ""
    },
    domProps: {
      value: _vm.user.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.user, "email", $event.target.value);
      }
    }
  }), _vm._v(" "), this.errors.email ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(this.errors.email[0])
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "password"
    }
  }, [_vm._v("Password")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.user.password,
      expression: "user.password"
    }],
    staticClass: "form-control",
    attrs: {
      id: "password",
      type: "password",
      name: "password",
      required: "",
      autocomplete: "current-password"
    },
    domProps: {
      value: _vm.user.password
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.user, "password", $event.target.value);
      }
    }
  }), _vm._v(" "), this.errors.password ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(this.errors.password[0])
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("div", {}, [_c("div", {
    staticClass: "form-check"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.user.remember,
      expression: "user.remember"
    }],
    staticClass: "form-check-input",
    attrs: {
      type: "checkbox",
      name: "remember",
      id: "remember"
    },
    domProps: {
      checked: Array.isArray(_vm.user.remember) ? _vm._i(_vm.user.remember, null) > -1 : _vm.user.remember
    },
    on: {
      change: function change($event) {
        var $$a = _vm.user.remember,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.user, "remember", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.user, "remember", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.user, "remember", $$c);
        }
      }
    }
  }), _vm._v(" "), _c("label", {
    staticClass: "form-check-label form-label",
    attrs: {
      "for": "remember"
    }
  }, [_vm._v("\r\n                                        Remember Me\r\n                                    ")])])])]), _vm._v(" "), _c("router-link", {
    attrs: {
      to: "/forgot-password"
    }
  }, [_c("span", [_vm._v("Forget Password?")])]), _vm._v(" "), _vm._m(0)], 1)])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("button", {
    staticClass: "form-btn mb-3",
    attrs: {
      type: "submit"
    }
  }, [_vm._v("\r\n                                    Sign In\r\n                                ")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/Register.vue?vue&type=template&id=07957adf&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Authentication/Register.vue?vue&type=template&id=07957adf& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "container"
  }, [_c("div", {
    staticClass: "row justify-content-center"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("div", {
    staticClass: "form"
  }, [_c("div", {
    staticClass: "form-header"
  }, [_vm._v("Sign Up")]), _vm._v(" "), _c("div", {
    staticClass: "form-body"
  }, [_c("form", {
    attrs: {
      method: "POST"
    },
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.RegisterUser.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Name")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.name,
      expression: "form.name"
    }],
    staticClass: "form-control",
    attrs: {
      id: "name",
      type: "text",
      name: "name",
      required: "",
      autocomplete: "name",
      autofocus: ""
    },
    domProps: {
      value: _vm.form.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.name ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.name[0])
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "email"
    }
  }, [_vm._v("E-Mail Address")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.email,
      expression: "form.email"
    }],
    staticClass: "form-control",
    attrs: {
      id: "email",
      type: "email",
      name: "email",
      value: "",
      required: "",
      autocomplete: "email"
    },
    domProps: {
      value: _vm.form.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "email", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.email ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.email[0])
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "password"
    }
  }, [_vm._v("Password")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.password,
      expression: "form.password"
    }],
    staticClass: "form-control",
    attrs: {
      id: "password",
      type: "password",
      name: "password",
      required: "",
      autocomplete: "new-password"
    },
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
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "password-confirm"
    }
  }, [_vm._v("Confirm Password")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.password_confirmation,
      expression: "form.password_confirmation"
    }],
    staticClass: "form-control",
    attrs: {
      id: "password-confirm",
      type: "password",
      name: "password_confirmation",
      required: "",
      autocomplete: "new-password"
    },
    domProps: {
      value: _vm.form.password_confirmation
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "password_confirmation", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.password_confirmation ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.password_confirmation[0])
    }
  }) : _vm._e()])]), _vm._v(" "), _vm._m(0)])])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("button", {
    staticClass: "form-btn",
    attrs: {
      type: "submit"
    }
  }, [_vm._v("\n                                    Sign Up\n                                ")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/ResetPassword.vue?vue&type=template&id=7f144dfe&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Authentication/ResetPassword.vue?vue&type=template&id=7f144dfe& ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "container"
  }, [_c("div", {
    staticClass: "row justify-content-center"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("div", {
    staticClass: "form"
  }, [_c("div", {
    staticClass: "form-header"
  }, [_vm._v("Reset Password")]), _vm._v(" "), _c("h5", [_vm._v("Enter your new password")]), _vm._v(" "), _c("div", {
    staticClass: "form-body"
  }, [_c("form", {
    attrs: {
      method: "POST"
    },
    on: {
      submit: function submit($event) {
        $event.preventDefault();
        return _vm.resetPassword.apply(null, arguments);
      }
    }
  }, [_c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "email"
    }
  }, [_vm._v("E-Mail Address")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.email,
      expression: "form.email"
    }],
    staticClass: "form-control",
    attrs: {
      id: "email",
      type: "email",
      name: "email",
      value: "",
      required: "",
      autocomplete: "email"
    },
    domProps: {
      value: _vm.form.email
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "email", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.email ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.email[0])
    }
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "password"
    }
  }, [_vm._v("Password")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.password,
      expression: "form.password"
    }],
    staticClass: "form-control",
    attrs: {
      id: "password",
      type: "password",
      name: "password",
      required: "",
      autocomplete: "new-password"
    },
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
  }) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "form-group"
  }, [_c("label", {
    staticClass: "form-label",
    attrs: {
      "for": "password-confirm"
    }
  }, [_vm._v("Confirm Password")]), _vm._v(" "), _c("div", {
    staticClass: "col-md-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.form.password_confirmation,
      expression: "form.password_confirmation"
    }],
    staticClass: "form-control",
    attrs: {
      id: "password-confirm",
      type: "password",
      name: "password_confirmation",
      required: "",
      autocomplete: "new-password"
    },
    domProps: {
      value: _vm.form.password_confirmation
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.form, "password_confirmation", $event.target.value);
      }
    }
  }), _vm._v(" "), _vm.errors.password_confirmation ? _c("span", {
    staticClass: "text-danger font-italic",
    domProps: {
      textContent: _vm._s(_vm.errors.password_confirmation[0])
    }
  }) : _vm._e()])]), _vm._v(" "), _vm._m(0)])])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("button", {
    staticClass: "form-btn",
    attrs: {
      type: "submit"
    }
  }, [_vm._v("\n                                    Reset Password\n                                ")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4& ***!
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
  return _c("div", [_c("div", {
    staticClass: "page-top"
  }, [_vm._v("Welcome To Your Dashboard")]), _vm._v(" "), _c("div", {
    staticClass: "dashboard-project m-4"
  }, [_c("p", {
    staticClass: "dashboard-heading float-left"
  }, [_c("b", [_vm._v("Total\n                "), _c("span", [_vm._v(_vm._s(_vm.projectState) + " Projects:")]), _vm._v("\n\t\t\t\t\t\t\t\t" + _vm._s(_vm.projectsCount) + "\n            ")])]), _vm._v(" "), _c("span", {
    staticClass: "float-right"
  }, [_c("button", {
    staticClass: "btn btn-sm btn-primary",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.activeProjects.apply(null, arguments);
      }
    }
  }, [_vm._v("Active Projects")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-sm btn-success",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.memberProjects.apply(null, arguments);
      }
    }
  }, [_vm._v("Projects Member")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-sm btn-danger",
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.abandonedProjects.apply(null, arguments);
      }
    }
  }, [_vm._v("Abandoned Projects")])])]), _vm._v(" "), _c("br"), _c("br"), _vm._v(" "), _c("div", {
    staticClass: "dashboard"
  }, [_c("div", {
    staticClass: "row"
  }, [_vm.message ? _c("div", {
    staticClass: "m-3"
  }, [_c("h5", [_c("b", [_vm._v(_vm._s(_vm.message) + " in " + _vm._s(_vm.projectState) + " Projects")])])]) : _vm._e(), _vm._v(" "), _vm._l(_vm.projects, function (project) {
    return _c("div", {
      staticClass: "col-md-4"
    }, [_c("router-link", {
      staticClass: "dashboard-link",
      attrs: {
        to: "/projects/" + project.slug
      }
    }, [_c("div", {
      staticClass: "dashboard-projects mt-5"
    }, [_c("span", {
      staticClass: "float-right"
    }, [_c("b", [_vm._v(_vm._s(_vm.projectState))])]), _vm._v(" "), _c("p", {
      staticClass: "mt-3"
    }, [_vm._v(_vm._s(project.name))]), _vm._v(" "), _c("p", [_vm._v("Project Stage: "), _c("span", {
      domProps: {
        textContent: _vm._s(_vm.stage(project))
      }
    })]), _vm._v(" "), _c("p", [_vm._v("Project Status:\n\t\t\t\t    "), _c("span", [_vm._v(" " + _vm._s(project.status))])]), _vm._v(" "), _c("p", [_vm._v("Created At: " + _vm._s(project.created_at))])])])], 1);
  })], 2)]), _vm._v(" "), _c("div", {
    staticClass: "dashboard-project_info m-4"
  }, [_vm._m(0), _vm._v(" "), _c("br"), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6"
  }, [_c("ProjectChart")], 1), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  })])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "float-left"
  }, [_c("b", [_vm._v("Your Projects Info")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Error.vue?vue&type=template&id=3409f2a6&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Error.vue?vue&type=template&id=3409f2a6& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "error-img"
  }, [_c("img", {
    attrs: {
      src: "img/404.png"
    }
  })]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Home.vue?vue&type=template&id=f2b6376c&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Home.vue?vue&type=template&id=f2b6376c& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "container"
  }, [_c("div", {
    staticClass: "row justify-content-center"
  }, [_c("div", {
    staticClass: "col-md-8"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-header"
  }, [_vm._v("Profresh Managment Area")]), _vm._v(" "), this.user.email_verified_at == null ? _c("div", {
    staticClass: "alert alert-success",
    attrs: {
      role: "alert"
    }
  }, [_vm._v("\n              To access all features, please verify your account.\n              "), _c("span", {
    staticClass: "btn btn-sm btn-primary",
    on: {
      click: function click($event) {
        return _vm.resendMail();
      }
    }
  }, [_vm._v("Resend verification mail")])]) : _vm._e(), _vm._v(" "), _vm._m(0)]), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  })])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("p", {
    staticClass: "mt-3"
  }, [_c("b", [_vm._v("Welcome To ProFresh Project Managment App")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c,
    _setup = _vm._self._setupProxy;
  return _vm._m(0);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c,
    _setup = _vm._self._setupProxy;
  return _c("div", [_c("p", [_vm._v("hy this is user profile Page")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee& ***!
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
  }, [_vm._v(" > ")]), _vm._v(" "), _c("span", [_c("router-link", {
    staticClass: "dashboard-link",
    attrs: {
      to: "/project/" + this.$route.params.slug
    }
  }, [_vm._v(_vm._s(this.$route.params.name))])], 1), _vm._v(" "), _c("span", {
    staticClass: "page-top_arrow"
  }, [_vm._v(" > ")]), _vm._v(" "), _c("span", [_vm._v("\n   Activities >\n   "), _c("span", {
    staticClass: "ml-2"
  }, [_vm._v(_vm._s(this.current))])])])])]), _vm._v(" "), _c("div", {
    staticClass: "container mt-3"
  }, [_c("div", {
    staticClass: "activity mb-5"
  }, [this.activities.data == null ? _c("div", {
    staticClass: "mt-3"
  }, [_c("h3", {
    staticClass: "text-center"
  }, [_vm._v("No related activities found")])]) : _vm._e(), _vm._v(" "), _c("ul", _vm._l(this.activities.data, function (activity, index) {
    return _c("li", {
      key: activity.id
    }, [_c("span", {
      staticClass: "activity-icon",
      "class": _vm.activityColor(activity.description)
    }, [_c("i", {
      "class": _vm.activityIcon(activity.description)
    })]), _vm._v("\n             " + _vm._s(activity.description) + "\n              "), _c("p", {
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
  }), 0)])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-4"
  }, [_c("div", {
    staticClass: "card"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "card-body activity-search"
  }, [_c("ul", [_c("li", [_c("a", {
    staticClass: "activity-icon_secondary",
    "class": {
      Activityfont: _vm.status == "all"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.allActivities.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-layer-group activity-icon_secondary mr-3"
  }), _vm._v("All Activities")])]), _vm._v(" "), _c("li", [_c("a", {
    staticClass: "'activity-icon_purple",
    "class": {
      Activityfont: _vm.status == "my"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.myActivities.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-user activity-icon_purple mr-3"
  }), _vm._v(" My Activities")])]), _vm._v(" "), _c("li", [_c("a", {
    staticClass: "activity-icon_green",
    "class": {
      Activityfont: _vm.status == "project"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.projectActivities.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "far fa-star activity-icon_green mr-3"
  }), _vm._v(" Project Activities")])]), _vm._v(" "), _c("li", [_c("a", {
    staticClass: "activity-icon_primary",
    "class": {
      Activityfont: _vm.status == "task"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.taskActivities();
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-tasks activity-icon_primary mr-3"
  }), _vm._v(" Task Activities")])]), _vm._v(" "), _c("li", [_c("a", {
    staticClass: "activity-icon_danger",
    "class": {
      Activityfont: _vm.status == "member"
    },
    attrs: {
      href: ""
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.memberActivities();
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-tasks activity-icon_danger mr-3"
  }), _vm._v(" Member Activities")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "mt-4"
  }, [_c("pagination", {
    attrs: {
      data: _vm.activities
    },
    on: {
      "pagination-change-page": _vm.getResults
    }
  })], 1)])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header"
  }, [_c("p", [_vm._v("Search Related Activities:")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Projects.vue?vue&type=template&id=533b60e5&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Projects.vue?vue&type=template&id=533b60e5& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "page-top"
  }, [_vm._v("Projects")]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/Authentication/ForgotPassword.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/Authentication/ForgotPassword.vue ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ForgotPassword_vue_vue_type_template_id_94c20acc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ForgotPassword.vue?vue&type=template&id=94c20acc& */ "./resources/js/components/Authentication/ForgotPassword.vue?vue&type=template&id=94c20acc&");
/* harmony import */ var _ForgotPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ForgotPassword.vue?vue&type=script&lang=js& */ "./resources/js/components/Authentication/ForgotPassword.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ForgotPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ForgotPassword_vue_vue_type_template_id_94c20acc___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ForgotPassword_vue_vue_type_template_id_94c20acc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Authentication/ForgotPassword.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Authentication/ForgotPassword.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/Authentication/ForgotPassword.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ForgotPassword.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/ForgotPassword.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Authentication/ForgotPassword.vue?vue&type=template&id=94c20acc&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/Authentication/ForgotPassword.vue?vue&type=template&id=94c20acc& ***!
  \**************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_template_id_94c20acc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./ForgotPassword.vue?vue&type=template&id=94c20acc& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/ForgotPassword.vue?vue&type=template&id=94c20acc&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_template_id_94c20acc___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ForgotPassword_vue_vue_type_template_id_94c20acc___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Authentication/Login.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/Authentication/Login.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Login_vue_vue_type_template_id_edf0d646___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Login.vue?vue&type=template&id=edf0d646& */ "./resources/js/components/Authentication/Login.vue?vue&type=template&id=edf0d646&");
/* harmony import */ var _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Login.vue?vue&type=script&lang=js& */ "./resources/js/components/Authentication/Login.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Login_vue_vue_type_template_id_edf0d646___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Login_vue_vue_type_template_id_edf0d646___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Authentication/Login.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Authentication/Login.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/Authentication/Login.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/Login.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Authentication/Login.vue?vue&type=template&id=edf0d646&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/Authentication/Login.vue?vue&type=template&id=edf0d646& ***!
  \*****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_edf0d646___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=template&id=edf0d646& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/Login.vue?vue&type=template&id=edf0d646&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_edf0d646___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_edf0d646___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Authentication/Register.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/Authentication/Register.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Register_vue_vue_type_template_id_07957adf___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Register.vue?vue&type=template&id=07957adf& */ "./resources/js/components/Authentication/Register.vue?vue&type=template&id=07957adf&");
/* harmony import */ var _Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Register.vue?vue&type=script&lang=js& */ "./resources/js/components/Authentication/Register.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Register_vue_vue_type_template_id_07957adf___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Register_vue_vue_type_template_id_07957adf___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Authentication/Register.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Authentication/Register.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/Authentication/Register.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Register.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/Register.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Authentication/Register.vue?vue&type=template&id=07957adf&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/Authentication/Register.vue?vue&type=template&id=07957adf& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_07957adf___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Register.vue?vue&type=template&id=07957adf& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/Register.vue?vue&type=template&id=07957adf&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_07957adf___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_07957adf___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Authentication/ResetPassword.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/Authentication/ResetPassword.vue ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ResetPassword_vue_vue_type_template_id_7f144dfe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ResetPassword.vue?vue&type=template&id=7f144dfe& */ "./resources/js/components/Authentication/ResetPassword.vue?vue&type=template&id=7f144dfe&");
/* harmony import */ var _ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ResetPassword.vue?vue&type=script&lang=js& */ "./resources/js/components/Authentication/ResetPassword.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ResetPassword_vue_vue_type_template_id_7f144dfe___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ResetPassword_vue_vue_type_template_id_7f144dfe___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Authentication/ResetPassword.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Authentication/ResetPassword.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/Authentication/ResetPassword.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ResetPassword.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/ResetPassword.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Authentication/ResetPassword.vue?vue&type=template&id=7f144dfe&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/Authentication/ResetPassword.vue?vue&type=template&id=7f144dfe& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_template_id_7f144dfe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./ResetPassword.vue?vue&type=template&id=7f144dfe& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Authentication/ResetPassword.vue?vue&type=template&id=7f144dfe&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_template_id_7f144dfe___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_template_id_7f144dfe___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Dashboard/Dashboard.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/Dashboard/Dashboard.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=template&id=c3d42bc4& */ "./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4&");
/* harmony import */ var _Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=script&lang=js& */ "./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Dashboard/Dashboard.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Dashboard.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/Dashboard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Dashboard.vue?vue&type=template&id=c3d42bc4& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/Dashboard.vue?vue&type=template&id=c3d42bc4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_c3d42bc4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Dashboard/ProjectChart.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/Dashboard/ProjectChart.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProjectChart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProjectChart.vue?vue&type=script&lang=js& */ "./resources/js/components/Dashboard/ProjectChart.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns




/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _ProjectChart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"],
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Dashboard/ProjectChart.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Dashboard/ProjectChart.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/Dashboard/ProjectChart.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectChart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProjectChart.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Dashboard/ProjectChart.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectChart_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Error.vue":
/*!*******************************************!*\
  !*** ./resources/js/components/Error.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Error_vue_vue_type_template_id_3409f2a6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Error.vue?vue&type=template&id=3409f2a6& */ "./resources/js/components/Error.vue?vue&type=template&id=3409f2a6&");
/* harmony import */ var _Error_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Error.vue?vue&type=script&lang=js& */ "./resources/js/components/Error.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Error_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Error_vue_vue_type_template_id_3409f2a6___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Error_vue_vue_type_template_id_3409f2a6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Error.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Error.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/components/Error.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Error_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Error.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Error.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Error_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Error.vue?vue&type=template&id=3409f2a6&":
/*!**************************************************************************!*\
  !*** ./resources/js/components/Error.vue?vue&type=template&id=3409f2a6& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Error_vue_vue_type_template_id_3409f2a6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./Error.vue?vue&type=template&id=3409f2a6& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Error.vue?vue&type=template&id=3409f2a6&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Error_vue_vue_type_template_id_3409f2a6___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Error_vue_vue_type_template_id_3409f2a6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Home.vue":
/*!******************************************!*\
  !*** ./resources/js/components/Home.vue ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Home_vue_vue_type_template_id_f2b6376c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Home.vue?vue&type=template&id=f2b6376c& */ "./resources/js/components/Home.vue?vue&type=template&id=f2b6376c&");
/* harmony import */ var _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Home.vue?vue&type=script&lang=js& */ "./resources/js/components/Home.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Home_vue_vue_type_template_id_f2b6376c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Home_vue_vue_type_template_id_f2b6376c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Home.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Home.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/components/Home.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Home.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Home.vue?vue&type=template&id=f2b6376c&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/Home.vue?vue&type=template&id=f2b6376c& ***!
  \*************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_f2b6376c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=template&id=f2b6376c& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Home.vue?vue&type=template&id=f2b6376c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_f2b6376c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_f2b6376c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Profile/ProfilePage.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/Profile/ProfilePage.vue ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProfilePage.vue?vue&type=template&id=150abd92& */ "./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92&");
/* harmony import */ var _ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProfilePage.vue?vue&type=script&lang=js& */ "./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js&");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Profile/ProfilePage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProfilePage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProfilePage.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./ProfilePage.vue?vue&type=template&id=150abd92& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Profile/ProfilePage.vue?vue&type=template&id=150abd92&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_template_id_150abd92___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Project/Activities.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/Project/Activities.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Activities.vue?vue&type=template&id=1793b4ee& */ "./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&");
/* harmony import */ var _Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Activities.vue?vue&type=script&lang=js& */ "./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Project/Activities.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Project/Activities.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Activities.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./Activities.vue?vue&type=template&id=1793b4ee& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Project/Activities.vue?vue&type=template&id=1793b4ee&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Activities_vue_vue_type_template_id_1793b4ee___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/Projects.vue":
/*!**********************************************!*\
  !*** ./resources/js/components/Projects.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Projects_vue_vue_type_template_id_533b60e5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Projects.vue?vue&type=template&id=533b60e5& */ "./resources/js/components/Projects.vue?vue&type=template&id=533b60e5&");
/* harmony import */ var _Projects_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Projects.vue?vue&type=script&lang=js& */ "./resources/js/components/Projects.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Projects_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Projects_vue_vue_type_template_id_533b60e5___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Projects_vue_vue_type_template_id_533b60e5___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Projects.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Projects.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/components/Projects.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Projects_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Projects.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Projects.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Projects_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Projects.vue?vue&type=template&id=533b60e5&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Projects.vue?vue&type=template&id=533b60e5& ***!
  \*****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Projects_vue_vue_type_template_id_533b60e5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./Projects.vue?vue&type=template&id=533b60e5& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Projects.vue?vue&type=template&id=533b60e5&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Projects_vue_vue_type_template_id_533b60e5___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_Projects_vue_vue_type_template_id_533b60e5___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/router.js":
/*!********************************!*\
  !*** ./resources/js/router.js ***!
  \********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.esm.js");
/* harmony import */ var _components_Home__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/Home */ "./resources/js/components/Home.vue");
/* harmony import */ var _components_Authentication_Register__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/Authentication/Register */ "./resources/js/components/Authentication/Register.vue");
/* harmony import */ var _components_Authentication_Login__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/Authentication/Login */ "./resources/js/components/Authentication/Login.vue");
/* harmony import */ var _components_Dashboard_Dashboard__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/Dashboard/Dashboard */ "./resources/js/components/Dashboard/Dashboard.vue");
/* harmony import */ var _components_Authentication_ForgotPassword__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/Authentication/ForgotPassword */ "./resources/js/components/Authentication/ForgotPassword.vue");
/* harmony import */ var _components_Authentication_ResetPassword__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./components/Authentication/ResetPassword */ "./resources/js/components/Authentication/ResetPassword.vue");
/* harmony import */ var _components_Authentication_VerifyPassword__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./components/Authentication/VerifyPassword */ "./resources/js/components/Authentication/VerifyPassword.vue");
/* harmony import */ var _components_Project_Page__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./components/Project/Page */ "./resources/js/components/Project/Page.vue");
/* harmony import */ var _components_Project_Activities__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./components/Project/Activities */ "./resources/js/components/Project/Activities.vue");
/* harmony import */ var _components_Projects__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./components/Projects */ "./resources/js/components/Projects.vue");
/* harmony import */ var _components_Profile_ProfilePage__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./components/Profile/ProfilePage */ "./resources/js/components/Profile/ProfilePage.vue");
/* harmony import */ var _components_Error__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./components/Error */ "./resources/js/components/Error.vue");


vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_router__WEBPACK_IMPORTED_MODULE_1__["default"]);












var guest = function guest(to, from, next) {
  if (!JSON.parse(localStorage.getItem("token"))) {
    return next();
  } else {
    return next('/home');
  }
};
var auth = function auth(to, from, next) {
  // Solve a bug where user isn't yet loaded but the app runs
  if (JSON.parse(localStorage.getItem("token"))) {
    return next();
  } else {
    return next('/login');
  }
};
var router = new vue_router__WEBPACK_IMPORTED_MODULE_1__["default"]({
  mode: 'history',
  linkActiveClass: 'font-semibold',
  routes: [{
    path: '*',
    component: _components_Error__WEBPACK_IMPORTED_MODULE_13__["default"]
  }, {
    path: '/home',
    component: _components_Home__WEBPACK_IMPORTED_MODULE_2__["default"],
    name: "Home",
    beforeEnter: auth
  }, {
    path: '/register',
    component: _components_Authentication_Register__WEBPACK_IMPORTED_MODULE_3__["default"],
    name: 'Register',
    beforeEnter: guest
  }, {
    path: '/login',
    component: _components_Authentication_Login__WEBPACK_IMPORTED_MODULE_4__["default"],
    name: 'Login',
    beforeEnter: guest
  }, {
    path: '/forgot-password',
    component: _components_Authentication_ForgotPassword__WEBPACK_IMPORTED_MODULE_6__["default"],
    name: 'Forgot',
    beforeEnter: guest
  }, {
    path: '/api/v1/password/reset/:token',
    component: _components_Authentication_ResetPassword__WEBPACK_IMPORTED_MODULE_7__["default"],
    name: 'Reset',
    beforeEnter: guest
  }, {
    path: '/api/v1/email/verify/:id',
    component: _components_Authentication_VerifyPassword__WEBPACK_IMPORTED_MODULE_8__["default"],
    name: "verification.verify"
  }, {
    path: "/dashboard",
    component: _components_Dashboard_Dashboard__WEBPACK_IMPORTED_MODULE_5__["default"],
    name: "Dashboard",
    beforeEnter: auth
  }, {
    path: "/projects/:slug",
    component: _components_Project_Page__WEBPACK_IMPORTED_MODULE_9__["default"],
    name: "Project",
    beforeEnter: auth
  }, {
    path: "/project/:name/:slug/activities",
    component: _components_Project_Activities__WEBPACK_IMPORTED_MODULE_10__["default"],
    name: "Activities",
    props: true,
    beforeEnter: auth
  }, {
    path: "/projects",
    component: _components_Projects__WEBPACK_IMPORTED_MODULE_11__["default"],
    name: "Projects",
    beforeEnter: auth
  }, {
    path: "/user/:id/profile",
    component: _components_Profile_ProfilePage__WEBPACK_IMPORTED_MODULE_12__["default"],
    name: "Profile",
    beforeEnter: auth
  }]
});
/* harmony default export */ __webpack_exports__["default"] = (router);

/***/ })

}]);