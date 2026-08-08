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
                    <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-bold text-center inline-flex items-center justify-center gap-2 w-full">
                        <i data-lucide="check-circle" class="w-5 h-5"></i> {{ __('Shift Hari Ini Selesai! Istirahat yang nyenyak.') }}
                    </div>
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
    </script>
</x-staff-layout>
