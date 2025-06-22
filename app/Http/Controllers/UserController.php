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
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $data['position'] = Position::get();
        // $data['title'] = 'Profile';
        
        return view('register/index', $data);
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
        $data['leave'] = Leave::get();
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
            $user = new User;
            $user->name  =  $request->name;
            $user->username  =  $request->username;
            $user->salary  =  preg_replace('/\D/', '', $request->salary);
            $user->phone  =  $request->phone;
            $user->email  =  $request->email;
            $user->work_start_date  =  $work_start_date;
            $user->ref_position_id  =  $request->ref_position_id;
            $user->ref_user_id  =  $request->ref_user_id ?? 0;
            $user->remark  =  $request->remark;
            // $user->ref_branch_id  =  session("branch_id");
            $user->password = Hash::make($request->password);
            $user->save();

            $uhb = new UserHasBranch;
            $uhb->ref_user_id  =  $user->id;
            $uhb->ref_branch_id  =  session("branch_id");
            $uhb->ref_position_id  =  $request->ref_position_id;
            $uhb->save();

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
    
     public function edit($id)
     {
        $data['page_url'] = 'user';
        $data['position'] = Position::get();
        $data['user'] = User::find($id);
        return view('user/view', $data);
     }

     public function check_user($email)
     {
        $data['page_url'] = 'user';
        $user_has_branch = UserHasBranch::where('ref_branch_id', session("branch_id"))->pluck('ref_user_id')->toArray();
        $user = User::whereNotIn('id', $user_has_branch)->where('email', $email)->first();
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
        // ตัวอย่างข้อมูล
        $results = User::orderBy('id','DESC')->get();
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
                        $row->work_start_date,

                        
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

    
}



// $targetPath = $request->file('image_name')->getClientOriginalName();
// $request->file('image_name')->move('upload/excel/', $targetPath);

// $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

// $spreadSheet = $Reader->load('upload/excel/'.$targetPath);
// $excelSheet = $spreadSheet->getActiveSheet();
// return $spreadSheetAry = $excelSheet->toArray();

