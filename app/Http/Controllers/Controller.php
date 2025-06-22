<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\RoomForRents;
use App\Models\RentBill;
use App\Models\Renter;
use App\Models\Contract;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function summary($branch_id)
    {
        $confirm_by_employee = RentBill::join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->where('rent_bills.ref_status_id', 2)->sum(DB::raw('rent_bills.electricity_amount + rent_bills.water_amount + rooms.rent'));

        $confirm_by_ceo = RentBill::join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->where('rent_bills.ref_status_id', 5)->sum(DB::raw('rent_bills.electricity_amount + rent_bills.water_amount + rooms.rent'));

        $cash = RentBill::join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->where('rent_bills.ref_status_id', 2)->where('rent_bills.payment_channel', 1)->sum(DB::raw('rent_bills.electricity_amount + rent_bills.water_amount + rooms.rent'));
        
        $transfer = RentBill::join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->where('rent_bills.ref_status_id', 2)->where('rent_bills.payment_channel', 2)->sum(DB::raw('rent_bills.electricity_amount + rent_bills.water_amount + rooms.rent'));

        $all_renter = Renter::join('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->distinct('renters.id')
                            ->where('buildings.ref_branch_id', $branch_id)
                            ->count();

        $all_renter_for_room = Contract::join('rooms', 'contracts.ref_room_id', '=', 'rooms.id')
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->distinct('rooms.id')
                            ->where('buildings.ref_branch_id', $branch_id)
                            ->count();

        // $all_booking_room = RoomForRents::join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
        //                                 ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
        //                                 ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
        //                                 ->where('rooms.status', 1)
        //                                 ->where('buildings.ref_branch_id', $branch_id)
        //                                 ->distinct('rooms.id')
        //                                 ->count();
        
        $all_booking_room = Room::where('rooms.status', 1)->count();


        $all_room = Room::join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->where('buildings.ref_branch_id', $branch_id)->count();

        $vacant_room = Room::join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->where('buildings.ref_branch_id', $branch_id)->count();

        $all_overdue = RentBill::join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', $branch_id)
                                ->where('rent_bills.ref_status_id', 3)
                                ->distinct('rooms.id')
                                ->count();

        $data['percent'] = 0; // อัตราเข้าพัก
        if ($all_room > 0) {
            $data['percent'] = number_format((100/$all_room)*$all_booking_room, 2); // อัตราเข้าพัก
        }
        $data['confirm_by_employee'] = number_format($confirm_by_employee,2).' บาท'; // ชำระเงินโดยพนักงาน
        $data['confirm_by_ceo'] = number_format($confirm_by_ceo,2).' บาท'; // ชำระเงินโดยผู้บริหาร
        $data['confirm_by_employee_confirm_by_ceo'] = number_format($confirm_by_employee + $confirm_by_ceo,2).' บาท'; // ชำระเงินหลังคอนเฟิร์ม
        $data['transfer'] = number_format($transfer,2).' บาท'; // เงินโอน
        $data['cash'] = number_format($cash,2).' บาท'; // เงินสด

        $data['all_renter_for_room'] = $all_renter_for_room; // จำนวนห้องไม่ว่าง
        $data['all_renter'] = $all_renter; // ผู้เช่า
        $data['all_booking_room'] = $all_booking_room; // ห้องจอง
        $data['all_overdue'] = $all_overdue; // ห้องค้างชำระ
        $data['vacant_room'] = $all_room - $all_booking_room; // ห้องว่าง
        return $data;
    }
}
