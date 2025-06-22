<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    // use HasFactory;
    protected $fillable = [
        'name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'assets';

    public function room_has_asset()
    {
        return $this->hasOne('App\Models\RoomHasAsset', 'ref_asset_id', 'id');
    }
}
