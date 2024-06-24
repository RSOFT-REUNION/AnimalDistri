<?php

namespace App\Http\Requests\Backend\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class ShopsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:catalog_products,id',
            'shop_id' => 'required|exists:catalog_shops,id',
            'quantity_in_stock' => 'required|integer|min:0',
            'quantity_reserved' => 'required|integer|min:0',
            'quantity_sold' => 'required|integer|min:0',
        ];
    }
}


