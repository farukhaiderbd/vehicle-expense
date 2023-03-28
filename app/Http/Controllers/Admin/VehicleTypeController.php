<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVehicleTypeRequest;
use App\Http\Requests\StoreVehicleTypeRequest;
use App\Http\Requests\UpdateVehicleTypeRequest;
use App\Models\VehicleType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VehicleTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleType::query()->select(sprintf('%s.*', (new VehicleType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vehicle_type_show';
                $editGate      = 'vehicle_type_edit';
                $deleteGate    = 'vehicle_type_delete';
                $crudRoutePart = 'vehicle-types';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.vehicleTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vehicleTypes.create');
    }

    public function store(StoreVehicleTypeRequest $request)
    {
        $vehicleType = VehicleType::create($request->all());

        return redirect()->route('admin.vehicle-types.index');
    }

    public function edit(VehicleType $vehicleType)
    {
        abort_if(Gate::denies('vehicle_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vehicleTypes.edit', compact('vehicleType'));
    }

    public function update(UpdateVehicleTypeRequest $request, VehicleType $vehicleType)
    {
        $vehicleType->update($request->all());

        return redirect()->route('admin.vehicle-types.index');
    }

    public function show(VehicleType $vehicleType)
    {
        abort_if(Gate::denies('vehicle_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleType->load('vehicleTypeCompanyVehicles');

        return view('admin.vehicleTypes.show', compact('vehicleType'));
    }

    public function destroy(VehicleType $vehicleType)
    {
        abort_if(Gate::denies('vehicle_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleType->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleTypeRequest $request)
    {
        $vehicleTypes = VehicleType::find(request('ids'));

        foreach ($vehicleTypes as $vehicleType) {
            $vehicleType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
