<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserTime;
use App\Models\Position;
use App\Models\Branch;
use App\Models\Work_shift;
use App\Models\Schedule;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use DateTime;
DB::beginTransaction();

class UserTimeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if(!in_array(Auth::user()->ref_position_id, [1,3]) && $id != Auth::user()->id){
            return redirect("user-time/".Auth::user()->id);
        }

        if(isset($id) && empty($id)){
            return redirect("user-time");
        }
        
        $data['page_url'] = 'user-time';
        $data['page'] = 'สรุปเวลาพนักงาน';
        $data['branch'] = Branch::get();
        $data['position'] = Position::get();
        // $data['title'] = 'Profile';
        
        return view('user-time/index', $data);
    }
    public function detail($id = null)
    {
        if(!in_array(Auth::user()->ref_position_id, [1,3]) && $id != Auth::user()->id){
            return redirect("user-time/".Auth::user()->id);
        }

        if($id){
            $user = User::find($id);
        }else{
            $user = Auth::user();
        }

        $user->position_name = Position::find($user->ref_position_id)->position_name;
        $data['page_url'] = $id;
        $data['title'] = 'Profile';
        $data['user'] = $user;
        
        return view('user-time-detail/index', $data);
    }

    public function change_input_date_from_to(Request $request)
    {
        // return $request->date_from_to;
        $date_from = explode(' - ', $request->date_from_to)[0];
        $date_to = explode(' - ', $request->date_from_to)[1];
        return view('user-time/div_date_from_to', ["date_from_to"=>$date_from.' - '.$date_to]);
    }
    public function thai_month($dateString) {
        // Array เก็บชื่อเดือนภาษาไทย
        $thaiMonths = array(
            "January" => "มกราคม",
            "February" => "กุมภาพันธ์",
            "March" => "มีนาคม",
            "April" => "เมษายน",
            "May" => "พฤษภาคม",
            "June" => "มิถุนายน",
            "July" => "กรกฎาคม",
            "August" => "สิงหาคม",
            "September" => "กันยายน",
            "October" => "ตุลาคม",
            "November" => "พฤศจิกายน",
            "December" => "ธันวาคม"
        );
        
        // แปลงวันที่
        $newDateFormat = date("j F Y", strtotime($dateString));
        
        // แปลงชื่อเดือนให้เป็นภาษาไทย
        foreach ($thaiMonths as $englishMonth => $thaiMonth) {
            $newDateFormat = str_replace($englishMonth, $thaiMonth, $newDateFormat);
        }
        
        return $newDateFormat;
    }
    public function datatable_by_id(Request $request, $id)
    {
            // return $request;
            $user = User::find($id);
            $u_t = UserTime::where('ref_user_id', $id);
            if($request->month){
                $s_year = explode('-', $request->month)[0];
                $s_month = explode('-', $request->month)[1];
                $u_t = $u_t->whereYear('day_date', $s_year)->whereMonth('day_date', $s_month);
            }else{
                $date_from = $this->ChangeDateFormat(explode(' - ', $request->date_from_to)[0]);
                $date_to = $this->ChangeDateFormat(explode(' - ', $request->date_from_to)[1]);
                $u_t = $u_t->whereDate('day_date', '>=', $date_from)->whereDate('day_date', '<=', $date_to);
            }


            $limit = 15;
            if(@$request['limit']){
                $limit = $request['limit'];
            }

            $u_t = $u_t->orderBy('day_date')->paginate($limit);
            $w_s = Work_shift::find($user->ref_work_shift_id);

                foreach($u_t as $ut){
                    $late = '00:00';
                    $ot = '00:00';
                    $ut->day_date_thai_text = $this->thai_month(date('Y-m-d', strtotime($ut->day_date . ' + 543 years')));
                    if($w_s->from_time < $ut->day_time_in){

                        $ex = explode(':',$ut->day_time_in);
                        $w_s_ex = explode(':',$w_s->from_time);
                        $start = Carbon::createFromTime($w_s_ex[0], $w_s_ex[1], $w_s_ex[2]);  
                        $end = Carbon::createFromTime($ex[0], $ex[1], $ex[2]);

                        // หาความแตกต่างระหว่างเวลา
                        $duration = $start->diff($end);

                        // แสดงผลลัพธ์
                        $duration->format('%H:%i');
                        
                        ///////////////////////////////////////
                        $time1 = Carbon::createFromTimeString($duration->format('%H:%i'));

                        $time2 = Carbon::createFromTimeString($late);

                        // บวกเวลา
                        $result = $time1->addHours($time2->hour)->addMinutes($time2->minute);

                        // แสดงผลลัพธ์
                        $late = $result->format('H:i');
                    }

                    if($w_s->to_time < $ut->day_time_out){

                        $ex = explode(':',$ut->day_time_out);
                        $w_s_ex = explode(':',$w_s->to_time);
                        $start = Carbon::createFromTime($w_s_ex[0], $w_s_ex[1], $w_s_ex[2]);  
                        $end = Carbon::createFromTime($ex[0], $ex[1], $ex[2]);

                        // หาความแตกต่างระหว่างเวลา
                        $duration = $start->diff($end);

                        // แสดงผลลัพธ์
                        $duration->format('%H:%i');
                        
                        ///////////////////////////////////////
                        $time1 = Carbon::createFromTimeString($duration->format('%H:%i'));

                        $time2 = Carbon::createFromTimeString($ot);

                        // บวกเวลา
                        $result = $time1->addHours($time2->hour)->addMinutes($time2->minute);

                        // แสดงผลลัพธ์
                        $ot = $result->format('H:i');
                    }

                    /////////// สาย
                    /////////// สาย
                    list($late_hour, $late_minute) = explode(':', $late);
                    $late_hour = ltrim($late_hour, '0');
                    $late_minute = ltrim($late_minute, '0');
                    // แปลงเป็นรูปแบบ ชั่วโมง นาที
                    if($late_hour == ''){
                        $ut->late = "$late_minute&nbsp; นาที";
                        if($late_minute == ''){
                            $ut->late = "<span style='color:#56cd1c'>ไม่สาย</span>";
                        }
                    }else{
                        $ut->late = "$late_hour&nbsp; ชม. &nbsp;$late_minute&nbsp; นาที";
                    }
                    ////////// สาย จบแล้ว
                    ////////// สาย จบแล้ว
                    
                    ////////// โอที
                    ////////// โอที
                    list($ot_hour, $ot_minute) = explode(':', $ot);
                    $ot_hour = ltrim($ot_hour, '0');
                    $ot_minute = ltrim($ot_minute, '0');
                    // แปลงเป็นรูปแบบ ชั่วโมง นาที
                    if($ot_hour == ''){
                        $ut->ot = "$ot_minute&nbsp; นาที";
                        if($ot_minute == ''){
                            $ut->ot = "ไม่มี OT";
                        }
                    }else{
                        $ut->ot = "$ot_hour&nbsp; ชม. &nbsp;$ot_minute&nbsp; นาที";
                    }
                    ////////// โอที จบแล้ว
                    ////////// โอที จบแล้ว

                }


        // return $results->items();
        // dd($results);
        $data['list_data'] = $u_t->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['page_url'] = 'user-time';
        $data['list_data'] = $u_t;

        return view('user-time-detail/table', $data);
    }
    public function datatable(Request $request)
    {
        // return $request;
        $results = User::where('ref_status_id',1)->with('work_shift')->orderBy('id','DESC');
        // return 123;
        if(@$request->search){
            $results = $results->Where('name','LIKE','%'.$request->search.'%');
        }

        if(@$request->ref_branch_id){
            $results = $results->Where('ref_branch_id', $request->ref_branch_id);
        }

        if(@$request->ref_position_id){
            $results = $results->Where('ref_position_id', $request->ref_position_id);
        }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }
        $results = $results->with('position')->paginate($limit);
        foreach($results as $re){
            // date('m', strtotime('-1 month'))
            // return $s_month;
            $u_t = UserTime::where('ref_user_id', $re->id);
            if($request->month){
                $s_year = explode('-', $request->month)[0];
                $s_month = explode('-', $request->month)[1];
                $u_t = $u_t->whereYear('day_date', $s_year)->whereMonth('day_date', $s_month);
            }else{
                $date_from = $this->ChangeDateFormat(explode(' - ', $request->date_from_to)[0]);
                $date_to = $this->ChangeDateFormat(explode(' - ', $request->date_from_to)[1]);
                $u_t = $u_t->whereDate('day_date', '>=', $date_from)->whereDate('day_date', '<=', $date_to);
            }


                $u_t = $u_t->get();
            $w_s = Work_shift::find($re->ref_work_shift_id);
            $late = '00:00';
            $ot = '00:00';

                foreach($u_t as $ut){

                    if($w_s->from_time < $ut->day_time_in){

                        $ex = explode(':',$ut->day_time_in);
                        $w_s_ex = explode(':',$w_s->from_time);
                        $start = Carbon::createFromTime($w_s_ex[0], $w_s_ex[1], $w_s_ex[2]);  
                        $end = Carbon::createFromTime($ex[0], $ex[1], $ex[2]);

                        // หาความแตกต่างระหว่างเวลา
                        $duration = $start->diff($end);

                        // แสดงผลลัพธ์
                        $duration->format('%H:%i');
                        
                        ///////////////////////////////////////
                        $time1 = Carbon::createFromTimeString($duration->format('%H:%i'));

                        $time2 = Carbon::createFromTimeString($late);

                        // บวกเวลา
                        $result = $time1->addHours($time2->hour)->addMinutes($time2->minute);

                        // แสดงผลลัพธ์
                        $late = $result->format('H:i');
                    }

                    if($w_s->to_time < $ut->day_time_out){

                        $ex = explode(':',$ut->day_time_out);
                        $w_s_ex = explode(':',$w_s->to_time);
                        $start = Carbon::createFromTime($w_s_ex[0], $w_s_ex[1], $w_s_ex[2]);  
                        $end = Carbon::createFromTime($ex[0], $ex[1], $ex[2]);

                        // หาความแตกต่างระหว่างเวลา
                        $duration = $start->diff($end);

                        // แสดงผลลัพธ์
                        $duration->format('%H:%i');
                        
                        ///////////////////////////////////////
                        $time1 = Carbon::createFromTimeString($duration->format('%H:%i'));

                        $time2 = Carbon::createFromTimeString($ot);

                        // บวกเวลา
                        $result = $time1->addHours($time2->hour)->addMinutes($time2->minute);

                        // แสดงผลลัพธ์
                        $ot = $result->format('H:i');
                    }

                }

                /////////// สาย
                /////////// สาย
                list($late_hour, $late_minute) = explode(':', $late);
                $late_hour = ltrim($late_hour, '0');
                $late_minute = ltrim($late_minute, '0');
                // แปลงเป็นรูปแบบ ชั่วโมง นาที
                if($late_hour == ''){
                    $re->late = "$late_minute&nbsp; นาที";
                    if($late_minute == ''){
                        $re->late = "<span style='color:#56cd1c'>ไม่สาย</span>";
                    }
                }else{
                    $re->late = "$late_hour&nbsp; ชม.";
                    if($late_minute != ''){
                        $re->late .= " &nbsp;$late_minute&nbsp; นาที";
                    }
                }
                ////////// สาย จบแล้ว
                ////////// สาย จบแล้ว
                
                ////////// โอที
                ////////// โอที
                list($ot_hour, $ot_minute) = explode(':', $ot);
                $ot_hour = ltrim($ot_hour, '0');
                $ot_minute = ltrim($ot_minute, '0');
                // แปลงเป็นรูปแบบ ชั่วโมง นาที
                if($ot_hour == ''){
                    $re->ot = "$ot_minute&nbsp; นาที";
                    if($ot_minute == ''){
                        $re->ot = "ไม่มี OT";
                    }
                }else{
                    $re->ot = "$ot_hour&nbsp; ชม. &nbsp;$ot_minute&nbsp; นาที";
                }
                ////////// โอที จบแล้ว
                ////////// โอที จบแล้ว


        }
        // return $results->items();
        // dd($results);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['page_url'] = 'user-time';
        $data['list_data'] = $results;

        return view('user-time/table', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function check_import_excel_user(Request $request)
    {
        // return 987;
        try{
            $targetPath = rand().'_'.$request->file('file')->getClientOriginalName();
            // $request->file('file')->move('upload/excel/', $targetPath);
            // copy('upload/excel/'.$targetPath, 'upload/ttime_excel/'.$targetPath);
            $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadSheet = $Reader->load('upload/excel/1823498963_time_test_srongpol.xlsx');
            $excelSheet = $spreadSheet->getActiveSheet();
            $spreadSheetAry = $excelSheet->toArray();

            foreach($spreadSheetAry as $key => $value){
                // if($key>1){ continue; }
                if($value[0] == ''){ continue; }
                if($value[0] != '' && @$spreadSheetAry[$key-1][0] == ''){ continue; }
                // return date('Y-m-d', strtotime($value[6]));
                $check = UserTime::where("employee_code", $value[2])->where("day_date", date('Y-m-d', strtotime($value[6])))->first();
                if(@$check){
                    $alreadyexists[] = $value;
                    // return 25;
                }else{
                    $newitem[] = $value;
                }
                if($value[0] == ''){ break; }
                
            }
            // return $alreadyexists;
            if(@$alreadyexists){
                $data = array(
                    "status" => false,
                    "modal" => "".view('user-time/alreadyexists', ['alreadyexists' => $alreadyexists, 'newitem' => @$newitem])
                );
                return $data;
            }
            return $this->import_excel_user($request);
            
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function import_excel_user(Request $request)
    {
        // return 5454;
        try{
            $targetPath = rand().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->move('upload/time_excel/', $targetPath);

            $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadSheet = $Reader->load('upload/time_excel/'.$targetPath);
            $excelSheet = $spreadSheet->getActiveSheet();
            $spreadSheetAry = $excelSheet->toArray();

            foreach($spreadSheetAry as $key => $value){
                // if($key>1){ continue; }
                if($value[0] == ''){ continue; }
                if($value[0] != '' && @$spreadSheetAry[$key-1][0] == ''){ continue; }

                $check = UserTime::where("employee_code", $value[2])->where("day_date", date('Y-m-d', strtotime($value[6])))->first();
                if(!$check){
                    $user = new UserTime;
                    $user->ref_user_id = User::where('employee_id', $value[2])->first()->id;
                    $user->machine_code = $value[1];
                    $user->employee_code = $value[2];
                    $user->position_name = $value[4];
                    $user->branch_name = $value[5];
                    $user->day_date = date('Y-m-d', strtotime($value[6]));
                    $user->day_time_in = $value[7];
                    $user->day_time_out = $value[8];
                    $user->save();
                }else{
                    $user = UserTime::find($check->id);
                    $user->ref_user_id = User::where('employee_id', $value[2])->first()->id;
                    $user->machine_code = $value[1];
                    $user->employee_code = $value[2];
                    $user->position_name = $value[4];
                    $user->branch_name = $value[5];
                    $user->day_date = date('Y-m-d', strtotime($value[6]));
                    $user->day_time_in = $value[7];
                    $user->day_time_out = $value[8];
                    $user->save();
                }
                if($value[0] == ''){ break; }
                
            }

            DB::commit();
            $data = array(
                "status" => true,
                "modal" => "".view('user-time/import-excel-modal')
            );
            return $data;
            
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function ChangeDateFormat($date)
    { 
        $dateCreate = date_create_from_format('d F, Y', $date);
        $formattedDate = date_format($dateCreate, 'Y-m-d');
        return $formattedDate;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}

// $targetPath = $request->file('image_name')->getClientOriginalName();
// $request->file('image_name')->move('upload/time_excel/', $targetPath);

// $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

// $spreadSheet = $Reader->load('upload/time_excel/'.$targetPath);
// $excelSheet = $spreadSheet->getActiveSheet();
// return $spreadSheetAry = $excelSheet->toArray();

