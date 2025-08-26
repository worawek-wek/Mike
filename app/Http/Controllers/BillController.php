<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\Meter;
use App\Models\IncomeExpenses;
use App\Models\User;
use App\Models\RoomHasService;
use App\Models\Service;
use App\Models\Discount;
use App\Models\Contract;
use App\Models\Receipt;
use App\Models\PaymentList;
use App\Models\Bank;
use App\Models\AdditionalCosts;
use App\Models\RentBill;
use App\Models\Branch;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomForRents;
use App\Models\StatusRentBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Carbon\Carbon;

DB::beginTransaction();

class BillController extends Controller
{
    public function index(Request $request)
    {
        // $rent = RentBill::get();
        // foreach($rent as $re){
        //     $ru = RentBill::find($re->id);
        //     $ru->total = $ru->total_amount;
        //     $ru->save();
        // }
        $invoice = RentBill::where('ref_status_id', '!=', 5)->where('ref_type_id', 1)->with(['receipt.payment_list_not_fine', 'room_for_rent.room.floor.building'])->get();
        foreach($invoice as $inv){

                $createdDay = \Carbon\Carbon::parse($inv->created_at)->day;
                $month_year = date('Y-m', strtotime($inv->created_at));

                // if ($createdDay > $inv->room_for_rent->room->start_fine_day) {
                //     $month_year = date('Y-m', strtotime('+1 month', strtotime($inv->created_at)));
                // }

            if (date_create(date('Y-m-d')) >= date_create($month_year.'-'.str_pad($inv->room_for_rent->room->start_fine_day, 2, '0', STR_PAD_LEFT))  &  $inv->room_for_rent->room->fine_day > 0){

                $title = "ค่าปรับ เกินชำระ ".date_diff(date_create($month_year.'-'.str_pad($inv->room_for_rent->room->start_fine_day, 2, '0', STR_PAD_LEFT)), date_create(date('Y-m-d')))->days.' วัน';
                $price = date_diff(date_create($month_year.'-'.str_pad($inv->room_for_rent->room->start_fine_day, 2, '0', STR_PAD_LEFT)), date_create(date('Y-m-d')))->days*$inv->room_for_rent->room->fine_day;
                
                $price = min($price, $inv->room->maximum_fine);

                $fine = PaymentList::where('ref_payment_id', $inv->id)->where('document_type', 1)->where('fine', 1)->first();
                if($fine){
                    $pay_list = PaymentList::find($fine->id); // สร้างรายการ ค่าห้อง
                }else{
                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->ref_payment_id  =  $inv->id;
                    $pay_list->document_type  =  1;
                    $pay_list->fine  =  1;
                }
                    $pay_list->title  =  $title;
                    $pay_list->price  =  $price;
                    $pay_list->save();                    
            }
            // return 123;
        }

        DB::commit();

        $data['page_url'] = 'bill';
        $data['status_rent_bill'] = StatusRentBill::get();
        $data['buildings'] = Building::get();
        $data['floors'] = Floor::get();

        return view('bill/index', $data);
    }
    public function waiting_for_confirmation(Request $request)
    {
        $request['limit'] = 9999999;
        $request['re'] = 1;
        $request['ref_status_id'] = 2;
        $data['list_data'] = Receipt::orderBy('rooms.name','ASC')
                                ->whereHas('invoice', function ($q) {
                                            $q->where('ref_status_id', '!=', 5);
                                        })
                                ->join('renters', 'receipts.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'receipts.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('receipts.ref_type_id', 1)
                                ->distinct('receipts.id')
                                ->select('receipts.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent')
                                ->paginate();

        return view('bill/waiting-for-confirmation', $data);
    }
    
    public function datatable(Request $request)
    {
        $results = RentBill::orderBy('rooms.name')
                                ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                ->distinct('rent_bills.id')
                                ->select('rent_bills.*', 'rent_bills.id as rent_bill_id', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
        
        if(@$request->search){
            $results = $results->Where(function ($query) use ($request) {
                                    $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', renters.surname) LIKE ?", ["%{$request->search}%"])
                                        ->orWhere('rooms.name','LIKE','%'.$request->search.'%');
                                });
        }
        if(@$request->ref_status_id != "all"){
            $results = $results->Where('rent_bills.ref_status_id','LIKE','%'.$request->ref_status_id.'%');
        }
        if(@$request->room_name){
            $results = $results->Where('rooms.name','LIKE','%'.$request->room_name.'%');
        }
        if(@$request->invoice_number){
            $results = $results->Where('rent_bills.invoice_number','LIKE','%'.$request->invoice_number.'%');
        }
        if(@$request->room_rent){
            $results = $results->Where('rent_bills.total', $request->room_rent);
        }
        if(@$request->building != "all"){
            $results = $results->Where('room_for_rents.ref_building_id', $request->building);
        }
        if(@$request->floor != "all"){
            $results = $results->Where('room_for_rents.ref_floor_id', $request->floor);
        }
        if(@$request->month){
            $results = $results->Where('rent_bills.year', explode('-', $request->month)[0])->Where('rent_bills.month', explode('-', $request->month)[1]);
        }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $results = $results->paginate($limit);

        foreach ($results as $res) {
            $total_fine = 0;
            $receipt = Receipt::where('ref_rent_bill_id', $res->rent_bill_id)->get();
            foreach ($receipt as $rec) {
                $total_fine += $rec->payment_list_fine->sum('price');
            }
            $res->total_fine = $total_fine; // ค่าปรับทั้งหมดของ ใบแจ้งหนี้ นี้
            // $res['totalFine'] = $res->receipt->payment_list_fine()->where('fine', 1)->sum('price');
        }
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;
        
        if(@$request->re){
            return $data['list_data'];
        }

        return view('bill/table', $data);
    }
    public function incomplete_update(Request $request)
    {
        try{
            $rent_bill = RentBill::find($request->id);
            $rent_bill->water_amount = $request->water_amount;
            $rent_bill->water_unit = $request->water_unit;
            
            $pay_list = PaymentList::find($request->payment_list_id);
            $pay_list->unit  =  $request->water_unit;
            $pay_list->price  =  $request->water_amount;
            $pay_list->save();

            $amount = PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 0)->sum('price') - PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 1)->sum('price');
            
            $total = Room::find($request->ref_room_id)->rent;

                if(@$request->payment_sd_list['title']){
                    foreach($request->payment_sd_list['title'] as $key => $payment_sd_list_title){

                        $pay_list = new PaymentList;
                        $pay_list->title  =  $payment_sd_list_title;
                        $pay_list->price  =  $request->payment_sd_list['price'][$key];
                        $pay_list->ref_payment_id  =  $rent_bill->id;
                        $pay_list->document_type  =  1; // RentBill ใบแจ้งหนี้, ใบแจ้งชำระเงิน
                        $pay_list->discount  =  $request->payment_sd_list['discount'][$key];
                        $pay_list->new_list_from_incomplate  =  1;
                        $pay_list->save();
                        
                        $total = $this->calculate_total($total, $request->payment_sd_list['discount'][$key], $request->payment_sd_list['price'][$key]);
                    
                    }
                }

                $rent_bill->ref_status_id = 7;

            $rent_bill->total = $rent_bill->total_amount;

            $rent_bill->save();
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
     // ชำระบิล
    public function payment_bill(Request $request) // ชำระบิล
    {
        try{
            $room = Room::find($request->ref_room_id);
            // return $request;
            // return $this->generateInvoiceCode();
            $rent_bill = RentBill::find($request->id);
            if($request->fine_paid_at){
                $rent_bill->fine_paid_at = date('Y-m-d');
            }
            // $rent_bill->payment_channel = $request->payment_channel;
            // $rent_bill->water_amount = $request->water_amount;
            // $rent_bill->water_unit = $request->water_unit;
            
            $amount = PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 0)->sum('price') - PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 1)->sum('price');

            $image_name = "";
            if($request->file('evidence_of_money_transfer')){
                // return 3;
                    $request->validate([
                        'evidence_of_money_transfer' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    ],[
                        'evidence_of_money_transfer.required' => 'กรุณาเลือกรูปภาพ',
                        'evidence_of_money_transfer.image' => 'ไฟล์ที่เลือกต้องเป็นรูปภาพเท่านั้น',
                        'evidence_of_money_transfer.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท: jpeg, png, jpg, gif หรือ webp',
                        'evidence_of_money_transfer.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
                    ]);
                $file = $request->file('evidence_of_money_transfer');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/receipt/";
                $image_name = $img_name.rand().'.'.$extension;
            }
            // return 2;
            $branch = Branch::find(session("branch_id"));

            $todayDay = Carbon::now()->day; // วันที่ปัจจุบัน เช่น 14
            $payment_end_date = (int) $branch->payment_end_date; // วันที่ที่เก็บไว้ เช่น 10

            if($request->payment_channel == 1){
                $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
            }else{
                $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date2)->format('Y-m-d');
            }
            $receipt = new Receipt;
            $receipt->receipt_number =  $this->generateReceiptCode();
            $receipt->ref_room_id  =  $request->ref_room_id;
            $receipt->ref_rent_bill_id  =  $request->ref_rent_bill_id;
            $receipt->ref_contract_id  =  $request->ref_contract_id;
            $receipt->ref_renter_id  =  $request->ref_renter_id;
            $receipt->payment_format  =  $request->payment_format;
            $receipt->payment_channel  =  $request->payment_channel; // รูปแบบชำระเงิน 1=เงินสด / 2=โอนเงิน
            $receipt->ref_bank_id  =  $request->ref_bank_id;
            $receipt->transfer_time  =  $request->transfer_time;
            $receipt->payment_date  =  $payment_date;
            $receipt->amount  =  $amount;
            $receipt->ref_type_id  =  $request->ref_type_id;
            $receipt->evidence_of_money_transfer  =  $image_name;
            $receipt->ref_user_id =  Auth::id();

            if ($todayDay > $payment_end_date) {
                if($room->fine_day > 0){
                    $receipt->payment_on_time  =  2;
                }else{
                    $receipt->payment_on_time  =  3;
                }
            }
            $receipt->save();
            
            
            $total = Room::find($request->ref_room_id)->rent;

            if($request->payment_format == 1){
                // return $request->payment_sd_list['title'];
                foreach($rent_bill->payment_list as $payment_list){

                    $pay_list = new PaymentList;
                    $pay_list->title  =  $payment_list->title;
                    $pay_list->unit  =  $payment_list->unit;
                    $pay_list->price  =  $payment_list->price;
                    $pay_list->ref_payment_id  =  $receipt->id;
                    $pay_list->document_type  =  2;
                    $pay_list->discount  =  $payment_list->discount;
                    if ($payment_list->title && str_contains($payment_list->title, 'ค่าปรับ')) {
                        $pay_list->fine  =  1; // รายการนี้เป็นค่าปรับ
                    }
                    $pay_list->save();
                    
                    $total = $this->calculate_total($total, $payment_list->discount, $payment_list->price);

                }

                if(@$request->payment_sd_list['title']){
                    foreach($request->payment_sd_list['title'] as $key => $payment_sd_list_title){

                        $pay_list = new PaymentList;
                        $pay_list->title  =  $payment_sd_list_title;
                        $pay_list->price  =  $request->payment_sd_list['price'][$key];
                        $pay_list->ref_payment_id  =  $receipt->id;
                        $pay_list->document_type  =  2; // Receipt ใบเสร็จรับเงิน
                        $pay_list->discount  =  $request->payment_sd_list['discount'][$key];

                        if ($payment_sd_list_title && str_contains($payment_sd_list_title, 'ค่าปรับ')) {
                            $pay_list->fine  =  1; // รายการนี้เป็นค่าปรับ ค่าปรับนี้จะไม่เอาไปเช็คว่าจ่ายครบไหม
                        }

                        $pay_list->save();

                        // $pay_list = new PaymentList;
                        // $pay_list->title  =  $payment_sd_list_title;
                        // $pay_list->price  =  $request->payment_sd_list['price'][$key];
                        // $pay_list->ref_payment_id  =  $rent_bill->id;
                        // $pay_list->document_type  =  1; // RentBill ใบแจ้งหนี้, ใบแจ้งชำระเงิน
                        // $pay_list->discount  =  $request->payment_sd_list['discount'][$key];
                        // $pay_list->save();
                        
                        $total = $this->calculate_total($total, $request->payment_sd_list['discount'][$key], $request->payment_sd_list['price'][$key]);
                    
                    }
                }

                $rent_bill->ref_status_id = 2;

            }else{

                foreach($request->payment_list['title'] as $key => $payment_list_title){
                    $pay_list = new PaymentList;
                    $pay_list->title  =  $payment_list_title;
                    $pay_list->price  =  $request->payment_list['price'][$key];
                    $pay_list->ref_payment_id  =  $receipt->id;
                    $pay_list->document_type  =  2;
                    $pay_list->discount  =  $request->payment_list['discount'][$key];

                    if ($payment_list_title && str_contains($payment_list_title, 'ค่าปรับ')) {
                        $pay_list->fine  =  1; // รายการนี้เป็นค่าปรับ ค่าปรับนี้จะไม่เอาไปเช็คว่าจ่ายครบไหม
                    }

                    $pay_list->save();
                }

                $receipt_price = Receipt::where('ref_rent_bill_id', $request->id)->get();

                $receipt_price = $receipt_price->pluck('payment_list')->flatten()->sum('price');
                
                $invoice_price = $rent_bill->total_amount; // ยอดรวม ใบแจ้งหนี้
                if($receipt_price >= $invoice_price){ // เช็คว่ายอดรวมใบเสร็จ ทั้งหมด เท่า ใบแจ้งหนี้หรือยัง ถ้ายอดเท่ากัน แสดงว่า จ่ายครบแล้ว
                    $rent_bill->ref_status_id = 2;

                }
            }
            $rent_bill->total = $rent_bill->total_amount;
            $rent_bill->payment_channel = $request->payment_channel;
            $rent_bill->ref_status_id = 2;

            $rent_bill->save();
            
            if(@$file) $file->move($path, $image_name);

            $expenses = new IncomeExpenses;
            $expenses->type  =  1;
            $expenses->label  =  "ใบเสร็จค่าเช่าห้อง";
            $expenses->amount  =  0;
            $expenses->date  =  Carbon::now();
            $expenses->ref_room_id  =  $request->ref_room_id;
            $expenses->ref_category_id  =  0;
            $expenses->name  =  $receipt->room->renter_name;
            $expenses->address  =  $receipt->room->renter_address;
            $expenses->id_card_number  =  $receipt->room->renter_id_card_number;
            $expenses->branch  =  0;
            $expenses->phone  =  $receipt->room->renter_phone;
            $expenses->remark  =  0;
            $expenses->ref_receipt_id  =  $receipt->id;
            $expenses->ref_user_id  =  Auth::id();
            $expenses->ref_branch_id  =  session("branch_id");
            $expenses->save();
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    public function calculate_total($total, $discount, $price)
    {
        if($discount == 0){
            $total += $price;
        }else{
            $total -= $price;
        }
        return $total;
    }
    public function invoice($id)
    {
        
        $data['page_url'] = 'bill';
        $invoice = RentBill::with(['receipt.payment_list_not_fine', 'room_for_rent.room.floor.building'])->find($id);
        $receipt = Receipt::where('ref_rent_bill_id', $id)->get();
        $fine_invoice = PaymentList::where('ref_payment_id', $id)->where('document_type', 1)->where('fine', 1)->first();
        $data['fine_invoice_price'] = 0;
        if(@$fine_invoice){
            $data['fine_invoice_price'] = $fine_invoice->price;
        }
        $invoice_fine = PaymentList::where('ref_payment_id', $id)->where('document_type', 1)->where('fine', 1)->first();
        $data['fine_price'] = $invoice_fine->price ?? 0;
        if(@$receipt){
            foreach($receipt as $rec){
                $fine = PaymentList::where('ref_payment_id', $rec->id)->where('document_type', 2)->where('fine', 1)->first();
                if(@$fine){
                    $data['fine_price'] = $invoice_fine->price - $fine->price;
                }
            }
        }
        $contract = Contract::find($invoice->ref_contract_id);
        $data['expenses'] = AdditionalCosts::where('ref_rent_bill_id', $id)->get();
        $data['invoice'] = $invoice;
        $data['contract'] = $contract;
        $data['bank'] = Bank::get();
        $data['days'] = [
            'Sunday'    => 'อาทิตย์',
            'Monday'    => 'จันทร์',
            'Tuesday'   => 'อังคาร',
            'Wednesday' => 'พุธ',
            'Thursday'  => 'พฤหัสบดี',
            'Friday'    => 'ศุกร์',
            'Saturday'  => 'เสาร์',
        ];
        
        $prevMonth = (int)$invoice->month - 1;
        $prevYear = (int)$invoice->year;

        if ($prevMonth < 1) {
            $prevMonth = 12;
            $prevYear -= 1;
        }

        $prevMonth = str_pad($prevMonth, 2, '0', STR_PAD_LEFT);
        
        $data['meterPrevious'] = Meter::where('ref_room_id', $contract->ref_room_id)->where('month', $prevMonth)->where('year', $prevYear)->first();

        if($invoice->ref_status_id == 3){
            return view('bill/incomplete', $data);
        }
        // if($invoice->ref_status_id == 7){
            return view('bill/payment', $data);
        // }
        // return view('bill/invoice', $data);
    }
    public function bill_summary()
    {
        return $this->summary(session("branch_id"));
    }
    public function change_status_bill(Request $request, $id)
    {
        try{
            if($request->status == 3){
                PaymentList::where('ref_payment_id', $id)->where('document_type', 1)->where('new_list_from_incomplate', 1)->delete();
            }
            if($id == 'all'){
                $bills = RentBill::with(['receipt.payment_list', 'payment_list'])
                                    ->where('ref_status_id', 2)
                                    ->get();

                foreach ($bills as $bill) {
                    if ($bill->total_paid_including_fine >= $bill->total_amount) {
                        foreach ($bills as $bill) {
                            if ($bill->total_paid_including_fine >= $bill->total_amount) {
                                $bill->ref_status_id = $request->status;
                                $bill->save();
                            }
                        }
                    }
                }
                DB::commit();
                return true;
            }

            $update = RentBill::whereIn('id', explode(',', $id));
            $update->update(['ref_status_id' => $request->status]);

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    public function delete_receipt(Request $request, $id)
    {
        // return $request;
        try{
                $re_del = Receipt::find($id);

                PaymentList::where('ref_payment_id', $re_del->id)->where('document_type', 2)->delete();

                $re_del?->delete();
                
                $rent_bill = RentBill::find($re_del->ref_rent_bill_id);
                // if(count($rent_bill->receipt) == 0){
                   $rent_bill->ref_status_id = 7;
                   $rent_bill->save();
                   
                    // DB::commit();
                    // return [ 'rent_bill_id' => $rent_bill->id ];
                // }

                DB::commit();
                return true;

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
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
    public function export_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        $results = RentBill::orderBy('rent_bills.id','DESC')
                                ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                // ->where('rent_bills.ref_status_id', '!=', 3)
                                ->distinct('rent_bills.id')
                                ->select('rent_bills.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.id as room_id', 'rooms.rent', 'rooms.furniture_rental', 'rooms.air_rental', 'renters.phone')
                                ->get();
        $branch = Branch::find(session("branch_id"));

        $service = Service::where('ref_branch_id', session("branch_id"))
                            ->pluck('name')
                            ->toArray();
        

        $data_1 = [
            "ห้อง",
            "ค่าเช่าห้อง",
            "ค่าน้ำประปา",
            "ค่าไฟฟ้า",
        ];
        $data_2 = [
            "ค่าปรับ",
            "รวม",
            "หมายเหตุ",
            "มิเตอร์น้ำก่อน",
            "มิเตอร์น้ำหลัง",
            "มิเตอร์ไฟฟ้าก่อน",
            "มิเตอร์ไฟฟ้าหลัง",
            "ชื่อ",
            "ที่อยู่",
            "เลขประจำตัวผู้เสียภาษี",
            "สำนักงานสาขา",
            "เบอร์โทร"
        ];

        $data =  [
                    [
                        $branch->name
                    ],
                    [
                        "บิลค่าเช่าห้องเดือน".date('m-Y')
                    ],
                    array_merge($data_1, $service, $data_2)

                ];
        // return $data;
        foreach($results as $row){
            $fine = PaymentList::where('ref_payment_id', $row->id)->where('document_type', 1)->where('fine', 1)->first();
            // foreach($service_id as $ser_id){
            //     RoomHasService::where('ref_room_id', $row->room_id)->where('ref_service_id', $ser_id)->first();
            // }
            $data_list = [
                        $row->room_name,
                        $row->rent,
                        (string) $row->water_amount,
                        $row->electricity_amount,
            ];
            $data_list_2 = [
                        $fine->price ?? "0",
                        number_format($row->total_amount),
                        "0",
                        "0",
                        $row->water_unit == 0 ? "0":$row->water_unit,
                        "0",
                        $row->electricity_unit ?? "0",
                        $row->renter_name,
                        @$row->room_for_rent->renter->fullThaiAddress(),
                        $row->id_card_number,
                        "",
                        $row->phone
            ];
            
            $service_price = Service::where('services.ref_branch_id', session('branch_id'))
                                            ->leftJoin('room_has_services', function ($join) use ($row) {
                                                $join->on('services.id', '=', 'room_has_services.ref_service_id')
                                                    ->where('room_has_services.ref_room_id', $row->room_id);
                                            })
                                            ->selectRaw('COALESCE(room_has_services.price, 0) as price')
                                            ->pluck('price')
                                            ->toArray();

            $data[] = array_merge($data_list, $service_price, $data_list_2);
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
        $writer->save("upload/export_excel/all-".date('m-Y', strtotime('-1 month')).".xlsx");
        return redirect("upload/export_excel/all-".date('m-Y', strtotime('-1 month')).".xlsx");
    }
    public function export_excel_summary()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        
        $results = RentBill::orderBy('rooms.name','asc')
                                ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                ->where('rent_bills.ref_status_id', '!=', 3)
                                ->distinct('rent_bills.id')
                                ->select('rent_bills.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent')
                                ->get();

        $branch = Branch::find(session("branch_id"));
        $data = 
        [
            [
                $branch->name
            ],
            [
                "ใบสรุปบิล"
            ],
            [
                "ห้อง",
                "ผู้เช่า",
                "จำนวนเงินรวม",
                "สถานะบิล"
            ]
        ];
        // return $data;
        foreach($results as $row){
            
            if (count(@$row->receipt) > 0 & $row->ref_status_id == 7){
                $status = "ค้างชำระ";
            }else{
                $status = $row->status->name;
            }

            $data[] = [
                        $row->room_name,
                        $row->prefix.' '.$row->renter_name,
                        number_format($row->total_amount),
                        $status
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
        $writer->save("upload/export_excel/ใบสรุปบิล-".date('m-Y', strtotime('-1 month')).".xlsx");
        return redirect("upload/export_excel/ใบสรุปบิล-".date('m-Y', strtotime('-1 month')).".xlsx");
    }
}