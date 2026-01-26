<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Manages employee relations, recruitment, and organizational development',
                'is_active' => true,
            ],
            [
                'name' => 'Information Technology',
                'code' => 'IT',
                'description' => 'Handles all technology infrastructure and software development',
                'is_active' => true,
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Manages financial planning, accounting, and budgeting',
                'is_active' => true,
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Responsible for brand promotion and customer acquisition',
                'is_active' => true,
            ],
            [
                'name' => 'Sales',
                'code' => 'SALES',
                'description' => 'Focuses on revenue generation and customer relationships',
                'is_active' => true,
            ],
            [
                'name' => 'Operations',
                'code' => 'OPS',
                'description' => 'Manages day-to-day business operations and processes',
                'is_active' => true,
            ],
            [
                'name' => 'Customer Support',
                'code' => 'CS',
                'description' => 'Provides customer service and technical support',
                'is_active' => true,
            ],
            [
                'name' => 'Research & Development',
                'code' => 'R&D',
                'description' => 'Focuses on innovation and product development',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }

        $this->command->info('Departments created successfully!');
        $this->command->info('Created '.count($departments).' departments.');
    }
}
