<?php

namespace App\Http\Requests\Shipper;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return array<string, mixed>
     */
    protected function prepareForValidation()
    {
      $items = $this->items ?? [];
      if (!empty($items)) {
        foreach ($items as $key => $item) {
          if (! empty($item['colly'])) {
              $items[$key]['colly'] = floatval(str_replace(',', '.', $item['colly']));
          }
          if (! empty($item['vol_weight'])) {
              $items[$key]['vol_weight'] = floatval(str_replace(',', '.', $item['vol_weight']));
          }
        }
      }
      return $this->merge([
        'destination_cost' => intval($this->destination_cost),
        'destination_id' => intval($this->destination_id),
        'items' => $items,
      ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
          'departure_date' => 'required|date',
          'name' => 'required|string',
          'harbor_name' => 'required|string',
          'ship_name' => 'required|string',
          'destination_id' => 'required|exists:destinations,id',
          'destination_type' => 'required',
          'destination_cost' => 'required|numeric',
          'items' => 'required|array|min:1',
          'items.*.recipient_name' => 'nullable',
          'items.*.colly' => 'required|numeric',
          'items.*.vol_weight' => 'required|numeric',
        ];
    }

     /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
      return [
        'departure_date.required' => 'Tanggal keberangkatan harus diisi!',
        'departure_date.date' => 'Tanggal keberangkatan harus berupa tanggal!',
        'name.required' => 'Nama penerima harus diisi!',
        'name.string' => 'Nama penerima harus berupa huruf!',
        'ship_name.required' => 'Nama pelabuhan harus diisi!',
        'ship_name.string' => 'Nama pelabuhan harus berupa huruf!',
        'ship_name.required' => 'Nama kapal harus diisi!',
        'ship_name.string' => 'Nama kapal harus berupa huruf!',
        'destination_id.required' => 'Lokasi tujuan harus diisi!',
        'destination_id.exists' => 'Lokasi tujuan tidak ditemukan!',
        'destination_type.required' => 'Tipe tujuan harus diisi!',
        'cost.numeric' => 'Biaya pengiriman harus berupa angka!',
        'cost.required' => 'Biaya pengiriman harus diisi!',
        'items.required' => 'Item harus diisi!',
        'items.array' => 'Item harus berupa array!',
        'items.min' => 'Item harus diisi!',
        'items.*.colly.required' => 'Colly harus diisi!',
        'items.*.colly.numeric' => 'Colly harus berupa angka!',
        'items.*.vol_weight.required' => 'Volume harus diisi!',
        'items.*.vol_weight.numeric' => 'Volume harus berupa angka!',
      ];
    }
}
