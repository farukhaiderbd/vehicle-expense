@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.company.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.companies.update", [$company->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="company_name">{{ trans('cruds.company.fields.company_name') }}</label>
                <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', $company->company_name) }}" required>
                @if($errors->has('company_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.company.fields.company_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="company_logo">{{ trans('cruds.company.fields.company_logo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('company_logo') ? 'is-invalid' : '' }}" id="company_logo-dropzone">
                </div>
                @if($errors->has('company_logo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company_logo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.company.fields.company_logo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="company_email">{{ trans('cruds.company.fields.company_email') }}</label>
                <input class="form-control {{ $errors->has('company_email') ? 'is-invalid' : '' }}" type="email" name="company_email" id="company_email" value="{{ old('company_email', $company->company_email) }}">
                @if($errors->has('company_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.company.fields.company_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="company_phone">{{ trans('cruds.company.fields.company_phone') }}</label>
                <input class="form-control {{ $errors->has('company_phone') ? 'is-invalid' : '' }}" type="text" name="company_phone" id="company_phone" value="{{ old('company_phone', $company->company_phone) }}">
                @if($errors->has('company_phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company_phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.company.fields.company_phone_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.companyLogoDropzone = {
    url: '{{ route('admin.companies.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="company_logo"]').remove()
      $('form').append('<input type="hidden" name="company_logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="company_logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($company) && $company->company_logo)
      var file = {!! json_encode($company->company_logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="company_logo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection