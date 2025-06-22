<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    // use HasFactory;
    protected $fillable = [
        'branch_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'branchs';

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
    public function user_has_branch()
    {
        return $this->hasOne('App\Models\UserHasBranch', 'ref_branch_id', 'id');
    }

    public function fullThaiAddress()
    {
        $subdistrict = $this->subdistrict?->name_in_thai ?? '';
        $district = $this->district?->name_in_thai ?? '';
        $province = $this->province?->name_in_thai ?? '';

        return trim("ต.{$subdistrict} อ.{$district} จ.{$province}");
    }
}
