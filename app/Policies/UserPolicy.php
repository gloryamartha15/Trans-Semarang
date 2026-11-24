<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Memeriksa apakah pengguna adalah Super Admin.
     */
    private function isSuperAdmin(User $authUser): bool
    {
        return $authUser->role === 'super_admin';
    }

    /**
     * Memeriksa apakah akun target boleh dikelola.
     */
    private function canManageTarget(User $authUser, User $target): bool
    {
        if ($this->isSuperAdmin($authUser)) {
            return true;
        }

        return $authUser->role === 'admin'
            && in_array($target->role, ['pengguna', 'petugas'], true);
    }

    public function viewAny(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            || $authUser->can('ViewAny:User');
    }

    public function view(User $authUser, User $user): bool
    {
        return $this->canManageTarget($authUser, $user)
            && ($this->isSuperAdmin($authUser) || $authUser->can('View:User'));
    }

    public function create(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            || $authUser->can('Create:User');
    }

    public function update(User $authUser, User $user): bool
    {
        return $this->canManageTarget($authUser, $user)
            && ($this->isSuperAdmin($authUser) || $authUser->can('Update:User'));
    }

    public function delete(User $authUser, User $user): bool
    {
        return $this->canManageTarget($authUser, $user)
            && ($this->isSuperAdmin($authUser) || $authUser->can('Delete:User'));
    }

    public function deleteAny(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            && $authUser->can('DeleteAny:User');
    }

    public function restore(User $authUser, User $user): bool
    {
        return $this->canManageTarget($authUser, $user)
            && ($this->isSuperAdmin($authUser) || $authUser->can('Restore:User'));
    }

    public function forceDelete(User $authUser, User $user): bool
    {
        return $this->canManageTarget($authUser, $user)
            && ($this->isSuperAdmin($authUser) || $authUser->can('ForceDelete:User'));
    }

    public function forceDeleteAny(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            && $authUser->can('ForceDeleteAny:User');
    }

    public function restoreAny(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            && $authUser->can('RestoreAny:User');
    }

    public function replicate(User $authUser, User $user): bool
    {
        return $this->canManageTarget($authUser, $user)
            && ($this->isSuperAdmin($authUser) || $authUser->can('Replicate:User'));
    }

    public function reorder(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            && $authUser->can('Reorder:User');
    }
}
