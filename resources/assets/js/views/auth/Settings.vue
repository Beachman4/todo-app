<template>
    <div class="settings_wrapper">
        <h1>Settings</h1>
        <div class="alert alert-danger" v-if="error != ''" role="error">
            {{ error }}
        </div>
        <div class="alert alert-info" v-if="alert != ''">
            {{ alert }}
        </div>
        <div class="row">
            <div class="col-12">
                <h4>Github</h4>
                <p><small>We use your Github account to check for outstanding PRs and create a todo item each morning for that PR.</small></p>
                <div v-if="githubUsername == ''">
                    <a class="btn btn-secondary" :href="getGithubConnectUrl">Connect your Github Account</a>
                </div>
                <div v-else>
                    <p>Connected: {{ githubUsername }}</p>
                    <a class="btn btn-danger" href="" @click.prevent="disconnectGithub">Disconnect Account</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4>Timezone</h4>
                <p><small>We require the correct timezone so we can send reminders according to your specific timezone</small></p>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <select name="timezone" id="timezone" @input="updateTimezone" class="form-control">
                                <option v-for="item in options.timezones" :value="item" :selected="settings.timezone == item">{{ item }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="" class="btn btn-success" @click.prevent="updateSettings">Update Settings</a>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapMutations, mapActions, mapGetters } from 'vuex';
    export default {
        mounted() {
            this.getSettings()
            this.getOptions()
        },
        computed: {
            ...mapGetters({
                githubUsername: 'settings/githubUsername',
                options: 'settings/options',
                error: 'settings/error',
                settings: 'settings/settings',
                alert: 'settings/alert'
            }),
            getGithubConnectUrl() {
                return 'https://github.com/login/oauth/authorize?client_id=' + this.options.github_client_id + '&state=' + this.options.state + '&scope=repo,read:user'
            }
        },
        methods: {
            ...mapMutations({
                updateGithubUsername: 'settings/updateGithubUsername'
            }),
            ...mapActions({
                getSettings: 'settings/getSettings',
                getOptions: 'settings/getOptions',
                disconnectGithub: 'settings/disconnectGithub',
                updateSettings: 'settings/updateSettings'
            }),
            updateTimezone(event) {
                this.$store.commit('settings/updateTimezone', event.target.value)
            }
        }
    }
</script>