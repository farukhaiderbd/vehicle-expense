<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleDocumentType extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'vehicle_document_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function vehicleDocumentTypeVehicleDocuments()
    {
        return $this->hasMany(VehicleDocument::class, 'vehicle_document_type_id', 'id');
    }
}
