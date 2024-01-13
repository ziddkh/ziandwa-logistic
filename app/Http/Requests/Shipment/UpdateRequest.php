<?php

namespace App\Http\Requests\Shipment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'recipient_name' => 'required|string',
            'recipient_phone' => 'nullable|string',
            'recipient_address' => 'required|string',
            'departure_date' => 'required|date',
            'destination_id' => 'required',
            'harbor_name' => 'nullable',
            'destination_cost' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'recipient_name.required' => 'Nama penerima harus diisi',
            'recipient_name.string' => 'Nama penerima harus berupa string',
            'recipient_phone.required' => 'Nomor telepon penerima harus diisi',
            'recipient_phone.string' => 'Nomor telepon penerima harus berupa string',
            'recipient_address.required' => 'Alamat penerima harus diisi',
            'recipient_address.string' => 'Alamat penerima harus berupa string',
            'departure_date.required' => 'Tanggal keberangkatan harus diisi',
            'departure_date.date' => 'Tanggal keberangkatan harus berupa tanggal',
            'destination_id.required' => 'Kota tujuan harus diisi',
            'destination_cost.required' => 'Ongkos kirim harus diisi',
        ];
    }
}
