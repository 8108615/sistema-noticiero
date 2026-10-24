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
        'nro_nota',
        'tipo_nota',
        'nombre_nota',
        'titulo',
        'redaccion',
        'orden',
    ];

    /**
     * Relación: Una nota pertenece a una escaleta
     */
    public function escaleta()
    {
        return $this->belongsTo(Escaleta::class, 'escaleta_id');
    }
}