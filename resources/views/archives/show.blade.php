<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('archives.index') }}" class="text-gray-400 hover:text-cnss-blue transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-xl text-cnss-blue uppercase tracking-tighter">
                {{ __('Examen du Rapport Technique') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- COLONNE GAUCHE : VISUALISATION DU DOCUMENT (7/12) -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden h-full flex flex-col">
                    <div class="bg-slate-800 p-4 flex justify-between items-center text-white">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest">Aperçu du support numérique</span>
                        </div>
                        <a href="{{ asset('storage/' . $archive->fichier_path) }}" target="_blank" class="text-[10px] bg-white/10 hover:bg-white/20 px-3 py-1 rounded-lg transition uppercase font-bold">Plein écran</a>
                    </div>
                    <div class="flex-1 bg-slate-100">
                        <iframe src="{{ asset('storage/' . $archive->fichier_path) }}" class="w-full h-[700px] border-none"></iframe>
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE : DETAILS ET DECISION (5/12) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Bloc Infos -->
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4">
                        <svg class="w-12 h-12 text-blue-50 opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M13 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V9l-7-7z"></path></svg>
                    </div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Fiche d'identification</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[9px] font-black text-cnss-blue uppercase tracking-widest">Intitulé du Rapport</p>
                            <p class="text-lg font-bold text-gray-800 leading-tight">{{ $archive->intitule }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase">Projet</p>
                                <p class="text-xs font-bold text-gray-700">{{ $archive->projet }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase">Soumis par</p>
                                <p class="text-xs font-bold text-gray-700">{{ $archive->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ZONE DE DÉCISION DYNAMIQUE -->
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100">
                    
                    {{-- 1. CAS DU CHEF DE SERVICE --}}
                    @if(auth()->user()->isChefDeService() && $archive->status == 'en_attente')
                        <h3 class="text-lg font-black text-cnss-blue mb-6 uppercase tracking-tighter border-b pb-2">Expertise du Chef de Service</h3>
                        <form action="{{ route('archives.validerChef', $archive) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 ml-1">Amendements / Commentaires techniques</label>
                                <textarea name="commentaire" rows="4" placeholder="Obligatoire en cas de rejet..." class="w-full rounded-2xl border-gray-200 focus:ring-2 focus:ring-cnss-blue text-sm font-medium shadow-inner"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <button type="submit" name="action" value="rejeter" class="bg-cnss-red text-white font-black py-4 rounded-2xl hover:bg-red-700 transition shadow-lg shadow-red-600/20 uppercase text-[10px] tracking-widest">
                                    Rejeter / Corriger
                                </button>
                                <button type="submit" name="action" value="valider" class="bg-cnss-blue text-white font-black py-4 rounded-2xl hover:bg-blue-800 transition shadow-lg shadow-blue-600/20 uppercase text-[10px] tracking-widest border-2 border-white/20">
                                    Valider (OK)
                                </button>
                            </div>
                        </form>
                    @endif

                    {{-- 2. CAS DU DIRECTEUR (LE VISA) --}}
                    @if(auth()->user()->isDirecteur())
                        @if($archive->status == 'valide_chef')
                            <div class="text-center py-4">
                                <h3 class="text-xl font-black text-emerald-600 mb-4 uppercase tracking-tighter">Visa de la Direction</h3>
                                <p class="text-xs text-gray-500 mb-8 italic font-medium leading-relaxed">
                                    "Le Chef de Service a validé la conformité technique. Votre signature autorise le classement final de ce rapport."
                                </p>
                                <form action="{{ route('archives.signer', $archive) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-600 text-white font-black py-5 rounded-2xl shadow-2xl shadow-emerald-600/30 hover:bg-emerald-700 hover:scale-[1.02] transition-all uppercase text-xs tracking-[0.2em] flex items-center justify-center border-2 border-white">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Apposer mon Visa définitif
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center py-10">
                                <div class="bg-blue-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-cnss-blue">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-[10px] font-black text-cnss-blue uppercase tracking-widest">En attente de validation technique</p>
                            </div>
                        @endif
                    @endif

                </div>

                <!-- Rappel du Workflow (Bas de page) -->
                <div class="bg-gray-950 p-6 rounded-[2rem] text-white flex items-center space-x-4 shadow-2xl">
                    <div class="p-3 bg-white/10 rounded-xl">
                        <svg class="w-6 h-6 text-cnss-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-cnss-blue">Intégrité CNSS</p>
                        <p class="text-[9px] text-gray-400 font-medium">Chaque action sur ce rapport est tracée dans le journal d'audit de la Division Technique.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>