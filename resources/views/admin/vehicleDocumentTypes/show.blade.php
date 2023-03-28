@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vehicleDocumentType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-document-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleDocumentType.fields.id') }}
                        </th>
                        <td>
                            {{ $vehicleDocumentType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleDocumentType.fields.name') }}
                        </th>
                        <td>
                            {{ $vehicleDocumentType->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-document-types.index') }}">
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
            <a class="nav-link" href="#vehicle_document_type_vehicle_documents" role="tab" data-toggle="tab">
                {{ trans('cruds.vehicleDocument.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="vehicle_document_type_vehicle_documents">
            @includeIf('admin.vehicleDocumentTypes.relationships.vehicleDocumentTypeVehicleDocuments', ['vehicleDocuments' => $vehicleDocumentType->vehicleDocumentTypeVehicleDocuments])
        </div>
    </div>
</div>

@endsection