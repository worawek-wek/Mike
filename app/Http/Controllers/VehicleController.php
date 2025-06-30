<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
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
                            ->join('renters', 'vehicles.ref_renter_id', '=', 'renters.id')
                            ->join('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->join('vehicle_types', 'vehicles.ref_type_id', '=', 'vehicle_types.id')
                            ->where('buildings.ref_branch_id', session("branch_id"))
                            ->whereIn('rooms.status', [1,2])
                            ->groupBy('vehicles.id')
                            ->selectRaw('vehicles.id, MAX(vehicles.created_at) as created_at, MAX(vehicles.car_registration) as car_registration, MAX(vehicles.detail) as detail, MAX(vehicles.remark) as remark, MAX(vehicles.ref_renter_id) as ref_renter_id, MAX(renters.prefix) as prefix, MAX(CONCAT(renters.name, " ", COALESCE(renters.surname, ""))) as renter_name, MAX(rooms.name) as room_name, MAX(vehicle_types.name) as type_name ');

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


        return view('vehicle/current-table', $data);
    }
    public function old_datatable(Request $request)
    {
        $results = Vehicle::orderBy('vehicles.id','DESC')
                            ->join('renters', 'vehicles.ref_renter_id', '=', 'renters.id')
                            ->join('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->join('vehicle_types', 'vehicles.ref_type_id', '=', 'vehicle_types.id')
                            ->where('buildings.ref_branch_id', session("branch_id"))
                            ->where('rooms.status', 0)
                            ->groupBy('vehicles.id')
                            ->selectRaw('vehicles.id, MAX(vehicles.created_at) as created_at, MAX(vehicles.car_registration) as car_registration, MAX(vehicles.detail) as detail, MAX(vehicles.remark) as remark, MAX(vehicles.ref_renter_id) as ref_renter_id, MAX(renters.prefix) as prefix, MAX(CONCAT(renters.name, " ", COALESCE(renters.surname, ""))) as renter_name, MAX(rooms.name) as room_name, MAX(vehicle_types.name) as type_name ');

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
        // ตัวอย่างข้อมูล
        $results = Vehicle::orderBy('vehicles.id','DESC')
                            ->join('renters', 'vehicles.ref_renter_id', '=', 'renters.id')
                            ->join('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->join('vehicle_types', 'vehicles.ref_type_id', '=', 'vehicle_types.id')
                            ->where('buildings.ref_branch_id', session("branch_id"))
                            ->groupBy('vehicles.id')
                            ->selectRaw('vehicles.id, MAX(vehicles.created_at) as created_at, MAX(vehicles.car_registration) as car_registration, MAX(vehicles.detail) as detail, MAX(vehicles.remark) as remark, MAX(vehicles.ref_renter_id) as ref_renter_id, MAX(renters.prefix) as prefix, MAX(CONCAT(renters.name, " ", COALESCE(renters.surname, ""))) as renter_name, MAX(rooms.name) as room_name, MAX(vehicle_types.name) as type_name ')
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
                        $row->room_name,
                        $row->renter_name,
                        $row->type_name,
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
                            ->join('renters', 'vehicles.ref_renter_id', '=', 'renters.id')
                            ->join('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                            ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                            ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                            ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                            ->join('vehicle_types', 'vehicles.ref_type_id', '=', 'vehicle_types.id')
                            ->where('buildings.ref_branch_id', session("branch_id"))
                            ->groupBy('vehicles.id')
                            ->selectRaw('vehicles.id, MAX(vehicles.created_at) as created_at, MAX(vehicles.car_registration) as car_registration, MAX(vehicles.detail) as detail, MAX(vehicles.remark) as remark, MAX(vehicles.ref_renter_id) as ref_renter_id, MAX(renters.prefix) as prefix, MAX(CONCAT(renters.name, " ", COALESCE(renters.surname, ""))) as renter_name, MAX(rooms.name) as room_name, MAX(vehicle_types.name) as type_name ')
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
                        $row->room_name,
                        $row->renter_name,
                        $row->type_name,
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
