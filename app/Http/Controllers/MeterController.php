<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Room;
use App\Models\Branch;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Leave;
use App\Models\Meter;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Carbon\Carbon;

DB::beginTransaction();

class MeterController extends Controller
{
    public function index(Request $request)
    {
        
        // DB::table('rooms')
        //     ->where('name', 'like', '1%')
        //     ->whereIn('ref_floor_id', [95,96,97,98,99,100,101,102,103])
        //     ->update([
        //         'name' => DB::raw('CONCAT("A", SUBSTRING(name, 2))')
        //     ]);
        // DB::table('rooms')
        //     ->where('name', 'like', '2%')
        //     ->whereIn('ref_floor_id', [95,96,97,98,99,100,101,102,103])
        //     ->update([
        //         'name' => DB::raw('CONCAT("B", SUBSTRING(name, 2))')
        //     ]);
        //     DB::commit();
            // return 1;
        // $response = Http::get('http://100.74.37.42:7953/getRealTimeData.aspx'); // ตำหรุ
        // $response = Http::get('http://100.111.169.37:7953/getRealTimeData.aspx'); // บางปลา
        // $response = Http::get('http://100.79.137.14:7953/getRealTimeData.aspx'); // แพรกษา

        // $response = Http::post('http://kittinakornplace.com/api/update_meter', [$electricity]);
        
        // // ตรวจสอบผลลัพธ์จาก API response
        // if ($response->successful()) {
        //     return $data = $response->json(); // ถ้าผลลัพธ์เป็น JSON
        //     // หรือ $response->body() ถ้าอยากได้เป็น text
        // } else {
        //     // ถ้าการส่ง request ล้มเหลว
        //     return $response->status(); // แสดง status code
        // }
        $branch = Branch::where('ip_meter','!=','')->get();

        // /////////////////////////////////
        foreach($branch as $bra){
            // return $bra['ip_meter'];

            if(session("branch_id") != $bra['id']){
                continue;
            }
            
            $connection = @fsockopen($bra['ip_meter'], 7953, $errno, $errstr, 10); // 10 คือ timeout
            if (!is_resource($connection)) {
                continue;
            }
            $response = Http::get('http://'.$bra['ip_meter'].':7953/getRealTimeData.aspx'); // เจริญใจ

            $xmlString = $response->body();
            
            // แปลง XML เป็น SimpleXMLElement
            $xmlObject = simplexml_load_string($xmlString);

            // แปลง SimpleXMLElement เป็น array ถ้าต้องการ
            $json = json_encode($xmlObject);
            $array = json_decode($json, true);

            $electricity = $array['Meters']['Meter']; // ส่งกลับเป็น array

            $room = Room::whereHas('floor.building', function ($query) use ($bra) {
                                    $query->where('ref_branch_id', $bra['id']);
                                })->get();
            foreach($room as $ro){

                // filter ดึง ข้อมูล meter ห้องนี้
                $filtered = array_filter($electricity, function($item) use ($ro) {
                        // if ($ro->name[0] == '1') {
                        //     return $item['@attributes']['GroupName'] = 'A' . substr($ro->name, 1);
                        // } elseif ($ro->name[0] == '2') {
                        //     return $item['@attributes']['GroupName'] = 'B' . substr($ro->name, 1);
                        // }
                    return $item['@attributes']['GroupName'] == $ro->name;
                });
                $electricity_unit = 0;
                if (!empty($filtered)) {
                    $electricity_unit = reset($filtered)['Value'][0];
                }
                // filter ดึง ข้อมูล meter ห้องนี้ จบ

                $check = Meter::where('ref_room_id', $ro->id)->where('month', date('m'))->where('year', date('Y'))->first();

                if($check){
                    $meter = Meter::find($check->id); 					
                }else{
                    $meter = new Meter; 					
                    $meter->water_unit  =  0;
                }
                $meter->ref_room_id  =  $ro->id;
                $meter->month  =  date('m');
                $meter->year  =  date('Y');
                $meter->electricity_unit  =  $electricity_unit;
                $meter->save();
            }
            break;
        }
        DB::commit();
        // // 100.74.37.42
        
        // $meter = [
        //     ["A101",	"1232"],["A102",	"539"],["A103",	"1005"],["ห้องแม่บ้าน/รปภ",	"1233"],["ห้องแม่บ้าน/รปภ",	"2076"],
        //     ["A106",	"0"],["A107",	"0"],["A108",	"0"],["ORANGE ทดสอบเท่านั้น",	"0"],["A201",	"560"],["A202",	"695"],
        //     ["A203",	"849"],["A204",	"786"],["A205",	"351"],["A206",	"795"],["A207",	"418"],["A208",	"1175"],["A209",	"1305"],
        //     ["A210",	"2772"],["A211",	"578"],["A212",	"1283"],["A213",	"917"],["A214",	"769"],["A215",	"622"],["A301",	"623"],
        //     ["A302",	"740"],["A303",	"684"],["A304",	"577"],["A305",	"543"],["A306",	"369"],["A307",	"716"],["A308",	"1067"],
        //     ["A309",	"509"],["A310",	"659"],["A311",	"664"],["A312",	"815"],["A313",	"877"],["A314",	"563"],["A315",	"509"],
        //     ["A401",	"478"],["A402",	"748"],["A403",	"347"],["A404",	"656"],["A405",	"1037"],["A406",	"615"],["A407",	"821"],
        //     ["A408",	"0"],["A409",	"745"],["A410",	"662"],["A411",	"1273"],["A412",	"764"],["A413",	"1214"],["A414",	"796"],
        //     ["A415",	"507"],["A501",	"631"],["A502",	"467"],["A503",	"929"],["A504",	"282"],["A505",	"379"],["A506",	"657"],["A507",	"259"],
        //     ["A508",	"739"],["A509",	"624"],["A510",	"753"],["A511",	"646"],["A512",	"687"],["A513",	"525"],["A514",	"875"],["A515",	"468"],
        //     ["A601",	"193"],["A602",	"617"],["A603",	"438"],["A604",	"400"],["A605",	"391"],["A606",	"380"],["A607",	"508"],["A608",	"533"],
        //     ["A609",	"548"],["A610",	"1343"],["A611",	"690"],["A612",	"791"],["A613",	"545"],["A614",	"484"],["A615",	"830"],["A701",	"1004"],
        //     ["A702",	"0"],["A703",	"0"],["A704",	"401"],["A705",	"0"],["A706",	"363"],["A707",	"0"],["A708",	"401"],["A709",	"391"],
        //     ["A710",	"620"],["A711",	"565"],["A712",	"631"],["A713",	"623"],["A714",	"449"],["A715",	"780"],["A801",	"265"],["A802",	"675"],
        //     ["A803",	"0"],["A804",	"121"],["A805",	"0"],["A806",	"0"],["A807",	"92"],["A808",	"293"],["A809",	"1283"],["A810",	"306"],
        //     ["A811",	"135"],["A812",	"598"],["A813",	"564"],["A814",	"427"],["A815",	"477"],["B101",	"3488"],["B102",	"193"],["B103",	"117"],
        //     ["ฟิตเนส",	"0"],["B105",	"0"],["ออฟฟิศ",	"0"],["B107",	"0"],["B108",	"860"],["B201",	"1524"],["B202",	"376"],["B203",	"631"],
        //     ["B204",	"368"],["B205",	"856"],["B206",	"899"],["B207",	"875"],["B208",	"431"],["B209",	"508"],["B210",	"776"],["B211",	"557"],
        //     ["B212",	"451"],["B213",	"742"],["B214",	"704"],["B215",	"662"],["B301",	"994"],["B302",	"464"],["B303",	"846"],["B304",	"521"],
        //     ["B305",	"451"],["B306",	"452"],["B307",	"836"],["B308",	"0"],["B309",	"545"],["B310",	"593"],["B311",	"0"],["B312",	"1052"],
        //     ["B313",	"691"],["B314",	"788"],["B315",	"0"],["B401",	"572"],["B402",	"539"],["B403",	"444"],["B404",	"389"],["B405",	"529"],
        //     ["B406",	"582"],["B407",	"527"],["B408",	"501"],["B409",	"524"],["B410",	"505"],["B411",	"625"],["B412",	"538"],["B413",	"451"],
        //     ["B414",	"589"],["B415",	"620"],["B501",	"453"],["B502",	"645"],["B503",	"320"],["B504",	"569"],["B505",	"7"],["B506",	"699"],
        //     ["B507",	"444"],["B508",	"442"],["B509",	"480"],["B510",	"772"],["B511",	"321"],["B512",	"434"],["B513",	"594"],["B514",	"290"],
        //     ["B515",	"27"],["B601",	"271"],["B602",	"731"],["B603",	"631"],["B604",	"729"],["B605",	"441"],["B606",	"309"],["B607",	"543"],
        //     ["B608",	"806"],["B609",	"288"],["B610",	"589"],["B611",	"491"],["B612",	"615"],["B613",	"386"],["B614",	"846"],["B615",	"613"],
        //     ["B701",	"530"],["B702",	"221"],["B703",	"0"],["B704",	"28"],["B705",	"0"],["B706",	"284"],["B707",	"0"],["B708",	"507"],
        //     ["B709",	"634"],["B710",	"477"],["B711",	"0"],["ห้องพี่หมิว",	"1064"],["B713",	"1047"],["B714",	"877"],["B715",	"438"],["B801",	"474"],
        //     ["B802",	"124"],["B803",	"0"],["B804",	"321"],["B805",	"0"],["B806",	"369"],["B807",	"301"],["B808",	"494"],["B809",	"0"],
        //     ["B810",	"466"],["B811",	"464"],["B812",	"314"],["B813",	"626"],["B814",	"354"],["B815",	"1428"]
        // ];
        
        // $meter_array = [];
        // foreach($meter as $me){
        //     $room = Room::whereHas('floor.building', function ($query) {
        //             $query->where('ref_branch_id', session("branch_id"));
        //         })
        //         ->leftJoin('meters', 'meters.ref_room_id', '=', 'rooms.id')
        //         ->where('rooms.name', $me[0])
        //         ->where('meters.month', "5")
        //         ->where('meters.year', "2025")
        //         ->select('meters.id as meter_id')
        //         ->first();
        //         if(!$room){
        //             continue;
        //         }
        //         $meter_array[] = [
        //                 "id" => $room->meter_id,
        //                 "value" => $me[1]
        //         ];
        // }
        // // return ;
        // $meter = new Request([
        //     "meter" => $meter_array
        // ]);
        // // return $meter;

        // $this->water_unit_update($meter);

        $data['page_url'] = 'meter';
        $data['buildings'] = Building::where('ref_branch_id', session("branch_id"))->get();
        $data['floors'] = Floor::get();

        return view('meter/index', $data);
    }
    public function update_meter(Request $request)
    {
        $dataArray = $request->meter;

        $room = Room::whereHas('floor.building', function ($query) {
                                $query->where('ref_branch_id', 1);
                            })->get();
        foreach($room as $ro){

            // filter ดึง ข้อมูล meter ห้องนี้
            $filtered = array_filter($dataArray, function($item) use ($ro) {
                return $item['@attributes']['GroupName'] == $ro->name;
            });
            $electricity_unit = 0;
            if (!empty($filtered)) {
                $electricity_unit = reset($filtered)['Value'][0];
            }
            // filter ดึง ข้อมูล meter ห้องนี้ จบ

            $check = Meter::where('ref_room_id', $ro->id)->where('month', date('m'))->where('year', date('Y'))->first();

            if($check){
                $meter = Meter::find($check->id); 					
            }else{
                $meter = new Meter; 					
                $meter->water_unit  =  0;
            }
            $meter->ref_room_id  =  $ro->id;
            $meter->month  =  date('m');
            $meter->year  =  date('Y');
            $meter->electricity_unit  =  $electricity_unit;
            $meter->save();
        }
        DB::commit();
    }
    public function datatable($request)
    {
        $month = date('m');
        $year = date('Y');

        if($request->month){
            $month = explode('-', $request->month)[1];
            $year = explode('-', $request->month)[0];
        }

        //////// หา เดือนก่อนหน้า
        $year_month_previous = date('Y-m', strtotime($year.'-'.$month . ' -1 month'));
        // dd($year_month_previous);
        $month_previous = explode('-', $year_month_previous)[1];
        $year_previous = explode('-', $year_month_previous)[0];
        //////// หา เดือนก่อนหน้า จบ

        $results = Room::orderBy('rooms.name')
                        ->leftJoin('meters', 'meters.ref_room_id', '=', 'rooms.id')
                        ->leftJoin('floors', 'floors.id', '=', 'rooms.ref_floor_id')
                        ->leftJoin('buildings', 'buildings.id', '=', 'floors.ref_building_id')
                        ->Where('meters.month', $month)->Where('meters.year', $year)
                        ->where('ref_branch_id',session("branch_id"))
                        ->with([
                            // 'meterCurrent' => fn($q) => $q->where('month', $month)->where('year', $year),
                            'meterPrevious' => fn($q) => $q->where('month', $month_previous)->where('year', $year_previous),
                        ])
                        // ->WhereHas('room_for_rent', function ($query) {
                        //     $query->where('status', 0); // กรอง User ที่มี Position status = 'active'
                        // })
                        ->select('rooms.*', 'meters.water_unit', 'meters.electricity_unit', 'meters.id as meters_id');

        // if(@$request->search){
        // $results = $results->orWhere(function ($query) use ($request) {
        //             $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', COALESCE(renters.surname, '')) LIKE ?", ["%{$request->search}%"])
        //                 ->orWhere('rooms.name','LIKE','%'.$request->search.'%');
        //         });
        // }
        // if($request->building != "all"){
        // $results = $results->Where('room_for_rents.ref_building_id', $request->building);
        // }
        
        if ($request->building != "all") {
            // return 456;
            $results->whereHas('floor', function ($query) use ($request) {
                $query->where('ref_building_id', $request->building);
            });
        }
        if ($request->floor != "all") {
            // return 123;
            $results->where('rooms.ref_floor_id', $request->floor);
        }

        $limit = 15;
        if(@$request['limit']){
        $limit = $request['limit'];
        }
        $results = $results->paginate($limit);
        // return 123;

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;
        $data['search_month'] = $month;
        $data['search_year'] = $year;
        $data['month_previous'] = $month_previous;
        $data['year_previous'] = $year_previous;

        return $data;

    }
    public function electricity_datatable(Request $request)
    {
        $data = $this->datatable($request);
        
        return view('meter/electricity-table', $data);
    }
    public function water_datatable(Request $request)
    {
        $data = $this->datatable($request);

        return view('meter/water-table', $data);
    }
    public function water_unit_update(Request $request)
    {
        try{
            foreach($request->meter as $meter){
                $update = Meter::find($meter['id']);
                $update->water_unit  =  $meter['value'];
                $update->save();
            }
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    public function electricityExportExcel(Request $request)
    {
        $month = date('m');
        $year = date('Y');

        if($request->month){
            $month = explode('-', $request->month)[1];
            $year = explode('-', $request->month)[0];
        }

        //////// หา เดือนก่อนหน้า
        $year_month_previous = date('Y-m', strtotime($year.'-'.$month . ' -1 month'));
        // dd($year_month_previous);
        $month_previous = explode('-', $year_month_previous)[1];
        $year_previous = explode('-', $year_month_previous)[0];
        //////// หา เดือนก่อนหน้า จบ
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        $results = Room::orderBy('rooms.name')
                        ->leftJoin('meters', 'meters.ref_room_id', '=', 'rooms.id')
                        ->leftJoin('floors', 'floors.id', '=', 'rooms.ref_floor_id')
                        ->leftJoin('buildings', 'buildings.id', '=', 'floors.ref_building_id')
                        ->Where('meters.month', $month)->Where('meters.year', $year)
                        ->where('ref_branch_id',session("branch_id"))
                        ->with([
                            // 'meterCurrent' => fn($q) => $q->where('month', $month)->where('year', $year),
                            'meterPrevious' => fn($q) => $q->where('month', $month_previous)->where('year', $year_previous),
                            ])
                        // ->WhereHas('room_for_rent', function ($query) {
                        //     $query->where('status', 0); // กรอง User ที่มี Position status = 'active'
                        // })
                        ->select('rooms.*', 'floors.name as floor_name', 'rooms.name as room_name', 'meters.water_unit', 'meters.electricity_unit', 'meters.id as meters_id');
                        
                        
        if ($request->building != "all") {
            // return 456;
            $results->whereHas('floor', function ($query) use ($request) {
                $query->where('ref_building_id', $request->building);
            });
        }
        if ($request->floor != "all") {
            // return 123;
            $results->where('rooms.ref_floor_id', $request->floor);
        }

        $results = $results->get();
        $data = 
        [
            ['ข้อมูล มิเตอร์ไฟ'],
            [
                'เดือน '.date('m/Y', strtotime($year.'-'.$month))
            ],
            [
                "ชั้น",
                "ห้อง",
                "เลขมิเตอร์ไฟฟ้าก่อนหน้า",
                "เลขมิเตอร์ไฟฟ้าล่าสุด",
                "หน่วยที่ใช้"
            ]
        ];
        // return $data;
        foreach($results as $key=>$row){
            $data[] = [
                        intval($row->floor_name),
                        intval($row->room_name),
                        intval($row->meterPrevious->electricity_unit),
                        intval($row->electricity_unit),
                        intval($row->electricity_unit) - intval($row->meterPrevious->electricity_unit),
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
        $writer->save("upload/export_excel/ข้อมูลมิเตอร์ไฟ".date('m-Y', strtotime($year.'-'.$month)).".xlsx");
        return redirect("upload/export_excel/ข้อมูลมิเตอร์ไฟ".date('m-Y', strtotime($year.'-'.$month)).".xlsx");
    }
    public function waterExportExcel(Request $request)
    {
        $month = date('m');
        $year = date('Y');

        if($request->month){
            $month = explode('-', $request->month)[1];
            $year = explode('-', $request->month)[0];
        }

        //////// หา เดือนก่อนหน้า
        $year_month_previous = date('Y-m', strtotime($year.'-'.$month . ' -1 month'));
        // dd($year_month_previous);
        $month_previous = explode('-', $year_month_previous)[1];
        $year_previous = explode('-', $year_month_previous)[0];
        //////// หา เดือนก่อนหน้า จบ
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        $results = Room::orderBy('rooms.name')
                        ->leftJoin('meters', 'meters.ref_room_id', '=', 'rooms.id')
                        ->leftJoin('floors', 'floors.id', '=', 'rooms.ref_floor_id')
                        ->leftJoin('buildings', 'buildings.id', '=', 'floors.ref_building_id')
                        ->Where('meters.month', $month)->Where('meters.year', $year)
                        ->where('ref_branch_id',session("branch_id"))
                        ->with([
                            // 'meterCurrent' => fn($q) => $q->where('month', $month)->where('year', $year),
                            'meterPrevious' => fn($q) => $q->where('month', $month_previous)->where('year', $year_previous),
                            ])
                        // ->WhereHas('room_for_rent', function ($query) {
                        //     $query->where('status', 0); // กรอง User ที่มี Position status = 'active'
                        // })
                        ->select('rooms.*', 'floors.name as floor_name', 'rooms.name as room_name', 'meters.water_unit', 'meters.electricity_unit', 'meters.id as meters_id');
                        
                        
        if ($request->building != "all") {
            // return 456;
            $results->whereHas('floor', function ($query) use ($request) {
                $query->where('ref_building_id', $request->building);
            });
        }
        if ($request->floor != "all") {
            // return 123;
            $results->where('rooms.ref_floor_id', $request->floor);
        }

        $results = $results->get();
        $data = 
        [
            ['ข้อมูล มิเตอร์น้ำ'],
            [
                'เดือน '.date('m/Y', strtotime($year.'-'.$month))
            ],
            [
                "ชั้น",
                "ห้อง",
                "เลขมิเตอร์น้ำก่อนหน้า",
                "เลขมิเตอร์น้ำล่าสุด",
                "หน่วยที่ใช้",
            ]
        ];
        // return $data;
        foreach($results as $key=>$row){
            $data[] = [
                        intval($row->floor_name),
                        intval($row->room_name),
                        intval($row->meterPrevious->water_unit),
                        intval($row->water_unit),
                        intval($row->water_unit) - intval($row->meterPrevious->water_unit),
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
        $writer->save("upload/export_excel/ข้อมูลมิเตอร์น้ำ".date('m-Y', strtotime($year.'-'.$month)).".xlsx");
        return redirect("upload/export_excel/ข้อมูลมิเตอร์น้ำ".date('m-Y', strtotime($year.'-'.$month)).".xlsx");
    }
    public function allExportExcel(Request $request)
    {
        $month = date('m');
        $year = date('Y');

        if($request->month){
            $month = explode('-', $request->month)[1];
            $year = explode('-', $request->month)[0];
        }

        //////// หา เดือนก่อนหน้า
        $year_month_previous = date('Y-m', strtotime($year.'-'.$month . ' -1 month'));
        // dd($year_month_previous);
        $month_previous = explode('-', $year_month_previous)[1];
        $year_previous = explode('-', $year_month_previous)[0];
        //////// หา เดือนก่อนหน้า จบ
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ตัวอย่างข้อมูล
        $results = Room::orderBy('rooms.name')
                        ->leftJoin('meters', 'meters.ref_room_id', '=', 'rooms.id')
                        ->leftJoin('floors', 'floors.id', '=', 'rooms.ref_floor_id')
                        ->leftJoin('buildings', 'buildings.id', '=', 'floors.ref_building_id')
                        ->Where('meters.month', $month)->Where('meters.year', $year)
                        ->where('ref_branch_id',session("branch_id"))
                        ->with([
                            // 'meterCurrent' => fn($q) => $q->where('month', $month)->where('year', $year),
                            'meterPrevious' => fn($q) => $q->where('month', $month_previous)->where('year', $year_previous),
                            ])
                        // ->WhereHas('room_for_rent', function ($query) {
                        //     $query->where('status', 0); // กรอง User ที่มี Position status = 'active'
                        // })
                        ->select('rooms.*', 'floors.name as floor_name', 'rooms.name as room_name', 'meters.water_unit', 'meters.electricity_unit', 'meters.id as meters_id')
                        ->get();
        $data = 
        [
            ['ข้อมูล มิเตอร์น้ำ'],
            [
                'เดือน '.date('m/Y', strtotime($year.'-'.$month))
            ],
            [
                "ชั้น",
                "ห้อง",
                "เลขมิเตอร์น้ำก่อนหน้า",
                "เลขมิเตอร์น้ำล่าสุด",
                "หน่วยที่ใช้",
                "เลขมิเตอร์ไฟฟ้าก่อนหน้า",
                "เลขมิเตอร์ไฟฟ้าล่าสุด",
                "หน่วยที่ใช้"
            ]
        ];
        // return $data;
        foreach($results as $key=>$row){

            $water_unit_used = "0";
            $ele_unit_used = "0";
            if(intval($row->water_unit) - intval($row->meterPrevious->water_unit) != 0){
                $water_unit_used = intval($row->water_unit) - intval($row->meterPrevious->water_unit);
            }
            if(intval($row->electricity_unit) - intval($row->meterPrevious->electricity_unit) != 0){
                $ele_unit_used = intval($row->electricity_unit) - intval($row->meterPrevious->electricity_unit);
            }

            $data[] = [
                        $row->floor_name,
                        $row->room_name,
                        intval($row->meterPrevious->water_unit),
                        intval($row->water_unit),
                        $water_unit_used,
                        intval($row->meterPrevious->electricity_unit),
                        intval($row->electricity_unit),
                        $ele_unit_used,
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
        $writer->save("upload/export_excel/ข้อมูลมิเตอร์น้ำ".date('m-Y', strtotime($year.'-'.$month)).".xlsx");
        return redirect("upload/export_excel/ข้อมูลมิเตอร์น้ำ".date('m-Y', strtotime($year.'-'.$month)).".xlsx");
    }
}
