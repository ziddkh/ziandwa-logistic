<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'phone_number' => ['nullable'],
            'delivery_address' => ['nullable'],
            'delivery_date' => ['required', 'date', 'after_or_equal:today'],
            'destination_location_id' => ['required'],
            'ship_name' => ['required'],
            'destination_type' => ['required'],
            'cost' => ['nullable', 'required_if:destination_type,==,spesial'],
            'packages' => ['required', 'array', 'min:1'],
            'packages.*.length' => ['required'],
            'packages.*.width' => ['required'],
            'packages.*.height' => ['required'],
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
            'name.required' => 'Nama penerima harus diisi!',
            'phone_number.required' => 'Nomor telepon penerima harus diisi!',
            'delivery_address.required' => 'Alamat penerima harus diisi!',
            'delivery_date.required' => 'Tanggal pengiriman harus diisi!',
            'destination_location_id.required' => 'Lokasi tujuan harus diisi!',
            'ship_name.required' => 'Nama kapal harus diisi!',
            'destination_type.required' => 'Tipe tujuan harus diisi!',
            'cost.required_if' => 'Biaya pengiriman harus diisi!',
            'packages.required' => 'Paket harus diisi!',
            'packages.min' => 'Paket harus diisi!',
            'packages.*.length.required' => 'Panjang paket harus diisi!',
            'packages.*.width.required' => 'Lebar paket harus diisi!',
            'packages.*.height.required' => 'Tinggi paket harus diisi!',
        ];
    }
}
