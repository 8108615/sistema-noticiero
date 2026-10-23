<?php

use Livewire\Component;
use Carbon\Carbon;

new class extends Component {
    public $year;
    public $month;
    public $selectedDate;

    public function mount()
    {
        // Inicializamos con el año y mes actual
        $this->year = Carbon::now()->year;
        $this->month = Carbon::now()->month;
        $this->selectedDate = Carbon::now()->toDateString(); // Fecha de hoy por defecto
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->year = $date->year;
        $this->month = $date->month;
    }

    public function prevMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->year = $date->year;
        $this->month = $date->month;
    }

    public function selectDate($dateString)
    {
        $this->selectedDate = $dateString;
    }

    // Pasamos variables a la vista con el método with() de Volt
    public function with(): array
    {
        $startOfMonth = Carbon::create($this->year, $this->month, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $startDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 (Lunes) a 7 (Domingo)

        // Configuramos idioma en español para el mes
        Carbon::setLocale('es');
        $monthName = ucfirst(Carbon::create($this->year, $this->month, 1)->translatedFormat('F Y'));

        return [
            'daysInMonth' => $daysInMonth,
            'startDayOfWeek' => $startDayOfWeek,
            'monthName' => $monthName,
            'currentToday' => Carbon::now()->toDateString(),
        ];
    }
};
?>

<div class="p-6 bg-zinc-900 text-zinc-100 rounded-xl shadow-xl border border-zinc-800">
    <!-- Cabecera del Calendario -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold uppercase tracking-wider text-amber-500">
            <i class="fa-solid fa-calendar-days mr-2"></i> {{ $monthName }}
        </h2>

        <div class="flex items-center space-x-2">
            <button wire:click="prevMonth" class="px-3 py-1.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-200 rounded-lg transition border border-zinc-700">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button wire:click="mount" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-lg transition">
                Hoy
            </button>
            <button wire:click="nextMonth" class="px-3 py-1.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-200 rounded-lg transition border border-zinc-700">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- Días de la semana -->
    <div class="grid grid-cols-7 gap-2 text-center font-semibold text-zinc-400 text-sm mb-3">
        <div>Lun</div>
        <div>Mar</div>
        <div>Mié</div>
        <div>Jue</div>
        <div>Vie</div>
        <div>Sáb</div>
        <div>Dom</div>
    </div>

    <!-- Grilla de días -->
    <div class="grid grid-cols-7 gap-2">
        <!-- Espacios vacíos antes del primer día del mes -->
        @for ($i = 1; $i < $startDayOfWeek; $i++)
            <div></div>
        @endfor

        <!-- Días del mes -->
        @for ($day = 1; $day <= $daysInMonth; $day++)
            @php
                $dateString = \Carbon\Carbon::create($year, $month, $day)->toDateString();
                $isToday = $dateString === $currentToday;
                $isSelected = $dateString === $selectedDate;
            @endphp

            <button wire:click="selectDate('{{ $dateString }}')"
                @dblclick="window.location.href = '{{ route('admin.escaleta.programa', $dateString) }}'"
                title="Haz doble clic para abrir los programas de esta fecha"
                class="h-14 flex flex-col items-center justify-center rounded-xl border transition relative select-none
                {{ $isSelected ? 'bg-amber-600 border-amber-500 text-white shadow-lg' : 'bg-zinc-800/50 border-zinc-700/60 hover:bg-zinc-800 text-zinc-300' }}
                {{ $isToday && !$isSelected ? 'ring-2 ring-blue-500' : '' }}">

                <span class="text-base font-bold">{{ $day }}</span>

                @if($isToday)
                    <span class="absolute bottom-1 text-[9px] uppercase tracking-tighter bg-blue-500/20 text-blue-400 px-1 rounded">Hoy</span>
                @endif
            </button>
        @endfor
    </div>

    <!-- Indicador de la fecha seleccionada -->
    <div class="mt-6 p-4 bg-zinc-800/80 rounded-xl border border-zinc-700 flex items-center justify-between">
        <div>
            <span class="text-xs text-zinc-400 block">Fecha seleccionada para emisión:</span>
            <span class="text-lg font-bold text-white">{{ $selectedDate }}</span>
        </div>
        <div class="text-right">
            <!-- Aquí luego colocaremos los botones para seleccionar el Noticiero (Revista, Meridiano, Central) -->
            <span class="text-xs text-amber-400 font-medium">Listo para elegir programa <i class="fa-solid fa-arrow-right ml-1"></i></span>
        </div>
    </div>
</div>
