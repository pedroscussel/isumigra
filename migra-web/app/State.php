<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class State extends Model
{
    use Sortable;
    use Searchname;
    public $sortable = ['id', 'name', 'country_id'];
    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany('App\City');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}
