<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LlaveUser extends Model
{
    use HasFactory;

    protected $table = 'llave_user'; // <-- Aquí especificas el nombre de la tabla

    protected $fillable = [
        'llave_id',
        'user_id',
        'combinacion',
        'estado',
    ];

    public function llave()
    {
        return $this->belongsTo(Llave::class);
    }
}


