@props(['on' => false])

<div x-data="{ shown: false, timeout: null }"
     x-show="shown"
     x-transition
     @{{ $on }}="
        clearTimeout(timeout);
        shown = true;
        timeout = setTimeout(() => { shown = false }, 2000);
     "
     {{ $attributes->merge(['class' => 'text-sm text-gray-600']) }}>
    {{ $slot }}
</div>
