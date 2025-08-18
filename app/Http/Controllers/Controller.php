<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\RoomForRents;
use App\Models\IncomeExpenses;
use App\Models\RentBill;
use App\Models\Receipt;
use App\Models\Renter;
use App\Models\Contract;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function summary($branch_id)
    {
        if(!$branch_id){
            $branch_id = session("branch_id");
        }
        $lastMonth = Carbon::now();
        // $lastMonth = Carbon::now()->subMonth();

        //////////////////////// ยอดชำระเงินทั้งหมด
        $all_receipt = Receipt::whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->get()
                                        ->sum(function ($receipt) {
                                            return $receipt->total_amount; // <-- ใช้ accessor ได้ที่นี่
                                        });
        //////////////////////// ยอดชำระเงินทั้งหมด

        //////////////////////// ยอดชำระเงิน ค่าปรับ ทั้งหมด
        $all_receipt_fine = Receipt::whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->get()
                                        ->sum(function ($receipt) {
                                            return $receipt->total_fine_amount; // <-- ใช้ accessor ได้ที่นี่
                                        });
        //////////////////////// ยอดชำระเงิน ค่าปรับ ทั้งหมด

        //////////////////////// ยอดชำระเงิน ทั้งหมด ไม่รวม ค่าปรับ
        $all_receipt_not_fine = Receipt::whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->get()
                                        ->sum(function ($receipt) {
                                            return $receipt->total_not_fine_amount; // <-- ใช้ accessor ได้ที่นี่
                                        });
        //////////////////////// ยอดชำระเงิน ทั้งหมด ไม่รวม ค่าปรับ
        
        //////////////////////// จ่ายตรงเวลา
        $all_receipt_on_time = Receipt::whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->where('ref_type_id', 1)
                                        ->where('payment_on_time', 1)
                                        ->count();
        //////////////////////// จ่ายตรงเวลา

        //////////////////////// จ่ายล่าช้าแบบนัด
        $all_receipt_late_with_appointment = Receipt::whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->where('ref_type_id', 1)
                                        ->where('payment_on_time', 2)
                                        ->get()
                                        ->count();
        //////////////////////// จ่ายล่าช้าแบบนัด
        //////////////////////// จ่ายล่าช้าแบบไม่ได้นัดเวลา
        $all_receipt_late = Receipt::whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->where('ref_type_id', 1)
                                        ->where('payment_on_time', 3)
                                        ->get()
                                        ->count();
        //////////////////////// จ่ายล่าช้าแบบไม่ได้นัดเวลา

        //////////////////////// ยอดเรียกเก็บเงิน ทั้งหมด
        $all_invoice = RentBill::whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->whereIn('ref_status_id', [2,4,5,7])
                                        ->get()
                                        ->sum(function ($invoice) {
                                            return $invoice->total_amount; // <-- ใช้ accessor ได้ที่นี่
                                        });
        //////////////////////// ยอดเรียกเก็บเงิน ทั้งหมด

        $confirm_by_employee = Receipt::with('payment_list')
                                        ->whereHas('invoice', function ($q) {
                                            $q->where('ref_status_id', '!=', 5);
                                        })
                                        ->whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->where('ref_type_id', 1)
                                        ->get()
                                        ->sum(function ($receipt) {
                                            return $receipt->total_amount; // <-- ใช้ accessor ได้ที่นี่
                                        });

        $all_receipt_last_month = Receipt::with('payment_list')
                                        ->whereHas('invoice', function ($q) use ($lastMonth) {
                                            $q->where('year', $lastMonth->year)
                                                ->where('month', $lastMonth->month);
                                        })
                                        ->whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->where('ref_type_id', 1)
                                        ->get()
                                        ->sum(function ($receipt) {
                                            return $receipt->total_amount; // <-- ใช้ accessor ได้ที่นี่
                                        });

        $confirm_by_ceo = Receipt::with('payment_list')->whereHas('invoice', function ($q) {
                                            $q->where('ref_status_id', 5);
                                        })
                                        ->whereHas('room.floor.building', function ($query) use ($branch_id) {
                                            $query->where('ref_branch_id', $branch_id);
                                        })
                                        ->where('ref_type_id', 1)->get()->sum('total_amount');

        $confirm_by_ceo_this_month = RentBill::with('payment_list')->where('month', explode('-', date('m-Y'))[0])           //
                                                ->where('year', explode('-', date('m-Y'))[1])->where('ref_status_id', 5)      //
                                                ->where('ref_type_id', 1)->get()->sum('total_amount');

        $all_rent_bill_last_month = RentBill::with('payment_list')->where('month', explode('-', date('m-Y'))[0])            //
                                                ->whereHas('room_for_rent.room.floor.building', function ($query) use ($branch_id) {
                                                    $query->where('ref_branch_id', $branch_id);
                                                })
                                                ->whereIn('ref_status_id', [2,4,5,7])
                                                ->where('year', explode('-', date('m-Y'))[1])       //
                                                ->where('ref_type_id', 1)->get()->sum('total_amount');
                            // ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            // ->where('rent_bills.ref_status_id', 5)->sum(DB::raw('rent_bills.electricity_amount + rent_bills.water_amount + rooms.rent'));
        
        $cash = Receipt::with('payment_list')
                        ->whereHas('room.floor.building', function ($query) use ($branch_id) {
                            $query->where('ref_branch_id', $branch_id);
                        })
                        ->where('ref_type_id', 1)
                        ->where('payment_channel', 1)
                        ->get()
                        ->sum(function ($receipt) {
                            return $receipt->total_amount; // <-- ใช้ accessor ได้ที่นี่
                        });
        
        $transfer = Receipt::with('payment_list')
                            ->whereHas('room.floor.building', function ($query) use ($branch_id) {
                                $query->where('ref_branch_id', $branch_id);
                            })
                            ->where('ref_type_id', 1)
                            ->where('payment_channel', 2)
                            ->get()
                            ->sum(function ($receipt) {
                                return $receipt->total_amount; // <-- ใช้ accessor ได้ที่นี่
                            });

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
        
        $all_booking_rented = Room::whereHas('floor.building', function ($query) use ($branch_id) {
                                        $query->where('ref_branch_id', $branch_id);
                                    })
                                    ->where('rooms.status', 2)->count();

                                    
        $all_booking_room = Room::whereHas('floor.building', function ($query) use ($branch_id) {
                                        $query->where('ref_branch_id', $branch_id);
                                    })
                                    ->where('rooms.status', 1)->count();


        $all_room = Room::join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->where('buildings.ref_branch_id', $branch_id)->count();

        $vacant_room = Room::whereHas('floor.building', function ($query) use ($branch_id) {
                                $query->where('ref_branch_id', $branch_id);
                            })
                            ->where('status', 0)->count();
// บิลค่าเช่าทั้งหมด
        $all_overdue = RentBill::join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', $branch_id)
                                ->whereIn('rent_bills.ref_status_id', [2, 4, 7])
                                ->distinct()
                                ->count('rooms.id'); // ✅ ใช้ count กับคอลัมน์ตรง ๆ
// บิลค่าเช่าทั้งหมด

// บิลค่าเช่าค้างชำระทั้งหมด               
        $overdueData = RentBill::with('receipt.payment_list_not_fine', 'room_for_rent.room')
                                ->whereHas('room_for_rent.room.floor.building', function ($query) use ($branch_id) {
                                    $query->where('ref_branch_id', $branch_id);
                                })
                                ->whereIn('ref_status_id', [2, 4, 7])
                                ->get()
                                ->filter(function ($bill) {
                                    $paidAmount = $bill->receipt->flatMap->payment_list_not_fine->sum('price');
                                    return $paidAmount < $bill->total_amount;
                                });

        // นับจำนวนห้องไม่ซ้ำ
        $overdueRoomCount = $overdueData->pluck('room_for_rent.room.id')->unique()->count();

        // รวมยอดค้างชำระทั้งหมด
        $overdueTotalAmount = $overdueData->sum(function ($bill) {
            $paidAmount = $bill->receipt->flatMap->payment_list_not_fine->sum('price');
            return $bill->total_amount - $paidAmount;
        });
// บิลค่าเช่าค้างชำระทั้งหมด               

        $data['percent'] = 0; // อัตราเข้าพัก
        if ($all_room > 0) {
            $data['percent'] = number_format((100/$all_room)*$all_booking_rented, 2); // อัตราเข้าพัก
        }
        
        $data['all_receipt'] = number_format($all_receipt); // ยอดชำระเงินทั้งหมด
        $data['all_receipt_fine'] = number_format($all_receipt_fine); // ยอดชำระเงิน ค่าปรับ ทั้งหมด
        $data['all_receipt_not_fine'] = number_format($all_receipt_not_fine); // ยอดชำระเงิน ทั้งหมด ไม่รวม ค่าปรับ
        $data['all_invoice'] = number_format($all_invoice); // ยอดเรียกเก็บเงินทั้งหมด
        $data['outstanding_balance'] = number_format($all_invoice - $all_receipt_not_fine); // ยอดค้างชำระทั้งหมด
        $data['all_receipt_last_month'] = number_format($all_receipt_last_month);
        $data['confirm_by_employee'] = number_format($confirm_by_employee,2).' บาท'; // ชำระเงินโดยพนักงาน
        $data['confirm_by_ceo'] = number_format($confirm_by_ceo,2).' บาท'; // ชำระเงินโดยผู้บริหาร
        $data['confirm_by_ceo_this_month'] = number_format($confirm_by_ceo_this_month); // ชำระเงินโดยผู้บริหาร
        $data['all_rent_bill_last_month'] = number_format($all_rent_bill_last_month); // ชำระเงินโดยผู้บริหาร
        $data['overdue_this_month'] = number_format($all_rent_bill_last_month-$all_receipt_last_month); // ชำระเงินโดยผู้บริหาร
        $data['confirm_by_employee_confirm_by_ceo'] = number_format($confirm_by_employee + $confirm_by_ceo,2).' บาท'; // ชำระเงินหลังคอนเฟิร์ม
        $data['transfer'] = number_format($transfer,2).' บาท'; // เงินโอน
        $data['cash'] = number_format($cash,2).' บาท'; // เงินสด

        $data['all_renter_for_room'] = $all_renter_for_room; // จำนวนห้องไม่ว่าง
        $data['all_renter'] = $all_renter; // ผู้เช่า
        $data['all_booking_room'] = $all_booking_room; // ห้องจอง
        $data['all_overdue'] = $all_overdue; // ห้องค้างชำระ
        $data['overdueRoomCount'] = $overdueRoomCount; // จำนวนห้องค้างชำระ
        $data['overdueTotalAmount'] = $overdueTotalAmount; // รวมยอดค้างชำระทั้งหมด
        $data['vacant_room'] = $vacant_room; // ห้องว่าง
        $data['all_receipt_on_time'] = $all_receipt_on_time; // ห้องว่าง
        $data['all_receipt_late_with_appointment'] = $all_receipt_late_with_appointment; // ห้องว่าง
        $data['all_receipt_late'] = $all_receipt_late; // ห้องว่าง
        return $data;
    }
    
    public function summary_calculate()
    {
        $income = IncomeExpenses::with('receipt_payment_list')->where('ref_branch_id', session("branch_id"))->where('type', 1)->get()
                                    ->sum(function ($item) {
                                        return $item->getTotalFromPaymentList();
                                    });
        $expenses = IncomeExpenses::where('type', 2)->where('ref_branch_id', session("branch_id"))->sum('amount');
        $data['income'] = $income;
        $data['expenses'] = $expenses;
        $data['total'] = $income-$expenses;
        return $data;
    }
}
