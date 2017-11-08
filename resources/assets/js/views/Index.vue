<template>
    <div class="wrapper">
        <div id="accordion" role="tablist">
            <div class="card" v-for="(value, key, index) in todoItems">
                <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" :href="'#collapse' + index" aria-controls="collapseOne">
                            {{ titles[key] }}
                        </a>
                    </h5>
                </div>

                <div :id="'collapse' + index" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div v-for="item in value">
                            <a target="_blank" v-if="item.url != ''" :href="item.url">{{ item.title }}</a>
                            <p v-else>{{ item.title }}</p>
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
        computed: {
            ...mapGetters({
                todoItems: 'todo/todoItems',
                titles: 'todo/titles'
            })
        },
        data() {
            return {

            }
        },
        mounted() {
            this.getList();
        },
        methods: {
            ...mapActions({
                getList: 'todo/getList'
            }),
        }
    }
</script>