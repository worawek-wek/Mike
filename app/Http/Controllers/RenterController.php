<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Room;
use App\Models\Position;
use App\Models\Branch;
use App\Models\Renter;
use App\Models\RoomForRents;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Carbon\Carbon;

DB::beginTransaction();

class RenterController extends Controller
{
    public function index(Request $request)
    {
        $data['page_url'] = 'renter';
        $data['page_url2'] = 'renter/current';
        $data['page_url3'] = 'renter/old';
        return view('renter/index', $data);
    }
    public function current_datatable(Request $request)
    {
        $results = Renter::join('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->where('renters.ref_branch_id', session("branch_id"))
                            ->whereIn('rooms.status', [1,2]);
                            // ->whereHas('room_for_rent.room', function ($query) {
                            //     $query->whereIn('status', [1,2]);
                            // });
        if(@$request->search){

            if(@$request->search_type == 1){ // ชื่อ - นามสกุล
                $results = $results->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', COALESCE(renters.surname, '')) LIKE ?", ["%{$request->search}%"]);
            }
            if(@$request->search_type == 2){ // เบอร์โทรศัพท์
                $results = $results->where('renters.phone','LIKE','%'.$request->search.'%');
            }
            if(@$request->search_type == 3){ // ตามห้อง
                $results = $results->WhereHas('room_for_rent.room', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });
            }
            if(@$request->search_type == 4){ // ค้นหาตามทะเบียนรถ
                $results = $results->WhereHas('vehicle', function ($q) use ($request) {
                    $q->where('car_registration', 'LIKE', '%' . $request->search . '%');
                });
            }
            if(@$request->search_type == ''){
                $results = $results->where(function ($query) use ($request) {
                    $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', COALESCE(renters.surname, '')) LIKE ?", ["%{$request->search}%"])
                        ->orWhere('renters.phone','LIKE','%'.$request->search.'%')
                        ->orWhereHas('room_for_rent.room', function ($q) use ($request) {
                            $q->where('name', 'LIKE', '%' . $request->search . '%');
                        })
                        ->orWhereHas('vehicle', function ($q) use ($request) {
                            $q->where('car_registration', 'LIKE', '%' . $request->search . '%');
                        });
                });
            }
            
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
        return view('renter/current-table', $data);
    }
    public function old_datatable(Request $request)
    {
        $results = Renter::join('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->where('renters.ref_branch_id', session("branch_id"))
                            ->whereHas('room_for_rent.room', function ($query) {
                                $query->whereIn('status', [0]);
                            });
        if(@$request->search){

            if(@$request->search_type == 1){ // ชื่อ - นามสกุล
                $results = $results->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', COALESCE(renters.surname, '')) LIKE ?", ["%{$request->search}%"]);
            }
            if(@$request->search_type == 2){ // เบอร์โทรศัพท์
                $results = $results->where('renters.phone','LIKE','%'.$request->search.'%');
            }
            if(@$request->search_type == 3){ // ตามห้อง
                $results = $results->WhereHas('room_for_rent.room', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });
            }
            if(@$request->search_type == 4){ // ค้นหาตามทะเบียนรถ
                $results = $results->WhereHas('vehicle', function ($q) use ($request) {
                    $q->where('car_registration', 'LIKE', '%' . $request->search . '%');
                });
            }
            
            if(@$request->search_type == ''){
                $results = $results->where(function ($query) use ($request) {
                    $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', COALESCE(renters.surname, '')) LIKE ?", ["%{$request->search}%"])
                        ->orWhere('renters.phone','LIKE','%'.$request->search.'%')
                        ->orWhereHas('room_for_rent.room', function ($q) use ($request) {
                            $q->where('name', 'LIKE', '%' . $request->search . '%');
                        })
                        ->orWhereHas('vehicle', function ($q) use ($request) {
                            $q->where('car_registration', 'LIKE', '%' . $request->search . '%');
                        });
                });
            }
            
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
        
        // if(@$request->re){
        //     return $data['list_data'];
        // }


        return view('renter/old-table', $data);
    }

    public function exportExcel($status = null)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        $results = Renter::where('renters.ref_branch_id', session("branch_id"))
                           ->whereHas('room_for_rent.room', function ($query) use ($status) {
                                $query->whereIn('status', explode(',', $status));
                            })->get();
        $data = 
        [
            ['ข้อมูลผู้เช่าปัจจุบัน'],
            [
                'ข้อมูลผู้เช่าปัจจุบัน วันที่ '.date('d/m/Y')
            ],
            [
                "ลำดับ",
                "ชื่อผู้เช่า",
                "ห้อง",
                "เบอร์ติดต่อ",
                "ยานพาหนะ",
                "วันที่เข้าพัก",
                "วันสิ้นสุดสัญญาเช่า",
                "อายุสัญญา"
            ]
        ];
        foreach($results as $key=>$row){
             if(@$row->room_for_rent->room->contract->contract_date){
                    $contractDate = $row->room_for_rent->room->contract->contract_date;
                    $contract_date_text = date('d/m/Y', strtotime($contractDate));
                    $period = $row->room_for_rent->room->contract->period;
                    $endDate = null;

                    if ($contractDate && $period) {
                        $endDate = date('d/m/Y', strtotime("+{$period} months", strtotime($contractDate)));
                    }

                    $endDate ?? '-';
            }else{
                    $endDate ?? '-';
                    $contract_date_text = '-';
            }
            $data[] = [
                        $key+1,
                        $row->prefix.' '.$row->name.' '.$row->surname,
                        $row->room_for_rent->room->name,
                        $row->phone,
                        @$row->vehicle->car_registration ?? '-',
                        $contract_date_text,
                        $endDate,
                        $row->room_for_rent->room->contract->period ?? '-',

                        
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
        $writer->save("upload/export_excel/ข้อมูลผู้ใช้งาน".date('m-Y', strtotime('-1 month')).".xlsx");
        return redirect("upload/export_excel/ข้อมูลผู้ใช้งาน".date('m-Y', strtotime('-1 month')).".xlsx");
    }
    
    public function destroy($renter_id, $room_id)
    {
        try{
            // $RoomForRents = RoomForRents::get();
            // foreach ($RoomForRents as $RoomFor) {
            //     $renter = Renter::find($RoomFor->ref_renter_id);
            //     if (!$renter) {
            //         RoomForRents::destroy($RoomFor->id);
            //     }
            // }
            // DB::commit();
            // return 1;

            Renter::destroy($renter_id);
            RoomForRents::where('ref_renter_id',$renter_id)->where('ref_room_id', $room_id)->delete();
            Vehicle::where('ref_renter_id', $renter_id)->delete();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
}
