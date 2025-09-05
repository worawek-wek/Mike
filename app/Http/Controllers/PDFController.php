<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Contract;
use App\Models\Receipt;
use App\Models\Building;
use App\Models\RentBill;
use App\Models\Setting_bill;
use App\Models\RoomHasService;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Branch;
use App\Models\Renter;
use App\Models\Province;
use App\Models\District;
use App\Models\IncomeExpenses;
use App\Models\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

DB::beginTransaction();

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($receipt_id)
    {
        $data['receipt'] = Receipt::find($receipt_id);

        return view('pdf/index', $data);
    }
    
    public function receipt($receipt_id)
    {
        $data['setting_bill'] = Setting_bill::first();
        $receipt = Receipt::find($receipt_id);
        $data['receipt'] = $receipt;
        $data['branch'] = Branch::find(session("branch_id"));
        $data['renter'] = Renter::find($receipt->ref_renter_id);
        $data['amount_thai'] = $this->convertToThaiBaht($receipt->total_amount);

        return view('pdf/receipt', $data);
    }
    public function invoice($invoice_id)
    {
        $data['setting_bill'] = Setting_bill::first();
        $invoice = RentBill::find($invoice_id);
        $data['invoice'] = $invoice;
        $data['branch'] = Branch::find(session("branch_id"));
        $data['renter'] = Renter::find($invoice->room_for_rent->ref_renter_id);
        $data['amount_thai'] = $this->convertToThaiBaht($invoice->total_amount);

        return view('pdf/invoice', $data);
    }
    public function overdue_invoice($room_id)
    {
        $data['setting_bill'] = Setting_bill::first();
        $invoice = RentBill::where('ref_room_id', $room_id)->whereIn('ref_status_id', [2, 4, 7])->get();
        $data['invoice'] = $invoice;
        $data['branch'] = Branch::find(session("branch_id"));
        $data['renter'] = Renter::find($invoice[0]->room_for_rent->ref_renter_id);
        foreach($invoice as $inv){
            $amount_thai[$inv->id] = $this->convertToThaiBaht($inv->total_amount);
        }
        $data['amount_thai'] = $amount_thai;

        return view('pdf/invoice-overdue', $data);
    }
    // พิมพ์หลายห้อง
    public function invoice_many($invoice_id)
    {
        
        // $invoice = RentBill::first();
        $data['setting_bill'] = Setting_bill::first();
        $invoice_many = Rentbill::whereHas('room.floor.building', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })
                                ->where('ref_type_id', 1)
                                ->where('ref_status_id', '!=', 3)
                                ->with('room_for_rent.renter')->get();
        $data['branch'] = Branch::find(session("branch_id"));
        foreach ($invoice_many as $invoice) {
            $invoice->thai_total_amount = $this->convertToThaiBaht($invoice->total_amount);
        }
        $data['invoice_many'] = $invoice_many;

        // $data['renter'] = Renter::find($invoice->room_for_rent->ref_renter_id);
        // $data['amount_thai'] = $this->convertToThaiBaht($invoice->total_amount);

        return view('pdf/invoice-many', $data);

        $invoice_id = RentBill::with('room_for_rent')->with('payment_list')->get();
        $html_pdf = '';
        $data = [];
        foreach($invoice_id as $key => $id){
            if(!@$id->room_for_rent){
                continue;
            }
            if(!@$id->payment_list || count($id->payment_list) == 0){
                continue;
            }
            
            $data[]['invoice'] = $id;
            $data[]['branch'] = Branch::find(session("branch_id"));
            $data[]['renter'] = Renter::find($id->room_for_rent->ref_renter_id);
            $data[]['amount_thai'] = $this->convertToThaiBaht($id->total_amount);


            // $html_pdf .= $this->invoice($id->id).'<div style="page-break-before: always;"></div>';
            // if($key == 1){
            //     break;
            // }
        }
        // return $data;
        return view('pdf/invoice-many', ['data' => $data])->render();

        return $html_pdf;
    }
    public function invoice_bill($invoice_id)
    {
        $results = RentBill::orderBy('rent_bills.id','DESC')
                                ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                ->distinct('rent_bills.id')
                                ->select('rent_bills.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent')
                                ->get();
                                
        $data['list_data'] = $results;

        return view('pdf/invoice-all', $data);
    }
    // พิมพ์ ใบสรุปรายรับรายจ่าย
    public function income_expenses_all(Request $request, $invoice_id)
    {
        $results = IncomeExpenses::where('ref_branch_id', session("branch_id"))->orderBy('id','DESC');
        
        if(@$request->from_month || $request->to_month){
            $from_month = "2000-01";
            if(@$request->from_month){
                $from_month = $request->from_month;
            }
            $results = $results->whereRaw("DATE_FORMAT(date, '%Y-%m') BETWEEN ? AND ?", [$from_month, $request->to_month]);
        }


        $results = $results->get(); 

        $data = $this->summary_calculate();
        
        $thaiMonths = [
            'January' => 'มกราคม',
            'February' => 'กุมภาพันธ์',
            'March' => 'มีนาคม',
            'April' => 'เมษายน',
            'May' => 'พฤษภาคม',
            'June' => 'มิถุนายน',
            'July' => 'กรกฎาคม',
            'August' => 'สิงหาคม',
            'September' => 'กันยายน',
            'October' => 'ตุลาคม',
            'November' => 'พฤศจิกายน',
            'December' => 'ธันวาคม',
        ];

        // ถ้าไม่มีค่า ให้กำหนด default
        $fromMonth = $request->from_month ?? '2025-01';
        $toMonth = $request->to_month ?? date('Y-m'); // default เป็นเดือนปัจจุบัน

        $from = Carbon::createFromFormat('Y-m', $fromMonth);
        $to = Carbon::createFromFormat('Y-m', $toMonth);

        $fromText = $thaiMonths[$from->format('F')] . '/' . $from->format('Y');
        $toText = $thaiMonths[$to->format('F')] . '/' . $to->format('Y');

        $data['month_to'] = "$fromText - $toText";
        $data['name_branch'] = Branch::find(session("branch_id"))->name;
        $data['list_data'] = $results;
        return view('pdf/income-expenses-all', $data);
    }

    public function checkCarPDF($status)
    {
        $data['name_branch'] = Branch::find(session("branch_id"))->name;
        
        // กำหนดสถานะตาม status
        if ($status == '0') {
            // ผู้เช่าเก่า
            $roomStatus = [0];
            $roomForRentStatus = [0];
        } else {
            // ผู้เช่าปัจจุบัน
            $roomStatus = [2];
            $roomForRentStatus = [1];
        }
        
        $results = Room::whereIn('status', $roomStatus)
                        ->whereHas('room_for_rent_s', function($query) use ($roomForRentStatus) {
                            $query->whereIn('status', $roomForRentStatus);
                        })
                        ->whereHas('room_for_rent_s.renter.vehicles')
                        ->with(['room_for_rent_s' => function($query) use ($roomForRentStatus) {
                            $query->whereIn('status', $roomForRentStatus);
                        }, 'room_for_rent_s.renter.vehicles'])
                        ->orderBy('id', 'DESC')
                        ->whereHas('floor.building', function ($query) {
                            $query->where('ref_branch_id', session("branch_id"));
                        })
                        ->get();
        $data['list_data'] = $results;
        return view('pdf/checkcar', $data);
    }

    public function report_monthly_booking(Request $request)
    {
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

        $data['list_data'] = $results;

        return view('pdf/report-monthlyBooking', $data);
    }
    public function report_view_overview(Request $request)
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

        $results = $results->get();

        $data['list_data'] = $results;

        return view('pdf/report-viewOverview', $data);
    }
    public function report_rent_bill(Request $request)
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

        $results = $results->get();

        $data['list_data'] = $results;

        return view('pdf/report-rentBill', $data);
    }
    public function report_move_in(Request $request)
    {
        $results = Contract::orderBy('id','ASC');

        if (!empty($request->month) && preg_match('/^\d{4}-\d{2}$/', $request->month)) {
            [$year, $month] = explode('-', $request->month);
            $results = $results->whereYear('created_at', $year)
                                ->whereMonth('created_at', $month);
        }

        $results = $results->get();

        $data['list_data'] = $results;

        return view('pdf/report-moveIn', $data);
    }
    public function report_bad_debt(Request $request)
    {
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

        $results = $results->get();

        $data['list_data'] = $results;

        return view('pdf/report-badDebt', $data);
    }
    
    // public function receipt()
    // {

    //     $html = view('pdf/receipt')->render();

    //     // $pdf = new \Mpdf\Mpdf();
    //     $pdf = new \Mpdf\Mpdf([
    //         'default_font_size' => 10,
    //         'default_font' => 'sarabun',
    //         'margin_top' => 3,
    //         'margin_left' => 3
    //     ]);
    //     $pdf->autoScriptToLang = true;
    //     $pdf->autoLangToFont = true;
    //     $pdf->WriteHTML($html);
    //     $pdf->Output();
    // }
    private function convertToThaiBaht($number)
    {
        $number = number_format($number, 2, '.', '');
        [$int, $dec] = explode('.', $number);

        $result = $this->readThaiNumber($int) . 'บาท';

        if ($dec == '00') {
            $result .= 'ถ้วน';
        } else {
            $result .= $this->readThaiNumber($dec) . 'สตางค์';
        }

        return $result;
    }
    public function readThaiNumber($number)
    {
        $is_negative = $number < 0;
        $number = abs((int)$number);

        $position_call = ["", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน"];
        $number_call = ["", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า"];
        $number = (string)$number;

        $result = '';
        $len = strlen($number);

        for ($i = 0; $i < $len; $i++) {
            $num = $number[$i];
            $pos = $len - $i - 1;

            if ($num == 0) continue;

            if ($pos == 0 && $num == 1 && $len > 1) {
                $result .= 'เอ็ด';
            } elseif ($pos == 1 && $num == 2) {
                $result .= 'ยี่' . $position_call[$pos];
            } elseif ($pos == 1 && $num == 1) {
                $result .= $position_call[$pos];
            } else {
                $result .= $number_call[$num] . $position_call[$pos];
            }
        }

        return $is_negative ? 'ลบ' . $result : $result;
    }


}
