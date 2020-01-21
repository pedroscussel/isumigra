<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Gate;

class Container extends Model
{
    use Uuids, Sortable, SoftDeletes;

    public $incrementing = false;
    public $sortable = [
        'id',
        'serial',
        'name',
        'company.name',
        'device.volume',
        'activeServiceOrder.daysSinceCreate'
    ];

    protected $fillable = ['name', 'serial'];

    public function scopeSearch($q)
    {
        if (Gate::allows('migra')) {
            return empty(request()->search)
                ? $q
                : $q->where('serial', 'LIKE', '%' . request()->search . '%');
        } else {
            return empty(request()->search)
                ? $q
                : $q->where('name', 'LIKE', '%' . request()->search . '%');
        }
    }

    public function getStatusAttribute()
    {
        return $this->device->status;
    }

    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault();
    }

    public function companyService()
    {
        return $this->belongsTo(Company::class)->withDefault();
    }

    public function serviceOrder()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function activeServiceOrder()
    {
        return $this->belongsTo(
            ServiceOrder::class,
            'service_order_id'
        )->withDefault();
    }

    public function type()
    {
        return $this->belongsTo(
            ContainerType::class,
            'container_type_id'
        )->withDefault();
    }

    public function originalType()
    {
        return $this->belongsTo(
            ContainerType::class,
            'original_container_type_id'
        )->withDefault();
    }

    public function device()
    {
        return $this->belongsTo(Device::class)->withDefault();
    }

    public function scopeFull($query)
    {
        return $query->whereHas('device', function ($query) {
            $query->full();
        });
    }

    public function scopeHalfFull($query)
    {
        return $query->whereHas('device', function ($query) {
            $query->halfFull();
        });
    }

    public function scopeEmpty($query)
    {
        return $query->whereHas('device', function ($query) {
            $query->empty();
        });
    }

    public function scopeLowBattery($query)
    {
        return $query->whereHas('device', function ($query) {
            $query->lowBattery();
        });
    }

    public function scopeOnlyCompany($query, $company_id)
    {
        return $query->where('company_id', $company_id);
    }

    public function scopeOld($query)
    {
        return $query->whereHas('activeServiceOrder', function ($query) {
            $query->old();
        });
    }
}
