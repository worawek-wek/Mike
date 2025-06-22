<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
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
        $data['list_data'] = $this->datatable($request);
        return view('bill/waiting-for-confirmation', $data);
    }
    
    public function datatable(Request $request)
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
                                ->select('rent_bills.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
        
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
        if(@$request->room_rent != "all"){
            $results = $results->Where('rooms.rent','LIKE','%'.$request->room_rent.'%');
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
            // return true;
            // return $this->generateInvoiceCode();
            $rent_bill = RentBill::find($request->id);
            // $rent_bill->payment_channel = $request->payment_channel;
            $rent_bill->water_amount = $request->water_amount;
            $rent_bill->water_unit = $request->water_unit;
            
            $amount = PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 0)->sum('price') - PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 1)->sum('price');

            // $image_name = "";
            // if($request->file('evidence_of_money_transfer')){
            //     $file = $request->file('evidence_of_money_transfer');
            //     $nameExtension = $file->getClientOriginalName();
            //     $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            //     $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            //     $path = "upload/receipt/";
            //     $image_name = $img_name.rand().'.'.$extension;
            // }
            
            // if($request->payment_channel == 1){
            //     $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
            // }else{
            //     $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date2)->format('Y-m-d');
            // }
            // $receipt = new Receipt;
            // $receipt->receipt_number =  $this->generateReceiptCode();
            // $receipt->ref_room_id  =  $request->ref_room_id;
            // $receipt->ref_rent_bill_id  =  $request->ref_rent_bill_id;
            // $receipt->ref_contract_id  =  $request->ref_contract_id;
            // $receipt->ref_renter_id  =  $request->ref_renter_id;
            // $receipt->payment_format  =  $request->payment_format;
            // $receipt->payment_channel  =  $request->payment_channel; // รูปแบบชำระเงิน 1=เงินสด / 2=โอนเงิน
            // $receipt->ref_bank_id  =  $request->ref_bank_id;
            // $receipt->transfer_time  =  $request->transfer_time;
            // $receipt->payment_date  =  $payment_date;
            // $receipt->amount  =  $amount;
            // $receipt->ref_type_id  =  $request->ref_type_id;
            // $receipt->evidence_of_money_transfer  =  $image_name;
            // $receipt->ref_user_id =  Auth::id();
            // $receipt->save();
            
            $total = Room::find($request->ref_room_id)->rent;

            // if($request->payment_format == 1){
                // return $request->payment_sd_list['title'];
                // foreach($rent_bill->payment_list as $payment_list){

                //     $pay_list = new PaymentList;
                //     $pay_list->title  =  $payment_list->title;
                //     $pay_list->unit  =  $payment_list->unit;
                //     $pay_list->price  =  $payment_list->price;
                //     $pay_list->ref_payment_id  =  $receipt->id;
                //     $pay_list->document_type  =  2;
                //     $pay_list->discount  =  $payment_list->discount;
                //     $pay_list->save();
                    
                //     $total = $this->calculate_total($total, $payment_list->discount, $payment_list->price);

                // }

                if(@$request->payment_sd_list['title']){
                    foreach($request->payment_sd_list['title'] as $key => $payment_sd_list_title){

                        // $pay_list = new PaymentList;
                        // $pay_list->title  =  $payment_sd_list_title;
                        // $pay_list->price  =  $request->payment_sd_list['price'][$key];
                        // $pay_list->ref_payment_id  =  $receipt->id;
                        // $pay_list->document_type  =  2; // Receipt ใบเสร็จรับเงิน
                        // $pay_list->discount  =  $request->payment_sd_list['discount'][$key];
                        // $pay_list->save();

                        $pay_list = new PaymentList;
                        $pay_list->title  =  $payment_sd_list_title;
                        $pay_list->price  =  $request->payment_sd_list['price'][$key];
                        $pay_list->ref_payment_id  =  $rent_bill->id;
                        $pay_list->document_type  =  1; // RentBill ใบแจ้งหนี้, ใบแจ้งชำระเงิน
                        $pay_list->discount  =  $request->payment_sd_list['discount'][$key];
                        $pay_list->save();
                        
                        $total = $this->calculate_total($total, $request->payment_sd_list['discount'][$key], $request->payment_sd_list['price'][$key]);
                    
                    }
                }

                $rent_bill->ref_status_id = 1;

            // }else{

            //     foreach($request->payment_list['title'] as $key => $payment_list_title){
            //         $pay_list = new PaymentList;
            //         $pay_list->title  =  $payment_list_title;
            //         $pay_list->price  =  $request->payment_list['price'][$key];
            //         $pay_list->ref_payment_id  =  $receipt->id;
            //         $pay_list->document_type  =  2;
            //         $pay_list->save();
            //     }

            //     $receipt_price = Receipt::where('ref_rent_bill_id', $request->id)->get();

            //     $receipt_price = $receipt_price->pluck('payment_list')->flatten()->sum('price');
                
            //     $invoice_price = $rent_bill->total_amount; // ยอดรวม ใบแจ้งหนี้
            //     if($receipt_price >= $invoice_price){ // เช็คว่ายอดรวมใบเสร็จ ทั้งหมด เท่า ใบแจ้งหนี้หรือยัง ถ้ายอดเท่ากัน แสดงว่า จ่ายครบแล้ว
            //         $rent_bill->ref_status_id = 2;

            //     }
            // }
            $rent_bill->total = $rent_bill->total_amount;

            $rent_bill->save();
            
            // $r_b = RentBill::find($request->ref_rent_bill_id);
            // $r_b->ref_status_id =  5; //  5 = ชำระแล้ว
            // $r_b->save();
            
            // if(@$file) $file->move($path, $image_name);

            // if(@$request->add_expenses_title){
            //     $expenses = new AdditionalCosts();
            //     $expenses->title = $request->add_expenses_title;
            //     $expenses->amount = $request->add_expenses_price;
            //     $expenses->ref_rent_bill_id = $rent_bill->id;
            //     $expenses->status = 1;
            //     $expenses->save();
            // }
            // if(@$request->discount_title){
            //     $update = new AdditionalCosts();
            //     $update->title = $request->discount_title;
            //     $update->amount = $request->discount_price;
            //     $update->ref_rent_bill_id = $rent_bill->id;
            //     $update->status = 2;
            //     $update->save();
            // }

            // foreach($request->buildings as $key => $building){
            //     $r_t_r = new RoomForRents;
            //     $r_t_r->date_stay  =  $date_stay;
            //     $r_t_r->ref_room_id  =  $room;
            //     $r_t_r->ref_floor_id  =  $key_2;
            //     $r_t_r->ref_building_id  =  $key;
            //     $r_t_r->ref_branch_id  =  $key;
            //     $r_t_r->ref_renter_id  =  $insert->id;
            //     $r_t_r->ref_user_id  =  1;
            //     $r_t_r->deposit  =  $request->deposit;
            //     $r_t_r->payment_method  =  $request->payment_method;
            //     $r_t_r->payment_received_date  =  $payment_received_date;
            //     $r_t_r->save();
                
            //     $r_b = new RentBill;
            //     $r_b->ref_room_for_rent_id  =  $r_t_r->id;
            //     $r_b->month  =  date('m')-1;
            //     $r_b->year  =  date('Y');
            //     $r_b->electricity_unit  =  300;
            //     $r_b->electricity_amount  =  105;
            //     $r_b->water_unit  =  200;
            //     $r_b->water_amount  =  106;
            //     $r_b->invoice_number =  $this->generateInvoiceCode();
            //     $r_b->ref_status_id =  1;
            //     $r_b->save();
            // }

            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    public function payment_bill(Request $request)
    {
        try{
            // return true;
            // return $this->generateInvoiceCode();
            $rent_bill = RentBill::find($request->id);
            // $rent_bill->payment_channel = $request->payment_channel;
            // $rent_bill->water_amount = $request->water_amount;
            // $rent_bill->water_unit = $request->water_unit;
            
            $amount = PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 0)->sum('price') - PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 1)->sum('price');

            $image_name = "";
            if($request->file('evidence_of_money_transfer')){
                $file = $request->file('evidence_of_money_transfer');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/receipt/";
                $image_name = $img_name.rand().'.'.$extension;
            }
            
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
                    $pay_list->save();
                }

                $receipt_price = Receipt::where('ref_rent_bill_id', $request->id)->get();

                $receipt_price = $receipt_price->pluck('payment_list')->flatten()->sum('price');
                
                $invoice_price = $rent_bill->total_amount; // ยอดรวม ใบแจ้งหนี้
                if($receipt_price >= $invoice_price){ // เช็คว่ายอดรวมใบเสร็จ ทั้งหมด เท่า ใบแจ้งหนี้หรือยัง ถ้ายอดเท่ากัน แสดงว่า จ่ายครบแล้ว
                    $rent_bill->ref_status_id = 2;

                }
            }
            // $rent_bill->total = 2;

            $rent_bill->save();
            
            // $r_b = RentBill::find($request->ref_rent_bill_id);
            // $r_b->ref_status_id =  5; //  5 = ชำระแล้ว
            // $r_b->save();
            
            if(@$file) $file->move($path, $image_name);

            // if(@$request->add_expenses_title){
            //     $expenses = new AdditionalCosts();
            //     $expenses->title = $request->add_expenses_title;
            //     $expenses->amount = $request->add_expenses_price;
            //     $expenses->ref_rent_bill_id = $rent_bill->id;
            //     $expenses->status = 1;
            //     $expenses->save();
            // }
            // if(@$request->discount_title){
            //     $update = new AdditionalCosts();
            //     $update->title = $request->discount_title;
            //     $update->amount = $request->discount_price;
            //     $update->ref_rent_bill_id = $rent_bill->id;
            //     $update->status = 2;
            //     $update->save();
            // }

            // foreach($request->buildings as $key => $building){
            //     $r_t_r = new RoomForRents;
            //     $r_t_r->date_stay  =  $date_stay;
            //     $r_t_r->ref_room_id  =  $room;
            //     $r_t_r->ref_floor_id  =  $key_2;
            //     $r_t_r->ref_building_id  =  $key;
            //     $r_t_r->ref_branch_id  =  $key;
            //     $r_t_r->ref_renter_id  =  $insert->id;
            //     $r_t_r->ref_user_id  =  1;
            //     $r_t_r->deposit  =  $request->deposit;
            //     $r_t_r->payment_method  =  $request->payment_method;
            //     $r_t_r->payment_received_date  =  $payment_received_date;
            //     $r_t_r->save();
                
            //     $r_b = new RentBill;
            //     $r_b->ref_room_for_rent_id  =  $r_t_r->id;
            //     $r_b->month  =  date('m')-1;
            //     $r_b->year  =  date('Y');
            //     $r_b->electricity_unit  =  300;
            //     $r_b->electricity_amount  =  105;
            //     $r_b->water_unit  =  200;
            //     $r_b->water_amount  =  106;
            //     $r_b->invoice_number =  $this->generateInvoiceCode();
            //     $r_b->ref_status_id =  1;
            //     $r_b->save();
            // }

            
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
        $invoice = RentBill::find($id);
        $contract = Contract::find($invoice->ref_contract_id);
        $data['expenses'] = AdditionalCosts::where('ref_rent_bill_id', $id)->get();
        $data['invoice'] = $invoice;
        $data['contract'] = $contract;
        $data['bank'] = Bank::get();

        if($invoice->ref_status_id == 3){
            return view('bill/incomplete', $data);
        }
        if($invoice->ref_status_id == 7){
            return view('bill/payment', $data);
        }
        return view('bill/invoice', $data);
    }
    public function bill_summary()
    {
        return $this->summary(session("branch_id"));
    }
    public function change_status_bill(Request $request, $id)
    {
        // return $request;
        try{
            if($id == 'all'){
                $insert = RentBill::where('ref_status_id', 2);
                $insert->update(['ref_status_id' => $request->status]);
                DB::commit();
                return true;
            }
            $insert = RentBill::whereIn('id', explode(',', $id));
            $insert->update(['ref_status_id' => $request->status]);

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
                "บิลค่าเช่าห้องเดือน".date('m-Y', strtotime('-1 month'))
            ],
            [
                "ห้อง",
                "ค่าเช่าห้อง",
                "ค่าน้ำประปา",
                "ค่าไฟฟ้า",
                "ค่าเช่าเฟอร์นิเจอร์",
                "ค่าที่จอดรถยนต์",
                "ค่าที่จอดมอเตอร์ไซค์",
                "ส่วนกลาง",
                "ค่าห้องพนักงาน",
                "จดค่าน้ำผิด",
                "หัก ภาษี",
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
            ]
        ];
        // return $data;
        foreach($results as $row){
            $data[] = [
                        $row->room_name,
                        $row->rent,
                        $row->water_amount,
                        $row->electricity_amount,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        number_format($row->total_amount),
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        $row->rent,
                        
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
        $writer->save("upload/export_excel/all-".date('m-Y', strtotime('-1 month')).".xlsx");
        return redirect("upload/export_excel/all-".date('m-Y', strtotime('-1 month')).".xlsx");
    }
}