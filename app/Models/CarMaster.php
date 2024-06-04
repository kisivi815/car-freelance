<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransferStock;

class CarMaster extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'carmaster';

    public function TrasnferStock()
    {
        return $this->belongsTo(TransferStock::class,'ChasisNo','ChasisNo');
    }
}
