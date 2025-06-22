<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Position;
use App\Models\Work_shift;
use App\Models\Schedule;
use App\Models\Leave;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

DB::beginTransaction();

class UserSettingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['news'] = News::find(1);
        $data['page_url'] = 'user-setting';
        $data['work_shift'] = Work_shift::get();
        // $data['title'] = 'Profile';
        
        return view('user-setting/index', $data);
    }
    public function work_shifts(Request $request)
    {
        try{
            // return true;

            // return $request->delete_id;
            // return explode(',',$request->delete_id[0]);

            foreach($request->work_shift as $key => $w_s){
                // return $w_s["work_shift_name"];
                if($key == 'insert'){
                    $work_shift = new Work_shift;
                    if($w_s['work_shift_name'] == null){
                        continue;
                    } 
                }else{
                    $work_shift = Work_shift::find($key);
                }
                $work_shift->work_shift_name = $w_s['work_shift_name'];
                $work_shift->from_time = $w_s['from_time'];
                $work_shift->to_time = $w_s['to_time'];
                $work_shift->save();

            }

                Work_shift::destroy(explode(',',$request->delete_id[0]));
            
            $data['work_shift'] = Work_shift::get();
            
            DB::commit();
            // $data['news_detail'] = $user->detail;
            return view('work-shift/form', $data);
            // return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
    public function profile($id = null)
    {
        if($id){
            $user = User::find($id);
        }else{
            $user = Auth::user();
        }

        $user->position_name = Position::find($user->ref_position_id)->position_name;
        $data['page_url'] = 'user';
        $data['title'] = 'Profile';
        $data['user'] = $user;
        
        return view('user/profile', $data);
    }

    public function datatable(Request $request)
    {
        $results = User::orderBy('id','DESC');
        // return 123;
        if(@$request->search){
            $results = $results->Where('name','LIKE','%'.$request->search.'%');
        }
        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $results = $results->with('position')->paginate($limit);
        // return $results->items();
        // dd($results);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['page_url'] = 'user';
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
