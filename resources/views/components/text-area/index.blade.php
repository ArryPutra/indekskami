<div class="flex flex-col gap-1.5">
    @if (@isset($label))
        <label for="{{ $attributes->get('name') }}">{{ $label }}</label>
    @endif
    <textarea
        {{ $attributes->merge([
            'class' =>
                'border-2 border-slate-200 rounded-lg px-3 py-1.5 outline-none ring-0 focus:ring-4 ring-primary/40 focus:border-primary/70 duration-150 resize-none',
        ]) }}
        placeholder="{{ $placeholder }}" rows="4" {{-- {{ $required ?? true == true ? 'required' : false }} --}}>{{ $value ?? '' }}</textarea>
    @error($attributes->get('name'))
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
