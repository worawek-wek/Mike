<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();

class WelfareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['page_url'] = 'welfare';
        $data['page'] = 'สวัสดิการ';
        $data['welfare'] = News::find(2);
        
        return view('welfare/index', $data);
    }

    public function datatable(Request $request)
    {
        $results = Welfare::orderBy('id','DESC');
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

        $data['page_url'] = 'welfare';
        $data['list_data'] = $results;

        return view('welfare/table', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Add New Welfare';
        $data['welfare'] = Welfare::get();
        $data['action'] = route('welfare.store');
        return view('welfare/form', $data);
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
            $welfare = new Welfare;
            $welfare->welfare_name = $request->welfare_name;
            $welfare->save();
            
            DB::commit();
            return redirect('welfare-page')->with('message', 'Insert Welfare "'.$request->welfare_name.'" success');
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
        $data['title'] = 'Edit Welfare';
        $data['page_before'] = 'Welfare';
        $data['page'] = 'Edit Welfare';
        $data['welfare'] = Welfare::get();
        $data['action'] = url('welfare/'.$id);
        $data['welfare'] = Welfare::find($id);

        return view('welfare/form', $data);
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
            $welfare = Welfare::find($id);
            $welfare->welfare_name = $request->welfare_name;
            $welfare->save();

            DB::commit();
            return redirect('welfare-page')->with('message', 'Update Welfare "'.$request->welfare_name.'" success');
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
            Welfare::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
        //
    }
}
