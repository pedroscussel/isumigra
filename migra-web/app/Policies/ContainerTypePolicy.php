<?php

namespace App\Policies;

use App\User;
use App\ContainerType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContainerTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the container type.
     *
     * @param  \App\User  $user
     * @param  \App\ContainerType  $containerType
     * @return mixed
     */
    public function view(User $user, ContainerType $containerType)
    {
        if ($user->can('migra')) {
            return true;
        }

        return ($user->company_id === $containerType->company_id && $containerType->company->company_id == null);
    }

    /**
     * Determine whether the user can create container types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, ContainerType $containerType)
    {
        if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('operator')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the container type.
     *
     * @param  \App\User  $user
     * @param  \App\ContainerType  $containerType
     * @return mixed
     */
    public function update(User $user, ContainerType $containerType)
    {
        if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('operator')) {
            return ($user->company_id === $containerType->company_id);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the container type.
     *
     * @param  \App\User  $user
     * @param  \App\ContainerType  $containerType
     * @return mixed
     */
    public function delete(User $user, ContainerType $containerType)
    {
        if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('admin')) {
            return ($user->company_id === $containerType->company_id);
        }

        return false;
    }

    /**
     * Determine whether the user can restore the container type.
     *
     * @param  \App\User  $user
     * @param  \App\ContainerType  $containerType
     * @return mixed
     */
    public function restore(User $user, ContainerType $containerType)
    {
        if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('admin')) {
            return ($user->company_id === $containerType->company_id);
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the container type.
     *
     * @param  \App\User  $user
     * @param  \App\ContainerType  $containerType
     * @return mixed
     */
    public function forceDelete(User $user, ContainerType $containerType)
    {
        if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('admin')) {
            return ($user->company_id === $containerType->company_id);
        }

        return false;
    }
}
