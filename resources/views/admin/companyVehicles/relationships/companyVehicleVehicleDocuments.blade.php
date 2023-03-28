@can('vehicle_document_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.vehicle-documents.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.vehicleDocument.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.vehicleDocument.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-companyVehicleVehicleDocuments">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.company_vehicle') }}
                        </th>
                        <th>
                            {{ trans('cruds.vehicleDocument.fields.vehicle_document_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicleDocuments as $key => $vehicleDocument)
                        <tr data-entry-id="{{ $vehicleDocument->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $vehicleDocument->id ?? '' }}
                            </td>
                            <td>
                                {{ $vehicleDocument->company->company_name ?? '' }}
                            </td>
                            <td>
                                {{ $vehicleDocument->company_vehicle->registration_number ?? '' }}
                            </td>
                            <td>
                                {{ $vehicleDocument->vehicle_document_type->name ?? '' }}
                            </td>
                            <td>
                                @can('vehicle_document_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.vehicle-documents.show', $vehicleDocument->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('vehicle_document_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.vehicle-documents.edit', $vehicleDocument->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('vehicle_document_delete')
                                    <form action="{{ route('admin.vehicle-documents.destroy', $vehicleDocument->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('vehicle_document_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.vehicle-documents.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 3, 'asc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-companyVehicleVehicleDocuments:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection