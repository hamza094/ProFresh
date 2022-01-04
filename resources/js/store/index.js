import Vue from 'vue'
import Vuex from 'vuex'

import createPersistedState from 'vuex-persistedstate'
import currentUser from "./currentUser"

Vue.use(Vuex)


export default new Vuex.Store({
  plugins:[
    createPersistedState()
  ],
  modules:{
     currentUser
  }
})
