import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import settings from './modules/settings'
import todo from './modules/todo'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        auth,
        settings,
        todo
    }
})