<?php
/*
 * Students: Tibudan, Chelsea Shaira E. | Los Baños, John Christian H.
 * Date Started: May 28, 2023
 * Subject: Integrative Programming | Application Development and Emerging Technologies
 * Legacy: This system is for grading purposes only
*/
namespace App\Observers;

use App\Models\Employee;
use App\Notifications\EmployeeCreated;
use App\Notifications\EmployeeDeleted;
use App\Notifications\EmployeeUpdated;
use Illuminate\Support\Facades\Notification;

class EmployeeObserver
{
  public $afterCommit = true;

  /**
   * Handle the Employee "created" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function created(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeCreated($employee));
  }

  /**
   * Handle the Employee "updated" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function updated(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeUpdated($employee));
  }

  /**
   * Handle the Employee "deleted" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function deleted(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeDeleted($employee));
  }

  /**
   * Handle the Employee "restored" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function restored(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeUpdated($employee));
  }

  /**
   * Handle the Employee "force deleted" event.
   *
   * @param  \App\Models\Employee  $employee
   * @return void
   */
  public function forceDeleted(Employee $employee)
  {
    Notification::route("webhook", "http://localhost/test.php")->notify(new EmployeeDeleted($employee));
  }
}
