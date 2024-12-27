import { createTomSelect } from "../../../helpers/create-tom-select.js"
import { displayErrors } from "../../../helpers/handle-errors.js"

const table = $("#table-kilograms")
const addButton = $("#add-kilogram-button")
let index = 1

addButton.on('click', function (e) {
    e.preventDefault()

    const currentIndex = index

    const HTML = `
        <tr>
            <td><p id="kilogram-iteration-${currentIndex}">${currentIndex}</p></td>
            <td>
                <input type="text" id="length-${currentIndex}" name="items[kilograms][${currentIndex}][length]" class="form-control form-control-sm input-only-number">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <input type="text" id="width-${currentIndex}" name="items[kilograms][${currentIndex}][width]" class="form-control form-control-sm input-only-number">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <input type="text" id="height-${currentIndex}" name="items[kilograms][${currentIndex}][height]" class="form-control form-control-sm input-only-number">
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
    table.find('tbody tr:last-child').before(HTML)

    $(`#length-${currentIndex}, #width-${currentIndex}, #height-${currentIndex}`).on('input', function() {calculateKilogramVolumeAndPrice(currentIndex)})

    inputOnlyNumber()

    index++
})

// Utils
function calculateKilogramVolumeAndPrice(currentIndex) {
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

function inputOnlyNumber() {
    $('.input-only-number').on('input', function (e) {
        const regex = /[^0-9,]/g
        const value = $(this).val()
        const newValue = value.replace(regex, '')
        $(this).val(newValue)
    })
}

function formatPrice(price) {
    const priceString = price.toString()
    const regex = /(\d)(?=(\d{3})+(?!\d))/g
    const newPrice = priceString.replace(regex, '$1.')
    return newPrice
}

