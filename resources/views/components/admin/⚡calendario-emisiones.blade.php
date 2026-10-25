<?php

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Escaleta;

new class extends Component {
    public $year;
    public $month;
    public $selectedDate;

    public function mount()
    {
        $this->year = Carbon::now()->year;
        $this->month = Carbon::now()->month;
        $this->selectedDate = Carbon::now()->toDateString();
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

    public function with(): array
    {
        $startOfMonth = Carbon::create($this->year, $this->month, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $startDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 (Lun) a 7 (Dom)

        Carbon::setLocale('es');
        $monthName = mb_strtoupper(Carbon::create($this->year, $this->month, 1)->translatedFormat('F Y'), 'UTF-8');

        // Obtenemos las fechas de este mes que tienen al menos 1 escaleta creada
        $fechasConEscaleta = Escaleta::whereYear('fecha', $this->year)
            ->whereMonth('fecha', $this->month)
            ->pluck('fecha')
            ->toArray();

        return [
            'daysInMonth' => $daysInMonth,
            'startDayOfWeek' => $startDayOfWeek,
            'monthName' => $monthName,
            'currentToday' => Carbon::now()->toDateString(),
            'fechasConEscaleta' => $fechasConEscaleta,
        ];
    }
};
?>

<div class="p-6 bg-zinc-900/90 text-zinc-100 rounded-2xl shadow-2xl border border-zinc-800 space-y-6">
    <!-- Cabecera del Calendario -->
    <div class="flex items-center justify-between pb-2 border-b border-zinc-800/60">
        <h2 class="text-xl font-extrabold tracking-wider text-amber-500 flex items-center gap-2">
            <i class="fa-solid fa-calendar-days text-amber-500"></i> {{ $monthName }}
        </h2>

        <div class="flex items-center space-x-2">
            <button wire:click="prevMonth" class="px-3 py-1.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 rounded-lg transition border border-zinc-700/80 text-sm">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button wire:click="mount" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-lg transition shadow-md">
                Hoy
            </button>
            <button wire:click="nextMonth" class="px-3 py-1.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 rounded-lg transition border border-zinc-700/80 text-sm">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- Nombres de los días de la semana -->
    <div class="grid grid-cols-7 gap-2 text-center font-medium text-zinc-400 text-xs uppercase tracking-wider">
        <div>Lun</div>
        <div>Mar</div>
        <div>Mié</div>
        <div>Jue</div>
        <div>Vie</div>
        <div>Sáb</div>
        <div>Dom</div>
    </div>

    <!-- Grilla principal de días -->
    <div class="grid grid-cols-7 gap-2">
        <!-- Relleno de espacios vacíos previos al 1er día -->
        @for ($i = 1; $i < $startDayOfWeek; $i++)
            <div class="h-16"></div>
        @endfor

        <!-- Renderizado de días del mes -->
        @for ($day = 1; $day <= $daysInMonth; $day++)
            @php
                $dateString = \Carbon\Carbon::create($year, $month, $day)->toDateString();
                $isToday = $dateString === $currentToday;
                $isSelected = $dateString === $selectedDate;
                $tieneEscaleta = in_array($dateString, $fechasConEscaleta);
            @endphp

            <button wire:click="selectDate('{{ $dateString }}')"
                @dblclick="window.location.href = '{{ route('admin.escaleta.programa', $dateString) }}'"
                title="Haz clic para seleccionar o doble clic para abrir los programas"
                class="h-16 flex flex-col items-center justify-center rounded-xl border transition relative select-none group
                {{ $isSelected && $isToday ? 'bg-blue-600 border-blue-500 text-white shadow-lg shadow-blue-600/30 font-bold' : '' }}
                {{ $isSelected && !$isToday ? 'bg-blue-600/30 border-blue-500 text-white shadow-md font-bold' : '' }}
                {{ !$isSelected && $isToday ? 'bg-zinc-800/80 border-blue-500/80 text-white font-semibold' : '' }}
                {{ !$isSelected && !$isToday ? 'bg-zinc-800/40 border-zinc-800/80 hover:bg-zinc-800 text-zinc-300 hover:border-zinc-700' : '' }}">

                <span class="text-base {{ $isSelected ? 'font-black' : 'font-semibold' }}">{{ $day }}</span>

                @if($isToday)
                    <span class="text-[9px] font-bold uppercase tracking-tighter mt-0.5 opacity-90">HOY</span>
                @endif

                <!-- Puntos indicativos en la esquina de cada celda -->
                <div class="absolute bottom-1.5 right-2 flex items-center gap-1">
                    @if($tieneEscaleta)
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-sm" title="Emisión programada"></span>
                    @endif
                    @if($isSelected && !$isToday)
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400 shadow-sm" title="Fecha seleccionada"></span>
                    @endif
                </div>
            </button>
        @endfor
    </div>

    <!-- Barra Inferior de Acción y Leyendas -->
    <div class="space-y-3 pt-2">
        <div class="p-4 bg-zinc-800/50 rounded-xl border border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-blue-500/10 text-blue-400 rounded-lg text-lg">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <span class="text-[11px] text-zinc-400 block uppercase tracking-wider font-medium">Fecha seleccionada para emisión:</span>
                    <span class="text-base font-bold text-white font-mono">{{ $selectedDate }}</span>
                </div>
            </div>

            <div>
                <a href="{{ route('admin.escaleta.programa', $selectedDate) }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded-xl transition shadow-lg flex items-center gap-2">
                    Elegir programa <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Leyenda / Puntos Informativos -->
        <div class="flex items-center justify-end gap-5 text-[11px] text-zinc-400 px-1">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span> Emisión programada
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span> Fecha seleccionada
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-blue-400 inline-block"></span> Hoy
            </span>
        </div>
    </div>
</div>
