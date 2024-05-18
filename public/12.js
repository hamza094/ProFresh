(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[12],{

/***/ "./resources/js/store/meeting":
/*!************************************!*\
  !*** ./resources/js/store/meeting ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
const state = {
  previous:'',
  message:'',
  meetings:{
    data: [],
    links: {},
    meta: {}
  },
  previousMeetings:[],
};

const mutations = {
setMeetings(state,meetingsData) {
    state.meetings = meetingsData.meetings;
  },
  setMessage(state,message) {
    state.message = message;
  },
  removeMeetingFromState(state, meetingId){
    const index = state.meetings.data.findIndex(meeting => meeting.id === meetingId);
    if (index !== -1) {
      state.meetings.data.splice(index, 1);
    }
  },

  setPreviousMeetings(state, previousmeetingsData) {
    state.previousMeetings = [...previousmeetingsData];
  },
    setPreviousMessage(state, previous) {
    state.previous = previous;
  },
  pushPreviousMeetings(state, meeting){
        state.previousMeetings.unshift(meeting);
  },
  removePreviousMeeting(state, meetingId){
    const index = state.previousMeetings.findIndex(meeting => meeting.id === meetingId);
    if (index !== -1) {
      state.previousMeetings.splice(index, 1);
    }
  },
};

const actions = {

    fetchMeetings({ commit }, { slug, page }) {
       return axios.get(`/api/v1/projects/${slug}/meetings?page=${page}`)
        .then(response => {
          commit('setMeetings', { page, meetings: response.data.meetingsData});
          commit('setMessage', response.data.message);
        }).catch(error=>{
        commit('setMeetings', { page, meetings: { data: [], links: {}, meta: {} } });
        commit('setMessage', 'Failed to load project meetings');
        });
    },

      loadPreviousMeetings({ commit }, slug) {
      return axios.get(`/api/v1/projects/${slug}/meetings`,{
         params: {
        request: 'previous'
      }
      }).then(response => { 
        commit('setPreviousMeetings', response.data.meetingsData);
        commit('setMessage', response.data.message);
        })
        .catch(error => {
        commit('setPreviousMeetings', []);
        commit('setPreviousMessage', 'Failed to load project meetings');
        })
      },
};

/* harmony default export */ __webpack_exports__["default"] = ({
  namespaced: true,
  state,
  mutations,
  actions,
});


/***/ })

}]);