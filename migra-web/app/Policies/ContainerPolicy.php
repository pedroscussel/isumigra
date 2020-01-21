<?php

namespace App\Policies;

use App\User;
use App\Container;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContainerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the container.
     *
     * @param  \App\User  $user
     * @param  \App\Container  $container
     * @return mixed
     */
    public function view(User $user, Container $container)
    {
        if ($user->can(['migra'])) {
            return true;
        }
        
        return $user->company->id == $container->company_id;
    }

    /**
     * Determine whether the user can create containers.
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
     * Determine whether the user can update the container.
     *
     * @param  \App\User  $user
     * @param  \App\Container  $container
     * @return mixed
     */
    public function update(User $user, Container $container)
    {
        if ($user->can(['migra_operator'])) {
            return true;
        } else if ($user->can('operator')) {
            return $user->company->id == $container->company_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the container.
     *
     * @param  \App\User  $user
     * @param  \App\Container  $container
     * @return mixed
     */
    public function delete(User $user, Container $container)
    {
        if ($user->can(['migra_operator'])) {
            return true;
        } else if ($user->can('operator')) {
            return $user->company->id == $container->company_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the container.
     *
     * @param  \App\User  $user
     * @param  \App\Container  $container
     * @return mixed
     */
    public function restore(User $user, Container $container)
    {
        if ($user->can(['root'])) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can permanently delete the container.
     *
     * @param  \App\User  $user
     * @param  \App\Container  $container
     * @return mixed
     */
    public function forceDelete(User $user, Container $container)
    {
        if ($user->can(['root'])) {
            return true;
        } else if ($user->can(['admin'])) {
            return ($user->company->id == $container->company_id && is_null($container->original_container_type_id));
        }
        
        return false;
    }
}
