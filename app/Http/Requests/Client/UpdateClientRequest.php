<?php

namespace App\Http\Requests\Client;

use App\Models\Client;
use App\Rules\ValidateCpfCnpj;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read Client $client
 */
class UpdateClientRequest extends FormRequest
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
            ],

            /**
             * Document number of the client (CPF or CNPJ).
             *
             * @example 12345678901234
             */
            'document_number' => [
                'string',
                Rule::unique('clients')->ignore($this->client->id),
                new ValidateCpfCnpj,
            ],

            /**
             * Name of the client.
             *
             * @example Empresa
             */
            'name' => [
                'max:60',
                'string',
            ],

            /**
             * Trade name of the client.
             *
             * @example Empresa Ltda
             */
            'trade_name' => [
                'max:100',
                'string',
            ],
        ];
    }
}
