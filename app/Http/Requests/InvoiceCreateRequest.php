<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceCreateRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'tax' => 'required|numeric|min:0',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:0,1'
        ];
    }
}
