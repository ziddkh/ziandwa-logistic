<?php

namespace App\Http\Requests\ShipperPayment;

use App\Enums\ShipperPaymentMethodEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'shipper_id' => 'required|exists:shippers,id',
            'payment_method' => ['required', Rule::enum(ShipperPaymentMethodEnums::class)],
            // 'payment_amount' => [
            //     Rule::requiredIf(function () {
            //         return $this->payment_method === ShipperPaymentMethodEnums::from('Bayar Nanti')->value;
            //     })]
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'payment_amount' => !empty($this->payment_amount) ? (int) str_replace('.', '', $this->payment_amount) : null,
        ]);
    }
}
