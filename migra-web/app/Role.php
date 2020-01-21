<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'slug', 'permissions'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    
    public function hasAllAccess(array $permissions) : bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    public function hasAccess(array $permissions) : bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    private function hasPermission(string $permission) : bool
    {
        return $this->permissions[$permission] ?? false;
    }
    
    
    public function scopeRootAdminPermission($query)
    {
        return $query->whereJsonContains('permissions->admin', true)
                ->whereJsonContains('permissions->migra', true);
    }
    
    public function scopeRootPermission($query, $permission)
    {
        return $query->whereJsonContains('permissions->migra', true)
                ->whereJsonContains("permissions->$permission", true);
    }
 
    public function scopeAdminPermission($query)
    {
        return $query->whereJsonContains('permissions->admin', true)
                ->whereJsonContains('permissions->migra', false);
    }
       
    public function scopeNoAdminPermission($query)
    {
        return $query->whereJsonContains('permissions->admin', false)
                ->whereJsonContains('permissions->migra', false);
    }
        
    public function scopePermission($query, $permission)
    {
        return $query->whereJsonContains('permissions->migra', false)
                ->whereJsonContains("permissions->$permission", true);
    }
    
    /**
     * Filtra regras de acordo com as permissões do usuário.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeListUserPermission($query, $user)
    {
        
        if ($user->hasAllAccess(['admin', 'migra'])) {
            return $query;
        } else if ($user->hasAllAccess(['migra'])) {
            return $query->whereJsonContains('permissions->admin', false)
                    ->whereJsonContains('permissions->migra', true)
                    ->orWhereJsonContains('permissions->migra', false);
        } else if ($user->hasAllAccess(['admin'])) {
            return $query->whereJsonContains('permissions->admin', false)
                    ->whereJsonContains('permissions->migra', false)
                    ->orWhereJsonContains('permissions->admin', true)
                    ->whereJsonContains('permissions->migra', false);
        } else if ($user->hasAllAccess(['operator'])) {
            return $query->whereJsonContains('permissions->admin', false)
                    ->whereJsonContains('permissions->migra', false);
        }
        
        foreach ($user->roles as $r) {
            foreach ($r->permissions as $k => $p) {
                $query->whereJsonContains("permissions->$k", $p);
            }
        }
        
        return $query;
    }
}
