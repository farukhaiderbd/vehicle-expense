<?php

namespace App\Http\Requests;

use App\Models\VehicleDocument;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVehicleDocumentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('vehicle_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:vehicle_documents,id',
        ];
    }
}
