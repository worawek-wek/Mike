<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLeave;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();

class UserLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_url'] = 'user_leave';
        $data['page'] = 'ลา';
        
        return view('user_leave/index', $data);
    }

    public function datatable(Request $request)
    {
        $results = UserLeave::orderBy('id','DESC');
        // if(@$request->brand_name){
        //     $results = $results->Where('brand_name','LIKE','%'.$request->brand_name.'%');
        // }
        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['page_url'] = 'user_leave';
        $data['list_data'] = $results;

        return view('user_leave/table', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Add New UserLeave';
        $data['user_leave'] = UserLeave::get();
        $data['action'] = route('user_leave.store');
        return view('user_leave/form', $data);
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
            $user_leave = new UserLeave;
            $user_leave->user_leave_name = $request->user_leave_name;
            $user_leave->save();
            
            DB::commit();
            return redirect('user_leave-page')->with('message', 'Insert UserLeave "'.$request->user_leave_name.'" success');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['title'] = 'Edit UserLeave';
        $data['page_before'] = 'UserLeave';
        $data['page'] = 'Edit UserLeave';
        $data['user_leave'] = UserLeave::get();
        $data['action'] = url('user_leave/'.$id);
        $data['user_leave'] = UserLeave::find($id);

        return view('user_leave/form', $data);
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
        //
        try{
            $user_leave = UserLeave::find($id);
            $user_leave->user_leave_name = $request->user_leave_name;
            $user_leave->save();

            DB::commit();
            return redirect('user_leave-page')->with('message', 'Update UserLeave "'.$request->user_leave_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
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
            UserLeave::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
}
