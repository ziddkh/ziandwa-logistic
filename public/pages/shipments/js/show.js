import { createTomSelect } from "../../../helpers/create-tom-select.js"
import { clearErrors, displayErrors } from "../../../helpers/handle-errors.js"

const tableBales = $('#table-bales')
const tableVehicles = $('#table-vehicles')
const actionBaleModal = $('#action-bale-modal')
const actionVehicleModal = $('#action-vehicle-modal')
const actionBaleForm = $('#action-bale-form')
const actionVehicleForm = $('#action-vehicle-form')
const btnCreateBale = $('#btn-create-bale')
const btnCreateVehicle = $('#btn-create-vehicle')

tableBales.on('click', '.btn-edit', async function (e) {
    e.preventDefault()
    const parent = $(this).closest('tr')
    const uuid = parent.find('#identifier').val()
    await getTransactionDetail(uuid)
        .then(shipment_item => {
            actionBaleModal.find('#action-bale-modal-label').text('Edit Bal')
            actionBaleModal.find('#departure-date').val(shipment_item.departure_date)
            actionBaleModal.find('#length').val(parseFloat(shipment_item.length))
            actionBaleModal.find('#width').val(parseFloat(shipment_item.width))
            actionBaleModal.find('#height').val(parseFloat(shipment_item.height))
            actionBaleModal.find('#vol-weight').text(parseFloat(shipment_item.vol_weight))
            actionBaleModal.find('#price').text(currencyFormat(shipment_item.price))
            actionBaleForm.attr('action', `${apiUrl}/shipment-items/${shipment_item.uuid}`)
            actionBaleForm.append('<input type="hidden" name="_method" value="PUT">')
        })
        .finally(() => {
            actionBaleModal.modal('show')
        })
})

tableVehicles.on('click', '.btn-edit', async function (e) {
    e.preventDefault()
    const parent = $(this).closest('tr')
    const uuid = parent.find('#identifier').val()
    await getTransactionDetail(uuid)
        .then(shipment_item => {
            actionVehicleModal.find('#action-vehicle-modal-label').text('Edit Kendaraan')
            actionVehicleModal.find('#description').val(shipment_item.description)
            actionVehicleModal.find('#price').val(shipment_item.price)
            actionVehicleForm.attr('action', `${apiUrl}/shipment-items/${shipment_item.uuid}`)
            actionVehicleForm.append('<input type="hidden" name="_method" value="PUT">')
        })
        .finally(() => {
            actionVehicleModal.modal('show')
        })
})

tableBales.on('click', '.btn-delete', function (e) {
    e.preventDefault()
    const parent = $(this).closest('tr')
    const uuid = parent.find('#identifier').val()
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            deletePackage(uuid)
        }
    })
})

tableVehicles.on('click', '.btn-delete', function (e) {
    e.preventDefault()
    const parent = $(this).closest('tr')
    const uuid = parent.find('#identifier').val()
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            deletePackage(uuid)
        }
    })
})

async function deletePackage(uuid) {
    const url = `${apiUrl}/shipment-items/${uuid}`
    const formData = new FormData()
    formData.append('_method', 'DELETE')
    try {
        const { data } = await axios.post(url, formData)
        window.location.reload()
    } catch (error) {
        console.error(error)
    }
}

btnCreateBale.on('click', function (e) {
    e.preventDefault()
    actionBaleModal.find('#action-bale-modal-label').text('Tambah Bal')
    actionBaleForm.attr('action', `${apiUrl}/shipment-items`)
    actionBaleForm.append(`<input type="hidden" name="shipment_header_id" value="${shipment.id}">`)
    actionBaleModal.modal('show')
})

btnCreateVehicle.on('click', function (e) {
    e.preventDefault()
    actionVehicleModal.find('#action-vehicle-modal-label').text('Tambah Kendaraan')
    actionVehicleForm.attr('action', `${apiUrl}/shipment-items`)
    actionVehicleForm.append(`<input type="hidden" name="shipment_header_id" value="${shipment.id}">`)
    actionVehicleModal.modal('show')
})

actionVehicleModal.on('hidden.bs.modal', function (e) {
    clearActionVehicleModal()
})

actionVehicleForm.on('submit', async function (e) {
    e.preventDefault()
    const formData = new FormData(this)
    const url = $(this).attr('action')
    await updatePackage(formData, url, actionVehicleForm).then(( {transaction_detail }) => {
        window.location.reload()
    })
})

actionBaleForm.on('submit', async function (e) {
    e.preventDefault()
    const formData = new FormData(this)
    const url = $(this).attr('action')
    await updatePackage(formData, url, actionBaleForm).then(( {transaction_detail }) => {
        window.location.reload()
    })
})

$('.input-only-number').on('input', function (e) {
    const regex = /[^0-9,]/g
    const value = $(this).val()
    const newValue = value.replace(regex, '')
    $(this).val(newValue)
})

async function updatePackage(formData, url, form) {
    clearErrors()
    try {
        const { data } = await axios.post(url, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
        })
        actionBaleModal.modal('hide')
        const { shipment_item } = await data
        return { shipment_item }
    } catch (error) {
        console.error(error)
        if (error.response.status === 422) {
            const errors = error.response.data.errors
            displayErrors(form, errors)
        }
    }
}

function clearActionVehicleModal() {
    clearErrors()
    actionVehicleForm.attr('action', '')
    actionVehicleModal.find('#transaction-id').val('')
    actionVehicleModal.find('#action-vehicle-modal-label').text('')
    actionVehicleModal.find('#description').val('')
    actionVehicleModal.find('#price').val('')
    if (actionVehicleForm.find('input[name="_method"]').length) {
        actionVehicleForm.find('input[name="_method"]').remove()
    }
    if (actionVehicleForm.find('input[name="shipment_header_id"]').length) {
        actionVehicleForm.find('input[name="shipment_header_id"]').remove()
    }
}

function clearActionBaleModal() {
    clearErrors()
    actionBaleForm.attr('action', '')
    actionBaleModal.find('#transaction-id').val('')
    actionBaleModal.find('#action-bale-modal-label').text('')
    actionBaleModal.find('#length').val('')
    actionBaleModal.find('#width').val('')
    actionBaleModal.find('#height').val('')
    actionBaleModal.find('#vol-weight').text('0.000')
    actionBaleModal.find('#price').text('0')
    if (actionBaleForm.find('input[name="_method"]').length) {
        actionBaleForm.find('input[name="_method"]').remove()
    }
    if (actionBaleForm.find('input[name="shipment_header_id"]').length) {
        actionBaleForm.find('input[name="shipment_header_id"]').remove()
    }
}

actionBaleModal.on('input', '#length, #width, #height', calculateVolumeAndPrice)

function calculateVolumeAndPrice() {
    const length = actionBaleModal.find('#length').val()
    const width = actionBaleModal.find('#width').val()
    const height = actionBaleModal.find('#height').val()
    const lengthDot = length.replace(/,/g, '.')
    const widthDot = width.replace(/,/g, '.')
    const heightDot = height.replace(/,/g, '.')
    const volume = (lengthDot * widthDot * heightDot / 1000000).toFixed(3)
    let price = (volume * COST).toFixed(0)
    price = currencyFormat(price)
    actionBaleModal.find('#vol-weight').text(volume)
    actionBaleModal.find('#price').text(price)
}

function currencyFormat(num) {
    const priceString = num.toString()
    const regex = /(\d)(?=(\d{3})+(?!\d))/g
    const currnecy = priceString.replace(regex, '$1.')
    return currnecy
}

async function getTransactionDetail(uuid) {
    const url = `${apiUrl}/shipment-items/${uuid}`
    try {
        const { data } = await axios.get(url)
        const { shipment_item } = data
        return shipment_item
    } catch (error) {
        console.error(error)
    }
}

actionBaleModal.on('hidden.bs.modal', function (e) {
    clearActionBaleModal()
})

$('.input-only-number').on('input', function (e) {
    const regex = /[^0-9,]/g
    const value = $(this).val()
    const newValue = value.replace(regex, '')
    $(this).val(newValue)
})

const btnEditInformation = $('#btn-edit-information')
const editInformationModal = $('#edit-information-modal')
const editInformationForm = $('#edit-information-form')
const inputDestination = createTomSelect("#destination-id", `${apiUrl}/destinations`, 'Pilih Pengiriman Via')
const destinationType = new TomSelect(`#destination-type`, {
    create: false,
    sortField: {
        field: 'text',
        direction: 'asc'
    }
})

inputDestination.on('change', function (e) {
    destinationType.clear()
    $(`#cost-wrapper`).hide()
    $(inputDestination).attr('type', 'hidden')
    $('#destination-cost').val('')
})

destinationType.on('change', async function (e) {
    const value = this.getValue()
    if (value == 'normal') {
        $(`#cost-wrapper`).hide()
        $('#destination-cost').attr('type', 'hidden')
        const value = inputDestination.getValue()
        await axios.get(`${apiUrl}/destinations/${value}`).then((response) => {
            const destination = response.data.destination
            $('#destination-cost').val(destination.cost)
        })
    } else if (value == 'spesial') {
        $('#destination-cost').val('')
        $('#cost-wrapper').show()
        $('#destination-cost').attr('type', 'text')
    }
})

btnEditInformation.on('click', async function (e) {
    e.preventDefault()
    await getShipmentHeader(shipment.uuid)
        .then((shipment_header) => {
            $('#recipient-name').val(shipment_header.recipient_name)
            $('#recipient-phone').val(shipment_header.recipient_phone)
            $('#recipient-address').val(shipment_header.recipient_address)
            $('#departure-date').val(shipment_header.departure_date)
            $('#harbor-name').val(shipment_header.harbor_name)
            inputDestination.addOption({
                id: shipment_header.destination.id,
                name: shipment_header.destination.name
            })
            inputDestination.setValue(shipment_header.destination_id);
            $('#destination-cost').val(shipment_header.destination_cost)
        })
        .finally(() => {
            editInformationModal.modal('show')
        })
})

editInformationModal.on('hidden.bs.modal', function (e) {
    $('#recipient-name').val('')
    $('#recipient-phone').val('')
    $('#recipient-address').val('')
    $('#departure-date').val('')
    inputDestination.clear()
    destinationType.clear()
    $('#destination-cost').val('')
})

async function getShipmentHeader(uuid) {
    const url = `${apiUrl}/shipment-headers/${uuid}`
    try {
        const { data } = await axios.get(url)
        const { shipment_header } = data
        return shipment_header
    } catch (error) {
        console.error(error)
    }
}

editInformationForm.on('submit', async function (e) {
    e.preventDefault()
    const formData = new FormData(this)
    formData.append('_method', 'PUT')
    const url = `${apiUrl}/shipment-headers/${shipment.uuid}`
    try {
        const { data } = await axios.post(url, formData)
        const { shipment_header } = data
        window.location.reload()
    } catch (error) {
        console.error(error)
        if (error.response.status === 422) {
            const errors = error.response.data.errors
            displayErrors(editInformationForm, errors)
        }
    }
})
