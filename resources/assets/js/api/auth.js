

export default {
    login (email, password) {
        return new Promise((resolve, reject) => {
            axios.post('/auth/login', { email, password }).then(data => {
                resolve(data.data)
            }).catch(data => {
                reject(data)
            })
        })
    },
    register (email, password, name) {
        return new Promise((resolve, reject) => {
            axios.post('/auth/register', { email, password, name }).then(data => {
                resolve(data.data)
            }).catch(data => {
                reject(data)
            })
        })
    },
    authenticate() {
        return new Promise((resolve, reject) => {
            window.axios.get('/auth/authenticate').then(data => {
                resolve(data.data)
            }).catch(data => {
                reject(data)
            })
        })
    },
    logout: () => {
        return new Promise((resolve, reject) => {
            axios.get('/auth/logout')
                .then(data => resolve(data.data))
                .catch(data => reject(data))
        })
    }
}