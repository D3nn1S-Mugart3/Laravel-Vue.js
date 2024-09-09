<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Controluser extends Model
{
    use HasFactory;

    protected $table = 'controluser';

    protected $fillable = [
        'nombre',
        'apellidos',
        'rol',
        'estatus',
        'fecha_alta',
        'fecha_baja',
        'fecha_modificacion'
    ];

    public function loginCredentials()
    {
        return $this->hasOne(LoginCredentials::class, 'controluser_id');
    }
}
