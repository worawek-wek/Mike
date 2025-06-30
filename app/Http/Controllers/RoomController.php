<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Branch;
use App\Models\Receipt;
use App\Models\PaymentList;
use App\Models\Province;
use App\Models\Service;
use App\Models\RoomHasService;
use App\Models\Discount;
use App\Models\RoomHasDiscount;
use App\Models\District;
use App\Models\Subdistrict;
use App\Models\Renter;
use App\Models\Meter;
use App\Models\Building;
use App\Models\Floor;
use App\Models\RentBill;
use App\Models\Room;
use App\Models\Bank;
use App\Models\Asset;
use App\Models\RoomHasAsset;
use App\Models\RoomForRents;
use App\Models\Contract;
use App\Models\StatusRoom;
use App\Models\AdditionalCosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Carbon\Carbon;

DB::beginTransaction();

class RoomController extends Controller
{
    public function index(Request $request)
    {
        // return $receipt = Receipt::where('ref_rent_bill_id', 48)->get()->pluck('total_amount')->sum();

        // return Auth::id();
        $data['page_url'] = 'room';
        // $contract_room_has = Contract::groupBy('ref_room_id')->get('ref_room_id')->toArray();
        // $data['renter'] = RoomForRents::leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
        //                                 // ->whereNotIn('room_for_rents.id', $contract_room_has)
        //                                 ->select('renters.*')
        //                                 ->distinct('renters.id')
        //                                 ->orderBy('renters.id')
        //                                 ->get();
        $data['renter_contract'] = RoomForRents::whereHas('rent_bills', function ($query) {
                                                    $query->where('ref_type_id', 3)
                                                            ->where('ref_status_id', '!=', 5);
                                                })
                                                ->with('renter')
                                                ->select('ref_renter_id') // เลือกเฉพาะ ref_room_id
                                                ->distinct()
                                                ->get();

        $data['renter'] = Renter::whereHas('room_for_rent', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })->get();
                                        
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['subdistrict'] = Subdistrict::get();
        $data['buildings'] = Building::where('ref_branch_id', session("branch_id"))->get();
        $data['floors'] = Floor::get();
        $data['service'] = Service::get();
        $data['bank'] = Bank::get();
        $data['asset'] = Asset::with('room_has_asset.room')->get();
        // $data['asset'] = Asset::get();
        // $data['selected_buildings'] = [];

        // $room = Room::where('status', 1)->get('id')->toArray();
        // $room_check = [];
        // foreach($room as $r_f_r){
        //     $room_check[] = $r_f_r['id'];
        // }
        // $data['room_check'] = $room_check;
        $data['summary'] = $this->summary(session("branch_id"));
        
        return view('room/index', $data);
    }
    public function reserve_form(Request $request)
    {
        // return Auth::id();
                                        
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['subdistrict'] = Subdistrict::get();
        $data['buildings'] = Building::where('ref_branch_id', session("branch_id"))->get();
        $data['floors'] = Floor::get();
        $data['asset'] = Asset::with('room_has_asset.room')->get();
        
        return view('room/room-reserve-form', $data);
    }
    public function show($id)
    {
        $data['page_url'] = 'room';

        $room = Room::find($id);
        if($room->status == 2){
            $contract = Contract::where('ref_room_id', $id)->orderBy('id','DESC')->first();
            $data['contract'] = $contract;
        }
        
        $room_for_rent = RoomForRents::leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                                    ->where('room_for_rents.ref_room_id', $id)
                                                    ->select('room_for_rents.*','room_for_rents.id as room_for_rent_id', 'renters.*', 'renters.id as renter_id', DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                                    ->orderBy('room_for_rents.created_at', 'desc') // หรือใช้ 'id' ตามที่ต้องการ
                                                    ->first();
        $data['room_for_rent'] = $room_for_rent;
        $data['renter'] = Renter::leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                                    ->where('room_for_rents.ref_room_id', $id)
                                    ->select('renters.*')
                                    ->get();

        $data['bill_month'] = RentBill::oldest()->first();

        // $data['bill_month'] = RentBill::leftJoin('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
        //                     ->where('room_for_rents.ref_room_id', $id)
        //                     // ->where('rent_bills.ref_type_id', 1)
        //                     ->orderBy('rent_bills.year', 'DESC')
        //                     ->orderBy('rent_bills.month', 'DESC')
        //                     ->groupBy('rent_bills.month', 'rent_bills.year')
        //                     ->select('rent_bills.month', 'rent_bills.year')
        //                     ->get();
        // $invoice_old = RentBill::leftJoin('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
        //                     ->where('room_for_rents.ref_room_id', $id)
        //                     ->where('rent_bills.ref_type_id', 1)
        //                     ->orderBy('rent_bills.created_at', 'ASC')
        //                     ->first();
        $month_thai = [
            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];
        $data['month_thai'] = $month_thai;
        $data['receipt'] = Receipt::where('ref_room_id', $id)->where('ref_type_id', 3)->orderBy('id','DESC')->first();
        $data['room'] = $room;
        $data['otherRooms'] = Room::whereHas('floor.building', function ($query) {
                                        $query->where('ref_branch_id', session("branch_id"));
                                    })->where('status', 0)->whereNot('id', $id)->get();
        $data['service'] = Service::get();
        $data['discount'] = Discount::get();
        $meter = Meter::where('ref_room_id', $id)->orderBy('created_at','DESC')->first();
        $data['meter'] = $meter;
        $data['room_has_service'] = RoomHasService::where('ref_room_id', $id)->pluck('ref_service_id')->toArray();
        $data['room_has_discount'] = RoomHasDiscount::where('ref_room_id', $id)->pluck('ref_discount_id')->toArray();
        $province = Province::find($room_for_rent->ref_province_id)->name_in_thai;
        $district = District::find($room_for_rent->ref_district_id)->name_in_thai;
        $subdistrict = Subdistrict::find($room_for_rent->ref_subdistrict_id);
        $data['asset'] = Asset::with(['room_has_asset' => function ($query) use ($id) { // ดึงข้อมูล รายการทรัพย์สิน
                                        $query->where('ref_room_id', $id); // with โดยแค่อันที่ห้องนี้มี
                                    }])->whereIn('id',[1,2])->get();
        $data['asset_has_room'] = RoomHasAsset::whereIn('ref_room_id', (array) $id)
                                                ->pluck('status', 'ref_asset_id')
                                                ->toArray();
        $data['address'] = $room_for_rent->addess.' '.$subdistrict->name_in_thai.' '.$district.' '.$province.' '.$subdistrict->zip_code;
        // return $room_for_rent->room_for_rent_id;
        $move_invoice_7 = RentBill::where('ref_status_id', 7)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_invoice_2 = RentBill::where('ref_type_id', 2)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_invoice_5 = RentBill::where('ref_type_id', 1)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_contract = Contract::find(@$move_invoice_5->ref_contract_id);
        $data['move_contract'] = $move_contract;
        if(@$move_invoice_7){
            $data['move_expenses'] = AdditionalCosts::where('ref_rent_bill_id', $id)->get();
            $data['move_invoice_7'] = $move_invoice_7;
            $data['move_bank'] = Bank::get();
        }
        
        $data['move_invoice_2'] = $move_invoice_2;
        $data['move_invoice_5'] = $move_invoice_5;
        
        return view('room/view', $data);
    }
    
//// รายการทรัพย์สิน
    public function get_asset($room_id, $asset_id)
    {
        $data['page_url'] = 'room';
        
        $room_has_asset = RoomHasAsset::where('ref_room_id', $room_id)->where('ref_asset_id', $asset_id)->first();
        if($room_has_asset){

            $data['room_has_asset'] = $room_has_asset;

        }else{
            $insert = new RoomHasAsset();
            $insert->ref_room_id = $room_id;
            $insert->ref_asset_id = $asset_id;
            $insert->status = 0;
            $insert->condition = 1;
            $insert->image_name = "";
            $insert->remark = "";
            $insert->save();

            $data['room_has_asset'] = $insert;

            DB::commit();
        }
        
        return view('room/room-asset-form', $data);
    }

//// ย้ายออก
    public function get_move_out($id)
    {
        $room = Room::find($id);
        $data['room'] = $room;

        return $room_for_rent = RoomForRents::leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                                    ->where('room_for_rents.ref_room_id', $id)
                                                    ->select('room_for_rents.*','room_for_rents.id as room_for_rent_id', 'renters.*', 'renters.id as renter_id', DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                                    ->orderBy('room_for_rents.created_at', 'desc') // หรือใช้ 'id' ตามที่ต้องการ
                                                    ->first();

        $data['renter'] = Renter::leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                                    ->where('room_for_rents.ref_room_id', $id)
                                    ->select('renters.*')
                                    ->get();

        $data['asset'] = Asset::with(['room_has_asset' => function ($query) use ($id) { // ดึงข้อมูล รายการทรัพย์สิน
                                        $query->where('ref_room_id', $id); // with โดยแค่อันที่ห้องนี้มี
                                    }])->whereIn('id',[1,2])->get();

        $move_invoice_7 = RentBill::where('ref_status_id', 7)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_invoice_2 = RentBill::where('ref_type_id', 2)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_invoice_5 = RentBill::where('ref_type_id', 1)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_contract = Contract::find(@$move_invoice_5->ref_contract_id);
        $data['move_contract'] = $move_contract;
        if(@$move_invoice_7){
            $data['move_expenses'] = AdditionalCosts::where('ref_rent_bill_id', $id)->get();
            $data['move_invoice_7'] = $move_invoice_7;
            $data['move_bank'] = Bank::get();
        }
        
        $data['move_invoice_2'] = $move_invoice_2;
        $data['move_invoice_5'] = $move_invoice_5;

        return view('room/move-out', $data);
    }

//// Update รายการทรัพย์สิน
    public function update_asset(Request $request)
    {
        try{
            $r_h_a = RoomHasAsset::find($request->id);
            $r_h_a->status  =  $request->status;
            $r_h_a->condition  =  $request->condition;
            $r_h_a->remark  =  $request->remark;
            if($request->file('image_name')){
                // return 123;
                $file = $request->file('image_name');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/asset/";
                $image_name = $img_name.rand().'.'.$extension;
                $r_h_a->image_name = $image_name;
            }
            
            $r_h_a->save();

            DB::commit();
            
            if(@$file) {
                @unlink("$path/$lastImage");
                $file->move($path, $image_name);
            }
            
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
//// Update รายการทรัพย์สิน ก่อนย้ายออก
    public function asset_upload_image_move_out(Request $request)
    {
        try{
            $r_h_a = RoomHasAsset::find($request->id);
            if($request->file('image_move_out')){
                // return 123;
                $file = $request->file('image_move_out');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/asset/";
                $image_move_out = $img_name.rand().'.'.$extension;
                //////////////
                $r_h_a->image_move_out = $image_move_out;
                //////////////
            }
            
            $r_h_a->save();

            $button = "<button class='btn btn-xs btn-label-info waves-effect text-black px-2'
                    onclick=\"showImage('" . asset('upload/asset/' . $r_h_a->image_move_out) . "')\">
                    <i class='ti ti-photo me-1'></i> ภาพก่อนย้ายออก
                </button>";

            DB::commit();
            
            if(@$file) {
                @unlink("$path/$lastImage");
                $file->move($path, $image_move_out);
            }
            return response()->json([
                'success' => true,
                'message' => 'บันทึกเรียบร้อยแล้ว',
                'button' => $button
            ]);
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    
    // form ชำระค่าประกัน
    public function get_deposit(Request $request)
    {
        $data['page_url'] = 'room';
        $contract = Contract::leftJoin('renters', 'contracts.ref_renter_id', '=', 'renters.id')
                                ->leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                                ->where('contracts.id', $request->contract_id)
                                ->select('contracts.*', 'renters.*', 'room_for_rents.deposit', 'room_for_rents.payment_received_date','contracts.id as contract_id','renters.id as renter_id', DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                ->orderBy('contracts.created_at', 'desc') // หรือใช้ 'id' ตามที่ต้องการ
                                ->first();
                                
        $receipt_reservation = Receipt::where('receipt_number', $contract->receipt_no)->where('ref_type_id', 3)->first(); // ใบเสร็จค่าจองห้อง
        $receipt_security_deposit = Receipt::where('ref_contract_id', $contract->contract_id)->where('ref_type_id', 2)->get();  // ใบเสร็จค่าประกันทั้งหมด
        
        $data['rent_bill'] = RentBill::find($request->rent_bill_id);
        $data['bank'] = Bank::get();
        $data['contract'] = $contract;
        $data['receipt_reservation'] = $receipt_reservation;
        $data['receipt_security_deposit'] = $receipt_security_deposit;
        // if($receipt_reservation){

        // }
        // return $contract->security_deposit;
        if($receipt_security_deposit->sum->amount > 0){
            $data['receipt_amount'] = $contract->security_deposit - $contract->deduction_booking_amount - $receipt_security_deposit->sum->amount;
        }else{
            $data['receipt_amount'] = $contract->security_deposit-$receipt_reservation->amount;
        }
        
        return view('room/room-deposit-form', $data);
    }

    // เปิด form ชำระค่าจอง
    public function get_reservation(Request $request)
    {
        $data['page_url'] = 'room';
        $data['rent_bill'] = RentBill::leftJoin('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->leftJoin('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->where('rent_bills.id', $request->rent_bill_id)
                                ->select('rent_bills.*','rooms.name as room_name','rent_bills.id as rent_bill_id', 'renters.*', 'room_for_rents.ref_room_id', 'room_for_rents.deposit', 'room_for_rents.payment_received_date','rent_bills.id as rent_bill_id','renters.id as renter_id', DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                ->orderBy('rent_bills.created_at', 'desc') // หรือใช้ 'id' ตามที่ต้องการ
                                ->first();
                                
        $data['bank'] = Bank::get();
        
        return view('room/room-reservation-form', $data);
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////
//    room/receipt ชำระ ค่าจอง, ค่าประกัน
    public function insert_receipt(Request $request)
    {
        // return 1;
        // return $request->payment_date2;
        // return 456;
        try{
            
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
                $payment_date = Carbon::createFromFormat('d/m/Y', '24/06/2025')->format('Y-m-d');
            }else{
                $payment_date = Carbon::createFromFormat('d/m/Y', trim($request->payment_date2))->format('Y-m-d');
            }
            $receipt = new Receipt;
            $receipt->receipt_number =  $this->generateReceiptCode();
            $receipt->ref_room_id  =  $request->ref_room_id;
            $receipt->ref_rent_bill_id  =  $request->ref_rent_bill_id;
            $receipt->ref_contract_id  =  $request->ref_contract_id;
            $receipt->ref_renter_id  =  $request->ref_renter_id;
            $receipt->payment_format  =  $request->payment_format; // รูปแบบชำระเงิน 1=เงินสด / 2=โอนเงิน
            $receipt->payment_channel  =  $request->payment_channel;
            $receipt->ref_bank_id  =  $request->ref_bank_id;
            $receipt->transfer_time  =  $request->transfer_time;
            $receipt->payment_date  =  $payment_date;
            $receipt->amount  =  $request->amount;
            $receipt->ref_type_id  =  $request->ref_type_id;
            $receipt->evidence_of_money_transfer  =  $image_name;
            $receipt->ref_user_id =  Auth::id();
            $receipt->save();
            
            foreach($request->payment_list['title'] as $key => $payment_list_title){
                $pay_list = new PaymentList;
                if($request->payment_format == 1 && $request->ref_type_id == 2){
                    if($key == 0){
                        $pay_list->title  =  "ค่าเงินประกันห้อง";
                    }else{
                        $pay_list->title  =  "หักจากค่าจองห้องพัก";
                        $pay_list->discount  =  1;
                    }
                }else{
                    $pay_list->title  =  $payment_list_title;
                    if($key == 1 && @$request->discount){
                        $pay_list->discount  =  1;
                    }
                }
                $pay_list->price  =  $request->payment_list['price'][$key];
                $pay_list->ref_payment_id  =  $receipt->id;
                $pay_list->document_type  =  2;
                $pay_list->save();
            }

            $receipt = Receipt::where('ref_rent_bill_id', $request->ref_rent_bill_id)->get()->pluck('total_amount')->sum();
            $invoice = RentBill::find($request->ref_rent_bill_id)->total_amount;
            if($invoice == $receipt){
                $r_b = RentBill::find($request->ref_rent_bill_id);
                $r_b->ref_status_id =  5; //  5 = ชำระแล้ว
                $r_b->save();
            }
            
            if(@$file) $file->move($path, $image_name);

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    public function move_out_submit(Request $request)
    {
        try{
            $room = Room::find($request->id);
            $room->status = 0;
            $room->save();
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    public function insert_receipt_all(Request $request)
    {
        try{
            foreach($request->insert as $insert){
                $merged = array_merge($insert, $request->insert_single);
                $this->insert_receipt(new Request($merged));
            }
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    public function get_room_rental_contract($id)
    {
        $data['room'] = Room::find($id);
        $renter = Renter::find($id);
        $meter = Meter::where('ref_room_id', $id)->orderBy('created_at','DESC')->first();
        $data['renter'] = $renter;
        $data['meter'] = $meter;
        $province = Province::find($renter->ref_province_id)->name_in_thai;
        $district = District::find($renter->ref_district_id)->name_in_thai;
        $subdistrict = Subdistrict::find($renter->ref_subdistrict_id);
        $data['address'] = $renter->addess.' '.$subdistrict->name_in_thai.' '.$district.' '.$province.' '.$subdistrict->zip_code;
        $contract_room_has = Contract::where('ref_renter_id', $id)->groupBy('ref_room_id')->get('ref_room_id')->toArray();
        $data['room_for_rent'] = RoomForRents::where('ref_renter_id', $id)->get();
        // $data['room_for_rent'] = RoomForRents::leftJoin('room', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
        //                                         ->where('ref_renter_id', $id)
        //                                         // ->whereNotIn('ref_room_id', $contract_room_has)
        //                                         ->get();

        return view('room/room-rental-contract', $data);
    }
    //// ชำระค่าจองหลายห้อง
    public function get_room_rental_reservation($id)
    {
        $data['page_url'] = 'room';
        // $reservation_room_has = Contract::where('ref_renter_id', $id)->groupBy('ref_room_id')->get('ref_room_id')->toArray();
        $data['rent_bill_s'] = RentBill::leftJoin('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                        ->leftJoin('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                        ->leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                        ->where('renters.id', $id)
                                        ->where('rent_bills.ref_status_id', 7)
                                        ->where('rent_bills.ref_type_id', 3)
                                        ->select('rent_bills.*','rooms.name as room_name','room_for_rents.ref_room_id', 
                                                'room_for_rents.deposit','room_for_rents.ref_renter_id', 'room_for_rents.payment_received_date',
                                                DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                        ->orderBy('rent_bills.created_at', 'desc')
                                        ->get();
                                
        $data['bank'] = Bank::get();
        
        return view('room/room-rental-reservation', $data);
    }
    // form สัญญา
    public function get_room_form_contract($id)
    {
        $data['room'] = Room::find($id);
        // $renter = Renter::where('ref_room_id', $id)->first();
        $meter = Meter::where('ref_room_id', $id)->orderBy('created_at','DESC')->first();
        // $data['renter'] = $renter;
        $data['meter'] = $meter;
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['subdistrict'] = Subdistrict::get();

        $contract = Renter::leftJoin('contracts', 'renters.id', '=', 'contracts.ref_renter_id')
                                ->leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                                ->where('room_for_rents.ref_room_id', $id)
                                ->select('contracts.*', 'renters.*', 'room_for_rents.deposit', 'room_for_rents.payment_received_date','contracts.id as contract_id','renters.id as renter_id', DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                ->orderBy('contracts.created_at', 'desc') // หรือใช้ 'id' ตามที่ต้องการ
                                ->first();
        
        $data['receipt'] = Receipt::where('ref_room_id', $id)->where('ref_type_id', 3)->orderBy('id','DESC')->first();

        $province = Province::find($contract->ref_province_id)->name_in_thai;
        $district = District::find($contract->ref_district_id)->name_in_thai;
        $subdistrict = Subdistrict::find($contract->ref_subdistrict_id);
        $data['address'] = $contract->addess.' '.$subdistrict->name_in_thai.' '.$district.' '.$province.' '.$subdistrict->zip_code;
        $data['contract'] = $contract;
        
        $data['service'] = Service::get();
        $data['discount'] = Discount::get();

        $data['room_has_service'] = RoomHasService::where('ref_room_id', $id)->pluck('ref_service_id')->toArray();
        $data['room_has_discount'] = RoomHasDiscount::where('ref_room_id', $id)->pluck('ref_discount_id')->toArray();

        return view('room/room-form-contract', $data);
    }
    // รายละเอียด สัญญา
    public function get_room_detail_contract($id)
    {
        // return 1234;
        $data['room'] = Room::find($id);
        // $renter = Renter::where('ref_room_id', $id)->first();
        $meter = Meter::where('ref_room_id', $id)->orderBy('created_at','DESC')->first();
        // $data['renter'] = $renter;
        $data['meter'] = $meter;
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['subdistrict'] = Subdistrict::get();
        $contract = Contract::leftJoin('renters', 'contracts.ref_renter_id', '=', 'renters.id')
                                ->where('contracts.ref_room_id', $id)
                                ->select('contracts.*','contracts.id as contract_id', 'renters.*', 'renters.id as renter_id', DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                ->orderBy('contracts.created_at', 'desc') // หรือใช้ 'id' ตามที่ต้องการ
                                ->first();
        $province = Province::find($contract->ref_province_id)->name_in_thai;
        $district = District::find($contract->ref_district_id)->name_in_thai;
        $subdistrict = Subdistrict::find($contract->ref_subdistrict_id);
        $data['contract_date_to'] = Carbon::createFromFormat('Y-m-d', $contract->contract_date)->addMonths($contract->period)->format('d/m/Y'); // แสดงผลแบบ 20/06/2025
        $receipt_first = Receipt::where('ref_contract_id', $contract->contract_id)->first();
        $receipt = Receipt::where('ref_contract_id', $contract->contract_id)->get();
        
        $receipt = Receipt::where('ref_room_id', $id)
                            ->where('ref_type_id', 2)
                            ->where('ref_contract_id', $contract->contract_id)
                            ->orderBy('id',"DESC")
                            ->get(); // ใบเสร็จ
        
        $rent_bill = RentBill::where('ref_type_id', 2)->where('ref_contract_id', $contract->contract_id)->first();;


        $data['address'] = $contract->addess.' '.$subdistrict->name_in_thai.' '.$district.' '.$province.' '.$subdistrict->zip_code;
        $data['contract'] = $contract;
        $data['receipt'] = $receipt;
        $data['rent_bill'] = $rent_bill;
        $data['service'] = Service::get();
        $data['discount'] = Discount::get();

        $data['room_has_service'] = RoomHasService::where('ref_room_id', $id)->pluck('ref_service_id')->toArray();
        $data['room_has_discount'] = RoomHasDiscount::where('ref_room_id', $id)->pluck('ref_discount_id')->toArray();

        $data['days'] = [
            'Sunday'    => 'อาทิตย์',
            'Monday'    => 'จันทร์',
            'Tuesday'   => 'อังคาร',
            'Wednesday' => 'พุธ',
            'Thursday'  => 'พฤหัสบดี',
            'Friday'    => 'ศุกร์',
            'Saturday'  => 'เสาร์',
        ];
        
        return view('room/room-detail-contract', $data);
    }
    public function get_bill($id, $month)
    {
        $data['page_url'] = 'bill';
        
        $invoice = RentBill::leftJoin('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                            ->leftJoin('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->where('rooms.id', $id)
                            ->whereNotIn('rent_bills.ref_status_id', [ 2 , 5 ])
                            ->whereYear('rent_bills.year', explode('-', $month)[0])
                            ->whereMonth('rent_bills.month', explode('-', $month)[1])  // พฤษภาคม
                            ->get(); // ใบเรียกเก็บเงิน กรณียังไม่ชำระ หรือ ชำระไม่หมด

        $receipt = Receipt::where('ref_room_id', $id)
                            ->whereYear('created_at', explode('-', $month)[0])
                            ->whereMonth('created_at', explode('-', $month)[1])  // พฤษภาคม
                            ->orderBy('id',"DESC")
                            ->get(); // ใบเสร็จ
                            
        $data['days'] = [
            'Sunday'    => 'อาทิตย์',
            'Monday'    => 'จันทร์',
            'Tuesday'   => 'อังคาร',
            'Wednesday' => 'พุธ',
            'Thursday'  => 'พฤหัสบดี',
            'Friday'    => 'ศุกร์',
            'Saturday'  => 'เสาร์',
        ];

        // $data['expenses'] = AdditionalCosts::where('ref_rent_bill_id', $id)->get();
        $data['invoice'] = $invoice;
        $data['receipt'] = $receipt;
        $data['bill_month'] = Carbon::createFromFormat('Y-m', $month)->locale('th')->isoFormat('MMMM/YYYY');

        return view('room/room-detail-bill', $data);
    }
    public function datatable(Request $request)
    {
        // Subquery: เอา room_for_rents ล่าสุดต่อห้อง
        $latestRoomForRent = DB::table('room_for_rents as r1')
            ->select('r1.*')
            ->whereRaw('r1.updated_at = (
                SELECT MAX(r2.updated_at)
                FROM room_for_rents r2
                WHERE r2.ref_room_id = r1.ref_room_id
            )');

        $results = Room::orderBy('rooms.ref_floor_id','ASC')
            ->orderBy('rooms.name', 'ASC')
            ->whereHas('floor.building', function ($query) {
                $query->where('ref_branch_id', session("branch_id"));
            })
            ->leftJoinSub($latestRoomForRent, 'room_for_rents', function ($join) {
                $join->on('rooms.id', '=', 'room_for_rents.ref_room_id');
            })
            ->leftJoin('contracts', 'rooms.id', '=', 'contracts.ref_room_id')
            ->leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
            ->leftJoin('rent_bills', function ($join) {
                $join->on('room_for_rents.id', '=', 'rent_bills.ref_room_for_rent_id')
                    ->orderBy('rent_bills.created_at', 'desc')
                    ->where('rent_bills.ref_type_id', 3);
            })
            ->leftJoin('receipts', 'rent_bills.id', '=', 'receipts.ref_rent_bill_id')
            ->groupBy('rooms.id')
            ->select(
                'rooms.id',
                DB::raw('MAX(rooms.name) as room_name'),
                DB::raw('MAX(rooms.status) as status'),
                DB::raw('MAX(renters.prefix) as renter_prefix'),
                DB::raw('MAX(CONCAT(renters.name, " ", COALESCE(renters.surname, ""))) as renter_name'),
                DB::raw('MAX(rent_bills.ref_status_id) as rent_bill_status'),
                DB::raw('MAX(rent_bills.id) as rent_bill_id'),
                DB::raw('MAX(receipts.id) as receipt_id'),
                DB::raw('
                    CASE 
                        WHEN MAX(rent_bills.ref_status_id) = 7 THEN "ค้างชำระ"
                        WHEN MAX(rooms.status) = 0 THEN "ห้องว่าง"
                        WHEN MAX(rooms.status) = 1 THEN "ห้องจอง"
                        WHEN MAX(rooms.status) = 2 THEN "มีผู้พักอาศัย"
                    END as status_name
                ')
            );

        // ฟิลเตอร์เพิ่มเติม
        if (@$request->search) {
            $results = $results->Where(function ($query) use ($request) {
                $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', COALESCE(renters.surname, '')) LIKE ?", ["%{$request->search}%"])
                    ->orWhere('rooms.name', 'LIKE', '%'.$request->search.'%');
            });
        }

        if ($request->building != "all" && @$request->building) {
            $results->whereHas('floor', function ($query) use ($request) {
                $query->where('ref_building_id', $request->building);
            });
            // $results->where('room_for_rents.ref_building_id', $request->building);
        }
        if ($request->floor != "all") {
            $results->where('rooms.ref_floor_id', $request->floor);
        }

        // paginate
        $limit = $request->limit ?? 15;

        $results = $results->paginate($limit);

        $status_room = StatusRoom::select('name', 'color')->get()->toArray();

        $status_room = array_column($status_room, 'color', 'name');

        // return $results->items();
        // dd($results);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;
        $data['status_room'] = $status_room;

        $data['list_data'] = $results;

        return view('room/table', $data);
    }
    public function change_room($old_room_id, $new_room_id)
    {
        try{
            // return $old_room_id.' '.$new_room_id;
            $rfr = RoomForRents::where('ref_room_id', $old_room_id)->latest()->first();
            RoomForRents::where('ref_room_id', $old_room_id)->orderBy('updated_at','DESC')->update([
                'ref_room_id' => $new_room_id
            ]);
            if($rfr){
                
                $contract = Contract::where('ref_room_id', $old_room_id)->where('ref_renter_id', $rfr->ref_renter_id)->first();
                
                Contract::where('ref_room_id', $old_room_id)->where('ref_renter_id', $rfr->ref_renter_id)->update([
                    'ref_room_id' => $new_room_id
                ]);
 
                Receipt::where('ref_room_id', $old_room_id)->where('ref_renter_id', $rfr->ref_renter_id)->update([
                    'ref_room_id' => $new_room_id
                ]);
            }

            $status = Room::find(($old_room_id))->status;

            $o_room = Room::find(($old_room_id));
            $o_room->status  =  0;
            $o_room->save();

            $n_room = Room::find($new_room_id);
            $n_room->status  =  $status;
            $n_room->save();
        
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    public function room_summary()
    {
        return $this->summary(session("branch_id"));

    }
    public function get_districts($id)
    {
        return $district = District::where('province_id', $id)->get();
    }
    public function get_subdistricts($id)
    {
        return Subdistrict::where('district_id', $id)->get();
    }
    public function get_zipcode($id)
    {
        return Subdistrict::find($id)->zip_code;
    }
    public function get_floors($id)
    {
        if($id == "all"){
            return Floor::get();
        }
        return Floor::where('ref_building_id', $id)->get();
    }
    public function selected(Request $request)
    {
        $data['structure'] = $request;
        // $structure = [
        //     "buildings" => [
        //         1 => [2 => [12, 13, 14]],
        //         2 => [4 => [17, 133]],
        //     ]
        // ];

        // ดึงข้อมูลชื่อจาก DB ทีละชุด
        if(@$request['buildings']){
            $data['buildings'] = Building::whereIn('id', array_keys($request['buildings']))->pluck('name', 'id');
            $data['floors'] = Floor::pluck('name', 'id');
            $data['rooms'] = Room::pluck('name', 'id');
        }

        // ส่งไปยัง View
        return view('room/selected', $data);
        
        // return view('room/selected', $data);
    }
/////////////////////////////////////////////////////// ทำสัญญา
    public function insert_contract(Request $request) /// ทำสัญญา
    {
    // return $request;
        // return response()->json([
        //     'success' => true,
        //     'message' => 'บันทึกเรียบร้อยแล้ว',
        //     'rent_bill_id' => 65,
        //     'contract_id' => 76,
        // ]);
        try{
            $contract_date = Carbon::createFromFormat('d/m/Y', $request->contract_date)->format('Y-m-d');
        // return $request->contract;
            foreach($request->contract as $row){
            // return $row;
                $room = Room::find($row['ref_room_id']); //save อยู่ข้างล่าง

                $deduction_booking_date = Carbon::createFromFormat('d/m/Y', $row['deduction_booking_date'])->format('Y-m-d');
                
                $contract = new Contract;

                $contract->ref_renter_id  =  $request->ref_renter_id;
                // $contract->homeland  =  $request->homeland;
                $contract->phone  =  $request->phone;
                $contract->id_card_number  =  $request->id_card_number; 
                $contract->address  =  $request->address;
                $contract->contract_date  =  $contract_date;
                $contract->period  =  $request->period;
                $contract->remark  =  $request->remark;

                $contract->ref_room_id  =  $row['ref_room_id'];
                $contract->security_deposit  =  $row['security_deposit'];
                $contract->deduction_booking_amount  =  $row['deduction_booking_amount'];
                $contract->deduction_booking_date  =  $deduction_booking_date;
                $contract->receipt_no  =  $row['receipt_no'];
                $contract->water_meter_start_living  =  @$row['water_meter_start_living'];
                $contract->electricity_meter_start_living  =  @$row['electricity_meter_start_living'];
                $contract->save();

                // $electricity_unit = $this->find_meter_by_name($room->name);

                $r_f_r = RoomForRents::where('ref_room_id', $row['ref_room_id'])->first();

                $r_b_room = new RentBill;  // สร้างบิลค่าเช่าห้อง สำหรับ Test
                $r_b_room->ref_room_for_rent_id  =  $r_f_r->id;
                $r_b_room->month  =  date('m')-1;
                $r_b_room->year  =  date('Y');
                $r_b_room->electricity_unit  =  456;
                $r_b_room->electricity_amount  =  105;
                $r_b_room->water_unit  =  15;
                $r_b_room->water_amount  =  360;
                $r_b_room->invoice_number =  $this->generateInvoiceCode();
                $r_b_room->ref_contract_id =  $contract->id;
                $r_b_room->ref_status_id =  3; // 3 = ไม่สมบูรณ์ / ค้างชำระ
                $r_b_room->ref_type_id =  1; // 1 = ค่าเช่าห้อง
                $r_b_room->ref_user_id =  Auth::id();
                $r_b_room->save();

                $r_b = new RentBill; // สร้างบิลค่าประกันห้อง
                $r_b->ref_room_for_rent_id  =  $r_f_r->id;
                $r_b->month  =  date('m')-1;
                $r_b->year  =  date('Y');
                $r_b->electricity_unit  =  0;
                $r_b->electricity_amount  =  0;
                $r_b->water_unit  =  0;
                $r_b->water_amount  =  0;
                $r_b->invoice_number  =  $this->generateInvoiceCode();
                $r_b->ref_contract_id =  $contract->id;
                $r_b->ref_status_id =  7; // 7 = ค้างชำระ
                $r_b->ref_type_id =  2; // 2 = ค่าประกันห้อง
                $r_b->ref_user_id =  Auth::id();
                $r_b->save();
                
                $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                $pay_list->title  =  "ค่าประกันห้อง";
                $pay_list->price  =  $row['security_deposit'];
                $pay_list->ref_payment_id  =  $r_b->id;
                $pay_list->document_type  =  1;
                $pay_list->save();
                
                $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                $pay_list->title  =  "หักจากค่าจองห้องพัก";
                $pay_list->price  =  $row['deduction_booking_amount'];
                $pay_list->ref_payment_id  =  $r_b->id;
                $pay_list->document_type  =  1;
                $pay_list->discount  =  1;
                $pay_list->save();

                $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                $pay_list->title  =  "ค่าเช่าห้อง (Room rate) $room->name เดือน ".(date('m')-1)."/".date('Y');
                $pay_list->price  =  $room->rent;
                $pay_list->ref_payment_id  =  $r_b_room->id;
                $pay_list->document_type  =  1;
                $pay_list->save();
                

                $pay_list = new PaymentList; // สร้างรายการ ค่าน้ำ
                $pay_list->title  =  "ค่าน้ำ (Water rate) เดือน 4/2025 ( 0 - ";  // เดือน 5/2025
                $pay_list->unit  =  15;
                $pay_list->price  =  360;
                $pay_list->ref_payment_id  =  $r_b_room->id;
                $pay_list->document_type  =  1;
                $pay_list->save();

                $pay_list = new PaymentList; // สร้างรายการ ค่าไฟ
                $pay_list->title  =  "ค่าไฟฟ้า (Electrical rate) เดือน 4/2025 ( 358-456 = 98 ยูนิต)";
                $pay_list->unit  =  456;
                $pay_list->price  =  105;
                $pay_list->ref_payment_id  =  $r_b_room->id;
                $pay_list->document_type  =  1;
                $pay_list->save();
                
                RoomHasService::where('ref_room_id', $row['ref_room_id'])->delete(); // ลบค่าบริการห้อง เพื่อ สร้างใหม่
                if(@$request->ref_service_id){
                    foreach($request->ref_service_id as $ser){ // for เพื่อสร้าง ค่าบริการห้องใหม่
                        
                        $insert = new RoomHasService;
                        $insert->ref_room_id  =  $row['ref_room_id'];
                        $insert->ref_service_id  =  $ser;
                        $insert->price  =  $request->service_price[$ser];
                        $insert->save();

                        $payment_list_title = Service::find($ser)->name;
                        $pay_list = new PaymentList;
                        $pay_list->title  =  $payment_list_title;
                        $pay_list->price  =  $request->service_price[$ser];
                        $pay_list->ref_payment_id  =  $r_b_room->id;
                        $pay_list->document_type  =  1;
                        $pay_list->save();
                    }
                }
                RoomHasDiscount::where('ref_room_id', $row['ref_room_id'])->delete(); // ลบส่วนลดห้อง เพื่อ สร้างใหม่
                if(@$request->ref_discount_id){
                    foreach($request->ref_discount_id as $dis){ // for เพื่อสร้าง ส่วนลดห้อง ใหม่

                        $insert = new RoomHasDiscount;
                        $insert->ref_room_id  =  $row['ref_room_id'];
                        $insert->ref_discount_id  =  $dis;
                        $insert->price  =  $request->discount_price[$dis];
                        $insert->save();

                        $payment_list_title = Discount::find($dis)->name;
                        $pay_list = new PaymentList;
                        $pay_list->title  =  $payment_list_title;
                        $pay_list->price  =  $request->discount_price[$dis];
                        $pay_list->ref_payment_id  =  $r_b_room->id;
                        $pay_list->document_type  =  1; // 1 = ใบแจ้งหนี้ หรือ ใบเรียกเก็บเงิน
                        $pay_list->discount  =  1; // 1 = ส่วนลด
                        $pay_list->save();

                    }
                }
                
                $update_r_1 = RentBill::find($r_b_room->id);
                $update_r_1->total = $update_r_1->total_amount;
                $update_r_1->save();

                $update_r_2 = RentBill::find($r_b->id);
                $update_r_2->total = $update_r_2->total_amount;
                $update_r_2->save();
                // return 333;

                $room->status = 2;
                $room->save();
                
            }

            
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'บันทึกเรียบร้อยแล้ว',
                'rent_bill_id' => $r_b->id,
                'contract_id' => $contract->id,
            ]);
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }


////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function update_contract(Request $request, $id)
    {
        try{
            $contract_date = Carbon::createFromFormat('d/m/Y', $request->contract_date)->format('Y-m-d');
        // return $request->contract;
            foreach($request->contract as $row){
            // return $row;

                $renter = Renter::find($request->ref_renter_id);
                // $renter->prefix  =  $request->prefix;
                $renter->name  =  explode(' ', $request->name)[0];
                $renter->surname  =  @explode(' ', $request->name)[1];
                $renter->phone  =  $request->phone;
                $renter->id_card_number  =  $request->id_card_number;
                $renter->address  =  $request->address;
                $renter->save();
            
                $update = Contract::find($id);

                $update->ref_renter_id  =  $request->ref_renter_id;
                // $update->homeland  =  $request->homeland;
                $update->phone  =  $request->phone;
                $update->id_card_number  =  $request->id_card_number; 
                // $update->address  =  $request->address;
                $update->contract_date  =  $contract_date;
                $update->period  =  $request->period;
                $update->remark  =  $request->remark;

                $update->ref_room_id  =  $row['ref_room_id'];
                $update->water_meter_start_living  =  $row['water_meter_start_living'];
                $update->electricity_meter_start_living  =  $row['electricity_meter_start_living'];
                $update->save();
                
            }

            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    public function find_meter_by_name($room_name)
    {
        $ip_meter = Branch::find(session("branch_id"))->ip_meter;

        $response = Http::get('http://' . $ip_meter . ':7953/getRealTimeData.aspx');
        $xmlString = $response->body();
        $xmlObject = simplexml_load_string($xmlString);
        $json = json_encode($xmlObject);
        $array = json_decode($json, true);

        $meters = $array['Meters']['Meter'];

        // ห่อด้วย collection
        $collection = collect(array_keys($meters) !== range(0, count($meters) - 1) ? [$meters] : $meters);


        // ใช้ firstWhere หา GroupName ที่ตรงกับชื่อห้อง
        $data = $collection->firstWhere('@attributes.GroupName', $room_name);
        
        $electricity_unit = 0;
        if ($data) {
            $electricity_unit = $data['Value'][0];
        }
        return $electricity_unit;
    }
    public function insert_renter(Request $request)
    {
        return true; 
        $booking_date = Carbon::createFromFormat('d/m/Y', $request->booking_date)->format('Y-m-d');
        $date_stay = Carbon::createFromFormat('d/m/Y', $request->date_stay)->format('Y-m-d');
        $payment_received_date = Carbon::createFromFormat('d/m/Y', $request->date_stay)->format('Y-m-d');
        // return $request;
        try{
            
            // return $this->generateInvoiceCode();
            $renter = new Renter;
            $renter->prefix  =  $request->prefix;
            $renter->name  =  $request->name;
            $renter->surname  =  $request->surname;
            $renter->phone  =  $request->phone;
            $renter->id_card_number  =  $request->id_card_number;
            $renter->address  =  $request->address;
            $renter->ref_subdistrict_id  =  $request->ref_subdistrict_id;
            $renter->ref_district_id  =  $request->ref_district_id;
            $renter->ref_province_id  =  $request->ref_province_id;
            $renter->zipcode  =  $request->zipcode;
            $renter->booking_date  =  $booking_date;
            $renter->booking_channel  =  $request->booking_channel;
            $renter->save();

            $r_t_r = new RoomForRents;
            $r_t_r->date_stay  =  $date_stay;
            $r_t_r->ref_room_id  =  $room;
            $r_t_r->ref_floor_id  =  $key_2;
            $r_t_r->ref_building_id  =  $key;
            $r_t_r->ref_branch_id  =  session("branch_id");
            $r_t_r->ref_renter_id  =  $renter->id;
            $r_t_r->ref_user_id  =  Auth::id();
            $r_t_r->deposit  =  $request->deposit;
            $r_t_r->payment_method  =  $request->payment_method;
            $r_t_r->payment_received_date  =  $payment_received_date;
            $r_t_r->save();

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    public function store(Request $request)
    {
        $booking_date = Carbon::createFromFormat('d/m/Y', $request->booking_date)->format('Y-m-d');
        $date_stay = Carbon::createFromFormat('d/m/Y', $request->date_stay)->format('Y-m-d');
        $payment_received_date = Carbon::createFromFormat('d/m/Y', $request->date_stay)->format('Y-m-d');
        // return $request;
        try{
            
            // return $this->generateInvoiceCode();
            $renter = new Renter;
            $renter->prefix  =  $request->prefix;
            $renter->name  =  $request->name;
            $renter->surname  =  $request->surname;
            $renter->phone  =  $request->phone;
            $renter->id_card_number  =  $request->id_card_number;
            $renter->address  =  $request->address;
            $renter->ref_subdistrict_id  =  $request->ref_subdistrict_id;
            $renter->ref_district_id  =  $request->ref_district_id;
            $renter->ref_province_id  =  $request->ref_province_id;
            $renter->zipcode  =  $request->zipcode;
            $renter->booking_date  =  $booking_date;
            $renter->booking_channel  =  $request->booking_channel;
            $renter->save();
            
            if($request->select_channel == 1){
                $room_names = explode(',', preg_replace('/\s+/', '', $request->room_text));
                $room_all = Room::whereHas('floor.building', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })
                                ->where('status', 0)
                                ->whereIn('name', $room_names)
                                ->get();

                // เช็คห้องที่ไม่ว่าง ถ้ามีให้ error ว่า ห้องเหล่านี้ไม่ว่าง เริ่ม {
                    $vacant_room_all = Room::whereHas('floor.building', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })
                                ->where('status', '!=', 0)
                                ->whereIn('name', $room_names)
                                ->pluck('name') // ดึงเฉพาะคอลัมน์ name
                                ->toArray();    // แปลงเป็น array

                    if (!empty($vacant_room_all)) {
                        return response()->json([
                            'status' => false,
                            'message' => 'ไม่สามารถจองห้องเหล่านี้ได้ <br>' . implode(', ', $vacant_room_all)
                        ]);
                    }
                    
                    $renter_blacklist = Renter::where('name', $request->name)->where('surname', $request->surname)->where('blacklist_status', 1)->first();
                    if (!empty($renter_blacklist)) {
                        return response()->json([
                            'status' => false,
                            'message' => 'บุคคลนี้ไม่สามารถ จอง ได้ เนื่องจากถูกขึ้นบัญชีดำ <br>' . implode(', ', $vacant_room_all)
                        ]);
                    }
                    
                // เช็คห้องที่ไม่ว่าง ถ้ามีให้ error ว่า ห้องเหล่านี้ไม่ว่าง จบ }
                
                
                foreach($room_all as $r_n){
                    
                            $r_f_r = new RoomForRents;
                            $r_f_r->date_stay  =  $date_stay;
                            $r_f_r->ref_room_id  =  $r_n->id;
                            $r_f_r->ref_floor_id  =  $r_n->ref_floor_id;
                            $r_f_r->ref_building_id  =  $r_n->floor->ref_building_id;
                            $r_f_r->ref_branch_id  =  session("branch_id");
                            $r_f_r->ref_renter_id  =  $renter->id;
                            $r_f_r->ref_user_id  =  Auth::id();
                            $r_f_r->deposit  =  $request->deposit;
                            $r_f_r->payment_method  =  $request->payment_method;
                            $r_f_r->payment_received_date  =  $payment_received_date;
                            $r_f_r->save();
                            
                            $update_room = Room::find($r_n->id);
                            $update_room->status  =  1;
                            $update_room->save();

                            $r_b = new RentBill;
                            $r_b->ref_room_for_rent_id  =  $r_f_r->id;
                            $r_b->month  =  date('m')-1;
                            $r_b->year  =  date('Y');
                            $r_b->electricity_unit  =  0;
                            $r_b->electricity_amount  =  0;
                            $r_b->water_unit  =  0;
                            $r_b->water_amount  =  0;
                            $r_b->total  =  $request->deposit;
                            $r_b->invoice_number  =  $this->generateInvoiceCode();
                            $r_b->ref_status_id =  7; //  3 = ไม่สมบูรณ์
                            $r_b->ref_type_id =  3;  //  3 ค่าจอง
                            $r_b->ref_user_id =  Auth::id();
                            $r_b->save();

                            // $receipt = new Receipt;
                            // $receipt->receipt_number =  $this->generateReceiptCode();
                            // $receipt->ref_room_id  =  $r_n->id;
                            // $receipt->ref_rent_bill_id  =  1; // รอ
                            // // $receipt->ref_contract_id  =  $request->ref_contract_id;
                            // $receipt->ref_renter_id  =  $renter->id;
                            // $receipt->payment_format  =  1;
                            // $receipt->payment_channel  =  $request->payment_method;
                            // $receipt->payment_date  =  $payment_received_date;
                            // $receipt->amount  =  $request->deposit;
                            // $receipt->save();
                                
                            $payment_list = new PaymentList;
                            $payment_list->title  =  'เงินประกันห้อง';
                            $payment_list->price  =  $request->deposit;
                            $payment_list->ref_payment_id  =  $r_b->id;
                            $payment_list->document_type  =  1;     //  1 = rent_bill
                            $payment_list->save();
                }
            }else{
                foreach($request->buildings as $key => $building){
                    foreach($building as $key_2 => $floor){
                        foreach($floor as $room){

                            $r_f_r = new RoomForRents;
                            $r_f_r->date_stay  =  $date_stay;
                            $r_f_r->ref_room_id  =  $room;
                            $r_f_r->ref_floor_id  =  $key_2;
                            $r_f_r->ref_building_id  =  $key;
                            $r_f_r->ref_branch_id  =  session("branch_id");
                            $r_f_r->ref_renter_id  =  $renter->id;
                            $r_f_r->ref_user_id  =  Auth::id();
                            $r_f_r->deposit  =  $request->deposit;
                            $r_f_r->payment_method  =  $request->payment_method;
                            $r_f_r->payment_received_date  =  $payment_received_date;
                            $r_f_r->save();
                            
                            $update_room = Room::find($room);
                            $update_room->status  =  1;
                            $update_room->save();

                            $r_b = new RentBill;
                            $r_b->ref_room_for_rent_id  =  $r_f_r->id;
                            $r_b->month  =  date('m')-1;
                            $r_b->year  =  date('Y');
                            $r_b->electricity_unit  =  0;
                            $r_b->electricity_amount  =  0;
                            $r_b->water_unit  =  0;
                            $r_b->water_amount  =  0;
                            $r_b->total  =  $request->deposit;
                            $r_b->invoice_number  =  $this->generateInvoiceCode();
                            $r_b->ref_status_id =  7; //  3 = ไม่สมบูรณ์
                            $r_b->ref_type_id =  3;  //  3 ค่าจอง
                            $r_b->ref_user_id =  Auth::id();
                            $r_b->save();

                            // $receipt = new Receipt;
                            // $receipt->receipt_number =  $this->generateReceiptCode();
                            // $receipt->ref_room_id  =  $room;
                            // $receipt->ref_rent_bill_id  =  1; // รอ
                            // // $receipt->ref_contract_id  =  $request->ref_contract_id;
                            // $receipt->ref_renter_id  =  $renter->id;
                            // $receipt->payment_format  =  1;
                            // $receipt->payment_channel  =  $request->payment_method;
                            // $receipt->payment_date  =  $payment_received_date;
                            // $receipt->amount  =  $request->deposit;
                            // $receipt->save();
                                
                            $payment_list = new PaymentList;
                            $payment_list->title  =  'เงินประกันห้อง';
                            $payment_list->price  =  $request->deposit;
                            $payment_list->ref_payment_id  =  $r_b->id;
                            $payment_list->document_type  =  1;     //  1 = rent_bill
                            $payment_list->save();
                        }
                    }
                }
            }

            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    public function generateInvoiceCode()
    {
        // Get the current year and month
        $year = Carbon::now()->year; // 2024
        $month = Carbon::now()->month-1; // 10
        
        // Format year and month
        $yearMonth = $year . str_pad($month, 2, '0', STR_PAD_LEFT); // 202410
        
        // Find the latest invoice in the same year and month
        $latestInvoice = RentBill::where('year', $year)
                                ->where('month', $month)
                                ->latest('id')
                                ->first();

        // Calculate the new invoice number (sequence)
        $sequence = $latestInvoice ? substr($latestInvoice->invoice_number, -6) + 1 : 1;
        $sequenceCode = str_pad($sequence, 6, '0', STR_PAD_LEFT); // 000001

        // Generate the invoice code
        $invoiceCode = 'INV' . $yearMonth . $sequenceCode;

        return $invoiceCode;
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
        $latestRoomForRent = DB::table('room_for_rents as r1')
                                ->select('r1.*')
                                ->whereRaw('r1.updated_at = (
                                    SELECT MAX(r2.updated_at)
                                    FROM room_for_rents r2
                                    WHERE r2.ref_room_id = r1.ref_room_id
                                )');

        $results = Room::orderBy('rooms.ref_floor_id','ASC')
                            ->orderBy('rooms.name', 'ASC')
                            ->whereHas('floor.building', function ($query) {
                                $query->where('ref_branch_id', session("branch_id"));
                            })
                            ->leftJoinSub($latestRoomForRent, 'room_for_rents', function ($join) {
                                $join->on('rooms.id', '=', 'room_for_rents.ref_room_id');
                            })
                            ->leftJoin('contracts', 'rooms.id', '=', 'contracts.ref_room_id')
                            ->leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                            ->leftJoin('rent_bills', function ($join) {
                                $join->on('room_for_rents.id', '=', 'rent_bills.ref_room_for_rent_id')
                                    ->orderBy('rent_bills.created_at', 'desc')
                                    ->where('rent_bills.ref_type_id', 3);
                            })
                            ->leftJoin('receipts', 'rent_bills.id', '=', 'receipts.ref_rent_bill_id')
                            ->groupBy('rooms.id')
                            ->select(
                                'rooms.id',
                                DB::raw('MAX(rooms.name) as room_name'),
                                DB::raw('MAX(rooms.status) as status'),
                                DB::raw('MAX(renters.prefix) as renter_prefix'),
                                DB::raw('MAX(CONCAT(renters.name, " ", COALESCE(renters.surname, ""))) as renter_name'),
                                DB::raw('MAX(rent_bills.ref_status_id) as rent_bill_status'),
                                DB::raw('MAX(rent_bills.id) as rent_bill_id'),
                                DB::raw('MAX(receipts.id) as receipt_id'),
                                DB::raw('
                                    CASE 
                                        WHEN MAX(rent_bills.ref_status_id) != 5 AND MAX(receipts.id) IS NULL THEN "ค้างชำระ"
                                        WHEN MAX(rooms.status) = 0 THEN "ห้องว่าง"
                                        WHEN MAX(rooms.status) = 1 THEN "ห้องจอง"
                                        WHEN MAX(rooms.status) = 2 THEN "มีผู้พักอาศัย"
                                    END as status_name
                                ')
                            )->get();
        $data = 
        [
            [
                "ห้อง",
                "ผู้เช่า",
                "สถานะ"
            ]
        ];
        // return $data;
        foreach($results as $row){
            $name = '-';
            if ($row->status_name != "ห้องว่าง"){
                $name = $row->prefix.' '.$row->renter_name;
            }
            if ($row->status == 1 && $row->status_name == "ค้างชำระ"){
                $status = "ห้องจอง(ค้างชำระ)";
            }else{
                $status = $row->status_name;
            }

            $data[] = [
                        $row->room_name,
                        $name,
                        $status,
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
