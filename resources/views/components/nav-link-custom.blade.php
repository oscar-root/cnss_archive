@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 bg-white bg-opacity-10 text-white border-l-4 border-white'
            : 'flex items-center px-4 py-3 text-blue-100 hover:bg-white hover:bg-opacity-5 hover:text-white transition duration-200 border-l-4 border-transparent';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="mr-3">
        <!-- Vous pouvez intégrer des icônes SVG ici selon l'attribut $icon -->
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
    </span>
    {{ $slot }}
</a>