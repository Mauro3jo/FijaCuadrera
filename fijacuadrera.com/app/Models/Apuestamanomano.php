<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apuestamanomano extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'carrera_id',
        'Ganancia',
        'Caballo1',
        'Caballo2', 
        'Monto1',
        'Monto2',
        'Tipo',
        'Estado',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'Estado' => 'boolean',
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function apuestamanomanoUsers()
    {
        return $this->hasMany(ApuestamanomanoUser::class);
    }
    
}
