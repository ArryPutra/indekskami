<div class="flex items-center">
    <input {{ $attributes }} id="{{ $value }}" type="radio" class="size-4">
    <label for="{{ $value }}" class="ms-2  text-sm font-medium text-gray-900">{{ $slot }}</label>
</div>
