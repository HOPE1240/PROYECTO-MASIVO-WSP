<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenMensajeMasivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'mensaje_masivo_id',
        'ruta',
    ];

    public function mensaje()
    {
        return $this->belongsTo(MensajeMasivo::class, 'mensaje_masivo_id');
    }
}
