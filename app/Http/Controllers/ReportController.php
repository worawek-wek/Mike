<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Position;
use App\Models\Branch;
use App\Models\Work_shift;
use App\Models\Schedule;
use App\Models\Leave;
use App\Models\UserLeave;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

DB::beginTransaction();

class ReportController extends Controller
{
    
    protected $LeaveController;

    public function __construct(LeaveController $LeaveController)
    {
        $this->LeaveController = $LeaveController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_overview(Request $request)
    {
        return view('report/report-viewOverview');
    }
    public function rent_bill(Request $request)
    {
        return view('report/report-rentBill');
    }
    public function move_in(Request $request)
    {
        return view('report/report-moveIn');
    }
    public function move_out(Request $request)
    {
        return view('report/report-moveOut');
    }
    public function badDebt(Request $request)
    {
        return view('report/report-badDebt');
    }
    public function monthly_booking(Request $request)
    {
        return view('report/report-monthlyBooking');
    }
}
