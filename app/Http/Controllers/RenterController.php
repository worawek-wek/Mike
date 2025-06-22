<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\User;
use App\Models\Position;
use App\Models\Branch;
use App\Models\Renter;
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

class RenterController extends Controller
{
    public function index(Request $request)
    {
        $data['page_url'] = 'renter';
        $data['page_url2'] = 'renter/current';
        return view('renter/index', $data);
    }
    public function current_datatable(Request $request)
    {
        $results = Renter::whereHas('room_for_rent.room', function ($query) {
                                                    $query->whereIn('status', [2,3]);
                                                })
                                // ->with('room_for_rent.room')
                                ->distinct('renters.id');
        if(@$request->search){
            $results = $results->where(function ($query) use ($request) {
                $query->where('renters.prefix','LIKE','%'.$request->search.'%')
                    ->orWhere('renters.name','LIKE','%'.$request->search.'%')
                    ->orWhere('renters.surname','LIKE','%'.$request->search.'%')
                    ->orWhere('renters.phone','LIKE','%'.$request->search.'%');
            });
        }
        // $results = RentBill::orderBy('rent_bills.id','DESC')
        //                         ->join('room_for_rents', 'rent_bills.ref_room_for_rent_id', '=', 'room_for_rents.id')
        //                         ->join('renters', 'room_for_rents.ref_renter_id', '=', 'renters.id')
        //                         ->join('rooms', 'room_for_rents.ref_room_id', '=', 'rooms.id')
        //                         ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
        //                         ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
        //                         ->where('buildings.ref_branch_id', session("branch_id"))
        //                         // ->where('rent_bills.ref_status_id', '!=', 3)
        //                         ->distinct('rent_bills.id')
        //                         ->select('rent_bills.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
        
        // if(@$request->search){
        //     $results = $results->Where(function ($query) use ($request) {
        //                             $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', renters.surname) LIKE ?", ["%{$request->search}%"])
        //                                 ->orWhere('rooms.name','LIKE','%'.$request->search.'%')
        //                                 ->orWhere('rent_bills.current_number','LIKE','%'.$request->search.'%');
        //                         });
        // }
        // if(@$request->ref_status_id != "all"){
        //     $results = $results->Where('rent_bills.ref_status_id', $request->ref_status_id);
        // }
        // if(@$request->ref_type_id != "all"){
        //     $results = $results->Where('rent_bills.ref_type_id', $request->ref_type_id);
        // }
        // if(@$request->month_from){

        //     $monthFrom = $request->month_from; // format: YYYY-MM
        //     $monthTo = $request->month_to;     // format: YYYY-MM

        //     // สร้างช่วงวันที่เต็ม (เริ่มต้นเดือน ถึง สิ้นเดือน)
        //     $startDate = Carbon::parse($monthFrom)->startOfMonth()->toDateString(); // 2025-06-01
        //     $endDate = Carbon::parse($monthTo)->endOfMonth()->toDateString();       // 2025-06-30

        //     $results = $results->whereBetween('rent_bills.created_at', [$startDate, $endDate]);
        // }

      
        
        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;
        
        // if(@$request->re){
        //     return $data['list_data'];
        // }


        return view('renter/current-table', $data);
    }
    public function old_datatable(Request $request)
    {
        $results = Renter::whereHas('room_for_rent.room', function ($query) {
                                                    $query->whereIn('status', [0]);
                                                })
                                // ->with('room_for_rent.room')
                                ->distinct('renters.id');
        // $results = Receipt::orderBy('olds.id','DESC')
        //                         // ->join('room_for_rents', 'olds.ref_room_for_rent_id', '=', 'room_for_rents.id')
        //                         ->join('renters', 'olds.ref_renter_id', '=', 'renters.id')
        //                         ->join('rooms', 'olds.ref_room_id', '=', 'rooms.id')
        //                         ->join('floors', 'rooms.ref_floor_id', '=', 'floors.id')
        //                         ->join('buildings', 'floors.ref_building_id', '=', 'buildings.id')
        //                         ->where('buildings.ref_branch_id', session("branch_id"))
        //                         // ->where('olds.ref_status_id', '!=', 3)
        //                         ->distinct('olds.id')
        //                         ->select('olds.*', 'renters.prefix' , DB::raw('CONCAT(renters.name, " ", COALESCE(renters.surname, "")) as renter_name'), 'rooms.name as room_name', 'rooms.rent');
        
        // if(@$request->search){
        //     $results = $results->Where(function ($query) use ($request) {
        //                             $query->whereRaw("CONCAT(renters.prefix ,' ' , renters.name, ' ', renters.surname) LIKE ?", ["%{$request->search}%"])
        //                                 ->orWhere('rooms.name','LIKE','%'.$request->search.'%')
        //                                 ->orWhere('olds.old_number','LIKE','%'.$request->search.'%');
        //                         });
        // }
        // // if(@$request->ref_status_id != "all"){
        // //     $results = $results->Where('olds.ref_status_id', $request->ref_status_id);
        // // }
        // if(@$request->ref_type_id != "all"){
        //     $results = $results->Where('olds.ref_type_id', $request->ref_type_id);
        // }
        // if(@$request->month_from){
            
        //     $monthFrom = $request->month_from; // format: YYYY-MM
        //     $monthTo = $request->month_to;     // format: YYYY-MM

        //     // สร้างช่วงวันที่เต็ม (เริ่มต้นเดือน ถึง สิ้นเดือน)
        //     $startDate = Carbon::parse($monthFrom)->startOfMonth()->toDateString(); // 2025-06-01
        //     $endDate = Carbon::parse($monthTo)->endOfMonth()->toDateString();       // 2025-06-30

        //     $results = $results->whereBetween('olds.created_at', [$startDate, $endDate]);
        // }
        

        $limit = 15;
        if(@$request['limit']){
            $limit = $request['limit'];
        }

        return $results = $results->paginate($limit);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $data['query']['limit'] = $limit;

        $data['list_data'] = $results;
        
        // if(@$request->re){
        //     return $data['list_data'];
        // }


        return view('renter/old-table', $data);
    }
}
