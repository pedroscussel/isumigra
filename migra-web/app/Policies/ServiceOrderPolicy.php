<?php

namespace App\Policies;

use App\User;
use App\ServiceOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the service order.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceOrder  $serviceOrder
     * @return mixed
     */
    public function view(User $user, ServiceOrder $serviceOrder)
    {
        if ($user->can('migra')) {
            return true;
        }

        return ($user->company_id === $serviceOrder->owner_id ||
                $user->company_id === $serviceOrder->client_id);
    }

    /**
     * Determine whether the user can create service orders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('migra_operator')) {
            return true;
        }

        return ($user->can('operator'));
    }

    /**
     * Determine whether the user can update the service order.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceOrder  $serviceOrder
     * @return mixed
     */
    public function update(User $user, ServiceOrder $serviceOrder)
    {
        if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('operator')) {
            return ($user->company_id === $serviceOrder->owner_id);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the service order.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceOrder  $serviceOrder
     * @return mixed
     */
    public function delete(User $user, ServiceOrder $serviceOrder)
    {
        if ($serviceOrder->is_done) {
            return false;
        } else if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('operator')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the service order.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceOrder  $serviceOrder
     * @return mixed
     */
    public function restore(User $user, ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the service order.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceOrder  $serviceOrder
     * @return mixed
     */
    public function forceDelete(User $user, ServiceOrder $serviceOrder)
    {
        if ($serviceOrder->is_done) {
            return false;
        } else if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('operator') && $user->can('business')) {
            return true;
        }

        return false;
    }
}
