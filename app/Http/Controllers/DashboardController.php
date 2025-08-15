<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Room;
use App\Models\Receipt;
use App\Models\Position;
use App\Models\Branch;
use App\Models\Work_shift;
use App\Models\Schedule;
use App\Models\Leave;
use App\Models\RentBill;
use App\Models\RoomForRents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

DB::beginTransaction();

class DashboardController extends Controller
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
    public function index(Request $request, $id = null)
    {
        // return $lastMonth = Carbon::now()->subMonth()->year;
        // return session("branch_id");
        if(!is_null($id)){
            session(["branch_id" => $id]);
            return redirect('dashboard');
        }


        $data['page_url'] = 'dashboard';
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
        $data['percent_on_time'] = $percent_on_time;
        $data['percent_late_with_appointment'] = $percent_late_with_appointment;
        $data['percent_late'] = $percent_late;
        $data['summary'] = $summary;

        return view('dashboard/index', $data);
    }
    public function overdue(Request $request)
    {
        $all_overdue_payment = RentBill::with('payment_list')
                                        ->whereHas('room_for_rent.room.floor.building', function ($query) {
                                            $query->where('ref_branch_id', session("branch_id"));
                                        })
                                        ->where('rent_bills.ref_status_id', 7)
                                        ->get()
                                        ->sum('total_amount'); // ใช้ accessor ในการ sum

        $data['page_url'] = 'dashboard';
        $data['summary'] = $this->summary(session("branch_id"));
        $data['all_overdue_payment'] = $all_overdue_payment;
        return view('dashboard/overdue', $data);
    }
    public function datatable(Request $request)
    {
        $results = Room::with([
                                'rent_bill_247.payment_list',
                                'room_for_rent_main.renter',
                                'rent_bill_247.receipt.payment_list'
                        ])
                        ->whereHas('floor.building', function ($query) {
                            $query->where('ref_branch_id', session("branch_id"));
                        })
                        ->whereHas('rent_bill', function ($query) {
                            $query->whereIn('ref_status_id', [2,4,7]);
                        })
                        ->distinct('rooms.id')
                        // ->whereHas('rent_bills', function ($query) {
                            // $query->where('ref_status_id', 7);
                        // })
                        ->paginate($request->limit ?? 15);
        
        // if(@$request->search){
        //     $results = $results->Where(function ($query) use ($request) {
        //                             $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', renters.surname) LIKE ?", ["%{$request->search}%"])
        //                                 ->orWhere('rooms.name','LIKE','%'.$request->search.'%');
        //                         });
        // }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }
        // // $data['prefix'] = [ 1 => 'บริษัท', 2 => 'นาย', 3 => 'นางสาว', 4 => 'นาง'];
        // $results = $results->paginate($limit);
        // return $results->items();
        // dd($results);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;

        return view('dashboard/table', $data);
    }
    public function monthly_rent_income(Request $request)
    {
        $year = $request->input('year', now()->year);

        $invoiceByMonth = \App\Models\Receipt::whereHas('room.floor.building', function ($query) {
                                                    $query->where('ref_branch_id', session("branch_id"));
                                                })
                                                ->whereHas('invoice', function ($query) {
                                                    $query->where('ref_status_id', 5);
                                                })
                                                ->with('payment_list')
                                                ->where('ref_type_id', 1)
                                                ->whereYear('updated_at', $year)
                                                ->get()
                                                ->groupBy(function ($item) {
                                                    return (int) $item->updated_at->format('m');
                                                })
                                                ->map(function ($group) {
                                                    return $group->sum('total_amount');
                                                });
        $monthlyTotals = collect(range(1, 12))->map(function ($month) use ($invoiceByMonth) {
            return $invoiceByMonth->get($month, 0);
        });

        return response()->json($monthlyTotals->values());
    }
    public function change_password_form()
    {
        $user = Auth::user();

        $user->work_start_date_th = $this->ChangeDateToTH($user->work_start_date);
        $user->birthday_th = $this->ChangeDateToTH($user->birthday);

        $data['user'] = $user;
        return view('dashboard/change_password', $data);

    }
    public function invoice($id)
    {
        $data['page_url'] = 'dashboard';
        $invoice = RentBill::find($id);
        $data['invoice'] = $invoice;

        return view('dashboard/invoice', $data);
    }
    
    public function ChangeDateToTH($date)
    {
        ////////////////////// แปลงรูปแบบวันเกิดเป็น ไทย
        // สร้าง Carbon instance จากวันที่
        $m = date('m', strtotime($date));
        $date = Carbon::createFromFormat('Y-m-d', $date);

        // คำนวณปีพุทธศักราช
        $buddhistYear = $date->year + 543;

        // แปลงวันที่เป็นรูปแบบไทย
        $thaiDate = $date->formatLocalized('%e %B ' . $buddhistYear);
        
        $monthTH = [ 
                "01" => "มกราคม",
                "02" => "กุมภาพันธ์",
                "03" => "มีนาคม",
                "04" => "เมษายน",
                "05" => "พฤษภาคม",
                "06" => "มิถุนายน",
                "07" => "กรกฎาคม",
                "08" => "สิงหาคม",
                "09" => "กันยายน",
                "10" => "ตุลาคม",
                "11" => "พฤศจิกายน",
                "12" => "ธันวาคม"
        ];
        $monthEN = [    
                "01" => "January",
                "02" => "February",
                "03" => "March",
                "04" => "April",
                "05" => "May",
                "06" => "June",
                "07" => "July",
                "08" => "August",
                "09" => "September",
                "10" => "October",
                "11" => "November",
                "12" => "December"
        ];
        return str_replace($monthEN[$m], $monthTH[$m], $thaiDate);
    }
}
