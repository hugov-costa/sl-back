<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * Barcode of the product.
             *
             * @example 1234567890123
             */
            'barcode' => [
                'max:14',
                'required',
                'string',
                'unique:products',
            ],

            /**
             * Code of the product.
             *
             * @example 1234567890
             */
            'code' => [
                'integer',
                'max_digits:10',
                'min:0',
                'required',
            ],

            /**
             * Description of the product.
             *
             * @example Caixa de madeira
             */
            'description' => [
                'max:60',
                'required',
                'string',
            ],

            /**
             * Gross weight of the product.
             *
             * @example 12000
             */
            'gross_weight' => [
                'integer',
                'max_digits:9',
                'min:0',
                'required',
            ],

            /**
             * Net weight of the product.
             *
             * @example 10000
             */
            'net_weight' => [
                'integer',
                'max_digits:9',
                'min:0',
                'required',
            ],

            /**
             * Price of the product in cents.
             *
             * @example 10000
             */
            'price' => [
                'integer',
                'max_digits:10',
                'min:0',
                'required',
            ],
        ];
    }
}
