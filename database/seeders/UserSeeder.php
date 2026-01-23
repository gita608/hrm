<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all roles
        $roles = Role::all()->keyBy('slug');
        
        // Define users for each role (5 users per role)
        $usersByRole = [
            'super-admin' => [
                ['name' => 'Super Admin ', 'email' => 'superadmin@gmail.com']
            ],
            'admin' => [
                ['name' => 'Admin One', 'email' => 'admin1@hrm.test'],
                ['name' => 'Admin Two', 'email' => 'admin2@hrm.test'],
                ['name' => 'Admin Three', 'email' => 'admin3@hrm.test'],
                ['name' => 'Admin Four', 'email' => 'admin4@hrm.test'],
                ['name' => 'Admin Five', 'email' => 'admin5@hrm.test'],
            ],
            'hr-manager' => [
                ['name' => 'HR Manager One', 'email' => 'hrmanager1@hrm.test'],
                ['name' => 'HR Manager Two', 'email' => 'hrmanager2@hrm.test'],
                ['name' => 'HR Manager Three', 'email' => 'hrmanager3@hrm.test'],
                ['name' => 'HR Manager Four', 'email' => 'hrmanager4@hrm.test'],
                ['name' => 'HR Manager Five', 'email' => 'hrmanager5@hrm.test'],
            ],
            'hr' => [
                ['name' => 'HR Staff One', 'email' => 'hr1@hrm.test'],
                ['name' => 'HR Staff Two', 'email' => 'hr2@hrm.test'],
                ['name' => 'HR Staff Three', 'email' => 'hr3@hrm.test'],
                ['name' => 'HR Staff Four', 'email' => 'hr4@hrm.test'],
                ['name' => 'HR Staff Five', 'email' => 'hr5@hrm.test'],
            ],
            'manager' => [
                ['name' => 'Manager One', 'email' => 'manager1@hrm.test'],
                ['name' => 'Manager Two', 'email' => 'manager2@hrm.test'],
                ['name' => 'Manager Three', 'email' => 'manager3@hrm.test'],
                ['name' => 'Manager Four', 'email' => 'manager4@hrm.test'],
                ['name' => 'Manager Five', 'email' => 'manager5@hrm.test'],
            ],
            'team-lead' => [
                ['name' => 'Team Lead One', 'email' => 'teamlead1@hrm.test'],
                ['name' => 'Team Lead Two', 'email' => 'teamlead2@hrm.test'],
                ['name' => 'Team Lead Three', 'email' => 'teamlead3@hrm.test'],
                ['name' => 'Team Lead Four', 'email' => 'teamlead4@hrm.test'],
                ['name' => 'Team Lead Five', 'email' => 'teamlead5@hrm.test'],
            ],
            'employee' => [
                ['name' => 'Employee One', 'email' => 'employee1@hrm.test'],
                ['name' => 'Employee Two', 'email' => 'employee2@hrm.test'],
                ['name' => 'Employee Three', 'email' => 'employee3@hrm.test'],
                ['name' => 'Employee Four', 'email' => 'employee4@hrm.test'],
                ['name' => 'Employee Five', 'email' => 'employee5@hrm.test'],
            ],
            'intern' => [
                ['name' => 'Intern One', 'email' => 'intern1@hrm.test'],
                ['name' => 'Intern Two', 'email' => 'intern2@hrm.test'],
                ['name' => 'Intern Three', 'email' => 'intern3@hrm.test'],
                ['name' => 'Intern Four', 'email' => 'intern4@hrm.test'],
                ['name' => 'Intern Five', 'email' => 'intern5@hrm.test'],
            ],
        ];

        $totalUsers = 0;

        // Create users for each role
        foreach ($usersByRole as $roleSlug => $users) {
            $role = $roles->get($roleSlug);
            
            if (!$role) {
                $this->command->warn("Role '{$roleSlug}' not found, skipping users for this role.");
                continue;
            }

            foreach ($users as $userData) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'role_id' => $role->id,
                ]);
                $totalUsers++;
            }
        }

        $this->command->info('Users created successfully!');
        $this->command->info("Created {$totalUsers} users across all roles.");
        $this->command->info('All users have password: password');
    }
}
