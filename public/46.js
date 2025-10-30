(window['webpackJsonp'] = window['webpackJsonp'] || []).push([
  [46],
  {
    /***/ './resources/js/auth.js':
      /*!******************************!*\
  !*** ./resources/js/auth.js ***!
  \******************************/
      /*! exports provided: permission */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, 'permission', function () {
          return permission;
        });
        function permission(auth, members, user) {
          var access = false;
          var owner = false;
          var member =
            members &&
            members.find(function (member) {
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
            owner: owner,
          };
        }

        /***/
      },
  },
]);
