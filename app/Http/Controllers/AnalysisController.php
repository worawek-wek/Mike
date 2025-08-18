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

class AnalysisController extends Controller
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
    public function monthly_rent(Request $request)
    {
        $summary = $this->summary(session("branch_id"));
        // return $summary['all_receipt_late'];
        $total = $summary['all_receipt_on_time'] + $summary['all_receipt_late_with_appointment'] + $summary['all_receipt_late'];

        if ($total > 0) {
            $percent_on_time = ($summary['all_receipt_on_time'] / $total) * 100;
            $percent_late_with_appointment = ($summary['all_receipt_late_with_appointment'] / $total) * 100;
            $percent_late = ($summary['all_receipt_late'] / $total) * 100;
        } else {
            $percent_on_time = $percent_late_with_appointment = $percent_late = 0;
        }
        $data['percent_on_time'] = number_format($percent_on_time);
        $data['percent_late_with_appointment'] = number_format($percent_late_with_appointment);
        $data['percent_late'] = number_format($percent_late);
        $data['summary'] = $summary;
        
        return view('analysis/analysis-monthlyRent', $data);
    }
    public function income_expense(Request $request)
    {
        $summary = $this->summary(session("branch_id"));
        // return $summary['all_receipt_late'];
        $total = $summary['all_receipt_on_time'] + $summary['all_receipt_late_with_appointment'] + $summary['all_receipt_late'];

        if ($total > 0) {
            $percent_on_time = ($summary['all_receipt_on_time'] / $total) * 100;
            $percent_late_with_appointment = ($summary['all_receipt_late_with_appointment'] / $total) * 100;
            $percent_late = ($summary['all_receipt_late'] / $total) * 100;
        } else {
            $percent_on_time = $percent_late_with_appointment = $percent_late = 0;
        }
        $data['percent_on_time'] = number_format($percent_on_time);
        $data['percent_late_with_appointment'] = number_format($percent_late_with_appointment);
        $data['percent_late'] = number_format($percent_late);
        $data['summary'] = $summary;

        return view('analysis/analysis-incomeExpense', $data);
    }
    public function water(Request $request)
    {
        return view('analysis/analysis-water');
    }
    public function elect(Request $request)
    {
        return view('analysis/analysis-elect');
    }
    public function meter(Request $request)
    {
        return view('analysis/analysis-meter');
    }
    public function tenants(Request $request)
    {
        return view('analysis/analysis-tenants');
    }
}
