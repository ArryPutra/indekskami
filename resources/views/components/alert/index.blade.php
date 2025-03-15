{{-- 

    Catatan:
    - Setiap kompenen diberikan variabel $type untuk menentukan jenis alert (tidak wajib, default: danger).
    - Variabel $isClosed digunakan agar dapat menutup alert jika variabel bernilai true.

--}}
@php
    $type = $type ?? 'danger';

    switch ($type) {
        case 'danger':
            $backgroundColor = 'bg-red-100';
            $color = 'text-red-400';
            $borderColor = 'border-red-200';
            break;
        case 'success':
            $backgroundColor = 'bg-green-100';
            $color = 'text-green-400';
            $borderColor = 'border-green-200';
            break;
        case 'warning':
            $backgroundColor = 'bg-yellow-100';
            $color = 'text-yellow-400';
            $borderColor = 'border-yellow-200';
            break;
        case 'message':
            $backgroundColor = 'bg-gray-100';
            $color = 'text-gray-400';
            $borderColor = 'border-gray-200';
            break;
        default:
            # code...
            break;
    }
@endphp

<div x-transition x-data="{ showAlert: true }" x-show="showAlert"
    {{ $attributes->merge(['class' => "$backgroundColor border $borderColor text-$color p-3 rounded flex gap-2 justify-between"]) }}
    role="alert">
    <span class="block text-sm">{{ $slot }}</span>
    <div>
        @if ($isClosed ?? false)
            <svg @click="showAlert = false" class="size-5 fill-{{ $color }} cursor-pointer"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="transform: ;msFilter:;">
                <path
                    d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z">
                </path>
            </svg>
        @endif
    </div>
</div>
