<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminPetugasRoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Membuat role jika belum tersedia.
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'admin',
        ]);

        $petugasRole = Role::firstOrCreate([
            'name' => 'petugas',
            'guard_name' => 'admin',
        ]);

        $penggunaRole = Role::firstOrCreate([
            'name' => 'pengguna',
            'guard_name' => 'admin',
        ]);

        // Permission khusus perubahan status aduan.
        Permission::firstOrCreate([
            'name' => 'Update:ComplaintStatus',
            'guard_name' => 'admin',
        ]);

        // Permission Admin.
        $adminPermissions = [
            'View:Dashboard',
            'View:ComplaintStats',
            'View:ComplaintLatestTable',
            'View:ComplaintCategoryChart',
            'View:ComplaintMonthlyChart',

            'Create:Buses', 'View:Buses', 'ViewAny:Buses',
            'Update:Buses', 'Delete:Buses', 'DeleteAny:Buses',

            'Create:Categories', 'View:Categories', 'ViewAny:Categories',
            'Update:Categories', 'Delete:Categories', 'DeleteAny:Categories',

            'Create:Routes', 'View:Routes', 'ViewAny:Routes',
            'Update:Routes', 'Delete:Routes', 'DeleteAny:Routes',

            'Create:Stops', 'View:Stops', 'ViewAny:Stops',
            'Update:Stops', 'Delete:Stops', 'DeleteAny:Stops',

            'Create:User', 'View:User', 'ViewAny:User',
            'Update:User', 'Delete:User', 'DeleteAny:User',

            'View:Complaints',
            'ViewAny:Complaints',
            'Update:Complaints',

            'Create:ComplaintsReplay',
            'View:ComplaintsReplay',
            'ViewAny:ComplaintsReplay',

            'Update:ComplaintStatus',
        ];

        // Permission Petugas.
        $petugasPermissions = [
            'View:Dashboard',
            'View:ComplaintStats',
            'View:ComplaintLatestTable',

            'View:Complaints',
            'ViewAny:Complaints',

            'Create:ComplaintsReplay',
            'View:ComplaintsReplay',
            'ViewAny:ComplaintsReplay',

            'Update:ComplaintStatus',
        ];

        // Membuat permission yang belum tersedia.
        $ensurePermissions = function (array $names) {
            return collect($names)->unique()->map(
                fn (string $name) => Permission::firstOrCreate([
                    'name' => $name,
                    'guard_name' => 'admin',
                ])
            );
        };

        // Sinkronisasi permission.
        $adminRole->syncPermissions(
            $ensurePermissions($adminPermissions)
        );

        $petugasRole->syncPermissions(
            $ensurePermissions($petugasPermissions)
        );

        // Sinkronisasi role berdasarkan users.role.
        User::where('role', 'admin')
            ->each(fn (User $user) => $user->syncRoles($adminRole));

        User::where('role', 'petugas')
            ->each(fn (User $user) => $user->syncRoles($petugasRole));

        User::where('role', 'pengguna')
            ->each(fn (User $user) => $user->syncRoles($penggunaRole));

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info(
            'Role Admin, Petugas, dan Pengguna berhasil dikonfigurasi.'
        );
    }
}
