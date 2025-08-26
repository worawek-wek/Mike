<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Room;
use App\Models\Contract;
use App\Models\Position;
use App\Models\Branch;
use App\Models\Receipt;
use App\Models\RentBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
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
        $data['page_url'] = 'report/view-overview';
        
        return view('report/report-viewOverview', $data);
    }
    public function view_overview_datatable(Request $request)
    {
        $results = Receipt::orderBy('rooms.id','ASC')
                                ->join('rent_bills', 'receipts.ref_rent_bill_id', '=', 'rent_bills.id')
                                ->join('renters', 'receipts.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'receipts.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                ->where('rent_bills.ref_status_id', 5)
                                ->distinct('rooms.id')
                                ->select('receipts.*','rent_bills.water_amount','rent_bills.electricity_amount', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.id as room_id', 'rooms.rent', 'renters.phone');
        
        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->where('rent_bills.year', $year)
                            ->where('rent_bills.month', $month);
        }

        $limit = $request->limit ?? 15;

        $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;

        return view('report/report-viewOverview-table', $data);
    }
    // รายงานบิลค่าเช่า
    public function rent_bill(Request $request)
    {
        $data['page_url'] = 'report/rent-bill';


        return view('report/report-rentBill', $data);
    }
    public function rent_bill_datatable(Request $request)
    {
        $results = Receipt::orderBy('rooms.id','ASC')
                                ->join('rent_bills', 'receipts.ref_rent_bill_id', '=', 'rent_bills.id')
                                ->join('renters', 'receipts.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'receipts.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                ->where('rent_bills.ref_status_id', 5)
                                ->distinct('receipts.id')
                                ->select('receipts.*','rent_bills.water_amount','rent_bills.electricity_amount', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.id as room_id', 'rooms.rent', 'renters.phone');
        
        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->where('rent_bills.year', $year)
                            ->where('rent_bills.month', $month);
        }

        $limit = $request->limit ?? 15;

        $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;

        return view('report/report-rentBill-table', $data);
    }
    public function rent_bill_summary(Request $request)
    {
        $paid = Receipt::with('payment_list') // เพื่อ preload
                            ->join('rent_bills', 'receipts.ref_rent_bill_id', '=', 'rent_bills.id')
                            ->where('rent_bills.ref_status_id', 5)
                            ->where('rent_bills.ref_type_id', 1)
                            ->select('receipts.*');
        
        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $paid = $paid->where('rent_bills.year', $year)
                            ->where('rent_bills.month', $month);
        }                    
        $paid = $paid->get()->sum(function($receipt) {
                                return $receipt->total_amount;
                            });                    
        // return $overdue = $paid->get()->sum->total_amount;

        ////////////////////////////////////////////////////////////////

        $overdue = RentBill::with('payment_list')
                            ->where('ref_status_id', "!=", 3)
                            ->where('ref_type_id', 1);
                            
        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $overdue = $overdue->where('rent_bills.year', $year)
                            ->where('rent_bills.month', $month);
        }                    
            $overdue = $overdue->get()
                            ->sum(function($rent_bill) {
                                return $rent_bill->total_amount;
                            });

        $data['paid'] = number_format($paid).' บาท';
        $data['overdue'] = number_format($overdue-$paid).' บาท';

        $transfer = $this->summary(session("branch_id"), $month, $year)['transfer'];
        $cash = $this->summary(session("branch_id"), $month, $year)['cash'];
        $cash_wait_for_confirm = $this->summary(session("branch_id"), $month, $year)['cash_wait_for_confirm'];
        
        $total_all = $transfer + $cash + $cash_wait_for_confirm;

        if($total_all > 0){
            $percent_transfer = $total_all > 0 ? ($transfer / $total_all) * 100 : 0;
            $percent_cash    = $total_all > 0 ? ($cash / $total_all) * 100 : 0;
            $percent_cash_wait_for_confirm   = 100 - ($percent_transfer + $percent_cash);
        }

        $data['transfer'] = $transfer;
        $data['cash'] = $cash;
        $data['cash_wait_for_confirm'] = $cash_wait_for_confirm;

        $data['percent_transfer'] = number_format($percent_transfer ?? 0);
        $data['percent_cash'] = number_format($percent_cash ?? 0);
        $data['percent_cash_wait_for_confirm'] = number_format($percent_cash_wait_for_confirm ?? 0);
        
        // foreach ($values as $value) {
        //         $percent = ($value / $total) * 100;
        //         echo number_format($value, 2) . " = " . number_format($percent, 2) . "%<br>";
        //     }

        return view('report/report-header', $data);
    }
    public function move_in(Request $request)
    {
        $data['page_url'] = 'report/move-in';
        $data['sum'] = $this->summary_calculate();
        $data['sum_room'] = Room::whereHas('floor.building', function ($query) {
                                        $query->where('ref_branch_id', session("branch_id"));
                                    })->where('status', 2)->count();

        return view('report/report-moveIn', $data);
    }
    public function move_in_datatable(Request $request)
    {
        $results = Contract::orderBy('id','ASC');

        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->whereYear('created_at', $year)
                                ->whereMonth('created_at', $month);
        }

        $limit = $request->limit ?? 15;

        $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;

        return view('report/report-moveIn-table', $data);
    }
    public function move_out(Request $request)
    {
        return view('report/report-moveOut');
    }
    public function badDebt(Request $request)
    {
        $data['count_room'] = RentBill::orderBy('rooms.name', 'ASC')
                                        ->join('room_for_rents', function ($join) {
                                            $join->on('rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                                ->where('room_for_rents.status', 0); // ใส่เงื่อนไขเพิ่มตรงนี้
                                        })
                                        ->join('rooms', 'rent_bills.ref_room_id', '=', 'rooms.id')
                                        ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                        ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                        ->where('buildings.ref_branch_id', session("branch_id"))
                                        ->where('rent_bills.ref_type_id', 1)
                                        ->where('rent_bills.ref_status_id', '!=', 5)
                                        ->where('room_for_rents.move_out_type', 2)
                                        ->distinct('rent_bills.id')
                                        ->count('rent_bills.id');
                                        
        $data['totalAmount'] = RentBill::orderBy('rooms.name', 'ASC')
                                        ->join('room_for_rents', function ($join) {
                                            $join->on('rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                                ->where('room_for_rents.status', 0); // ใส่เงื่อนไขเพิ่มตรงนี้
                                        })
                                        ->join('rooms', 'rent_bills.ref_room_id', '=', 'rooms.id')
                                        ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                        ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                        ->where('buildings.ref_branch_id', session("branch_id"))
                                        ->where('rent_bills.ref_type_id', 1)
                                        ->where('rent_bills.ref_status_id', '!=', 5)
                                        ->where('room_for_rents.move_out_type', 2)
                                        ->select(
                                            'rent_bills.*',
                                            'room_for_rents.payment_method as payment_method',
                                            'room_for_rents.date_stay as date_stay',
                                            'rooms.name as room_name',
                                            'rooms.rent'
                                        )
                                        ->with('payment_list') // โหลดความสัมพันธ์เพื่อใช้ accessor
                                        ->get()
                                        ->sum(function ($bill) {
                                            return $bill->total_amount; // ใช้ accessor ที่คุณเขียนไว้
                                        });

        $data['page_url'] = 'report/bad-debt';
        return view('report/report-badDebt', $data);
    }
    public function badDebt_datatable(Request $request)
    {
        // $receipt = Receipt:;
        $results = RentBill::orderBy('rooms.name', 'ASC')
                            ->join('room_for_rents', function ($join) {
                                $join->on('rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                    ->where('room_for_rents.status', 0); // ใส่เงื่อนไขเพิ่มตรงนี้
                            })
                            ->join('rooms', 'rent_bills.ref_room_id', '=', 'rooms.id')
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->where('buildings.ref_branch_id', session("branch_id"))
                            ->where('rent_bills.ref_type_id', 1)
                            ->where('rent_bills.ref_status_id', '!=', 5)
                            ->where('room_for_rents.move_out_type', 2)
                            ->select(
                                'rent_bills.*',
                                'room_for_rents.payment_method as payment_method',
                                'room_for_rents.date_stay as date_stay',
                                'rooms.name as room_name',
                                'rooms.rent'
                            )
                            ->with('payment_water')
                            ->distinct('rent_bills.id');

                        // ตรวจสอบว่า $request->month มีค่าและอยู่ในรูปแบบที่ถูกต้อง
        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->where('rent_bills.year', $year)
                            ->where('rent_bills.month', $month);
        }

                        // จัดการเรื่อง limit
        $limit = $request->limit ?? 15;

        $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;
        
        return view('report/report-badDebt-table', $data);
    }
    public function badDebt_export_excel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $results = RentBill::orderBy('rooms.name', 'ASC')
                            ->join('room_for_rents', function ($join) {
                                $join->on('rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                    ->where('room_for_rents.status', 0); // ใส่เงื่อนไขเพิ่มตรงนี้
                            })
                            ->join('rooms', 'rent_bills.ref_room_id', '=', 'rooms.id')
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->where('buildings.ref_branch_id', session("branch_id"))
                            ->where('rent_bills.ref_type_id', 1)
                            ->where('rent_bills.ref_status_id', '!=', 5)
                            ->where('room_for_rents.move_out_type', 2)
                            ->select(
                                'rent_bills.*',
                                'room_for_rents.payment_method as payment_method',
                                'room_for_rents.date_stay as date_stay',
                                'rooms.name as room_name',
                                'rooms.rent'
                            )
                            ->with('payment_water')
                            ->distinct('rent_bills.id');

        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->where('rent_bills.year', $year)
                            ->where('rent_bills.month', $month);
        }


        $results = $results->get();
        
        $data = 
        [
            [
                'รายงานหนี้สูญ วันที่ '.date('d/m/Y')
            ],
            [
                "ห้อง",
                "รอบบิล",
                "ค่าเช่าห้อง",
                "ค่าน้ำ",
                "ค่าไฟ",
                "ชำระแล้ว",
                "คืนเงินประกัน",
                "แจ้งหนี้โดย",
                "วันที่",
            ]
        ];
        foreach($results as $key=>$row){
            $data[] = [
                        $key+1,
                        $row->room_name,
                        $row->month.'/'.$row->year,
                        $row->rent,
                        $row->payment_water->price,
                        $row->payment_electricity->price,
                        0,
                        0,
                        date('d/m/Y',strtotime($row->created_at)),
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);
        $sheet->getStyle(
            'A1:' . 
            $sheet->getHighestColumn() . 
            $sheet->getHighestRow()
        )->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $writer = new WriterXlsx($spreadsheet);
        $writer->save("upload/export_excel/รายงานหนี้สูญ.xlsx");
        return redirect("upload/export_excel/รายงานหนี้สูญ.xlsx");
    }
    public function monthly_booking(Request $request)
    {
        // $receipt = Receipt:;
        $data['page_url'] = 'report/monthly-booking';
        return view('report/report-monthlyBooking', $data);
    }
    public function monthly_booking_datatable(Request $request)
    {
        // $receipt = Receipt:;
        $results = Receipt::orderBy('rooms.name', 'ASC')
                            ->join('renters', 'receipts.ref_renter_id', '=', 'renters.id')
                            ->join('rooms', 'receipts.ref_room_id', '=', 'rooms.id')
                            ->join('room_for_rents', function($join) {
                                $join->on('receipts.ref_room_id', '=', 'room_for_rents.ref_room_id')
                                    ->whereColumn('receipts.ref_renter_id', '=', 'room_for_rents.ref_renter_id');
                            })
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->where('buildings.ref_branch_id', session("branch_id"))
                            ->where('receipts.ref_type_id', 3)
                            ->select(
                                'receipts.*',
                                'renters.prefix',
                                DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'),
                                'renters.booking_date',
                                'room_for_rents.payment_method as payment_method',
                                'room_for_rents.date_stay as date_stay',
                                'rooms.name as room_name',
                                'rooms.rent'
                            )
                            ->distinct('receipts.id');

                        // ตรวจสอบว่า $request->month มีค่าและอยู่ในรูปแบบที่ถูกต้อง
        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->whereYear('renters.booking_date', $year)
                            ->whereMonth('renters.booking_date', $month);
        }

                        // จัดการเรื่อง limit
        $limit = $request->limit ?? 15;

        $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;
        
        return view('report/report-monthlyBooking-table', $data);
    }
    
    public function rent_bill_excel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
         $results = Receipt::orderBy('rooms.id','ASC')
                                ->join('rent_bills', 'receipts.ref_rent_bill_id', '=', 'rent_bills.id')
                                ->join('renters', 'receipts.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'receipts.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                ->where('rent_bills.ref_status_id', 5)
                                ->distinct('receipts.id')
                                ->select('receipts.*','rent_bills.water_amount','rent_bills.electricity_amount', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.id as room_id', 'rooms.rent', 'renters.phone');
        
        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->where('rent_bills.year', $year)
                            ->where('rent_bills.month', $month);
        }

        $results = $results->get();
        
        $data = 
        [
            [
                "ห้อง",
                "ชื่อผู้เช่า",
                "เลขที่ใบเสร็จ",
                "วันที่รับชำระ",
                "ช่องทาง",
                "รับชำระโดย",
                "ค่าห้องเช่า",
                "ค่าน้ำ",
                "ค่าไฟ",
                "ค่าที่จอด รถยนต์",
                "ค่าที่จอด รถมอเตอร์ไซค์",
                "ส่วนกลาง",
                "รวม",
                "สถานะ"
            ]
        ];
        foreach($results as $key => $row){
            $data[] = [
                        $row->room_name,
                        $row->renter_name,
                        $row->receipt_number,
                        date("d/m/Y" , strtotime($row->payment_date)),
                        $row->payment_method == 1? "เงินสด" : "โอนเงิน",
                        $row->user->name,
                        $row->water_amount,
                        $row->electricity_amount,
                        '-',
                        '-',
                        '-',
                        '-',
                        $row->total_amount,
                        "ชำระแล้ว"
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);
        $sheet->getStyle(
            'A1:' . 
            $sheet->getHighestColumn() . 
            $sheet->getHighestRow()
        )->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $writer = new WriterXlsx($spreadsheet);
        $writer->save("upload/export_excel/รายงานบิลค่าเช่า".date('m-Y', strtotime($request->month)).".xlsx");
        return redirect("upload/export_excel/รายงานบิลค่าเช่า".date('m-Y', strtotime($request->month)).".xlsx");
    }
    public function move_in_excel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $results = Contract::orderBy('id','ASC');

        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->whereYear('created_at', $year)
                                ->whereMonth('created_at', $month);
        }

        $results = $results->get();
        
        $data = 
        [
            [
                "ห้อง",
                "วันที่",
                "โดย",
                "ช่องทาง",
                "ค่าประกันห้อง",
                "หักค่ามัดจำจอง",
                "รวม",
            ]
        ];
        foreach($results as $key => $row){
            $data[] = [
                        $row->room->name,
                        date('d/m/Y', strtotime($row->created_at)),
                        $row->renter->room_for_rent->user->name,
                        $row->renter->room_for_rent->payment_method == 1 ? 'เงินสด': 'โอนเงิน',
                        $row->security_deposit,
                        $row->renter->room_for_rent->deposit,
                        $row->security_deposit+@$row->renter->room_for_rent->deposit
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);
        $sheet->getStyle(
            'A1:' . 
            $sheet->getHighestColumn() . 
            $sheet->getHighestRow()
        )->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $writer = new WriterXlsx($spreadsheet);
        $writer->save("upload/export_excel/รายงานย้ายเข้า".date('m-Y', strtotime($request->month)).".xlsx");
        return redirect("upload/export_excel/รายงานย้ายเข้า".date('m-Y', strtotime($request->month)).".xlsx");
    }
    public function monthly_booking_excel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $results = Receipt::orderBy('rooms.name', 'ASC')
                            ->join('renters', 'receipts.ref_renter_id', '=', 'renters.id')
                            ->join('rooms', 'receipts.ref_room_id', '=', 'rooms.id')
                            ->join('room_for_rents', function($join) {
                                $join->on('receipts.ref_room_id', '=', 'room_for_rents.ref_room_id')
                                    ->whereColumn('receipts.ref_renter_id', '=', 'room_for_rents.ref_renter_id');
                            })
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->where('buildings.ref_branch_id', session("branch_id"))
                            ->where('receipts.ref_type_id', 3)
                            ->select(
                                'receipts.*',
                                'renters.prefix',
                                DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'),
                                'renters.booking_date',
                                'room_for_rents.payment_method as payment_method',
                                'room_for_rents.date_stay as date_stay',
                                'rooms.name as room_name',
                                'rooms.rent'
                            )
                            ->distinct('receipts.id');

                        // ตรวจสอบว่า $request->month มีค่าและอยู่ในรูปแบบที่ถูกต้อง
        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->whereYear('renters.booking_date', $year)
                            ->whereMonth('renters.booking_date', $month);
        }

        $results = $results->get();
        
        $data = 
        [
            [
                "ห้อง",
                "ชื่อผู้จอง",
                "หมายเลขการจอง",
                "วันที่จอง",
                "วันที่เข้าพัก",
                "ช่องทาง",
                "รับจองโดย",
                "ค่ามัดจำ",
                "รวม",
                "สถานะ"
            ]
        ];
        foreach($results as $key => $row){
            $data[] = [
                        $row->room_name,
                        $row->renter_name,
                        $row->receipt_number,
                        date("d/m/Y" , strtotime($row->booking_date)),
                        date("d/m/Y" , strtotime($row->date_stay)),
                        $row->payment_method == 1? "เงินสด" : "โอนเงิน",
                        $row->user->name,
                        $row->amount,
                        $row->amount,
                        $row->จองแล้ว
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);
        $sheet->getStyle(
            'A1:' . 
            $sheet->getHighestColumn() . 
            $sheet->getHighestRow()
        )->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $writer = new WriterXlsx($spreadsheet);
        $writer->save("upload/export_excel/รายงานจองรายเดือน".date('m-Y', strtotime($request->month)).".xlsx");
        return redirect("upload/export_excel/รายงานจองรายเดือน".date('m-Y', strtotime($request->month)).".xlsx");
    }
}
