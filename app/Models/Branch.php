<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransferStock;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branch';

    public function TransferStockSource(){
        return $this->belongsTo(TransferStock::class, 'SourceBranch' , 'id');
    }

    public function TransferStockDestination(){
        return $this->belongsTo(TransferStock::class, 'DestinationBranch' , 'id');
    }
}
