<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;
use App\Models\UserTime;
use App\Models\Position;
use App\Models\Branch;
use App\Models\UserHasBranch;
use App\Models\Schedule;
use App\Models\Permission;
use App\Models\PermissionGroups;
use App\Models\PermissionGroupHasUserBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Carbon\Carbon;
use Mpdf\Mpdf;

DB::beginTransaction();

class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        // สร้าง instance ของ mPDF
        
    public function index()
    {
        // $pghub = PermissionGroupHasUserBranch::with('permission','permission_group')->where('ref_branch_id', session("branch_id"))->where('ref_user_id', 1)->orderBy('ref_permission_group_id')->orderBy('ref_permission_id')->get();

        // $permission = [];

        // // จัดกลุ่มตาม ref_permission_group_id
        // foreach ($pghub as $item) {
        //     $groupId = $item['ref_permission_group_id'];

        //     // ถ้ายังไม่มี group นี้ใน $permission ให้สร้าง
        //     if (!isset($permission[$groupId])) {
        //         $permission[$groupId] = [
        //             "id" => $item['id'],
        //             "ref_user_id" => $item['ref_user_id'],
        //             "ref_branch_id" => $item['ref_branch_id'],
        //             "ref_permission_group_id" => $groupId,
        //             "ref_permission_id" => $item['ref_permission_id'],
        //             "status" => $item['status'],
        //             "created_at" => $item['created_at'],
        //             "updated_at" => $item['updated_at'],
        //             "permission_group" => $item['permission_group'],
        //             "permission" => []
        //         ];
        //     }

        //     // ดึงข้อมูล permission ของ item นี้
        //     $permission[$groupId]["permission"][] = [
        //         "id" => $item["permission"]["id"],
        //         "name" => $item["permission"]["name"],
        //         "description" => $item["permission"]["description"],
        //         "ref_permission_id" => $item["permission"]["ref_permission_id"],
        //         "ref_permission_group_id" => $item["permission"]["ref_permission_group_id"],
        //         "created_at" => $item["permission"]["created_at"],
        //         "updated_at" => $item["permission"]["updated_at"],
        //     ];
        // }

        // // แปลง associative array เป็น index array
        // $permission = array_values($permission);

        // return $data['permission'] = $permission;

        $data['page_url'] = 'user';
        $data['page'] = 'พนักงาน';
        $data['position'] = Position::get();

        // $data['title'] = 'Profile';
        
        return view('user/index', $data);
    }
    public function register()
    {

        $data['page_url'] = 'register';
        $data['page'] = 'พนักงาน';
        $data['position'] = Position::whereIn('id', [1,2])->get();
        // $data['title'] = 'Profile';
        
        return view('register/index', $data);
    }
    public function forgot_password()
    {

        $data['page_url'] = 'forgot-password';
        $data['page'] = 'ลืมรหัสผ่าน';
        $data['position'] = Position::whereIn('id', [1,2])->get();
        // $data['title'] = 'Profile';
        
        return view('forgot-password/index', $data);
    }
    public function reset_password($remember_token)
    {

        $data['page_url'] = 'forgot-password';
        $data['page'] = 'พนักงาน';
        $data['remember_token'] = $remember_token;
        $user = user::where('remember_token', $remember_token)->first();

        if(!$user){
            return 'ไม่สามารถดำเนินการได้.!';
        }

        $data['position'] = Position::whereIn('id', [1,2])->get();
        // $data['title'] = 'Profile';
        
        return view('forgot-password/reset', $data);
    }

    public function submit_reset_password(Request $request)
    {
        try{
            $user = user::where('remember_token', $request->remember_token)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            // return $user->password;
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }

    }

    public function profile($id = null)
    {
        if($id){
            $user = User::find($id);
        }else{
            $user = Auth::user();
        }

        $user->birthday_th = $this->ChangeDateToTH($user->birthday);
        ////////////////////// แปลงรูปแบบวันเกิดเป็น ไทย

        $user->position_name = Position::find($user->ref_position_id)->position_name;
        $data['page_url'] = 'user';
        $data['title'] = 'Profile';
        $data['user'] = $user;
        
        return view('user/profile', $data);
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

    public function datatable(Request $request)
    {
        $results = User::whereHas('user_has_branch', function ($query) {
                            $query->where('ref_branch_id', session("branch_id"));
                        })->orderBy(
                                    DB::table('user_has_branchs')
                                    ->select('ref_position_id')
                                    ->whereColumn('user_has_branchs.ref_user_id', 'users.id')
                                    ->where('ref_branch_id', session("branch_id"))
                                    ->limit(1),
                                    'asc'
                                );
        
        if(@$request->search){
            $results = $results->where(function ($query) use ($request) {
                                    $query->where('users.name','LIKE','%'.$request->search.'%')
                                        ->orWhere('users.email','LIKE','%'.$request->search.'%')
                                        ->orWhere('users.salary','LIKE','%'.$request->search.'%')
                                        ->orWhere('users.phone','LIKE','%'.$request->search.'%')
                                        ->orWhere('users.remark','LIKE','%'.$request->search.'%');
                                });
        }
        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $results = $results->with('user_has_branch')->paginate($limit);
        // return $results->items();
        // dd($results);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;
        $data['position'] = Position::get();

        $data['list_data'] = $results;

        return view('user/table', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Add New Employee';
        $data['branch'] = Branch::get();
        $data['position'] = Position::get();
        $data['work_shift'] = Work_shift::get();
        $data['schedule'] = Schedule::get();
        // $data['leave'] = Leave::get();
        $data['boss'] = User::get();
        $data['action'] = route('user.store');
        $data['user'] = [
                            'leave_just_id' => ["1","2","3","9"],
                            'leave_id_number' => ["1"=>"6","2"=>"30","3"=>"6","9"=>"10"]
                        ];
        // return $data['user'];
        return view('user/form', $data);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $work_start_date = Carbon::createFromFormat('d/m/Y', $request->work_start_date)->format('Y-m-d');
            $ref_user_id = $request->ref_user_id;
            if($ref_user_id == null){
                $ref_user_id = 0;
            }

            $user = new User;
            $user->name  =  $request->name;
            $user->username  =  $request->username;
            $user->salary  =  preg_replace('/\D/', '', $request->salary);
            $user->phone  =  $request->phone;
            $user->email  =  $request->email;
            $user->work_start_date  =  $work_start_date;
            $user->ref_position_id  =  $request->ref_position_id;
            $user->ref_user_id  =  $ref_user_id;
            $user->remark  =  $request->remark;
            // $user->ref_branch_id  =  session("branch_id");
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();
            
            if (!Auth::attempt([
                'email' => $user->email,
                'password' => $request->password // อย่า Hash ซ้ำ
            ])) {
                throw new \Exception('Login failed after registration.');
            }
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function forgot_password_send_mail(Request $request)
    {
        try{

            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'ไม่พบ ผู้ใช้ อีเมล นี้ ในระบบ'
                ]);
            }
            
            $remember_token = rand();
            
            // $user = User;
            $user->remember_token = $remember_token;
            $user->save();

            $data['user'] = $user;
            $data['remember_token'] = $remember_token;

            Mail::send('forgot-password.email', $data, function ($message) use ($request) {
                $message->from('worawek@ots.co.th', 'Kittinakorn');
                // $message->to('wolverine.wek@gmail.com')
                $message->to($request->email)->subject("ลืมรหัสผ่าน");
            });

            // $work_start_date = Carbon::createFromFormat('d/m/Y', $request->work_start_date)->format('Y-m-d');
            // $ref_user_id = $request->ref_user_id;
            // if($ref_user_id == null){
            //     $ref_user_id = 0;
            // }

            // $user = new User;
            // $user->name  =  $request->name;
            // $user->username  =  $request->username;
            // $user->salary  =  preg_replace('/\D/', '', $request->salary);
            // $user->phone  =  $request->phone;
            // $user->email  =  $request->email;
            // $user->work_start_date  =  $work_start_date;
            // $user->ref_position_id  =  $request->ref_position_id;
            // $user->ref_user_id  =  $ref_user_id;
            // $user->remark  =  $request->remark;
            // // $user->ref_branch_id  =  session("branch_id");
            // $user->password = Hash::make($request->password);
            // $user->save();

            DB::commit();
            
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ]);

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
    public function check_have_email(Request $request)
    {
        $email = User::where('email', $request->email)->first();
        if(@$email){
            return false;
        }
            return true;
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
    
     public function edit($id)
     {
        $user_check = Auth::guard()->user();
        if($user_check){
            if($user_check->ref_position_id != 1){
                return response()->json([ "title"=> "เกิดข้อผิดพลาด", "text"=> "คุณไม่มีสิทธิ์ในการใช้งาน"],500);
            }
        }
        $data['page_url'] = 'user';
        $data['position'] = Position::get();
        $data['user'] = User::find($id);
        
        $pghub = PermissionGroupHasUserBranch::with('permission','permission_group')->where('ref_branch_id', session("branch_id"))->where('ref_user_id', $id)->orderBy('ref_permission_group_id')->orderBy('ref_permission_id')->get();

        // if($pghub->isNotEmpty()){
        //     $permission_id_1 = PermissionGroupHasUserBranch::with('permission','permission_group')->where('ref_branch_id', 1)->where('ref_user_id', 1)->orderBy('ref_permission_group_id')->orderBy('ref_permission_id')->get();
        // }

        $permission = [];

        // จัดกลุ่มตาม ref_permission_group_id
        foreach ($pghub as $item) {
            
            // $branch = UserHasBranch::get();
            // foreach($branch as $bra){
            //     if($bra->ref_user_id == $id && $bra->ref_branch_id == session("branch_id")){

            //     }else{
            //         $insert = new PermissionGroupHasUserBranch();
            //         $insert->ref_user_id = $bra->ref_user_id;
            //         $insert->ref_branch_id = $bra->ref_branch_id;
            //         $insert->ref_permission_group_id = $item['ref_permission_group_id'];
            //         $insert->ref_permission_id = $item['ref_permission_id'];
            //         $insert->status = 1;
            //         $insert->save();
            //     }
            // }

            $groupId = $item['ref_permission_group_id'];

            // ถ้ายังไม่มี group นี้ใน $permission ให้สร้าง
            if (!isset($permission[$groupId])) {
                $permission[$groupId] = [
                    "id" => $item['id'],
                    "ref_user_id" => $item['ref_user_id'],
                    "ref_branch_id" => $item['ref_branch_id'],
                    "ref_permission_group_id" => $groupId,
                    "ref_permission_id" => $item['ref_permission_id'],
                    "status" => $item['status'],
                    "created_at" => $item['created_at'],
                    "updated_at" => $item['updated_at'],
                    "permission_group" => $item['permission_group'],
                    "permission" => []
                ];
            }

            // ดึงข้อมูล permission ของ item นี้
            $permission[$groupId]["permission"][] = [
                "id" => $item["permission"]["id"],
                "name" => $item["permission"]["name"],
                "description" => $item["permission"]["description"],
                "ref_permission_id" => $item["permission"]["ref_permission_id"],
                "ref_permission_group_id" => $item["permission"]["ref_permission_group_id"],
                "permission_group_has_user_branch_id" => $item['id'],
                "permission_group_has_user_branch_status" => $item['status'],
                "created_at" => $item["permission"]["created_at"],
                "updated_at" => $item["permission"]["updated_at"],
            ];
        }
        // DB::commit();
        // แปลง associative array เป็น index array
        $permission = array_values($permission);

        $data['permission'] = $permission;
        return view('user/view', $data);
     }

     public function check_user($email)
     {
        $data['page_url'] = 'user';
        $user_has_branch = UserHasBranch::where('ref_branch_id', session("branch_id"))->pluck('ref_user_id')->toArray();
        $user = User::whereNotIn('id', $user_has_branch)
                ->where(function ($query) use ($email) {
                    $query->where('email', $email)
                          ->orWhere('phone', $email);
                })
                ->first();
        if($user){
            return "ค้นพบบุคลากร : <span class='text-success'>$user->name</span>";
        }else{
            return "<span class='text-warning'>ไม่พบบุคลากร</span>";
        }
     }
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        try{

            $work_start_date = Carbon::createFromFormat('d/m/Y', $request->work_start_date)->format('Y-m-d');

            $user = User::find($id);
            $user->name  =  $request->name;
            $user->username  =  $request->username;
            $user->salary  =  preg_replace('/\D/', '', $request->salary);
            $user->phone  =  $request->phone;
            $user->email  =  $request->email;
            $user->work_start_date  =  $work_start_date;
            $user->ref_position_id  =  $request->ref_position_id;
            $user->remark  =  $request->remark;
            if(!empty($request->password)){
                $user->password = Hash::make($request->password);
            }
            $user->save();
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function check_password(Request $request)
    {
        $user = Auth::user();
        if(Hash::check($request->password, $user->password)){
            return true;
        }
        return false;

    }
    public function change_password(Request $request)
    {
        try{
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();
            // return $user->password;
            DB::commit();
            return redirect('/')->with('message', 'Insert Employee "'.$request->name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }

    }
    public function edit_news(Request $request,$id = 1)
    {
        try{
            $news = News::find($id);
            $news->detail = $request->detail;
            $news->save();
            
            DB::commit();
            // $data['news_detail'] = $user->detail;
            return $news->detail;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = User::find($id);
            $user->status = "0";
            $user->save();
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }

    public function exportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // ดึงข้อมูลผู้ใช้เฉพาะสาขาปัจจุบัน (ป้องกันข้อมูลซ้ำ)
        $results = User::join('user_has_branchs', 'users.id', '=', 'user_has_branchs.ref_user_id')
                      ->where('user_has_branchs.ref_branch_id', session('branch_id'))
                      ->select('users.*')
                      ->distinct()
                      ->orderBy('users.id','DESC')
                      ->get();
        $data = 
        [
            ['ข้อมูลผู้ใช้งาน'],
            [
                'รายงานผู้ใช้งาน วันที่ '.date('d/m/Y')
            ],
            [
                "ลำดับ",
                "ชื่อพนักงาน",
                "ชื่อผู้ใช้งาน",
                "อีเมล",
                "เบอร์โทรศัพท์",
                "เงินเดือน",
                "วันที่เริ่มทำงาน"
            ]
        ];
        // return $data;
        foreach($results as $key=>$row){
            $data[] = [
                        $key+1,
                        $row->name,
                        $row->username,
                        $row->email,
                        $row->phone,
                        $row->salary,
                        date('d/m/Y', strtotime($row->work_start_date)),  
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

        $sheet->getColumnDimension('A')->setWidth(10);  // ลำดับ
        $sheet->getColumnDimension('B')->setWidth(42);  // ชื่อพนักงาน
        $sheet->getColumnDimension('C')->setWidth(42);  // ชื่อผู้ใช้งาน
        $sheet->getColumnDimension('D')->setWidth(35);  // อีเมล
        $sheet->getColumnDimension('E')->setWidth(20);  // เบอร์โทรศัพท์
        $sheet->getColumnDimension('F')->setWidth(15);  // เงินเดือน
        $sheet->getColumnDimension('G')->setWidth(20);  // วันที่เริ่มทำงาน
        
        $writer = new WriterXlsx($spreadsheet);
        $writer->save("upload/export_excel/ข้อมูลผู้ใช้งานทั้งหมดประจำวันที่ ".date('d-m-Y').".xlsx");
        return redirect("upload/export_excel/ข้อมูลผู้ใช้งานทั้งหมดประจำวันที่ ".date('d-m-Y').".xlsx");
    }

    
}



// $targetPath = $request->file('image_name')->getClientOriginalName();
// $request->file('image_name')->move('upload/excel/', $targetPath);

// $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

// $spreadSheet = $Reader->load('upload/excel/'.$targetPath);
// $excelSheet = $spreadSheet->getActiveSheet();
// return $spreadSheetAry = $excelSheet->toArray();

