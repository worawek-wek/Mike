<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    // use HasFactory;
    protected $fillable = [
        'receipt_number',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'receipts';
    
    public function renter()
    {
        return $this->hasOne('App\Models\Renter', 'id', 'ref_renter_id');
    }
    public function status()
    {
        return $this->hasOne('App\Models\StatusRentBill', 'id', 'ref_status_id');
    }
    public function bank()
    {
        return $this->hasOne('App\Models\Bank', 'id', 'ref_bank_id');
    }
    public function invoice()
    {
        return $this->hasOne('App\Models\RentBill', 'id', 'ref_rent_bill_id');
    }
    public function receipt_move_out() // บิลย้ายออก
    {
        return $this->hasOne(Receipt::class, 'ref_contract_id', 'ref_contract_id')->where('ref_type_id', 4);
    }
    public function deposit_move_out() // บิลคืนเงินประกิน
    {
        return $this->hasOne(RentBill::class, 'ref_contract_id', 'ref_contract_id')->where('ref_type_id', 6);
    }
    public function room()
    {
        return $this->hasOne('App\Models\Room', 'id', 'ref_room_id');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'ref_user_id');
    }
    public function payment_list()
    {
        return $this->hasMany('App\Models\PaymentList', 'ref_payment_id', 'id')->where('document_type', 2);
    }
    public function payment_list_fine()
    {
        return $this->hasMany('App\Models\PaymentList', 'ref_payment_id', 'id')->where('fine', 5)->where('document_type', 2); // จริง ๆ ต้อง fine = 1
    }
    public function payment_list_not_fine()
    {
        return $this->hasMany('App\Models\PaymentList', 'ref_payment_id', 'id')->where('fine', 0)->where('document_type', 2);
    }
    public function getTotalAmountAttribute()
    {

        $lists = $this->payment_list; // ใช้ attribute ที่ถูกโหลดแล้ว

        $total = $lists->where('discount', 0)->sum('price');
        $discount = $lists->where('discount', 1)->sum('price');

        return $total - $discount;
    }
    public function getTotalFineAmountAttribute()
    {
        $lists = $this->payment_list_fine; // ใช้ความสัมพันธ์ fine=1

        $total = $lists->where('discount', 0)->sum('price');
        $discount = $lists->where('discount', 1)->sum('price');

        return $total - $discount;
    }
    public function getTotalNotFineAmountAttribute()
    {
        $lists = $this->payment_list_not_fine;

        $total = $lists->where('discount', 0)->sum('price');
        $discount = $lists->where('discount', 1)->sum('price');

        return $total - $discount;
    }
    public function getTotalNotDiscountAmountAttribute()
    {
        return $this->payment_list->where('discount', 0)->sum('price');
    }
}
