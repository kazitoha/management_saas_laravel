@props(['rows', 'columns', 'searchName' => 'search', 'searchPlaceholder' => 'Search...'])

@php
    $searchValue = request($searchName);
@endphp

<div class="space-y-4">
    {{-- Search --}}
    <form method="GET" action="{{ url()->current() }}"
        class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="w-full sm:max-w-sm">
            <input type="text" name="{{ $searchName }}" value="{{ $searchValue }}"
                placeholder="{{ $searchPlaceholder }}"
                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900 outline-none
                       focus:border-slate-300 focus:ring-2 focus:ring-slate-200">
        </div>

        <div class="flex items-center gap-2">
            <button type="submit"
                class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                Search
            </button>

            @if ($searchValue)
                <a href="{{ url()->current() }}"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Clear
                </a>
            @endif
        </div>

        {{-- Preserve other query params (like filters) --}}
        @foreach (request()->except([$searchName, 'page']) as $k => $v)
            @if (is_array($v))
                @foreach ($v as $vv)
                    <input type="hidden" name="{{ $k }}[]" value="{{ $vv }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endif
        @endforeach
    </form>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        @foreach ($columns as $col)
                            <th
                                class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                {{ $col['label'] ?? '' }}
                            </th>
                        @endforeach

                        @isset($actions)
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>
                        @endisset
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($rows as $row)
                        <tr class="hover:bg-slate-50/60">
                            @foreach ($columns as $col)
                                @php $key = $col['key'] ?? null; @endphp
                                <td class="px-5 py-4 text-sm text-slate-700">
                                    {{-- Default cell --}}
                                    {{ $key ? data_get($row, $key) : '' }}
                                </td>
                            @endforeach

                            @isset($actions)
                                <td class="px-5 py-4 text-right text-sm">
                                    {{ $actions($row) }}
                                </td>
                            @endisset
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + (isset($actions) ? 1 : 0) }}"
                                class="px-5 py-10 text-center text-sm text-slate-500">
                                No results found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="border-t border-slate-200 bg-white px-4 py-3">
            {{ $rows->appends(request()->query())->links() }}
        </div>
    </div>
</div>
