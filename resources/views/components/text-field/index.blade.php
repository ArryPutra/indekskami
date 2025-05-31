<div class="flex flex-col gap-1.5 w-full">
    @if (@isset($label))
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input {{ $attributes }} {{-- {{ $required ?? true == true ? 'required' : false }} --}}
        @if (isset($value)) value="{{ $value }}" @endif type="{{ $type ?? 'text' }}"
        name="{{ $name }}" id="{{ $name }}"
        class="border-2 border-slate-200 rounded-lg px-3 py-1.5 outline-none ring-0 focus:ring-4
        ring-primary/40 focus:border-primary/70 duration-150 w-full">
    @error($attributes->get('name'))
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
