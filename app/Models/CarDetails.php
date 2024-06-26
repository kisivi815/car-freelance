<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDetails extends Model
{
    use HasFactory;

    protected $table = 'car_details';

    protected $fillable = [
        'id',
        'PPL',
        'Fuel',
        'Variant',
        'EmissionNorm',
        'MakersName',
        'HSNCode',
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
        'active',
        'created_at',
        'updated_at',
    ];
}
