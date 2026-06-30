<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('archives.index') }}" class="text-gray-400 hover:text-cnss-blue transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-xl text-cnss-blue uppercase tracking-tighter">
                {{ __('Constitution d\'une nouvelle archive') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-blue-900/10 border border-gray-100 overflow-hidden">
                
                <!-- ENTÊTE -->
                <div class="bg-cnss-blue p-8 text-white relative">
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-black tracking-tight">Nouveau Rapport Technique</h3>
                            <p class="text-blue-200 text-[10px] font-black uppercase tracking-[0.2em] mt-1">Saisie des données réelles</p>
                        </div>
                    </div>
                </div>

                <!-- FORMULAIRE (Ajout de Alpine.js pour le nom du fichier) -->
                <form action="{{ route('archives.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      x-data="{ fileName: '' }" 
                      class="p-10 space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-8">
                        
                        <!-- Intitulé -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Intitulé officiel</label>
                            <div class="relative flex items-center">
                                <input type="text" name="intitule" placeholder="Ex: Rapport d'audit..." 
                                    class="w-full bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm font-bold text-gray-700 py-4 px-5 shadow-inner z-10" required>
                                <!-- pointer-events-none empêche l'icône de bloquer le clic -->
                                <svg class="w-5 h-5 text-gray-300 absolute right-4 pointer-events-none z-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                        </div>

                        <!-- Projet -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Projet concerné</label>
                            <div class="relative flex items-center">
                                <input type="text" name="projet" placeholder="Ex: Projet Kamina..." 
                                    class="w-full bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm font-bold text-gray-700 py-4 px-5 shadow-inner z-10" required>
                                <svg class="w-5 h-5 text-gray-300 absolute right-4 pointer-events-none z-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Date du rapport</label>
                            <div class="relative flex items-center">
                                <input type="date" name="date_projet" 
                                    class="w-full bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm font-black text-cnss-blue py-4 px-5 shadow-inner z-10" required>
                                <svg class="w-5 h-5 text-gray-300 absolute right-4 pointer-events-none z-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>

                        <!-- Zone de Téléchargement CORRIGÉE -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Support numérique (PDF / DOCX)</label>
                            <div class="relative h-40 group">
                                <!-- Décoration de fond -->
                                <div class="absolute inset-0 bg-blue-50 border-2 border-dashed border-blue-200 rounded-[2rem] transition-all group-hover:bg-blue-100/50 group-hover:border-cnss-blue"></div>
                                
                                <!-- Contenu visuel -->
                                <div class="relative h-full flex flex-col items-center justify-center text-center p-5 pointer-events-none">
                                    <svg class="w-10 h-10 text-cnss-blue mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="text-xs font-bold text-gray-600" x-text="fileName ? 'Fichier sélectionné' : 'Cliquer pour choisir le fichier'"></p>
                                    <p class="text-[10px] font-black text-cnss-blue mt-1 uppercase truncate max-w-xs" x-text="fileName"></p>
                                </div>

                                <!-- Input réel (L'astuce est de le mettre à la fin avec un curseur sur toute la zone) -->
                                <input type="file" name="fichier" 
                                    @change="fileName = $event.target.files[0].name"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30" required>
                            </div>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="flex items-center justify-between pt-8 border-t border-gray-50">
                        <a href="{{ route('archives.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-cnss-red transition-colors">Annuler</a>
                        <button type="submit" class="bg-cnss-blue text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-blue-600/20 hover:bg-blue-800 transition-all uppercase text-xs tracking-widest flex items-center">
                            Valider et Transmettre
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>