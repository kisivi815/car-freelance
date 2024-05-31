<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'image';

    public $timestamps = false;

    protected $fillable = [
        'id', 
        'imageurl', 
        'type', 
        'transferstockid'
    ];

    public function TrasnferStock()
    {
        return $this->belongsTo(TransferStock::class,'id','transferstockid');
    }

}
