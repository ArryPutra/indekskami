<div
    {{ $attributes->merge([
        'class' =>
            'bg-primary text-white p-4 rounded-lg hover:ring-primary/50 hover:ring-4 ring-0 cursor-pointer duration-200 flex items-center gap-3',
    ]) }}>
    <div class="fill-white size-8 w-fit h-fit bg-black/10 p-3 rounded-full">
        {{ $icon }}
    </div>
    <div>
        <h1>{{ $label }}</h1>
        <h1 class="font-bold text-xl">{{ $value }}</h1>
    </div>
</div>
