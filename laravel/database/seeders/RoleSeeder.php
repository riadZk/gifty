<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin',   'label' => 'Administrator', 'description' => 'Full access to all features.'],
            ['name' => 'manager', 'label' => 'Manager',       'description' => 'Can manage clients and requests.'],
            ['name' => 'viewer',  'label' => 'Viewer',        'description' => 'Read-only access.'],
        ];

        foreach ($roles as $data) {
            Role::firstOrCreate(['name' => $data['name']], $data);
        }

        // // Assign admin role to user ID 1
        // $user = User::find(1);
        // if ($user) {
        //     $adminRole = Role::where('name', 'admin')->first();
        //     $user->roles()->syncWithoutDetaching([$adminRole->id]);
        // }
    }
}
