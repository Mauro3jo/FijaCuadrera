<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formapago extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['cbu', 'alias'];

    protected $searchableFields = ['*'];
}
