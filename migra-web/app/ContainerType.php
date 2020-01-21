<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ContainerType extends Model
{
    use Uuids;
    use Searchname, Sortable;
    public $incrementing = false;
    public $sortable = ['name', 'company.name'];
    
    protected $attributes = [
        'width' => 0.0,
        'length' => 0.0,
        'height' => 0.0
    ];

    public function containers()
    {
        return $this->hasMany(Container::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeOnlyCompany($query, $company_id)
    {
        return $query->where('company_id', $company_id);
    }
    
    public function getSizeAttribute()
    {
        return sprintf(
            "%s m x %s m x %s m",
            number_format($this->attributes['width'], 2, ",", ""),
            number_format($this->attributes['length'], 2, ",", ""),
            number_format($this->attributes['height'], 2, ",", "")
        );
    }
    
    public function setWidthAttribute($value)
    {
        $this->attributes['width'] = str_replace(',', '.', $value);
    }
    
    public function getWidthAttribute()
    {
        return number_format((float) $this->attributes['width'], 2, ",", "");
    }
    
    public function setLengthAttribute($value)
    {
        $this->attributes['length'] = str_replace(',', '.', $value);
    }
    
    public function getLengthAttribute()
    {
        return number_format((float) $this->attributes['length'], 2, ",", "");
    }
    
    public function setHeightAttribute($value)
    {
        $this->attributes['height'] = str_replace(',', '.', $value);
    }
    
    public function getHeightAttribute()
    {
        return number_format((float) $this->attributes['height'], 2, ",", "");
    }
    
    public function setBulkAttribute($value)
    {
        $this->attributes['bulk'] = str_replace(',', '.', $value);
    }
    
    public function getBulkAttribute()
    {
        return number_format((float) $this->attributes['bulk'], 2, ",", "");
    }
    
    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = str_replace(',', '.', $value);
    }
    
    public function getWeightAttribute()
    {
        return number_format((float) $this->attributes['weight'], 2, ",", "");
    }
    
    public function setCarryingCapacityAttribute($value)
    {
        $this->attributes['carrying_capacity'] = str_replace(',', '.', $value);
    }
    
    public function getCarryingCapacityAttribute()
    {
        return number_format((float) $this->attributes['carrying_capacity'], 2, ",", "");
    }
}
