<?php
/*
 * Students: Tibudan, Chelsea Shaira E. | Los Baños, John Christian H.
 * Date Started: May 28, 2023
 * Subject: Integrative Programming | Application Development and Emerging Technologies
 * Legacy: This system is for grading purposes only
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimesheetDay extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      "date",
      "description",
      "start_time",
      "end_time",
      "adjustment",
      "total_units",
      "timesheet_id",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      'date' => 'datetime',
      'start_time' => 'datetime',
      'end_time' => 'datetime',
    ];

    /**
     * Get the timesheet that this day belongs to
     */
    public function Timesheet()
    {
      return $this->belongsTo(Timesheet::class);
    }
}
