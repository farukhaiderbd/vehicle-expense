<?php

namespace App\Http\Requests;

use App\Models\CompanyVehicle;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCompanyVehicleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('company_vehicle_edit');
    }

    public function rules()
    {
        return [
            'company_id' => [
                'required',
                'integer',
            ],
            'department_id' => [
                'required',
                'integer',
            ],
            'vehicle_type_id' => [
                'required',
                'integer',
            ],
            'registration_number' => [
                'string',
                'required',
                'unique:company_vehicles,registration_number,' . request()->route('company_vehicle')->id,
            ],
            'plate_number' => [
                'string',
                'required',
            ],
            'license_number' => [
                'string',
                'required',
            ],
            'license_issues_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'license_expire_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
