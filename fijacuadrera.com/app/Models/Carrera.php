<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Carrera extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nombre', 'fecha', 'estado', 'hipico_id', 'imagen'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'fecha' => 'datetime',
        'estado' => 'boolean',
    ];

    public function hipico()
    {
        return $this->belongsTo(Hipico::class);
    }

    public function apuestamanomanos()
    {
        return $this->hasMany(Apuestamanomano::class);
    }

    public function apuestaPollas()
    {
        return $this->hasMany(ApuestaPolla::class);
    }
    public function caballos()
    {
        return $this->belongsToMany(Caballo::class, 'caballo_carrera')->withPivot('resultado');
    }
    }
