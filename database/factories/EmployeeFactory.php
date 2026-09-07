<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $firstname = fake()->firstName();
        $lastname = fake()->lastName();

        return [
            'user_id' => null
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'date_of_birth' => fake()->date(),
            'position_id' => \App\Models\Position::factory(),
            'department_id' => \App\Models\Department::factory(),
            'hired_date' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'salary' => fake()->randomFloat(2, 75000, 500000),
            'manager_id' => null, 
            'employment_status' => 'active',
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->phoneNumber(),
            'emergency_contact_relationship' => fake()->word(),
            'avatar_path' => fake()->imageUrl(200, 200, 'people'),

        ];
    }
}
