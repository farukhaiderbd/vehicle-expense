<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCompanyVehicleRequest;
use App\Http\Requests\StoreCompanyVehicleRequest;
use App\Http\Requests\UpdateCompanyVehicleRequest;
use App\Models\Company;
use App\Models\CompanyVehicle;
use App\Models\Department;
use App\Models\User;
use App\Models\VehicleType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CompanyVehicleController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('company_vehicle_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CompanyVehicle::with(['company', 'department', 'vehicle_type', 'created_by'])->select(sprintf('%s.*', (new CompanyVehicle)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'company_vehicle_show';
                $editGate      = 'company_vehicle_edit';
                $deleteGate    = 'company_vehicle_delete';
                $crudRoutePart = 'company-vehicles';

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
            $table->addColumn('company_company_name', function ($row) {
                return $row->company ? $row->company->company_name : '';
            });

            $table->addColumn('department_name', function ($row) {
                return $row->department ? $row->department->name : '';
            });

            $table->addColumn('vehicle_type_name', function ($row) {
                return $row->vehicle_type ? $row->vehicle_type->name : '';
            });

            $table->editColumn('registration_number', function ($row) {
                return $row->registration_number ? $row->registration_number : '';
            });
            $table->editColumn('plate_number', function ($row) {
                return $row->plate_number ? $row->plate_number : '';
            });
            $table->editColumn('license_number', function ($row) {
                return $row->license_number ? $row->license_number : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'company', 'department', 'vehicle_type']);

            return $table->make(true);
        }

        $companies     = Company::get();
        $departments   = Department::get();
        $vehicle_types = VehicleType::get();
        $users         = User::get();

        return view('admin.companyVehicles.index', compact('companies', 'departments', 'vehicle_types', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('company_vehicle_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_types = VehicleType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.companyVehicles.create', compact('companies', 'departments', 'vehicle_types'));
    }

    public function store(StoreCompanyVehicleRequest $request)
    {
        $companyVehicle = CompanyVehicle::create($request->all());

        return redirect()->route('admin.company-vehicles.index');
    }

    public function edit(CompanyVehicle $companyVehicle)
    {
        abort_if(Gate::denies('company_vehicle_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_types = VehicleType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companyVehicle->load('company', 'department', 'vehicle_type', 'created_by');

        return view('admin.companyVehicles.edit', compact('companies', 'companyVehicle', 'departments', 'vehicle_types'));
    }

    public function update(UpdateCompanyVehicleRequest $request, CompanyVehicle $companyVehicle)
    {
        $companyVehicle->update($request->all());

        return redirect()->route('admin.company-vehicles.index');
    }

    public function show(CompanyVehicle $companyVehicle)
    {
        abort_if(Gate::denies('company_vehicle_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyVehicle->load('company', 'department', 'vehicle_type', 'created_by', 'companyVehicleVehicleDocuments', 'companyVehicleExpenses');

        return view('admin.companyVehicles.show', compact('companyVehicle'));
    }

    public function destroy(CompanyVehicle $companyVehicle)
    {
        abort_if(Gate::denies('company_vehicle_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyVehicle->delete();

        return back();
    }

    public function massDestroy(MassDestroyCompanyVehicleRequest $request)
    {
        $companyVehicles = CompanyVehicle::find(request('ids'));

        foreach ($companyVehicles as $companyVehicle) {
            $companyVehicle->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
