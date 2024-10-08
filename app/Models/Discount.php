<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discount';

    public function sales(){
        return $this->belongsTo(Sales::class, 'ID', 'DiscountType');
    }
}
