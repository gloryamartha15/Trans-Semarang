<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\ComplaintsReplay;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplaintsReplayPolicy
{
    use HandlesAuthorization;

    private function isSuperAdmin(User $user): bool
    {
        return $user->role === 'super_admin';
    }

    public function viewAny(User $user): bool
    {
        return $this->isSuperAdmin($user)
            || $user->can('ViewAny:ComplaintsReplay');
    }

    public function view(User $user, ComplaintsReplay $complaintsReplay): bool
    {
        return $this->isSuperAdmin($user)
            || $user->can('View:ComplaintsReplay');
    }

    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user)
            || $user->can('Create:ComplaintsReplay');
    }

    public function update(User $user, ComplaintsReplay $complaintsReplay): bool
    {
        return false;
    }

    public function delete(User $user, ComplaintsReplay $complaintsReplay): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, ComplaintsReplay $complaintsReplay): bool
    {
        return false;
    }

    public function forceDelete(User $user, ComplaintsReplay $complaintsReplay): bool
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

    public function replicate(User $user, ComplaintsReplay $complaintsReplay): bool
    {
        return false;
    }

    public function reorder(User $user): bool
    {
        return false;
    }
}
