<?php
/*
 * Students: Tibudan, Chelsea Shaira E. | Los Baños, John Christian H.
 * Date Started: May 28, 2023
 * Subject: Integrative Programming | Application Development and Emerging Technologies
 * Legacy: This system is for grading purposes only
*/
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $hired_at = $this->faker->dateTimeBetween('-3 years', '-1 day');
        $pay_type = $this->faker->randomElement(['hourly', 'salary']);

        return [
            'firstname' => $this->faker->firstName(),
            'middlename' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique->safeEmail(),
            'telephone' => $this->faker->phoneNumber(),
            'street1' => $this->faker->streetAddress(),
            'street2' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zip' => $this->faker->postcode(),
            'birthdate' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'hired_at' => $hired_at,
            'terminated_at' => $this->faker->randomElement([null, $this->faker->dateTimeBetween($hired_at, 'now')]),
            'pay_type' => $pay_type,
            'pay_period' => $this->faker->randomElement(['daily', 'weekly', 'biweekly', 'monthly']),
            'pay_rate' => $pay_type === "hourly" ? $this->faker->randomFloat(0, 11, 95) : $this->faker->randomFloat(0, 225, 950),
            'title' => $this->faker->jobTitle(),
            'employment_status' => $this->faker->randomElement(['active', 'terminated', 'suspended']),
            'comments' => $this->faker->text(),
        ];
    }
}
