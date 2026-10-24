<x-layouts::app :title="__('Editar Nota')">
    <div class="max-w-3xl mx-auto p-4 space-y-6">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
            <div>
                <a href="{{ route('admin.escaleta.show', ['fecha' => $nota->escaleta->fecha, 'programa' => $nota->escaleta->programa]) }}" class="text-xs text-zinc-400 hover:text-white transition flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-arrow-left"></i> Volver a la Escaleta
                </a>
                <!-- Ícono superior en color verde esmeralda -->
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-500"></i> Editar Nota #{{ $nota->nro_nota }}
                </h2>
            </div>
            <span class="px-3 py-1 bg-zinc-800 border border-zinc-700 text-zinc-300 rounded-lg text-sm font-mono">
                {{ $nota->escaleta->fecha }}
            </span>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-xl">
            <form action="{{ route('admin.escaleta.nota.update', $nota->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Fila 1: Nro Nota y Tipo de Nota -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Nro Nota *</label>
                        <input type="number" name="nro_nota" value="{{ old('nro_nota', $nota->nro_nota) }}" required
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Tipo de Nota *</label>
                        <select name="tipo_nota" required
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-emerald-500">
                            @foreach(['CUÑA', 'V.O.', 'F.V.', 'Nota', 'Deportes', 'Entrevista'] as $tipo)
                                <option value="{{ $tipo }}" {{ $nota->tipo_nota === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Fila 2: Periodista y Usuario Registrador -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Periodista / Redactor *</label>
                        <input type="text" name="periodista" value="{{ old('periodista', $nota->periodista) }}" placeholder="Ej: Juan Pérez" required
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Registrado por (Usuario actual)</label>
                        <input type="text" value="{{ $nota->usuario->name ?? auth()->user()->name }}" disabled
                            class="w-full bg-zinc-800/50 border border-zinc-700/50 rounded-xl px-3 py-2 text-zinc-400 text-sm cursor-not-allowed">
                    </div>
                </div>

                <!-- Nombre de la Nota -->
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Nombre de la Nota *</label>
                    <input type="text" name="nombre_nota" value="{{ old('nombre_nota', $nota->nombre_nota) }}" required
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-emerald-500">
                </div>

                <!-- Título / Zócalo -->
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Título (Zócalo / GC) *</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $nota->titulo) }}" required
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-emerald-500">
                </div>

                <!-- Redacción / Guion -->
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Redacción / Guion</label>
                    <textarea name="redaccion" rows="6"
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-emerald-500">{{ old('redaccion', $nota->redaccion) }}</textarea>
                </div>

                <!-- Botones de Acción: Botón Actualizar Nota en verde esmeralda -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-zinc-800">
                    <a href="{{ route('admin.escaleta.show', ['fecha' => $nota->escaleta->fecha, 'programa' => $nota->escaleta->programa]) }}" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-semibold text-xs rounded-xl transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm rounded-xl transition shadow-lg flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Actualizar Nota
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>