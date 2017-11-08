<template>
    <div class="login-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group mb-0">
                    <div class="card p-4">
                        <div class="card-block">
                            <div v-if="loggingIn">
                                <loading text="Logging In"></loading>
                            </div>
                            <div v-else>
                                <div class="alert alert-danger" v-if="status.error">
                                    {{ status.message }}
                                </div>
                                <h1>Login</h1>
                                <form>
                                    <div class="form-group">
                                        <label for="email" class="form-control-label">Email</label>
                                        <input type="text" class="form-control form-control-danger" id="email" name="email" v-model="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-control-label">Password</label>
                                        <input type="password" class="form-control form-control-danger" id="password" name="password" v-model="password">
                                    </div>
                                    <button class="btn btn-outline-success btn-block" @click.prevent="login([email, password])">Login</button>
                                    <router-link class="btn btn-outline-warning btn-block" :to="{name: 'Register'}">Register</router-link>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    export default {
        data() {
            return {
                email: '',
                password: ''
            }
        },
        computed: {
            ...mapGetters({
                status: 'auth/status',
                loggingIn: 'auth/loggingIn'
            })
        },
        methods: {
            ...mapActions({
                login: 'auth/login'
            })
        }
    }
</script>