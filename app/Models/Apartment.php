<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    // use HasFactory;
    protected $fillable = [
        'apartment_name',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'apartments';
}
