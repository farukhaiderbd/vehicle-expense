@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.department.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.departments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.department.fields.id') }}
                        </th>
                        <td>
                            {{ $department->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.department.fields.name') }}
                        </th>
                        <td>
                            {{ $department->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.departments.index') }}">
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
            <a class="nav-link" href="#department_company_vehicles" role="tab" data-toggle="tab">
                {{ trans('cruds.companyVehicle.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#department_expenses" role="tab" data-toggle="tab">
                {{ trans('cruds.expense.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="department_company_vehicles">
            @includeIf('admin.departments.relationships.departmentCompanyVehicles', ['companyVehicles' => $department->departmentCompanyVehicles])
        </div>
        <div class="tab-pane" role="tabpanel" id="department_expenses">
            @includeIf('admin.departments.relationships.departmentExpenses', ['expenses' => $department->departmentExpenses])
        </div>
    </div>
</div>

@endsection