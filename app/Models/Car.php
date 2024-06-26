<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransferStock;

class Car extends Model
{
    use HasFactory;

    protected $table = 'car';

    protected $fillable = [
        'ID',
        'ChasisNo',
        'Model',
        'ProductLine',
        'Colour',
        'PhysicalStatus',
        'EngineNo',
        'EmissionNorm',
        'ManufacturingDate',
        'TMInvoiceDate',
        'CommercialInvoiceNo',
        'HSNCode',
        'active',
        'created_at',
        'updated_at',
    ];

    public function TrasnferStock()
    {
        return $this->belongsTo(TransferStock::class, 'ChasisNo', 'ChasisNo');
    }
}
