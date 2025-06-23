<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
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
    public function invoice_many($invoice_id)
    {
        
        $invoice = RentBill::find(53);
        $data['invoice'] = $invoice;
        $data['branch'] = Branch::find(session("branch_id"));
        $data['renter'] = Renter::find($invoice->room_for_rent->ref_renter_id);
        $data['amount_thai'] = $this->convertToThaiBaht($invoice->total_amount);

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
    public function income_expenses_all($invoice_id)
    {
        $results = IncomeExpenses::orderBy('id','DESC')->get();                
        $data['list_data'] = $results;
        return view('pdf/income-expenses-all', $data);
    }

    public function checkCarPDF($invoice_id)
    {
        $results = Renter::orderBy('id','DESC')->get();                
        $data['list_data'] = $results;
        return view('pdf/checkcar', $data);
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

    private function readThaiNumber($number)
    {
        $position_call = ["", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน"];
        $number_call = ["", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า"];
        $number = (string)(int)$number;

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

        return $result;
    }

}
