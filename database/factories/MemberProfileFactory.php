<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberProfile>
 */
class MemberProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = ['male', 'female'];
        $maritalStatuses = ['single', 'married', 'divorced', 'widow'];
        $nationalities = [
            'Bahraini', 'Saudi Arabian', 'Emirati', 'Kuwaiti', 'Qatari', 'Omani',
            'Jordanian', 'Lebanese', 'Syrian', 'Egyptian', 'Indian', 'Pakistani',
            'Bangladeshi', 'Filipino', 'British', 'American', 'Other',
        ];
        $departments = [
            'Human Resources', 'Finance', 'IT', 'Marketing', 'Operations',
            'Sales', 'Customer Service', 'Logistics', 'Administration',
        ];
        $positions = [
            'Manager', 'Senior Executive', 'Executive', 'Assistant Manager',
            'Coordinator', 'Specialist', 'Officer', 'Supervisor', 'Analyst',
        ];
        $educationLevels = [
            'High School', 'Diploma', 'Bachelors Degree', 'Masters Degree',
            'PhD', 'Professional Certificate', 'Other',
        ];

        return [
            'cpr_number' => $this->faker->numerify('#########'),
            'staff_number' => 'EMP'.$this->faker->unique()->numberBetween(10000, 99999),
            'full_name' => $this->faker->name(),
            'nationality' => $this->faker->randomElement($nationalities),
            'gender' => $this->faker->randomElement($genders),
            'marital_status' => $this->faker->randomElement($maritalStatuses),
            'email' => $this->faker->optional(0.8)->safeEmail(),
            'date_of_joining' => $this->faker->dateTimeBetween('-10 years', '-1 month'),
            'position' => $this->faker->randomElement($positions),
            'department' => $this->faker->randomElement($departments),
            'section' => $this->faker->optional(0.7)->words(2, true),
            'working_place_address' => $this->faker->address(),
            'office_phone' => $this->faker->optional(0.6)->phoneNumber(),
            'education_qualification' => $this->faker->randomElement($educationLevels),
            'mobile_number' => $this->faker->phoneNumber(),
            'home_phone' => $this->faker->optional(0.5)->phoneNumber(),
            'permanent_address' => $this->faker->address(),
            'profile_status' => $this->faker->boolean(85), // 85% chance of being active
        ];
    }
}
