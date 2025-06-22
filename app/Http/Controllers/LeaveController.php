<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Work_shift;
use App\Models\User;
use App\Models\UserLeave;
use App\Models\Branch;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

DB::beginTransaction();

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function check_leave_index()
    {
        
        $data['branch'] = Branch::get();
        $data['position'] = Position::get();
        $user = Auth::user();
        $results = UserLeave::where('ref_user_id',$user->id)->orderBy('id','DESC')->get();
        $leave = Leave::get();
        $data['list_data'] = $results;
        $data['leave'] = $leave;
        $data['page_url'] = 'check-employee-leave';
        $data['page'] = 'ลา';
        
        return view('check-employee-leave/index', $data);
    }

/////////////////////////////////////////////////////////////////////////////

    public function index(Request $request)
    {
        $user = Auth::user();
        $leave_by_user = explode(',',$user->ref_leave_id);

        foreach($leave_by_user as $l_by_u){
            
            $id_leaves[] = explode(':',$l_by_u)[0];
            $lbu[explode(':',$l_by_u)[0]] = explode(':',$l_by_u)[1];
            $leave_all = UserLeave::where('ref_user_id',$user->id)->where('ref_leave_id',explode(':',$l_by_u)[0])->where('ref_status_id',1)->get(); // ดึงข้อมูลการลา ที่อนุมัติแล้ว ของ user นี้
            
            $minutes = 0;
            $text_time = "0";

            foreach($leave_all as $l_all){
                if($l_all->type_time == "day"){
                    $count_day = $this->countDays($l_all->from_date, $l_all->to_date); // หาจำนวนวันที่ลา
                    $minutes += $count_day*8*60; // ทำให้เป็น นาที
                }else{
                    if($l_all->from_time < '12:00' && $l_all->to_time > '13:00'){
                        $carbonTime = Carbon::createFromFormat('H:i:s', $l_all->to_time);

                        // ลบ 1 ชั่วโมง
                        $newTime = $carbonTime->subHour();

                        // แสดงผลเวลาใหม่
                        $l_all->to_time = $newTime->format('H:i:s');
                    }
                    $startTime = Carbon::createFromFormat('H:i:s', $l_all->from_time);
                    $endtTime = Carbon::createFromFormat('H:i:s', $l_all->to_time);
                    $minutes += $startTime->diffInMinutes($endtTime); // เป็น นาที
                }

            }
                    if($minutes > 0){
                        $text_time = "";
                        // return ($minutes/60);
                        if(($minutes/60) >= 8){
                            $text_time .= explode('.', explode('.', ($minutes/60))[0]/8)[0]." วัน ";
                            $minutes = $minutes - (explode('.', explode('.', ($minutes/60))[0]/8)[0]*8)*60; // หาเศษ ชั่วโมง นาที หลังจากหา จำนวน วัน ได้แล้ว
                        }
                        if($minutes > 0){
                            $hours = floor($minutes / 60);
                            $remainingMinutes = $minutes % 60;
                            
                            // แสดงผลในรูปแบบ H:i ชั่วโมง:นาที
                            $timeFormat = sprintf('%02d:%02d', $hours, $remainingMinutes);
    
                            $text_time .= $this->convertTimeToText($timeFormat);  // แปลงเป็น ตัวหนังสือ
                        }
                    }
                    
            $leave_remaining[explode(':',$l_by_u)[0]] = $text_time;
        }

        $leave = Leave::whereIn('id', $id_leaves)->get();
        $work_shift = Work_shift::find($user->ref_work_shift_id);

        $data['lbu'] = $lbu;
        $data['leave_remaining'] = $leave_remaining;
        $data['leave'] = $leave;
        $data['work_shift'] = $work_shift;
        $data['page_url'] = 'leave';
        $data['page'] = 'ลา';
        
        return view('leave/index', $data);
    }

/////////////////////////////////////////////////////////////////////////////

    public function changeToTime($seconds) // แปลงเป็น ชั่วโมง:นาที
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        
        // แสดงผลในรูปแบบ H:i
        $timeFormat = sprintf('%02d:%02d', $hours, $minutes);

        return $timeFormat;
    }

/////////////////////////////////////////////////////////////////////////////

    public function countDays($start, $end)
    {
        $startDate = Carbon::create(explode('-', $start)[0], explode('-', $start)[1], explode('-', $start)[2]);
        $endDate = Carbon::create(explode('-', $end)[0], explode('-', $end)[1], explode('-', $end)[2]);

        $count_time = $startDate->diffInDays($endDate)+1;

        return $count_time;
    }

/////////////////////////////////////////////////////////////////////////////

    public function convertTimeToText($time)
    {
        // สร้าง Carbon instance จากเวลาในรูปแบบ H:i
        $carbonTime = Carbon::createFromFormat('H:i', $time);

        // คำนวณจำนวนชั่วโมงและนาที
        $hours = $carbonTime->hour;
        $minutes = $carbonTime->minute;
        
        // สร้างข้อความที่ต้องการ
        $text = '';
        if ($hours > 0) {
            $text .= $hours . ' ชม. ';
        }
        if ($minutes > 0) {
            $text .= $minutes . ' นาที';
        }

        // ส่งผลลัพธ์ไปยัง view หรือแสดงผล
        return $text;
    }

/////////////////////////////////////////////////////////////////////////////

    public function datatable_id(Request $request)
    {
        $results = UserLeave::where('ref_user_id',Auth::id())->orderBy('id','DESC');
        if(@$request->ref_leave_id){
            $results = $results->where('ref_leave_id',$request->ref_leave_id);
        }
        
        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $results = $results->paginate($limit);
        // $results->toArray()['from'];
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['page_url'] = 'leave';

        return view('leave/table', $data);
    }

/////////////////////////////////////////////////////////////////////////////

    public function datatable(Request $request)
    {
        $results = UserLeave::orderBy('id','DESC');
        if(@$request->ref_leave_id){
            $results = $results->Where('ref_leave_id', $request->ref_leave_id);
        }
        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $user = Auth::user();
        if (!in_array($user->ref_position_id,[1,3])){
            $ref_user = User::where("ref_user_id", $user->id)->get(); /// เช็คว่า user ที่ใช้งานอยู่เป็นหัวหน้างานไหม
            if(@$ref_user){
                $results = $results->WhereIn('ref_user_id', array_column(json_decode($ref_user, true), 'id'));
            }
        }

        $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['page_url'] = 'leave';
        $data['list_data'] = $results;

        return view('check-employee-leave/table', $data);
    }

/////////////////////////////////////////////////////////////////////////////

    public function ChangeDateFormat($date){ 

        $dateCreate = date_create_from_format('d F, Y', $date);
        $formattedDate = date_format($dateCreate, 'Y-m-d');
        return $formattedDate;

    }

/////////////////////////////////////////////////////////////////////////////

    public function store(Request $request)
    {
        $user = Auth::user();
        $leave = Leave::find($request->ref_leave_id);
        $boss = User::find($user->ref_user_id);
        $work_shift = Work_shift::find($user->ref_work_shift_id);
        try{
            $last_leave_number = 'LEV'.date('Y').'-0000';
            $last_leave = UserLeave::latest()->first();
            if($last_leave){
                $last_leave_number = $last_leave->leave_number;
            }
            $prefix = substr($last_leave_number, 0, strrpos($last_leave_number, '-') + 1); // 'ORDER-'
            $number = substr($last_leave_number, strrpos($last_leave_number, '-') + 1); // '0009'
            $newNumber = sprintf('%04d', intval($number) + 1); // '0010'

            $new_leave_number = $prefix . $newNumber;
            if($request->type_time == 'day'){
                // return $request->from_date;

                $leave_date = explode(' - ',$request->from_date);
                $from_date = $this->ChangeDateFormat($leave_date[0]);
                $to_date = $this->ChangeDateFormat($leave_date[1]);

                $from_time = $work_shift->from_time;
                $to_time = $work_shift->to_time;
            }else{
                // return 123;
                
                $from_date = $this->ChangeDateFormat($request->date_leave);
                $to_date = $this->ChangeDateFormat($request->date_leave);

                $from_time = $request->from_time;
                $to_time = $request->to_time;
                
                $data['from_time'] = $from_time;
                $data['to_time'] = $to_time;
            }

            // return $request;
            // $request->file('file_name');
            $file_name = "";
            if($request->file('file_name')){
                $file = $request->file('file_name');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/leave/";
                $file_name = $new_leave_number.'.'.$extension;
                $request->file('file_name')->move($path, $file_name);
            }
            
            $user_leave = new UserLeave;
            $user_leave->leave_number = $new_leave_number;
            $user_leave->ref_user_id = Auth::id();
            $user_leave->ref_leave_id = $request->ref_leave_id;
            $user_leave->detail = $request->detail;
            $user_leave->from_date = $from_date;
            $user_leave->to_date = $to_date;
            $user_leave->from_time = $from_time;
            $user_leave->to_time= $to_time;
            $user_leave->type_time = $request->type_time;
            $user_leave->file_name = $file_name;
            $user_leave->save();
            
            $data['new_leave_number'] = $new_leave_number;
            $data['leave'] = $leave;
            $data['detail'] = $request->detail;
            $data['user'] = $user;
            $data['from_date'] = $this->change_date_to_text($from_date);
            $data['to_date'] = $this->change_date_to_text($to_date);

            DB::commit();
            // return view('leave.email', $data);
            //// ส่งอีเมล เริ่ม
            Mail::send('leave.email', $data, function ($message) use ($boss) {
                $message->from('worawe@ots.co.th', 'Srongpol');
                // $message->to('wolverine.wek@gmail.com')
                $message->to($boss->email)
                ->subject("รายการลาใหม่");
            });
            //// ส่งอีเมล จบ
            // return view('leave.email', ['user_leave'=>$user_leave,'leave'=>$leave,'user'=>$user]);
            return redirect('leave-page')->with('message', 'Insert Leave "'.$request->leave_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }

    }
    public function change_date_to_text($dateString)
    {
    // สร้าง DateTime ออบเจ็กต์จากวันที่
        $date = Carbon::createFromFormat('Y-m-d', $dateString);
        
        // กำหนดชื่อเดือนในภาษาไทย
        $monthsThai = [
            '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
            '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
            '09' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
        ];
        
        // ดึงข้อมูลวัน, เดือน, และปี
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;

        // แปลงปีคริสต์ศักราชเป็นปีไทย
        $thaiYear = $year + 543;

        // แปลงเดือนเป็นชื่อเดือนภาษาไทย
        $thaiMonth = $monthsThai[str_pad($month, 2, '0', STR_PAD_LEFT)];

        // รวมวันที่เป็นสตริงที่ต้องการ
        return "$day $thaiMonth $thaiYear";
    }
/////////////////////////////////////////////////////////////////////////////

    public function change_boss_status(Request $request, $id)
    {
        
        try{
            $user_leave = UserLeave::find($id);
            $user_leave->ref_boss_status_id = $request->boss_status;
            $user_leave->save();

            DB::commit();
            
            if($request->boss_status == 1){

                $user = User::find($user_leave->ref_user_id);
                $leave = Leave::find($user_leave->ref_leave_id);
                $HR = User::where('ref_position_id', 3)->get();

                $data['new_leave_number'] = $user_leave->leave_number;
                $data['leave'] = $leave;
                $data['user'] = $user;

                $data['from_date'] = $this->change_date_to_text($user_leave->from_date);
                $data['to_date'] = $this->change_date_to_text($user_leave->to_date);

                if($request->type_time == 'time'){

                    $data['from_time'] = $user_leave->from_time;
                    $data['to_time'] = $user_leave->to_time;

                }

                foreach($HR as $h){
                    $data['detail'] = $request->detail;
                    Mail::send('leave.email', $data, function ($message) use ($h) {
                        $message->from('worawe@ots.co.th', 'Srongpol');
                        // $message->to('wolverine.wek@gmail.com')
                        $message->to($h->email)
                        ->subject("รายการลาใหม่");
                    });
                }
            }

            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }

/////////////////////////////////////////////////////////////////////////////

    public function change_status(Request $request, $id)
    {
        
        try{
            $leave = UserLeave::find($id);
            $leave->ref_status_id = $request->status;
            $leave->ref_approve_id = Auth::id();
            $leave->save();
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }

/////////////////////////////////////////////////////////////////////////////

}
