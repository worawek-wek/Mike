<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work_shift;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();

class WorkShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['page_url'] = 'work_shift';
        $data['page'] = 'กะการทำงาน';
        $data['work_shift'] = Work_shift::get();
        
        return view('work-shift/index', $data);
    }

    public function datatable(Request $request)
    {
        $results = WorkShift::orderBy('id','DESC');
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

        $data['page_url'] = 'work_shift';
        $data['list_data'] = $results;

        return view('work-shift/table', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Add New WorkShift';
        $data['work_shift'] = WorkShift::get();
        $data['action'] = route('work_shift.store');
        return view('work-shift/form', $data);
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
            $work_shift = new WorkShift;
            $work_shift->work_shift_name = $request->work_shift_name;
            $work_shift->save();
            
            DB::commit();
            return redirect('work_shift-page')->with('message', 'Insert WorkShift "'.$request->work_shift_name.'" success');
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
        $data['title'] = 'Edit WorkShift';
        $data['page_before'] = 'WorkShift';
        $data['page'] = 'Edit WorkShift';
        $data['work_shift'] = WorkShift::get();
        $data['action'] = url('work_shift/'.$id);
        $data['work_shift'] = WorkShift::find($id);

        return view('work-shift/form', $data);
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
            $work_shift = WorkShift::find($id);
            $work_shift->work_shift_name = $request->work_shift_name;
            $work_shift->save();

            DB::commit();
            return redirect('work_shift-page')->with('message', 'Update WorkShift "'.$request->work_shift_name.'" success');
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
            WorkShift::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
}
