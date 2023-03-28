@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vehicleType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleType.fields.id') }}
                        </th>
                        <td>
                            {{ $vehicleType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleType.fields.name') }}
                        </th>
                        <td>
                            {{ $vehicleType->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-types.index') }}">
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
            <a class="nav-link" href="#vehicle_type_company_vehicles" role="tab" data-toggle="tab">
                {{ trans('cruds.companyVehicle.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="vehicle_type_company_vehicles">
            @includeIf('admin.vehicleTypes.relationships.vehicleTypeCompanyVehicles', ['companyVehicles' => $vehicleType->vehicleTypeCompanyVehicles])
        </div>
    </div>
</div>

@endsection