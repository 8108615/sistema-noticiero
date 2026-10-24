<x-layouts::app :title="__('Escaleta - ' . $programa)">
    <div class="max-w-7xl mx-auto p-4 space-y-6">

        <!-- Encabezado -->
        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-zinc-800 pb-4 gap-4">
            <div>
                <a href="{{ route('admin.escaleta.programa', $fecha) }}" class="text-xs text-zinc-400 hover:text-white transition flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-arrow-left"></i> Cambiar de Programa
                </a>
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <i class="fa-solid fa-list-check text-amber-500"></i> 
                    Escaleta: <span class="text-amber-400">{{ $programa }}</span>
                </h2>
                <p class="text-xs text-zinc-400 mt-0.5">
                    Emisión del {{ \Carbon\Carbon::parse($fecha)->translatedFormat('l, d \d\e F \d\e Y') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.escaleta.nota.create', $escaleta->id) }}" 
                   class="px-4 py-2 bg-amber-600 hover:bg-amber-500 text-white font-bold text-sm rounded-xl transition shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Nueva Nota
                </a>
            </div>
        </div>

        <!-- Tabla con el Listado de Notas -->
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5 shadow-xl">
            <div class="flex items-center justify-between mb-4 border-b border-zinc-800 pb-3">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-amber-500"></i> Notas Registradas ({{ $notas->count() }})
                </h3>
            </div>

            @if($notas->isEmpty())
                <div class="text-center py-12 text-zinc-500">
                    <i class="fa-solid fa-folder-open text-4xl mb-3 block opacity-50"></i>
                    <p class="text-sm">No hay notas registradas para esta emisión.</p>
                    <a href="{{ route('admin.escaleta.nota.create', $escaleta->id) }}" class="inline-block mt-3 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-amber-400 font-semibold text-xs rounded-xl transition border border-zinc-700">
                        ＋ Crear la primera nota
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-300">
                        <thead class="bg-zinc-800/80 text-zinc-400 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-3 py-2.5 rounded-l-lg">N°</th>
                                <th class="px-3 py-2.5">Tipo</th>
                                <th class="px-3 py-2.5">Nombre / Título</th>
                                <th class="px-3 py-2.5">Redacción</th>
                                <th class="px-3 py-2.5 text-center rounded-r-lg">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/60">
                            @foreach($notas as $nota)
                                <tr class="hover:bg-zinc-800/40 transition">
                                    <td class="px-3 py-3 font-bold text-amber-400">#{{ $nota->nro_nota }}</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded uppercase
                                            {{ $nota->tipo_nota === 'CUÑA' ? 'bg-red-500/20 text-red-400 border border-red-500/30' : '' }}
                                            {{ $nota->tipo_nota === 'V.O.' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}
                                            {{ $nota->tipo_nota === 'F.V.' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : '' }}
                                            {{ $nota->tipo_nota === 'Nota' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : '' }}
                                            {{ $nota->tipo_nota === 'Deportes' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : '' }}
                                            {{ $nota->tipo_nota === 'Entrevista' ? 'bg-cyan-500/20 text-cyan-400 border border-cyan-500/30' : '' }}">
                                            {{ $nota->tipo_nota }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="font-semibold text-white">{{ $nota->nombre_nota }}</div>
                                        <div class="text-xs text-zinc-400 italic"><i class="fa-solid fa-quote-left mr-1 text-zinc-600"></i>{{ $nota->titulo }}</div>
                                    </td>
                                    <td class="px-3 py-3 max-w-xs">
                                        <p class="text-xs text-zinc-400 line-clamp-2">{{ $nota->redaccion ?? 'Sin redacción' }}</p>
                                    </td>
                                    <td class="px-3 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- VER (Ojo) -->
                                            <a href="{{ route('admin.escaleta.nota.show', $nota->id) }}" class="p-2 bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white rounded-lg transition" title="Ver Nota">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <!-- EDITAR (Lápiz) -->
                                            <a href="{{ route('admin.escaleta.nota.edit', $nota->id) }}" class="p-2 bg-amber-500/10 text-amber-400 hover:bg-amber-500 hover:text-white rounded-lg transition" title="Editar Nota">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <!-- ELIMINAR (Basurero) -->
                                            <form action="{{ route('admin.escaleta.nota.destroy', $nota->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta nota?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition" title="Eliminar Nota">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>