$('#shipments-table').on('click', '.btn-delete', function (e) {
    e.preventDefault()
    const uuid = $(this).data('shipment')
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            deleteTransaction(uuid)
        }
    })
})

async function deleteTransaction(uuid) {
    const url = `${SHIPMENT_DELETE_URL}/${uuid}`
    const formData = new FormData()
    formData.append('_method', 'DELETE')
    try {
        const { data } = await axios.post(url, formData)
        window.location.reload()
    } catch (error) {
        console.error(error)
    }
}
