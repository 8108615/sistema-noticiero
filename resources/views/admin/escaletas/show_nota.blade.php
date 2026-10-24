<x-layouts::app :title="__('Detalle de Nota')">
    <div class="max-w-3xl mx-auto p-4 space-y-6">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
            <div>
                <a href="{{ route('admin.escaleta.show', ['fecha' => $nota->escaleta->fecha, 'programa' => $nota->escaleta->programa]) }}" class="text-xs text-zinc-400 hover:text-white transition flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-arrow-left"></i> Volver a la Escaleta
                </a>
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-eye text-blue-500"></i> Nota #{{ $nota->nro_nota }} - {{ $nota->nombre_nota }}
                </h2>
            </div>
            <a href="{{ route('admin.escaleta.nota.edit', $nota->id) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square"></i> Editar
            </a>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-xl space-y-4 text-zinc-200">
            <div class="grid grid-cols-2 gap-4 border-b border-zinc-800 pb-4">
                <div>
                    <span class="text-xs text-zinc-500 uppercase block font-semibold">Tipo de Nota</span>
                    <span class="text-sm font-bold text-amber-400">{{ $nota->tipo_nota }}</span>
                </div>
                <div>
                    <span class="text-xs text-zinc-500 uppercase block font-semibold">Programa / Fecha</span>
                    <span class="text-sm font-bold text-white">{{ $nota->escaleta->programa }} ({{ $nota->escaleta->fecha }})</span>
                </div>
            </div>

            <div>
                <span class="text-xs text-zinc-500 uppercase block font-semibold mb-1">Título (Zócalo / GC)</span>
                <p class="text-base font-semibold text-white bg-zinc-800/80 p-3 rounded-xl border border-zinc-700/60">{{ $nota->titulo }}</p>
            </div>

            <div>
                <span class="text-xs text-zinc-500 uppercase block font-semibold mb-1">Redacción Completa</span>
                <div class="bg-zinc-800/40 p-4 rounded-xl border border-zinc-800 text-sm whitespace-pre-line leading-relaxed text-zinc-300">
                    {{ $nota->redaccion ?? 'Sin redacción grabada.' }}
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>