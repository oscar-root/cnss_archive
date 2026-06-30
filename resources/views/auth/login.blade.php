<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accès Sécurisé | CNSS ArchiveTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,600,900&display=swap" rel="stylesheet" />
    <style>
        body {
            background: #020617; /* Fond noir bleuté profond */
            overflow: hidden;
        }
        /* Effet de particules lumineuses en arrière-plan */
        .bg-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(10, 42, 94, 0.4) 0%, rgba(2, 6, 23, 0) 70%);
            filter: blur(80px);
            z-index: 0;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .input-dark {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-dark:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2) !important;
        }
        .btn-elite {
            background: linear-gradient(135deg, #0a2a5e 0%, #1e40af 100%);
            position: relative;
            overflow: hidden;
        }
        .btn-elite::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        .btn-elite:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="antialiased font-sans flex items-center justify-center min-h-screen">

    <!-- Arrière-plan Technologique -->
    <div class="bg-glow"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>

    <div class="relative z-10 w-full max-w-[1100px] flex items-center justify-center p-6">
        
        <!-- MODULE DE CONNEXION CENTRAL -->
        <div class="glass-card w-full max-w-4xl rounded-[40px] flex flex-col md:flex-row overflow-hidden border-t border-l border-white/10">
            
            <!-- SECTION GAUCHE : VISUEL INSTITUTIONNEL -->
            <div class="hidden md:flex md:w-1/2 p-12 flex-col justify-between border-r border-white/5 bg-gradient-to-b from-white/5 to-transparent">
                <div>
                    <img src="{{ asset('images/logo-cnss.png') }}" class="h-16 brightness-200 mb-8 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                    <h2 class="text-4xl font-black text-white uppercase tracking-tighter leading-none mb-4">
                        Archive<span class="text-blue-400">Tech</span> <br>
                        <span class="text-xl font-light tracking-[0.3em] text-blue-200/50">Terminal v2.0</span>
                    </h2>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center border border-blue-500/30">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-blue-100/70 uppercase tracking-widest leading-relaxed">
                            Accès restreint au personnel de la <br> Division Technique de Kamina.
                        </p>
                    </div>
                </div>

                <div class="text-[9px] font-black text-white/20 uppercase tracking-[0.5em]">
                    CNSS DRC • Système d'audit actif
                </div>
            </div>

            <!-- SECTION DROITE : FORMULAIRE ÉPURÉ -->
            <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">
                <div class="mb-10 text-center md:text-left">
                    <h1 class="text-3xl font-black text-white tracking-tight mb-2">Authentification</h1>
                    <div class="h-1 w-12 bg-blue-600 rounded-full mb-4 mx-auto md:mx-0"></div>
                    <p class="text-slate-400 text-sm font-medium">Veuillez décliner votre identité numérique.</p>
                </div>

                <!-- Erreurs Laravel -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500/10 rounded-2xl border border-red-500/50">
                        @foreach ($errors->all() as $error)
                            <p class="text-[10px] font-bold text-red-400 uppercase tracking-widest text-center">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Identifiant Email</label>
                        <input type="email" name="email" :value="old('email')" required autofocus 
                            class="input-dark w-full px-6 py-4 rounded-2xl text-sm outline-none" 
                            placeholder="agent@cnss.cd">
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Clé d'accès</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[9px] font-black text-blue-400 hover:text-white transition-colors uppercase tracking-widest">Oubliée ?</a>
                            @endif
                        </div>
                        <input type="password" name="password" required 
                            class="input-dark w-full px-6 py-4 rounded-2xl text-sm outline-none" 
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center px-1">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-white/10 bg-white/5 text-blue-600 focus:ring-blue-600">
                        <label for="remember_me" class="ml-3 text-[10px] font-black text-slate-500 uppercase tracking-widest cursor-pointer hover:text-slate-300 transition-colors">Maintenir la session</label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn-elite w-full text-white font-black py-5 rounded-[22px] shadow-2xl hover:scale-[1.02] active:scale-95 transition-all uppercase text-[11px] tracking-[0.3em] border border-white/10">
                            Initialiser la Connexion
                        </button>
                    </div>
                </form>

                <!-- Footer Mobile -->
                <div class="md:hidden mt-12 text-center">
                    <img src="{{ asset('images/logo-cnss.png') }}" class="h-10 mx-auto opacity-50 brightness-200">
                </div>
            </div>

        </div>
    </div>

</body>
</html>