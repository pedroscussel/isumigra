<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kyslik\ColumnSortable\Sortable;
use Gate;

class Company extends Model
{
    use Uuids,Searchname,Sortable, SoftDeletes;
    public $incrementing = false;
    public $sortable = ['id', 'name','owner_id'];

    public function containers()
    {
        return $this->hasMany(Container::class);
    }

    public function devices()
    {
        return $this->hasManyThrough(Device::class, Container::class)
                ->orderBy('volume', 'desc');
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function getFullAddressAttribute()
    {
        $address = '';
        if ($this->address->street) {
            $address .= $this->address->street  . ', ';
        }
        if ($this->address->number) {
            $address .= $this->address->number  . ', ';
        }
        if ($this->address->complement) {
            $address .= $this->address->complement . ', ';
        }
        if ($this->address->city->name) {
            $address .= $this->address->city->name . ', ';
        }
        if ($this->address->state()->name) {
            $address .= $this->address->state()->name . ', ';
        }
        if ($this->address->country()->name) {
            $address .= $this->address->country()->name;
        }
            return $address;
    }

    public function type()
    {
        return $this->belongsTo(CompanyType::class, 'company_type_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(Company::class)->withDefault();
    }

    public function scopeOnlyCompany($query, $company_id)
    {
        return $query->where('id', $company_id)
                ->orWhere('owner_id', $company_id);
    }

    public function fullContainers()
    {
        return $this->devices()->full()->get();
    }

    public function halfFullContainers()
    {
        return $this->devices()->halfFull()->get();
    }

    public function emptyContainers()
    {
        return $this->devices()->empty()->get();
    }

    public function lowBatteryContainers()
    {
        return $this->devices()->lowBattery()->get();
    }

    public function allFullContainers()
    {
        if (Gate::allows('migra')) {
            return Container::full()->get();
        }
        return null;
    }

    public function allHalfFullContainers()
    {
        if (Gate::allows('migra')) {
            return Container::halfFull()->get();
        }
        return null;
    }

    public function allEmptyContainers()
    {
        if (Gate::allows('migra')) {
            return Container::empty()->get();
        }
        return null;
    }

    public function allLowBatteryContainers()
    {
        if (Gate::allows('migra')) {
            return Container::lowBattery()->get();
        }
        return null;
    }

    public function sumFullContainers()
    {
        return $this->containers()->full()->get()->sum('device.volume');
    }

    public function sumHalffFullContainers()
    {
        return $this->containers()->halfFull()->get()->sum('device.volume');
    }

    public function sumEmptyContainers()
    {
        return $this->containers()->empty()->get()->sum('device.volume');
    }

    public function sumLowBatteryContainers()
    {
        return $this->devices()->lowBattery()->get()->sum('device.bat');
    }

    public function countFullContainers()
    {
        return $this->containers()->full()->get()->count('device.volume');
    }

    public function countHalfFullContainers()
    {
        return $this->containers()->halfFull()->get()->count('device.volume');
    }

    public function countEmptyContainers()
    {
        return $this->containers()->empty()->get()->count('device.volume');
    }

    public function countLowBatteryContainers()
    {
        return $this->devices()->lowBattery()->get()->count('device.bat');
    }

    public function countAllContainers()
    {
        if (Gate::allows('migra')) {
            return Container::count();
        }
        return null;
    }

    public function countAllFullContainers()
    {
        if (Gate::allows('migra')) {
            return Container::full()->get()->count('device.volume');
        }
        return null;
    }

    public function countAllHalfFullContainers()
    {
        if (Gate::allows('migra')) {
            return Container::halfFull()->get()->count('device.volume');
        }
        return null;
    }

    public function countAllEmptyContainers()
    {
        if (Gate::allows('migra')) {
            return Container::empty()->get()->count('device.volume');
        }
        return null;
    }

    public function countAllLowBatteryContainers()
    {
        if (Gate::allows('migra')) {
            return Container::lowBattery()->get()->count('device.bat');
        }
        return null;
    }

    public function oldContainers()
    {
        return $this->containers()->old()->get();
    }

    public function countOldContainers()
    {
        return count($this->oldContainers());
    }

    public function countAllOldContainers()
    {
        if (Gate::allows('migra')) {
            return Container::old()->get()->count();
        }
        return null;
    }
}
