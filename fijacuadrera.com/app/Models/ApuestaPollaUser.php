<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApuestaPollaUser extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'apuesta_polla_id',
        'user_id',
        'caballo_id',
        'Resultadoapuesta',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'apuesta_polla_users';

    public function apuestaPolla()
    {
        return $this->belongsTo(ApuestaPolla::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function caballo()
    {
        return $this->belongsTo(Caballo::class);
    }
}
