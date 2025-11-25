<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Recipe;
use App\Models\Role;
use App\Models\RolesToPermissions;
use App\Models\User;
use App\Models\UsersToRoles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('zaq12wsxCDE#3edcvfr4$RFVbgt5'),
        ]);

        $role = Role::create([
            'code' => 'super-user',
            'label' => 'Site Administrator',
        ]);

        UsersToRoles::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        Permission::create([
            'object' => Recipe::class,
            'action' => 'update',
            'label' => 'Update ' . Recipe::class,
        ]);

        Permission::create([
            'object' => Recipe::class,
            'action' => 'read',
            'label' => 'Read ' . Recipe::class,
        ]);

        Permission::create([
            'object' => Recipe::class,
            'action' => 'delete',
            'label' => 'Update ' . Recipe::class,
        ]);

        foreach (Permission::all() as $permission) {
            RolesToPermissions::create([
                'role_id' => $role->id,
                'permission_id' => $permission->id,
            ]);
        }
    }
}
