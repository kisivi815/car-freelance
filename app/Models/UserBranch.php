<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use App\Models\Image;
use App\Models\Branch;

class UserBranch extends Model
{
    use HasFactory;

    protected $table = 'user_branch';

    public $timestamps = false;


    public function User()
    {
        return $this->belongsTo(User::class,'id','user_id');
    }

}
