<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExpenseRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Company;
use App\Models\CompanyVehicle;
use App\Models\Department;
use App\Models\Expense;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Expense::with(['department', 'company', 'company_vehicle', 'created_by'])->select(sprintf('%s.*', (new Expense)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'expense_show';
                $editGate      = 'expense_edit';
                $deleteGate    = 'expense_delete';
                $crudRoutePart = 'expenses';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('department_name', function ($row) {
                return $row->department ? $row->department->name : '';
            });

            $table->addColumn('company_company_name', function ($row) {
                return $row->company ? $row->company->company_name : '';
            });

            $table->addColumn('company_vehicle_registration_number', function ($row) {
                return $row->company_vehicle ? $row->company_vehicle->registration_number : '';
            });

            $table->editColumn('company_vehicle.plate_number', function ($row) {
                return $row->company_vehicle ? (is_string($row->company_vehicle) ? $row->company_vehicle : $row->company_vehicle->plate_number) : '';
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('payment_status', function ($row) {
                return $row->payment_status ? Expense::PAYMENT_STATUS_RADIO[$row->payment_status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'department', 'company', 'company_vehicle']);

            return $table->make(true);
        }

        return view('admin.expenses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('expense_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = Company::pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $company_vehicles = CompanyVehicle::pluck('registration_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.expenses.create', compact('companies', 'company_vehicles', 'departments'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->all());

        return redirect()->route('admin.expenses.index');
    }

    public function edit(Expense $expense)
    {
        abort_if(Gate::denies('expense_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = Company::pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $company_vehicles = CompanyVehicle::pluck('registration_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $expense->load('department', 'company', 'company_vehicle', 'created_by');

        return view('admin.expenses.edit', compact('companies', 'company_vehicles', 'departments', 'expense'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->all());

        return redirect()->route('admin.expenses.index');
    }

    public function show(Expense $expense)
    {
        abort_if(Gate::denies('expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->load('department', 'company', 'company_vehicle', 'created_by');

        return view('admin.expenses.show', compact('expense'));
    }

    public function destroy(Expense $expense)
    {
        abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->delete();

        return back();
    }

    public function massDestroy(MassDestroyExpenseRequest $request)
    {
        $expenses = Expense::find(request('ids'));

        foreach ($expenses as $expense) {
            $expense->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
