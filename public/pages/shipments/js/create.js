import { createTomSelect } from "../../../helpers/create-tom-select.js"
import { displayErrors } from "../../../helpers/handle-errors.js"

const form = $("#form")
const submitFormButton = $("#submit-form-button")
const balesWrapper = $("#table-bales")
const buttonAddBale = $("#add-bale-button")
const vehiclesTable = $("#table-vehicles")
const buttonAddVehicle = $("#add-vehicle-button")
let baleIndex = 1
let vehicleIndex = 1

const inputDestination = createTomSelect("#destination-id", GET_DESTINATIONS, 'Pilih Pengiriman Via')

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
    $('#cost').attr('type', 'hidden')
    $('#cost').val('')
})

destinationType.on('change', async function (e) {
    const value = this.getValue()
    if (value == 'normal') {
        $(`#cost-wrapper`).hide()
        $('#cost').attr('type', 'hidden')
        const value = inputDestination.getValue()
        await axios.get(`${GET_DESTINATIONS}/${value}`).then((response) => {
            const destination = response.data.destination
            $('#cost').val(destination.cost)
        })
    } else if (value == 'spesial') {
        $('#cost').val('')
        $('#cost-wrapper').show()
        $('#cost').attr('type', 'text')
        inputOnlyNumber()
        $(`#cost`).on('input', function (e) {
            const value = $(this).val()
            const newValue = value.replace(/,/g, '.')
            $('#cost').val(newValue)
        })
    }
})

function inputOnlyNumber() {
    $('.input-only-number').on('input', function (e) {
        const regex = /[^0-9,]/g
        const value = $(this).val()
        const newValue = value.replace(regex, '')
        $(this).val(newValue)
    })
}

$('.input-only-phone-number').on('input', function (e) {
    const regex = /[^0-9]/g
    const value = $(this).val()
    const newValue = value.replace(regex, '')
    $(this).val(newValue)
})

function formatPrice(price) {
    const priceString = price.toString()
    const regex = /(\d)(?=(\d{3})+(?!\d))/g
    const newPrice = priceString.replace(regex, '$1.')
    return newPrice
}

function calculateBalesVolumeAndPrice(currentIndex) {
    const cost = $('#cost').val()
    const length = $(`#length-${currentIndex}`).val()
    const width = $(`#width-${currentIndex}`).val()
    const height = $(`#height-${currentIndex}`).val()
    const lengthDot = length.replace(/,/g, '.')
    const widthDot = width.replace(/,/g, '.')
    const heightDot = height.replace(/,/g, '.')
    const volume = (lengthDot * widthDot * heightDot / 1000000).toFixed(3)
    let price = (volume * cost).toFixed(0)
    price = formatPrice(price)
    $(`#volume-${currentIndex}`).text(volume)
    $(`#total-${currentIndex}`).text(price)
}

buttonAddBale.on('click', function (e) {
    e.preventDefault()

    const currentIndex = baleIndex

    const baleHTML = `
        <tr>
            <td><p id="bale-iteration-${currentIndex}">${currentIndex}</p></td>
            <td>
                <input type="text" id="length-${currentIndex}" name="items[bales][${currentIndex}][length]" class="form-control form-control-sm input-only-number">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <input type="text" id="width-${currentIndex}" name="items[bales][${currentIndex}][width]" class="form-control form-control-sm input-only-number">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <input type="text" id="height-${currentIndex}" name="items[bales][${currentIndex}][height]" class="form-control form-control-sm input-only-number">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <p id="volume-${currentIndex}"></p>
            </td>
            <td>
                <p id="total-${currentIndex}"></p>
            </td>
            <td>
                <div class="action-btns d-flex justify-content-center">
                    <a href="javascript:void(0);" class="action-btn btn-delete bs-tooltip remove-bale-button" data-toggle="tooltip" data-placement="top" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    </a>
                </div>
            </td>
        </tr>
    `;
    balesWrapper.find('tbody tr:last-child').before(baleHTML)

    $(`#length-${currentIndex}, #width-${currentIndex}, #height-${currentIndex}`).on('input', function() {calculateBalesVolumeAndPrice(currentIndex)})

    inputOnlyNumber()

    baleIndex++
})

function updateIndices(wrapper, type) {
    wrapper.find('tbody tr').each(function(index, element) {
        const newIndex = index + 1;
        $(element).find('input, p').each(function() {
            const id = $(this).attr('id');
            const name = $(this).attr('name');
            if (id) {
                const newId = id.replace(/-\d+$/, `-${newIndex}`);
                $(this).attr('id', newId);
                if ($(this).is('p') && id.startsWith(`${type}-iteration-`)) {
                    $(this).text(newIndex); // Update the iteration number
                }
            }
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${newIndex}]`);
                $(this).attr('name', newName);
            }
        });
        // Update input event with the new index
        $(element).find('input').off('input').on('input', function() {
            calculateBalesVolumeAndPrice(newIndex);
        });
    });
}


balesWrapper.on('click', '.remove-bale-button', function (e) {
    e.preventDefault()
    $(this).closest('tr').remove();
    updateIndices(balesWrapper, 'bale'); // Update indices after a row is removed
    baleIndex = balesWrapper.find('tbody tr').length;
})

buttonAddVehicle.on('click', function (e) {
    e.preventDefault()
    const currentIndex = vehicleIndex
    const vehicleHTML = `
        <tr>
            <td><p id="vehicle-iteration-${currentIndex}">${currentIndex}</p></td>
            <td>
                <input type="text" class="form-control form-control-sm" id="vehicle-description-${currentIndex}" name="items[vehicles][${currentIndex}][description]">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-only-number" id="vehicle-price-${currentIndex}" name="items[vehicles][${currentIndex}][price]">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <div class="action-btns d-flex justify-content-center">
                    <a href="javascript:void(0);" class="action-btn btn-delete bs-tooltip remove-vehicle-button" data-toggle="tooltip" data-placement="top" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    </a>
                </div>
            </td>
        </tr>
    `

    vehiclesTable.find('tbody tr:last-child').before(vehicleHTML)

    inputOnlyNumber()
    vehicleIndex++
})

vehiclesTable.on('click', '.remove-vehicle-button', function (e) {
    e.preventDefault()
    $(this).closest('tr').remove()
    updateIndices(vehiclesTable, 'vehicle'); // Update indices after a row is removed
    vehicleIndex = vehiclesTable.find('tbody tr').length;
})

function setLoading(loading) {
    if (loading === true) {
        submitFormButton.attr('disabled', true)
    } else {
        submitFormButton.attr('disabled', false)
    }
}

form.on('submit', async function (e) {
    e.preventDefault()
    const formData = new FormData(this)
    await submitForm(formData)
})

async function submitForm(formData) {
    setLoading(true)
    try {
        const response = await axios.post(CREATE_SHIPMENT_URL, formData)
        try {
            if (response && response.data && response.data.redirect_url) {
                // Delay the redirect to ensure the response is fully processed
                setTimeout(() => {
                    window.location.href = response.data.redirect_url;
                }, 100);
            } else {
                throw new Error('Invalid response or missing redirect URL');
            }
        } catch (error) {
            console.error(error.message);
            setLoading(false);
        }
    } catch (error) {
        setLoading(false)
        if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors
            displayErrors(form, errors)
        } else {
            console.error('An error occurred:', error);
        }
    }
}
