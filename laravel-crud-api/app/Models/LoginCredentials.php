<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginCredentials extends Model
{
    use HasFactory;

    protected $table = 'login_credentials';

    protected $fillable = [
        'controluser_id',
        'email',
        'password'
    ];

    public function controlUser()
    {
        return $this->belongsTo(Controluser::class, 'controluser_id');
    }
}
