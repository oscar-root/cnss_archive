@props(['title', 'value', 'color', 'icon'])

@php
    $colors = [
        'blue' => 'text-cnss-blue bg-blue-50',
        'red' => 'text-cnss-red bg-red-50',
        'green' => 'text-green-600 bg-green-50',
        'gray' => 'text-gray-600 bg-gray-50',
    ];
@endphp

<div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex items-center justify-between hover:scale-105 transition transform duration-300">
    <div>
        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">{{ $title }}</p>
        <p class="text-3xl font-black text-gray-900">{{ $value }}</p>
    </div>
    <div class="p-4 rounded-xl {{ $colors[$color] ?? $colors['blue'] }}">
        <!-- Icônes simples basées sur le nom -->
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
    </div>
</div>