<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use App\Models\Subdistrict;
use App\Models\Schedule;
use App\Models\Leave;
use App\Models\UserLeave;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

DB::beginTransaction();

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        return view('building/index');
    }
    public function add(Request $request)
    {
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['subdistrict'] = Subdistrict::get();
        return view('building/add',$data);
    }
///////////
    public function store(Request $request)
    {
        $work_start_date = Carbon::createFromFormat('d/m/Y', $request->work_start_date)->format('Y-m-d');
        try{

            $user = new Building;
            $user->name  =  $request->name;
            $user->address  =  $request->address;
            $user->ref_province_id  =  $request->ref_province_id;
            $user->ref_district_id  =  $request->ref_district_id;
            $user->ref_subdistrict_id  =  $ref_subdistrict_id;
            $user->zipcode  =  $request->zipcode;
            $user->phone  =  $request->phone;
            $user->email  =  $request->email;
            $user->billing_date  =  $request->billing_date;
            $user->payment_end_date  =  $request->payment_end_date;
            $user->save();
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
            return false;
        }
        //
    }
///////////
    public function manage(Request $request)
    {
        return view('building/manage');
    }
}
