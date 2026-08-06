<x-guest-layout>
    <div class="space-y-7">
        <div class="space-y-2">
            <a href="{{ route('home') }}" class="hidden lg:inline-flex text-xs font-bold text-kanca-teal hover:text-kanca-orange transition-colors">Back to Kanca Coffee</a>
            <h2 class="text-3xl font-extrabold text-kanca-dark leading-tight">Join the table.</h2>
            <p class="text-sm text-gray-500">Buat akun untuk daftar event, simpan menu favorit, dan jadi bagian dari komunitas Kanca Coffee.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your name" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="email" class="block text-xs font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 chars" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-extrabold text-gray-700 mb-2 uppercase tracking-wide">Confirm</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password" class="w-full rounded-2xl border border-gray-200 bg-kanca-bg/70 px-4 py-3 text-sm text-kanca-dark placeholder:text-gray-400 focus:border-kanca-orange focus:ring-kanca-orange">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-kanca-orange px-5 py-3.5 text-sm font-extrabold text-white shadow-xl shadow-kanca-orange/20 hover:bg-kanca-orangeHover hover:-translate-y-0.5 transition-all">
                Create Kanca Account
            </button>
        </form>

        <div class="grid grid-cols-3 gap-3 text-center text-xs">
            <div class="rounded-2xl bg-kanca-bg border border-orange-100 p-3">
                <p class="font-extrabold text-kanca-orange">Events</p>
                <p class="text-gray-500 mt-1">Reserve seats</p>
            </div>
            <div class="rounded-2xl bg-kanca-bg border border-teal-100 p-3">
                <p class="font-extrabold text-kanca-teal">Menus</p>
                <p class="text-gray-500 mt-1">Save favorites</p>
            </div>
            <div class="rounded-2xl bg-kanca-bg border border-gray-100 p-3">
                <p class="font-extrabold text-kanca-dark">Profile</p>
                <p class="text-gray-500 mt-1">Edit anytime</p>
            </div>
        </div>

        <p class="text-center text-sm text-gray-500">
            Already registered?
            <a href="{{ route('login') }}" class="font-extrabold text-kanca-orange hover:text-kanca-teal transition-colors">Login here</a>
        </p>
    </div>
</x-guest-layout>
