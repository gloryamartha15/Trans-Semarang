<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    private function isSuperAdmin(User $authUser): bool
    {
        return $authUser->role === 'super_admin';
    }

    private function isProtectedRole(Role $role): bool
    {
        return $role->name === 'super_admin';
    }

    public function viewAny(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            && $authUser->can('ViewAny:Role');
    }

    public function view(User $authUser, Role $role): bool
    {
        return $this->isSuperAdmin($authUser)
            && $authUser->can('View:Role');
    }

    public function create(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            && $authUser->can('Create:Role');
    }

    public function update(User $authUser, Role $role): bool
    {
        return $this->isSuperAdmin($authUser)
            && ! $this->isProtectedRole($role)
            && $authUser->can('Update:Role');
    }

    public function delete(User $authUser, Role $role): bool
    {
        return $this->isSuperAdmin($authUser)
            && ! $this->isProtectedRole($role)
            && $authUser->can('Delete:Role');
    }

    public function deleteAny(User $authUser): bool
    {
        return false;
    }

    public function restore(User $authUser, Role $role): bool
    {
        return $this->isSuperAdmin($authUser)
            && ! $this->isProtectedRole($role)
            && $authUser->can('Restore:Role');
    }

    public function forceDelete(User $authUser, Role $role): bool
    {
        return $this->isSuperAdmin($authUser)
            && ! $this->isProtectedRole($role)
            && $authUser->can('ForceDelete:Role');
    }

    public function forceDeleteAny(User $authUser): bool
    {
        return false;
    }

    public function restoreAny(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            && $authUser->can('RestoreAny:Role');
    }

    public function replicate(User $authUser, Role $role): bool
    {
        return $this->isSuperAdmin($authUser)
            && ! $this->isProtectedRole($role)
            && $authUser->can('Replicate:Role');
    }

    public function reorder(User $authUser): bool
    {
        return $this->isSuperAdmin($authUser)
            && $authUser->can('Reorder:Role');
    }
}
