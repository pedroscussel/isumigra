<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{
    use Uuids, Sortable, SoftDeletes;

    public $incrementing = false;
    public $sortable = ['id', 'name','license_plate', 'is_defect', 'is_outofservice'];

    public function scopeSearch($q)
    {
        return empty(request()->search) ? $q : $q->where('license_plate', 'LIKE', '%' . request()->search .'%');
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeOnlyCompany($query, $company_id)
    {
        return $query->where('company_id', $company_id);
    }
}
