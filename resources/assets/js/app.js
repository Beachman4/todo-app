
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import store from './store'
import router from './router'
import { sync } from 'vuex-router-sync'

window.Vue = require('vue');

Vue.component('user-menu', require('./components/Menu.vue'))
Vue.component('loading', require('./components/Loading.vue'))
Vue.component('app-view', require('./views/App.vue'))

window.loading_screen = window.pleaseWait({
    backgroundColor: '#1d64f0',
    loadingHtml: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
});

sync(store, router)

axios.interceptors.response.use(function (response) {

    return response;
}, function (error) {
    if (error.response.status === 401) {
        router.push('/login')
    }
    return Promise.reject(error);
});

const app = new Vue({
    router,
    store
}).$mount('#app-body');