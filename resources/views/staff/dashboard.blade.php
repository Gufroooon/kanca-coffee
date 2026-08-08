<x-staff-layout>
    <div class="space-y-8" x-data="staffClockApp()">
        <!-- Live Clock & Shift Header -->
        <div class="glass-card dark:glass-dark rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-zinc-800 shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="space-y-1 text-center md:text-left">
                <span class="px-3 py-1 rounded-full bg-kanca-teal/10 text-kanca-teal font-extrabold text-[10px] uppercase tracking-wider">
                    {{ __('Shift Ditetapkan') }}: {{ $user->shift }}
                </span>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ __('Selamat datang kembali,') }} {{ $user->name }}</h2>
                <p class="text-xs text-gray-500">{{ __('Stasiun Operasional Barista & Toko') }}</p>
            </div>

            <!-- Digital Clock Display -->
            <div class="bg-zinc-900 text-white px-8 py-4 rounded-2xl shadow-inner text-center">
                <span class="block text-xs text-kanca-orange font-bold uppercase tracking-widest" x-text="currentDate"></span>
                <span class="text-3xl sm:text-4xl font-extrabold font-mono text-white" x-text="currentTime">00:00:00</span>
            </div>
        </div>

        <!-- Attendance Action Widget -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Today Status & Clock Buttons -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-200 dark:border-zinc-800 shadow-lg space-y-6">
                <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-zinc-800">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white">{{ __('Absensi Shift Hari Ini') }}</h3>
                    @if($todayAttendance)
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $todayAttendance->status === 'late' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                            {{ __('Status') }}: {{ $todayAttendance->status }}
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 uppercase">{{ __('Belum Absen Masuk') }}</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700">
                        <span class="text-[10px] text-gray-400 font-bold uppercase block">{{ __('Absen Masuk') }}</span>
                        <span class="text-xl font-extrabold text-emerald-600">{{ $todayAttendance ? ($todayAttendance->clock_in ?? '-') : '-' }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700">
                        <span class="text-[10px] text-gray-400 font-bold uppercase block">{{ __('Absen Keluar') }}</span>
                        <span class="text-xl font-extrabold text-rose-600">{{ $todayAttendance ? ($todayAttendance->clock_out ?? '-') : '-' }}</span>
                    </div>
                </div>

                @if($errors->any())
                    <div class="rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-xs text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Clock In / Clock Out Forms -->
                @if(!$todayAttendance)
                    <form action="{{ route('staff.attendance.clock-in') }}" method="POST" class="space-y-3" @submit.prevent="submitAttendance($event)">
                        @csrf
                        <input type="hidden" name="latitude" x-model="latitude">
                        <input type="hidden" name="longitude" x-model="longitude">
                        <input type="hidden" name="accuracy" x-model="accuracy">
                        <input type="text" name="notes" placeholder="{{ __('Catatan Absen Masuk Opsional (mis. Info lalu lintas)...') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                        <button type="button" disabled class="w-full py-3 rounded-2xl bg-gray-100 dark:bg-zinc-800 text-gray-400 dark:text-gray-500 font-extrabold text-xs cursor-not-allowed">
                            {{ __('ABSEN KELUAR TERSEDIA SETELAH ABSEN MASUK') }}
                        </button>
                        <button type="submit" :disabled="isLocating" class="w-full py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 text-white font-extrabold text-sm transition-all shadow-xl shadow-emerald-600/20">
                            <i data-lucide="log-in" class="w-5 h-5 inline-block"></i> {{ __('ABSEN MASUK SEKARANG') }}
                        </button>
                    </form>
                @elseif(!$todayAttendance->clock_out)
                    <form action="{{ route('staff.attendance.clock-out') }}" method="POST" class="space-y-3" @submit.prevent="submitAttendance($event)">
                        @csrf
                        <input type="hidden" name="latitude" x-model="latitude">
                        <input type="hidden" name="longitude" x-model="longitude">
                        <input type="hidden" name="accuracy" x-model="accuracy">
                        <input type="text" name="notes" placeholder="{{ __('Catatan Absen Keluar Opsional...') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                        <button type="submit" :disabled="isLocating" class="w-full py-4 rounded-2xl bg-rose-600 hover:bg-rose-700 disabled:opacity-60 text-white font-extrabold text-sm transition-all shadow-xl shadow-rose-600/20">
                            <i data-lucide="log-out" class="w-5 h-5 inline-block"></i> {{ __('ABSEN KELUAR SEKARANG') }}
                        </button>
                    </form>
                @else
                    {{-- Shift completed - show summary then allow new clock-in for next shift --}}
                    <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-bold flex items-center justify-center gap-2 w-full">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        {{ __('Shift Terakhir Selesai! Istirahat yang nyenyak.') }}
                    </div>
                    {{-- Allow new clock-in for a new/next shift --}}
                    <form action="{{ route('staff.attendance.clock-in') }}" method="POST" class="space-y-3" @submit.prevent="submitAttendance($event)">
                        @csrf
                        <input type="hidden" name="latitude" x-model="latitude">
                        <input type="hidden" name="longitude" x-model="longitude">
                        <input type="hidden" name="accuracy" x-model="accuracy">
                        <input type="text" name="notes" placeholder="{{ __('Catatan Absen Masuk Shift Baru...') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                        <button type="submit" :disabled="isLocating" class="w-full py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 text-white font-extrabold text-sm transition-all shadow-xl shadow-emerald-600/20">
                            <i data-lucide="log-in" class="w-5 h-5 inline-block"></i> {{ __('MULAI SHIFT BARU') }}
                        </button>
                    </form>
                @endif
            </div>

            <!-- Quick Shift Guidelines & Location Tracker -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-200 dark:border-zinc-800 shadow-lg space-y-4">
                <h3 class="font-bold text-base text-gray-900 dark:text-white">{{ __('Panduan Operasional Barista') }}</h3>
                <ul class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> <span>{{ __('Absen masuk setidaknya 10 menit sebelum espresso bar buka.') }}</span></li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> <span>{{ __('Verifikasi kalibrasi penggiling biji kopi & tekanan air.') }}</span></li>
                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500"></i> <span>{{ __('Koordinat lokasi otomatis divalidasi saat dikirim.') }}</span></li>
                </ul>

                <div class="pt-4 border-t border-gray-100 dark:border-zinc-800 text-xs text-gray-500 dark:text-gray-400 space-y-2">
                    <p><strong>GPS Status:</strong> <span x-text="gpsStatus"></span></p>
                    <p x-show="gpsError" x-text="gpsError" class="text-rose-500 font-medium"></p>
                    <p x-show="latitude"><strong>{{ __('Koordinat') }}:</strong> <span x-text="coordinateLabel"></span></p>
                </div>
                <iframe x-show="latitude" x-bind:src="mapUrl" class="w-full h-48 rounded-2xl border border-gray-200 dark:border-zinc-700" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Current employee GPS location"></iframe>
                @if($todayAttendance && $todayAttendance->clock_in_latitude && $todayAttendance->clock_in_longitude)
                    <div class="pt-2">
                        <p class="text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Lokasi Absen Masuk Tersimpan') }}</p>
                        <iframe src="https://www.google.com/maps?q={{ $todayAttendance->clock_in_latitude }},{{ $todayAttendance->clock_in_longitude }}&z=16&output=embed" class="w-full h-48 rounded-2xl border border-gray-200 dark:border-zinc-700" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Saved clock-in location"></iframe>
                    </div>
                @endif
                @if($todayAttendance && $todayAttendance->clock_out_latitude && $todayAttendance->clock_out_longitude)
                    <div class="pt-2">
                        <p class="text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Lokasi Absen Keluar Tersimpan') }}</p>
                        <iframe src="https://www.google.com/maps?q={{ $todayAttendance->clock_out_latitude }},{{ $todayAttendance->clock_out_longitude }}&z=16&output=embed" class="w-full h-48 rounded-2xl border border-gray-200 dark:border-zinc-700" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Saved clock-out location"></iframe>
                    </div>
                @endif
            </div>
        </div>

        <!-- Food/Beverage Ordering Widget and Orders Table -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="staffOrderApp({{ json_encode($menus) }})">
            <!-- Order Form -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-200 dark:border-zinc-800 shadow-lg space-y-6 lg:col-span-1">
                <div class="pb-4 border-b border-gray-100 dark:border-zinc-800">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="coffee" class="w-5 h-5 text-kanca-orange"></i>
                        {{ __('Pemesanan Makanan / Minuman') }}
                    </h3>
                    <p class="text-[10px] text-gray-500 mt-1">{{ __('Input pesanan pelanggan langsung ke sistem.') }}</p>
                </div>

                <form action="{{ route('staff.orders.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Select Menu -->
                    <div class="space-y-1.5">
                        <label for="menu_id" class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ __('Ingin Beli Apa?') }}</label>
                        <select name="menu_id" id="menu_id" x-model="selectedMenuId" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:ring-kanca-orange focus:border-kanca-orange">
                            <option value="">-- {{ __('Pilih Makanan / Minuman') }} --</option>
                            <template x-for="menu in menus" :key="menu.id">
                                <option :value="menu.id" x-text="menu.name + ' - ' + formatPrice(menu.price)"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Dynamic Menu Preview -->
                    <div x-show="selectedMenu" class="p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700 space-y-4 transition-all duration-300" x-transition>
                        <div class="flex gap-4">
                            <img :src="selectedMenu ? selectedMenu.image : ''" :alt="selectedMenu ? selectedMenu.name : ''" class="w-20 h-20 rounded-xl object-cover shadow-md border border-gray-200 dark:border-zinc-700">
                            <div class="space-y-1 flex-1 min-w-0">
                                <span class="text-xs font-extrabold text-gray-900 dark:text-white block truncate" x-text="selectedMenu ? selectedMenu.name : ''"></span>
                                <span class="text-xs text-kanca-orange font-bold block" x-text="selectedMenu ? formatPrice(selectedMenu.price) : ''"></span>
                                <p class="text-[10px] text-gray-400 line-clamp-2" x-text="selectedMenu ? selectedMenu.description : ''"></p>
                            </div>
                        </div>

                        <!-- Quantity Counter -->
                        <div class="flex items-center justify-between pt-2 border-t border-zinc-200/50 dark:border-zinc-700/50">
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ __('Jumlah Pesanan') }}</span>
                            <div class="flex items-center gap-3">
                                <button type="button" @click="decrement" class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200 dark:bg-zinc-700 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-zinc-600 transition-colors font-extrabold text-base focus:outline-none">-</button>
                                <span class="text-sm font-bold text-gray-900 dark:text-white w-6 text-center" x-text="quantity"></span>
                                <button type="button" @click="increment" class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200 dark:bg-zinc-700 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-zinc-600 transition-colors font-extrabold text-base focus:outline-none">+</button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Input for Quantity -->
                    <input type="hidden" name="quantity" :value="quantity">

                    <!-- Table Number Dropdown -->
                    <div class="space-y-1.5">
                        <label for="table_number" class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ __('Nomor Meja') }}</label>
                        <select name="table_number" id="table_number" x-model="tableNumber" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:ring-kanca-orange focus:border-kanca-orange">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ __('Meja') }} {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Total Price and Submit Button -->
                    <div class="pt-4 border-t border-gray-100 dark:border-zinc-800 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-gray-500">{{ __('Total Harga') }}</span>
                            <span class="text-lg font-extrabold text-kanca-orange" x-text="formatPrice(totalPrice)">Rp 0</span>
                        </div>
                        <button type="submit" :disabled="!selectedMenuId" class="w-full py-4 rounded-2xl bg-gradient-brand hover:opacity-90 disabled:opacity-50 text-white font-extrabold text-sm transition-all shadow-xl shadow-kanca-orange/20">
                            <i data-lucide="shopping-bag" class="w-5 h-5 inline-block mr-1"></i> {{ __('KIRIM PESANAN') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Today's Orders Table -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-200 dark:border-zinc-800 shadow-lg space-y-6 lg:col-span-2">
                <div class="pb-4 border-b border-gray-100 dark:border-zinc-800 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-white">{{ __('Daftar Pemesanan Hari Ini') }}</h3>
                        <p class="text-[10px] text-gray-500 mt-1">{{ __('Pantau status pesanan dan proses makanan/minuman.') }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-[10px] font-bold text-gray-600 dark:text-gray-400">
                        {{ count($todayOrders) }} {{ __('Pesanan') }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                            <tr>
                                <th class="p-3">{{ __('Waktu') }}</th>
                                <th class="p-3">{{ __('Meja') }}</th>
                                <th class="p-3">{{ __('Pelanggan') }}</th>
                                <th class="p-3">{{ __('Pesanan') }}</th>
                                <th class="p-3">{{ __('Total') }}</th>
                                <th class="p-3">{{ __('Status') }}</th>
                                <th class="p-3 text-right">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                            @forelse($todayOrders as $order)
                                <tr>
                                    <td class="p-3 font-semibold text-gray-500">{{ $order->created_at->setTimezone('Asia/Jakarta')->format('H:i') }}</td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-1 rounded-xl bg-kanca-cream text-kanca-orange font-extrabold text-[10px]">
                                            Meja {{ $order->table_number }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="font-bold text-gray-800 dark:text-zinc-200 text-xs">
                                            {{ $order->customer_name ?: ($order->user ? $order->user->name : '—') }}
                                        </div>
                                        @if($order->customer_note)
                                            <div class="text-[10px] text-gray-400 italic mt-0.5 max-w-[120px] truncate">{{ $order->customer_note }}</div>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center gap-2 py-1">
                                                @if($item->menu && $item->menu->image)
                                                    <img src="{{ $item->menu->image }}" alt="{{ $item->menu->name }}" class="w-8 h-8 rounded-lg object-cover border border-gray-100 dark:border-zinc-700">
                                                @endif
                                                <div>
                                                    <span class="font-bold text-gray-800 dark:text-zinc-200">{{ $item->menu->name ?? 'Menu Terhapus' }}</span>
                                                    <span class="text-xs text-gray-500 font-semibold block">x{{ $item->quantity }} @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="p-3 font-extrabold text-gray-900 dark:text-white">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3">
                                        @if($order->status === 'completed')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 uppercase">
                                                {{ __('Selesai') }}
                                            </span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 uppercase">
                                                {{ __('Batal') }}
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 uppercase animate-pulse">
                                                {{ __('Pending') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right space-y-1 sm:space-y-0 sm:space-x-1 whitespace-nowrap">
                                        @if($order->status === 'pending')
                                            <form action="{{ route('staff.orders.update-status', $order) }}" method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="px-3 py-1 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-[10px] transition-colors shadow-sm">
                                                    {{ __('Selesai') }}
                                                </button>
                                            </form>
                                            <form action="{{ route('staff.orders.update-status', $order) }}" method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="px-3 py-1 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-[10px] transition-colors shadow-sm">
                                                    {{ __('Batalkan') }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] font-semibold text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400 font-medium">
                                        <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i>
                                        {{ __('Belum ada pesanan masuk hari ini.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Monthly Attendance History -->
        <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-200 dark:border-zinc-800 shadow-lg space-y-4">
            <h3 class="font-bold text-base text-gray-900 dark:text-white">{{ __('Log Absensi Shift Bulanan') }}</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-3">{{ __('Tanggal') }}</th>
                            <th class="p-3">{{ __('Absen Masuk') }}</th>
                            <th class="p-3">{{ __('Absen Keluar') }}</th>
                            <th class="p-3">{{ __('Koordinat Absen Masuk') }}</th>
                            <th class="p-3">{{ __('Koordinat Absen Keluar') }}</th>
                            <th class="p-3">{{ __('Status') }}</th>
                            <th class="p-3">{{ __('Catatan') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($monthlyHistory as $log)
                            <tr>
                                <td class="p-3 font-bold">{{ $log->date ? $log->date->format('d M Y') : '' }}</td>
                                <td class="p-3 font-semibold text-emerald-600">{{ $log->clock_in ?? '-' }}</td>
                                <td class="p-3 font-semibold text-rose-600">{{ $log->clock_out ?? '-' }}</td>
                                <td class="p-3 text-gray-500 whitespace-nowrap">
                                    @if($log->clock_in_latitude !== null && $log->clock_in_longitude !== null)
                                        <a href="https://www.google.com/maps?q={{ $log->clock_in_latitude }},{{ $log->clock_in_longitude }}" target="_blank" rel="noopener" class="text-kanca-teal hover:underline">
                                            {{ number_format($log->clock_in_latitude, 6) }}, {{ number_format($log->clock_in_longitude, 6) }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-3 text-gray-500 whitespace-nowrap">
                                    @if($log->clock_out_latitude !== null && $log->clock_out_longitude !== null)
                                        <a href="https://www.google.com/maps?q={{ $log->clock_out_latitude }},{{ $log->clock_out_longitude }}" target="_blank" rel="noopener" class="text-kanca-orange hover:underline">
                                            {{ number_format($log->clock_out_latitude, 6) }}, {{ number_format($log->clock_out_longitude, 6) }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $log->status === 'late' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $log->status }}
                                    </span>
                                </td>
                                <td class="p-3 text-gray-500">{{ $log->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-400">{{ __('Tidak ada catatan shift untuk bulan ini.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function staffClockApp() {
            return {
                currentTime: '',
                currentDate: '',
                latitude: '',
                longitude: '',
                accuracy: '',
                isLocating: false,
                gpsError: '',
                get gpsStatus() {
                    return this.isLocating ? '{{ __('Meminta lokasi…') }}' : (this.latitude ? '{{ __('Lokasi siap') }}' : '{{ __('Lokasi diperlukan sebelum absen masuk/keluar') }}');
                },
                get coordinateLabel() {
                    return `${Number(this.latitude).toFixed(6)}, ${Number(this.longitude).toFixed(6)} (±${Math.round(this.accuracy)} m)`;
                },
                get mapUrl() {
                    return this.latitude ? `https://www.google.com/maps?q=${this.latitude},${this.longitude}&z=16&output=embed` : '';
                },
                submitAttendance(event) {
                    this.gpsError = '';
                    if (!navigator.geolocation) {
                        this.gpsError = '{{ __('Browser ini tidak mendukung lokasi GPS.') }}';
                        return;
                    }

                    this.isLocating = true;
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.latitude = position.coords.latitude;
                            this.longitude = position.coords.longitude;
                            this.accuracy = position.coords.accuracy;
                            // Set native form inputs directly: Alpine updates x-model on the next render cycle,
                            // while this form must be submitted immediately after the GPS callback.
                            event.target.querySelector('[name="latitude"]').value = position.coords.latitude;
                            event.target.querySelector('[name="longitude"]').value = position.coords.longitude;
                            event.target.querySelector('[name="accuracy"]').value = position.coords.accuracy;
                            this.isLocating = false;
                            event.target.submit();
                        },
                        (error) => {
                            this.isLocating = false;
                            this.gpsError = error.code === 1
                                ? '{{ __('Izin GPS ditolak. Izinkan akses lokasi, lalu coba lagi.') }}'
                                : '{{ __('Tidak dapat memperoleh lokasi GPS yang akurat. Pindah ke area terbuka dan coba lagi.') }}';
                        },
                        { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                    );
                },
                init() {
                    const update = () => {
                        const now = new Date();
                        this.currentTime = now.toLocaleTimeString('en-US', { hour12: false });
                        this.currentDate = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                    };
                    update();
                    setInterval(update, 1000);
                }
            }
        }

        function staffOrderApp(menus) {
            return {
                menus: menus,
                selectedMenuId: '',
                quantity: 1,
                tableNumber: 1,
                get selectedMenu() {
                    return this.menus.find(m => m.id == this.selectedMenuId) || null;
                },
                get totalPrice() {
                    if (!this.selectedMenu) return 0;
                    return this.selectedMenu.price * this.quantity;
                },
                increment() {
                    this.quantity++;
                },
                decrement() {
                    if (this.quantity > 1) {
                        this.quantity--;
                    }
                },
                formatPrice(value) {
                    return 'Rp ' + Number(value).toLocaleString('id-ID');
                },
                init() {
                    this.$watch('selectedMenuId', value => {
                        if (value) {
                            this.quantity = 1;
                        }
                    });
                }
            }
        }
    </script>
</x-staff-layout>
