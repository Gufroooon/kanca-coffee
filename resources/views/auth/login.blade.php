<x-guest-layout>
    <div class="space-y-7">
        <div class="space-y-2">
            <a href="{{ route('home') }}" class="hidden lg:inline-flex text-xs font-bold text-kanca-teal hover:text-kanca-orange transition-colors">{{ __('Back to Kanca Coffee') }}</a>
            <h2 class="text-3xl font-extrabold text-kanca-dark leading-tight">{{ __('Selamat datang kembali.') }}</h2>
            <p class="text-sm text-gray-500">{{ __('Login untuk melihat dashboard, event pass, menu favorit, dan portal sesuai role akunmu.') }}</p>
        </div>

        <x-auth-session-status class="rounded-2xl bg-kanca-teal/10 px-4 py-3 text-sm text-kanca-teal" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs font-extrabold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Alamat Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@kancacoffee.com" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-extrabold text-gray-700 uppercase tracking-wide">{{ __('Kata Sandi') }}</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-kanca-teal hover:text-kanca-orange transition-colors" href="{{ route('password.request') }}">{{ __('Lupa kata sandi?') }}</a>
                    @endif
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="{{ __('Masukkan kata sandi Anda') }}" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <label for="remember_me" class="flex items-center gap-3 text-sm text-gray-600">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-kanca-orange shadow-sm focus:ring-kanca-orange" name="remember">
                <span>{{ __('Ingat perangkat ini') }}</span>
            </label>

            <button type="submit" class="w-full rounded-2xl bg-kanca-orange px-5 py-3.5 text-sm font-extrabold text-white shadow-xl shadow-kanca-orange/20 hover:bg-kanca-orangeHover hover:-translate-y-0.5 transition-all">
                {{ __('Login ke Kanca') }}
            </button>
        </form>

        <div class="rounded-2xl bg-kanca-bg border border-orange-100 p-4 text-xs text-gray-600 space-y-2">
            <p class="font-extrabold text-kanca-dark">{{ __('Akun demo') }}</p>
            <p><strong>Admin:</strong> admin@kancacoffee.com</p>
            <p><strong>Staff:</strong> staff@kancacoffee.com</p>
            <p><strong>User:</strong> user@kancacoffee.com</p>
            <p>{{ __('Kata Sandi') }}: <strong>password</strong></p>
        </div>

        <p class="text-center text-sm text-gray-500">
            {{ __('Baru di Kanca?') }}
            <a href="{{ route('register') }}" class="font-extrabold text-kanca-orange hover:text-kanca-teal transition-colors">{{ __('Buat akun') }}</a>
        </p>
    </div>
</x-guest-layout>
