<?php

namespace App\Http\Requests\Shipment;

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
        if (! empty($items)) {
            $bales = $items['bales'] ?? [];
            $vehicles = $items['vehicles'] ?? [];
            if (! empty($bales)) {
                foreach ($bales as $key => $bale) {
                    if (! empty($bale['length'])) {
                        $bales[$key]['length'] = floatval(str_replace(',', '.', $bale['length']));
                    }
                    if (! empty($bale['width'])) {
                        $bales[$key]['width'] = floatval(str_replace(',', '.', $bale['width']));
                    }
                    if (! empty($bale['height'])) {
                        $bales[$key]['height'] = floatval(str_replace(',', '.', $bale['height']));
                    }
                }

                $items['bales'] = $bales;
            }

            if (! empty($vehicles)) {
                foreach ($vehicles as $key => $vehicle) {
                    if (! empty($vehicle['price'])) {
                        $vehicles[$key]['price'] = intval($vehicle['price']);
                    }
                }

                $items['vehicles'] = $vehicles;
            }
        }

        // $items = $this->items;
        // if (!empty($this->items)) {
        //     foreach ($items as $key => $item) {
        //         if (!empty($item['length'])) {
        //             $items[$key]['length'] = floatval(str_replace(',', '.', $item['length']));
        //         }
        //         if (!empty($item['width'])) {
        //             $items[$key]['width'] = floatval(str_replace(',', '.', $item['width']));
        //         }
        //         if (!empty($item['height'])) {
        //             $items[$key]['height'] = floatval(str_replace(',', '.', $item['height']));
        //         }
        //     }
        // }

        return $this->merge([
            'cost' => intval($this->cost),
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
            'cost' => 'required|numeric',
            'departure_date' => 'required|date',
            'destination_id' => 'required|exists:destinations,id',
            'harbor_name' => 'nullable|string',
            'destination_type' => 'required',
            'recipient_name' => 'required|string',
            'recipient_phone' => 'nullable|string',
            'recipient_address' => 'nullable|string',
            'ship_name' => 'required|string',
            'items' => 'required|array|min:1',
            'items.bales.*.length' => 'required|numeric',
            'items.bales.*.width' => 'required|numeric',
            'items.bales.*.height' => 'required|numeric',
            'items.vehicles.*.description' => 'required|string',
            'items.vehicles.*.price' => 'required|numeric',
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
            'cost.required' => 'Biaya pengiriman harus diisi!',
            'cost.numeric' => 'Biaya pengiriman harus berupa angka!',
            'departure_date.required' => 'Tanggal keberangkatan harus diisi!',
            'departure_date.date' => 'Tanggal keberangkatan harus berupa tanggal!',
            'destination_id.required' => 'Lokasi tujuan harus diisi!',
            'destination_id.exists' => 'Lokasi tujuan tidak ditemukan!',
            'destination_type.required' => 'Tipe tujuan harus diisi!',
            'recipient_name.required' => 'Nama penerima harus diisi!',
            'recipient_name.string' => 'Nama penerima harus berupa huruf!',
            'recipient_phone.required' => 'Nomor telepon penerima harus diisi!',
            'recipient_phone.string' => 'Nomor telepon penerima harus berupa huruf!',
            'recipient_address.required' => 'Alamat penerima harus diisi!',
            'recipient_address.string' => 'Alamat penerima harus berupa huruf!',
            'ship_name.required' => 'Nama kapal harus diisi!',
            'ship_name.string' => 'Nama kapal harus berupa huruf!',
            'items.required' => 'Item harus diisi!',
            'items.array' => 'Item harus berupa array!',
            'items.min' => 'Item harus diisi!',
            'items.bales.*.length.required' => 'Panjang paket harus diisi!',
            'items.bales.*.length.numeric' => 'Panjang paket harus berupa angka!',
            'items.bales.*.width.required' => 'Lebar paket harus diisi!',
            'items.bales.*.width.numeric' => 'Lebar paket harus berupa angka!',
            'items.bales.*.height.required' => 'Tinggi paket harus diisi!',
            'items.bales.*.height.numeric' => 'Tinggi paket harus berupa angka!',
            'items.vehicles.*.description.required' => 'Deskripsi kendaraan harus diisi!',
            'items.vehicles.*.description.string' => 'Deskripsi kendaraan harus berupa huruf!',
            'items.vehicles.*.price.required' => 'Harga kendaraan harus diisi!',
            'items.vehicles.*.price.numeric' => 'Harga kendaraan harus berupa angka!',
        ];
    }
}
