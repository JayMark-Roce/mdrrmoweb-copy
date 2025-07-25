<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Driver extends Authenticatable
{
    use Notifiable;

protected $fillable = [
    'name',
    'email',
    'password',
    'ambulance_id', // 💥 Don't forget this!
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function ambulance()
{
    return $this->belongsTo(Ambulance::class);
}

}
