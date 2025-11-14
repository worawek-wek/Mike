<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\IncomeExpenses;
use App\Models\User;
use App\Models\MoveOut;
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
use App\Models\Vehicle;
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
    public function index(Request $request, $branch_id = null)
    {
        
        if(!is_null($branch_id)){
            session(["branch_id" => $branch_id]);
            return redirect('room');
        }
        // $rentbill = RentBill::where('ref_type_id', 2)->get();
        // foreach($rentbill as $bill){
        //     $insert = new RentBill;
        //     $insert->ref_room_for_rent_id  = $bill->ref_room_for_rent_id;
        //     $insert->month  = $bill->month;
        //     $insert->year  = $bill->year;
        //     $insert->electricity_unit  = $bill->electricity_unit;
        //     $insert->electricity_amount  = $bill->electricity_amount;
        //     $insert->water_unit  = $bill->water_unit;
        //     $insert->water_amount  = $bill->water_amount;
        //     $insert->invoice_number  = $bill->invoice_number;
        //     $insert->ref_room_id = $bill->ref_room_id;
        //     $insert->ref_contract_id = $bill->ref_contract_id;
        //     $insert->ref_status_id = 5;
        //     $insert->ref_type_id = 6;
        //     $insert->ref_user_id = $bill->ref_user_id;
        //     $insert->save();
        //     foreach($bill->payment_not_discount as $pay){

        //         $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
        //         $pay_list->title  =  $pay->title;
        //         $pay_list->price  =  $pay->price;
        //         $pay_list->ref_payment_id  =  $insert->id;
        //         $pay_list->document_type  =  $pay->document_type;
        //         $pay_list->save();
                
        //     }
        // }

        ///////////////////////////////////
        ///////////////////////////////////
        ///////////////////////////////////

        // $rentbill = RentBill::where('ref_type_id', 6)->get();
        // foreach($rentbill as $bill){
        //     $insert = new RentBill;
        //     $insert->ref_room_for_rent_id = $bill->ref_room_for_rent_id;
        //     $insert->month = $bill->month;
        //     $insert->year = $bill->year;
        //     $insert->electricity_unit = $bill->electricity_unit;
        //     $insert->electricity_amount = $bill->electricity_amount;
        //     $insert->water_unit = $bill->water_unit;
        //     $insert->water_amount = $bill->water_amount;
        //     $insert->invoice_number = $this->generateInvoiceCode();
        //     $insert->ref_room_id = $bill->ref_room_id;
        //     $insert->ref_contract_id = $bill->ref_contract_id;
        //     $insert->ref_status_id = 5;
        //     $insert->ref_type_id = 7;
        //     $insert->ref_user_id = $bill->ref_user_id;
        //     $insert->save();

        //     foreach($bill->payment_list as $pay){
        //         $pay_list = new PaymentList; // สร้างรายการ รายการคืน/หักเงินประกัน 
        //         $pay_list->title  =  $pay->title;
        //         $pay_list->price  =  $pay->price;
        //         $pay_list->ref_payment_id  =  $insert->id;
        //         $pay_list->document_type  =  1;
        //         $pay_list->save();
        //     }

        //     $bill_receipt_move_out = RentBill::where('ref_type_id', 4)->where('ref_status_id', 3)->where('ref_contract_id', $bill->ref_contract_id)->first(); // ใบเสร็จย้ายออก ชำระโดย หักจากเงินประกัน
        //     if ($bill_receipt_move_out) {
        //         foreach($bill_receipt_move_out->payment_list as $brmopl){

        //             $pay_list = new PaymentList; // สร้างรายการ รายการคืน/หักเงินประกัน 
        //             $pay_list->title  =  $brmopl->title;
        //             $pay_list->price  =  $brmopl->price;
        //             $pay_list->ref_payment_id  =  $insert->id;
        //             $pay_list->document_type  =  1;
        //             $pay_list->discount  =  !$brmopl->discount;
        //             $pay_list->save();
        //         }
        //     }
        //     // }
        // }
        
        ///////////////////////////////////
        ///////////////////////////////////
        ///////////////////////////////////
        
            DB::commit();

        // $r_f_r = RoomForRents::get();
        // foreach($r_f_r as $r){
        //     $room = Renter::find($r->ref_renter_id);
        //     $room->ref_branch_id = $r->ref_branch_id;
        //     $room->save();
        // }
        // DB::commit();

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

        $data['renter'] = Renter::whereHas('room_for_rent', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })
                                // ->whereHas('room_for_rent.rent_bills', function ($query) {
                                //                     $query->where('ref_type_id', 3)
                                //                             ->where('ref_status_id', '!=', 5);
                                //                 })
                                ->whereHas('room_for_rent.room', function ($query) {
                                    $query->where('status', 2);
                                })->get();
                                        
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['subdistrict'] = Subdistrict::get();
        $data['buildings'] = Building::where('ref_branch_id', session("branch_id"))->get();
        $data['floors'] = Floor::whereHas('building', function ($query) {
                                        $query->where('ref_branch_id', session("branch_id"));
                                    })->get();
        $data['service'] = Service::where('ref_branch_id', session("branch_id"))->get();
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
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
    public function datatable(Request $request)
    {
        // Subquery: เอา room_for_rents ล่าสุดต่อห้อง
        $latestRoomForRent = DB::table('room_for_rents as r1')
            ->select('r1.*')
            ->whereRaw('r1.updated_at = (
                SELECT MIN(r2.updated_at)
                FROM room_for_rents r2
                WHERE r2.ref_room_id = r1.ref_room_id
                AND r2.status = 1
            )');

        $results = Room::orderBy('rooms.name', 'ASC')
                        ->whereHas('floor.building', function ($query) {
                            $query->where('ref_branch_id', session("branch_id"));
                        })
                        ->leftJoinSub($latestRoomForRent, 'room_for_rents', function ($join) {
                            $join->on('rooms.id', '=', 'room_for_rents.ref_room_id');
                                    // ->where('room_for_rents.status', 1);
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
                            DB::raw('MAX(receipts.ref_status_id) as receipt_status_id'),
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
        // $results = $results->paginate($limit);

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
    public function reserve_form(Request $request, $id = null)
    {
        // return Auth::id();
        
        $data['room_id'] = $id;
        $data['room'] = Room::find($id);
        $data['room_name'] = $request->room_name;
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['subdistrict'] = Subdistrict::get();
        $data['buildings'] = Building::where('ref_branch_id', session("branch_id"))->get();
        $data['all_rooms'] = Room::whereHas('floor.building', function ($query) {
                                        $query->where('ref_branch_id', session("branch_id"));
                                    })->get();
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        $data['floors'] = Floor::get();
        $data['asset'] = Asset::with('room_has_asset.room')->get();
        
        $data['renter'] = Renter::whereHas('room_for_rent', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })
                                ->whereHas('room_for_rent.rent_bills', function ($query) {
                                                    $query->where('ref_type_id', 3)
                                                            ->where('ref_status_id', '!=', 5);
                                                })
                                ->whereHas('room_for_rent.room', function ($query) {
                                    $query->where('status', 1);
                                })->get();

        return view('room/room-reserve-form', $data);
    }
    
    public function reserve_data(Request $request)
    {
        // return Auth::id();
        $data['room_id'] = $request->room_id;
        $data['room_name'] = $request->room_name;
        $data['room'] = Room::find($request->room_id);

        $receipt_jong = Receipt::where('ref_room_id', $request->room_id)
                                ->where('ref_type_id', 3)
                                ->orderBy('id',"DESC")
                                ->first(); // ใบเสร็จ

        $data['receipt_jong'] = $receipt_jong;
        
        $data['days'] = [
            'Sunday'    => 'อาทิตย์',
            'Monday'    => 'จันทร์',
            'Tuesday'   => 'อังคาร',
            'Wednesday' => 'พุธ',
            'Thursday'  => 'พฤหัสบดี',
            'Friday'    => 'ศุกร์',
            'Saturday'  => 'เสาร์',
        ];

        return view('room/room-reserve-data', $data);
    }

    public function get_check_in($room_id)
    {
        // return Auth::id();
        $data['page_url'] = 'room';

        $room = Room::find($room_id);
        $data['check_in'] = "1";
        $data['room'] = $room;
        $data['service'] = Service::where('ref_branch_id', session("branch_id"))->get();
        $data['discount'] = Discount::where('ref_branch_id', session("branch_id"))->get();
        $data['room_has_service'] = RoomHasService::where('ref_room_id', $room_id)->pluck('ref_service_id')->toArray();
        $data['room_has_discount'] = RoomHasDiscount::where('ref_room_id', $room_id)->pluck('ref_discount_id')->toArray();
        $meter = Meter::where('ref_room_id', $room_id)->orderBy('created_at','DESC')->first();
        $data['meter'] = $meter;
        
        return view('room/room-check-in-form', $data);
    }
    
    // form ทำสัญญาหลายห้อง
    public function room_rental_contract_form(Request $request)
    {
        // return Auth::id();
       
        $data['renter_contract'] = RoomForRents::whereHas('rent_bills', function ($query) {
                                                    $query->where('ref_type_id', 3)
                                                            ->where('ref_status_id', 5);
                                                })
                                                ->whereHas('room', function ($query) {
                                                    $query->where('status', 1);
                                                })
                                                ->where('ref_branch_id', session("branch_id"))
                                                ->with('renter')
                                                ->select('ref_renter_id') // เลือกเฉพาะ ref_room_id
                                                ->distinct('ref_renter_id')
                                                ->get();
        
        return view('room/room-all-form-contract', $data);
    }
    

    public function reserve_form_check_user(Request $request){
        $keyword = $request->input('keyword');
        // $room = Room::where('name', $keyword)->first();
        $room = Room::orderBy('rooms.ref_floor_id','ASC')
            ->whereHas('floor.building', function ($query) {
                $query->where('ref_branch_id', session("branch_id"));
            })
            ->where('rooms.name',$keyword)
            ->where('rooms.status',0)
            ->first();
        return response()->json([
            'found' => $room ? true : false
        ]);
    }
    // view
    public function show($id)
    {
        $data['page_url'] = 'room';

        $room = Room::find($id);
        if($room->status == 2){
            $contract = Contract::where('ref_room_id', $id)->orderBy('id','DESC')->first();
            $data['contract'] = $contract;
        }
        
        $room_for_rent = RoomForRents::leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                                    ->where('room_for_rents.status', 1)
                                                    ->where('room_for_rents.ref_room_id', $id)
                                                    ->select('room_for_rents.*','room_for_rents.id as room_for_rent_id', 'renters.*', 'renters.id as renter_id', DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                                    ->orderBy('room_for_rents.created_at', 'desc') // หรือใช้ 'id' ตามที่ต้องการ
                                                    ->first();
        $data['room_for_rent'] = $room_for_rent;
        $data['renter'] = Renter::orderBy('room_for_rents.id','asc')
                                    ->leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                                    ->where('room_for_rents.ref_room_id', $id)
                                    ->where('room_for_rents.status', 1)
                                    ->select('renters.*', DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                    ->get();

        $data['bill_month'] = RentBill::oldest()->first();
        $data['month_year_bill'] = Receipt::orderBy('id','desc')
                                            ->where('ref_room_id', $id)
                                            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year')
                                            ->groupByRaw('MONTH(created_at), YEAR(created_at)')
                                            ->get();
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
            "0","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];
        $data['month_thai'] = $month_thai;
        $data['receipt'] = Receipt::where('ref_room_id', $id)->where('ref_type_id', 3)->orderBy('id','DESC')->first();
        $data['room'] = $room;
        $data['otherRooms'] = Room::whereHas('floor.building', function ($query) {
                                        $query->where('ref_branch_id', session("branch_id"));
                                    })->where('status', 0)->whereNot('id', $id)->get();
        
        $data['service'] = Service::where('ref_branch_id', session("branch_id"))->get();
        $data['discount'] = Discount::where('ref_branch_id', session("branch_id"))->get();
        
        $meter = Meter::where('ref_room_id', $id)->orderBy('created_at','DESC')->first();
        $data['meter'] = $meter;
        $data['room_has_service'] = RoomHasService::where('ref_room_id', $id)->pluck('ref_service_id')->toArray();
        $data['room_has_discount'] = RoomHasDiscount::where('ref_room_id', $id)->pluck('ref_discount_id')->toArray();
        $province = Province::find(@$room_for_rent->ref_province_id)->name_in_thai ?? '';
        $district = District::find(@$room_for_rent->ref_district_id)->name_in_thai ?? '';
        $subdistrict = Subdistrict::find(@$room_for_rent->ref_subdistrict_id);
        $data['asset'] = Asset::with(['room_has_asset' => function ($query) use ($id) { // ดึงข้อมูล รายการทรัพย์สิน
                                        $query->where('ref_room_id', $id); // with โดยแค่อันที่ห้องนี้มี
                                    }])->whereIn('id',[1,2])->get();
        $data['asset_has_room'] = RoomHasAsset::whereIn('ref_room_id', (array) $id)
                                                ->pluck('status', 'ref_asset_id')
                                                ->toArray();
        $data['address'] = $room_for_rent->addess.' '.@$subdistrict->name_in_thai.' '.@$district.' '.@$province.' '.@$subdistrict->zip_code;
        // return $room_for_rent->room_for_rent_id;
        $move_invoice_7 = RentBill::where('ref_status_id', 7)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_invoice_2 = RentBill::where('ref_type_id', 2)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_invoice_type_4 = RentBill::where('ref_type_id', 4)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_invoice_5 = RentBill::where('ref_type_id', 1)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_contract = Contract::where('ref_room_id', $id)->orderBy('id','desc')->first();
        $data['move_contract'] = $move_contract;
        if(@$move_invoice_7){
            $data['move_expenses'] = AdditionalCosts::where('ref_rent_bill_id', $id)->get();
            $data['move_invoice_7'] = $move_invoice_7;
        }
        
            $data['move_bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        $data['move_invoice_2'] = $move_invoice_2;
        $data['move_invoice_5'] = $move_invoice_5;
        $data['move_invoice_type_4'] = $move_invoice_type_4;
        
        return view('room/view', $data);
    }
//// เพิ่มผู้เช่า
    public function get_form_add_renter($room_id, $renter_id = null)
    {
        $data['page_url'] = 'room';
        if(@$renter_id){
            // return $renter_id;
            $renter = Renter::find($renter_id);
            $data['renter_edit'] = $renter;
        }
        $room = Room::find($room_id);
        $province = Province::get();
        $district = District::get();
        $subdistrict = Subdistrict::get();

        $data['room'] = $room;
        $data['province'] = $province;
        $data['district'] = $district;
        $data['subdistrict'] = $subdistrict;

        return view('room/add-renter', $data);
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
    public function get_invoice_move_out($contract_id){
        $move_invoice_type_7 = RentBill::where('ref_contract_id', $contract_id)->where('ref_type_id', 7)->first(); // invoice ย้ายออก
        // return $move_invoice_type_7->total_amount;
        // return $move_invoice_type_7->payment_list;
    }
//// แท็บ -ย้ายออก
    public function get_move_out($id)
    {
        $room = Room::find($id);
            // $insert = new RentBill;
            // $insert->ref_room_for_rent_id = $room->room_for_rent_main->id;
            // $insert->month = date('m');
            // $insert->year = date('Y');
            // $insert->electricity_unit = 0;
            // $insert->electricity_amount = 0;
            // $insert->water_unit = 0;
            // $insert->water_amount = 0;
            // $insert->invoice_number = $this->generateInvoiceCode();
            // $insert->ref_room_id = $bill->ref_room_id;
            // $insert->ref_contract_id = $bill->ref_contract_id;
            // $insert->ref_status_id = 5;
            // $insert->ref_type_id = 7;
            // $insert->ref_user_id = $bill->ref_user_id;
            // $insert->save();

            // foreach($bill->payment_list as $pay){
            //     $pay_list = new PaymentList; // สร้างรายการ รายการคืน/หักเงินประกัน 
            //     $pay_list->title  =  $pay->title;
            //     $pay_list->price  =  $pay->price;
            //     $pay_list->ref_payment_id  =  $insert->id;
            //     $pay_list->document_type  =  1;
            //     $pay_list->save();
            // }
        $data['room'] = $room;
        if(in_array($room->status, [0,1])){
            return '<div class="text-center mx-4 text-muted">
                        <i class="ti ti-file-x" style="font-size: 60px;"></i>
                        <h5 class="mt-2">ไม่พบข้อมูล</h5>
                    </div>';
        }
        if($room->status == 2){
            $contract = Contract::where('ref_room_id', $id)->orderBy('id','DESC')->first();
            $data['contract'] = $contract;
        }

        $move_invoice_type_7 = RentBill::where('ref_contract_id', $contract->id)->where('ref_type_id', 7)->first(); // invoice ย้ายออก
        // $bill_receipt_move_out = Receipt::where('ref_type_id', 4)->where('payment_channel', 3)->where('ref_contract_id', $contract->id)->first(); // ใบเสร็จย้ายออก ชำระโดย หักจากเงินประกัน

        // if ($bill_receipt_move_out) {
        //     foreach($bill_receipt_move_out->payment_list as $brmopl){

        //         $pay_list = new PaymentList; // สร้างรายการ รายการคืน/หักเงินประกัน 
        //         $pay_list->title  =  $brmopl->title;
        //         $pay_list->price  =  $brmopl->price;
        //         $pay_list->ref_payment_id  =  $move_invoice_type_7->id;
        //         $pay_list->document_type  =  1;
        //         $pay_list->discount  =  !$brmopl->discount;
        //         $pay_list->save();
        //     }
        // }
        // DB::commit();

        $room_for_rent = RoomForRents::leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                                    ->where('room_for_rents.ref_room_id', $id)
                                                    ->select('room_for_rents.*','room_for_rents.id as room_for_rent_id', 'renters.*', 'renters.id as renter_id', DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                                    ->orderBy('room_for_rents.created_at', 'desc') // หรือใช้ 'id' ตามที่ต้องการ
                                                    ->first();

        $data['receipt_1'] = Receipt::where('ref_contract_id', $contract->id)->where('ref_type_id', 1)->orderBy('id','DESC')->latest()->first();
        // $invoice = RentBill::where('ref_type_id', 4)->where('ref_room_id', $id)->first(); // บิลย้ายออก
        // if($invoice->receipt_move_out){
        //     $amount_move = 
        // }

        $data['renter'] = Renter::leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                                    ->where('room_for_rents.ref_room_id', $id)
                                    ->select('renters.*')
                                    ->orderBy('room_for_rents.id',"DESC")
                                    ->get();

        $data['asset'] = Asset::with(['room_has_asset' => function ($query) use ($id) { // ดึงข้อมูล รายการทรัพย์สิน
                                        $query->where('ref_room_id', $id); // with โดยแค่อันที่ห้องนี้มี
                                    }])->whereIn('id',[1,2])->get();

        $move_invoice_7 = RentBill::where('ref_status_id', 7)->where('ref_type_id', 1)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first(); // บิลค่าเช่า ที่ค้างชำระ
        $move_invoice_6 = RentBill::where('ref_type_id', 6)->where('ref_contract_id', $contract->id)->latest()->first(); // เงินประกัน
        
        if(!$move_invoice_type_7){

                $rentbill = RentBill::where('ref_contract_id', $contract->id)->where('ref_type_id', 2)->first();
                $insert = new RentBill;
                $insert->ref_room_for_rent_id  = $rentbill->ref_room_for_rent_id;
                $insert->month  = $rentbill->month;
                $insert->year  = $rentbill->year;
                $insert->electricity_unit  = $rentbill->electricity_unit;
                $insert->electricity_amount  = $rentbill->electricity_amount;
                $insert->water_unit  = $rentbill->water_unit;
                $insert->water_amount  = $rentbill->water_amount;
                $insert->invoice_number  = $rentbill->invoice_number;
                $insert->ref_room_id = $rentbill->ref_room_id;
                $insert->ref_contract_id = $rentbill->ref_contract_id;
                $insert->ref_status_id = 5;
                $insert->ref_type_id = 7;
                $insert->ref_user_id = $rentbill->ref_user_id;
                $insert->save();
            
            $move_invoice_type_7 = RentBill::where('ref_contract_id', $contract->id)->where('ref_type_id', 7)->first(); // invoice ย้ายออก

        }

        if(!$move_invoice_6){

            $rentbill = RentBill::where('ref_contract_id', $contract->id)->where('ref_type_id', 2)->first();
                $insert = new RentBill;
                $insert->ref_room_for_rent_id  = $rentbill->ref_room_for_rent_id;
                $insert->month  = $rentbill->month;
                $insert->year  = $rentbill->year;
                $insert->electricity_unit  = $rentbill->electricity_unit;
                $insert->electricity_amount  = $rentbill->electricity_amount;
                $insert->water_unit  = $rentbill->water_unit;
                $insert->water_amount  = $rentbill->water_amount;
                $insert->invoice_number  = $rentbill->invoice_number;
                $insert->ref_room_id = $rentbill->ref_room_id;
                $insert->ref_contract_id = $rentbill->ref_contract_id;
                $insert->ref_status_id = 5;
                $insert->ref_type_id = 6;
                $insert->ref_user_id = $rentbill->ref_user_id;
                $insert->save();
                foreach($rentbill->payment_not_discount as $pay){

                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->title  =  $pay->title;
                    $pay_list->price  =  $pay->price;
                    $pay_list->ref_payment_id  =  $insert->id;
                    $pay_list->document_type  =  $pay->document_type;
                    $pay_list->save();
                    
                }
            
            $move_invoice_6 = RentBill::where('ref_type_id', 6)->where('ref_contract_id', $contract->id)->latest()->first(); // เงินประกัน

        }

        $receipt_move_out_deducted = Receipt::where('ref_contract_id', $contract->id)->where('payment_channel', 3)->where('ref_type_id', 4)->latest()->first(); // ใบเสร็จย้ายออก ชำระ หักจากเงิน
        // return 
        // return $receipt_move_out_deducted->total_amount;
        $cal = $move_invoice_6->total_amount;
        if(@$receipt_move_out_deducted){
            $cal = $cal-$receipt_move_out_deducted->total_amount??0;
        }
        // return 123;

        $data['cal'] = $cal;

        $move_invoice_type_4 = RentBill::where('ref_type_id', 4)->where('ref_room_id', $id)->first(); // ใบเสร็จย้ายออก
        $move_invoice_5 = RentBill::where('ref_type_id', 1)->where('ref_room_for_rent_id', $room_for_rent->room_for_rent_id)->first();
        $move_contract = Contract::find(@$move_invoice_5->ref_contract_id);
        $data['move_contract'] = $move_contract;
        if(@$move_invoice_7){
            $data['move_expenses'] = AdditionalCosts::where('ref_rent_bill_id', $id)->get();
            $data['move_invoice_7'] = $move_invoice_7;
        }

        $meter = Meter::where('ref_room_id', $id)->orderBy('created_at','DESC')->first();
        // บิลผู้เช่าหนี
        $renter = Renter::leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->where('room_for_rents.ref_room_id', $id)
                            ->where('room_for_rents.status', 1)
                            ->select('renters.*','room_for_rents.id as room_for_rents_id')
                            ->get();

        $renter_ids = $renter->pluck('room_for_rents_id')->toArray();

        $bad_debt_invoice = RentBill::where('ref_type_id', 5)->where('ref_room_id', $id)->whereIn('ref_room_for_rent_id', $renter_ids)->first();
        // บิลผู้เช่าหนี

        $data['bad_debt_invoice'] = $bad_debt_invoice;
        $data['move_bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        $data['meter'] = $meter;
        $data['move_invoice_6'] = $move_invoice_6;
        $data['move_invoice_type_4'] = $move_invoice_type_4;
        $data['move_invoice_5'] = $move_invoice_5;
        $data['room_for_rent'] = $room_for_rent;
        $data['move_invoice_type_7'] = $move_invoice_type_7;

        $data['days'] = [
            'Sunday'    => 'อาทิตย์',
            'Monday'    => 'จันทร์',
            'Tuesday'   => 'อังคาร',
            'Wednesday' => 'พุธ',
            'Thursday'  => 'พฤหัสบดี',
            'Friday'    => 'ศุกร์',
            'Saturday'  => 'เสาร์',
        ];
            DB::commit();

        return [
                    'html' => view('room/move-out', $data)->render(),
                    'invoice_move_out' => $move_invoice_type_4 == null ? 0 : 1
                ];
    }
    // ดึงใบเสร็จย้ายออก
    public function get_move_out_detail_receipt($id)
    {
        // $invoice = RentBill::where('ref_type_id', 4)->where('ref_room_id', $id)->first();
        $contract = Contract::where('ref_room_id', $id)->latest()->first();
        $renter = Renter::leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->where('room_for_rents.ref_room_id', $id)
                            ->where('room_for_rents.status', 1)
                            ->select('renters.*','room_for_rents.id as room_for_rents_id')
                            ->get();

        $renter_ids = $renter->pluck('room_for_rents_id')->toArray();

        $invoice = RentBill::where('ref_type_id', 4)->where('ref_room_id', $id)->where('ref_contract_id', $contract->id)->first();
        
        if(!$invoice){
            return $this->get_move_out_form_receipt($id);
        }
        $data['invoice'] = $invoice;
        $data['contract'] = $contract;
        $data['receipt'] = $invoice->receipt_move_out ?? null;
        $data['amount_receipt_payment_chanel_deposit'] = 1000;
        // if($invoice->receipt_move_out){
        //     $invoice->receipt_move_out->total_amount 
        // }
        $data['move_bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();

        $data['days'] = [
            'Sunday'    => 'อาทิตย์',
            'Monday'    => 'จันทร์',
            'Tuesday'   => 'อังคาร',
            'Wednesday' => 'พุธ',
            'Thursday'  => 'พฤหัสบดี',
            'Friday'    => 'ศุกร์',
            'Saturday'  => 'เสาร์',
        ];

        return view('room/move-out-detail-receipt', $data);
    }
    public function get_move_out_form_receipt($id)
    {
        $data['room'] = Room::find($id);
        $contract = Contract::where('ref_room_id', $id)->latest()->first();
        $renter = Renter::leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                                    ->where('room_for_rents.ref_room_id', $id)
                                    ->where('room_for_rents.status', 1)
                                    ->select('renters.*','room_for_rents.id as room_for_rents_id')
                                    ->orderBy('room_for_rents.id',"DESC")
                                    ->get();
        $renter_ids = $renter->pluck('room_for_rents_id')->toArray();

        $invoice = RentBill::where('ref_type_id', 4)->where('ref_room_id', $id)->where('ref_contract_id', $contract->id)->first();
        $data['renter'] = $renter;
        $data['contract'] = $contract;
        $data['invoice'] = $invoice;

        return view('room/move-out-form-receipt', $data);
    }

    // ใบเสร็จย้ายออก
    public function move_out_detail_bad_debt_bill($id)
    {
        // $invoice = RentBill::where('ref_type_id', 4)->where('ref_room_id', $id)->first();
        
        $renter = Renter::leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->where('room_for_rents.ref_room_id', $id)
                            ->where('room_for_rents.status', 1)
                            ->select('renters.*','room_for_rents.id as room_for_rents_id')
                            ->get();

        $renter_ids = $renter->pluck('room_for_rents_id')->toArray();

        $invoice = RentBill::where('ref_type_id', 5)->where('ref_room_id', $id)->whereIn('ref_room_for_rent_id', $renter_ids)->first(); // บิลหนี้สูญ
        if(!$invoice){
            return $this->move_out_form_bad_debt_bill($id);
        }
        $invoice_rent_room = RentBill::where('ref_type_id', 1)->where('ref_status_id', 7)->where('ref_room_id', $id)->whereIn('ref_room_for_rent_id', $renter_ids)->first();
        
        if(@$invoice_rent_room){
            $pml = PaymentList::where('ref_payment_id', $invoice->id)->where('document_type', 1)->where('bad_debt_rent_status', 1)->first();
            if(!@$pml){
                
                $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                $pay_list->title  =  "ค่าเช่าห้อง ".$invoice->room->name." เดือน $invoice_rent_room->month/$invoice_rent_room->year";
                $pay_list->price  =  $invoice_rent_room->total_amount;
                $pay_list->ref_payment_id  =  $invoice->id;
                $pay_list->document_type  =  1;
                $pay_list->bad_debt_rent_status  =  1; // 1 = รายการที่เป็นค่าเช่าค้างชำระ
                $pay_list->save();

                DB::commit();
                
            }
        }

        $data['invoice'] = $invoice;
        $data['receipt'] = $invoice->receipt_move_out ?? null;
        $data['amount_receipt_payment_chanel_deposit'] = 1000;
        // if($invoice->receipt_move_out){
        //     $invoice->receipt_move_out->total_amount 
        // }
        $data['move_bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();

        $data['days'] = [
            'Sunday'    => 'อาทิตย์',
            'Monday'    => 'จันทร์',
            'Tuesday'   => 'อังคาร',
            'Wednesday' => 'พุธ',
            'Thursday'  => 'พฤหัสบดี',
            'Friday'    => 'ศุกร์',
            'Saturday'  => 'เสาร์',
        ];

        return view('room/move-out-detail-bad-debt-bill', $data);
    }
    public function move_out_form_bad_debt_bill($id)
    {
        $room = Room::find($id);
        $data['room'] = $room;
        $renter = Renter::leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                                    ->where('room_for_rents.ref_room_id', $id)
                                    ->where('room_for_rents.status', 1)
                                    ->select('renters.*','room_for_rents.id as room_for_rents_id')
                                    ->orderBy('room_for_rents.id',"DESC")
                                    ->get();
        $renter_ids = $renter->pluck('room_for_rents_id')->toArray();
        
        $invoice = RentBill::where('ref_type_id', 5)->where('ref_room_id', $id)->whereIn('ref_room_for_rent_id', $renter_ids)->first();
        $invoice_rent_room = RentBill::where('ref_type_id', 1)->where('ref_status_id', 7)->where('ref_room_id', $id)->whereIn('ref_room_for_rent_id', $renter_ids)->first();
        
        $data['renter'] = $renter;
        $data['invoice'] = $invoice;
        $data['invoice_rent_room'] = $invoice_rent_room;

        return view('room/move-out-form-bad-debt-bill', $data);
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
                    $request->validate([
                        'image_name' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    ],[
                        'image_name.required' => 'กรุณาเลือกรูปภาพ',
                        'image_name.image' => 'ไฟล์ที่เลือกต้องเป็นรูปภาพเท่านั้น',
                        'image_name.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท: jpeg, png, jpg, gif หรือ webp',
                        'image_name.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
                    ]);
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
                    $request->validate([
                        'image_move_out' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    ],[
                        'image_move_out.required' => 'กรุณาเลือกรูปภาพ',
                        'image_move_out.image' => 'ไฟล์ที่เลือกต้องเป็นรูปภาพเท่านั้น',
                        'image_move_out.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท: jpeg, png, jpg, gif หรือ webp',
                        'image_move_out.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
                    ]);
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
                                
        // return $receipt_reservation = Receipt::where('receipt_number', $contract->receipt_no)->where('ref_type_id', 3)->first(); // ใบเสร็จค่าจองห้อง
        $receipt_security_deposit = Receipt::where('ref_contract_id', $contract->contract_id)->where('ref_type_id', 2)->get();  // ใบเสร็จค่าประกันทั้งหมด
        
        $data['rent_bill'] = RentBill::find($request->rent_bill_id);
        // return $data['rent_bill']->payment_list;
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        $data['contract'] = $contract;
        // $data['receipt_reservation'] = $receipt_reservation;
        $data['receipt_security_deposit'] = $receipt_security_deposit;
        // if($receipt_reservation){

        // }
        // return $contract->security_deposit;
        if($receipt_security_deposit->sum->amount > 0){
            $data['receipt_amount'] = $contract->security_deposit - $contract->deduction_booking_amount - $receipt_security_deposit->sum->amount;
        }else{
            $data['receipt_amount'] = $contract->security_deposit - $contract->deduction_booking_amount;
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
                                
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        
        return view('room/room-reservation-form', $data);
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
                                                'room_for_rents.deposit','room_for_rents.ref_renter_id', 'room_for_rents.payment_received_date','renters.id_card_number', 'renters.phone',
                                                DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
                                        ->orderBy('rooms.name')
                                        ->get();
                                
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        
        return view('room/room-rental-reservation', $data);
    }
//// ดึงห้อง ย้ายออกหลายห้อง
    public function get_room_move_out($id)
    {

        $data['page_url'] = 'room';
        $room = Room::whereHas('room_for_rent_s', function ($query) use ($id) {
                    $query->where('ref_renter_id', $id);
                })
                ->where('status', 2)
                ->get();
        foreach($room as $row){
            
            $move_invoice_type_7 = RentBill::where('ref_contract_id', $row->contract->id)->where('ref_type_id', 7)->first(); // invoice ย้ายออก
            
            $move_invoice_6 = RentBill::with('payment_list')->where('ref_type_id', 6)->where('ref_contract_id', $row->contract->id)->latest()->first(); // เงินประกัน
            
            if(!$move_invoice_type_7){

                    $rentbill = RentBill::where('ref_contract_id', $row->contract->id)->where('ref_type_id', 2)->first();
                    $insert = new RentBill;
                    $insert->ref_room_for_rent_id  = $rentbill->ref_room_for_rent_id;
                    $insert->month  = $rentbill->month;
                    $insert->year  = $rentbill->year;
                    $insert->electricity_unit  = $rentbill->electricity_unit;
                    $insert->electricity_amount  = $rentbill->electricity_amount;
                    $insert->water_unit  = $rentbill->water_unit;
                    $insert->water_amount  = $rentbill->water_amount;
                    $insert->invoice_number  = $rentbill->invoice_number;
                    $insert->ref_room_id = $rentbill->ref_room_id;
                    $insert->ref_contract_id = $rentbill->ref_contract_id;
                    $insert->ref_status_id = 5;
                    $insert->ref_type_id = 7;
                    $insert->ref_user_id = $rentbill->ref_user_id;
                    $insert->save();
                
                $move_invoice_type_7 = RentBill::where('ref_contract_id', $row->contract->id)->where('ref_type_id', 7)->first(); // invoice ย้ายออก

            }

            if(!$move_invoice_6){

                $rentbill = RentBill::where('ref_contract_id', $row->contract->id)->where('ref_type_id', 2)->first();
                    $insert = new RentBill;
                    $insert->ref_room_for_rent_id  = $rentbill->ref_room_for_rent_id;
                    $insert->month  = $rentbill->month;
                    $insert->year  = $rentbill->year;
                    $insert->electricity_unit  = $rentbill->electricity_unit;
                    $insert->electricity_amount  = $rentbill->electricity_amount;
                    $insert->water_unit  = $rentbill->water_unit;
                    $insert->water_amount  = $rentbill->water_amount;
                    $insert->invoice_number  = $rentbill->invoice_number;
                    $insert->ref_room_id = $rentbill->ref_room_id;
                    $insert->ref_contract_id = $rentbill->ref_contract_id;
                    $insert->ref_status_id = 5;
                    $insert->ref_type_id = 6;
                    $insert->ref_user_id = $rentbill->ref_user_id;
                    $insert->save();
                    foreach($rentbill->payment_not_discount as $pay){

                        $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                        $pay_list->title  =  $pay->title;
                        $pay_list->price  =  $pay->price;
                        $pay_list->ref_payment_id  =  $insert->id;
                        $pay_list->document_type  =  $pay->document_type;
                        $pay_list->save();
                        
                    }
                
                $move_invoice_6 = RentBill::where('ref_type_id', 6)->where('ref_contract_id', $row->contract->id)->latest()->first(); // เงินประกัน

            }
            $move_invoice_4 = RentBill::where('ref_type_id', 4)->where('ref_room_id', $row->id)->where('ref_contract_id', $row->contract->id)->first();

            $row['move_invoice_4'] = $move_invoice_4;
            $row['move_invoice_6'] = $move_invoice_6;
            $row['move_invoice_type_7'] = $move_invoice_type_7;
        }
        DB::commit();
        $data['room'] = $room;
        // $data['move_invoice_type_7'] = $move_invoice_type_7;
        // $data['move_invoice_6'] = $move_invoice_6;
        // // $reservation_room_has = Contract::where('ref_renter_id', $id)->groupBy('ref_room_id')->get('ref_room_id')->toArray();
        // $data['rent_bill_s'] = RentBill::leftJoin('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
        //                                 ->leftJoin('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
        //                                 ->leftJoin('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
        //                                 ->where('renters.id', $id)
        //                                 // ->where('rent_bills.ref_status_id', 7)
        //                                 ->where('rent_bills.ref_type_id', 4)
        //                                 ->select('rent_bills.*','rooms.name as room_name','room_for_rents.ref_room_id', 
        //                                         'room_for_rents.deposit','room_for_rents.ref_renter_id', 'room_for_rents.payment_received_date','renters.id_card_number', 'renters.phone',
        //                                         DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name"))
        //                                 ->orderBy('rooms.name')
        //                                 ->get();
                                
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        
        return view('room/room-move-out', $data);
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
            if($request->payment_channel == 1){
                $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
            }else{
                $payment_date = Carbon::createFromFormat('d/m/Y', trim($request->payment_date))->format('Y-m-d');
                
                if($request->file('evidence_of_money_transfer')){
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
            $receipt->ref_status_id  =  2;
            $receipt->evidence_of_money_transfer  =  $image_name;
            $receipt->ref_user_id =  Auth::id();
            $receipt->save();
            foreach($request->payment_list['title'] as $key => $payment_list_title){
                $pay_list = new PaymentList;
                $pay_list->title  =  $payment_list_title;
                $pay_list->price  =  $request->payment_list['price'][$key];
                $pay_list->discount  =  $request->payment_list['discount'][$key] ?? 0;
                $pay_list->ref_payment_id  =  $receipt->id;
                $pay_list->document_type  =  2;
                $pay_list->save();
            }

            $receipt_total_amount = Receipt::where('ref_rent_bill_id', $request->ref_rent_bill_id)->get()->pluck('total_amount')->sum();
            $invoice_total_amount = RentBill::find($request->ref_rent_bill_id)->total_amount;
            if($invoice_total_amount == $receipt_total_amount){
                $r_b = RentBill::find($request->ref_rent_bill_id);
                $r_b->ref_status_id =  5; //  5 = ชำระแล้ว
                $r_b->save();
            }
            $expenses = new IncomeExpenses;
            $expenses->type  =  1;
            if($request->ref_type_id == 2){
                $expenses->label  =  "ใบเสร็จค่าประกันห้อง";
            }else{
                $expenses->label  =  "ใบเสร็จค่าจองห้อง";
            }
            $expenses->amount  =  0;
            $expenses->date  =  Carbon::now();
            $expenses->ref_room_id  =  $request->ref_room_id;
            $expenses->ref_category_id  =  0;
            $expenses->name  =  $receipt->renter->fullName();
            $expenses->address  =  $receipt->renter->fullThaiAddress();
            $expenses->id_card_number  =  $receipt->renter->id_card_number;
            $expenses->branch  =  0;
            $expenses->phone  =  $receipt->renter->phone;
            $expenses->remark  =  0;
            $expenses->ref_user_id  =  Auth::id();
            $expenses->ref_receipt_id  =  $receipt->id;
            $expenses->ref_branch_id  =  session("branch_id");
            $expenses->save();

            if(@$file) $file->move($path, $image_name);

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    // บันทึก ย้ายออก
    public function move_out_form_all(Request $request)
    {
        // return $request->ref_renter_id;
        try{
            $room = Room::whereHas('room_for_rent_main', function ($query) use ($request) {
                                                    $query->where('ref_renter_id', $request->ref_renter_id);
                                                })->update([ 'status' => 0 ]);
//             $meter = Meter::where('ref_room_id', $request->room_id)->orderBy('year', 'desc')->orderBy('month', 'desc')->first();	
//             if($meter){
//                 $room->move_out_electricity_meter = $meter->electricity_unit;
//                 $room->move_out_water_meter = $meter->water_unit;
//             }
//             $room->save();
            
//             RoomForRents::where('ref_room_id', $request->room_id)->update(['status' => 0]);
//             $invoice = RentBill::where('ref_room_id', $request->room_id)->where('ref_status_id', 3)->first();
//             if(@$invoice){
//                 RentBill::destroy($invoice->id);
//                 PaymentList::where('ref_payment_id', $invoice->id)->where('document_type', 1)->delete();
//             }
//             if($request->type_move_out == 2){
//                     $up_renter = Renter::find($request->ref_renter_id);
//                     $up_renter->blacklist_detail  =  "ผู้เช่าหนี";
//                     $up_renter->blacklist_status  =  1;
//                     $up_renter->blacklist_date  =  Carbon::now();
//                     $up_renter->save();
//             }
//             RoomHasAsset::where('ref_room_id', $request->room_id)->delete();

// // ใบเสร็จเกี่ยวกับสรุปย้ายออก
//             $invoice_summarize = RentBill::find($request->invoice_id);
//             PaymentList::where('ref_payment_id', $request->invoice_id)->where('document_type', 1)->delete();
//             //////////////////////////////////////////////////////////////////////////////////////////////////////
            
//                 $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
                
//                 $image_name = "";
//                 if($request->file('evidence_of_money_transfer')){
//                     // return 3;
//                         $request->validate([
//                             'evidence_of_money_transfer' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
//                         ],[
//                             'evidence_of_money_transfer.required' => 'กรุณาเลือกรูปภาพ',
//                             'evidence_of_money_transfer.image' => 'ไฟล์ที่เลือกต้องเป็นรูปภาพเท่านั้น',
//                             'evidence_of_money_transfer.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท: jpeg, png, jpg, gif หรือ webp',
//                             'evidence_of_money_transfer.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
//                         ]);
//                     $file = $request->file('evidence_of_money_transfer');
//                     $nameExtension = $file->getClientOriginalName();
//                     $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
//                     $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
//                     $path = "upload/receipt/";
//                     $image_name = $img_name.rand().'.'.$extension;
//                 }

//                 $receipt = new Receipt;
//                 $receipt->receipt_number =  $this->generateReceiptCode();
//                 $receipt->ref_room_id  =  $room->id;
//                 $receipt->ref_rent_bill_id  =  $request->invoice_id;
//                 $receipt->ref_contract_id  =  $invoice_summarize->ref_contract_id;
//                 $receipt->ref_renter_id  =  $request->ref_renter_id;
//                 $receipt->payment_format  =  $request->payment_format;
//                 $receipt->payment_channel  =  $request->receipt_payment_channel; // รูปแบบชำระเงิน 1=เงินสด / 2=โอนเงิน / 3/หักจากเงินประกัน
//                 $receipt->ref_bank_id  =  $request->ref_bank_id;
//                 $receipt->transfer_time  =  $request->transfer_time;
//                 $receipt->payment_date  =  $payment_date;
//                 $receipt->ref_type_id  =  7;
//                 $receipt->ref_status_id  =  5;
//                 $receipt->evidence_of_money_transfer  =  $image_name;
//                 $receipt->ref_user_id =  Auth::id();
//                 $receipt->amount  =  0;
//                 $receipt->save();

//             //////////////////////////////////////////////////////////////////////////////////////////////////////
//             $move_invoice_6 = RentBill::where('ref_type_id', 6)->where('ref_room_id', $room->id)->latest()->first(); // เงินประกัน
//             foreach($move_invoice_6->payment_list as $payment_list){

//                     $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
//                     $pay_list->title  =  $payment_list->title;
//                     $pay_list->price  =  $payment_list->price;
//                     $pay_list->ref_payment_id  =  $request->invoice_id;
//                     $pay_list->document_type  =  1;
//                     $pay_list->save();

//                     $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
//                     $pay_list->title  =  $payment_list->title;
//                     $pay_list->price  =  $payment_list->price;
//                     $pay_list->ref_payment_id  =  $receipt->id;
//                     $pay_list->document_type  =  2;
//                     $pay_list->save();

//             }

//             $receipt_move_out_deducted = Receipt::where('ref_contract_id', $invoice_summarize->ref_contract_id)->where('payment_channel', 3)->where('ref_type_id', 4)->latest()->first();
//             if($receipt_move_out_deducted){
//                 foreach($receipt_move_out_deducted->payment_list as $payment_list){
//                         $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
//                         $pay_list->title  =  $payment_list->title;
//                         $pay_list->price  =  $payment_list->price*-1;
//                         $pay_list->ref_payment_id  =  $request->invoice_id;
//                         $pay_list->document_type  =  1;
//                         $pay_list->save();
                        
//                         $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
//                         $pay_list->title  =  $payment_list->title;
//                         $pay_list->price  =  $payment_list->price*-1;
//                         $pay_list->ref_payment_id  =  $receipt->id;
//                         $pay_list->document_type  =  2;
//                         $pay_list->save();
//                 }
//             }
//             $invoice_summarize->ref_status_id  =  5;
//             $invoice_summarize->save();
            
            // $request->merge([
            //     'payment_channel' => $request->bad_debt_payment_channel,
            // ]);
            // return $request;
            // return $this->payment_receipt_move_out_bill($request);
            // new MoveOut();

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    // บันทึก ย้ายออก
    public function move_out_submit(Request $request)
    {
        // return $request;
        try{
            $room = Room::find($request->room_id);
            $room->status = 0;
            $meter = Meter::where('ref_room_id', $request->room_id)->orderBy('year', 'desc')->orderBy('month', 'desc')->first();	
            if($meter){
                $room->move_out_electricity_meter = $meter->electricity_unit;
                $room->move_out_water_meter = $meter->water_unit;
            }
            $room->save();
            
            RoomForRents::where('ref_room_id', $request->room_id)->update(['status' => 0]);
            $invoice = RentBill::where('ref_room_id', $request->room_id)->where('ref_status_id', 3)->first();
            if(@$invoice){
                RentBill::destroy($invoice->id);
                PaymentList::where('ref_payment_id', $invoice->id)->where('document_type', 1)->delete();
            }
            if($request->type_move_out == 2){
                    $up_renter = Renter::find($request->ref_renter_id);
                    $up_renter->blacklist_detail  =  "ผู้เช่าหนี";
                    $up_renter->blacklist_status  =  1;
                    $up_renter->blacklist_date  =  Carbon::now();
                    $up_renter->save();
            }
            RoomHasAsset::where('ref_room_id', $request->room_id)->delete();

// ใบเสร็จเกี่ยวกับสรุปย้ายออก
            $invoice_summarize = RentBill::find($request->invoice_id);
            PaymentList::where('ref_payment_id', $request->invoice_id)->where('document_type', 1)->delete();
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            
                $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
                
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

                $receipt = new Receipt;
                $receipt->receipt_number =  $this->generateReceiptCode();
                $receipt->ref_room_id  =  $room->id;
                $receipt->ref_rent_bill_id  =  $request->invoice_id;
                $receipt->ref_contract_id  =  $invoice_summarize->ref_contract_id;
                $receipt->ref_renter_id  =  $request->ref_renter_id;
                $receipt->payment_format  =  $request->payment_format;
                $receipt->payment_channel  =  $request->receipt_payment_channel; // รูปแบบชำระเงิน 1=เงินสด / 2=โอนเงิน / 3/หักจากเงินประกัน
                $receipt->ref_bank_id  =  $request->ref_bank_id;
                $receipt->transfer_time  =  $request->transfer_time;
                $receipt->payment_date  =  $payment_date;
                $receipt->ref_type_id  =  7;
                $receipt->ref_status_id  =  5;
                $receipt->evidence_of_money_transfer  =  $image_name;
                $receipt->ref_user_id =  Auth::id();
                $receipt->amount  =  0;
                $receipt->save();

            //////////////////////////////////////////////////////////////////////////////////////////////////////
            $move_invoice_6 = RentBill::where('ref_type_id', 6)->where('ref_room_id', $room->id)->latest()->first(); // เงินประกัน
            foreach($move_invoice_6->payment_list as $payment_list){

                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->title  =  $payment_list->title;
                    $pay_list->price  =  $payment_list->price;
                    $pay_list->ref_payment_id  =  $request->invoice_id;
                    $pay_list->document_type  =  1;
                    $pay_list->save();

                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->title  =  $payment_list->title;
                    $pay_list->price  =  $payment_list->price;
                    $pay_list->ref_payment_id  =  $receipt->id;
                    $pay_list->document_type  =  2;
                    $pay_list->save();

            }

            $receipt_move_out_deducted = Receipt::where('ref_contract_id', $invoice_summarize->ref_contract_id)->where('payment_channel', 3)->where('ref_type_id', 4)->latest()->first();
            if($receipt_move_out_deducted){
                foreach($receipt_move_out_deducted->payment_list as $payment_list){
                        $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                        $pay_list->title  =  $payment_list->title;
                        $pay_list->price  =  $payment_list->price*-1;
                        $pay_list->ref_payment_id  =  $request->invoice_id;
                        $pay_list->document_type  =  1;
                        $pay_list->save();
                        
                        $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                        $pay_list->title  =  $payment_list->title;
                        $pay_list->price  =  $payment_list->price*-1;
                        $pay_list->ref_payment_id  =  $receipt->id;
                        $pay_list->document_type  =  2;
                        $pay_list->save();
                }
            }
            $invoice_summarize->ref_status_id  =  5;
            $invoice_summarize->save();
            
            // $request->merge([
            //     'payment_channel' => $request->bad_debt_payment_channel,
            // ]);
            // return $request;
            // return $this->payment_receipt_move_out_bill($request);
            // new MoveOut();

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    public function save_move_out_receipt(Request $request)
    {
        // return $request;
        try{
            if($request->invoice_id){

                $invoice = RentBill::find($request->invoice_id);
                PaymentList::where('ref_payment_id', $invoice->id)->where('document_type', 1)->delete();

            }else{
                $invoice = new RentBill;
                $invoice->invoice_number =  $this->generateInvoiceCode();
                $invoice->ref_room_id =  $request->ref_room_id;
                $invoice->ref_contract_id =  $request->ref_contract_id;
                $invoice->ref_status_id =  5;
                $invoice->ref_type_id =  4; // 4 = บิลย้ายออก
                $invoice->ref_user_id =  Auth::id();
                $invoice->ref_room_for_rent_id  =  $request->ref_room_for_rent_id;
                $invoice->month  =  date('m');
                $invoice->year  =  date('Y');
            }
                $invoice->name  =  $request->name;
                $invoice->address  =  $request->homeland;
                $invoice->phone  =  $request->phone;
                $invoice->id_card_number  =  $request->id_card_number;
                $invoice->remark  =  $request->remark;
                $invoice->save();

                foreach($request->payment_list['title'] as $key => $title){
                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->title  =  $title;
                    $pay_list->price  =  $request->payment_list['price'][$key];
                    $pay_list->ref_payment_id  =  $invoice->id;
                    $pay_list->document_type  =  1;
                    // return $request->payment_list['discount'][$key];
                    $pay_list->discount  =  $request->payment_list['discount'][$key];
                    $pay_list->save();
                }

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    // บันทึก การแก้ไข รายการ คืนเงินประกัน ย้ายออก
    public function update_deposit_refund(Request $request)
    {
        // return $request;
        try{
            // if($request->invoice_id){

                $invoice = RentBill::find($request->invoice_id);
                PaymentList::where('ref_payment_id', $invoice->id)->where('document_type', 1)->delete();

            // }else{
            //     $invoice = new RentBill;
            //     $invoice->invoice_number =  $this->generateInvoiceCode();
            //     $invoice->ref_room_id =  $request->ref_room_id;
            //     $invoice->ref_contract_id =  $request->ref_contract_id;
            //     $invoice->ref_status_id =  5;
            //     $invoice->ref_type_id =  4; // 4 = บิลย้ายออก
            //     $invoice->ref_user_id =  Auth::id();
            //     $invoice->ref_room_for_rent_id  =  $request->ref_room_for_rent_id;
            //     $invoice->month  =  date('m');
            //     $invoice->year  =  date('Y');
            // }
                // $invoice->name  =  $request->name;
                // $invoice->address  =  $request->homeland;
                // $invoice->phone  =  $request->phone;
                // $invoice->id_card_number  =  $request->id_card_number;
                // $invoice->remark  =  $request->remark;
                // $invoice->save();

                foreach($request->payment_list_p['title'] as $key => $title){
                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->title  =  $title;
                    $pay_list->price  =  $request->payment_list_p['price'][$key];
                    $pay_list->ref_payment_id  =  $invoice->id;
                    $pay_list->document_type  =  1;
                    $pay_list->save();
                }
                $invoice->total  =  $invoice->total_amount;
                $invoice->save();

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    public function save_move_out_bad_debt_bill(Request $request)
    {
        // return $request;
        try{
            if($request->invoice_id){

                $invoice = RentBill::find($request->invoice_id);
                PaymentList::where('ref_payment_id', $invoice->id)->where('document_type', 1)->delete();

            }else{
                $invoice = new RentBill;
                $invoice->invoice_number =  $this->generateInvoiceCode();
                $invoice->ref_room_id =  $request->ref_room_id;
                $invoice->ref_contract_id =  $request->ref_contract_id;
                $invoice->ref_status_id =  5;
                $invoice->ref_type_id =  5; // 5 = บิลหนี้สูญ
                $invoice->ref_user_id =  Auth::id();
                $invoice->ref_room_for_rent_id  =  $request->ref_room_for_rent_id;
                $invoice->month  =  date('m');
                $invoice->year  =  date('Y');
            }
                $invoice->name  =  $request->name;
                $invoice->address  =  $request->homeland;
                $invoice->phone  =  $request->phone;
                $invoice->id_card_number  =  $request->id_card_number;
                $invoice->remark  =  $request->remark;
                $invoice->save();

                foreach($request->payment_list['title'] as $key => $title){
                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->title  =  $title;
                    $pay_list->price  =  $request->payment_list['price'][$key];
                    $pay_list->ref_payment_id  =  $invoice->id;
                    $pay_list->document_type  =  1;
                    // return $request->payment_list['discount'][$key];
                    $pay_list->discount  =  $request->payment_list['discount'][$key];
                    $pay_list->bad_debt_rent_status  =  $request->payment_list['bad_debt_rent_status'][$key] ?? 0;
                    $pay_list->save();
                }

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    public function payment_receipt_move_out_bill(Request $request)
    {
        try{
                $invoice = RentBill::find($request->invoice_id);

                $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
                
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

                $receipt = new Receipt;
                $receipt->receipt_number =  $this->generateReceiptCode();
                $receipt->ref_room_id  =  $invoice->ref_room_id;
                $receipt->ref_rent_bill_id  =  $invoice->id;
                $receipt->ref_contract_id  =  $invoice->ref_contract_id;
                $receipt->ref_renter_id  =  $invoice->room_for_rent->ref_renter_id;
                $receipt->payment_format  =  $request->payment_format;
                $receipt->payment_channel  =  $request->receipt_payment_channel ?? $request->bad_debt_payment_channel; // รูปแบบชำระเงิน 1=เงินสด / 2=โอนเงิน / หักจากเงินประกัน
                $receipt->ref_bank_id  =  $request->ref_bank_id;
                $receipt->transfer_time  =  $request->transfer_time;
                $receipt->payment_date  =  $payment_date;
                $receipt->amount  =  $invoice->total_amount;
                $receipt->ref_type_id  =  $request->ref_type_id;
                $receipt->ref_status_id  =  5;
                $receipt->evidence_of_money_transfer  =  $image_name;
                $receipt->ref_user_id =  Auth::id();
                $receipt->save();

                $expenses = new IncomeExpenses;
                $expenses->type  =  1;
                $expenses->label  =  "ใบเสร็จย้ายออก";
                $expenses->amount  =  0;
                $expenses->date  =  Carbon::now();
                $expenses->ref_room_id  =  $invoice->ref_room_id;
                $expenses->ref_category_id  =  0;
                $expenses->name  =  $receipt->renter->fullName();
                $expenses->address  =  $receipt->renter->fullThaiAddress();
                $expenses->id_card_number  =  $receipt->renter->id_card_number;
                $expenses->branch  =  0;
                $expenses->phone  =  $receipt->renter->phone;
                $expenses->remark  =  0;
                $expenses->ref_user_id  =  Auth::id();
                $expenses->ref_receipt_id  =  $receipt->id;
                $expenses->ref_branch_id  =  session("branch_id");
                $expenses->save();

                foreach($invoice->payment_list as $key => $payment_list){
                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->title  =  $payment_list->title;
                    $pay_list->price  =  $payment_list->price;
                    $pay_list->ref_payment_id  =  $receipt->id;
                    $pay_list->document_type  =  2;
                    $pay_list->discount  =  $payment_list->discount;
                    $pay_list->save();
                }
                
                $invoice->ref_status_id  =  5;
                $invoice->payment_channel  =  $request->receipt_payment_channel ?? $request->bad_debt_payment_channel;
                $invoice->save();
                // if($request->receipt_payment_channel == 3){

                // }
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
    }
    
//   ชำระ ค่าจองหลายห้อง
    public function insert_receipt_all(Request $request)
    {
        // return $request;
        try{
            foreach($request->insert as $insert){
                // $request->insert_single;
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
        $province = Province::find($renter->ref_province_id)->name_in_thai ?? '';
        $district = District::find($renter->ref_district_id)->name_in_thai ?? '';
        $subdistrict = Subdistrict::find($renter->ref_subdistrict_id) ?? '';
        $data['bank'] = Bank::where('ref_branch_id', session("branch_id"))->get();
        $data['address'] = $renter->addess.' '.@$subdistrict->name_in_thai ?? ''.' '.$district.' '.$province.' '.@$subdistrict->zip_code ?? '';
        $contract_room_has = Contract::where('ref_renter_id', $id)->groupBy('ref_room_id')->get('ref_room_id')->toArray();
        $data['room_for_rent'] = RoomForRents::whereHas('rent_bills', function ($query) {
                                                    $query->where('ref_type_id', 3)
                                                            ->where('ref_status_id', 5);
                                                })
                                                ->whereHas('room', function ($query) {
                                                    $query->where('status', 1);
                                                })
                                                ->where('ref_branch_id', session("branch_id"))
                                                ->where('ref_renter_id', $id)
                                                ->get();
        // $data['room_for_rent'] = RoomForRents::leftJoin('room', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
        //                                         ->where('ref_renter_id', $id)
        //                                         // ->whereNotIn('ref_room_id', $contract_room_has)
        //                                         ->get();

        return view('room/room-rental-contract', $data);
    }
    public function get_room_rental_move_out($id)
    {
        $renter = Renter::find($id);
        $renter->fullName = $renter->fullName();

        return response()->json([
            'success' => true,
            'renter' => $renter,
            'renter_address' => $renter->fullThaiAddress()
        ]);
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

        $province = Province::find(@$contract->ref_province_id)->name_in_thai ?? '';
        $district = District::find(@$contract->ref_district_id)->name_in_thai ?? '';
        $subdistrict = Subdistrict::find(@$contract->ref_subdistrict_id);

        $data['address'] = $contract->addess.' '.@$subdistrict->name_in_thai.' '.@$district.' '.@$province.' '.@$subdistrict->zip_code;
        $data['contract'] = $contract;
        
        $data['service'] = Service::where('ref_branch_id', session("branch_id"))->get();
        $data['discount'] = Discount::where('ref_branch_id', session("branch_id"))->get();

        $data['room_has_service'] = RoomHasService::where('ref_room_id', $id)->pluck('ref_service_id')->toArray();
        $data['room_has_discount'] = RoomHasDiscount::where('ref_room_id', $id)->pluck('ref_discount_id')->toArray();

        return view('room/room-form-contract', $data);
    }
    // รายละเอียด สัญญา
    public function get_room_detail_contract($id)
    {
        // return 1234;
        $room = Room::find($id);
        $data['room'] = $room;
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
                                
        $province = Province::find(@$contract->ref_province_id)->name_in_thai ?? '';
        $district = District::find(@$contract->ref_district_id)->name_in_thai ?? '';
        $subdistrict = Subdistrict::find(@$contract->ref_subdistrict_id);

        $data['contract_date_to'] = Carbon::createFromFormat('Y-m-d', $contract->contract_date)->addMonths($contract->period)->format('d/m/Y'); // แสดงผลแบบ 20/06/2025
        $receipt_first = Receipt::where('ref_contract_id', $contract->contract_id)->first();
        $receipt = Receipt::where('ref_contract_id', $contract->contract_id)->get();
        
        $receipt_wait_for_confirm = Receipt::where('ref_room_id', $id)
                            ->where('ref_type_id', 2)
                            ->where('ref_status_id', 2)
                            ->where('ref_contract_id', $contract->contract_id)
                            ->orderBy('id',"DESC")
                            ->get(); // ใบเสร็จ

        $receipt = Receipt::where('ref_room_id', $id)
                            ->where('ref_type_id', 2)
                            ->where('ref_status_id', 5)
                            ->where('ref_contract_id', $contract->contract_id)
                            ->orderBy('id',"DESC")
                            ->get(); // ใบเสร็จ

        $receipt_jong = Receipt::where('ref_room_id', $id)
                            ->where('ref_type_id', 3)
                            ->orderBy('id',"DESC")
                            ->first(); // ใบเสร็จ
        
        // $rent_bill_jong = RentBill::where('ref_type_id', 3)->where('ref_room_id', $id)->where('ref_room_for_rent_id', $room->room_for_rent_main->id)->first();
        $rent_bill = RentBill::where('ref_type_id', 2)->where('ref_contract_id', $contract->contract_id)->first();

        $data['address'] = $contract->addess.' '.@$subdistrict->name_in_thai.' '.@$district.' '.@$province.' '.@$subdistrict->zip_code;
        $data['contract'] = $contract;
        $data['receipt_wait_for_confirm'] = $receipt_wait_for_confirm;
        $data['receipt'] = $receipt;
        $data['receipt_jong'] = $receipt_jong;
        // $data['rent_bill_jong_total_amount'] = $rent_bill_jong->total_amount ?? 0;
        $data['rent_bill'] = $rent_bill;
        $data['service'] = Service::where('ref_branch_id', session("branch_id"))->get();
        $data['discount'] = Discount::where('ref_branch_id', session("branch_id"))->get();

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
        }else{
            if(!$request['rooms']){
                return '';
            }
            $roomIds = $request['rooms'];
            $rooms = Room::with('floor')->whereIn('id', $roomIds)->get();
            if(count($rooms) == 0){
                return view('room/selected');
            }
            $structure = [];
            foreach ($rooms as $ro) {
                $buildingId = $ro->floor->ref_building_id;
                $floorId    = $ro->floor->id;
                $roomId     = $ro->id;

                $structure[$buildingId][$floorId][] = $roomId;
                $buildings[$buildingId] = $ro->floor->building->name;
            }
            $data['structure']['buildings'] = $structure;

            $data['buildings'] = $buildings;
            $data['class'] = 'col-sm-4';
        }

            $data['floors'] = Floor::whereHas('building', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })->pluck('name', 'id');
            $data['rooms'] = Room::whereHas('floor.building', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })->pluck('name', 'id');
        // return $data;
        return view('room/selected', $data);
        
        // return view('room/selected', $data);
    }
    
    // เข้าพักทันทีโดยไม่ต้องจอง
    public function insert_check_in(Request $request)
    {
        $booking_date = Carbon::createFromFormat('d/m/Y', $request->contract_date)->format('Y-m-d');
        $date_stay = Carbon::createFromFormat('d/m/Y', $request->contract_date)->format('Y-m-d');
        $payment_received_date = Carbon::createFromFormat('d/m/Y', $request->contract_date)->format('Y-m-d');
        // return $request;
        try{
            // return 123;
            $renter_blacklist = Renter::where('id_card_number', $request->id_card_number)->where('blacklist_status', 1)->first();
            if ($renter_blacklist) {
                return response()->json([
                    'status' => false,
                    'message' => 'บุคคลนี้ไม่สามารถ จอง ได้ เนื่องจากถูกขึ้นบัญชีดำ <br> เนื่องจาก '.$renter_blacklist->blacklist_detail.'<br>'.$renter_blacklist->room_for_rent->branch->name
                ]);
            }

            $room = Room::find($request->room_id);

            $renter = new Renter;
            $renter->ref_branch_id  =  session("branch_id");
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
            $renter->booking_channel  =  'จองโดยตรงกับที่พัก';
            $renter->save();
                    
                $r_f_r = new RoomForRents;
                $r_f_r->date_stay  =  $date_stay;
                $r_f_r->ref_room_id  =  $request->room_id;
                $r_f_r->ref_floor_id  =  $room->ref_floor_id;
                $r_f_r->ref_building_id  =  $room->floor->ref_building_id;
                $r_f_r->ref_branch_id  =  session("branch_id");
                $r_f_r->ref_renter_id  =  $renter->id;
                $r_f_r->ref_user_id  =  Auth::id();
                $r_f_r->deposit  =  0;
                $r_f_r->payment_method  =  1;
                $r_f_r->payment_received_date  =  $payment_received_date;
                $r_f_r->save();
                
                    // $update_room = Room::find($r_n->id);
                    $room->status  =  1;
                    $room->save();
                            
            // $merged = array_merge($insert, $request);
            $request->merge([
                'check_in' => 1,
                'ref_room_id' => $request->room_id,
                'ref_renter_id' => $renter->id
            ]);
            $this->insert_contract($request);
                
            // DB::commit();

            // return $renter->id;
            // return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
/// ทำสัญญา
    public function insert_contract(Request $request) /// ทำสัญญา
    {
    // return $request;
        try{
            $contract_date = Carbon::createFromFormat('d/m/Y', $request->contract_date)->format('Y-m-d');
        // return $request->contract;
            foreach($request->contract as $row){
                $pay = [];
            // return $row;
                $room = Room::find($row['ref_room_id'] ?? $request->ref_room_id); //save อยู่ข้างล่าง
                if(@$row['deduction_booking_date']){
                    $deduction_booking_date = Carbon::createFromFormat('d/m/Y', $row['deduction_booking_date'])->format('Y-m-d');
                }
                
                $contract = new Contract;

                $contract->ref_renter_id  =  $request->ref_renter_id;
                // $contract->homeland  =  $request->homeland;
                $contract->phone  =  $request->phone;
                $contract->id_card_number  =  $request->id_card_number; 
                $contract->address  =  $request->address;
                $contract->contract_date  =  $contract_date;
                $contract->period  =  $request->period;
                $contract->remark  =  $request->remark;

                $contract->ref_room_id  =  $row['ref_room_id'] ?? $request->ref_room_id;
                    $contracts = $row['deposit'];
                    $security_deposit = collect($contracts)->sum(function ($item) { // รวมจำนวนเงิน ค่าประกัน security_deposit ทั้งหมด
                        return (float) $item['security_deposit'];
                    });
                $contract->security_deposit  = $security_deposit;
                $contract->deduction_booking_amount  =  $row['deduction_booking_amount'] ?? 0;
                $contract->deduction_booking_date  =  $deduction_booking_date ?? null;
                $contract->receipt_no  =  $row['receipt_no'] ?? null;
                $contract->water_meter_start_living  =  @$row['water_meter_start_living'];
                $contract->electricity_meter_start_living  =  @$row['electricity_meter_start_living'];
                $contract->save();

                $prevMonth = (int)date('m') - 1;
                $prevYear = (int)date('Y');

                if ($prevMonth < 1) {
                    $prevMonth = 12;
                    $prevYear -= 1;
                }

                $prevMonth = str_pad($prevMonth, 2, '0', STR_PAD_LEFT);

                
                $meterPrevious = Meter::where('ref_room_id', $room->id)->where('month', $prevMonth)->where('year', $prevYear)->first();
                $meter = Meter::where('ref_room_id', $room->id)->where('month', date('m'))->where('year', date('Y'))->first();
                // dd($meter);
                $r_f_r = RoomForRents::where('ref_room_id', $row['ref_room_id'] ?? $request->ref_room_id)->latest()->first();
                $current_month_usage_water = (int)$meter->water_unit+(int)$meter->meter_before_change-(int)$meter->start_value_of_new_meter - (int)$row['water_meter_start_living'];
                $current_month_usage_electricity = (int)$meter->electricity_unit+(int)$meter->meter_before_change-(int)$meter->start_value_of_new_meter - (int)$row['electricity_meter_start_living'];

                $prevMonth = str_pad($prevMonth, 2, '0', STR_PAD_LEFT);

                // $electricity_unit = $this->find_meter_by_name($room->name);
                
                $r_b_room = new RentBill;  // สร้างบิลค่าเช่าห้อง สำหรับ Test
                $r_b_room->ref_room_for_rent_id  =  $r_f_r->id;
                $r_b_room->month  =  date('m');
                $r_b_room->year  =  date('Y');
                $r_b_room->previous_electricity_unit  =  (int)$row['electricity_meter_start_living'];
                $r_b_room->electricity_unit  =  $meter->electricity_unit;
                $r_b_room->electricity_amount  =  $room->ele_baht_per_unit*$current_month_usage_electricity;
                $r_b_room->previous_water_unit  =  (int)$row['water_meter_start_living'];
                $r_b_room->water_unit  =  (int)$meter->water_unit;
                $r_b_room->water_amount  =  $room->water_baht_per_unit*$current_month_usage_water;
                $r_b_room->invoice_number =  $this->generateInvoiceCode();
                $r_b_room->ref_room_id =  $row['ref_room_id'] ?? $request->ref_room_id;
                $r_b_room->ref_contract_id =  $contract->id;
                $r_b_room->ref_status_id =  3; // 3 = ไม่สมบูรณ์ / ค้างชำระ
                $r_b_room->ref_type_id =  1; // 1 = ค่าเช่าห้อง
                $r_b_room->ref_user_id =  Auth::id();
                $r_b_room->save();

                $r_b = new RentBill; // สร้างบิลค่าประกันห้อง
                $r_b->ref_room_for_rent_id  =  $r_f_r->id;
                $r_b->month  =  date('m');
                $r_b->year  =  date('Y');
                $r_b->electricity_unit  =  0;
                $r_b->electricity_amount  =  0;
                $r_b->water_unit  =  0;
                $r_b->water_amount  =  0;
                $r_b->invoice_number  =  $this->generateInvoiceCode();
                $r_b->ref_room_id =  $row['ref_room_id'] ?? $request->ref_room_id;
                $r_b->ref_contract_id =  $contract->id;
                $r_b->ref_status_id =  7; // 7 = ค้างชำระ
                $r_b->ref_type_id =  2; // 2 = ค่าประกันห้อง
                $r_b->ref_user_id =  Auth::id();
                $r_b->save();
                
                foreach($row['deposit'] as $r){
                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->title  =  $r['title'];
                    $pay_list->price  =  $r['security_deposit'];
                    $pay_list->ref_payment_id  =  $r_b->id;
                    $pay_list->document_type  =  1;
                    $pay_list->save();
                    
                    $pay['payment_list']['title'][]  =  $r['title'];
                    $pay['payment_list']['price'][]  =  $r['security_deposit'];
                    $pay['payment_list']['discount'][]  =  0;
                }
                if($request->check_in == null){
                    $pay_list = new PaymentList; // สร้างรายการ ค่าห้อง
                    $pay_list->title  =  "หักจากค่าจองห้องพัก";
                    $pay_list->price  =  $row['deduction_booking_amount'];
                    $pay_list->ref_payment_id  =  $r_b->id;
                    $pay_list->document_type  =  1;
                    $pay_list->discount  =  1;
                    $pay_list->save();
                    
                    $pay['payment_list']['title'][]  =  'หักจากค่าจองห้องพัก';
                    $pay['payment_list']['price'][]  =  $row['deduction_booking_amount'];
                    $pay['payment_list']['discount'][]  =  1;
                }
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
                $pay_list->title  =  "ค่าไฟฟ้า (Electrical rate) เดือน ".(date('m'))." (".(int)$meter->electricity_unit." - ".(int)$row['electricity_meter_start_living']." = ".(int)$meter->electricity_unit-(int)$row['electricity_meter_start_living']." ยูนิต)";
                $pay_list->unit  =  (int)$meter->electricity_unit;
                $pay_list->price  =  $room->ele_baht_per_unit*(int)$current_month_usage_electricity;
                $pay_list->ref_payment_id  =  $r_b_room->id;
                $pay_list->document_type  =  1;
                $pay_list->save();
                
                RoomHasService::where('ref_room_id', $row['ref_room_id'] ?? $request->ref_room_id)->delete(); // ลบค่าบริการห้อง เพื่อ สร้างใหม่
                if(@$request->ref_service_id){
                    foreach($request->ref_service_id as $ser){ // for เพื่อสร้าง ค่าบริการห้องใหม่
                        
                        $insert = new RoomHasService;
                        $insert->ref_room_id  =  $row['ref_room_id'] ?? $request->ref_room_id;
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
                RoomHasDiscount::where('ref_room_id', $row['ref_room_id'] ?? $request->ref_room_id)->delete(); // ลบส่วนลดห้อง เพื่อ สร้างใหม่
                if(@$request->ref_discount_id){
                    foreach($request->ref_discount_id as $dis){ // for เพื่อสร้าง ส่วนลดห้อง ใหม่

                        $insert = new RoomHasDiscount;
                        $insert->ref_room_id  =  $row['ref_room_id'] ?? $request->ref_room_id;
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

                if(@$request->payment_channel){

                    $pay['payment_format']  =  1;
                    $pay['ref_room_id']  =  $room->id;
                    $pay['ref_rent_bill_id']  =  $r_b->id;
                    $pay['ref_contract_id']  =  $contract->id;
                    $pay['ref_renter_id']  =  $request->ref_renter_id;
                    $pay['amount']  =  $update_r_2->total_amount;
                    $pay['ref_type_id']  =  2;

                    $merged = array_merge($pay, $request->all());
                    $this->insert_receipt(new Request($merged));

                }
                
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
    // เพิ่ม หรือ แก้ไข ผู้เช่า
    public function insert_or_update_renter(Request $request)
    {
        // $booking_date = Carbon::createFromFormat('d/m/Y', $request->booking_date)->format('Y-m-d');
        // $date_stay = Carbon::createFromFormat('d/m/Y', $request->date_stay)->format('Y-m-d');
        $birthdate = Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('Y-m-d');
        $room = Room::find($request->room_id);
        // return $request;
        $room_for_rent = RoomForRents::where('ref_room_id', $request->room_id)->orderBy('id', 'desc')->first();

        try{
            
            // return $this->generateInvoiceCode();
            if(@$request->renter_id){
                $renter = Renter::find($request->renter_id);

                Vehicle::where('ref_renter_id', $request->renter_id)->delete();

            }else{
                $renter = new Renter;
            }

                $renter->ref_branch_id  =  session("branch_id");
                $renter->prefix  =  $request->prefix;
                $renter->name  =  $request->name;
                $renter->surname  =  $request->surname;
                $renter->phone  =  $request->phone;
                $renter->salary  =  $request->salary;
                $renter->id_card_number  =  $request->id_card_number;
                $renter->address  =  $request->address;
                $renter->ref_subdistrict_id  =  $request->ref_subdistrict_id;
                $renter->ref_district_id  =  $request->ref_district_id;
                $renter->ref_province_id  =  $request->ref_province_id;
                $renter->birthdate  =  $birthdate;
                $renter->zipcode  =  $request->zipcode;
                $renter->booking_date  =  $room_for_rent->renter->booking_date;
                $renter->booking_channel  =  $room_for_rent->renter->booking_channel;
                $renter->save();

            $room_for_rent_id = $room_for_rent->id;

            if(!$request->renter_id){

                $r_t_r = new RoomForRents;
                $r_t_r->date_stay  =  $room_for_rent->payment_received_date;
                $r_t_r->ref_room_id  =  $request->room_id;
                $r_t_r->ref_floor_id  =  $room_for_rent->ref_floor_id;
                $r_t_r->ref_building_id  =  $room_for_rent->ref_building_id;
                $r_t_r->ref_branch_id  =  session("branch_id");
                $r_t_r->ref_renter_id  =  $renter->id;
                $r_t_r->ref_user_id  =  Auth::id();
                $r_t_r->deposit  =  $room_for_rent->deposit;
                $r_t_r->payment_method  =  $room_for_rent->payment_method;
                $r_t_r->payment_received_date  =  $room_for_rent->payment_received_date;
                $r_t_r->status  =  1;
                $r_t_r->save();

                $room_for_rent_id = $r_t_r->id;
            }
            // return $request->vehicles;
            foreach($request->vehicles as $vehicle){
                if($vehicle['car_registration'] == '' & $vehicle['detail'] == ''){
                    continue;
                }
                $vehi = new Vehicle();
                $vehi->ref_renter_id = $renter->id;
                $vehi->ref_room_for_rent_id = $room_for_rent_id;
                $vehi->ref_room_id = $request->room_id;
                $vehi->ref_type_id = $vehicle['ref_type_id'];
                $vehi->car_registration = $vehicle['car_registration'];
                $vehi->detail = $vehicle['detail'];
                $vehi->remark = "-";
                $vehi->save();
            }

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        
    }
    // จองห้อง
    public function store(Request $request)
    {
        $booking_date = Carbon::createFromFormat('d/m/Y', $request->booking_date)->format('Y-m-d');
        $date_stay = Carbon::createFromFormat('d/m/Y', $request->date_stay)->format('Y-m-d');
        $payment_received_date = Carbon::createFromFormat('d/m/Y', $request->date_stay)->format('Y-m-d');
        // return $request;
        try{
            // return 123;
            $renter_blacklist = Renter::where('id_card_number', $request->id_card_number)->where('blacklist_status', 1)->first();
            if ($renter_blacklist) {
                return response()->json([
                    'status' => false,
                    'message' => 'บุคคลนี้ไม่สามารถ จอง ได้ เนื่องจากถูกขึ้นบัญชีดำ <br> เนื่องจาก '.$renter_blacklist->blacklist_detail.'<br>'.$renter_blacklist->room_for_rent->branch->name
                ]);
            }

            $renter = new Renter;
            $renter->ref_branch_id  =  session("branch_id");
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
                // return $request->room_text;
                if(@$request->room_text){

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

                }else{
                    $room_all = Room::whereIn('id', $request->room_text_id)->get();

                    // เช็คห้องที่ไม่ว่าง ถ้ามีให้ error ว่า ห้องเหล่านี้ไม่ว่าง เริ่ม {
                    $vacant_room_all = Room::whereHas('floor.building', function ($query) {
                                    $query->where('ref_branch_id', session("branch_id"));
                                })
                                ->where('status', '!=', 0)
                                ->whereIn('id', $request->room_text_id)
                                ->pluck('name') // ดึงเฉพาะคอลัมน์ name
                                ->toArray();    // แปลงเป็น array
                }

                    if (!empty($vacant_room_all)) {
                        return response()->json([
                            'status' => false,
                            'message' => 'ไม่สามารถจองห้องเหล่านี้ได้ <br>' . implode(', ', $vacant_room_all)
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
                            $r_f_r->payment_method  =  $request->payment_channel;
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
                            $r_b->ref_room_id =  $r_n->id;
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
                            // $receipt->payment_channel  =  $request->payment_channel;
                            // $receipt->payment_date  =  $payment_received_date;
                            // $receipt->amount  =  $request->deposit;
                            // $receipt->save();
                                
                            $payment_list = new PaymentList;
                            $payment_list->title  =  'เงินค่าจองห้อง';
                            $payment_list->price  =  $request->deposit;
                            $payment_list->ref_payment_id  =  $r_b->id;
                            $payment_list->document_type  =  1;     //  1 = rent_bill
                            $payment_list->save();
                            
                            // ชำระเงินค่าจอง
                            $image_name = "";
                            if($request->payment_channel == 1){
                                $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
                            }else{
                                $payment_date = Carbon::createFromFormat('d/m/Y', trim($request->payment_date))->format('Y-m-d');
                                
                                if($request->file('evidence_of_money_transfer')){
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
                            }
                            $receipt = new Receipt;
                            $receipt->receipt_number =  $this->generateReceiptCode();
                            $receipt->ref_room_id  =  $r_n->id;
                            $receipt->ref_rent_bill_id  =  $r_b->id;
                            // $receipt->ref_contract_id  =  '';
                            $receipt->ref_renter_id  =  $renter->id;
                            $receipt->payment_format  =  1; // รูปแบบชำระเงิน 1=เงินสด / 2=โอนเงิน
                            $receipt->payment_channel  =  $request->payment_channel;
                            $receipt->ref_bank_id  =  $request->ref_bank_id ?? '';
                            $receipt->transfer_time  =  $request->transfer_time;
                            $receipt->payment_date  =  $payment_date;
                            $receipt->amount  =  $request->deposit;
                            $receipt->ref_type_id  =  3;
                            $receipt->ref_status_id  =  2;
                            $receipt->evidence_of_money_transfer  =  $image_name;
                            $receipt->ref_user_id =  Auth::id();
                            $receipt->save();

                               
                            $payment_list = new PaymentList;
                            $payment_list->title  =  'รับชำระค่าจองห้อง '.$update_room->name;
                            $payment_list->price  =  $request->deposit;
                            $payment_list->ref_payment_id  =  $receipt->id;
                            $payment_list->document_type  =  2;     //  1 = rent_bill
                            $payment_list->save();

                            // foreach($request->payment_list['title'] as $key => $payment_list_title){
                            //     $pay_list = new PaymentList;
                            //     $pay_list->title  =  $payment_list_title;
                            //     $pay_list->price  =  $request->payment_list['price'][$key];
                            //     $pay_list->discount  =  $request->payment_list['discount'][$key] ?? 0;
                            //     $pay_list->ref_payment_id  =  $receipt->id;
                            //     $pay_list->document_type  =  2;
                            //     $pay_list->save();
                            // }

                            $receipt_total_amount = Receipt::where('ref_rent_bill_id', $r_b->id)->get()->pluck('total_amount')->sum();
                            $invoice_total_amount = RentBill::find($r_b->id)->total_amount;
                            if($invoice_total_amount == $receipt_total_amount){
                                $r_b = RentBill::find($r_b->id);
                                $r_b->ref_status_id =  5; //  5 = ชำระแล้ว
                                $r_b->save();
                            }
                            $expenses = new IncomeExpenses;
                            $expenses->type  =  1;
                            $expenses->label  =  "ใบเสร็จค่าจองห้อง";
                            $expenses->amount  =  0;
                            $expenses->date  =  Carbon::now();
                            $expenses->ref_room_id  =  $r_n->id;
                            $expenses->ref_category_id  =  0;
                            $expenses->name  =  $receipt->renter->fullName();
                            $expenses->address  =  $receipt->renter->fullThaiAddress();
                            $expenses->id_card_number  =  $receipt->renter->id_card_number;
                            $expenses->branch  =  0;
                            $expenses->phone  =  $receipt->renter->phone;
                            $expenses->remark  =  0;
                            $expenses->ref_user_id  =  Auth::id();
                            $expenses->ref_receipt_id  =  $receipt->id;
                            $expenses->ref_branch_id  =  session("branch_id");
                            $expenses->save();

                            if(@$file) $file->move($path, $image_name);
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
                            $r_f_r->payment_method  =  $request->payment_channel;
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
                            $r_b->ref_room_id =  $room;
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
                            // $receipt->payment_channel  =  $request->payment_channel;
                            // $receipt->payment_date  =  $payment_received_date;
                            // $receipt->amount  =  $request->deposit;
                            // $receipt->save();
                                
                            $payment_list = new PaymentList;
                            $payment_list->title  =  'เงินค่าจองห้อง';
                            $payment_list->price  =  $request->deposit;
                            $payment_list->ref_payment_id  =  $r_b->id;
                            $payment_list->document_type  =  1;     //  1 = rent_bill
                            $payment_list->save();

                            
                            // ชำระเงินค่าจอง
                            $image_name = "";
                            if($request->payment_channel == 1){
                                $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
                            }else{
                                $payment_date = Carbon::createFromFormat('d/m/Y', trim($request->payment_date))->format('Y-m-d');
                                
                                if($request->file('evidence_of_money_transfer')){
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
                            }
                            $receipt = new Receipt;
                            $receipt->receipt_number =  $this->generateReceiptCode();
                            $receipt->ref_room_id  =  $room;
                            $receipt->ref_rent_bill_id  =  $r_b->id;
                            // $receipt->ref_contract_id  =  '';
                            $receipt->ref_renter_id  =  $renter->id;
                            $receipt->payment_format  =  1; // รูปแบบชำระเงิน 1=เงินสด / 2=โอนเงิน
                            $receipt->payment_channel  =  $request->payment_channel;
                            $receipt->ref_bank_id  =  $request->ref_bank_id ?? '';
                            $receipt->transfer_time  =  $request->transfer_time;
                            $receipt->payment_date  =  $payment_date;
                            $receipt->amount  =  $request->deposit;
                            $receipt->ref_type_id  =  3;
                            $receipt->ref_status_id  =  2;
                            $receipt->evidence_of_money_transfer  =  $image_name;
                            $receipt->ref_user_id =  Auth::id();
                            $receipt->save();

                               
                            $payment_list = new PaymentList;
                            $payment_list->title  =  'รับชำระค่าจองห้อง '.$update_room->name;
                            $payment_list->price  =  $request->deposit;
                            $payment_list->ref_payment_id  =  $receipt->id;
                            $payment_list->document_type  =  2;     //  1 = rent_bill
                            $payment_list->save();

                            // foreach($request->payment_list['title'] as $key => $payment_list_title){
                            //     $pay_list = new PaymentList;
                            //     $pay_list->title  =  $payment_list_title;
                            //     $pay_list->price  =  $request->payment_list['price'][$key];
                            //     $pay_list->discount  =  $request->payment_list['discount'][$key] ?? 0;
                            //     $pay_list->ref_payment_id  =  $receipt->id;
                            //     $pay_list->document_type  =  2;
                            //     $pay_list->save();
                            // }

                            $receipt_total_amount = Receipt::where('ref_rent_bill_id', $r_b->id)->get()->pluck('total_amount')->sum();
                            $invoice_total_amount = RentBill::find($r_b->id)->total_amount;
                            if($invoice_total_amount == $receipt_total_amount){
                                $r_b = RentBill::find($r_b->id);
                                $r_b->ref_status_id =  5; //  5 = ชำระแล้ว
                                $r_b->save();
                            }
                            $expenses = new IncomeExpenses;
                            $expenses->type  =  1;
                            $expenses->label  =  "ใบเสร็จค่าจองห้อง";
                            $expenses->amount  =  0;
                            $expenses->date  =  Carbon::now();
                            $expenses->ref_room_id  =  $room;
                            $expenses->ref_category_id  =  0;
                            $expenses->name  =  $receipt->renter->fullName();
                            $expenses->address  =  $receipt->renter->fullThaiAddress();
                            $expenses->id_card_number  =  $receipt->renter->id_card_number;
                            $expenses->branch  =  0;
                            $expenses->phone  =  $receipt->renter->phone;
                            $expenses->remark  =  0;
                            $expenses->ref_user_id  =  Auth::id();
                            $expenses->ref_receipt_id  =  $receipt->id;
                            $expenses->ref_branch_id  =  session("branch_id");
                            $expenses->save();

                            if(@$file) $file->move($path, $image_name);
                        }
                    }
                }
            }
            
            DB::commit();

            return $renter->id;
            // return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
    // public function generateInvoiceCode()
    // {
    //     $year = Carbon::now()->format('Y');   // 2024
    //     $month = Carbon::now()->format('m');  // 01-12

    //     $yearMonth = $year . $month;

    //     // ใช้ lock เพื่อป้องกัน race condition
    //     return DB::transaction(function () use ($year, $month, $yearMonth) {
    //         $latestInvoice = RentBill::where('year', $year)
    //                                 ->where('month', $month)
    //                                 ->lockForUpdate()   // lock row
    //                                 ->latest('id')
    //                                 ->first();

    //         $sequence = $latestInvoice ? (int)substr($latestInvoice->invoice_number, -6) + 1 : 1;
    //         $sequenceCode = str_pad($sequence, 6, '0', STR_PAD_LEFT);

    //         return 'INV' . $yearMonth . $sequenceCode;
    //     });
    // }
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
