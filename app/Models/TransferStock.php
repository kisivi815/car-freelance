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
        'MileageSend',
        'MileageReceive',
        'DriverName', 
        'Note',
        'GatePassId', 
        'DateOfTransfer',
        'SendBy',
        'ReceivedBy',
        'DateOfReceive',
        'ReceiveNote',
        'ApprovedBy',
        'RejectedBy'
    ];

    public function Car()
    {
        return $this->hasOne(Car::class,'ChasisNo','ChasisNo');
    }

    public function CarMaster()
    {
        return $this->hasOne(CarMaster::class,'ChasisNo','ChasisNo');
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

    public function UserSendBy(){
        return $this->hasOne(User::class,'id','SendBy');
    }

    public function UserApprovedBy(){
        return $this->hasOne(User::class,'id','ApprovedBy');
    }

    public function UserRejectedBy(){
        return $this->hasOne(User::class,'id','RejectBy');
    }
}
