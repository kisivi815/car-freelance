<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;

class QuickSales extends Model
{
    use HasFactory;

    protected $table = 'quick_sales';

    protected $fillable = [
        'ID',
        'SalesId', 
        'ChasisNo', 
        'SalesPersonName', 
        'Branch', 
        'CustomerMobileNo', 
        'CustomerName',
        'DateOfBooking',
        'TMInvoiceNo', 
        'created_at',
        'updated_at',
    ];

    public function SalesBranch(){
        return $this->hasOne(Branch::class,'id','Branch');
    }

    public function CarMaster()
    {
        return $this->hasOne(CarMaster::class,'ChasisNo','ChasisNo');
    }

}
