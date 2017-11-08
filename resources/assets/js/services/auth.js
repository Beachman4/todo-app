import Cookie from 'cookies-js'
import authApi from '../api/auth'
import store from '../store'
import auth from '../store/modules/auth'
import router from '../router'

export default {
    storeToken (token) {
        const myDate = new Date()
        const days = 7
        const domain = 'todo.the9grounds.com'
        myDate.setTime(myDate.getTime() + (days * 24 * 60 * 60 * 1000))
        Cookie.set('userToken', token, {
            path: '/',
            domain: domain,
            expires: myDate,
            secure: false
        })
    },
    checkAuth () {
        const userToken = Cookie.get('userToken')
        if (userToken && userToken !== '') {
            authApi.authenticate().then(data => {
                auth.actions.loggedIn(store, data)
            }).catch(data => {
                router.push('/login')
            })
        } else {
            router.push('/login')
        }
        window.loading_screen.finish()
    },
    logout: () => {

    }
}