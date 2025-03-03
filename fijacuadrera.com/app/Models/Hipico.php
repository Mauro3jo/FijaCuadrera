<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hipico extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nombre', 'direccion', 'imagen'];

    protected $searchableFields = ['*'];

    public function carreras()
    {
        return $this->hasMany(Carrera::class);
    }
}
