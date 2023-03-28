<?php

namespace App\Http\Requests;

use App\Models\VehicleDocumentType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVehicleDocumentTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_document_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:vehicle_document_types',
            ],
        ];
    }
}
