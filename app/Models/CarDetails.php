<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDetails extends Model
{
    use HasFactory;

    protected $table = 'car_details';

    /* protected $fillable = [
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
    ]; */
}
