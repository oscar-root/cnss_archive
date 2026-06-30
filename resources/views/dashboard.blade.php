<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-xl text-cnss-blue uppercase tracking-tighter">
                {{ __('Tableau de Bord Institutionnel') }}
            </h2>
            <div class="text-[10px] font-black uppercase text-gray-400 tracking-widest bg-gray-100 px-4 py-1.5 rounded-full border border-gray-200">
                Session : {{ auth()->user()->role }}
            </div>
        </div>
    </x-slot>

    <!-- Inclusion de Chart.js pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- SECTION 1 : ENTÊTE DE BIENVENUE -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-[2rem] p-8 mb-8 border-l-[12px] border-cnss-blue flex flex-col md:flex-row justify-between items-center relative">
                <div class="relative z-10 text-center md:text-left">
                    <h3 class="text-3xl font-black text-gray-800 leading-none mb-2">Bonjour, {{ auth()->user()->name }}</h3>
                    <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.3em]">Caisse Nationale de Sécurité Sociale • Kamina</p>
                </div>
                <div class="mt-6 md:mt-0 opacity-10 hidden md:block">
                    <img src="{{ asset('images/logo-cnss.png') }}" class="h-16">
                </div>
            </div>

            <!-- SECTION 2 : CARTES DE STATISTIQUES (Données réelles) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    $cardStyle = "bg-white p-6 rounded-[2rem] shadow-xl shadow-blue-900/5 border border-gray-100 flex items-center justify-between hover:scale-105 transition duration-300";
                @endphp

                @if(auth()->user()->isSecretaire())
                    <div class="{{ $cardStyle }}">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Mes soumissions</p>
                            <p class="text-3xl font-black text-cnss-blue">{{ $stats['crees'] ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-2xl text-cnss-blue">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                    <div class="{{ $cardStyle }}">
                        <div>
                            <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Dossiers Rejetés</p>
                            <p class="text-3xl font-black text-cnss-red">{{ $stats['rejete'] ?? 0 }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-2xl text-cnss-red">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                    <div class="{{ $cardStyle }}">
                        <div>
                            <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Total Archivés</p>
                            <p class="text-3xl font-black text-emerald-600">{{ $stats['classes'] ?? 0 }}</p>
                        </div>
                        <div class="bg-emerald-50 p-4 rounded-2xl text-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                    </div>
                @endif

                @if(auth()->user()->isChefDeService())
                    <div class="{{ $cardStyle }}">
                        <div>
                            <p class="text-[10px] font-black text-amber-400 uppercase tracking-widest mb-1">Expertises en attente</p>
                            <p class="text-3xl font-black text-amber-600">{{ $stats['a_verifier'] ?? 0 }}</p>
                        </div>
                        <div class="bg-amber-50 p-4 rounded-2xl text-amber-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <!-- Ajoutez d'autres stats ici pour le Chef -->
                @endif
            </div>

            <!-- SECTION 3 : GRAPHIQUE ET ACTIONS -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Graphique -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-8">Activité du Registre Numérique</h4>
                    <canvas id="archiveChart" height="180"></canvas>
                </div>

                <!-- Actions Rapides -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-8">Opérations Prioritaires</h4>
                    <div class="space-y-4">
                        @if(auth()->user()->isSecretaire())
                            <a href="{{ route('archives.create') }}" class="flex items-center justify-between p-5 bg-cnss-blue text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-blue-800 shadow-xl shadow-blue-600/20 transition-all active:scale-95 group">
                                <span>Constituer une Archive</span>
                                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="{{ route('archives.index') }}" class="flex items-center justify-between p-5 border-2 border-cnss-blue text-cnss-blue rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-blue-50 transition-all">
                                <span>Vérifier mes rapports</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path></svg>
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="flex items-center justify-between p-5 bg-cnss-blue text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-blue-800 transition-all shadow-xl">
                                <span>Gérer les comptes utilisateurs</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SECTION 4 : DERNIERS MOUVEMENTS -->
             @if(auth()->user()->isSecretaire() || auth()->user()->isChefDeService() || auth()->user()->isDirecteur() )
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-5 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Flux de travail récent</h4>
                    <a href="{{ route('archives.index') }}" class="text-[9px] font-black text-cnss-blue uppercase tracking-widest border-b-2 border-cnss-blue">Voir le registre complet</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentActivities ?? [] as $archive)
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="px-8 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $archive->intitule }}</div>
                                    <div class="text-[9px] font-black text-gray-400 uppercase">{{ $archive->projet }}</div>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase
                                        {{ $archive->status == 'en_attente' ? 'bg-amber-50 text-amber-600' : '' }}
                                        {{ $archive->status == 'signe_directeur' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                        {{ $archive->status == 'rejete' ? 'bg-red-50 text-cnss-red' : '' }}
                                        {{ $archive->status == 'classe' ? 'bg-slate-900 text-white' : '' }}
                                    ">
                                        {{ str_replace('_', ' ', $archive->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right text-[10px] font-bold text-gray-400">
                                    {{ $archive->created_at->diffForHumans() }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-10 text-center text-gray-300 italic text-sm">Aucun mouvement récent enregistré.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Script du graphique (données factices pour l'exemple, à lier à $chartData) -->
    <script>
        const ctx = document.getElementById('archiveChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Volume de rapports',
                    data: [12, 19, 13, 25, 22, 30],
                    borderColor: '#003399',
                    borderWidth: 4,
                    backgroundColor: 'rgba(0, 51, 153, 0.05)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { 
                    x: { display: false },
                    y: { grid: { display: false }, ticks: { display: false } }
                }
            }
        });
    </script>
</x-app-layout>