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
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimesheetDay>
 */
class TimesheetDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
          "date" => $this->faker->dateTimeBetween('+25 years', '+190 years'),
          "description" => $this->faker->randomElement([null, "No show", "Sick", "On the road", "Traveling", $this->faker->sentence()]),
          "start_time" => $this->faker->time("H:i:s"),
          "end_time" => $this->faker->time("H:i:s"),
          "adjustment" => $this->faker->randomFloat(2, -4, 4),
          "total_units" => $this->faker->randomFloat(2, 0, 8),
          "deleted_at" => $this->faker->randomElement([null, $this->faker->dateTime("now"), null]),
          "timesheet_id" => function (array $attributes) {
              return $attributes['timesheet_id'];
          },
          "updated_at" => null,
        ];
    }
}
