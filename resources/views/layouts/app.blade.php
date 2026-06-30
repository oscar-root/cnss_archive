<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 text-gray-900">
    <title>{{ config('app.name', 'CNSS Archive') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts/CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        
        <!-- ================= SIDEBAR (BLEU CNSS) ================= -->
        <aside class="w-64 bg-cnss-blue text-white flex-shrink-0 flex flex-col shadow-xl">
            <!-- Logo Area -->
            <div class="p-6 border-b border-blue-800 flex items-center space-x-3 bg-blue-900">
                <div class="bg-white p-1 rounded-full shadow-md">
                    <img src="{{ asset('images/logo-cnss.png') }}" class="h-8 w-auto" alt="Logo CNSS">
                </div>
                <span class="font-black text-lg tracking-tighter uppercase">CNSS Archive</span>
            </div>

            <!-- Nav Items -->
            <nav class="flex-1 overflow-y-auto py-4 custom-scrollbar">
                <div class="px-6 mb-2 text-xs font-black text-blue-300 uppercase tracking-widest text-opacity-50">Menu Principal</div>
                
                <x-nav-link-custom :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Tableau de bord
                </x-nav-link-custom>

                <!-- 1. TACHES SECRETAIRE (Workflow complet) -->
                @if(auth()->user()->isSecretaire())
                    <div class="px-6 mt-8 mb-2 text-xs font-black text-blue-300 uppercase tracking-widest text-opacity-50">Secrétariat</div>
                    
                    <!-- Tâche : Constitution -->
                    <x-nav-link-custom :href="route('archives.create')" :active="request()->routeIs('archives.create')" wire:navigate>
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                        Nouvelle Archive
                    </x-nav-link-custom>

                    <!-- Tâche : Suivi / Rectification -->
                    <x-nav-link-custom :href="route('archives.index')" :active="request()->routeIs('archives.index') && !request()->has('filter_status')" wire:navigate>
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Mes Archives
                    </x-nav-link-custom>

                    <!-- Tâche : Classement (Dossiers avec Visa) -->
                    <x-nav-link-custom :href="route('archives.index', ['filter_status' => 'signe_directeur'])" :active="request()->get('filter_status') == 'signe_directeur'" wire:navigate>
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        Classement final
                    </x-nav-link-custom>
                @endif

                <!-- 2. TACHES CHEF DE SERVICE -->
                @if(auth()->user()->isChefDeService())
                    <div class="px-6 mt-8 mb-2 text-xs font-black text-blue-300 uppercase tracking-widest text-opacity-50">Expertise</div>
                    <x-nav-link-custom :href="route('archives.index')" :active="request()->routeIs('archives.index')" wire:navigate>
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Archives à vérifier
                    </x-nav-link-custom>
                @endif

                <!-- 3. TACHES DIRECTEUR -->
                @if(auth()->user()->isDirecteur())
                    <div class="px-6 mt-8 mb-2 text-xs font-black text-blue-300 uppercase tracking-widest text-opacity-50">Direction</div>
                    <x-nav-link-custom :href="route('archives.index')" :active="request()->routeIs('archives.index')" wire:navigate>
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Visas & Signatures
                    </x-nav-link-custom>
                @endif

                <!-- 4. TACHES ADMIN -->
                @if(auth()->user()->isAdmin())
                    <div class="px-6 mt-8 mb-2 text-xs font-black text-blue-300 uppercase tracking-widest text-opacity-50">Système</div>
                    <x-nav-link-custom :href="route('users.index')" :active="request()->routeIs('users.index')" wire:navigate>
                        <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Gestion Utilisateurs
                    </x-nav-link-custom>
                @endif
            </nav>

            <!-- ================= USER FOOTER : PROFIL & SETTINGS ================= -->
            <div class="p-4 border-t border-blue-800 bg-blue-950">
                <div class="flex items-center justify-between p-2 bg-white bg-opacity-5 rounded-xl mb-4 group hover:bg-opacity-10 transition duration-200">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        <!-- Avatar initiales -->
                        <div class="h-10 w-10 flex-shrink-0 rounded-full bg-white text-cnss-blue flex items-center justify-center font-black text-lg border-2 border-blue-400 shadow-inner">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <!-- Coordonnées -->
                        <div class="truncate">
                            <p class="text-sm font-bold truncate text-white leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[9px] text-blue-300 uppercase font-black tracking-widest">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    
                    <!-- BOUTON RÉGLAGES (MODIF PROFIL) -->
                    <a href="{{ route('profile.edit') }}" title="Modifier mon compte" class="p-2 text-blue-300 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-lg transition-all" wire:navigate>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                </div>

                <!-- BOUTON DÉCONNEXION -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 py-2.5 bg-cnss-red text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-red-700 transition shadow-lg active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>DÉCONNEXION</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ================= MAIN CONTENT AREA ================= -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <!-- Top Header -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-8 z-10 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <div class="h-6 w-1 bg-cnss-blue rounded-full"></div>
                    <h2 class="font-extrabold text-xl text-cnss-blue tracking-tight uppercase">
                        {{ $header ?? "Gestion des Archives Techniques" }}
                    </h2>
                </div>
                <div class="flex items-center space-x-4 text-xs font-bold text-gray-500 bg-gray-50 px-4 py-2 rounded-full border border-gray-100">
                    <svg class="w-4 h-4 text-cnss-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="uppercase tracking-tighter">{{ now()->translatedFormat('d F Y') }}</span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
                <!-- Notifications Succès -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 font-bold text-sm rounded-r-xl shadow-sm flex items-center animate-fade-in">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </main>

            <!-- Bottom Footer -->
            <footer class="bg-white border-t border-gray-200 py-3 px-8 flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                <div>&copy; {{ date('Y') }} <span class="text-cnss-blue">CAISSE NATIONALE DE SÉCURITÉ SOCIALE</span></div>
                <div class="flex items-center">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                    Terminal Division Technique - Kamina
                </div>
            </footer>
        </div>
    </div>
</body>
</html>