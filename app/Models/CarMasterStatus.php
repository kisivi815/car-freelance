<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarMasterStatus extends Model
{
    use HasFactory;

    protected $table = 'carmaster_status';

    public $timestamps = false;

    protected $fillable = [
        'id', 
        'ChasisNo', 
        'status', 
        'date'
    ];

}
