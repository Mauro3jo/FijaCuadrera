<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caballo extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nombre', 'edad', 'Raza', 'imagen'];

    protected $searchableFields = ['*'];

    public function apuestamanomanoUsers()
    {
        return $this->hasMany(ApuestamanomanoUser::class);
    }

    public function apuestaPollaUsers()
    {
        return $this->hasMany(ApuestaPollaUser::class);
    }
    public function carreras()
{
    return $this->belongsToMany(Carrera::class, 'caballo_carrera')->withPivot('resultado');
}


   
}
