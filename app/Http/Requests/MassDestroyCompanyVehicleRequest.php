<?php

namespace App\Http\Requests;

use App\Models\CompanyVehicle;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCompanyVehicleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('company_vehicle_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:company_vehicles,id',
        ];
    }
}
