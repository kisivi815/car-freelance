<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'Mobile',
        'Saluation',
        'FirstName',
        'LastName',
        'FathersName',
        'Email',
        'Aadhar',
        'PAN',
        'GST',
        'PermanentAddress',
        'TemporaryAddress',
        'ChasisNo',
        'Bank',
        'InsuranceName',
        'DiscountType',
        'Accessories',
        'TypeofGST',
    ];

    
}
