<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contacto extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['celular', 'HoraDisponible'];

    protected $searchableFields = ['*'];
}
