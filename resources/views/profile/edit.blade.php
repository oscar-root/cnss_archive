<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-cnss-blue uppercase tracking-tighter">
            {{ __('Paramètres du Compte Agent') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- COLONNE GAUCHE : RÉSUMÉ DE L'IDENTITÉ -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-[#0a2a5e] rounded-[2.5rem] p-8 text-center shadow-2xl shadow-blue-900/20 relative overflow-hidden">
                        <!-- Déco fond -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-400/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                        
                        <div class="relative z-10">
                            <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center text-cnss-blue text-3xl font-black shadow-xl border-4 border-blue-400/30 mb-4">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <h3 class="text-white font-black text-xl tracking-tight">{{ auth()->user()->name }}</h3>
                            <p class="text-blue-300 text-[10px] font-black uppercase tracking-[0.2em] mt-1">{{ auth()->user()->role }}</p>
                            
                            <div class="mt-8 pt-8 border-t border-white/10 space-y-4">
                                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-blue-200/50">
                                    <span>Membre depuis</span>
                                    <span class="text-white">{{ auth()->user()->created_at->format('M Y') }}</span>
                                </div>
                                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-blue-200/50">
                                    <span>Statut Compte</span>
                                    <span class="text-emerald-400 flex items-center">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-2 animate-pulse"></span>
                                        Actif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Note de sécurité -->
                    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-xl flex items-start space-x-4">
                        <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-800">Conseil Sécurité</h4>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed mt-1">Utilisez un mot de passe complexe mêlant chiffres et symboles pour protéger vos accès au registre technique.</p>
                        </div>
                    </div>
                </div>

                <!-- COLONNE DROITE : FORMULAIRES -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- 1. Informations de base -->
                    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
                        <div class="flex items-center space-x-3 mb-8">
                            <div class="h-8 w-1 bg-cnss-blue rounded-full"></div>
                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tighter">Informations Personnelles</h3>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- 2. Mot de passe -->
                    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
                        <div class="flex items-center space-x-3 mb-8">
                            <div class="h-8 w-1 bg-cnss-blue rounded-full"></div>
                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tighter">Sécurisation (Mot de passe)</h3>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- 3. Suppression (Zone de Danger) -->
                    @if(auth()->user()->isAdmin())
                    <div class="bg-red-50/30 p-10 rounded-[2.5rem] border border-red-100">
                        <div class="flex items-center space-x-3 mb-8 text-cnss-red">
                            <div class="h-8 w-1 bg-cnss-red rounded-full"></div>
                            <h3 class="text-lg font-black uppercase tracking-tighter">Zone Critique</h3>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>