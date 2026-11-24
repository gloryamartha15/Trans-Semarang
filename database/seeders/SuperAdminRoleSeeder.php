<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class SuperAdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Membuat atau mengambil role Super Admin.
        $role = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'admin',
        ]);

        // Mengambil seluruh permission untuk guard admin.
        $permissions = Permission::where('guard_name', 'admin')->get();

        // Memberikan seluruh permission kepada Super Admin.
        $role->syncPermissions($permissions);

        // Sinkronisasi akun berdasarkan users.role.
        User::where('role', 'super_admin')
            ->each(fn (User $user) => $user->syncRoles($role));

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info(
            'Super Admin berhasil mendapatkan ' .
            $permissions->count() .
            ' permissions.'
        );
    }
}
