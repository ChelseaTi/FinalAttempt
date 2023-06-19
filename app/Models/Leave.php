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

class Leave extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "comments",
        "start_date",
        "end_date",
        "status",
        "approved_at",
        "approved_user_id",
        "declined_at",
        "declined_user_id",
        "employee_id",
        "timesheet_id",
        "type",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'approved_at' => 'datetime',
        'declined_at' => 'datetime',
    ];

    /**
     * Get employee that this leave belongs to
     */
    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get timesheet that this leave may be associated with
     */
    public function Timesheet()
    {
        return $this->belongsTo(Timesheet::class);
    }

    /**
     * Get the duration of this leave
     *
     * @return \DateInterval duration
     */
    public function getDurationAttribute()
    {
        return $this->start_date->diff($this->end_date);
    }
}
