@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.companyVehicle.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.company-vehicles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.id') }}
                        </th>
                        <td>
                            {{ $companyVehicle->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.company') }}
                        </th>
                        <td>
                            {{ $companyVehicle->company->company_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.department') }}
                        </th>
                        <td>
                            {{ $companyVehicle->department->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.vehicle_type') }}
                        </th>
                        <td>
                            {{ $companyVehicle->vehicle_type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.registration_number') }}
                        </th>
                        <td>
                            {{ $companyVehicle->registration_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.plate_number') }}
                        </th>
                        <td>
                            {{ $companyVehicle->plate_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.license_number') }}
                        </th>
                        <td>
                            {{ $companyVehicle->license_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.license_issues_date') }}
                        </th>
                        <td>
                            {{ $companyVehicle->license_issues_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.license_expire_date') }}
                        </th>
                        <td>
                            {{ $companyVehicle->license_expire_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.company-vehicles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#company_vehicle_vehicle_documents" role="tab" data-toggle="tab">
                {{ trans('cruds.vehicleDocument.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#company_vehicle_expenses" role="tab" data-toggle="tab">
                {{ trans('cruds.expense.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="company_vehicle_vehicle_documents">
            @includeIf('admin.companyVehicles.relationships.companyVehicleVehicleDocuments', ['vehicleDocuments' => $companyVehicle->companyVehicleVehicleDocuments])
        </div>
        <div class="tab-pane" role="tabpanel" id="company_vehicle_expenses">
            @includeIf('admin.companyVehicles.relationships.companyVehicleExpenses', ['expenses' => $companyVehicle->companyVehicleExpenses])
        </div>
    </div>
</div>

@endsection