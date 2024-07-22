<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'created_at',
        'updated_at',
    ];

}
