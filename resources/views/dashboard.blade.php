<x-layouts::app :title="__('Dashboard - Sistema de Noticiero')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-2">

        <!-- Fila superior: Tarjetas informativas de bienvenida o accesos rápidos -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="p-5 bg-zinc-900 border border-zinc-800 rounded-xl shadow-lg flex items-center justify-between">
                <div>
                    <span class="text-xs text-zinc-400 uppercase tracking-wider font-semibold">Usuario Conectado</span>
                    <h3 class="text-lg font-bold text-white mt-1">{{ auth()->user()->name }}</h3>
                    <span class="inline-block mt-2 px-2.5 py-0.5 text-xs font-semibold bg-amber-500/20 text-amber-400 rounded-full">
                        {{ auth()->user()->getRoleNames()->first() ?? 'Sin Rol' }}
                    </span>
                </div>
                <div class="p-3 bg-amber-500/10 text-amber-500 rounded-xl text-xl">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>

            <div class="p-5 bg-zinc-900 border border-zinc-800 rounded-xl shadow-lg flex items-center justify-between">
                <div>
                    <span class="text-xs text-zinc-400 uppercase tracking-wider font-semibold">Emisiones TV</span>
                    <h3 class="text-lg font-bold text-white mt-1">Gestión de Escaletas</h3>
                    <span class="text-xs text-zinc-400 mt-1 block">Selecciona fecha y programa</span>
                </div>
                <div class="p-3 bg-blue-500/10 text-blue-500 rounded-xl text-xl">
                    <i class="fa-solid fa-tv"></i>
                </div>
            </div>

            <div class="p-5 bg-zinc-900 border border-zinc-800 rounded-xl shadow-lg flex items-center justify-between">
                <div>
                    <span class="text-xs text-zinc-400 uppercase tracking-wider font-semibold">Estado del Sistema</span>
                    <h3 class="text-lg font-bold text-emerald-400 mt-1">En Línea</h3>
                    <span class="text-xs text-zinc-400 mt-1 block">Base de datos sincronizada</span>
                </div>
                <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-xl text-xl">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>

        <!-- Fila principal: El Calendario Interactivo de Emisiones -->
        <div class="flex-1 w-full">
            <livewire:admin.calendario-emisiones />
        </div>

    </div>
</x-layouts::app>
