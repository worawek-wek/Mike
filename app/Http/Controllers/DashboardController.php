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
        if(!is_null($id)){
            session(["branch_id" => $id]);
            return redirect('dashboard');
        }
        $data['page_url'] = 'dashboard';
        $data['summary'] = $this->summary(session("branch_id"));

        return view('dashboard/index', $data);
    }
    public function overdue(Request $request)
    {
        $all_overdue_payment = RentBill::where('rent_bills.ref_status_id', 7)
                                        ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                        ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                        ->sum(DB::raw('rooms.rent + rent_bills.electricity_amount + rent_bills.water_amount'));

        $data['page_url'] = 'dashboard';
        $data['summary'] = $this->summary(session("branch_id"));
        $data['all_overdue_payment'] = $all_overdue_payment;
        return view('dashboard/overdue', $data);
    }
    public function datatable(Request $request)
    {
        $year = $request->input('year', now()->year);

        $invoiceByMonth = \App\Models\RentBill::with('payment_list')
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

        // return response()->json($monthlyTotals->values());
        // // ผลลัพธ์: [1 => xxx, 2 => yyy, ..., 12 => zzz]
        //     return 12354;

        // return view('dashboard/table', $data);

        $results = RentBill::orderBy('id','DESC')
                                ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->Where('rent_bills.ref_status_id', 7)
                                ->select('rent_bills.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
        
        if(@$request->search){
            $results = $results->Where(function ($query) use ($request) {
                                    $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', renters.surname) LIKE ?", ["%{$request->search}%"])
                                        ->orWhere('rooms.name','LIKE','%'.$request->search.'%');
                                });
        }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }
        // $data['prefix'] = [ 1 => 'บริษัท', 2 => 'นาย', 3 => 'นางสาว', 4 => 'นาง'];
        $results = $results->paginate($limit);
        // return $results->items();
        // dd($results);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;

        return view('dashboard/table', $data);
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
