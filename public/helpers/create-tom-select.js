export function createTomSelect(selector, url, placeholder) {
    const options = {
        placeholder: placeholder,
        create: false,
        sortField: {
            field: "name",
            direction: "asc",
        },
        persist: false,
        maxItems: 1,
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        load: function (query, callback) {
            axios.get(url, {
                params: {
                    q: query
                }
            }).then(response => {
                callback(response.data.data)
            }).catch(() => {
                callback()
            })
        }
    }
    return new TomSelect(selector, options)
}
