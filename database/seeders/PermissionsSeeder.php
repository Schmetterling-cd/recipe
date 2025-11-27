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
        $user = User::firstOrCreate([
            'name' => 'Super Admin',
            'email' => env('ADMIN_EMAIL'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);

        $role = Role::firstOrCreate([
            'code' => 'super-user',
            'label' => 'Site Administrator',
        ]);

        UsersToRoles::firstOrCreate([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        Permission::firstOrCreate([
            'object' => Recipe::class,
            'action' => 'update',
            'label' => 'Update ' . Recipe::class,
        ]);

        Permission::firstOrCreate([
            'object' => Recipe::class,
            'action' => 'read',
            'label' => 'Read ' . Recipe::class,
        ]);

        Permission::firstOrCreate([
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
