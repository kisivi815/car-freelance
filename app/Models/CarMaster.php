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

    protected $primaryKey = 'ChasisNo';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
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
        'TypeOfFuel',
        'MakersName',
        'NoOfCylinders',
        'SeatingCapacity',
        'CatalyticConverter',
        'UnladenWeight',
        'FrontAxle',
        'RearAxle',
        'AnyOtherAxle',
        'TandemAxle',
        'GrossWeight',
        'TypeOfBody',
        'HorsePower',
        'Rate',
        'TaxableValue',
        'Amount',
    ];

    public function TrasnferStock()
    {
        return $this->belongsTo(TransferStock::class, 'ChasisNo', 'ChasisNo');
    }
}
