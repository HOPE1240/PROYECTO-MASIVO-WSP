<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEnvioMasivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'mensaje_masivo_id',
        'cliente_id',
        'mensaje_final',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function mensaje()
    {
        return $this->belongsTo(MensajeMasivo::class, 'mensaje_masivo_id');
    }
}
