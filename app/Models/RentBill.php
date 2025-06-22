<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentBill extends Model
{
    // use HasFactory;
    protected $fillable = [
        'invoice_number',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'rent_bills';
    
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'ref_user_id');
    }
    public function room_for_rent()
    {
        return $this->hasOne('App\Models\RoomForRents', 'id', 'ref_room_for_rent_id');
    }
    public function additional_costs()
    {
        return $this->hasMany('App\Models\AdditionalCosts', 'ref_rent_bill_id', 'id');
    }
    public function receipt()
    {
        return $this->hasMany('App\Models\Receipt', 'ref_rent_bill_id', 'id');
    }
    public function status()
    {
        return $this->hasOne('App\Models\StatusRentBill', 'id', 'ref_status_id');
    }
    public function payment_list()
    {
        return $this->hasMany('App\Models\PaymentList', 'ref_payment_id', 'id')->where('document_type', 1);
    }
    public function getTotalAmountAttribute()
    {

        $lists = $this->payment_list; // ใช้ attribute ที่ถูกโหลดแล้ว

        $total = $lists->where('discount', 0)->sum('price');
        $discount = $lists->where('discount', 1)->sum('price');


        return $total - $discount;
    }
}
