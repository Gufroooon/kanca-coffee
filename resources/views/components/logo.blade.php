@props([
    'class' => 'w-10 h-10',
    'rounded' => 'rounded-2xl',
])

<img
    src="{{ asset('images/kanca-logo.jpg') }}"
    alt="Kanca Coffee"
    {{ $attributes->merge(['class' => $class . ' ' . $rounded . ' object-cover flex-shrink-0']) }}
/>
