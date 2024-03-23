<?php

namespace App\Http\Requests\ShipmentItem;

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
     * Prepare the data for validation.
     *
     * @return array<string, mixed>
     */
    protected function prepareForValidation()
    {
        $length = (bool) $this->length ? floatval(str_replace(',', '.', $this->length)) : null;
        $width = (bool) $this->width ? floatval(str_replace(',', '.', $this->width)) : null;
        $height = (bool) $this->height ? floatval(str_replace(',', '.', $this->height)) : null;
        $price = (bool) $this->price ? intval($this->price) : null;

        return $this->merge([
            'length' => $length,
            'width' => $width,
            'height' => $height,
            'price' => $price,
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
            'ship_name' => 'nullable|string',
            'type' => 'required|string',
            'length' => 'required_if:type,bale',
            'width' => 'required_if:type,bale',
            'height' => 'required_if:type,bale',
            'price' => 'required_if:type,vehicle',
            'description' => 'required_if:type,vehicle',
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
            'ship_name.required' => 'Nama kapal harus diisi',
            'ship_name.string' => 'Nama kapal harus berupa string',
            'type.required' => 'Tipe kapal harus diisi',
            'type.string' => 'Tipe kapal harus berupa string',
            'length.required_if' => 'Panjang kapal harus diisi',
            'width.required_if' => 'Lebar kapal harus diisi',
            'height.required_if' => 'Tinggi kapal harus diisi',
            'price.required_if' => 'Harga kapal harus diisi',
            'description.required_if' => 'Deskripsi kapal harus diisi',
        ];
    }
}
