@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.vehicleDocument.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.vehicle-documents.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="company_id">{{ trans('cruds.vehicleDocument.fields.company') }}</label>
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
                <span class="help-block">{{ trans('cruds.vehicleDocument.fields.company_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="company_vehicle_id">{{ trans('cruds.vehicleDocument.fields.company_vehicle') }}</label>
                <select class="form-control select2 {{ $errors->has('company_vehicle') ? 'is-invalid' : '' }}" name="company_vehicle_id" id="company_vehicle_id" required>
                    @foreach($company_vehicles as $id => $entry)
                        <option value="{{ $id }}" {{ old('company_vehicle_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('company_vehicle'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company_vehicle') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleDocument.fields.company_vehicle_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.vehicleDocument.fields.note') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{!! old('note') !!}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleDocument.fields.note_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="attachment">{{ trans('cruds.vehicleDocument.fields.attachment') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachment') ? 'is-invalid' : '' }}" id="attachment-dropzone">
                </div>
                @if($errors->has('attachment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('attachment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleDocument.fields.attachment_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="vehicle_document_type_id">{{ trans('cruds.vehicleDocument.fields.vehicle_document_type') }}</label>
                <select class="form-control select2 {{ $errors->has('vehicle_document_type') ? 'is-invalid' : '' }}" name="vehicle_document_type_id" id="vehicle_document_type_id" required>
                    @foreach($vehicle_document_types as $id => $entry)
                        <option value="{{ $id }}" {{ old('vehicle_document_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('vehicle_document_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vehicle_document_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vehicleDocument.fields.vehicle_document_type_helper') }}</span>
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
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.vehicle-documents.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $vehicleDocument->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    var uploadedAttachmentMap = {}
Dropzone.options.attachmentDropzone = {
    url: '{{ route('admin.vehicle-documents.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="attachment[]" value="' + response.name + '">')
      uploadedAttachmentMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedAttachmentMap[file.name]
      }
      $('form').find('input[name="attachment[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($vehicleDocument) && $vehicleDocument->attachment)
          var files =
            {!! json_encode($vehicleDocument->attachment) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="attachment[]" value="' + file.file_name + '">')
            }
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