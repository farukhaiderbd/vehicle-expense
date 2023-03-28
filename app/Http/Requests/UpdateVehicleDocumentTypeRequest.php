<?php

namespace App\Http\Requests;

use App\Models\VehicleDocumentType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVehicleDocumentTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_document_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:vehicle_document_types,name,' . request()->route('vehicle_document_type')->id,
            ],
        ];
    }
}
