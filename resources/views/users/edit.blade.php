<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('users.index') }}" class="text-gray-400 hover:text-cnss-blue transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-black text-xl text-cnss-blue uppercase tracking-tighter">
                {{ __('Modifier le profil agent') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl shadow-blue-900/10 border border-gray-100 overflow-hidden">
                
                <!-- HEADER DE LA CARTE : IDENTITÉ VISUELLE -->
                <div class="bg-cnss-blue p-8 text-center relative overflow-hidden">
                    <!-- Motif de fond discret -->
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <path d="M0 0 L100 100 L100 0 Z"></path>
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <div class="h-24 w-24 mx-auto bg-white rounded-full flex items-center justify-center text-cnss-blue text-3xl font-black shadow-2xl border-4 border-blue-400/30">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <h3 class="text-white font-black text-2xl mt-4 tracking-tight">{{ $user->name }}</h3>
                        <div class="inline-block mt-2 px-4 py-1 bg-blue-900/30 rounded-full border border-blue-400/20">
                            <span class="text-blue-100 text-[10px] font-black uppercase tracking-widest">
                                Rôle actuel : {{ str_replace('_', ' ', $user->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- FORMULAIRE DE MISE À JOUR -->
                <form action="{{ route('users.update', $user) }}" method="POST" class="p-10 space-y-8">
                    @csrf 
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Champ Nom -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Nom complet de l'agent</label>
                            <div class="relative">
                                <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm font-bold text-gray-700 py-4 px-5 transition-all" required>
                                <svg class="w-5 h-5 text-gray-300 absolute right-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>

                        <!-- Champ Email -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Adresse email professionnelle</label>
                            <div class="relative">
                                <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm font-bold text-gray-700 py-4 px-5 transition-all" required>
                                <svg class="w-5 h-5 text-gray-300 absolute right-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>

                        <!-- Champ Rôle -->
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Modifier l'habilitation</label>
                            <select name="role" class="w-full bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm font-black text-cnss-blue py-4 px-5 appearance-none cursor-pointer">
                                <option value="secretaire" {{ $user->role == 'secretaire' ? 'selected' : '' }}>Secrétaire (Constitution)</option>
                                <option value="chef_de_service" {{ $user->role == 'chef_de_service' ? 'selected' : '' }}>Chef de Service (Amendement)</option>
                                <option value="directeur" {{ $user->role == 'directeur' ? 'selected' : '' }}>Directeur (Visa/Signature)</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur (Système)</option>
                            </select>
                        </div>

                        <!-- ZONE SÉCURITÉ : MOT DE PASSE -->
                        <div class="mt-4 p-6 bg-blue-50/50 rounded-3xl border border-blue-100 space-y-4">
                            <div class="flex items-center space-x-2 mb-2">
                                <svg class="w-4 h-4 text-cnss-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <h4 class="text-[10px] font-black text-cnss-blue uppercase tracking-widest">Sécurité du compte</h4>
                            </div>
                            
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Nouveau mot de passe</label>
                                <input type="password" name="password" placeholder="••••••••" class="w-full bg-white border-none rounded-xl focus:ring-2 focus:ring-cnss-blue text-sm py-3 px-4 shadow-sm">
                                <p class="text-[9px] text-gray-400 font-bold italic ml-1 mt-1 uppercase leading-tight">
                                    * Laisser vide pour conserver l'accès actuel
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="flex items-center justify-between pt-6">
                        <a href="{{ route('users.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-cnss-red transition-colors">
                            Annuler l'édition
                        </a>
                        
                        <button type="submit" class="bg-cnss-blue text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-blue-600/20 hover:bg-blue-800 hover:scale-105 transition-all duration-300 uppercase text-xs tracking-widest border-2 border-white/20">
                            Sauvegarder les modifications
                        </button>
                    </div>
                </form>

                <!-- FOOTER DE SÉCURITÉ -->
                <div class="px-10 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-center space-x-2">
                    <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"></path></svg>
                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Modification tracée par le système</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>