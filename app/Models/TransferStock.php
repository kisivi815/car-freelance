<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use App\Models\Image;
use App\Models\Branch;

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
        'ReceivedBy',
        'DateOfReceive',
        'ReceiveNote'
    ];

    public function Car()
    {
        return $this->hasOne(Car::class,'ChasisNo','ChasisNo');
    }

    public function Image()
    {
        return $this->hasMany(Image::class,'transferstockid','id');
    }

    public function Source(){
        return $this->hasOne(Branch::class,'id','SourceBranch');
    }

    public function Destination(){
        return $this->hasOne(Branch::class,'id','DestinationBranch');
    }
}
