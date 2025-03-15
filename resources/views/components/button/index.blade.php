@php
    $color = $color ?? 'primary';

    $bg = 'bg-primary';
    $ringFocus = 'focus:ring-primary/40';
    $textColor = 'text-white';

    switch ($color) {
        case 'red':
            $bg = 'bg-red-500';
            $ringFocus = 'focus:ring-red-300';
            break;
        case 'orange':
            $bg = 'bg-orange-500';
            $ringFocus = 'focus:ring-orange-300';
            break;
        case 'green':
            $bg = 'bg-green-500';
            $ringFocus = 'focus:ring-green-300';
            break;
        case 'gray':
            $bg = 'bg-gray-100';
            $ringFocus = 'focus:ring-gray-300';
            $textColor = 'text-black';
            break;
        case 'yellow':
            $bg = 'bg-yellow-500';
            $ringFocus = 'focus:ring-yellow-300';
            $textColor = 'text-black';
            break;
        case 'blue':
            $bg = 'bg-blue-500';
            $ringFocus = 'focus:ring-blue-300';
            break;
    }

    $isSubmit = $attributes->get('type') === 'submit' || $attributes->get('type') === 'button';

@endphp

@if ($isSubmit)
    <button type="submit"
        {{ $attributes->merge([
            'class' => "$bg $ringFocus $textColor fill-white flex items-center justify-center gap-2 px-3 py-2 font-semibold rounded-lg ring-0 focus:ring-4 duration-150 cursor-pointer",
        ]) }}>
        {{ $slot }}
    </button>
@else
    <a href="{{ $attributes->get('href') }}"
        {{ $attributes->merge([
            'class' => "$bg $ringFocus $textColor fill-white flex items-center justify-center gap-2 px-3 py-2 font-semibold rounded-lg ring-0 focus:ring-4 duration-150 cursor-pointer",
        ]) }}>
        {{ $slot }}
    </a>
@endif
