<?php
/*
 * Students: Tibudan, Chelsea Shaira E. | Los Baños, John Christian H.
 * Date Started: May 28, 2023
 * Subject: Integrative Programming | Application Development and Emerging Technologies
 * Legacy: This system is for grading purposes only
*/
namespace App\Console\Commands;

use App;
use Illuminate;
use Illuminate\Console\Command;

class Factories extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'run:factories';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Run the database test factories';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    // Delete old data
    Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    App\Models\Employee::truncate();
    App\Models\Leave::truncate();
    App\Models\Timesheet::truncate();
    App\Models\TimesheetDay::truncate();
    Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // Disable Observer
    App\Models\Employee::unsetEventDispatcher();

    // Create new models
    App\Models\Employee::factory()->count(rand(6, 45))
      ->has(App\Models\Timesheet::factory()->count(rand(1, 8))
          ->has(App\Models\TimesheetDay::factory()->count(rand(1, 22))))
      ->has(App\Models\Leave::factory()->count(rand(1, 3)))
      ->create();

    return Command::SUCCESS;
  }
}
