<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Electricity;
use App\Models\Water;
use App\Models\QRCode;
use App\Models\Bank;
use App\Models\Renter;
use App\Models\Building;
use App\Models\Service;
use App\Models\RoomHasService;
use App\Models\Discount;
use App\Models\RoomHasDiscount;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Branch;
use App\Models\Apartment;
use App\Models\Province;
use App\Models\District;
use App\Models\Subdistrict;
use App\Models\Company;
use App\Models\RentalcontractModel;
use App\Models\Setting_bill;
use App\Models\PermissionGroupHasUserBranch;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\UserHasBranch;
use Carbon\Carbon;

DB::beginTransaction();

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fine(Request $request)
    {
        $data['buildings'] = Building::where('ref_branch_id', session("branch_id"))->get();
        $data['floors'] = Floor::whereHas('building', function ($query) {
                                            $query->where('ref_branch_id', session("branch_id"));
                                        })->get();
        $data['page_url'] = 'setting/fine';

        return view('setting/setting-fine', $data);
    }
    public function fine_datatable(Request $request)
    {
        $results = Room::leftJoin('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                        ->leftJoin('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                        ->whereHas('floor.building', function ($query) {
                            $query->where('ref_branch_id', session("branch_id"));
                        })
                        ->select('rooms.*');
        
        if($request->building != "all"){
            $results = $results->Where('buildings.id', $request->building);
        }
        if($request->floor != "all"){
            $results = $results->Where('floors.id', $request->floor);
        }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }
        // $data['prefix'] = [ 1 => 'บริษัท', 2 => 'นาย', 3 => 'นางสาว', 4 => 'นาง'];
        $results = $results->paginate($limit);

        $data['list_data'] = $results;

        return view('setting/setting-fine-table', $data);
    }

    public function fine_edit($id)
    {
        $data['page_url'] = 'fine';
        $data['fine'] = Room::find($id);
        return view('setting/setting-fine-form', $data);
    }

    public function fine_update(Request $request, $id)
    {
        
        try{

            $update = Room::whereIn('id', explode(',', $id))
                            ->update([
                                'fine_type' => $request->fine_type == null?0:$request->fine_type,
                                'fine_day' => $request->fine_day == null?0:$request->fine_day,
                                // 'after_fine_day' => $request->after_fine_day == null?0:$request->after_fine_day,
                                'maximum_fine' => $request->maximum_fine == null?0:$request->maximum_fine,
                                'start_fine_day' => $request->start_fine_day == null?0:$request->start_fine_day
                            ]);
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function manage_bill(Request $request)
    {
        return view('setting/setting-manageBill',[
            'data' => Setting_bill::find(1),
        ]);
    }
    public function manage_billSubmit(Request $request)
    {
        try{
            $data = Setting_bill::find(1);
            if($data){
                $data->type  =  $request->type;
                $data->company_name  =  $request->company_name;
                $data->address  =  $request->address;
                $data->tax_no  =  $request->tax_no;
                $data->phone  =  $request->phone;
                $data->email  =  $request->email;
                $data->type_doc  =  $request->type_doc;
                // $data->detail_footer  =  $request->detail_footer;
                $data->detail_footer  =  null;
                $data->detail_doc  =  $request->detail_doc;
                if($data->save()){
                    DB::commit();
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
          
        } catch (QueryException $err) {
            // DB::rollBack();
        }
    }
    
    public function rental_contract(Request $request)
    {
        $data['data'] = RentalcontractModel::find(1);
        // $data['company'] = Company::where('ref_branch_id', session('branch_id'))->get();

        return view('setting/setting-rentalContract',$data);
    }
    public function rental_contractSubmit(Request $request)
    {
        try{
            $data = RentalcontractModel::find(1);
            $data->detail  =  $request->detail;
            $data->save();
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function dorm_info()
    {
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['subdistrict'] = Subdistrict::get();
        $branch = Branch::find(session("branch_id"));
        $data['branch'] = $branch;
        return view('setting/setting-dormInfo', $data);
    }
    public function get_contract_data()
    {
        $branch = Branch::find(session("branch_id"));
        $data['name'] = $branch->name;
        $data['address'] = $branch->fullThaiAddress();
        $data['renter'] = 'นาย สมชาย';
        $data['cartID'] = '1234567891234';
        $data['tel'] = '029999999';
        $data['roomName'] = 'A101';
        $data['floorName'] = '3';
        $data['contractPeriod'] = '12 เดือน';
        $data['contractDate'] = '1 มกราคม 2568';
        $data['contractEndDate'] = '31 ธันวาคม 2568';
        $data['deposit'] = '5,000 บาท';
        $data['allRoomRent'] = '7,500 บาท';
        $data['furnitureRental'] = '1,000 บาท';
        $data['roomRent'] = '6,500 บาท';
        $data['paymentDueDate'] = '5 มกราคม 2568';
        $data['electricityStartUnit'] = '0000';
        $data['waterStartUnit'] = '0000';
        $data['tenant_signature'] = 'นาย สมชาย';
        return $data;
    }
    public function update_branch(Request $request)
    {
        try{
            
            $update = Branch::find(session("branch_id"));
            $update->name  =  $request->name;
            $update->address  =  $request->address;
            $update->ref_province_id  =  $request->ref_province_id;
            $update->ref_district_id  =  $request->ref_district_id;
            $update->ref_subdistrict_id  =  $request->ref_subdistrict_id;
            $update->zipcode  =  $request->zipcode;
            $update->phone  =  $request->phone;
            $update->email  =  $request->email;
            $update->billing_date  =  $request->billing_date;
            $update->payment_end_date  =  $request->payment_end_date;
            $update->lat  =  $request->lat;
            $update->lng  =  $request->lng;
            $update->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function room_rent(Request $request)
    {
        $data['buildings'] = Building::where('ref_branch_id', session("branch_id"))->get();
        $data['floors'] = Floor::whereHas('building', function ($query) {
                                            $query->where('ref_branch_id', session("branch_id"));
                                        })->get();
        $data['page_url'] = 'setting/room-rent';

        return view('setting/setting-roomRent',$data);
    }
    public function room_rent_datatable(Request $request)
    {
        $results = Room::leftJoin('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                        ->leftJoin('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                        ->whereHas('floor.building', function ($query) {
                            $query->where('ref_branch_id', session("branch_id"));
                        })
                        ->select('rooms.*');
        
        if($request->building != "all"){
            $results = $results->Where('buildings.id', $request->building);
        }
        if($request->floor != "all"){
            $results = $results->Where('floors.id', $request->floor);
        }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }
        // $data['prefix'] = [ 1 => 'บริษัท', 2 => 'นาย', 3 => 'นางสาว', 4 => 'นาง'];
        $results = $results->paginate($limit);

        $data['list_data'] = $results;

        return view('setting/setting-roomRent-table', $data);
    }

    public function room_rent_edit($id)
    {
        $data['page_url'] = 'room_rent';
        $data['room_rent'] = Room::find($id);
        return view('setting/setting-roomRent-form', $data);
    }

    public function room_rent_update(Request $request, $id)
    {
        
        try{

            $update = Room::whereIn('id', explode(',', $id))
                            ->update([
                                'rent' => $request->rent == null?0:$request->rent,
                                'furniture_rental' => $request->furniture_rental == null?0:$request->furniture_rental,
                                'air_rental' => $request->air_rental == null?0:$request->air_rental
                            ]);
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function room_layout(Request $request)
    {
        // $response = Http::get('http://100.64.10.101:7953/getRealTimeData.aspx');
        // $xmlString = $response->body();
        
        // // แปลง XML เป็น SimpleXMLElement
        // $xmlObject = simplexml_load_string($xmlString);

        // // แปลง SimpleXMLElement เป็น array ถ้าต้องการ
        // $json = json_encode($xmlObject);
        // $array = json_decode($json, true);

        // return $array; // ส่งกลับเป็น array
        
        $data['building'] = Building::where('ref_branch_id',session("branch_id"))->get();
        // $data['floor'] = Floor::where('ref_building_id',session("branch_id"))->get();
        return view('setting/setting-roomLayout', $data);
    }
    public function insert_all(Request $request)
    {
        try{
            $targetPath = rand().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->move('upload/time_excel/', $targetPath);

            $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadSheet = $Reader->load('upload/time_excel/'.$targetPath);
            $excelSheet = $spreadSheet->getActiveSheet();
            $spreadSheetAry = $excelSheet->toArray();
            // $ta = [];
            foreach($spreadSheetAry as $key => $value){
                if($key == 0){ continue; }
                if (strpos($value[0], 'ตึก') !== false) {
                    // ทำสิ่งที่ต้องการเมื่อพบคำว่า "ตึก"
                    $building = new Building;
                    $building->name  =  $value[0];
                    $building->ref_branch_id  =  session("branch_id");
                    $building->save();
                    continue;
                }
                if (strpos($value[0], 'ชั้น') !== false) {
                    // ทำสิ่งที่ต้องการเมื่อพบคำว่า "ชั้น"
                    $floor = new Floor;
                    $floor->name  =  $value[0];
                    $floor->ref_building_id  =  $building->id;
                    $floor->save();
                    continue;
                }

                $room = new Room;
                $room->name  =  $value[0];
                $room->ref_floor_id  =  $floor->id;
                $room->save();
                
            }

            DB::commit();
            return 1;
            $data = array(
                "status" => true,
                "modal" => "".view('user-time/import-excel-modal')
            );
            return $data;
            
        } catch (QueryException $err) {
            DB::rollBack();
        }
        
        $data['building'] = Building::where('ref_branch_id',session("branch_id"))->get();
        // $data['floor'] = Floor::where('ref_building_id',session("branch_id"))->get();
        return view('setting/setting-roomLayout', $data);
    }
    public function room_layout_building(Request $request)
    {
        $data['building'] = Building::where('ref_branch_id',session("branch_id"))->get();
        return view('setting/setting-roomLayout-building', $data);
    }
    public function room_layout_building_insert(Request $request)
    {
        try{
            $insert = new Building;
            $insert->name  =  $request->name;
            $insert->ref_branch_id  =  session("branch_id");
            $insert->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function room_layout_building_delete($id)
    {
        try{

            Building::destroy($id);

            $floor = Floor::where('ref_building_id', $id)->get('id')->toArray();

            Floor::where('ref_building_id', $id)->delete();
            Room::whereIn('ref_floor_id', $floor)->delete();

            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function room_layout_floor($building_id)
    {
        $data['row']['floor'] = Floor::where('ref_building_id', $building_id)->get();
        return view('setting/setting-roomLayout-floor', $data);
    }
    public function room_layout_floor_insert(Request $request)
    {
        try{
            $insert = new Floor;
            $insert->name  =  $request->name;
            $insert->ref_building_id  =  $request->ref_building_id;
            $insert->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function room_layout_floor_delete($id)
    {
        try{
            Floor::destroy($id);
            Room::where('ref_floor_id', $id)->delete();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function room_layout_room($floor_id)
    {
        $data['floor']['room'] = Room::where('ref_floor_id', $floor_id)->get();
        return view('setting/setting-roomLayout-room', $data);
    }
    public function room_layout_room_insert(Request $request)
    {
        try{
            $insert = new Room;
            $insert->name  =  $request->name;
            $insert->ref_floor_id  =  $request->ref_floor_id;
            $insert->minimum_water_bill = 0;
            $insert->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function room_layout_room_update(Request $request)
    {
        try{
            foreach($request->room as $room){
                $update = Room::find($room['id']);
                $update->name  =  $room['value'];
                $update->save();
            }
                
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function room_layout_room_delete($id)
    {
        try{
            Room::destroy($id);
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    // public function water_electric_bill(Request $request)
    // {
    //     return view('setting/setting-waterElectricBill');
    // }
    public function water_electric_bill(Request $request)
    {
        $data['buildings'] = Building::where('ref_branch_id', session("branch_id"))->get();
        $data['floors'] = Floor::whereHas('building', function ($query) {
                                            $query->where('ref_branch_id', session("branch_id"));
                                        })->get();
        $data['page_url'] = 'setting/water-electric-bill';

        return view('setting/setting-waterElectricBill', $data);
    }
    public function water_electric_bill_datatable(Request $request)
    {
        $results = Room::leftJoin('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                        ->leftJoin('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                        ->whereHas('floor.building', function ($query) {
                            $query->where('ref_branch_id', session("branch_id"));
                        })
                        ->select('rooms.*');
        
        if($request->building != "all"){
            $results = $results->Where('buildings.id', $request->building);
        }
        if($request->floor != "all"){
            $results = $results->Where('floors.id', $request->floor);
        }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }
        // $data['prefix'] = [ 1 => 'บริษัท', 2 => 'นาย', 3 => 'นางสาว', 4 => 'นาง'];
        $results = $results->paginate($limit);

        $data['list_data'] = $results;

        return view('setting/setting-waterElectricBill-table', $data);
    }

    public function water_bill_edit($id)
    {
        $data['page_url'] = 'water-electric-bill';
        $water_bill = Room::find($id);
        $data['water_bill'] = $water_bill;
        if($water_bill){
            $data['how'] = [$water_bill->how_to_cal_water => 'checked' ];
        }else{
            $data['how'] = [ 4 => 'checked' ];
        }
        return view('setting/setting-waterBill-form', $data);
    }

    public function electric_bill_edit($id)
    {
        $data['page_url'] = 'water-electric-bill';
        $electric_bill = Room::find($id);
        $data['electric_bill'] = $electric_bill;
        if($electric_bill){
            $data['how'] = [$electric_bill->how_to_cal_ele => 'checked' ];
        }else{
            $data['how'] = [ 3 => 'checked' ];
        }
        return view('setting/setting-electricBill-form', $data);
    }

    public function water_bill_update(Request $request, $id)
    {
        
        try{
            $data_update['how_to_cal_water'] = $request->how_to_cal_water ?? 0;
            if($request->how_to_cal_water == 3){
                $data_update['water_baht_per_unit'] = $request->water_baht_per_unit ?? 0;
            }else{
                $data_update['water_baht_per_unit'] = $request->water_baht_per_unit_2 ?? 0;
            }

            $data_update['water_monthly_rental'] = $request->water_monthly_rental ?? 0;
            $data_update['minimum_water_bill'] = $request->minimum_water_bill ?? 0;
            
            $update = Room::whereIn('id', explode(',', $id))
                            ->update($data_update);
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function electric_bill_update(Request $request, $id)
    {
        
        try{

            $data_update['how_to_cal_ele'] = $request->how_to_cal_ele ?? 0;
            if($request->how_to_cal_ele == 2){
                $data_update['ele_baht_per_unit'] = $request->ele_baht_per_unit ?? 0;
            }else{
                $data_update['ele_baht_per_unit'] = $request->ele_baht_per_unit_2 ?? 0;
            }

            $data_update['ele_monthly_rental'] = $request->ele_monthly_rental ?? 0;
            $data_update['minimum_ele_bill'] = $request->minimum_ele_bill ?? 0;
            
            $update = Room::whereIn('id', explode(',', $id))
                            ->update($data_update);
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function service_discount(Request $request)
    {
        $data['page_url'] = 'setting/setting-serviceDiscount';
        return view('setting/setting-serviceDiscount', $data);
    }

    public function service_datatable(Request $request)
    {
        $data['building'] = Building::where('ref_branch_id',session("branch_id"))->get();
        
        // $data['list_data'] = $results;

        return view('setting/setting-service-table', $data);
    }
    public function get_service(Request $request)
    {
        $data['service'] = Service::where('ref_branch_id',session("branch_id"))->get();
        
        // $data['list_data'] = $results;

        return view('setting/setting-service-form-add', $data);
    }
    public function delete_service(Request $request)
    {
        $data['service'] = Service::where('ref_branch_id',session("branch_id"))->get();
        
        // $data['list_data'] = $results;

        return view('setting/setting-service-form-delete', $data);
    }
    public function service_room($id)
    {
        // $data['service_id'] = RoomHasService::where('ref_room_id', $id)->pluck('ref_service_id')->toArray();
        $data['service'] = Service::with(['room_has_service' => function ($query) use ($id) {
                                        $query->where('ref_room_id', $id);
                                    }])->where('ref_branch_id',session("branch_id"))->get();
        
        $data['room_id'] = $id;

        return view('setting/setting-service-view', $data);
    }

    public function service_insert(Request $request)
    {
        
        try{
            $insert = new Service;
            $insert->name  =  $request->name;
            $insert->price  =  $request->price;
            $insert->ref_branch_id  =  session("branch_id");
            $insert->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function service_update(Request $request, $id)
    {
        // return 1;
        try{

            $update = Service::find($id);
            $update->name  =  $request->name;
            $update->price  =  $request->price;
            $update->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function service_room_update(Request $request)
    {
        try{
            $ref_room_id = explode(',',$request->ref_room_id);
            RoomHasService::whereIn('ref_room_id', $ref_room_id)->delete();
            if(@$ref_room_id){
                foreach($ref_room_id as $room_id){
                    if(@$request->ref_service_id){
                        foreach($request->ref_service_id as $id){
                            $insert = new RoomHasService;
                            $insert->ref_room_id  =  $room_id;
                            $insert->ref_service_id  =  $id;
                            $insert->price  =  $request->price[$id];
                            $insert->save();
                        }
                    }
                }

            }
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function service_on_room_delete(Request $request)
    {
        try{
            RoomHasService::whereIn('ref_room_id', $request->id)->whereIn('ref_service_id', $request->ref_service_id)->delete();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function service_delete($id)
    {
        try{
            Service::destroy($id);
            RoomHasService::where('ref_service_id', $id)->delete();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }

    /////////////////////////////////////////////////
    /////////////////////////////////////////////////
    
    public function discount_discount(Request $request)
    {
        $data['page_url'] = 'setting/setting-discountDiscount';
        return view('setting/setting-discountDiscount', $data);
    }

    public function discount_datatable(Request $request)
    {
        $data['building'] = Building::where('ref_branch_id',session("branch_id"))->get();

        return view('setting/setting-discount-table', $data);
    }
    public function get_discount(Request $request)
    {
        $data['discount'] = Discount::where('ref_branch_id',session("branch_id"))->get();

        return view('setting/setting-discount-form-add', $data);
    }
    public function delete_discount(Request $request)
    {
        $data['discount'] = Discount::where('ref_branch_id',session("branch_id"))->get();

        return view('setting/setting-discount-form-delete', $data);
    }
    public function discount_room($id)
    {
        // $data['discount_id'] = RoomHasDiscount::where('ref_room_id', $id)->pluck('ref_discount_id')->toArray();
        $data['discount'] = Discount::with(['room_has_discount' => function ($query) use ($id) {
                                        $query->where('ref_room_id', $id);
                                    }])->where('ref_branch_id',session("branch_id"))->get();
        $data['room_id'] = $id;

        return view('setting/setting-discount-view', $data);
    }

    public function discount_insert(Request $request)
    {
        
        try{
            $insert = new Discount;
            $insert->name  =  $request->name;
            $insert->price  =  $request->price;
            $insert->ref_branch_id  =  session("branch_id");
            $insert->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function discount_update(Request $request, $id)
    {
        // return 1;
        try{

            $update = Discount::find($id);
            $update->name  =  $request->name;
            $update->price  =  $request->price;
            $update->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function discount_room_update(Request $request)
    {
        try{
            $ref_room_id = explode(',',$request->ref_room_id);
            RoomHasDiscount::whereIn('ref_room_id', $ref_room_id)->delete();
            foreach($ref_room_id as $room_id){
                foreach($request->ref_discount_id ?? [] as $id){
                    $insert = new RoomHasDiscount;
                    $insert->ref_room_id  =  $room_id;
                    $insert->ref_discount_id  =  $id;
                    $insert->price  =  $request->price[$id];
                    $insert->save();
                }
            }
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function discount_on_room_delete(Request $request)
    {
        try{
            RoomHasDiscount::whereIn('ref_room_id', $request->id)->whereIn('ref_discount_id', $request->ref_discount_id)->delete();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function discount_delete($id)
    {
        try{
            Discount::destroy($id);
            RoomHasDiscount::where('ref_discount_id', $id)->delete();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }

    /////////////////////////////////////////////////
    /////////////////////////////////////////////////

    public function bank(Request $request)
    {
        
        $data['page_url'] = 'setting/bank';
        $data['bank'] = Bank::where('ref_branch_id',session("branch_id"))->get();

        return view('setting/setting-bank', $data);
    }
    public function bank_datatable(Request $request)
    {
        $results = Bank::where('ref_branch_id',session("branch_id"))->orderBy('id','DESC')->get();
        
        $data['list_data'] = $results;

        return view('setting/setting-bank-table', $data);
    }
    
    public function bank_insert(Request $request)
    {
        
        try{
            $insert = new Bank;
            $insert->bank  =  $request->bank;
            $insert->branch  =  $request->branch;
            $insert->bank_account_name  =  $request->bank_account_name;
            $insert->bank_account_number  =  $request->bank_account_number;
            $insert->remark  =  $request->remark;
            $insert->ref_branch_id  =  session("branch_id");
            $insert->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function bank_edit($id)
    {
        $data['page_url'] = 'bank';
        $data['bank'] = Bank::find($id);
        return view('setting/setting-bank-form', $data);
    }
 

    public function bank_update(Request $request, $id)
    {
        
        try{

            $update = Bank::find($id);
            $update->bank  =  $request->bank;
            $update->branch  =  $request->branch;
            $update->bank_account_name  =  $request->bank_account_name;
            $update->bank_account_number  =  $request->bank_account_number;
            $update->remark  =  $request->remark;
            $update->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function bank_delete($id)
    {
        try{
            Bank::destroy($id);
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    
    /////////////////////////////////////////////////
    /////////////////////////////////////////////////

    public function blacklist(Request $request)
    {
        $data['page_url'] = 'setting/blacklist';
        $data['renters'] = Renter::where('blacklist_status', 0)->get();

        return view('setting/setting-blacklist', $data);
    }
    public function blacklist_datatable(Request $request)
    {
        $results = Renter::where('blacklist_status', 1)->orderBy('blacklist_date', 'desc');
        
        if(@$request->search){
            $results = $results->where(function ($query) use ($request) {
                                    $query->where('name','LIKE','%'.$request->search.'%')
                                        ->orWhere('surname','LIKE','%'.$request->search.'%')
                                        ->orWhere('phone','LIKE','%'.$request->search.'%')
                                        ->orWhere('id_card_number','LIKE','%'.$request->search.'%');
                                });
        }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }
        // $data['prefix'] = [ 1 => 'บริษัท', 2 => 'นาย', 3 => 'นางสาว', 4 => 'นาง'];
        $results = $results->paginate($limit);
        
        $data['list_data'] = $results;

        return view('setting/setting-blacklist-table', $data);
    }
    
    public function blacklist_insert(Request $request)
    {
        
        try{
            $update = Renter::find($request->id);
            $update->blacklist_detail  =  $request->blacklist_detail;
            $update->blacklist_status  =  1;
            $update->blacklist_date  =  Carbon::now();
            $update->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function blacklist_edit($id)
    {
        $data['page_url'] = 'blacklist';
        $data['renters'] = Renter::where('blacklist_status', 0)->get();
        $data['blacklist'] = Renter::find($id);
        return view('setting/setting-blacklist-form', $data);
    }
 

    public function blacklist_update(Request $request)
    {
        
        try{
                $update = Renter::find($request->last_id);
                $update->blacklist_detail  =  null;
                $update->blacklist_status  =  0;
                $update->save();

                $update_new = Renter::find($request->id);
                $update_new->blacklist_detail  =  $request->blacklist_detail;
                $update_new->blacklist_status  =  1;
                $update_new->blacklist_date  =  $update->blacklist_date;
                $update_new->save();
                
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function blacklist_delete($id)
    {
        try{
            
            if(Auth::user()->user_has_branch->position->id == 1)
            {
                $update = Renter::find($id);
                $update->blacklist_detail  =  null;
                $update->blacklist_status  =  0;
                $update->blacklist_date  =  null;
                $update->save();
                DB::commit();
                return 1;

            }else{
                return 0;
            }
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    /////////////////////////////////////////////////    /////////////////////////////////////////////////

    public function company(Request $request)
    {
        
        $data['page_url'] = 'setting/company';
        $data['company'] = Company::where('ref_branch_id',session("branch_id"))->get();

        return view('setting/setting-company', $data);
    }
    public function company_datatable(Request $request)
    {
        $results = Company::where('ref_branch_id',session("branch_id"))->orderBy('id','DESC')->get();
        
        $data['list_data'] = $results;

        return view('setting/setting-company-table', $data);
    }
    
    public function company_insert(Request $request)
    {
        
        try{
            $insert = new Company;
            $insert->name  =  $request->name;
            $insert->detail  =  $request->detail;
            $insert->ref_branch_id  =  session("branch_id");
            $insert->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function company_edit($id)
    {
        $data['page_url'] = 'company';
        $data['company'] = Company::find($id);
        return view('setting/setting-company-form', $data);
    }
 

    public function company_update(Request $request, $id)
    {
        
        try{

            $update = Company::find($id);
            $update->name  =  $request->name;
            $update->detail  =  $request->detail;
            $update->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function company_delete($id)
    {
        try{
            Company::destroy($id);
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    //    User User User User
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    public function insert_user_has_branch(Request $request) // เพิ่ม บุคลากร จาก เบอร์โทร email
    {
        try{
            // Validate required field
            if (empty($request->email)) {
                return "กรุณากรอกอีเมลหรือเบอร์โทรศัพท์เพื่อค้นหา";
            }
            
            // $user = User::where('email', $request->email)->first();
            $email_check = $request->email;
            $user = User::where(function ($query) use ($email_check) {
                $query->where('email', $email_check)
                ->orWhere('phone', $email_check);
            })
            ->first();
            
            if(!$user){
                return "ไม่พบบุคลากร";
            }
            $ref_position_id = $user->ref_position_id;
            $u_h_b = UserHasBranch::where('ref_user_id', $user->id)->where("ref_branch_id", session("branch_id"))->first();
            
            if($u_h_b){
                return "ไม่พบบุคลากร";
            }
            // return $user->id;
            $uhb = new UserHasBranch;
            $uhb->ref_user_id  =  $user->id;
            $uhb->ref_branch_id  =  session("branch_id");
            $uhb->ref_position_id  =  2;
            $uhb->save();

            $permission = Permission::get(); // ดึง Permission ทั้งหมด เพื่อเอามา foreach

            foreach($permission as $permis){
                $pghub = new PermissionGroupHasUserBranch; // insert Permission ของ user ใน branch นี้
                $pghub->ref_branch_id = session("branch_id");
                $pghub->ref_user_id = $user->id;
                $pghub->ref_permission_id = $permis->id;
                $pghub->ref_permission_group_id = $permis->ref_permission_group_id;
                $pghub->status = 1;
                $pghub->save();
            }

            DB::commit();
            
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function insert_user_to_branch(Request $request) // สร้าง บุคลากร ด้วยตนเอง
    {
        try{
            // Validate required fields
            if (empty($request->name)) {
                return "กรุณากรอกชื่อพนักงาน";
            }
            if (empty($request->salary)) {
                return "กรุณากรอกเงินเดือน";
            }
            if (empty($request->phone)) {
                return "กรุณากรอกเบอร์โทรศัพท์";
            }
            if (empty($request->email)) {
                return "กรุณากรอกอีเมล";
            }
            if (empty($request->password)) {
                return "กรุณากรอกรหัสผ่าน";
            }
            
            $work_start_date = null;
            if($request->work_start_date){
                $work_start_date = Carbon::createFromFormat('d/m/Y', $request->work_start_date)->format('Y-m-d');
            }

            $ref_user_id = $request->ref_user_id;
            if($ref_user_id == null){
                $ref_user_id = 0;
            }

            $user = new User;
            $user->name  =  $request->name;
            $user->username  =  $request->username;
            $user->salary  =  preg_replace('/\D/', '', $request->salary);
            $user->phone  =  $request->phone;
            $user->email  =  $request->email;
            $user->work_start_date  =  $work_start_date;
            $user->ref_position_id  =  $request->ref_position_id;
            $user->ref_user_id  =  $ref_user_id;
            $user->remark  =  $request->remark;
            // $user->ref_branch_id  =  session("branch_id");
            $user->password = Hash::make($request->password);
            $user->save();

            $uhb = new UserHasBranch;
            $uhb->ref_user_id  =  $user->id;
            $uhb->ref_branch_id  =  session("branch_id");
            $uhb->ref_position_id  =  $request->ref_position_id;
            $uhb->save();

            $permission = Permission::get(); // ดึง Permission ทั้งหมด เพื่อเอามา foreach

            foreach($permission as $permis){
                $pghub = new PermissionGroupHasUserBranch; // insert Permission ของ user ใน branch นี้
                $pghub->ref_branch_id = session("branch_id");
                $pghub->ref_user_id = $user->id;
                $pghub->ref_permission_id = $permis->id;
                $pghub->ref_permission_group_id = $permis->ref_permission_group_id;
                $pghub->status = 1;
                $pghub->save();
            }


            DB::commit();
            
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update_user(Request $request, $id)
    {
        // return $request;
        try{
            $work_start_date = Carbon::createFromFormat('d/m/Y', $request->work_start_date)->format('Y-m-d');

            $user = User::find($id);
            $user->name  =  $request->name;
            $user->username  =  $request->username;
            $user->salary  =  preg_replace('/\D/', '', $request->salary);
            $user->phone  =  $request->phone;
            $user->email  =  $request->email;
            $user->work_start_date  =  $work_start_date;
            $user->ref_position_id  =  $request->ref_position_id;
            $user->remark  =  $request->remark;
            if(!empty($request->password)){
                $user->password = Hash::make($request->password);
            }
            $user->save();
            
            $uhb = UserHasBranch::where('ref_user_id',$id)->where('ref_branch_id', session("branch_id"))->first();
            $uhb->ref_position_id  =  $request->ref_position_id;
            $uhb->save();

            PermissionGroupHasUserBranch::where('ref_user_id', $id)->where('ref_branch_id', session("branch_id"))->update(['status' => 0]);
            PermissionGroupHasUserBranch::whereIn('id', $request->permission_id)->update(['status' => 1]);

            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    
    public function room_layout_qr_code(Request $request)
    {
        $data['qr_code'] = QRCode::where('ref_branch_id', session("branch_id"))->get();
        $data['building'] = Building::where('ref_branch_id',session("branch_id"))->get();
        return view('setting/setting-roomLayout-qr-code', $data);
    }
    
    public function upload_qr_code(Request $request)
    {
            
        try{
            $request->validate([
                'qr_code' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ],[
                'qr_code.required' => 'กรุณาเลือกรูปภาพ',
                'qr_code.image' => 'ไฟล์ที่เลือกต้องเป็นรูปภาพเท่านั้น',
                'qr_code.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท: jpeg, png, jpg, gif หรือ webp',
                'qr_code.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
            ]);
            $qrc = new QRCode;            
            $qrc->ref_branch_id = session("branch_id");
            if($request->file('qr_code')){
                // return 123;
                $file = $request->file('qr_code');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/qr-code/";
                $image_name = $img_name.rand().'.'.$extension;

                $qrc->qr_code = $image_name;

            }
            $qrc->save();

            DB::commit();
            
            if(@$file) {
                @unlink("$path/$lastImage");
                $file->move($path, $image_name);
            }

            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
            
    }
    public function update_qr_code(Request $request)
    {
            
        try{
            Floor::query()->update(['qr_code' => ""]);
            if(!$request->floor){
                DB::commit();
                return 1;
            }
            foreach($request->floor as $key => $floor){
                $qrc = Floor::find($key);            
                $qrc->qr_code = $floor;
                $qrc->save();
            }
            
            DB::commit();
            
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
            
    }
    public function delete_qr_code($id)
    {
        try{
            $qr_code = QRCode::find($id);
            $delete = QRCode::destroy(explode(',',$id));

            Floor::where('qr_code', $qr_code->qr_code)->update(['qr_code' => ""]);

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function change_position(Request $request, $user_has_branch_id)
    {
        try{
            // return $user->id;
            $uhb = UserHasBranch::find($user_has_branch_id);
            $uhb->ref_position_id  =  $request->ref_position_id;
            $uhb->save();
            
            DB::commit();
            
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function delete_user_in_branch(Request $request, $id)
    {
        // $ref_position_id = 1 เจ้าของหอพัก
        try{

            $user = Auth::guard()->user();
            if($user){
                $user_position = $user->ref_position_id;
                $branch = UserHasBranch::whereIn('id', explode(',',$id))->get();
                if($branch)
                {
                    foreach($branch as $data){
                        if($user->id == $data->ref_user_id){
                            return response()->json([ "title"=> "เกิดข้อผิดพลาด", "text"=> "คุณไม่สามารถลบตัวเองออกได้ !"],500);
                        }
                        $data_position = $data->ref_position_id;

                        if($data_position == 1){
                            if($user_position != 1){
                                return response()->json([ "title"=> "เกิดข้อผิดพลาด", "text"=> "คุณไม่สามารถลบข้อมูลของเจ้าของหอพักได้ !"],500);
                            }
                        }
                        UserHasBranch::destroy($data->id);
                        PermissionGroupHasUserBranch::where('ref_user_id', $data->ref_user_id)->where('ref_branch_id', session("branch_id"))->delete();
                    }
                }
                DB::commit();
                return response()->json([ "title"=> "ดำเนินการสำเร็จ", "text"=> "ลบข้อมูลผู้ลงทะเบียนเรียบร้อย"],200);
            }
            else
            {
                return response()->json([ "title"=> "เกิดข้อผิดพลาด", "text"=> "ไม่พบข้อมูลผู้ใช้งาน !"],500);
            }

            // DB::commit();
            // return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    /////////////////////////////////////////////////
    
    public function insert_electricity_bill(Request $request)
    {
        try{
            $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
            $insert = new Electricity;
            $insert->use_unit = $request->use_unit;
            $insert->amount = $request->amount;
            $insert->payment_date = $payment_date;
            $insert->ref_branch_id = session("branch_id");
            if($request->file('slip')){
                // return 123;
                    $request->validate([
                        'slip' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    ],[
                        'slip.required' => 'กรุณาเลือกรูปภาพ',
                        'slip.image' => 'ไฟล์ที่เลือกต้องเป็นรูปภาพเท่านั้น',
                        'slip.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท: jpeg, png, jpg, gif หรือ webp',
                        'slip.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
                    ]);
                $file = $request->file('slip');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/slip/";
                $slip = $img_name.rand().'.'.$extension;
                $insert->slip = $slip;
            }
            $insert->save();

            if(@$file) $file->move($path, $slip);

            DB::commit();

            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        // return view('analysis/analysis-elect');
    }
    /////////////////////////////////////////////////
    
    public function insert_water_bill(Request $request)
    {
        try{
            $payment_date = Carbon::createFromFormat('d/m/Y', $request->payment_date)->format('Y-m-d');
            $insert = new Water;
            $insert->use_unit = $request->use_unit;
            $insert->amount = $request->amount;
            $insert->payment_date = $payment_date;
            $insert->ref_branch_id = session("branch_id");
            if($request->file('slip')){
                // return 123;
                    $request->validate([
                        'slip' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    ],[
                        'slip.required' => 'กรุณาเลือกรูปภาพ',
                        'slip.image' => 'ไฟล์ที่เลือกต้องเป็นรูปภาพเท่านั้น',
                        'slip.mimes' => 'รูปภาพต้องเป็นไฟล์ประเภท: jpeg, png, jpg, gif หรือ webp',
                        'slip.max' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB',
                    ]);
                $file = $request->file('slip');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/slip/";
                $slip = $img_name.rand().'.'.$extension;
                $insert->slip = $slip;
            }
            $insert->save();

            if(@$file) $file->move($path, $slip);

            DB::commit();

            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        // return view('analysis/analysis-elect');
    }
}
