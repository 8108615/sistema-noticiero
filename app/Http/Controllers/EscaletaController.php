<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escaleta;
use App\Models\NotaEscaleta;

class EscaletaController extends Controller
{
    public function seleccionarPrograma($fecha)
    {
        $escaletasCreadas = Escaleta::where('fecha', $fecha)->pluck('programa')->toArray();
        return view('admin.escaletas.seleccionar-programa', compact('fecha', 'escaletasCreadas'));
    }

    // 1. Muestra la tabla de la escaleta
    public function show($fecha, $programa)
    {
        $escaleta = Escaleta::firstOrCreate(
            ['fecha' => $fecha, 'programa' => $programa],
            ['estado' => 'Borrador']
        );

        $notas = $escaleta->notas()->orderBy('nro_nota', 'asc')->get();

        return view('admin.escaletas.show', compact('escaleta', 'notas', 'fecha', 'programa'));
    }

    // 2. Formulario para crear una nueva nota
    public function createNota($escaleta_id)
    {
        $escaleta = Escaleta::findOrFail($escaleta_id);
        $siguienteNro = $escaleta->notas()->max('nro_nota') + 1;

        return view('admin.escaletas.create_nota', compact('escaleta', 'siguienteNro'));
    }

    // 3. Guardar la nueva nota y redirigir al listado
    public function storeNota(Request $request)
    {
        $request->validate([
            'escaleta_id' => 'required|exists:escaletas,id',
            'nro_nota' => 'required|integer',
            'tipo_nota' => 'required|in:CUÑA,V.O.,F.V.,Nota,Deportes,Entrevista',
            'nombre_nota' => 'required|string|max:255',
            'periodista' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'redaccion' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        // Forzar mayúsculas en los campos solicitados
        $data['periodista'] = mb_strtoupper($request->periodista, 'UTF-8');
        $data['nombre_nota'] = mb_strtoupper($request->nombre_nota, 'UTF-8');
        $data['titulo'] = mb_strtoupper($request->titulo, 'UTF-8');

        $nota = NotaEscaleta::create($data);
        $escaleta = $nota->escaleta;

        return redirect()->route('admin.escaleta.show', ['fecha' => $escaleta->fecha, 'programa' => $escaleta->programa])
            ->with('mensaje', 'Nota agregada con éxito')
            ->with('icono', 'success');
    }

    // 4. Ver los detalles de una nota (Solo lectura)
    public function showNota($id)
    {
        $nota = NotaEscaleta::with('escaleta')->findOrFail($id);
        return view('admin.escaletas.show_nota', compact('nota'));
    }

    // 5. Formulario para editar una nota
    public function editNota($id)
    {
        $nota = NotaEscaleta::with('escaleta')->findOrFail($id);
        return view('admin.escaletas.edit_nota', compact('nota'));
    }

    // 6. Actualizar la nota en BD
    public function updateNota(Request $request, $id)
    {
        $nota = NotaEscaleta::findOrFail($id);

        $request->validate([
            'nro_nota' => 'required|integer',
            'tipo_nota' => 'required|in:CUÑA,V.O.,F.V.,Nota,Deportes,Entrevista',
            'nombre_nota' => 'required|string|max:255',
            'periodista' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'redaccion' => 'nullable|string',
        ]);

        $data = $request->all();

        // Forzar mayúsculas también al actualizar
        $data['periodista'] = mb_strtoupper($request->periodista, 'UTF-8');
        $data['nombre_nota'] = mb_strtoupper($request->nombre_nota, 'UTF-8');
        $data['titulo'] = mb_strtoupper($request->titulo, 'UTF-8');

        $nota->update($data);
        $escaleta = $nota->escaleta;

        return redirect()->route('admin.escaleta.show', ['fecha' => $escaleta->fecha, 'programa' => $escaleta->programa])
            ->with('mensaje', 'Nota actualizada correctamente')
            ->with('icono', 'success');
    }

    // 7. Eliminar nota
    public function destroyNota($id)
    {
        $nota = NotaEscaleta::findOrFail($id);
        $escaleta = $nota->escaleta;
        $nota->delete();

        return redirect()->route('admin.escaleta.show', ['fecha' => $escaleta->fecha, 'programa' => $escaleta->programa])
            ->with('mensaje', 'Nota eliminada correctamente')
            ->with('icono', 'success');
    }

    public function clonarNota(Request $request, $id)
    {
        $request->validate([
            'fecha_destino' => 'required|date',
            'programa_destino' => 'required|in:Revista,Noticiero Meridiano,Noticiero Central',
        ]);

        $notaOriginal = NotaEscaleta::findOrFail($id);
        $escaletaOrigen = $notaOriginal->escaleta; // Guardamos la escaleta actual para volver aquí

        // 1. Buscar o crear la escaleta destino para esa fecha y programa
        $escaletaDestino = Escaleta::firstOrCreate(
            ['fecha' => $request->fecha_destino, 'programa' => $request->programa_destino],
            ['estado' => 'Borrador']
        );

        // 2. Calcular el siguiente número de nota en la escaleta destino
        $siguienteNro = $escaletaDestino->notas()->max('nro_nota') + 1;

        // 3. Duplicar la nota
        NotaEscaleta::create([
            'escaleta_id' => $escaletaDestino->id,
            'nro_nota' => $siguienteNro,
            'tipo_nota' => $notaOriginal->tipo_nota,
            'nombre_nota' => $notaOriginal->nombre_nota,
            'periodista' => $notaOriginal->periodista,
            'titulo' => $notaOriginal->titulo,
            'redaccion' => $notaOriginal->redaccion,
            'user_id' => auth()->id(),
        ]);

        // Redirigir de regreso a la misma escaleta actual
        return redirect()->route('admin.escaleta.show', ['fecha' => $escaletaOrigen->fecha, 'programa' => $escaletaOrigen->programa])
            ->with('mensaje', '¡Nota clonada con éxito a ' . $escaletaDestino->programa . ' (' . $escaletaDestino->fecha . ')!')
            ->with('icono', 'success');
    }
}
