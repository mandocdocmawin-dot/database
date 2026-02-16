<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $course = ['BS Computer Science', 'BS Information Technology', 'BS Information System'];
        $year = ['1st', '2nd', '3rd', '4th'];
        return [
            'uuid' => Str::uuid(),
            'student_id' => 'STU' . str_pad($this->faker->unique()->numberBetween(1, 10000), 4, '0', STR_PAD_LEFT), 
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(), 
            'course' => $this->faker->randomElement($course),
            'year_level' => $this->faker->randomElement($year),
        ];
    }
}
