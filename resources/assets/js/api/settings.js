
export default {
    getOptions: () => {
        return new Promise((resolve, reject) => {
            axios.get('/settings/options')
                .then(data => resolve(data.data))
                .catch(data => reject(data))
        })
    },
    getSettings: () => {
        return new Promise((resolve, reject) => {
            axios.get('/settings')
                .then(data => resolve(data.data))
                .catch(data => reject(data))
        })
    },
    disconnectGithub: () => {
        return new Promise((resolve, reject) => {
            axios.get('/settings/github/disconnect')
                .then(data => resolve(data.data))
                .catch(data => reject(data))
        })
    },
    updateSettings: (settings) => {
        return new Promise((resolve, reject) => {
            axios.post('/settings', settings).then(data => resolve(data.data)).catch(data => reject(data))
        })
    }
}