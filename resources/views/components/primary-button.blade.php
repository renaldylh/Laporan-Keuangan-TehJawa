@props(['disabled' => false])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-teh-primary']) }}>
    {{ $slot }}
</button>
