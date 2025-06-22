<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalCosts extends Model
{
    // use HasFactory;
    protected $fillable = [
        'title',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'additional_costs';
}
