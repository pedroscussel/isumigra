<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateInterval;

class ServiceOrder extends Model
{
    use Uuids;
    use Sortable;
    public $incrementing = false;
    public $sortable = ['num_service', 'company.name', 'owner.name','created_at'];

    public function scopeSearch($q)
    {
        return empty(request()->search) ? $q : $q->where('num_service', 'LIKE', '%' . request()->search .'%');
    }

    public function addressSrc()
    {
            return $this->belongsTo(Address::class, 'address_src_id');
    }

    public function addressDes()
    {
        return $this->belongsTo(Address::class, 'address_des_id');
    }

    public function containerType()
    {
        return $this->belongsTo(ContainerType::class);
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function owner()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function daysSinceCreated()
    {
        $created_at = new DateTime($this->created_at);
        $now = new DateTime('now');
        $days_old = $created_at->diff($now);
        return $days_old->format('%a').' '.__('messages.days');
    }

    public function scopeOld($query)
    {
        $date = new DateTime('now');
        $date->sub(new DateInterval('P30D'));
        return $query->whereDate('created_at', '<', $date);
    }

    public function scopeOnlyCompany($query, $company_id)
    {
        return $query->where('owner_id', $company_id);
    }
}
