<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-5">
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Mot de passe actuel</label>
                <input type="password" name="current_password" class="w-full mt-1 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm py-3.5 px-5 shadow-inner" autocomplete="current-password">
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Nouveau mot de passe</label>
                    <input type="password" name="password" class="w-full mt-1 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm py-3.5 px-5 shadow-inner" autocomplete="new-password">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase ml-1 tracking-widest">Confirmation</label>
                    <input type="password" name="password_confirmation" class="w-full mt-1 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-cnss-blue text-sm py-3.5 px-5 shadow-inner" autocomplete="new-password">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-cnss-blue text-white font-black py-3.5 px-8 rounded-xl shadow-lg shadow-blue-600/20 hover:bg-blue-800 transition uppercase text-[10px] tracking-widest">
                Changer la clé d'accès
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">
                    Sécurité mise à jour.
                </p>
            @endif
        </div>
    </form>
</section>