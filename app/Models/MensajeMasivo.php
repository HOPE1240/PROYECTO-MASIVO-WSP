<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeMasivo extends Model // Cambiado a MensajeMasivo
{
    use HasFactory;

    protected $table = 'mensaje_masivos';

    protected $fillable = [
        'titulo',
        'contenido',
        'area_id',
        'variables',
        'ruta_imagen',
        'estado',
    ];

    protected $casts = [
        'variables' => 'array',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function logs()
    {
        return $this->hasMany(LogEnvioMasivo::class, 'mensaje_masivo_id');
    }
}
