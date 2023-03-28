<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVehicleDocumentTypeRequest;
use App\Http\Requests\StoreVehicleDocumentTypeRequest;
use App\Http\Requests\UpdateVehicleDocumentTypeRequest;
use App\Models\VehicleDocumentType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleDocumentTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vehicle_document_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleDocumentTypes = VehicleDocumentType::all();

        return view('admin.vehicleDocumentTypes.index', compact('vehicleDocumentTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_document_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vehicleDocumentTypes.create');
    }

    public function store(StoreVehicleDocumentTypeRequest $request)
    {
        $vehicleDocumentType = VehicleDocumentType::create($request->all());

        return redirect()->route('admin.vehicle-document-types.index');
    }

    public function edit(VehicleDocumentType $vehicleDocumentType)
    {
        abort_if(Gate::denies('vehicle_document_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vehicleDocumentTypes.edit', compact('vehicleDocumentType'));
    }

    public function update(UpdateVehicleDocumentTypeRequest $request, VehicleDocumentType $vehicleDocumentType)
    {
        $vehicleDocumentType->update($request->all());

        return redirect()->route('admin.vehicle-document-types.index');
    }

    public function show(VehicleDocumentType $vehicleDocumentType)
    {
        abort_if(Gate::denies('vehicle_document_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleDocumentType->load('vehicleDocumentTypeVehicleDocuments');

        return view('admin.vehicleDocumentTypes.show', compact('vehicleDocumentType'));
    }

    public function destroy(VehicleDocumentType $vehicleDocumentType)
    {
        abort_if(Gate::denies('vehicle_document_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleDocumentType->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleDocumentTypeRequest $request)
    {
        $vehicleDocumentTypes = VehicleDocumentType::find(request('ids'));

        foreach ($vehicleDocumentTypes as $vehicleDocumentType) {
            $vehicleDocumentType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
