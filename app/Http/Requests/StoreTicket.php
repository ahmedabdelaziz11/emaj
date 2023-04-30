<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicket extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'client_id' => 'bail|required|exists:clients,id',
            'employees' => 'bail|required|array',
            'employees.*.id' => 'bail|required|exists:employees,id',
            'date' => 'bail|required|date',
            'ticket_type' => 'bail|required|in:invoice,warranty,other',
            'ticket_parent_id' => 'bail|nullable|exists:tickets,id',
            'address' => 'bail|required|string',
            'received_money' => 'bail|nullable|integer',
            'recommended_path' => 'bail|required|string',
            'invoice_product_id' => 'bail|nullable|exists:invoice_products,id',
        ];
    }
}
