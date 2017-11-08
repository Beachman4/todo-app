import todoApi from '../../api/todo'
import moment from 'moment'

const state = {
    todoItems: [],
    createItem: {},
    titles: {},
    created: false
}

const getters = {
    todoItems: state => {
        return state.todoItems
    },
    titles: state => {
        return state.titles
    }
}

const mutations = {
    updateItems: (state, items) => {
        state.todoItems = items;
    },
    updateCreateItem: (state, data) => {
        state.createItem = data
    },
    updateTitles: (state, data) => {
        state.titles = data
    },
    clearCreateItem: state => {
        state.createItem = {}
    }
}

const actions = {
    getList: ({ commit }) => {
        todoApi.list().then(data => {
            let list = data.items
            Object.keys(list).forEach(item => {
                if (!Array.isArray(list[item])) {
                    let array = list[item]
                    let result = Array.from(Object.keys(array), k => array[k])
                    list[item] = result
                }
            });
            commit('updateItems', list)

            let titles = Object.keys(list).reduce((title, item) => {
                let format = moment(item).format("MMMM DD YYYY")
                let items = list[item]
                let length = Array.isArray(items) ? items.length : 1

                title[item] = `${format}: ${length} Todo Item${length == 1 ? '' : 's'}`

                return title
            }, {})

            commit('updateTitles', titles)
        }).catch(error => {

        })
    },
    create: (store) => {
        todoApi.create(store.state.createItem).then(data => {
            store.state.created = true
            store.dispatch('getList');
        }).catch(error => {

        })
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}