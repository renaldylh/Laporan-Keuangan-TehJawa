@props(['disabled' => false])

<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-teh-secondary']) }}>
    {{ $slot }}
</button>
