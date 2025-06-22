<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnnualHoliday;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

DB::beginTransaction();

class AnnualHolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['page_url'] = 'annual-holiday';
        $data['page'] = 'ตารางวันหยุด';
        $annual_holiday = AnnualHoliday::get();
        
        foreach($annual_holiday as $res){
            $res->date_th = $this->ChangeDateToTH($res->date);
        }
        $data['annual_holiday'] = $annual_holiday;

        return view('annual-holiday/index', $data);
    }
    // public function datatable(Request $request)
    // {
    //     $results = AnnualHoliday::orderBy('id','DESC');
    //     // if(@$request->brand_name){
    //     //     $results = $results->Where('brand_name','LIKE','%'.$request->brand_name.'%');
    //     // }
    //     $limit = 15;
    //     if(@$request['limit']){
    //         $limit = $request['limit'];
    //     }

    //     $results = $results->paginate($limit);
    //     foreach($results as $res){
    //         $res->name_th = $this->ChangeDateToTH($res->name);
    //     }

    //     return $data['list_data'] = $results->appends(request()->query());
    //     $data['query'] = request()->query();
    //     $data['query']['limit'] = $limit;

    //     $data['page_url'] = 'annual-holiday';
    //     $data['list_data'] = $results;

    //     return view('annual-holiday/table', $data);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            // return true;

            // return $request->delete_id;
            // return explode(',',$request->delete_id[0]);

            foreach($request->annual_holiday as $key => $a_h){
                // return $a_h["name"];
                if($key == 'insert'){
                    $annual_holiday = new AnnualHoliday;
                    if($a_h['name'] == null){
                        continue;
                    } 
                }else{
                    $annual_holiday = AnnualHoliday::find($key);
                }
                $annual_holiday->name = $a_h['name'];
                $annual_holiday->date = $a_h['date'];
                $annual_holiday->remark = $a_h['remark'];
                $annual_holiday->year = date('Y');
                $annual_holiday->save();

            }

                AnnualHoliday::destroy(explode(',',$request->delete_id[0]));
            
            $data['annual_holiday'] = AnnualHoliday::get();
            
            DB::commit();
            // $data['news_detail'] = $user->detail;
            return view('annual-holiday/form', $data);
            // return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    public function ChangeDateToTH($date)
    {
        ////////////////////// แปลงรูปแบบวันเกิดเป็น ไทย
        // สร้าง Carbon instance จากวันที่
        $m = date('m', strtotime($date));
        $date = Carbon::createFromFormat('Y-m-d', $date);

        // คำนวณปีพุทธศักราช
        $buddhistYear = $date->year + 543;

        // แปลงวันที่เป็นรูปแบบไทย
        $thaiDate = $date->formatLocalized('%e %B ' . $buddhistYear);
        
        $monthTH = [ 
                "01" => "มกราคม",
                "02" => "กุมภาพันธ์",
                "03" => "มีนาคม",
                "04" => "เมษายน",
                "05" => "พฤษภาคม",
                "06" => "มิถุนายน",
                "07" => "กรกฎาคม",
                "08" => "สิงหาคม",
                "09" => "กันยายน",
                "10" => "ตุลาคม",
                "11" => "พฤศจิกายน",
                "12" => "ธันวาคม"
        ];
        $monthEN = [    
                "01" => "January",
                "02" => "February",
                "03" => "March",
                "04" => "April",
                "05" => "May",
                "06" => "June",
                "07" => "July",
                "08" => "August",
                "09" => "September",
                "10" => "October",
                "11" => "November",
                "12" => "December"
        ];
        return str_replace($monthEN[$m], $monthTH[$m], $thaiDate);
    }
    public function destroy($id)
    {
        try{
            AnnualHoliday::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
}
