<?php

namespace App\Policies;

use App\User;
use App\Material;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;

    
    /**
     * Determine whether the user can view the material.
     *
     * @param  \App\User  $user
     * @param  \App\Material  $material
     * @return mixed
     */
    public function view(User $user, Material $material)
    {
        if ($user->can(['migra'])) {
            return true;
        }
        
        return $user->company->id == $material->company_id;
    }

    /**
     * Determine whether the user can create materials.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('operator')) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can update the material.
     *
     * @param  \App\User  $user
     * @param  \App\Material  $material
     * @return mixed
     */
    public function update(User $user, Material $material)
    {
        if ($user->can(['migra_operator'])) {
            return true;
        } else if ($user->can('operator')) {
            return $user->company->id == $material->company_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the material.
     *
     * @param  \App\User  $user
     * @param  \App\Material  $material
     * @return mixed
     */
    public function delete(User $user, Material $material)
    {
        if ($user->can(['migra_operator'])) {
            return true;
        } else if ($user->can('operator')) {
            return $user->company->id == $material->company_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the material.
     *
     * @param  \App\User  $user
     * @param  \App\Material  $material
     * @return mixed
     */
    public function restore(User $user, Material $material)
    {
        if ($user->can(['root'])) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can permanently delete the material.
     *
     * @param  \App\User  $user
     * @param  \App\Material  $material
     * @return mixed
     */
    public function forceDelete(User $user, Material $material)
    {
        if ($user->can(['root'])) {
            return true;
        } else if ($user->can(['admin'])) {
            return ($user->company->id == $material->company_id);
        }
        
        return false;
    }
}
