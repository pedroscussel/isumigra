<?php

namespace App\Policies;

use App\User;
use App\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function view(User $user, Company $company)
    {
        if ($user->can('migra')) {
            return true;
        }

        return ($user->company_id === $company->owner_id ||
                $user->company_id === $company->id);
    }

    /**
     * Determine whether the user can create companies.
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
     * Determine whether the user can update the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        if ($user->can(['migra_operator'])) {
            return true;
        } else if ($user->can('admin')) {
            return $user->company->id == $company->owner_id || $user->company->id == $company->id;
        } else if ($user->can('operator')) {
            //return $user->company->id == $company->owner_id; //TODO: verificar isso, pois com a de baixo passa no PHPunit
            return $user->company->id == $company->owner_id || $user->company->id == $company->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function delete(User $user, Company $company)
    {
        if ($user->can('migra_operator')) {
            return true;
        } else if ($user->can('operator')) {
            return ($user->company_id === $company->owner_id);
        }

        return false;
    }

    /**
     * Determine whether the user can restore the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function restore(User $user, Company $company)
    {
        if ($user->can('root')) {
            return true;
        } else if ($user->can('admin')) {
            return ($user->company_id === $company->owner_id);
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function forceDelete(User $user, Company $company)
    {
        if ($user->can('root')) {
            return true;
        } else if ($user->can('admin')) {
            return ($user->company_id === $company->owner_id);
        }

        return false;
    }
}
