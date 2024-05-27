<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransferStock;

class Car extends Model
{
    use HasFactory;

    protected $table = 'car';

    public function TrasnferStock()
    {
        return $this->belongsTo(TransferStock::class,'ChasisNo','ChasisNo');
    }
}
