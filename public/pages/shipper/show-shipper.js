import { createTomSelect } from "../../../helpers/create-tom-select.js"
import { clearErrors, displayErrors } from "../../../helpers/handle-errors.js"

const buttonAddPayment = $("#btn-add-payment")
const modalAddPayment = $("#modal-add-payment")
const formAddPayment = $("#form-add-payment")
const wrapperPaymentAmount = $("#wrapper-payment-amount")
const selectPaymentMethod = $("#payment-method")
const inputPaymentAmount = $("#payment-amount")

buttonAddPayment.on('click', function (e) {
    e.preventDefault()
    modalAddPayment.modal('show')
})

selectPaymentMethod.on('change', function () {
    // if ($(this).val() === 'Bayar Nanti') {
    //     wrapperPaymentAmount.show()
    // } else {
    //     wrapperPaymentAmount.hide()
    //     inputPaymentAmount.val('')
    // }
})

modalAddPayment.on('hidden.bs.modal', function () {
    wrapperPaymentAmount.hide()
    selectPaymentMethod.val(null).trigger('change')
    inputPaymentAmount.val('')
})

formAddPayment.on('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(this)
    const url = $(this).attr('action')
    try {
        await axios.post(url, formData)
    } catch (error) {
        console.log(error)
        if (error.response.status === 422) {
            const errors = error.response.data.errors
            displayErrors(formAddPayment, errors)
        }
    }

})

$('.btn-approve-shipper-payment').on('click', async function (e) {
    e.preventDefault()
    const actionUrl = $(this).attr('href')

    if (confirm("Apakah yakin untuk menkonfirmasi pembayaran") === true) {
        await axios.post(actionUrl)
        .then((response) => {
            window.location.reload()
        })
        .catch(error => {
            console.log(error.response)
        })
    }
})

$('.input-price').on('input', function (e) {
    const value = $(this).val();
    const numericValue = value.replace(/[^0-9,]/g, '');
    const cleanedValue = numericValue.replace(/,+/g, ',');
    const parts = cleanedValue.split(',');
    if (parts.length > 2) {
        const integerPart = parts.shift();
        const decimalPart = parts.join('');
        $(this).val(integerPart + ',' + decimalPart);
    } else {
        $(this).val(cleanedValue);
    }
    const formattedValue = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    $(this).val(formattedValue);
})
