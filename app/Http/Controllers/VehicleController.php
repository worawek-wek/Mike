<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Room;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\Branch;
use App\Models\Work_shift;
use App\Models\Schedule;
use App\Models\Leave;
use App\Models\UserLeave;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Carbon\Carbon;

DB::beginTransaction();

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $data['type'] = VehicleType::get();
        $data['page_url'] = 'vehicle';

        return view('vehicle/index', $data);
    }
    public function current_datatable(Request $request)
    {
        $results = Vehicle::orderBy('vehicles.id','DESC')
                            ->join('vehicle_types', 'vehicles.ref_type_id', '=', 'vehicle_types.id')
                            ->whereHas('renter.room_for_rent.room.floor.building', function ($query) {
                                $query->where('ref_branch_id', session("branch_id"));
                            })
                            ->whereHas('room_for_rent.room', function ($query) {
                                $query->whereIn('rooms.status', [2]);
                            })
                            ->whereHas('room_for_rent', function ($query) {
                                $query->whereIn('status', [1]);
                            })
                            ->select('vehicles.*','vehicle_types.name');

        if (@$request->car_registration) {
            $results = $results->where('vehicles.car_registration', 'LIKE', '%' . $request->car_registration . '%');
        }
        if (@$request->room) {
            $results = $results->whereHas('renter.room_for_rent.room', function ($query) use ($request) {
                                $query->where('name', 'LIKE', '%' . $request->room . '%');
                                // $query->whereIn('status', [2]);
                            });
        }
        if (@$request->ref_type_id != "all") {
            $results = $results->where('vehicles.ref_type_id', $request->ref_type_id);
        }

        $limit = $request['limit'] ?? 15;
        $results = $results->paginate($limit);


        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;
        
        if(@$request->re){
            return $data['list_data'];
        }


        return view('vehicle/current-table', $data);
    }
    public function old_datatable(Request $request)
    {
        $results = Vehicle::orderBy('vehicles.id','DESC')
                            ->join('vehicle_types', 'vehicles.ref_type_id', '=', 'vehicle_types.id')
                            ->whereHas('renter.room_for_rent.room.floor.building', function ($query) {
                                $query->where('ref_branch_id', session("branch_id"));
                            })
                            ->whereHas('room_for_rent', function ($query) {
                                $query->whereIn('status', [0]);
                                // $query->whereIn('status', [2]);
                            });
                            // ->whereHas('renter.room_for_rent.room', function ($query) {
                            //     $query->whereIn('rooms.status', [0]);
                            // });

        if (@$request->car_registration) {
            $results = $results->where('vehicles.car_registration', 'LIKE', '%' . $request->car_registration . '%');
        }
        if (@$request->room) {
            $results = $results->where('rooms.name', 'LIKE', '%' . $request->room . '%');
        }
        if (@$request->ref_type_id != "all") {
            $results = $results->where('vehicles.ref_type_id', $request->ref_type_id);
        }

        $limit = $request['limit'] ?? 15;
        $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;
        
        if(@$request->re){
            return $data['list_data'];
        }

        return view('vehicle/old-table', $data);
    }
    public function current_export_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $branch = Branch::find(session("branch_id"));

        $results = Vehicle::orderBy('vehicles.id','DESC')
                            ->join('vehicle_types', 'vehicles.ref_type_id', '=', 'vehicle_types.id')
                            ->whereHas('renter.room_for_rent.room.floor.building', function ($query) {
                                $query->where('ref_branch_id', session("branch_id"));
                            })
                            ->whereHas('room_for_rent.room', function ($query) {
                                $query->whereIn('rooms.status', [2]);
                            })
                            ->whereHas('room_for_rent', function ($query) {
                                $query->whereIn('status', [1]);
                            })->get();
        // หัวตาราง
        $sheet->fromArray([
            [ 'ข้อมูลยานพาหนะ ' . session('branch_name') ], // แถวแรก เป็นชื่อสาขา
            [], // แถวว่าง
            [ "วันที่เพิ่มข้อมูล", "เลขห้อง", "ผู้เช่า", "ประเภทรถ", "ทะเบียนรถ", "รายละเอียดรถ", "หมายเหตุ" ] // แถวหัวคอลัมน์
        ], null, 'A1');

        $rowNum = 4; // เริ่มเขียนข้อมูลแถวที่ 4

        foreach ($results as $room) {
            // return $room;
            // return $room;
            foreach ($room->room->room_for_rent_s as $rentData) {
                $renter = $rentData->renter;
                $renterName = $renter->prefix . ' ' . $renter->name . ' ' . $renter->surname;
                $vehicles = $renter->vehicles ?? [];

                if (!empty($vehicles)) {
                    foreach ($vehicles as $vehicle) {
                        $sheet->fromArray([
                            $rentData->created_at->format('d/m/Y'), // วันที่เพิ่มข้อมูล
                            $room->room->name,                             // เลขห้อง
                            $renterName,                             // ผู้เช่า
                            $room->type->name,                   // ประเภทรถ
                            $vehicle->car_registration,             // ทะเบียนรถ
                            $vehicle->detail,                        // รายละเอียดรถ
                            $vehicle->remark                         // หมายเหตุ
                        ], null, 'A' . $rowNum);
                        $rowNum++;
                    }
                } else {
                    // ถ้าไม่มีรถ
                    $sheet->fromArray([
                        $rentData->created_at->format('Y-m-d'),
                        $room->name,
                        $renterName,
                        '',
                        '',
                        '',
                        ''
                    ], null, 'A' . $rowNum);
                    $rowNum++;
                }
            }
        }

        // บันทึกไฟล์
        $writer = new WriterXlsx($spreadsheet);
        $writer->save("upload/export_excel/ข้อมูลยานพาหนะ-$branch->name".date('m-Y', strtotime('-1 month')).".xlsx");
        return redirect("upload/export_excel/ข้อมูลยานพาหนะ-$branch->name".date('m-Y', strtotime('-1 month')).".xlsx");
        // ตัวอย่างข้อมูล
        
        return $results = Room::whereIn('status', [2])
                        ->whereHas('room_for_rent_s.renter.vehicles')->with('room_for_rent_s.renter.vehicles')->orderBy('id', 'DESC')
                        ->whereHas('floor.building', function ($query) {
                            $query->where('ref_branch_id', session("branch_id"));
                        })
                        ->get();

        $branch = Branch::find(session("branch_id"));

        $data = 
        [
            [
                'ข้อมูลยานพาหนะ '.$branch->name
            ],
            [

            ],
            [
                "วันที่เพิ่มข้อมูล",
                "เลขห้อง",
                "ผู้เช่า",
                "ประเภทรถ",
                "ทะเบียนรถ",
                "รายละเอียดรถ",
                "หมายเหตุ"
            ]
        ];
        // return $data;
        foreach($results as $row){
            $data[] = [
                        date('d/m/Y',strtotime($row->created_at)),
                        $row->renter->room_for_rent->room->name,
                        $row->renter->prefix.' '.$row->renter->name.' '.$row->renter->surname,
                        $row->type->name,
                        $row->car_registration,
                        $row->detail,
                        $row->remark
                        
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
        $writer->save("upload/export_excel/ข้อมูลยานพาหนะ-$branch->name".date('m-Y', strtotime('-1 month')).".xlsx");
        return redirect("upload/export_excel/ข้อมูลยานพาหนะ-$branch->name".date('m-Y', strtotime('-1 month')).".xlsx");
    }
    public function old_export_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        
        $results = Vehicle::orderBy('vehicles.id','DESC')
                            ->join('vehicle_types', 'vehicles.ref_type_id', '=', 'vehicle_types.id')
                            ->whereHas('renter.room_for_rent.room.floor.building', function ($query) {
                                $query->where('ref_branch_id', session("branch_id"));
                            })
                            ->whereHas('room_for_rent', function ($query) {
                                $query->whereIn('status', [0]);
                                // $query->whereIn('status', [2]);
                            })->get();

        $branch = Branch::find(session("branch_id"));

        $data = 
        [
            [
                'ข้อมูลยานพาหนะ '.$branch->name
            ],
            [

            ],
            [
                "วันที่เพิ่มข้อมูล",
                "เลขห้อง",
                "ผู้เช่า",
                "ประเภทรถ",
                "ทะเบียนรถ",
                "รายละเอียดรถ",
                "หมายเหตุ"
            ]
        ];
        // return $data;
        foreach($results as $row){
            $data[] = [
                        date('d/m/Y',strtotime($row->created_at)),
                        $row->renter->room_for_rent->room->name,
                        $row->renter->prefix.' '.$row->renter->name.' '.$row->renter->surname,
                        $row->type->name,
                        $row->car_registration,
                        $row->detail,
                        $row->remark
                        
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
        $writer->save("upload/export_excel/ข้อมูลยานพาหนะ-$branch->name".date('m-Y', strtotime('-1 month')).".xlsx");
        return redirect("upload/export_excel/ข้อมูลยานพาหนะ-$branch->name".date('m-Y', strtotime('-1 month')).".xlsx");
    }
}
