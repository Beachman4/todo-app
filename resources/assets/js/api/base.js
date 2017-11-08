import axios from 'axios'
import Cookie from 'cookies-js'
import router from '../router'

const userToken = Cookie.get("todoToken")
let instance = null
let token = document.head.querySelector('meta[name="csrf-token"]');
if (userToken && userToken !== "") {
    instance = axios.create({
        baseURL: '/api',
        headers: {
            Authorization: `Bearer ${userToken}`,
            'X-CSRF-TOKEN': token.content
        }
    })
} else {
    instance = axios.create({
        baseURL: '/api',
        headers: {
            'X-CSRF-TOKEN': token.content
        }
    })
}

instance.interceptors.response.use(function (response) {

    return response;
}, function (error) {
    if (error.response.status === 401) {
        router.push('/login')
    }
    return Promise.reject(error);
});

export default instance