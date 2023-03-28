@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.companyVehicle.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.company-vehicles.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="company_id">{{ trans('cruds.companyVehicle.fields.company') }}</label>
                <select class="form-control select2 {{ $errors->has('company') ? 'is-invalid' : '' }}" name="company_id" id="company_id" required>
                    @foreach($companies as $id => $entry)
                        <option value="{{ $id }}" {{ old('company_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('company'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.companyVehicle.fields.company_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="department_id">{{ trans('cruds.companyVehicle.fields.department') }}</label>
                <select class="form-control select2 {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department_id" id="department_id" required>
                    @foreach($departments as $id => $entry)
                        <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('department'))
                    <div class="invalid-feedback">
                        {{ $errors->first('department') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.companyVehicle.fields.department_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="vehicle_type_id">{{ trans('cruds.companyVehicle.fields.vehicle_type') }}</label>
                <select class="form-control select2 {{ $errors->has('vehicle_type') ? 'is-invalid' : '' }}" name="vehicle_type_id" id="vehicle_type_id" required>
                    @foreach($vehicle_types as $id => $entry)
                        <option value="{{ $id }}" {{ old('vehicle_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('vehicle_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vehicle_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.companyVehicle.fields.vehicle_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="registration_number">{{ trans('cruds.companyVehicle.fields.registration_number') }}</label>
                <input class="form-control {{ $errors->has('registration_number') ? 'is-invalid' : '' }}" type="text" name="registration_number" id="registration_number" value="{{ old('registration_number', '') }}" required>
                @if($errors->has('registration_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('registration_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.companyVehicle.fields.registration_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="plate_number">{{ trans('cruds.companyVehicle.fields.plate_number') }}</label>
                <input class="form-control {{ $errors->has('plate_number') ? 'is-invalid' : '' }}" type="text" name="plate_number" id="plate_number" value="{{ old('plate_number', '') }}" required>
                @if($errors->has('plate_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('plate_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.companyVehicle.fields.plate_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="license_number">{{ trans('cruds.companyVehicle.fields.license_number') }}</label>
                <input class="form-control {{ $errors->has('license_number') ? 'is-invalid' : '' }}" type="text" name="license_number" id="license_number" value="{{ old('license_number', '') }}" required>
                @if($errors->has('license_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('license_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.companyVehicle.fields.license_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="license_issues_date">{{ trans('cruds.companyVehicle.fields.license_issues_date') }}</label>
                <input class="form-control date {{ $errors->has('license_issues_date') ? 'is-invalid' : '' }}" type="text" name="license_issues_date" id="license_issues_date" value="{{ old('license_issues_date') }}">
                @if($errors->has('license_issues_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('license_issues_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.companyVehicle.fields.license_issues_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="license_expire_date">{{ trans('cruds.companyVehicle.fields.license_expire_date') }}</label>
                <input class="form-control date {{ $errors->has('license_expire_date') ? 'is-invalid' : '' }}" type="text" name="license_expire_date" id="license_expire_date" value="{{ old('license_expire_date') }}" required>
                @if($errors->has('license_expire_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('license_expire_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.companyVehicle.fields.license_expire_date_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection