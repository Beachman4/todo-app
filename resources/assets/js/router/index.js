import Vue from 'vue'
import VueRouter from 'vue-router'
import Auth from './auth'
import Settings from './settings'


Vue.use(VueRouter)

const index = [{path: '/', component: require('../views/Index.vue'), name: 'Index'}];

const routes = [...Auth, ...index, ...Settings]
const Router = new VueRouter({
    mode: 'history',
    routes: routes
})

export default Router