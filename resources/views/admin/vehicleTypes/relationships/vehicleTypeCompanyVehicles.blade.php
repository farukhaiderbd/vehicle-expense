@can('company_vehicle_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.company-vehicles.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.companyVehicle.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.companyVehicle.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-vehicleTypeCompanyVehicles">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.department') }}
                        </th>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.vehicle_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.registration_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.plate_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.license_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.companyVehicle.fields.license_expire_date') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companyVehicles as $key => $companyVehicle)
                        <tr data-entry-id="{{ $companyVehicle->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $companyVehicle->id ?? '' }}
                            </td>
                            <td>
                                {{ $companyVehicle->company->company_name ?? '' }}
                            </td>
                            <td>
                                {{ $companyVehicle->department->name ?? '' }}
                            </td>
                            <td>
                                {{ $companyVehicle->vehicle_type->name ?? '' }}
                            </td>
                            <td>
                                {{ $companyVehicle->registration_number ?? '' }}
                            </td>
                            <td>
                                {{ $companyVehicle->plate_number ?? '' }}
                            </td>
                            <td>
                                {{ $companyVehicle->license_number ?? '' }}
                            </td>
                            <td>
                                {{ $companyVehicle->license_expire_date ?? '' }}
                            </td>
                            <td>
                                @can('company_vehicle_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.company-vehicles.show', $companyVehicle->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('company_vehicle_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.company-vehicles.edit', $companyVehicle->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('company_vehicle_delete')
                                    <form action="{{ route('admin.company-vehicles.destroy', $companyVehicle->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('company_vehicle_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.company-vehicles.massDestroy') }}",
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
    order: [[ 2, 'asc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-vehicleTypeCompanyVehicles:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection