<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Escaleta;
use App\Models\NotaEscaleta;

new class extends Component {
    use WithPagination;

    public $escaletaId;
    public $search = '';
    public $perPage = 10;

    public function mount($escaletaId)
    {
        $this->escaletaId = $escaletaId;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $escaleta = Escaleta::findOrFail($this->escaletaId);

        $notas = NotaEscaleta::where('escaleta_id', $this->escaletaId)
            ->where(function ($query) {
                $query->where('nombre_nota', 'like', '%' . $this->search . '%')
                      ->orWhere('titulo', 'like', '%' . $this->search . '%')
                      ->orWhere('periodista', 'like', '%' . $this->search . '%')
                      ->orWhere('tipo_nota', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nro_nota', 'asc')
            ->paginate($this->perPage);

        return [
            'escaleta' => $escaleta,
            'notas' => $notas,
        ];
    }

    public function eliminarNota($id)
    {
        $nota = NotaEscaleta::find($id);
        if ($nota) {
            $nota->delete();
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Nota eliminada correctamente'
            ]);
        }
    }
};
?>

<div class="max-w-7xl mx-auto p-4 space-y-6">

    <!-- Encabezado -->
    <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-zinc-800 pb-4 gap-4">
        <div>
            <a href="{{ route('admin.escaleta.programa', $escaleta->fecha) }}" class="text-xs text-zinc-400 hover:text-white transition flex items-center gap-2 mb-1">
                <i class="fa-solid fa-arrow-left"></i> Cambiar de Programa
            </a>
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <i class="fa-solid fa-list-check text-amber-500"></i> 
                Escaleta: <span class="text-amber-400">{{ $escaleta->programa }}</span>
            </h2>
            <p class="text-xs text-zinc-400 mt-0.5">
                Emisión del {{ \Carbon\Carbon::parse($escaleta->fecha)->translatedFormat('l, d \d\e F \d\e Y') }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.escaleta.nota.create', $escaleta->id) }}" 
               class="px-4 py-2 bg-amber-600 hover:bg-amber-500 text-white font-bold text-sm rounded-xl transition shadow-lg flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Nueva Nota
            </a>
        </div>
    </div>

    <!-- Contenedor Principal de la Tabla con Buscador y Paginador -->
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5 shadow-xl space-y-4">
        
        <!-- Barra de Controles Superior -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-3 border-b border-zinc-800">
            <div class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" 
                    placeholder="Buscar por nombre, título, periodista..." 
                    class="w-full bg-zinc-800 border border-zinc-700 rounded-xl pl-9 pr-4 py-2 text-white text-xs focus:outline-none focus:border-amber-500 transition">
            </div>

            <div class="flex items-center gap-2 text-xs text-zinc-400 w-full sm:w-auto justify-end">
                <span>Mostrar:</span>
                <select wire:model.live="perPage" class="bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-1.5 text-white text-xs focus:outline-none focus:border-amber-500">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>registros</span>
            </div>
        </div>

        <!-- Título de sección -->
        <div class="flex items-center justify-between">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-amber-500"></i> Notas Registradas ({{ $notas->total() }})
            </h3>
        </div>

        @if($notas->isEmpty())
            <div class="text-center py-12 text-zinc-500">
                <i class="fa-solid fa-folder-open text-4xl mb-3 block opacity-50"></i>
                <p class="text-sm">No se encontraron notas registradas o coincidentes.</p>
                <a href="{{ route('admin.escaleta.nota.create', $escaleta->id) }}" class="inline-block mt-3 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-amber-400 font-semibold text-xs rounded-xl transition border border-zinc-700">
                    ＋ Crear la primera nota
                </a>
            </div>
        @else
            <!-- Tabla de Notas -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-300">
                    <thead class="bg-zinc-800/80 text-zinc-400 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-3 py-2.5 rounded-l-lg">N°</th>
                            <th class="px-3 py-2.5">Tipo</th>
                            <th class="px-3 py-2.5">Nombre / Título</th>
                            <th class="px-3 py-2.5">Periodista / Reg.</th>
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

                                <td class="px-3 py-3">
                                    <div class="text-xs font-semibold text-white">
                                        <i class="fa-solid fa-user-pen mr-1 text-amber-500"></i>{{ $nota->periodista ?? 'Sin asignar' }}
                                    </div>
                                    <div class="text-[11px] text-zinc-500 mt-0.5">
                                        <i class="fa-solid fa-laptop-code mr-1"></i>Reg: {{ $nota->usuario->name ?? 'Sistema' }}
                                    </div>
                                </td>

                                <td class="px-3 py-3 max-w-xs">
                                    <p class="text-xs text-zinc-400 line-clamp-2">{{ $nota->redaccion ?? 'Sin redacción' }}</p>
                                </td>

                                <td class="px-3 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- VER -->
                                        <a href="{{ route('admin.escaleta.nota.show', $nota->id) }}" class="p-2 bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white rounded-lg transition" title="Ver Nota">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <!-- EDITAR -->
                                        <a href="{{ route('admin.escaleta.nota.edit', $nota->id) }}" class="p-2 bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500 hover:text-white rounded-lg transition" title="Editar Nota">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <!-- ELIMINAR Directo con función JavaScript -->
                                        <button type="button" 
                                            onclick="confirmarEliminacion({{ $nota->id }}, '{{ addslashes($nota->nombre_nota) }}')"
                                            class="p-2 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition" title="Eliminar Nota">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Sección de Paginación y Resumen -->
            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-zinc-800 gap-4 text-xs text-zinc-400">
                <div>
                    Mostrando del <span class="font-semibold text-white">{{ $notas->firstItem() ?? 0 }}</span> al <span class="font-semibold text-white">{{ $notas->lastItem() ?? 0 }}</span> de un total de <span class="font-semibold text-white">{{ $notas->total() }}</span> resultados
                </div>

                <div>
                    {{ $notas->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Script de SweetAlert2 incrustado directamente para evitar errores de carga -->
    <script>
        function confirmarEliminacion(id, nombreNota) {
            Swal.fire({
                title: '¿Desea eliminar esta nota?',
                html: `<strong class="text-red-500 text-base">"${nombreNota}"</strong>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('eliminarNota', id);
                }
            });
        }

        document.addEventListener('livewire:initialized', () => {
            window.addEventListener('swal', event => {
                Swal.fire({
                    position: "top-end",
                    icon: event.detail[0].icon,
                    title: event.detail[0].title,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        });
    </script>
</div>