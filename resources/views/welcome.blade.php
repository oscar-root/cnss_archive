<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CNSS | Archivage Numérique</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,700,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        .reveal { 
            opacity: 0; 
            transform: translateY(30px); 
            transition: all 1s cubic-bezier(0.22, 1, 0.36, 1); 
        }
        .reveal.active { opacity: 1; transform: translateY(0); }
        
        @keyframes kenburns {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }
        .animate-kenburns { animation: kenburns 8s ease-in-out infinite alternate; }

        .glass-nav {
            background: rgba(10, 42, 94, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        /* Effet de texte moderne sans bloc lourd */
        .text-accent {
            color: #0a2a5e;
            position: relative;
            display: inline-block;
        }
        .text-accent::after {
            content: "";
            position: absolute;
            bottom: 8px;
            left: 0;
            width: 100%;
            height: 12px;
            background: rgba(10, 42, 94, 0.1);
            z-index: -1;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-[#fcfdfe] text-slate-900 font-sans" x-data="{ isTop: true }" @scroll.window="isTop = window.pageYOffset < 50">

    <!-- ========== NAVBAR ========== -->
    <nav :class="isTop ? 'bg-[#0a2a5e] py-6' : 'glass-nav py-3 shadow-2xl'" class="fixed w-full top-0 z-50 transition-all duration-500">
        <div class="max-w-7xl mx-auto px-8 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo-cnss.png') }}" class="h-10 w-auto">
                <div class="h-6 w-px bg-white/20"></div>
                <span class="font-black text-lg tracking-tighter text-white uppercase italic">Archive<span class="text-blue-400">Tech</span></span>
            </div>

            <div class="hidden lg:flex items-center space-x-1">
                <a href="#accueil" class="px-6 py-2 text-[10px] font-black uppercase tracking-[0.2em] text-white/70 hover:text-white transition">Accueil</a>
                <a href="#mission" class="px-6 py-2 text-[10px] font-black uppercase tracking-[0.2em] text-white/70 hover:text-white transition">Mission</a>
                <a href="#propos" class="px-6 py-2 text-[10px] font-black uppercase tracking-[0.2em] text-white/70 hover:text-white transition">À Propos</a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-[#0a2a5e] px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl transition-all" wire:navigate>Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-white/80 hover:text-white transition mr-4" wire:navigate>Connexion</a>
                    
                @endauth
            </div>
        </div>
    </nav>

    <!-- ========== SECTION ACCUEIL (HERO) AMÉLIORÉE ========== -->
    <section id="accueil" class="relative min-h-screen flex items-center pt-24 overflow-hidden">
        <div class="max-w-6xl mx-auto px-8 w-full text-center">
            <div class="reveal active">
                <span class="inline-block bg-blue-50 text-[#0a2a5e] px-5 py-1.5 rounded-full text-[9px] font-black uppercase tracking-[0.4em] mb-8 border border-blue-100">
                    Direction provinciale • Kamina
                </span>
                
                <h1 class="text-6xl md:text-7xl lg:text-8xl font-black leading-[1.05] tracking-tighter text-slate-900 mb-8">
                    L'excellence de <br>
                    <span class="text-accent italic">l'archivage</span> numérique.
                </h1>
                
                <p class="text-lg md:text-xl text-slate-500 font-medium max-w-2xl mx-auto leading-relaxed mb-12">
                    Une architecture numérique sécurisée dédiée à la pérennité et à la traçabilité des données techniques de la CNSS.
                </p>
                
                <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                    <a href="{{ route('login') }}" class="px-10 py-4 bg-[#0a2a5e] text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-2xl hover:scale-105 transition-transform active:scale-95" wire:navigate>
                        Démarrer l'expérience
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Décoration légère -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-50 rounded-full blur-[100px] -z-10 opacity-60"></div>
    </section>

    <!-- ========== MISSION DIAPORAMA (RÉDUIT) ========== -->
    <section id="mission" class="py-24 bg-white" x-data="{ 
        active: 0, 
        slides: [
            { title: 'BUREAU NUMÉRIQUE', label: 'Espace Agent', text: 'Une productivité décuplée grâce à une interface de gestion simplifiée.', img: '{{ asset('images/bureau.png') }}' },
            { title: 'FLUX INTERNE', label: 'Circuit de Validation', text: 'Transmission instantanée des rapports entre Secrétariat et Expertise.', img: '{{ asset('images/interne.png') }}' },
            { title: 'ACCÈS SÉCURISÉ', label: 'Protection AES-256', text: 'Consultez vos archives en toute sécurité via le réseau privé CNSS.', img: '{{ asset('images/externe.png') }}' }
        ],
        next() { this.active = (this.active + 1) % this.slides.length },
        init() { setInterval(() => this.next(), 5000) }
    }">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center mb-16 reveal">
                <span class="text-blue-600 font-black text-[10px] uppercase tracking-[0.4em] mb-4 block underline decoration-2 underline-offset-4">Performance</span>
                <h2 class="text-4xl font-black tracking-tighter uppercase text-slate-900">Notre Mission Digitale</h2>
            </div>

            <!-- Container Diapo RÉDUIT : Hauteur 450px -->
            <div class="relative max-w-5xl mx-auto h-[450px] rounded-[40px] overflow-hidden shadow-2xl border-[8px] border-slate-50">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="active === index" 
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 scale-105"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute inset-0">
                        
                        <div class="absolute inset-0 overflow-hidden">
                            <img :src="slide.img" class="w-full h-full object-cover animate-kenburns">
                        </div>
                        
                        <!-- Overlay dégradé -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a2a5e] via-[#0a2a5e]/20 to-transparent"></div>
                        
                        <div class="absolute bottom-12 left-10 md:left-16 text-white max-w-xl">
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-blue-300 mb-3 inline-block" x-text="slide.label"></span>
                            <h3 class="text-4xl font-black mb-4 leading-none uppercase" x-text="slide.title"></h3>
                            <p class="text-base font-medium text-white/80 leading-relaxed" x-text="slide.text"></p>
                        </div>
                    </div>
                </template>

                <!-- Indicateurs Modernes -->
                <div class="absolute top-8 right-10 flex space-x-2">
                    <template x-for="(s, i) in slides" :key="i">
                        <div class="h-1 transition-all duration-500 rounded-full" 
                             :class="active === i ? 'w-10 bg-white' : 'w-3 bg-white/20'"></div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SECTION À PROPOS ========== -->
    <section id="propos" class="py-32 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="reveal">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="h-56 bg-[#0a2a5e] rounded-[35px] p-8 flex flex-col justify-end text-white shadow-xl">
                            <span class="text-4xl font-black mb-2">100%</span>
                            <span class="text-[9px] font-bold uppercase tracking-widest opacity-60">Intégrité</span>
                        </div>
                        <div class="h-56 bg-white rounded-[35px] p-8 flex flex-col justify-end border border-slate-100 shadow-xl mt-10">
                            <span class="text-4xl font-black text-cnss-blue mb-2">0</span>
                            <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Pertes</span>
                        </div>
                    </div>
                </div>

                <div class="reveal">
                    <h2 class="text-5xl font-black text-slate-900 leading-tight mb-8 uppercase tracking-tighter">
                        Un héritage technique <br> <span class="italic text-[#0a2a5e]">sous haute protection.</span>
                    </h2>
                    <p class="text-lg text-slate-600 font-medium leading-relaxed">
                        Le diagnostic de 2026 a révélé l'urgence d'une transition numérique. La Division de Kamina est désormais le fer de lance de cette innovation au sein de la CNSS.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FOOTER ========== -->
    <footer class="bg-[#0a2a5e] pt-32 pb-12 overflow-hidden relative">
        <!-- Décorations -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400/10 rounded-full blur-[100px]"></div>
        
        <div class="max-w-7xl mx-auto px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start border-b border-white/10 pb-20 mb-12">
                <div class="max-w-md">
                    <img src="{{ asset('images/logo-cnss.png') }}" class="h-14 mb-8 brightness-200">
                    <p class="text-blue-100/60 font-medium leading-relaxed">
                        Institution de référence pour la protection sociale en RDC. Division Technique de Kamina.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-20 mt-12 md:mt-0">
                    <div>
                        <h4 class="text-white font-black text-xs uppercase tracking-[0.3em] mb-8">Navigation</h4>
                        <ul class="space-y-4">
                            <li><a href="#accueil" class="text-blue-100/40 hover:text-white transition text-xs font-bold uppercase tracking-widest">Accueil</a></li>
                            <li><a href="#mission" class="text-blue-100/40 hover:text-white transition text-xs font-bold uppercase tracking-widest">Mission</a></li>
                            <li><a href="#propos" class="text-blue-100/40 hover:text-white transition text-xs font-bold uppercase tracking-widest">À Propos</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-black text-xs uppercase tracking-[0.3em] mb-8">Légal</h4>
                        <p class="text-blue-100/40 text-xs font-bold uppercase tracking-widest leading-loose">
                            République Démocratique du Congo <br> Province du Haut-Lomami
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center text-[10px] font-black text-white/20 uppercase tracking-[0.5em]">
                <span>© {{ date('Y') }} CNSS ArchiveTech</span>
                <span class="mt-4 md:mt-0">SÉCURITÉ • FIABILITÉ • PÉRENNITÉ</span>
            </div>
        </div>
    </footer>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>

</body>
</html>