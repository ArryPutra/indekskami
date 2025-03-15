<div {{ $attributes->merge(['class' => 'flex flex-col gap-1.5 w-full']) }}>
    @if (@isset($label))
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input @if (!empty($value)) value="{{ $value }}" @endif type="{{ $type ?? 'text' }}"
        name="{{ $name }}" placeholder="{{ $placeholder }}" id="{{ $name }}"
        class="border-2 border-slate-200 rounded-lg px-3 py-1.5 outline-none ring-0 focus:ring-4
        ring-primary/40 focus:border-primary/70 duration-150 w-full">
    @error($attributes->get('name'))
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
