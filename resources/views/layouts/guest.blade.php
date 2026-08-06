<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kanca Coffee') }} - Account Access</title>
    <meta name="description" content="Login or register to join Kanca Coffee community events, save favorite menus, and manage your account.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-kanca-bg text-kanca-dark">
    <main class="min-h-screen grid grid-cols-1 lg:grid-cols-12">
        <section class="relative hidden lg:flex lg:col-span-6 xl:col-span-7 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=1600&q=80" alt="Kanca Coffee lounge" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-br from-kanca-dark/80 via-kanca-dark/45 to-kanca-orange/35"></div>

            <div class="relative z-10 flex flex-col justify-between w-full p-10 xl:p-14 text-white">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 w-fit">
                    <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-kanca-orange to-kanca-teal flex items-center justify-center text-white font-extrabold shadow-lg">K</span>
                    <span class="font-extrabold text-2xl tracking-tight">KANCA<span class="text-kanca-orange">.</span></span>
                </a>

                <div class="max-w-2xl space-y-6">
                    <span class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur text-xs font-bold uppercase tracking-[0.2em]">Teman yang kamu cari ada di seberang meja</span>
                    <h1 class="text-5xl xl:text-6xl font-extrabold leading-tight">Masuk ke ruang komunitas Kanca Coffee.</h1>
                    <p class="text-white/80 text-base leading-relaxed">
                        Simpan menu favorit, daftar event, pantau tiket komunitas, dan nikmati pengalaman coffee shop interaktif dalam satu akun.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-4 max-w-xl">
                    <div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur p-4">
                        <p class="text-2xl font-extrabold">11+</p>
                        <p class="text-[11px] text-white/70 uppercase">Menu curated</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur p-4">
                        <p class="text-2xl font-extrabold">5</p>
                        <p class="text-[11px] text-white/70 uppercase">Community events</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur p-4">
                        <p class="text-2xl font-extrabold">3</p>
                        <p class="text-[11px] text-white/70 uppercase">Role portals</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="lg:col-span-6 xl:col-span-5 flex items-center justify-center px-5 py-10 sm:px-8 bg-[radial-gradient(circle_at_top_left,#fff_0,#fff8f5_45%,#f7fffd_100%)]">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-8 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-gradient-to-br from-kanca-orange to-kanca-teal flex items-center justify-center text-white font-extrabold">K</span>
                        <span class="font-extrabold text-xl tracking-tight">KANCA<span class="text-kanca-orange">.</span></span>
                    </a>
                    <a href="{{ route('home') }}" class="text-xs font-bold text-kanca-teal">Home</a>
                </div>

                <div class="rounded-[2rem] bg-white/85 backdrop-blur-xl border border-white shadow-2xl shadow-kanca-orange/10 p-6 sm:p-8">
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-xs text-gray-500">
                    Kanca Coffee account access is protected with Laravel authentication and CSRF validation.
                </p>
            </div>
        </section>
    </main>
</body>
</html>
