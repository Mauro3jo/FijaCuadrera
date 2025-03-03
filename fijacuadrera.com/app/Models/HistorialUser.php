<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialUser extends Model
{
    use HasFactory;

    protected $table = 'historialusers';

    protected $fillable = [
        'semana',
        'a_depositar',
        'total_depositado',
        'saldo',
        'gano',
        'perdio',
        'comision',
        'SALDO_NEGATIVO',
        'SALDO_POSITIVO',
        'OBSERVACION',
        'INICIO',
        'FIN',
        'user_id',     'SaldoAnterior',
        'Diferencia',
        'SaldoFinal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
