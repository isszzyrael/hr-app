<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Position;
use App\Models\Payslip;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;




class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'Toheebat Admin',
            'email' => 'admin@hr.com',
            'role' => 'admin',
        ]);

        $hr = User::factory()->create([
            'name' => 'Amaka HR',
            'email' => 'hr@hr.com',
            'role' => 'hr',
        ]);

        $manager = User::factory()->create([
            'name' => 'Oladimeji Manager',
            'email' => 'manager@hr.com',
            'role' => 'manager',
        ]);

        $employee = User::factory()->create([
            'name' => 'Adebayo Employee',
            'email' => 'employee@hr.com',
            'role' => 'employee',
        ]);

        //Leave Types
        $annual = LeaveType::factory()->create([
            'name' => 'Annual Leave',
            'description' => 'Paid time off for vacation or personal reasons.',
            'default_days_per_year' => 20,
            'is_paid' => true
        ]);

        $sick = LeaveType::factory()->create([
            'name' => 'Sick Leave',
            'description' => 'Paid time off for illness or medical appointments.',
            'default_days_per_year' => 10,
            'is_paid' => true
        ]);

        $unpaid = LeaveType::factory()->create([
            'name' => 'Unpaid Leave',
            'description' => 'Time off without pay, typically for personal reasons.',
            'default_days_per_year' => 0,
            'is_paid' => false
        ]);

        $leaveTypes = [$annual, $sick, $unpaid];
        

        // Departments + Positions
        $blueprints = [
            'IT' => ['IT Specialist', 'DevOps Engineer', 'QA Engineer', 'Digital Marketing Specialist'],
            'Human Resources' => ['HR Manager', 'Recruiter', 'HR Coordinator', 'Admin Officer', 'Front Desk Officer'],
            'Sales' => ['Sales Manager', 'Account Executive', 'Sales Associate'],
            'Marketing' => ['Marketing Manager', 'Content Strategist', 'SEO Specialist'],
            'Finance' => ['Financial Analyst', 'Accountant', 'Payable Officer', 'Chief Financial Officer'],
            'Operations' => ['Operations Manager', 'Logistics Coordinator', 'Supply Chain Analyst', 'Chief Operations Officer'],
            'Audit' => ['Internal Auditor', 'Compliance Officer', 'Risk Analyst'],
            'Procurement' => ['Procurement Manager', 'Purchasing Agent', 'Business Development'],
            'Management' => ['General Manager', 'Project Manager', 'Executive Assistant', 'CEO', 'MD'],
            'Legal' => ['Legal Counsel', 'Paralegal', 'Contract Manager', 'Head Legal Officer'],
        ];
        $positions = collect();
        $departments = collect();

        foreach ($blueprints as $deptName => $titles) {
            $department = Department::factory()->create([
                'name' => $deptName,
                'code' => strtoupper(substr(str_replace(' ', '_', $deptName), 0, 3)),
                'description' => "The {$deptName} department.",
            ]);

            $departments->push($department);

            foreach ($titles as $title) {
                $position->push($department->positions()->create([
                    'title' => $title,
                    'description' => "The {$title} position in the {$deptName} department.",
                ]));

            }
        }

// a few managers for each department and position
        $managers = collect();
        foreach ($departments as $i => $department) {
            $managerPosition = $department->position()
            ->where('title', 'like', '%Manager%')->first() ?? $department->position()->first();  


        $managers = Employee::factory()->count(5)->create([
            'user_id' => $i === 0 ? $manager->id : null,
            'department_id' => $departments->id,
            'position_id' => $positions->id,
            'manager_id' => null,
        ]);

        // Employees demo to real account for each department and position
        Employee::factory()->create([
            'user_id' => $employee->id,
            'first_name' => 'Adebayo',
            'last_name' => 'Employee',
            'email' => 'employee@hr.com',
            'department_id' => $department->first()->id,
            'position_id' => $position->first()->id,
            'manager_id' => $managers->first()->id,
        ]);

    }
}
