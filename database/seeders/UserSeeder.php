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

        // Define users for each role (3 users per role)
        $usersByRole = [
            'super-admin' => [
                ['name' => 'Super Admin ', 'email' => 'superadmin@gmail.com', 'phone' => '+1-555-0001', 'address' => '100 Corporate Plaza, New York, NY 10001'],
            ],
            'admin' => [
                ['name' => 'Admin One', 'email' => 'admin1@hrm.test', 'phone' => '+1-555-0101', 'address' => '123 Main Street, New York, NY 10001'],
                ['name' => 'Admin Two', 'email' => 'admin2@hrm.test', 'phone' => '+1-555-0102', 'address' => '456 Oak Avenue, Los Angeles, CA 90001'],
                ['name' => 'Admin Three', 'email' => 'admin3@hrm.test', 'phone' => '+1-555-0103', 'address' => '789 Pine Road, Chicago, IL 60601'],
            ],
            'hr-manager' => [
                ['name' => 'HR Manager One', 'email' => 'hrmanager1@hrm.test', 'phone' => '+1-555-0106', 'address' => '987 Cedar Lane, Philadelphia, PA 19101'],
                ['name' => 'HR Manager Two', 'email' => 'hrmanager2@hrm.test', 'phone' => '+1-555-0107', 'address' => '147 Birch Boulevard, San Antonio, TX 78201'],
                ['name' => 'HR Manager Three', 'email' => 'hrmanager3@hrm.test', 'phone' => '+1-555-0108', 'address' => '258 Spruce Way, San Diego, CA 92101'],
            ],
            'hr' => [
                ['name' => 'HR Staff One', 'email' => 'hr1@hrm.test', 'phone' => '+1-555-0111', 'address' => '852 Cherry Avenue, Austin, TX 78701'],
                ['name' => 'HR Staff Two', 'email' => 'hr2@hrm.test', 'phone' => '+1-555-0112', 'address' => '963 Poplar Road, Jacksonville, FL 32201'],
                ['name' => 'HR Staff Three', 'email' => 'hr3@hrm.test', 'phone' => '+1-555-0113', 'address' => '159 Magnolia Drive, Fort Worth, TX 76101'],
            ],
            'manager' => [
                ['name' => 'Manager One', 'email' => 'manager1@hrm.test', 'phone' => '+1-555-0116', 'address' => '579 Sycamore Way, San Francisco, CA 94101'],
                ['name' => 'Manager Two', 'email' => 'manager2@hrm.test', 'phone' => '+1-555-0117', 'address' => '680 Chestnut Court, Indianapolis, IN 46201'],
                ['name' => 'Manager Three', 'email' => 'manager3@hrm.test', 'phone' => '+1-555-0118', 'address' => '791 Walnut Street, Seattle, WA 98101'],
            ],
            'team-lead' => [
                ['name' => 'Team Lead One', 'email' => 'teamlead1@hrm.test', 'phone' => '+1-555-0121', 'address' => '024 Hemlock Drive, Boston, MA 02101'],
                ['name' => 'Team Lead Two', 'email' => 'teamlead2@hrm.test', 'phone' => '+1-555-0122', 'address' => '135 Juniper Lane, El Paso, TX 79901'],
                ['name' => 'Team Lead Three', 'email' => 'teamlead3@hrm.test', 'phone' => '+1-555-0123', 'address' => '246 Redwood Boulevard, Nashville, TN 37201'],
            ],
            'employee' => [
                ['name' => 'Employee One', 'email' => 'employee1@hrm.test', 'phone' => '+1-555-0126', 'address' => '579 Eucalyptus Street, Portland, OR 97201'],
                ['name' => 'Employee Two', 'email' => 'employee2@hrm.test', 'phone' => '+1-555-0127', 'address' => '680 Acacia Avenue, Las Vegas, NV 89101'],
                ['name' => 'Employee Three', 'email' => 'employee3@hrm.test', 'phone' => '+1-555-0128', 'address' => '791 Banyan Road, Memphis, TN 38101'],
            ],
            'intern' => [
                ['name' => 'Intern One', 'email' => 'intern1@hrm.test', 'phone' => '+1-555-0131', 'address' => '024 Jacaranda Boulevard, Milwaukee, WI 53201'],
                ['name' => 'Intern Two', 'email' => 'intern2@hrm.test', 'phone' => '+1-555-0132', 'address' => '135 Kapok Way, Albuquerque, NM 87101'],
                ['name' => 'Intern Three', 'email' => 'intern3@hrm.test', 'phone' => '+1-555-0133', 'address' => '246 Larch Court, Tucson, AZ 85701'],
            ],
        ];

        $totalUsers = 0;

        // Create users for each role
        foreach ($usersByRole as $roleSlug => $users) {
            $role = $roles->get($roleSlug);

            if (! $role) {
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
                    'phone' => $userData['phone'] ?? null,
                    'address' => $userData['address'] ?? null,
                ]);
                $totalUsers++;
            }
        }

        $this->command->info('Users created successfully!');
        $this->command->info("Created {$totalUsers} users across all roles.");
        $this->command->info('All users have password: password');
    }
}
