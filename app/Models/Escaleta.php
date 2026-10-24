<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escaleta extends Model
{
    use HasFactory;

    protected $table = 'escaletas';

    protected $fillable = [
        'fecha',
        'programa',
        'titulo_programa',
        'estado',
    ];

    /**
     * Relación: Una escaleta tiene muchas notas
     */
    public function notas()
    {
        return $this->hasMany(NotaEscaleta::class, 'escaleta_id');
    }
}