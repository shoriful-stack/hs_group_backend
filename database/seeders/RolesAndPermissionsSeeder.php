<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Admin role
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        // Assign all permissions to the Admin role
        // $adminRole->syncPermissions(Permission::all());
    }
}
