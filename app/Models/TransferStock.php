<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;

class TransferStock extends Model
{
    use HasFactory;

    protected $table = 'transferstock';

    public $timestamps = false;

    protected $fillable = [
        'ChasisNo', 
        'SourceBranch', 
        'DestinationBranch', 
        'DriverName', 
        'Note',
        'GatePassId', 
        'DateOfTransfer',
        'SendBy',
    ];

    public function Car()
    {
        return $this->hasOne(Car::class,'ChasisNo','ChasisNo');
    }


}
