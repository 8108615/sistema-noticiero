<x-layouts::app :title="__('Asignar Permisos - ' . $rol->name)">
    <div class="max-w-6xl mx-auto p-4 space-y-6">

        <!-- Encabezado -->
        <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
            <div>
                <a href="{{ route('admin.roles.index') }}" class="text-xs text-zinc-400 hover:text-white transition flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-arrow-left"></i> Volver a Roles
                </a>
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-key text-blue-500"></i> Configurar Permisos para el Rol: <span class="text-blue-400">{{ $rol->name }}</span>
                </h2>
                <p class="text-xs text-zinc-400 mt-1">Selecciona los módulos y acciones que este rol podrá ejecutar en el sistema de noticiero.</p>
            </div>
        </div>

        <!-- Formulario Principal -->
        <form action="{{ route('admin.roles.updatePermisos', $rol->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @php
                    // Agrupamos visualmente los permisos según su nombre o palabra clave
                    $modulos = [
                        'Usuarios' => $permissions->filter(fn($p) => str_contains($p->name, 'Usuario')),
                        'Roles y Permisos' => $permissions->filter(fn($p) => str_contains($p->name, 'Rol') || str_contains($p->name, 'Permiso')),
                        'Escaleta y Notas' => $permissions->filter(fn($p) => str_contains($p->name, 'Calendario') || str_contains($p->name, 'Nota') || str_contains($p->name, 'Clonar')),
                    ];
                @endphp

                @foreach($modulos as $tituloModulo => $perms)
                    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5 shadow-xl flex flex-col justify-between space-y-4">
                        <div>
                            <!-- Cabecera de la Tarjeta del Módulo -->
                            <div class="flex items-center justify-between pb-3 border-b border-blue-900/50 mb-4">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-blue-400 flex items-center gap-2">
                                    <i class="fa-solid fa-shield-halved text-blue-500"></i> {{ $tituloModulo }}
                                </h3>
                                <span class="text-[10px] bg-blue-950 text-blue-300 px-2 py-0.5 rounded-full font-mono border border-blue-900/50">
                                    {{ $perms->count() }} permisos
                                </span>
                            </div>

                            <!-- Lista de Permisos con Checkbox Moderno -->
                            <div class="space-y-2.5">
                                @foreach($perms as $permission)
                                    <label class="flex items-center justify-between p-2.5 bg-zinc-800/40 border border-zinc-700/40 rounded-xl hover:bg-zinc-800/80 transition cursor-pointer group">
                                        <span class="text-xs font-medium text-zinc-200 group-hover:text-white transition">
                                            {{ $permission->name }}
                                        </span>
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            {{ $rol->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-zinc-900 border-zinc-700 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Botones de Acción Fijos Abajo -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-zinc-800">
                <a href="{{ route('admin.roles.index') }}" class="px-5 py-2.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-semibold text-xs rounded-xl transition border border-zinc-700">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs rounded-xl transition shadow-lg flex items-center gap-2 border border-blue-600/50">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios de Permisos
                </button>
            </div>
        </form>
    </div>
</x-layouts::app>
