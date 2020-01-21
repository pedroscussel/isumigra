<?php

namespace App\Policies;

use App\User;
use App\Device;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function view(User $user, Device $device)
    {
        if ($user->can(['migra'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create devices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can(['migra_operator'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function update(User $user, Device $device)
    {
        if ($user->can(['migra_operator'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function delete(User $user, Device $device)
    {
        if ($user->can(['migra_operator'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function restore(User $user, Device $device)
    {
        if ($user->can(['root'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function forceDelete(User $user, Device $device)
    {
        if ($user->can(['root'])) {
            return true;
        }

        return false;
    }
}
