<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
