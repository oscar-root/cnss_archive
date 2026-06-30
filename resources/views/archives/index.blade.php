<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-xl text-cnss-blue uppercase tracking-tighter">
                @if(auth()->user()->isSecretaire()) 
                    {{ __('Mon Registre d\'Archives') }} 
                @else 
                    {{ __('Registre des Rapports Techniques') }} 
                @endif
            </h2>
            <div class="flex items-center space-x-3">
                <span class="bg-blue-50 text-cnss-blue px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-100 shadow-sm">
                    {{ $archives->count() }} Dossiers en base
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- 1. BARRE DE RECHERCHE ET FILTRAGE PREMIUM -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-8">
                <div class="lg:col-span-9 bg-white p-3 rounded-[2rem] shadow-xl shadow-blue-900/5 border border-gray-100">
                    <form action="{{ route('archives.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Rechercher par intitulé, projet ou référence..." 
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border-none rounded-2xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-cnss-blue transition-all">
                            <svg class="w-5 h-5 text-gray-300 absolute left-4 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        
                        <select name="filter_status" class="bg-gray-50 border-none rounded-2xl text-xs font-black uppercase tracking-widest text-cnss-blue focus:ring-2 focus:ring-cnss-blue py-3 px-6 cursor-pointer">
                            <option value="">Tous les États</option>
                            <option value="en_attente" {{ request('filter_status') == 'en_attente' ? 'selected' : '' }}>En expertise</option>
                            <option value="rejete" {{ request('filter_status') == 'rejete' ? 'selected' : '' }}>À rectifier</option>
                            <option value="valide_chef" {{ request('filter_status') == 'valide_chef' ? 'selected' : '' }}>Prêts Visa</option>
                            <option value="signe_directeur" {{ request('filter_status') == 'signe_directeur' ? 'selected' : '' }}>Signés (À classer)</option>
                            <option value="classe" {{ request('filter_status') == 'classe' ? 'selected' : '' }}>Archivés</option>
                        </select>

                        <button type="submit" class="bg-cnss-blue text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-800 transition shadow-lg shadow-blue-600/20">
                            Appliquer les filtres
                        </button>
                    </form>
                </div>

                <!-- Bouton d'ajout rapide (Secrétaire uniquement) -->
                <div class="lg:col-span-3">
                    @if(auth()->user()->isSecretaire())
                        <a href="{{ route('archives.create') }}" class="flex items-center justify-center h-full bg-cnss-blue text-white rounded-[2rem] hover:bg-blue-800 transition-all shadow-xl shadow-blue-600/20 group p-4 border-2 border-white/20">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            <span class="text-[10px] font-black uppercase tracking-widest">Nouveau Rapport</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- 2. TABLEAU DE GESTION DU FLUX -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-blue-900/10 border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Document & Identité</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Projet Technique</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Progression Flux</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Actions Métier</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($archives as $archive)
                            <tr class="group hover:bg-blue-50/30 transition-all duration-300">
                                <!-- Colonne 1 : Identité -->
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-cnss-blue border border-gray-100 group-hover:bg-cnss-blue group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900 leading-tight mb-1">{{ $archive->intitule }}</div>
                                            <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Enregistré le {{ $archive->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Colonne 2 : Projet -->
                                <td class="px-8 py-6">
                                    <div class="text-xs font-bold text-slate-600">{{ $archive->projet }}</div>
                                    <div class="flex items-center mt-1 text-[9px] text-cnss-blue font-black uppercase tracking-tighter">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        Division Technique Kamina
                                    </div>
                                </td>

                                <!-- Colonne 3 : Statut & Rectification -->
                                <td class="px-8 py-6">
                                    @php
                                        $statuses = [
                                            'en_attente' => ['label' => 'En expertise', 'class' => 'bg-amber-50 text-amber-600 border-amber-100'],
                                            'rejete' => ['label' => 'À rectifier', 'class' => 'bg-red-50 text-cnss-red border-red-100'],
                                            'valide_chef' => ['label' => 'Chef de Service : OK', 'class' => 'bg-blue-50 text-cnss-blue border-blue-100'],
                                            'signe_directeur' => ['label' => 'Visa Accordé', 'class' => 'bg-emerald-50 text-emerald-600 border-emerald-100'],
                                            'classe' => ['label' => 'Archivé', 'class' => 'bg-slate-900 text-white border-slate-900'],
                                        ];
                                        $current = $statuses[$archive->status] ?? $statuses['en_attente'];
                                    @endphp
                                    <div class="flex flex-col">
                                        <span class="px-3 py-1 border rounded-full text-[9px] font-black uppercase tracking-tighter w-fit {{ $current['class'] }}">
                                            {{ $current['label'] }}
                                        </span>
                                        
                                        <!-- INDICATEUR DE RECTIFICATION -->
                                        @if($archive->status == 'en_attente' && $archive->updated_at > $archive->created_at)
                                            <span class="text-[8px] text-blue-500 mt-1 font-black uppercase tracking-[0.2em] italic flex items-center">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1 animate-pulse"></span>
                                                Rapport Rectifié
                                            </span>
                                        @endif
                                        
                                        @if($archive->status == 'rejete')
                                            <span class="text-[9px] text-red-400 mt-1 italic font-medium">Motif: {{ Str::limit($archive->commentaires_chef, 25) }}</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Colonne 4 : ACTIONS MÉTIERS DYNAMIQUE -->
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        
                                        <!-- 1. VISUALISATION (Tous) -->
                                        <a href="{{ asset('storage/' . $archive->fichier_path) }}" target="_blank" class="p-2.5 text-gray-400 hover:text-cnss-blue transition-colors bg-gray-50 rounded-xl border border-transparent hover:border-gray-200" title="Consulter le PDF">
                                            <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>

                                        <!-- 2. ACTIONS DU SECRETAIRE -->
                                        @if(auth()->user()->isSecretaire())
                                            @if($archive->status == 'rejete')
                                                <a href="{{ route('archives.edit', $archive) }}" class="px-5 py-2 bg-cnss-blue text-white rounded-xl text-[9px] font-black uppercase tracking-widest shadow-lg shadow-blue-600/20 hover:scale-105 transition-all">Rectifier</a>
                                            @endif

                                            @if($archive->status == 'signe_directeur')
                                                <div class="bg-emerald-50 p-1 rounded-xl border border-emerald-100 flex items-center animate-pulse">
                                                    <form action="{{ route('archives.classer', $archive) }}" method="POST" class="flex items-center space-x-1">
                                                        @csrf
                                                        <input type="text" name="reference" placeholder="Rayon N°" class="text-[10px] bg-white border-none rounded-lg p-2 w-20 focus:ring-1 focus:ring-emerald-500 font-bold shadow-inner" required>
                                                        <button type="submit" class="p-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 shadow-lg">
                                                            <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endif

                                        <!-- 3. ACTION DU CHEF DE SERVICE -->
                                        @if(auth()->user()->isChefDeService() && $archive->status == 'en_attente')
                                            <a href="{{ route('archives.show', $archive) }}" class="px-5 py-2 bg-cnss-blue text-white rounded-xl text-[9px] font-black uppercase tracking-widest shadow-xl shadow-blue-600/20 border-2 border-white/20">Étudier & Amender</a>
                                        @endif

                                        <!-- 4. ACTION DU DIRECTEUR (VISA) -->
                                        @if(auth()->user()->isDirecteur() && $archive->status == 'valide_chef')
                                            <a href="{{ route('archives.show', $archive) }}" class="px-5 py-2 bg-emerald-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest shadow-xl shadow-emerald-600/20 border-2 border-white/20 flex items-center">
                                                <svg class="w-3 h-3 mr-1 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                Visa Direction
                                            </a>
                                        @endif

                                        <!-- 5. ACTION ADMIN (SUPPRESSION) -->
                                        @if(auth()->user()->isAdmin())
                                            <form action="{{ route('archives.destroy', $archive) }}" method="POST" onsubmit="return confirm('Confirmer la suppression définitive de cet archive ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2.5 text-cnss-red bg-red-50 rounded-xl hover:bg-cnss-red hover:text-white transition-all shadow-sm">
                                                    <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- 6. AFFICHAGE RÉSULTAT FINAL (Si classé) -->
                                        @if($archive->status == 'classe')
                                            <div class="px-4 py-2 bg-slate-900 rounded-xl text-[9px] font-black text-white uppercase tracking-[0.2em] border border-slate-700 shadow-xl flex items-center">
                                                <svg class="w-3 h-3 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                Réf : {{ $archive->reference }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-24 text-center">
                                    <div class="bg-gray-50/50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 border border-gray-100 shadow-inner">
                                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="text-xs font-black text-gray-300 uppercase tracking-[0.3em]">Aucun dossier ne correspond à votre recherche</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- FOOTER DE TRAÇABILITÉ -->
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-center space-x-8 text-[8px] font-black text-gray-400 uppercase tracking-[0.4em]">
                    <span class="flex items-center"><span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2 shadow-sm"></span>Système d'Audit Actif</span>
                    <span>•</span>
                    <span>Transmission Sécurisée AES-256</span>
                    <span>•</span>
                    <span>CNSS Division Kamina</span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>