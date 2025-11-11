<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\IncomeExpenses;
use App\Models\Room;
use App\Models\Branch;
use App\Models\Work_shift;
use App\Models\Category;
use App\Models\IncomeList;
use App\Models\PaymentList;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Carbon\Carbon;

DB::beginTransaction();

class IncomeExpensesController extends Controller
{
    public function index(Request $request)
    {
        $data['page_url'] = 'income-expenses';
        $data['room'] = Room::orderBy('rooms.name', 'ASC')
                            ->whereHas('floor.building', function ($query) {
                                $query->where('ref_branch_id', session("branch_id"));
                            })->get();
        $data['category'] = Category::get();
        $income = IncomeExpenses::where('ref_branch_id', session("branch_id"))->where('type', 1)->sum('amount');
        $expenses = IncomeExpenses::where('ref_branch_id', session("branch_id"))->where('type', 2)->sum('amount');
        $data['income'] = $income;
        $data['expenses'] = $expenses;
        $data['total'] = $income-$expenses;
        // $data['title'] = 'Profile';
        
        return view('income-expenses/index', $data);
    }
    public function datatable(Request $request)
    {
        $results = IncomeExpenses::orderBy('id','DESC')->where('ref_branch_id', session("branch_id"));
        
        if(@$request->search){
            $results = $results->Where(function ($query) use ($request) {
                                    $query->where('label','LIKE','%'.$request->search.'%');
                                        // ->orWhere('email','LIKE','%'.$request->search.'%');
                                });
        }

        if(@$request->ref_category_id != "all"){

            if($request->ref_category_id == 2){
                $results = $results->whereIN('ref_category_id',[0,$request->ref_category_id]);

            }else{
                $results = $results->Where('ref_category_id', $request->ref_category_id);
            }
        }

        if(@$request->type != "all"){
            $results = $results->Where('type', $request->type);
        }

        if(@$request->from_month || $request->to_month){
            $from_month = "2000-01";
            if(@$request->from_month){
                $from_month = $request->from_month;
            }
            $results = $results->whereRaw("DATE_FORMAT(date, '%Y-%m') BETWEEN ? AND ?", [$from_month, $request->to_month]);
        }
        // if(@$request->to_month){
        //     $results = $results->WhereDate('date', '<=', $request->to_month);
        // }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $results = $results->paginate($limit);
        // return $results[0]->room;
        // return $results->items();
        // dd($results);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;
        $data['list_data'] = $results;

        return view('income-expenses/table', $data);
    }
    public function store(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        try{
            // 1 เพิ่ม รายรับรายจ่าย
            $insert_income_expenses = new IncomeExpenses;
            $insert_income_expenses->type  =  $request->type;
            $insert_income_expenses->label  =  $request->label;
            $insert_income_expenses->amount  =  $request->amount ?? 0;
            $insert_income_expenses->payment_channel  =  $request->payment_channel ?? 0;
            $insert_income_expenses->time  =  $request->time ?? date('H:i');
            $insert_income_expenses->date  =  $date;
            $insert_income_expenses->ref_category_id  =  $request->ref_category_id ?? 1;
            $insert_income_expenses->ref_room_id  =  $request->ref_room_id;
            $insert_income_expenses->name  =  $request->name;
            $insert_income_expenses->address  =  $request->address;
            $insert_income_expenses->id_card_number  =  $request->id_card_number;
            $insert_income_expenses->branch  =  $request->branch;
            $insert_income_expenses->phone  =  $request->phone;
            $insert_income_expenses->remark  =  $request->remark;
            $insert_income_expenses->ref_branch_id  =  session("branch_id");

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // 1.1 อัพโหลดรูปภาพ หลักฐานการจ่ายเงิน
            if($request->file('proof_of_payment')){
                    $request->validate([
                        'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    ],[
                        'proof_of_payment.required' => 'กรุณาเลือกรูปภาพ',
                        'proof_of_payment.image' => 'ไฟล์ที่เลือกต้องเป็นรูปภาพเท่านั้น',
                        'proof_of_payment.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท: jpeg, png, jpg, gif หรือ webp',
                        'proof_of_payment.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
                    ]);
                // return 123;
                $file = $request->file('proof_of_payment');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/expenses/";
                $proof_of_payment = $img_name.rand().'.'.$extension;
                $insert_income_expenses->proof_of_payment = $proof_of_payment;
            }
            // 1.2 อัพโหลดรูปภาพ ใบสำคัญจ่าย
            if($request->file('payment_voucher')){
                    $request->validate([
                        'payment_voucher' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    ],[
                        'payment_voucher.required' => 'กรุณาเลือกรูปภาพ',
                        'payment_voucher.image' => 'ไฟล์ที่เลือกต้องเป็นรูปภาพเท่านั้น',
                        'payment_voucher.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท: jpeg, png, jpg, gif หรือ webp',
                        'payment_voucher.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
                    ]);
                $file = $request->file('payment_voucher');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/expenses/";
                $payment_voucher = $img_name.rand().'.'.$extension;
                $insert_income_expenses->payment_voucher = $payment_voucher;
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $insert_income_expenses->ref_user_id  =  Auth::id();
            $insert_income_expenses->save();
            
            // ถ้ามีการเพิ่มรายการ รับเงิน (ที่เป็นตาราง)
            if(@$request->payment_sd_list['title']){
                // 2. เพิ่มใบเสร็จรับเงิน
                $receipt = new Receipt;
                $receipt->receipt_number =  $this->generateReceiptCode();
                $receipt->ref_room_id  =  $request->ref_room_id;
                $receipt->ref_rent_bill_id  =  0;
                $receipt->ref_contract_id  =  0;
                $receipt->ref_renter_id  =  0;
                $receipt->payment_format  =  0;
                $receipt->payment_channel  =  0; // รูปแบบชำระเงิน 1=เงินสด / 2=โอนเงิน
                $receipt->ref_bank_id  =  0;
                $receipt->transfer_time  =  0;
                $receipt->payment_date  =  $date;
                $receipt->amount  =  0;
                $receipt->ref_type_id  =  0;
                $receipt->evidence_of_money_transfer  =  0;
                $receipt->ref_user_id =  Auth::id();
                $receipt->save();
                
                $insert_income_expenses->ref_receipt_id  =  $receipt->id;
                $insert_income_expenses->save(); 

                foreach($request->payment_sd_list['title'] as $key => $payment_sd_list_title){
                    // // 2.1 เพิ่ม รายการ ใบเสร็จรับเงิน
                    // $pay_list = new IncomeList;
                    // $pay_list->title  =  $payment_sd_list_title;
                    // $pay_list->price  =  $request->payment_sd_list['price'][$key];
                    // $pay_list->ref_payment_id  =  $insert_income_expenses->id;
                    // $pay_list->discount  =  $request->payment_sd_list['discount'][$key];
                    // $pay_list->save();

                    // 2.2 เพิ่ม รายการ ใบเสร็จรับเงิน
                    $pay_list = new PaymentList;
                    $pay_list->title  =  $payment_sd_list_title;
                    $pay_list->price  =  $request->payment_sd_list['price'][$key];
                    $pay_list->ref_payment_id  =  $receipt->id;
                    $pay_list->document_type  =  2; // Receipt ใบเสร็จรับเงิน
                    $pay_list->discount  =  $request->payment_sd_list['discount'][$key];
                    $pay_list->save();
                }
            }
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    
    public function generateReceiptCode()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        
        $yearMonth = $year . str_pad($month, 2, '0', STR_PAD_LEFT);
        
        $latestReceipt = Receipt::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->latest('id')
                                ->first();
        
        $sequence = $latestReceipt ? ((int) substr($latestReceipt->receipt_number, -6)) + 1 : 1;
        $sequenceCode = str_pad($sequence, 6, '0', STR_PAD_LEFT);
        
        $receiptCode = 'RE' . $yearMonth . $sequenceCode;
        
        return $receiptCode;
        
    }
    public function show($id)
    {
        $data['page_url'] = 'income-expenses';
        $data['income_expenses'] = IncomeExpenses::find($id);
        // return $data['income_expenses'];
        return view('income-expenses/view-expenses', $data);
    }
    public function summary_IE()
    {
        $data = $this->summary_calculate();

        return view('income-expenses/summary', $data);
    }


    public function exportExcel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $results = IncomeExpenses::where('ref_branch_id', session("branch_id"))->orderBy('id','DESC');
        
        if(@$request->search){
            $results = $results->Where(function ($query) use ($request) {
                                    $query->where('label','LIKE','%'.$request->search.'%');
                                        // ->orWhere('email','LIKE','%'.$request->search.'%');
                                });
        }

        if(@$request->ref_category_id != "all"){
            $results = $results->Where('ref_category_id', $request->ref_category_id);
        }

        if(@$request->type != "all"){
            $results = $results->Where('type', $request->type);
        }

        if(@$request->from_month || $request->to_month){
            $from_month = "2000-01";
            if(@$request->from_month){
                $from_month = $request->from_month;
            }
            $results = $results->whereRaw("DATE_FORMAT(date, '%Y-%m') BETWEEN ? AND ?", [$from_month, $request->to_month]);
        }

        $results = $results->get();
        
        $data = 
        [
            ['รายรับ-รายจ่าย'],
            [
                'รายงานรายรับ - รายจ่ายประจำ วันที่ '.date('d/m/Y')
            ],
            [
                "ลำดับ",
                "เลขที่ใบเสร็จ",
                "รายละเอียด",
                "ห้อง",
                "หมวดหมู่",
                "จำนวนเงิน",
                "โดย"
            ]
        ];
        foreach($results as $key=>$row){
            if ($row->type == 2){
                $amount = '-'.number_format($row->amount);    
            }else{
                $amount = number_format($row->receipt->total_amount ?? $row->total_amount);  
            }

            $data[] = [
                        $key+1,
                        date('d/m/Y',strtotime($row->date)),
                        @$row->label,
                        @$row->room->name,
                        @$row->category->name,
                        $amount,
                        $row->user->name,

                        
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
        $writer->save("upload/export_excel/รายรับรายจ่าย".date('m-Y', strtotime('-1 month')).".xlsx");
        return redirect("upload/export_excel/รายรับรายจ่าย".date('m-Y', strtotime('-1 month')).".xlsx");
    }
}
