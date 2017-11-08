<template>
    <div class="app-wrapper">
        <user-menu v-if="authenticated"></user-menu>
        <div class="container-fluid">
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import authService from '../services/auth'
    export default {
        mounted() {
            authService.checkAuth()
        },
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated'
            })
        }
    }
</script>