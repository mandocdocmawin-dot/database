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
            // Explain: STU is the prefix, str_pad is used to pad the number with zeros, numberBetween is used to generate a random number between 1 and 10000, unique is used to ensure that the number is unique, faker is used to generate a random number.
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(), // Explain: unique is used to ensure that the email is unique, faker is used to generate a random email address.
            // 'password' => $this->faker->password(),
            'course' => $this->faker->randomElement($course),
            'year_level' => $this->faker->randomElement($year),
        ];
    }
}
