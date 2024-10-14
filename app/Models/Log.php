<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'log';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'affected_id',
        'action',
        'log_message',
        'module',
        'created_at',
        'updated_at'
    ];
}
