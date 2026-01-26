<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all()->keyBy('code');

        $designations = [
            // HR Department
            [
                'name' => 'HR Manager',
                'code' => 'HR-MGR',
                'description' => 'Manages HR operations and team',
                'department_id' => $departments->get('HR')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'HR Executive',
                'code' => 'HR-EXEC',
                'description' => 'Handles recruitment and employee relations',
                'department_id' => $departments->get('HR')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'HR Assistant',
                'code' => 'HR-ASST',
                'description' => 'Supports HR operations and administrative tasks',
                'department_id' => $departments->get('HR')?->id,
                'is_active' => true,
            ],

            // IT Department
            [
                'name' => 'IT Manager',
                'code' => 'IT-MGR',
                'description' => 'Manages IT infrastructure and team',
                'department_id' => $departments->get('IT')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Senior Developer',
                'code' => 'IT-SR-DEV',
                'description' => 'Senior software developer',
                'department_id' => $departments->get('IT')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Developer',
                'code' => 'IT-DEV',
                'description' => 'Software developer',
                'department_id' => $departments->get('IT')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'System Administrator',
                'code' => 'IT-SYS-ADMIN',
                'description' => 'Manages system infrastructure',
                'department_id' => $departments->get('IT')?->id,
                'is_active' => true,
            ],

            // Finance Department
            [
                'name' => 'Finance Manager',
                'code' => 'FIN-MGR',
                'description' => 'Manages financial operations',
                'department_id' => $departments->get('FIN')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Accountant',
                'code' => 'FIN-ACC',
                'description' => 'Handles accounting and bookkeeping',
                'department_id' => $departments->get('FIN')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Financial Analyst',
                'code' => 'FIN-ANAL',
                'description' => 'Analyzes financial data and trends',
                'department_id' => $departments->get('FIN')?->id,
                'is_active' => true,
            ],

            // Marketing Department
            [
                'name' => 'Marketing Manager',
                'code' => 'MKT-MGR',
                'description' => 'Manages marketing campaigns and strategy',
                'department_id' => $departments->get('MKT')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Marketing Executive',
                'code' => 'MKT-EXEC',
                'description' => 'Executes marketing campaigns',
                'department_id' => $departments->get('MKT')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Content Writer',
                'code' => 'MKT-CONTENT',
                'description' => 'Creates marketing content',
                'department_id' => $departments->get('MKT')?->id,
                'is_active' => true,
            ],

            // Sales Department
            [
                'name' => 'Sales Manager',
                'code' => 'SALES-MGR',
                'description' => 'Manages sales team and targets',
                'department_id' => $departments->get('SALES')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Sales Executive',
                'code' => 'SALES-EXEC',
                'description' => 'Handles customer sales',
                'department_id' => $departments->get('SALES')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Business Development Executive',
                'code' => 'SALES-BDE',
                'description' => 'Focuses on business growth',
                'department_id' => $departments->get('SALES')?->id,
                'is_active' => true,
            ],

            // Operations Department
            [
                'name' => 'Operations Manager',
                'code' => 'OPS-MGR',
                'description' => 'Manages daily operations',
                'department_id' => $departments->get('OPS')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Operations Executive',
                'code' => 'OPS-EXEC',
                'description' => 'Handles operational tasks',
                'department_id' => $departments->get('OPS')?->id,
                'is_active' => true,
            ],

            // Customer Support Department
            [
                'name' => 'Support Manager',
                'code' => 'CS-MGR',
                'description' => 'Manages customer support team',
                'department_id' => $departments->get('CS')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Support Executive',
                'code' => 'CS-EXEC',
                'description' => 'Provides customer support',
                'department_id' => $departments->get('CS')?->id,
                'is_active' => true,
            ],

            // R&D Department
            [
                'name' => 'R&D Manager',
                'code' => 'RD-MGR',
                'description' => 'Manages research and development',
                'department_id' => $departments->get('R&D')?->id,
                'is_active' => true,
            ],
            [
                'name' => 'Research Scientist',
                'code' => 'RD-SCI',
                'description' => 'Conducts research and experiments',
                'department_id' => $departments->get('R&D')?->id,
                'is_active' => true,
            ],
        ];

        foreach ($designations as $designation) {
            Designation::create($designation);
        }

        $this->command->info('Designations created successfully!');
        $this->command->info('Created '.count($designations).' designations.');
    }
}
