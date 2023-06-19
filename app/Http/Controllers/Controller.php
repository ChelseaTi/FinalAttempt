<?php
/*
 * Students: Tibudan, Chelsea Shaira E. | Los Baños, John Christian H.
 * Date Started: May 28, 2023
 * Subject: Integrative Programming | Application Development and Emerging Technologies
 * Legacy: This system is for grading purposes only
*/
namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Get application index
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Contracts\View\View
   */
  public function index(Request $request)
  {
    $openLeaves = Cache::remember('openLeaves', 60*5, function () {
      return Leave::where("status", "pending")
        ->where("start_date", ">=", date("Y-m-d"))
        ->orderBy("created_at")
        ->get();
    });

    $upcomingLeaves = Cache::remember('upcomingLeaves', 60*60, function () {
      return Leave::where("status", "approved")
        ->where("start_date", ">=", date("Y-m-d"))
        ->where("start_date", "<=", date("Y-m-d", strtotime("+3 weeks")))
        ->orderBy("start_date")
        ->get();
    });

    return view('index', compact("openLeaves", "upcomingLeaves"));
  }
}
