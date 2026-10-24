<x-layouts::app :title="__('Detalles de la Nota')">
    <div class="max-w-4xl mx-auto p-4 space-y-6">
        
        <!-- Encabezado -->
        <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
            <div>
                <a href="{{ route('admin.escaleta.show', ['fecha' => $nota->escaleta->fecha, 'programa' => $nota->escaleta->programa]) }}" class="text-xs text-zinc-400 hover:text-white transition flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-arrow-left"></i> Volver a la Escaleta
                </a>
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-500"></i> Nota #{{ $nota->nro_nota }} - <span class="text-amber-400">{{ $nota->nombre_nota }}</span>
                </h2>
            </div>

            <div>
                <a href="{{ route('admin.escaleta.nota.edit', $nota->id) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm rounded-xl transition shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> Editar
                </a>
            </div>
        </div>

        <!-- Tarjeta Principal de Información -->
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-xl space-y-6">
            
            <!-- Fila 1: Datos Técnicos (Tipo, Programa, Fecha) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-4 border-b border-zinc-800 text-xs">
                <div>
                    <span class="block text-zinc-500 uppercase tracking-wider font-semibold mb-1">Tipo de Nota</span>
                    <span class="px-2 py-1 text-xs font-bold rounded uppercase
                        {{ $nota->tipo_nota === 'CUÑA' ? 'bg-red-500/20 text-red-400 border border-red-500/30' : '' }}
                        {{ $nota->tipo_nota === 'V.O.' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}
                        {{ $nota->tipo_nota === 'F.V.' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : '' }}
                        {{ $nota->tipo_nota === 'Nota' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : '' }}
                        {{ $nota->tipo_nota === 'Deportes' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : '' }}
                        {{ $nota->tipo_nota === 'Entrevista' ? 'bg-cyan-500/20 text-cyan-400 border border-cyan-500/30' : '' }}">
                        {{ $nota->tipo_nota }}
                    </span>
                </div>

                <div>
                    <span class="block text-zinc-500 uppercase tracking-wider font-semibold mb-1">Programa / Emisión</span>
                    <span class="text-zinc-200 font-medium">{{ $nota->escaleta->programa }} ({{ $nota->escaleta->fecha }})</span>
                </div>

                <div>
                    <span class="block text-zinc-500 uppercase tracking-wider font-semibold mb-1">Periodista / Registro</span>
                    <div class="text-zinc-200 font-medium"><i class="fa-solid fa-user-pen mr-1 text-amber-500"></i> {{ $nota->periodista ?? 'Sin asignar' }}</div>
                    <div class="text-zinc-500 text-[11px] mt-0.5"><i class="fa-solid fa-laptop-code mr-1"></i> Reg: {{ $nota->usuario->name ?? 'Sistema' }}</div>
                </div>
            </div>

            <!-- Fila 2: Título / Zócalo (GC) -->
            <div>
                <span class="block text-zinc-500 uppercase tracking-wider font-semibold mb-1.5 text-xs">Título / Zócalo (GC)</span>
                <div class="bg-zinc-800/60 border border-zinc-700/60 rounded-xl p-3 text-white font-semibold text-sm">
                    {{ $nota->titulo }}
                </div>
            </div>

            <!-- Fila 3: Redacción / Guion (Enfoque Principal para Lectura de Presentadores) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="block text-amber-400 uppercase tracking-wider font-bold text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-microphone-lines text-sm"></i> Guion / Redacción Completa (Lectura en Set)
                    </span>
                    <span class="text-[11px] text-zinc-500">Optimizado para teleprompter / lectura</span>
                </div>
                
                <div class="bg-zinc-950 border-2 border-amber-500/30 rounded-2xl p-5 shadow-inner">
                    <div class="text-zinc-100 text-lg leading-relaxed whitespace-pre-line font-normal tracking-wide">
                        {{ $nota->redaccion ?? 'Sin redacción registrada para esta nota.' }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts::app>