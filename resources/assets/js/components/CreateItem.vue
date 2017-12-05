<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="createItemModal" tabindex="-1" role="dialog" aria-labelledby="createItemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createItemModalLabel">Create Todo Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="form-control-label">Title</label>
                            <input type="text" name="title" v-model="item.title" class="form-control" id="title" @input="updateData">
                        </div>
                        <div class="form-group">
                            <label for="url" class="form-control-label">Url</label>
                            <input type="text" name="url" v-model="item.url" class="form-control" id="url" @input="updateData">
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Description</label>
                            <input type="text" name="description" v-model="item.description" class="form-control" id="description" @input="updateData">
                        </div>
                        <vue-datepicker-local v-model="item.date" :local="local" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="createItemButton" data-dismiss="modal" @click="createItem">Create Item</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions, mapMutations } from 'vuex';
    import VueDatepickerLocal from 'vue-datepicker-local'

    export default {
        components: {
            VueDatepickerLocal
        },
        mounted() {

        },

        data() {
            return {
                item: {
                    title: '',
                    description: '',
                    date: '',
                    url: ''
                },
                local: {
                    dow: 4, // Sunday is the first day of the week
                    hourTip: 'Select Hour', // tip of select hour
                    minuteTip: 'Select Minute', // tip of select minute
                    secondTip: 'Select Second', // tip of select second
                    yearSuffix: '', // suffix of head
                    monthsHead: 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'), // months of head
                    months: 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'), // months of panel
                    weeks: 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_') // weeks
                }
            };
        },

        methods: {
            updateData() {
                this.$store.commit('todo/updateCreateItem', this.item)
            },
            createItem() {
                this.$store.dispatch('todo/create')
                this.item = {
                    title: '',
                    description: '',
                    date: '',
                    url: ''
                }
            }
        }
    }
</script>