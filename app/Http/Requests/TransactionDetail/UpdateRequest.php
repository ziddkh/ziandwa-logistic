<?php

namespace App\Http\Requests\TransactionDetail;

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
            'delivery_date' => 'required|date',
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'transaction_id' => 'required',
            'cost' => 'required',
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
            'delivery_date.required' => 'Tanggal pengiriman harus diisi!',
            'delivery_date.date' => 'Tanggal pengiriman harus berupa tanggal!',
            'length.required' => 'Panjang harus diisi!',
            'width.required' => 'Lebar harus diisi!',
            'height.required' => 'Tinggi harus diisi!',
            'transaction_id.required' => 'ID transaksi harus diisi!',
            'cost.required' => 'Biaya harus diisi!',
        ];
    }
}
