<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearBalance extends Model
{
    // use HasFactory;
    protected $fillable = [
        'name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'clear_balances';

    public function room()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'ref_branch_id');
    }
}
