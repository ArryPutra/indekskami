<div class="flex flex-col gap-1.5 w-full">
    @if (isset($label))
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <select class="px-3 py-2 border-2 rounded-lg border-slate-200 bg-slate-100" name="{{ $name }}"
        id="{{ $name }}" {{ $attributes }}>
        {{ $slot }}
    </select>
    @error($attributes->get('name'))
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
