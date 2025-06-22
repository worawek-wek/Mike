<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use App\Models\Subdistrict;
use App\Models\Apartment;
use App\Models\Branch;
use App\Models\Leave;
use App\Models\UserHasBranch;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

DB::beginTransaction();

class BranchController extends Controller
{
    public function index(Request $request)
    {
        return view('branch/index');
    }
    public function add(Request $request)
    {
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['subdistrict'] = Subdistrict::get();
        return view('branch/add',$data);
    }
///////////
    public function store(Request $request)
    {
        try{
            $insert = new Branch;
            $insert->name  =  $request->name;
            $insert->address  =  $request->address;
            $insert->ref_province_id  =  $request->ref_province_id;
            $insert->ref_district_id  =  $request->ref_district_id;
            $insert->ref_subdistrict_id  =  $request->ref_subdistrict_id;
            $insert->zipcode  =  $request->zipcode;
            $insert->phone  =  $request->phone;
            $insert->email  =  $request->email;
            $insert->billing_date  =  $request->billing_date;
            $insert->payment_end_date  =  $request->payment_end_date;
            $insert->ref_apartment_id  =  1;
            $insert->ref_user_id  =  Auth::id();
            $insert->save();
            
            // $user_has_branch = UserHasBranch::where('ref_user_id', Auth::id())->oldest()->first();

            // $user = User::whereHas('user_has_branch', function ($query) use ($user_has_branch) {
            //                 $query->where('ref_branch_id', $user_has_branch->ref_branch_id);
            //             })->get();

            // foreach($user as $user_v){
                $uhb = new UserHasBranch;
                $uhb->ref_user_id  =  Auth::id();
                $uhb->ref_branch_id  =  $insert->id;
                $uhb->ref_position_id  =  1;
                $uhb->save();
            // }

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
        $apartment = Apartment::first();
        
        $branch = Branch::whereHas('user_has_branch', function ($query) {
                            $query->where('ref_user_id', Auth::id());
                        })->get();

        foreach($branch as $branch_val){
            $branch_val->summary = $this->summary($branch_val->id);
        }
        $data['apartment'] = $apartment;
        $data['branch'] = $branch;
        return view('branch/manage',$data);
    }
}
