@extends('layouts.admin')
@section('content')
@can('expense_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.expenses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.expense.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.expense.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Expense">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.expense.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.expense.fields.department') }}
                    </th>
                    <th>
                        {{ trans('cruds.expense.fields.company') }}
                    </th>
                    <th>
                        {{ trans('cruds.expense.fields.company_vehicle') }}
                    </th>
                    <th>
                        {{ trans('cruds.companyVehicle.fields.plate_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.expense.fields.entry_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.expense.fields.amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.expense.fields.description') }}
                    </th>
                    <th>
                        {{ trans('cruds.expense.fields.payment_status') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('expense_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.expenses.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.expenses.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'department_name', name: 'department.name' },
{ data: 'company_company_name', name: 'company.company_name' },
{ data: 'company_vehicle_registration_number', name: 'company_vehicle.registration_number' },
{ data: 'company_vehicle.plate_number', name: 'company_vehicle.plate_number' },
{ data: 'entry_date', name: 'entry_date' },
{ data: 'amount', name: 'amount' },
{ data: 'description', name: 'description' },
{ data: 'payment_status', name: 'payment_status' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 6, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-Expense').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection