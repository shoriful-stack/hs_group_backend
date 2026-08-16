<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $save = User::query()
            ->updateOrCreate([
                'email' => 'admin@gmail.com',
            ],[
                'name' => 'HS Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'branch_id' => 1,
                'role_id' => 1,
            ]);

        // $role = Role::find(1);
        // $save->assignRole($role);
    }
}
