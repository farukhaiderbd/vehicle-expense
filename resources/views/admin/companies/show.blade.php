@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.company.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.companies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.id') }}
                        </th>
                        <td>
                            {{ $company->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.company_name') }}
                        </th>
                        <td>
                            {{ $company->company_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.company_logo') }}
                        </th>
                        <td>
                            @if($company->company_logo)
                                <a href="{{ $company->company_logo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $company->company_logo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.company_email') }}
                        </th>
                        <td>
                            {{ $company->company_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.company.fields.company_phone') }}
                        </th>
                        <td>
                            {{ $company->company_phone }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.companies.index') }}">
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
            <a class="nav-link" href="#company_company_vehicles" role="tab" data-toggle="tab">
                {{ trans('cruds.companyVehicle.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#company_expenses" role="tab" data-toggle="tab">
                {{ trans('cruds.expense.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="company_company_vehicles">
            @includeIf('admin.companies.relationships.companyCompanyVehicles', ['companyVehicles' => $company->companyCompanyVehicles])
        </div>
        <div class="tab-pane" role="tabpanel" id="company_expenses">
            @includeIf('admin.companies.relationships.companyExpenses', ['expenses' => $company->companyExpenses])
        </div>
    </div>
</div>

@endsection