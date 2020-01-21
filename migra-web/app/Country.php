<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Country extends Model
{
    use Sortable;
    use Searchname;
    public $timestamps = false;

    public function states()
    {
        return $this->hasMany(State::class)->orderBy('name');
    }

    public function scopeGetDefault($query)
    {
        return $query->where('common', config('config.default_country'))->first();
    }

    public function scopeGetDefaultStates($query)
    {
        return $query->getDefault()->states();
    }
}
