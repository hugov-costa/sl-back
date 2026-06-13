<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read Product $product
 */
class UpdateProductRequest extends FormRequest
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
                'string',
                Rule::unique('products')->ignore($this->product->id),
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
            ],

            /**
             * Description of the product.
             *
             * @example Caixa de madeira
             */
            'description' => [
                'max:60',
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
            ],
        ];
    }
}
