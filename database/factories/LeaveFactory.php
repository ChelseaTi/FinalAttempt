<?php
/*
 * Students: Tibudan, Chelsea Shaira E. | Los Baños, John Christian H.
 * Date Started: May 28, 2023
 * Subject: Integrative Programming | Application Development and Emerging Technologies
 * Legacy: This system is for grading purposes only
*/
namespace Database\Factories;

use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
      $start = $this->faker->dateTimeBetween('-2 years', '+8 months');
      $status = $this->faker->randomElement(['approved', 'pending', 'declined']);
      $created = (clone $start)->sub(new DateInterval("P".mt_rand(2, 90)."D"));

      return [
          'employee_id' => function (array $attributes) {
              return $attributes['employee_id'];
          },
          'start_date' => $start,
          'end_date' => (clone $start)->add(new DateInterval("P".rand(1, 45)."D")),
          'comments' => $this->faker->randomElement(["", $this->faker->sentence()]),
          'status' => $status,
          'approved_at' => $status === "approved" ? $this->faker->dateTimeBetween($created, $start) : null,
          'approved_user_id' => null,
          'declined_at' => $status === "declined" ? $this->faker->dateTimeBetween($created, $start) : null,
          'declined_user_id' => null,
          'timesheet_id' => null,
          'type' => $this->faker->randomElement(['paid', 'sick', 'vacation', 'parental', 'unpaid', 'other']),
          'created_at' => $created,
          'updated_at' => null,
      ];
    }
}
