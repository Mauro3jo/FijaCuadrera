<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApuestaPolla extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'carrera_id',
        'Ganancia',
        'Caballo1',
        'Monto1',
        'Caballo2',
        'Monto2',
        'Caballo3',
        'Monto3',
        'Caballo4',
        'Monto4',
        'Caballo5',
        'Monto5',
        'Estado',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'apuesta_pollas';

    protected $casts = [
        'Estado' => 'boolean',
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function apuestaPollaUsers()
    {
        return $this->hasMany(ApuestaPollaUser::class);
    }
}
