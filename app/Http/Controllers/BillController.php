<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\BillController;
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
use App\Models\ClearBalance;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomForRents;
use App\Models\StatusRentBill;
use App\Models\Renter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
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
        // return Receipt::with('payment_list')->where('ref_status_id', 5)
        //                                 ->whereHas('room.floor.building', function ($query) {
        //                                     $query->where('ref_branch_id', session("branch_id"));
        //                                 })
        //                                 ->get();
        $rooms = Room::whereDoesntHave('rent_bill', function ($query) {
                                                $query->where('ref_type_id', 1)
                                                    ->where('rent_bills.year', date('Y'))
                                                    ->where('rent_bills.month', date('m'));
                                            })
                                            ->where('status', 2)
                                            ->get();
                                            
            $year = Carbon::now()->year;
            $month = Carbon::now()->month - 1;

            // ดึงเลขล่าสุดครั้งเดียว
            $latestInvoice = RentBill::where('year', $year)
                ->where('month', $month)
                ->lockForUpdate() // 🔒 สำคัญมาก
                ->latest('id')
                ->first();

            $sequence = $latestInvoice
                ? (int) substr($latestInvoice->invoice_number, -6)
                : 0;

        foreach($rooms as $room){
                $meter = Meter::where('ref_room_id', $room->id)->where('month', date('m'))->where('year', date('Y'))->first();
                $current_month_usage_water = $meter->water_unit - $room->rent_bill_rent->water_unit;
                $current_month_usage_electricity = $meter->electricity_unit - $room->rent_bill_rent->electricity_unit;
            // rent_bill_rent
                $r_b_room = new RentBill;  // สร้างบิลค่าเช่าห้อง สำหรับ Test
                $r_b_room->ref_room_for_rent_id  =  $room->rent_bill_rent->ref_room_for_rent_id;
                $r_b_room->month  =  date('m');
                $r_b_room->year  =  date('Y');
                // $r_b_room->previous_electricity_unit  =  (int)$row['electricity_meter_start_living'];
                $r_b_room->electricity_unit  =  $meter->electricity_unit;
                $r_b_room->electricity_amount  =  $room->ele_baht_per_unit*$current_month_usage_water;
                // $r_b_room->previous_water_unit  =  (int)$row['water_meter_start_living'];
                $r_b_room->water_unit  =  (int)$meter->water_unit;
                $r_b_room->water_amount  =  $room->water_baht_per_unit*$current_month_usage_electricity;

$sequence++;

    $invoiceCode = 'INV'. $year
                        . str_pad($month, 2, '0', STR_PAD_LEFT)
                        . str_pad($sequence, 6, '0', STR_PAD_LEFT);

                $r_b_room->invoice_number =  $invoiceCode;
                $r_b_room->ref_room_id =  $room->id;
                $r_b_room->ref_contract_id =  $room->contract->id;
                $r_b_room->ref_status_id =  3; // 3 = ไม่สมบูรณ์ / ค้างชำระ
                $r_b_room->ref_type_id =  1; // 1 = ค่าเช่าห้อง
                $r_b_room->ref_user_id =  Auth::id();
                $r_b_room->save();
                
                $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                $pay_list->title  =  "ค่าเช่าห้อง (Room rate) $room->name เดือน ".(date('m'))."/".date('Y');
                $pay_list->price  =  $room->rent+$room->furniture_rental+$room->air_rental;
                $pay_list->ref_payment_id  =  $r_b_room->id;
                $pay_list->document_type  =  1;
                $pay_list->save();
                
                $pay_list = new PaymentList; // สร้างรายการ ค่าน้ำ
                $pay_list->title  =  "ค่าน้ำ (Water rate) เดือน ".(date('m'))." ("; 
                $pay_list->unit  =  (int)$meter->water_unit;
                $pay_list->price  =  $room->water_baht_per_unit*(int)$current_month_usage_water;
                $pay_list->ref_payment_id  =  $r_b_room->id;
                $pay_list->document_type  =  1;
                $pay_list->save();

                $pay_list = new PaymentList; // สร้างรายการ ค่าไฟ
                $pay_list->title  =  "ค่าไฟฟ้า (Electrical rate) เดือน ".(date('m'))." (".(int)$meter->electricity_unit." - ".(int)$room->rent_bill_rent->electricity_unit." = ".(int)$meter->electricity_unit-(int)$room->rent_bill_rent->electricity_unit." ยูนิต)";
                $pay_list->unit  =  (int)$meter->electricity_unit;
                $pay_list->price  =  $room->ele_baht_per_unit*(int)$current_month_usage_electricity;
                $pay_list->ref_payment_id  =  $r_b_room->id;
                $pay_list->document_type  =  1;
                $pay_list->save();
        }
        DB::commit();
        $data['renter'] = Renter::whereHas('room_for_rent', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })
                                ->whereHas('room_for_rent.rent_bills', function ($query) {
                                                    $query->where('ref_type_id', 1)
                                                            ->where('ref_status_id', 7);
                                                })
                                ->whereHas('room_for_rent.room', function ($query) {
                                    $query->where('status', 2);
                                })->get();
        
        $this->get_update_to_current_fine();

        $data['page_url'] = 'bill';
        $data['status_rent_bill'] = StatusRentBill::get();
        $data['buildings'] = Building::get();
        $data['floors'] = Floor::get();

        return view('bill/index', $data);
    }
    
    public function get_update_to_current_fine(){

        try{
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
            }
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    public function get_room_for_payment(Request $request) // ดึง ห้อง   // ข้อมูลชำระเงินห้อง ที่ติ๊ก
    {
        // return $request;
        // $data['list_data'] = RentBill::with('payment_list')
        //                                 ->where('ref_status_id', '!=', 5)
        //                                 ->whereHas('room.floor.building', function ($query) {
        //                                     $query->where('ref_branch_id', session("branch_id"));
        //                                 })
        //                                 ->where('ref_type_id', 1)
        //                                 ->get()
        //                                 ->filter(function ($bill) {
        //                                     return $bill->total_not_discount_amount >= $bill->total_amount;
        //                                 });
        // $data['type'] = [ 1 => 'บิลค่าเช่าห้อง', 2 => 'บิลค่าประกันห้อง', 3 => 'บิลค่าจองห้อง', 4 => 'บิลย้ายออก', 4 => 'บิลหนี้สูญ' ];
        // $data['payment_channel'] = [ 1 => 'เงินสด', 2 => 'โอนเงิน', 3 => 'หักจากเงินประกัน'];
        $data['list'] = $request->list;
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        // return $request->invoice_ids;
        // if($request->delete_list_id){
        //     $request->
        // }
        $invoice_alls = RentBill::orderBy('rooms.name')
                                        ->join('rooms', 'rent_bills.ref_room_id', '=', 'rooms.id')
                                        // ->with('payment_rent_room_array')
                                        ->whereIn('rent_bills.id', $request->invoice_ids)
                                        ->whereNotIn('rent_bills.ref_status_id', [3,5]);
        if(@$request->delete_list_id){
            $invoice_alls = $invoice_alls->whereNotIn('rent_bills.id', $request->delete_list_id);
        }
        $invoice_alls = $invoice_alls->where('rent_bills.ref_type_id', 1)
                                        ->select('rent_bills.*')
                                        ->get();
        $data['invoice_alls'] = $invoice_alls; 
        // return 123;
        return view('bill/list-payment-all', $data);
        
        // $html = view('bill/list-payment-all', $data)->render();
        // $have = count($invoice_alls) > 0 ? 1 : 0;
        // return ['html' => $html, 'have' => $have];
    }
    
    function get_list_payment_by_id(Request $request) // ดึง ห้อง   // ข้อมูลชำระเงินห้อง ที่ติ๊ก
    {
        if(!$request->list){
            return "";
        }
        $data['list'] = $request->list;
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        // return $request->invoice_ids;
        $invoice = RentBill::find($request->invoice_id);
        $data['total_installment_payment_price'] = PaymentList::where('installment_payment', 1)
                                                        ->where('document_type', 2)
                                                        ->where('paid', 0)
                                                        ->whereHas('receipt', function ($q) use ($request) {
                                                            $q->where('ref_rent_bill_id', $request->invoice_id);
                                                        })
                                                        ->sum('price'); // ยอดที่แบ่งจ่ายแล้ว แต่ยังไม่เอาไปลด
        // return $receipt_list = PaymentList::whereHas('receipt', function ($query) use ($invoice) {
        //                             $query->where('ref_rent_bill_id', $invoice->id);
        //                         })->where('title', $invoice->payment_fine_array)->where('fine', 1)->where('document_type', 2)->first();
        $data['payment_fine_price'] = 0;
        if (in_array('payment_other_array', $request->list)) {
            $data['payment_fine_price'] = $invoice->payment_fine->price ?? 0 - $invoice->receipt->sum(function ($r) { return $r->total_fine_amount; }); // ค่าปรับ RentBill - ค่าปรับ Receipt // หายอดค่าปรับที่เหลือ
        }
        $data['invoice'] = $invoice;
        // return 123;
        return view('bill/list-payment-by-id', $data);
        
    }
    public function waiting_for_confirmation(Request $request) // ดึง ใบเสร็จที่รอคอนเฟิร์มการชำระเงิน ref_status_id = 2
    {
        $request['limit'] = 9999999;
        $request['re'] = 1;
        $request['ref_status_id'] = 2;
        // $data['list_data'] = RentBill::with('payment_list')
        //                                 ->where('ref_status_id', '!=', 5)
        //                                 ->whereHas('room.floor.building', function ($query) {
        //                                     $query->where('ref_branch_id', session("branch_id"));
        //                                 })
        //                                 ->where('ref_type_id', 1)
        //                                 ->get()
        //                                 ->filter(function ($bill) {
        //                                     return $bill->total_not_discount_amount >= $bill->total_amount;
        //                                 });
        $data['type'] = [ 1 => 'บิลค่าเช่าห้อง', 2 => 'บิลค่าประกันห้อง', 3 => 'บิลค่าจองห้อง', 4 => 'บิลย้ายออก', 4 => 'บิลหนี้สูญ' ];
        $data['payment_channel'] = [ 1 => 'เงินสด', 2 => 'โอนเงิน', 3 => 'หักจากเงินประกัน'];
        $data['list_data'] = Receipt::orderBy('rooms.name')
                                        ->with('payment_list')
                                        ->join('rooms', 'receipts.ref_room_id', '=', 'rooms.id')
                                        ->where('receipts.ref_status_id', 2)
                                        ->whereHas('room.floor.building', function ($query) {
                                            $query->where('ref_branch_id', session("branch_id"));
                                        })
                                        ->select('receipts.*')
                                        ->get()
                                        ->filter(function ($bill) {
                                            return $bill->total_amount;
                                        });

        return view('bill/waiting-for-confirmation', $data);
    }
    public function confirmation(Request $request)
    {
        $request['limit'] = 9999999;
        $request['re'] = 1;
        $request['ref_status_id'] = 2;
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->pluck('bank', 'id');
        
        $confirm_by_ceo = Receipt::with('payment_list')
                                    ->where('ref_status_id', 5)
                                    ->where('receipts.payment_channel', 1)
                                    ->where('receipts.clear_balances', 0)
                                    ->whereIn('ref_type_id', [1,2,3])
                                    ->whereHas('room.floor.building', function ($query) {
                                        $query->where('ref_branch_id', session('branch_id'));
                                })
                                    ->get()
                                    ->sum('total_amount');

        $list_data = Receipt::with('payment_list')
                                ->where('receipts.ref_status_id', 5)
                                ->where('receipts.payment_channel', 2)
                                ->where('receipts.clear_balances', 0)
                                ->whereIn('ref_type_id', [1,2,3])
                                ->whereHas('room.floor.building', function ($query) {
                                    $query->where('ref_branch_id', session('branch_id'));
                                })
                                ->get()
                                ->filter(fn($bill) => $bill->total_amount)
                                ->groupBy('ref_bank_id')
                                ->map(fn($group) => $group->sum(fn($item) => $item->total_amount));; // ใช้ Accessor ได้ตรงนี้
        $total_amount = [];
        foreach($list_data as $bank_id => $amount){
            $bank = Bank::find($bank_id);
            $total_amount[] = [ 'bank' => $bank, 'amount' => $amount];
        }
        // return $total_amount;
        // foreach ($total_amount as $key => $item){
        // // foreach($total_amount as $total){
        //     return $item['bank']->bank;
        // }
        $data['confirm_by_ceo'] = $confirm_by_ceo;
        $data['total_amount'] = $total_amount;
        
        $data['list_data'] = $list_data;
        return view('bill/confirmation', $data);
    }
    
    public function datatable(Request $request)
    {
        $this->get_update_to_current_fine();
        // return RentBill::find(96)->payment_list;
        $results = RentBill::orderBy('rooms.name')
                                ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                ->where('room_for_rents.status', 1)
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
            session(['month' => $request->month]);
            $results = $results->Where('rent_bills.year', explode('-', $request->month)[0])->Where('rent_bills.month', explode('-', $request->month)[1]);
        }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $allIdsQuery = clone $results; // <-- แยกออกเป็น object ใหม่
        $allIds = $allIdsQuery->where('rent_bills.ref_status_id', 3)
                            ->get()
                            ->pluck('id')
                            ->implode(',');

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

        $data['allIds'] = $allIds;
        $data['list_data'] = $results;
        
        if(@$request->re){
            return $data['list_data'];
        }

        return view('bill/table', $data);
    }
    // คอนเฟิร์มบิล
    public function incomplete_update(Request $request, $submit = null)
    {
        try{
            // return $submit;
            $rent_bill = RentBill::find($request->id);
            $rent_bill->water_amount = $request->water_amount;
            $rent_bill->water_unit = $request->water_unit;
            
            $pay_list = PaymentList::find($request->payment_list_id);
            $pay_list->unit  =  $request->water_unit;
            $pay_list->price  =  $request->water_amount;
            $pay_list->save();

            $amount = PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 0)->sum('price') - PaymentList::where('ref_payment_id', $rent_bill->id)->where('document_type', 1)->where('discount', 1)->sum('price');
            
            $total = Room::find($request->ref_room_id)->rent;

            PaymentList::where('ref_payment_id', $rent_bill->id)->where('new_list_from_incomplate', 1)->where('document_type', 1)->delete();
            
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
            if(@$submit == 'approve'){
                $rent_bill->ref_status_id = 7;
            }

            $rent_bill->remark = $request->remark;
            $rent_bill->total = $rent_bill->total_amount;

            $rent_bill->save();

            $last_bill = RentBill::where('ref_room_id', $rent_bill->ref_room_id)->orderBy('year', 'DESC')->orderBy('month', 'DESC')->first();
            if($last_bill->id == $rent_bill->id){
                $meter = Meter::where('ref_room_id', $rent_bill->ref_room_id)->orderBy('year', 'desc')->orderBy('month', 'desc')->first();
                $meter->water_unit = $request->water_unit;
                $meter->save();
            }
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    // คอนเฟิร์มบิลทั้งหมด
    public function confirm_bill_all(Request $request)
    {
        try{
            RentBill::whereIn('id', $request->id)->where('ref_status_id', 3)->update(['ref_status_id' => 7]);
            
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
            // $receipt->ref_occupancy_id  =  $room->ref_occupancy_id;
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
            $receipt->paid_on_checkout  =  $request->paid_on_checkout ?? 0;
            $receipt->remark  =  $request->remark;
            if($request->payment_channel == 3){
                $receipt->ref_status_id  =  5;
            }else{
                $receipt->ref_status_id  =  2;
            }
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

            $payment_list_rent_bad = PaymentList::whereHas('invoice', function ($query) use ($room) {
                                            $query->where('ref_type_id', 5)->where('ref_contract_id', $room->contract->id);
                                        })
                                        ->where('document_type', 1)
                                        ->get();
            if($payment_list_rent_bad->isNotEmpty()){
                // return "มี";
                foreach($payment_list_rent_bad as $p_rent_bad){
                    if($p_rent_bad->bad_debt_rent_status == 1){
                        PaymentList::destroy($p_rent_bad->id);
                    }
                }
                // return $payment_list_rent_bad;
            }

            $bad_debt = RentBill::where('ref_type_id', 5)->where('ref_contract_id', $room->contract->id)->get();
            if($bad_debt->isNotEmpty()){
                // return "มี";
                foreach($bad_debt as $bad){
                    if(count($bad->payment_list) == 0){
                        RentBill::destroy($bad->id);
                    }
                }
                // return $payment_list_rent_bad;
            }

            
            $total = Room::find($request->ref_room_id)->rent;

            if($request->payment_format == 1){ // ถ้าติ๊กจ่ายเต็มจำนวน 

                foreach($rent_bill->payment_list as $payment_list){
                    $title = $payment_list->title;
                    if (strpos($payment_list->title, 'Water rate') !== false){
                        $title = $payment_list->title.number_format($payment_list->unit).' - '.($rent_bill->previous_water_unit).' = '.($payment_list->unit - ($rent_bill->previous_water_unit)).' ยูนิต)';
                    }
                    $pay_list = new PaymentList;
                    $pay_list->title  =  $title;
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

                        PaymentList::where('id', $request->payment_sd_list['id'][$key])->update(['paid' => 1]);

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

                // $rent_bill->paid_on_checkout  =  $request->paid_on_checkout ?? 0;
                $rent_bill->ref_status_id = 2;

            }else{  // ถ้าติ๊กแบ่งจ่าย

                foreach($request->payment_list['title'] as $key => $payment_list_title){

                    $pay_list = new PaymentList;
                    $pay_list->title  =  $payment_list_title;
                    $pay_list->price  =  $request->payment_list['price'][$key];
                    $pay_list->ref_payment_id  =  $receipt->id;
                    $pay_list->document_type  =  2;
                    $pay_list->discount  =  $request->payment_list['discount'][$key];

                    if(@$request->payment_list['id'][$key]){
                        if($request->payment_list['id'][$key] === "installment_payment"){
                            PaymentList::where('installment_payment', 1)
                                        ->where('document_type', 2)
                                        ->whereHas('receipt', function ($q) use ($request) {
                                            $q->where('ref_rent_bill_id', $request->id);
                                        })
                                        ->update([
                                            'paid' => 1
                                        ]);
                        }else{
                            PaymentList::where('id', $request->payment_list['id'][$key])->update(['paid' => 1]);
                        }
                    }else{
                        $pay_list->installment_payment  =  1;
                    }

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
            $expenses->time  =  date('H:i:s');
            $expenses->ref_room_id  =  $request->ref_room_id;
            $expenses->ref_category_id  =  1;
            $expenses->name  =  $receipt->renter->fullName();
            $expenses->address  =  $receipt->renter->fullThaiAddress();
            $expenses->id_card_number  =  $receipt->renter->id_card_number;
            // $expenses->branch  =  0;
            $expenses->phone  =  $receipt->renter->phone;
            // $expenses->remark  =  0;
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
//// ดึงห้อง ชำระเงินหลายห้อง
    public function get_room_rent_bill(Request $request, $renter_id)
    {

        $data['page_url'] = 'room';
        $data['renter_id'] = $renter_id;
        $roomIds = RentBill::where('ref_type_id', 1)
                                ->whereHas('room_for_rent', function ($query) use ($renter_id) {
                                    $query->where('ref_renter_id', $renter_id)
                                            ->where('status', 1);
                                })
                                ->pluck('id')
                                ->toArray();
                                
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        
        return $roomIds;
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
    public function invoice($id, $overdue = null)
    {
        
        $data['page_url'] = 'bill';
        $invoice = RentBill::with(['receipt.payment_list_not_fine', 'room_for_rent.room.floor.building'])->find($id);
        $receipt = Receipt::where('ref_rent_bill_id', $id)->get();
        $data['receipt_total_amount'] = $receipt->sum->total_amount ?? 0;
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
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
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

        if(@$overdue == 1){
            $data['overdue'] = 1;
        }

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
        $summary = $this->summary(session("branch_id"));
        $summary['cash_wait_for_confirm'] = number_format($summary['cash_wait_for_confirm']);
        $summary['transfer'] = number_format($summary['transfer']);
        return $summary;
    }
    public function change_status_bill_receipt(Request $request)
    {
        try{
            // return $request;
            // if($request->status == 3){
            //     PaymentList::whereHas('invoice.room.floor.building', function ($query) {
            //                         $query->where('ref_branch_id', session("branch_id"));
            //                     })->where('ref_payment_id', $id)->where('document_type', 1)->where('new_list_from_incomplate', 1)->get();
            // }
            // if($id == 'all'){
                Receipt::whereIn('id', $request->id)->update(['ref_status_id'=> 5]);
                foreach($request->id as $id){
                    $receict = Receipt::find($id);
                    $bill = RentBill::with(['receipt.payment_list', 'payment_list'])
                                        ->where('id', $receict->ref_rent_bill_id)
                                        ->first();

                    // foreach ($bills as $bill) {
                    //     if ($bill->total_not_discount_amount >= $bill->total_amount) {
                    //         foreach ($bills as $bill) {
                    // return $bill->total_amount;
                                if ($bill->total_not_discount_amount >= $bill->total_amount) {
                                    $bill->ref_status_id = $request->status;
                                    $bill->save();
                                }
                    //         }
                    //     }
                    // }
                }
                DB::commit();
                return true;
            // }

            // $update = RentBill::whereIn('id', explode(',', $id));
            // $update->update(['ref_status_id' => $request->status]);

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    public function clear_balance(Request $request)
    {
        try{
                // $clear_balance = new ClearBalance;
                // $clear_balance->price = $request->price;
                // $clear_balance->ref_branch_id = session("branch_id");
                // $clear_balance->save();
                Receipt::where('ref_status_id', 5)->update(['clear_balances' => 1]);
                DB::commit();
                return true;

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    public function change_status_bill_invoice(Request $request, $id = null)
    {
        try{
            // return $request;
            if($request->status == 3){
                // PaymentList::whereHas('invoice.room.floor.building', function ($query) {
                //                     $query->where('ref_branch_id', session("branch_id"));
                //                 })->where('ref_payment_id', $id)->where('document_type', 1)->where('new_list_from_incomplate', 1)->get();
                                
                $update = RentBill::where('id', $id)->update(['ref_status_id' => $request->status]);
            }
            // if($id == 'all'){
                // Receipt::whereIn('id', $request->id)->update(['ref_status_id'=> 5]);
                // return $request->id;
                if(!$request->id){
                    $request->id = [$id];
                }
                $bills = RentBill::with(['receipt.payment_list', 'payment_list'])
                                        ->whereIn('id', $request->id)
                                        ->get();
                // foreach($request->id as $id){
                //     $receict = Receipt::find($id);
                //     $bill = RentBill::with(['receipt.payment_list', 'payment_list'])
                //                         ->where('id', $receict->ref_rent_bill_id)
                //                         ->first();

                    // foreach ($bills as $bill) {
                    //     if ($bill->total_not_discount_amount >= $bill->total_amount) {
                            foreach ($bills as $bill) {
                                Receipt::where('ref_rent_bill_id', $bill->id)->update(['ref_status_id'=> 5]);
                    // return $bill->total_amount;
                                if ($bill->total_not_discount_amount >= $bill->total_amount) {
                                    $bill->ref_status_id = $request->status;
                                    $bill->save();
                                }
                            }
                    //     }
                    // }
                // }
                DB::commit();
                return true;
            // }

            // $update = RentBill::whereIn('id', explode(',', $id));
            // $update->update(['ref_status_id' => $request->status]);

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
                foreach($re_del->payment_list as $payment_list){
                    
                    PaymentList::where('ref_payment_id', $re_del->ref_rent_bill_id)->where('document_type', 1)->Where('title', $payment_list->title)->update(['paid' => 0]); // แก้ไข paid ของรายการ ใบแจ้งหนี้ ให้เป็น 0 
                    
                }
                    PaymentList::where('ref_payment_id', $re_del->id)->where('document_type', 2)->delete(); // ลบรายการ ใบเสร็จ

                
                IncomeExpenses::where('ref_receipt_id', $id)->delete();

                $re_del?->delete();
                
                $rent_bill = RentBill::find($re_del->ref_rent_bill_id);
                // if(count($rent_bill->receipt) == 0){
                   $rent_bill->ref_status_id = 7;
                   $rent_bill->save();
                   
                    // DB::commit();
                    // return [ 'rent_bill_id' => $rent_bill->id ];
                // }

                // DB::commit();
                // return true;

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
    public function export_excel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        $results = RentBill::orderBy('rooms.name','ASC')
                                ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                // ->where('rent_bills.ref_status_id', '!=', 3)
                                ->distinct('rent_bills.id')
                                ->select('rent_bills.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'),
                                'rooms.name as room_name', 'rooms.id as room_id', 'rooms.rent', 'rooms.furniture_rental', 'rooms.air_rental', 'renters.id_card_number', 'renters.phone');
                                
        if(@$request->month){
            $results = $results->Where('rent_bills.year', explode('-', $request->month)[0])->Where('rent_bills.month', explode('-', $request->month)[1]);
        }
                                
        $results = $results->get();

        $branch = Branch::find(session("branch_id"));

        $service = Service::where('ref_branch_id', session("branch_id"))
                            ->pluck('name')
                            ->toArray();

        $data_1 = [
            "ห้อง",
            "ค่าเช่าห้อง",
            "มิเตอร์น้ำก่อน",
            "มิเตอร์น้ำหลัง",
            "หน่วยที่ใช้",
            "ค่าน้ำประปา",
            "มิเตอร์ไฟฟ้าก่อน",
            "มิเตอร์ไฟฟ้าหลัง",
            "หน่วยที่ใช้",
            "ค่าไฟฟ้า",
        ];
        $data_2 = [
            "ค่าปรับ",
            "รวม",
            "หมายเหตุ",
            "ชื่อ",
            "ที่อยู่",
            "เลขประจำตัวผู้เสียภาษี",
            "สำนักงานสาขา",
            "เบอร์โทร",
            "สถานะบิล"
        ];

        $data = [
            [$branch->name],
            ["บิลค่าเช่าห้องเดือน " . date('m-Y', strtotime($request->month))],
            array_merge($data_1, $service, $data_2)
        ];

        // วนลูปข้อมูลจริง
        foreach ($results as $row) {
            $fine = PaymentList::where('ref_payment_id', $row->id)
                ->where('document_type', 1)
                ->where('fine', 1)
                ->first();

            $unit_water_used = $row->water_unit - $row->previous_water_unit;
            $unit_electricity_used = $row->electricity_unit - $row->previous_electricity_unit;

            $data_list = [
                $row->room_name,
                $row->rent,
                $row->previous_water_unit == 0 ? "0" : $row->previous_water_unit,
                $row->water_unit == 0 ? "0" : $row->water_unit,
                $row->unit_water_used == 0 ? "0" : $row->unit_water_used,
                (string)$row->water_amount,
                $row->previous_electricity_unit == 0 ? "0" : $row->previous_electricity_unit,
                $row->electricity_unit == 0 ? "0" : $row->electricity_unit,
                $row->unit_electricity_used == 0 ? "0" : $row->unit_electricity_used,
                (string)$row->electricity_amount,
            ];

            $data_list_2 = [
                $fine->price ?? "0",
                number_format($row->total_amount),
                "0",
                $row->renter_name,
                @$row->room_for_rent->renter->fullThaiAddress(),
                $row->id_card_number,
                "",
                $row->phone,
                $row->status->name
            ];

            // ดึงราคาบริการแต่ละรายการ
            $service_price = Service::where('services.ref_branch_id', session('branch_id'))
                                    ->leftJoin('room_has_services', function ($join) use ($row) {
                                        $join->on('services.id', '=', 'room_has_services.ref_service_id')
                                            ->where('room_has_services.ref_room_id', $row->room_id);
                                    })
                                    ->selectRaw('COALESCE(room_has_services.price, 0) as price')
                                    ->pluck('price')
                                    ->toArray();

            // รวมเป็นแถวสุดท้าย
            $data[] = array_merge($data_list, $service_price, $data_list_2);
        }

        // ใส่ข้อมูลลงในชีต
        $rowNum = 1;
        foreach ($data as $row) {
            $col = 'A';
            foreach ($row as $cellValue) {
                $sheet->setCellValue($col . $rowNum, $cellValue);
                $col++;
            }
            $rowNum++;
        }

        // ✅ ใส่พื้นหลังแถวหัวตาราง (แถวที่ 3)
        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . '3')
            ->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('CCE5FF'); // ฟ้าอ่อน

        // ✅ ใส่พื้นหลังเฉพาะคอลัมน์ค่าน้ำ (F) และค่าไฟ (J)
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("F4:F{$lastRow}")
            ->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('d9f8fc'); // เขียวอ่อน

        $sheet->getStyle("J4:J{$lastRow}")
            ->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('fce5e6'); // เหลืองอ่อน

        // ✅ ใส่เส้นขอบทุกช่อง
        $lastCol = $sheet->getHighestColumn();
        $sheet->getStyle("A1:{$lastCol}{$lastRow}")
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // ✅ ปรับความกว้างคอลัมน์อัตโนมัติ
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $sheet->fromArray($data);
        $sheet->getStyle(
            'A1:' . 
            $sheet->getHighestColumn() . 
            $sheet->getHighestRow()
        )->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $writer = new WriterXlsx($spreadsheet);
        $writer->save("upload/export_excel/all-".date('m-Y', strtotime($request->month)).".xlsx");
        return redirect("upload/export_excel/all-".date('m-Y', strtotime($request->month)).".xlsx");
    }
    public function export_excel_summary(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        
        $results = RentBill::orderBy('rooms.name')
                                ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                ->where('rent_bills.ref_type_id', 1)
                                ->where('room_for_rents.status', 1)
                                ->distinct('rent_bills.id')
                                ->select('rent_bills.*', 'rent_bills.id as rent_bill_id', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
                                
        if(@$request->search){
            $results = $results->Where(function ($query) use ($request) {
                                    $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', renters.surname) LIKE ?", ["%{$request->search}%"])
                                        ->orWhere('rooms.name','LIKE','%'.$request->search.'%');
                                });
        }
            // return 456;
        if(@$request->ref_status_id && $request->ref_status_id != "all"){
            // return 123;
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
        if(@$request->building && $request->building != "all"){
            $results = $results->Where('room_for_rents.ref_building_id', $request->building);
        }
        if(@$request->floor && $request->floor != "all"){
            $results = $results->Where('room_for_rents.ref_floor_id', $request->floor);
        }
        if(@$request->month){
            $results = $results->Where('rent_bills.year', explode('-', $request->month)[0])->Where('rent_bills.month', explode('-', $request->month)[1]);
        }
                                
        $results = $results->get();

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
        $writer->save("upload/export_excel/บิลค่าเช่า-".date('m-Y', strtotime($request->month)).".xlsx");
        return redirect("upload/export_excel/บิลค่าเช่า-".date('m-Y', strtotime($request->month)).".xlsx");
    }
}