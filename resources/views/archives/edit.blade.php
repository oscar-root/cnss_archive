<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('archives.index') }}" class="text-gray-400 hover:text-cnss-blue transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-xl text-cnss-blue uppercase tracking-tighter">
                {{ __('Rectification du Rapport Technique') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- AFFICHAGE DES ERREURS DE VALIDATION (CRUCIAL POUR SAVOIR POURQUOI ÇA BLOQUE) -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-600 text-white rounded-2xl shadow-lg font-bold text-xs uppercase tracking-widest">
                    <p class="mb-2 italic underline text-[10px]">Erreurs détectées par le système :</p>
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- ALERTE : MOTIF DE REJET -->
            <div class="mb-8 bg-white rounded-3xl shadow-xl shadow-red-900/10 border-l-[12px] border-cnss-red overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="bg-red-100 p-3 rounded-2xl">
                            <svg class="w-6 h-6 text-cnss-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-[10px] font-black text-cnss-red uppercase tracking-[0.2em] mb-1">Instruction de correction (Chef de Service)</h4>
                            <p class="text-gray-700 font-bold italic leading-relaxed uppercase">
                                "{{ $archive->commentaires_chef }}"
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-red-50 px-6 py-2">
                        <p class="text-[9px] font-bold text-red-400 uppercase tracking-widest">Ajustez les données réelles avant de renvoyer le flux</p>
                </div>
            </div>

            <!-- FORMULAIRE DE CORRECTION -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-blue-900/10 border border-gray-100 overflow-hidden">
                <form action="{{ route('archives.update', $archive) }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      x-data="{ newFileName: '' }"
                      class="p-10 space-y-8">
                    @csrf 
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-8">
                        
                        <!-- Modification Intitulé -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Modifier l'Intitulé officiel</label>
                            <div class="relative">
                                <!-- pointer-events-none sur l'icône libère l'accès au champ de texte -->
                                <input type="text" name="intitule" value="{{ old('intitule', $archive->intitule) }}" 
                                    class="w-full bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm font-bold text-gray-700 py-4 px-5 transition-all shadow-inner" required>
                                <svg class="w-5 h-5 text-gray-300 absolute right-4 top-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                        </div>

                        <!-- Modification Projet -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Ajuster le Nom du Projet</label>
                            <div class="relative">
                                <input type="text" name="projet" value="{{ old('projet', $archive->projet) }}" 
                                    class="w-full bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm font-bold text-gray-700 py-4 px-5 transition-all shadow-inner" required>
                                <svg class="w-5 h-5 text-gray-300 absolute right-4 top-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                        </div>

                        <!-- Remplacement Fichier -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Support numérique (Modifier si nécessaire)</label>
                            <div class="relative h-44 group">
                                <div class="absolute inset-0 bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] transition-all group-hover:bg-blue-50 group-hover:border-cnss-blue"></div>
                                
                                <div class="relative h-full flex flex-col items-center justify-center text-center p-5 pointer-events-none">
                                    <svg class="w-10 h-10 text-gray-300 mb-3 group-hover:text-cnss-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="text-xs font-bold text-gray-500 mb-1" x-text="newFileName ? 'Fichier prêt pour téléversement' : 'Cliquer pour charger la version corrigée'"></p>
                                    <p class="text-[9px] font-black text-cnss-blue uppercase tracking-tighter truncate max-w-xs" x-text="newFileName ? newFileName : 'Document actuel : {{ basename($archive->fichier_path) }}'"></p>
                                </div>

                                <input type="file" name="fichier" 
                                    @change="newFileName = $event.target.files[0].name"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30">
                            </div>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="flex items-center justify-between pt-8 border-t border-gray-50">
                        <a href="{{ route('archives.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-cnss-red transition-colors">
                            Abandonner
                        </a>
                        
                        <button type="submit" class="bg-cnss-blue text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-blue-600/20 hover:bg-blue-800 hover:scale-105 transition-all duration-300 uppercase text-xs tracking-widest flex items-center">
                            <span>Renvoyer pour Amendement</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>