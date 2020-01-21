<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use Notifiable;
    use Uuids;
    use Sortable;
    use Searchname;

    public $incrementing = false;

    public $sortable = ['id', 'name','email', 'company.name'];

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    public function hasAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        foreach ($this->roles as $role) {
            if ($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    public function hasAllAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        
        foreach ($this->roles as $role) {
            if (!$role->hasAllAccess($permissions)) {
                return false;
            }
        }
        
        return true;
    }
    
    public function scopeOnlyCompany($query, $company_id)
    {
        return $query->where('company_id', $company_id)
                ->orWhereHas('company', function ($query) use ($company_id) {
                    $query->where('owner_id', $company_id);
                });
    }
    
    public function getRoles()
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $k => $p) {
                $permissions[$k] = $p;
            }
        }
        return $permission;
    }
}
