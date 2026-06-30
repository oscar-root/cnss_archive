<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Récupération de compte | CNSS ArchiveTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,600,900&display=swap" rel="stylesheet" />
    <style>
        body {
            background: #020617; /* Même fond noir bleuté que le login */
            overflow: hidden;
        }
        .bg-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 500px;
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
            transition: all 0.4s ease;
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
            transition: 0.6s;
        }
        .btn-elite:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="antialiased font-sans flex items-center justify-center min-h-screen">

    <div class="bg-glow"></div>

    <div class="relative z-10 w-full max-w-md p-6">
        
        <!-- MODULE RÉCUPÉRATION CENTRAL -->
        <div class="glass-card rounded-[40px] p-8 md:p-12 border-t border-l border-white/10">
            
            <div class="text-center mb-10">
                <img src="{{ asset('images/logo-cnss.png') }}" class="h-14 mx-auto mb-6 brightness-200 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                <h1 class="text-2xl font-black text-white tracking-tight mb-4 uppercase">Identité Oubliée</h1>
                <div class="h-1 w-12 bg-blue-600 rounded-full mb-6 mx-auto"></div>
                
                <p class="text-slate-400 text-xs font-medium leading-relaxed uppercase tracking-wider">
                    Saisissez votre adresse email pour recevoir un lien de réinitialisation sécurisé.
                </p>
            </div>

            <!-- Session Status (Succès de l'envoi) -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-500/10 rounded-2xl border border-emerald-500/50">
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest text-center">
                        {{ session('status') }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Email Professionnel</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                        class="input-dark w-full px-6 py-4 rounded-2xl text-sm outline-none shadow-inner" 
                        placeholder="agent@cnss.cd">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold text-red-400 uppercase" />
                </div>

                <div class="pt-4 space-y-4">
                    <button type="submit" class="btn-elite w-full text-white font-black py-5 rounded-[22px] shadow-2xl hover:scale-[1.02] active:scale-95 transition-all uppercase text-[10px] tracking-[0.2em] border border-white/10">
                        Envoyer les Instructions
                    </button>

                    <a href="{{ route('login') }}" class="block text-center text-[9px] font-black text-slate-500 hover:text-white transition-colors uppercase tracking-[0.3em]">
                        Retourner au terminal
                    </a>
                </div>
            </form>

            <div class="mt-12 text-center text-[8px] font-black text-white/10 uppercase tracking-[0.5em]">
                Protocole de sécurité CNSS ArchiveTech
            </div>
        </div>
    </div>

</body>
</html>