<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApuestamanomanoUser extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'apuestamanomano_id',
        'user_id',
        'caballo_id',
        'Caballo',

        'resultadoapuesta',
        'Tipo',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'apuestamanomano_users';

    public function apuestamanomano()
    {
        return $this->belongsTo(Apuestamanomano::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function caballo()
    {
        return $this->belongsTo(Caballo::class, 'caballo_id');
    }
}
