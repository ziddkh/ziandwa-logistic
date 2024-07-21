$('#shippers-table').on('click', '.btn-delete', function (e) {
    e.preventDefault()
    const uuid = $(this).data('shipper')
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            deleteShipper(uuid)
        }
    })
})

async function deleteShipper(uuid) {
    const url = `${DELETE_SHIPPER_URL}/${uuid}`
    const formData = new FormData()
    formData.append('_method', 'DELETE')
    try {
        const { data } = await axios.post(url, formData)
        window.location.reload()
    } catch (error) {
        console.error(error)
    }
}
