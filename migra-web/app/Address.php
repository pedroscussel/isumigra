<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use Uuids;
    public $incrementing = false;
    public $timestamps = false;

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->city->state;
    }

    public function country()
    {
        return $this->city->state->country;
    }

    public function getFullAddressAttribute()
    {
        $address = '';
        if ($this->street) {
            $address .= $this->street  . ', ';
        }
        if ($this->number) {
            $address .= $this->number  . ', ';
        }
        if ($this->complement) {
            $address .= $this->complement . ', ';
        }
        if ($this->city->name) {
            $address .= $this->city->name . ', ';
        }
        if ($this->state()->name) {
            $address .= $this->state()->name . ', ';
        }
        if ($this->country()->name) {
            $address .= $this->country()->name;
        }
            return $address;
    }
}
