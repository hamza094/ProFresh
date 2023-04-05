import Vue from 'vue'
import Vuex from 'vuex'

import createPersistedState from 'vuex-persistedstate'
import currentUser from "./currentUser"
import profile from "./profile"
import project from "./project"

Vue.use(Vuex)

export default new Vuex.Store({
  plugins:[
    createPersistedState()
  ],
  modules:{
     currentUser,
     profile,
     project,
  }
})
