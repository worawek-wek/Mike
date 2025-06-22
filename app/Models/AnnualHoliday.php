<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualHoliday extends Model
{
    protected $fillable = [
        'name',
        'date',
        'year'
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'annual_holidays';
}
