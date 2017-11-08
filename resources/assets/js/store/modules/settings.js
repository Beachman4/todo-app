import Settings from '../../api/settings'

const state = {
    github_username: '',
    options: {},
    error: "",
    alert: "",
    settings: {
        timezone: ""
    }
}

const getters = {
    githubUsername: state => {
        return state.github_username
    },
    options: state => {
        return state.options
    },
    error: state => {
        return state.error
    },
    settings: state => {
        return state.settings
    },
    alert: state => {
        return state.alert
    }
}

const mutations = {
    updateSettings: (state, data) => {
        state.github_username = data.github_username
        state.settings = data.settings
    },
    updateGithubUsername: (state, username) => {
        state.github_username = username
    },
    updateOptions: (state, options) => {
        state.options = options
    },
    updateError: (state, error) => {
        state.error = error
    },
    updateAlert: (state, alert) => {
        state.alert = alert
    },
    updateTimezone: (state, timezone) => {
        state.settings.timezone = timezone
    }
}

const actions = {
    getSettings: ({ commit }) => {
        Settings.getSettings().then(data => {
            commit('updateSettings', data)
        }).catch(data => {
            commit('updateError', data)
        })
    },
    getOptions: ({ commit }) => {
        Settings.getOptions().then(data => {
            commit('updateOptions', data)
        }).catch(data => {
            commit('updateError', data)
        })
    },
    disconnectGithub: ( { commit }) => {
        Settings.disconnectGithub().then(data => {
            commit('updateAlert', 'Github account disconnected')
            commit('updateGithubUsername', '')
        }).catch(data => {

        })
    },
    updateSettings: ( { commit, state }) => {
        Settings.updateSettings(state.settings).then(data => {
            commit('updateAlert', 'Settings Updated')
        }).catch(data => {

        })
    }
}


export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}