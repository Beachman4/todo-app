import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'


export default [
    {
        path: '/login',
        component: Login,
        name: 'Login'
    },
    {
        path: '/register',
        component: Register,
        name: 'Register'
    }
]