<template>
    <div class="login-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group mb-0">
                    <div class="card p-4">
                        <div class="card-block">
                            <div v-if="registerSent">
                                <loading text="Registering your account..."></loading>
                            </div>
                            <div v-else>
                                <div class="alert alert-danger" v-if="status.error">
                                    {{ status.message }}
                                </div>
                                <h1>Register</h1>
                                <form>
                                    <div class="form-group">
                                        <label for="email" class="form-control-label">Email</label>
                                        <input type="text" class="form-control form-control-danger" id="email" name="email" v-model="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Name</label>
                                        <input type="text" class="form-control form-control-danger" id="name" name="name" v-model="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-control-label">Password</label>
                                        <input type="password" class="form-control form-control-danger" id="password" name="password" v-model="password">
                                    </div>
                                    <button class="btn btn-outline-success btn-block" @click.prevent="register([email, password, name])">Register</button>
                                    <router-link class="btn btn-outline-warning btn-block" :to="{name: 'Login'}">Login</router-link>
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
                name: '',
                password: ''
            }
        },
        computed: {
            ...mapGetters({
                status: 'auth/status',
                registerSent: 'auth/registerSent'
            })
        },
        methods: {
            ...mapActions({
                register: 'auth/register'
            })
        }
    }
</script>