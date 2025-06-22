<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Position;
use App\Models\Branch;
use App\Models\RentBill;
use App\Models\Receipt;
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

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $data['page_url'] = 'audit';

        return view('audit/index', $data);
    }
    public function invoice_datatable(Request $request)
    {
        $results = RentBill::orderBy('rent_bills.id','DESC')
                                ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                // ->where('rent_bills.ref_status_id', '!=', 3)
                                ->distinct('rent_bills.id')
                                ->select('rent_bills.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
        
        if(@$request->search){
            $results = $results->Where(function ($query) use ($request) {
                                    $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', renters.surname) LIKE ?", ["%{$request->search}%"])
                                        ->orWhere('rooms.name','LIKE','%'.$request->search.'%')
                                        ->orWhere('rent_bills.invoice_number','LIKE','%'.$request->search.'%');
                                });
        }
        if(@$request->ref_status_id != "all"){
            $results = $results->Where('rent_bills.ref_status_id', $request->ref_status_id);
        }
        if(@$request->ref_type_id != "all"){
            $results = $results->Where('rent_bills.ref_type_id', $request->ref_type_id);
        }
        if(@$request->month_from){

            $monthFrom = $request->month_from; // format: YYYY-MM
            $monthTo = $request->month_to;     // format: YYYY-MM

            // สร้างช่วงวันที่เต็ม (เริ่มต้นเดือน ถึง สิ้นเดือน)
            $startDate = Carbon::parse($monthFrom)->startOfMonth()->toDateString(); // 2025-06-01
            $endDate = Carbon::parse($monthTo)->endOfMonth()->toDateString();       // 2025-06-30

            $results = $results->whereBetween('rent_bills.created_at', [$startDate, $endDate]);
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


        return view('audit/invoice-table', $data);
    }
    public function receipt_datatable(Request $request)
    {
        $results = Receipt::orderBy('receipts.id','DESC')
                                // ->join('room_for_rents', 'receipts.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'receipts.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'receipts.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                // ->where('receipts.ref_status_id', '!=', 3)
                                ->distinct('receipts.id')
                                ->select('receipts.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
        
        if(@$request->search){
            $results = $results->Where(function ($query) use ($request) {
                                    $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', renters.surname) LIKE ?", ["%{$request->search}%"])
                                        ->orWhere('rooms.name','LIKE','%'.$request->search.'%')
                                        ->orWhere('receipts.receipt_number','LIKE','%'.$request->search.'%');
                                });
        }
        // if(@$request->ref_status_id != "all"){
        //     $results = $results->Where('receipts.ref_status_id', $request->ref_status_id);
        // }
        if(@$request->ref_type_id != "all"){
            $results = $results->Where('receipts.ref_type_id', $request->ref_type_id);
        }
        if(@$request->month_from){
            
            $monthFrom = $request->month_from; // format: YYYY-MM
            $monthTo = $request->month_to;     // format: YYYY-MM

            // สร้างช่วงวันที่เต็ม (เริ่มต้นเดือน ถึง สิ้นเดือน)
            $startDate = Carbon::parse($monthFrom)->startOfMonth()->toDateString(); // 2025-06-01
            $endDate = Carbon::parse($monthTo)->endOfMonth()->toDateString();       // 2025-06-30

            $results = $results->whereBetween('receipts.created_at', [$startDate, $endDate]);
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


        return view('audit/receipt-table', $data);
    }
    public function invoice_export_excel(Request $request)
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
                                ->distinct('rent_bills.id')
                                ->select('rent_bills.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
        
            $monthFrom = $request->month_from; // format: YYYY-MM
            $monthTo = $request->month_to;     // format: YYYY-MM

            // สร้างช่วงวันที่เต็ม (เริ่มต้นเดือน ถึง สิ้นเดือน)
            $startDate = Carbon::parse($monthFrom)->startOfMonth()->toDateString(); // 2025-06-01
            $endDate = Carbon::parse($monthTo)->endOfMonth()->toDateString();       // 2025-06-30

            $results = $results->whereBetween('rent_bills.created_at', [$startDate, $endDate])
                                ->get();

        $branch = Branch::find(session("branch_id"));
        $type = [ 3 => "ค่าจองห้อง", 2 => "ค่าเงินประกันห้อง", 1 => "ค่าเช่ารายเดือน"];

        $data = 
        [
            [
                'ข้อมูลยานพาหนะ '.$branch->name
            ],
            [
                'รายงานใบแจ้งหนี้ วันที่ '.date('d/m/Y',strtotime($startDate)).' - '.date('d/m/Y',strtotime($endDate))
            ],
            [

            ],
            [
                "วันที่",
                "เลขที่เอกสาร",
                "ประเภท",
                "ห้อง",
                "ชื่อลูกค้า",
                "รวม",
                "ภาษีมูลค่าเพิ่ม",
                "รวมสุทธิ",
                "สถานะ"
            ]
        ];
        // return $data;
        foreach($results as $row){
            
            if (count(@$row->receipt) > 0 & $row->ref_status_id == 3){
                $status = "ค้างชำระ";
            }else{

                    $status = $row->status->name;
            }

            $data[] = [
                        date('d/m/Y', strtotime($row->created_at)),
                        $row->invoice_number,
                        $type[$row->ref_type_id],
                        $row->room_name,
                        $row->prefix.' '.$row->renter_name,
                        number_format($row->total_amount),
                        0,
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
        $writer->save("upload/export_excel/รายงานใบแจ้งหนี้-เดือน-".date('d-m-Y',strtotime($startDate)).'-'.date('d-m-Y',strtotime($endDate)).".xlsx");
        return redirect("upload/export_excel/รายงานใบแจ้งหนี้-เดือน-".date('d-m-Y',strtotime($startDate)).'-'.date('d-m-Y',strtotime($endDate)).".xlsx");
    }
    public function receipt_export_excel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        $results = Receipt::orderBy('receipts.id','DESC')
                                // ->join('room_for_rents', 'receipts.ref_room_for_rent_id', '=', 'room_for_rents.id')
                                ->join('renters', 'receipts.ref_renter_id', '=', 'renters.id')
                                ->join('rooms', 'receipts.ref_room_id', '=', 'rooms.id')
                                ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
                                ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
                                ->where('buildings.ref_branch_id', session("branch_id"))
                                // ->where('receipts.ref_status_id', '!=', 3)
                                ->distinct('receipts.id')
                                ->select('receipts.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
        
        $monthFrom = $request->month_from; // format: YYYY-MM
        $monthTo = $request->month_to;     // format: YYYY-MM

        // สร้างช่วงวันที่เต็ม (เริ่มต้นเดือน ถึง สิ้นเดือน)
        $startDate = Carbon::parse($monthFrom)->startOfMonth()->toDateString(); // 2025-06-01
        $endDate = Carbon::parse($monthTo)->endOfMonth()->toDateString();       // 2025-06-30

        $results = $results->whereBetween('receipts.created_at', [$startDate, $endDate])
                                ->get();

        $branch = Branch::find(session("branch_id"));
        $type = [ 3 => "ค่าจองห้อง", 2 => "ค่าเงินประกันห้อง", 1 => "ค่าเช่ารายเดือน"];

        $data = 
        [
            [
                'ข้อมูลยานพาหนะ '.$branch->name
            ],
            [
                'รายงานใบเสร็จรับเงิน วันที่ '.date('d/m/Y',strtotime($startDate)).' - '.date('d/m/Y',strtotime($endDate))
            ],
            [

            ],
            [
                "วันที่",
                "เลขที่เอกสาร",
                "ประเภท",
                "ห้อง",
                "ชื่อลูกค้า",
                "รวม",
                "ภาษีมูลค่าเพิ่ม",
                "รวมสุทธิ"
            ]
        ];
        // return $data;
        foreach($results as $row){

            $data[] = [
                        date('d/m/Y', strtotime($row->created_at)),
                        $row->receipt_number,
                        $type[$row->ref_type_id],
                        $row->room_name,
                        $row->prefix.' '.$row->renter_name,
                        number_format($row->total_amount),
                        0,
                        number_format($row->total_amount)
                        
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
        $writer->save("upload/export_excel/รายงานใบเสร็จรับเงิน-เดือน-".date('d-m-Y',strtotime($startDate)).'-'.date('d-m-Y',strtotime($endDate)).".xlsx");
        return redirect("upload/export_excel/รายงานใบเสร็จรับเงิน-เดือน-".date('d-m-Y',strtotime($startDate)).'-'.date('d-m-Y',strtotime($endDate)).".xlsx");
    }
}
