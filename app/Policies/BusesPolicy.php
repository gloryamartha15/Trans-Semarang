<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Buses;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusesPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Buses');
    }

    public function view(AuthUser $authUser, Buses $buses): bool
    {
        return $authUser->can('View:Buses');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Buses');
    }

    public function update(AuthUser $authUser, Buses $buses): bool
    {
        return $authUser->can('Update:Buses');
    }

    public function delete(AuthUser $authUser, Buses $buses): bool
    {
        return $authUser->can('Delete:Buses');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Buses');
    }

    public function restore(AuthUser $authUser, Buses $buses): bool
    {
        return $authUser->can('Restore:Buses');
    }

    public function forceDelete(AuthUser $authUser, Buses $buses): bool
    {
        return $authUser->can('ForceDelete:Buses');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Buses');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Buses');
    }

    public function replicate(AuthUser $authUser, Buses $buses): bool
    {
        return $authUser->can('Replicate:Buses');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Buses');
    }

}