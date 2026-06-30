<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#0a2a5e] via-[#0d3b7a] to-[#1a4f96] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Éléments décoratifs -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-white/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Carte de réinitialisation -->
        <div class="w-full max-w-md relative z-10">
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 p-8 md:p-10 transition-all duration-500 hover:shadow-3xl">
                
                <!-- Logo et titre -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <img src="{{ asset('images/logo-cnss.png') }}" class="h-16 w-auto drop-shadow-2xl">
                            <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-400 rounded-full border-2 border-[#0a2a5e]"></span>
                        </div>
                    </div>
                    <h2 class="text-3xl font-black text-white tracking-tight">
                        Nouveau mot de passe
                    </h2>
                    <p class="mt-2 text-sm text-blue-200/70 font-medium">
                        Créez un mot de passe sécurisé
                    </p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Adresse email')" class="text-sm font-bold text-blue-100 uppercase tracking-wider" />
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-300/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <x-text-input id="email" 
                                class="block w-full pl-10 pr-3 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-blue-200/30 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 transition-all duration-300" 
                                type="email" 
                                name="email" 
                                :value="old('email', $request->email)" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="exemple@cnss.cd" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs font-medium" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Nouveau mot de passe')" class="text-sm font-bold text-blue-100 uppercase tracking-wider" />
                        <div class="mt-1 relative" x-data="{ showPassword: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-300/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <x-text-input id="password" 
                                class="block w-full pl-10 pr-12 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-blue-200/30 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 transition-all duration-300" 
                                :type="showPassword ? 'text' : 'password'"
                                name="password" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••" />
                            <button type="button" 
                                @click="showPassword = !showPassword" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-300/40 hover:text-blue-200 transition-colors">
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs font-medium" />
                        
                        <!-- Indicateur de force du mot de passe -->
                        <div class="mt-2">
                            <div class="flex items-center space-x-2">
                                <div class="flex-1 h-1 bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-400 rounded-full transition-all duration-500" style="width: 0%" x-data="{ strength: 0 }" x-init="
                                        $watch('password', value => {
                                            let score = 0;
                                            if (value.length >= 8) score++;
                                            if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score++;
                                            if (/\d/.test(value)) score++;
                                            if (/[^a-zA-Z0-9]/.test(value)) score++;
                                            strength = (score / 4) * 100;
                                        })
                                    " :style="`width: ${strength}%`"></div>
                                </div>
                                <span class="text-[10px] font-bold text-blue-200/40 uppercase tracking-wider" x-text="
                                    strength === 0 ? 'Faible' :
                                    strength <= 50 ? 'Moyen' :
                                    strength <= 75 ? 'Fort' : 'Très fort'
                                "></span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-sm font-bold text-blue-100 uppercase tracking-wider" />
                        <div class="mt-1 relative" x-data="{ showConfirm: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-300/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <x-text-input id="password_confirmation" 
                                class="block w-full pl-10 pr-12 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-blue-200/30 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/30 transition-all duration-300" 
                                :type="showConfirm ? 'text' : 'password'"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••" />
                            <button type="button" 
                                @click="showConfirm = !showConfirm" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-300/40 hover:text-blue-200 transition-colors">
                                <svg x-show="!showConfirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showConfirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-xs font-medium" />
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                            class="w-full flex justify-center items-center py-3.5 px-4 bg-white text-[#0a2a5e] font-black text-sm uppercase tracking-widest rounded-xl shadow-xl shadow-black/20 hover:shadow-2xl hover:shadow-black/30 hover:-translate-y-0.5 transition-all duration-300 active:scale-95">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            {{ __('Réinitialiser le mot de passe') }}
                        </button>
                    </div>

                    <!-- Retour à la connexion -->
                    <div class="text-center">
                        <p class="text-sm text-blue-200/60">
                            Vous vous souvenez de votre mot de passe ? 
                            <a href="{{ route('login') }}" class="font-bold text-white hover:text-blue-200 transition-colors duration-300 underline decoration-2 underline-offset-2 decoration-blue-400/30">
                                Se connecter
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer minimal -->
            <div class="mt-6 text-center">
                <p class="text-xs text-blue-200/30 font-medium tracking-wider">
                    &copy; {{ date('Y') }} CNSS DRC - Archivage Numérique
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>