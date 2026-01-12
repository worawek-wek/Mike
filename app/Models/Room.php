<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // use HasFactory;
    protected $fillable = [
        'name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'rooms';

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'ref_floor_id');
    }
    public function rent_bill()
    {
        return $this->hasMany('App\Models\RentBill', 'ref_room_id', 'id');
    }
    public function rent_bill_booking()
    {
        return $this->hasOne('App\Models\RentBill', 'ref_room_id', 'id')->where('ref_type_id', 3);
    }
    public function rent_bill_deposit()
    {
        return $this->hasOne('App\Models\RentBill', 'ref_room_id', 'id')->where('ref_type_id', 2);
    }
    public function rent_bill_rent()
    {
        return $this->hasOne('App\Models\RentBill', 'ref_room_id', 'id')->where('ref_type_id', 1);
    }
    public function rent_bill_247() // บิลค้างชำระ
    {
        return $this->hasMany('App\Models\RentBill', 'ref_room_id', 'id')->whereIn('ref_status_id', [2,4,7]);
    }
    public function rent_bill_overdue() // บิลค้างชำระ
    {
        return $this->hasMany('App\Models\RentBill', 'ref_room_id', 'id')->whereIn('ref_status_id', [2,4,7]);
    }
    public function room_status()
    {
        return $this->hasOne('App\Models\StatusRoom', 'id', 'status');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'ref_user_id');
    }
    public function contract()
    {
        return $this->hasOne(Contract::class, 'ref_room_id', 'id')
                    ->whereRaw('contracts.occupancy_id = ?', [$this->occupancy_id]);
    }
    public function room_for_rent_main()
    {
        return $this->hasOne(RoomForRents::class, 'ref_room_id', 'id')
                    ->where('status', 1)
                    ->latest('id');
    }
    public function room_for_rent() // สำหรับ ผู้เช่า ปัจจุบัน
    {
        return $this->hasOne('App\Models\RoomForRents', 'occupancy_id', 'occupancy_id');
    }
    public function room_for_rent_s()
    {
        return $this->hasMany('App\Models\RoomForRents', 'ref_room_id', 'id');
    }
    // public function room_has_asset()
    // {
    //     return $this->hasOne('App\Models\RoomForRents', 'ref_room_id', 'id')->where('status', 0);
    // }
    public function room_has_service()
    {
        return $this->hasMany('App\Models\RoomHasService', 'ref_room_id', 'id');
    }
    public function room_has_discount()
    {
        return $this->hasMany('App\Models\RoomHasDiscount', 'ref_room_id', 'id');
    }
    public function meterCurrent()
    {
        return $this->hasOne(Meter::class, 'ref_room_id');
    }

    public function meterPrevious()
    {
        return $this->hasOne(Meter::class, 'ref_room_id');
    }
}
