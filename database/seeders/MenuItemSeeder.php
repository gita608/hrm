<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dashboard
        MenuItem::create([
            'name' => 'DASHBOARD',
            'type' => 'title',
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Dashboard',
            'icon' => 'ti ti-layout-dashboard',
            'route' => 'dashboard',
            'order' => 2,
        ]);

        // Organization
        MenuItem::create([
            'name' => 'ORGANIZATION',
            'type' => 'title',
            'order' => 3,
        ]);

        MenuItem::create([
            'name' => 'Departments',
            'icon' => 'ti ti-building',
            'route' => 'departments.index',
            'order' => 4,
        ]);

        MenuItem::create([
            'name' => 'Designations',
            'icon' => 'ti ti-briefcase',
            'route' => 'designations.index',
            'order' => 5,
        ]);

        $userManagement = MenuItem::create([
            'name' => 'User Management',
            'icon' => 'ti ti-user-star',
            'order' => 6,
        ]);

        MenuItem::create([
            'name' => 'Users',
            'route' => 'users.index',
            'parent_id' => $userManagement->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Roles & Permissions',
            'route' => 'roles.index',
            'parent_id' => $userManagement->id,
            'order' => 2,
        ]);

        // Employee Management
        MenuItem::create([
            'name' => 'EMPLOYEE MANAGEMENT',
            'type' => 'title',
            'order' => 7,
        ]);

        $attendance = MenuItem::create([
            'name' => 'Attendance',
            'icon' => 'ti ti-file-time',
            'order' => 8,
        ]);

        MenuItem::create([
            'name' => 'Attendance (Admin)',
            'route' => 'attendance.admin',
            'parent_id' => $attendance->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Attendance (Employee)',
            'route' => 'attendance.employee',
            'parent_id' => $attendance->id,
            'order' => 2,
        ]);

        $leaves = MenuItem::create([
            'name' => 'Leaves',
            'icon' => 'ti ti-calendar-off',
            'order' => 9,
        ]);

        MenuItem::create([
            'name' => 'Leaves (Admin)',
            'route' => 'leaves.index',
            'parent_id' => $leaves->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Leave (Employee)',
            'route' => 'leaves.employee',
            'parent_id' => $leaves->id,
            'order' => 2,
        ]);

        MenuItem::create([
            'name' => 'Leave Settings',
            'route' => 'leaves.settings',
            'parent_id' => $leaves->id,
            'order' => 3,
        ]);

        MenuItem::create([
            'name' => 'Shift & Schedule',
            'icon' => 'ti ti-calendar-time',
            'route' => 'schedule.index',
            'order' => 10,
        ]);

        MenuItem::create([
            'name' => 'Overtime',
            'icon' => 'ti ti-clock-hour-4',
            'route' => 'overtime.index',
            'order' => 11,
        ]);

        MenuItem::create([
            'name' => 'Holidays',
            'icon' => 'ti ti-calendar-event',
            'route' => 'holidays.index',
            'order' => 12,
        ]);

        $training = MenuItem::create([
            'name' => 'Training',
            'icon' => 'ti ti-edit',
            'order' => 13,
        ]);

        MenuItem::create([
            'name' => 'Training List',
            'route' => 'training.index',
            'parent_id' => $training->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Trainers',
            'route' => 'trainers.index',
            'parent_id' => $training->id,
            'order' => 2,
        ]);

        MenuItem::create([
            'name' => 'Training Type',
            'route' => 'training.types.index',
            'parent_id' => $training->id,
            'order' => 3,
        ]);

        MenuItem::create([
            'name' => 'Promotion',
            'icon' => 'ti ti-speakerphone',
            'route' => 'promotions.index',
            'order' => 14,
        ]);

        MenuItem::create([
            'name' => 'Resignation',
            'icon' => 'ti ti-external-link',
            'route' => 'resignations.index',
            'order' => 15,
        ]);

        MenuItem::create([
            'name' => 'Termination',
            'icon' => 'ti ti-circle-x',
            'route' => 'terminations.index',
            'order' => 16,
        ]);

        // Recruitment
        MenuItem::create([
            'name' => 'RECRUITMENT',
            'type' => 'title',
            'order' => 17,
        ]);

        MenuItem::create([
            'name' => 'Jobs',
            'icon' => 'ti ti-timeline',
            'route' => 'jobs.index',
            'order' => 18,
        ]);

        MenuItem::create([
            'name' => 'Candidates',
            'icon' => 'ti ti-user-shield',
            'route' => 'candidates.index',
            'order' => 19,
        ]);

        $interviews = MenuItem::create([
            'name' => 'Interview',
            'icon' => 'ti ti-calendar-check',
            'order' => 20,
        ]);

        MenuItem::create([
            'name' => 'Interview Schedule',
            'route' => 'interviews.index',
            'parent_id' => $interviews->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Interview Feedback',
            'route' => 'interviews.feedback.index',
            'parent_id' => $interviews->id,
            'order' => 2,
        ]);

        MenuItem::create([
            'name' => 'Referrals',
            'icon' => 'ti ti-ux-circle',
            'route' => 'referrals.index',
            'order' => 21,
        ]);

        // Finance & Payroll
        MenuItem::create([
            'name' => 'FINANCE & PAYROLL',
            'type' => 'title',
            'order' => 22,
        ]);

        $payroll = MenuItem::create([
            'name' => 'Payroll',
            'icon' => 'ti ti-cash',
            'order' => 23,
        ]);

        MenuItem::create([
            'name' => 'Employee Salary',
            'route' => 'payroll.salary.index',
            'parent_id' => $payroll->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Payslip',
            'route' => 'payroll.payslip.index',
            'parent_id' => $payroll->id,
            'order' => 2,
        ]);

        MenuItem::create([
            'name' => 'Payroll Items',
            'route' => 'payroll.items.index',
            'parent_id' => $payroll->id,
            'order' => 3,
        ]);

        MenuItem::create([
            'name' => 'Provident Fund',
            'route' => 'payroll.provident-fund.index',
            'parent_id' => $payroll->id,
            'order' => 4,
        ]);

        MenuItem::create([
            'name' => 'Taxes',
            'route' => 'payroll.tax.index',
            'parent_id' => $payroll->id,
            'order' => 5,
        ]);

        // Documents & Support
        MenuItem::create([
            'name' => 'DOCUMENTS & SUPPORT',
            'type' => 'title',
            'order' => 24,
        ]);

        $documents = MenuItem::create([
            'name' => 'Documents',
            'icon' => 'ti ti-file-text',
            'order' => 25,
        ]);

        MenuItem::create([
            'name' => 'Document Library',
            'route' => 'documents.index',
            'parent_id' => $documents->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'HR Letters',
            'route' => 'hr-letters.index',
            'parent_id' => $documents->id,
            'order' => 2,
        ]);

        MenuItem::create([
            'name' => 'Certificates',
            'route' => 'certificates.index',
            'parent_id' => $documents->id,
            'order' => 3,
        ]);

        // Assets & Resources
        MenuItem::create([
            'name' => 'ASSETS & RESOURCES',
            'type' => 'title',
            'order' => 26,
        ]);

        $assets = MenuItem::create([
            'name' => 'Assets',
            'icon' => 'ti ti-package',
            'order' => 27,
        ]);

        MenuItem::create([
            'name' => 'Assets',
            'route' => 'assets.index',
            'parent_id' => $assets->id,
            'order' => 1,
        ]);

        MenuItem::create([
            'name' => 'Asset Categories',
            'route' => 'assets.categories.index',
            'parent_id' => $assets->id,
            'order' => 2,
        ]);

        // Reports & Analytics
        MenuItem::create([
            'name' => 'REPORTS & ANALYTICS',
            'type' => 'title',
            'order' => 28,
            'is_active' => false,
        ]);

        $reports = MenuItem::create([
            'name' => 'Reports',
            'icon' => 'ti ti-chart-bar',
            'order' => 29,
            'is_active' => false,
        ]);

        MenuItem::create([
            'name' => 'Employee Report',
            'route' => 'reports.employees',
            'parent_id' => $reports->id,
            'order' => 1,
            'is_active' => false,
        ]);

        MenuItem::create([
            'name' => 'Attendance Report',
            'route' => 'reports.attendance',
            'parent_id' => $reports->id,
            'order' => 2,
            'is_active' => false,
        ]);

        MenuItem::create([
            'name' => 'Leave Report',
            'route' => 'reports.leaves',
            'parent_id' => $reports->id,
            'order' => 3,
            'is_active' => false,
        ]);

        MenuItem::create([
            'name' => 'Payslip Report',
            'route' => 'reports.payslips',
            'parent_id' => $reports->id,
            'order' => 4,
            'is_active' => false,
        ]);

        MenuItem::create([
            'name' => 'Expense Report',
            'route' => 'reports.expenses',
            'parent_id' => $reports->id,
            'order' => 5,
            'is_active' => false,
        ]);

        MenuItem::create([
            'name' => 'Training Report',
            'route' => 'reports.training',
            'parent_id' => $reports->id,
            'order' => 6,
            'is_active' => false,
        ]);

        MenuItem::create([
            'name' => 'Recruitment Report',
            'route' => 'reports.recruitment',
            'parent_id' => $reports->id,
            'order' => 7,
            'is_active' => false,
        ]);

        MenuItem::create([
            'name' => 'User Report',
            'route' => 'reports.users',
            'parent_id' => $reports->id,
            'order' => 8,
            'is_active' => false,
        ]);

        MenuItem::create([
            'name' => 'Daily Report',
            'route' => 'reports.daily',
            'parent_id' => $reports->id,
            'order' => 9,
            'is_active' => false,
        ]);

        // Settings
        MenuItem::create([
            'name' => 'SETTINGS',
            'type' => 'title',
            'order' => 30,
        ]);

        MenuItem::create([
            'name' => 'Settings',
            'icon' => 'ti ti-settings',
            'route' => 'settings.index',
            'order' => 31,
        ]);
    }
}
