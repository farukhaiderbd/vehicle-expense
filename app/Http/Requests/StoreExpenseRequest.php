<?php

namespace App\Http\Requests;

use App\Models\Expense;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('expense_create');
    }

    public function rules()
    {
        return [
            'department_id' => [
                'required',
                'integer',
            ],
            'company_id' => [
                'required',
                'integer',
            ],
            'company_vehicle_id' => [
                'required',
                'integer',
            ],
            'entry_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'amount' => [
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'payment_status' => [
                'required',
            ],
        ];
    }
}
