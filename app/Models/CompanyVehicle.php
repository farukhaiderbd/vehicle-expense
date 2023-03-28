<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyVehicle extends Model
{
    use SoftDeletes, MultiTenantModelTrait, Auditable, HasFactory;

    public $table = 'company_vehicles';

    protected $dates = [
        'created_at',
        'license_issues_date',
        'license_expire_date',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'company_id',
        'department_id',
        'vehicle_type_id',
        'registration_number',
        'plate_number',
        'created_at',
        'license_number',
        'license_issues_date',
        'license_expire_date',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function companyVehicleVehicleDocuments()
    {
        return $this->hasMany(VehicleDocument::class, 'company_vehicle_id', 'id');
    }

    public function companyVehicleExpenses()
    {
        return $this->hasMany(Expense::class, 'company_vehicle_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function vehicle_type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function getLicenseIssuesDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setLicenseIssuesDateAttribute($value)
    {
        $this->attributes['license_issues_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getLicenseExpireDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setLicenseExpireDateAttribute($value)
    {
        $this->attributes['license_expire_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
