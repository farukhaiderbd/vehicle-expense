<?php

namespace App\Http\Requests;

use App\Models\Company;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('company_edit');
    }

    public function rules()
    {
        return [
            'company_name' => [
                'string',
                'required',
                'unique:companies,company_name,' . request()->route('company')->id,
            ],
            'company_phone' => [
                'string',
                'nullable',
            ],
        ];
    }
}
