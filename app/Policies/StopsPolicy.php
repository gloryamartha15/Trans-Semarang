<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Stops;
use Illuminate\Auth\Access\HandlesAuthorization;

class StopsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Stops');
    }

    public function view(AuthUser $authUser, Stops $stops): bool
    {
        return $authUser->can('View:Stops');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Stops');
    }

    public function update(AuthUser $authUser, Stops $stops): bool
    {
        return $authUser->can('Update:Stops');
    }

    public function delete(AuthUser $authUser, Stops $stops): bool
    {
        return $authUser->can('Delete:Stops');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Stops');
    }

    public function restore(AuthUser $authUser, Stops $stops): bool
    {
        return $authUser->can('Restore:Stops');
    }

    public function forceDelete(AuthUser $authUser, Stops $stops): bool
    {
        return $authUser->can('ForceDelete:Stops');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Stops');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Stops');
    }

    public function replicate(AuthUser $authUser, Stops $stops): bool
    {
        return $authUser->can('Replicate:Stops');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Stops');
    }

}