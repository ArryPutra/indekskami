<div class="flex flex-col gap-1.5 w-fit">
    @if (@isset($label))
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input
        {{ $attributes->merge([
            'class' =>
                'border-2 border-slate-200 rounded-lg px-3 py-1.5 outline-none ring-0 focus:ring-4 ring-primary/40 focus:border-primary/70 duration-150 w-full',
        ]) }}
        @if (isset($value)) value="{{ $value }}" @endif type="date"
        name="{{ $attributes->get('name') }}" id="{{ $attributes->get('name') }}">
    @error($attributes->get('name'))
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
