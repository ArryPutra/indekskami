<div class="flex flex-col gap-1.5">
    {{-- <label class="text-black" for="file_input">Upload file</label> --}}
    <input {{ $attributes }}
        class="bg-gray-50 border-gray-200 border rounded-lg file:px-3 file:py-2 file:mr-2 file:bg-gray-100 w-72"
        type="file" name="{{ $attributes->get('name') }}">
</div>
