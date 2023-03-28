@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vehicleDocument.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.id') }}
                        </th>
                        <td>
                            {{ $vehicleDocument->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.company') }}
                        </th>
                        <td>
                            {{ $vehicleDocument->company->company_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.company_vehicle') }}
                        </th>
                        <td>
                            {{ $vehicleDocument->company_vehicle->registration_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.note') }}
                        </th>
                        <td>
                            {!! $vehicleDocument->note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.attachment') }}
                        </th>
                        <td>
                            @foreach($vehicleDocument->attachment as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.vehicle_document_type') }}
                        </th>
                        <td>
                            {{ $vehicleDocument->vehicle_document_type->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vehicle-documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection