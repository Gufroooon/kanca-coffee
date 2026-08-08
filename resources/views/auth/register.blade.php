<x-guest-layout>
    <div class="space-y-7">
        <div class="space-y-2">
            <a href="{{ route('home') }}" class="hidden lg:inline-flex text-xs font-bold text-kanca-teal hover:text-kanca-orange transition-colors">{{ __('Back to Kanca Coffee') }}</a>
            <h2 class="text-3xl font-extrabold text-kanca-dark leading-tight">{{ __('Bergabunglah bersama kami.') }}</h2>
            <p class="text-sm text-gray-500">{{ __('Buat akun untuk daftar event, simpan menu favorit, dan jadi bagian dari komunitas Kanca Coffee.') }}</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-extrabold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Nama Lengkap') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ __('Nama Anda') }}" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="email" class="block text-xs font-extrabold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Alamat Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-extrabold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Kata Sandi') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="{{ __('Min. 8 karakter') }}" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-extrabold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Konfirmasi') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Ulangi kata sandi') }}" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-kanca-orange px-5 py-3.5 text-sm font-extrabold text-white shadow-xl shadow-kanca-orange/20 hover:bg-kanca-orangeHover hover:-translate-y-0.5 transition-all">
                {{ __('Buat Akun Kanca') }}
            </button>
        </form>

        <div class="grid grid-cols-3 gap-3 text-center text-xs">
            <div class="rounded-2xl bg-kanca-bg border border-orange-100 p-3">
                <p class="font-extrabold text-kanca-orange">{{ __('Events') }}</p>
                <p class="text-gray-500 mt-1">{{ __('Pesan kursi') }}</p>
            </div>
            <div class="rounded-2xl bg-kanca-bg border border-teal-100 p-3">
                <p class="font-extrabold text-kanca-teal">{{ __('Menu') }}</p>
                <p class="text-gray-500 mt-1">{{ __('Simpan favorit') }}</p>
            </div>
            <div class="rounded-2xl bg-kanca-bg border border-gray-100 p-3">
                <p class="font-extrabold text-kanca-dark">{{ __('Profil') }}</p>
                <p class="text-gray-500 mt-1">{{ __('Edit kapan saja') }}</p>
            </div>
        </div>

        <p class="text-center text-sm text-gray-500">
            {{ __('Sudah terdaftar?') }}
            <a href="{{ route('login') }}" class="font-extrabold text-kanca-orange hover:text-kanca-teal transition-colors">{{ __('Login di sini') }}</a>
        </p>
    </div>
</x-guest-layout>
