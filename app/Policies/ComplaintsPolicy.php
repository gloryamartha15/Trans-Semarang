<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Complaints;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplaintsPolicy
{
    use HandlesAuthorization;

    private function isSuperAdmin(User $user): bool
    {
        return $user->role === 'super_admin';
    }

    private function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function viewAny(User $user): bool
    {
        return $this->isSuperAdmin($user)
            || $user->can('ViewAny:Complaints');
    }

    public function view(User $user, Complaints $complaints): bool
    {
        return $this->isSuperAdmin($user)
            || $user->can('View:Complaints');
    }

    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user)
            || $user->can('Create:Complaints');
    }

    public function update(User $user, Complaints $complaints): bool
    {
        return $this->isSuperAdmin($user)
            || (
                $this->isAdmin($user)
                && $user->can('Update:Complaints')
            );
    }

    public function delete(User $user, Complaints $complaints): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, Complaints $complaints): bool
    {
        return false;
    }

    public function forceDelete(User $user, Complaints $complaints): bool
    {
        return false;
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }

    public function restoreAny(User $user): bool
    {
        return false;
    }

    public function replicate(User $user, Complaints $complaints): bool
    {
        return false;
    }

    public function reorder(User $user): bool
    {
        return false;
    }
}
