import { createTomSelect } from "../../../helpers/create-tom-select.js"
import { displayErrors } from "../../../helpers/handle-errors.js"

const form = $("#create-form")
const formButton = $("#submit-create-form-button")
const table = $("#table-item")
const tableButton = $("#add-item-button")

let itemIndex = 1

const destination = createTomSelect("#destination", GET_DESTINATIONS, 'Pilih Pengiriman Via')
const destinationType = new TomSelect(`#destination-type`, {
  create: false,
  sortField: {
      field: 'text',
      direction: 'asc'
  }
})

form.on('submit', async function (e) {
  e.preventDefault()
  const formData = new FormData(this)
  await submitForm(formData)
})

async function submitForm(formData) {
  setLoading(true)
  try {
      const response = await axios.post(CREATE_SHIPPER_URL, formData)
      if (response) {
          return window.location.href = await response.data.redirect_url
      }
  } catch (error) {
      setLoading(false)
      if (error.response.status === 422) {
          const errors = error.response.data.errors
          displayErrors(form, errors)
      }
  }
}

tableButton.on('click', function (e) {
  e.preventDefault()
  const currentIndex = itemIndex
  const HTML = `
        <tr>
            <td><p id="item-iteration-${currentIndex}">${currentIndex}</p></td>
            <td>
                <input type="text" id="recipient-name-${currentIndex}" name="items[${currentIndex}][recipient_name]" class="form-control form-control-sm">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <input type="text" id="colly-${currentIndex}" name="items[${currentIndex}][colly]" class="form-control form-control-sm input-only-number">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <input type="text" id="vol-weight-${currentIndex}" name="items[${currentIndex}][vol_weight]" class="form-control form-control-sm input-only-number">
                <span class="invalid-feedback"></span>
            </td>
            <td>
                <p id="price-${currentIndex}"></p>
            </td>
            <td>
                <div class="action-btns d-flex justify-content-center">
                    <a href="javascript:void(0);" class="action-btn btn-delete bs-tooltip remove-item-button" data-toggle="tooltip" data-placement="top" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    </a>
                </div>
            </td>
        </tr>
    `;
    table.find('tbody tr:last-child').before(HTML)

    $(`#vol-weight-${currentIndex}`).on('input', function() {calculatePrice(currentIndex)})

    inputOnlyNumber()

    itemIndex++
})

table.on('click', '.remove-item-button', function (e) {
  e.preventDefault()
  $(this).closest('tr').remove()
  updateIndices(table, 'item')
  itemIndex = table.find('tbody tr').length
})



// * Utils
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

function calculatePrice(currentIndex) {
  const cost = $('#cost').val()
  const volume = $(`#vol-weight-${currentIndex}`).val().replace(/,/g, '.')
  let price = (volume * cost).toFixed(0)
  price = formatPrice(price)
  $(`#price-${currentIndex}`).text(price)
}

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
          calculatePrice(newIndex);
      });
  });
}

function setLoading(loading) {
  if (loading === true) {
      formButton.attr('disabled', true)
  } else {
      formButton.attr('disabled', false)
  }
}
