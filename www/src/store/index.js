import Vue from 'vue'
import Vuex from 'vuex'

import userInfo from './modules/userinfo'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        userInfo
    }
})