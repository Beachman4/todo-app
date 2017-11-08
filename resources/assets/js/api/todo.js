

export default {
    list: () => {
        return new Promise((resolve, reject) => {
            axios.get('/todo').then(data => resolve(data.data)).catch(error => reject(error))
        })
    },
    create: data => {
        return new Promise((resolve, reject) => {
            axios.post('/todo', data).then(data => resolve(data.data)).catch(error => reject(error))
        })
    },
    update: (id, data) => {
        return new Promise((resolve, reject) => {
            axios.put(`/todo/${id}`, data).then(data => resolve(data.data)).catch(error => reject(error))
        })
    },
    view: id => {

    }
}