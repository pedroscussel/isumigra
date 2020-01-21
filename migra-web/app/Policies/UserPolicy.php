<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        $company = $model->company;

        return ($user->id === $model->id) || ($company->id == $user->company_id || $company->owner_id == $user->company_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can(['admin'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        $company = $model->company;

        if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('operator')) {
            return ($company->id == $user->company_id || $company->owner_id == $user->company_id);
        }
        /*
        if ($user->can('migra_operator') && $model->can(['root'])) {
            return false;
        } else if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('operator') && $model->can('admin')) {
            return false;
        } else if ($user->can('operator')) {
            return ($company->id == $user->company_id || $company->owner_id == $user->company_id);
        }
        */
        return ($user->id === $model->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        $company = $model->company;
        if ($user->can(['root'])) {
            return true;
        } else if (!$user->can('admin')) {
            return false;
        }

        return ($user->id != $model->id) || ($company->id == $user->company_id || $company->owner_id == $user->company_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        $company = $model->company;
        if ($user->can(['root'])) {
            return true;
        } else if (!$user->can('admin')) {
            return false;
        }

        return ($user->id != $model->id) || ($company->id == $user->company_id || $company->owner_id == $user->company_id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return false;
    }
}
