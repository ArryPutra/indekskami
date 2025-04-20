<div {{ $attributes->merge(['class' => 'overflow-x-auto max-md:-mx-4']) }}>
    <table class="w-full text-sm text-left rtl:text-right">
        {{ $slot }}
    </table>
</div>
