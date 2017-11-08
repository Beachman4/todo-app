
import auth from '../../api/auth'
import authService from '../../services/auth'
import router from '../../router'
import Cookie from 'cookies-js'
import base from '../../api/base'

const state = {
    loggingIn: false,
    registerSent: false,
    token: '',
    user: {
        name: ""
    },
    authenticated: false,
    login: {
        email: '',
        password: ''
    },
    register: {
        email: '',
        password: '',
        firstName: '',
        lastName: ''
    },
    status: {
        message: '',
        error: false
    }
}

const getters = {

    token (state) {
        return state.token
    },
    user (state) {
        return state.user
    },
    authenticated (state) {
        return state.authenticated
    },
    status (state) {
        return state.status
    },
    loggingIn: state => {
        return state.loggingIn
    },
    registerSent: state => {
        return state.registerSent
    }
}

const mutations = {
    authFailed: state => {
        state.authenticated = false
    },
    authSuccess: state => {
        state.authenticated = true
    },
    loginSent (state) {
        state.loggingIn = true
    },
    loginFailed (state, message) {
        state.loggingIn = false
        state.status.error = true
        state.status.message = message
    },
    loginSuccess (state, data) {
        state.loggingIn = false
        state.status.error = false
        state.token = data.token
        state.user = data.user
        state.authenticated = true
    },
    registerSent (state) {
        state.registerSent = true
    },
    registerFailed (state, message) {
        state.registerSent = false
        state.status.error = true
        state.status.message = message
    },
    registerSuccess (state, data) {
        state.registerSent = false
        state.status.error = false
        state.token = data.token
        state.user = data.user
        state.authenticated = true
    },
    updateUser: (state, data) => {
        state.user = data
    },
    logOut: state => {
        state.token = ""
        state.user = {}
        state.authenticated = false
    }
}

const actions = {
    login ({ commit }, [email, password]) {
        commit('loginSent')
        auth.login(email, password).then(data => {
            if (data.status === 'error') {
                commit('loginFailed', data.message)
            } else {
                commit('loginSuccess', data)
                authService.storeToken(data.token)
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.token;
                router.push('/')
            }
        }).catch(error => {
            const data = error.response.data
            commit('loginFailed', data.message)
        })
    },
    register ({ commit }, [email, password, name]) {
        commit('registerSent')
        auth.register(email, password, name).then(data => {
            if (data.status === 'error') {
                commit('registerFailed', data.message)
            } else {
                commit('registerSuccess', data)
                authService.storeToken(data.token)
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.token;
                router.push('/');
            }
        }).catch(error => {
            const data = error.response.data
            commit('registerFailed', data.message)
        })
    },
    loggedIn: ({ commit }, data) => {
        commit('auth/updateUser', data)
        commit('auth/authSuccess')
    },
    logout: ( { commit }) => {
        auth.logout().then(data => {
            commit('logOut')
            Cookie.expire('todoToken')
            // window.location.href = '/'
            router.push('/login')
        }).catch(data => {

        })
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}