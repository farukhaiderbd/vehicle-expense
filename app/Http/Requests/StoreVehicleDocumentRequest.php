<?php

namespace App\Http\Requests;

use App\Models\VehicleDocument;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVehicleDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vehicle_document_create');
    }

    public function rules()
    {
        return [
            'company_id' => [
                'required',
                'integer',
            ],
            'company_vehicle_id' => [
                'required',
                'integer',
            ],
            'attachment' => [
                'array',
                'required',
            ],
            'attachment.*' => [
                'required',
            ],
            'vehicle_document_type_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
