<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Full system access with all permissions',
                'is_active' => true,
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrative access to manage users and settings',
                'is_active' => true,
            ],
            [
                'name' => 'HR Manager',
                'slug' => 'hr-manager',
                'description' => 'Human Resources management with employee oversight',
                'is_active' => true,
            ],
            [
                'name' => 'HR',
                'slug' => 'hr',
                'description' => 'Human Resources staff with limited management access',
                'is_active' => true,
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Department manager with team management capabilities',
                'is_active' => true,
            ],
            [
                'name' => 'Team Lead',
                'slug' => 'team-lead',
                'description' => 'Team leader with project and team oversight',
                'is_active' => true,
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'description' => 'Standard employee with basic access',
                'is_active' => true,
            ],
            [
                'name' => 'Intern',
                'slug' => 'intern',
                'description' => 'Intern with limited access',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->command->info('Roles created successfully!');
        $this->command->info('Created '.count($roles).' roles.');
    }
}
