<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function mensajes()
    {
        return $this->hasMany(MensajeMasivo::class);
    }
}
