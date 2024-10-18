<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleAccesoriesFile extends Model
{
    use HasFactory;

    protected $table = 'saleAccesoriesFile';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'filename', 
        'salesId'
    ];

    public function sales()
    {
        return $this->belongsTo(Sales::class,'ID','salesId');
    }

}
