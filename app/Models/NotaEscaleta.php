<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaEscaleta extends Model
{
    use HasFactory;

    protected $table = 'notas_escaleta';

    protected $fillable = [
        'escaleta_id',
        'user_id',
        'nro_nota',
        'tipo_nota',
        'nombre_nota',
        'periodista',
        'titulo',
        'redaccion',
        'orden',
    ];

    public function escaleta()
    {
        return $this->belongsTo(Escaleta::class, 'escaleta_id');
    }

    // Relación con el usuario que registró la nota
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}