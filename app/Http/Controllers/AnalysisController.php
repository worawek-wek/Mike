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
        return view('analysis/analysis-monthlyRent');
    }
    public function income_expense(Request $request)
    {
        return view('analysis/analysis-incomeExpense');
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
