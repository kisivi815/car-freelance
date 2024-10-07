<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $table = 'insurance';

    public function sales(){
        return $this->belongsTo(Sales::class, 'InsuranceName', 'ID');
    }
}
