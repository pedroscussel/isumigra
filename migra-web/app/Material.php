<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Company;

class Material extends Model
{
    use Uuids, Searchname, Sortable, SoftDeletes;
    public $sortable = ['name'];
    protected $fillable = ['name'];

    public $incrementing = false;

    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault();
    }
}
