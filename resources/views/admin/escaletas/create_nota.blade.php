<x-layouts::app :title="__('Nueva Nota')">
    <div class="max-w-3xl mx-auto p-4 space-y-6">

        <!-- Encabezado con Icono Azul -->
        <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
            <div>
                <a href="{{ route('admin.escaleta.show', ['fecha' => $escaleta->fecha, 'programa' => $escaleta->programa]) }}" class="text-xs text-zinc-400 hover:text-white transition flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-arrow-left"></i> Volver a la Escaleta
                </a>
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus text-blue-500"></i> Nueva Nota para <span class="text-blue-400">{{ $escaleta->programa }}</span>
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

                <!-- Fila 1: Nro Nota y Tipo de Nota -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Nro Nota *</label>
                        <input type="number" name="nro_nota" value="{{ old('nro_nota', $siguienteNro) }}" required
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Tipo de Nota *</label>
                        <select name="tipo_nota" required
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">
                            @foreach(['CUÑA', 'V.O.', 'F.V.', 'Nota', 'Deportes', 'Entrevista'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo_nota') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Fila 2: Periodista y Usuario Registrador (Periodista forzado a Mayúsculas) -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Periodista / Redactor *</label>
                        <input type="text" name="periodista" value="{{ old('periodista') }}" placeholder="Ej: JUAN PÉREZ" required
                            oninput="this.value = this.value.toUpperCase()"
                            class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm uppercase focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1">Registrado por (Usuario actual)</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled
                            class="w-full bg-zinc-800/50 border border-zinc-700/50 rounded-xl px-3 py-2 text-zinc-400 text-sm cursor-not-allowed">
                    </div>
                </div>

                <!-- Nombre de la Nota (Forzado a Mayúsculas) -->
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Nombre de la Nota *</label>
                    <input type="text" name="nombre_nota" value="{{ old('nombre_nota') }}" placeholder="Ej: OPERATIVOS DE CONTROL DE PRECIOS" required
                        oninput="this.value = this.value.toUpperCase()"
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm uppercase focus:outline-none focus:border-blue-500">
                </div>

                <!-- Título / Zócalo (Forzado a Mayúsculas) -->
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Título (Zócalo / GC) *</label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ej: INTENSIFICAN CONTROLES EN MERCADOS" required
                        oninput="this.value = this.value.toUpperCase()"
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm uppercase focus:outline-none focus:border-blue-500">
                </div>

                <!-- Redacción / Guion -->
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1">Redacción / Guion</label>
                    <textarea name="redaccion" rows="6" placeholder="Escribe aquí el guion o texto de la noticia..."
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-sm focus:outline-none focus:border-blue-500">{{ old('redaccion') }}</textarea>
                </div>

                <!-- Botones de Acción (Botón Guardar en Azul) -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-zinc-800">
                    <a href="{{ route('admin.escaleta.show', ['fecha' => $escaleta->fecha, 'programa' => $escaleta->programa]) }}" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-semibold text-xs rounded-xl transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm rounded-xl transition shadow-lg flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Nota
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
