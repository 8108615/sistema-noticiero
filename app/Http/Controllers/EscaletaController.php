<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escaleta;

class EscaletaController extends Controller
{
    /**
     * Muestra la pantalla para elegir el programa (Revista, Meridiano, Central) según la fecha
     */
    public function seleccionarPrograma($fecha)
    {
        // Obtenemos qué programas ya tienen escaleta creada para esta fecha
        $escaletasCreadas = Escaleta::where('fecha', $fecha)->pluck('programa')->toArray();

        return view('admin.escaletas.seleccionar-programa', compact('fecha', 'escaletasCreadas'));
    }
}
