<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyVehicleDocumentRequest;
use App\Http\Requests\StoreVehicleDocumentRequest;
use App\Http\Requests\UpdateVehicleDocumentRequest;
use App\Models\Company;
use App\Models\CompanyVehicle;
use App\Models\VehicleDocument;
use App\Models\VehicleDocumentType;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VehicleDocumentController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('vehicle_document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VehicleDocument::with(['company', 'company_vehicle', 'vehicle_document_type', 'created_by'])->select(sprintf('%s.*', (new VehicleDocument)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vehicle_document_show';
                $editGate      = 'vehicle_document_edit';
                $deleteGate    = 'vehicle_document_delete';
                $crudRoutePart = 'vehicle-documents';

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
            $table->addColumn('company_company_name', function ($row) {
                return $row->company ? $row->company->company_name : '';
            });

            $table->addColumn('company_vehicle_registration_number', function ($row) {
                return $row->company_vehicle ? $row->company_vehicle->registration_number : '';
            });

            $table->addColumn('vehicle_document_type_name', function ($row) {
                return $row->vehicle_document_type ? $row->vehicle_document_type->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'company', 'company_vehicle', 'vehicle_document_type']);

            return $table->make(true);
        }

        return view('admin.vehicleDocuments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('vehicle_document_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $company_vehicles = CompanyVehicle::pluck('registration_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_document_types = VehicleDocumentType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.vehicleDocuments.create', compact('companies', 'company_vehicles', 'vehicle_document_types'));
    }

    public function store(StoreVehicleDocumentRequest $request)
    {
        $vehicleDocument = VehicleDocument::create($request->all());

        foreach ($request->input('attachment', []) as $file) {
            $vehicleDocument->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachment');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $vehicleDocument->id]);
        }

        return redirect()->route('admin.vehicle-documents.index');
    }

    public function edit(VehicleDocument $vehicleDocument)
    {
        abort_if(Gate::denies('vehicle_document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $company_vehicles = CompanyVehicle::pluck('registration_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicle_document_types = VehicleDocumentType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vehicleDocument->load('company', 'company_vehicle', 'vehicle_document_type', 'created_by');

        return view('admin.vehicleDocuments.edit', compact('companies', 'company_vehicles', 'vehicleDocument', 'vehicle_document_types'));
    }

    public function update(UpdateVehicleDocumentRequest $request, VehicleDocument $vehicleDocument)
    {
        $vehicleDocument->update($request->all());

        if (count($vehicleDocument->attachment) > 0) {
            foreach ($vehicleDocument->attachment as $media) {
                if (! in_array($media->file_name, $request->input('attachment', []))) {
                    $media->delete();
                }
            }
        }
        $media = $vehicleDocument->attachment->pluck('file_name')->toArray();
        foreach ($request->input('attachment', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $vehicleDocument->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachment');
            }
        }

        return redirect()->route('admin.vehicle-documents.index');
    }

    public function show(VehicleDocument $vehicleDocument)
    {
        abort_if(Gate::denies('vehicle_document_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleDocument->load('company', 'company_vehicle', 'vehicle_document_type', 'created_by');

        return view('admin.vehicleDocuments.show', compact('vehicleDocument'));
    }

    public function destroy(VehicleDocument $vehicleDocument)
    {
        abort_if(Gate::denies('vehicle_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleDocument->delete();

        return back();
    }

    public function massDestroy(MassDestroyVehicleDocumentRequest $request)
    {
        $vehicleDocuments = VehicleDocument::find(request('ids'));

        foreach ($vehicleDocuments as $vehicleDocument) {
            $vehicleDocument->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('vehicle_document_create') && Gate::denies('vehicle_document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new VehicleDocument();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
