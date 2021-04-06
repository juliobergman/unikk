<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Chart;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChartPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chart  $chart
     * @return mixed
     */
    public function view(User $user, Chart $chart)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chart  $chart
     * @return mixed
     */
    public function update(User $user, Chart $chart)
    {
        return $user->id === $chart->user_id
                ? Response::allow()
                : Response::deny('Permission to delete Chart Denied');

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chart  $chart
     * @return mixed
     */
    public function delete(User $user, Chart $chart)
    {
        return $user->id === $chart->user_id
                ? Response::allow()
                : Response::deny('Permission to delete Chart Denied');

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chart  $chart
     * @return mixed
     */
    public function restore(User $user, Chart $chart)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chart  $chart
     * @return mixed
     */
    public function forceDelete(User $user, Chart $chart)
    {
        //
    }
}
