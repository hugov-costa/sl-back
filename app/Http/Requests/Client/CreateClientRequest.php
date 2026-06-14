<?php

namespace App\Http\Requests\Client;

use App\Rules\ValidateCpfCnpj;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
             * Address of the client.
             *
             * @example Rua das Flores, 123, São Paulo, SP
             */
            'address' => [
                'max:1000',
                'required',
                'string',
            ],

            /**
             * Code of the client.
             *
             * @example 1000
             */
            'code' => [
                'integer',
                'max_digits:10',
                'min:0',
                'required',
            ],

            /**
             * Document number of the client (CPF or CNPJ).
             *
             * @example 12345678901234
             */
            'document_number' => [
                'required',
                'string',
                'unique:clients',
                new ValidateCpfCnpj,
            ],

            /**
             * Name of the client.
             *
             * @example Empresa
             */
            'name' => [
                'max:60',
                'required',
                'string',
            ],

            /**
             * Trade name of the client.
             *
             * @example Empresa Ltda.
             */
            'trade_name' => [
                'max:100',
                'required',
                'string',
            ],
        ];
    }
}
