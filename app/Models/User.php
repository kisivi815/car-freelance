<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function UserBranch()
    {
        return $this->hasMany(UserBranch::class,'user_id','id');
    }

    public function TransferStockSendBy()
    {
        return $this->hasOne(TransferStock::class,'SendBy','id');
    }

    public function TransferStockApprovedBy()
    {
        return $this->hasOne(TransferStock::class, 'ApprovedBy', 'id');
    }

    public function TransferStockRejectedBy()
    {
        return $this->hasOne(TransferStock::class, 'RejectedBy', 'id');
    }
}
