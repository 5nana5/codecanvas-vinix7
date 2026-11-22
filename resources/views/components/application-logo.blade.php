@props(['imageClass' => 'h-5 w-auto block object-contain'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center bg-white px-2.5 py-1.5 rounded-lg leading-none']) }}>
    <img src="{{ asset('images/logo-vinix7.png') }}" alt="Logo VINIX7" class="{{ $imageClass }}">
</span>
