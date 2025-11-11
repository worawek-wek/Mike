<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\RentBill;
use App\Models\Room;
use App\Models\Meter;
use App\Models\User;
use App\Models\Electricity;
use App\Models\Water;
use App\Models\Receipt;
use App\Models\IncomeExpenses;
use App\Models\Position;
use App\Models\Branch;
use App\Models\Floor;
use App\Models\Contract;
use App\Models\Leave;
use App\Models\UserLeave;
use App\Models\News;
use App\Models\Building;
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
        $data['page_url'] = "analysis/income-expense";

        return view('analysis/analysis-incomeExpense', $data);
    }
    public function get_income(Request $request)
    {

        $year = $request->input('year', now()->year);

        $invoiceByMonth = IncomeExpenses::with('receipt_payment_list')
                                                ->where('ref_branch_id', session("branch_id"))
                                                ->where('type', 1)
                                                ->get()
                                                ->groupBy(function ($item) {
                                                    return (int) Carbon::parse($item->date)->format('m');
                                                })
                                                ->map(function ($group) {
                                                    return $group->sum('total_from_payment_list');
                                                });
        $monthlyTotals = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        });

        return $monthlyTotals->values();
        
        // return [
        //                                     'tenant' => $monthlyTotals->values(),
        //                                     'common' => [10000,5000,0,0,0,0,0,5000,0,0,7000,0]
        //                                 ];
    }
    public function get_expense(Request $request)
    {

        $year = $request->input('year', now()->year);

        $invoiceByMonth = IncomeExpenses::selectRaw('MONTH(date) as month, SUM(amount) as total')
                                        ->where('ref_branch_id', session("branch_id"))
                                        ->whereYear('date', $year)
                                        ->groupBy('month')
                                        ->pluck('total', 'month');

        $monthlyTotals = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        });

        return $monthlyTotals->values();
    }
    public function income(Request $request)
    {
        $seriesData = [];
        for ($i = 1; $i <= 12; $i++) {
            
            $seriesData[] = rand(100, 999) ?? 0;
        }

        return response()->json([
            'seriesData' => $seriesData
        ]);
    }

    public function water(Request $request)
    {

        $data['total_expense'] = Water::where("ref_branch_id", session("branch_id"))->sum('amount');
        $data['total_income'] = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 5)->get()->sum->total_water_amount;
        $data['page_url'] = "analysis/water";
        return view('analysis/analysis-water', $data);
    }
    public function calculate_water_income_expense(Request $request)
    {
        $year = $request->input('year', now()->year);
        $total_expense = Water::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                        ->sum('amount');
        $total_income = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('year', $year)
                                            ->where('ref_status_id', 5)
                                            ->get()
                                            ->sum->total_water_amount;

        return ['total_expense' => number_format($total_expense), 'total_income' => number_format($total_income), 'total_income_total_expense' => number_format($total_income-$total_expense)];
    }
    public function calculate_water_usage(Request $request)
    {
        $year = $request->input('year', now()->year);
        $total_expense = Water::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                        ->sum('amount');
        $total_income = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('year', $year)
                                            ->where('ref_status_id', 5)->get()->sum->total_water_amount;
        $total = $total_income + $total_expense;

        $percent_income = 0;
        $percent_expense = 0;

        if ($total > 0) {
            $percent_income = round(($total_income / $total) * 100, 2);
            $percent_expense = round(($total_expense / $total) * 100, 2);
        }
        return [$percent_expense, $percent_income];
    }
    public function calculate_water_profit_loss(Request $request)
    {
        $year = $request->input('year', now()->year);

        $water_get = Water::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                        ->get()
                                        ->groupBy(function ($item) {
                                            return (int) Carbon::parse($item->date)->format('m');
                                        })
                                        ->map(function ($group) {
                                            return $group->sum('amount');
                                        });
        $water = collect(range(1, 12))->map(function ($month) use ($water_get) {
            return $water_get->get($month, 0);
        })->values();

        $invoiceByMonth = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 5)
                                            ->where('year', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('water_amount');
                                            });
        $total_income = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        })->values();

        $cepl = [
                    $water[0] - $total_income[0],
                    $water[1] - $total_income[1],
                    $water[2] - $total_income[2],
                    $water[3] - $total_income[3],
                    $water[4] - $total_income[4],
                    $water[5] - $total_income[5],
                    $water[6] - $total_income[6],
                    $water[7] - $total_income[7],
                    $water[8] - $total_income[8],
                    $water[9] - $total_income[9],
                    $water[10] - $total_income[10],
                    $water[11] - $total_income[11]
                ];

        return $cepl;
    }
    public function water_expenses(Request $request)
    {
        $year = $request->input('year', now()->year);

        $invoiceByMonth = Water::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                        ->get()
                                        ->groupBy(function ($item) {
                                            return (int) Carbon::parse($item->date)->format('m');
                                        })
                                        ->map(function ($group) {
                                            return $group->sum('amount');
                                        });
        $monthlyTotals = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        });

        return $monthlyTotals->values();
    }
    public function water_renter_income_baht(Request $request)
    {
        $year = $request->input('year', now()->year);

        $invoiceByMonth = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 5)
                                            ->where('year', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('water_amount');
                                            });
        $total_income = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        })->values();

        $overdue = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 7)
                                            ->where('year', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('water_amount');
                                            });
        $total_overdue = collect(range(1, 12))->map(function ($month) use ($overdue) {
            return $overdue->get($month, 0);
        })->values();
        
        return $cepl = [
            'total_income' => $total_income,
            'total_overdue' => $total_overdue
        ];
        
    }
    public function water_usage_unit(Request $request)
    {
        
        $year = $request->input('year', now()->year);

        $invoiceByMonth = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 9)
                                            ->where('year', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('water_unit');
                                            });
        $total_by_renter = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        })->values();

        $water = Water::where("ref_branch_id", session("branch_id"))
                                            ->whereYear('payment_date', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('use_unit');
                                            });
        $total_water = collect(range(1, 12))->map(function ($month) use ($water) {
            return $water->get($month, 0);
        })->values();
        
        return $cepl = [
            'total_by_renter' => $total_by_renter,
            'total_water' => $total_water
        ];
    }
    // ----------------------------------------------
    // ----------------------------------------------
    // ----------------------------------------------
    // ----------------------------------------------
    // ----------------------------------------------
    public function elect(Request $request)
    {
        $data['page_url'] = "analysis/elect";
        return view('analysis/analysis-elect', $data);
    }
    public function calculate_ele_income_expense(Request $request)
    {
        $year = $request->input('year', now()->year);
        $total_expense = Electricity::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                        ->sum('amount');
        $total_income = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('year', $year)
                                            ->where('ref_status_id', 5)
                                            ->get()
                                            ->sum->total_e_l_e_amount;

        return ['total_expense' => number_format($total_expense), 'total_income' => number_format($total_income), 'total_income_total_expense' => number_format($total_income-$total_expense)];
    }
    public function calculate_ele_usage(Request $request)
    {
        $year = $request->input('year', now()->year);
        $total_expense = Electricity::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                        ->sum('amount');
        $total_income = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('year', $year)
                                            ->where('ref_status_id', 5)->get()->sum->total_e_l_e_amount;
        $total = $total_income + $total_expense;

        $percent_income = 0;
        $percent_expense = 0;

        if ($total > 0) {
            $percent_income = round(($total_income / $total) * 100, 2);
            $percent_expense = round(($total_expense / $total) * 100, 2);
        }
        return [$percent_expense, $percent_income];
    }
    public function calculate_ele_profit_loss(Request $request)
    {
        $year = $request->input('year', now()->year);

        $elect_get = Electricity::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                        ->get()
                                        ->groupBy(function ($item) {
                                            return (int) Carbon::parse($item->date)->format('m');
                                        })
                                        ->map(function ($group) {
                                            return $group->sum('amount');
                                        });
        $electricity = collect(range(1, 12))->map(function ($month) use ($elect_get) {
            return $elect_get->get($month, 0);
        })->values();

        $invoiceByMonth = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 5)
                                            ->where('year', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('electricity_amount');
                                            });
        $total_income = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        })->values();

        $cepl = [
                    $electricity[0] - $total_income[0],
                    $electricity[1] - $total_income[1],
                    $electricity[2] - $total_income[2],
                    $electricity[3] - $total_income[3],
                    $electricity[4] - $total_income[4],
                    $electricity[5] - $total_income[5],
                    $electricity[6] - $total_income[6],
                    $electricity[7] - $total_income[7],
                    $electricity[8] - $total_income[8],
                    $electricity[9] - $total_income[9],
                    $electricity[10] - $total_income[10],
                    $electricity[11] - $total_income[11]
                ];

        return $cepl;
    }
    public function electricity_expenses(Request $request)
    {
        $year = $request->input('year', now()->year);

        $invoiceByMonth = Electricity::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                        ->get()
                                        ->groupBy(function ($item) {
                                            return (int) Carbon::parse($item->date)->format('m');
                                        })
                                        ->map(function ($group) {
                                            return $group->sum('amount');
                                        });
        $monthlyTotals = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        });

        return $monthlyTotals->values();
    }
    public function renter_income_baht(Request $request)
    {
        $year = $request->input('year', now()->year);

        $invoiceByMonth = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 5)
                                            ->where('year', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('electricity_amount');
                                            });
        $total_income = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        })->values();

        $overdue = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 7)
                                            ->where('year', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('electricity_amount');
                                            });
        $total_overdue = collect(range(1, 12))->map(function ($month) use ($overdue) {
            return $overdue->get($month, 0);
        })->values();
        
        return $cepl = [
            'total_income' => $total_income,
            'total_overdue' => $total_overdue
        ];
        
    }
    public function electricity_usage_unit(Request $request)
    {
        
        $year = $request->input('year', now()->year);

        $invoiceByMonth = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 9)
                                            ->where('year', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('electricity_unit');
                                            });
        $total_by_renter = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        })->values();

        $elect = Electricity::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('use_unit');
                                            });
        $total_elect = collect(range(1, 12))->map(function ($month) use ($elect) {
            return $elect->get($month, 0);
        })->values();
        
        return $cepl = [
            'total_by_renter' => $total_by_renter,
            'total_elect' => $total_elect
        ];
    }
    public function meter(Request $request)
    {
        // $year = date('Y');
        // $room = Room::orderBy('rooms.id')->limit(10)->get();
        // foreach($room as $ro){
        //     // $meter = Meter::orderBy('year')->orderBy('month')->where('year', date('Y'))->where('ref_room_id', $ro->id)->get();
        //     $start = now()->subMonths(11); // 11 เดือนก่อนหน้า + เดือนปัจจุบัน = 12 เดือน
        //     $end   = now();
            
        //     $months = collect(range(0, 11)) // 12 เดือน
        //                 ->mapWithKeys(function ($i) {
        //                     $month = \Carbon\Carbon::now()->subMonths(11 - $i)->month;
        //                     return [$month => 0];
        //                 })
        //                 ->toArray();

        //     $meters = Meter::where('ref_room_id', $ro->id)
        //                     ->whereBetween(DB::raw("STR_TO_DATE(CONCAT(year,'-',LPAD(month,2,'0'),'-01'), '%Y-%m-%d')"), [
        //                         $start->startOfMonth(),
        //                         $end->endOfMonth()
        //                     ])
        //                     ->orderBy('year')
        //                     ->orderBy('month')
        //                     ->get();
        //     foreach($meters as $key => $meter){
        //             $meter;
        //             $electricity_unit = Meter::where('ref_room_id', $ro->id)->where('id', '<' , $meter->id)->latest('id')->first()->electricity_unit ?? 0;
        //             $months[$meter->month] = intval($meter->electricity_unit) - intval($electricity_unit);
        //         // $months[$meter->month]
        //     }
        //     return $months;

        // }
        // return $results = Room::orderBy('rooms.name')
        //                 ->leftJoin('meters', 'meters.ref_room_id', '=', 'rooms.id')
        //                 ->leftJoin('floors', 'floors.id', '=', 'rooms.ref_floor_id')
        //                 ->leftJoin('buildings', 'buildings.id', '=', 'floors.ref_building_id')
        //                 ->Where('meters.year', $year)
        //                 ->where('ref_branch_id',session("branch_id"))
        //                 ->with([
        //                     'meterPrevious' => fn($q) => $q->where('year', $year),
        //                 ])
        //                 ->select('rooms.id as room_id',
        //                         'meters.water_unit',
        //                         'meters.meter_before_change',
        //                         'meters.start_value_of_new_meter',
        //                         'meters.electricity_unit',
        //                         DB::raw("
        //                             CASE meters.ref_reason_id
        //                                 WHEN 1 THEN 'มิเตอร์เต็ม'
        //                                 WHEN 2 THEN 'เปลี่ยนมิเตอร์'
        //                                 ELSE ''
        //                             END as reason_name
        //                         "),
        //                         'meters.id as meters_id')
        //                 ->get();

        $data['page_url'] = "analysis/meter";
        return view('analysis/analysis-meter', $data);
    }
    public function meter_usage_unit(Request $request)
    {
        
        $year = $request->input('year', now()->year);

        $invoiceByMonth = RentBill::with('payment_list')
                                            ->whereHas('room.floor.building', function ($query) {
                                                $query->where('ref_branch_id', session("branch_id"));
                                            })
                                            ->where('ref_status_id', 9)
                                            ->where('year', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('electricity_unit');
                                            });
        $total_by_renter = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        })->values();

        $elect = Electricity::where("ref_branch_id", session("branch_id"))
                                        ->whereYear('payment_date', $year)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return (int) Carbon::parse($item->date)->format('m');
                                            })
                                            ->map(function ($group) {
                                                return $group->sum('use_unit');
                                            });
        $total_elect = collect(range(1, 12))->map(function ($month) use ($elect) {
            return $elect->get($month, 0);
        })->values();
        
        return $cepl = [
            'total_by_renter' => $total_by_renter,
            'total_elect' => $total_elect
        ];
    }
    
    public function get_room_floor(Request $request)
    {
        
        $data['buildings'] = Building::where('ref_branch_id', session("branch_id"))->get();
        $data['floors'] = Floor::whereHas('building', function ($query) {
                                        $query->where('ref_branch_id', session("branch_id"));
                                    })->get();

        $floors_previous_id = Floor::orderBy('ref_building_id')->orderBy('name')->whereHas('building', function ($query) {
                                $query->where('ref_branch_id', session("branch_id"));
                            })
                            ->where('id', '<', $request->ref_floor_id)
                            ->latest('name')
                            ->first()->id ?? null;

        $floors_next_id = Floor::orderBy('ref_building_id')->orderBy('name')->whereHas('building', function ($query) {
                                $query->where('ref_branch_id', session("branch_id"));
                            })
                            ->where('id', '>', $request->ref_floor_id)
                            ->oldest('name')
                            ->first()->id ?? null;

        $results = Room::orderBy('rooms.name')
                                ->where('ref_floor_id', $request->ref_floor_id)
                                ->get();
                                
        $months = collect(range(0, 5)) // 6 เดือนล่าสุด
                    ->mapWithKeys(function ($i) {
                        $date = \Carbon\Carbon::now()->subMonths(5 - $i); // 5 - $i เพื่อเรียงจากเก่า -> ใหม่
                        $key = $date->month . '/' . $date->year; // รวมเดือน/ปี
                        return [$key => 0];
                    })
                    ->toArray();

        $months_water = $months;

        foreach($results as $ro){
            // $meter = Meter::orderBy('year')->orderBy('month')->where('year', date('Y'))->where('ref_room_id', $ro->id)->get();
            $start = now()->subMonths(5); // 11 เดือนก่อนหน้า + เดือนปัจจุบัน = 12 เดือน
            $end   = now();
            
            $meters = Meter::where('ref_room_id', $ro->id)
                            ->whereBetween(DB::raw("STR_TO_DATE(CONCAT(year,'-',LPAD(month,2,'0'),'-01'), '%Y-%m-%d')"), [
                                $start->startOfMonth(),
                                $end->endOfMonth()
                            ])
                            ->orderBy('year')
                            ->orderBy('month')
                            ->get();
            foreach($meters as $key => $meter){
                    $last_unit = Meter::where('ref_room_id', $ro->id)->where('id', '<' , $meter->id)->latest('id')->first();
                    $months[$meter->month.'/'.$meter->year] = intval($meter->electricity_unit) - intval($last_unit->electricity_unit ?? 0);
                    $months_water[$meter->month.'/'.$meter->year] = intval($meter->water_unit) - intval($last_unit->water_unit ?? 0);
                // $months[$meter->month]
            }
            $ro['months'] = [
                                'elect' => array_values($months),
                                'water' => array_values($months_water)
                            ];
        }
        
        $data['rooms'] = $results;
        $data['months'] = array_keys($months);
        $data['floor_id'] = $request->ref_floor_id;
        $data['floors_previous_id'] = $floors_previous_id;
        $data['floors_next_id'] = $floors_next_id;

        return view('analysis/analysis-meter-table', $data);
    }

    public function tenants(Request $request)
    {
        $all_receipt_men = Receipt::whereHas('room.floor.building', function ($query) {
                                            $query->where('ref_branch_id',  session("branch_id"));
                                        })
                                        ->whereHas('renter', function ($q) {
                                            $q->where('prefix', 'นาย');
                                        })
                                        ->get() // ดึงข้อมูลออกมาเป็น Collection
                                        ->sum(function ($receipt) {
                                            return $receipt->total_amount; // ใช้ accessor ที่คุณเขียนไว้
                                        });

        $all_receipt_women = Receipt::whereHas('room.floor.building', function ($query) {
                                            $query->where('ref_branch_id',  session("branch_id"));
                                        })
                                        ->whereHas('renter', function ($q) {
                                            $q->whereIn('prefix', ['นาง','นางสาว']);
                                        })
                                        ->get() // ดึงข้อมูลออกมาเป็น Collection
                                        ->sum(function ($receipt) {
                                            return $receipt->total_amount; // ใช้ accessor ที่คุณเขียนไว้
                                        });

        $all_receipt_not_specified = Receipt::whereHas('room.floor.building', function ($query) {
                                            $query->where('ref_branch_id',  session("branch_id"));
                                        })
                                        ->whereHas('renter', function ($q) {
                                            $q->whereIn('prefix', ['บริษัท']);
                                        })
                                        ->get() // ดึงข้อมูลออกมาเป็น Collection
                                        ->sum(function ($receipt) {
                                            return $receipt->total_amount; // ใช้ accessor ที่คุณเขียนไว้
                                        });
        $total = $all_receipt_men + $all_receipt_women + $all_receipt_not_specified;

            $percent_all_receipt_men = 0;
            $percent_all_receipt_women = 0;
            $percent_all_receipt_not_specified = 0;

        if ($total > 0) {
            $percent_all_receipt_men = ($all_receipt_men / $total) * 100;
            $percent_all_receipt_women = ($all_receipt_women / $total) * 100;
            $percent_all_receipt_not_specified = ($all_receipt_not_specified / $total) * 100;
        }
        $data['percent_all_receipt_men'] = number_format($percent_all_receipt_men);
        $data['percent_all_receipt_women'] = number_format($percent_all_receipt_women);
        $data['percent_all_receipt_not_specified'] = number_format($percent_all_receipt_not_specified);

        $data['page_url'] = "analysis/tenants";
        return view('analysis/analysis-tenants', $data);
    }
    public function move_in_out(Request $request)
    {
        // $contract = Contract::orderBy('id','ASC')->whereYear('created_at', 2025)->get();
        $raw = Contract::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                        // ->whereHas('room', function ($query) {
                        //     $query->where('status', '!=', 0);
                        // })
                        ->whereYear('created_at', 2025)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->pluck('total','month');

        $raw_out = Contract::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                        ->whereHas('room', function ($query) {
                            $query->where('status', 0);
                        })
                        ->whereYear('created_at', 2025)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->pluck('total','month');

        $rentIn = [];
        $rentOut = [];
        for ($i = 1; $i <= 12; $i++) {
            $rentIn[] = $raw[$i] ?? 0;
            $rentOut[] = $raw_out[$i] ?? 0;
        }

        $data['rentIn']  = $rentIn;
        $data['rentOut'] = $rentOut;
        return $data;

    }
}
