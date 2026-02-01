@php
    $label = ucwords(str_replace('_', ' ', $status ?? ''));
    $class = match ($status) {
        'completed', 'finished' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'in_progress', 'on_going' => 'bg-amber-100 text-amber-800 border-amber-200',
        'not_started', 'pending' => 'bg-slate-100 text-slate-700 border-slate-200',
        'unfinished' => 'bg-rose-100 text-rose-800 border-rose-200',
        default => 'bg-slate-100 text-slate-700 border-slate-200',
    };
@endphp

<span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[11px] font-semibold {{ $class }}">
    {{ $label ?: '—' }}
</span>
