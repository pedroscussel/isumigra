<?php

namespace App\Policies;

use App\User;
use App\Truck;
use Illuminate\Auth\Access\HandlesAuthorization;

class TruckPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the truck.
     *
     * @param  \App\User  $user
     * @param  \App\Truck  $truck
     * @return mixed
     */
    public function view(User $user, Truck $truck)
    {
        if ($user->can(['migra'])) {
            return true;
        }

        return $user->company->id == $truck->company_id;
    }

    /**
     * Determine whether the user can create trucks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can(['operator'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the truck.
     *
     * @param  \App\User  $user
     * @param  \App\Truck  $truck
     * @return mixed
     */
    public function update(User $user, Truck $truck)
    {
        if ($user->can(['migra_operator'])) {
            return true;
        } else if ($user->can('operator')) {
            return $user->company_id == $truck->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the truck.
     *
     * @param  \App\User  $user
     * @param  \App\Truck  $truck
     * @return mixed
     */
    public function delete(User $user, Truck $truck)
    {
        if ($user->can(['admin'])) {
            return true;
        } else if ($user->can('admin')) {
            return $user->company_id == $truck->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the truck.
     *
     * @param  \App\User  $user
     * @param  \App\Truck  $truck
     * @return mixed
     */
    public function restore(User $user, Truck $truck)
    {
        if ($user->can(['root'])) {
            return true;
        } else if ($user->can(['admin'])) {
            return $user->company_id == $truck->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the truck.
     *
     * @param  \App\User  $user
     * @param  \App\Truck  $truck
     * @return mixed
     */
    public function forceDelete(User $user, Truck $truck)
    {
        if ($user->can(['root'])) {
            return true;
        } else if ($user->can(['admin'])) {
            return $user->company_id == $truck->company_id;
        }

        return false;
    }
}
