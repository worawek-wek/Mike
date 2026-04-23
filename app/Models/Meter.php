<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    // use HasFactory;
    protected $fillable = [
        'ref_reason_id', // เพิ่มเข้าไปถ้าจะใช้ Mass Assignment
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'meters';
    
    protected $appends = ['reason_name']; // เพื่อให้ reason_name ติดมาด้วยเวลาเรียก toArray()

    public function getReasonNameAttribute()
    {
        return match ($this->ref_reason_id) {
            1 => 'มิเตอร์เต็ม',
            2 => 'เปลี่ยนมิเตอร์',
            default => '',
        };
    }
    public function previousMonthMeter()
    {
        // คำนวณเดือน/ปี ของเดือนที่แล้ว
        $prevMonth = $this->month == 1 ? 12 : $this->month - 1;
        $prevYear = $this->month == 1 ? $this->year - 1 : $this->year;

        return $this->hasOne(Meter::class, 'ref_room_id', 'ref_room_id') // เปลี่ยน key ตามจริง เช่น meter_id หรือ ref_room_id
            ->where('month', $prevMonth)
            ->where('year', $prevYear);
    }
}
