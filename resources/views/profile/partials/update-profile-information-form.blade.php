<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Nom d'affichage</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-1 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue font-bold text-sm text-slate-700 py-3.5 px-5 shadow-inner" required autofocus autocomplete="name">
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Email Professionnel</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full mt-1 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue font-bold text-sm text-slate-700 py-3.5 px-5 shadow-inner" required autocomplete="username">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-cnss-blue text-white font-black py-3.5 px-8 rounded-xl shadow-lg shadow-blue-600/20 hover:bg-blue-800 transition uppercase text-[10px] tracking-widest">
                Enregistrer les modifications
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">
                    Mise à jour réussie.
                </p>
            @endif
        </div>
    </form>
</section>