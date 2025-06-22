<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeExpenses extends Model
{
    // use HasFactory;
    protected $fillable = [
        'name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'income_expenses';
    
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'ref_category_id');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'ref_user_id');
    }
    public function room()
    {
        return $this->hasOne('App\Models\Room', 'id', 'ref_room_id');
    }
    public function payment_list()
    {
        return $this->hasMany('App\Models\IncomeList', 'ref_payment_id', 'id');
    }
    public function getTotalAmountAttribute()
    {

        $lists = $this->payment_list; // ใช้ attribute ที่ถูกโหลดแล้ว

        $total = $lists->where('discount', 0)->sum('price');
        $discount = $lists->where('discount', 1)->sum('price');

        return $total - $discount;
    }
}
