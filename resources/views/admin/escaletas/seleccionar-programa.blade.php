<x-layouts::app :title="__('Seleccionar Programa - ' . $fecha)">
    <div class="max-w-5xl mx-auto p-4 space-y-6">

        <!-- Botón Volver y Encabezado -->
        <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
            <div>
                <a href="{{ route('admin.index') }}" class="text-xs text-zinc-400 hover:text-white transition flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-arrow-left"></i> Volver al Calendario
                </a>
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-calendar-day text-amber-500"></i> Emisiones del {{ \Carbon\Carbon::parse($fecha)->translatedFormat('l, d \d\e F \d\e Y') }}
                </h2>
            </div>
            <span class="px-3 py-1 bg-zinc-800 border border-zinc-700 text-zinc-300 rounded-lg text-sm font-mono">
                {{ $fecha }}
            </span>
        </div>

        <p class="text-zinc-400 text-sm">
            Selecciona el programa de televisión al que deseas ingresar para gestionar la escaleta y cargar las notas correspondientes.
        </p>

        <!-- Tarjetas / Botones de los 3 Programas -->
        <div class="grid md:grid-cols-3 gap-6 pt-2">

            <!-- 1. REVISTA -->
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 flex flex-col justify-between hover:border-amber-500/50 transition shadow-xl group">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-sun"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Revista</h3>
                    <p class="text-zinc-400 text-xs mt-2">Emisión matutina. Entrevistas, sectores de variedad y primeras noticias del día.</p>
                </div>

                <div class="mt-6 pt-4 border-t border-zinc-800/80 flex items-center justify-between">
                    @if(in_array('Revista', $escaletasCreadas))
                        <span class="text-[11px] text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20 font-medium">
                            <i class="fa-solid fa-check mr-1"></i> Con Escaleta
                        </span>
                    @else
                        <span class="text-[11px] text-zinc-500 bg-zinc-800 px-2 py-0.5 rounded font-medium">
                            Sin Iniciar
                        </span>
                    @endif

                    <a href="{{ route('admin.escaleta.show', ['fecha' => $fecha, 'programa' => 'Revista']) }}" 
                       class="px-4 py-2 bg-amber-600 hover:bg-amber-500 text-white font-semibold text-xs rounded-xl transition flex items-center gap-2">
                        Ingresar <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            </div>

            <!-- 2. NOTICIERO MERIDIANO -->
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 flex flex-col justify-between hover:border-blue-500/50 transition shadow-xl group">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-clock-three"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Noticiero Meridiano</h3>
                    <p class="text-zinc-400 text-xs mt-2">Emisión del mediodía. Resumen informativo, despacho en vivo y cobertura del momento.</p>
                </div>

                <div class="mt-6 pt-4 border-t border-zinc-800/80 flex items-center justify-between">
                    @if(in_array('Noticiero Meridiano', $escaletasCreadas))
                        <span class="text-[11px] text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20 font-medium">
                            <i class="fa-solid fa-check mr-1"></i> Con Escaleta
                        </span>
                    @else
                        <span class="text-[11px] text-zinc-500 bg-zinc-800 px-2 py-0.5 rounded font-medium">
                            Sin Iniciar
                        </span>
                    @endif

                    <a href="{{ route('admin.escaleta.show', ['fecha' => $fecha, 'programa' => 'Noticiero Meridiano']) }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xs rounded-xl transition flex items-center gap-2">
                        Ingresar <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            </div>

            <!-- 3. NOTICIERO CENTRAL -->
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 flex flex-col justify-between hover:border-purple-500/50 transition shadow-xl group">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-moon"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Noticiero Central</h3>
                    <p class="text-zinc-400 text-xs mt-2">Emisión estelar de la noche. Análisis profundo, investigación y notas principales del día.</p>
                </div>

                <div class="mt-6 pt-4 border-t border-zinc-800/80 flex items-center justify-between">
                    @if(in_array('Noticiero Central', $escaletasCreadas))
                        <span class="text-[11px] text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20 font-medium">
                            <i class="fa-solid fa-check mr-1"></i> Con Escaleta
                        </span>
                    @else
                        <span class="text-[11px] text-zinc-500 bg-zinc-800 px-2 py-0.5 rounded font-medium">
                            Sin Iniciar
                        </span>
                    @endif

                    <a href="{{ route('admin.escaleta.show', ['fecha' => $fecha, 'programa' => 'Noticiero Central']) }}" 
                       class="px-4 py-2 bg-purple-600 hover:bg-purple-500 text-white font-semibold text-xs rounded-xl transition flex items-center gap-2">
                        Ingresar <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-layouts::app>