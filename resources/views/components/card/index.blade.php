<div
    {{ $attributes->merge([
        'class' =>
            'bg-primary text-white p-4 rounded-lg hover:shadow-primary/50 hover:shadow-md cursor-pointer duration-150 flex items-center gap-3',
    ]) }}>
    <div class="fill-white size-8 w-fit h-fit bg-black/10 p-3 rounded-full">
        {{ $icon }}
    </div>
    <div>
        <h1>{{ $label }}</h1>
        <h1 class="font-bold text-xl">{{ $value }}</h1>
    </div>
</div>
