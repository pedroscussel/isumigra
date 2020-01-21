<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class City extends Model
{
    use Searchname;
    use Sortable;
    public $timestamps = false;

    public $sortable = ['id', 'name', 'state_id'];

    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }
}
