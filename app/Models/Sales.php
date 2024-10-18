<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'InvoiceNo',
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
        'DateOfBooking',
        'Status'
    ];

    public function carMaster(){
        return $this->hasOne(CarMaster::class, 'ChasisNo', 'ChasisNo');
    }

    public function bank(){
        return $this->hasOne(Bank::class, 'ID', 'Bank');
    }

    public function insurance(){
        return $this->hasOne(Insurance::class, 'ID', 'InsuranceName');
    }

    public function discount(){
        return $this->hasOne(Discount::class, 'ID', 'DiscountType');
    }

    public function accessoriesFile(){
        return $this->hasMany(SaleAccesoriesFile::class, 'salesId', 'ID');
    }
}
