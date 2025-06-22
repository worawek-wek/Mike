<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    // use HasFactory;
    protected $fillable = [
        'name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'renters';
    
    public function province()
    {
        return $this->belongsTo(\App\Models\Province::class, 'ref_province_id');
    }
    
    public function district()
    {
        return $this->belongsTo(\App\Models\District::class, 'ref_district_id');
    }
    
    public function subdistrict()
    {
        return $this->belongsTo(\App\Models\Subdistrict::class, 'ref_subdistrict_id');
    }

    public function room_for_rent()
    {
        return $this->hasOne('App\Models\RoomForRents', 'ref_renter_id', 'id');
    }

    public function fullThaiAddress()
    {
        $subdistrict = $this->subdistrict?->name_in_thai ?? '';
        $district = $this->district?->name_in_thai ?? '';
        $province = $this->province?->name_in_thai ?? '';

        return trim("ต.{$subdistrict} อ.{$district} จ.{$province}");
    }
    
}
