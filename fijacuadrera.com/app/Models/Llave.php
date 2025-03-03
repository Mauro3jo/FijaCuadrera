<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Llave extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_de_llave',
        'caballo_1_1',
        'caballo_2_1',
        'caballo_1_2',
        'caballo_2_2',
        'caballo_1_3',
        'caballo_2_3',
        'caballo_1_4',
        'caballo_2_4',
        'caballo_1_5',
        'caballo_2_5',
        'caballo_1_6',
        'caballo_2_6',
        'caballo_1_7',
        'caballo_2_7',
        'caballo_1_8',
        'caballo_2_8',
        'caballo_1_9',
        'caballo_2_9',
        'caballo_1_10',
        'caballo_2_10',
        'valor',
        'premio',
        'estado',
    ];

    public function llaveUser()
    {
        return $this->hasOne(LlaveUser::class);
    }
}

