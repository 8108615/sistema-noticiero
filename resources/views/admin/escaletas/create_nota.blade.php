<x-layouts::app :title="__('Crear Nueva Nota')">
    <div class="max-w-3xl mx-auto p-4 space-y-6">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
            <div>
                <a href="{{ route('admin.escaleta.show', ['fecha' => $escaleta->fecha, 'programa' => $escaleta->programa]) }}" class="text-xs text-zinc-400 hover:text-white transition flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-arrow-left"></i> Volver a la Escaleta
                </a>
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus text-amber-500"></i> Nueva Nota para {{ $escaleta->programa }}
                </h2>
            </div>
            <span class="px-3 py-1 bg-zinc-800 border border-zinc-700 text-zinc-300 rounded-lg text-sm font-mono">
                {{ $escaleta->fecha }}
            </span>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-xl">
            <form action="{{ route('admin.escaleta.nota.store') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="escaleta_id" value="{{ $escaleta->id }}">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Nro Nota *</label>
                        <input type="number" name="nro_nota" value="{{ old('nro_nota', $siguienteNro) }}" required
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Tipo de Nota *</label>
                        <select name="tipo_nota" required
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-amber-500">
                            <option value="Nota">Nota</option>
                            <option value="CUÑA">CUÑA</option>
                            <option value="V.O.">V.O.</option>
                            <option value="F.V.">F.V.</option>
                            <option value="Deportes">Deportes</option>
                            <option value="Entrevista">Entrevista</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Nombre de la Nota *</label>
                    <input type="text" name="nombre_nota" placeholder="Ej: Operativos de control de precios" required
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Título (Zócalo / GC) *</label>
                    <input type="text" name="titulo" placeholder="Ej: INTENSIFICAN CONTROLES EN MERCADOS" required
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Redacción / Guion</label>
                    <textarea name="redaccion" rows="6" placeholder="Escribe aquí el guion o texto de la noticia..."
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-amber-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-zinc-800">
                    <a href="{{ route('admin.escaleta.show', ['fecha' => $escaleta->fecha, 'programa' => $escaleta->programa]) }}" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-semibold text-xs rounded-xl transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-500 text-white font-bold text-sm rounded-xl transition shadow-lg flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Nota
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>