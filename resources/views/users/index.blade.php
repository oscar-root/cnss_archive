<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-xl text-cnss-blue uppercase tracking-tighter">
                {{ __('Administration des Utilisateurs') }}
            </h2>
            <div class="flex space-x-2">
                <span class="bg-blue-100 text-cnss-blue px-3 py-1 rounded-full text-[10px] font-black uppercase">
                    Total : {{ $users->count() }} Acteurs
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- SECTION FORMULAIRE : DESIGN ÉPURÉ -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 border border-gray-100 overflow-hidden sticky top-24">
                        <div class="bg-cnss-blue p-6">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Enrôler un agent
                            </h3>
                            <p class="text-blue-200 text-[10px] uppercase font-bold mt-1 tracking-widest">Création de compte sécurisé</p>
                        </div>

                        <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-5">
                            @csrf
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Nom complet de l'agent</label>
                                <input type="text" name="name" placeholder="Ex: Jean Mukendi" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-cnss-blue text-sm font-bold text-gray-700 placeholder-gray-300 transition-all duration-300">
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Adresse Email</label>
                                <input type="email" name="email" placeholder="agent@cnss.cd" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-cnss-blue text-sm font-bold text-gray-700 placeholder-gray-300">
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Attribution du Rôle</label>
                                <select name="role" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-cnss-blue text-sm font-bold text-cnss-blue">
                                    <option value="secretaire">Secrétaire (Constitution)</option>
                                    <option value="chef_de_service">Chef de Service (Amendement)</option>
                                    <option value="directeur">Directeur (Visa/Signature)</option>
                                    <option value="admin">Administrateur (Système)</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase ml-1">Mot de passe temporaire</label>
                                <input type="password" name="password" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-cnss-blue text-sm">
                            </div>

                            <button type="submit" class="w-full bg-cnss-blue text-white font-black py-4 rounded-xl shadow-lg shadow-blue-600/20 hover:bg-blue-800 hover:-translate-y-1 transition-all duration-300 uppercase text-xs tracking-widest">
                                Confirmer l'inscription
                            </button>
                        </form>
                    </div>
                </div>

                <!-- SECTION LISTE : DESIGN "DATA-TABLE" MODERNE -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-white border-b border-gray-50 flex justify-between items-center">
                            <h4 class="font-black text-gray-400 text-[10px] uppercase tracking-widest">Registre des accès</h4>
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un agent..." class="pl-8 pr-4 py-2 bg-gray-50 border-none rounded-full text-xs w-64 focus:ring-1 focus:ring-cnss-blue">
                                <svg class="w-4 h-4 text-gray-300 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50/50">
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-left tracking-wider">Agent</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-left tracking-wider">Habilitation</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-right tracking-wider">Gestion</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($users as $user)
                                    <tr class="group hover:bg-blue-50/50 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <!-- AVATAR GÉNÉRÉ -->
                                                <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gradient-to-br from-cnss-blue to-blue-400 flex items-center justify-center text-white font-black text-xs shadow-inner">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900 group-hover:text-cnss-blue transition-colors">{{ $user->name }}</div>
                                                    <div class="text-[10px] text-gray-400 font-medium">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $roleClasses = [
                                                    'admin' => 'bg-red-50 text-cnss-red border-red-100',
                                                    'secretaire' => 'bg-blue-50 text-cnss-blue border-blue-100',
                                                    'chef_de_service' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                    'directeur' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                ];
                                            @endphp
                                            <span class="px-3 py-1 border rounded-full text-[9px] font-black uppercase tracking-tighter {{ $roleClasses[$user->role] ?? 'bg-gray-50' }}">
                                                {{ str_replace('_', ' ', $user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                                            <div class="flex justify-end items-center space-x-4">
                                                <a href="{{ route('users.edit', $user) }}" class="text-gray-400 hover:text-cnss-blue flex items-center transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    
                                                </a>
                                                
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Supprimer cet agent ?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-gray-300 hover:text-cnss-red flex items-center transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- FOOTER TABLEAU -->
                        <div class="p-4 bg-gray-50/50 text-center">
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest italic">
                                Accès sécurisé - Journal des modifications actif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>