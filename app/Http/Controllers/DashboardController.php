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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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
        $summary_month = $this->summary(session("branch_id"), date('m'), date('Y'));
        // return $summary['all_receipt_late'];
        $total = $summary_month['all_receipt_on_time'] + $summary_month['all_receipt_late_with_appointment'] + $summary_month['all_receipt_late'];

        if ($total > 0) {
            $data['persen_overview'] = "100";
            $percent_on_time = ($summary_month['all_receipt_on_time'] / $total) * 100;
            $percent_late_with_appointment = ($summary_month['all_receipt_late_with_appointment'] / $total) * 100;
            $percent_late = ($summary_month['all_receipt_late'] / $total) * 100;
        } else {
            $data['persen_overview'] = "0";
            $percent_on_time = $percent_late_with_appointment = $percent_late = 0;
        }
        $data['percent_on_time'] = number_format($percent_on_time);
        $data['percent_late_with_appointment'] = number_format($percent_late_with_appointment);
        $data['percent_late'] = number_format($percent_late);
        $data['summary'] = $summary;
        $data['summary_month'] = $summary_month;

        return view('dashboard/index', $data);
    }
    public function overdue(Request $request)
    {
        $all_overdue_payment = RentBill::with('payment_list')
                                        ->whereHas('room_for_rent.room.floor.building', function ($query) {
                                            $query->where('ref_branch_id', session("branch_id"));
                                        })
                                        ->whereIn('ref_status_id', [2, 4, 7])
                                        ->get()
                                        ->sum('total_amount'); // ใช้ accessor ในการ sum

        $data['page_url'] = 'dashboard';
        $data['summary'] = $this->summary(session("branch_id"));
        $data['all_overdue_payment'] = $all_overdue_payment;
        return view('dashboard/overdue', $data);
    }
    public function datatable(Request $request)
    {
        
        $perPage = $request->limit ?? 15;
        $page = Paginator::resolveCurrentPage('page');

        $overdueBills = Room::whereHas('floor.building', function ($query) {
                                    $query->where('ref_branch_id', session('branch_id'));
                                })
                                ->whereHas('rent_bill', function ($query) {
                                    $query->whereIn('ref_status_id', [2, 4, 7]);
                                });

        $limit = $request['limit'] ?? 15;

        $overdueBills = $overdueBills->paginate($limit);
                                    // ->filter(function ($bill) {
                                    //     $paidAmount = $bill->receipt->flatMap->payment_list_not_fine->sum('price');
                                    //     return $paidAmount < $bill->total_amount; // ยอดค้างชำระ
                                    // })
                                    // ->values();

        // ทำ paginate หลังจาก filter
        // $page = request()->get('page', 1);
        // $perPage = $request->limit ?? 15;
        // $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
        //     $overdueBills->forPage($page, $perPage),
        //     $overdueBills->count(),
        //     $perPage,
        //     $page,
        //     ['path' => request()->url(), 'query' => request()->query()]
        // );

        $data['list_data'] = $overdueBills;
        $data['query'] = request()->query();
        $data['query']['limit'] = $request->limit ?? 15;

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
    public function invoice($room_id)
    {
        $room = Room::find($room_id);
        $invoice = RentBill::with(['receipt.payment_list_not_fine', 'room_for_rent.room.floor.building'])
                            ->whereIn('ref_status_id', [2, 4, 7])
                            ->where('ref_room_id', $room_id)
                            ->get();
        // $receipt = Receipt::where('ref_rent_bill_id', $id)->get();
        // $fine_invoice = PaymentList::where('ref_payment_id', $id)->where('document_type', 1)->where('fine', 1)->first();
        // $data['fine_invoice_price'] = 0;
        // if(@$fine_invoice){
        //     $data['fine_invoice_price'] = $fine_invoice->price;
        // }
        // $invoice_fine = PaymentList::where('ref_payment_id', $id)->where('document_type', 1)->where('fine', 1)->first();
        // $data['fine_price'] = $invoice_fine->price ?? 0;
        // if(@$receipt){
        //     foreach($receipt as $rec){
        //         $fine = PaymentList::where('ref_payment_id', $rec->id)->where('document_type', 2)->where('fine', 1)->first();
        //         if(@$fine){
        //             $data['fine_price'] = $invoice_fine->price - $fine->price;
        //         }
        //     }
        // }
        // $contract = Contract::find($invoice->ref_contract_id);
        // $data['expenses'] = AdditionalCosts::where('ref_rent_bill_id', $id)->get();
        // $data['invoice'] = $invoice;
        // $data['contract'] = $contract;
        // $data['bank'] = Bank::get();
        // $data['days'] = [
        //     'Sunday'    => 'อาทิตย์',
        //     'Monday'    => 'จันทร์',
        //     'Tuesday'   => 'อังคาร',
        //     'Wednesday' => 'พุธ',
        //     'Thursday'  => 'พฤหัสบดี',
        //     'Friday'    => 'ศุกร์',
        //     'Saturday'  => 'เสาร์',
        // ];
        
        // $prevMonth = (int)$invoice->month - 1;
        // $prevYear = (int)$invoice->year;

        // if ($prevMonth < 1) {
        //     $prevMonth = 12;
        //     $prevYear -= 1;
        // }

        // $prevMonth = str_pad($prevMonth, 2, '0', STR_PAD_LEFT);
        
        // $data['meterPrevious'] = Meter::where('ref_room_id', $contract->ref_room_id)->where('month', $prevMonth)->where('year', $prevYear)->first();

        $data['page_url'] = 'dashboard';
        // $invoice = RentBill::find($id);
        $data['room'] = $room;
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
