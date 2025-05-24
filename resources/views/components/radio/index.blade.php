<div {{ $attributes->merge(['class' => 'flex flex-col gap-1.5']) }}>
    <p>{{ $label }}</p>
    <div class="space-y-1">
        {{ $slot }}
    </div>
    @error($attributes->get('name'))
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
