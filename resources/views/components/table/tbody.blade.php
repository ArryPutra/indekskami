<tbody>
    @if ($dataCount > 0)
        {{ $slot }}
    @else
        <x-table.tr>
            <x-table.td colspan="{{ $colspan }}" class="text-center">Data kosong!</x-table.td>
        </x-table.tr>
    @endif
</tbody>
