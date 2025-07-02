<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\IncomeExpenses;
use App\Models\Room;
use App\Models\Branch;
use App\Models\Work_shift;
use App\Models\Category;
use App\Models\IncomeList;
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

class IncomeExpensesController extends Controller
{
    public function index(Request $request)
    {
        $data['page_url'] = 'income-expenses';
        $data['room'] = Room::orderBy('rooms.name', 'ASC')
                            ->whereHas('floor.building', function ($query) {
                                $query->where('ref_branch_id', session("branch_id"));
                            })->get();
        $data['category'] = Category::get();
        $income = IncomeExpenses::where('type', 1)->sum('amount');
        $expenses = IncomeExpenses::where('type', 2)->sum('amount');
        $data['income'] = $income;
        $data['expenses'] = $expenses;
        $data['total'] = $income-$expenses;
        // $data['title'] = 'Profile';
        
        return view('income-expenses/index', $data);
    }
    public function datatable(Request $request)
    {
        $results = IncomeExpenses::orderBy('id','DESC')
                                    ->where('ref_branch_id', session("branch_id"));
        
        if(@$request->search){
            $results = $results->Where(function ($query) use ($request) {
                                    $query->where('label','LIKE','%'.$request->search.'%');
                                        // ->orWhere('email','LIKE','%'.$request->search.'%');
                                });
        }

        if(@$request->ref_category_id != "all"){
            $results = $results->Where('ref_category_id', $request->ref_category_id);
        }

        if(@$request->type != "all"){
            $results = $results->Where('type', $request->type);
        }

        if(@$request->from_month){
            $to_month = 2000-01;
            if(@$request->to_month){
                $to_month = $request->to_month;
            }
            $results = $results->whereRaw("DATE_FORMAT(date, '%Y-%m') BETWEEN ? AND ?", [$request->from_month, $to_month]);
        }
        // if(@$request->to_month){
        //     $results = $results->WhereDate('date', '<=', $request->to_month);
        // }

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $results = $results->paginate($limit);
        // return $results[0]->room;
        // return $results->items();
        // dd($results);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;
        $data['list_data'] = $results;

        return view('income-expenses/table', $data);
    }
    public function store(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        try{
            $expenses = new IncomeExpenses;
            $expenses->type  =  $request->type;
            $expenses->label  =  $request->label;
            $expenses->amount  =  $request->amount ?? 0;
            $expenses->date  =  $date;
            $expenses->ref_category_id  =  $request->ref_category_id ?? 1;
            $expenses->ref_room_id  =  $request->ref_room_id;
            $expenses->name  =  $request->name;
            $expenses->address  =  $request->address;
            $expenses->id_card_number  =  $request->id_card_number;
            $expenses->branch  =  $request->branch;
            $expenses->phone  =  $request->phone;
            $expenses->remark  =  $request->remark;
            $expenses->ref_branch_id  =  session("branch_id");

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // return $request->file('proof_of_payment');
            if($request->file('proof_of_payment')){
                // return 123;
                $file = $request->file('proof_of_payment');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/expenses/";
                $proof_of_payment = $img_name.rand().'.'.$extension;
                $expenses->proof_of_payment = $proof_of_payment;
            }
            // return 999;
            if($request->file('payment_voucher')){
                // return 123;
                $file = $request->file('payment_voucher');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/expenses/";
                $payment_voucher = $img_name.rand().'.'.$extension;
                $expenses->payment_voucher = $payment_voucher;
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $expenses->ref_user_id  =  Auth::id();
            $expenses->save();
            
            if(@$request->payment_sd_list['title']){
                foreach($request->payment_sd_list['title'] as $key => $payment_sd_list_title){

                    $pay_list = new IncomeList;
                    $pay_list->title  =  $payment_sd_list_title;
                    $pay_list->price  =  $request->payment_sd_list['price'][$key];
                    $pay_list->ref_payment_id  =  $expenses->id;
                    $pay_list->discount  =  $request->payment_sd_list['discount'][$key];
                    $pay_list->save();
                    
                
                }
            }
            
            DB::commit();
            return 1;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function show($id)
    {
        $data['page_url'] = 'income-expenses';
        $data['income_expenses'] = IncomeExpenses::find($id);
        return view('income-expenses/view-expenses', $data);
    }
    public function summary_IE()
    {
        $income = IncomeExpenses::with('payment_list')->where('type', 1)->get()->sum('total_amount') + IncomeExpenses::with('payment_list')->get()
                                                                                                                    ->sum(function ($item) {
                                                                                                                        return $item->getTotalFromPaymentList();
                                                                                                                    });
        $expenses = IncomeExpenses::where('type', 2)->sum('amount');
        $data['income'] = $income;
        $data['expenses'] = $expenses;
        $data['total'] = $income-$expenses;

        return view('income-expenses/summary', $data);
    }


    public function exportExcel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $results = IncomeExpenses::orderBy('id','DESC');
        
        if(@$request->search){
            $results = $results->Where(function ($query) use ($request) {
                                    $query->where('label','LIKE','%'.$request->search.'%');
                                        // ->orWhere('email','LIKE','%'.$request->search.'%');
                                });
        }

        if(@$request->ref_category_id != "all"){
            $results = $results->Where('ref_category_id', $request->ref_category_id);
        }

        if(@$request->type != "all"){
            $results = $results->Where('type', $request->type);
        }

        if(@$request->from_month){
            $to_month = 2000-01;
            if(@$request->to_month){
                $to_month = $request->to_month;
            }
            $results = $results->whereRaw("DATE_FORMAT(date, '%Y-%m') BETWEEN ? AND ?", [$request->from_month, $to_month]);
        }

        $results = $results->get();
        
        $data = 
        [
            ['รายรับ-รายจ่าย'],
            [
                'รายงานรายรับ - รายจ่ายประจำ วันที่ '.date('d/m/Y')
            ],
            [
                "ลำดับ",
                "เลขที่ใบเสร็จ",
                "รายละเอียด",
                "ห้อง",
                "หมวดหมู่",
                "จำนวนเงิน",
                "โดย"
            ]
        ];
        foreach($results as $key=>$row){
            $data[] = [
                        $key+1,
                        date('d/m/Y',strtotime($row->date)),
                        @$row->label,
                        @$row->room->name,
                        @$row->category->name,
                        number_format($row->amount,2),
                        $row->user->name,

                        
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
        $writer->save("upload/export_excel/รายรับรายจ่าย".date('m-Y', strtotime('-1 month')).".xlsx");
        return redirect("upload/export_excel/รายรับรายจ่าย".date('m-Y', strtotime('-1 month')).".xlsx");
    }
}
